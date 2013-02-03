<?php
// Enter image filenames and data into the images table of the database.

require_once('../../../db/elloracaves_db.php');
$ID_start = //5426;
$ID_stop  = //5426;
$prepend  = 'ELO';
$append   = '.JPG';
$cave_ID  = 100;
$plan_ID  = 0;
$date = '12/16/2012';

// Find largest image_ID
$query = "SELECT * FROM images";
$result = mysql_query( $query, $dbh );
$max_ID = 0;
if ($result) {
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		if ($row['image_ID'] > $max_ID) {
			$max_ID = $row['image_ID'];
		}
	}
}
echo "<result>" . ( $result ? "The maximum image_ID is ".$max_ID."<br />" : "failure" )
."</result>";

for ($ID = $ID_start; $ID <= $ID_stop; $ID += 1) {
	$ID_string = $ID;
	if ($ID<10) {
		$ID_string = '000'.$ID;
	}
	else {
		if ($ID<100) {
			$ID_string = '00'.$ID;
		}
		else {
			if ($ID<1000) {
				$ID_string = '0'.$ID;
			}
		}
	}

	$max_ID = $max_ID + 1;
	$image_file = $prepend.$ID_string.$append;
	$query2  = "INSERT INTO images (image_ID, image_master_ID,
		image_cave_ID, image_plan_ID, image_medium, image_file,
		image_date, image_rank, image_rotate, image_plan_x, image_plan_y) 
		VALUES ($max_ID, $max_ID, $cave_ID, $plan_ID, 'rock-cut',
		'".$image_file."', '".$date."', 1, 0, -1, -1)";

	$result2 = mysql_query( $query2, $dbh );
	echo "<result>" . ( $result2 ? "Success: " : "Failure: " ) . "</result>";
	echo $query2 . '<br />';
}

mysql_close($dbh) or die ("Could not close connection to database!");

?>
