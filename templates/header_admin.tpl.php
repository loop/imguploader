<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<title><?= $this->config['site_name']; ?> - Admin Panel</title>
<meta http-equiv="language" content="en" />
<meta http-equiv="content-language" content="en" />
<base href="<?= $this->config['site_url']; ?>/" />
<link rel="stylesheet" href="./assets/css/global_v1.css" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" href="./assets/css/table.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" language="javascript" src="./assets/javascript/jquery.js"></script>
<script type="text/javascript" language="javascript" src="./assets/javascript/table.js"></script>
<script language="JavaScript" type="text/javascript">
var JQ = jQuery.noConflict();

JQ().ready(function() 
{
    JQ("#searchtable").show();
	JQ("#table1").advancedtable({searchField: "#search", loadElement: "#loader", searchCaseSensitive: false, ascImage: "./assets/images/up.png", descImage: "./assets/images/down.png"});
});
</script>
</head>
<body>
<div id="navigation">
<ul id="mymenu">
	<li><a href="./adm.php" title="Home">Home</a></li>
    <li><a href="./adm.php?m=users">Manage Members</a></li>
    <li><a href="./adm.php?m=files">Manage Files</a></li>
    <li><a href="./adm.php?m=site_logs">View Site Logs</a></li>
    <li><a href="<?= $this->config['site_url']; ?>">View Site</a></li>
</ul>
</div>
<div id="logo"> ImgUploader </div>
