<?php include $this->template('header.tpl.php') ?>
<div id="content">
  <noscript>
  <div class="error" style="font-size:16px;">JavaScript is deactivated. Please activate Javascript!</div>
  </noscript>
  <br />
  <br />
  <div class="box">
    <h1>Image Links</h1>
    <br clear="all">
    <fieldset style="width:530px;padding:5px;">
	<legend> Image: <b><?= $this->file['file_name']; ?></b></legend> 
				<table class="basic"> 
					<tr> 
						<td class="right" style="width:60px;">Direct Link:</td> 
						<td><input type="text" value="<?= $this->config['site_url']; ?>/images/<?= $this->file['file_id']; ?>/<?= $this->file['file_name']; ?>" style="width:430px;font-size:9px;" onClick="this.focus();this.select();" /></td> 
					</tr> 
					<tr> 
						<td class="right" style="width:70px;">Forum link:</td> 
						<td><input type="text" value="[URL=<?= $this->config['site_url']; ?>/images/<?= $this->file['file_id']; ?>/<?= $this->file['file_name']; ?>][IMG]<?= $this->config['site_url']; ?>/images/<?= $this->file['file_id']; ?>/<?= $this->file['file_name']; ?>[/IMG][/URL]" style="width:430px;font-size:9px;" onClick="this.focus();this.select();" /></td> 
					</tr> 
                    <tr> 
						<td class="right" style="width:70px;">HTML link:</td> 
						<td><input type="text" value="<a href=&quot;<?= $this->config['site_url']; ?>/images/<?= $this->file['file_id']; ?>/<?= $this->file['file_name']; ?>&quot;><img src=&quot;<?= $this->config['site_url']; ?>/images/<?= $this->file['file_id']; ?>/<?= $this->file['file_name']; ?>&quot;></a>" style="width:430px;font-size:9px;" onClick="this.focus();this.select();" /></td> 
					</tr> 
					<tr> 
						<td class="right" style="width:70px;">View Page:</td> 
						<td><input type="text" value="<?= $this->config['site_url']; ?>/view/<?= $this->file['file_id']; ?>/<?= $this->file['file_name']; ?>" style="width:430px;font-size:9px;" onClick="this.focus();this.select();" /></td> 
					</tr> 
					<tr> 
						<td class="right" style="width:60px;">Delete link:</td> 
						<td><input type="text" value="<?= $this->config['site_url']; ?>/delete/<?= $this->file['delete_id']; ?>/<?= $this->file['file_id']; ?>/<?= $this->file['file_name']; ?>" style="width:430px;font-size:9px;" onClick="this.focus();this.select();" /></td> 
					</tr> 
				</table>
</fieldset>
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