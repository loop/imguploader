<?php

/* global template vars */
$tpl->config = $config;
$tpl->_CONFIG = $_CONFIG;
$tpl->user = $user;
$tpl->page = $page;
$tpl->core = $core;

/* display template file */
$tpl->display($page . ".tpl.php");

?>