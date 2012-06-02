<?php

/* start sessions if not already started */
@session_start();

/* include config files */
include(dirname(__FILE__) . "/configs/config_base.php");
include(dirname(__FILE__) . "/configs/config_templates.php");
include(dirname(__FILE__) . "/configs/config_mysql.php");
include(dirname(__FILE__) . "/configs/config_upload.php");

/* include function files */
include(dirname(__FILE__) . "/functions/functions_mysql.php");
include(dirname(__FILE__) . "/functions/functions_security.php");
include(dirname(__FILE__) . "/functions/functions_general.php");
include(dirname(__FILE__) . "/functions/functions_email.php");

/* include class files */
include(dirname(__FILE__) . "/classes/class_core.php");
include(dirname(__FILE__) . "/classes/class_user.php");
include(dirname(__FILE__) . "/classes/class_pagination.php");
include(dirname(__FILE__) . "/classes/class_download.php");

/* include other required files */
include(dirname(__FILE__) . "/uploader_ini.php");
include(dirname(__FILE__) . "/uploader_lib.php");

/* initiate new classes */
$core = new Core();
$user = new User();

/* set upload config */
$_CONFIG['max_upload_size'] = $config["max_upload_size"];
$_CONFIG['upload_dir'] = $config["upload_path"];

?>