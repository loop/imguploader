<?php include $this->template('header.tpl.php') ?>
<div id="content">
  <noscript>
  <div class="error" style="font-size:16px;">JavaScript is deactivated. Please activate Javascript!</div>
  </noscript>
  <br />
  <br />
  <div class="box">
    <h1 style="text-align:left;">Register</h1>
    <?php if($this->is_error != 0): ?><div class="error"><?= $this->error_message ?></div><?php endif; ?>
    <form action="./register.php" method="post">
      <table style="border:none;">
        <tr>
          <td style="text-align:right;">Username:*</td>
          <td style="text-align:left;"><input type="text" name="username" value="<?= $this->eprint($_POST['username']); ?>" style="width:300px;" /></td>
        </tr>
        <tr>
          <td style="text-align:right;">e-Mail:*</td>
          <td style="text-align:left;"><input type="text" name="email" value="<?= $this->eprint($_POST['email']); ?>" style="width:300px;" /></td>
        </tr>
        <tr>
          <td style="text-align:right;">Password:*</td>
          <td style="text-align:left;"><input type="password" name="pass" style="width:300px;" /></td>
        </tr>
        <tr>
          <td style="text-align:right;">Confirm Password:*</td>
          <td style="text-align:left;"><input type="password" name="pass2" style="width:300px;" /></td>
        </tr>
        <tr>
          <td style="text-align:right;">Captcha:*</td>
          <td style="text-align:left;"><img src="./captcha.php?c=<?= rand(15, 999); ?>" style="position:relative;" />
            <div style="display:inline;position:absolute;margin-left:5px;">
              <input type="text" name="captcha" size="6" style="font-size:15px;font-weight:bold;width:90px;" />
            </div></td>
        </tr>
        <tr>
          <td></td>
          <td><input type="submit" value="Register" name="submit" class="upload" /></td>
        </tr>
      </table>
      <input type="hidden" name="task" value="doregister" />
    </form>
  </div>
</div>
<?php include $this->template('footer.tpl.php') ?>