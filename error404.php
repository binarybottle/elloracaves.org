<?php
include("../db/elloracaves_db.php");
include("./shared/header.php");

$image_dir   = "https://elloracaves.org/images/caves/";
$thumb_dir   = "https://elloracaves.org/images/caves_thumbs/";
$plan_dir    = "https://elloracaves.org/images/plans/";
$table_width = 800;
$image_width = 480;
$scale       = 0.75;
$offsetY     = 210;
$offsetY_marker = 20;  // $offsetX_marker below
$default_cave_ID = '0';
$default_plan_width = $scale*480;
?>

<body style="background-image:url(https://elloracaves.org/images/maps/map_260x1024px_gradient.png);
             background-repeat:no-repeat;
             background-position: top left;
             background-color: black;">

<title>Ellora Cave Temples</title>

<?php include("./shared/banner_home.php"); ?>

<div class="text_block">

<table width="760" border="0" cellspacing="0" cellpadding="100">
 <tr>
  <td width="240" valign="top">

I'm sorry, but that address does not exist.
<br>
<br>
 Please try <a href="https://elloracaves.org">again</a>.

  </td>
 </tr>
</table>
</div>
</body>
</html>