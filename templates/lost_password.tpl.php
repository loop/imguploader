<?php include $this->template('header.tpl.php') ?>

<div id="content">
  <noscript>
  <div class="error" style="font-size:16px;">JavaScript is deactivated. Please activate Javascript!</div>
  </noscript>
  <br />
  <br />
  <div class="box">
    <h1 style="text-align:left;">Lost Password Form</h1>
    <?php if($this->is_error != 0): ?><div class="error"><?= $this->message ?></div><?php endif; ?>
    <?php if($this->is_success == 1): ?><div class="success"><?= $this->message ?></div><?php endif; ?>
    <form action="./lostpassword.php" method="post">
      <table style="border:none;">
        <tr>
          <td style="text-align:right;">Email:</td>
          <td style="text-align:left;"><input type="text" name="email" value="<?= $this->eprint($_POST['email']); ?>" style="width:300px;" /></td>
        </tr>
        <tr>
          <td></td>
          <td><input type="submit" value="Reset" name="submit" class="upload" /></td>
        </tr>
      </table>
      <input type="hidden" name="task" value="doreset" />
    </form>
  </div>
</div>
<?php include $this->template('footer.tpl.php') ?>
