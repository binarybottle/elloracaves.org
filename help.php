<?php
include("../db/elloracaves_db.php");
include("./shared/header_caves.php");

$image_dir   = "http://media.elloracaves.org/images/caves/";
$thumb_dir   = "http://media.elloracaves.org/images/caves_thumbs/";
$plan_dir    = "http://media.elloracaves.org/images/plans/";
$table_width = 800;
$image_width = 480;
$scale       = 0.75;
$offsetY     = 210;
$offsetY_marker = 20;  // $offsetX_marker below
$default_cave_ID = '0';
$default_plan_width = $scale*480;
?>

<body style="background-image:url(http://media.elloracaves.org/images/maps/map_260x1024px_gradient.png);
             background-repeat:no-repeat;
             background-position: top left;
             background-color: black;">

<title>Ellora Cave Temples</title>

<div class="text_block">
<font color="orange">NOTE: Internet Explorer is not supported.</font>
<br /><br /><br />
<b>Search help:</b>
<br /><br />
Anything <font color="#487a14">green</font> is a link and can be clicked or moused over.<br />
<br />
There are two ways to search for images:<br />
1. Click on a cave number on the map above to view images of that cave.<br />
2. Or, type in <b>Keywords</b> and/or select a <b>Cave</b> from the search bar, then click "<b>Search</b>".
 <br />
 <br />
 <i>Keyword examples:</i><br />
 To show images described with the word "buddha" <i>OR</i> "seated" type:
 <br /><br /> 
 &nbsp;&nbsp;&nbsp;&nbsp;
 buddha seated 
 <br /><br />
 To show images described with the word "buddha" <i>AND</i> "seated" type:
 <br /><br /> 
 &nbsp;&nbsp;&nbsp;&nbsp;
 +buddha +seated 
 <br /><br />
 To show images described with the word "buddha" <i>AND NOT</i> "standing" type:
 <br /><br /> 
 &nbsp;&nbsp;&nbsp;&nbsp;
 +buddha -standing 
 <br /><br />
 For further instructions, please refer to the relevant MySQL 
<a href="http://dev.mysql.com/doc/refman/5.0/en/fulltext-boolean.html" onClick="return popup(this,'MySQL help')">help</a> 
 page.


</div>


<?php include("./shared/footer.php"); ?>

</body>
</html>
