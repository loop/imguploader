<?php

/* include common file */
include("include/common.php");

/* clean all $_POST, $_GET & $_COOKIE vars */
$_POST = security($_POST);
$_GET = security($_GET);
$_COOKIE = security($_COOKIE);


?>