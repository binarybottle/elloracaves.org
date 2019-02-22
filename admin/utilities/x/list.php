<?php

 // Log into MySQL server
    require_once('../../../db/elloracaves_db.php');

//    $query1  = "SELECT * FROM images ORDER BY cave_ID";
    $query1  = "SELECT distinct cave_ID FROM images ORDER BY cave_ID";
    $result1 = mysql_query($query1,$dbh);
    $field_past = '';

    if ($result1) {
   
       while ($row = mysql_fetch_array($result1)) { //, MYSQL_ASSOC)) {

//print_r($row);
//print_r($row[0]);
//                $field = $row['cave_ID'];
//                if (strcmp($field,$field_past)==0) {
//                   echo $field . '<br />';
//              }
//                $field_past = $field;
              echo $row[0] . '<br />';
       }
    }

    mysql_close($dbh) or die ("Could not close connection to database!");

?>