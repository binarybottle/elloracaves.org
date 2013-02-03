<?php

// Replace all field entries that have a given value 
// ($search) with a given value ($replace).
// Ex: Set image_plan_y to -1 wherever it is 0:
// $table = "images";
// $field = "image_plan_y";
// $search = "0";
// $replace = "-1";

$table = "images";
$field = "image_plan_ID";
$search = //"5016";
$replace = //"2016";

 // Log into MySQL server
require_once('../../../db/elloracaves_db.php');

$query  = "UPDATE ".$table." SET ";
$query .= $field." = '".trim(mysql_real_escape_string(stripslashes($replace)))."' ";
$query .= " WHERE ".$field." = '".$search."' ";
echo $query . '<br>';
$result = mysql_query( $query, $dbh );
echo "<result>" . ( $result ? "success" : "failure" ) . "</result>";

mysql_close($dbh) or die ("Could not close connection to database!");

?>