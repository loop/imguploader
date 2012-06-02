<?php

///////////////////////////////////////////////////////////////////////////////
//	Get/Set/Store uploaded file slot name, file name, file size and file type
///////////////////////////////////////////////////////////////////////////////
class FileInfo{
	var $slot = '';
	var $name = '';
	var $size = 0;
	var $type = '';
	var $status = '';
	var $status_desc = '';

	function getFileInfo($key){
		if(strcasecmp($key, 'slot') == 0){ return $this->slot; }
		elseif(strcasecmp($key, 'name') == 0){ return $this->name; }
		elseif(strcasecmp($key, 'size') == 0){ return $this->size; }
		elseif(strcasecmp($key, 'type') == 0){ return $this->type; }
		elseif(strcasecmp($key, 'status') == 0){ return $this->status; }
		elseif(strcasecmp($key, 'status_desc') == 0){ return $this->status_desc; }
		else{ print "Error: Invalid get member $key value on FileInfo object<br>\n"; }
	}

	function setFileInfo($key, $value){
		if(strcasecmp($key, 'slot') == 0){ $this->slot = $value; }
		elseif(strcasecmp($key, 'name') == 0){ $this->name = $value; }
		elseif(strcasecmp($key, 'size') == 0){ $this->size = $value; }
		elseif(strcasecmp($key, 'type') == 0){ $this->type = $value; }
		elseif(strcasecmp($key, 'status') == 0){ $this->status = $value; }
		elseif(strcasecmp($key, 'status_desc') == 0){ $this->status_desc = $value; }
		else{ print "Error: Invalid set member $key value on FileInfo object<br>\n"; }
	}
}

///////////////////////////////////////////////////////////////////////
//	XML Parser
//	Contributor: http://www.php.net/manual/en/function.xml-parse.php
///////////////////////////////////////////////////////////////////////
class XML_Parser{
	var $XML_Parser;
	var $error_msg = '';
	var $delete_xml_file = 1;
	var $in_error = 0;
	var $xml_file = '';
	var $raw_xml_data = '';
	var $xml_post_data = '';
	var $xml_data = array();
	var $upload_id = '';

	function setXMLFileDelete($delete_xml_file){ $this->delete_xml_file = $delete_xml_file; }
	function setXMLFile($temp_dir, $upload_id){
		$this->xml_file = $temp_dir . $upload_id . ".redirect";
		$this->upload_id = $upload_id;
	}
	function getError(){ return $this->in_error; }
	function getErrorMsg(){ return $this->error_msg; }
	function getRawXMLData(){ return $this->raw_xml_data; }
	function getXMLData(){ return $this->xml_data; }

	function startHandler($parser, $name, $attribs){
		$_content = array('name' => $name);

		if(!empty($attribs)){ $_content['attrs'] = $attribs; }

		array_push($this->xml_data, $_content);
	}

	function dataHandler($parser, $data){
		if(count(trim($data))){
			$_data_idx = count($this->xml_data) - 1;

			if(!isset($this->xml_data[$_data_idx]['content'])){ $this->xml_data[$_data_idx]['content'] = ''; }

			$this->xml_data[$_data_idx]['content'] .= $data;
		}
	}

	function endHandler($parser, $name){
		if(count($this->xml_data) > 1){
			$_data = array_pop($this->xml_data);
			$_data_idx = count($this->xml_data) - 1;
			$this->xml_data[$_data_idx]['child'][] = $_data;
		}
	}

	function parseFeed(){
		// read the upload_id.redirect file
		if($this->xml_post_data = readUbrFile($this->xml_file)){
			// store the raw xml file
			$this->raw_xml_data = $this->xml_post_data;

			// format the xml data into 1 long string
			$this->xml_post_data = preg_replace('/\>(\n|\r|\r\n| |\t)*\</','><', $this->xml_post_data);

			// create the xml parser
			$this->XML_Parser = xml_parser_create('');

			// set xml parser options
			xml_set_object($this->XML_Parser, $this);
			xml_parser_set_option($this->XML_Parser, XML_OPTION_CASE_FOLDING, false);
			xml_set_element_handler($this->XML_Parser, "startHandler", "endHandler");
			xml_set_character_data_handler($this->XML_Parser, "dataHandler");

			// parse upload_id.redirect file
			if(!xml_parse($this->XML_Parser, $this->xml_post_data)){
				$this->in_error = true;
				$this->error_msg = sprintf("<span class='ubrError'>XML ERROR</span>: %s at line %d", xml_error_string(xml_get_error_code($this->XML_Parser)), xml_get_current_line_number($this->XML_Parser));
			}

			xml_parser_free($this->XML_Parser);

			// delete upload_id.redirect file
			if($this->delete_xml_file){
				for($i = 0; $i < 3; $i++){
					if(@unlink($this->xml_file)){ break; }
					else{ sleep(1); }
				}
			}
		}
		else{
			$this->in_error = true;
			$this->error_msg = "<span class='error'>Failed to open redirect file " . $this->upload_id . ".redirect</span>";
		}
	}
}

