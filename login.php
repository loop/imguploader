<?php

/* include header */
include("header.php");

/* set page name */
$page = "login";

/* try to log user in */
if(isset($_POST['task']) && $_POST['task'] == "dologin")
{
    $user->login($_POST['user'], $_POST['pass'], $_POST['return']);
}

/* set templates vars */
$tpl->is_error = $user->is_error;
$tpl->error_message = $user->error_message;

/* include footer */
include("footer.php");

?>