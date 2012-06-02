<?php

/* include header */
include("header.php");

/* set page name */
$page = "lost_password";

/* attempt to reset password */
if(isset($_POST['task']) && $_POST['task'] == "doreset")
{
    // check if email exists
	$q = mysql_query("SELECT user_email FROM members WHERE user_email = '".$_POST['email']."' LIMIT 1");
	if(!mysql_num_rows($q))
	{
	    $is_error = 1;
		$message = "Account not found, please try again.";
	}
	
	// reset password
	if($is_error != 1)
	{
		// get user info
		$uinf = sql_row("SELECT * FROM members WHERE user_email = '".$_POST['email']."' LIMIT 1");
		
		// generate new password
		$new = randomStr(6, 8);
		
		// update database
		mysql_query("UPDATE members SET user_password = '".sha1($new)."' WHERE user_id = '".$uinf['user_id']."'");
		
		// send new password email
		$message = "Hi,\n\nYour new password is: " . $new . "\n\nThanks";
		send_generic($_POST['email'], $config['admin_email'], "Password Reset", $message);
		
		// set success
		$is_success = 1;
		$message = "A new password has successfully been emailed to you.";
	}
}

/* set template vars */
$tpl->is_error = $is_error;
$tpl-> is_success = $is_success;
$tpl->message = $message;

/* include footer */
include("footer.php");

?>