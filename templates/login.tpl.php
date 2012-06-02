<?php include $this->template('header.tpl.php') ?>

<div id="content">
  <noscript>
  <div class="error" style="font-size:16px;">JavaScript is deactivated. Please activate Javascript!</div>
  </noscript>
  <br />
  <br />
  <div class="box">
    <h1 style="text-align:left;">Login</h1>
    <?php if($this->is_error != 0): ?><div class="error"><?= $this->error_message ?></div><?php endif; ?>
    <form action="./login.php" method="post">
      <table style="border:none;">
        <tr>
          <td style="text-align:right;">Username:</td>
          <td style="text-align:left;"><input type="text" name="user" value="<?= $this->eprint($_POST['email']); ?>" style="width:300px;" /></td>
        </tr>
        <tr>
          <td style="text-align:right;">Password:</td>
          <td style="text-align:left;"><input type="password" name="pass" style="width:300px;" /></td>
        </tr>
        <tr>
          <td></td>
          <td><input type="submit" value="Login" name="submit" class="upload" /></td>
        </tr>
        <tr>
          <td></td>
          <td style="text-align:right;"><a href="./lostpassword.php">Lost Password?</a></td>
        </tr>
      </table>
      <input type="hidden" name="task" value="dologin" />
      <input type="hidden" name="return" value="<?php if($_SERVER['REQUEST_URI'] != "/login.php"){ echo $this->eprint($_SERVER['REQUEST_URI']); }else{ echo "./members/myfiles.php"; } ?>" />
    </form>
  </div>
</div>
<?php include $this->template('footer.tpl.php') ?>
