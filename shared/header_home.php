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
  <meta name="dc.identifier" content="http://www.elloracaves.org">
  <meta name="dc.identifier" content="http://www.elloracaves.org">
  <link rel="stylesheet" type="text/css" href="./shared/style.css" />
  <link rel="stylesheet" type="text/css" href="./shared/cave_numbers.css" />

<script type="text/javascript" src="./shared/jquery-1.4.4.min.js"></script>
<?php include("./shared/popup.js"); ?>

<script type="text/javascript">

// Fade banner image to 0% when the page loads
jQuery(document).ready(function(){
   $(".map_overlay").fadeOut(20000);
})

<?php 
/*
  // Postload images:
   //$("p.postload").text("The DOM is now loaded and can be manipulated.");
  $sqlPL = 'SELECT plan_image, plan_image2, plan_image3, image_file
            FROM images, caves, plans
            WHERE cave_ID = image_cave_ID 
            AND plan_ID = cave_ID
            AND image_rank = 1
            AND plan_image_ID = image_ID';
  $resultPL = mysql_query($sqlPL) or die (mysql_error());
  while($rowPL = mysql_fetch_array($resultPL)){
      echo '$("p.postload").load("'.$plan_dir.$rowPL["plan_image"].'");';
      echo '$("p.postload").load("'.$plan_dir.$rowPL["plan_image2"].'");';
      echo '$("p.postload").load("'.$plan_dir.$rowPL["plan_image3"].'");';
      echo '$("p.postload").load("'.$image_dir.$rowPL["image_file"].'");';
      echo '$("p.postload").load("'.$thumb_dir.$rowPL["image_file"].'");';
  }
  
  $sqlPL2 = 'SELECT image_file
            FROM images
            WHERE image_cave_ID = 10
            AND image_rank = 1';
  $resultPL2 = mysql_query($sqlPL2) or die (mysql_error());
  while($rowPL2 = mysql_fetch_array($resultPL2)){
      echo '$("p.postload").load("'.$image_dir.$rowPL2["image_file"].'");';
      echo '$("p.postload").load("'.$thumb_dir.$rowPL2["image_file"].'");';
  }
})
*/
?>

</script>
</head>
