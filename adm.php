<?php

// include header
include("header.php");

// set page name
$page = "admin";

/* check for valid admin login */
$user->check_admin_login();

// get task
$task = $_GET['m'];

// reset error vars
$is_error = 0;

/* switch task */
switch($task)
{
	// manage members
	case "users":
	    
		// query for all members
		$q = "SELECT user_id, user_email, user_name, premium, user_signup FROM members ORDER BY user_id DESC";
		$num = mysql_num_rows(mysql_query($q));
		$r = mysql_query($q);
		
		// delete member
		if(isset($_GET['task']) && $_GET['task'] == "delete")
		{
			// build query
			$q = "DELETE FROM members WHERE user_id = '".$_GET['u']."' AND user_id != '1' LIMIT 1";
			
			// execure query
			mysql_query($q);
			
			// redirect on success
			header("Location: ./adm.php?m=users&success=1");
			
			// exit
			exit();
		}
		
		// set template vars
		$tpl->task = "users";
		$tpl->result = $r;
		$tpl->total = $num;
		
	break;
	
	// manage files
	case "files":
	    
		// query for all files
		$q = "SELECT file_name, file_size, upload_date, views, file_id, delete_id, upload_owner FROM uploads ORDER BY id DESC";
		$num = mysql_num_rows(mysql_query($q));
		$r = mysql_query($q);
		
		// set template vars
		$tpl->task = "files";
		$tpl->result = $r;
		$tpl->total = $num;
		
		// delete files
		if(isset($_GET['task']) && $_GET['task'] == "delete")
		{
			// get file id
		    $file_id = $_GET['f'];
		
		    // get file details
		    $file = sql_row("SELECT file_name, file_id FROM uploads WHERE file_id = '".$file_id."' LIMIT 1");
		
		    // delete from database
	        mysql_query("DELETE FROM uploads WHERE file_id = '".$file['file_id']."'");
		
		    // delete from uploads folder
		    @unlink($config['upload_path'] . $file['file_name']);
			@unlink($config['upload_path'] . "thumbSmall_" . $file['file_name']);
			@unlink($config['upload_path'] . "thumbLarge_" . $file['file_name']);
			
			// log action
			admin_log("File Delete", "Admin deleted file: " . $file['file_name']);
		
		    // redirect on success
			header("Location: ./adm.php?m=files&success=1");
			
			// exit
			exit();
		}
		
	break;
	
	// manage siute logs
	case "site_logs":
	
	    // query for all logs
		$q = "SELECT id, action, action_date, action_text FROM site_logs ORDER BY id DESC";
		$num = mysql_num_rows(mysql_query($q));
		$r = mysql_query($q);
		
		// set template vars
		$tpl->task = "site_logs";
		$tpl->result = $r;
		$tpl->total = $num;
	
	break;
	
    // default view
	default:
	
	    // get total members
		$total_members = sql_row("SELECT count(user_id) AS total FROM members");
		
		// get total files
		$total_files = sql_row("SELECT count(id) AS total FROM uploads");
		
		// get total uploads size
		$total_space = sql_row("SELECT SUM(file_size) AS total_space FROM uploads");
	
	    // set template vars
		$tpl->total_members = $total_members['total'];
		$tpl->total_files = $total_files['total'];
		$tpl->total_space = $total_space['total_space'];
	    $tpl->task = "main";
}

// include footer
include("footer.php");

?>