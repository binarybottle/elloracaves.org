<?php

#$table1 = "images_20090923";
#$table1 = "images_20100531";
#$table1 = "images_20110405";
#$table1 = "images_20110404";
#$table1 = "images_20110101";
$table2 = "images";
$field1 = "description";
$field2 = "image_description";

// Log into MySQL server
require_once('../../../db/elloracaves_db.php');
$query1 = "SELECT ".$table1.".".$field1.", ".$table2.".".$field2.", ".$table1.".image_ID";
$query1.= " FROM ".$table1.", ".$table2;
$query1.= " WHERE ".$table1.".image_ID = ".$table2.".image_ID";
$query1.= ' AND '.$table1.'.'.$field1.' != ""';
$query1.= ' AND '.$table2.'.'.$field2.' = ""';
$query1.= " ORDER BY ".$table1.".image_ID";
echo $query1 . '<br /><br />';
$result1 = mysql_query($query1,$dbh);
if ($result1) {
    while ($row = mysql_fetch_array($result1, MYSQL_ASSOC)) {

        $ID = $row[image_ID];
        $entry1 = $row[$field1];

        $query2  = "UPDATE ".$table2." SET ";
        $query2 .= $field2.' = "'.$entry1.'"';
        $query2 .= " WHERE image_ID = ".$ID;
        echo $query2 . '<br />';
        
        //$result2 = mysql_query( $query2, $dbh );
        //echo "<result>" . ( $result2 ? "success" : "failure" ) . "</result>";
    }
}

mysql_close($dbh) or die ("Could not close connection to database!");

?>
