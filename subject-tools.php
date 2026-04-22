<?php
require_once __DIR__ . '/config.php';

$subjects   = json_decode(SUBJECTS, true);
$subjectMap = [];
foreach ($subjects as $s) $subjectMap[$s['slug']] = $s;
$subj = $subjectMap['math-tools'];

$page_title = 'Math Tools - Free Online Calculators & Solvers';
$page_desc  = 'Free interactive math tools for students aged 6-16. Fraction calculator, percentage calculator, geometry solver, graphing calculator and more.';
$body_class = 'page-subject';
include '_header.php';

$tools = [
  ['slug'=>'fraction-calculator',    'name'=>'Fraction Calculator',       'icon'=>'fa-divide',          'color'=>'#a855f7', 'desc'=>'Add, subtract, multiply & divide fractions with step-by-step solutions.',      'grade'=>'3-9',  'diff'=>'easy'],
  ['slug'=>'percentage-calculator',  'name'=>'Percentage Calculator',     'icon'=>'fa-percent',         'color'=>'#f97316', 'desc'=>'Calculate percentages, percentage change, and reverse percentages instantly.', 'grade'=>'5-10', 'diff'=>'easy'],
  ['slug'=>'equation-solver',        'name'=>'Equation Solver',           'icon'=>'fa-equals',          'color'=>'#3b82f6', 'desc'=>'Solve linear and quadratic equations with full working shown step by step.',     'grade'=>'7-11', 'diff'=>'medium'],
  ['slug'=>'geometry-calculator',    'name'=>'Geometry Calculator',       'icon'=>'fa-draw-polygon',    'color'=>'#22c55e', 'desc'=>'Calculate area, perimeter, volume and surface area for all common shapes.',     'grade'=>'5-10', 'diff'=>'medium'],
  ['slug'=>'graphing-calculator',    'name'=>'Graphing Calculator',       'icon'=>'fa-chart-line',      'color'=>'#6366f1', 'desc'=>'Plot functions and equations on an interactive graph instantly.',                'grade'=>'8-12', 'diff'=>'medium'],
  ['slug'=>'triangle-calculator',    'name'=>'Triangle Calculator',       'icon'=>'fa-mountain',        'color'=>'#14b8a6', 'desc'=>'Solve any triangle - find missing sides and angles using trigonometry.',        'grade'=>'7-11', 'diff'=>'medium'],
  ['slug'=>'gcf-lcm-calculator',     'name'=>'GCF & LCM Calculator',     'icon'=>'fa-layer-group',     'color'=>'#ec4899', 'desc'=>'Find the greatest common factor and lowest common multiple of any numbers.',    'grade'=>'4-8',  'diff'=>'easy'],
  ['slug'=>'ratio-calculator',       'name'=>'Ratio Calculator',          'icon'=>'fa-scale-balanced',  'color'=>'#eab308', 'desc'=>'Simplify ratios, solve proportions and scale quantities with ease.',            'grade'=>'5-9',  'diff'=>'easy'],
  ['slug'=>'statistics-calculator',  'name'=>'Statistics Calculator',     'icon'=>'fa-chart-bar',       'color'=>'#0ea5e9', 'desc'=>'Calculate mean, median, mode, range, variance and standard deviation.',        'grade'=>'6-11', 'diff'=>'medium'],
  ['slug'=>'exponent-calculator',    'name'=>'Exponent Calculator',       'icon'=>'fa-superscript',     'color'=>'#f43f5e', 'desc'=>'Calculate powers, roots and scientific notation with detailed steps.',          'grade'=>'6-10', 'diff'=>'easy'],
  ['slug'=>'prime-checker',          'name'=>'Prime Number Checker',      'icon'=>'fa-hashtag',         'color'=>'#8b5cf6', 'desc'=>'Check if any number is prime and find prime factors instantly.',                'grade'=>'4-8',  'diff'=>'easy'],
  ['slug'=>'times-table',            'name'=>'Times Table Generator',     'icon'=>'fa-table',           'color'=>'#10b981', 'desc'=>'Generate and practise multiplication tables for any number.',                   'grade'=>'2-6',  'diff'=>'easy'],
  ['slug'=>'unit-converter',         'name'=>'Unit Converter',            'icon'=>'fa-arrows-left-right','color'=>'#f97316','desc'=>'Convert length, weight, temperature, speed and more between units.',            'grade'=>'5-10', 'diff'=>'easy'],
  ['slug'=>'roman-numeral-converter','name'=>'Roman Numeral Converter',   'icon'=>'fa-landmark',        'color'=>'#64748b', 'desc'=>'Convert numbers to Roman numerals and Roman numerals back to numbers.',        'grade'=>'4-8',  'diff'=>'easy'],
  ['slug'=>'base-converter',         'name'=>'Number Base Converter',     'icon'=>'fa-binary',          'color'=>'#0891b2', 'desc'=>'Convert numbers between binary, decimal, octal and hexadecimal bases.',        'grade'=>'8-12', 'diff'=>'hard'],
];
?>

<!-- Subject Hero -->
<div class="subject-hero" style="--sc:#0ea5e9;--sb:#f0f9ff">
  <div class="subject-hero-inner">
    <div class="subject-hero-icon"><i class="fa-solid fa-calculator"></i></div>
    <div>
      <h1 class="subject-hero-title">Math Tools</h1>
      <p class="subject-hero-desc">Free interactive calculators and solvers for every maths topic</p>
      <div class="subject-hero-count"><strong><?= count($tools) ?></strong> tools available</div>
    </div>
  </div>
</div>

<!-- Breadcrumb -->
<nav class="breadcrumb" aria-label="Breadcrumb">
  <a href="/">Home</a>
  <span class="bc-sep">›</span>
  <span style="color:#0ea5e9">Math Tools</span>
</nav>

<!-- Tools grid -->
<div class="topic-grid subject-topic-grid" style="padding-top:24px">
  <?php foreach ($tools as $t): ?>
  <a href="/math-tools/<?= $t['slug'] ?>" class="topic-card tool-card" style="--tc:<?= $t['color'] ?>">
    <div class="topic-card-subj" style="background:<?= $t['color'] ?>">
      <i class="fa-solid <?= $t['icon'] ?>"></i> Math Tools
    </div>
    <div class="topic-card-body">
      <h2 class="topic-card-title"><?= htmlspecialchars($t['name']) ?></h2>
      <p class="topic-card-desc"><?= htmlspecialchars($t['desc']) ?></p>
    </div>
    <div class="topic-card-footer">
      <span class="topic-card-grade">Yr <?= $t['grade'] ?></span>
      <span class="topic-card-diff topic-diff-<?= $t['diff'] ?>"><?= ucfirst($t['diff']) ?></span>
    </div>
  </a>
  <?php endforeach; ?>
</div>

<?php include '_footer.php'; ?>
