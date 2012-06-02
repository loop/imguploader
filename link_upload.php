<?php

$UPLOAD_ID = '';               // Initialize upload id

include("./include/common.php");

if(!isset($_POST['upload_file']) || empty($_POST['upload_file'])){ kak("<span class='error'>Invalid parameters passed</span>", 1, __LINE__); }

// Generate upload id
$UPLOAD_ID = generateUploadID();

// Format link file path
$PATH_TO_LINK_FILE = $TEMP_DIR . $UPLOAD_ID . ".link";

//Pass ini settings via the link file
$_CONFIG['temp_dir'] = $TEMP_DIR;
$_CONFIG['upload_id'] = $UPLOAD_ID;
$_CONFIG['path_to_link_file'] = $PATH_TO_LINK_FILE;
$_CONFIG['redirect_after_upload'] = $_INI['redirect_after_upload'];
$_CONFIG['embedded_upload_results'] = $_INI['embedded_upload_results'];
$_CONFIG['cgi_upload_hook'] = $_INI['cgi_upload_hook'];
$_CONFIG['debug_upload'] = $_INI['debug_upload'];
$_CONFIG['delete_link_file'] = $_INI['delete_link_file'];
$_CONFIG['purge_temp_dirs'] = $_INI['purge_temp_dirs'];
$_CONFIG['purge_temp_dirs_limit'] = $_INI['purge_temp_dirs_limit'];

///////////////////////////////////////////////////////////////////////////////////////////////
//	ATTENTION
//
//	You can pass data via the link file by creating or over-riding config values. eg.
//
//	$_CONFIG['max_upload_size'] = $_SESSION['new_max_upload_size'];
//	$_CONFIG['max_upload_size'] = $_COOKIE['new_max_upload_size'];
//	$_CONFIG['max_upload_size'] = $_POST['new_max_upload_size'];
//
///////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////
//	ATTENTION
//
//	All upload form values including file names are available to this script through $_POST.
//	Therefore it is possible to create or over-ride config values based on user input. eg.
//
//	if($_POST['upload_location'] == 1){ $_CONFIG['upload_dir'] = '/var/home/docs/foo/'; }
//	else{ $_CONFIG['upload_dir'] = '/var/home/docs/bar/'; }
//
//	To access file names simply use a for loop. eg
//
//	for($i = 0; $i < count($_POST['upload_file']); $i++){
//		$file_name = rawurldecode($_POST['upload_file'][$i]);
//	}
//
////////////////////////////////////////////////////////////////////////////////////////////////

// Create temp, upload and log directories
if(!createDir($TEMP_DIR)){
	showAlertMessage("<span class='error'>Failed to create temp_dir</span>", 1);
}
if(!createDir($_CONFIG['upload_dir'])){
	showAlertMessage("<span class='error'>Failed to create upload_dir</span>", 1);
}

// Purge old .link files
if($_INI['purge_link_files']){ purgeFiles($TEMP_DIR, $_INI['purge_link_limit'], 'link', $_INI['debug_ajax']); }

// Purge old .redirect files
if($_INI['purge_redirect_files']){ purgeFiles($TEMP_DIR, $_INI['purge_redirect_limit'], 'redirect', $_INI['debug_ajax']); }

// Write link file
if(writeLinkFile($_CONFIG, $DATA_DELIMITER)){
	startUpload($UPLOAD_ID, $_INI['debug_upload'], $_INI['debug_ajax']);
}
else{
	showAlertMessage("<span class='error'>Failed to create link file: $UPLOAD_ID.link</span>", 1);
}

?>