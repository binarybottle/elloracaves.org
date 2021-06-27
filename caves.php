<?php
$image_dir   = "images/caves_360px/";
$thumb_dir   = "images/caves_thumbs/";
$plan_dir    = "images/plans/";

$default_cave_ID = '10';
$default_plan_floor = 1;
$miniplan_width = 100;
$image_width = 360;
$caption_left = 400;
$thumbs_shift_down = 300; //20;
$thumbs_shift_right = 135;
$thumb_height = 100;
$scale_plans = 0.75;
$default_plan_width = $scale_plans*480;
$blank_image = 'blank.png';
$postload = 1;

//$searchcave   = mysqli_real_escape_string($_GET['cave_ID']);
$searchcave   = $_GET['cave_ID'];
$searchfloor  = $_GET['plan_floor'];
$searchimage  = $_GET['image_ID'];
$plan_images  = $_GET['plan_images'];

if (strlen($searchcave)==0) {
  $searchcave = $default_cave_ID;
}
if (strlen($searchfloor) == 0) {
  $searchfloor = $default_plan_floor;
}

include("./shared/header_caves.php");
?>

<body style="background-color: black;
             background-image:url(images/maps/map_260x1024px_gradient.png);
             background-repeat:no-repeat;
             background-position: top left;">

<title>Ellora Cave Temples</title>

<?php

// plan_image_ID
$sql = "SELECT *
         FROM plans
         WHERE plan_cave_ID = '".$searchcave."'";
$result = mysqli_query($link,$sql) or die (mysql_error());
$row_plan = mysqli_fetch_array($result);
$plan_image_ID = $row_plan['plan_image_ID'];
$plan_ID = $row_plan['plan_ID'];

// Mini floorplans
// If there is a plan image, mini ground plans
if ($plan_image_ID > 0 && strlen(trim($searchstring))==0) {

    // Floor numbers
    $sql = "SELECT plan_floor
         FROM plans
         WHERE plan_cave_ID = '".$searchcave."'";
    $result = mysqli_query($link,$sql) or die (mysql_error());
    // Create floors array
    $floors = array();
    $i=0;
    while($row_floor = mysqli_fetch_array($result)){
        $floors[$i] = $row_floor;
        $i = $i + 1;
    }

    // Plan images
    $sql = "SELECT plan_image
         FROM plans
         WHERE plan_cave_ID = '".$searchcave."'";
    $result = mysqli_query($link,$sql) or die (mysql_error());
    // Create plan_images array
    $plan_images = array();
    $i=0;
    while($row_plan_images = mysqli_fetch_array($result)){
        $plan_images[$i] = $row_plan_images;
        $i = $i + 1;
    }

    // Mini-plans
    if (sizeof($floors) > 1) {
        echo '<div class="miniplans">';
        for ($ifloor = 0; $ifloor < sizeof($floors); $ifloor++) {
            echo '<a href="https://elloracaves.org/caves.php?cmd=search&words=&imageID=&cave_ID='.$searchcave.'&plan_floor='.($ifloor+1).'">';
            echo '<img src="'.$plan_dir.$plan_images[$ifloor][0].'" width="'.$miniplan_width.'"/><br />';
            echo '</a>';
            echo '<div class="miniplan_title">floor '.$floors[$ifloor][0].'</div><br /><br /><br />';
        }
        echo '</div>';
    }
}


// Cave images  
// If there is a cave_ID, get cave images and the number of cave images
if ($searchcave > 0 && strlen(trim($searchstring))==0) {
    $sql = "SELECT * FROM images
         WHERE image_cave_ID = '".$searchcave."'";
    $resultIMAGES = mysqli_query($link,$sql) or die (mysql_error());
    $num_cave_images=0;
    while($row_resultIMAGES = mysqli_fetch_array($resultIMAGES)){
        $num_cave_images = $num_cave_images + 1;
    }
}

