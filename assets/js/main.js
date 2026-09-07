/* ================================================================
   EduMain - Main JS
   ================================================================ */

// ── Mobile nav sidebar ────────────────────────────────────────────
(function() {
  var menuBtn  = document.getElementById('mob-menu-btn');
  var closeBtn = document.getElementById('mob-nav-close');
  var nav      = document.getElementById('mob-nav');
  var overlay  = document.getElementById('mob-overlay');
  if (!menuBtn || !nav || !overlay) return;

  function openMobNav() {
    nav.classList.add('open');
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
  }
  function closeMobNav() {
    nav.classList.remove('open');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
  }

  menuBtn.addEventListener('click', openMobNav);
  if (closeBtn) closeBtn.addEventListener('click', closeMobNav);
  overlay.addEventListener('click', closeMobNav);
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && nav.classList.contains('open')) closeMobNav();
  });
})();

// ── Shared Quiz Logic ─────────────────────────────────────────────
(function() {
  document.querySelectorAll('.topic-quiz').forEach(function(container) {
    var questions = container.querySelectorAll('.quiz-q');
    var scoreEl   = container.querySelector('.quiz-score');
    var scoreNum  = container.querySelector('.quiz-score-num');
    var retryBtn  = container.querySelector('.quiz-retry-btn');
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
              if (scoreNum) scoreNum.textContent = correct;
              if (scoreEl) scoreEl.style.display = 'block';
            }, 600);
          }
        });
      });
    });

    if (retryBtn) {
      retryBtn.addEventListener('click', function() {
        answered = 0; correct = 0;
        questions.forEach(function(qEl) {
          qEl.classList.remove('quiz-done');
          var opts = qEl.querySelectorAll('.quiz-opt');
          opts.forEach(function(b) {
            b.disabled = false;
            b.classList.remove('quiz-correct', 'quiz-wrong');
          });
          var fb = qEl.querySelector('.quiz-feedback');
          if (fb) { fb.style.display = 'none'; fb.textContent = ''; fb.className = 'quiz-feedback'; }
        });
        if (scoreEl) scoreEl.style.display = 'none';
      });
    }
  });
})();
