<?php
    // Cave dropdown
    echo '<span class="cave_menu">';
    echo '<i>Cave: </i>';
    echo '<select name="cave_ID">';                      

    $sql = "SELECT * FROM caves ORDER BY cave_ID";
    $result = mysql_query($sql) or die (mysql_error());
    if ($result) {
    // Loop through search results      
       while($row = mysql_fetch_object($result))
       {
         $cave_ID   = $row->cave_ID;
         $cave_name = $row->cave_name;       
         echo '   <option value="'.$cave_ID.'">'.$cave_name.'</option>';
       }
    }
    echo '</select>';
?>
