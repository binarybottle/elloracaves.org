<?php

// Modify all entries for field.
// Ex: Set image_master_ID entries to those of image_ID:
// $table = "images";
// $field_source = "image_ID";
// $field_target = "image_master_ID";
// $ID_name = "image_ID";

$table = "images";
$field_modify = "image_file";
$field_sort = "image_ID";
$ID_start = 5817;
$ID_stop  = 6712;
$prepend  = '_';
$append   = '';

// Log into MySQL server
require_once('../../../db/elloracaves_db.php');
$query1  = "SELECT * FROM ".$table. " ORDER BY ". $field_sort;
$result1 = mysql_query($query1,$dbh);
if ($result1) {
	while ($row = mysql_fetch_array($result1, MYSQL_ASSOC)) {
		$ID = $row[$field_sort];
		if ($ID >= $ID_start && $ID <= $ID_stop) {
			$value = $row[$field_modify];
			
			$query2  = "UPDATE ".$table." SET ";
			$query2 .= $field_modify." = '".trim(mysql_real_escape_string(stripslashes($prepend.$value.$append)))."' ";
			$query2 .= " WHERE ".$field_sort." = ".$ID;
			
			echo $query2 . '<br>';
			$result2 = mysql_query( $query2, $dbh );
			echo "<result>" . ( $result2 ? "success" : "failure" ) . "</result>";
		}
	}
}

mysql_close($dbh) or die ("Could not close connection to database!");

?>
