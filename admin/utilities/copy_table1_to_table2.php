<?php

require_once('../../../db/elloracaves_db.php');
$table_source = //"imagesALT";
$table_target = //"images";
$filter_field = "image_cave_ID";
$filter_value = "10";

// Loop through rows of target table
$sql = "SELECT * FROM ".$table_source.
       " WHERE ".$filter_field."=".$filter_value.
       " ORDER BY image_ID";
echo $sql.'<br /><br />';
$result = mysql_query($sql, $dbh);
if ($result) {
	while($row = mysql_fetch_array($result)) {

		$image_ID =           $row['image_ID'];
                /*
		$image_master_ID =    $row['image_master_ID'];
		$image_cave_ID =      $row['image_cave_ID'];
		$image_plan_ID =      $row['image_plan_ID'];
		$image_medium =       $row['image_medium'];
		$image_subject =      $row['image_subject'];
		$image_motifs =       $row['image_motifs'];
		$image_description =  $row['image_description'];
		$image_file =         $row['image_file'];
		$image_date =         $row['image_date'];
		$image_notes =        $row['image_notes'];
		$image_rank =         $row['image_rank'];
		$image_rotate =       $row['image_rotate'];
		$image_plan_x =       $row['image_plan_x'];
		$image_plan_y =       $row['image_plan_y'];
                */

		// Find corresponding row in source table
		$sql2 = "SELECT * FROM ".$table_source.
		        " WHERE image_ID=".$image_ID;
		echo $sql2.'<br /><br />';
		$result2 = mysql_query($sql2, $dbh);
		if ($result2) {
			$row2 = mysql_fetch_array($result2);

			// Update target table
			$query2  = "UPDATE ".$table_target." SET ";
			$query2 .= " image_master_ID='".trim(mysql_real_escape_string(stripslashes($row2['image_master_ID'])))."', ";
			$query2 .= " image_cave_ID='".trim(mysql_real_escape_string(stripslashes($row2['image_cave_ID'])))."', ";
			$query2 .= " image_plan_ID='".trim(mysql_real_escape_string(stripslashes($row2['image_plan_ID'])))."', ";
			$query2 .= " image_medium='".trim(mysql_real_escape_string(stripslashes($row2['image_medium'])))."', ";
			$query2 .= " image_subject='".trim(mysql_real_escape_string(stripslashes($row2['image_subject'])))."', ";
			$query2 .= " image_motifs='".trim(mysql_real_escape_string(stripslashes($row2['image_motifs'])))."', ";
			$query2 .= " image_description='".trim(mysql_real_escape_string(stripslashes($row2['image_description'])))."', ";
			$query2 .= " image_file='".trim(mysql_real_escape_string(stripslashes($row2['image_file'])))."', ";
			$query2 .= " image_date='".trim(mysql_real_escape_string(stripslashes($row2['image_date'])))."', ";
			$query2 .= " image_notes='".trim(mysql_real_escape_string(stripslashes($row2['image_notes'])))."', ";
			$query2 .= " image_rank='".trim(mysql_real_escape_string(stripslashes($row2['image_rank'])))."', ";
			$query2 .= " image_rotate='".trim(mysql_real_escape_string(stripslashes($row2['image_rotate'])))."', ";
			$query2 .= " image_plan_x='".trim(mysql_real_escape_string(stripslashes($row2['image_plan_x'])))."', ";
			$query2 .= " image_plan_y='".trim(mysql_real_escape_string(stripslashes($row2['image_plan_y'])))."' ";
			$query2 .= " WHERE image_ID = ".$image_ID;
			echo $query2 . '<br />';
			$result2 = mysql_query( $query2, $dbh );
			echo "<result>" . ( $result2 ? "success" : "failure" ) . "</result><br /><br />";
		}
	}
}

mysql_close($dbh) or die ("Could not close connection to database!");

?>