///////////////////////////////////////////
//	Parse config data out of the xml data
///////////////////////////////////////////
function getConfigData($_XML_DATA){
	$_config_data = array();

	if(isset($_XML_DATA[0]['child'][0]['child'])){
		$num_configs = count($_XML_DATA[0]['child'][0]['child']);

		//config data is assumed to be stored in $_XML_DATA[0]['child'][0]
		for($i = 0; $i < $num_configs; $i++){
			if(isset($_XML_DATA[0]['child'][0]['child'][$i]['name']) && isset($_XML_DATA[0]['child'][0]['child'][$i]['content'])){
				$_config_data[$_XML_DATA[0]['child'][0]['child'][$i]['name']] = $_XML_DATA[0]['child'][0]['child'][$i]['content'];
			}
		}
	}

	return $_config_data;
}

/////////////////////////////////////////
//	Parse post data out of the xml data
/////////////////////////////////////////
function getPostData($_XML_DATA){
	$_post_value = array();
	$_post_data = array();

	if(isset($_XML_DATA[0]['child'][1]['child'])){
		$num_posts = count($_XML_DATA[0]['child'][1]['child']);

		//post data is assumed to be stored in $_XML_DATA[0]['child'][1]
		for($i = 0; $i < $num_posts; $i++){
			if(isset($_XML_DATA[0]['child'][1]['child'][$i]['name']) ){
				if(isset($_XML_DATA[0]['child'][1]['child'][$i]['content'])){
					$_post_value[$_XML_DATA[0]['child'][1]['child'][$i]['name']][$i] = $_XML_DATA[0]['child'][1]['child'][$i]['content'];
				}
				else{
					$_post_value[$_XML_DATA[0]['child'][1]['child'][$i]['name']][$i] = '';
				}
			}
		}

		foreach($_post_value as $key => $value){
			if(count($_post_value[$key]) > 1){
				$j = 0;

				foreach($_post_value[$key] as $content){
					$_post_data[$key][$j] = $content;
					$j++;
				}
			}
			else{
				foreach($_post_value[$key] as $content){ $_post_data[$key] = $content; }
			}
		}
	}

	return $_post_data;
}

/////////////////////////////////////////
//	Parse file data out of the xml data
/////////////////////////////////////////
function getFileData($_XML_DATA){
	$_file_data = array();

	if(isset($_XML_DATA[0]['child'][2]['child'])){
		$num_files = count($_XML_DATA[0]['child'][2]['child']);

		//file data is assumed to be stored in $_XML_DATA[0]['child'][2]
		for($i = 0; $i < $num_files; $i++){
			$file_info = new FileInfo;

			// file slot name
			if(isset($_XML_DATA[0]['child'][2]['child'][$i]['child'][0]['name']) && $_XML_DATA[0]['child'][2]['child'][$i]['child'][0]['name'] === 'slot' && isset($_XML_DATA[0]['child'][2]['child'][$i]['child'][0]['content'])){
				$file_info->setFileInfo($_XML_DATA[0]['child'][2]['child'][$i]['child'][0]['name'], $_XML_DATA[0]['child'][2]['child'][$i]['child'][0]['content']);
			}

			// file name
			if(isset($_XML_DATA[0]['child'][2]['child'][$i]['child'][1]['name']) && $_XML_DATA[0]['child'][2]['child'][$i]['child'][1]['name'] === 'name' && isset($_XML_DATA[0]['child'][2]['child'][$i]['child'][1]['content'])){
				$file_info->setFileInfo($_XML_DATA[0]['child'][2]['child'][$i]['child'][1]['name'], $_XML_DATA[0]['child'][2]['child'][$i]['child'][1]['content']);
			}

			// file size
			if(isset($_XML_DATA[0]['child'][2]['child'][$i]['child'][2]['name']) && $_XML_DATA[0]['child'][2]['child'][$i]['child'][2]['name'] === 'size'  && isset($_XML_DATA[0]['child'][2]['child'][$i]['child'][2]['content'])){
				$file_info->setFileInfo($_XML_DATA[0]['child'][2]['child'][$i]['child'][2]['name'], $_XML_DATA[0]['child'][2]['child'][$i]['child'][2]['content']);
			}

			// file type
			if(isset($_XML_DATA[0]['child'][2]['child'][$i]['child'][3]['name']) && $_XML_DATA[0]['child'][2]['child'][$i]['child'][3]['name'] === 'type' && isset($_XML_DATA[0]['child'][2]['child'][$i]['child'][3]['content'])){
				$file_info->setFileInfo($_XML_DATA[0]['child'][2]['child'][$i]['child'][3]['name'], $_XML_DATA[0]['child'][2]['child'][$i]['child'][3]['content']);
			}

			// file transfer status
			if(isset($_XML_DATA[0]['child'][2]['child'][$i]['child'][4]['name']) && $_XML_DATA[0]['child'][2]['child'][$i]['child'][4]['name'] === 'status' && isset($_XML_DATA[0]['child'][2]['child'][$i]['child'][4]['content'])){
				$file_info->setFileInfo($_XML_DATA[0]['child'][2]['child'][$i]['child'][4]['name'], $_XML_DATA[0]['child'][2]['child'][$i]['child'][4]['content']);
			}

			// file transfer status description
			if(isset($_XML_DATA[0]['child'][2]['child'][$i]['child'][5]['name']) && $_XML_DATA[0]['child'][2]['child'][$i]['child'][5]['name'] === 'status_desc' && isset($_XML_DATA[0]['child'][2]['child'][$i]['child'][5]['content'])){
				$file_info->setFileInfo($_XML_DATA[0]['child'][2]['child'][$i]['child'][5]['name'], $_XML_DATA[0]['child'][2]['child'][$i]['child'][5]['content']);
			}

			$_file_data[$i] = $file_info;
		}
	}

	return $_file_data;
}

