<?php

/* set config array */
$config = array();

/* site config */
$config['site_name'] = "ImgUploader"; // The name of your site (eg. FlexShare)
$config['site_url'] = "http://www.example.com"; // Main url of your site (no trailing slash)
$config['base_path'] = "/home/example/public_html"; // Base server path of script (no trailing slash)
$config['upload_path'] = $config['base_path'] . "/uploads/"; // Server path to uploads dir (INC trailing slash)
$config['admin_email'] = "admin@example.com"; // Admin email for site
$config['max_upload_size'] = 2097152; // Max upload size (in bytes)

/* adsense settings */
$config['adsense_pub_id'] = "pub-xxxxxxxxxxx"; // Your adsense PUB id

?>