<?php

$UPLOAD_ID = '';                 // Initialize upload id

include("./include/common.php");

if(isset($_GET['upload_id']) && preg_match("/^[a-zA-Z0-9]{32}$/", $_GET['upload_id'])){ $UPLOAD_ID = $_GET['upload_id']; }
else{ kak("<span class='error'>Invalid parameters passed</span>", 1, __LINE__); }

$flength_file = $TEMP_DIR . $UPLOAD_ID . '.dir/' . $UPLOAD_ID . '.flength';
$hook_file = $TEMP_DIR . $UPLOAD_ID . '.dir/' . $UPLOAD_ID . '.hook';
$found_flength_file = false;
$found_hook_file = false;

// Keep trying to read the flength file until timeout
for($i = 0; $i < $_INI['flength_timeout_limit']; $i++){
	if($total_upload_size = readUbrFile($flength_file, $_INI['debug_ajax'])){
		$found_flength_file = true;
		$start_time = time();
		break;
	}

	clearstatcache();
	sleep(1);
}

// Failed to find the flength file in the alloted time
if(!$found_flength_file){
	showAlertMessage("<span class='error'>Failed to find flength file</span>", 1);
}
elseif(strstr($total_upload_size, "ERROR")){
	// Found the flength file but it contains an error
	list($error, $error_msg) = explode($DATA_DELIMITER, $total_upload_size);
	stopUpload();
	showAlertMessage("<span class='error'>" . $error_msg . "</span>", 1);
}
else{
	startProgressBar($UPLOAD_ID, $total_upload_size, $start_time);
}

?>