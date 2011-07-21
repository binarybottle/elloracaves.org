<?php
include("../../../db/elloracaves_db.php");

$num_rows=$_POST[num_rows];

$i2=0;
while($i2 < $num_rows) {

    $i2=$i2+1;

    $image_cave_ID = trim(mysql_real_escape_string(stripslashes($_POST[update_image_cave_ID.$i2])));
    $plan_floor = trim(mysql_real_escape_string(stripslashes($_POST[update_floor.$i2])));

    $sql2  = 'UPDATE images SET ';
    $sql2 .= 'image_cave_ID="'     .$image_cave_ID.'", ';

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

    $sql2 .= 'image_medium="'      .trim(mysql_real_escape_string(stripslashes($_POST[update_image_medium.$i2]))).'", ';
    $sql2 .= 'image_subject="'     .trim(mysql_real_escape_string(stripslashes($_POST[update_image_subject.$i2]))).'", ';
    $sql2 .= 'image_motifs="'      .trim(mysql_real_escape_string(stripslashes($_POST[update_image_motifs.$i2]))).'", ';
    $sql2 .= 'image_description="' .trim(mysql_real_escape_string(stripslashes($_POST[update_image_description.$i2]))).'", ';
    $sql2 .= 'image_date="'  .trim(mysql_real_escape_string(stripslashes($_POST[update_image_date.$i2]))).'", ';
    $sql2 .= 'image_rank="'  .trim(mysql_real_escape_string(stripslashes($_POST[update_image_rank.$i2]))).'", ';
    $sql2 .= 'image_rotate="'.trim(mysql_real_escape_string(stripslashes($_POST[update_image_rotate.$i2]))).'", ';
    $sql2 .= 'image_master_ID="'.trim(mysql_real_escape_string(stripslashes($_POST[update_master_ID.$i2]))).'", ';
    $sql2 .= 'image_plan_x="'.trim(mysql_real_escape_string(stripslashes($_POST[update_x.$i2]))).'", ';
    $sql2 .= 'image_plan_y="'.trim(mysql_real_escape_string(stripslashes($_POST[update_y.$i2]))).'" ';
    $sql2 .= ' WHERE image_ID="'   .trim(mysql_real_escape_string(stripslashes($_POST[update_image_ID.$i2]))).'" ';
    //$sql2 .= 'image_file="'  .trim(mysql_real_escape_string(stripslashes($_POST[update_image_file.$i2]))).'", ';
    //$sql2 .= 'image_notes="' .trim(mysql_real_escape_string(stripslashes($_POST[update_image_notes.$i2]))).'", ';

    $result2 = mysql_query($sql2) or die (mysql_error());           
}

if ($num_rows<2) {
   echo '<br /><br />'.$num_rows.' entry updated. Please hit the back button and keep working...';
}
else {
   echo '<br /><br />'.$num_rows.' entries updated. Please hit the back button and keep working...';
}

?>