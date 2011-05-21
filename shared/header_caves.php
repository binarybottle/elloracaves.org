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
<script language="javascript" type="text/javascript" src="./shared/raphael-min.js"></script> 

<?php include("./shared/popup.js"); ?>
<?php include("./shared/banner_caves.php"); // Calls search.php ?>

<script type="text/javascript">

 jQuery(document).ready(function(){
 
  // Rollover markers in cave plans
  <?php
    foreach ($Images as &$row) {
          
      echo '$("img#marker'.$row["image_ID"].'").hover(
      function() {
        $(this).attr("src","http://media.elloracaves.org/images/decor/marker_on.png");
      }, 
      function() {
        $(this).attr("src","http://media.elloracaves.org/images/decor/marker_off.png");
      });';
    }

    // Postload images:
    if ($postload==1 && strlen($searchcave)>0) {
      $sqlPL = 'SELECT image_file
                FROM images
                WHERE image_cave_ID = '.$searchcave.'
                AND image_rank = 1';
      $resultPL = mysql_query($sqlPL) or die (mysql_error());
      // Create JS array: Array('image_1.png', 'image_2.png', 'image_3.png');
      $array_string = '';
      $i0 = 0;
      while($rowPL = mysql_fetch_array($resultPL)){
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
                      /*}  else {*/
                      /* all images have been loaded */
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
