<?php require_once __DIR__ . '/../config.php'; $page_title = 'Number Base Converter'; $page_desc = 'Convert numbers between binary, octal, decimal and hexadecimal with glowing bit-display visualization.'; $body_class = 'page-article'; include __DIR__ . '/../_header.php'; ?>

<style>
.base-page { background: #1a2038; min-height: 60vh; padding: 2rem 1rem; color: #c8d4f0; font-family: 'Segoe UI', sans-serif; border-radius: 16px; overflow: hidden; max-width: 900px; margin-left: auto; margin-right: auto; }
.base-hero { text-align: center; margin-bottom: 2rem; }
.base-hero h1 { color: #c8d4f0; font-size: 2.2rem; font-weight: 800; margin: 0; text-shadow: 0 0 20px #f5a62344; }
.base-hero p { color: #7c8bb0; font-size: 1.05rem; margin-top: .4rem; }
.base-main { max-width: 800px; margin: 0 auto; }
.base-input-wrap { background: #222840; border-radius: 20px; border: 1.5px solid #2e3a5c; padding: 1.5rem; margin-bottom: 1.5rem; }
.base-input-wrap label { display: block; font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #f5a623; margin-bottom: .6rem; }
.base-source-row { display: flex; gap: .8rem; flex-wrap: wrap; align-items: center; }
.base-input { flex: 1; background: #1a2038; border: 2px solid #2e3a5c; color: #c8d4f0; font-size: 1.6rem; font-weight: 800; border-radius: 12px; padding: .55rem 1rem; outline: none; transition: border-color .2s; font-family: 'Courier New', monospace; min-width: 160px; }
.base-input:focus { border-color: #f5a623; box-shadow: 0 0 0 3px #f5a62322; }
.base-from-select { background: #1a2038; border: 2px solid #2e3a5c; color: #c8d4f0; font-size: .95rem; font-weight: 700; border-radius: 10px; padding: .6rem .9rem; outline: none; cursor: pointer; }
.base-btn { background: linear-gradient(135deg, #f5a623, #e8901a); color: #1a2038; font-size: 1rem; font-weight: 800; border: none; border-radius: 12px; padding: .65rem 1.5rem; cursor: pointer; transition: all .2s; white-space: nowrap; }
.base-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px #f5a62355; }
.base-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; }
@media (max-width: 580px) { .base-grid { grid-template-columns: 1fr; } }
.base-card { background: #222840; border: 1.5px solid #2e3a5c; border-radius: 18px; padding: 1.3rem; transition: border-color .3s; }
.base-card.active-base { border-color: #f5a623; box-shadow: 0 0 20px #f5a62322; }
.base-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: .8rem; }
.base-card-title { font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; }
.base-card-sub { font-size: .7rem; color: #5a6a8a; }
.base-value { font-family: 'Courier New', monospace; font-size: 1.3rem; font-weight: 800; color: #f5a623; word-break: break-all; min-height: 2em; cursor: pointer; transition: color .2s; }
.base-value:hover { color: #ffd700; }
.bit-display { display: flex; flex-wrap: wrap; gap: 4px; margin-top: .7rem; }
.bit { width: 22px; height: 22px; border-radius: 5px; display: flex; align-items: center; justify-content: center; font-size: .7rem; font-weight: 800; transition: all .3s; }
.bit.on { background: #f5a623; color: #1a2038; box-shadow: 0 0 8px #f5a62388; }
.bit.off { background: #1a2038; color: #3a4a6c; border: 1px solid #2e3a5c; }
.hex-display { display: flex; flex-wrap: wrap; gap: 5px; margin-top: .7rem; }
.hex-digit { font-size: 1.1rem; font-weight: 900; font-family: 'Courier New', monospace; padding: .2rem .4rem; border-radius: 6px; transition: all .3s; }
.octal-display { display: flex; flex-wrap: wrap; gap: 5px; margin-top: .6rem; }
.octal-digit { font-size: 1.1rem; font-weight: 800; font-family: 'Courier New', monospace; color: #818cf8; }
.dec-bar { height: 6px; border-radius: 3px; background: linear-gradient(90deg, #f5a623, #2dd4bf); margin-top: .6rem; transition: width .5s cubic-bezier(.4,0,.2,1); }
.copy-badge { font-size: .65rem; background: #2e3a5c; border-radius: 6px; padding: .15rem .4rem; color: #7c8bb0; cursor: pointer; transition: all .15s; border: none; }
.copy-badge:hover { background: #f5a623; color: #1a2038; }
.base-error { color: #f43f5e; font-size: .85rem; font-weight: 600; margin-top: .4rem; display: none; }
.tooltip { position: fixed; background: #f5a623; color: #1a2038; font-size: .75rem; font-weight: 700; padding: .25rem .6rem; border-radius: 6px; pointer-events: none; z-index: 999; animation: fadeInOut .8s forwards; }
@keyframes fadeInOut { 0% {opacity:0;transform:translateY(4px);} 30% {opacity:1;transform:translateY(0);} 70% {opacity:1;} 100% {opacity:0;} }
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
  <span>Number Base Converter</span>
</nav>
<div class="tool-page-layout" style="max-width:1100px;width:100%;margin:0 auto;padding:24px 24px 48px;box-sizing:border-box;">
<div class="tool-nav-row">
  <a href="/math-tools/triangle-calculator" class="tool-nav-card" style="--tnc-color:#14b8a6">
    <div class="tool-nav-icon"><i class="fa-solid fa-draw-polygon"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Previous</div><div class="tool-nav-name">Triangle Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-left"></i></div>
  </a>
  <div class="tool-nav-placeholder"></div>
</div>
<div class="base-page">
  <div class="base-main">
    <div class="base-hero">
      <h1>Number Base Converter</h1>
    </div>

    <div class="base-input-wrap">
      <label><i class="fa-solid fa-keyboard" style="margin-right:.3rem;"></i>Enter a Number</label>
      <div class="base-source-row">
        <input class="base-input" type="text" id="baseInput" placeholder="e.g. 255" value="42">
        <select class="base-from-select" id="fromBase">
          <option value="10">Decimal (Base 10)</option>
          <option value="2">Binary (Base 2)</option>
          <option value="8">Octal (Base 8)</option>
          <option value="16">Hex (Base 16)</option>
        </select>
        <button class="base-btn" onclick="doConvert()"><i class="fa-solid fa-bolt" style="margin-right:.3rem;"></i>Convert</button>
      </div>
      <div class="base-error" id="baseError"></div>
    </div>

    <div class="base-grid">
      <!-- Binary -->
      <div class="base-card" id="card-bin">
        <div class="base-card-header">
          <span class="base-card-title" style="color:#f5a623;">Binary</span>
          <span class="base-card-sub">Base 2 (0s and 1s)</span>
          <button class="copy-badge" onclick="copyVal('binVal')">Copy</button>
        </div>
        <div class="base-value" id="binVal" onclick="setFromBase('binVal','2')">-</div>
        <div class="bit-display" id="bitDisplay"></div>
      </div>

      <!-- Octal -->
      <div class="base-card" id="card-oct">
        <div class="base-card-header">
          <span class="base-card-title" style="color:#818cf8;">Octal</span>
          <span class="base-card-sub">Base 8 (0-7)</span>
          <button class="copy-badge" onclick="copyVal('octVal')">Copy</button>
        </div>
        <div class="base-value" id="octVal" onclick="setFromBase('octVal','8')" style="color:#818cf8;">-</div>
        <div class="octal-display" id="octDisplay"></div>
      </div>

      <!-- Decimal -->
      <div class="base-card" id="card-dec">
        <div class="base-card-header">
          <span class="base-card-title" style="color:#2dd4bf;">Decimal</span>
          <span class="base-card-sub">Base 10 (0-9)</span>
          <button class="copy-badge" onclick="copyVal('decVal')">Copy</button>
        </div>
        <div class="base-value" id="decVal" onclick="setFromBase('decVal','10')" style="color:#2dd4bf;">-</div>
        <div class="dec-bar" id="decBar" style="width:0;"></div>
      </div>

      <!-- Hex -->
      <div class="base-card" id="card-hex">
        <div class="base-card-header">
          <span class="base-card-title" style="color:#f43f5e;">Hexadecimal</span>
          <span class="base-card-sub">Base 16 (0-9, A-F)</span>
          <button class="copy-badge" onclick="copyVal('hexVal')">Copy</button>
        </div>
        <div class="base-value" id="hexVal" onclick="setFromBase('hexVal','16')" style="color:#f43f5e;">-</div>
        <div class="hex-display" id="hexDisplay"></div>
      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const HEX_COLORS = ['#f43f5e','#f97316','#f5a623','#eab308','#84cc16','#22c55e','#14b8a6','#06b6d4','#3b82f6','#6366f1','#8b5cf6','#a855f7','#ec4899','#f43f5e','#fb923c','#fbbf24'];

  function updateBits(binStr) {
    const container = document.getElementById('bitDisplay');
    container.innerHTML = '';
    const padded = binStr.length < 8 ? binStr.padStart(8, '0') : binStr;
    padded.split('').forEach((bit, i) => {
      const span = document.createElement('div');
      span.className = 'bit ' + (bit === '1' ? 'on' : 'off');
      span.textContent = bit;
      span.style.animationDelay = i * 30 + 'ms';
      container.appendChild(span);
    });
  }

  function updateHex(hexStr) {
    const container = document.getElementById('hexDisplay');
    container.innerHTML = '';
    hexStr.split('').forEach((ch, i) => {
      const span = document.createElement('span');
      span.className = 'hex-digit';
      const v = parseInt(ch, 16);
      span.style.cssText = `color: ${HEX_COLORS[v] || '#c8d4f0'}; background: ${HEX_COLORS[v]}22; border-radius: 4px; padding: .1rem .3rem;`;
      span.textContent = ch.toUpperCase();
      container.appendChild(span);
    });
  }

  function updateOctal(octStr) {
    const container = document.getElementById('octDisplay');
    container.innerHTML = '';
    octStr.split('').forEach(ch => {
      const span = document.createElement('span');
      span.className = 'octal-digit';
      span.textContent = ch;
      container.appendChild(span);
    });
  }

  function updateDecBar(val, max) {
    const bar = document.getElementById('decBar');
    const pct = Math.min((val / Math.max(max, 1)) * 100, 100);
    bar.style.width = pct + '%';
  }

  window.doConvert = function() {
    const raw = document.getElementById('baseInput').value.trim().toUpperCase();
    const fromBase = parseInt(document.getElementById('fromBase').value);
    const errEl = document.getElementById('baseError');
    errEl.style.display = 'none';

    if(!raw) { errEl.textContent = 'Please enter a number!'; errEl.style.display = 'block'; return; }

    // Validate
    const validChars = { 2: /^[01]+$/, 8: /^[0-7]+$/, 10: /^\d+$/, 16: /^[0-9A-F]+$/ };
    if(!validChars[fromBase].test(raw)) {
      errEl.textContent = `Invalid ${fromBase === 2 ? 'binary' : fromBase === 8 ? 'octal' : fromBase === 10 ? 'decimal' : 'hex'} number!`;
      errEl.style.display = 'block';
      return;
    }

    const decimal = parseInt(raw, fromBase);
    if(decimal > 2147483647) {
      errEl.textContent = 'Number too large! Maximum is 2,147,483,647.';
      errEl.style.display = 'block';
      return;
    }

    const binStr = decimal.toString(2);
    const octStr = decimal.toString(8);
    const decStr = decimal.toString(10);
    const hexStr = decimal.toString(16).toUpperCase();

    // Animate values with transition
    const setVal = (id, val) => {
      const el = document.getElementById(id);
      el.style.opacity = '0';
      setTimeout(() => {
        el.textContent = val;
        el.style.opacity = '1';
        el.style.transition = 'opacity .3s';
      }, 150);
    };

    setVal('binVal', binStr);
    setVal('octVal', octStr);
    setVal('decVal', decStr);
    setVal('hexVal', hexStr);

    setTimeout(() => {
      updateBits(binStr);
      updateOctal(octStr);
      updateDecBar(decimal, 65535);
      updateHex(hexStr);
    }, 200);

    // Highlight active source base card
    ['bin','oct','dec','hex'].forEach(b => {
      document.getElementById('card-' + b).classList.remove('active-base');
    });
    const baseMap = { '2':'bin', '8':'oct', '10':'dec', '16':'hex' };
    if(baseMap[fromBase]) document.getElementById('card-' + baseMap[fromBase]).classList.add('active-base');
  };

  window.setFromBase = function(valId, base) {
    const val = document.getElementById(valId).textContent;
    if(val === '-') return;
    document.getElementById('baseInput').value = val;
    document.getElementById('fromBase').value = base;
    doConvert();
  };

  window.copyVal = function(id) {
    const val = document.getElementById(id).textContent;
    if(val === '-') return;
    navigator.clipboard.writeText(val).catch(() => {});
    const el = document.getElementById(id);
    const rect = el.getBoundingClientRect();
    const tip = document.createElement('div');
    tip.className = 'tooltip';
    tip.textContent = 'Copied!';
    tip.style.left = (rect.left + window.scrollX) + 'px';
    tip.style.top = (rect.top + window.scrollY - 30) + 'px';
    document.body.appendChild(tip);
    setTimeout(() => tip.remove(), 900);
  };

  document.getElementById('baseInput').addEventListener('keydown', e => {
    if(e.key === 'Enter') doConvert();
  });

  doConvert();
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

  <h2>How to Use This Converter</h2>
  <p>Type your number in any of the four fields: decimal, binary, octal, or hexadecimal. The tool converts it instantly into all the other bases at the same time. You can type a decimal like 255, a binary like 11111111, or a hex value like FF. All four outputs update as you type.</p>

  <h2>Number Bases Explained</h2>
  <p>Every number system uses positional notation. The position of a digit tells you what power of the base to multiply it by. In decimal (base 10), the number 352 means 3 x 100 + 5 x 10 + 2 x 1. The base tells you how many symbols you have before you run out and roll over to the next position.</p>
  <p>Decimal has 10 symbols (0-9). Binary has 2 (0 and 1). Each number system works the same way, just with a different base.</p>

  <h2>The Four Common Bases</h2>
  <table class="ta-table">
    <thead><tr><th>Base</th><th>Name</th><th>Digits Used</th><th>Common Use</th></tr></thead>
    <tbody>
      <tr><td>2</td><td>Binary</td><td>0, 1</td><td>Computer hardware, logic circuits</td></tr>
      <tr><td>8</td><td>Octal</td><td>0-7</td><td>Unix file permissions, legacy systems</td></tr>
      <tr><td>10</td><td>Decimal</td><td>0-9</td><td>Everyday arithmetic</td></tr>
      <tr><td>16</td><td>Hexadecimal</td><td>0-9, A-F</td><td>HTML colors, memory addresses, RGB</td></tr>
    </tbody>
  </table>

  <h2>Converting Decimal to Binary</h2>
  <p>Divide your decimal number by 2 repeatedly. Write down the remainder at each step (it will always be 0 or 1). When you reach 0, read the remainders from bottom to top. That sequence is your binary number.</p>
  <div class="ta-box">
    <strong>Example: decimal 13 to binary</strong>
    13 / 2 = 6 remainder 1<br>
    6 / 2 = 3 remainder 0<br>
    3 / 2 = 1 remainder 1<br>
    1 / 2 = 0 remainder 1<br>
    Read bottom to top: 1101. So 13 in binary is 1101.
  </div>

  <h2>Hexadecimal in Practice</h2>
  <p>Hexadecimal uses 16 symbols: the digits 0 through 9, then the letters A through F. A = 10, B = 11, C = 12, D = 13, E = 14, F = 15. It is a compact way to write binary because one hex digit always equals exactly 4 binary digits.</p>
  <p>You see hex everywhere once you know to look. HTML color codes like #FF5733 are three hex pairs representing red, green, and blue values. Memory addresses in programming are almost always written in hex.</p>

  <h2>Common Mistakes to Avoid</h2>
  <ul>
    <li>Confusing octal with decimal. Octal numbers often start with a leading 0 in code (like 0755 in Unix), which means something different from decimal 755.</li>
    <li>Mixing up uppercase and lowercase hex letters. A and a both mean 10, but some systems are case-sensitive.</li>
    <li>Forgetting that place values double each step in binary. The rightmost position is 1, then 2, 4, 8, 16, 32, and so on.</li>
    <li>Reading binary remainders top to bottom instead of bottom to top when converting from decimal.</li>
  </ul>

  </section>

<div class="tool-nav-row">
  <a href="/math-tools/triangle-calculator" class="tool-nav-card" style="--tnc-color:#14b8a6">
    <div class="tool-nav-icon"><i class="fa-solid fa-draw-polygon"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Previous</div><div class="tool-nav-name">Triangle Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-left"></i></div>
  </a>
  <div class="tool-nav-placeholder"></div>
</div>

<div class="topic-quiz" id="tool-quiz">
  <div class="quiz-header" style="background:#0ea5e9">
    <i class="fa-solid fa-circle-question"></i> Quick Quiz
    <span class="quiz-sub">3 questions</span>
  </div>
  <div class="quiz-body">
    <div class="quiz-q" data-qi="0" data-correct="1">
      <p class="quiz-question"><strong>Q1.</strong> What is 1010 in binary equal to in decimal?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">8</button>
        <button class="quiz-opt" data-oi="1">10</button>
        <button class="quiz-opt" data-oi="2">12</button>
        <button class="quiz-opt" data-oi="3">16</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="1" data-correct="1">
      <p class="quiz-question"><strong>Q2.</strong> What is 15 in decimal in hexadecimal?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">E</button>
        <button class="quiz-opt" data-oi="1">F</button>
        <button class="quiz-opt" data-oi="2">10</button>
        <button class="quiz-opt" data-oi="3">1F</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="2" data-correct="0">
      <p class="quiz-question"><strong>Q3.</strong> What is 8 in decimal in binary?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">1000</button>
        <button class="quiz-opt" data-oi="1">1001</button>
        <button class="quiz-opt" data-oi="2">1010</button>
        <button class="quiz-opt" data-oi="3">1100</button>
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
