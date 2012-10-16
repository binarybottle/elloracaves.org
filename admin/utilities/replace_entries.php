<?php

$table = "images";
$source_field = "image_cave_ID";
$source_value = "102";
$target_field = "image_plan_ID";
$target_value = "102";

 // Log into MySQL server
require_once('../../../db/elloracaves_db.php');

$query  = "UPDATE ".$table." SET ";
$query .= $target_field." = '".$target_value."' ";
$query .= " WHERE ".$source_field." = '".$source_value."' ";
echo $query . '<br>';
$result = mysql_query( $query, $dbh );
echo "<result>" . ( $result ? "success" : "failure" ) . "</result>";

mysql_close($dbh) or die ("Could not close connection to database!");

?>