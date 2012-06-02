<?php

/* include header */
include("header.php");

/* set page name */
$page = "index";

/* get latest uploads */
$q = "SELECT file_id, file_name FROM uploads ORDER BY id DESC LIMIT 4";
$r = mysql_query($q);
$num = mysql_num_rows($r);
while($row = mysql_fetch_assoc($r))
{
	/* build array */
	$image_array[] = array("file_name" => $row['file_name'],
						   "file_id" => $row['file_id']);
}

/* assign template vars */
$tpl->image_array = $image_array;
$tpl->num = $num;

/* include footer */
include("footer.php");

?>