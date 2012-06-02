<?php

/* include commons file */
include("include/common.php");

/* initialize upload id */
$UPLOAD_ID = '';

/* require upload finished lib */
require_once("./include/uploader_finished_lib.php");

/* include thumbnail class */
include_once('./include/classes/class_thumb.php');

/* initiate new thumb class */
$thumb_small = new Thumbnail;
$thumb_large = new Thumbnail;

/* set headers */
header('Content-type: text/html; charset=UTF-8');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: '.date('r'));
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

/* set upload ID or throw error */
if(isset($_GET['upload_id']) && preg_match("/^[a-zA-Z0-9]{32}$/", $_GET['upload_id'])){ $UPLOAD_ID = $_GET['upload_id']; }else{ kak("<span class='error'>Invalid parameters passed</span>", 1, __LINE__); }

/* set arrays */
$_XML_DATA = array();
$_CONFIG_DATA = array();
$_POST_DATA = array();
$_FILE_DATA = array();
$_FILE_DATA_TABLE = '';
$_FILE_DATA_EMAIL = '';

/* new XML parser */
$xml_parser = new XML_Parser;

/* set upload_id.redirect file */
$xml_parser->setXMLFile($TEMP_DIR, $_GET['upload_id']);

/* delete upload_id.redirect file when finished parsing */
$xml_parser->setXMLFileDelete($_INI['delete_redirect_file']);

/* parse upload_id.redirect file */
$xml_parser->parseFeed();

/* display message if the XML parser encountered an error */
if($xml_parser->getError()){ kak($xml_parser->getErrorMsg(), 1, __LINE__); }

/* get xml data from the xml parser */
$_XML_DATA = $xml_parser->getXMLData();

/* get data from xml */
$_CONFIG_DATA = getConfigData($_XML_DATA);
$_POST_DATA  = getPostData($_XML_DATA);
$_FILE_DATA = getFileData($_XML_DATA);

/* get upload owner */
$upload_owner = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '0';

/* handle files */
for($i = 0; $i < count($_FILE_DATA); $i++)
{
	// set rand file id
    $file_id = randomStr(4, 8) . time();

    // set delete id
    $del_id = randomStr(6, 8) . time();
	
	// create small thumb
	$thumb_small->Thumbheight = 150;
	$thumb_small->Thumbwidth = 150;
	$thumb_small->Quality = 60;
	$thumb_small->Thumblocation = $config['upload_path'];
	$thumb_small->Thumbprefix = 'thumbSmall_';
	$thumb_small->Thumbfilename = $_FILE_DATA[$i]->getFileInfo('name');
	$thumb_small->Createthumb($config['upload_path'] . $_FILE_DATA[$i]->getFileInfo('name'), 'file');
	
	// create large thumb
	$thumb_large->Thumbwidth = 500;
	$thumb_large->Quality = 60;
	$thumb_large->Thumblocation = $config['upload_path'];
	$thumb_large->Thumbprefix = 'thumbLarge_';
	$thumb_large->Thumbfilename = $_FILE_DATA[$i]->getFileInfo('name');
	$thumb_large->Createthumb($config['upload_path'] . $_FILE_DATA[$i]->getFileInfo('name'), 'file');
	
    // insert file in to database
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
								      '".$_FILE_DATA[$i]->getFileInfo('name')."',
								      '".$_FILE_DATA[$i]->getFileInfo('type')."',
								      '".$_FILE_DATA[$i]->getFileInfo('size')."',
								      '".$_SERVER['REMOTE_ADDR']."',
								      '".time()."',
								      '0',
								      '".$upload_owner."')");

    // display upload results on page
    print getFormattedUploadResults($_FILE_DATA[$i]->getFileInfo('name'), $file_id, $del_id, $config['site_url']);
}

?>