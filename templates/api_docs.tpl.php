<?php include $this->template('header.tpl.php') ?>
<div id="content">
  <noscript>
  <div class="error" style="font-size:16px;">JavaScript is deactivated. Please activate Javascript!</div>
  </noscript>
  <br />
  <br />
  <div class="box">
    <h1>API Documentation</h1>
    <br clear="all">
    In order to access the API interface, you must have a working API key. You can get your API key <a href="./members/account.php">here</a> . To get your API key you must have a premium or free account. <br />
    <br />
    <h2>Get file information:</h2>
    <p>You must pass your API key and the files ID via post or get</p>
    <pre><code>Example Get:<br /><?= $this->config['site_url']; ?>/api/info.php?api_key=1234567890&amp;file_id=1234567890<br /><br />Output:<br />Array ( [file_id] => QCRssxD12y0260423 [file_name] => myFile.rar [file_type] => application/octet-stream [file_size] => 1434112, [views] => 126 )</code></pre>
    <br />
    <br />
    <h2>Uploading Files:</h2>
    <p>The following code is just an example, you can achive the same affect in other programming languages.</p>
    <pre><code>Example:<br />
    class Uploader 
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

    $upload_server = "<?= $this->config['site_url']; ?>/api/upload.php";
    $upload = new Uploader('file.rar', $upload_server, 'file', array('api_key' => 'YOUR_API_KEY'));
    $result = $upload->UploadFile();

    if(preg_match("/upload_failed/", $result)){ echo "Upload failed."; }
    if(preg_match("/invalid_api/", $result)){ echo "Invalid API Code."; }

    if(preg_match("/upload_success/", $result)){ echo $result; }<br /><br />Output:<br />upload_success<br /><?= $this->config['site_url']; ?>/images/123456789/myimage.jpg<br /><?= $this->config['site_url']; ?>/delete/123456789/123456789/myimage.jpg</code></pre>
    <br clear="all">
  </div>
  <div class="box" style="text-align:center">
    <h1>Sponsor</h1>
    <script type="text/javascript">
	<!--
	google_ad_client = "<?= $this->config['adsense_pub_id']; ?>";
	google_ad_width = 468;
	google_ad_height = 60;
	//-->
    </script>
    <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
  </div>
</div>
<?php include $this->template('footer.tpl.php') ?>