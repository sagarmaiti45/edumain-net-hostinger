<?php require_once __DIR__ . '/../config.php'; $page_title = 'Graphing Calculator'; $page_desc = 'Graph linear equations on an interactive coordinate plane with animated line drawing and slope visualization.'; $body_class = 'page-article'; include __DIR__ . '/../_header.php'; ?>

<style>
.graph-page { background: #1a2038; min-height: 60vh; padding: 2rem 1rem; color: #c8d4f0; font-family: 'Segoe UI', sans-serif; border-radius: 16px; overflow: hidden; max-width: 900px; margin-left: auto; margin-right: auto; }
.graph-hero { text-align: center; margin-bottom: 2rem; }
.graph-hero h1 { color: #c8d4f0; font-size: 2.2rem; font-weight: 800; margin: 0; text-shadow: 0 0 20px #f5a62344; }
.graph-hero p { color: #7c8bb0; font-size: 1.05rem; margin-top: .4rem; }
.graph-main { max-width: 800px; margin: 0 auto; display: grid; grid-template-columns: 300px 1fr; gap: 1.5rem; align-items: start; }
@media (max-width: 660px) { .graph-main { grid-template-columns: 1fr; } }
.graph-controls { background: #222840; border-radius: 20px; padding: 1.5rem; border: 1.5px solid #2e3a5c; }
.graph-controls h3 { font-size: .8rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #f5a623; margin: 0 0 1.2rem; }
.eq-display { background: #1a2038; border: 1.5px solid #2e3a5c; border-radius: 12px; padding: 1rem; text-align: center; margin-bottom: 1.2rem; font-size: 1.4rem; font-weight: 800; color: #f5a623; font-family: 'Courier New', monospace; min-height: 50px; letter-spacing: .05em; }
.param-row { display: grid; grid-template-columns: 1fr 1fr; gap: .8rem; margin-bottom: .8rem; }
.param-group { display: flex; flex-direction: column; gap: .3rem; }
.param-group label { font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #7c8bb0; }
.param-group input { background: #1a2038; border: 1.5px solid #2e3a5c; color: #c8d4f0; font-size: 1.5rem; font-weight: 800; border-radius: 10px; padding: .45rem .7rem; outline: none; text-align: center; transition: border-color .2s; width: 100%; box-sizing: border-box; }
.param-group input:focus { border-color: #f5a623; box-shadow: 0 0 0 3px #f5a62322; }
.param-hint { font-size: .72rem; color: #5a6a8a; text-align: center; margin-bottom: 1rem; }
.graph-btn { width: 100%; background: linear-gradient(135deg, #f5a623, #e8901a); color: #1a2038; font-size: 1rem; font-weight: 800; border: none; border-radius: 12px; padding: .9rem; cursor: pointer; transition: all .2s; letter-spacing: .03em; }
.graph-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px #f5a62355; }
.graph-info { margin-top: 1.2rem; padding-top: 1.2rem; border-top: 1.5px solid #2e3a5c; }
.info-row { display: flex; justify-content: space-between; padding: .45rem 0; font-size: .88rem; border-bottom: 1px solid #2e3a5c22; }
.info-label { color: #7c8bb0; font-weight: 600; }
.info-val { color: #f5a623; font-weight: 800; }
.graph-svg-wrap { background: #222840; border-radius: 20px; padding: 1rem; border: 1.5px solid #2e3a5c; overflow: hidden; }
#graphSvg { width: 100%; height: 360px; display: block; }
.axis-label { font-family: 'Segoe UI', sans-serif; font-size: 11px; fill: #7c8bb0; }
.grid-line { stroke: #2e3a5c; stroke-width: 1; }
.axis-line { stroke: #4a5a80; stroke-width: 2; }
.graph-line { fill: none; stroke: #f5a623; stroke-width: 3; stroke-linecap: round; filter: drop-shadow(0 0 4px #f5a62366); }
.intercept-dot { fill: #f5a623; filter: drop-shadow(0 0 4px #f5a623); }
.slope-label-bg { fill: #1a2038; rx: 4; ry: 4; }
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
  <span>Graphing Calculator</span>
</nav>
<div class="tool-page-layout" style="max-width:1100px;width:100%;margin:0 auto;padding:24px 24px 48px;box-sizing:border-box;">
<div class="tool-nav-row">
  <a href="/math-tools/geometry-calculator" class="tool-nav-card" style="--tnc-color:#007aff">
    <div class="tool-nav-icon"><i class="fa-solid fa-shapes"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Previous</div><div class="tool-nav-name">Geometry Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-left"></i></div>
  </a>
  <a href="/math-tools/prime-checker" class="tool-nav-card tool-nav-next" style="--tnc-color:#4ecdc4">
    <div class="tool-nav-icon"><i class="fa-solid fa-atom"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Next</div><div class="tool-nav-name">Prime Number Checker</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-right"></i></div>
  </a>
</div>
<div class="graph-page">
  <div style="max-width:800px; margin: 0 auto;">
    <div class="graph-hero">
      <h1>Graphing Calculator</h1>
    </div>
    <div class="graph-main">
      <div class="graph-controls">
        <h3><i class="fa-solid fa-sliders" style="margin-right:.3rem;"></i>Equation y = mx + b</h3>
        <div class="eq-display" id="eqDisplay">y = 1x + 0</div>
        <div class="param-row">
          <div class="param-group">
            <label>Slope (m)</label>
            <input type="number" id="slopeM" value="1" step="0.5">
          </div>
          <div class="param-group">
            <label>Y-intercept (b)</label>
            <input type="number" id="interceptB" value="0" step="1">
          </div>
        </div>
        <div class="param-hint">Enter slope and y-intercept to graph the line</div>
        <button class="graph-btn" onclick="drawGraph()"><i class="fa-solid fa-play" style="margin-right:.4rem;"></i>Graph It!</button>
        <div class="graph-info" id="graphInfo">
          <div class="info-row"><span class="info-label">Slope</span><span class="info-val" id="infoSlope">m = 1</span></div>
          <div class="info-row"><span class="info-label">Y-intercept</span><span class="info-val" id="infoYint">b = 0</span></div>
          <div class="info-row"><span class="info-label">X-intercept</span><span class="info-val" id="infoXint">x = 0</span></div>
          <div class="info-row"><span class="info-label">Direction</span><span class="info-val" id="infoDir">Positive slope</span></div>
        </div>
      </div>

      <div class="graph-svg-wrap">
        <svg id="graphSvg" viewBox="0 0 400 360"></svg>
      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const SVG_W = 400, SVG_H = 360;
  const PADDING = 40;
  const GRID_RANGE = 10; // -10 to 10
  const STEP = (SVG_W - 2*PADDING) / (2*GRID_RANGE);
  const CX = PADDING + GRID_RANGE * STEP;
  const CY = PADDING + GRID_RANGE * STEP;

  function gridX(val) { return CX + val * STEP; }
  function gridY(val) { return CY - val * STEP; }

  function buildGrid() {
    const svg = document.getElementById('graphSvg');
    svg.innerHTML = '';

    // Background
    const bg = document.createElementNS('http://www.w3.org/2000/svg','rect');
    bg.setAttribute('width', SVG_W); bg.setAttribute('height', SVG_H);
    bg.setAttribute('fill', '#1a2038'); svg.appendChild(bg);

    // Grid lines
    for(let i = -GRID_RANGE; i <= GRID_RANGE; i++) {
      const vline = document.createElementNS('http://www.w3.org/2000/svg','line');
      vline.setAttribute('x1', gridX(i)); vline.setAttribute('y1', PADDING);
      vline.setAttribute('x2', gridX(i)); vline.setAttribute('y2', SVG_H - PADDING);
      vline.setAttribute('class', 'grid-line');
      if(i % 5 === 0) vline.setAttribute('stroke', '#3a4a6c');
      svg.appendChild(vline);

      const hline = document.createElementNS('http://www.w3.org/2000/svg','line');
      hline.setAttribute('x1', PADDING); hline.setAttribute('y1', gridY(i));
      hline.setAttribute('x2', SVG_W - PADDING); hline.setAttribute('y2', gridY(i));
      hline.setAttribute('class', 'grid-line');
      if(i % 5 === 0) hline.setAttribute('stroke', '#3a4a6c');
      svg.appendChild(hline);
    }

    // Axes
    const xAxis = document.createElementNS('http://www.w3.org/2000/svg','line');
    xAxis.setAttribute('x1', PADDING); xAxis.setAttribute('y1', CY);
    xAxis.setAttribute('x2', SVG_W-PADDING); xAxis.setAttribute('y2', CY);
    xAxis.setAttribute('class', 'axis-line'); svg.appendChild(xAxis);

    const yAxis = document.createElementNS('http://www.w3.org/2000/svg','line');
    yAxis.setAttribute('x1', CX); yAxis.setAttribute('y1', PADDING);
    yAxis.setAttribute('x2', CX); yAxis.setAttribute('y2', SVG_H-PADDING);
    yAxis.setAttribute('class', 'axis-line'); svg.appendChild(yAxis);

    // Axis labels
    const xLabel = document.createElementNS('http://www.w3.org/2000/svg','text');
    xLabel.setAttribute('x', SVG_W - PADDING + 8); xLabel.setAttribute('y', CY + 4);
    xLabel.setAttribute('class', 'axis-label'); xLabel.setAttribute('fill', '#c8d4f0');
    xLabel.textContent = 'x'; svg.appendChild(xLabel);

    const yLabel = document.createElementNS('http://www.w3.org/2000/svg','text');
    yLabel.setAttribute('x', CX + 6); yLabel.setAttribute('y', PADDING - 6);
    yLabel.setAttribute('class', 'axis-label'); yLabel.setAttribute('fill', '#c8d4f0');
    yLabel.textContent = 'y'; svg.appendChild(yLabel);

    // Tick labels
    for(let i = -GRID_RANGE; i <= GRID_RANGE; i += 2) {
      if(i !== 0) {
        const xt = document.createElementNS('http://www.w3.org/2000/svg','text');
        xt.setAttribute('x', gridX(i)); xt.setAttribute('y', CY + 16);
        xt.setAttribute('text-anchor', 'middle'); xt.setAttribute('class', 'axis-label');
        xt.textContent = i; svg.appendChild(xt);

        const yt = document.createElementNS('http://www.w3.org/2000/svg','text');
        yt.setAttribute('x', CX - 8); yt.setAttribute('y', gridY(i) + 4);
        yt.setAttribute('text-anchor', 'end'); yt.setAttribute('class', 'axis-label');
        yt.textContent = i; svg.appendChild(yt);
      }
    }

    return svg;
  }

  window.drawGraph = function() {
    const m = parseFloat(document.getElementById('slopeM').value) || 0;
    const b = parseFloat(document.getElementById('interceptB').value) || 0;

    // Update display
    const mStr = m === 1 ? '' : m === -1 ? '-' : m;
    document.getElementById('eqDisplay').textContent = `y = ${mStr}x ${b >= 0 ? '+' : ''}${b === 0 ? '' : b}`.replace('= x', '= 1x').replace('  ', ' ');
    document.getElementById('eqDisplay').textContent = `y = ${m}x + ${b}`.replace('+ -', '- ');

    // Info panel
    document.getElementById('infoSlope').textContent = `m = ${m}`;
    document.getElementById('infoYint').textContent = `b = ${b}`;
    const xInt = m !== 0 ? (-b/m).toFixed(2) : 'undefined';
    document.getElementById('infoXint').textContent = `x = ${xInt}`;
    document.getElementById('infoDir').textContent = m > 0 ? 'Positive slope ↗' : m < 0 ? 'Negative slope ↘' : 'Horizontal line →';

    const svg = buildGrid();

    // Compute line endpoints (clipped to grid)
    const x1 = -GRID_RANGE, y1 = m*x1 + b;
    const x2 = GRID_RANGE, y2 = m*x2 + b;

    const px1 = gridX(x1), py1 = gridY(Math.max(-GRID_RANGE, Math.min(GRID_RANGE, y1)));
    const px2 = gridX(x2), py2 = gridY(Math.max(-GRID_RANGE, Math.min(GRID_RANGE, y2)));

    const totalLen = Math.sqrt((px2-px1)**2 + (py2-py1)**2);

    const path = document.createElementNS('http://www.w3.org/2000/svg','line');
    path.setAttribute('x1', px1); path.setAttribute('y1', py1);
    path.setAttribute('x2', px2); path.setAttribute('y2', py2);
    path.setAttribute('class', 'graph-line');
    path.setAttribute('stroke-dasharray', totalLen);
    path.setAttribute('stroke-dashoffset', totalLen);
    svg.appendChild(path);

    // Animate
    let start = null;
    const duration = 900;
    function animate(ts) {
      if(!start) start = ts;
      const progress = Math.min((ts - start) / duration, 1);
      const ease = 1 - Math.pow(1 - progress, 3);
      path.setAttribute('stroke-dashoffset', totalLen * (1 - ease));
      if(progress < 1) requestAnimationFrame(animate);
    }
    requestAnimationFrame(animate);

    // Y-intercept dot
    if(Math.abs(b) <= GRID_RANGE) {
      const dot = document.createElementNS('http://www.w3.org/2000/svg','circle');
      dot.setAttribute('cx', gridX(0)); dot.setAttribute('cy', gridY(b));
      dot.setAttribute('r', 5); dot.setAttribute('class', 'intercept-dot');
      svg.appendChild(dot);

      const lbl = document.createElementNS('http://www.w3.org/2000/svg','text');
      lbl.setAttribute('x', gridX(0) + 10); lbl.setAttribute('y', gridY(b) - 8);
      lbl.setAttribute('fill', '#f5a623'); lbl.setAttribute('font-size', '11');
      lbl.setAttribute('font-weight', '700');
      lbl.textContent = `(0, ${b})`; svg.appendChild(lbl);
    }

    // Slope indicator
    if(m !== 0 && Math.abs(b) <= GRID_RANGE - 2) {
      const run = 2, rise = m * run;
      const sx = gridX(0), sy = gridY(b);
      const ex = gridX(run), ey = gridY(b);
      const ez = gridY(b + rise);

      const runLine = document.createElementNS('http://www.w3.org/2000/svg','line');
      runLine.setAttribute('x1', sx); runLine.setAttribute('y1', sy);
      runLine.setAttribute('x2', ex); runLine.setAttribute('y2', sy);
      runLine.setAttribute('stroke', '#2dd4bf'); runLine.setAttribute('stroke-width', '1.5');
      runLine.setAttribute('stroke-dasharray', '4,3'); svg.appendChild(runLine);

      const riseLine = document.createElementNS('http://www.w3.org/2000/svg','line');
      riseLine.setAttribute('x1', ex); riseLine.setAttribute('y1', sy);
      riseLine.setAttribute('x2', ex); riseLine.setAttribute('y2', ez);
      riseLine.setAttribute('stroke', '#f43f5e'); riseLine.setAttribute('stroke-width', '1.5');
      riseLine.setAttribute('stroke-dasharray', '4,3'); svg.appendChild(riseLine);

      const slopeLbl = document.createElementNS('http://www.w3.org/2000/svg','text');
      slopeLbl.setAttribute('x', ex + 6); slopeLbl.setAttribute('y', (sy + ez) / 2 + 4);
      slopeLbl.setAttribute('fill', '#f43f5e'); slopeLbl.setAttribute('font-size', '10');
      slopeLbl.setAttribute('font-weight', '700');
      slopeLbl.textContent = `rise=${rise}`; svg.appendChild(slopeLbl);
    }
  };

  document.getElementById('slopeM').addEventListener('input', function() {
    const m = this.value || 0;
    const b = document.getElementById('interceptB').value || 0;
    document.getElementById('eqDisplay').textContent = `y = ${m}x + ${b}`.replace('+ -', '- ');
  });
  document.getElementById('interceptB').addEventListener('input', function() {
    const b = this.value || 0;
    const m = document.getElementById('slopeM').value || 0;
    document.getElementById('eqDisplay').textContent = `y = ${m}x + ${b}`.replace('+ -', '- ');
  });

  drawGraph();
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

  <h2>How to Use This Grapher</h2>
  <p>Enter a value for slope (m) and y-intercept (b) in the fields on the left. The graph updates live as you type. You will see the line drawn on the coordinate grid with the slope and intercept labelled. Try changing m to see how the steepness shifts, then adjust b to move the line up or down.</p>

  <h2>The Slope-Intercept Form</h2>
  <p>The equation y = mx + b is called slope-intercept form. It is the most useful way to write a linear equation because it tells you two things instantly: the slope (m) and where the line crosses the y-axis (b).</p>
  <p>The slope m tells you how the y value changes for every 1 unit increase in x. If m = 3, then y goes up by 3 every time x goes up by 1. If m is negative, the line goes downward as x increases. The y-intercept b is the starting point. When x = 0, y equals b.</p>

  <h2>Slope Values Reference</h2>
  <table class="ta-table">
    <thead><tr><th>Slope (m)</th><th>What the Line Looks Like</th></tr></thead>
    <tbody>
      <tr><td>m = 3</td><td>Steep upward line, rises quickly</td></tr>
      <tr><td>m = 0.5</td><td>Gentle upward line, gradual rise</td></tr>
      <tr><td>m = 0</td><td>Perfectly horizontal line</td></tr>
      <tr><td>m = -1</td><td>Diagonal downward line at 45 degrees</td></tr>
      <tr><td>m = -3</td><td>Steep downward line, drops quickly</td></tr>
    </tbody>
  </table>

  <h2>Reading Slope from a Graph</h2>
  <p>Pick any two points on the line. Slope = rise divided by run. Rise is how much y changes between the two points. Run is how much x changes. If you go from (1, 2) to (3, 8), the rise is 8 - 2 = 6 and the run is 3 - 1 = 2. So slope = 6 / 2 = 3.</p>

  <h2>Finding the Equation from Two Points</h2>
  <ol>
    <li>Calculate slope: m = (y2 - y1) / (x2 - x1)</li>
    <li>Pick either point and substitute into y = mx + b</li>
    <li>Solve for b</li>
    <li>Write the final equation with your m and b values</li>
  </ol>
  <div class="ta-box">
    <strong>Example: points (2, 5) and (4, 11)</strong>
    Slope = (11 - 5) / (4 - 2) = 6 / 2 = 3. Plug in: 5 = 3(2) + b, so b = -1. Equation: y = 3x - 1.
  </div>

  <h2>Common Mistakes to Avoid</h2>
  <ul>
    <li>Mixing up which is rise and which is run. Rise is vertical (y), run is horizontal (x).</li>
    <li>Forgetting that a negative slope means the line goes down, not up.</li>
    <li>Confusing the y-intercept with the x-intercept. The y-intercept is where x = 0.</li>
    <li>Dividing run by rise instead of rise by run when calculating slope.</li>
  </ul>

  </section>

<div class="tool-nav-row">
  <a href="/math-tools/geometry-calculator" class="tool-nav-card" style="--tnc-color:#007aff">
    <div class="tool-nav-icon"><i class="fa-solid fa-shapes"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Previous</div><div class="tool-nav-name">Geometry Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-left"></i></div>
  </a>
  <a href="/math-tools/prime-checker" class="tool-nav-card tool-nav-next" style="--tnc-color:#4ecdc4">
    <div class="tool-nav-icon"><i class="fa-solid fa-atom"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Next</div><div class="tool-nav-name">Prime Number Checker</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-right"></i></div>
  </a>
</div>

<div class="topic-quiz" id="tool-quiz">
  <div class="quiz-header" style="background:#0ea5e9">
    <i class="fa-solid fa-circle-question"></i> Quick Quiz
    <span class="quiz-sub">3 questions</span>
  </div>
  <div class="quiz-body">
    <div class="quiz-q" data-qi="0" data-correct="1">
      <p class="quiz-question"><strong>Q1.</strong> What is the slope of the line y = 3x + 2?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">2</button>
        <button class="quiz-opt" data-oi="1">3</button>
        <button class="quiz-opt" data-oi="2">5</button>
        <button class="quiz-opt" data-oi="3">1</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="1" data-correct="1">
      <p class="quiz-question"><strong>Q2.</strong> Where does y = x² + 1 cross the y-axis?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">(0, 0)</button>
        <button class="quiz-opt" data-oi="1">(0, 1)</button>
        <button class="quiz-opt" data-oi="2">(1, 0)</button>
        <button class="quiz-opt" data-oi="3">(1, 2)</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="2" data-correct="2">
      <p class="quiz-question"><strong>Q3.</strong> Which equation has a slope of -2?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">y = 2x + 1</button>
        <button class="quiz-opt" data-oi="1">y = x - 2</button>
        <button class="quiz-opt" data-oi="2">y = -2x + 5</button>
        <button class="quiz-opt" data-oi="3">y = 2 - x</button>
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
