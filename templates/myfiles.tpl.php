<?php include $this->template('header.tpl.php') ?>
<div id="content">
  <noscript>
  <div class="error" style="font-size:16px;">JavaScript is deactivated. Please activate Javascript!</div>
  </noscript>
  <div class="box" style="text-align:center">
    <h1 style="text-align:left;">Sponsor</h1>
    <script type="text/javascript">
	<!--
	google_ad_client = "<?= $this->config['adsense_pub_id']; ?>";
	google_ad_width = 468;
	google_ad_height = 60;
	//-->
    </script>
	<script type="text/javascript"src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
  </div>
  <div class="box">
    <table width="100%" class="normal" id="searchtable" border="0" cellspacing="4" cellpadding="0">
      <tr>
        <td width="20%"><input name="search" type="text" id="search" style="display:none;" class="upload" /></td>
        <td width="20%">Search Form</td>
        <td width="60%"><div id="loader" style="display:none;"><img src="./assets/images/loader.gif" alt="" /></div></td>
      </tr>
    </table>
    <br clear="all" />
    <table width="100%" id="table1" class="advancedtable" border="0" cellspacing="0" cellpadding="0">
      <thead>
        <tr>
          <th>Image</th>
          <th>Size</th>
          <th>Uploade Date</th>
          <th>Views</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if($this->total != 0): while($row = mysql_fetch_array($this->result)): ?>
        <tr align="center">
          <td><a href="<?= $this->config['site_url']; ?>/view/<?= $row['file_id']; ?>/<?= $row['file_name']; ?>" title="<?= $row['file_name']; ?>" target="_blank"><img src="./get-thumb.php?id=<?= $row['file_id']; ?>&size=Small" width="60" height="60" style="border:1px solid #999;" /></a></td>
          <td><?= format_size($row['file_size']); ?></td>
          <td><?= date("d-m-Y", $row['upload_date']); ?></td>
          <td><?= $row['views']; ?></td>
          <td><a href="./members/links/<?= $row['file_id']; ?>/<?= $row['file_name']; ?>" title="Get Links" target="_blank"><img src="./assets/images/link.png" title="Get Links" /></a> <a href="#"><img src="./assets/images/edit.png" title="Rename" /></a> <a href="./members/delete/<?= $row['delete_id']; ?>/<?= $row['file_id']; ?>/<?= $row['file_name']; ?>.html"><img src="./assets/images/remove.png" title="Delete" /></a></td>
        </tr>
        <?php endwhile; else: ?>
        <tr>
          <td colspan="6" align="center">You have not uploaded any images yet.</td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <div class="box" style="text-align:center">
    <h1 style="text-align:left;">Sponsor</h1>
    <script type="text/javascript">
	<!--
	google_ad_client = "<?= $this->config['adsense_pub_id']; ?>";
	google_ad_width = 468;
	google_ad_height = 60;
	//-->
    </script>
	<script type="text/javascript"src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
  </div>
</div>
<?php include $this->template('footer.tpl.php') ?>