<?php

// Full-Text Search Example
// http://www.phpfreaks.com/tutorials/129/0.php
// Create the search function:

function searchForm()
{
  // Re-usable form

  echo '<table>';
  echo '<tr>';
  echo '<td>';
  
  // variable setup for the form.
  $searchwords = (isset($_GET['words']) ? htmlspecialchars(stripslashes($_REQUEST['words'])) : '');
  $normal = (($_GET['mode'] == 'normal') ? ' selected="selected"' : '' );
  $boolean = (($_GET['mode'] == 'boolean') ? ' selected="selected"' : '' );

  echo '<div class="search_form">';
  echo '<form method="get" action="./search.php">'; //'.$_SERVER['PHP_SELF'].'">';
  echo '<input type="hidden" name="cmd" value="search" />';

  echo '<font size=/"2/"><i>Search keywords: <input type="text" size="25" name="words" value="'.$searchwords.'" /> ';
  echo '<select name="mode" class="search_form_select">';
  echo '<option value="normal"'.$normal.'>Normal</option>';
  echo '<option value="boolean"'.$boolean.'>Boolean</option>';
  echo '</select> ';
  echo '<br />';

  include('./shared/cave_menu.php');

  echo '<br />';
  echo '</td><td width="30">';
  echo '</td><td>';
  echo '<br />';
  echo '<input type="submit" value="Search" class="search_button" />';
  echo '</td>';
  echo '</tr>';
  echo '</table>';
  echo '</form><br />';

  echo '<div class="search_help"><a href="./search_help.php">help</a></div>';
}

?>
