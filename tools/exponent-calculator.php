<?php require_once __DIR__ . '/../config.php'; $page_title = 'Exponent Calculator'; $page_desc = 'Calculate powers and exponents with an animated visual grid that shows base × base × base multiplication.'; $body_class = 'page-article'; include __DIR__ . '/../_header.php'; ?>

<style>
.exp-page { background: #1a2038; min-height: 60vh; padding: 2rem 1rem; color: #c8d4f0; font-family: 'Segoe UI', sans-serif; border-radius: 16px; overflow: hidden; max-width: 900px; margin-left: auto; margin-right: auto; }
.exp-hero { text-align: center; margin-bottom: 2rem; }
.exp-hero h1 { color: #c8d4f0; font-size: 2.2rem; font-weight: 800; margin: 0; text-shadow: 0 0 20px #f5a62344; }
.exp-hero p { color: #7c8bb0; font-size: 1.05rem; margin-top: .4rem; }
.exp-main { max-width: 700px; margin: 0 auto; }
.exp-display { background: #222840; border-radius: 20px; border: 1.5px solid #2e3a5c; padding: 2.5rem 2rem; text-align: center; margin-bottom: 1.5rem; }
.exp-visual-num { font-size: 5rem; font-weight: 900; color: #f5a623; line-height: 1; display: inline-flex; align-items: flex-start; gap: .2rem; text-shadow: 0 0 30px #f5a62355; }
.exp-visual-num sup { font-size: 2.5rem; color: #ffd700; margin-top: .3rem; text-shadow: 0 0 16px #ffd70088; }
.exp-equals { color: #7c8bb0; font-size: 2rem; margin: .5rem 0; }
.exp-result-num { font-size: 3rem; font-weight: 900; color: #2dd4bf; text-shadow: 0 0 16px #2dd4bf55; }
.exp-controls { background: #222840; border-radius: 20px; border: 1.5px solid #2e3a5c; padding: 1.5rem; margin-bottom: 1.5rem; display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.exp-input-group { display: flex; flex-direction: column; gap: .4rem; }
.exp-input-group label { font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #7c8bb0; }
.exp-input { background: #1a2038; border: 2px solid #2e3a5c; color: #c8d4f0; font-size: 2rem; font-weight: 800; border-radius: 12px; padding: .5rem .8rem; outline: none; text-align: center; transition: border-color .2s; width: 100%; box-sizing: border-box; }
.exp-input:focus { border-color: #f5a623; box-shadow: 0 0 0 3px #f5a62322; }
.exp-btn { grid-column: span 2; background: linear-gradient(135deg, #f5a623, #e8901a); color: #1a2038; font-size: 1.05rem; font-weight: 800; border: none; border-radius: 12px; padding: .9rem; cursor: pointer; transition: all .2s; }
.exp-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px #f5a62355; }
.exp-grid-wrap { background: #222840; border-radius: 20px; border: 1.5px solid #2e3a5c; padding: 1.5rem; }
.exp-grid-wrap h3 { font-size: .78rem; font-weight: 700; text-transform: uppercase; color: #f5a623; letter-spacing: .07em; margin: 0 0 1rem; }
#expGrid { display: flex; flex-wrap: wrap; gap: 4px; min-height: 60px; }
.exp-square { width: 28px; height: 28px; border-radius: 5px; display: flex; align-items: center; justify-content: center; font-size: .65rem; font-weight: 800; transition: all .2s; animation: squarePop .25s cubic-bezier(.175,.885,.32,1.275) backwards; }
@keyframes squarePop { from { opacity: 0; transform: scale(0); } to { opacity: 1; transform: scale(1); } }
.exp-grid-note { font-size: .82rem; color: #7c8bb0; margin-top: .8rem; }
.steps-box { background: #1a2038; border-radius: 12px; border: 1.5px solid #2e3a5c; padding: 1rem 1.3rem; margin-top: 1rem; }
.steps-box h4 { font-size: .75rem; font-weight: 700; text-transform: uppercase; color: #f5a623; letter-spacing: .06em; margin: 0 0 .6rem; }
.step-item { font-size: .88rem; color: #c8d4f0; padding: .3rem 0; border-bottom: 1px solid #2e3a5c; display: flex; gap: .5rem; align-items: center; }
.step-item:last-child { border-bottom: none; }
.step-num { width: 20px; height: 20px; background: #f5a623; border-radius: 50%; color: #1a2038; font-size: .65rem; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
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
  <span>Exponent Calculator</span>
</nav>
<div class="tool-page-layout" style="max-width:1100px;width:100%;margin:0 auto;padding:24px 24px 48px;box-sizing:border-box;">
<div class="tool-nav-row">
  <a href="/math-tools/statistics-calculator" class="tool-nav-card" style="--tnc-color:#6366f1">
    <div class="tool-nav-icon"><i class="fa-solid fa-chart-bar"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Previous</div><div class="tool-nav-name">Statistics Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-left"></i></div>
  </a>
  <a href="/math-tools/roman-numeral-converter" class="tool-nav-card tool-nav-next" style="--tnc-color:#007aff">
    <div class="tool-nav-icon"><i class="fa-solid fa-landmark"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Next</div><div class="tool-nav-name">Roman Numeral Converter</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-right"></i></div>
  </a>
</div>
<div class="exp-page">
  <div class="exp-main">
    <div class="exp-hero">
      <h1>Exponent Calculator</h1>
    </div>

    <div class="exp-display" id="expDisplay">
      <div class="exp-visual-num" id="expVisualNum">
        <span id="baseDisplay">2</span><sup id="expDisplay2">3</sup>
      </div>
      <div class="exp-equals">=</div>
      <div class="exp-result-num" id="expResultNum">8</div>
    </div>

    <div class="exp-controls">
      <div class="exp-input-group">
        <label>Base</label>
        <input class="exp-input" type="number" id="base" value="2" step="1" min="-1000" max="1000">
      </div>
      <div class="exp-input-group">
        <label>Exponent</label>
        <input class="exp-input" type="number" id="exponent" value="3" step="1" min="-10" max="20">
      </div>
      <button class="exp-btn" onclick="calcExponent()"><i class="fa-solid fa-bolt" style="margin-right:.4rem;"></i>Calculate</button>
    </div>

    <div class="exp-grid-wrap">
      <h3><i class="fa-solid fa-grid-2" style="margin-right:.3rem;"></i>Visual Grid</h3>
      <div id="expGrid"></div>
      <div class="exp-grid-note" id="expGridNote">Calculate to see the visual representation</div>
      <div class="steps-box" id="stepsBox" style="display:none;">
        <h4><i class="fa-solid fa-list-ol" style="margin-right:.3rem;"></i>Step-by-Step</h4>
        <div id="stepsContainer"></div>
      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const GRID_COLORS = [
    ['#f5a623','#1a2038'], ['#ffd700','#1a2038'], ['#2dd4bf','#1a2038'],
    ['#818cf8','#1a2038'], ['#f43f5e','#1a2038'], ['#4ade80','#1a2038'],
    ['#fb923c','#1a2038'], ['#a78bfa','#1a2038'], ['#38bdf8','#1a2038'],
    ['#f472b6','#1a2038']
  ];

  function updateDisplay() {
    const base = document.getElementById('base').value || '?';
    const exp = document.getElementById('exponent').value || '?';
    document.getElementById('baseDisplay').textContent = base;
    document.getElementById('expDisplay2').textContent = exp;
  }

  document.getElementById('base').addEventListener('input', updateDisplay);
  document.getElementById('exponent').addEventListener('input', updateDisplay);

  window.calcExponent = function() {
    const base = parseFloat(document.getElementById('base').value);
    const exp = parseInt(document.getElementById('exponent').value);

    if(isNaN(base) || isNaN(exp)) { alert('Please enter valid numbers!'); return; }

    const result = Math.pow(base, exp);

    document.getElementById('baseDisplay').textContent = base;
    document.getElementById('expDisplay2').textContent = exp;

    // Animate result number
    const resultEl = document.getElementById('expResultNum');
    let current = 0;
    const target = result;
    const isSmall = Math.abs(target) < 1e6;
    if(isSmall) {
      let start = null;
      function animNum(ts) {
        if(!start) start = ts;
        const progress = Math.min((ts - start) / 600, 1);
        const ease = 1 - Math.pow(1 - progress, 3);
        resultEl.textContent = parseFloat((target * ease).toFixed(2));
        if(progress < 1) requestAnimationFrame(animNum);
        else resultEl.textContent = result % 1 === 0 ? result : result.toFixed(6);
      }
      requestAnimationFrame(animNum);
    } else {
      resultEl.textContent = result.toExponential(4);
    }

    // Build steps
    const steps = [];
    if(exp === 0) {
      steps.push(`Any number to the power of 0 = 1`);
      steps.push(`${base}⁰ = 1`);
    } else if(exp === 1) {
      steps.push(`Any number to the power of 1 = itself`);
      steps.push(`${base}¹ = ${base}`);
    } else if(exp < 0) {
      steps.push(`Negative exponent: ${base}^${exp} = 1 / ${base}^${Math.abs(exp)}`);
      steps.push(`${base}^${Math.abs(exp)} = ${Math.pow(base, Math.abs(exp))}`);
      steps.push(`Result: 1 / ${Math.pow(base, Math.abs(exp))} = ${result}`);
    } else {
      let mult = base;
      steps.push(`Start: ${base}`);
      for(let i = 2; i <= Math.min(exp, 8); i++) {
        mult *= base;
        steps.push(`× ${base} = ${mult}`);
      }
      if(exp > 8) steps.push(`... (continued) = ${result}`);
    }

    const stepsContainer = document.getElementById('stepsContainer');
    stepsContainer.innerHTML = '';
    steps.forEach((s, i) => {
      const div = document.createElement('div');
      div.className = 'step-item';
      div.innerHTML = `<div class="step-num">${i+1}</div><span>${s}</span>`;
      stepsContainer.appendChild(div);
    });

    const stepsBox = document.getElementById('stepsBox');
    stepsBox.style.display = 'block';

    // Draw grid (only for reasonable cases)
    const grid = document.getElementById('expGrid');
    const gridNote = document.getElementById('expGridNote');
    grid.innerHTML = '';

    const b = Math.abs(Math.round(base));
    const e = Math.abs(exp);

    if(b > 0 && b <= 15 && e >= 1 && e <= 7 && result > 0 && result <= 200) {
      const totalSquares = Math.round(result);
      const groupSize = Math.round(Math.pow(b, e > 1 ? 1 : 0));

      for(let i = 0; i < totalSquares; i++) {
        const sq = document.createElement('div');
        sq.className = 'exp-square';
        const groupIdx = Math.floor(i / b);
        const [bg, fg] = GRID_COLORS[groupIdx % GRID_COLORS.length];
        sq.style.cssText = `background: ${bg}; color: ${fg}; animation-delay: ${i * 20}ms;`;
        if(b <= 6) sq.textContent = base;
        grid.appendChild(sq);
      }
      gridNote.textContent = `${totalSquares} squares = ${base}${'×' + base.toString().repeat(e-1)} (${e} times)`;
    } else if(result > 200) {
      gridNote.textContent = `${base}^${exp} = ${result} - too large to display as grid, but calculated above!`;
      // Show a symbolic representation instead
      const info = document.createElement('div');
      info.style.cssText = 'color:#f5a623;font-size:1.5rem;font-weight:900;padding:.5rem;';
      info.textContent = `${base}` + ' × '.repeat(Math.min(exp-1, 5)) + `${base}` + (exp > 6 ? ` ... (${exp} times)` : '');
      grid.appendChild(info);
    } else {
      gridNote.textContent = 'Grid visualization not available for this combination';
    }
  };

  calcExponent();
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
<section class="tool-article" style="--accent-color:#f5a623">

  <h2>How to Use This Calculator</h2>
  <p>Enter a base number and an exponent (the power). Press Calculate to see the result, along with each multiplication step written out. You can use negative bases and negative exponents. The result updates with a visual scale bar showing how large the answer is relative to the base.</p>

  <h2>What Exponents Mean</h2>
  <p>An exponent is shorthand for repeated multiplication. The expression 2^5 means 2 multiplied by itself 5 times: 2 x 2 x 2 x 2 x 2 = 32. The bottom number is the base. The top number is the exponent, also called the power.</p>
  <p>Exponents grow fast. 2^10 is already 1,024. That is why they appear everywhere from computer memory (powers of 2) to scientific notation (powers of 10 for very large or very small numbers).</p>

  <h2>The Exponent Rules</h2>
  <table class="ta-table">
    <thead><tr><th>Rule Name</th><th>Formula</th><th>Example</th></tr></thead>
    <tbody>
      <tr><td>Product rule</td><td>a^m x a^n = a^(m+n)</td><td>2^3 x 2^4 = 2^7 = 128</td></tr>
      <tr><td>Quotient rule</td><td>a^m / a^n = a^(m-n)</td><td>3^5 / 3^2 = 3^3 = 27</td></tr>
      <tr><td>Power rule</td><td>(a^m)^n = a^(m x n)</td><td>(2^3)^2 = 2^6 = 64</td></tr>
      <tr><td>Zero exponent</td><td>a^0 = 1</td><td>7^0 = 1</td></tr>
      <tr><td>Negative exponent</td><td>a^(-n) = 1 / a^n</td><td>2^(-3) = 1/8 = 0.125</td></tr>
    </tbody>
  </table>

  <h2>Square Roots and Cube Roots</h2>
  <p>Roots are the inverse of powers. The square root asks: what number squared gives this result? The square root of 25 is 5 because 5^2 = 25. You can write square root as a fractional exponent: 25^(1/2) = 5.</p>
  <p>The cube root asks: what number cubed gives this result? The cube root of 27 is 3 because 3^3 = 27. Written as a fractional exponent: 27^(1/3) = 3.</p>

  <h2>Common Mistakes to Avoid</h2>
  <ul>
    <li>Thinking 2^3 means 2 x 3 = 6. It actually means 2 x 2 x 2 = 8. The exponent counts multiplications, not the size of the multiplier.</li>
    <li>Forgetting that any number to the power 0 equals 1. This surprises students who expect the answer to be 0.</li>
    <li>Confusing a negative base with a negative exponent. (-2)^3 = -8 but 2^(-3) = 1/8. These are very different things.</li>
    <li>Applying product rule when the bases are different. You can only add exponents when multiplying terms with the same base.</li>
  </ul>

  </section>

<div class="tool-nav-row">
  <a href="/math-tools/statistics-calculator" class="tool-nav-card" style="--tnc-color:#6366f1">
    <div class="tool-nav-icon"><i class="fa-solid fa-chart-bar"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Previous</div><div class="tool-nav-name">Statistics Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-left"></i></div>
  </a>
  <a href="/math-tools/roman-numeral-converter" class="tool-nav-card tool-nav-next" style="--tnc-color:#007aff">
    <div class="tool-nav-icon"><i class="fa-solid fa-landmark"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Next</div><div class="tool-nav-name">Roman Numeral Converter</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-right"></i></div>
  </a>
</div>

<div class="topic-quiz" id="tool-quiz">
  <div class="quiz-header" style="background:#8b5cf6">
    <i class="fa-solid fa-circle-question"></i> Quick Quiz
    <span class="quiz-sub">3 questions</span>
  </div>
  <div class="quiz-body">
    <div class="quiz-q" data-qi="0" data-correct="2">
      <p class="quiz-question"><strong>Q1.</strong> What is 2⁵?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">10</button>
        <button class="quiz-opt" data-oi="1">16</button>
        <button class="quiz-opt" data-oi="2">32</button>
        <button class="quiz-opt" data-oi="3">64</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="1" data-correct="1">
      <p class="quiz-question"><strong>Q2.</strong> What is 3⁰?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">0</button>
        <button class="quiz-opt" data-oi="1">1</button>
        <button class="quiz-opt" data-oi="2">3</button>
        <button class="quiz-opt" data-oi="3">9</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="2" data-correct="1">
      <p class="quiz-question"><strong>Q3.</strong> What is 10⁻²?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">0.001</button>
        <button class="quiz-opt" data-oi="1">0.01</button>
        <button class="quiz-opt" data-oi="2">0.1</button>
        <button class="quiz-opt" data-oi="3">100</button>
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
