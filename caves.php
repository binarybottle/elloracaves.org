<?php
$image_dir   = "http://media.elloracaves.org/images/caves_360px/";
$thumb_dir   = "http://media.elloracaves.org/images/caves_thumbs/";
$plan_dir    = "http://media.elloracaves.org/images/plans/";

$table_height = 570;
$table_width = 1000;
$image_width = 360;
$scale_images = 1;
$scale_plans = 0.75;
$offset_plan = 120;
$offsetX_marker = 0;
$offsetY_marker = 245 + $scale_plans*20;
$default_cave_ID = '10';
$default_plan_width = $scale_plans*480;
$miniplan_width = 100;
$slide_height = 554;
$caption_width = 300;
$limit = 200;
$postload = 1;

if (strlen($searchcave)==0) {
  $searchcave = $default_cave_ID;
}
include("./shared/header_caves.php");
?>

<body style="background-image:url(http://media.elloracaves.org/images/maps/map_260x1024px_gradient.png);
             background-repeat:no-repeat;
             background-position: top left;
             background-color: black;">

<title>Ellora Cave Temples</title>

<?php
if (strlen(trim($searchstring))==0 || strlen($searchimage)>0) { 

  // Mini ground plans
  echo '<div class="miniplans">';
  
  if (strlen($plan_image)>0) {
    echo '<img src="'.$plan_dir.$plan_image.'" width="'.$miniplan_width.'"/><br />';
    echo '<div class="miniplan_title">floor 1</div><br /><br /><br />';
  }
  if (strlen($plan_image2)>0) {
    echo '<img src="'.$plan_dir.$plan_image2.'" width="'.$miniplan_width.'"/><br />';
    echo '<div class="miniplan_title">floor 2</div><br /><br /><br />';
  }
  if (strlen($plan_image3)>0) {
    echo '<img src="'.$plan_dir.$plan_image3.'" width="'.$miniplan_width.'"/><br />';
    echo '<div class="miniplan_title">floor 3</div><br /><br /><br />';
  }
  echo '</div>';

  // If there is a plan image
  if ($plan_image_ID > 0) {       

    // Ground plan
    echo '<img src="'.$plan_dir.$plan_image.'" width="'.$plan_width.'" class="plan" style="position:absolute; left:'.$offset_plan.'px;"/>';
    echo '<span class="plan_title">'.$cave_name.'</span>';

    // Markers on ground plan
    echo '<div style="position:absolute; left:'.$offset_plan.'px;">';
    echo '<dl id="switches">'; 
    foreach ($Images as &$row) {
        if ($row['image_plan_x']>0 && $row['image_plan_y']>0) {
          if ($row['image_ID']==$searchimage) {
            echo '<dt class = "active">';
            $marker_state = 'off';
            $marker_size = 10;
          } else {
            echo '<dt>';
            $marker_state = 'on';
            $marker_size = 9;
          }
          echo '<img src="http://media.elloracaves.org/images/decor/marker_'.$marker_state.'.png"
                id="marker'.$row["image_ID"].'"
                border="0" width="'.$marker_size.'" height="'.$marker_size.'"
                style="position:absolute;
                       top:'.($offsetY_marker+$scale_plans*$row['image_plan_y']).'px;
                       left:'.($offsetX_marker + $scale_plans*$row['image_plan_x']).'px;" />';
          echo '</dt>';
        }
    }
    echo '</dl></div>';

    // Main images on the plan
    echo '<div class="slidebox" style="height:'.$slide_height.'px;">';
    echo '<div id="slides">';
    foreach ($Images as &$row) {
      //$image_size = getimagesize($image_dir.$row["image_file"]);
      //$image_height = $scale_images * $image_size[1];
      if ($row['image_plan_x']>0 && $row['image_plan_y']>0) {
        if ($row['image_ID']==$start_image_ID) { //$searchimage) {
          echo '<div id="image_'.$row["image_ID"].'" class="active">';
          echo '<img src="'.$image_dir.$row["image_file"].'" width="'.$image_width.'"/>';
          echo '<span class="active caption" style="width:'.$caption_width.'px;">';
          echo $row["image_description"];
          echo '<br /><br /><span class="tiny">'.$row["image_ID"].'</span>';
          echo '</span>';
          echo '</div>';
          //break;
        } else {
          echo '<div id="image_'.$row["image_ID"].'">';
          echo '<img src="'.$image_dir.$row["image_file"].'" width="'.$image_width.'"/>';
          echo '<span class="caption" style="width:'.$caption_width.'px;">';
          echo $row["image_description"];
          echo '<br /><br /><span class="tiny">'.$row["image_ID"].'</span>';
          echo '</span>';
          echo '</div>';
        }
      }
    }
    echo '</div>';
    echo '</div>';

    // Main image not on the plan
    echo '<div class="slidebox" style="height:'.$slide_height.'px;">';
    echo '<div id="slides_dummy">';
    foreach ($Images as &$row) {
      if ($row['image_plan_x']<=0 || $row['image_plan_y']<=0) {
        if ($row['image_ID']==$searchimage) {
          echo '<div id="image_'.$row["image_ID"].'" class="active">';
          echo '<img src="'.$image_dir.$row["image_file"].'" width="'.$image_width.'"/>';
          echo '<span class="active caption" style="width:'.$caption_width.'px;">';
          echo $row["image_description"];
          echo '<br /><br /><span class="tiny">'.$row["image_ID"].'</span>';
          echo '</span>';
          echo '</div>';
          break;
        }
      }
    }
    echo '</div>';
    echo '</div>';
  
  // If there is no plan image
  } else {
    echo '<div class="no_plan_title">'.$cave_name.' plan under preparation...</div>';

    // Main image
    echo '<div class="slidebox" style="height:'.$slide_height.'px;">';
    echo '<div id="slides_dummy">';
    foreach ($Images as &$row) {
        if ($row['image_ID']==$start_image_ID) {
          echo '<div id="image_'.$row["image_ID"].'">';
          echo '<img src="'.$image_dir.$row["image_file"].'" width="'.$image_width.'"/>';
          echo '<span class="caption" style="width:'.$caption_width.'px;">';
          echo $row["image_description"];
          echo '<br /><br /><span class="tiny">'.$row["image_ID"].'</span>';
          echo '</span>';
          echo '</div>';
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
  echo '<i> in cave </i> <b>'.$searchcave.'</b>';
}
echo ':<br />';

foreach ($Images as &$row) {
  echo '<span id="thumb_'.$row["image_ID"].'">';
  echo '<a href="http://www.elloracaves.org/caves.php?cmd=search&words='.$searchstring.'&cave_ID='.$searchcave.'&image_ID='.$row['image_ID'].'">';

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
