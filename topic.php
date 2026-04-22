<?php
require_once __DIR__ . '/config.php';

$topic_id = $_GET['id'] ?? '';
$topic = get_topic($topic_id);

if (!$topic) {
    http_response_code(404);
    include '404.php';
    exit;
}

$subjects   = json_decode(SUBJECTS, true);
$subjectMap = [];
foreach ($subjects as $s) $subjectMap[$s['slug']] = $s;
$subj = $subjectMap[$topic['subject']] ?? ['color'=>'#7c3aed','name'=>$topic['subject'],'icon'=>'fa-book','bg'=>'#f5f3ff'];

$page_title = htmlspecialchars($topic['title']) . ' - EduMain';
$page_desc  = htmlspecialchars($topic['desc']);
$body_class = 'page-topic';
include '_header.php';

// Related topics
$related = [];
if (!empty($topic['related'])) {
    foreach ($topic['related'] as $rid) {
        $rt = get_topic($rid);
        if ($rt) $related[] = $rt;
    }
}
?>

<!-- Breadcrumb -->
<nav class="breadcrumb" aria-label="Breadcrumb">
  <a href="/">Home</a>
  <span class="bc-sep">›</span>
  <a href="/<?= $topic['subject'] ?>" style="color:<?= $subj['color'] ?>"><?= $subj['name'] ?></a>
  <span class="bc-sep">›</span>
  <span><?= htmlspecialchars($topic['title']) ?></span>
</nav>

<!-- Topic Hero -->
<div class="topic-hero" style="--tc:<?= $subj['color'] ?>;--tb:<?= $subj['bg'] ?>">
  <div class="topic-hero-inner">
    <div class="topic-hero-subj">
      <i class="fa-solid <?= $subj['icon'] ?>"></i> <?= $subj['name'] ?>
    </div>
    <h1 class="topic-hero-title"><?= htmlspecialchars($topic['title']) ?></h1>
    <div class="topic-hero-meta">
      <span class="meta-tag"><i class="fa-solid fa-graduation-cap"></i> Year <?= implode('-', [min($topic['grade']), max($topic['grade'])]) ?></span>
      <span class="meta-tag topic-diff-<?= $topic['difficulty'] ?>"><?= ucfirst($topic['difficulty']) ?></span>
      <?php foreach ($topic['countries'] as $c): ?>
      <span class="meta-tag meta-country"><?= match($c){ 'US'=>'🇺🇸 USA','UK'=>'🇬🇧 UK','AU'=>'🇦🇺 AUS','ES'=>'🇪🇸 Spain',default=>$c } ?></span>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<!-- Topic Content -->
