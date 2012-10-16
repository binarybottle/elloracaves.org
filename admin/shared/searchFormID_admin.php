<?php

function searchFormID_admin()
{
  // Re-usable form

  echo '<form method="get" action="'.$_SERVER['PHP_SELF'].'">';
  echo '<input type="hidden" name="cmd" value="search" />';

  $range_start = (isset($_GET['start']) ? htmlspecialchars(stripslashes($_REQUEST['start'])) : '');

  echo '<br /><br />';
  echo 'ID: <input type="text" size="6" name="start" value="'.$range_start.'" /> ';

  echo '<br /><br />';

  echo '<input type="submit" value="Search" />';
  echo '</form> <br />';

}

?>
