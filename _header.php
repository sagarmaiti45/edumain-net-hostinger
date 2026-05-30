<?php
require_once __DIR__ . '/config.php';
$_subjects = json_decode(SUBJECTS, true);
$_uri = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($page_title ?? SITE_NAME . ' - ' . SITE_TAGLINE) ?></title>
  <meta name="description" content="<?= htmlspecialchars($page_desc ?? SITE_DESCRIPTION) ?>">
  <meta name="keywords" content="<?= META_KEYWORDS ?>">
  <meta name="robots" content="<?= $robots ?? 'index, follow' ?>">
  <?php
  $_canonical = SITE_URL . strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
  $_og_title  = htmlspecialchars($page_title ?? SITE_NAME);
  $_og_desc   = htmlspecialchars($page_desc ?? SITE_DESCRIPTION);
  $_og_type   = ($body_class ?? '') === 'page-topic' ? 'article' : 'website';
  ?>
  <meta property="og:title" content="<?= $_og_title ?>">
  <meta property="og:description" content="<?= $_og_desc ?>">
  <meta property="og:type" content="<?= $_og_type ?>">
  <meta property="og:url" content="<?= $_canonical ?>">
  <meta property="og:image" content="<?= SITE_URL ?>/assets/img/logo.png">
  <meta property="og:site_name" content="<?= SITE_NAME ?>">
  <meta name="twitter:card" content="summary">
  <meta name="twitter:title" content="<?= $_og_title ?>">
  <meta name="twitter:description" content="<?= $_og_desc ?>">
  <link rel="canonical" href="<?= $_canonical ?>">
  <?php if ($_og_type === 'article' && isset($topic)): ?>
  <script type="application/ld+json">{"@context":"https://schema.org","@type":"Article","headline":"<?= addslashes($page_title ?? '') ?>","description":"<?= addslashes($page_desc ?? '') ?>","url":"<?= $_canonical ?>","publisher":{"@type":"Organization","name":"<?= SITE_NAME ?>","url":"<?= SITE_URL ?>"},"dateModified":"<?= date('Y-m-d') ?>"}</script>
  <?php elseif ($_uri === '/'): ?>
  <script type="application/ld+json">{"@context":"https://schema.org","@type":"WebSite","name":"<?= SITE_NAME ?>","url":"<?= SITE_URL ?>","description":"<?= addslashes(SITE_DESCRIPTION) ?>"}</script>
  <?php endif; ?>
  <link rel="icon" type="image/png" href="/assets/img/logo.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"></noscript>
  <link rel="preconnect" href="https://cdnjs.cloudflare.com">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/fontawesome.min.css" media="print" onload="this.media='all'">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/solid.min.css" media="print" onload="this.media='all'">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/regular.min.css" media="print" onload="this.media='all'">
  <noscript>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/solid.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/regular.min.css">
  </noscript>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/7.2.3/css/flag-icons.min.css" media="print" onload="this.media='all'">
  <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/7.2.3/css/flag-icons.min.css"></noscript>
  <link rel="stylesheet" href="/assets/css/style.css?v=5">
  <style>
    :root {
      --bg:          <?= COLOR_BG ?>;
      --bg2:         <?= COLOR_BG2 ?>;
      --bg3:         <?= COLOR_BG3 ?>;
      --card:        <?= COLOR_CARD ?>;
      --card-hover:  <?= COLOR_CARD_HOVER ?>;
      --accent:      <?= COLOR_ACCENT ?>;
      --accent2:     <?= COLOR_ACCENT2 ?>;
      --text:        <?= COLOR_TEXT ?>;
      --text-muted:  <?= COLOR_TEXT_MUTED ?>;
      --border:      <?= COLOR_BORDER ?>;
    }
  </style>
  <script>
  if (localStorage.getItem('sc_cookie_consent') === '1') {
    <?php if (!empty(GA_ID)): ?>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);} window.gtag = gtag;
    gtag('js', new Date()); gtag('config', '<?= GA_ID ?>');
    var gs = document.createElement('script'); gs.async = true;
    gs.src = 'https://www.googletagmanager.com/gtag/js?id=<?= GA_ID ?>';
    document.head.appendChild(gs);
    <?php endif; ?>
  }
  // Restore font size immediately
  (function(){ var s = parseInt(localStorage.getItem('em_font') || '0', 10); if (s) document.documentElement.style.fontSize = (16 + s * 1.5) + 'px'; })();
  </script>
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8260668593000194" crossorigin="anonymous"></script>
</head>
<body class="<?= $body_class ?? '' ?>">

