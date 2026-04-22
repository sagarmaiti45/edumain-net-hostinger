<?php
require_once __DIR__ . '/config.php';
http_response_code(404);
$page_title = '404 - Page Not Found | ' . SITE_NAME;
$page_desc  = 'The page you are looking for could not be found.';
$body_class = 'page-404';
$robots     = 'noindex, nofollow';
include '_header.php';
?>
<div class="static-page" style="text-align:center; padding: 80px 20px;">
  <div style="font-size:5rem; margin-bottom:16px;">📚</div>
  <h1 style="font-size:2.5rem; font-weight:900; color:var(--text); margin-bottom:12px;">Page Not Found</h1>
  <p style="font-size:1rem; color:var(--text-m); max-width:420px; margin:0 auto 28px;">
    Oops! That page doesn't exist. It may have moved or been removed. Head back home and explore our school topics.
  </p>
  <a href="/" style="display:inline-block; background:var(--accent); color:#fff; padding:12px 32px; border-radius:25px; font-weight:800; font-size:0.95rem; text-decoration:none;">
    Back to Home
  </a>
  <div style="margin-top:40px; display:flex; justify-content:center; gap:12px; flex-wrap:wrap; font-size:0.85rem;">
    <a href="/math" style="color:var(--accent); font-weight:700;">Math Topics</a>
    <a href="/science" style="color:var(--accent); font-weight:700;">Science Topics</a>
    <a href="/history" style="color:var(--accent); font-weight:700;">History Topics</a>
    <a href="/search" style="color:var(--accent); font-weight:700;">Search All Topics</a>
  </div>
</div>
<?php include '_footer.php'; ?>
