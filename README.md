#imguploader
===========

Image uploader with user/admin section and ability to implement your own ads or adsense.

## System requirements

PHP 5+
MYSQL 4+
Apache web server
Mod Rewrite
CGI access
cUrl

## Installation instructions

1. Upload all files in the "Upload" folder to your server
2. Create a MYSQL database and execute the file /docs/database.sql
3. CHMOD 0777 the following directory: temp
4. CHMOD 0755 the following files: /cgi-bin/upload.cgi
5. Edit include/configs/config_base.php and change all the values to suit your needs.
6. Edit include/configs/config_mysql.php and enter your MYSQL details.

## Admin login

Default admin login:
Admin page: www.example.com/adm.php
Username: admin
Password: admin123

## API instructions

Get file information: (You must pass your API key and the files ID via post or get)

### Getting Files

**Input**
<pre><code>http://www.example.com/api/info.php?api_key=1234567890&file_id=1234567890</code></pre>

**Output:**
<pre><code>Array ( [file_id] => QCRssxD12y0260423 [file_name] => myFile.rar [file_type] => application/octet-stream [file_size] => 1434112 [views] => 128 )</code></pre>

### Uploading Files

**Input (example code):**
<pre><code>class Uploader 
    {
        var $filePath;
	    var $uploadURL;
	    var $formFileVariableName;
	    var $postParams = array ();
        
        function Uploader($filePath, $uploadURL, $formFileVariableName, $otherParams = false) 
        {
            $this->filePath = $filePath;
		    $this->uploadURL = $uploadURL;
		    if(is_array($otherParams) && $otherParams != false) 
		    {
			    foreach($otherParams as $fieldName => $fieldValue) 
			    {
				    $this->postParams[$fieldName] = $fieldValue;
			    }
		    }
		    $this->postParams[$formFileVariableName] = "@" . $filePath;
	    }
        
        function UploadFile() 
	    {
		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, $this->uploadURL);
		    curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, $this->postParams);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    $postResult = curl_exec($ch);

		    if (curl_errno($ch)) 
		    {
			    print curl_error($ch);
			    print "Unable to upload file.";
			    exit();
		    }
		    curl_close($ch);

		    return $postResult;
	    }
    }

    $upload_server = "http://www.example.com/api/upload.php";
    $upload = new Uploader('file.rar', $upload_server, 'file', array('api_key' => 'YOUR_API_KEY'));
    $result = $upload->UploadFile();

    if(preg_match("/upload_failed/", $result)){ echo "Upload failed."; }
    if(preg_match("/invalid_api/", $result)){ echo "Invalid API Code."; }

    if(preg_match("/upload_success/", $result)){ echo $result; }</code></pre>

**Output:**
<pre><code>upload_success
http://www.example.com/images/123456789/transformers.jpg
http://www.example.com/delete/123456789/123456789/transformers.jpg</code></pre>

## Open Source License

Released under the MIT public license.

## Footnote

I used to sell this and some other scripts online back in 2010 or so and some not very nice people started to distribute it for free or sell it and make profit and I stopped selling this script and others. Now I decided to open source and release it for free officially.