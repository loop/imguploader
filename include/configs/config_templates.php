<?php

/* include class file */
include($config['base_path'] . "/include/templateEngine/Savant3.php");

/* initiate new template class */
$tpl = new Savant3();

/* set default templates folder */
$tpl->setPath("template", $config['base_path'] . "/templates/");

?>