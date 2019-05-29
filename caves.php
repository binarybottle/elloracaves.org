<?php
$image_dir   = "https://elloracaves.org/images/caves_360px/";
$thumb_dir   = "https://elloracaves.org/images/caves_thumbs/";
$plan_dir    = "https://elloracaves.org/images/plans/";

$default_cave_ID = '10';
$default_plan_floor = 1;
$miniplan_width = 100;
$image_width = 360;
$caption_left = 400;
$thumbs_shift_down = 20;
$thumb_height = 100;
$scale_plans = 0.75;
$default_plan_width = $scale_plans*480;
$blank_image = 'blank.png';


if (strlen($searchcave)==0) {
  $searchcave = $default_cave_ID;
}
if (strlen($searchfloor) == 0) {
  $searchfloor = $default_plan_floor;
}

include("./shared/header_caves.php");
?>

<body style="background-color: black;
             background-image:url(https://elloracaves.org/images/maps/map_260x1024px_gradient.png);
             background-repeat:no-repeat;
             background-position: top left;">

<title>Ellora Cave Temples</title>

<?php


// Mini floorplans
// If there is a plan image, mini ground plans
if ($plan_image_ID > 0 && strlen(trim($searchstring))==0) {
    // Find floor numbers
    $sql = "SELECT plan_floor
         FROM plans
         WHERE plan_cave_ID = '".$searchcave."'";
    $result = mysql_query($sql) or die (mysql_error());
    // Create floors array
    $floors = array();
    $i=0;
    while($row = mysql_fetch_array($result)){
        $floors[$i] = $row;
        $i = $i + 1;
    }
    if (sizeof($floors) > 1) {
        echo '<div class="miniplans">';
        for ($ifloor = 0; $ifloor < sizeof($floors); $ifloor++) {
            echo '<a href="https://elloracaves.org/caves.php?cmd=search&words=&imageID=&cave_ID='.$searchcave.'&plan_floor='.($ifloor+1).'">';
            echo '<img src="'.$plan_dir.$plan_images[$ifloor].'" width="'.$miniplan_width.'"/><br />';
            echo '</a>';
            echo '<div class="miniplan_title">floor '.$floors[$ifloor][0].'</div><br /><br /><br />';
        }
        echo '</div>';
    }
}


// Main box (plan, image, caption, thumbnails)
echo '<div class="mainbox">';
echo '<div class="topbox" style="float:left;">';


    // Plot plan and main image above thumbnails if no search or if found image
    if (strlen(trim($searchstring))==0 || strlen($searchimage)>0) { 

        // If there is a plan image
        if ($plan_image_ID > 0) {

            // Plan box (floor plan)
            echo '<div class="planbox" style="float:left;">';
            echo '<img src="'.$plan_dir.$plan_image.'" width="'.$plan_width.'px;"/>';
            if ($plan_image != $blank_image) {
                echo '<span style="position:absolute; left:'.($plan_width/2-20).
                   'px; bottom:-20px;">'.$cave_name.'</span>';
            }

            // Markers on plan
            $plan_size = getimagesize($plan_dir.$plan_image);
            $plan_height = $plan_size[1];
            $plan_height = $scale_plans * $plan_height;
            echo '<div>
                  <dl id="switches">
                  ';
            foreach ($Images as &$row) {

                $X = $row['image_plan_x'];
                $Y = $row['image_plan_y'];

                // Markers
                if ($row['image_ID']==$searchimage) {
                    echo '<dt class = "active">';
                    $marker_state = 'off';
                    $marker_size = 8;
                } else {
                    echo '<dt>';
                    $marker_state = 'on';
                    $marker_size = 6;
                }
                // If there is a pair of coordinates for an image, place marker
                if ($X>0 && $Y>0 && $row['image_plan_ID']==$plan_ID) {
                    $x0 = $scale_plans*$X;
                    $y0 = $scale_plans*$Y;
                    if ($row['image_ID'] == $row['image_master_ID']) {
                        echo '<img src="https://elloracaves.org/images/decor/marker_'.$marker_state.'.png"
                            id="marker'.$row["image_ID"].'" rel="target'.$row["image_ID"].'"
                            border="0" width="'.$marker_size.'" height="'.$marker_size.'"
                            style="position:absolute; top:'.$y0.'px; left:'.$x0.'px;" />
                            ';
                    } else {
                        echo '<span
                            id="marker'.$row["image_ID"].'" rel="target'.$row["image_ID"].'"
                            border="0" width="'.$marker_size.'" height="'.$marker_size.'"
                            style="position:absolute; top:'.$y0.'px; left:'.$x0.'px;"></span>';
                    }
                }
            }
            echo '</dl></div>';
            echo '</div>';  // planbox
        }


        // Slide box (main image)
        echo '<div class="slidebox" style="float:left;">';
        echo '<div id="slides">';
        $max_height = $plan_height;
        foreach ($Images as &$row) {
            if ($row['image_ID']==$start_image_ID) {
                $active_string1 = 'class="active"';
                $active_string2 = ''; //'active.';
            } else {
                $active_string1 = '';
                $active_string2 = '';
            }

            // Image
            echo '<div id="image_'.$row["image_ID"].'" '.$active_string1.'>';
            $img = $image_dir.$row["image_file"];
            echo '<img src="'.$img.'" width="'.$image_width.'"/>';

            // Find maximum image height
            $img_size = getimagesize($img);
            $img_height = $img_size[1];
            $img_width = $img_size[0];
            if ($img_width < $image_width) {
                $img_height *= $image_width / $img_width;
            }
            if ($img_height > $max_height) {
                $max_height = $img_height;
            }

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
                    echo '<a href="https://elloracaves.org/caves.php?cmd=search&words='.$searchstring;
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
                    echo '<a href="https://elloracaves.org/caves.php?cmd=search&words='.$searchstring;
                    echo '&cave_ID='.$searchcave.'&plan_floor='.$searchfloor;
                    echo '&image_ID='.$scroll_image_IDs[$scroll_image_next].'">';
                    echo '<b>>></b>';
                    echo '</a>';
                    echo '</span>';
                }
                echo '</span>';
            }

            // Caption
            echo '<span class="'.$active_string2.'caption" style="font-size:85%; left:'.$caption_left.'px;">';
                 // overflow:auto; background-color:#000000;">';
            echo $row["image_subject"];
            if ($row["image_description"]!="") {
                echo '<br /><br />'.$row["image_description"];
            }
            echo '<br /><br /><span class="tiny">'.$row["image_ID"].' ('.$row["image_file"].')</span>';
            echo '</span>';

            echo '</div>';  // image_
        }
        echo '</div>';  // slides
        echo '</div>';  // slidebox
        echo '</div>';  // topbox
    } else {
        $thumbs_top = 0;
    }


    // Thumb box (thumbnails)
    echo '<div class="thumbbox" style="position:absolute; top:'.($max_height + $thumbs_shift_down).'px;">';
