<?php
require_once __DIR__ . '/config.php';
$page_title = 'EduMain - School Topics Explained Simply';
$page_desc  = 'Free explainers for every school subject - Maths, Science, History, English, Geography and more. Written simply for students aged 6-16 in the USA, UK, Australia and Spain.';
$body_class = 'page-home';
include '_header.php';

$subjects  = json_decode(SUBJECTS, true);
$all_topics = get_topics();
$featured  = array_values(array_filter($all_topics, fn($t) => !empty($t['featured'])));
?>

<!-- ══ HERO ══ -->
<section class="home-hero">

  <!-- Floating subject chips -->
  <div class="hero-floats" aria-hidden="true">
    <div class="hf hf-1"><i class="fa-solid fa-calculator"></i><span>Maths</span></div>
    <div class="hf hf-2"><i class="fa-solid fa-flask"></i><span>Science</span></div>
    <div class="hf hf-3"><i class="fa-solid fa-landmark"></i><span>History</span></div>
    <div class="hf hf-4"><i class="fa-solid fa-book-open"></i><span>English</span></div>
    <div class="hf hf-5"><i class="fa-solid fa-earth-americas"></i><span>Geography</span></div>
    <div class="hf hf-6"><i class="fa-solid fa-palette"></i><span>Art</span></div>
    <div class="hf hf-7"><i class="fa-solid fa-music"></i><span>Music</span></div>
    <div class="hf hf-8"><i class="fa-solid fa-atom"></i><span>Science</span></div>
    <div class="hf hf-9"><i class="fa-solid fa-pencil"></i><span>English</span></div>
    <div class="hf hf-10"><i class="fa-solid fa-laptop-code"></i><span>Computing</span></div>
  </div>

  <div class="hero-inner">
    <h1 class="hero-title">Learn Anything.<br><span class="hero-title-accent">Simply Explained.</span></h1>
    <p class="hero-desc">Free school topic explainers for students aged 6-16 in the USA, UK, Australia &amp; Spain. Pick a subject and start learning.</p>
    <form action="/search" method="get" class="hero-search-form" role="search">
      <div class="hero-search-wrap">
        <i class="fa-solid fa-magnifying-glass hero-search-icon"></i>
        <input type="search" name="q" class="hero-search-input" placeholder="Try &quot;photosynthesis&quot;, &quot;fractions&quot;, &quot;World War 2&quot;…" autocomplete="off">
        <button type="submit" class="hero-search-btn">Search</button>
      </div>
    </form>
    <div class="hero-tags">
      <a href="/math/fractions">Fractions</a>
      <a href="/science/photosynthesis">Photosynthesis</a>
      <a href="/history/world-war-2">WW2</a>
      <a href="/science/solar-system">Solar System</a>
      <a href="/math/algebra-basics">Algebra</a>
      <a href="/english/parts-of-speech">Parts of Speech</a>
    </div>
  </div>
</section>

<!-- AdsTerra native banner — above subject grid -->
<div class="home-native-ad">
  <script async="async" data-cfasync="false" src="https://pl29223878.profitablecpmratenetwork.com/9e7f11281adcc579755f8757bf17e0dc/invoke.js"></script>
  <div id="container-9e7f11281adcc579755f8757bf17e0dc"></div>
</div>

<!-- ══ SUBJECT GRID ══ -->
<section class="home-section">
  <div class="section-header">
    <h2 class="section-title">Choose a Subject</h2>
    <p class="section-sub">Browse by subject to find the topics you're studying</p>
  </div>
  <div class="subject-grid">
    <?php foreach ($subjects as $s): ?>
    <a href="/<?= $s['slug'] ?>" class="subject-card" style="--sc:<?= $s['color'] ?>;--sb:<?= $s['bg'] ?>">
      <div class="subject-card-icon"><i class="fa-solid <?= $s['icon'] ?>"></i></div>
      <div class="subject-card-body">
        <strong class="subject-card-name"><?= $s['name'] ?></strong>
        <span class="subject-card-desc"><?= $s['desc'] ?></span>
      </div>
      <div class="subject-card-arrow"><i class="fa-solid fa-chevron-right"></i></div>
    </a>
    <?php endforeach; ?>
  </div>
</section>

