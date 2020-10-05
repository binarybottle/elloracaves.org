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
  <link rel="icon" type="image/png" sizes="96x96" href="./shared/icons/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="32x32" href="./shared/icons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="./shared/icons/favicon-16x16.png">

<script type="text/javascript" src="./shared/jquery-1.4.4.min.js"></script>
<script language="javascript" type="text/javascript" src="./shared/raphael-min.js"></script> 

<?php include("./shared/popup.js"); ?>
<?php include("./shared/banner_caves.php"); // Calls search.php ?>
<?php include("../db/elloracaves_db.php"); // Calls search.php ?>

<!--script type="text/javascript">

  // Rollover markers in cave plans
<?php
/*
    foreach ($Images as &$row) {
      echo '$(img#marker'.$row["image_ID"].').mouseenter(function (){
        this.attr({fill: "red"});
      });';
*/
/*
      function() {
        circle.show();
      }, 
      function() {
        circle.hide();
      });';
*/
//    }
?>

</script-->

<script type="text/javascript">

 jQuery(document).ready(function(){

<?php 
/*
    foreach ($Images as &$row) {
      echo '$("img#marker'.$row["image_ID"].'").hover(
      function() {
        $(this).attr("src","http://elloracaves.org/images/decor/marker_on.png");
      }, 
      function() {
        $(this).attr("src","http://elloracaves.org/images/decor/marker_off.png");
      });';
*/
    // Postload images:
    $postload = 1;
    if ($postload==1 && strlen($searchcave)>0) {
      $sqlPL = 'SELECT image_file
                FROM images
                WHERE image_cave_ID = '.$searchcave.'
                AND image_rank = 1';
      $resultPL = mysqli_query($link,$sqlPL) or die (mysql_error());
      // Create JS array: Array('image_1.png', 'image_2.png', 'image_3.png');

      $array_string = '';
      $i0 = 0;
      while($rowPL = mysqli_fetch_array($resultPL)){
          $i0 = $i0 + 1;
          if ($i0 > 1) {
            $array_string .= ',';
          }
          $array_string .= '"'.$image_dir.$rowPL["image_file"].'",';
          $array_string .= '"'.$thumb_dir.$rowPL["image_file"].'"';
      }
?>
      // Postload images:
      jQuery(document).ready(function(){
        $(window).bind('load', function() {
              var preload = new Array(<?php echo $array_string; ?>);
              var img = document.createElement('img');
              $(img).bind('load', function() {
                      if(preload[0]) {
                              this.src = preload.shift();
                      }
              }).trigger('load');
        });
      });
  <?php } ?>

  // Make active images appear
  // (http://stackoverflow.com/questions/34536/how-do-you-swap-divs-on-mouseover-jquery)
  switches = $('#switches > dt');
  slides = $('#slides > div');
  switches.each(function(idx) {
     $(this).data('slide', slides.eq(idx));
   }).hover(
   function() {
     switches.removeClass('active');
     slides.removeClass('active');
     $(this).addClass('active');
     $(this).data('slide').addClass('active');
   });
 });

</script>

<style type="text/css">

<!-- CSS for plan markers -->
<style type="text/css">
 #switches .active {
   font-weight: bold;
 }
 #slides div {
   display: none;
 }
 #slides div.active {
   display: block;
 }
</style>

</head>

<?php flush(); ?>
