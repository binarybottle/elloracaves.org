<?php
include_once("../db/elloracaves_db.php");

// Search form (http://www.phpfreaks.com/tutorials/129/0.php)
function searchForm()
{
  echo '<div class="search">';
  echo '<table cellspacing="5" cellpadding="0"><tr><td align="right">';
  $searchwords = (isset($_GET['words']) ? htmlspecialchars(stripslashes($_REQUEST['words'])) : '');
  echo '<form method="get" action="'.$_SERVER["PHP_SELF"].'">';
  echo '<input type="hidden" name="cmd" value="search" />';
  echo 'Keywords: ';
  echo '</td><td>';
  echo '<input class="input_keywords" type="text" size="20" name="words" value="'.$searchwords.'" />';
  echo '</td><td>Cave: </td><td>';
  include('./shared/cave_menu.php');
  echo '</td><td></td><td>';
  echo '<input class="submit_query" type="submit" value="Search" />';
  echo '</form>';
  echo '</td></tr></table>';
  echo '</div>';
}

// Create the navigation switch
$cmd = (isset($_GET['cmd']) ? $_GET['cmd'] : '');
$searchstring = mysql_escape_string($_GET['words']);
$searchcave   = mysql_escape_string($_GET['cave_ID']);
$searchimage  = mysql_escape_string($_GET['image_ID']);
$bool = ' IN BOOLEAN MODE ';
if (strlen($cmd)==0) {
  $cmd = "search";
  $searchcave = $default_cave_ID;
}

switch($cmd)
{
  default:
  searchForm();
  break;
  case "search":
    searchForm();

    // All images for selected cave 
    if (strlen(trim($searchstring))==0 && strlen(trim($searchcave))>0) {
      $sql = "SELECT image_ID, image_cave_ID, image_file, image_rank,
             image_description, cave_name, 
             plan_ID, plan_cave_ID, plan_image_ID, plan_width, plan_image,
             image_plan_x, image_plan_y
             FROM images, caves, plans
             WHERE cave_ID = '".$searchcave."'
             AND image_cave_ID = cave_ID
             AND plan_cave_ID = cave_ID
             AND image_rank = 1
             ORDER BY image_file ASC
             LIMIT ".$limit;
      $result = mysql_query($sql) or die (mysql_error());
      // Create Images array
      $Images = array();
      $i=0;
      while($row = mysql_fetch_array($result)){
        //print_r($row);
// CAVE 10 IMAGES REPEAT!!!!
        if ($searchcave==10) {
          if ($i % 2 == 0) {
            $Images[$i] = $row;
          }
        } else {
            $Images[$i] = $row;
        }
        $i = $i + 1;
      }
      //print_r($Images);
    }
    // All images described with provided keywords (optionally for selected cave) 
    elseif (strlen(trim($searchstring))>0 && strlen(trim($searchcave))>=0) {
      if (strlen(trim($searchcave))>0) {
        $s_string = " AND image_cave_ID = '".$searchcave."' ";
      } else {
        $s_string = " ";
      }
      $sql = "SELECT image_ID, image_cave_ID, image_medium, image_subject,
                     image_motifs, image_description, image_file, image_date,
                     image_notes, image_rank,
                     image_plan_x, image_plan_y,
              MATCH(image_medium, image_subject, image_motifs, image_description,
                     image_notes)
              AGAINST ('$searchstring'" . $bool . ") AS score FROM images
              WHERE MATCH(image_medium, image_subject, image_motifs,
                          image_description, image_notes)
              AGAINST ('$searchstring'" . $bool . ")
              AND image_rank = '1' "
              .$s_string.
              " ORDER BY image_file ASC
              LIMIT ".$limit;
              #ORDER BY score DESC, image_file ASC";
              #ORDER BY image_cave_ID DESC, score DESC";
      $result = mysql_query($sql) or die (mysql_error());
      // Create Images array
      $Images = array();
      $i=0;
      while($row = mysql_fetch_array($result)){
        $Images[$i] = $row;
        $i = $i + 1;
      }
    }
  break;
}

// Cave- and plan-dependent parameters
$cave_name = $Images[0]['cave_name'];
$plan_image = $Images[0]['plan_image'];
$plan_image_ID = $Images[0]['plan_image_ID'];
$plan_cave_ID = $Images[0]['plan_cave_ID'];
$plan_width = $scale_plans*$Images[0]['plan_width'];
if ($plan_width <= 0) {
  $plan_width = $default_plan_width;
}
$image_width = $scale_images * $image_width;

// If given image_ID, find other information to include plan
if (strlen($searchimage)>0) {
  $start_image_ID = $searchimage;
  $sql_temp = 'SELECT cave_name, plan_image_ID, plan_cave_ID, 
               plan_width, plan_image 
               FROM images, caves, plans 
               WHERE cave_ID = image_cave_ID 
               AND plan_cave_ID = cave_ID 
               AND image_rank = 1
               AND image_ID = "'.$start_image_ID.'"';
  $result = mysql_query($sql_temp) or die (mysql_error());
  while($row = mysql_fetch_array($result)){
    $cave_name = $row['cave_name'];
    $plan_image_ID = $row['plan_image_ID'];
    $plan_cave_ID = $row['plan_cave_ID'];
    $plan_image = $row['plan_image'];
    $plan_width = $scale_plans*$row['plan_width'];
    if ($plan_width <= 0) {
      $plan_width = $default_plan_width;
    }
    break;
  }
} else {
  if ($plan_image_ID==0) {
    $start_image_ID = $Images[0]['image_ID'];
  } else {
    $start_image_ID = $plan_image_ID;
  }
}

?>