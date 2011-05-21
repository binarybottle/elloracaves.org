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
/*
  if (strlen($plan_image2)>0) {
    echo '<img src="'.$plan_dir.$plan_image2.'" width="'.$miniplan_width.'"/><br />';
    echo '<div class="miniplan_title">floor 2</div><br /><br /><br />';
  }
  if (strlen($plan_image3)>0) {
    echo '<img src="'.$plan_dir.$plan_image3.'" width="'.$miniplan_width.'"/><br />';
    echo '<div class="miniplan_title">floor 3</div><br /><br /><br />';
  }
*/
  echo '</div>';

  // If there is a plan image
  if ($plan_image_ID > 0) {       

    // Ground plan
    echo '<img src="'.$plan_dir.$plan_image.'" width="'.$plan_width.'" class="plan" style="position:absolute; left:'.$offset_plan.'px;"/>';
    echo '<span class="plan_title">'.$cave_name.'</span>';

$plan_height = 1.7 * $plan_width;

    // Markers on ground plan
    echo '<script type="text/javascript"> 
           var paper = Raphael('.($offset_plan+3).',10,'.$plan_width.','.$plan_height.');
          </script>
    ';
    echo '<div style="position:absolute; left:'.$offset_plan.'px;">
          <dl id="switches">
          ';
    foreach ($Images as &$row) {
        $X = explode(",",$row['image_plan_x']);
        $Y = explode(",",$row['image_plan_y']);

        // If there is at least one pair of coordinates for an image:
        if ($X[0]>0 && $Y[0]>0) {
          // First marker:
          if ($row['image_ID']==$searchimage) {
            echo '<dt class = "active">';
            $marker_state = 'off';
            $marker_size = 8;
          } else {
            echo '<dt>';
            $marker_state = 'on';
            $marker_size = 6;
          }
          $x0 = $offsetX_marker + $scale_plans*$X[0];
          $y0 = $offsetY_marker + $scale_plans*$Y[0];
          echo '<img src="http://media.elloracaves.org/images/decor/marker_'.$marker_state.'.png"
                id="marker'.$row["image_ID"].'" rel="target'.$row["image_ID"].'"
                border="0" width="'.$marker_size.'" height="'.$marker_size.'"
                style="position:absolute; top:'.$y0.'px; left:'.$x0.'px;" />
                ';

          // If there is a second pair of coordinates for an image:
          if ($X[1]>0 && $Y[1]>0) {
            $x1 = $offsetX_marker + $scale_plans*$X[1];
            $y1 = $offsetY_marker + $scale_plans*$Y[1];

            // Draw lines of sight:
            echo '<script type="text/javascript"> 
             var line = paper.path("M'.$x0.' '.$y0.'L'.$x1.' '.$y1.'");
             line.attr({stroke: "yellow", opacity: '.$opacity.'});
            </script>
            ';

            // Second marker:
            $radius = 2;
            $opacity = 0.6;
            echo '<script type="text/javascript">
             var circle = paper.circle('.$x1.','.$y1.','.$radius.');
             circle.attr({fill: "yellow", opacity: '.$opacity.'});
            </script>
            ';
          }
        }
    }
    echo '</dl></div>
    ';

    // Main images on the plan
    echo '<div class="slidebox" style="height:'.$slide_height.'px;">';
    echo '<div id="slides">';
    foreach ($Images as &$row) {
      //$image_size = getimagesize($image_dir.$row["image_file"]);
      //$image_height = $scale_images * $image_size[1];
      $X = explode(",",$row['image_plan_x']);
      $Y = explode(",",$row['image_plan_y']);
      if ($X[0]>0 && $Y[0]>0) {
        if ($row['image_ID']==$start_image_ID) { //$searchimage) {
          echo '<div id="image_'.$row["image_ID"].'" class="active">';
          echo '<img src="'.$image_dir.$row["image_file"].'" width="'.$image_width.'"/>';
          echo '<span class="active caption" style="width:'.$caption_width.'px;">';
          echo $row["image_description"];
          echo '<br /><br /><span class="tiny">'.$row["image_ID"].'</span>';
          echo '</span>';
          echo '</div>';
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
      $X = explode(",",$row['image_plan_x']);
      $Y = explode(",",$row['image_plan_y']);
      if ($X[0]<=0 || $Y[0]<=0) {
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
