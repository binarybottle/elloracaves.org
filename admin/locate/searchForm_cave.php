<?php 
 $cave_name = mysql_escape_string($_POST['cave_name']); 
?>

<div class="searchbox">
 <form method="post" action="<?php echo $PHP_SELF;?>">

  <!--input type="hidden" name="cmd" value="search" /-->
  
<?php
  include('../shared/cave_menu.php');
?>

<input type="submit" value="select cave" name="submit">
</form> 
</div>



