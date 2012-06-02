<?php

/* include header */
include("header.php");

/* set page name */
$page = "delete_file";

/* reset error vars */
$is_error = 0;
$error_message = "";

/* delete file */
if(isset($_POST['action']) && $_POST['action'] == "delete_file")
{
    // check if delete key is correct for file
	$query = mysql_query("SELECT * FROM uploads WHERE file_id = '".$_POST['file_id']."'
												AND delete_id = '".$_POST['delete_id']."' LIMIT 1");
	
	// get file info based on vars passed
    $file = sql_row("SELECT * FROM uploads WHERE file_id = '".$_POST['file_id']."' LIMIT 1");
	
	// if the delete key is wrond, show error
	if(!mysql_num_rows($query))
	{
	    $is_error = 1;
		$error_message = "Incorrect delete key or file id, please try again.";
	}
	
	// no error, delete file
	if($is_error != 1)
	{
		// delete from database
	    mysql_query("DELETE FROM uploads WHERE file_id = '".$file['file_id']."' AND delete_id = '".$file['delete_id']."'");
		
		// delete from uploads folder
		@unlink($config['upload_path'] . $file['file_name']);
		@unlink($config['upload_path'] . "thumbSmall_" . $file['file_name']);
		@unlink($config['upload_path'] . "thumbLarge_" . $file['file_name']);
		
		// set success
		$tpl->is_success = 1;
		$tpl->success_message = "Image successfully deleted!";
		
		/* remove confirm buttons and set return button */
		$tpl->done = 1;
	}
}

/* set template vars */
$tpl->is_error = $is_error;
$tpl->error_message = $error_message;

/* include footer */
include("footer.php");

?>