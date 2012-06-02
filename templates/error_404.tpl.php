<?php include $this->template('header.tpl.php') ?>
<div id="content">
  <div class="box">
    <h1>404 Page Not Found</h1>
    <br clear="all">
    <div class="error" style="text-align:center">The page you have requested has not been found, details have been logged for site admins.</div><br /><br />
    <center><input type="button" class="upload" value="Go Back" onclick="javascript:history.go(-1);" /></center>
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