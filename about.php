<?php
require_once __DIR__ . '/config.php';
$page_title = 'About EduMain - Free School Topic Explainers';
$page_desc  = 'EduMain is a free educational website covering school topics for students aged 6-16 in the USA, UK, Australia and Spain.';
$body_class = 'page-about';
include '_header.php';
?>
<div class="legal-page">
  <nav class="legal-breadcrumb">
    <a href="/">Home</a> <span>›</span> <span>About</span>
  </nav>
  <h1>About EduMain</h1>
  <p>EduMain is a free educational website built for school students aged 6-16. It covers core school subjects with clear, simple explainers - no jargon, no ads that get in the way, and nothing to download or pay for.</p>

  <h2>What EduMain Covers</h2>
  <p>We cover 10 school subjects: Maths, Science, History, English, Geography, Art, Music, Computing, PE, and Languages. Each topic includes a plain-English introduction, key facts, and a quick quiz so you can test yourself.</p>
  <p>Topics are tagged by year group and difficulty (Easy / Medium / Hard) so you can find exactly what matches your school level.</p>

  <h2>Which Countries?</h2>
  <p>EduMain is designed for students in the <strong>USA</strong>, <strong>UK</strong>, <strong>Australia</strong>, and <strong>Spain</strong>. Curriculum topics are chosen to reflect what students in those countries study at school.</p>

  <h2>Who Made It?</h2>
  <p>EduMain is an independent project built to make school learning a little easier and more accessible. We believe every student deserves clear, free explanations of what they are learning in class.</p>

  <h2>Contact</h2>
  <p>Questions, suggestions, or spotted an error? Email us at <a href="mailto:<?= CONTACT_EMAIL ?>"><?= CONTACT_EMAIL ?></a> or use the <a href="/contact">contact page</a>.</p>

</div><!-- /legal-page -->
<?php include '_footer.php'; ?>
