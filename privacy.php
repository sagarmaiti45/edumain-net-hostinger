<?php
require_once __DIR__ . '/config.php';
$page_title = 'Privacy Policy - EduMain';
$page_desc  = 'Read the EduMain.net privacy policy to understand how we collect, use, and protect your data when you use our free online calculator and math tools.';
$body_class = 'page-inner';
include '_header.php';
?>
<div class="legal-page">
  <nav class="legal-breadcrumb">
    <a href="/">Home</a> <span>›</span> <span>Privacy Policy</span>
  </nav>
  <h1>Privacy Policy</h1>
  <p><strong>Last updated:</strong> March <?= SITE_YEAR ?></p>
  <p>EduMain ("<strong>we</strong>", "<strong>our</strong>", or "<strong>us</strong>") runs <?= SITE_URL ?>. This page explains what data we collect and how we use it.</p>

  <h2>What We Collect</h2>
  <p>We do not collect personally identifiable information. All calculations run in your browser and nothing you type is sent to our servers.</p>
  <p>Our server logs basic access data like IP address, browser type, and pages visited. This is standard for any website and is used only for security and keeping the site running. This data is not linked to any identity and is never sold.</p>

  <h2>Cookies</h2>
  <p>We only load analytics and advertising cookies after you accept them through the consent banner on your first visit. If you decline, no tracking cookies are set. You can change your mind by clearing your browser's local storage for this site.</p>
  <p>If you accept cookies, two third-party services may be active:</p>
  <ul>
    <li><strong>Google Analytics</strong> collects anonymised data like pages visited and session duration. This helps us understand how the site is used. You can opt out with the <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener noreferrer">Google Analytics Opt-out Add-on</a>. Data is handled under <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer">Google's Privacy Policy</a>.</li>
    <li><strong>Google AdSense</strong> shows ads that help keep the site free. Google may use cookies based on your browsing history to show relevant ads. You can manage this at <a href="https://adssettings.google.com" target="_blank" rel="noopener noreferrer">Google Ad Settings</a> or opt out at <a href="https://www.aboutads.info/choices/" target="_blank" rel="noopener noreferrer">AboutAds.info</a>.</li>
  </ul>

  <h2>How We Use Data</h2>
  <p>We use aggregate analytics data to improve the site, for example to see which tools get used most or how pages load on mobile. We do not use any data for anything outside of running and improving EduMain.</p>

  <h2>Third-Party Links</h2>
  <p>The site may link to external pages. We are not responsible for how those sites handle your data, so check their policies if needed.</p>

  <h2>Your Rights</h2>
  <p>If you are in the EU or California, you have rights around your personal data. Since we do not hold any personally identifiable information, there is nothing for us to act on from our side. For data held by Google, use their <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer">privacy controls</a>.</p>

  <h2>Changes</h2>
  <p>If we update this policy, the new version will be posted here with an updated date at the top.</p>

  <h2>Contact</h2>
  <p>Questions? Email us at <a href="mailto:<?= CONTACT_EMAIL ?>"><?= CONTACT_EMAIL ?></a>.</p>

</div><!-- /legal-page -->
<?php include '_footer.php'; ?>
