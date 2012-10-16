<?php

 // Log into MySQL server
    require_once('../../../db/elloracaves_db.php');

    $filepath = 'DSCN';
    $cave_ID = '102';
    $ID1 = ;
    $ID2 = ;

    for ( $counter = $ID1; $counter <= $ID2; $counter += 1) {

        $query2  = "UPDATE images SET ";
        $query2 .= "image_cave_ID = '".$cave_ID."' ";

        if ($counter<1000) {
          $query2 .= " WHERE image_file='$filepath"."0"."$counter.jpg'";
        }
        else {
          $query2 .= " WHERE image_file='$filepath$counter.jpg'";
        }

        echo $query2 . '<br>';
        $result2 = mysql_query( $query2, $dbh );
        echo "<result>" . ( $result2 ? "success" : "failure" ) . "</result>";

    }

    mysql_close($dbh) or die ("Could not close connection to database!");

?>