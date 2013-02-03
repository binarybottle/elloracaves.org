<?php

// Set all entries resulting from a search to a given value.
// Ex: Set all image_plan_ID's with "Saptamatrika" in its description
//     to '2016' if image_cave_ID = '16' (optional):
// require_once('../../../db/elloracaves_db.php');
// $searchstring = 'Saptamatrika';
// $field = 'image_plan_ID';
// $value  = '2016';
// $optional_field = 'image_cave_ID';
// $optional_value = '16';

require_once('../../../db/elloracaves_db.php');
$searchstring = 'Saptamatrika';
$field = 'image_plan_ID';
$value  = //'2016';
$optional_field = 'image_cave_ID';
$optional_value = '16';

$bool = ' IN BOOLEAN MODE ';
$sql = "SELECT image_ID, image_master_ID, image_cave_ID, image_file, image_rank, image_plan_ID,
         image_date, image_description, image_subject, image_motifs, image_medium,
         image_notes, image_plan_x, image_plan_y,
        MATCH(image_description, image_subject, image_motifs, image_medium, image_notes)
        AGAINST ('$searchstring'" . $bool . ") AS score FROM images
        WHERE MATCH(image_description, image_subject, image_motifs, image_medium, image_notes)
        AGAINST ('$searchstring'" . $bool . ")";

$result = mysql_query($sql) or die (mysql_error());
while($row = mysql_fetch_array($result)){

    $sql2  = "UPDATE images SET ";
    $sql2 .= $field."=".trim(mysql_real_escape_string(stripslashes($value)));
    $sql2 .= " WHERE image_ID=".$row['image_ID'];
    if ($optional_field != '') {
        $sql2 .= " AND ".$optional_field." = '".$optional_value."' ";
    }
    echo $sql2 . '<br>';
    $result2 = mysql_query( $sql2, $dbh );
    echo "<result>" . ( $result2 ? "success" : "failure" ) . "</result>";

}

mysql_close($dbh) or die ("Could not close connection to database!");

?>