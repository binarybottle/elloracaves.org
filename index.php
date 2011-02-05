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

<div class="text_block">

<b>About this site:</b>
<br /><br />
Dr. Deepanjana Klein of Christie's, Professor Emeritus Walter Spink of the University of Michigan, <br />
and Arno Klein of Columbia University have brought to you the first comprehensive documentation<br />
of the Ellora cave temples.  Scholars and students are welcome to use this online resource, <br />
which will be incorporated in a book.  It was 
<a href="http://www.artstor.org/news/n-html/an-081204-ellora.shtml" onClick="return popup(this,'Announcement')">announced</a> 
in December, 2008, by our sponsor 
<a href="http://www.artstor.org" onClick="return popup(this,'ArtStor')">ArtStor</a>.
<br />
<br />
Photographs and website design: <a href="http://www.binarybottle.com" onClick="return popup(this,'binarybottle')">Arno Klein</a><br />
Descriptions accompanying photographs are based on the original field notes of Professor Spink.
<br /><br />
<h2 style="position:absolute; left:225px;"><a href="./trove.php">ENTER THE CAVES</a></h2>

<img align="center" src="./images/decor/home_c5_H7.jpg" width="830px" />

</div>

<?php include("./shared/footer.php"); ?>

</body>
</html>