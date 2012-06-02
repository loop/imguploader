<?php

/* include header */
include("header.php");

/* get image id */
$id = isset($_GET['id']) ? $_GET['id'] : 0;

/* check if image exists */
$q = "SELECT * FROM uploads WHERE file_id = '{$id}' LIMIT 1";
if(!sql_num_rows($q))
{
	header('Content-Type: image/gif');
	header('Content-Disposition: inline; filename=image_not_found.gif');
	@readfile($config['base_path'] . "/assets/images/image_not_found.gif");
}else

/* display image */
if(sql_num_rows($q))
{
	$image = sql_row($q);
	header('Content-Type: '. $image['file_type']);
	header('Content-Disposition: inline; filename='. $image['file_name']);
	@readfile($config['upload_path'] . $image['file_name']);
	
	/* update views and last access */
	mysql_query("UPDATE uploads SET views = views+1, last_access = '".time()."' WHERE file_id = '{$id}'");
}

?>