<?php require_once __DIR__ . '/../config.php'; $page_title = 'Fraction Calculator'; $page_desc = 'Add, subtract, multiply and divide fractions with visual pie chart and step-by-step solutions.'; $body_class = 'page-article'; include __DIR__ . '/../_header.php'; ?>

<style>
:root {
  --frac-bg: #fdf4ff;
  --frac-card: #ffffff;
  --frac-accent: #c084fc;
  --frac-accent2: #a855f7;
  --frac-text: #3b1a6b;
  --frac-muted: #7c3aed;
  --frac-border: #e9d5ff;
}
.tool-share-row { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:.5rem; margin-bottom:1.5rem; }
.tool-share-btn { display:inline-flex; align-items:center; gap:.4rem; font-size:.82rem; font-weight:600; padding:.4rem .9rem; border-radius:50px; border:1.5px solid var(--border,#e5e7eb); background:transparent; cursor:pointer; color:var(--text-muted,#6b7280); transition:all .15s; }
.tool-share-btn:hover { border-color:var(--accent,#4f46e5); color:var(--accent,#4f46e5); }
.frac-page { background: var(--frac-bg); min-height: 60vh; padding: 2rem 1rem; font-family: 'Segoe UI', sans-serif; border-radius: 16px; overflow: hidden; max-width: 900px; margin-left: auto; margin-right: auto; }
.frac-hero { text-align: center; margin-bottom: 2rem; }
.frac-hero h1 { color: var(--frac-text); font-size: 2.2rem; font-weight: 800; margin: 0; }
.frac-hero p { color: var(--frac-muted); font-size: 1.05rem; margin-top: .4rem; }
.frac-main { max-width: 860px; margin: 0 auto; }
.frac-ops { display: flex; justify-content: center; gap: .6rem; margin-bottom: 2rem; flex-wrap: wrap; }
.op-btn { background: #fff; border: 2px solid var(--frac-border); color: var(--frac-muted); font-size: 1.4rem; font-weight: 700; border-radius: 50px; width: 52px; height: 52px; cursor: pointer; transition: all .2s; display: flex; align-items: center; justify-content: center; }
.op-btn:hover { border-color: var(--frac-accent); transform: scale(1.1); }
.op-btn.active { background: var(--frac-accent2); border-color: var(--frac-accent2); color: #fff; box-shadow: 0 4px 14px #a855f755; }
.frac-inputs { display: flex; align-items: center; justify-content: center; gap: 1.2rem; flex-wrap: wrap; margin-bottom: 2rem; }
.frac-box { background: #fff; border-radius: 20px; box-shadow: 0 4px 20px #c084fc22; padding: 1.5rem 2rem; text-align: center; min-width: 140px; border: 2px solid var(--frac-border); }
.frac-box label { font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--frac-accent2); display: block; margin-bottom: .5rem; }
.frac-num-input { width: 80px; text-align: center; font-size: 2rem; font-weight: 800; color: var(--frac-text); border: none; border-bottom: 3px solid var(--frac-accent); background: transparent; outline: none; padding: .2rem; }
.frac-line { width: 80px; height: 3px; background: var(--frac-text); margin: .4rem auto; border-radius: 2px; }
.op-display { font-size: 2.5rem; font-weight: 900; color: var(--frac-accent2); }
.frac-calc-btn { display: block; margin: 0 auto 2rem; background: linear-gradient(135deg, var(--frac-accent), var(--frac-accent2)); color: #fff; font-size: 1.1rem; font-weight: 700; border: none; border-radius: 50px; padding: .85rem 2.8rem; cursor: pointer; box-shadow: 0 6px 20px #a855f744; transition: all .2s; letter-spacing: .04em; }
.frac-calc-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 28px #a855f766; }
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
.frac-visuals { display: flex; gap: 1.5rem; justify-content: center; flex-wrap: wrap; margin-bottom: 2rem; }
.pie-wrap { text-align: center; }
.pie-wrap svg { filter: drop-shadow(0 4px 12px #c084fc44); }
.pie-label { font-size: .85rem; font-weight: 700; color: var(--frac-accent2); margin-top: .4rem; }
.frac-result { background: linear-gradient(135deg, #f5e8ff, #ede0ff); border: 2px solid var(--frac-border); border-radius: 20px; padding: 2rem; text-align: center; display: none; animation: popIn .4s cubic-bezier(.175,.885,.32,1.275); }
@keyframes popIn { from { opacity: 0; transform: scale(.85); } to { opacity: 1; transform: scale(1); } }
.result-label { font-size: .8rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--frac-muted); margin-bottom: .5rem; }
.result-fraction { display: flex; flex-direction: column; align-items: center; gap: .2rem; margin: .5rem auto; }
.result-num { font-size: 3rem; font-weight: 900; color: var(--frac-accent2); line-height: 1; }
.result-line { width: 80px; height: 4px; background: var(--frac-text); border-radius: 2px; }
.result-mixed { font-size: 1.1rem; color: var(--frac-muted); margin-top: .5rem; font-weight: 600; }
.steps-box { background: #fff; border-radius: 14px; padding: 1.2rem 1.5rem; margin-top: 1.2rem; text-align: left; border: 1px solid var(--frac-border); }
.steps-box h3 { font-size: .85rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--frac-accent2); margin: 0 0 .7rem; }
.step-item { font-size: .9rem; color: var(--frac-text); padding: .3rem 0; border-bottom: 1px dashed var(--frac-border); display: flex; align-items: center; gap: .5rem; }
.step-item:last-child { border-bottom: none; }
.step-icon { width: 22px; height: 22px; background: var(--frac-accent); border-radius: 50%; color: #fff; font-size: .7rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.confetti-container { position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 9999; overflow: hidden; }
.confetti-piece { position: absolute; width: 10px; height: 10px; border-radius: 2px; animation: confettiFall linear forwards; }
@keyframes confettiFall { 0% { transform: translateY(-20px) rotate(0deg); opacity: 1; } 100% { transform: translateY(100vh) rotate(720deg); opacity: 0; } }
@media (max-width: 600px) { .frac-inputs { flex-direction: column; align-items: center; } .op-display { transform: rotate(90deg); } }
</style>

<nav class="breadcrumb" aria-label="Breadcrumb">
  <a href="/">Home</a>
  <span class="bc-sep">›</span>
  <a href="/math-tools">Math Tools</a>
  <span class="bc-sep">›</span>
  <span>Fraction Calculator</span>
</nav>
<div class="tool-page-layout" style="max-width:1100px;width:100%;margin:0 auto;padding:24px 24px 48px;box-sizing:border-box;">
<div class="tool-nav-row">
  <div class="tool-nav-placeholder"></div>
  <a href="/math-tools/percentage-calculator" class="tool-nav-card tool-nav-next" style="--tnc-color:#14b8a6">
    <div class="tool-nav-icon"><i class="fa-solid fa-percent"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Next</div><div class="tool-nav-name">Percentage Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-right"></i></div>
  </a>
</div>
<div class="frac-page">
  <div class="frac-main">
    <div class="frac-hero">
      <h1>Fraction Calculator</h1>
    </div>

    <div class="frac-ops">
      <button class="op-btn active" data-op="+" title="Add">+</button>
      <button class="op-btn" data-op="-" title="Subtract">−</button>
      <button class="op-btn" data-op="*" title="Multiply">×</button>
      <button class="op-btn" data-op="/" title="Divide">÷</button>
    </div>

    <div class="frac-inputs">
      <div class="frac-box">
        <label>Fraction A</label>
        <input class="frac-num-input" id="a_num" type="number" value="1" min="-999" max="999" step="1">
        <div class="frac-line"></div>
        <input class="frac-num-input" id="a_den" type="number" value="2" min="1" max="999" step="1">
      </div>
      <div class="op-display" id="opDisplay">+</div>
      <div class="frac-box">
        <label>Fraction B</label>
        <input class="frac-num-input" id="b_num" type="number" value="1" min="-999" max="999" step="1">
        <div class="frac-line"></div>
        <input class="frac-num-input" id="b_den" type="number" value="3" min="1" max="999" step="1">
      </div>
    </div>

    <div class="frac-visuals" id="fracVisuals">
      <div class="pie-wrap">
        <svg id="pieA" width="110" height="110" viewBox="0 0 110 110"></svg>
        <div class="pie-label" id="pieALabel">1/2</div>
      </div>
      <div class="pie-wrap">
        <svg id="pieB" width="110" height="110" viewBox="0 0 110 110"></svg>
        <div class="pie-label" id="pieBLabel">1/3</div>
      </div>
    </div>

    <button class="frac-calc-btn" id="calcBtn"><i class="fa-solid fa-equals" style="margin-right:.4rem;"></i>Calculate</button>

    <div class="frac-result" id="fracResult">
      <div class="result-label">Result</div>
      <div class="result-fraction">
        <div class="result-num" id="resNum">0</div>
        <div class="result-line" id="resLine"></div>
        <div class="result-num" id="resDen">1</div>
      </div>
      <div class="result-mixed" id="resMixed"></div>
      <div class="steps-box">
        <h3><i class="fa-solid fa-list-ol" style="margin-right:.3rem;"></i>Step-by-Step</h3>
        <div id="stepsContainer"></div>
      </div>
    </div>
    <div id="confettiContainer" class="confetti-container"></div>
  </div>
</div>

<script>
(function(){
  let currentOp = '+';

  document.querySelectorAll('.op-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.op-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      currentOp = btn.dataset.op;
      document.getElementById('opDisplay').textContent =
        currentOp === '+' ? '+' : currentOp === '-' ? '−' : currentOp === '*' ? '×' : '÷';
      updatePies();
    });
  });

  ['a_num','a_den','b_num','b_den'].forEach(id => {
    document.getElementById(id).addEventListener('input', updatePies);
  });

  function gcd(a, b) {
    a = Math.abs(a); b = Math.abs(b);
    while(b) { let t = b; b = a % b; a = t; }
    return a || 1;
  }

  function simplify(n, d) {
    if(d === 0) return [n, d];
    const g = gcd(Math.abs(n), Math.abs(d));
    let sn = n/g, sd = d/g;
    if(sd < 0) { sn = -sn; sd = -sd; }
    return [sn, sd];
  }

  function drawPie(svgId, num, den, color1, color2) {
    const svg = document.getElementById(svgId);
    const cx = 55, cy = 55, r = 48;
    svg.innerHTML = '';
    const denom = Math.abs(den) || 1;
    const numer = Math.min(Math.abs(num), denom);
    const ratio = numer / denom;

    // Background circle
    const bgCircle = document.createElementNS('http://www.w3.org/2000/svg','circle');
    bgCircle.setAttribute('cx', cx); bgCircle.setAttribute('cy', cy);
    bgCircle.setAttribute('r', r); bgCircle.setAttribute('fill', '#e9d5ff');
    svg.appendChild(bgCircle);

    if(ratio > 0 && ratio <= 1) {
      const angle = ratio * 2 * Math.PI;
      const x = cx + r * Math.sin(angle);
      const y = cy - r * Math.cos(angle);
      const largeArc = ratio > 0.5 ? 1 : 0;
      const path = document.createElementNS('http://www.w3.org/2000/svg','path');
      const d = ratio >= 1
        ? `M ${cx} ${cy-r} A ${r} ${r} 0 1 1 ${cx-0.001} ${cy-r} Z`
        : `M ${cx} ${cy-r} A ${r} ${r} 0 ${largeArc} 1 ${x} ${y} L ${cx} ${cy} Z`;
      path.setAttribute('d', d);
      path.setAttribute('fill', color1);
      svg.appendChild(path);
    }

    // Draw dividing lines for equal parts
    for(let i = 0; i < denom && denom <= 20; i++) {
      const ang = (i / denom) * 2 * Math.PI;
      const lx = cx + r * Math.sin(ang);
      const ly = cy - r * Math.cos(ang);
      const line = document.createElementNS('http://www.w3.org/2000/svg','line');
      line.setAttribute('x1', cx); line.setAttribute('y1', cy);
      line.setAttribute('x2', lx); line.setAttribute('y2', ly);
      line.setAttribute('stroke', '#fff'); line.setAttribute('stroke-width', '1.5');
      svg.appendChild(line);
    }

    // Border
    const border = document.createElementNS('http://www.w3.org/2000/svg','circle');
    border.setAttribute('cx', cx); border.setAttribute('cy', cy);
    border.setAttribute('r', r); border.setAttribute('fill', 'none');
    border.setAttribute('stroke', color2); border.setAttribute('stroke-width', '2.5');
    svg.appendChild(border);
  }

  function updatePies() {
    const an = parseInt(document.getElementById('a_num').value)||0;
    const ad = parseInt(document.getElementById('a_den').value)||1;
    const bn = parseInt(document.getElementById('b_num').value)||0;
    const bd = parseInt(document.getElementById('b_den').value)||1;
    drawPie('pieA', an, ad, '#c084fc', '#a855f7');
    drawPie('pieB', bn, bd, '#f0abfc', '#e879f9');
    document.getElementById('pieALabel').textContent = an + '/' + ad;
    document.getElementById('pieBLabel').textContent = bn + '/' + bd;
  }

  document.getElementById('calcBtn').addEventListener('click', calculate);

  function calculate() {
    const an = parseInt(document.getElementById('a_num').value)||0;
    const ad = parseInt(document.getElementById('a_den').value)||1;
    const bn = parseInt(document.getElementById('b_num').value)||0;
    const bd = parseInt(document.getElementById('b_den').value)||1;

    if(ad === 0 || bd === 0) { alert('Denominator cannot be zero!'); return; }
    if(currentOp === '/' && bn === 0) { alert('Cannot divide by zero fraction!'); return; }

    let rn, rd;
    const steps = [];

    if(currentOp === '+') {
      rn = an*bd + bn*ad; rd = ad*bd;
      steps.push(`Find common denominator: ${ad} × ${bd} = ${rd}`);
      steps.push(`Convert: ${an}/${ad} = ${an*bd}/${rd}, ${bn}/${bd} = ${bn*ad}/${rd}`);
      steps.push(`Add numerators: ${an*bd} + ${bn*ad} = ${rn}`);
    } else if(currentOp === '-') {
      rn = an*bd - bn*ad; rd = ad*bd;
      steps.push(`Find common denominator: ${ad} × ${bd} = ${rd}`);
      steps.push(`Convert: ${an}/${ad} = ${an*bd}/${rd}, ${bn}/${bd} = ${bn*ad}/${rd}`);
      steps.push(`Subtract numerators: ${an*bd} − ${bn*ad} = ${rn}`);
    } else if(currentOp === '*') {
      rn = an*bn; rd = ad*bd;
      steps.push(`Multiply numerators: ${an} × ${bn} = ${rn}`);
      steps.push(`Multiply denominators: ${ad} × ${bd} = ${rd}`);
    } else {
      rn = an*bd; rd = ad*bn;
      steps.push(`Flip the second fraction: ${bn}/${bd} → ${bd}/${bn}`);
      steps.push(`Multiply: (${an} × ${bd}) / (${ad} × ${bn}) = ${rn}/${rd}`);
    }

    const [sn, sd] = simplify(rn, rd);
    const g = gcd(Math.abs(rn), Math.abs(rd));
    if(g > 1) steps.push(`Simplify by dividing by ${g}: ${rn}/${rd} = ${sn}/${sd}`);

    document.getElementById('resNum').textContent = sn;
    document.getElementById('resDen').textContent = sd;

    const resLine = document.getElementById('resLine');
    const resMixed = document.getElementById('resMixed');

    if(sd === 1) {
      resLine.style.display = 'none';
      resMixed.textContent = '';
    } else {
      resLine.style.display = 'block';
      if(Math.abs(sn) > sd) {
        const whole = Math.trunc(sn/sd);
        const rem = Math.abs(sn % sd);
        resMixed.textContent = rem > 0 ? `Mixed number: ${whole} ${rem}/${sd}` : '';
      } else { resMixed.textContent = `= ${(sn/sd).toFixed(4)}`; }
    }

    const stepsContainer = document.getElementById('stepsContainer');
    stepsContainer.innerHTML = '';
    steps.forEach((s, i) => {
      const div = document.createElement('div');
      div.className = 'step-item';
      div.innerHTML = `<div class="step-icon">${i+1}</div><span>${s}</span>`;
      stepsContainer.appendChild(div);
    });

    const res = document.getElementById('fracResult');
    res.style.display = 'block';
    res.style.animation = 'none';
    res.offsetHeight;
    res.style.animation = 'popIn .4s cubic-bezier(.175,.885,.32,1.275)';

    launchConfetti();
  }

  function launchConfetti() {
    const container = document.getElementById('confettiContainer');
    container.innerHTML = '';
    const colors = ['#c084fc','#a855f7','#f0abfc','#e879f9','#d8b4fe','#fde68a'];
    for(let i = 0; i < 60; i++) {
      const piece = document.createElement('div');
      piece.className = 'confetti-piece';
      piece.style.cssText = `
        left: ${Math.random()*100}%;
        background: ${colors[Math.floor(Math.random()*colors.length)]};
        width: ${6+Math.random()*8}px;
        height: ${6+Math.random()*8}px;
        border-radius: ${Math.random()>0.5?'50%':'2px'};
        animation-duration: ${1.5+Math.random()*2}s;
        animation-delay: ${Math.random()*.5}s;
      `;
      container.appendChild(piece);
    }
    setTimeout(() => { container.innerHTML = ''; }, 3500);
  }

  updatePies();
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
<section class="tool-article" style="--accent-color:#c084fc">

  <h2>How to Use This Calculator</h2>
  <p>This calculator handles all four fraction operations: addition, subtraction, multiplication, and division. Enter your two fractions, pick an operation, and press Calculate. The result appears as a fully simplified fraction along with a decimal equivalent, and the pie charts at the top update in real time so you get a visual feel for each value before you even click.</p>
  <ol>
    <li>Type the numerator (top number) of Fraction A into the upper input box, then type the denominator (bottom number) below the dividing line.</li>
    <li>Do the same for Fraction B in the second box.</li>
    <li>Click one of the four operation buttons: + for addition, - for subtraction, x for multiplication, or the division symbol.</li>
    <li>Press the Calculate button. The answer appears below with the full step-by-step working shown.</li>
    <li>If the result is an improper fraction, the calculator also shows the equivalent mixed number.</li>
  </ol>
  <p>You can chain calculations by reading the result and typing it back in as one of your fractions for the next step. Negative numerators are supported too, so problems like -3/4 + 1/2 work fine.</p>

  <h2>What Fractions Actually Mean</h2>
  <p>A fraction is just a way of writing division. The number on the bottom, called the denominator, says how many equal pieces the whole has been cut into. The number on top, called the numerator, says how many of those pieces you are holding.</p>
  <p>So 3/8 means the whole was sliced into 8 equal parts and you have 3 of them. Think of a pizza cut into 8 slices and you ate 3 - that is exactly 3/8 of the pizza.</p>
  <p>There are three types worth knowing:</p>
  <ul>
    <li><strong>Proper fractions</strong> have a numerator smaller than the denominator, like 2/5. They represent less than one whole.</li>
    <li><strong>Improper fractions</strong> have a numerator equal to or larger than the denominator, like 9/4. They represent one whole or more.</li>
    <li><strong>Mixed numbers</strong> combine a whole number and a proper fraction, like 2 and 1/4. They are just another way to write an improper fraction.</li>
  </ul>
  <p>Both improper fractions and mixed numbers are equally valid answers. Your teacher may prefer one form, but they describe the same amount.</p>

  <h2>The Four Operations at a Glance</h2>
  <p>Each operation follows its own short set of rules. Here is a summary before the detailed walkthroughs below:</p>
  <table class="ta-table">
    <thead>
      <tr><th>Operation</th><th>Core Rule</th><th>Quick Example</th><th>Result</th></tr>
    </thead>
    <tbody>
      <tr><td>Addition</td><td>Common denominator, then add numerators</td><td>1/4 + 1/6</td><td>5/12</td></tr>
      <tr><td>Subtraction</td><td>Common denominator, then subtract numerators</td><td>5/6 - 1/4</td><td>7/12</td></tr>
      <tr><td>Multiplication</td><td>Numerator times numerator, denominator times denominator</td><td>2/3 x 3/5</td><td>2/5</td></tr>
      <tr><td>Division</td><td>Flip the second fraction, then multiply</td><td>3/4 / 3/8</td><td>2</td></tr>
    </tbody>
  </table>

  <div class="ta-box">
    <strong>Worked Example: Subtracting 5/6 - 1/4</strong>
    The denominators are 6 and 4. The lowest common denominator is 12. Convert: 5/6 becomes 10/12, and 1/4 becomes 3/12. Subtract the numerators: 10 - 3 = 7. Answer: 7/12.
  </div>

  <h2>Step-by-Step: Adding Fractions</h2>
  <p>Adding fractions trips people up because you cannot just add the top numbers and add the bottom numbers separately. The denominators must match first. Here is a full walkthrough with 3/8 + 5/12.</p>
  <ol>
    <li><strong>Find the lowest common denominator (LCD).</strong> The LCD of 8 and 12 is 24. To find it, list multiples of the larger number until you hit one that the smaller also divides into evenly. Multiples of 12: 12, 24. Does 8 divide into 24? Yes (24 / 8 = 3). So the LCD is 24.</li>
    <li><strong>Convert each fraction to the LCD.</strong> For 3/8: multiply top and bottom by 3, giving 9/24. For 5/12: multiply top and bottom by 2, giving 10/24.</li>
    <li><strong>Add the numerators.</strong> 9 + 10 = 19. Keep the denominator as 24. You now have 19/24.</li>
    <li><strong>Check if you can simplify.</strong> Does any number other than 1 divide both 19 and 24? 19 is prime, so no. The answer is already in simplest form: 19/24.</li>
  </ol>

  <div class="ta-box">
    <strong>Worked Example: Adding 2/5 + 3/4</strong>
    LCD of 5 and 4 is 20. Convert: 2/5 = 8/20, and 3/4 = 15/20. Add: 8 + 15 = 23. Result: 23/20. That is an improper fraction, so as a mixed number it is 1 and 3/20.
  </div>

  <h2>Step-by-Step: Dividing Fractions</h2>
  <p>Division looks scarier than it is. The trick has one name: keep, change, flip. Keep the first fraction exactly as it is. Change the division sign to multiplication. Flip (invert) the second fraction. Then multiply normally.</p>
  <ol>
    <li><strong>Write down the problem.</strong> Say you have 5/6 divided by 2/3.</li>
    <li><strong>Keep the first fraction.</strong> 5/6 stays as 5/6.</li>
    <li><strong>Change division to multiplication.</strong> The sign becomes x.</li>
    <li><strong>Flip the second fraction.</strong> 2/3 becomes 3/2.</li>
    <li><strong>Multiply.</strong> (5 x 3) / (6 x 2) = 15/12.</li>
    <li><strong>Simplify.</strong> The GCF of 15 and 12 is 3. Divide both: 15/3 = 5 and 12/3 = 4. Final answer: 5/4, or 1 and 1/4 as a mixed number.</li>
  </ol>

  <div class="ta-box">
    <strong>Did You Know?</strong>
    Dividing by a fraction is the same as multiplying by its reciprocal. That is why the "flip and multiply" rule always works - you are not doing anything magical, you are just rewriting the division as a multiplication by the inverse value.
  </div>

  <h2>Simplifying Fractions</h2>
  <p>A fraction is in its simplest form when the numerator and denominator share no common factor greater than 1. This is also called being in lowest terms. To simplify, find the greatest common factor (GCF) of the two numbers and divide both by it.</p>
  <p>For example, 18/24: the GCF of 18 and 24 is 6. Divide both by 6: 18/6 = 3 and 24/6 = 4. Simplified answer: 3/4.</p>
  <p>One fast way to find the GCF is to list the factors of each number and spot the largest one they share:</p>
  <ul>
    <li>Factors of 18: 1, 2, 3, 6, 9, 18</li>
    <li>Factors of 24: 1, 2, 3, 4, 6, 8, 12, 24</li>
    <li>Common factors: 1, 2, 3, 6. Greatest: 6.</li>
  </ul>
  <p>If both numbers are even, start by dividing both by 2 and repeat until they are no longer both even. This is not the fastest method but it always works and avoids having to think too hard about large numbers.</p>

  <div class="ta-box">
    <strong>Worked Example: Simplify 36/48</strong>
    Both are even, so divide by 2: 18/24. Both still even, divide by 2 again: 9/12. Now divide by 3 (both divisible): 3/4. Done. Or just spot that GCF(36,48) = 12 from the start and do it in one step: 36/12 = 3, 48/12 = 4.
  </div>

  <h2>Mixed Numbers and Improper Fractions</h2>
  <p>These two forms represent the same value and you can move between them freely.</p>
  <p><strong>Improper fraction to mixed number:</strong> Divide the numerator by the denominator. The quotient is the whole number part. The remainder goes over the original denominator. For 11/4: 11 divided by 4 is 2 remainder 3, so the mixed number is 2 and 3/4.</p>
  <p><strong>Mixed number to improper fraction:</strong> Multiply the whole number by the denominator, then add the numerator. That total becomes the new numerator; the denominator stays the same. For 3 and 2/5: (3 x 5) + 2 = 17, so the improper fraction is 17/5.</p>
  <p>When adding or subtracting mixed numbers, the cleanest approach is usually to convert to improper fractions first, do the operation, then convert back. This calculator handles mixed numbers internally using that same approach.</p>

  <h2>Fraction to Decimal Reference</h2>
  <p>These are the most common fractions you will encounter. Memorising a few of them makes it much faster to check whether a calculator answer looks right.</p>
  <table class="ta-table">
    <thead>
      <tr><th>Fraction</th><th>Decimal</th><th>Percentage</th></tr>
    </thead>
    <tbody>
      <tr><td>1/2</td><td>0.5</td><td>50%</td></tr>
      <tr><td>1/3</td><td>0.333...</td><td>33.3%</td></tr>
      <tr><td>2/3</td><td>0.666...</td><td>66.7%</td></tr>
      <tr><td>1/4</td><td>0.25</td><td>25%</td></tr>
      <tr><td>3/4</td><td>0.75</td><td>75%</td></tr>
      <tr><td>1/5</td><td>0.2</td><td>20%</td></tr>
      <tr><td>3/5</td><td>0.6</td><td>60%</td></tr>
      <tr><td>1/6</td><td>0.1666...</td><td>16.7%</td></tr>
      <tr><td>1/8</td><td>0.125</td><td>12.5%</td></tr>
      <tr><td>1/10</td><td>0.1</td><td>10%</td></tr>
    </tbody>
  </table>
  <p>Fractions like 1/3 and 1/6 produce repeating decimals, which is why those are often easier to leave as fractions rather than converting to decimal form in calculations.</p>

  <h2>Common Mistakes to Avoid</h2>
  <p>Most fraction errors come from a small set of habits. Watch out for these:</p>
  <ul>
    <li><strong>Adding the denominators.</strong> When you add 1/3 + 1/4, the answer is not 2/7. The denominators are not terms to add - they describe the size of the pieces. The denominator in the answer comes from finding a common base.</li>
    <li><strong>Skipping the common denominator step.</strong> You must convert both fractions to the same denominator before adding or subtracting. Even one step skipped gives a wrong answer.</li>
    <li><strong>Flipping the first fraction when dividing.</strong> The rule is to flip the second fraction (the divisor), not the first. 3/4 / 2/5 means flip 2/5 to get 5/2, then multiply: 3/4 x 5/2 = 15/8.</li>
    <li><strong>Leaving the answer unsimplified.</strong> 6/8 and 3/4 are equal, but 3/4 is the expected form. Always check the GCF of your numerator and denominator.</li>
    <li><strong>Forgetting the negative sign.</strong> With negative fractions, track the sign separately. A fraction is negative if either the numerator or denominator is negative - but not if both are (negative over negative is positive).</li>
    <li><strong>Multiplying when you meant to divide.</strong> The two operations feel similar because division becomes multiplication after the flip. Double-check which operation the problem asks for before you start.</li>
  </ul>

  <h2>Where Fractions Show Up in Real Life</h2>
  <p>Fractions are not just classroom exercises - they appear in practical situations all the time.</p>
  <ul>
    <li><strong>Cooking and baking:</strong> Recipes almost always use fractions. If a recipe calls for 3/4 cup of flour and you want to make half the batch, you need 3/4 x 1/2 = 3/8 cup.</li>
    <li><strong>Home improvement:</strong> Measuring wood, tile, or fabric requires fractions. Cutting a 2 and 3/8 inch piece from a 5 and 1/4 inch board means subtracting mixed numbers.</li>
    <li><strong>Finance:</strong> Interest rates, discounts, and tax rates are often expressed as fractions. A 1/4 percent change in a mortgage rate on a large loan translates to real money.</li>
    <li><strong>Time management:</strong> Scheduling often involves fractions of an hour. A 45-minute meeting is 3/4 of an hour. If you have three such meetings, that is 3 x 3/4 = 9/4 = 2 and 1/4 hours.</li>
    <li><strong>Probability:</strong> The chance of rolling a 3 on a standard die is 1/6. Two such rolls land on 3 with probability 1/6 x 1/6 = 1/36.</li>
    <li><strong>Music:</strong> Time signatures in music are fractions. A 3/4 time signature means 3 quarter-note beats per measure, which is why a waltz has that distinctive three-count feel.</li>
  </ul>
  <p>Once you are comfortable with the mechanics, fractions become a natural tool for any problem that involves parts of a whole. The calculator above is here when the arithmetic gets tedious, but understanding the steps means you can catch an unexpected answer and investigate why it happened.</p>

  </section>

<div class="tool-nav-row">
  <div class="tool-nav-placeholder"></div>
  <a href="/math-tools/percentage-calculator" class="tool-nav-card tool-nav-next" style="--tnc-color:#14b8a6">
    <div class="tool-nav-icon"><i class="fa-solid fa-percent"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Next</div><div class="tool-nav-name">Percentage Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-right"></i></div>
  </a>
</div>

<div class="topic-quiz" id="tool-quiz">
  <div class="quiz-header" style="background:#a855f7">
    <i class="fa-solid fa-circle-question"></i> Quick Quiz
    <span class="quiz-sub">3 questions</span>
  </div>
  <div class="quiz-body">
    <div class="quiz-q" data-qi="0" data-correct="1">
      <p class="quiz-question"><strong>Q1.</strong> What is 1/2 + 1/4?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">1/6</button>
        <button class="quiz-opt" data-oi="1">3/4</button>
        <button class="quiz-opt" data-oi="2">2/6</button>
        <button class="quiz-opt" data-oi="3">3/6</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="1" data-correct="2">
      <p class="quiz-question"><strong>Q2.</strong> What is 3/4 × 4/3?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">9/12</button>
        <button class="quiz-opt" data-oi="1">7/7</button>
        <button class="quiz-opt" data-oi="2">1</button>
        <button class="quiz-opt" data-oi="3">12/9</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="2" data-correct="2">
      <p class="quiz-question"><strong>Q3.</strong> Which fraction is smallest?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">2/3</button>
        <button class="quiz-opt" data-oi="1">3/4</button>
        <button class="quiz-opt" data-oi="2">1/2</button>
        <button class="quiz-opt" data-oi="3">5/8</button>
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
