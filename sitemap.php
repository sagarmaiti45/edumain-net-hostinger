<?php
require_once __DIR__ . '/config.php';

$type = $_GET['type'] ?? 'index';

header('Content-Type: application/xml; charset=utf-8');
header('X-Robots-Tag: noindex');

$today      = date('Y-m-d');
$last_month = date('Y-m-d', strtotime('-30 days'));

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";

// ── INDEX ──────────────────────────────────────────────────────────────
if ($type === 'index') { ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <sitemap>
    <loc><?= SITE_URL ?>/sitemap-static.xml</loc>
    <lastmod><?= $today ?></lastmod>
  </sitemap>
  <sitemap>
    <loc><?= SITE_URL ?>/sitemap-tools.xml</loc>
    <lastmod><?= $today ?></lastmod>
  </sitemap>
  <sitemap>
    <loc><?= SITE_URL ?>/sitemap-topics.xml</loc>
    <lastmod><?= $last_month ?></lastmod>
  </sitemap>
</sitemapindex>
<?php return; }

// ── STATIC PAGES ───────────────────────────────────────────────────────
if ($type === 'static') {
  $subjects = json_decode(SUBJECTS, true);
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url><loc><?= SITE_URL ?>/</loc><lastmod><?= $today ?></lastmod><changefreq>daily</changefreq><priority>1.0</priority></url>
  <url><loc><?= SITE_URL ?>/math-tools</loc><lastmod><?= $today ?></lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>
<?php foreach ($subjects as $s): if ($s['slug'] === 'math-tools') continue; ?>
  <url><loc><?= SITE_URL ?>/<?= $s['slug'] ?></loc><lastmod><?= $today ?></lastmod><changefreq>weekly</changefreq><priority>0.85</priority></url>
<?php endforeach; ?>
  <url><loc><?= SITE_URL ?>/search</loc><lastmod><?= $today ?></lastmod><changefreq>monthly</changefreq><priority>0.6</priority></url>
  <url><loc><?= SITE_URL ?>/about</loc><lastmod><?= $last_month ?></lastmod><changefreq>monthly</changefreq><priority>0.5</priority></url>
  <url><loc><?= SITE_URL ?>/contact</loc><lastmod><?= $last_month ?></lastmod><changefreq>monthly</changefreq><priority>0.4</priority></url>
  <url><loc><?= SITE_URL ?>/privacy</loc><lastmod><?= $last_month ?></lastmod><changefreq>yearly</changefreq><priority>0.3</priority></url>
  <url><loc><?= SITE_URL ?>/terms</loc><lastmod><?= $last_month ?></lastmod><changefreq>yearly</changefreq><priority>0.3</priority></url>
  <url><loc><?= SITE_URL ?>/disclaimer</loc><lastmod><?= $last_month ?></lastmod><changefreq>yearly</changefreq><priority>0.3</priority></url>
</urlset>
<?php return; }

// ── MATH TOOLS PAGES ───────────────────────────────────────────────────
if ($type === 'tools') {
  $tools = [
    'fraction-calculator', 'percentage-calculator', 'unit-converter',
    'geometry-calculator', 'graphing-calculator', 'prime-checker',
    'gcf-lcm-calculator', 'ratio-calculator', 'statistics-calculator',
    'exponent-calculator', 'roman-numeral-converter', 'times-table',
    'equation-solver', 'triangle-calculator', 'base-converter',
  ];
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($tools as $slug): ?>
  <url><loc><?= SITE_URL ?>/math-tools/<?= $slug ?></loc><lastmod><?= $today ?></lastmod><changefreq>monthly</changefreq><priority>0.8</priority></url>
<?php endforeach; ?>
</urlset>
<?php return; }

// ── TOPIC PAGES ─────────────────────────────────────────────────────────
if ($type === 'topics') {
  $topics = get_topics();
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($topics as $t): ?>
  <url><loc><?= SITE_URL ?>/<?= $t['subject'] ?>/<?= $t['id'] ?></loc><lastmod><?= $last_month ?></lastmod><changefreq>monthly</changefreq><priority>0.7</priority></url>
<?php endforeach; ?>
</urlset>
<?php return; }
?>
