<?php include $this->template('header.tpl.php') ?>
<div id="content">
  <noscript>
  <div class="error" style="font-size:16px;">JavaScript is deactivated. Please activate Javascript!</div>
  </noscript>
  <br />
  <br />
  <div class="box">
    <h1>Privacy Policy</h1>
    <br clear="all">
    Agreement regarding confidentiality. <br />
    <br />
    <b>IP addresses of users</b><br />
    Our servers can detect the IP address of your browser according to Internet-technology. This IP address is registered by <?= $this->config['site_name']; ?> servers especially for our internal use (registration of use, optimal downloads use and so on).<br />
    <br />
    <b>E-mail</b><br />
    Our server writes in the register of <?= $this->config['site_name']; ?> users e-mails only for their registration and calculation. Under no circumstances will <?= $this->config['site_name']; ?> lease, sell, or provide your personal information to any companies.<br />
    <br />
    <b>Cookies use.</b><br />
    <?= $this->config['site_name']; ?> uses cookies for the users comfort in order to save the browser settings. <?= $this->config['site_name']; ?> does not any methods for tracking users (the so-called &quot;spy&quot; or &quot;1x1&quot; gif images and so on).<br />
    <br />
    <b>Safe operation with files.</b><br />
    We have taken the appropriate security measures at the servers physical location to protect from loss, incorrect usage, or change of information provided to us by the users of the service. Files, saved for delivery can be accessible only to <?= $this->config['site_name']; ?> representatives or via a link provided to the recipient. All files saved by our service are deleted after a certain time period if you do not delete them yourself.<br />
    <br />
    <b>Credit card information.</b><br />
    All purchases on <?= $this->config['site_name']; ?> are handled by a third paryt pay system - Paypal.com. in which the transferred information thereof is encrypted. <?= $this->config['site_name']; ?> does not arrange and save numbers or any information from your credit card.<br />
    <br />
    <b>Advertisements.</b><br />
    Advertisements located on our website can be posted by third party advertisement firm. These companies can use the information regarding your visits on these or other web pages (your name, address, e-mail, and phone number are excluded) to place an advertisement of wares and services that might be interesting to you.<br />
    <p> <b>NOTE.</b><br/>
      We can disclose your personal information in case it becomes necessary to defend our juridical rights.</br>
      Especially if your information is connected with tangible or assumed saboteur actions or poses a potential threat to any persons physical safety.</br>
      Disclosure of your information can be lawful or as a result of a legal process.</br>
    </p>
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