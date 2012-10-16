<?php

// Loaded variables
$plan_ID = mysql_escape_string($_GET['plan_ID']);
$image_ID = mysql_escape_string($_GET['image_ID']);

// Paths and database
$image_dir = "http://media.elloracaves.org/images/caves_360px/";
$thumb_dir = "http://media.elloracaves.org/images/caves_thumbs/";
$plan_dir = "http://media.elloracaves.org/images/plans/";
include_once("../../../db/elloracaves_db.php");

// Settings
$image_width = 360;
$plus        = 5;
$nclicks     = 1;
$yoffset     = 13;
$xoffset     = 5;
$ydraw       = -2;
$xdraw       = 3;

// Search for image and corresponding plan
// If no image or plan
if ($image_ID=="" && $plan_ID=="") {
  // Search for image with empty or negative coordinate and corresponding plan
  $sql = "SELECT image_ID, image_file, image_rank, image_description,";
  $sql.= "image_cave_ID, image_plan_ID, image_plan_x, image_plan_y,";
  $sql.= "cave_ID, cave_name, ";
  $sql.= "plan_cave_ID, plan_image, plan_floor, plan_width, plan_ID ";
  $sql.= "FROM images, caves, plans ";
  $sql.= "WHERE (image_plan_x<0 OR image_plan_y<0 or image_plan_x='' OR image_plan_y='') ";
  $sql.= "AND image_cave_ID=plan_cave_ID ";
  $sql.= "AND plan_cave_ID=cave_ID ";
  $sql.= "AND plan_ID=image_plan_ID ";
  $sql.= "AND image_rank=1 ";
} else {
  // If plan but no image
  if ($image_ID=="") {
    $sql = "SELECT image_ID, image_file, image_rank, image_description,";
    $sql.= "image_cave_ID, image_plan_ID, image_plan_x, image_plan_y,";
    $sql.= "cave_ID, cave_name, ";
    $sql.= "plan_cave_ID, plan_image, plan_floor, plan_width, plan_ID ";
    $sql.= "FROM images, caves, plans ";
    $sql.= "WHERE (image_plan_x<0 OR image_plan_y<0 or image_plan_x='' OR image_plan_y='') ";
    $sql.= "AND plan_ID=".$plan_ID." ";
    $sql.= "AND image_plan_ID=".$plan_ID." ";
    $sql.= "AND plan_cave_ID=cave_ID ";
    $sql.= "AND image_cave_ID=plan_cave_ID ";
    $sql.= "AND image_rank=1 ";
  // If image but no plan
  } else {
      $sql = "SELECT image_ID, image_file, image_rank, image_description,";
      $sql.= "image_cave_ID, image_plan_ID, image_plan_x, image_plan_y,";
      $sql.= "cave_ID, cave_name, ";
      $sql.= "plan_cave_ID, plan_image, plan_floor, plan_width, plan_ID ";
      $sql.= "FROM images, caves, plans ";
      $sql.= "WHERE image_ID=".$image_ID." ";
      $sql.= "AND plan_cave_ID=cave_ID ";
      $sql.= "AND image_plan_ID=plan_ID ";
      $sql.= "AND image_cave_ID=plan_cave_ID ";
      $sql.= "AND image_rank=1 ";
  }
}
// Retrieve the first result
$result = mysql_query($sql) or die (mysql_error());
$row = mysql_fetch_object($result);
$image_ID    = $row->image_ID;
$image_file  = $row->image_file;
$image_rank  = $row->image_rank;
$image_desc  = $row->image_description;
$cave_name   = $row->cave_name;
$plan_image  = $row->plan_image;
$plan_floor  = $row->plan_floor;
$plan_width  = $row->plan_width;
$image_cave_ID  = $row->image_cave_ID;
$plan_ID = $row->plan_ID;

