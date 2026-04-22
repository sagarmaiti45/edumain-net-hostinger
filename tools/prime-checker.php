<?php require_once __DIR__ . '/../config.php'; $page_title = 'Prime Number Checker'; $page_desc = 'Check if any number is prime and see all its factors visualized as animated bubbles.'; $body_class = 'page-article'; include __DIR__ . '/../_header.php'; ?>

<style>
.prime-page { background: #14141c; min-height: 60vh; padding: 2rem 1rem; color: #dde0f0; font-family: 'Segoe UI', sans-serif; border-radius: 16px; overflow: hidden; max-width: 900px; margin-left: auto; margin-right: auto; }
.prime-hero { text-align: center; margin-bottom: 2rem; }
.prime-hero h1 { color: #dde0f0; font-size: 2.2rem; font-weight: 800; margin: 0; }
.prime-hero p { color: #6b6e8a; font-size: 1.05rem; margin-top: .4rem; }
.prime-main { max-width: 600px; margin: 0 auto; text-align: center; }
.prime-input-row { display: flex; gap: .8rem; margin-bottom: 2rem; justify-content: center; align-items: center; }
.prime-input { background: #1e1e2e; border: 2px solid #2e2e42; color: #dde0f0; font-size: 2rem; font-weight: 800; border-radius: 16px; padding: .6rem 1.2rem; outline: none; width: 220px; text-align: center; transition: border-color .2s; }
.prime-input:focus { border-color: #4ecdc4; box-shadow: 0 0 0 3px #4ecdc422; }
.prime-check-btn { background: linear-gradient(135deg, #4ecdc4, #2ab7ae); color: #14141c; font-size: 1.1rem; font-weight: 800; border: none; border-radius: 16px; padding: .75rem 1.8rem; cursor: pointer; transition: all .2s; box-shadow: 0 4px 16px #4ecdc444; white-space: nowrap; }
.prime-check-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px #4ecdc466; }
.prime-arena { position: relative; width: 320px; height: 320px; margin: 0 auto 2rem; }
.prime-circle { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 200px; height: 200px; border-radius: 50%; background: #1e1e2e; border: 3px solid #2e2e42; display: flex; flex-direction: column; align-items: center; justify-content: center; transition: border-color .5s, box-shadow .5s; z-index: 2; }
.prime-circle.prime { border-color: #4ade80; box-shadow: 0 0 40px #4ade8055, 0 0 80px #4ade8022; }
.prime-circle.composite { border-color: #f43f5e; box-shadow: 0 0 40px #f43f5e55, 0 0 80px #f43f5e22; }
.prime-number { font-size: 3.5rem; font-weight: 900; color: #dde0f0; line-height: 1; }
.prime-verdict { font-size: .9rem; font-weight: 700; margin-top: .3rem; }
.verdict-prime { color: #4ade80; }
.verdict-composite { color: #f43f5e; }
.factor-bubble { position: absolute; background: #2e2e42; border: 2px solid #4ecdc4; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; color: #4ecdc4; cursor: default; animation: bubblePop .5s cubic-bezier(.175,.885,.32,1.275) forwards; opacity: 0; z-index: 1; }
@keyframes bubblePop { 0% { opacity: 0; transform: translate(-50%, -50%) scale(0); } 70% { opacity: 1; transform: translate(var(--tx), var(--ty)) scale(1.2); } 100% { opacity: 1; transform: translate(var(--tx), var(--ty)) scale(1); } }
.prime-msg { font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem; min-height: 1.5em; }
.msg-prime { color: #4ade80; text-shadow: 0 0 12px #4ade8055; }
.msg-composite { color: #f43f5e; }
.factors-list { background: #1e1e2e; border: 1.5px solid #2e2e42; border-radius: 14px; padding: 1rem 1.5rem; text-align: left; display: none; animation: fadeIn .4s ease; }
@keyframes fadeIn { from { opacity:0; transform: translateY(10px); } to { opacity:1; transform: translateY(0); } }
.factors-list h4 { font-size: .78rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #4ecdc4; margin: 0 0 .6rem; }
.factor-chips { display: flex; flex-wrap: wrap; gap: .4rem; }
.factor-chip { background: #2e2e42; border: 1.5px solid #4ecdc455; border-radius: 8px; padding: .3rem .7rem; font-size: .9rem; font-weight: 700; color: #4ecdc4; }
.sparkle { position: absolute; pointer-events: none; animation: sparkleFly 1.2s ease forwards; opacity: 0; font-size: 1.2rem; }
@keyframes sparkleFly { 0% { opacity: 1; transform: translate(0,0) scale(1); } 100% { opacity: 0; transform: translate(var(--sx), var(--sy)) scale(0); } }
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
  <span>Prime Number Checker</span>
</nav>
<div class="tool-page-layout" style="max-width:1100px;width:100%;margin:0 auto;padding:24px 24px 48px;box-sizing:border-box;">
<div class="tool-nav-row">
  <a href="/math-tools/graphing-calculator" class="tool-nav-card" style="--tnc-color:#f5a623">
    <div class="tool-nav-icon"><i class="fa-solid fa-chart-line"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Previous</div><div class="tool-nav-name">Graphing Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-left"></i></div>
  </a>
  <a href="/math-tools/gcf-lcm-calculator" class="tool-nav-card tool-nav-next" style="--tnc-color:#c084fc">
    <div class="tool-nav-icon"><i class="fa-solid fa-circle-nodes"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Next</div><div class="tool-nav-name">GCF & LCM Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-right"></i></div>
  </a>
</div>
<div class="prime-page">
  <div class="prime-main">
    <div class="prime-hero">
      <h1>Prime Number Checker</h1>
    </div>

    <div class="prime-input-row">
      <input class="prime-input" type="number" id="primeInput" placeholder="Enter number" min="2" max="99999" value="">
      <button class="prime-check-btn" onclick="checkPrime()"><i class="fa-solid fa-magnifying-glass" style="margin-right:.3rem;"></i>CHECK</button>
    </div>

    <div class="prime-msg" id="primeMsg">Enter a number and press CHECK!</div>

    <div class="prime-arena" id="primeArena">
      <div class="prime-circle" id="primeCircle">
        <div class="prime-number" id="primeNum">?</div>
        <div class="prime-verdict" id="primeVerdict"></div>
      </div>
    </div>

    <div class="factors-list" id="factorsList">
      <h4><i class="fa-solid fa-list" style="margin-right:.3rem;"></i>All Factors</h4>
      <div class="factor-chips" id="factorChips"></div>
    </div>
  </div>
</div>

<script>
(function(){
  function isPrime(n) {
    if(n < 2) return false;
    if(n === 2) return true;
    if(n % 2 === 0) return false;
    for(let i = 3; i <= Math.sqrt(n); i += 2) {
      if(n % i === 0) return false;
    }
    return true;
  }

  function getFactors(n) {
    const factors = [];
    for(let i = 1; i <= n; i++) {
      if(n % i === 0) factors.push(i);
    }
    return factors;
  }

  function getPrimeFactors(n) {
    const factors = [];
    let d = 2;
    while(d * d <= n) {
      while(n % d === 0) { factors.push(d); n = Math.floor(n/d); }
      d++;
    }
    if(n > 1) factors.push(n);
    return factors;
  }

  function clearBubbles() {
    const arena = document.getElementById('primeArena');
    arena.querySelectorAll('.factor-bubble, .sparkle').forEach(el => el.remove());
  }

  function spawnSparkles(cx, cy) {
    const arena = document.getElementById('primeArena');
    const emojis = ['✨','⭐','💫','🌟'];
    for(let i = 0; i < 12; i++) {
      const s = document.createElement('div');
      s.className = 'sparkle';
      const angle = (i / 12) * 2 * Math.PI;
      const dist = 80 + Math.random() * 60;
      const sx = Math.cos(angle) * dist;
      const sy = Math.sin(angle) * dist;
      s.style.cssText = `left: ${cx}px; top: ${cy}px; --sx: ${sx}px; --sy: ${sy}px; animation-delay: ${Math.random()*.3}s;`;
      s.textContent = emojis[Math.floor(Math.random()*emojis.length)];
      arena.appendChild(s);
    }
  }

  function spawnFactorBubbles(factors, cx, cy) {
    const arena = document.getElementById('primeArena');
    const displayed = factors.filter(f => f !== 1 && f !== factors[factors.length-1]).slice(0, 10);
    const compositeFactors = factors.slice(1, -1);
    const toShow = compositeFactors.slice(0, 8);
    const total = toShow.length;
    toShow.forEach((f, i) => {
      const angle = (i / Math.max(total, 1)) * 2 * Math.PI - Math.PI/2;
      const dist = 120;
      const tx = Math.cos(angle) * dist;
      const ty = Math.sin(angle) * dist;
      const size = f < 10 ? 44 : f < 100 ? 50 : 58;
      const bubble = document.createElement('div');
      bubble.className = 'factor-bubble';
      bubble.style.cssText = `
        left: ${cx}px; top: ${cy}px;
        width: ${size}px; height: ${size}px;
        font-size: ${f < 100 ? '1rem' : '.8rem'};
        --tx: calc(${tx}px - 50%);
        --ty: calc(${ty}px - 50%);
        animation-delay: ${i * 0.08}s;
      `;
      bubble.textContent = f;
      arena.appendChild(bubble);
    });
  }

  window.checkPrime = function() {
    const val = parseInt(document.getElementById('primeInput').value);
    if(isNaN(val) || val < 1) { alert('Please enter a valid positive integer!'); return; }

    clearBubbles();
    const circle = document.getElementById('primeCircle');
    const numEl = document.getElementById('primeNum');
    const verdictEl = document.getElementById('primeVerdict');
    const msgEl = document.getElementById('primeMsg');
    const factorsList = document.getElementById('factorsList');
    const factorChips = document.getElementById('factorChips');

    numEl.textContent = val;
    circle.className = 'prime-circle';

    const prime = isPrime(val);
    const factors = getFactors(val);
    const primeFactors = getPrimeFactors(val);

    setTimeout(() => {
      if(prime) {
        circle.classList.add('prime');
        verdictEl.innerHTML = '<span class="verdict-prime">PRIME! ✨</span>';
        msgEl.innerHTML = '<span class="msg-prime">🎉 ' + val + ' is a PRIME number! It has no divisors except 1 and itself!</span>';
        factorsList.style.display = 'none';
        spawnSparkles(160, 160);
      } else {
        circle.classList.add('composite');
        verdictEl.innerHTML = '<span class="verdict-composite">Composite</span>';
        msgEl.innerHTML = '<span class="msg-composite">📊 ' + val + ' is composite. Prime factors: ' + primeFactors.join(' × ') + '</span>';
        factorChips.innerHTML = factors.map(f =>
          `<span class="factor-chip">${f}</span>`
        ).join('');
        factorsList.style.display = 'block';
        factorsList.style.animation = 'none';
        factorsList.offsetHeight;
        factorsList.style.animation = 'fadeIn .4s ease';
        spawnFactorBubbles(factors, 160, 160);
      }
    }, 100);
  };

  document.getElementById('primeInput').addEventListener('keydown', e => {
    if(e.key === 'Enter') checkPrime();
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

  <h2>How to Use This Checker</h2>
  <p>Type any whole number into the input field and press Check. The tool instantly tells you whether the number is prime or composite. If it is composite, you will also see all its factors displayed as animated bubbles. Try entering numbers like 17, 49, or 97 to see how they differ.</p>

  <h2>What Makes a Number Prime</h2>
  <p>A prime number has exactly two factors: 1 and itself. That is the whole definition. 7 is prime because the only numbers that divide evenly into 7 are 1 and 7. 8 is not prime because you can also divide it by 2 and 4.</p>
  <p>The number 1 is not prime. It only has one factor, which is itself. Prime numbers must have exactly two factors. The number 2 is the only even prime. Every other even number is divisible by 2, so it has more than two factors.</p>

  <h2>Prime Numbers Up to 100</h2>
  <table class="ta-table">
    <thead><tr><th>Range</th><th>Prime Numbers</th></tr></thead>
    <tbody>
      <tr><td>1 to 20</td><td>2, 3, 5, 7, 11, 13, 17, 19</td></tr>
      <tr><td>21 to 50</td><td>23, 29, 31, 37, 41, 43, 47</td></tr>
      <tr><td>51 to 100</td><td>53, 59, 61, 67, 71, 73, 79, 83, 89, 97</td></tr>
    </tbody>
  </table>

  <h2>How to Test for Primality</h2>
  <p>To check if n is prime, test whether any number from 2 up to the square root of n divides it evenly. You only need to go to the square root because any factor bigger than that would be paired with one smaller than it, and you would have found that one already.</p>
  <p>To test 37: the square root of 37 is about 6.08, so you only check 2, 3, 4, 5, and 6. None of them divide 37 evenly, so 37 is prime. Testing stops early, which makes the process fast.</p>

  <h2>Prime Factorization</h2>
  <p>Every composite number can be broken down into prime numbers multiplied together. This is called prime factorization. For example, 60 = 2 × 2 × 3 × 5. A factor tree helps you find this: start with the number and split it into two factors, then split each of those until all the pieces are prime.</p>
  <p>The Fundamental Theorem of Arithmetic says this breakdown is always unique. No matter how you get there, 60 always factors down to 2 × 2 × 3 × 5.</p>

  <h2>Common Mistakes to Avoid</h2>
  <ul>
    <li>Thinking 1 is prime. It is not. Prime numbers must have exactly two factors, and 1 only has one.</li>
    <li>Forgetting that 2 is prime. It is the only even prime number.</li>
    <li>Stopping a primality test too early. You must check all numbers up to the square root.</li>
    <li>Confusing factors with multiples. Factors divide evenly into a number. Multiples are the products of that number.</li>
  </ul>

  </section>

<div class="tool-nav-row">
  <a href="/math-tools/graphing-calculator" class="tool-nav-card" style="--tnc-color:#f5a623">
    <div class="tool-nav-icon"><i class="fa-solid fa-chart-line"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Previous</div><div class="tool-nav-name">Graphing Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-left"></i></div>
  </a>
  <a href="/math-tools/gcf-lcm-calculator" class="tool-nav-card tool-nav-next" style="--tnc-color:#c084fc">
    <div class="tool-nav-icon"><i class="fa-solid fa-circle-nodes"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Next</div><div class="tool-nav-name">GCF & LCM Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-right"></i></div>
  </a>
</div>

<div class="topic-quiz" id="tool-quiz">
  <div class="quiz-header" style="background:#f43f5e">
    <i class="fa-solid fa-circle-question"></i> Quick Quiz
    <span class="quiz-sub">3 questions</span>
  </div>
  <div class="quiz-body">
    <div class="quiz-q" data-qi="0" data-correct="2">
      <p class="quiz-question"><strong>Q1.</strong> Which of these is a prime number?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">9</button>
        <button class="quiz-opt" data-oi="1">15</button>
        <button class="quiz-opt" data-oi="2">17</button>
        <button class="quiz-opt" data-oi="3">21</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="1" data-correct="1">
      <p class="quiz-question"><strong>Q2.</strong> How many factors does a prime number have?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">1</button>
        <button class="quiz-opt" data-oi="1">2</button>
        <button class="quiz-opt" data-oi="2">3</button>
        <button class="quiz-opt" data-oi="3">4</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="2" data-correct="1">
      <p class="quiz-question"><strong>Q3.</strong> Is 1 a prime number?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">Yes</button>
        <button class="quiz-opt" data-oi="1">No</button>
        <button class="quiz-opt" data-oi="2">Sometimes</button>
        <button class="quiz-opt" data-oi="3">It depends</button>
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
