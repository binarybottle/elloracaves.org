<?php
include("../../../db/elloracaves_db.php");

// Image repository
   $image_repository = "http://media.elloracaves.org/images/caves_360px/";
	
// Search form
   include_once("../shared/searchForm.php");

// Create the navigation switch
   $cmd = (isset($_GET['cmd']) ? $_GET['cmd'] : '');

   switch($cmd)
   {
      default:
      searchForm();
  
      break;
    
      case "search":
        searchForm();
    
        $searchstring = mysql_escape_string($_GET['words']);
        $searchcave   = mysql_escape_string($_GET['cave_name']);

        switch($_GET['mode'])
        {
             case "normal":
               $bool = '';
               break;
             case "boolean":
               $bool = ' IN BOOLEAN MODE ';
               break;
        }

        if (strlen(trim($searchstring))==0 && strlen(trim($searchcave))>0) {
           $sql = "SELECT * FROM images
                     WHERE image_cave_ID = '".$searchcave."'
                     AND image_rank = '1'
                     ORDER BY image_file ASC"; #, score DESC";
        }
        elseif (strlen(trim($searchstring))>0 && strlen(trim($searchcave))>=0) {
           if (strlen(trim($searchcave))>0) {
               $s_string = " AND image_cave_ID = '".$searchcave."' ";
           } else {
               $s_string = " ";
           }
           $sql = "SELECT image_ID, image_master_ID, image_cave_ID, image_medium, image_subject,
                          image_motifs, image_description, image_file, image_date,
                          image_notes, image_rank, image_plan_x, image_plan_y
                   MATCH(image_medium, image_subject, image_motifs, image_description,
                         image_notes)
                   AGAINST ('$searchstring'" . $bool . ") AS score FROM images
                   WHERE MATCH(image_medium, image_subject, image_motifs,
                               image_description, image_notes)
                   AGAINST ('$searchstring'" . $bool . ")
                   AND image_rank = '1' "
                   .$s_string.
                   " ORDER BY image_file ASC, score DESC";
#                   ORDER BY score DESC, image_file ASC";
#                   ORDER BY image_cave_ID DESC, score DESC";
        }
        else {
           echo 'Please enter search terms and/or a cave name. ';
        }

        $result = mysql_query($sql) or die (mysql_error());

        if (mysql_num_rows($result)==1) {
           echo '<span class="font80"><i>Found ' . mysql_num_rows($result) . ' result:  </i></span><br />';
        }
        else {
           echo '<span class="font80"><i>Found ' . mysql_num_rows($result) . ' results: </i></span><br />';
        }

      break;
   }

   if ($result) {

   // Loop through search results
      while($row = mysql_fetch_object($result))
      {
         $image_ID =           $row->image_ID;
         $image_master_ID =    $row->image_master_ID;
         $image_cave_ID =      $row->image_cave_ID;
         $image_subject =      $row->image_subject;
         $image_description =  $row->image_description;
         $image_file =         $row->image_file;
         $image_notes =        $row->image_notes;
         $image_medium =       $row->image_medium;
         $image_motifs =       $row->image_motifs;
         $image_date =         $row->image_date;
         $image_rank =         $row->image_rank;

      // Line
         echo '<hr size="1" />';

      // Anchor
         echo '<a name="'.$image_ID.'"></a>';

      // Image
         echo '<table width="800" border="0" cellspacing="0" cellpadding="10">';
         echo ' <tr>';
         echo '  <td width="240">';
         echo '   <img src="' . $image_repository . $image_file . '" height="240">';
         echo '   <span class="font60" color="gray">'.$image_ID.'</span>';
         echo '  </td>';
         echo '  <td width="560">';

      // Image text
         if (strlen(trim($image_cave_ID))>0) {
            echo 'Cave '.stripslashes(htmlspecialchars(trim($image_cave_ID))).'<br />';
         }   
         if (strlen(trim($image_subject))>0) {
            echo stripslashes(htmlspecialchars(trim($image_subject))).'<br />';
         }   
         if (strlen(trim($image_description))>0) {
            echo '<br />'.stripslashes(htmlspecialchars(trim($image_description))).'<br />';
         }
         /*
         if (strlen(trim($image_medium))>0) {
           echo stripslashes(htmlspecialchars(trim($image_medium))).'<br />';
         }
         if (strlen(trim($image_motifs))>0) {
           echo stripslashes(htmlspecialchars(trim($image_motifs))).'<br />';
         }   
         if (strlen(trim($image_notes))>0) {
           echo '<br />Image: '.stripslashes(htmlspecialchars(trim($image_notes))).'<br />';
         }
         */

         echo '   </td>';
         echo '  </tr>';
         echo ' </table>';

      }
   }

?>