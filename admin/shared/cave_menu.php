<?php
  $use_menu=1;
  if ($use_menu==1) {
      // Cave dropdown
         echo '<span class="cave_menu">';
         echo '<i>Cave: </i>';
         echo '<select name="cave_name">';
         echo '<option value="">ALL</option>';
         echo '<option value="1">1</option>';
         echo '<option value="2">2</option>';
         echo '<option value="3">3</option>';
         echo '<option value="4">4</option>';
         echo '<option value="5">5</option>';
         echo '<option value="6">6</option>';
         echo '<option value="7">7</option>';
         echo '<option value="8">8</option>';
         echo '<option value="9">9</option>';
         echo '<option value="10">10</option>';
         echo '<option value="11">11</option>';
         echo '<option value="12">12</option>';
         echo '<option value="13">13</option>';
         echo '<option value="14">14</option>';
         echo '<option value="15">15</option>';
         echo '<option value="16">16</option>';
         echo '<option value="1016">16: Lankeshwar</option>';
         echo '<option value="2016">16: Triple story</option>';
         echo '<option value="3016">16 A,B</option>';
         echo '<option value="4016">16 satellite</option>';
         echo '<option value="17">17</option>';
         echo '<option value="18">18</option>';
         echo '<option value="19">19</option>';
         echo '<option value="20">20A</option>';
         echo '<option value="120">20B</option>';
         echo '<option value="21">21</option>';
         echo '<option value="22">22</option>';
         #echo '<option value="122">22A</option>';
         echo '<option value="23">23</option>';
         echo '<option value="24">24</option>';
         echo '<option value="124">24A shrine 1</option>';
         echo '<option value="224">24A shrine 2</option>';
         echo '<option value="25">25</option>';
         #echo '<option value="125">25A</option>';
         echo '<option value="26">26</option>';
         echo '<option value="27">27</option>';
         echo '<option value="28">28</option>';
         echo '<option value="29">29</option>';
         echo '<option value="30">30</option>';
         echo '<option value="130">30A</option>';
         echo '<option value="31">31</option>';
         echo '<option value="32">32</option>';
         echo '<option value="132">32 Yadavas</option>';
         echo '<option value="33">33</option>';
         echo '<option value="34">34</option>';
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

    echo '<select name="cave_name">';

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
