<?php

/* include header */
include("header.php");

/* set page name */
$page = "contact";

/* reset error vars */
$is_error = 0;
$error_message = "";

/* try to send contact form */
if(isset($_POST['task']) && $_POST['task'] == "send")
{
    // get department
	$dep = $_POST['dep'];
	
	// get message
	$message = $_POST['message'];
	
	// get email
	$email = $_POST['email'];
	
	// get name
	$name = $_POST['name'];
	
	// get captcha
	$captcha = $_POST['captcha'];
	
	// reply message
	$reply = "We have received your message and will aim to reply within 24hours.";
	
	// check if all fields are filled
	if(empty($message) || empty($email) || empty($name) || empty($captcha))
	{
	    $is_error = 1;
		$error_message = "Please fill all fields.";
	}
	
	// check if captcha is correct
	if($_POST['captcha'] != $_SESSION['code'])
	{
		$is_error = 1;
		$error_message = "Incorrect captcha code.";
	}
	
	// no error
	if($is_error != 1)
	{
	    // send message
		send_generic($dep . "@" . $core->email_url, $email, $dep, $message);
		send_generic($email, $dep . "@" . $core->email_url, "Message Received", $reply);
		
		// set success var
		$tpl->sent = 1;
	}
}

/* set template vars */
$tpl->is_error = $is_error;
$tpl->error_message = $error_message;

/* include footer */
include("footer.php");

?>