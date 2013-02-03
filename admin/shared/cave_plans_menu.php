<?php
  $use_menu=1;
  if ($use_menu==1) {
      // Cave dropdown
         echo '<span class="cave_menu">';
         echo '<i>Plan: </i>';
         echo '<select name="plan_ID">';
         echo '<option value="">ALL</option>';
         echo '<option value="1">Cave 1</option>';
         echo '<option value="2">Cave 2</option>';
         echo '<option value="3">Cave 3</option>';
         echo '<option value="4">Cave 4</option>';
         echo '<option value="5">Cave 5</option>';
         echo '<option value="6">Cave 6</option>';
         echo '<option value="7">Cave 7</option>';
         echo '<option value="8">Cave 8</option>';
         echo '<option value="9">Cave 9</option>';
         echo '<option value="10">Cave 10: floor 1</option>';
         echo '<option value="210">Cave 10: floor 2</option>';
         echo '<option value="11">Cave 11: floor 1</option>';
         echo '<option value="211">Cave 11: floor 2</option>';
         echo '<option value="311">Cave 11: floor 3</option>';
         echo '<option value="12">Cave 12: floor 1</option>';
         echo '<option value="212">Cave 12: floor 2</option>';
         echo '<option value="312">Cave 12: floor 3</option>';
         echo '<option value="13">Cave 13</option>';
         echo '<option value="14">Cave 14</option>';
         echo '<option value="15">Cave 15: floor 1</option>';
         echo '<option value="215">Cave 15: floor 2</option>';
         echo '<option value="16">Cave 16: floor 1</option>';
         echo '<option value="216">Cave 16: floor 2</option>';
         echo '<option value="1216">Cave 16: Lankeshwar</option>';
         echo '<option value="2016">Cave 16: Triple story: floor 1</option>';
         echo '<option value="2216">Cave 16: Triple story: floor 2</option>';
         echo '<option value="2316">Cave 16: Triple story: floor 3</option>';
         echo '<option value="2416">Cave 16: Triple story: roof</option>';
         echo '<option value="3016">16 A,B</option>';
         echo '<option value="4016">16 satellite</option>';
         echo '<option value="17">Cave 17</option>';
         echo '<option value="18">Cave 18</option>';
         echo '<option value="19">Cave 19</option>';
         echo '<option value="20">Cave 20A</option>';
         echo '<option value="120">Cave 20B</option>';
         echo '<option value="21">Cave 21</option>';
         echo '<option value="22">Cave 22</option>';
         #echo '<option value="122">Cave 22A</option>';
         echo '<option value="23">Cave 23</option>';
         echo '<option value="24">Cave 24</option>';
         echo '<option value="124">Cave 24A shrine 1</option>';
         echo '<option value="224">Cave 24A shrine 2</option>';
         echo '<option value="25">Cave 25</option>';
         #echo '<option value="125">Cave 25A</option>';
         echo '<option value="26">Cave 26</option>';
         echo '<option value="27">Cave 27</option>';
         echo '<option value="28">Cave 28</option>';
         echo '<option value="29">Cave 29</option>';
         echo '<option value="30">Cave 30</option>';
         echo '<option value="130">Cave 30A</option>';
         echo '<option value="31">Cave 31</option>';
         echo '<option value="32">Cave 32: floor 1</option>';
         echo '<option value="232">Cave 32: floor 2</option>';
         echo '<option value="132">Cave 32 Yadavas</option>';
         echo '<option value="33">Cave 33: floor 1</option>';
         echo '<option value="233">Cave 33: floor 2</option>';
         echo '<option value="34">Cave 34</option>';
         echo '<option value="10001">Ganeshleni: 1-5</option>';  
         echo '<option value="10006">Ganeshleni: 6-7</option>';  
         echo '<option value="10008">Ganeshleni: 8-12</option>';  
         echo '<option value="10013">Ganeshleni: 13-16</option>';  
         echo '<option value="10017">Ganeshleni: 17-19</option>';  
         echo '<option value="20001">Jogeshwari: 1-2</option>';
         echo '<option value="20003">Jogeshwari: 3-4</option>';
         echo '<option value="100">Misc</option>';
         echo '</span>';
         echo '</select>';

  } else {

    echo '<select name="cave_ID">';

    $sql = "SELECT * FROM caves ORDER BY ID";
    $result = mysql_query($sql) or die (mysql_error());
    if ($result) {
    // Loop through search results      
       while($row = mysql_fetch_object($result))
       {
         $cave_ID   = $row->cave_ID;
         $cave_name = $row->cave_name;       
         echo '   <option value="'.$cave_name.'">'.$cave_name.'</option>';
       }
    }
    echo '</select>';
  }
?>
