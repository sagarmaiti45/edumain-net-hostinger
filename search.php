<?php
require_once __DIR__ . '/config.php';

$q = trim($_GET['q'] ?? '');
$subjects = json_decode(SUBJECTS, true);
$subjectMap = [];
foreach ($subjects as $s) $subjectMap[$s['slug']] = $s;

$results = [];
if ($q !== '') {
    $lq = strtolower($q);
    foreach (get_topics() as $t) {
        $score = 0;
        if (stripos($t['title'], $q) !== false) $score += 10;
        if (stripos($t['desc'], $q) !== false) $score += 5;
        if (stripos($t['subject'], $q) !== false) $score += 3;
        if (!empty($t['facts'])) {
            foreach ($t['facts'] as $f) {
                if (stripos($f, $q) !== false) { $score += 2; break; }
            }
        }
        if ($score > 0) { $t['_score'] = $score; $results[] = $t; }
    }
    usort($results, fn($a, $b) => $b['_score'] - $a['_score']);
}

$page_title = $q ? 'Search: "' . htmlspecialchars($q) . '" - EduMain' : 'Search - EduMain';
$page_desc  = 'Search EduMain for school topic explainers.';
$body_class = 'page-search';
include '_header.php';
?>

<div class="search-page">
  <div class="search-page-header">
    <h1 class="search-title">
      <?php if ($q): ?>
      Results for <em>"<?= htmlspecialchars($q) ?>"</em>
      <?php else: ?>
      Search Topics
      <?php endif; ?>
    </h1>
    <form action="/search" method="get" class="search-page-form" role="search">
      <div class="search-page-wrap">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Search topics…" autocomplete="off" autofocus>
        <button type="submit">Search</button>
      </div>
    </form>
  </div>

  <?php if ($q): ?>
    <?php if (empty($results)): ?>
    <div class="search-no-results">
      <i class="fa-solid fa-face-sad-tear"></i>
      <p>No results found for <strong>"<?= htmlspecialchars($q) ?>"</strong>.</p>
      <p class="search-suggestion">Try a different keyword, or <a href="/">browse by subject</a>.</p>
    </div>
    <?php else: ?>
    <p class="search-count"><strong><?= count($results) ?></strong> result<?= count($results) !== 1 ? 's' : '' ?> found</p>
    <div class="topic-grid">
      <?php foreach ($results as $t):
        $subj = $subjectMap[$t['subject']] ?? ['color'=>'#7c3aed','icon'=>'fa-book','name'=>$t['subject']];
      ?>
      <a href="/<?= $t['subject'] ?>/<?= $t['id'] ?>" class="topic-card" style="--tc:<?= $subj['color'] ?>">
        <div class="topic-card-subj" style="background:<?= $subj['color'] ?>">
          <i class="fa-solid <?= $subj['icon'] ?>"></i> <?= $subj['name'] ?>
        </div>
        <div class="topic-card-body">
          <h2 class="topic-card-title"><?= htmlspecialchars($t['title']) ?></h2>
          <p class="topic-card-desc"><?= htmlspecialchars($t['desc']) ?></p>
        </div>
        <div class="topic-card-footer">
          <span class="topic-card-grade">Yr <?= implode('-', [min($t['grade']), max($t['grade'])]) ?></span>
          <span class="topic-card-diff topic-diff-<?= $t['difficulty'] ?>"><?= ucfirst($t['difficulty']) ?></span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  <?php else: ?>
  <!-- No query - show subject links -->
  <div class="search-browse">
    <h2>Or browse by subject:</h2>
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
  </div>
  <?php endif; ?>
</div>

<?php include '_footer.php'; ?>
