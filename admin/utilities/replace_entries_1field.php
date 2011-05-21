<?php

$table = "images";
$field = "image_plan_y";
$search = "0";
$replace = "-1";

 // Log into MySQL server
require_once('../../../db/elloracaves_db.php');

$query  = "UPDATE ".$table." SET ";
$query .= $field." = '".$replace."' ";
$query .= " WHERE ".$field." = '".$search."' ";
echo $query . '<br>';
$result = mysql_query( $query, $dbh );
echo "<result>" . ( $result ? "success" : "failure" ) . "</result>";

mysql_close($dbh) or die ("Could not close connection to database!");

?>