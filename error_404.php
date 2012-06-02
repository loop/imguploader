<?php

/* include header */
include("header.php");

/* set page name */
$page = "error_404";

/* very simple 404 error report */
$report = "A 404 error was encounded on pgae: " . $_SERVER['REQUEST_URI'] . " on " . date("d-m-Y @ h:i:s");
$report .= "\n\nReffering URL: " . $_SERVER['HTTP_REFERER'];
send_generic("admin@" . $core->email_url, "noreply@" . $core->email_url, "404 Error", $report);

/* include footer */
include("footer.php");

?>