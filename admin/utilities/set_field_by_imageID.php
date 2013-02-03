<?php

// Set a given field to a given value for a range of image IDs.

    require_once('../../../db/elloracaves_db.php');

    $ID_start = '6469';
    $ID_stop  = '6557';
    $field    = 'image_plan_ID';
    $value    = //'232';

    for ( $counter = $ID_start; $counter <= $ID_stop; $counter += 1) {

       $query1  = "SELECT * FROM images WHERE image_ID = ".$counter;
       $result1 = mysql_query($query1,$dbh);

       if ($result1) {
   
          while ($row = mysql_fetch_array($result1, MYSQL_ASSOC)) {

                $query2  = "UPDATE images SET ";
                $query2 .= $field." = '".trim(mysql_real_escape_string(stripslashes($value)))."' ";
                $query2 .= " WHERE image_ID=".$counter;

                echo $query2 . '<br>';
                $result2 = mysql_query( $query2, $dbh );
                echo "<result>" . ( $result2 ? "success" : "failure" ) . "</result>";
          }
       }
    }

    mysql_close($dbh) or die ("Could not close connection to database!");

?>