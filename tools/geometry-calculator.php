<?php require_once __DIR__ . '/../config.php'; $page_title = 'Geometry Calculator'; $page_desc = 'Calculate area and perimeter of circles, squares, rectangles, triangles and trapezoids with live SVG previews.'; $body_class = 'page-article'; include __DIR__ . '/../_header.php'; ?>

<style>
.geo-page { background: #f2f2f7; min-height: 60vh; padding: 2rem 1rem; font-family: 'Segoe UI', sans-serif; border-radius: 16px; overflow: hidden; max-width: 900px; margin-left: auto; margin-right: auto; }
.geo-hero { text-align: center; margin-bottom: 2rem; }
.geo-hero h1 { color: #1c1c1e; font-size: 2.2rem; font-weight: 800; margin: 0; }
.geo-hero p { color: #636366; font-size: 1.05rem; margin-top: .4rem; }
.geo-main { max-width: 800px; margin: 0 auto; }
.shape-cards { display: flex; gap: .8rem; flex-wrap: wrap; justify-content: center; margin-bottom: 2rem; }
.shape-card { background: #fff; border: 2px solid #e5e5ea; border-radius: 18px; padding: 1rem 1.2rem; cursor: pointer; text-align: center; transition: all .22s; min-width: 100px; flex: 1; max-width: 130px; }
.shape-card:hover { border-color: #007aff; transform: translateY(-3px); box-shadow: 0 8px 20px #007aff22; }
.shape-card.active { border-color: #007aff; background: #eaf4ff; box-shadow: 0 6px 18px #007aff33; }
.shape-card i { font-size: 2rem; color: #007aff; display: block; margin-bottom: .4rem; }
.shape-card span { font-size: .8rem; font-weight: 700; color: #1c1c1e; }
.geo-content { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
@media (max-width: 580px) { .geo-content { grid-template-columns: 1fr; } }
.geo-card { background: #fff; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,.08); padding: 1.5rem; }
.geo-card h3 { font-size: .8rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #007aff; margin: 0 0 1rem; }
.geo-input-group { margin-bottom: .9rem; }
.geo-input-group label { display: block; font-size: .78rem; font-weight: 600; color: #636366; margin-bottom: .3rem; }
.geo-input-group input { width: 100%; box-sizing: border-box; font-size: 1.3rem; font-weight: 700; color: #1c1c1e; border: 2px solid #e5e5ea; border-radius: 10px; padding: .55rem .9rem; outline: none; transition: border-color .2s; }
.geo-input-group input:focus { border-color: #007aff; }
.geo-btn { width: 100%; background: #007aff; color: #fff; font-size: 1rem; font-weight: 700; border: none; border-radius: 12px; padding: .9rem; cursor: pointer; transition: all .2s; margin-top: .5rem; }
.geo-btn:hover { background: #0066d6; box-shadow: 0 6px 16px #007aff44; transform: translateY(-1px); }
.geo-results { margin-top: 1rem; display: none; animation: revealDown .4s ease; }
@keyframes revealDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
.res-item { display: flex; justify-content: space-between; align-items: center; padding: .6rem 0; border-bottom: 1.5px solid #f2f2f7; }
.res-item:last-child { border-bottom: none; }
.res-name { font-size: .85rem; font-weight: 600; color: #636366; }
.res-val { font-size: 1.1rem; font-weight: 800; color: #007aff; }
.svg-preview { display: flex; align-items: center; justify-content: center; min-height: 200px; }
.svg-preview svg { max-width: 100%; }
.shape-panel { display: none; }
.shape-panel.active { display: block; }
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
  <span>Geometry Calculator</span>
</nav>
<div class="tool-page-layout" style="max-width:1100px;width:100%;margin:0 auto;padding:24px 24px 48px;box-sizing:border-box;">
<div class="tool-nav-row">
  <a href="/math-tools/unit-converter" class="tool-nav-card" style="--tnc-color:#6366f1">
    <div class="tool-nav-icon"><i class="fa-solid fa-arrows-left-right"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Previous</div><div class="tool-nav-name">Unit Converter</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-left"></i></div>
  </a>
  <a href="/math-tools/graphing-calculator" class="tool-nav-card tool-nav-next" style="--tnc-color:#f5a623">
    <div class="tool-nav-icon"><i class="fa-solid fa-chart-line"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Next</div><div class="tool-nav-name">Graphing Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-right"></i></div>
  </a>
</div>
<div class="geo-page">
  <div class="geo-main">
    <div class="geo-hero">
      <h1>Geometry Calculator</h1>
    </div>

    <div class="shape-cards">
      <div class="shape-card active" data-shape="circle"><i class="fa-regular fa-circle"></i><span>Circle</span></div>
      <div class="shape-card" data-shape="square"><i class="fa-regular fa-square"></i><span>Square</span></div>
      <div class="shape-card" data-shape="rectangle"><i class="fa-solid fa-vector-square"></i><span>Rectangle</span></div>
      <div class="shape-card" data-shape="triangle"><i class="fa-solid fa-play" style="transform:rotate(90deg)"></i><span>Triangle</span></div>
      <div class="shape-card" data-shape="trapezoid"><i class="fa-solid fa-shapes"></i><span>Trapezoid</span></div>
    </div>

    <div class="geo-content">
      <!-- Inputs -->
      <div class="geo-card">
        <!-- Circle -->
        <div class="shape-panel active" id="panel-circle">
          <h3><i class="fa-regular fa-circle" style="margin-right:.3rem;"></i>Circle</h3>
          <div class="geo-input-group">
            <label>Radius (r)</label>
            <input type="number" id="c-r" value="5" min="0" step="any">
          </div>
          <button class="geo-btn" onclick="calcCircle()">Calculate</button>
          <div class="geo-results" id="res-circle">
            <div class="res-item"><span class="res-name">Area</span><span class="res-val" id="c-area">-</span></div>
            <div class="res-item"><span class="res-name">Circumference</span><span class="res-val" id="c-circ">-</span></div>
            <div class="res-item"><span class="res-name">Diameter</span><span class="res-val" id="c-diam">-</span></div>
          </div>
        </div>
        <!-- Square -->
        <div class="shape-panel" id="panel-square">
          <h3><i class="fa-regular fa-square" style="margin-right:.3rem;"></i>Square</h3>
          <div class="geo-input-group">
            <label>Side (a)</label>
            <input type="number" id="sq-a" value="5" min="0" step="any">
          </div>
          <button class="geo-btn" onclick="calcSquare()">Calculate</button>
          <div class="geo-results" id="res-square">
            <div class="res-item"><span class="res-name">Area</span><span class="res-val" id="sq-area">-</span></div>
            <div class="res-item"><span class="res-name">Perimeter</span><span class="res-val" id="sq-perim">-</span></div>
            <div class="res-item"><span class="res-name">Diagonal</span><span class="res-val" id="sq-diag">-</span></div>
          </div>
        </div>
        <!-- Rectangle -->
        <div class="shape-panel" id="panel-rectangle">
          <h3><i class="fa-solid fa-vector-square" style="margin-right:.3rem;"></i>Rectangle</h3>
          <div class="geo-input-group">
            <label>Length (l)</label>
            <input type="number" id="rect-l" value="8" min="0" step="any">
          </div>
          <div class="geo-input-group">
            <label>Width (w)</label>
            <input type="number" id="rect-w" value="5" min="0" step="any">
          </div>
          <button class="geo-btn" onclick="calcRect()">Calculate</button>
          <div class="geo-results" id="res-rectangle">
            <div class="res-item"><span class="res-name">Area</span><span class="res-val" id="rect-area">-</span></div>
            <div class="res-item"><span class="res-name">Perimeter</span><span class="res-val" id="rect-perim">-</span></div>
            <div class="res-item"><span class="res-name">Diagonal</span><span class="res-val" id="rect-diag">-</span></div>
          </div>
        </div>
        <!-- Triangle -->
        <div class="shape-panel" id="panel-triangle">
          <h3><i class="fa-solid fa-play" style="margin-right:.3rem; transform:rotate(90deg);display:inline-block;"></i>Triangle</h3>
          <div class="geo-input-group">
            <label>Base (b)</label>
            <input type="number" id="tri-b" value="6" min="0" step="any">
          </div>
          <div class="geo-input-group">
            <label>Height (h)</label>
            <input type="number" id="tri-h" value="4" min="0" step="any">
          </div>
          <div class="geo-input-group">
            <label>Side A</label>
            <input type="number" id="tri-a" value="5" min="0" step="any">
          </div>
          <div class="geo-input-group">
            <label>Side C</label>
            <input type="number" id="tri-c" value="5" min="0" step="any">
          </div>
          <button class="geo-btn" onclick="calcTriangle()">Calculate</button>
          <div class="geo-results" id="res-triangle">
            <div class="res-item"><span class="res-name">Area</span><span class="res-val" id="tri-area">-</span></div>
            <div class="res-item"><span class="res-name">Perimeter</span><span class="res-val" id="tri-perim">-</span></div>
          </div>
        </div>
        <!-- Trapezoid -->
        <div class="shape-panel" id="panel-trapezoid">
          <h3><i class="fa-solid fa-shapes" style="margin-right:.3rem;"></i>Trapezoid</h3>
          <div class="geo-input-group">
            <label>Top base (a)</label>
            <input type="number" id="trap-a" value="4" min="0" step="any">
          </div>
          <div class="geo-input-group">
            <label>Bottom base (b)</label>
            <input type="number" id="trap-b" value="8" min="0" step="any">
          </div>
          <div class="geo-input-group">
            <label>Height (h)</label>
            <input type="number" id="trap-h" value="5" min="0" step="any">
          </div>
          <div class="geo-input-group">
            <label>Side (c)</label>
            <input type="number" id="trap-c" value="5.4" min="0" step="any">
          </div>
          <div class="geo-input-group">
            <label>Side (d)</label>
            <input type="number" id="trap-d" value="5.4" min="0" step="any">
          </div>
          <button class="geo-btn" onclick="calcTrapezoid()">Calculate</button>
          <div class="geo-results" id="res-trapezoid">
            <div class="res-item"><span class="res-name">Area</span><span class="res-val" id="trap-area">-</span></div>
            <div class="res-item"><span class="res-name">Perimeter</span><span class="res-val" id="trap-perim">-</span></div>
          </div>
        </div>
      </div>

      <!-- SVG Preview -->
      <div class="geo-card">
        <h3><i class="fa-solid fa-eye" style="margin-right:.3rem;"></i>Visual Preview</h3>
        <div class="svg-preview" id="svgPreview">
          <svg id="geoSvg" width="200" height="200" viewBox="0 0 200 200"></svg>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const fmt = n => parseFloat(n.toFixed(4));

  document.querySelectorAll('.shape-card').forEach(card => {
    card.addEventListener('click', () => {
      document.querySelectorAll('.shape-card').forEach(c => c.classList.remove('active'));
      document.querySelectorAll('.shape-panel').forEach(p => p.classList.remove('active'));
      card.classList.add('active');
      document.getElementById('panel-' + card.dataset.shape).classList.add('active');
      drawShape(card.dataset.shape);
    });
  });

  function showRes(id) {
    const el = document.getElementById('res-' + id);
    el.style.display = 'block';
    el.style.animation = 'none';
    el.offsetHeight;
    el.style.animation = 'revealDown .4s ease';
  }

  function drawSvg(content) {
    const svg = document.getElementById('geoSvg');
    svg.innerHTML = content;
  }

  function drawShape(shape, params) {
    params = params || {};
    const cx = 100, cy = 100;
    switch(shape) {
      case 'circle': {
        const r = Math.min(80, Math.max(10, (params.r || 5) * 8));
        drawSvg(`
          <circle cx="${cx}" cy="${cy}" r="${r}" fill="#eaf4ff" stroke="#007aff" stroke-width="2.5"/>
          <line x1="${cx}" y1="${cy}" x2="${cx+r}" y2="${cy}" stroke="#007aff" stroke-width="1.5" stroke-dasharray="4,3"/>
          <text x="${cx+r/2}" y="${cy-6}" fill="#007aff" font-size="12" font-weight="700" text-anchor="middle">r</text>
          <circle cx="${cx}" cy="${cy}" r="3" fill="#007aff"/>
        `); break;
      }
      case 'square': {
        const s = Math.min(140, Math.max(20, (params.a || 5) * 14));
        const x0 = cx - s/2, y0 = cy - s/2;
        drawSvg(`
          <rect x="${x0}" y="${y0}" width="${s}" height="${s}" fill="#eaf4ff" stroke="#007aff" stroke-width="2.5" rx="2"/>
          <text x="${cx}" y="${y0-6}" fill="#007aff" font-size="12" font-weight="700" text-anchor="middle">a</text>
          <text x="${x0-10}" y="${cy+4}" fill="#007aff" font-size="12" font-weight="700" text-anchor="middle">a</text>
        `); break;
      }
      case 'rectangle': {
        const l = params.l || 8, w = params.w || 5;
        const ratio = l / Math.max(l, w);
        const wRatio = w / Math.max(l, w);
        const sw = Math.max(40, ratio * 160), sh = Math.max(30, wRatio * 120);
        const x0 = cx - sw/2, y0 = cy - sh/2;
        drawSvg(`
          <rect x="${x0}" y="${y0}" width="${sw}" height="${sh}" fill="#eaf4ff" stroke="#007aff" stroke-width="2.5" rx="2"/>
          <text x="${cx}" y="${y0-6}" fill="#007aff" font-size="12" font-weight="700" text-anchor="middle">l = ${l}</text>
          <text x="${x0-12}" y="${cy+4}" fill="#007aff" font-size="11" font-weight="700" text-anchor="middle">w=${w}</text>
        `); break;
      }
      case 'triangle': {
        const b = params.b || 6, h = params.h || 4;
        const scale = Math.min(150/Math.max(b,h), 15);
        const bpx = b * scale, hpx = h * scale;
        const x0 = cx - bpx/2, x1 = cx + bpx/2, ytop = cy - hpx/2, ybot = cy + hpx/2;
        drawSvg(`
          <polygon points="${cx},${ytop} ${x0},${ybot} ${x1},${ybot}" fill="#eaf4ff" stroke="#007aff" stroke-width="2.5"/>
          <line x1="${cx}" y1="${ytop}" x2="${cx}" y2="${ybot}" stroke="#007aff" stroke-width="1.5" stroke-dasharray="4,3"/>
          <text x="${cx+6}" y="${cy+4}" fill="#007aff" font-size="11" font-weight="700">h</text>
          <text x="${cx}" y="${ybot+16}" fill="#007aff" font-size="12" font-weight="700" text-anchor="middle">b</text>
        `); break;
      }
      case 'trapezoid': {
        const a = params.a || 4, b = params.b || 8, h = params.h || 5;
        const scale = Math.min(140/Math.max(a,b), 18);
        const bpx = b*scale, apx = a*scale, hpx = Math.min(h*scale, 100);
        const xoff = (bpx - apx)/2;
        const x0 = cx - bpx/2, x1 = cx + bpx/2;
        const xt0 = cx - apx/2, xt1 = cx + apx/2;
        const ytop = cy - hpx/2, ybot = cy + hpx/2;
        drawSvg(`
          <polygon points="${xt0},${ytop} ${xt1},${ytop} ${x1},${ybot} ${x0},${ybot}" fill="#eaf4ff" stroke="#007aff" stroke-width="2.5"/>
          <text x="${cx}" y="${ytop-6}" fill="#007aff" font-size="11" font-weight="700" text-anchor="middle">a=${a}</text>
          <text x="${cx}" y="${ybot+16}" fill="#007aff" font-size="12" font-weight="700" text-anchor="middle">b=${b}</text>
          <line x1="${cx}" y1="${ytop}" x2="${cx}" y2="${ybot}" stroke="#007aff" stroke-width="1.5" stroke-dasharray="4,3"/>
          <text x="${cx+6}" y="${cy+4}" fill="#007aff" font-size="11" font-weight="700">h</text>
        `); break;
      }
    }
  }

  window.calcCircle = function() {
    const r = parseFloat(document.getElementById('c-r').value)||0;
    document.getElementById('c-area').textContent = fmt(Math.PI * r * r) + ' units²';
    document.getElementById('c-circ').textContent = fmt(2 * Math.PI * r) + ' units';
    document.getElementById('c-diam').textContent = fmt(2 * r) + ' units';
    showRes('circle');
    drawShape('circle', {r});
  };

  window.calcSquare = function() {
    const a = parseFloat(document.getElementById('sq-a').value)||0;
    document.getElementById('sq-area').textContent = fmt(a*a) + ' units²';
    document.getElementById('sq-perim').textContent = fmt(4*a) + ' units';
    document.getElementById('sq-diag').textContent = fmt(a*Math.SQRT2) + ' units';
    showRes('square');
    drawShape('square', {a});
  };

  window.calcRect = function() {
    const l = parseFloat(document.getElementById('rect-l').value)||0;
    const w = parseFloat(document.getElementById('rect-w').value)||0;
    document.getElementById('rect-area').textContent = fmt(l*w) + ' units²';
    document.getElementById('rect-perim').textContent = fmt(2*(l+w)) + ' units';
    document.getElementById('rect-diag').textContent = fmt(Math.sqrt(l*l+w*w)) + ' units';
    showRes('rectangle');
    drawShape('rectangle', {l, w});
  };

  window.calcTriangle = function() {
    const b = parseFloat(document.getElementById('tri-b').value)||0;
    const h = parseFloat(document.getElementById('tri-h').value)||0;
    const a = parseFloat(document.getElementById('tri-a').value)||0;
    const c = parseFloat(document.getElementById('tri-c').value)||0;
    document.getElementById('tri-area').textContent = fmt(0.5*b*h) + ' units²';
    document.getElementById('tri-perim').textContent = fmt(a+b+c) + ' units';
    showRes('triangle');
    drawShape('triangle', {b, h});
  };

  window.calcTrapezoid = function() {
    const a = parseFloat(document.getElementById('trap-a').value)||0;
    const b = parseFloat(document.getElementById('trap-b').value)||0;
    const h = parseFloat(document.getElementById('trap-h').value)||0;
    const c = parseFloat(document.getElementById('trap-c').value)||0;
    const d = parseFloat(document.getElementById('trap-d').value)||0;
    document.getElementById('trap-area').textContent = fmt(0.5*(a+b)*h) + ' units²';
    document.getElementById('trap-perim').textContent = fmt(a+b+c+d) + ' units';
    showRes('trapezoid');
    drawShape('trapezoid', {a, b, h});
  };

  drawShape('circle', {r: 5});
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

  <h2>How to Use This Calculator</h2>
  <p>Pick a shape from the buttons at the top. Enter the measurements asked for, such as radius, side length, or base and height. Press Calculate and you will see the area, perimeter (or circumference), and a live preview drawing of the shape with your values.</p>

  <h2>Area vs Perimeter</h2>
  <p>Area is the amount of flat space inside a shape. You measure it in square units, like cm² or m². Think of it as how much paint you would need to fill a shape in.</p>
  <p>Perimeter is the total distance around the outside of a shape. You measure it in regular units, like cm or m. Think of it as how much fencing you would need to go around a yard. For circles, the equivalent of perimeter is called circumference.</p>
  <p>Use area when you need to cover a surface. Use perimeter when you need to go around an edge.</p>

  <h2>Formulas at a Glance</h2>
  <table class="ta-table">
    <thead><tr><th>Shape</th><th>Area Formula</th><th>Perimeter Formula</th></tr></thead>
    <tbody>
      <tr><td>Circle</td><td>A = π × r²</td><td>C = 2 × π × r</td></tr>
      <tr><td>Square</td><td>A = s²</td><td>P = 4 × s</td></tr>
      <tr><td>Rectangle</td><td>A = l × w</td><td>P = 2l + 2w</td></tr>
      <tr><td>Triangle</td><td>A = 0.5 × b × h</td><td>P = a + b + c</td></tr>
      <tr><td>Trapezoid</td><td>A = 0.5 × (a + b) × h</td><td>P = a + b + c + d</td></tr>
    </tbody>
  </table>

  <h2>Understanding Pi</h2>
  <p>Pi (written as the symbol π) is the ratio of a circle's circumference to its diameter. No matter how big or small the circle is, this ratio is always the same number: approximately 3.14159.</p>
  <p>Pi is called an irrational number because its decimal never ends and never repeats. For most calculations you can use 3.14 or the fraction 22/7 as an approximation. This calculator uses the full precision value so your answers are accurate.</p>

  <h2>Worked Examples</h2>
  <div class="ta-box">
    <strong>Circle with radius 5</strong>
    Area = π × 5² = π × 25 = 78.54 cm². Circumference = 2 × π × 5 = 31.42 cm.
  </div>
  <div class="ta-box">
    <strong>Rectangle 8 x 3</strong>
    Area = 8 × 3 = 24 cm². Perimeter = 2(8) + 2(3) = 16 + 6 = 22 cm.
  </div>
  <div class="ta-box">
    <strong>Triangle base 6, height 4</strong>
    Area = 0.5 × 6 × 4 = 12 cm².
  </div>

  <h2>Common Mistakes to Avoid</h2>
  <ul>
    <li>Confusing radius and diameter. The radius is half the diameter. If someone gives you a diameter, divide by 2 before using the area formula.</li>
    <li>Forgetting to write square units for area. An area answer without the squared symbol is incomplete.</li>
    <li>Using the area formula for perimeter and vice versa. Double-check which one the question asks for.</li>
    <li>Using the height of a triangle incorrectly. The height must be perpendicular to the base, not along a slanted side.</li>
  </ul>

  </section>

<div class="tool-nav-row">
  <a href="/math-tools/unit-converter" class="tool-nav-card" style="--tnc-color:#6366f1">
    <div class="tool-nav-icon"><i class="fa-solid fa-arrows-left-right"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Previous</div><div class="tool-nav-name">Unit Converter</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-left"></i></div>
  </a>
  <a href="/math-tools/graphing-calculator" class="tool-nav-card tool-nav-next" style="--tnc-color:#f5a623">
    <div class="tool-nav-icon"><i class="fa-solid fa-chart-line"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Next</div><div class="tool-nav-name">Graphing Calculator</div></div>
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
      <p class="quiz-question"><strong>Q1.</strong> What is the area of a rectangle with length 8 and width 5?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">26</button>
        <button class="quiz-opt" data-oi="1">30</button>
        <button class="quiz-opt" data-oi="2">40</button>
        <button class="quiz-opt" data-oi="3">45</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="1" data-correct="2">
      <p class="quiz-question"><strong>Q2.</strong> What is the area of a circle with radius 7? (use π ≈ 3.14)</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">21.98</button>
        <button class="quiz-opt" data-oi="1">43.96</button>
        <button class="quiz-opt" data-oi="2">153.86</button>
        <button class="quiz-opt" data-oi="3">219.8</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="2" data-correct="2">
      <p class="quiz-question"><strong>Q3.</strong> What is the perimeter of a square with side 6?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">12</button>
        <button class="quiz-opt" data-oi="1">18</button>
        <button class="quiz-opt" data-oi="2">24</button>
        <button class="quiz-opt" data-oi="3">36</button>
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
