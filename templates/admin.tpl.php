<?php include $this->template('header_admin.tpl.php') ?>
<div id="content" style="width:700px">
  <?php if($this->task == "main"): ?>
  <div class="box">
    <h1>Quick Stats</h1>
    <br clear="all">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center"><table width="400" border="0" cellspacing="0" cellpadding="0" style="border:none">
      <tr>
        <td>Registered Members:</td>
        <td><?= $this->total_members; ?></td>
      </tr>
      <tr>
        <td>Files Hosted:</td>
        <td><?= $this->total_files; ?></td>
      </tr>
      <tr>
        <td>Space Used:</td>
        <td><?= format_size($this->total_space); ?></td>
      </tr>
    </table></td>
      </tr>
    </table>
    <br clear="all">
  </div>
  <?php elseif($this->task == "users"): ?>
  <div class="box">
    <table width="100%" class="normal" id="searchtable" border="0" cellspacing="4" cellpadding="0">
      <tr>
        <td width="20%"><input name="search" type="text" id="search" style="display:none;" class="upload" /></td>
        <td width="20%">Search Form</td>
        <td width="60%"><div id="loader" style="display:none;"><img src="./assets/images/loader.gif" alt="" /></div></td>
      </tr>
    </table>
    <br clear="all" />
    <?php if(isset($_GET['success']) && $_GET['success'] == 1): ?><div class="success">User successfully deleted.</div><?php endif; ?>
    <table width="100%" id="table1" class="advancedtable" border="0" cellspacing="0" cellpadding="0">
      <thead>
        <tr>
          <th>Username</th>
          <th>Email</th>
          <th>Registered</th>
          <th>Files</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = mysql_fetch_array($this->result)): ?>
        <tr>
          <td><?= $row['user_name']; ?></td>
          <td><a href="mailto:<?= $row['user_email']; ?>">
            <?= $row['user_email']; ?>
            </a></td>
          <td><?= date("d-m-Y", $row['user_signup']); ?></td>
          <td><?= $this->user->file_count($row['user_id']); ?></td>
          <td><a href="./adm.php?m=users&task=delete&u=<?= $row['user_id']; ?>" onclick="return confirm('Delete?');"><img src="./assets/images/remove.png" /></a></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
  <?php elseif($this->task == "files"): ?>
  <div class="box">
    <?php if(isset($_GET['success']) && $_GET['success'] == 1): ?><div class="success">Image successfully deleted.</div><?php endif; ?>
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
          <th>Owner</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = mysql_fetch_array($this->result)): ?>
        <tr align="center">
          <td><a href="<?= $this->config['site_url']; ?>/view/<?= $row['file_id']; ?>/<?= $row['file_name']; ?>" title="<?= $row['file_name']; ?>" target="_blank"><img src="./get-thumb.php?id=<?= $row['file_id']; ?>&size=Small" width="60" height="60" style="border:1px solid #999;" /></a></td>
          <td><?= format_size($row['file_size']); ?></td>
          <td><?= date("d-m-Y", $row['upload_date']); ?></td>
          <td><?= $row['views']; ?></td>
          <td><?= $this->user->get_username($row['upload_owner']); ?></td>
          <td><a href="./adm.php?m=files&task=delete&f=<?= $row['file_id']; ?>" onclick="return confirm('Delete?');"><img src="./assets/images/remove.png" /></a></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
  <?php elseif($this->task == "site_logs"): ?>
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
          <th>Action</th>
          <th>Description</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        <?php if($this->total != 0): while($row = mysql_fetch_array($this->result)): ?>
        <tr>
          <td><?= $row['action']; ?></td>
          <td><?= $row['action_text']; ?></td>
          <td><?= date("d-m-Y", $row['action_date']); ?></td>
        </tr>
        <?php endwhile; else: ?>
        <tr>
          <td colspan="3"><p align="center">No logs available to view.</p></td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>
<?php include $this->template('footer.tpl.php') ?>