<?php

// Compare entries in two tables to see if there are any differences.

require_once('../../../db/elloracaves_db.php');
$table1 = //"imagesOLD";
$table2 = //"images";
$field1 = "image_description";
$field2 = "image_description";

// Log into MySQL server
$query1 = "SELECT ".$table1.".".$field1.", ".$table2.".".$field2.", ".$table1.".image_ID, ".$table2.".image_ID";
$query1.= " FROM ".$table1.", ".$table2;
$query1.= " WHERE ".$table1.".image_ID = ".$table2.".image_ID";
$query1.= ' AND '.$table1.'.'.$field1.' != '.$table2.'.'.$field2;
$query1.= " ORDER BY ".$table1.".image_ID";
echo $query1 . '<br /><br />';
$result1 = mysql_query($query1, $dbh);
if ($result1) {

    $count = 0;
    while ($row = mysql_fetch_array($result1, MYSQL_ASSOC)) {

        $count = $count + 1;
		echo 'Row '.$count.':<br />';
		echo $row['image_description'].'<br /><br />';
/*		
        $ID = $row[image_ID];
        $entry1 = $row[$field1];

        $query2  = "UPDATE ".$table2." SET ";
        $query2 .= $field2.' = "'.$entry1.'"';
        $query2 .= " WHERE image_ID = ".$ID;
        echo $query2 . '<br />';
*/        
        //$result2 = mysql_query( $query2, $dbh );
        //echo "<result>" . ( $result2 ? "success" : "failure" ) . "</result>";
    } 
} 

if ($count == 0) {
        echo 'No difference between '.$table1.'.'.$field1.' and '.$table2.'.'.$field2.'.';
}

mysql_close($dbh) or die ("Could not close connection to database!");

?>
