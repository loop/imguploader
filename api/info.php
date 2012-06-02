<?php

/* include header */
include("../header.php");

/* reset vars used in script */
$file_id = 0;
$api_key = 0;

/* get file id via get or post */
if(isset($_GET['file_id'])){ $file_id = $_GET['file_id']; }
if(isset($_POST['file_id'])){ $file_id = $_POST['file_id']; }

/* get api key via get or post */
if(isset($_GET['api_key'])){ $api_key = $_GET['api_key']; }
if(isset($_POST['api_key'])){ $api_key = $_POST['api_key']; }

/* check api key is valid */
$result = sql_num_rows("SELECT * FROM api_keys WHERE api_key = '{$api_key}' LIMIT 1");
if(!$result){ die("invalid api key"); }

/* if a valid api key has been supplied then continue with query */
if($result)
{
    /* check file exists */
    $file_exists = sql_num_rows("SELECT * FROM uploads WHERE file_id = '{$file_id}' LIMIT 1");
    if($file_exists)
	{
		/* get file info */
		$file = sql_row("SELECT * FROM uploads WHERE file_id = '{$file_id}' LIMIT 1");
		
		/* set file info array */
	    $info_array = array();
		
		/* build array */
		$info_array = array("file_id" => $file['file_id'],
							"file_name" => $file['file_name'],
							"file_type" => $file['file_type'],
							"file_size" => $file['file_size'],
							"views" = > $file['views']);
		
		/* print array to screen */
		print_r($info_array);
		
	}else{
		die("file does not exist");
	}
}


?>