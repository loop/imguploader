<?php include $this->template('header.tpl.php') ?>
<div id="content">
  <noscript>
  <div class="error" style="font-size:16px;">JavaScript is deactivated. Please activate Javascript!</div>
  </noscript>
  <br />
  <br />
  <div class="box">
    <h1>Image Viewer</h1>
    <br clear="all">
    <?php if($this->num): ?>
    <p align="center"><img src="./get-thumb.php?id=<?= $this->image['file_id']; ?>&size=Large" style="max-width:500px;" /></p>
    <?php else: ?>
    <div class="error">Sorry but the image you have requested does not exist</div>
    <?php endif; ?>
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