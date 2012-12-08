<?php include("../db/elloracaves_db.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <meta name="description" content="Image database containing annotated Ellora cave temple photographs.">
  <meta name="keywords" content="photographs, annotated images, Ellora caves, Ellora cave temples">
  <meta http-equiv="Content-language" content="en">
  <meta name="author" content="mailto:arno&#64;binarybottle.com">
  <meta name="dc.title" content="Annotated Ellora Cave Temple Images"> 
  <meta name="dc.creator.address" content="arno&#64;binarybottle.com"> 
  <meta name="dc.subject" content="photographs, annotated images, Ellora caves, Ellora cave temples">
  <meta name="dc.type" content="text.homepage.educational"> 
  <meta name="dc.format" content="text/html"> 
  <meta name="dc.identifier" content="http://elloracaves.org">
  <meta name="dc.identifier" content="http://elloracaves.org">
  <link rel="stylesheet" type="text/css" href="./shared/style.css" />
  <link rel="stylesheet" type="text/css" href="./shared/cave_numbers.css" />

<script type="text/javascript" src="./shared/jquery-1.4.4.min.js"></script>
<?php include("./shared/popup.js"); ?>

<script type="text/javascript">

// Fade banner image to 0% when the page loads
jQuery(document).ready(function(){
   $(".map_overlay").fadeOut(5000);
})

<?php 

// Preload images (top of the caves page -- plans, default images):
$preload_plans = 1;
$preload_default_cave = 1;

if ($preload_plans==1) {
  $sqlPL = 'SELECT plan_image, image_file
            FROM images, caves, plans
            WHERE cave_ID = image_cave_ID 
            AND plan_ID = cave_ID
            AND image_rank = 1
            AND plan_image_ID = image_ID';
  $resultPL = mysql_query($sqlPL) or die (mysql_error());
  // Create JS array: Array('image_1.png', 'image_2.png', 'image_3.png');
  $array_string = '';
  $i0 = 0;
  while($rowPL = mysql_fetch_array($resultPL)){
      $i0 = $i0 + 1;
      if ($i0 > 1) {
        $array_string .= ',';
      }
      if (strlen($rowPL["plan_image"])>0) {
        $array_string .= '"'.$plan_dir.$rowPL["plan_image"].'",';
      }
      if (strlen($rowPL["image_file"])>0) {
        $array_string .= '"'.$image_dir.$rowPL["image_file"].'",';
        $array_string .= '"'.$thumb_dir.$rowPL["image_file"].'"';
      }
  }

  if ($preload_default_cave==1) {
    $sqlPL2 = 'SELECT image_file
              FROM images
              WHERE image_cave_ID = 10
              AND image_rank = 1';
    $resultPL2 = mysql_query($sqlPL2) or die (mysql_error());
    while($rowPL2 = mysql_fetch_array($resultPL2)){
        $array_string .= ',"'.$image_dir.$rowPL2["image_file"].'",';
        $array_string .= '"'.$thumb_dir.$rowPL2["image_file"].'"';
    }
  }
  ?>
  
  jQuery(document).ready(function(){
  
    // Postload images:
    $(window).bind('load', function() {
          var preload = new Array(<?php echo $array_string; ?>);
          var img = document.createElement('img');
          $(img).bind('load', function() {
                  if(preload[0]) {
                          this.src = preload.shift();
                  /*}  else {*/
                  /* all images have been loaded */
                  }
          }).trigger('load');
    });
  });
  
<?php } ?>

</script>
</head>
<?php flush(); ?>

