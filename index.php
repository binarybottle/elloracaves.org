<?php
$image_dir   = "http://media.elloracaves.org/images/caves_360px/";
$thumb_dir   = "http://media.elloracaves.org/images/caves_thumbs/";
$plan_dir    = "http://media.elloracaves.org/images/plans/";

include("./shared/header_home.php");
?>

<body style="background-image:url(http://media.elloracaves.org/images/maps/map_260x1024px_gradient.png);
             background-repeat:no-repeat;
             background-position: top left;
             background-color: black;">

<title>Ellora Cave Temples</title>

<!-- Disappearing map overlay -->
<img src="http://media.elloracaves.org/images/maps/map_260x1024px_photo.png" alt="map" border="0" class="map_overlay" />

<?php include("./shared/banner_home.php"); ?>

<img class="home_image" align="center" src="http://media.elloracaves.org/images/decor/home_c5_H7.jpg" width="840px" />

<div class="text_block">

<b>About this site:</b>
<br /><br />
Dr. Deepanjana Klein of Christie's, Professor Emeritus Walter Spink of the University of Michigan,
and Arno Klein of Columbia University have brought to you the first comprehensive documentation
of the Ellora cave temples.
<!--Everyone is welcome to use this online resource,
which will be incorporated in a book.-->
Our sponsor ArtStor <a href="http://www.artstor.org/news/n-html/an-081204-ellora.shtml" 
   onClick="return popup(this,'Announcement')">
announced</a> the collection in December, 2008.
<br />
<br />
Currently, we are including ground plans and are preparing to embark on another trip 
to the caves to check all of our entries.

<br />
<br />

<h2 style="position:absolute; left:225px;"><a href="./caves.php">ENTER THE CAVES</a></h2>
<br />
<span style="position:relative; left:226px; top:30px;">
<i>-Internet Explorer is <!--font color="red"-->not<!--/font--> supported-</i>
</span>

<div style="position:absolute; top:740px; left:0px;">
Photographs and website design: <a href="http://www.binarybottle.com" onClick="return popup(this,'binarybottle')">Arno Klein</a>
<br />
Descriptions accompanying photographs are based on the original field notes of Professor Spink.
</div>

</div>

<?php include("./shared/footer.php"); ?>

</body>
</html>