<?php

 // Log into MySQL server
    require_once('../../../db/elloracaves_db.php');

    $ID1 = 4610;
    $ID2 = 5217;
    $image_cave_ID = '16';

    for ( $counter = $ID1; $counter <= $ID2; $counter += 1) {

       $query1  = "SELECT * FROM images WHERE image_ID = ".$counter;
       $result1 = mysql_query($query1,$dbh);

       if ($result1) {
   
          while ($row = mysql_fetch_array($result1, MYSQL_ASSOC)) {

                $query2  = "UPDATE images SET ";
                $query2 .= "image_cave_ID = '".$image_cave_ID."', ";
                $query2 .= "image_medium = 'rock-cut' ";
                $query2 .= " WHERE image_ID=".$counter;

                echo $query2 . '<br>';
                $result2 = mysql_query( $query2, $dbh );
                echo "<result>" . ( $result2 ? "success" : "failure" ) . "</result>";
          }
       }
    }

    mysql_close($dbh) or die ("Could not close connection to database!");

?>