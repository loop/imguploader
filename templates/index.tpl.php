<?php include $this->template('header.tpl.php') ?>
<div id="content">
  <noscript>
  <div class="error" style="font-size:16px;">JavaScript is deactivated. Please activate Javascript!</div>
  </noscript>
  <br />
  <br />
  <div class="box">
    <h1>Upload</h1>
    <br clear="all">
    <p align="center" id="choose"><strong>Choose a File:</strong> (max. <?= format_size($this->_CONFIG['max_upload_size']); ?>)</p>
    <div id="uploader_alert"></div>
    <!-- begin progress bar -->
    <div id="progress_bar_container">
      <div id="progress_bar_background">
        <div id="progress_bar">
          <div id="percent_complete">&nbsp;</div>
        </div>
      </div>
    </div>
    <br clear="all">
    <!-- end progress bar -->
    <div id="upload_container"></div>
    <!-- start upload form -->
    <form id="upload_form" name="upload_form" method="post" enctype="multipart/form-data" action="#" onSubmit="return Uploader.linkUpload();">
      <div id="file_picker_container"></div>
      <div id="upload_slots_container"></div>
      <div id="upload_form_values_container">
        <!-- Add Your Form Values Here -->
      </div>
      <div id="upload_buttons_container">
        <input type="button" id="reset_button" name="reset_button" value="Reset" class="upload">
        &nbsp;&nbsp;&nbsp;
        <input type="submit" id="upload_button" name="upload_button" value="Upload" class="upload">
      </div>
    </form>
    <br clear="all">
    <!-- end upload form -->
  </div>
  <div class="box" style="text-align:center">
    <h1>Recent Uploads</h1>
    <?php if($this->num): ?>
    <?php foreach($this->image_array as $image): ?>
    <a href="./view/<?= $image['file_id']; ?>/<?= $image['file_name']; ?>"><img src="./get-thumb.php?id=<?= $image['file_id']; ?>&size=Small" alt="<?= $image['file_name']; ?>" style="border:1px solid #999;" width="125" height="125" /></a>
    <?php endforeach; ?>
    <?php else: ?>
    No recent uploads to display.
    <?php endif; ?>
  </div>
</div>
<?php include $this->template('footer.tpl.php') ?>