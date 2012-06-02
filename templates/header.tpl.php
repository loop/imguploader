<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<title><?= $this->config['site_name']; ?></title>
<meta http-equiv="language" content="en-GB" />
<meta http-equiv="content-language" content="en-GB" />
<meta name="description" content="<?= $this->config['site_name']; ?>" />
<meta name="keywords" content="" />
<meta name='revisit-after' content="3 days" />
<meta name="robots" content="index, follow, all" />
<base href="<?= $this->config['site_url']; ?>/" />
<link rel="stylesheet" href="./assets/css/global_v1.css" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" href="./assets/css/table.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" language="javascript" src="./assets/javascript/jquery.js"></script>
<script type="text/javascript" language="javascript" src="./assets/javascript/table.js"></script>
<script language="JavaScript" type="text/javascript" src="./assets/javascript/block_ui.js"></script>
<script language="JavaScript" type="text/javascript" src="./assets/javascript/uploader.js"></script>
<script language="JavaScript" type="text/javascript">
var JQ = jQuery.noConflict();
<?php if($this->page == "myfiles"): ?>
JQ().ready(function() 
{
    JQ("#searchtable").show();
	JQ("#table1").advancedtable({searchField: "#search", loadElement: "#loader", searchCaseSensitive: false, ascImage: "./assets/images/up.png", descImage: "./assets/images/down.png"});
});
<?php endif; ?>
<?php if($this->page == "index"): ?>
Uploader.path_to_upload_script = "<?= $this->config['site_url']; ?>/cgi-bin/upload.cgi";
Uploader.max_upload_slots = 5;

JQ(document).ready(function()
{
    Uploader.resetFileUploadPage();
	JQ("#reset_button").bind("click", function(e){ Uploader.resetFileUploadPage(); });
	JQ("#progress_bar_background").css("width", Uploader.progress_bar_width);
});
<?php endif; ?>
<?php if($this->page == "faq"): ?>
function changeFAQ(id) 
{
    JQ('#faq-'+id).toggle();
	if(JQ('#img-'+id).attr('src') == './assets/images/plus.gif') {
		JQ('#img-'+id).attr('src', './assets/images/minus.gif');
	} else {
		JQ('#img-'+id).attr('src', './assets/images/plus.gif');
	}
}
<?php endif; ?>
</script>
</head>
<body>
<div id="navigation">
<ul id="mymenu">
	<li><a href="./" title="Home">Home</a></li>
    <?php if($this->user->user_exists == 0): ?>
    <li><a href="./register.php" title="Register for a free account">Register</a></li>
    <li><a href="./login.php" title="Login to your account">Login</a></li>
    <?php else: ?>
    <li><a href="./members/myfiles.php" title="Manage your files">My Files</a></li>
    <li><a href="./members/account.php" title="Manage your account">Account</a></li>
    <li><a href="./logout.php" onclick="return confirm('Logout?');" title="Logout">Logout</a></li>
    <?php endif; ?>
    <li><a href="./help/faq.php" title="FAQ">FAQ</a></li>
    <li><a href="./help/report-abuse.php" title="Report Abuse">Abuse</a></li>
    <li><a href="./help/contact.php" title="Contact Us">Contact</a></li>
    <?php if($this->user->user_info['is_admin'] == 1): ?>
    <li><a href="./adm.php" title="Admin Panel">Admin Panel</a></li>
    <?php endif; ?>
</ul>
</div>
<div id="logo"> ImgUploader </a> </div>
