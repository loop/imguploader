<?php

/* this function stripslashes and encodes html entities for security purposes */
function security($value) 
{
    if(is_array($value)) {
	  $value = array_map('security', $value);
	} else {
	  if(!get_magic_quotes_gpc()) {
	    $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
	  } else {
	    $value = htmlspecialchars(stripslashes($value), ENT_QUOTES, 'UTF-8');
	  }
	  $value = str_replace("\\", "\\\\", $value);
	}
	return $value;
}

?>