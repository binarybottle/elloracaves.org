<?php

// Full-Text Search Example
// http://www.phpfreaks.com/tutorials/129/0.php
// Create the search function:

function searchForm_admin()
{
  // Re-usable form
  
  // variable setup for the form.
  $searchwords = (isset($_GET['words']) ? htmlspecialchars(stripslashes($_REQUEST['words'])) : '');
  $normal = (($_GET['mode'] == 'normal') ? ' selected="selected"' : '' );
  $boolean = (($_GET['mode'] == 'boolean') ? ' selected="selected"' : '' );

  echo '<form method="get" action="'.$_SERVER['PHP_SELF'].'">';
  echo '<input type="hidden" name="cmd" value="search" />';

  echo '<font size=/"2/"><i>Search for: <input type="text" size="35" name="words" value="'.$searchwords.'" /> ';
  echo '&nbsp;&nbsp; Mode: ';
  echo '<select name="mode">';
  echo '<option value="normal"'.$normal.'>Normal</option>';
  echo '<option value="boolean"'.$boolean.'>Boolean</option>';
  echo '</select> ';

  echo '<br /><br />';

  include('../shared/cave_menu.php');

  $range_start = (isset($_GET['start']) ? htmlspecialchars(stripslashes($_REQUEST['start'])) : '');
  $range_stop  = (isset($_GET['stop'])  ? htmlspecialchars(stripslashes($_REQUEST['stop']))  : '');

  echo '<br /><br />';
  echo 'Start: <input type="text" size="6" name="start" value="'.$range_start.'" /> ';
  echo '&nbsp;&nbsp; End: <input type="text" size="6" name="stop" value="'.$range_stop.'" /></i></font> ';

  echo '<br /><br />';

  echo '<input type="submit" value="Search" />';
  echo '</form> <br />';

}

?>
