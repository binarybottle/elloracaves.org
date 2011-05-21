<?php 
include("../../../db/elloracaves_db.php");

$image_ID = $_GET['image_ID'];
$X = $_GET['X'];
$Y = $_GET['Y'];

/*
$sql = "UPDATE images SET ";
$sql.= "image_plan_x='".$X[0]."',";
$sql.= "image_plan_y='".$Y[0]."',";
$sql.= "image_plan_x2='".$X[1]."',";
$sql.= "image_plan_y2='".$Y[1]."' ";
$sql.= "WHERE image_ID ='".$image_ID."'";
*/

$X = implode (',', $X);
$Y = implode (',', $Y);

$sql = "UPDATE images SET ";
$sql.= "image_plan_x='".$X."',";
$sql.= "image_plan_y='".$Y."' ";
$sql.= "WHERE image_ID ='".$image_ID."'";

mysql_query("$sql") or die(mysql_error());  

?>
