<?php

// Replace all target field entries that have a given value 
// ($replace_value) with the value in a given source field.
// Ex: Copy the values from image_ID to image_master_ID
//     if the image_master_ID = 0: 
// $table = "images";
// $source_field = "image_ID";
// $target_field = "image_master_ID";
// $replace_value = "0";

$table = "images";
$source_field = "image_ID";
$target_field = "image_master_ID";
$replace_value = //"0";

// Log into MySQL server
require_once('../../../db/elloracaves_db.php');

$sql = "SELECT image_ID, image_master_ID, image_cave_ID, image_file, image_rank, image_plan_ID,
               image_date, image_description, image_subject, image_motifs, image_medium,
               image_notes, image_plan_x, image_plan_y
        FROM ".$table.
        " WHERE ".$target_field." = ".$replace_value;

echo $sql . '<br><br>';
$result = mysql_query($sql) or die (mysql_error());
while($row = mysql_fetch_array($result)){

        $sql2  = "UPDATE ".$table." SET ";
        $sql2 .= $target_field."=".trim(mysql_real_escape_string(stripslashes($row[$source_field])));
        $sql2 .= " WHERE ".$target_field." = ".$replace_value;
        $sql2 .= " AND ".$source_field." = ".$row['image_ID'];

        echo $sql2 . '<br>';
        $result2 = mysql_query( $sql2, $dbh );
        echo "<result>" . ( $result2 ? "success" : "failure" ) . "</result>";
}

mysql_close($dbh) or die ("Could not close connection to database!");

?>