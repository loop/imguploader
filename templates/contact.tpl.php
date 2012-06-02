<?php include $this->template('header.tpl.php') ?>
<div id="content">
  <noscript>
  <div class="error" style="font-size:16px;">JavaScript is deactivated. Please activate Javascript!</div>
  </noscript>
  <br />
  <br />
  <div class="box">
    <h1>Contact Us</h1>
    <br clear="all">
    <?php if($this->sent != 1): ?>
    <?php if($this->is_error != 0): ?><div class="error"><?= $this->error_message ?></div><?php endif; ?>
    <form action="./help/contact.php" method="post">
      <table style="border:none;margin:auto;">
        <tr>
          <td style="text-align:right;">Full Name:*</td>
          <td style="text-align:left;"><input type="text" name="name" value="<?= $this->eprint($_POST['name']); ?>" style="width:400px;" /></td>
        </tr>
        <tr>
          <td style="text-align:right;">Email:*</td>
          <td style="text-align:left;"><input type="text" name="email" value="<?= $this->eprint($_POST['email']); ?>" style="width:400px;" /></td>
        </tr>
        <tr>
          <td style="text-align:right;">Department:*</td>
          <td style="text-align:left;"><select name="dep" style="width:407px;">
              <option value="contact">General</option>
              <option value="support">Technical</option>
              <option value="sales">Premium Accounts</option>
              <option value="abuse">Abuse</option>
              <option value="contact">Other</option>
            </select></td>
        </tr>
        <tr>
          <td style="text-align:right;">Message:*</td>
          <td style="text-align:left;"><textarea name="message" rows="8" style="width:400px;"><?= $this->eprint($_POST['message']); ?></textarea></td>
        </tr>
        <tr>
          <td style="text-align:right;">Solve:</td>
          <td style="text-align:left;"><img src="./captcha.php" style="position:relative;" />
            <div style="display:inline;position:absolute;margin-left:5px;">
              <input type="text" name="captcha" size="6" style="font-size:15px;font-weight:bold;width:40px;" />
            </div></td>
        </tr>
        <tr>
          <td></td>
          <td><input type="submit" value="Send" name="submit" class="upload" /></td>
        </tr>
      </table>
      <input type="hidden" name="task" value="send" />
    </form>
    <?php else: ?>
    <div class="success">Message successfully sent.</div>
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