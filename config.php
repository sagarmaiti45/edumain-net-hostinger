<?php
// ════════════════════════════════════════════════════════
//  SITE CONFIG - Edit ONLY this file when replicating
// ════════════════════════════════════════════════════════

if (file_exists(__DIR__ . '/.env')) {
    foreach (file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if ($line[0] === '#' || !str_contains($line, '=')) continue;
        [$k, $v] = explode('=', $line, 2);
        putenv(trim($k) . '=' . trim($v));
    }
}

define('SITE_NAME',        'EduMain');
define('SITE_SHORT_NAME',  'EduMain');
define('SITE_TAGLINE',     'School Topics Explained Simply');
define('SITE_DESCRIPTION', 'EduMain explains school curriculum topics simply for students aged 6-16. Free explainers for Maths, Science, History, English, Geography and more - used by students in the USA, UK, Australia and Spain.');

$_host = $_SERVER['HTTP_HOST'] ?? '';
define('IS_DEV', str_starts_with($_host, 'localhost') || str_starts_with($_host, '127.'));

define('SITE_URL',    'https://edumain.net');
define('CDN_URL',     'https://learn.edumain.net');
define('THUMB_URL',   CDN_URL . '/thumbs');
define('GAMES_URL',   CDN_URL . '/games');

define('CONTACT_EMAIL', 'support@edumain.net');

define('ADSENSE_ID',   '');
define('GA_ID',        'G-J4XN9750P7');

define('COLOR_BG',         '#f0f9ff');
define('COLOR_BG2',        '#ffffff');
define('COLOR_BG3',        '#e0f2fe');
define('COLOR_CARD',       '#ffffff');
define('COLOR_CARD_HOVER', '#f0f9ff');
define('COLOR_ACCENT',     '#0ea5e9');
define('COLOR_ACCENT2',    '#38bdf8');
define('COLOR_TEXT',       '#0c1a2e');
define('COLOR_TEXT_MUTED', '#4b6a8a');
define('COLOR_BORDER',     '#bae6fd');

define('META_KEYWORDS', 'school topics explained, homework help, educational articles for kids, maths explained simply, science for students, history for kids, geography explained, english grammar help, edumain');
define('TWITTER_HANDLE', '');
define('SITE_YEAR', date('Y'));

define('SUBJECTS', json_encode([
  ['slug'=>'math',      'name'=>'Maths',     'icon'=>'fa-calculator',     'color'=>'#3b82f6', 'bg'=>'#eff6ff', 'desc'=>'Numbers, algebra, geometry & statistics'],
  ['slug'=>'science',   'name'=>'Science',   'icon'=>'fa-flask',          'color'=>'#22c55e', 'bg'=>'#f0fdf4', 'desc'=>'Biology, chemistry, physics & space'],
  ['slug'=>'history',   'name'=>'History',   'icon'=>'fa-landmark',       'color'=>'#f97316', 'bg'=>'#fff7ed', 'desc'=>'World events, empires & revolutions'],
  ['slug'=>'english',   'name'=>'English',   'icon'=>'fa-book-open',      'color'=>'#a855f7', 'bg'=>'#faf5ff', 'desc'=>'Grammar, writing & literature'],
  ['slug'=>'geography', 'name'=>'Geography', 'icon'=>'fa-earth-americas', 'color'=>'#14b8a6', 'bg'=>'#f0fdfa', 'desc'=>'Countries, climate & physical features'],
  ['slug'=>'art',       'name'=>'Art',       'icon'=>'fa-palette',        'color'=>'#ec4899', 'bg'=>'#fdf2f8', 'desc'=>'Techniques, artists & art history'],
  ['slug'=>'music',     'name'=>'Music',     'icon'=>'fa-music',          'color'=>'#eab308', 'bg'=>'#fefce8', 'desc'=>'Theory, instruments & music history'],
  ['slug'=>'computing', 'name'=>'Computing', 'icon'=>'fa-laptop-code',    'color'=>'#6366f1', 'bg'=>'#eef2ff', 'desc'=>'Coding, algorithms & digital skills'],
  ['slug'=>'pe',          'name'=>'PE',          'icon'=>'fa-person-running', 'color'=>'#ef4444', 'bg'=>'#fef2f2', 'desc'=>'Sports, fitness & health'],
  ['slug'=>'languages',   'name'=>'Languages',   'icon'=>'fa-language',       'color'=>'#f43f5e', 'bg'=>'#fff1f2', 'desc'=>'Spanish, French, German & more'],
  ['slug'=>'math-tools',  'name'=>'Math Tools',  'icon'=>'fa-calculator',     'color'=>'#0ea5e9', 'bg'=>'#f0f9ff', 'desc'=>'Interactive calculators & solvers', 'is_tools'=>true],
]));

// Load topics helper
function get_topics() {
    static $_cache = null;
    if ($_cache !== null) return $_cache;
    $f = __DIR__ . '/data/topics.json';
    $_cache = file_exists($f) ? json_decode(file_get_contents($f), true) : [];
    return $_cache;
}

function get_topic($id) {
    foreach (get_topics() as $t) {
        if ($t['id'] === $id) return $t;
    }
    return null;
}

function get_topics_by_subject($subject) {
    return array_values(array_filter(get_topics(), fn($t) => $t['subject'] === $subject));
}
