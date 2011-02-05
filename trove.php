<?php
$image_dir   = "http://media.elloracaves.org/images/caves_360px/";
$thumb_dir   = "http://media.elloracaves.org/images/caves_thumbs/";
$plan_dir    = "http://media.elloracaves.org/images/plans/";

$table_height = 570;
$table_width = 800;
$image_width = 360;
$scale_images = 1;
$scale_plans = 0.75;
$offsetX_marker = $scale_plans*(-2);
$offsetY_marker = $scale_plans*20;
$default_cave_ID = '10';
$default_plan_width = $scale_plans*480;

include("./shared/header_trove.php");
?>

<body style="background-image:url(http://media.elloracaves.org/images/maps/map_260x1024px_gradient.png);
             background-repeat:no-repeat;
             background-position: top left;
             background-color: black;">

<title>Ellora Cave Temples</title>

<?php
echo '<div class="main">';
echo '<table width="'.$table_width.'" border="0" cellspacing="0">';
 
if (strlen(trim($searchstring))==0 || strlen($searchimage)>0) { 
  
  echo '<tr height="'.$table_height.'">';
  
  // Main image
  echo '<td width="'.$image_width.'" valign="top" rowspan="2">';
  echo '<div id="slides">';
  foreach ($Images as &$row) {
    if ($plan_image_ID==0) {       
      if ($row['image_ID']==$start_image_ID) {
        echo '<div id="image_'.$row["image_ID"].'" class="active">';
        echo '<img src="'.$image_dir.$row["image_file"].'" width="'.$image_width.'"><br />';
        echo '<span class="tiny">'.$row["image_ID"].'</span><br /><br />';
        echo '<span class="caption">'.$row["image_description"].'</span>';
        echo '</div>';
        //break;
      } else {
        echo '<div id="image_'.$row["image_ID"].'"></div>';
      }
    } else {
        if ($row['image_plan_x']>0 && $row['image_plan_y']>0) {
          $plan_x = $row['image_plan_x'];
          $plan_y = $row['image_plan_y'];
          $plan_img = $plan_image;
        } elseif ($row['image_plan2_x']>0 && $row['image_plan2_y']>0) {
          $plan_x = $row['image_plan2_x'];
          $plan_y = $row['image_plan2_y'];
          $plan_img = $plan_image2;
        } elseif ($row['image_plan3_x']>0 && $row['image_plan3_y']>0) {
          $plan_x = $row['image_plan3_x'];
          $plan_y = $row['image_plan3_y'];
          $plan_img = $plan_image3;
        } else {
          $plan_x = 0;
          $plan_y = 0;
        }
        if ($plan_x>0 && $plan_y>0) {
          //if ($row['image_ID']==$searchimage) {
          if ($row['image_ID']==$start_image_ID) {
            echo '<div id="image_'.$row["image_ID"].'" class="active">';
          } else {
            echo '<div id="image_'.$row["image_ID"].'">';
          }
          echo '<img src="'.$image_dir.$row["image_file"].'" width="'.$image_width.'"><br />';
          echo '<span class="tiny">'.$row["image_ID"].'</span><br /><br />';
          echo '<span class="caption">'.$row["image_description"].'</span>';
          echo '</div>';
        }
    }
  }
  echo '</div>';

  echo '</td><td width="'.$table_tween.'" rowspan="2"></td>';
  echo '<td width="'.$plan_width.'" valign="top" align="left">';

  // Ground plan
  if ($plan_image_ID!=0) {       

    // Markers on ground plan
    echo '<dl id="switches">'; 
    foreach ($Images as &$row) {
        if ($row['image_plan_x']>0 && $row['image_plan_y']>0) {
          $plan_x = $row['image_plan_x'];
          $plan_y = $row['image_plan_y'];
          $plan_img = $plan_image;
        } elseif ($row['image_plan2_x']>0 && $row['image_plan2_y']>0) {
          $plan_x = $row['image_plan2_x'];
          $plan_y = $row['image_plan2_y'];
          $plan_img = $plan_image2;
        } elseif ($row['image_plan3_x']>0 && $row['image_plan3_y']>0) {
          $plan_x = $row['image_plan3_x'];
          $plan_y = $row['image_plan3_y'];
          $plan_img = $plan_image3;
        } else {
          $plan_x = 0;
          $plan_y = 0;
        }
        if ($plan_x>0 && $plan_y>0) {
          if ($row['image_ID']==$searchimage) {
            echo '<dt class = "active">';
            $marker_state = 'off';
            $marker_size = 10;
          } else {
            echo '<dt>';
            $marker_state = 'on';
            $marker_size = 9;
          }
          echo '<img src="./images/decor/marker_'.$marker_state.'.png"
                id="marker'.$row["image_ID"].'"
                border="0" width="'.$marker_size.'" height="'.$marker_size.'"
                style="position:absolute;
                       top:'.($offsetY_marker+$scale_plans*$plan_y).'px;
                       left:'.($offsetX_marker+$image_width+$table_tween+$scale_plans*$plan_x).'px;" />';
          echo '</dt>';
        }
    }
    echo '</dl>';
  } else {
    echo '<div class="cave_name">'.$cave_name.' plan under preparation...</div>';
  }

  echo '<img src="'.$plan_dir.$plan_img.'" width="'.$plan_width.'">';

  echo '</td></tr>';
  
  // Mini ground plans
  echo '<tr><td valign="top" align="center">';
  $plan_string = '<b>'.$cave_name.'</b>: &nbsp; <i>floor';
  if (strlen($plan_image2)>0) {
    if (strlen($plan_image3)>0) {
      $plan_string = $plan_string.'s 1, 2, and 3</i>';
    } else {
      $plan_string = $plan_string.'s 1 and 2</i>';
    }
  } else {
    $plan_string = $plan_string.' 1</i>';
  }
  echo '<div class="cave_name">'.$plan_string.'</div><br />';
  echo '<img src="'.$plan_dir.$plan_image.'" width="'.($plan_width/3).'">';
  echo '<img src="'.$plan_dir.$plan_image2.'" width="'.($plan_width/3).'">';
  echo '<img src="'.$plan_dir.$plan_image3.'" width="'.($plan_width/3).'">';
  echo '</td></tr>';
}
  
// Thumbnails
echo '<tr><td width="'.($image_width+$table_tween+$plan_width).'" colspan="3">';
echo '<div class="thumbnails">';
echo '<br /><i>' . count($Images) . ' result';
if (count($Images)>1) { echo 's'; }
echo ': </i><br />';

foreach ($Images as &$row) {
  echo '<span id="thumb_'.$row["image_ID"].'">';
  echo '<a href="http://www.elloracaves.org/trove.php?cmd=search&words='.$searchstring.'&cave_ID='.$searchcave.'&image_ID='.$row['image_ID'].'">';

  if ($row['image_ID']==$start_image_ID) {
    echo '<img src="' . $thumb_dir . $row['image_file'] . '" height="100" border="2"></a>';
  } else {
    echo '<img src="' . $thumb_dir . $row['image_file'] . '" height="100" border="0"></a>';
  }
  echo ' ';
  echo '</span>';
} 

echo '</div></td></tr>';
echo '</table>';
echo '<p class="postload"></p>';
echo '</div>';

include("./shared/footer.php"); 

?>

</body>
</html>
