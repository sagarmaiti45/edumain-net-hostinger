<?php
require_once __DIR__ . '/config.php';

$subject_slug = $_GET['subject'] ?? '';
$subjects = json_decode(SUBJECTS, true);
$subjectMap = [];
foreach ($subjects as $s) $subjectMap[$s['slug']] = $s;

$subj = $subjectMap[$subject_slug] ?? null;
if (!$subj) {
    http_response_code(404);
    include '404.php';
    exit;
}

$topics = get_topics_by_subject($subject_slug);

$page_title = $subj['name'] . ' Explained Simply - EduMain';
$page_desc  = 'Free ' . $subj['name'] . ' explainers for students aged 6-16. ' . $subj['desc'] . '. Includes key facts, examples and quick quizzes.';
$body_class = 'page-subject';
include '_header.php';
?>

<!-- Subject Hero -->
<div class="subject-hero" style="--sc:<?= $subj['color'] ?>;--sb:<?= $subj['bg'] ?>">
  <div class="subject-hero-inner">
    <div class="subject-hero-icon"><i class="fa-solid <?= $subj['icon'] ?>"></i></div>
    <div>
      <h1 class="subject-hero-title"><?= $subj['name'] ?></h1>
      <p class="subject-hero-desc"><?= $subj['desc'] ?></p>
      <div class="subject-hero-count"><strong><?= count($topics) ?></strong> topics available</div>
    </div>
  </div>
</div>

<!-- Breadcrumb -->
<nav class="breadcrumb" aria-label="Breadcrumb">
  <a href="/">Home</a>
  <span class="bc-sep">›</span>
  <span style="color:<?= $subj['color'] ?>"><?= $subj['name'] ?></span>
</nav>

<!-- Difficulty filter -->
<div class="subject-filters">
  <button class="subj-filter active" data-filter="">All</button>
  <button class="subj-filter" data-filter="easy">Easy</button>
  <button class="subj-filter" data-filter="medium">Medium</button>
  <button class="subj-filter" data-filter="hard">Hard</button>
</div>

<!-- Topics grid -->
<?php if (empty($topics)): ?>
<div class="empty-state">
  <i class="fa-solid <?= $subj['icon'] ?>"></i>
  <p>Topics for <?= $subj['name'] ?> are coming soon!</p>
</div>
<?php else: ?>
<div class="topic-grid subject-topic-grid" id="subject-grid">
  <?php foreach ($topics as $t): ?>
  <a href="/<?= $t['subject'] ?>/<?= $t['id'] ?>"
     class="topic-card"
     style="--tc:<?= $subj['color'] ?>"
     data-difficulty="<?= $t['difficulty'] ?>">
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

<div class="subject-empty-filter" id="subject-empty" style="display:none">
  <i class="fa-solid fa-magnifying-glass"></i>
  <p>No topics found for this filter.</p>
</div>
<?php endif; ?>

<script>
(function() {
  var btns  = document.querySelectorAll('.subj-filter');
  var cards = document.querySelectorAll('#subject-grid .topic-card');
  var empty = document.getElementById('subject-empty');

  btns.forEach(function(btn) {
    btn.addEventListener('click', function() {
      btns.forEach(function(b) { b.classList.remove('active'); });
      btn.classList.add('active');
      var filter = btn.dataset.filter;
      var visible = 0;
      cards.forEach(function(card) {
        var show = !filter || card.dataset.difficulty === filter;
        card.style.display = show ? '' : 'none';
        if (show) visible++;
      });
      if (empty) empty.style.display = (visible === 0) ? 'flex' : 'none';
    });
  });
})();
</script>

<?php include '_footer.php'; ?>