// If there is a cave_ID and a $searchimage, get the image:
echo '<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$searchimage.' &  '.$searchstring;
if ($searchimage > 0) {
} else {
    $sql = "SELECT image_master_ID FROM images WHERE image_cave_ID = ".$searchcave;
    $resultIMAGE = mysqli_query($link,$sql) or die (mysql_error());
    $row_resultIMAGE = mysqli_fetch_array($resultIMAGE);
    $searchimage = $row_resultIMAGE['image_master_ID'];
}
//if ($searchimage > 0 && strlen(trim($searchstring))==0) {
if (strlen(trim($searchstring))==0) {
    $sql = "SELECT image_file,image_subject,image_description,image_ID
         FROM images WHERE image_ID = '".$searchimage."'";
    $resultIMAGE = mysqli_query($link,$sql) or die (mysql_error());
    $row_resultIMAGE = mysqli_fetch_array($resultIMAGE);
    $image_file = $row_resultIMAGE['image_file'];

    $image_subject = $row_resultIMAGE['image_subject'];
    $image_description = $row_resultIMAGE['image_description'];
    $image_ID = $row_resultIMAGE['image_ID'];
}


// Main box (plan, image, caption, thumbnails)
echo '<div class="mainbox">';
echo '<br><br><br>';
echo '<div class="topbox" style="float:left;">';

