<?php

/* include header */
include("header.php");

/* set page name */
$page = "myfiles";

/* check for valid login */
$user->login_check();

/* get list of all members files */
$q = "SELECT file_name, file_size, upload_date, views, file_id, delete_id FROM uploads WHERE upload_owner='".$user->user_info['user_id']."' ORDER BY id DESC";
$num = mysql_num_rows(mysql_query($q));
$r = mysql_query($q);

/* assign template vars */
$tpl->result = $r;
$tpl->total = $num;

/* include footer */
include("footer.php");

?>