//    echo '<div class="thumbbox" style="float:left;">';  // (thumbs cover main image if bigger than plan)
    echo '<br />'.count($Images).' result';
    if (count($Images)!=1) { echo 's'; }
    if (strlen(trim($searchstring)) > 0) {
        echo ' with search string "<i>'.$searchstring.'</i>"';
    } 
    if (strlen($searchcave) > 0) {
        $sql = "SELECT cave_name
         FROM caves
         WHERE cave_ID = '".$searchcave."'";
        $result = mysql_query($sql) or die (mysql_error());
        $row = mysql_fetch_array($result);
        $cave_name = $row['cave_name'];
        echo '<i> in </i> <b> '.$cave_name.'</b>'; // , floor '.$searchfloor;
    }
    echo ':<br />';

    // Thumbnails
    foreach ($Images as &$row) {
        echo '<span id="thumb_'.$row["image_ID"].'">';
        echo '<a href="https://elloracaves.org/caves.php?cmd=search&words='.$searchstring;
        echo '&cave_ID='.$searchcave.'&plan_floor='.$searchfloor.'&image_ID='.$row['image_ID'].'">';
    
        if ($row['image_ID']==$start_image_ID) {
            $border_width = 2;
        } else {
            $border_width = 0;
        }
        echo '<img src="' . $thumb_dir . $row['image_file'] . '" height="'.$thumb_height.'" border="'.$border_width.'"/></a>';
        echo ' ';
        echo '</span>';
    } 
    
    echo '</div>';  // thumbbox
    echo '</div>';  // mainbox


include("./shared/footer.php"); 

?>

</body>
</html>