// Plot plan and main image above thumbnails if no search or if found image
if (strlen(trim($searchstring))==0 || strlen($searchimage)>0) { 

        // If there is a plan image
        if ($plan_image_ID > 0) {

            $plan_image = $plan_images[$searchfloor-1][0];
            $url = $plan_dir.$plan_image;
            $url = trim($url); // Get rid of any accidental whitespace

            // Plan box (floor plan)
            echo '<div class="planbox" style="float:left;">';
            echo '<img src="'.$url.'" width="'.$plan_width.'px;"/>';
            if ($plan_image != $blank_image) {
                echo '<span style="position:absolute; left:'.($plan_width/2-20).
                   'px; bottom:-20px;">'.$cave_name.'</span>';
            }

            // Markers on plan
            $parsed = parse_url($url); // analyse the URL
            if (isset($parsed['scheme']) && strtolower($parsed['scheme']) == 'https') {
              // If it is https, change it to http
              $url = 'http://'.substr($url,8);
            }
            $plan_size = getimagesize($url);
            $plan_height = $plan_size[1];
            $plan_height = $scale_plans * $plan_height;
            echo '<div>
                  <dl id="switches">
                  ';
            foreach ($resultIMAGES as $row_resultIMAGE) {
                $X = $row_resultIMAGE['image_plan_x'];
                $Y = $row_resultIMAGE['image_plan_y'];

                // Markers
                if ($row_resultIMAGE['image_ID']==$searchimage) {
                    echo '<dt class = "active">';
                    $marker_state = 'off';
                    $marker_size = 8;
                } else {
                    echo '<dt>';
                    $marker_state = 'on';
                    $marker_size = 6;
                }

                // Floor number
                $sql = "SELECT image_plan_ID FROM images WHERE image_ID = '".$row_resultIMAGE['image_ID']."'";
                $resultIPLAN = mysqli_query($link,$sql) or die (mysql_error());
                $rowIPLAN = mysqli_fetch_array($resultIPLAN);
                $image_plan_ID = $rowIPLAN['image_plan_ID'];

                $sqlFL = "SELECT plan_floor FROM plans WHERE plan_ID = '".$image_plan_ID."'";
                $resultFL = mysqli_query($link,$sqlFL) or die (mysql_error());
                $rowFL = mysqli_fetch_array($resultFL);
                $plan_floor = $rowFL['plan_floor'];

                // If there is a pair of coordinates for an image, place marker
                if ($X>0 && $Y>0 && $plan_floor==$searchfloor) {
                    $x0 = $X; //$scale_plans*$X;
                    $y0 = $Y; //$scale_plans*$Y;
                    if ($row_resultIMAGE['image_ID'] == $row_resultIMAGE['image_master_ID']) {

                        echo '<a href="https://elloracaves.org/caves.php?cmd=search&words=&cave_ID='.$plan_ID.'&plan_floor='.$plan_floor.'&image_ID='.$row_resultIMAGE["image_ID"].'">';
                        echo '<img src="images/decor/marker_'.$marker_state.'.png"
                            id="marker'.$row_resultIMAGE["image_ID"].'" rel="target'.$row_resultIMAGE["image_ID"].'"
                            border="0" width="'.$marker_size.'" height="'.$marker_size.'"
                            style="position:absolute; top:'.$y0.'px; left:'.$x0.'px;" />
                            ';
                         echo '</a>';
                    } else {
                        echo '<span
                            id="marker'.$row_resultIMAGE["image_ID"].'" rel="target'.$row_resultIMAGE["image_ID"].'"
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

        foreach ($resultIMAGES as $row) {

            if ($row['image_ID']==$start_image_ID) {
                $active_string1 = 'class="active"';
                $active_string2 = ''; //'active.';
            } else {
                $active_string1 = '';
                $active_string2 = '';
            }

            // Image
            if (strlen($searchimage)>0) { 
                $img = $image_dir.$image_file;
            } else {
                $img = $image_dir.$row["image_file"];
            }
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
            foreach ($resultIMAGES as $row2) {
               if ($row2['image_master_ID']==$row['image_master_ID']) {
                    $scroll_image_IDs[$irow2] = $row2['image_ID'];
                    if ($row2['image_ID']==$row['image_ID']) {
                        $scroll_image_number = $irow2;
                    }
                    $irow2 = $irow2 + 1;
                }
            }
/*
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
*/
            // Caption
            echo '<span class="'.$active_string2.'caption" style="font-size:85%; left:'.$caption_left.'px;">';  // overflow:auto; background-color:#000000;">';
            echo $image_subject;
            if ($image_description!="") {
                echo '<br /><br />'.$image_description;
            }
            if ($image_ID > 0) {
                echo '<br /><br /><span class="tiny">'.$image_ID.' ('.$image_file.')</span>';
            }
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
echo '<div class="thumbbox" style="position:absolute; top:'.($max_height + $thumbs_shift_down).'px; left:'.$thumbs_shift_right.'px;">';
echo '<br><br><br>';
echo '<br><br><br>';
echo '<br><br><br>';
echo '<br />'.$num_cave_images.' result';
if ($num_cave_images!=1) {
        echo 's'; 
}
if (strlen(trim($searchstring)) > 0) {
        echo ' with search string "<i>'.$searchstring.'</i>"';
} 
if (strlen($searchcave) > 0) {
        $sql = "SELECT cave_name
         FROM caves
         WHERE cave_ID = '".$searchcave."'";
        $result = mysqli_query($link,$sql) or die (mysql_error());
        $rowB = mysqli_fetch_array($result);
        $cave_name = $rowB['cave_name'];
        echo '<i> in </i> <b> '.$cave_name.'</b>'; // , floor '.$searchfloor;
}
echo ':<br />';

// Thumbnails
foreach ($resultIMAGES as $rowI) {
        echo '<span id="thumb_'.$rowI["image_ID"].'">';
        echo '<a href="https://elloracaves.org/caves.php?cmd=search&words='.$searchstring;
        echo '&cave_ID='.$searchcave.'&plan_floor='.$searchfloor.'&image_ID='.$rowI['image_ID'].'">';
    
        if ($rowI['image_ID']==$start_image_ID) {
            $border_width = 2;
        } else {
            $border_width = 0;
        }
        echo '<img src="' . $thumb_dir . $rowI['image_file'] . '" height="'.$thumb_height.'" border="'.$border_width.'"/></a>';
        echo ' ';
        echo '</span>';
} 
    
echo '</div>';  // thumbbox
echo '</div>';  // mainbox

include("./shared/footer.php"); 

?>

</body>
</html>
