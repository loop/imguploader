<?php

/* mysql server details */
$host = "localhost"; // Your database host
$user = ""; // Your database username
$pass = ""; // Your database password
$database = ""; // Your database name

/* conect to database */
@mysql_connect($host, $user, $pass) or die($tpl->display("db_error.tpl.php"));
@mysql_select_db($database) or die($tpl->display("db_error.tpl.php"));

?>