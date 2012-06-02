<?php

/* include header */
include("../header.php");

/* reset vars used in script */
$api_key = 0;

/* get api key via post */
if(isset($_POST['api_key'])){ $api_key = $_POST['api_key']; }

/* check api key is valid */
$result = sql_num_rows("SELECT * FROM api_keys WHERE api_key = '{$api_key}' LIMIT 1");
if(!$result){ die("invalid_api"); }

/* check file size */
if($_FILES['file']['size'] > $_CONFIG['max_upload_size']){ die("upload_failed"); }

/* set allowed file types */
$allowed = array("jpg", "jpeg", "pjpeg", "gif", "png", "bmp");

/* check file type */
$ext = substr(strrchr($_FILES['file']['name'], '.'), 1);
if(!in_array($ext, $allowed)){ die("upload_failed"); }

/* upload file */
$file_name = str_replace(" ", "_", $_FILES['file']['name']);
if(move_uploaded_file($_FILES['file']['tmp_name'], $config['upload_path'] . $file_name))
{
    /* set rand file id */
    $file_id = randomStr(4, 8) . time();

    /* set delete id */
    $del_id = randomStr(6, 8) . time();
	
    /* insert file in to database */
    mysql_query("INSERT INTO uploads (file_id, 
								      delete_id,
								      file_name,
								      file_type,
								      file_size,
								      uploader_ip,
								      upload_date,
								      views,
								      upload_owner
								      ) VALUES (
								      '".$file_id."',
								      '".$del_id."',
								      '".$_FILES['file']['name']."',
								      '".$_FILES['file']['type']."',
								      '".$_FILES['file']['size']."',
								      '".$_SERVER['REMOTE_ADDR']."',
								      '".time()."',
								      '0',
								      '0')");
	
	/* output links */
	$links = "<br>" . $core->base_url . "/images/" . $file_id . "/" . $file_name . "<br>";
	$links .= $core->base_url . "/delete/" . $del_id . "/" . $file_id . "/" . $file_name . "";
	echo("upload_success");
	echo($links);
	
}else{
	die("upload_failed");
}


?>