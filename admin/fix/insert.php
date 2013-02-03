<?php
include("../../../db/elloracaves_db.php");

$image_cave_ID = trim(mysql_real_escape_string(stripslashes($_POST[update_image_cave_ID])));
$plan_floor = trim(mysql_real_escape_string(stripslashes($_POST[update_floor])));

$sql2  = 'UPDATE images SET ';
$sql2 .= 'image_cave_ID="' .$image_cave_ID.'", ';

if ($plan_floor) {
    $sql3 = "SELECT plan_ID FROM plans ";
    $sql3.= "WHERE plan_cave_ID = '".$image_cave_ID."' AND plan_floor = '".$plan_floor."'";
    $result3 = mysql_query($sql3) or die (mysql_error());
    if ($result3) {
        $row3 = mysql_fetch_row($result3);
        $image_plan_ID = $row3[0];
        if ($image_plan_ID) {
            $sql2 .= 'image_plan_ID="' .$image_plan_ID.'", ';
        }
    }
}

$sql2 .= 'image_master_ID="'   .trim(mysql_real_escape_string(stripslashes($_POST[update_image_master_ID]))).'", ';
$sql2 .= 'image_medium="'      .trim(mysql_real_escape_string(stripslashes($_POST[update_image_medium]))).'", ';
$sql2 .= 'image_subject="'     .trim(mysql_real_escape_string(stripslashes($_POST[update_image_subject]))).'", ';
$sql2 .= 'image_motifs="'      .trim(mysql_real_escape_string(stripslashes($_POST[update_image_motifs]))).'", ';
$sql2 .= 'image_description="' .trim(mysql_real_escape_string(stripslashes($_POST[update_image_description]))).'", ';
//$sql2 .= 'image_file="'  .trim(mysql_real_escape_string(stripslashes($_POST[update_image_file]))).'", ';
$sql2 .= 'image_date="'  .trim(mysql_real_escape_string(stripslashes($_POST[update_image_date]))).'", ';
$sql2 .= 'image_notes="' .trim(mysql_real_escape_string(stripslashes($_POST[update_image_notes]))).'", ';
$sql2 .= 'image_rank="'  .trim(mysql_real_escape_string(stripslashes($_POST[update_image_rank]))).'", ';
$sql2 .= 'image_rotate="'.trim(mysql_real_escape_string(stripslashes($_POST[update_image_rotate]))).'", ';
$sql2 .= 'image_plan_x="'.trim(mysql_real_escape_string(stripslashes($_POST[update_image_plan_x]))).'", ';
$sql2 .= 'image_plan_y="'.trim(mysql_real_escape_string(stripslashes($_POST[update_image_plan_y]))).'" ';
$sql2 .= ' WHERE image_ID="'   .trim(mysql_real_escape_string(stripslashes($_POST[update_image_ID]))).'" ';

$result2 = mysql_query($sql2) or die (mysql_error());

echo '<br /><br />Entry updated. Please hit the back button and keep working...';

echo '<br /><br />SQL command: <br />'.$sql2;

?>