<header class="site-header">
  <div class="header-inner">
    <a href="/" class="logo">
      <i class="fa-solid fa-graduation-cap logo-hat-icon"></i>
      <span class="logo-text">Edu<span class="logo-accent">Main</span></span>
    </a>

    <div class="header-right">
      <nav class="header-nav" id="header-nav" aria-label="Subjects">
        <?php
        $subjects_limited = array_slice($_subjects, 0, 5);
        foreach ($subjects_limited as $s): ?>
        <a href="/<?= $s['slug'] ?>"
           class="nav-subj<?= ($_uri === '/' . $s['slug'] || str_starts_with($_uri, '/' . $s['slug'] . '/')) ? ' active' : '' ?>"
           style="--sc:<?= $s['color'] ?>">
          <i class="fa-solid <?= $s['icon'] ?>"></i>
          <span><?= $s['name'] ?></span>
        </a>
        <?php endforeach; ?>
        <div class="nav-more-wrap" id="nav-more-wrap">
          <button class="nav-more-btn" id="nav-more-btn" aria-label="More subjects">···</button>
          <div class="nav-more-dropdown" id="nav-more-dropdown">
            <?php foreach (array_slice($_subjects, 5) as $s): ?>
            <a href="/<?= $s['slug'] ?>"
               class="nav-subj<?= ($_uri === '/' . $s['slug'] || str_starts_with($_uri, '/' . $s['slug'] . '/')) ? ' active' : '' ?>"
               style="--sc:<?= $s['color'] ?>">
              <i class="fa-solid <?= $s['icon'] ?>"></i>
              <span><?= $s['name'] ?></span>
            </a>
            <?php endforeach; ?>
          </div>
        </div>
      </nav>

      <form action="/search" method="get" class="header-search-form" role="search">
        <input type="search" name="q" placeholder="Search topics…" class="header-search"
               value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" autocomplete="off">
        <button type="submit" class="header-search-btn" aria-label="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
      </form>
      <button class="mob-menu-btn" id="mob-menu-btn" aria-label="Open menu">
        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
      </button>
    </div>
  </div>
</header>

<!-- Mobile nav sidebar -->
<div class="mob-nav" id="mob-nav" aria-label="Mobile navigation">
  <div class="mob-nav-head">
    <span class="logo-text">Edu<span class="logo-accent">Main</span></span>
    <button class="mob-nav-close" id="mob-nav-close" aria-label="Close menu">
      <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"/></svg>
    </button>
  </div>
  <div class="mob-nav-search">
    <form action="/search" method="get" role="search">
      <input type="search" name="q" placeholder="Search topics…" autocomplete="off">
      <button type="submit" aria-label="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
  </div>
  <nav class="mob-nav-links">
    <?php foreach ($_subjects as $s): ?>
    <a href="/<?= $s['slug'] ?>"
       style="--sc:<?= $s['color'] ?>"
       <?= ($_uri === '/' . $s['slug'] || str_starts_with($_uri, '/' . $s['slug'] . '/')) ? 'class="active"' : '' ?>>
      <i class="fa-solid <?= $s['icon'] ?>"></i><?= $s['name'] ?>
    </a>
    <?php endforeach; ?>
    <div class="mob-nav-divider"></div>
    <a href="/about"><i class="fa-solid fa-circle-info"></i>About</a>
    <a href="/contact"><i class="fa-solid fa-envelope"></i>Contact</a>
  </nav>
</div>
<div class="mob-overlay" id="mob-overlay"></div>

<div class="page-wrap">
