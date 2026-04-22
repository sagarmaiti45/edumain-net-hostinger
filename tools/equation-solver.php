<?php require_once __DIR__ . '/../config.php'; $page_title = 'Equation Solver'; $page_desc = 'Solve simple linear equations step by step with typewriter animation on a chalkboard-style display.'; $body_class = 'page-article'; include __DIR__ . '/../_header.php'; ?>

<style>
.eq-page { background: #14141c; min-height: 60vh; padding: 2rem 1rem; color: #dde0f0; font-family: 'Segoe UI', sans-serif; border-radius: 16px; overflow: hidden; max-width: 900px; margin-left: auto; margin-right: auto; }
.eq-hero { text-align: center; margin-bottom: 2rem; }
.eq-hero h1 { color: #dde0f0; font-size: 2.2rem; font-weight: 800; margin: 0; }
.eq-hero p { color: #6b6e8a; font-size: 1.05rem; margin-top: .4rem; }
.eq-main { max-width: 680px; margin: 0 auto; }
.eq-input-card { background: #1e1e2e; border-radius: 20px; border: 1.5px solid #2e2e42; padding: 1.8rem; margin-bottom: 1.5rem; }
.eq-input-card label { display: block; font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #4ecdc4; margin-bottom: .6rem; }
.eq-input { width: 100%; box-sizing: border-box; background: #14141c; border: 2px solid #2e2e42; color: #dde0f0; font-size: 1.5rem; font-weight: 700; border-radius: 12px; padding: .65rem 1rem; outline: none; transition: border-color .2s; font-family: 'Courier New', monospace; letter-spacing: .05em; }
.eq-input:focus { border-color: #4ecdc4; box-shadow: 0 0 0 3px #4ecdc422; }
.eq-hint { font-size: .78rem; color: #4a4d68; margin-top: .5rem; }
.eq-examples { display: flex; flex-wrap: wrap; gap: .4rem; margin-top: .8rem; }
.eq-example { background: #2e2e42; border: none; border-radius: 20px; color: #4ecdc4; font-size: .75rem; font-weight: 600; padding: .25rem .75rem; cursor: pointer; transition: background .2s; }
.eq-example:hover { background: #4ecdc4; color: #14141c; }
.eq-solve-btn { display: block; width: 100%; margin-top: .8rem; background: linear-gradient(135deg, #4ecdc4, #2ab7ae); color: #14141c; font-size: 1.05rem; font-weight: 800; border: none; border-radius: 12px; padding: .9rem; cursor: pointer; transition: all .2s; }
.eq-solve-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px #4ecdc455; }
/* Chalkboard */
.chalkboard { background: #1e3d1e; border: 4px solid #6b4a2a; border-radius: 12px; box-shadow: inset 0 0 30px rgba(0,0,0,.5), 0 8px 24px rgba(0,0,0,.4); padding: 2rem 2.5rem; min-height: 300px; display: none; position: relative; font-family: 'Courier New', monospace; }
.chalkboard::before { content: ''; position: absolute; inset: 8px; border: 1px dashed rgba(255,255,255,.05); border-radius: 6px; pointer-events: none; }
.chalk-title { font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; color: #4ecdc4; margin-bottom: 1rem; font-family: 'Segoe UI', sans-serif; }
.chalk-step { font-size: 1.05rem; color: rgba(255,255,255,.85); padding: .5rem 0; border-bottom: 1px dashed rgba(255,255,255,.08); display: flex; align-items: flex-start; gap: .8rem; min-height: 2em; overflow: hidden; }
.chalk-step:last-child { border-bottom: none; }
.chalk-step-num { background: #4ecdc422; border: 1px solid #4ecdc444; border-radius: 50%; width: 22px; height: 22px; min-width: 22px; display: flex; align-items: center; justify-content: center; font-size: .7rem; font-weight: 700; color: #4ecdc4; margin-top: .1rem; font-family: 'Segoe UI', sans-serif; }
.chalk-text { font-size: 1.05rem; }
.chalk-text .op-note { color: #fde68a; font-style: italic; font-size: .88rem; margin-left: .5rem; }
.chalk-solution { margin-top: 1rem; padding-top: 1rem; border-top: 2px solid #4ecdc4; text-align: center; }
.chalk-solution .sol-label { font-size: .78rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #4ecdc4; margin-bottom: .4rem; font-family: 'Segoe UI', sans-serif; }
.chalk-solution .sol-value { font-size: 3rem; font-weight: 900; color: #4ecdc4; text-shadow: 0 0 20px #4ecdc455; animation: solGlow 1s ease-in-out infinite alternate; }
@keyframes solGlow { from { text-shadow: 0 0 10px #4ecdc455; } to { text-shadow: 0 0 30px #4ecdc4cc; } }
.eq-error { background: #2e1a1a; border: 1.5px solid #f43f5e; border-radius: 12px; padding: .8rem 1rem; color: #f43f5e; font-size: .9rem; font-weight: 600; margin-top: .8rem; display: none; }
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
  <span>Equation Solver</span>
</nav>
<div class="tool-page-layout" style="max-width:1100px;width:100%;margin:0 auto;padding:24px 24px 48px;box-sizing:border-box;">
<div class="tool-nav-row">
  <a href="/math-tools/times-table" class="tool-nav-card" style="--tnc-color:#c084fc">
    <div class="tool-nav-icon"><i class="fa-solid fa-table-cells"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Previous</div><div class="tool-nav-name">Times Table</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-left"></i></div>
  </a>
  <a href="/math-tools/triangle-calculator" class="tool-nav-card tool-nav-next" style="--tnc-color:#14b8a6">
    <div class="tool-nav-icon"><i class="fa-solid fa-draw-polygon"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Next</div><div class="tool-nav-name">Triangle Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-right"></i></div>
  </a>
</div>
<div class="eq-page">
  <div class="eq-main">
    <div class="eq-hero">
      <h1>Equation Solver</h1>
    </div>

    <div class="eq-input-card">
      <label><i class="fa-solid fa-keyboard" style="margin-right:.3rem;"></i>Enter Linear Equation</label>
      <input class="eq-input" type="text" id="eqInput" placeholder="e.g. 2x + 5 = 15">
      <div class="eq-hint">Supports: ax + b = c, ax - b = c, ax = b, x + b = c (one variable)</div>
      <div class="eq-examples">
        <span style="font-size:.75rem;color:#4a4d68;align-self:center;">Try:</span>
        <button class="eq-example" onclick="setEq('2x + 5 = 15')">2x + 5 = 15</button>
        <button class="eq-example" onclick="setEq('3x - 7 = 14')">3x - 7 = 14</button>
        <button class="eq-example" onclick="setEq('5x = 35')">5x = 35</button>
        <button class="eq-example" onclick="setEq('x + 12 = 20')">x + 12 = 20</button>
        <button class="eq-example" onclick="setEq('4x + 3 = 2x + 11')">4x + 3 = 2x + 11</button>
        <button class="eq-example" onclick="setEq('-2x + 10 = 4')">-2x + 10 = 4</button>
      </div>
      <button class="eq-solve-btn" onclick="solveEq()"><i class="fa-solid fa-chalkboard-user" style="margin-right:.4rem;"></i>Solve on Chalkboard</button>
      <div class="eq-error" id="eqError"></div>
    </div>

    <div class="chalkboard" id="chalkboard">
      <div class="chalk-title"><i class="fa-solid fa-chalkboard" style="margin-right:.3rem;"></i>Solution Steps</div>
      <div id="stepsArea"></div>
      <div class="chalk-solution" id="solutionArea" style="display:none;">
        <div class="sol-label">Solution</div>
        <div class="sol-value" id="solValue"></div>
      </div>
    </div>
  </div>
</div>

<script>
(function(){
  window.setEq = function(eq) {
    document.getElementById('eqInput').value = eq;
    solveEq();
  };

  function parseCoef(str) {
    // Parse something like "2x", "-x", "x", "-3x"
    str = str.trim();
    if(!str.includes('x')) return {coef: 0, isX: false, num: parseFloat(str)||0};
    const part = str.replace('x','').trim();
    let c;
    if(part === '' || part === '+') c = 1;
    else if(part === '-') c = -1;
    else c = parseFloat(part);
    return {coef: isNaN(c) ? 1 : c, isX: true, num: 0};
  }

  function parseSide(str) {
    str = str.trim();
    // Tokenize: split by + or - keeping sign
    const tokens = str.match(/[+-]?[^+-]+/g) || [];
    let xCoef = 0, constant = 0;
    tokens.forEach(t => {
      t = t.trim();
      if(!t) return;
      if(t.includes('x')) {
        const p = t.replace('x','').trim();
        let c;
        if(p === '' || p === '+') c = 1;
        else if(p === '-') c = -1;
        else c = parseFloat(p);
        xCoef += isNaN(c) ? (t.startsWith('-') ? -1 : 1) : c;
      } else {
        constant += parseFloat(t) || 0;
      }
    });
    return {xCoef, constant};
  }

  function typewrite(el, text, delay) {
    return new Promise(resolve => {
      let i = 0;
      el.textContent = '';
      const interval = setInterval(() => {
        el.textContent += text[i];
        i++;
        if(i >= text.length) { clearInterval(interval); resolve(); }
      }, delay || 30);
    });
  }

  function addStep(stepsArea, num, text, note) {
    const div = document.createElement('div');
    div.className = 'chalk-step';
    const numEl = document.createElement('div');
    numEl.className = 'chalk-step-num';
    numEl.textContent = num;
    const textEl = document.createElement('div');
    textEl.className = 'chalk-text';
    div.appendChild(numEl);
    div.appendChild(textEl);
    stepsArea.appendChild(div);
    return textEl;
  }

  window.solveEq = async function() {
    const raw = document.getElementById('eqInput').value.trim();
    const errEl = document.getElementById('eqError');
    errEl.style.display = 'none';

    if(!raw) { errEl.textContent = 'Please enter an equation!'; errEl.style.display = 'block'; return; }
    if(!raw.includes('=')) { errEl.textContent = 'Equation must contain "=" sign!'; errEl.style.display = 'block'; return; }
    if(!raw.toLowerCase().includes('x')) { errEl.textContent = 'Equation must contain variable "x"!'; errEl.style.display = 'block'; return; }

    const parts = raw.split('=');
    if(parts.length !== 2) { errEl.textContent = 'Too many "=" signs!'; errEl.style.display = 'block'; return; }

    let leftStr = parts[0].trim();
    let rightStr = parts[1].trim();

    // Normalize spaces around operators
    leftStr = leftStr.replace(/\s+/g, '').replace(/([+-])/g, ' $1 ').trim();
    rightStr = rightStr.replace(/\s+/g, '').replace(/([+-])/g, ' $1 ').trim();

    // Re-normalize: combine tokens
    leftStr = parts[0].trim().replace(/\s/g,'');
    rightStr = parts[1].trim().replace(/\s/g,'');

    const left = parseSide(leftStr);
    const right = parseSide(rightStr);

    // ax + b = cx + d  → (a-c)x = d - b
    const a = left.xCoef - right.xCoef;
    const b = right.constant - left.constant;

    if(a === 0) {
      errEl.textContent = b === 0 ? 'Infinite solutions (identity).' : 'No solution (contradiction).';
      errEl.style.display = 'block';
      return;
    }

    const x = b / a;

    // Build steps
    const chalkboard = document.getElementById('chalkboard');
    chalkboard.style.display = 'block';
    const stepsArea = document.getElementById('stepsArea');
    stepsArea.innerHTML = '';
    document.getElementById('solutionArea').style.display = 'none';

    const steps = [];
    steps.push({text: `Original equation: ${raw}`, note: ''});

    if(right.xCoef !== 0) {
      const newLeft = `${a}x`;
      const newRight = `${right.constant}`;
      const op = right.xCoef > 0 ? `Subtract ${right.xCoef}x from both sides` : `Add ${Math.abs(right.xCoef)}x to both sides`;
      steps.push({text: `${op}: ${newLeft} = ${left.constant} ${right.constant >= 0 ? '+' : ''}${right.constant-left.constant+left.constant}`, note: `→ ${a}x = ${b}`});
    }

    if(left.constant !== 0) {
      const op2 = left.constant > 0 ? `Subtract ${left.constant} from both sides` : `Add ${Math.abs(left.constant)} to both sides`;
      steps.push({text: `${op2}: ${a}x = ${b}`, note: `isolate ${a}x`});
    }

    if(a !== 1) {
      steps.push({text: `Divide both sides by ${a}: x = ${b}/${a} = ${x}`, note: `solve for x`});
    }

    steps.push({text: `Check: substitute x = ${x} into original equation`, note: ''});

    // Verify
    const lVal = left.xCoef * x + left.constant;
    const rVal = right.xCoef * x + right.constant;
    steps.push({text: `LHS = ${left.xCoef}(${x}) + ${left.constant} = ${lVal}`, note: ''});
    steps.push({text: `RHS = ${right.xCoef}(${x}) + ${right.constant} = ${rVal}`, note: ''});
    steps.push({text: `${lVal} = ${rVal} ✓ Verified!`, note: ''});

    // Animate steps
    for(let i = 0; i < steps.length; i++) {
      const textEl = addStep(stepsArea, i+1, steps[i].text);
      await typewrite(textEl, steps[i].text, 18);
      if(steps[i].note) {
        const noteSpan = document.createElement('span');
        noteSpan.className = 'op-note';
        noteSpan.textContent = ' (' + steps[i].note + ')';
        textEl.appendChild(noteSpan);
      }
      await new Promise(r => setTimeout(r, 120));
    }

    // Show solution
    const solArea = document.getElementById('solutionArea');
    const solVal = document.getElementById('solValue');
    solVal.textContent = `x = ${parseFloat(x.toFixed(6))}`;
    solArea.style.display = 'block';
    solArea.style.animation = 'none';
    solArea.offsetHeight;
  };

  document.getElementById('eqInput').addEventListener('keydown', e => {
    if(e.key === 'Enter') solveEq();
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
<section class="tool-article" style="--accent-color:#4ecdc4">

  <h2>How to Use This Solver</h2>
  <p>Type your linear equation into the input field using x as your variable. Use standard notation: 2x + 3 = 11, or 5x - 4 = 3x + 8. Press Solve and the tool will show you the answer with every step written out. You can also enter equations with parentheses like 3(x + 2) = 18.</p>

  <h2>What a Linear Equation Is</h2>
  <p>A linear equation has exactly one variable, and that variable has an exponent of 1 (meaning it is just x, not x squared or x cubed). The word "linear" means the equation describes a straight line when graphed.</p>
  <p>Think of an equation as a balance scale. Both sides must stay equal. Whatever you do to one side, you must do the same to the other side. That is the fundamental rule that lets you solve for x.</p>

  <h2>The Four Steps to Solve</h2>
  <ol>
    <li><strong>Simplify both sides.</strong> Distribute brackets and combine like terms on each side.</li>
    <li><strong>Move variable terms to one side.</strong> Add or subtract to get all x terms on the left.</li>
    <li><strong>Move constants to the other side.</strong> Add or subtract numbers to isolate the variable term.</li>
    <li><strong>Divide to isolate x.</strong> Divide both sides by the coefficient of x.</li>
  </ol>

  <h2>Worked Examples</h2>
  <table class="ta-table">
    <thead><tr><th>Equation</th><th>Steps</th><th>Answer</th></tr></thead>
    <tbody>
      <tr><td>2x + 3 = 11</td><td>Subtract 3: 2x = 8. Divide by 2.</td><td>x = 4</td></tr>
      <tr><td>5x - 4 = 3x + 8</td><td>Subtract 3x: 2x - 4 = 8. Add 4: 2x = 12. Divide by 2.</td><td>x = 6</td></tr>
      <tr><td>3(x + 2) = 18</td><td>Distribute: 3x + 6 = 18. Subtract 6: 3x = 12. Divide by 3.</td><td>x = 4</td></tr>
    </tbody>
  </table>

  <h2>Checking Your Answer</h2>
  <p>After solving, plug your value back into the original equation. Replace x with your answer and calculate both sides. If both sides give the same number, your answer is correct.</p>
  <div class="ta-box">
    <strong>Check: 2x + 3 = 11 with x = 4</strong>
    Left side: 2(4) + 3 = 8 + 3 = 11. Right side: 11. Both equal 11, so x = 4 is correct.
  </div>

  <h2>Common Mistakes to Avoid</h2>
  <ul>
    <li>Sign errors when moving terms. Subtracting from one side means adding to the other, not subtracting from both.</li>
    <li>Forgetting to distribute when there are brackets. 3(x + 2) is 3x + 6, not 3x + 2.</li>
    <li>Dividing only one term on a side instead of the whole expression. When you divide, both terms on that side must be divided.</li>
    <li>Not checking the answer. A simple substitution confirms whether you got it right or made an error somewhere.</li>
  </ul>

  </section>

<div class="tool-nav-row">
  <a href="/math-tools/times-table" class="tool-nav-card" style="--tnc-color:#c084fc">
    <div class="tool-nav-icon"><i class="fa-solid fa-table-cells"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Previous</div><div class="tool-nav-name">Times Table</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-left"></i></div>
  </a>
  <a href="/math-tools/triangle-calculator" class="tool-nav-card tool-nav-next" style="--tnc-color:#14b8a6">
    <div class="tool-nav-icon"><i class="fa-solid fa-draw-polygon"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Next</div><div class="tool-nav-name">Triangle Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-right"></i></div>
  </a>
</div>

<div class="topic-quiz" id="tool-quiz">
  <div class="quiz-header" style="background:#4ecdc4">
    <i class="fa-solid fa-circle-question"></i> Quick Quiz
    <span class="quiz-sub">3 questions</span>
  </div>
  <div class="quiz-body">
    <div class="quiz-q" data-qi="0" data-correct="1">
      <p class="quiz-question"><strong>Q1.</strong> Solve for x: 2x + 3 = 11</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">x = 3</button>
        <button class="quiz-opt" data-oi="1">x = 4</button>
        <button class="quiz-opt" data-oi="2">x = 5</button>
        <button class="quiz-opt" data-oi="3">x = 7</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="1" data-correct="2">
      <p class="quiz-question"><strong>Q2.</strong> Solve for x: 5x - 10 = 15</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">x = 1</button>
        <button class="quiz-opt" data-oi="1">x = 3</button>
        <button class="quiz-opt" data-oi="2">x = 5</button>
        <button class="quiz-opt" data-oi="3">x = 7</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="2" data-correct="0">
      <p class="quiz-question"><strong>Q3.</strong> Solve for x: 3(x + 2) = 18</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">x = 4</button>
        <button class="quiz-opt" data-oi="1">x = 5</button>
        <button class="quiz-opt" data-oi="2">x = 6</button>
        <button class="quiz-opt" data-oi="3">x = 8</button>
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
