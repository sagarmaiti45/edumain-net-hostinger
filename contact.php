<?php
require_once __DIR__ . '/config.php';
$page_title = 'Contact EduMain';
$page_desc  = 'Get in touch with the EduMain team for questions, feedback, or topic suggestions.';
$body_class = 'page-contact';
include '_header.php';
?>
<div class="legal-page">
  <nav class="legal-breadcrumb">
    <a href="/">Home</a> <span>›</span> <span>Contact</span>
  </nav>
  <h1>Contact Us</h1>
  <p>Got a question, spotted a mistake, or want to suggest a topic we should cover? We'd love to hear from you. EduMain is a small team and your feedback genuinely helps us improve.</p>

  <h2>Email</h2>
  <p>The best way to reach us is by email at <a href="mailto:<?= CONTACT_EMAIL ?>"><?= CONTACT_EMAIL ?></a>. We usually reply within 1-2 days.</p>

  <h2>What to Include</h2>
  <p>To help us reply faster, please include:</p>
  <ul>
    <li>What your question or issue is</li>
    <li>Which page or topic you're asking about</li>
    <li>Your browser and device if you're reporting a bug</li>
  </ul>

  <h2>Topic Suggestions</h2>
  <p>Want us to cover a topic that isn't on EduMain yet? Email us the subject and topic name and we'll add it to our list.</p>

  <div class="legal-contact-box">
    <p>Email us at</p>
    <a href="mailto:<?= CONTACT_EMAIL ?>"><?= CONTACT_EMAIL ?></a>
  </div>

</div><!-- /legal-page -->
<?php include '_footer.php'; ?>
