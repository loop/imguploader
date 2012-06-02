<?php include $this->template('header.tpl.php') ?>
<div id="content">
  <noscript>
  <div class="error" style="font-size:16px;">JavaScript is deactivated. Please activate Javascript!</div>
  </noscript>
  <br />
  <br />
  <div class="box">
    <h1 style="text-align:left;">Manage Your Account</h1>
    <?php if($this->is_error != 0): ?><div class="error"><?= $this->message ?></div><?php endif; ?>
    <?php if($this->is_success != 0): ?><div class="success"><?= $this->message ?></div><?php endif; ?>
    <form action="./account.php" method="post">
      <table style="border:none;">
        <tr>
          <td style="text-align:right;">Username:</td>
          <td style="text-align:left;"><input type="text" name="username" value="<?= $this->user->user_info['user_name']; ?>" style="width:300px;" readonly="readonly" /></td>
        </tr>
        <tr>
          <td style="text-align:right;">e-Mail:</td>
          <td style="text-align:left;"><input type="text" name="email" value="<?= $this->user->user_info['user_email']; ?>" style="width:300px;" /></td>
        </tr>
        <tr>
          <td style="text-align:right;">New Password:</td>
          <td style="text-align:left;"><input type="password" name="pass" style="width:300px;" /></td>
        </tr>
        <tr>
          <td style="text-align:right;">Confirm Password:</td>
          <td style="text-align:left;"><input type="password" name="pass2" style="width:300px;" /></td>
        </tr>
        <tr>
          <td style="text-align:right;">API Key:</td>
          <td style="text-align:left;"><input type="text" style="width:300px;" disabled="disabled" value="<?= $this->api_key; ?>" /> <a href="./account.php?task=get_api_key">Get API Key</a></td>
        </tr>
        <tr>
          <td></td>
          <td><input type="submit" value="Update" name="submit" class="upload" /></td>
        </tr>
      </table>
      <input type="hidden" name="task" value="doupdate" />
    </form>
  </div>
</div>
<?php include $this->template('footer.tpl.php') ?>