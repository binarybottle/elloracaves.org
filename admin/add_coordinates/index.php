<?php
 $image_dir = "http://media.elloracaves.org/images/caves_360px/";
 $plan_dir = "http://media.elloracaves.org/images/plans/";

 include_once("../../db/elloracaves_db.php");
 include("../shared/header_start.php");

 $image_width = 360;
 $offsetX     = 10;
 $offsetY     = 10;
 $plus        = 5;
 $nclicks     = 1;
 $offset_plus = -10;
 $offset_crosshairs = 10;
?>

  <script type="text/javascript" src="scripts/jquery.js"></script>
  <script type="text/javascript" src="scripts/wz_jsgraphics.js"></script>
  <script type="text/javascript">

   $(document).ready(function(){

     var offsetX     = <?= $offsetX ?>;
     var offsetY     = <?= $offsetY ?>;
     var plus        = <?= $plus ?>;
     var image_width = <?= $image_width ?>;
     var nclicks     = <?= $nclicks-1 ?>;
     var offset_plus = <?= $offset_plus ?>;
     var offset_crosshairs = <?= $offset_crosshairs ?>;

     var shiftX      = offsetX + offset_crosshairs + image_width
     var shiftY      = offsetY + offset_crosshairs
     var shiftXplus  = shiftX + offset_plus
     var shiftYplus  = shiftY + offset_plus

     jQuery(document).ready(function(){
       var X = [];
       var Y = [];
       $("#plan").mousemove(function(e){
         $('#live').html((e.pageX - this.offsetLeft - shiftX) +', '+ (e.pageY - this.offsetTop - shiftY));
       }); 
       $("#plan").click(function(e){
         var iX = X.length;
         X[iX] = e.pageX - this.offsetLeft - shiftX;
         Y[iX] = e.pageY - this.offsetTop - shiftY;

         jg.setColor("#ff0000");
         jg.drawLine(X[iX]+shiftXplus-plus, Y[iX]+shiftYplus, X[iX]+shiftXplus+plus, Y[iX]+shiftYplus);
         jg.drawLine(X[iX]+shiftXplus, Y[iX]+shiftYplus-plus, X[iX]+shiftXplus, Y[iX]+shiftYplus+plus);
         jg.paint();

         $('#click').html(X[iX] +', '+ Y[iX]);

         if (iX==nclicks) {

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
<title>Create Ellora Cave Temple Walk-through</title>

<div>
 <table width="*" border="0" cellspacing="0" cellpadding="0">
  <tr>
   <td width="<? echo $image_width; ?>" valign="bottom">
   <!-- SEARCH -->
   <?
      //include("./searchForm_cave.php");
      if (strlen(trim($cave_name))==0) {
        $s_string = " ";
      } else {
        $s_string = " AND cave_name='".$cave_name."' ";
      }
      $sql = "SELECT image_ID, image_file, image_rank, image_description,";
      $sql.= "image_cave_ID, image_plan_x, image_plan_y,";
      $sql.= "cave_ID, cave_name, ";
      $sql.= "plan_image, plan_width, plan_cave_ID ";
      $sql.= "FROM images, caves, plans ";
      $sql.= "WHERE (image_plan_x<1 OR image_plan_y<1) ";
      $sql.= "AND image_cave_ID=cave_ID ";
      $sql.= "AND plan_cave_ID=cave_ID " . $s_string . " ";
      $sql.= "AND image_rank=1 ";
      $result = mysql_query($sql) or die (mysql_error());
      if ($result) {
      // Just retrieve the first result
         $row = mysql_fetch_object($result);
         $image_ID    = $row->image_ID;
         $image_file  = $row->image_file;
         $image_rank  = $row->image_rank;
         $image_desc  = $row->image_description;
         $cave_ID     = $row->cave_ID;
         $cave_name   = $row->cave_name;
         $plan_image  = $row->plan_image;
         $plan_width  = $row->plan_width;
         $image_cave_ID  = $row->image_cave_ID;
         $plan_cave_ID  = $row->plan_cave_ID;
   ?>
         <script type="text/javascript">
           var image_ID = <?= $image_ID ?>;
         </script>
         <br />

      <!-- IMAGE -->
         <div id="image">
          <img src="<? echo $image_dir.$image_file;?>" width="<? echo $image_width;?>">
          </a>
          <br />
         </div>
         <span class="caption"><? echo $image_ID; ?>:</span>
          &nbsp;&nbsp;&nbsp;
         <span class="caption">(<? echo $cave_name; ?>)</span>
          &nbsp;&nbsp;&nbsp;
         <span class="caption"><? echo $image_file; ?></span>
         <br /><br />
          &nbsp;&nbsp;&nbsp;
         <span class="caption"><? echo $image_desc; ?></span>
   </td>

   <!-- PLAN -->
   <td width="<? echo $plan_width; ?>" valign="top">
      <div id="plan">
        <img src="<? echo $plan_dir.$plan_image; ?>" width="<? echo $plan_width; ?>.'">
      </div>
      <div id="live">0, 0</div>
      <!--div id="click">0, 0</div-->
   <?
      }
   ?>

   <!-- GRAPHICS -->
    <script type="text/javascript">
      var jg = new jsGraphics("plan");
    </script>

   <!-- CROSSHAIRS -->
   <script type="text/javascript" src="scripts/crosshairs.js"></script>

   </td>
  </tr>
 </table>

</div>
</body>
</html>
