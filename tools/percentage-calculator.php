<?php require_once __DIR__ . '/../config.php'; $page_title = 'Percentage Calculator'; $page_desc = 'Calculate percentages, percentage change, and what percent one number is of another - with animated visual rings.'; $body_class = 'page-article'; include __DIR__ . '/../_header.php'; ?>

<style>
.pct-page { background: #0d1f1f; min-height: 60vh; padding: 2rem 1rem; color: #e2f8f5; font-family: 'Segoe UI', sans-serif; border-radius: 16px; overflow: hidden; max-width: 900px; margin-left: auto; margin-right: auto; }
.pct-hero { text-align: center; margin-bottom: 2rem; }
.pct-hero h1 { color: #e2f8f5; font-size: 2.2rem; font-weight: 800; margin: 0; text-shadow: 0 0 20px #14b8a655; }
.pct-hero p { color: #5eead4; font-size: 1.05rem; margin-top: .4rem; }
.pct-main { max-width: 700px; margin: 0 auto; }
.pct-tabs { display: flex; gap: .5rem; background: #0a1a1a; border-radius: 14px; padding: .4rem; margin-bottom: 2rem; }
.pct-tab { flex: 1; text-align: center; padding: .65rem .5rem; border-radius: 10px; cursor: pointer; font-size: .8rem; font-weight: 700; color: #5eead4; transition: all .2s; border: none; background: transparent; }
.pct-tab.active { background: #14b8a6; color: #0d1f1f; box-shadow: 0 4px 12px #14b8a655; }
.pct-tab:hover:not(.active) { background: #1a3535; }
.pct-panel { display: none; }
.pct-panel.active { display: block; }
.pct-card { background: #122626; border: 1.5px solid #1d4040; border-radius: 20px; padding: 2rem; }
.pct-ring-wrap { display: flex; flex-direction: column; align-items: center; margin: 1.5rem 0; position: relative; }
.ring-container { position: relative; width: 200px; height: 200px; }
.ring-container svg { transform: rotate(-90deg); }
.ring-bg { fill: none; stroke: #1d4040; stroke-width: 18; }
.ring-fill { fill: none; stroke: #14b8a6; stroke-width: 18; stroke-linecap: round; transition: stroke-dashoffset 1s cubic-bezier(.4,0,.2,1), stroke .5s; filter: drop-shadow(0 0 8px #14b8a688); }
.ring-text { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; }
.ring-number { font-size: 2.8rem; font-weight: 900; color: #2dd4bf; line-height: 1; }
.ring-unit { font-size: 1rem; color: #5eead4; font-weight: 600; }
.pct-fields { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.2rem; }
.pct-fields.single { grid-template-columns: 1fr; }
.pct-field { display: flex; flex-direction: column; gap: .3rem; }
.pct-field label { font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #5eead4; }
.pct-field input { background: #0d1f1f; border: 1.5px solid #1d4040; color: #e2f8f5; font-size: 1.4rem; font-weight: 700; border-radius: 10px; padding: .65rem 1rem; outline: none; transition: border-color .2s; width: 100%; box-sizing: border-box; }
.pct-field input:focus { border-color: #14b8a6; box-shadow: 0 0 0 3px #14b8a622; }
.pct-btn { width: 100%; background: linear-gradient(135deg, #14b8a6, #0d9488); color: #fff; font-size: 1.1rem; font-weight: 700; border: none; border-radius: 12px; padding: 1rem; cursor: pointer; box-shadow: 0 4px 16px #14b8a644; transition: all .2s; letter-spacing: .04em; margin-top: .5rem; }
.pct-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px #14b8a666; }
.pct-result-box { background: #0a1a1a; border: 1.5px solid #14b8a655; border-radius: 14px; padding: 1.2rem 1.5rem; margin-top: 1.2rem; display: none; animation: slideUp .4s ease; }
@keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.pct-result-label { font-size: .75rem; font-weight: 700; text-transform: uppercase; color: #5eead4; margin-bottom: .3rem; }
.pct-result-value { font-size: 2.5rem; font-weight: 900; color: #2dd4bf; text-shadow: 0 0 16px #2dd4bf55; }
.pct-result-note { font-size: .9rem; color: #5eead4; margin-top: .3rem; }
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
  <span>Percentage Calculator</span>
</nav>
<div class="tool-page-layout" style="max-width:1100px;width:100%;margin:0 auto;padding:24px 24px 48px;box-sizing:border-box;">
<div class="tool-nav-row">
  <a href="/math-tools/fraction-calculator" class="tool-nav-card" style="--tnc-color:#c084fc">
    <div class="tool-nav-icon"><i class="fa-solid fa-divide"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Previous</div><div class="tool-nav-name">Fraction Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-left"></i></div>
  </a>
  <a href="/math-tools/unit-converter" class="tool-nav-card tool-nav-next" style="--tnc-color:#6366f1">
    <div class="tool-nav-icon"><i class="fa-solid fa-arrows-left-right"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Next</div><div class="tool-nav-name">Unit Converter</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-right"></i></div>
  </a>
</div>
<div class="pct-page">
  <div class="pct-main">
    <div class="pct-hero">
      <h1>Percentage Calculator</h1>
    </div>

    <div class="pct-card">
      <div class="pct-tabs">
        <button class="pct-tab active" data-panel="find">Find Percentage</button>
        <button class="pct-tab" data-panel="change">Percentage Change</button>
        <button class="pct-tab" data-panel="what">What Percent?</button>
      </div>

      <!-- Panel 1: Find Percentage -->
      <div class="pct-panel active" id="panel-find">
        <div class="pct-ring-wrap">
          <div class="ring-container">
            <svg width="200" height="200" viewBox="0 0 200 200">
              <circle class="ring-bg" cx="100" cy="100" r="82"/>
              <circle class="ring-fill" id="ring1" cx="100" cy="100" r="82" stroke-dasharray="515.22" stroke-dashoffset="515.22"/>
            </svg>
            <div class="ring-text">
              <div class="ring-number" id="ring1-num">0</div>
              <div class="ring-unit">%</div>
            </div>
          </div>
        </div>
        <div class="pct-fields">
          <div class="pct-field">
            <label>Percentage (%)</label>
            <input type="number" id="f-pct" placeholder="e.g. 25" min="0" max="100" step="any">
          </div>
          <div class="pct-field">
            <label>Of Number</label>
            <input type="number" id="f-num" placeholder="e.g. 200" step="any">
          </div>
        </div>
        <button class="pct-btn" onclick="calcFind()"><i class="fa-solid fa-calculator" style="margin-right:.4rem;"></i>Calculate</button>
        <div class="pct-result-box" id="res-find">
          <div class="pct-result-label">Result</div>
          <div class="pct-result-value" id="res-find-val">-</div>
          <div class="pct-result-note" id="res-find-note"></div>
        </div>
      </div>

      <!-- Panel 2: Percentage Change -->
      <div class="pct-panel" id="panel-change">
        <div class="pct-ring-wrap">
          <div class="ring-container">
            <svg width="200" height="200" viewBox="0 0 200 200">
              <circle class="ring-bg" cx="100" cy="100" r="82"/>
              <circle class="ring-fill" id="ring2" cx="100" cy="100" r="82" stroke-dasharray="515.22" stroke-dashoffset="515.22"/>
            </svg>
            <div class="ring-text">
              <div class="ring-number" id="ring2-num">0</div>
              <div class="ring-unit" id="ring2-unit">%</div>
            </div>
          </div>
        </div>
        <div class="pct-fields">
          <div class="pct-field">
            <label>Original Value</label>
            <input type="number" id="c-orig" placeholder="e.g. 80" step="any">
          </div>
          <div class="pct-field">
            <label>New Value</label>
            <input type="number" id="c-new" placeholder="e.g. 100" step="any">
          </div>
        </div>
        <button class="pct-btn" onclick="calcChange()"><i class="fa-solid fa-arrow-trend-up" style="margin-right:.4rem;"></i>Calculate Change</button>
        <div class="pct-result-box" id="res-change">
          <div class="pct-result-label">Percentage Change</div>
          <div class="pct-result-value" id="res-change-val">-</div>
          <div class="pct-result-note" id="res-change-note"></div>
        </div>
      </div>

      <!-- Panel 3: What Percent -->
      <div class="pct-panel" id="panel-what">
        <div class="pct-ring-wrap">
          <div class="ring-container">
            <svg width="200" height="200" viewBox="0 0 200 200">
              <circle class="ring-bg" cx="100" cy="100" r="82"/>
              <circle class="ring-fill" id="ring3" cx="100" cy="100" r="82" stroke-dasharray="515.22" stroke-dashoffset="515.22"/>
            </svg>
            <div class="ring-text">
              <div class="ring-number" id="ring3-num">0</div>
              <div class="ring-unit">%</div>
            </div>
          </div>
        </div>
        <div class="pct-fields">
          <div class="pct-field">
            <label>Part</label>
            <input type="number" id="w-part" placeholder="e.g. 30" step="any">
          </div>
          <div class="pct-field">
            <label>Whole / Total</label>
            <input type="number" id="w-whole" placeholder="e.g. 120" step="any">
          </div>
        </div>
        <button class="pct-btn" onclick="calcWhat()"><i class="fa-solid fa-question" style="margin-right:.4rem;"></i>Find Percent</button>
        <div class="pct-result-box" id="res-what">
          <div class="pct-result-label">Answer</div>
          <div class="pct-result-value" id="res-what-val">-</div>
          <div class="pct-result-note" id="res-what-note"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const CIRC = 2 * Math.PI * 82; // 515.22

  document.querySelectorAll('.pct-tab').forEach(tab => {
    tab.addEventListener('click', () => {
      document.querySelectorAll('.pct-tab').forEach(t => t.classList.remove('active'));
      document.querySelectorAll('.pct-panel').forEach(p => p.classList.remove('active'));
      tab.classList.add('active');
      document.getElementById('panel-' + tab.dataset.panel).classList.add('active');
    });
  });

  function animateRing(ringId, numId, pct, color) {
    const ring = document.getElementById(ringId);
    const numEl = document.getElementById(numId);
    const clampedPct = Math.max(0, Math.min(100, Math.abs(pct)));
    const offset = CIRC - (clampedPct / 100) * CIRC;
    ring.style.strokeDashoffset = offset;
    ring.style.stroke = color || '#14b8a6';
    let current = 0;
    const target = Math.round(pct * 100) / 100;
    const duration = 1000;
    const startTime = performance.now();
    function update(now) {
      const elapsed = now - startTime;
      const progress = Math.min(elapsed / duration, 1);
      const ease = 1 - Math.pow(1 - progress, 3);
      current = target * ease;
      numEl.textContent = current.toFixed(current % 1 === 0 ? 0 : 1);
      if(progress < 1) requestAnimationFrame(update);
      else numEl.textContent = target % 1 === 0 ? target : target.toFixed(2);
    }
    requestAnimationFrame(update);
  }

  function showResult(boxId, val, note) {
    const box = document.getElementById(boxId);
    box.style.display = 'block';
    box.style.animation = 'none';
    box.offsetHeight;
    box.style.animation = 'slideUp .4s ease';
    document.getElementById(boxId + '-val').textContent = val;
    if(note) document.getElementById(boxId + '-note').textContent = note;
  }

  window.calcFind = function() {
    const pct = parseFloat(document.getElementById('f-pct').value);
    const num = parseFloat(document.getElementById('f-num').value);
    if(isNaN(pct) || isNaN(num)) { alert('Please enter both values!'); return; }
    const result = (pct / 100) * num;
    animateRing('ring1', 'ring1-num', pct, '#14b8a6');
    showResult('res-find', result.toLocaleString('en', {maximumFractionDigits:4}),
      `${pct}% of ${num} = ${result.toFixed(4).replace(/\.?0+$/,'')}`);
  };

  window.calcChange = function() {
    const orig = parseFloat(document.getElementById('c-orig').value);
    const newVal = parseFloat(document.getElementById('c-new').value);
    if(isNaN(orig) || isNaN(newVal)) { alert('Please enter both values!'); return; }
    if(orig === 0) { alert('Original value cannot be zero!'); return; }
    const change = ((newVal - orig) / Math.abs(orig)) * 100;
    const isIncrease = change >= 0;
    const color = isIncrease ? '#14b8a6' : '#f43f5e';
    document.getElementById('ring2-unit').textContent = isIncrease ? '% ↑' : '% ↓';
    animateRing('ring2', 'ring2-num', Math.abs(change), color);
    document.getElementById('ring2').style.stroke = color;
    const sign = isIncrease ? '+' : '';
    showResult('res-change', sign + change.toFixed(2) + '%',
      isIncrease ? `Increased from ${orig} to ${newVal}` : `Decreased from ${orig} to ${newVal}`);
    document.getElementById('res-change-val').style.color = color;
  };

  window.calcWhat = function() {
    const part = parseFloat(document.getElementById('w-part').value);
    const whole = parseFloat(document.getElementById('w-whole').value);
    if(isNaN(part) || isNaN(whole)) { alert('Please enter both values!'); return; }
    if(whole === 0) { alert('Total cannot be zero!'); return; }
    const pct = (part / whole) * 100;
    animateRing('ring3', 'ring3-num', pct, '#2dd4bf');
    showResult('res-what', pct.toFixed(2) + '%', `${part} is ${pct.toFixed(2)}% of ${whole}`);
  };
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
  <p>This calculator has three tabs. Each one solves a different type of percentage problem. Pick the tab that matches your question, fill in the numbers, and press Calculate.</p>
  <ol>
    <li><strong>Find Percentage:</strong> Enter a percentage and a number to find what that percentage of the number is. Example: 20% of 85.</li>
    <li><strong>What Percent:</strong> Enter a part and a whole to find what percent the part is of the whole. Example: 30 is what percent of 120?</li>
    <li><strong>Percentage Change:</strong> Enter an original value and a new value to find how much it changed as a percentage. Example: change from 50 to 65.</li>
  </ol>

  <h2>What Percentages Really Are</h2>
  <p>The word "percent" comes from the Latin phrase "per centum," which means per hundred. So when you say 45%, you are really saying 45 out of every 100. That is all it is.</p>
  <p>Percentages connect directly to fractions and decimals. 45% equals 45/100, which equals 0.45. These three forms all say the same thing. Knowing that helps you switch between them easily. 50% is the same as one half. 25% is the same as one quarter. 10% is just divide by 10.</p>

  <h2>Common Percentage Formulas</h2>
  <table class="ta-table">
    <thead><tr><th>What You Want to Find</th><th>Formula</th><th>Example</th></tr></thead>
    <tbody>
      <tr><td>Percentage of a number</td><td>(P / 100) x N</td><td>20% of 85 = 0.20 x 85 = 17</td></tr>
      <tr><td>What percent is X of Y</td><td>(Part / Whole) x 100</td><td>30 / 120 x 100 = 25%</td></tr>
      <tr><td>Percentage change</td><td>(New - Old) / Old x 100</td><td>(65 - 50) / 50 x 100 = 30%</td></tr>
      <tr><td>Percentage increase</td><td>Old x (1 + P/100)</td><td>50 x 1.30 = 65</td></tr>
      <tr><td>Percentage decrease</td><td>Old x (1 - P/100)</td><td>80 x 0.75 = 60</td></tr>
    </tbody>
  </table>

  <h2>Worked Examples</h2>
  <div class="ta-box">
    <strong>Example 1: 20% of 85</strong>
    Use formula: (20 / 100) x 85 = 0.20 x 85 = 17. Answer: 17.
  </div>
  <div class="ta-box">
    <strong>Example 2: 30 is what percent of 120?</strong>
    Use formula: (30 / 120) x 100 = 0.25 x 100 = 25%. Answer: 25%.
  </div>
  <div class="ta-box">
    <strong>Example 3: Change from 50 to 65</strong>
    Use formula: (65 - 50) / 50 x 100 = 15 / 50 x 100 = 30% increase.
  </div>

  <h2>Common Mistakes to Avoid</h2>
  <ul>
    <li>Confusing "percent of" with "percent change." They use different formulas.</li>
    <li>Using the wrong base when calculating percent change. Always divide by the original, not the new value.</li>
    <li>Forgetting to multiply by 100 at the end. The fraction (Part/Whole) gives a decimal, not a percent.</li>
    <li>Thinking 100% more means doubling the percentage. It means doubling the original number.</li>
  </ul>

  </section>

<div class="tool-nav-row">
  <a href="/math-tools/fraction-calculator" class="tool-nav-card" style="--tnc-color:#c084fc">
    <div class="tool-nav-icon"><i class="fa-solid fa-divide"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Previous</div><div class="tool-nav-name">Fraction Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-left"></i></div>
  </a>
  <a href="/math-tools/unit-converter" class="tool-nav-card tool-nav-next" style="--tnc-color:#6366f1">
    <div class="tool-nav-icon"><i class="fa-solid fa-arrows-left-right"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Next</div><div class="tool-nav-name">Unit Converter</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-right"></i></div>
  </a>
</div>

<div class="topic-quiz" id="tool-quiz">
  <div class="quiz-header" style="background:#14b8a6">
    <i class="fa-solid fa-circle-question"></i> Quick Quiz
    <span class="quiz-sub">3 questions</span>
  </div>
  <div class="quiz-body">
    <div class="quiz-q" data-qi="0" data-correct="1">
      <p class="quiz-question"><strong>Q1.</strong> What is 25% of 80?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">15</button>
        <button class="quiz-opt" data-oi="1">20</button>
        <button class="quiz-opt" data-oi="2">25</button>
        <button class="quiz-opt" data-oi="3">30</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="1" data-correct="1">
      <p class="quiz-question"><strong>Q2.</strong> If a $50 item is 10% off, what is the sale price?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">$40</button>
        <button class="quiz-opt" data-oi="1">$45</button>
        <button class="quiz-opt" data-oi="2">$48</button>
        <button class="quiz-opt" data-oi="3">$35</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="2" data-correct="1">
      <p class="quiz-question"><strong>Q3.</strong> What percentage is 30 out of 120?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">20%</button>
        <button class="quiz-opt" data-oi="1">25%</button>
        <button class="quiz-opt" data-oi="2">30%</button>
        <button class="quiz-opt" data-oi="3">40%</button>
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
