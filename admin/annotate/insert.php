<?php
include("../../db/elloracaves_db.php");

$num_rows=$_POST[num_rows];

            $i2=0;
            while($i2 < $num_rows) {

              $i2=$i2+1;

              $sql2  = 'UPDATE images SET ';
              $sql2 .= 'image_cave_ID="'     .trim(mysql_real_escape_string(stripslashes($_POST[update_image_cave_ID.$i2]))).'", ';
              $sql2 .= 'image_medium="'      .trim(mysql_real_escape_string(stripslashes($_POST[update_image_medium.$i2]))).'", ';
              $sql2 .= 'image_subject="'     .trim(mysql_real_escape_string(stripslashes($_POST[update_image_subject.$i2]))).'", ';
              $sql2 .= 'image_motifs="'      .trim(mysql_real_escape_string(stripslashes($_POST[update_image_motifs.$i2]))).'", ';
              $sql2 .= 'image_description="' .trim(mysql_real_escape_string(stripslashes($_POST[update_image_description.$i2]))).'", ';
              $sql2 .= 'image_date="'  .trim(mysql_real_escape_string(stripslashes($_POST[update_image_date.$i2]))).'", ';
              $sql2 .= 'image_light="' .trim(mysql_real_escape_string(stripslashes($_POST[update_image_light.$i2]))).'", ';
              $sql2 .= 'image_rank="'  .trim(mysql_real_escape_string(stripslashes($_POST[update_image_rank.$i2]))).'", ';
              $sql2 .= 'image_rotate="'.trim(mysql_real_escape_string(stripslashes($_POST[update_image_rotate.$i2]))).'" ';
              $sql2 .= ' WHERE image_ID="'   .trim(mysql_real_escape_string(stripslashes($_POST[update_image_ID.$i2]))).'" ';
            //$sql2 .= 'image_file="'  .trim(mysql_real_escape_string(stripslashes($_POST[update_image_file.$i2]))).'", ';
            //$sql2 .= 'image_notes="' .trim(mysql_real_escape_string(stripslashes($_POST[update_image_notes.$i2]))).'", ';

              $result2 = mysql_query($sql2) or die (mysql_error());           

           }  //while($i2 < $num_rows) {
//echo $sql2;

if ($num_rows<2) {
   echo '<br /><br />'.$num_rows.' entry updated. Please hit the back button and keep working...';
}
else {
   echo '<br /><br />'.$num_rows.' entries updated. Please hit the back button and keep working...';
}

?>