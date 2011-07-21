<?php
 $cave_ID = mysql_escape_string($_POST['cave_ID']);
 if ($cave_ID=="") {
   $cave_ID = 23;
 }
 $image_dir = "http://media.elloracaves.org/images/caves_360px/";
 $plan_dir = "http://media.elloracaves.org/images/plans/";

 include_once("../../../db/elloracaves_db.php");
 //include("../shared/header_start.php");

 $image_width = 360;
 $plus        = 5;
 $nclicks     = 2;

 $yoffset     = 13;
 $xoffset     = 5;

 $ydraw       = -2;
 $xdraw       = 3;
?>

  <script type="text/javascript" src="scripts/jquery.js"></script>
  <script type="text/javascript" src="scripts/wz_jsgraphics.js"></script>
  <script language="javascript" type="text/javascript" src="scripts/raphael-min.js"></script> 
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

</head>
<body>

<title>Edit coordinates in Ellora Cave Temple ground plans</title>

<!-- Search for image with coordinate < 0 -->
<?php
$sql = "SELECT image_ID, image_file, image_rank, image_description,";
$sql.= "image_cave_ID, image_plan_x, image_plan_y,";
$sql.= "cave_ID, cave_name, ";
$sql.= "plan_cave_ID, plan_image, plan_floor, plan_width, plan_ID ";
$sql.= "FROM images, caves, plans ";
//$sql.= "WHERE (image_plan_x<0 OR image_plan_y<0) ";
//$sql.= "AND image_cave_ID=cave_ID ";
$sql.= "WHERE image_cave_ID=cave_ID ";
$sql.= "AND image_cave_ID=plan_cave_ID ";
$sql.= "AND plan_cave_ID=cave_ID ";
$sql.= "AND cave_ID=".$cave_ID." ";
$sql.= "AND image_rank=1 ";
$result = mysql_query($sql) or die (mysql_error());

// retrieve the first result
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
$plan_ID  = $row->plan_ID;

if ($plan_image=="") {
  echo '<br /><br />All images for cave ID = '.$cave_ID.' have been assigned.  
  To reassign, go to <a href="edit.php">edit.php</a>';
} else {

  // GROUND PLAN
  echo '<div id="plan">';
  echo '<img src="'.$plan_dir.$plan_image.'" width="'.$plan_width.'";
         border="0" style="position:absolute; left:0px;"/>';

  // All images for selected cave 
  $sql = "SELECT image_ID, image_cave_ID, image_file, image_rank,
         image_description, cave_name, 
         plan_ID, plan_cave_ID, plan_image_ID, plan_width, 
         plan_image, image_plan_x, image_plan_y
         FROM images, caves, plans
         WHERE cave_ID = '".$cave_ID."'
         AND image_cave_ID = cave_ID
         AND plan_cave_ID = cave_ID
         AND image_rank = 1
         ORDER BY image_file ASC";
  $result = mysql_query($sql) or die (mysql_error());
  // Create Images array
  $Images = array();
  $i=0;
  while($row = mysql_fetch_array($result)){
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
  // Markers on ground plan
  echo '<div style="position:absolute; left:0px;">';
  echo '<script type="text/javascript">
        var paper = Raphael(0,0,'.$plan_width.','.($plan_width*5).');
        </script>
        ';

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
                     left:'.$x0.'px;" />
              ';
        /*
        // If there is a second pair of coordinates for an image,
        // draw lines of sight from standing marker to subject marker
        $x1 = $X[1];
        $y1 = $Y[1];
        if ($x1>0 && $y1>0) {
            $radius = 2;
            $opacity = 0.6;
            // If there is a second pair of coordinates for an image,
            // draw lines of sight from standing marker to subject marker
            echo '<script type="text/javascript"> 
             var line = paper.path("M'.($xoffset+$x0).' '.($yoffset+$y0).'L'.($xoffset+$x1).' '.($yoffset+$y1).'");
             line.attr({stroke: "red", opacity: '.$opacity.'});
            </script>
            ';
            // Subject marker
            echo '<script type="text/javascript">
             var circle = paper.circle('.($xoffset+$x1).','.($yoffset+$y1).','.$radius.');
             circle.attr({fill: "yellow", opacity: '.$opacity.'});
            </script>
            ';
        }
        */
      }

  }
  echo '</div>';
?>

  <!-- GRAPHICS -->
  <script type="text/javascript">
    var jg = new jsGraphics("plan");
  </script>
 
  <!-- CROSSHAIRS -->
  <!--script type="text/javascript" src="scripts/crosshairs.js"></script-->
 
  <!--script type="text/javascript"> var image_ID = <!--?= $image_ID ?>; </script-->
 
  </div>

  <!-- IMAGE -->
  <div id="image" style="position:absolute; left:<? echo ($plan_width+20) ?>px;">
   <img src="<? echo $image_dir.$image_file; ?>" width="<? echo $image_width; ?>"/>
   <div style="width:<? echo $image_width; ?>px;">
    <span class="caption"><? echo $image_ID; ?>:</span>
     &nbsp;&nbsp;&nbsp;
    <span class="caption"><b><? echo $cave_name; ?></b></span>
     &nbsp;&nbsp;&nbsp;
    <span class="caption"><? echo $image_file; ?></span>
    <br /><br />
     &nbsp;&nbsp;&nbsp;
    <span class="caption"><? echo $image_desc; ?></span>
    <br /><br />
    <!--div id="live">0, 0</div-->
    </div>
    <br /><br />

    <form method="post" action="<?php echo $PHP_SELF;?>">
     <?php include('../shared/cave_menu_return_cave_ID.php'); ?>
     <input type="submit" value="select cave" name="submit">
    </form>

</div>


   </div>
  </div>

<? } ?>

</body>
</html>
