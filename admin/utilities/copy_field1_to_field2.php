<?php

// Copy all entries from field1 to field2.
// Ex: Set image_master_ID entries to those of image_ID:
// $table = "images";
// $field_source = "image_ID";
// $field_target = "image_master_ID";
// $ID_name = "image_ID";

$table = "images";
$field_source = //"image_ID";
$field_target = //"image_master_ID";
$ID_name = "image_ID";

// Log into MySQL server
require_once('../../../db/elloracaves_db.php');
$query1  = "SELECT * FROM ".$table. " ORDER BY ". $ID_name;
$result1 = mysql_query($query1,$dbh);
if ($result1) {
    while ($row = mysql_fetch_array($result1, MYSQL_ASSOC)) {

        $ID = $row[$ID_name];
        $source_entry = $row[$field_source];

        $query2  = "UPDATE ".$table." SET ";
        $query2 .= $field_target." = '".trim(mysql_real_escape_string(stripslashes($source_entry)))."' ";
        $query2 .= " WHERE ".$ID_name." = ".$ID;

        echo $query2 . '<br>';
        $result2 = mysql_query( $query2, $dbh );
        echo "<result>" . ( $result2 ? "success" : "failure" ) . "</result>";
    }
}

mysql_close($dbh) or die ("Could not close connection to database!");

?>
