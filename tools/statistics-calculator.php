<?php require_once __DIR__ . '/../config.php'; $page_title = 'Statistics Calculator'; $page_desc = 'Calculate mean, median, mode, range and more with an animated bar chart that builds as you type.'; $body_class = 'page-article'; include __DIR__ . '/../_header.php'; ?>

<style>
.stats-page { background: #fff; min-height: 60vh; padding: 2rem 1rem; font-family: 'Segoe UI', sans-serif; border-radius: 16px; overflow: hidden; max-width: 900px; margin-left: auto; margin-right: auto; }
.stats-hero { text-align: center; margin-bottom: 2rem; }
.stats-hero h1 { color: #111827; font-size: 2.2rem; font-weight: 800; margin: 0; }
.stats-hero p { color: #6b7280; font-size: 1.05rem; margin-top: .4rem; }
.stats-main { max-width: 800px; margin: 0 auto; }
.stats-input-card { background: #fff; border: 1.5px solid #e5e7eb; border-radius: 20px; padding: 1.5rem; box-shadow: 0 4px 16px rgba(0,0,0,.05); margin-bottom: 1.5rem; }
.stats-input-card label { display: block; font-size: .78rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #6366f1; margin-bottom: .6rem; }
.stats-textarea { width: 100%; box-sizing: border-box; min-height: 70px; background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 12px; color: #111827; font-size: 1.1rem; font-weight: 600; padding: .75rem 1rem; outline: none; transition: border-color .2s; resize: vertical; font-family: 'Courier New', monospace; }
.stats-textarea:focus { border-color: #6366f1; box-shadow: 0 0 0 3px #6366f122; }
.stats-hint { font-size: .78rem; color: #9ca3af; margin-top: .4rem; }
.stats-content { display: grid; grid-template-columns: 1fr 260px; gap: 1.5rem; }
@media (max-width: 640px) { .stats-content { grid-template-columns: 1fr; } }
.chart-card { background: #fff; border: 1.5px solid #e5e7eb; border-radius: 20px; padding: 1.5rem; box-shadow: 0 4px 16px rgba(0,0,0,.05); }
.chart-card h3 { font-size: .78rem; font-weight: 700; text-transform: uppercase; color: #6366f1; letter-spacing: .07em; margin: 0 0 1rem; }
.chart-area { position: relative; height: 240px; overflow: hidden; }
#barChartSvg { width: 100%; height: 100%; }
.results-card { background: #fff; border: 1.5px solid #e5e7eb; border-radius: 20px; padding: 1.5rem; box-shadow: 0 4px 16px rgba(0,0,0,.05); height: fit-content; }
.results-card h3 { font-size: .78rem; font-weight: 700; text-transform: uppercase; color: #6366f1; letter-spacing: .07em; margin: 0 0 1rem; }
.stat-row { display: flex; justify-content: space-between; align-items: center; padding: .6rem 0; border-bottom: 1.5px solid #f3f4f6; }
.stat-row:last-child { border-bottom: none; }
.stat-name { font-size: .88rem; font-weight: 600; color: #6b7280; }
.stat-val { font-size: 1.05rem; font-weight: 800; color: #6366f1; }
.stat-val.highlight { color: #4f46e5; font-size: 1.2rem; }
.no-data { text-align: center; color: #9ca3af; font-size: .9rem; padding: 2rem 0; }
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
  <span>Statistics Calculator</span>
</nav>
<div class="tool-page-layout" style="max-width:1100px;width:100%;margin:0 auto;padding:24px 24px 48px;box-sizing:border-box;">
<div class="tool-nav-row">
  <a href="/math-tools/ratio-calculator" class="tool-nav-card" style="--tnc-color:#14b8a6">
    <div class="tool-nav-icon"><i class="fa-solid fa-scale-balanced"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Previous</div><div class="tool-nav-name">Ratio Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-left"></i></div>
  </a>
  <a href="/math-tools/exponent-calculator" class="tool-nav-card tool-nav-next" style="--tnc-color:#f5a623">
    <div class="tool-nav-icon"><i class="fa-solid fa-superscript"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Next</div><div class="tool-nav-name">Exponent Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-right"></i></div>
  </a>
</div>
<div class="stats-page">
  <div class="stats-main">
    <div class="stats-hero">
      <h1>Statistics Calculator</h1>
    </div>

    <div class="stats-input-card">
      <label><i class="fa-solid fa-keyboard" style="margin-right:.3rem;"></i>Enter Your Numbers</label>
      <textarea class="stats-textarea" id="statsInput" placeholder="e.g. 5, 8, 3, 12, 7, 8, 4, 10"></textarea>
      <div class="stats-hint">Separate numbers with commas or spaces. The chart updates as you type!</div>
    </div>

    <div class="stats-content">
      <div class="chart-card">
        <h3><i class="fa-solid fa-chart-bar" style="margin-right:.3rem;"></i>Bar Chart</h3>
        <div class="chart-area">
          <svg id="barChartSvg" viewBox="0 0 400 220" preserveAspectRatio="xMidYMid meet"></svg>
        </div>
      </div>
      <div class="results-card">
        <h3><i class="fa-solid fa-calculator" style="margin-right:.3rem;"></i>Results</h3>
        <div id="statsResults">
          <div class="no-data">Enter numbers above to see statistics</div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const COLORS = ['#6366f1','#818cf8','#4f46e5','#7c3aed','#8b5cf6','#a78bfa','#c4b5fd','#4338ca','#6d28d9','#7c3aed'];
  const SVG_W = 400, SVG_H = 220;
  const PADDING = { top: 20, right: 10, bottom: 30, left: 40 };

  let animFrame = null;
  let prevBars = [];

  function parseNumbers(str) {
    if(!str.trim()) return [];
    return str.split(/[\s,;]+/).map(s => parseFloat(s.trim())).filter(n => !isNaN(n));
  }

  function calcStats(nums) {
    if(!nums.length) return null;
    const sorted = [...nums].sort((a,b) => a-b);
    const n = nums.length;
    const mean = nums.reduce((a,b) => a+b, 0) / n;
    const median = n % 2 === 0 ? (sorted[n/2-1] + sorted[n/2]) / 2 : sorted[Math.floor(n/2)];
    const range = sorted[n-1] - sorted[0];
    const freq = {};
    nums.forEach(v => { freq[v] = (freq[v]||0) + 1; });
    const maxFreq = Math.max(...Object.values(freq));
    const modes = Object.entries(freq).filter(([,f]) => f === maxFreq).map(([v]) => parseFloat(v));
    const variance = nums.reduce((s, v) => s + (v-mean)**2, 0) / n;
    const std = Math.sqrt(variance);
    return { n, mean, median, modes, range, min: sorted[0], max: sorted[n-1], sum: nums.reduce((a,b)=>a+b,0), std };
  }

  function fmt(n) {
    return isNaN(n) ? '-' : parseFloat(n.toFixed(4)).toString();
  }

  function drawBars(nums, stats) {
    const svg = document.getElementById('barChartSvg');
    svg.innerHTML = '';
    if(!nums.length) {
      const t = document.createElementNS('http://www.w3.org/2000/svg','text');
      t.setAttribute('x', SVG_W/2); t.setAttribute('y', SVG_H/2);
      t.setAttribute('text-anchor', 'middle'); t.setAttribute('fill', '#9ca3af');
      t.setAttribute('font-size', '13'); t.textContent = 'Enter numbers to see chart';
      svg.appendChild(t);
      return;
    }

    const chartW = SVG_W - PADDING.left - PADDING.right;
    const chartH = SVG_H - PADDING.top - PADDING.bottom;
    const maxVal = Math.max(...nums);
    const n = nums.length;
    const barW = Math.max(4, Math.min(50, (chartW - n * 2) / n));
    const barSpacing = (chartW - n * barW) / (n + 1);
    const baseline = PADDING.top + chartH;

    // Y-axis
    const yAxis = document.createElementNS('http://www.w3.org/2000/svg','line');
    yAxis.setAttribute('x1', PADDING.left); yAxis.setAttribute('y1', PADDING.top);
    yAxis.setAttribute('x2', PADDING.left); yAxis.setAttribute('y2', baseline);
    yAxis.setAttribute('stroke', '#e5e7eb'); yAxis.setAttribute('stroke-width', '1.5');
    svg.appendChild(yAxis);

    // X-axis
    const xAxis = document.createElementNS('http://www.w3.org/2000/svg','line');
    xAxis.setAttribute('x1', PADDING.left); xAxis.setAttribute('y1', baseline);
    xAxis.setAttribute('x2', SVG_W - PADDING.right); xAxis.setAttribute('y2', baseline);
    xAxis.setAttribute('stroke', '#e5e7eb'); xAxis.setAttribute('stroke-width', '1.5');
    svg.appendChild(xAxis);

    // Mean line
    if(stats) {
      const meanY = PADDING.top + chartH * (1 - stats.mean / maxVal);
      const meanLine = document.createElementNS('http://www.w3.org/2000/svg','line');
      meanLine.setAttribute('x1', PADDING.left); meanLine.setAttribute('y1', meanY);
      meanLine.setAttribute('x2', SVG_W - PADDING.right); meanLine.setAttribute('y2', meanY);
      meanLine.setAttribute('stroke', '#f59e0b'); meanLine.setAttribute('stroke-width', '1.5');
      meanLine.setAttribute('stroke-dasharray', '5,4');
      svg.appendChild(meanLine);

      const meanLbl = document.createElementNS('http://www.w3.org/2000/svg','text');
      meanLbl.setAttribute('x', SVG_W - PADDING.right - 2); meanLbl.setAttribute('y', meanY - 3);
      meanLbl.setAttribute('text-anchor', 'end'); meanLbl.setAttribute('font-size', '9');
      meanLbl.setAttribute('fill', '#f59e0b'); meanLbl.setAttribute('font-weight', '700');
      meanLbl.textContent = 'mean=' + fmt(stats.mean); svg.appendChild(meanLbl);
    }

    // Bars
    nums.forEach((val, i) => {
      const barH = maxVal > 0 ? (val / maxVal) * chartH : 0;
      const x = PADDING.left + barSpacing + i * (barW + barSpacing);
      const y = baseline - barH;
      const color = COLORS[i % COLORS.length];

      const rect = document.createElementNS('http://www.w3.org/2000/svg','rect');
      rect.setAttribute('x', x); rect.setAttribute('y', baseline);
      rect.setAttribute('width', barW); rect.setAttribute('height', 0);
      rect.setAttribute('fill', color); rect.setAttribute('rx', '3');
      rect.setAttribute('opacity', '0.9');
      svg.appendChild(rect);

      // Animate bar height
      const targetH = barH;
      let currentH = 0;
      const duration = 400;
      const startTime = performance.now();
      function animBar(ts) {
        const elapsed = ts - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const ease = 1 - Math.pow(1 - progress, 3);
        currentH = targetH * ease;
        rect.setAttribute('y', baseline - currentH);
        rect.setAttribute('height', currentH);
        if(progress < 1) requestAnimationFrame(animBar);
      }
      requestAnimationFrame(animBar);

      // Value label on top
      if(barW >= 14) {
        const lbl = document.createElementNS('http://www.w3.org/2000/svg','text');
        lbl.setAttribute('x', x + barW/2); lbl.setAttribute('y', y - 3);
        lbl.setAttribute('text-anchor', 'middle'); lbl.setAttribute('font-size', '9');
        lbl.setAttribute('fill', color); lbl.setAttribute('font-weight', '700');
        lbl.textContent = val; svg.appendChild(lbl);
      }

      // Index label below
      if(barW >= 10) {
        const idx = document.createElementNS('http://www.w3.org/2000/svg','text');
        idx.setAttribute('x', x + barW/2); idx.setAttribute('y', baseline + 14);
        idx.setAttribute('text-anchor', 'middle'); idx.setAttribute('font-size', '9');
        idx.setAttribute('fill', '#9ca3af');
        idx.textContent = i+1; svg.appendChild(idx);
      }
    });
  }

  function updateStats() {
    const nums = parseNumbers(document.getElementById('statsInput').value);
    const stats = calcStats(nums);
    drawBars(nums, stats);

    const resultsEl = document.getElementById('statsResults');
    if(!stats) {
      resultsEl.innerHTML = '<div class="no-data">Enter numbers above to see statistics</div>';
      return;
    }

    resultsEl.innerHTML = `
      <div class="stat-row"><span class="stat-name">Count</span><span class="stat-val">${stats.n}</span></div>
      <div class="stat-row"><span class="stat-name">Sum</span><span class="stat-val">${fmt(stats.sum)}</span></div>
      <div class="stat-row"><span class="stat-name">Mean</span><span class="stat-val highlight">${fmt(stats.mean)}</span></div>
      <div class="stat-row"><span class="stat-name">Median</span><span class="stat-val highlight">${fmt(stats.median)}</span></div>
      <div class="stat-row"><span class="stat-name">Mode</span><span class="stat-val">${stats.modes.join(', ')}</span></div>
      <div class="stat-row"><span class="stat-name">Range</span><span class="stat-val">${fmt(stats.range)}</span></div>
      <div class="stat-row"><span class="stat-name">Min</span><span class="stat-val">${fmt(stats.min)}</span></div>
      <div class="stat-row"><span class="stat-name">Max</span><span class="stat-val">${fmt(stats.max)}</span></div>
      <div class="stat-row"><span class="stat-name">Std Dev</span><span class="stat-val">${fmt(stats.std)}</span></div>
    `;
  }

  document.getElementById('statsInput').addEventListener('input', updateStats);
  updateStats();
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
<section class="tool-article" style="--accent-color:#6366f1">

  <h2>How to Use This Calculator</h2>
  <p>Type your numbers separated by commas in the input field, then press Calculate. The tool finds the mean, median, mode, range, and standard deviation for your dataset. You can enter as few as 2 values or as many as you like. The bar chart updates to show the distribution of your data visually.</p>

  <h2>The Four Main Measures</h2>
  <p><strong>Mean:</strong> Add all values and divide by how many there are. This is the arithmetic average.</p>
  <p><strong>Median:</strong> Sort the values from smallest to largest and pick the middle one. If there are two middle values, average them.</p>
  <p><strong>Mode:</strong> The value that appears most often. A dataset can have no mode, one mode, or several modes.</p>
  <p><strong>Range:</strong> Subtract the smallest value from the largest. This tells you how spread out the data is.</p>

  <h2>When to Use Which Measure</h2>
  <table class="ta-table">
    <thead><tr><th>Situation</th><th>Best Measure</th><th>Why</th></tr></thead>
    <tbody>
      <tr><td>Test scores in a class</td><td>Mean</td><td>Data is usually evenly spread</td></tr>
      <tr><td>Income or house prices</td><td>Median</td><td>Outliers like very high earners skew the mean</td></tr>
      <tr><td>Most popular shoe size</td><td>Mode</td><td>You want the most common item, not an average</td></tr>
      <tr><td>How consistent data is</td><td>Range or standard deviation</td><td>Measures how much values vary</td></tr>
    </tbody>
  </table>

  <h2>Calculating Mean Step by Step</h2>
  <div class="ta-box">
    <strong>Dataset: 4, 8, 6, 10, 12</strong>
    Step 1: Add all values: 4 + 8 + 6 + 10 + 12 = 40.<br>
    Step 2: Count the values: there are 5.<br>
    Step 3: Divide: 40 / 5 = 8.<br>
    Mean = 8.
  </div>

  <h2>Median with Even vs Odd Counts</h2>
  <p>With an odd count: sort the values and take the exact middle one. For 3, 7, 9, 11, 15, the median is 9 (the 3rd of 5 values).</p>
  <p>With an even count: sort the values and average the two middle ones. For 3, 7, 9, 11, the median is (7 + 9) / 2 = 8.</p>

  <h2>Common Mistakes to Avoid</h2>
  <ul>
    <li>Forgetting to sort the data before finding the median. Order matters.</li>
    <li>Assuming the mean and median will always be close. Outliers can separate them widely.</li>
    <li>Thinking a dataset must have a mode. If no value repeats, there is no mode.</li>
    <li>Confusing range with standard deviation. Range uses only two values; standard deviation uses all of them.</li>
  </ul>

  </section>

<div class="tool-nav-row">
  <a href="/math-tools/ratio-calculator" class="tool-nav-card" style="--tnc-color:#14b8a6">
    <div class="tool-nav-icon"><i class="fa-solid fa-scale-balanced"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Previous</div><div class="tool-nav-name">Ratio Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-left"></i></div>
  </a>
  <a href="/math-tools/exponent-calculator" class="tool-nav-card tool-nav-next" style="--tnc-color:#f5a623">
    <div class="tool-nav-icon"><i class="fa-solid fa-superscript"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Next</div><div class="tool-nav-name">Exponent Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-right"></i></div>
  </a>
</div>

<div class="topic-quiz" id="tool-quiz">
  <div class="quiz-header" style="background:#eab308">
    <i class="fa-solid fa-circle-question"></i> Quick Quiz
    <span class="quiz-sub">3 questions</span>
  </div>
  <div class="quiz-body">
    <div class="quiz-q" data-qi="0" data-correct="1">
      <p class="quiz-question"><strong>Q1.</strong> What is the mean of 2, 4, 6, 8?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">4</button>
        <button class="quiz-opt" data-oi="1">5</button>
        <button class="quiz-opt" data-oi="2">6</button>
        <button class="quiz-opt" data-oi="3">7</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="1" data-correct="1">
      <p class="quiz-question"><strong>Q2.</strong> What is the median of 3, 1, 7, 5, 9?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">3</button>
        <button class="quiz-opt" data-oi="1">5</button>
        <button class="quiz-opt" data-oi="2">7</button>
        <button class="quiz-opt" data-oi="3">9</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="2" data-correct="1">
      <p class="quiz-question"><strong>Q3.</strong> What is the mode of 2, 3, 3, 4, 5, 3?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">2</button>
        <button class="quiz-opt" data-oi="1">3</button>
        <button class="quiz-opt" data-oi="2">4</button>
        <button class="quiz-opt" data-oi="3">5</button>
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
