<?php

/* include header */
include("header.php");

/* get image id */
$id = isset($_GET['id']) ? $_GET['id'] : 0;

/* get size */
$size = isset($_GET['size']) ? $_GET['size'] : "Small";

/* check if image exists in database */
$q = "SELECT * FROM uploads WHERE file_id = '{$id}' LIMIT 1";
if(!sql_num_rows($q))
{
	header('Content-Type: image/gif');
	header('Content-Disposition: inline; filename=image_not_found.gif');
	@readfile($config['base_path'] . "/assets/images/image_not_found.gif");
}else

/* check if image exists on server */
$image = sql_row($q);
if(!file_exists($config['upload_path'] . "thumb" . $size . "_" . $image['file_name']))
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
	header('Content-Disposition: inline; filename='. "thumb" . $size . "_" . $image['file_name']);
	@readfile($config['upload_path'] . "thumb" . $size . "_" . $image['file_name']);
}

?>