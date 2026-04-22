<?php require_once __DIR__ . '/../config.php'; $page_title = 'Roman Numeral Converter'; $page_desc = 'Convert numbers to Roman numerals and back with animated chisel-in symbol effects and breakdown tables.'; $body_class = 'page-article'; include __DIR__ . '/../_header.php'; ?>

<style>
.roman-page { background: #f2f2f7; min-height: 60vh; padding: 2rem 1rem; font-family: 'Segoe UI', sans-serif; border-radius: 16px; overflow: hidden; max-width: 900px; margin-left: auto; margin-right: auto; }
.roman-hero { text-align: center; margin-bottom: 2rem; }
.roman-hero h1 { color: #1c1c1e; font-size: 2.2rem; font-weight: 800; margin: 0; }
.roman-hero p { color: #636366; font-size: 1.05rem; margin-top: .4rem; }
.roman-main { max-width: 660px; margin: 0 auto; }
.roman-toggle { display: flex; background: #fff; border-radius: 14px; padding: .35rem; gap: .3rem; margin-bottom: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
.toggle-btn { flex: 1; padding: .7rem; text-align: center; border-radius: 10px; cursor: pointer; font-size: .88rem; font-weight: 700; color: #636366; border: none; background: transparent; transition: all .2s; }
.toggle-btn.active { background: #007aff; color: #fff; box-shadow: 0 3px 10px #007aff44; }
.roman-card { background: #fff; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,.08); padding: 2rem; margin-bottom: 1.5rem; }
.roman-input-group { margin-bottom: 1.2rem; }
.roman-input-group label { display: block; font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #007aff; margin-bottom: .5rem; }
.roman-input { width: 100%; box-sizing: border-box; font-size: 1.8rem; font-weight: 800; color: #1c1c1e; border: 2px solid #e5e5ea; border-radius: 12px; padding: .6rem 1rem; outline: none; transition: border-color .2s; }
.roman-input:focus { border-color: #007aff; box-shadow: 0 0 0 3px #007aff22; }
.roman-btn { width: 100%; background: #007aff; color: #fff; font-size: 1.05rem; font-weight: 700; border: none; border-radius: 12px; padding: .9rem; cursor: pointer; transition: all .2s; box-shadow: 0 4px 14px #007aff44; }
.roman-btn:hover { background: #0066d6; transform: translateY(-1px); box-shadow: 0 8px 22px #007aff55; }
.parchment { background: #f4e9c4; border: 3px solid #c8a96e; border-radius: 16px; padding: 2rem; text-align: center; min-height: 120px; display: flex; align-items: center; justify-content: center; flex-direction: column; margin: 1.2rem 0; box-shadow: inset 0 0 30px rgba(0,0,0,.08), 0 4px 16px rgba(0,0,0,.1); position: relative; overflow: hidden; }
.parchment::before, .parchment::after {
  content: '';
  position: absolute;
  width: 100%;
  height: 10px;
  left: 0;
}
.parchment::before { top: 0; background: linear-gradient(180deg, #c8a96e22, transparent); }
.parchment::after { bottom: 0; background: linear-gradient(0deg, #c8a96e22, transparent); }
.roman-symbols { display: flex; gap: .4rem; flex-wrap: wrap; justify-content: center; }
.roman-sym { font-size: 3rem; font-weight: 900; color: #5c3d11; font-family: 'Georgia', serif; display: inline-block; animation: chisel .4s cubic-bezier(.175,.885,.32,1.275) backwards; }
@keyframes chisel {
  0% { opacity: 0; transform: scale(1.8) rotateY(90deg); filter: blur(4px); }
  60% { opacity: 1; transform: scale(1.05) rotateY(-5deg); filter: blur(0); }
  100% { opacity: 1; transform: scale(1) rotateY(0deg); filter: blur(0); }
}
.parchment-label { font-size: .78rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; color: #9a7040; margin-top: .8rem; }
.breakdown-table { width: 100%; border-collapse: collapse; border-radius: 12px; overflow: hidden; }
.breakdown-table th { background: #007aff; color: #fff; font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; padding: .6rem .9rem; text-align: left; }
.breakdown-table td { padding: .55rem .9rem; font-size: .9rem; border-bottom: 1.5px solid #f2f2f7; }
.breakdown-table tr:last-child td { border-bottom: none; }
.breakdown-table tr:nth-child(even) { background: #f9f9fb; }
.sym-cell { font-size: 1.2rem; font-weight: 900; color: #007aff; font-family: 'Georgia', serif; }
.val-cell { font-weight: 700; color: #1c1c1e; }
.result-section { display: none; }
.roman-error { color: #f43f5e; font-size: .9rem; font-weight: 600; margin-top: .5rem; display: none; }
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
  <span>Roman Numeral Converter</span>
</nav>
<div class="tool-page-layout" style="max-width:1100px;width:100%;margin:0 auto;padding:24px 24px 48px;box-sizing:border-box;">
<div class="tool-nav-row">
  <a href="/math-tools/exponent-calculator" class="tool-nav-card" style="--tnc-color:#f5a623">
    <div class="tool-nav-icon"><i class="fa-solid fa-superscript"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Previous</div><div class="tool-nav-name">Exponent Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-left"></i></div>
  </a>
  <a href="/math-tools/times-table" class="tool-nav-card tool-nav-next" style="--tnc-color:#c084fc">
    <div class="tool-nav-icon"><i class="fa-solid fa-table-cells"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Next</div><div class="tool-nav-name">Times Table</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-right"></i></div>
  </a>
</div>
<div class="roman-page">
  <div class="roman-main">
    <div class="roman-hero">
      <h1>Roman Numeral Converter</h1>
    </div>

    <div class="roman-toggle">
      <button class="toggle-btn active" id="toRomanBtn" onclick="setMode('toRoman')">
        <i class="fa-solid fa-arrow-right" style="margin-right:.3rem;"></i>Number → Roman
      </button>
      <button class="toggle-btn" id="toNumBtn" onclick="setMode('toNum')">
        <i class="fa-solid fa-arrow-left" style="margin-right:.3rem;"></i>Roman → Number
      </button>
    </div>

    <div class="roman-card">
      <!-- Number to Roman -->
      <div id="panel-toRoman">
        <div class="roman-input-group">
          <label>Enter a Number (1 - 3999)</label>
          <input class="roman-input" type="number" id="numInput" placeholder="e.g. 2024" min="1" max="3999">
        </div>
        <div class="roman-error" id="numError"></div>
        <button class="roman-btn" onclick="convertToRoman()"><i class="fa-solid fa-landmark" style="margin-right:.4rem;"></i>Convert to Roman</button>
      </div>

      <!-- Roman to Number -->
      <div id="panel-toNum" style="display:none;">
        <div class="roman-input-group">
          <label>Enter Roman Numerals</label>
          <input class="roman-input" type="text" id="romanInput" placeholder="e.g. MMXXIV" style="text-transform:uppercase; letter-spacing:.1em; font-family:'Georgia',serif;">
        </div>
        <div class="roman-error" id="romanError"></div>
        <button class="roman-btn" onclick="convertToNum()"><i class="fa-solid fa-hashtag" style="margin-right:.4rem;"></i>Convert to Number</button>
      </div>

      <div class="parchment" id="parchmentDisplay">
        <div class="roman-symbols" id="romanSymbols"></div>
        <div class="parchment-label" id="parchmentLabel">Your result will appear here</div>
      </div>

      <div class="result-section" id="resultSection">
        <table class="breakdown-table">
          <thead>
            <tr><th>Symbol</th><th>Value</th><th>Count</th><th>Subtotal</th></tr>
          </thead>
          <tbody id="breakdownBody"></tbody>
        </table>
      </div>
    </div>

    <!-- Reference table -->
    <div class="roman-card">
      <h3 style="font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#007aff;margin:0 0 1rem;"><i class="fa-solid fa-table" style="margin-right:.3rem;"></i>Roman Numeral Reference</h3>
      <div style="display:flex;flex-wrap:wrap;gap:.5rem;">
        <table class="breakdown-table" style="width:auto;flex:1;">
          <thead><tr><th>Symbol</th><th>Value</th></tr></thead>
          <tbody>
            <tr><td class="sym-cell">I</td><td class="val-cell">1</td></tr>
            <tr><td class="sym-cell">V</td><td class="val-cell">5</td></tr>
            <tr><td class="sym-cell">X</td><td class="val-cell">10</td></tr>
            <tr><td class="sym-cell">L</td><td class="val-cell">50</td></tr>
          </tbody>
        </table>
        <table class="breakdown-table" style="width:auto;flex:1;">
          <thead><tr><th>Symbol</th><th>Value</th></tr></thead>
          <tbody>
            <tr><td class="sym-cell">C</td><td class="val-cell">100</td></tr>
            <tr><td class="sym-cell">D</td><td class="val-cell">500</td></tr>
            <tr><td class="sym-cell">M</td><td class="val-cell">1000</td></tr>
            <tr><td class="sym-cell">IV</td><td class="val-cell">4</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const ROMAN_MAP = [
    [1000,'M'],[900,'CM'],[500,'D'],[400,'CD'],
    [100,'C'],[90,'XC'],[50,'L'],[40,'XL'],
    [10,'X'],[9,'IX'],[5,'V'],[4,'IV'],[1,'I']
  ];

  window.setMode = function(mode) {
    document.getElementById('panel-toRoman').style.display = mode === 'toRoman' ? 'block' : 'none';
    document.getElementById('panel-toNum').style.display = mode === 'toNum' ? 'block' : 'none';
    document.getElementById('toRomanBtn').classList.toggle('active', mode === 'toRoman');
    document.getElementById('toNumBtn').classList.toggle('active', mode === 'toNum');
    document.getElementById('romanSymbols').innerHTML = '';
    document.getElementById('parchmentLabel').textContent = 'Your result will appear here';
    document.getElementById('resultSection').style.display = 'none';
  };

  function toRoman(num) {
    let result = '', steps = [];
    for(const [val, sym] of ROMAN_MAP) {
      while(num >= val) {
        result += sym;
        steps.push({sym, val, num: Math.floor(num/val), subtotal: Math.floor(num/val)*val});
        num -= val;
      }
    }
    return {result, steps};
  }

  function fromRoman(str) {
    const vals = {M:1000, D:500, C:100, L:50, X:10, V:5, I:1};
    let total = 0, prev = 0;
    const breakdown = {};
    for(let i = str.length - 1; i >= 0; i--) {
      const v = vals[str[i]];
      if(!v) return null;
      breakdown[str[i]] = (breakdown[str[i]] || 0) + 1;
      if(v < prev) total -= v;
      else total += v;
      prev = v;
    }
    return {total, breakdown};
  }

  function displaySymbols(roman) {
    const container = document.getElementById('romanSymbols');
    container.innerHTML = '';
    roman.split('').forEach((ch, i) => {
      const span = document.createElement('span');
      span.className = 'roman-sym';
      span.style.animationDelay = (i * 120) + 'ms';
      span.textContent = ch;
      container.appendChild(span);
    });
  }

  window.convertToRoman = function() {
    const num = parseInt(document.getElementById('numInput').value);
    const errEl = document.getElementById('numError');
    errEl.style.display = 'none';

    if(isNaN(num) || num < 1 || num > 3999) {
      errEl.textContent = 'Please enter a number between 1 and 3999.';
      errEl.style.display = 'block';
      return;
    }

    const {result, steps} = toRoman(num);
    displaySymbols(result);
    document.getElementById('parchmentLabel').textContent = num + ' in Roman numerals';

    const body = document.getElementById('breakdownBody');
    body.innerHTML = '';
    steps.forEach(s => {
      const tr = document.createElement('tr');
      tr.innerHTML = `<td class="sym-cell">${s.sym}</td><td class="val-cell">${s.val}</td><td>${s.num}</td><td>${s.subtotal}</td>`;
      body.appendChild(tr);
    });

    const total = document.createElement('tr');
    total.innerHTML = `<td colspan="3" style="font-weight:800;color:#007aff;font-size:.9rem;">Total</td><td style="font-weight:900;color:#007aff;">${num}</td>`;
    body.appendChild(total);

    document.getElementById('resultSection').style.display = 'block';
  };

  window.convertToNum = function() {
    const str = document.getElementById('romanInput').value.trim().toUpperCase();
    const errEl = document.getElementById('romanError');
    errEl.style.display = 'none';

    if(!str) { errEl.textContent = 'Please enter Roman numerals.'; errEl.style.display = 'block'; return; }
    if(!/^[MDCLXVI]+$/.test(str)) {
      errEl.textContent = 'Invalid Roman numerals! Only M, D, C, L, X, V, I are allowed.';
      errEl.style.display = 'block';
      return;
    }

    const res = fromRoman(str);
    if(!res) { errEl.textContent = 'Could not parse Roman numerals!'; errEl.style.display = 'block'; return; }

    displaySymbols(str);
    document.getElementById('parchmentLabel').textContent = str + ' = ' + res.total;

    const body = document.getElementById('breakdownBody');
    body.innerHTML = '';
    const vals = {M:1000, D:500, C:100, L:50, X:10, V:5, I:1};
    Object.entries(res.breakdown).forEach(([sym, count]) => {
      const tr = document.createElement('tr');
      tr.innerHTML = `<td class="sym-cell">${sym}</td><td class="val-cell">${vals[sym]}</td><td>${count}</td><td>${vals[sym]*count}</td>`;
      body.appendChild(tr);
    });

    const total = document.createElement('tr');
    total.innerHTML = `<td colspan="3" style="font-weight:800;color:#007aff;">Total</td><td style="font-weight:900;color:#007aff;">${res.total}</td>`;
    body.appendChild(total);

    document.getElementById('resultSection').style.display = 'block';
  };

  document.getElementById('numInput').addEventListener('keydown', e => { if(e.key === 'Enter') convertToRoman(); });
  document.getElementById('romanInput').addEventListener('input', function() { this.value = this.value.toUpperCase(); });
  document.getElementById('romanInput').addEventListener('keydown', e => { if(e.key === 'Enter') convertToNum(); });
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
<section class="tool-article" style="--accent-color:#007aff">

  <h2>How to Use This Converter</h2>
  <p>Type a number in the decimal box to see its Roman numeral equivalent. Or type a Roman numeral in the other box to convert it back to a regular number. The converter works in both directions instantly. Numbers from 1 to 3999 are supported, which covers the standard Roman numeral range.</p>

  <h2>The Seven Roman Numeral Symbols</h2>
  <table class="ta-table">
    <thead><tr><th>Symbol</th><th>Value</th><th>Notes</th></tr></thead>
    <tbody>
      <tr><td>I</td><td>1</td><td>Basic unit</td></tr>
      <tr><td>V</td><td>5</td><td>Cannot be repeated</td></tr>
      <tr><td>X</td><td>10</td><td>Used for tens</td></tr>
      <tr><td>L</td><td>50</td><td>Cannot be repeated</td></tr>
      <tr><td>C</td><td>100</td><td>Used for hundreds</td></tr>
      <tr><td>D</td><td>500</td><td>Cannot be repeated</td></tr>
      <tr><td>M</td><td>1000</td><td>Used for thousands</td></tr>
    </tbody>
  </table>

  <h2>Subtractive Notation</h2>
  <p>Normally, symbols are written largest to smallest and added together. VIII = 5 + 1 + 1 + 1 = 8. But when a smaller symbol comes before a larger one, you subtract it instead. This is called subtractive notation.</p>
  <p>There are exactly six subtractive pairs to learn: IV = 4, IX = 9, XL = 40, XC = 90, CD = 400, CM = 900. Any other combination simply adds. So XIV = 10 + (5 - 1) = 14.</p>

  <h2>How to Convert Step by Step</h2>
  <p>Use the greedy approach. Start with the largest symbol value that fits, write it down, subtract it from your number, then repeat. To convert 1999:</p>
  <ol>
    <li>1999 - 1000 = 999. Write M.</li>
    <li>999 - 900 = 99. Write CM.</li>
    <li>99 - 90 = 9. Write XC.</li>
    <li>9 - 9 = 0. Write IX.</li>
  </ol>
  <p>Result: MCMXCIX. Keep going until you reach 0.</p>

  <h2>Where Roman Numerals Appear Today</h2>
  <ul>
    <li>Clock and watch faces (especially analog clocks)</li>
    <li>Super Bowl numbering (Super Bowl LVIII, etc.)</li>
    <li>Movie release years in credits</li>
    <li>Chapter headings in books</li>
    <li>Monarch names like King Charles III</li>
  </ul>

  <h2>Common Mistakes to Avoid</h2>
  <ul>
    <li>Writing IIII instead of IV. The correct way to write 4 is IV.</li>
    <li>Putting a smaller symbol before a larger one when it is not one of the six valid subtractive pairs.</li>
    <li>Using the same symbol more than three times in a row. You can write III but not IIII or XXXX.</li>
    <li>Trying to write 0 or numbers above 3999 in standard Roman numerals. The system does not cover those.</li>
  </ul>

  </section>

<div class="tool-nav-row">
  <a href="/math-tools/exponent-calculator" class="tool-nav-card" style="--tnc-color:#f5a623">
    <div class="tool-nav-icon"><i class="fa-solid fa-superscript"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Previous</div><div class="tool-nav-name">Exponent Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-left"></i></div>
  </a>
  <a href="/math-tools/times-table" class="tool-nav-card tool-nav-next" style="--tnc-color:#c084fc">
    <div class="tool-nav-icon"><i class="fa-solid fa-table-cells"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Next</div><div class="tool-nav-name">Times Table</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-right"></i></div>
  </a>
</div>

<div class="topic-quiz" id="tool-quiz">
  <div class="quiz-header" style="background:#84cc16">
    <i class="fa-solid fa-circle-question"></i> Quick Quiz
    <span class="quiz-sub">3 questions</span>
  </div>
  <div class="quiz-body">
    <div class="quiz-q" data-qi="0" data-correct="1">
      <p class="quiz-question"><strong>Q1.</strong> What is the Roman numeral for 4?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">IIII</button>
        <button class="quiz-opt" data-oi="1">IV</button>
        <button class="quiz-opt" data-oi="2">VI</button>
        <button class="quiz-opt" data-oi="3">IIV</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="1" data-correct="1">
      <p class="quiz-question"><strong>Q2.</strong> What does XIV represent in decimal?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">11</button>
        <button class="quiz-opt" data-oi="1">14</button>
        <button class="quiz-opt" data-oi="2">16</button>
        <button class="quiz-opt" data-oi="3">40</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="2" data-correct="0">
      <p class="quiz-question"><strong>Q3.</strong> What is 50 in Roman numerals?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">L</button>
        <button class="quiz-opt" data-oi="1">C</button>
        <button class="quiz-opt" data-oi="2">D</button>
        <button class="quiz-opt" data-oi="3">M</button>
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