// Find images to plot on selected cave plan
// Check to see if there are any images to fix
if ($image_ID=="") {
  echo '<br /><br />All images have been assigned coordinates.for this cave plan.';
} else {

  // Get all images for selected cave plan
  $sql = "SELECT image_ID, image_cave_ID, image_file, image_rank,
         image_description, cave_name, 
         plan_ID, plan_cave_ID, plan_image_ID, plan_width, 
         plan_image, image_plan_x, image_plan_y
         FROM images, caves, plans
         WHERE image_plan_ID = ".$plan_ID."
         AND plan_ID = ".$plan_ID."
         AND image_cave_ID = cave_ID
         AND plan_cave_ID = cave_ID
         AND image_rank = 1
         ORDER BY image_file ASC";
  $result = mysql_query($sql) or die (mysql_error());
  // Create Images array
  $Images = array();
  $i=0;
  while($row = mysql_fetch_array($result)){
    // NOTE: CAVE 10 floor 1 IMAGES REPEAT
    if ($plan_ID==10) {
      if ($i % 2 == 0) {
        $Images[$i] = $row;
      }
    } else {
        $Images[$i] = $row;
    }
    $i = $i + 1;
  }

  // Get all images missing coordinates in selected cave plan
  $sql = "SELECT image_ID, image_file, image_rank, image_description,";
  $sql.= "image_cave_ID, image_plan_ID, image_plan_x, image_plan_y,";
  $sql.= "cave_ID, cave_name, ";
  $sql.= "plan_cave_ID, plan_image, plan_floor, plan_width, plan_ID ";
  $sql.= "FROM images, caves, plans ";
  $sql.= "WHERE (image_plan_x<0 OR image_plan_y<0 or image_plan_x='' OR image_plan_y='') ";
  $sql.= "AND plan_ID=".$plan_ID." ";
  $sql.= "AND image_plan_ID=".$plan_ID." ";
  $sql.= "AND plan_cave_ID=cave_ID ";
  $sql.= "AND image_cave_ID=plan_cave_ID ";
  $sql.= "AND image_rank=1 ";
  $result = mysql_query($sql) or die (mysql_error());
  // Create Missing_images array
  $Missing_images = array();
  $i=0;
  while($row = mysql_fetch_array($result)){
    // NOTE: CAVE 10 floor 1 IMAGES REPEAT
    if ($plan_ID==10) {
      if ($i % 2 == 0) {
        $Missing_images[$i] = $row;
      }
    } else {
        $Missing_images[$i] = $row;
    }
    $i = $i + 1;
  }
}
?>

<!-- Scripts -->
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/wz_jsgraphics.js"></script>
<script language="javascript" type="text/javascript" src="scripts/raphael-min.js"></script> 

<!-- Function to draw on cave plans -->
<script type="text/javascript">
$(document).ready(function(){

  var plus    = <?= $plus ?>;
  var yoffset = <?= $yoffset ?>;
  var xoffset = <?= $xoffset ?>;
  var xdraw    = <?= $xdraw ?>;
  var ydraw    = <?= $ydraw ?>;
  var nclicks = <?= $nclicks-1 ?>;

  jQuery(document).ready(function(){
    var X = [];
    var Y = [];
    $("#plan").mousemove(function(e){
      $('#live').html((e.pageX - this.offsetLeft - xoffset) +', '+ (e.pageY - this.offsetTop - yoffset));
    }); 
    $("#plan").click(function(e){
      var iX = X.length;
      X[iX] = e.pageX - this.offsetLeft - xoffset;
      Y[iX] = e.pageY - this.offsetTop - yoffset;

      jg.setColor("#ff0000");
      jg.drawLine(X[iX]-plus+xdraw, Y[iX]+yoffset+ydraw, X[iX]+plus+xdraw, Y[iX]+yoffset+ydraw);
      jg.drawLine(X[iX]+xdraw, Y[iX]+yoffset-plus+ydraw, X[iX]+xdraw, Y[iX]+yoffset+plus+ydraw);
      jg.paint();

      $('#click').html(X[iX] +', '+ Y[iX]);

      if (iX==nclicks) {

        jg.drawLine(X[0]+xdraw, Y[0]+yoffset+ydraw, X[1]+xdraw, Y[1]+yoffset+ydraw);
        jg.paint();

        //document.write('Y[] = ' + Y);
        $.get("store_points.php", { image_ID: image_ID, 'X[]': X, 'Y[]': Y });

        // Refresh page
        setTimeout("location.reload(true);",1000);

      }
    }); 
  });
});
</script>

