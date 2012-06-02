<?php include $this->template('header.tpl.php') ?>
<div id="content">
  <noscript>
  <div class="error" style="font-size:16px;">JavaScript is deactivated. Please activate Javascript!</div>
  </noscript>
  <br />
  <br />
  <div class="box">
    <h1>Delete Image</h1>
    <br clear="all">
    <?php if($this->is_error != 0): ?><div class="error" style="text-align:center"><?= $this->error_message ?></div><br clear="all"><?php endif; ?>
    <?php if($this->is_success != 0): ?><div class="success" style="text-align:center"><?= $this->success_message ?></div><br clear="all"><?php endif; ?>
    <?php if($this->done != 1): ?>
    <p align="center">Are you sure you want to delete this image?<br clear="all"><br clear="all">
    <form action="<?= $_SERVER['REQUEST_URI']; ?>" method="post" style="text-align:center">
    <input type="hidden" name="delete_id" value="<?= $this->eprint($_GET['delete_id']); ?>" />
    <input type="hidden" name="file_id" value="<?= $this->eprint($_GET['file_id']); ?>" />
    <input type="hidden" name="action" value="delete_file" />
    <input type="submit" value="Yes" class="upload">
    <input type="button" value="No" class="upload" onclick="document.location='<?php if($this->user->user_exists == 1): ?>./members/myfiles.php<?php else: ?>./<?php endif; ?>';">
    </form>
    </p>
    <?php else: ?>
    <p align="center"><input type="button" value="Return Home" class="upload" onclick="document.location='<?php if($this->user->user_exists == 1): ?>./members/myfiles.php<?php else: ?>./<?php endif; ?>';"></p>
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