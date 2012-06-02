<?php

// Output a message to screen and exit
function kak($msg, $exit_ubr, $line, $path_to_css_file='./assets/css/global_v1.css'){
	print "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">\n";
	print "<html>\n";
	print "		<head>\n";
	print "			<title>Upload</title>\n";
	print "			<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">\n";
	print "			<meta http-equiv=\"Pragma\" content=\"no-cache\">\n";
	print "			<meta http-equiv=\"cache-control\" content=\"no-cache\">\n";
	print "			<meta http-equiv=\"expires\" content=\"-1\">\n";
	print "			<meta name=\"robots\" content=\"none\">\n";
	print "			<link rel=\"stylesheet\" type=\"text/css\" href=\"$path_to_css_file\">\n";
	print "		</head>\n";
	print "		<body bgcolor=\"#EEEEEE\">\n";
	print "			<div id=\"main_container\">\n";
	print "				<br>\n";
	print "				$msg\n";
	print "				<br>\n";
	print "				<!-- kak on line $line -->\n";
	print "			</div>\n";
	print "		</body>\n";
	print "</html>\n";

	if($exit_ubr){ exit; }
}

// Read a file
function readUbrFile($file, $debug_ajax=0){
	if(@is_file($file)){
		if(@is_readable($file)){
			$file_contents = '';

			if(function_exists('file_get_contents')){
				if(($file_contents = @file_get_contents($file)) !== false){ return $file_contents; }
				else{
					if($debug_ajax){ showDebugMessage("Failed to read file contents:" . $file); }
					return false;
				}
			}
			else{
				if(($fh = @fopen($file, "rb")) !== false){
					if(($file_contents = @fread($fh, @filesize($file))) !== false){
						fclose($fh);
						return $file_contents;
					}
					else{
						if($debug_ajax){ showDebugMessage("Failed to fread file:" . $file); }
						return false;
					}
				}
				else{
					if($debug_ajax){ showDebugMessage("Failed to open file:" . $file); }
					return false;
				}
			}
		}
		else{
			if($debug_ajax){ showDebugMessage("Failed to read file:" . $file); }
			return false;
		}
	}
	else{
		if($debug_ajax){ showDebugMessage("Failed to find file:" . $file); }
		return false;
	}
}

// Delete all files in a directory and delete directory
function deleteDir($dir){
	if(($dp = @opendir($dir)) !== false){
		while(($file_name = @readdir($dp)) !== false){
			if($file_name !== "." && $file_name !== ".."){ @unlink($dir . '/' . $file_name); }
		}
		closedir($dp);
	}

	if(@rmdir($dir)){ return true; }
	else{ return false; }
}

// Create a directory with full read and write permissions
function createDir($dir){
	if(is_dir($dir)){ return true; }
	else{
		if(@mkdir($dir, 0777)){ return true; }
		else{ return false; }
	}
}

//Purge old file based on extension and timestamp
function purgeFiles($temp_dir, $purge_time_limit, $file_type, $debug_ajax=0){
	$now_time = mktime();

	if(is_dir($temp_dir)){
		if(($dp = @opendir($temp_dir)) !== false){
			while(($file_name = readdir($dp)) !== false){
				if($file_name !== '.' && $file_name !== '..' && strcmp(getFileExtension($file_name), $file_type) == 0){
					if($file_time = @filectime($temp_dir . $file_name)){
						if(($now_time - $file_time) > $purge_time_limit){ @unlink($temp_dir . $file_name); }
					}
				}
			}
			closedir($dp);
		}
		else{
			if($debug_ajax){ showDebugMessage('Failed to open temp_dir ' . $temp_dir); }
			showAlertMessage("<span class='error'>Failed to open temp_dir</span>", 1);
		}
	}
	else{
		if($debug_ajax){ showDebugMessage('Failed to find temp_dir ' . $temp_dir); }
		showAlertMessage("<span class='error'>Failed to find temp_dir</span>", 1);
	}
}

