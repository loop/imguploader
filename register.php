<?php

/* include header */
include("header.php");

/* set page name */
$page = "register";

/* try to register user */
if(isset($_POST['task']) && $_POST['task'] == "doregister")
{
    // pass details to user class
	$user->register($_POST['username'], $_POST['email'], $_POST['pass'], $_POST['pass2'], $_POST['captcha']);
}

/* set templates vars */
$tpl->is_error = $user->is_error;
$tpl->error_message = $user->error_message;

/* include footer */
include("footer.php");

?>