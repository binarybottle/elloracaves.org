<?php

// Replace all field entries  with a given value ($replace_value)
// if a reference field has a given value ($reference_value).
// Ex: Set image_plan_ID to 102 wherever image_cave_ID is 102:
// $table = "images";
// $reference_field = "image_cave_ID";
// $reference_value = "102";
// $replace_field = "image_plan_ID";
// $replace_value = "102";

$table = "images";
$reference_field = "image_cave_ID";
$reference_value = //"102";
$replace_field = "image_plan_ID";
$replace_value = //"102";

 // Log into MySQL server
require_once('../../../db/elloracaves_db.php');

$query  = "UPDATE ".$table." SET ";
$query .= $replace_field." = '".trim(mysql_real_escape_string(stripslashes($replace_value)))."' ";
$query .= " WHERE ".$reference_field." = '".$reference_value."' ";
echo $query . '<br>';
$result = mysql_query( $query, $dbh );
echo "<result>" . ( $result ? "success" : "failure" ) . "</result>";

mysql_close($dbh) or die ("Could not close connection to database!");

?>