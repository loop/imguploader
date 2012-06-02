<?php

class Core
{
    /* set initial vars */
	var $is_error;
	var $error_message;
	var $base_url;
	var $base_path;
	var $upload_dir;
	var $temp_dir;
	var $email_url;
	var $setting;
	
	
	/* this function sets default vars for class */
	function Core()
	{
		// set globals
		global $config;
		
		// base url of script
		$this->base_url = $config["site_url"];
		
		// email url
		$elink_remove = array("http://", "https://", "www."); // may add more
		$this->email_url = $this->base_url;
		$this->email_url = str_replace($elink_remove, "", $this->email_url);
	}
	
	
}

?>