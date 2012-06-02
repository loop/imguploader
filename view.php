<?php

/* include header */
include("header.php");

/* set page name */
$page = "view";

/* get image id */
$id = isset($_GET['id']) ? $_GET['id'] : 0;

/* check if image exists */
$q = "SELECT * FROM uploads WHERE file_id = '{$id}' LIMIT 1";
$num = sql_num_rows($q);

/* get image info */
if($num)
{
	/* pull image info from database */
    $image = sql_row($q);
	
	/* update views and last access */
	mysql_query("UPDATE uploads SET views = views+1, last_access = '".time()."' WHERE file_id = '{$id}'");
}

/* set template vars */
$tpl->num = $num;
$tpl->image = $image;

/* include footer */
include("footer.php");

?>