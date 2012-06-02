<?php

class User extends Core
{
    /* set initial vars */
	var $is_error;
	var $error_message;
	var $user_info;
	var $total_files;
	var $total_size;
	var $user_exists;
	
	
	/* this function sets default vars for class */
	function User()
	{
		// set default vars
		$this->user_exists = 0;
		
		// get user info if logged in
		if(isset($_SESSION['logged_in']))
		{
			// get user info
		    $user_info = sql_row("SELECT * FROM members WHERE user_name = '".$_SESSION['username']."' LIMIT 1");
			$this->user_info = $user_info;
			
			// set user exists
			$this->user_exists = 1;
			
			// get total uploaded files
			$total_files = sql_row("SELECT count(file_id) AS total FROM uploads WHERE upload_owner = '".$this->user_info['user_id']."'");
			$this->total_files = $total_files['total'];
			
			// get total uploaded files size
			$total_size = sql_row("SELECT SUM(file_size) AS total_size FROM uploads WHERE upload_owner = '".$this->user_info['user_id']."'");
			$this->total_size = format_size($total_size['total_size']);
		}
	}
	
	
	/* this function registers a user */
	function register($user, $email, $pass, $pass2, $captcha)
	{
		// check if username is filled
		if(empty($user))
		{
		    $this->is_error = 1;
			$this->error_message = "Please choose a username.";
		}else
		
		// check if email is filled
		if(empty($email))
		{
		    $this->is_error = 1;
			$this->error_message = "Please enter your email address.";
		}else
		
		// check if password is filled
		if(empty($pass))
		{
		    $this->is_error = 1;
			$this->error_message = "Please choose a password.";
		}else
		
		// check if confirm password is filled
		if(empty($pass2))
		{
		    $this->is_error = 1;
			$this->error_message = "Please confirm your password.";
		}else
		
		// check if captcha is filled
		if(empty($captcha))
		{
		    $this->is_error = 1;
			$this->error_message = "Please enter the correct captcha code.";
		}else
		
		// check if passwords match
		if($pass != $pass2)
		{
		    $this->is_error = 1;
			$this->error_message = "Your passwords do not match.";
		}else
		
	    // check if captcha is correct
		if($captcha != $_SESSION['code'])
		{
			$this->is_error = 1;
			$this->error_message = "Incorrect captcha code.";
		}else
		
		// check password length
		/*if($pass < 6)
		{
			$this->is_error = 1;
			$this->error_message = "Passwords must be 6 chars or more.";
		}else*/
		
		// check username length
		if($user > 20)
		{
			$this->is_error = 1;
			$this->error_message = "Please choose a shorter username.";
		}else
		
		// check email address is valid
		if(!check_email($email))
		{
		    $this->is_error = 1;
			$this->error_message = "Please enter a valid email address.";
		}else
		
		// check username is valid
		if(!check_username($user))
		{
		    $this->is_error = 1;
			$this->error_message = "Your username should contain only letters, numbers and underscores.";
		}else
		
		
		// if there is no error, continue
		if($this->is_error != 1)
		{
			// insert user in to db
		    mysql_query("INSERT INTO members (user_name,
											  user_email,
											  user_password,
											  user_ip,
											  user_signup,
											  user_last_login
											  ) VALUES (
											  '".$user."',
											  '".$email."',
											  '".sha1($pass)."',
											  '".$_SERVER['REMOTE_ADDR']."',
											  '".time()."',
											  '".time()."')");	
			
			// get users details
			$row = sql_row("SELECT * FROM members WHERE user_name = '".$user."' LIMIT 1");
			
		    // set user login sessions
			$_SESSION['logged_in'] = true;
			$_SESSION['user_id'] = $row['user_id'];
			$_SESSION['username'] = $row['user_name'];
			
			// redirect
			header("Location: ./");
			
			//exit
			exit();
		}
	}
	
	
	/* this function logs a user in */
	function login($user, $pass, $return)
	{
	    // check if username is filled
		if(empty($user))
		{
		    $this->is_error = 1;
			$this->error_message = "Please enter your username.";
		}else
		
		// check if password is filled
		if(empty($pass))
		{
		    $this->is_error = 1;
			$this->error_message = "Please enter your password.";
		}else
		
		// query database to find user
		$query = @mysql_query("SELECT user_name, user_password FROM members WHERE user_name = '".$user."' AND user_password = '".sha1($pass)."' LIMIT 1");
		
		// check if user exists
		if(@mysql_num_rows($query) == 0)
		{
		    $this->is_error = 1;
			$this->error_message = "Login details incorrect, please try again.";
		}else
		
		// no error?, continue
		if($this->is_error != 1)
		{
			// get users details
			$row = sql_row("SELECT * FROM members WHERE user_name = '".$user."' LIMIT 1");
			
		    // set user login sessions
			$_SESSION['logged_in'] = true;
			$_SESSION['user_id'] = $row['user_id'];
			$_SESSION['username'] = $row['user_name'];
			
			// update last login
			mysql_query("UPDATE members SET user_last_login='".time()."' WHERE user_id = '".$row['user_id']."'");
			
			// redirect
			header("Location: $return");
			
			//exit
			exit();	
		}
	}
	
	
	/* this function logs a user out */
	function logout()
	{
	    // unset sessions
		unset($_SESSION['logged_in']);
		unset($_SESSION['user_id']);
		unset($_SESSION['username']);
		
		// redirect
		header("Location: ./");
		
		// exit
		exit();
	}
	
	
	/* this function checks for a valid login */
	function login_check()
	{
		// set globals
		global $tpl; 
		
		// check for sessions
	    if(!isset($_SESSION['logged_in']) || !isset($_SESSION['user_id']) || !isset($_SESSION['username']))
		{
			// set error message
			$tpl->is_error = 1;
			$tpl->error_message = "You must be logged in to do that.";
			
			// display login page
			$tpl->display("login.tpl.php");
			
			// exit
			exit;
		}
	}
	
	
	/* this function checks for a valid admin login */
	function check_admin_login()
	{
		// set globals
		global $tpl, $core; 
		
		// check for sessions
	    if(!isset($_SESSION['logged_in']) || !isset($_SESSION['user_id']) || !isset($_SESSION['username']) || $this->user_info['is_admin'] == 0)
		{
			// set error message
			$tpl->is_error = 1;
			$tpl->error_message = "You must be logged in with an admin account to view this page.";
			
			// set vars
			$tpl->core = $core;
			
			// display login page
		    $tpl->display("login.tpl.php");
			
			// exit
			exit;
		}
    }
	
	
	/* this function returns the number of files each user is hosting */
	function file_count($user)
	{
	    // build query
		$q = "SELECT file_id FROM uploads WHERE upload_owner = '".$user."'";
		
		// return total
		return mysql_num_rows(mysql_query($q));
	}
	
	
	/* this function returns a username from use id */
	function get_username($user)
	{
	    // query
		$q = "SELECT user_name FROM members WHERE user_id = '".$user."' LIMIT 1";
		
		// pull username row
		$r = mysql_fetch_array(mysql_query($q));
		
		// check for annonymous
		if($user == 0){ $user_id = "none"; }else{ $user_id = $r['user_name']; }
		
		// reutn username
		return $user_id;
	}
	
	
	
	
	
	
}

?>