<!-- ══ FEATURED TOPICS ══ -->
<section class="home-section">
  <div class="section-header">
    <h2 class="section-title">Featured Topics</h2>
    <p class="section-sub">Popular topics students are reading right now</p>
  </div>
  <div class="topic-grid">
    <?php
    $subjectMap = [];
    foreach (json_decode(SUBJECTS, true) as $s) $subjectMap[$s['slug']] = $s;
    foreach (array_slice($featured, 0, 12) as $t):
      $subj = $subjectMap[$t['subject']] ?? ['color'=>'#7c3aed','name'=>$t['subject'],'icon'=>'fa-book'];
    ?>
    <a href="/<?= $t['subject'] ?>/<?= $t['id'] ?>" class="topic-card" style="--tc:<?= $subj['color'] ?>">
      <div class="topic-card-subj" style="background:<?= $subj['color'] ?>">
        <i class="fa-solid <?= $subj['icon'] ?>"></i> <?= $subj['name'] ?>
      </div>
      <div class="topic-card-body">
        <h3 class="topic-card-title"><?= htmlspecialchars($t['title']) ?></h3>
        <p class="topic-card-desc"><?= htmlspecialchars($t['desc']) ?></p>
      </div>
      <div class="topic-card-footer">
        <span class="topic-card-grade">Yr <?= implode('-', [min($t['grade']), max($t['grade'])]) ?></span>
        <span class="topic-card-diff topic-diff-<?= $t['difficulty'] ?>"><?= ucfirst($t['difficulty']) ?></span>
      </div>
    </a>
    <?php endforeach; ?>
  </div>
</section>

<!-- AdsTerra 300x250 — between featured topics and math tools promo -->
<div class="home-banner-300x250">
  <script>atOptions = {'key' : 'f093d96a9666c21a7ab93bfc887fd236','format' : 'iframe','height' : 250,'width' : 300,'params' : {}};</script>
  <script src="https://www.highperformanceformat.com/f093d96a9666c21a7ab93bfc887fd236/invoke.js"></script>
</div>

<!-- ══ MATH TOOLS PROMO ══ -->
<section class="home-section home-section-tools-promo">
  <div class="tools-promo-inner">
    <div class="tools-promo-text">
      <div class="tools-promo-badge"><i class="fa-solid fa-calculator"></i> Math Tools</div>
      <h2 class="tools-promo-title">Free Interactive Math Calculators</h2>
      <p class="tools-promo-desc">15 interactive tools including a fraction calculator, equation solver, graphing calculator and more - all free, no sign-up needed.</p>
      <a href="/math-tools" class="tools-promo-btn">Explore Math Tools</a>
    </div>
    <div class="tools-promo-grid">
      <a href="/math-tools/fraction-calculator"   class="tpg-item"><i class="fa-solid fa-divide"></i><span>Fractions</span></a>
      <a href="/math-tools/percentage-calculator" class="tpg-item"><i class="fa-solid fa-percent"></i><span>Percentages</span></a>
      <a href="/math-tools/equation-solver"       class="tpg-item"><i class="fa-solid fa-equals"></i><span>Equations</span></a>
      <a href="/math-tools/geometry-calculator"   class="tpg-item"><i class="fa-solid fa-draw-polygon"></i><span>Geometry</span></a>
      <a href="/math-tools/graphing-calculator"   class="tpg-item"><i class="fa-solid fa-chart-line"></i><span>Graphing</span></a>
      <a href="/math-tools/statistics-calculator" class="tpg-item"><i class="fa-solid fa-chart-bar"></i><span>Statistics</span></a>
      <a href="/math-tools/prime-checker"         class="tpg-item"><i class="fa-solid fa-hashtag"></i><span>Primes</span></a>
      <a href="/math-tools/times-table"           class="tpg-item"><i class="fa-solid fa-table"></i><span>Times Tables</span></a>
    </div>
  </div>
</section>

<!-- ══ HOW IT WORKS ══ -->
<section class="home-section">
  <div class="section-header">
    <h2 class="section-title">How It Works</h2>
    <p class="section-sub">Simple steps to get the most out of EduMain</p>
  </div>
  <div class="how-grid">
    <div class="how-card">
      <div class="how-num">1</div>
      <div class="how-icon"><i class="fa-solid fa-compass"></i></div>
      <h3 class="how-title">Pick a Subject</h3>
      <p class="how-desc">Choose from 10 subjects including Maths, Science, History, English, Geography and more.</p>
    </div>
    <div class="how-card">
      <div class="how-num">2</div>
      <div class="how-icon"><i class="fa-solid fa-book-open"></i></div>
      <h3 class="how-title">Read the Explainer</h3>
      <p class="how-desc">Each topic has a clear, simple explanation with key facts written in plain English - no confusing jargon.</p>
    </div>
    <div class="how-card">
      <div class="how-num">3</div>
      <div class="how-icon"><i class="fa-solid fa-circle-question"></i></div>
      <h3 class="how-title">Test Yourself</h3>
      <p class="how-desc">Every topic has a quick quiz with instant feedback so you can check what you've learned.</p>
    </div>
    <div class="how-card">
      <div class="how-num">4</div>
      <div class="how-icon"><i class="fa-solid fa-calculator"></i></div>
      <h3 class="how-title">Use the Tools</h3>
      <p class="how-desc">Stuck on a calculation? Use our free interactive math tools to solve problems step by step.</p>
    </div>
  </div>
