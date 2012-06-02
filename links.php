<?php

/* include header */
include("header.php");

/* set page name */
$page = "links";

/* get file info */
$file = sql_row("SELECT * FROM uploads WHERE file_id = '".$_GET['file_id']."' LIMIT 1");

/* set template vars */
$tpl->file = $file;

/* include footer */
include("footer.php");

?>