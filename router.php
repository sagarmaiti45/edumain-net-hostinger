<?php
// Router for PHP built-in server - replicates .htaccess clean URL logic
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Serve existing static files with cache headers
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    $ext = strtolower(pathinfo($uri, PATHINFO_EXTENSION));
    $ttl = match($ext) {
        'css', 'js'                          => 31536000,
        'png', 'jpg', 'jpeg', 'webp', 'gif',
        'svg', 'ico', 'woff', 'woff2'        => 31536000,
        'xsl', 'xml'                         => 86400,
        default                              => 3600,
    };
    header("Cache-Control: public, max-age=$ttl, immutable");
    return false;
}

// Block access to includes and data
if (preg_match('/^\/(_|\bdata\b)/', $uri)) {
    http_response_code(403);
    exit('Forbidden');
}

$path = trim($uri, '/');

// Root
if ($path === '' || $path === 'index') {
    require __DIR__ . '/index.php';
    exit;
}

// Search
if ($path === 'search') {
    require __DIR__ . '/search.php';
    exit;
}

// Sitemap
if ($path === 'sitemap.xml') {
    require __DIR__ . '/sitemap.php';
    exit;
}
if ($path === 'sitemap-static.xml') {
    $_GET['type'] = 'static';
    require __DIR__ . '/sitemap.php';
    exit;
}
if ($path === 'sitemap-tools.xml') {
    $_GET['type'] = 'tools';
    require __DIR__ . '/sitemap.php';
    exit;
}
if ($path === 'sitemap-topics.xml') {
    $_GET['type'] = 'topics';
    require __DIR__ . '/sitemap.php';
    exit;
}

// API
if ($path === 'api/vault') {
    require __DIR__ . '/api/vault.php';
    exit;
}
if ($path === 'api/req-games') {
    require __DIR__ . '/api/req-games.php';
    exit;
}

// Static pages
$static = ['about', 'contact', 'privacy', 'terms', 'disclaimer', '404'];
if (in_array($path, $static)) {
    $file = __DIR__ . '/' . $path . '.php';
    if (file_exists($file)) { require $file; exit; }
}

require_once __DIR__ . '/config.php';
$subjects = json_decode(SUBJECTS, true);
$slugs    = array_column($subjects, 'slug');

// Math Tools slugs
$_toolSlugs = [
    'fraction-calculator','percentage-calculator','unit-converter',
    'geometry-calculator','graphing-calculator','prime-checker',
    'gcf-lcm-calculator','ratio-calculator','statistics-calculator',
    'exponent-calculator','roman-numeral-converter','times-table',
    'equation-solver','triangle-calculator','base-converter',
];

// /math-tools → tools hub
if ($path === 'math-tools') {
    $_GET['subject'] = 'math-tools';
    require __DIR__ . '/subject-tools.php';
    exit;
}

// /math-tools/<tool-slug> → tool page
if (preg_match('/^math-tools\/([a-z0-9\-]+)$/', $path, $m)) {
    $toolSlug = $m[1];
    $toolFile = __DIR__ . '/tools/' . $toolSlug . '.php';
    if (in_array($toolSlug, $_toolSlugs) && file_exists($toolFile)) {
        require $toolFile;
        exit;
    }
}

// /math, /science, etc. → subject hub
if (in_array($path, $slugs)) {
    $_GET['subject'] = $path;
    require __DIR__ . '/subject.php';
    exit;
}

// /math/fractions, /science/photosynthesis → topic page
if (preg_match('/^([a-z0-9\-]+)\/([a-z0-9\-]+)$/', $path, $m)) {
    $subject = $m[1];
    $topicId = $m[2];
    if (in_array($subject, $slugs)) {
        $_GET['subject'] = $subject;
        $_GET['id']      = $topicId;
        require __DIR__ . '/topic.php';
        exit;
    }
}

// 404
http_response_code(404);
require __DIR__ . '/404.php';