<div class="topic-layout">

  <!-- Main -->
  <main class="topic-main">

    <!-- Intro -->
    <div class="topic-intro">
      <p><?= htmlspecialchars($topic['intro']) ?></p>
    </div>

    <!-- Key Facts -->
    <div class="topic-facts-box" style="border-color:<?= $subj['color'] ?>">
      <div class="facts-box-header" style="background:<?= $subj['color'] ?>">
        <i class="fa-solid fa-lightbulb"></i> Key Facts
      </div>
      <ul class="facts-list">
        <?php foreach ($topic['facts'] as $fact): ?>
        <li><?= htmlspecialchars($fact) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <!-- Explanation section -->
    <div class="topic-content">
      <h2>About <?= htmlspecialchars($topic['title']) ?></h2>
      <p><?= htmlspecialchars($topic['intro']) ?></p>
      <p>This is one of the most important topics in <?= $subj['name'] ?> at school level. Understanding it thoroughly will help you in exams and beyond.</p>
      <p>Make sure to practise using the quick quiz below to test how much you've learned!</p>
    </div>

    <!-- Quick Quiz -->
    <?php if (!empty($topic['quiz'])): ?>
    <div class="topic-quiz" id="topic-quiz">
      <div class="quiz-header" style="background:<?= $subj['color'] ?>">
        <i class="fa-solid fa-circle-question"></i> Quick Quiz
        <span class="quiz-sub"><?= count($topic['quiz']) ?> questions</span>
      </div>
      <div class="quiz-body">
        <?php foreach ($topic['quiz'] as $qi => $q): ?>
        <div class="quiz-q" data-qi="<?= $qi ?>" data-correct="<?= $q['correct'] ?>">
          <p class="quiz-question"><strong>Q<?= $qi + 1 ?>.</strong> <?= htmlspecialchars($q['q']) ?></p>
          <div class="quiz-options">
            <?php foreach ($q['options'] as $oi => $opt): ?>
            <button class="quiz-opt" data-oi="<?= $oi ?>"><?= htmlspecialchars($opt) ?></button>
            <?php endforeach; ?>
          </div>
          <div class="quiz-feedback" style="display:none"></div>
        </div>
        <?php endforeach; ?>
        <div class="quiz-score" style="display:none">
          <div class="quiz-score-inner">
            <div class="quiz-score-icon"><i class="fa-solid fa-trophy"></i></div>
            <div class="quiz-score-text">You scored <strong id="quiz-score-num">0</strong> / <?= count($topic['quiz']) ?></div>
            <button class="quiz-retry-btn">Try Again</button>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>

  </main>

  <!-- Sidebar -->
  <aside class="topic-sidebar">

    <!-- Related Topics -->
    <?php if ($related): ?>
    <div class="sidebar-widget">
      <h3 class="widget-title"><i class="fa-solid fa-link"></i> Related Topics</h3>
      <div class="related-list">
        <?php foreach ($related as $rt):
          $rsubj = $subjectMap[$rt['subject']] ?? ['color'=>'#7c3aed','icon'=>'fa-book','name'=>$rt['subject']];
        ?>
        <a href="/<?= $rt['subject'] ?>/<?= $rt['id'] ?>" class="related-item" style="--tc:<?= $rsubj['color'] ?>">
          <span class="related-icon" style="background:<?= $rsubj['color'] ?>"><i class="fa-solid <?= $rsubj['icon'] ?>"></i></span>
          <div>
            <div class="related-title"><?= htmlspecialchars($rt['title']) ?></div>
            <div class="related-subj"><?= $rsubj['name'] ?></div>
          </div>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- Subject Link -->
    <a href="/<?= $topic['subject'] ?>" class="sidebar-widget sidebar-subj-link" style="--tc:<?= $subj['color'] ?>">
      <i class="fa-solid <?= $subj['icon'] ?>"></i>
      <div>
        <strong>More <?= $subj['name'] ?> Topics</strong>
        <span>Browse all <?= $subj['name'] ?> explainers</span>
      </div>
      <i class="fa-solid fa-chevron-right"></i>
    </a>

  </aside>

</div><!-- /topic-layout -->

<script>
// Quick Quiz logic
(function() {
  var quizContainer = document.getElementById('topic-quiz');
  if (!quizContainer) return;

  var questions = quizContainer.querySelectorAll('.quiz-q');
  var scoreEl   = quizContainer.querySelector('.quiz-score');
  var scoreNum  = document.getElementById('quiz-score-num');
  var retryBtn  = quizContainer.querySelector('.quiz-retry-btn');
  var answered  = 0;
  var correct   = 0;

  questions.forEach(function(qEl) {
    var correctIdx = parseInt(qEl.dataset.correct);
    var opts = qEl.querySelectorAll('.quiz-opt');
    var feedback = qEl.querySelector('.quiz-feedback');

    opts.forEach(function(btn) {
      btn.addEventListener('click', function() {
        if (qEl.classList.contains('quiz-done')) return;
        qEl.classList.add('quiz-done');
        var chosen = parseInt(btn.dataset.oi);
        opts.forEach(function(b) { b.disabled = true; });
        if (chosen === correctIdx) {
          btn.classList.add('quiz-correct');
          feedback.textContent = '✓ Correct!';
          feedback.className = 'quiz-feedback quiz-ok';
          correct++;
        } else {
          btn.classList.add('quiz-wrong');
          opts[correctIdx].classList.add('quiz-correct');
          feedback.textContent = '✗ Not quite - the correct answer is highlighted.';
          feedback.className = 'quiz-feedback quiz-err';
        }
        feedback.style.display = 'block';
        answered++;
        if (answered === questions.length) {
          setTimeout(function() {
            scoreNum.textContent = correct;
            scoreEl.style.display = 'block';
          }, 600);
        }
      });
    });
  });

  if (retryBtn) {
    retryBtn.addEventListener('click', function() {
      answered = 0; correct = 0;
      scoreEl.style.display = 'none';
      questions.forEach(function(qEl) {
        qEl.classList.remove('quiz-done');
        qEl.querySelectorAll('.quiz-opt').forEach(function(b) {
          b.disabled = false;
          b.classList.remove('quiz-correct', 'quiz-wrong');
        });
        var fb = qEl.querySelector('.quiz-feedback');
        fb.style.display = 'none';
        fb.className = 'quiz-feedback';
      });
    });
  }
})();
</script>

<?php include '_footer.php'; ?>
