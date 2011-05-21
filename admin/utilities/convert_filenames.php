<?php

 // Log into MySQL server
    require_once('../../../db/elloracaves_db.php');
    $query1  = "SELECT * FROM images ORDER BY ID";
    $result1 = mysql_query($query1,$dbh);
    $pk      = 1;

    if ($result1) {
   
       while ($row = mysql_fetch_array($result1, MYSQL_ASSOC)) {

                $string = $row['image_file'];
                $pattern = '/.*\//i';
                $replacement = '${1}';

                $string1 = preg_replace($pattern, $replacement, $string);

                $query2  = "UPDATE images SET ";
                $query2 .= "image_file = '"       . $string1 . "' ";


                $query2 .= " WHERE ID = '"  . $pk       . "' ";
                echo $query2 . '<br>';
                $result2 = mysql_query( $query2, $dbh );
                echo "<result>" . ( $result2 ? "success" : "failure" ) . "</result>";

                $pk = $pk + 1;
       }
    }

    mysql_close($dbh) or die ("Could not close connection to database!");

?>