</section>

<!-- AdsTerra 160x300 — between How It Works and Why EduMain -->
<div class="home-banner-160x300">
  <script>atOptions = {'key' : 'f942d0c6515398bb20bcb59c82781b61','format' : 'iframe','height' : 300,'width' : 160,'params' : {}};</script>
  <script src="https://www.highperformanceformat.com/f942d0c6515398bb20bcb59c82781b61/invoke.js"></script>
</div>

<!-- ══ WHY EDUMAIN ══ -->
<section class="home-section home-section-why">
  <div class="section-header">
    <h2 class="section-title">Why Students Love EduMain</h2>
    <p class="section-sub">Everything you need to understand school topics - in one place</p>
  </div>
  <div class="why-grid">
    <div class="why-item">
      <i class="fa-solid fa-check-circle why-icon"></i>
      <div>
        <strong>100% Free</strong>
        <p>No subscriptions, no sign-ups, no adverts interrupting your learning.</p>
      </div>
    </div>
    <div class="why-item">
      <i class="fa-solid fa-language why-icon"></i>
      <div>
        <strong>Plain English</strong>
        <p>Every topic is written in clear, simple language that students aged 6-16 can understand.</p>
      </div>
    </div>
    <div class="why-item">
      <i class="fa-solid fa-graduation-cap why-icon"></i>
      <div>
        <strong>Curriculum Aligned</strong>
        <p>Content mapped to USA, UK, Australia and Spain national curriculum standards.</p>
      </div>
    </div>
    <div class="why-item">
      <i class="fa-solid fa-bolt why-icon"></i>
      <div>
        <strong>Quick Quizzes</strong>
        <p>Test your knowledge with instant-feedback quizzes on every single topic.</p>
      </div>
    </div>
    <div class="why-item">
      <i class="fa-solid fa-calculator why-icon"></i>
      <div>
        <strong>Interactive Tools</strong>
        <p>15 free math calculators and solvers to help with homework and exam prep.</p>
      </div>
    </div>
    <div class="why-item">
      <i class="fa-solid fa-mobile-screen why-icon"></i>
      <div>
        <strong>Works Everywhere</strong>
        <p>Fully responsive design that works perfectly on phones, tablets and computers.</p>
      </div>
    </div>
  </div>
</section>

<!-- ══ COUNTRIES SECTION ══ -->
<section class="home-section home-section-countries">
  <div class="section-header">
    <h2 class="section-title">For Students Everywhere</h2>
    <p class="section-sub">Content aligned with curriculum standards across four countries</p>
  </div>
  <div class="country-grid">
    <div class="country-card">
      <div class="country-flag"><span class="fi fi-us fis"></span></div>
      <strong>USA</strong>
      <span>Common Core + State Standards</span>
    </div>
    <div class="country-card">
      <div class="country-flag"><span class="fi fi-gb fis"></span></div>
      <strong>UK</strong>
      <span>National Curriculum KS1-KS4</span>
    </div>
    <div class="country-card">
      <div class="country-flag"><span class="fi fi-au fis"></span></div>
      <strong>Australia</strong>
      <span>ACARA Australian Curriculum</span>
    </div>
    <div class="country-card">
      <div class="country-flag"><span class="fi fi-es fis"></span></div>
      <strong>Spain</strong>
      <span>LOMLOE Curriculum</span>
    </div>
  </div>
</section>

<!-- ══ STATS BANNER ══ -->
<section class="home-stats-banner">
  <div class="stats-inner">
    <div class="stat-item"><strong>87+</strong><span>Topics Explained</span></div>
    <div class="stat-item"><strong>10</strong><span>School Subjects</span></div>
    <div class="stat-item"><strong>15</strong><span>Math Tools</span></div>
    <div class="stat-item"><strong>4</strong><span>Countries</span></div>
    <div class="stat-item"><strong>6-16</strong><span>Age Range</span></div>
  </div>
</section>

<?php include '_footer.php'; ?>
