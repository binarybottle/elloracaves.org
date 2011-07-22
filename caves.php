<?php
$image_dir   = "http://media.elloracaves.org/images/caves_360px/";
$thumb_dir   = "http://media.elloracaves.org/images/caves_thumbs/";
$plan_dir    = "http://media.elloracaves.org/images/plans/";

$image_width = 360;
$scale_images = 1;
$scale_plans = 0.75;
$offsetX_plan = 120;
$default_cave_ID = '10';
$default_plan_floor = 1;
$default_plan_width = $scale_plans*480;
$miniplan_width = 100;
$slide_height = 554;
$caption_width = 300;
$limit = 200;
$postload = 1;

if (strlen($searchcave)==0) {
  $searchcave = $default_cave_ID;
}
if (strlen($searchfloor) == 0) {
  $searchfloor = $default_plan_floor;
}

include("./shared/header_caves.php");
?>

<body style="background-color: black;
             background-image:url(http://media.elloracaves.org/images/maps/map_260x1024px_gradient.png);
             background-repeat:no-repeat;
             background-position: top left;">

<title>Ellora Cave Temples</title>

<?php

// If there is a plan image, mini ground plans
if ($plan_image_ID > 0 && strlen(trim($searchstring))==0) {
    echo '<div class="miniplans">';
    for ($iplan = 0; $iplan < sizeof($plan_images); $iplan++) {
      echo '<a href="http://www.elloracaves.org/caves.php?cmd=search&words='.$searchstring.'&cave_ID='.$searchcave.'&plan_floor='.($iplan+1).'">';
      echo '<img src="'.$plan_dir.$plan_images[$iplan].'" width="'.$miniplan_width.'"/><br />';
      echo '</a>';
      echo '<div class="miniplan_title">floor '.($iplan+1).'</div><br /><br /><br />';
    }
    echo '</div>';
}

if (strlen(trim($searchstring))==0 || strlen($searchimage)>0) { 

  // If there is a plan image
  if ($plan_image_ID > 0) {

    // Ground plan
    echo '<div class="planbox" style="position:absolute; left:'.$offsetX_plan.'px; height:'.$slide_height.'px;">';
    echo '<div style="position:absolute; bottom:0px;">';
    echo '<img src="'.$plan_dir.$plan_image.'" width="'.$plan_width.'px;"/>';
    echo '<span style="position:absolute; left:'.($plan_width/2-20).'px; bottom:-20px;">'.$cave_name.'</span>';

    // Markers on ground plan
    $plan_size = getimagesize($plan_dir.$plan_image);
    $plan_height = $plan_size[1];
    $plan_height = $scale_plans * $plan_height;
    //echo '<script type="text/javascript"> 
    //       var paper = Raphael('.($offsetX_plan+3).',10,'.$plan_width.','.$plan_height.');
    //      </script>
    //';
    //echo '<div style="position:absolute; left:'.$offsetX_plan.'px;">
    echo '<div>
          <dl id="switches">
          ';
    foreach ($Images as &$row) {

        //$master_ID = $row['image_master_ID'];
        //echo $master_ID.'-m i-'.$row['image_ID'];
        //if ($row['image_ID'] == $master_ID) {

            $X = $row['image_plan_x'];
            $Y = $row['image_plan_y'];
    
            // Markers:
            if ($row['image_ID']==$searchimage) {
              echo '<dt class = "active">';
              $marker_state = 'off';
              $marker_size = 8;
            } else {
              echo '<dt>';
              $marker_state = 'on';
              $marker_size = 6;
            }
            // If there is a pair of coordinates for an image:
            if ($X>0 && $Y>0 && $row['image_plan_ID']==$plan_ID) {
              $x0 = $scale_plans*$X;
              $y0 = $scale_plans*$Y;
              echo '<img src="http://media.elloracaves.org/images/decor/marker_'.$marker_state.'.png"
                    id="marker'.$row["image_ID"].'" rel="target'.$row["image_ID"].'"
                    border="0" width="'.$marker_size.'" height="'.$marker_size.'"
                    style="position:absolute; top:'.$y0.'px; left:'.$x0.'px;" />
                    ';
            }
        //}
    }
    echo '</dl></div>';
    echo '</div>';
    echo '</div>';

    // Main images
    echo '<div class="slidebox" style="height:'.$slide_height.'px;">';
    echo '<div id="slides">';
    foreach ($Images as &$row) {
      if ($row['image_ID']==$start_image_ID) {
        $active_string1 = 'class="active"';
        $active_string2 = 'active.';
      } else {
        $active_string1 = '';
        $active_string2 = '';
      }

      // Image
      echo '<div id="image_'.$row["image_ID"].'" '.$active_string1.'>';
      echo '<img src="'.$image_dir.$row["image_file"].'" width="'.$image_width.'"/>';

      // Scroll through images of the same object (image_master_ID):
      $scroll_image_IDs = array();
      $irow2 = 0;
      foreach ($Images as &$row2) {
          if ($row2['image_master_ID']==$row['image_master_ID']) {
              $scroll_image_IDs[$irow2] = $row2['image_ID'];
              if ($row2['image_ID']==$row['image_ID']) {
                  $scroll_image_number = $irow2;
              }
              $irow2 = $irow2 + 1;
          }
      }
      if (sizeof($scroll_image_IDs) > 1) {
          echo '<span class="'.$active_string2.'caption" style="width:'.$image_width.'px;
                      position:absolute; bottom:-20px; left:0px; font-size:85%;">';
          $scroll_image_prev = $scroll_image_number - 1;
          $scroll_image_next = $scroll_image_number + 1;
          if ($scroll_image_prev > -1) {
              echo '<span style="position:absolute; bottom:0px; left:0px;">';
              echo '<a href="http://www.elloracaves.org/caves.php?cmd=search&words='.$searchstring;
              echo '&cave_ID='.$searchcave.'&plan_floor='.$searchfloor;
              echo '&image_ID='.$scroll_image_IDs[$scroll_image_prev].'">';
              echo '<b><<</b>';
              echo '</a>';
              echo '</span>';
          }
          echo '<span style="position:absolute; bottom:0px; left:'.($image_width/2-24).'px;">';
          echo ($scroll_image_number+1) .' of '. sizeof($scroll_image_IDs);
          echo '</span>';
          if ($scroll_image_next < sizeof($scroll_image_IDs)) {
              echo '<span style="position:absolute; bottom:0px; right:0px;">';
              echo '<a href="http://www.elloracaves.org/caves.php?cmd=search&words='.$searchstring;
              echo '&cave_ID='.$searchcave.'&plan_floor='.$searchfloor;
              echo '&image_ID='.$scroll_image_IDs[$scroll_image_next].'">';
              echo '<b>>></b>';
              echo '</a>';
              echo '</span>';
          }
          echo '</span>';
      }

      // Caption
      echo '<span class="'.$active_string2.'caption" style="width:'.$caption_width.'px;
                  position:absolute; bottom:0px; left:370px; font-size:85%; 
                  height:'.($slide_height-300).'px; overflow:auto; background-color:#000000;">';
//                  overflow:auto; background-color:#000000;">';
//                  height:'.$slide_height.'px; overflow:auto; background-color:#000000;">';
      echo $row["image_subject"];
      if ($row["image_description"]!="") {
          echo '<br /><br />';
//          echo '<div style="height:'.$slide_height.'px;width:'.$caption_width.'px;overflow:scroll;">';
//          echo '<div style="height:20px;width:100px;overflow:scroll;">';
          echo $row["image_description"];
//          echo '</div>';

      }
      echo '<br /><br /><span class="tiny">'.$row["image_ID"].'</span>';
      echo '</span>';
      echo '</div>';
    }
    echo '</div>';
    echo '</div>';

  // Main images with no plan image
  } else {
    echo '<div class="no_plan_title">'.$cave_name.' plan under preparation...</div>';
    echo '<div class="slidebox" style="height:'.$slide_height.'px;">';
    echo '<div id="slides_dummy">';
    foreach ($Images as &$row) {
        if ($row['image_ID']==$start_image_ID) {

          // Image
          echo '<div id="image_'.$row["image_ID"].'">';
          echo '<img src="'.$image_dir.$row["image_file"].'" width="'.$image_width.'"/>';

          // Scroll through images of the same object (image_master_ID):
          $irow2 = 0;
          foreach ($Images as &$row2) {
              if ($row2['image_master_ID']==$row['image_master_ID']) {
                  $scroll_image_IDs[$irow2] = $row2['image_ID'];
                  if ($row2['image_ID']==$row['image_ID']) {
                      $scroll_image_number = $irow2;
                  }
                  $irow2 = $irow2 + 1;
              }
          }
          if (sizeof($scroll_image_IDs) > 1) {
              echo '<span class="'.$active_string2.'caption" style="width:'.$image_width.'px;
                          position:absolute; bottom:-20px; left:0px; font-size:85%;">';
              $scroll_image_prev = $scroll_image_number - 1;
              $scroll_image_next = $scroll_image_number + 1;
              if ($scroll_image_prev > -1) {
                  echo '<span style="position:absolute; bottom:0px; left:0px;">';
                  echo '<a href="http://www.elloracaves.org/caves.php?cmd=search&words='.$searchstring;
                  echo '&cave_ID='.$searchcave.'&plan_floor='.$searchfloor;
                  echo '&image_ID='.$scroll_image_IDs[$scroll_image_prev].'">';
                  echo '<<';
                  echo '</a>';
                  echo '</span>';
              }
              echo '<span style="position:absolute; bottom:0px; left:'.($image_width/2-24).'px;">';
              echo ($scroll_image_number+1) .' of '. sizeof($scroll_image_IDs);
              echo '</span>';
              if ($scroll_image_next < sizeof($scroll_image_IDs)) {
                  echo '<span style="position:absolute; bottom:0px; right:0px;">';
                  echo '<a href="http://www.elloracaves.org/caves.php?cmd=search&words='.$searchstring;
                  echo '&cave_ID='.$searchcave.'&plan_floor='.$searchfloor;
                  echo '&image_ID='.$scroll_image_IDs[$scroll_image_next].'">';
                  echo '>>';
                  echo '</a>';
                  echo '</span>';
              }
              echo '</span>';
          }

          // Caption
          echo '<span class="caption" style="width:'.$caption_width.'px; 
                  height:'.($slide_height-300).'px; overflow:auto;
                  background-color:#000000;
                  scrollbar-base-color:#000000;
                  scrollbar-face-color:#000000;">';
          echo $row["image_subject"];
          if ($row["image_description"]!="") {
              echo '<br /><br />'.$row["image_description"];
          }
          echo $row["image_description"];
          echo '<br /><br /><span class="tiny">'.$row["image_ID"].'</span>';
          echo '</span>';
          echo '</div>';
          break;
        }
    }
    echo '</div>';
    echo '</div>';
  }
}

// Thumbnails
if (strlen(trim($searchstring))>0 && strlen($searchimage)==0) { 
  echo '<div class="thumbnails" style="width:1014px; top:280px;">';
} else {
  echo '<div class="thumbnails" style="width:1014px; top:800px;">';
}
if (count($Images)>=$limit) { 
  $limit_string = 'First '; 
} else {
  $limit_string = '';
}
echo '<br /><i>' . $limit_string . '</i><b>' . count($Images) . '</b><i> result';
if (count($Images)>1) { echo 's'; }
echo '</i>';
if (strlen(trim($searchstring)) > 0) {
  echo '<i> with search string </i>"<b>'.$searchstring.'</b>"';
} 
if (strlen($searchcave) > 0) {
  echo '<i> in cave </i> <b>'.$searchcave.'</b>'; // , floor '.$searchfloor;
}
echo ':<br />';

foreach ($Images as &$row) {
  echo '<span id="thumb_'.$row["image_ID"].'">';
  echo '<a href="http://www.elloracaves.org/caves.php?cmd=search&words='.$searchstring;
  echo '&cave_ID='.$searchcave.'&plan_floor='.$searchfloor.'&image_ID='.$row['image_ID'].'">';

  if ($row['image_ID']==$start_image_ID) {
    echo '<img src="' . $thumb_dir . $row['image_file'] . '" height="100" border="2"/></a>';
  } else {
    echo '<img src="' . $thumb_dir . $row['image_file'] . '" height="100" border="0"/></a>';
  }
  echo ' ';
  echo '</span>';
} 

include("./shared/footer.php"); 

?>

</body>
</html>
