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
<?php include("./shared/banner.php"); // Calls search.php ?>

<script type="text/javascript">

 jQuery(document).ready(function(){
 
  // Rollover markers in cave plans
  <?php
    foreach ($Images as &$row) {
      $div_string = '<img src="'.$image_dir.$row["image_file"].'" width="'.$image_width.'"><br /><span class="tiny">'.$row["image_ID"].'</span><br />';
//      $div_string .= '<br /><span class="caption">'.$row["image_description"].'</span>';
      $div_string = preg_replace('/\'/', '\\\'', $div_string); 
      
      echo '$("img#marker'.$row["image_ID"].'").hover(
      function() {
        $(this).attr("src","http://media.elloracaves.org/images/decor/marker_on.png");
        $("div.slides").html(\''.$div_string.'\');
      }, 
      function() {
        $(this).attr("src","http://media.elloracaves.org/images/decor/marker_off.png");
      });';

      // Postload images:
      // echo '$("div#image_'.$row["image_ID"].'").html("'.$div_string.'");';
      //echo '$("div#image_'.$row["image_ID"].'").load("'.$image_dir.$row["image_file"].'");';
      //echo '$("span#thumb_'.$row["image_ID"].'").load("'.$thumb_dir.$row["image_file"].'");';
    }
  ?>
  
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
   <?php 
   /*
   // Goes with the following within the HTML:
   <dl id="switches">
    <dt class="active">First slide</dt>
    <dt>Second slide</dt>
    <dt>Third slide</dt>
    <dt>Fourth slide</dt>
   </dt>
   <div id="slides">
    <div class="active">Well well.</div>
    <div>Oh no!</div>
    <div>You again?</div>
    <div>I'm gone!</div>
   </div>
   */
   ?>
 });

</script>

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
