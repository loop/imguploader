<?php include $this->template('header.tpl.php') ?>
<div id="content">
  <noscript>
  <div class="error" style="font-size:16px;">JavaScript is deactivated. Please activate Javascript!</div>
  </noscript>
  <br />
  <br />
  <div class="box">
    <h1>FAQ</h1>
    <br clear="all">
    <table style="border:none;">
      <tr>
        <td class="column1"><a href="javascript:changeFAQ(1);"><img src="./assets/images/plus.gif" id="img-13" /> <b>What is <?= $this->config['site_name']; ?>?</b></a><br />
          <div id="faq-1" style="display:none;margin-left:20px;"><br />
            <?= $this->config['site_name']; ?> is a one click online image hosting service to provide people with an easy way to share their images accross the net.<br />
          </div></td>
      </tr>
      <tr>
        <td class="column1"><a href="javascript:changeFAQ(2);"><img src="./assets/images/plus.gif" id="img-11" /> <b>Do you delete inactive images?</b></a><br />
          <div id="faq-2" style="display:none;margin-left:20px;"><br />
            Yes, after 120 days of inactivity.<br />
            <br />
          </div></td>
      </tr>
      <tr>
        <td class="column1"><a href="javascript:changeFAQ(3);"><img src="./assets/images/plus.gif" id="img-11" /> <b>How many images can i upload at once?</b></a><br />
          <div id="faq-3" style="display:none;margin-left:20px;"><br />
           You can upload up to 5 images at a time using our multi image uploader.<br />
            <br />
          </div></td>
      </tr>
    </table>
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