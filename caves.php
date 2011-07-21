<?php
$image_dir   = "http://media.elloracaves.org/images/caves_360px/";
$thumb_dir   = "http://media.elloracaves.org/images/caves_thumbs/";
$plan_dir    = "http://media.elloracaves.org/images/plans/";

$image_width = 360;
$scale_images = 1;
$scale_plans = 0.75;
$offset_plan = 120;
$offsetX_marker = 0;
$offsetY_marker = 245 + $scale_plans*20;
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
    echo '<img src="'.$plan_dir.$plan_image.'" width="'.$plan_width.'" class="plan" style="position:absolute; left:'.$offset_plan.'px;"/>';
    echo '<span class="plan_title">'.$cave_name.'</span>';

    // Markers on ground plan
    $plan_size = getimagesize($plan_dir.$plan_image);
    $plan_height = $plan_size[1];
    $plan_height = $scale_plans * $plan_height;
    echo '<script type="text/javascript"> 
           var paper = Raphael('.($offset_plan+3).',10,'.$plan_width.','.$plan_height.');
          </script>
    ';
    echo '<div style="position:absolute; left:'.$offset_plan.'px;">
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
              $x0 = $offsetX_marker + $scale_plans*$X;
              $y0 = $offsetY_marker + $scale_plans*$Y;
              echo '<img src="http://media.elloracaves.org/images/decor/marker_'.$marker_state.'.png"
                    id="marker'.$row["image_ID"].'" rel="target'.$row["image_ID"].'"
                    border="0" width="'.$marker_size.'" height="'.$marker_size.'"
                    style="position:absolute; top:'.$y0.'px; left:'.$x0.'px;" />
                    ';
            }
        //}
    }
    echo '</dl></div>
    ';

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
      echo '<div id="image_'.$row["image_ID"].'" '.$active_string1.'>';
      echo '<img src="'.$image_dir.$row["image_file"].'" width="'.$image_width.'"/>';
      echo '<span class="'.$active_string2.'caption" style="width:'.$caption_width.'px;
                  position:absolute; bottom:0px; left:370px; font-size:85%;">';
      echo $row["image_subject"];
      if ($row["image_description"]!="") {
          echo '<br /><br />'.$row["image_description"];
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
          echo '<div id="image_'.$row["image_ID"].'">';
          echo '<img src="'.$image_dir.$row["image_file"].'" width="'.$image_width.'"/>';
          echo '<span class="caption" style="width:'.$caption_width.'">';
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
  echo '<a href="http://www.elloracaves.org/caves.php?cmd=search&words='.$searchstring.'&cave_ID='.$searchcave.'&plan_floor='.$searchfloor.'&image_ID='.$row['image_ID'].'">';

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