//////////////////////////////////////////////////
//	formatBytes($file_size) mixed file sizes
//	formatBytes($file_size, 0) KB file sizes
//	formatBytes($file_size, 1) MB file sizes etc
//////////////////////////////////////////////////
function formatBytes($bytes, $format=99){
	$byte_size = 1024;
	$byte_type = array(" KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");

	$bytes /= $byte_size;
	$i = 0;

	if($format == 99 || $format > 7){
		while($bytes > $byte_size){
			$bytes /= $byte_size;
			$i++;
		}
	}
	else{
		while($i < $format){
			$bytes /= $byte_size;
			$i++;
		}
	}

	$bytes = sprintf("%1.2f", $bytes);
	$bytes .= $byte_type[$i];

	return $bytes;
}

function getFormattedUploadResults($file_name, $file_id, $del_id, $link_url)
{
    $upload_results = "<fieldset style=\"width:530px;padding:5px;\"> \n";
	$upload_results .= "<legend> Image: <b>".$file_name."</b></legend> 
				<table class=\"basic\"> 
					<tr> 
						<td class=\"right\" style=\"width:60px;\">Direct Link:</td> 
						<td><input type=\"text\" value=\"" . $link_url . "/images/".$file_id."/".$file_name."\" style=\"width:430px;font-size:9px;\" onClick=\"this.focus();this.select();\" /></td> 
					</tr> 
					<tr> 
						<td class=\"right\" style=\"width:70px;\">Forum link:</td> 
						<td><input type=\"text\" value=\"[URL=" . $link_url . "/images/".$file_id."/".$file_name."][IMG]" . $link_url . "/images/".$file_id."/".$file_name."[/IMG][/URL]\" style=\"width:430px;font-size:9px;\" onClick=\"this.focus();this.select();\" /></td> 
					</tr> 
					<tr> 
						<td class=\"right\" style=\"width:70px;\">HTML link:</td> 
						<td><input type=\"text\" value=\"<a href=&quot;" . $link_url . "/images/".$file_id."/".$file_name."&quot;><img src=&quot;" . $link_url . "/images/".$file_id."/".$file_name."&quot;></a>\" style=\"width:430px;font-size:9px;\" onClick=\"this.focus();this.select();\" /></td> 
					</tr>
					<tr> 
						<td class=\"right\" style=\"width:60px;\">View Page:</td> 
						<td><input type=\"text\" value=\"" . $link_url . "/view/".$file_id."/".$file_name."\" style=\"width:430px;font-size:9px;\" onClick=\"this.focus();this.select();\" /></td> 
					</tr> 
					<tr> 
						<td class=\"right\" style=\"width:60px;\">Delete link:</td> 
						<td><input type=\"text\" value=\"" . $link_url . "/delete/".$del_id."/".$file_id."/".$file_name."\" style=\"width:430px;font-size:9px;\" onClick=\"this.focus();this.select();\" /></td> 
					</tr> 
				</table>";
    $upload_results .= "</fieldset>\n<br clear=\"all\" />";
	return $upload_results;
}

?>