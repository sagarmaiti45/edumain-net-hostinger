<?php require_once __DIR__ . '/../config.php'; $page_title = 'Ratio Calculator'; $page_desc = 'Solve proportions and ratios with an animated balance scale showing whether ratios are equal.'; $body_class = 'page-article'; include __DIR__ . '/../_header.php'; ?>

<style>
.ratio-page { background: #0d1f1f; min-height: 60vh; padding: 2rem 1rem; color: #e2f8f5; font-family: 'Segoe UI', sans-serif; border-radius: 16px; overflow: hidden; max-width: 900px; margin-left: auto; margin-right: auto; }
.ratio-hero { text-align: center; margin-bottom: 2rem; }
.ratio-hero h1 { color: #e2f8f5; font-size: 2.2rem; font-weight: 800; margin: 0; text-shadow: 0 0 20px #14b8a644; }
.ratio-hero p { color: #5eead4; font-size: 1.05rem; margin-top: .4rem; }
.ratio-main { max-width: 680px; margin: 0 auto; }
.ratio-card { background: #122626; border: 1.5px solid #1d4040; border-radius: 20px; padding: 2rem; margin-bottom: 1.5rem; }
.ratio-equation { display: flex; align-items: center; justify-content: center; gap: 1rem; flex-wrap: wrap; margin-bottom: 1.5rem; }
.ratio-pair { display: flex; flex-direction: column; align-items: center; gap: .2rem; background: #0d1f1f; border: 2px solid #1d4040; border-radius: 14px; padding: .8rem 1rem; }
.ratio-pair label { font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #5eead4; }
.ratio-input { background: transparent; border: none; border-bottom: 2px solid #14b8a6; color: #e2f8f5; font-size: 2rem; font-weight: 900; width: 80px; text-align: center; outline: none; padding: .2rem 0; }
.ratio-colon { font-size: 2.5rem; font-weight: 900; color: #14b8a6; }
.ratio-equals { font-size: 2.5rem; font-weight: 900; color: #2dd4bf; }
.ratio-unknown { background: #14b8a622; border: 2px dashed #14b8a6; color: #2dd4bf; font-size: 2rem; font-weight: 900; width: 80px; text-align: center; border-radius: 10px; padding: .2rem 0; outline: none; font-family: 'Segoe UI', sans-serif; }
.ratio-btn { display: block; width: 100%; background: linear-gradient(135deg, #14b8a6, #0d9488); color: #fff; font-size: 1.05rem; font-weight: 700; border: none; border-radius: 12px; padding: .9rem; cursor: pointer; box-shadow: 0 4px 16px #14b8a644; transition: all .2s; }
.ratio-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px #14b8a666; }
.scale-wrap { background: #0a1a1a; border-radius: 16px; padding: 1.5rem; text-align: center; margin-bottom: 1.5rem; }
.scale-wrap h3 { font-size: .78rem; font-weight: 700; text-transform: uppercase; color: #5eead4; margin: 0 0 1rem; letter-spacing: .07em; }
#scaleSvg { width: 100%; max-width: 380px; display: block; margin: 0 auto; }
.result-box { background: #122626; border: 2px solid #14b8a6; border-radius: 14px; padding: 1.5rem; text-align: center; display: none; animation: popIn .5s cubic-bezier(.175,.885,.32,1.275); }
@keyframes popIn { from { opacity: 0; transform: scale(.88); } to { opacity: 1; transform: scale(1); } }
.result-label { font-size: .78rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #5eead4; margin-bottom: .4rem; }
.result-value { font-size: 3.5rem; font-weight: 900; color: #2dd4bf; text-shadow: 0 0 20px #2dd4bf55; }
.result-formula { font-size: .9rem; color: #5eead4; margin-top: .4rem; }
.balanced-badge { display: inline-block; background: #14b8a622; border: 1.5px solid #14b8a6; border-radius: 20px; padding: .3rem .9rem; font-size: .82rem; font-weight: 700; color: #14b8a6; margin-top: .6rem; }
.tool-share-row { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:.5rem; margin-bottom:1.5rem; }
.tool-share-btn { display:inline-flex; align-items:center; gap:.4rem; font-size:.82rem; font-weight:600; padding:.4rem .9rem; border-radius:50px; border:1.5px solid var(--border,#e5e7eb); background:transparent; cursor:pointer; color:var(--text-muted,#6b7280); transition:all .15s; }
.tool-share-btn:hover { border-color:var(--accent,#4f46e5); color:var(--accent,#4f46e5); }
.tool-article { margin: 2.5rem 0 3rem; padding: 0 1rem 2.5rem; }
.tool-article h2 { font-size: 1.35rem; font-weight: 800; margin: 1.8rem 0 .6rem; }
.tool-article p { font-size: 1.05rem; line-height: 1.85; margin: 0 0 .8rem; color: var(--text-muted, #555); }
.tool-article ul, .tool-article ol { font-size: 1.05rem; line-height: 1.85; color: var(--text-muted, #555); padding-left: 0; list-style-position: inside; margin: 0 0 1rem; }
.tool-article li { margin-bottom: .35rem; }
.ta-table { width: 100%; border-collapse: collapse; margin: 1rem 0 1.4rem; font-size: 1rem; }
.ta-table th { background: var(--accent-color, #6366f1); color: #fff; padding: .55rem .9rem; text-align: left; font-weight: 700; }
.ta-table td { padding: .5rem .9rem; border-bottom: 1px solid var(--border, #e5e7eb); color: var(--text-muted, #555); }
.ta-table tr:last-child td { border-bottom: none; }
.ta-table tr:nth-child(even) td { background: rgba(0,0,0,.03); }
.ta-box { background: var(--card, #f9fafb); border: 1.5px solid var(--border, #e5e7eb); border-radius: 12px; padding: 1rem 1.2rem; margin: 1rem 0 1.4rem; font-size: 1.02rem; }
.ta-box strong { display: block; margin-bottom: .4rem; font-size: .82rem; text-transform: uppercase; letter-spacing: .06em; color: var(--accent-color, #6366f1); }
.share-row { display: flex; align-items: center; gap: .6rem; flex-wrap: wrap; margin-top: 2rem; padding-top: 1.2rem; border-top: 1px solid var(--border, #e5e7eb); }
.share-row span { font-size: .82rem; font-weight: 700; color: var(--text-muted, #888); margin-right: .2rem; }
.share-icon-btn { display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 50%; border: 1.5px solid var(--border, #e5e7eb); background: transparent; cursor: pointer; font-size: .9rem; color: var(--text-muted, #555); text-decoration: none; transition: all .15s; }
.share-icon-btn:hover { border-color: var(--accent-color, #6366f1); color: var(--accent-color, #6366f1); transform: translateY(-2px); }
.share-icon-btn.copy-btn { font-size: .75rem; width: auto; padding: 0 .8rem; border-radius: 50px; gap: .3rem; }
</style>

<nav class="breadcrumb" aria-label="Breadcrumb">
  <a href="/">Home</a>
  <span class="bc-sep">›</span>
  <a href="/math-tools">Math Tools</a>
  <span class="bc-sep">›</span>
  <span>Ratio Calculator</span>
</nav>
<div class="tool-page-layout" style="max-width:1100px;width:100%;margin:0 auto;padding:24px 24px 48px;box-sizing:border-box;">
<div class="tool-nav-row">
  <a href="/math-tools/gcf-lcm-calculator" class="tool-nav-card" style="--tnc-color:#c084fc">
    <div class="tool-nav-icon"><i class="fa-solid fa-circle-nodes"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Previous</div><div class="tool-nav-name">GCF & LCM Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-left"></i></div>
  </a>
  <a href="/math-tools/statistics-calculator" class="tool-nav-card tool-nav-next" style="--tnc-color:#6366f1">
    <div class="tool-nav-icon"><i class="fa-solid fa-chart-bar"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Next</div><div class="tool-nav-name">Statistics Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-right"></i></div>
  </a>
</div>
<div class="ratio-page">
  <div class="ratio-main">
    <div class="ratio-hero">
      <h1>Ratio Calculator</h1>
    </div>

    <div class="ratio-card">
      <div class="ratio-equation">
        <div class="ratio-pair">
          <label>A</label>
          <input class="ratio-input" type="number" id="ratioA" value="3" min="0" step="any">
        </div>
        <div class="ratio-colon">:</div>
        <div class="ratio-pair">
          <label>B</label>
          <input class="ratio-input" type="number" id="ratioB" value="4" min="0" step="any">
        </div>
        <div class="ratio-equals">=</div>
        <div class="ratio-pair">
          <label>C</label>
          <input class="ratio-input" type="number" id="ratioC" value="9" min="0" step="any">
        </div>
        <div class="ratio-colon">:</div>
        <div class="ratio-pair">
          <label>D (find)</label>
          <input class="ratio-unknown" id="ratioD" readonly value="?">
        </div>
      </div>
      <button class="ratio-btn" onclick="calcRatio()"><i class="fa-solid fa-balance-scale" style="margin-right:.4rem;"></i>Solve Proportion</button>
    </div>

    <div class="scale-wrap">
      <h3><i class="fa-solid fa-scale-balanced" style="margin-right:.3rem;"></i>Balance Scale</h3>
      <svg id="scaleSvg" height="180" viewBox="0 0 380 180"></svg>
    </div>

    <div class="result-box" id="resultBox">
      <div class="result-label">Missing Value (D)</div>
      <div class="result-value" id="resultVal">-</div>
      <div class="result-formula" id="resultFormula"></div>
      <div class="balanced-badge" id="balancedBadge"></div>
    </div>
  </div>
</div>

<script>
(function(){
  let currentTilt = 0;

  function drawScale(tilt) {
    const svg = document.getElementById('scaleSvg');
    svg.innerHTML = '';
    const W = 380, H = 180;
    const cx = 190, poleTop = 30, poleBot = 100;
    const beamLen = 130;
    const angle = Math.max(-25, Math.min(25, tilt));
    const rad = angle * Math.PI / 180;

    // Pole
    const pole = document.createElementNS('http://www.w3.org/2000/svg','line');
    pole.setAttribute('x1', cx); pole.setAttribute('y1', poleTop);
    pole.setAttribute('x2', cx); pole.setAttribute('y2', poleBot);
    pole.setAttribute('stroke', '#2dd4bf'); pole.setAttribute('stroke-width', '3');
    svg.appendChild(pole);

    // Pivot circle
    const pivot = document.createElementNS('http://www.w3.org/2000/svg','circle');
    pivot.setAttribute('cx', cx); pivot.setAttribute('cy', poleTop);
    pivot.setAttribute('r', 6); pivot.setAttribute('fill', '#14b8a6');
    svg.appendChild(pivot);

    // Beam
    const lx = cx - Math.cos(rad) * beamLen;
    const ly = poleTop + Math.sin(rad) * beamLen;
    const rx = cx + Math.cos(rad) * beamLen;
    const ry = poleTop - Math.sin(rad) * beamLen;

    const beam = document.createElementNS('http://www.w3.org/2000/svg','line');
    beam.setAttribute('x1', lx); beam.setAttribute('y1', ly);
    beam.setAttribute('x2', rx); beam.setAttribute('y2', ry);
    beam.setAttribute('stroke', angle === 0 ? '#4ade80' : '#2dd4bf');
    beam.setAttribute('stroke-width', '3.5');
    svg.appendChild(beam);

    // Left pan (hangs from left end)
    const lPanY = ly + 40;
    const rPanY = ry + 40;
    const panW = 70, panH = 12;

    const lString = document.createElementNS('http://www.w3.org/2000/svg','line');
    lString.setAttribute('x1', lx); lString.setAttribute('y1', ly);
    lString.setAttribute('x2', lx); lString.setAttribute('y2', lPanY);
    lString.setAttribute('stroke', '#5eead4'); lString.setAttribute('stroke-width', '1.5');
    svg.appendChild(lString);

    const rString = document.createElementNS('http://www.w3.org/2000/svg','line');
    rString.setAttribute('x1', rx); rString.setAttribute('y1', ry);
    rString.setAttribute('x2', rx); rString.setAttribute('y2', rPanY);
    rString.setAttribute('stroke', '#5eead4'); rString.setAttribute('stroke-width', '1.5');
    svg.appendChild(rString);

    const lPan = document.createElementNS('http://www.w3.org/2000/svg','ellipse');
    lPan.setAttribute('cx', lx); lPan.setAttribute('cy', lPanY);
    lPan.setAttribute('rx', panW/2); lPan.setAttribute('ry', panH/2);
    lPan.setAttribute('fill', '#122626'); lPan.setAttribute('stroke', '#14b8a6'); lPan.setAttribute('stroke-width', '2');
    svg.appendChild(lPan);

    const rPan = document.createElementNS('http://www.w3.org/2000/svg','ellipse');
    rPan.setAttribute('cx', rx); rPan.setAttribute('cy', rPanY);
    rPan.setAttribute('rx', panW/2); rPan.setAttribute('ry', panH/2);
    rPan.setAttribute('fill', '#122626'); rPan.setAttribute('stroke', '#14b8a6'); rPan.setAttribute('stroke-width', '2');
    svg.appendChild(rPan);

    // A:B label on left pan
    const a = document.getElementById('ratioA').value || '?';
    const b = document.getElementById('ratioB').value || '?';
    const lt = document.createElementNS('http://www.w3.org/2000/svg','text');
    lt.setAttribute('x', lx); lt.setAttribute('y', lPanY + 22);
    lt.setAttribute('text-anchor', 'middle'); lt.setAttribute('font-size', '13');
    lt.setAttribute('font-weight', '800'); lt.setAttribute('fill', '#2dd4bf');
    lt.textContent = `${a}:${b}`; svg.appendChild(lt);

    const c = document.getElementById('ratioC').value || '?';
    const d = document.getElementById('ratioD').value;
    const rt = document.createElementNS('http://www.w3.org/2000/svg','text');
    rt.setAttribute('x', rx); rt.setAttribute('y', rPanY + 22);
    rt.setAttribute('text-anchor', 'middle'); rt.setAttribute('font-size', '13');
    rt.setAttribute('font-weight', '800'); rt.setAttribute('fill', '#2dd4bf');
    rt.textContent = `${c}:${d}`; svg.appendChild(rt);

    // Base
    const base = document.createElementNS('http://www.w3.org/2000/svg','rect');
    base.setAttribute('x', cx - 15); base.setAttribute('y', poleBot);
    base.setAttribute('width', 30); base.setAttribute('height', 8);
    base.setAttribute('fill', '#14b8a6'); base.setAttribute('rx', 3);
    svg.appendChild(base);

    if(angle === 0) {
      const balanced = document.createElementNS('http://www.w3.org/2000/svg','text');
      balanced.setAttribute('x', cx); balanced.setAttribute('y', H - 10);
      balanced.setAttribute('text-anchor', 'middle'); balanced.setAttribute('font-size', '13');
      balanced.setAttribute('font-weight', '800'); balanced.setAttribute('fill', '#4ade80');
      balanced.textContent = '⚖ Balanced!'; svg.appendChild(balanced);
    }
  }

  window.calcRatio = function() {
    const a = parseFloat(document.getElementById('ratioA').value);
    const b = parseFloat(document.getElementById('ratioB').value);
    const c = parseFloat(document.getElementById('ratioC').value);

    if(isNaN(a) || isNaN(b) || isNaN(c)) { alert('Please enter values for A, B, and C!'); return; }
    if(a === 0) { alert('A cannot be zero!'); return; }

    const d = (b * c) / a;

    document.getElementById('ratioD').value = parseFloat(d.toFixed(4));

    // Animate scale to balanced
    const aRatio = a/b;
    const cRatio = c/d;
    const diff = aRatio - cRatio;
    let tilt = diff * 20;
    tilt = Math.max(-25, Math.min(25, tilt));

    // First show unbalanced
    drawScale(tilt);
    setTimeout(() => {
      // Then balance
      let current = tilt;
      const target = 0;
      const steps = 30;
      let step = 0;
      const interval = setInterval(() => {
        step++;
        current = tilt * (1 - step/steps);
        drawScale(current);
        if(step >= steps) {
          clearInterval(interval);
          drawScale(0);
        }
      }, 16);
    }, 600);

    document.getElementById('resultVal').textContent = parseFloat(d.toFixed(4));
    document.getElementById('resultFormula').textContent = `${a} : ${b} = ${c} : ${d.toFixed(4)}    →    D = (B × C) ÷ A = (${b} × ${c}) ÷ ${a}`;
    document.getElementById('balancedBadge').textContent = `⚖ Ratio verified: ${a}/${b} = ${c}/${d.toFixed(4)}`;

    const res = document.getElementById('resultBox');
    res.style.display = 'block';
    res.style.animation = 'none';
    res.offsetHeight;
    res.style.animation = 'popIn .5s cubic-bezier(.175,.885,.32,1.275)';
  };

  drawScale(0);

  document.querySelectorAll('.ratio-input').forEach(input => {
    input.addEventListener('keydown', e => { if(e.key === 'Enter') calcRatio(); });
  });
})();

function shareThisPage() {
  if (navigator.share) {
    navigator.share({ title: document.title, url: location.href });
  } else {
    navigator.clipboard.writeText(location.href).then(() => {
      var btn = document.querySelector('.tool-share-btn');
      var orig = btn.innerHTML;
      btn.innerHTML = '<i class="fa-solid fa-check"></i> Copied!';
      setTimeout(function(){ btn.innerHTML = orig; }, 2000);
    });
  }
}
</script>
<section class="tool-article" style="--accent-color:#14b8a6">

  <h2>How to Use This Calculator</h2>
  <p>Enter the two numbers that make up your ratio in the A and B fields. Press Calculate to see the simplified ratio, decimal equivalents, and a visual bar comparison. If you want to find a missing value in a proportion, use the proportion mode: enter three of the four values and the tool solves for the fourth.</p>

  <h2>What a Ratio Tells You</h2>
  <p>A ratio is a comparison of two quantities. If a recipe calls for 2 cups of flour and 1 cup of sugar, the ratio of flour to sugar is 2:1. That means for every 1 cup of sugar, you use 2 cups of flour.</p>
  <p>Order matters in a ratio. The ratio 3:4 is not the same as 4:3. Writing the ratio out of order gives you a completely different comparison. Always read the question carefully to know which quantity goes first.</p>

  <h2>Equivalent Ratios</h2>
  <p>Equivalent ratios represent the same relationship at different scales. 1:2 and 3:6 and 10:20 are all equivalent. You scale ratios up or down by multiplying or dividing both parts by the same number, just like simplifying fractions.</p>
  <p>To check if two ratios are equivalent, simplify both down to their lowest terms and compare. If they match, they are equivalent.</p>

  <h2>Solving Proportions</h2>
  <p>A proportion says two ratios are equal: a/b = c/d. To find a missing value, use cross-multiplication. Multiply the diagonal pairs and set them equal.</p>
  <div class="ta-box">
    <strong>Example: 3/4 = x/12</strong>
    Cross-multiply: 3 x 12 = 4 x x. So 36 = 4x. Divide both sides by 4: x = 9.
  </div>

  <h2>Ratios in Real Life</h2>
  <table class="ta-table">
    <thead><tr><th>Situation</th><th>How Ratios Are Used</th></tr></thead>
    <tbody>
      <tr><td>Recipe scaling</td><td>Double or halve every ingredient by the same ratio</td></tr>
      <tr><td>Map distances</td><td>Scale ratio like 1:50,000 converts map to real distance</td></tr>
      <tr><td>Screen resolution</td><td>Aspect ratio like 16:9 describes width to height</td></tr>
      <tr><td>Mixing paint or concrete</td><td>Fixed part ratios ensure consistent results every time</td></tr>
    </tbody>
  </table>

  <h2>Common Mistakes to Avoid</h2>
  <ul>
    <li>Reversing the order of a:b. The first number in the ratio matches the first item mentioned in the problem.</li>
    <li>Forgetting to simplify. A ratio like 12:8 should be reduced to 3:2.</li>
    <li>Mixing up the missing value position in proportions. Label your values a, b, c, d to stay organised.</li>
    <li>Treating a ratio as a fraction and dividing when the question wants a ratio. Know what the question is actually asking for.</li>
  </ul>

  </section>

<div class="tool-nav-row">
  <a href="/math-tools/gcf-lcm-calculator" class="tool-nav-card" style="--tnc-color:#c084fc">
    <div class="tool-nav-icon"><i class="fa-solid fa-circle-nodes"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Previous</div><div class="tool-nav-name">GCF & LCM Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-left"></i></div>
  </a>
  <a href="/math-tools/statistics-calculator" class="tool-nav-card tool-nav-next" style="--tnc-color:#6366f1">
    <div class="tool-nav-icon"><i class="fa-solid fa-chart-bar"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Next</div><div class="tool-nav-name">Statistics Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-right"></i></div>
  </a>
</div>

<div class="topic-quiz" id="tool-quiz">
  <div class="quiz-header" style="background:#06b6d4">
    <i class="fa-solid fa-circle-question"></i> Quick Quiz
    <span class="quiz-sub">3 questions</span>
  </div>
  <div class="quiz-body">
    <div class="quiz-q" data-qi="0" data-correct="0">
      <p class="quiz-question"><strong>Q1.</strong> Simplify the ratio 12:16</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">3:4</button>
        <button class="quiz-opt" data-oi="1">4:5</button>
        <button class="quiz-opt" data-oi="2">6:8</button>
        <button class="quiz-opt" data-oi="3">2:3</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="1" data-correct="1">
      <p class="quiz-question"><strong>Q2.</strong> If 3:x = 6:10, what is x?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">3</button>
        <button class="quiz-opt" data-oi="1">5</button>
        <button class="quiz-opt" data-oi="2">6</button>
        <button class="quiz-opt" data-oi="3">8</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="2" data-correct="1">
      <p class="quiz-question"><strong>Q3.</strong> A recipe uses flour and sugar in ratio 3:1. For 120g flour, how much sugar?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">30g</button>
        <button class="quiz-opt" data-oi="1">40g</button>
        <button class="quiz-opt" data-oi="2">60g</button>
        <button class="quiz-opt" data-oi="3">90g</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-score" style="display:none">
      <div class="quiz-score-inner">
        <div class="quiz-score-icon"><i class="fa-solid fa-trophy"></i></div>
        <div class="quiz-score-text">You scored <strong class="quiz-score-num">0</strong> / 3</div>
        <button class="quiz-retry-btn">Try Again</button>
      </div>
    </div>
  </div>
</div>
</div><!-- /tool-page-layout -->

<?php include __DIR__ . '/../_footer.php'; ?>