//Write 'upload_id.link' file
function writeLinkFile($_config, $data_delimiter){
	if(($fh = @fopen($_config['path_to_link_file'], "wb")) !== false){
		foreach($_config as $config_setting=>$config_value){
			$config_setting = trim($config_setting);
			$config_value = trim($config_value);
			$config_string = $config_setting . $data_delimiter. $config_value . "\n";
			fwrite($fh, $config_string);
		}

		ftruncate($fh, (ftell($fh) - 1));
		fclose($fh);
		chmod($_config['path_to_link_file'], 0666);

		if(is_readable($_config['path_to_link_file'])){ return true; }
		else{ return false; }
	}
	else{ return false; }
}

// Show alert message on file upload page
function showAlertMessage($message, $exit_ubr){
	print "if(typeof Uploader.showAlertMessage == 'function'){ Uploader.showAlertMessage(" . '"' . $message . '"' . "); }";

	if($exit_ubr){ exit(); }
}

// Generate a 32 character string
function generateUploadID(){ return md5(uniqid(mt_rand(), true)); }

// Return file extension in lowercase
function getFileExtension($file_name){
	$file_extension = strtolower(substr(strrchr($file_name, '.'), 1));

	return $file_extension;
}

// Javascript function wrappers
function showDebugMessage($message){ print "if(typeof Uploader.showDebugMessage == 'function'){ Uploader.showDebugMessage(" . '"' . $message . '"' . "); }"; }
function stopUpload(){ print "if(typeof Uploader.stopUpload == 'function'){ Uploader.stopUpload(); }"; }
function startUpload($upload_id, $debug_upload, $debug_ajax){ print "if(typeof Uploader.startUpload == 'function'){ Uploader.startUpload(" . '"' . $upload_id . '",' . $debug_upload . "," . $debug_ajax . "); }"; }
function startProgressBar($upload_id, $total_upload_size, $start_time){ print "if(typeof Uploader.startProgressBar == 'function'){ Uploader.startProgressBar(" . '"' . $upload_id . '",' . $total_upload_size . "," . $start_time . "); }"; }
function setProgressStatus($total_bytes_read, $files_uploaded, $current_filename, $bytes_read, $lapsed_time){ print "if(typeof Uploader.setProgressStatus == 'function'){ Uploader.setProgressStatus(" . $total_bytes_read . "," . $files_uploaded . ",'" . $current_filename . "'," . $bytes_read . "," . $lapsed_time . "); }"; }
function stopDataLoop(){ print "if(typeof Uploader.stopDataLoop == 'function'){ Uploader.stopDataLoop(); }"; }
function getProgressStatus($get_status_speed){ print "if(typeof Uploader.getProgressStatus == 'function'){ setTimeout('Uploader.getProgressStatus()', $get_status_speed); }"; }

////////////////////////////////////////////////////////////////////////////////
//	Output array to screen (debug, debug_var, next_div, debug_colorize_string)
//	Contributor: http://www.php.net/manual/en/function.print-r.php
////////////////////////////////////////////////////////////////////////////////
function debug($name, $data){
	ob_start();
	print_r($data);
	$str = ob_get_contents();
	ob_end_clean();
	debug_var($name, $str);
}

function debug_var($name, $data){
	$captured = preg_split("/\r?\n/", $data);

	print "<script>function toggleDiv(num){var span = document.getElementById('d'+num);var a = document.getElementById('a'+num);var cur = span.style.display;if(cur == 'none'){a.innerHTML = '-';span.style.display = 'inline';}else{a.innerHTML = '+';span.style.display = 'none';}}</script>";
	print "<b>$name</b>\n";
	print "<pre>\n";

	foreach($captured as $line){ print debug_colorize_string($line) . "\n"; }

	print "</pre>\n";
}

function next_div($matches){
	static $num = 0;
	++$num;
	return "$matches[1]<a id=a$num href=\"javascript: toggleDiv($num)\">+</a><span id=d$num style=\"display:none\">(";
}

function debug_colorize_string($string){
	$string = preg_replace("/\[(\w*)\]/i", '[<font color="red">$1</font>]', $string);
	$string = preg_replace_callback("/(\s+)\($/", 'next_div', $string);
	$string = preg_replace("/(\s+)\)$/", '$1)</span>', $string);
	$string = str_replace('Array', '<font color="blue">Array</font>', $string);
	$string = str_replace('=>', '<font color="#556F55">=></font>', $string);

	return $string;
}

?>