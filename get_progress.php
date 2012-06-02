<?php

$UPLOAD_ID = '';           // Initialize upload id

include("./include/common.php");

if(isset($_GET['upload_id']) && preg_match("/^[a-zA-Z0-9]{32}$/", $_GET['upload_id']) && isset($_GET['start_time']) && isset($_GET['total_upload_size'])){ $UPLOAD_ID = $_GET['upload_id']; }
else{ kak("<span class='error'>Invalid parameters passed</span>", 1, __LINE__); }

$total_bytes_read = 0;
$files_uploaded = 0;
$current_filename = '';
$bytes_read = 0;
$upload_active = 0;
$flength_file = $UPLOAD_ID . '.flength';
$path_to_flength_file = $TEMP_DIR . $UPLOAD_ID . '.dir/' . $flength_file;
$temp_upload_dir = $TEMP_DIR . $UPLOAD_ID . '.dir';

// If the "/temp_dir/upload_id.dir/upload_id.flength" file exist, the upload is active
if(@is_readable($path_to_flength_file)){
	$upload_active = 1;

		// Get upload status by reading the "/temp_dir/upload_id.dir" directory
		if(($dp = @opendir($temp_upload_dir)) !== false){
			while(($file_name = @readdir($dp)) !== false){
				if(($file_name !== '.') && ($file_name !== '..') && ($file_name !== $flength_file)){
					$total_bytes_read += sprintf("%u", @filesize($temp_upload_dir . '/' . $file_name));
					$files_uploaded++;
				}
			}
			@closedir($dp);

			if($files_uploaded > 0){ $files_uploaded -= 1; }
		}
		else{ $upload_active = 0; }
	}

if($upload_active && $total_bytes_read < $_GET['total_upload_size'])
{
	$lapsed_time = time() - $_GET['start_time'];
	setProgressStatus($total_bytes_read, $files_uploaded, $current_filename, $bytes_read, $lapsed_time);
	getProgressStatus($_INI['get_progress_speed']);
}
else{
	stopDataLoop();
}

?>