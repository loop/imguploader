<?php

/* include header */
include("header.php");

/* set page name */
$page = "account";

/* reset error vars */
$is_error = 0;

/* update account details */
if(isset($_POST['task']) && $_POST['task'] == "doupdate")
{
	// check if email is filled
	if(empty($_POST['email']))
	{
		$tpl->is_error = 1;
		$tpl->message = "Please enter a valid email address.";
		$is_error = 1;
	}
	
	// check if passwords match
	if(!empty($_POST['pass']) && $_POST['pass'] != $_POST['pass2'])
	{
		$tpl->is_error = 1;
		$tpl->error_message = "Your passwords do not match.";
		$is_error = 1;
	}
	
	// no error?
	if($is_error != 1)
	{
        // build query
	    $q = "UPDATE members SET user_email = '".$_POST['email']."' ";
	    if(!empty($_POST['pass'])){ $q .= ", user_password = '".sha1($_POST['pass'])."' "; }
	    $q .= "WHERE user_id = '".$user->user_info['user_id']."'";
		
		// execute query
		mysql_query($q);
		
		// set success
		$tpl->is_success = 1;
		$tpl->message = "Details successfully updated.";
	}
}

/* include footer */
include("footer.php");

?>