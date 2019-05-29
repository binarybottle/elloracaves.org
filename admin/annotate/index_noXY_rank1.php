<?php 
 $image_repository = "http://elloracaves.org/images/caves_360px/";
 include_once("../../../db/elloracaves_db.php");
 include_once("../shared/header_start.php"); 

 $limit_max = 50;
 $limit = "LIMIT 0, ".$limit_max;
 //$limit = "";
 if (strlen($limit) == 0) {
   $limit_max = 1000000;
 }
?>

<script type="text/javascript" src="../shared/popups.js"></script>

</head>
<body>

<title>Annotate Ellora Cave Temple Image Database</title>

<div class="main">

<b>Annotate Ellora cave temple images</b> (Limit: <?php echo $limit_max; ?> at a time)
<br />
<br />

<?php
 
// Search form (words & range)
   include_once("../shared/searchForm_plan_admin.php");

// Create the navigation switch
   $cmd = (isset($_GET['cmd']) ? $_GET['cmd'] : '');

   switch($cmd)
   {
      default:
      searchForm_plan_admin();
  
      break;
    
      case "search":
        searchForm_plan_admin();
    
/*        $searchstring = trim(mysql_real_escape_string(stripslashes($_GET['words'])));
        $searchplan   = trim(mysql_real_escape_string(stripslashes($_GET['plan_ID'])));
        $searchstart  = trim(mysql_real_escape_string(stripslashes($_GET['start'])));
        $searchstop   = trim(mysql_real_escape_string(stripslashes($_GET['stop'])));
*/
        $searchstring = $_GET['words'];
        $searchplan   = $_GET['plan_ID'];
        $searchstart  = $_GET['start'];
        $searchstop   = $_GET['stop'];

        if (strlen(trim($searchstart))==0) {
           $searchstart = 1;
        }
        if (strlen(trim($searchstop))==0) {
            if ($searchstart==1) {
              $searchstop = 99999; #$searchstart;
            } else {
              $searchstop = $searchstart;
            }
        }

        if (strlen(trim($searchstring))+strlen(trim($searchplan))==0) {
           $sql = "SELECT * FROM images
                   WHERE image_ID >= " . (int)$searchstart . 
                   " AND image_ID <= " . (int)$searchstop .
                   " AND image_plan_x = '-1'
                     AND image_plan_y = '-1'
                     AND image_rank = '1'
                     ORDER BY image_ID ASC ".$limit;
        }
        elseif (strlen(trim($searchstring))==0) {
           $sql = "SELECT * FROM images
                     WHERE image_plan_ID = '".$searchplan.
                  "' AND image_ID >= " . (int)$searchstart . 
                   " AND image_ID <= " . (int)$searchstop .
                   " AND image_plan_x = '-1'
                     AND image_plan_y = '-1'
                     AND image_rank = '1'
                     ORDER BY image_ID ASC ".$limit;
        }
        else {
           if (strlen(trim($searchplan))==0) {
             $s_string = " ";
           } else {
             $s_string = " AND image_plan_ID = '".$searchplan."'";
           }
           
           switch($_GET['mode'])
           {
             case "normal":
               $bool = '';
               break;
             case "boolean":
               $bool = ' IN BOOLEAN MODE ';
               break;
           }

           $sql = "SELECT image_ID, image_master_ID, image_cave_ID, image_plan_ID, 
                          image_medium, image_subject,
                          image_motifs, image_description, image_file, image_date,
                          image_notes, image_rank, image_rotate, 
                          image_plan_x, image_plan_y,
                   MATCH(image_medium, image_subject, image_motifs,
                         image_description, image_notes)
                   AGAINST ('$searchstring'" . $bool . ") AS score FROM images
                   WHERE MATCH(image_medium, image_subject, image_motifs,
                               image_description, image_notes)
                   AGAINST ('$searchstring'" . $bool . ")
                   AND image_ID >= " . (int)$searchstart . "
                   AND image_ID <= " . (int)$searchstop . " " . $s_string
                   ." ORDER BY image_ID ASC, score DESC ".$limit;
        }
        $result = mysql_query($sql) or die (mysql_error());

        $num_rows = mysql_num_rows($result);

        if ($num_rows==1) {
           echo '<span class="font80"><i>Found ' . $num_rows . ' result:  </i></span><br />';
        }
        elseif ($num_rows>=$limit_max) {
           echo '<span class="font80"><i>Found at least ' . $num_rows . ' results (ordered by image ID):  </i></span><br />';
        }
        else {
           echo '<span class="font80"><i>Found ' . $num_rows . ' results (ordered by image ID):  </i></span><br />';
        }

      break;
   }  // switch

   if ($result) {

      echo '<form action="./insert.php" method="post">';

   // Loop through search results      
      echo '<input type="hidden" name="num_rows" value="'.$num_rows.'">';
      $i=1;
      while($row = mysql_fetch_object($result))
      {
         $image_ID          = $row->image_ID;
         $image_master_ID   = $row->image_master_ID;
         $image_cave_ID     = $row->image_cave_ID;
         $image_plan_ID     = $row->image_plan_ID;
         $image_medium      = $row->image_medium;
         $image_subject     = $row->image_subject;
         $image_motifs      = $row->image_motifs;
         $image_description = $row->image_description;
         $image_file        = $row->image_file;
         $image_date        = $row->image_date;
         $image_notes       = $row->image_notes;
         $image_rank        = $row->image_rank;
         $image_rotate      = $row->image_rotate;
         $image_plan_x      = $row->image_plan_x;
         $image_plan_y      = $row->image_plan_y;

         $sql_loop = "SELECT plan_floor FROM plans WHERE plan_ID = '".$image_plan_ID."'";
         $result_loop = mysql_query($sql_loop) or die (mysql_error());
         if ($result_loop) {
             $row_loop = mysql_fetch_row($result_loop);
             $plan_floor = $row_loop[0];
         } else {
             $plan_floor = 1;
         }

      // Line
         echo '<hr size="1" />';

      // Anchor
         echo '<a name="'.$image_ID.'"></a>';

      // Image
         echo '<table width="800" border="0" cellspacing="0" cellpadding="5">';
         echo ' <tr>';
         echo '  <td width="240">';
         echo '   <img src="' . $image_repository . $image_file . '" height="240"></a><br />';
         echo '   <span class="font80">ID: '.$image_ID.'&nbsp;&nbsp; file: '.$image_file.'</span>';
         echo '  </td>';
         echo '  <td width="560">';

      // Update form (all fields)
         echo '<div class="font80"><i>';
         echo '<input type="hidden" name="update_image_ID'.$i.'" value="'.$image_ID.'">';
         echo '<input type="hidden" name="update_image_file'.$i.'" value="'.$image_file.'">';
         echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td>';
         echo 'Cave ID (plan '.$image_plan_ID.'):     <br /><input type="text" size="20"  name="update_image_cave_ID'.$i.'"     value="'.$image_cave_ID      .'">';
         echo '</td><td>';

         if ($plan_floor==1) {
            $floor1 = 'checked'; $floor2 = ''; $floor3 = '';
         }
         elseif ($plan_floor==2) {
            $floor2 = 'checked'; $floor1 = ''; $floor3 = '';
         }
         elseif ($plan_floor==3) {
            $floor3 = 'checked'; $floor1 = ''; $floor2 = '';
         }
         echo 'Floor: ';
         echo '&nbsp;&nbsp;&nbsp;&nbsp;';
         echo '1  <input type="radio" name="update_floor'.$i.'" value="1" '.$floor1.'>';
         echo '&nbsp;&nbsp;&nbsp;&nbsp;';
         echo '2  <input type="radio" name="update_floor'.$i.'" value="2" '.$floor2.'>';
         echo '&nbsp;&nbsp;&nbsp;&nbsp;';
         echo '3  <input type="radio" name="update_floor'.$i.'" value="3" '.$floor3.'>';
         echo '</i>';

         echo '</td><td>';
         echo 'Medium:      <br /><input type="text" size="20" name="update_image_medium'.$i.'"     value="'.$image_medium      .'"><br />';
         echo '</td></tr></table>';
         echo 'Subject:     <br /><input type="text" size="65" name="update_image_subject'.$i.'"    value="'.$image_subject     .'"><br />';
         echo 'Motifs:      <br /><input type="text" size="65" name="update_image_motifs'.$i.'"     value="'.$image_motifs      .'"><br />';
         echo 'Description: <br /><textarea cols="75" rows="3" name="update_image_description'.$i.'">'.$image_description.'</textarea><br />';
         echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td>';
         echo 'Notes: <br /><textarea cols="40" rows="1" name="update_image_notes'.$i.'">'.$image_notes.'</textarea><br />';
         //echo 'File:      <br /><input type="text" size="50" name="update_image_file'.$i.'"     value="'.$image_file      .'">';
         echo '</td><td>';
         echo 'Date:      <br /><input type="text" size="20" name="update_image_date'.$i.'"     value="'.$image_date      .'"><br />';
         echo '</td></tr></table>';
         echo 'Image rank:        <input type="text" size="2"  name="update_image_rank'.$i.'"       value="'.$image_rank  .'">';

         if ($image_rotate==0) {
            $rot0 = 'checked'; $rot1 = ''; $rot2 = ''; $rot3 = '';
         }
         elseif ($image_rotate==1) {
            $rot1 = 'checked'; $rot0 = ''; $rot2 = ''; $rot3 = '';
         }
         elseif ($image_rotate==2) {
            $rot2 = 'checked'; $rot1 = ''; $rot0 = ''; $rot3 = '';
         }
         elseif ($image_rotate==3) {
            $rot3 = 'checked'; $rot1 = ''; $rot2 = ''; $rot0 = '';
         }
         echo '&nbsp;&nbsp;&nbsp;&nbsp;';
         echo '&nbsp;&nbsp;&nbsp;&nbsp;';
         echo 'Rotate (# times): ';
         echo '&nbsp;&nbsp;&nbsp;&nbsp;';
         echo '0  <input type="radio" name="update_image_rotate'.$i.'" value="0" '.$rot0.'>';
         echo '&nbsp;&nbsp;&nbsp;&nbsp;';
         echo '1  <input type="radio" name="update_image_rotate'.$i.'" value="1" '.$rot1.'>';
         echo '&nbsp;&nbsp;&nbsp;&nbsp;';
         echo '2  <input type="radio" name="update_image_rotate'.$i.'" value="2" '.$rot2.'>';
         echo '&nbsp;&nbsp;&nbsp;&nbsp;';
         echo '3  <input type="radio" name="update_image_rotate'.$i.'" value="3" '.$rot3.'>';
         echo '<br />Master image ID: <input type="text" size="2"  name="update_image_master_ID'.$i.'"       value="'.$image_master_ID .'">';
         echo '&nbsp;&nbsp; x: <input type="text" size="2"  name="update_image_plan_x'.$i.'"       value="'.$image_plan_x .'">';
         echo '&nbsp;&nbsp; y: <input type="text" size="2"  name="update_image_plan_y'.$i.'"       value="'.$image_plan_y .'">';

         echo '</i>';

         echo '   </div>';
         echo '   </td>';
         echo '  </tr>';
         echo ' </table>';

         $i=$i+1;

      } // while

      echo '<br /><input type="submit" value="Update" />';
      echo '<input type="reset"  value="Reset"  />';
      echo '</form> <br />';

   }          //switch($cmd)

   echo '</div>';
 
?>

