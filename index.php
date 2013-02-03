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

<br />
Dr. Deepanjana Klein of Christie's, Professor Walter Spink of the University of Michigan,

<br/>
and Arno Klein
bring you the first comprehensive documentation
of the Ellora cave temples.
<br />
In December 2012,
we geolocated over 7,000 of our annotated photographs on temple floor plans.
<br />
<br />

<h2 style="position:absolute; left:225px;"><a href="./caves.php">ENTER THE CAVES</a></h2>
<br />
<span style="position:relative; left:226px; top:30px;">
<i>-Internet Explorer is not supported-</i>
</span>

<div style="position:absolute; top:740px; left:0px;">
<br />
Photographs and website design: <a href="http://binarybottle.com" onClick="return popup(this,'binarybottle')">Arno Klein</a>
<br />
Descriptions accompanying photographs are based on the original field notes of Professor Spink.
<br />
This project has received funding from <a href="http://www.artstor.org/news/n-html/an-081204-ellora.shtml" 
   onClick="return popup(this,'Announcement')">
ArtStor</a> and the Indian government. 
<br />
<br />
</div>

</div>

<?php include("./shared/footer.php"); ?>

</body>
</html>