<!-- Start web page -->
</head>
<body>
<title>Fix images: annotate and add coordinates to ground plans</title>

<?php
if ($image_ID!="") {

// Ground plan
  echo '<div id="plan">';
  echo '<img src="'.$plan_dir.$plan_image.'" width="'.$plan_width.'";
         border="0" style="position:absolute; left:0px;"/>';
  // Markers on ground plan
  echo '<div style="position:absolute; left:0px;">';
  foreach ($Images as &$row) {
    $X = explode(",",$row['image_plan_x']);
    $Y = explode(",",$row['image_plan_y']);
    $marker_size1 = 8;
    $marker_size2 = 4;
    // If there is at least one pair of coordinates for an image:
    $x0 = $X[0];
    $y0 = $Y[0];
    if ($x0>0 && $y0>0) {
      // Standing marker:
      echo '<img src="http://media.elloracaves.org/images/decor/marker_on.png"
            id="marker'.$row["image_ID"].'"
            border="0" width="'.$marker_size1.'" height="'.$marker_size1.'"
            style="position:absolute;
                   top:'.$y0.'px;
                   left:'.$x0.'px;" />';
    }
  }
  echo '</div>';
?>

<!-- Graphics and crosshair variables-->
<script type="text/javascript">
  var jg = new jsGraphics("plan");
</script>
<script type="text/javascript" src="scripts/crosshairs.js"></script>
<script type="text/javascript"> var image_ID = <?= $image_ID ?>; </script>
</div>

<?php
// Image
  echo '<div id="image" style="position:absolute; left:'.($plan_width+20).'px;">';
  echo '   <img src="' . $image_dir . $image_file . '" width="'.$image_width.'"><br />';
  echo '   <span class="caption">ID: '.$image_ID;
  echo '   &nbsp;&nbsp;&nbsp;';
  echo '   <span class="caption"><b>'.$cave_name.'</b></span>';
  echo '   <span class="caption"> (floor '.$plan_floor.')</span>';
  echo '   &nbsp;&nbsp;&nbsp;';
  echo '   <span class="caption">'.$image_file.'</span><br /><br />';
  echo '   <div id="live">0, 0</div>';
  echo '   <br /><br />';

// Form to select cave plan -- returns first image that is missing coordinates
  echo '   <form method="get" action='.$PHP_SELF.'?imageID=&plan_ID='.$plan_ID.'>';
            include("../shared/cave_plans_menu.php");
  echo '   <input type="submit" value="select cave plan" name="submit">';
  echo '   </form>';
  echo '   <br /><br />';

// Form to select image by ID
  echo '   <form method="get" action='.$PHP_SELF.'?image_ID='.$image_ID.'&plan_ID=>';
  echo '    Image ID:&nbsp;&nbsp;<input type="text" size="10"  name="image_ID" value="'.$image_ID.'">';
  echo '   <input type="submit" value="OR select image" name="submit">';
  echo '   </form>';

  echo '</div>';

// Form to update image annotation entries
  echo '<form action="./insert.php" method="post">';
  echo '<div id="image" style="position:absolute; left:'.($plan_width+$image_width+40).'px;">';
  echo '<div class="caption"><i>';
  echo '<input type="hidden" name="num_rows" value="'.$num_rows.'">';
  echo '<input type="hidden" name="update_image_ID" value="'.$image_ID.'">';
  echo 'Cave ID: <br /><input type="text" size="20"  name="update_image_cave_ID" value="'.$image_cave_ID.'">';

  if ($plan_floor==1) {
     $floor1 = 'checked'; $floor2 = ''; $floor3 = '';
  }
  elseif ($plan_floor==2) {
     $floor2 = 'checked'; $floor1 = ''; $floor3 = '';
  }
  elseif ($plan_floor==3) {
     $floor3 = 'checked'; $floor1 = ''; $floor2 = '';
  }
  echo 'Floor: ';
  echo '&nbsp;&nbsp;&nbsp;';
  echo '1  <input type="radio" name="update_floor" value="1" '.$floor1.'>';
  echo '&nbsp;&nbsp;&nbsp;&nbsp;';
  echo '2  <input type="radio" name="update_floor" value="2" '.$floor2.'>';
  echo '&nbsp;&nbsp;&nbsp;&nbsp;';
  echo '3  <input type="radio" name="update_floor" value="3" '.$floor3.'>';
  echo '<br>';

  echo 'Medium: <br /><input type="text" size="20" name="update_image_medium" value="'.$image_medium.'"><br />';
  echo 'Subject: <br /><input type="text" size="65" name="update_image_subject" value="'.$image_subject.'"><br />';
  echo 'Motifs: <br /><input type="text" size="65" name="update_image_motifs" value="'.$image_motifs.'"><br />';
  echo 'Description: <br /><textarea cols="47" rows="10" name="update_image_description">'.$image_desc.'</textarea><br />';
  echo 'Image rank: <input type="text" size="2"  name="update_image_rank" value="'.$image_rank  .'">';

  if ($image_rotate==0) {
     $rot0 = 'checked'; $rot1 = ''; $rot2 = ''; $rot3 = '';
  }
  elseif ($image_rotate==1) {
     $rot1 = 'checked'; $rot0 = ''; $rot2 = ''; $rot3 = '';
  }
  elseif ($image_rotate==2) {
     $rot2 = 'checked'; $rot1 = ''; $rot0 = ''; $rot3 = '';
  }
  elseif ($image_rotate==3) {
     $rot3 = 'checked'; $rot1 = ''; $rot2 = ''; $rot0 = '';
  }
  echo '<br />Rotate (# times): ';
  echo '&nbsp;&nbsp;&nbsp;&nbsp;';
  echo '0  <input type="radio" name="update_image_rotate" value="0" '.$rot0.'>';
  echo '&nbsp;&nbsp;&nbsp;&nbsp;';
  echo '1  <input type="radio" name="update_image_rotate" value="1" '.$rot1.'>';
  echo '&nbsp;&nbsp;&nbsp;&nbsp;';
  echo '2  <input type="radio" name="update_image_rotate" value="2" '.$rot2.'>';
  echo '&nbsp;&nbsp;&nbsp;&nbsp;';
  echo '3  <input type="radio" name="update_image_rotate" value="3" '.$rot3.'>';
  echo '<br />Master image ID: <input type="text" size="2"  name="update_master_ID"       value="'.$master_ID .'">';
  echo '&nbsp;&nbsp; x: <input type="text" size="2"  name="update_x"       value="'.$image_plan_x .'">';
  echo '&nbsp;&nbsp; y: <input type="text" size="2"  name="update_y"       value="'.$image_plan_y .'">';
  echo '</i>';
  echo '</div>';

  echo '<br /><input type="submit" value="Update" />';
  echo '<input type="reset"  value="Reset"  />';
  echo '</form>';
  echo '</div>';

// Thumbnail images missing coordinates
  echo '<div class="thumbnails" style="position:relative; width:1200px; top:760px;">';
  foreach ($Missing_images as &$row) {
    echo '<span id="thumb_'.$row["image_ID"].'">';
    echo '<a href="http://elloracaves.org/admin/fix/index.php?image_ID='.$row['image_ID'].'&plan_ID=&submit=select+cave+plan">';

    if ($row['image_ID']==$image_ID) {
      echo '<img src="' . $thumb_dir . $row['image_file'] . '" height="100" border="4"/></a>';
    } else {
      echo '<img src="' . $thumb_dir . $row['image_file'] . '" height="100" border="0"/></a>';
    }
    echo ' ';
    echo '</span>';
  }
  echo '</div>';
}
?>

</body>
</html>
