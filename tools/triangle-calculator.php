<?php require_once __DIR__ . '/../config.php'; $page_title = 'Triangle Calculator'; $page_desc = 'Solve triangles using SSS, SAS, ASA, or AAS with a live SVG drawing that updates as you type.'; $body_class = 'page-article'; include __DIR__ . '/../_header.php'; ?>

<style>
.tri-page { background: #0d1f1f; min-height: 60vh; padding: 2rem 1rem; color: #e2f8f5; font-family: 'Segoe UI', sans-serif; border-radius: 16px; overflow: hidden; max-width: 900px; margin-left: auto; margin-right: auto; }
.tri-hero { text-align: center; margin-bottom: 2rem; }
.tri-hero h1 { color: #e2f8f5; font-size: 2.2rem; font-weight: 800; margin: 0; text-shadow: 0 0 20px #14b8a644; }
.tri-hero p { color: #5eead4; font-size: 1.05rem; margin-top: .4rem; }
.tri-main { max-width: 800px; margin: 0 auto; }
.tri-tabs { display: flex; gap: .4rem; background: #0a1a1a; border-radius: 14px; padding: .35rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
.tri-tab { flex: 1; text-align: center; padding: .6rem .5rem; border-radius: 10px; cursor: pointer; font-size: .82rem; font-weight: 700; color: #5eead4; border: none; background: transparent; transition: all .2s; min-width: 70px; }
.tri-tab.active { background: #14b8a6; color: #0d1f1f; box-shadow: 0 3px 10px #14b8a655; }
.tri-content { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
@media (max-width: 580px) { .tri-content { grid-template-columns: 1fr; } }
.tri-card { background: #122626; border: 1.5px solid #1d4040; border-radius: 20px; padding: 1.5rem; }
.tri-card h3 { font-size: .78rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #14b8a6; margin: 0 0 1rem; }
.tri-input-group { margin-bottom: .85rem; }
.tri-input-group label { display: block; font-size: .75rem; font-weight: 600; color: #5eead4; margin-bottom: .3rem; }
.tri-input-group input { width: 100%; box-sizing: border-box; background: #0d1f1f; border: 1.5px solid #1d4040; color: #e2f8f5; font-size: 1.3rem; font-weight: 700; border-radius: 10px; padding: .5rem .8rem; outline: none; transition: border-color .2s; }
.tri-input-group input:focus { border-color: #14b8a6; }
.tri-input-group input:disabled { opacity: .4; cursor: not-allowed; }
.tri-btn { width: 100%; background: linear-gradient(135deg, #14b8a6, #0d9488); color: #fff; font-size: 1rem; font-weight: 700; border: none; border-radius: 12px; padding: .85rem; cursor: pointer; transition: all .2s; margin-top: .3rem; }
.tri-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 22px #14b8a655; }
.tri-results { margin-top: 1rem; padding-top: 1rem; border-top: 1.5px solid #1d4040; display: none; }
.res-row { display: flex; justify-content: space-between; align-items: center; padding: .45rem 0; border-bottom: 1px solid #1d404050; }
.res-row:last-child { border-bottom: none; }
.res-name { font-size: .85rem; color: #5eead4; font-weight: 600; }
.res-val { font-size: 1rem; font-weight: 800; color: #2dd4bf; }
.svg-card { background: #0a1a1a; border: 1.5px solid #1d4040; border-radius: 20px; padding: 1.5rem; display: flex; flex-direction: column; }
.svg-card h3 { font-size: .78rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #14b8a6; margin: 0 0 1rem; }
#triSvg { width: 100%; flex: 1; min-height: 220px; }
.tri-panel { display: none; }
.tri-panel.active { display: block; }
.angle-note { font-size: .72rem; color: #5eead4; margin-top: .3rem; font-style: italic; }
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
  <span>Triangle Calculator</span>
</nav>
<div class="tool-page-layout" style="max-width:1100px;width:100%;margin:0 auto;padding:24px 24px 48px;box-sizing:border-box;">
<div class="tool-nav-row">
  <a href="/math-tools/equation-solver" class="tool-nav-card" style="--tnc-color:#4ecdc4">
    <div class="tool-nav-icon"><i class="fa-solid fa-square-root-variable"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Previous</div><div class="tool-nav-name">Equation Solver</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-left"></i></div>
  </a>
  <a href="/math-tools/base-converter" class="tool-nav-card tool-nav-next" style="--tnc-color:#f5a623">
    <div class="tool-nav-icon"><i class="fa-solid fa-code"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Next</div><div class="tool-nav-name">Number Base Converter</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-right"></i></div>
  </a>
</div>
<div class="tri-page">
  <div class="tri-main">
    <div class="tri-hero">
      <h1>Triangle Calculator</h1>
    </div>

    <div class="tri-tabs">
      <button class="tri-tab active" data-mode="SSS">SSS</button>
      <button class="tri-tab" data-mode="SAS">SAS</button>
      <button class="tri-tab" data-mode="ASA">ASA</button>
      <button class="tri-tab" data-mode="AAS">AAS</button>
    </div>

    <div class="tri-content">
      <div class="tri-card">
        <!-- SSS -->
        <div class="tri-panel active" id="panel-SSS">
          <h3>SSS - Three Sides</h3>
          <div class="tri-input-group"><label>Side a</label><input type="number" id="sss-a" value="5" min="0.01" step="any"></div>
          <div class="tri-input-group"><label>Side b</label><input type="number" id="sss-b" value="6" min="0.01" step="any"></div>
          <div class="tri-input-group"><label>Side c</label><input type="number" id="sss-c" value="7" min="0.01" step="any"></div>
          <button class="tri-btn" onclick="solveSSS()"><i class="fa-solid fa-play" style="margin-right:.3rem;"></i>Solve</button>
          <div class="tri-results" id="res-SSS"></div>
        </div>
        <!-- SAS -->
        <div class="tri-panel" id="panel-SAS">
          <h3>SAS - Two Sides, Included Angle</h3>
          <div class="tri-input-group"><label>Side a</label><input type="number" id="sas-a" value="5" min="0.01" step="any"></div>
          <div class="tri-input-group"><label>Angle C (degrees, between a and b)</label><input type="number" id="sas-C" value="60" min="0.01" max="179" step="any"></div>
          <div class="tri-input-group"><label>Side b</label><input type="number" id="sas-b" value="6" min="0.01" step="any"></div>
          <button class="tri-btn" onclick="solveSAS()"><i class="fa-solid fa-play" style="margin-right:.3rem;"></i>Solve</button>
          <div class="tri-results" id="res-SAS"></div>
        </div>
        <!-- ASA -->
        <div class="tri-panel" id="panel-ASA">
          <h3>ASA - Two Angles, Included Side</h3>
          <div class="tri-input-group"><label>Angle A (degrees)</label><input type="number" id="asa-A" value="60" min="0.01" max="178" step="any"></div>
          <div class="tri-input-group"><label>Side c (between A and B)</label><input type="number" id="asa-c" value="7" min="0.01" step="any"></div>
          <div class="tri-input-group"><label>Angle B (degrees)</label><input type="number" id="asa-B" value="70" min="0.01" max="178" step="any"></div>
          <div class="angle-note">Angle C = 180 − A − B will be calculated</div>
          <button class="tri-btn" onclick="solveASA()"><i class="fa-solid fa-play" style="margin-right:.3rem;"></i>Solve</button>
          <div class="tri-results" id="res-ASA"></div>
        </div>
        <!-- AAS -->
        <div class="tri-panel" id="panel-AAS">
          <h3>AAS - Two Angles, Non-Included Side</h3>
          <div class="tri-input-group"><label>Angle A (degrees)</label><input type="number" id="aas-A" value="50" min="0.01" max="178" step="any"></div>
          <div class="tri-input-group"><label>Angle B (degrees)</label><input type="number" id="aas-B" value="60" min="0.01" max="178" step="any"></div>
          <div class="tri-input-group"><label>Side a (opposite to A)</label><input type="number" id="aas-a" value="5" min="0.01" step="any"></div>
          <div class="angle-note">Angle C = 180 − A − B will be calculated</div>
          <button class="tri-btn" onclick="solveAAS()"><i class="fa-solid fa-play" style="margin-right:.3rem;"></i>Solve</button>
          <div class="tri-results" id="res-AAS"></div>
        </div>
      </div>

      <div class="svg-card">
        <h3><i class="fa-solid fa-eye" style="margin-right:.3rem;"></i>Live Triangle</h3>
        <svg id="triSvg" viewBox="0 0 280 240"></svg>
      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const RAD = Math.PI / 180;
  const DEG = 180 / Math.PI;
  const fmt = n => parseFloat(n.toFixed(4));

  document.querySelectorAll('.tri-tab').forEach(tab => {
    tab.addEventListener('click', () => {
      document.querySelectorAll('.tri-tab').forEach(t => t.classList.remove('active'));
      document.querySelectorAll('.tri-panel').forEach(p => p.classList.remove('active'));
      tab.classList.add('active');
      document.getElementById('panel-' + tab.dataset.mode).classList.add('active');
    });
  });

  function showResults(mode, data) {
    const el = document.getElementById('res-' + mode);
    el.style.display = 'block';
    el.innerHTML = Object.entries(data).map(([k, v]) =>
      `<div class="res-row"><span class="res-name">${k}</span><span class="res-val">${v}</span></div>`
    ).join('');
  }

  function drawTriangle(ax, ay, bx, by, cx, cy, labels) {
    const svg = document.getElementById('triSvg');
    svg.innerHTML = '';
    const W = 280, H = 240, pad = 40;

    // Normalize points to fit SVG
    const xs = [ax, bx, cx], ys = [ay, by, cy];
    const minX = Math.min(...xs), maxX = Math.max(...xs);
    const minY = Math.min(...ys), maxY = Math.max(...ys);
    const scaleX = (W - 2*pad) / (maxX - minX || 1);
    const scaleY = (H - 2*pad) / (maxY - minY || 1);
    const scale = Math.min(scaleX, scaleY);
    const offX = pad + ((W - 2*pad) - (maxX - minX) * scale) / 2;
    const offY = pad + ((H - 2*pad) - (maxY - minY) * scale) / 2;

    const tx = v => offX + (v - minX) * scale;
    const ty = v => H - offY - (v - minY) * scale;

    const p = [[tx(ax),ty(ay)],[tx(bx),ty(by)],[tx(cx),ty(cy)]];

    // Fill with animated opacity
    const fill = document.createElementNS('http://www.w3.org/2000/svg','polygon');
    fill.setAttribute('points', p.map(pt => pt.join(',')).join(' '));
    fill.setAttribute('fill', '#14b8a622');
    fill.setAttribute('stroke', 'none');
    svg.appendChild(fill);

    // Sides
    const poly = document.createElementNS('http://www.w3.org/2000/svg','polygon');
    poly.setAttribute('points', p.map(pt => pt.join(',')).join(' '));
    poly.setAttribute('fill', 'none');
    poly.setAttribute('stroke', '#14b8a6');
    poly.setAttribute('stroke-width', '2.5');
    svg.appendChild(poly);

    // Side length labels
    if(labels) {
      const midAB = [(p[0][0]+p[1][0])/2, (p[0][1]+p[1][1])/2];
      const midBC = [(p[1][0]+p[2][0])/2, (p[1][1]+p[2][1])/2];
      const midCA = [(p[2][0]+p[0][0])/2, (p[2][1]+p[0][1])/2];

      function addLabel(x, y, text, color) {
        const t = document.createElementNS('http://www.w3.org/2000/svg','text');
        t.setAttribute('x', x); t.setAttribute('y', y);
        t.setAttribute('text-anchor', 'middle'); t.setAttribute('font-size', '11');
        t.setAttribute('font-weight', '800'); t.setAttribute('fill', color || '#2dd4bf');
        t.setAttribute('font-family', 'Segoe UI, sans-serif');
        t.textContent = text; svg.appendChild(t);
      }

      if(labels.c) addLabel(midAB[0], midAB[1] - 8, 'c=' + fmt(labels.c), '#2dd4bf');
      if(labels.a) addLabel(midBC[0] + 12, midBC[1], 'a=' + fmt(labels.a), '#2dd4bf');
      if(labels.b) addLabel(midCA[0] - 12, midCA[1], 'b=' + fmt(labels.b), '#2dd4bf');

      // Vertex labels
      const vLabels = ['A', 'B', 'C'];
      const offsets = [[-12,-8],[12,-8],[0,16]];
      p.forEach((pt, i) => {
        const t = document.createElementNS('http://www.w3.org/2000/svg','text');
        t.setAttribute('x', pt[0] + offsets[i][0]); t.setAttribute('y', pt[1] + offsets[i][1]);
        t.setAttribute('text-anchor', 'middle'); t.setAttribute('font-size', '12');
        t.setAttribute('font-weight', '900'); t.setAttribute('fill', '#5eead4');
        t.textContent = vLabels[i]; svg.appendChild(t);
      });

      // Angle labels
      if(labels.A) {
        const t = document.createElementNS('http://www.w3.org/2000/svg','text');
        t.setAttribute('x', p[0][0] + 14); t.setAttribute('y', p[0][1] + 4);
        t.setAttribute('font-size', '10'); t.setAttribute('fill', '#fde68a');
        t.setAttribute('font-weight', '700');
        t.textContent = fmt(labels.A) + '°'; svg.appendChild(t);
      }
      if(labels.B) {
        const t = document.createElementNS('http://www.w3.org/2000/svg','text');
        t.setAttribute('x', p[1][0] - 14); t.setAttribute('y', p[1][1] + 4);
        t.setAttribute('font-size', '10'); t.setAttribute('fill', '#fde68a');
        t.setAttribute('font-weight', '700'); t.setAttribute('text-anchor', 'end');
        t.textContent = fmt(labels.B) + '°'; svg.appendChild(t);
      }
      if(labels.C) {
        const t = document.createElementNS('http://www.w3.org/2000/svg','text');
        t.setAttribute('x', p[2][0]); t.setAttribute('y', p[2][1] - 6);
        t.setAttribute('font-size', '10'); t.setAttribute('fill', '#fde68a');
        t.setAttribute('font-weight', '700'); t.setAttribute('text-anchor', 'middle');
        t.textContent = fmt(labels.C) + '°'; svg.appendChild(t);
      }
    }
  }

  window.solveSSS = function() {
    const a = parseFloat(document.getElementById('sss-a').value)||0;
    const b = parseFloat(document.getElementById('sss-b').value)||0;
    const c = parseFloat(document.getElementById('sss-c').value)||0;
    if(a+b <= c || a+c <= b || b+c <= a) { alert('These sides cannot form a valid triangle!'); return; }

    const A = Math.acos((b*b + c*c - a*a) / (2*b*c)) * DEG;
    const B = Math.acos((a*a + c*c - b*b) / (2*a*c)) * DEG;
    const C = 180 - A - B;
    const s = (a+b+c)/2;
    const area = Math.sqrt(s*(s-a)*(s-b)*(s-c));

    showResults('SSS', { 'Angle A': fmt(A) + '°', 'Angle B': fmt(B) + '°', 'Angle C': fmt(C) + '°', 'Perimeter': fmt(a+b+c), 'Area': fmt(area) });

    const Ar = A * RAD;
    drawTriangle(0, 0, c, 0, b*Math.cos(Ar), b*Math.sin(Ar), {a,b,c,A,B,C});
  };

  window.solveSAS = function() {
    const a = parseFloat(document.getElementById('sas-a').value)||0;
    const C = parseFloat(document.getElementById('sas-C').value)||0;
    const b = parseFloat(document.getElementById('sas-b').value)||0;
    if(C <= 0 || C >= 180) { alert('Angle must be between 0 and 180 degrees!'); return; }

    const c = Math.sqrt(a*a + b*b - 2*a*b*Math.cos(C*RAD));
    const A = Math.asin(a * Math.sin(C*RAD) / c) * DEG;
    const B = 180 - A - C;
    const area = 0.5 * a * b * Math.sin(C*RAD);

    showResults('SAS', { 'Side c': fmt(c), 'Angle A': fmt(A) + '°', 'Angle B': fmt(B) + '°', 'Perimeter': fmt(a+b+c), 'Area': fmt(area) });

    const Ar = A * RAD;
    drawTriangle(0, 0, c, 0, b*Math.cos(Ar), b*Math.sin(Ar), {a,b,c,A,B,C});
  };

  window.solveASA = function() {
    const A = parseFloat(document.getElementById('asa-A').value)||0;
    const side_c = parseFloat(document.getElementById('asa-c').value)||0;
    const B = parseFloat(document.getElementById('asa-B').value)||0;
    const C = 180 - A - B;
    if(C <= 0) { alert('Angles must sum to less than 180!'); return; }

    const a = side_c * Math.sin(A*RAD) / Math.sin(C*RAD);
    const b = side_c * Math.sin(B*RAD) / Math.sin(C*RAD);
    const area = 0.5 * side_c * side_c * Math.sin(A*RAD) * Math.sin(B*RAD) / Math.sin(C*RAD) / Math.sin(C*RAD) * Math.sin(C*RAD);

    showResults('ASA', { 'Side a': fmt(a), 'Side b': fmt(b), 'Angle C': fmt(C) + '°', 'Perimeter': fmt(a+b+side_c), 'Area': fmt(area) });

    const Ar = A * RAD;
    drawTriangle(0, 0, side_c, 0, b*Math.cos(Ar), b*Math.sin(Ar), {a, b, c:side_c, A, B, C});
  };

  window.solveAAS = function() {
    const A = parseFloat(document.getElementById('aas-A').value)||0;
    const B = parseFloat(document.getElementById('aas-B').value)||0;
    const a = parseFloat(document.getElementById('aas-a').value)||0;
    const C = 180 - A - B;
    if(C <= 0) { alert('Angles must sum to less than 180!'); return; }

    const b = a * Math.sin(B*RAD) / Math.sin(A*RAD);
    const c = a * Math.sin(C*RAD) / Math.sin(A*RAD);
    const area = 0.5 * a * b * Math.sin(C*RAD);

    showResults('AAS', { 'Side b': fmt(b), 'Side c': fmt(c), 'Angle C': fmt(C) + '°', 'Perimeter': fmt(a+b+c), 'Area': fmt(area) });

    const Ar = A * RAD;
    drawTriangle(0, 0, c, 0, b*Math.cos(Ar), b*Math.sin(Ar), {a, b, c, A, B, C});
  };

  // Initial draw
  drawTriangle(0, 0, 7, 0, 3, 5, {a:5,b:6,c:7});
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
  <p>Select the input mode that matches what you know about your triangle: SSS if you have all three sides, SAS if you have two sides and the angle between them, ASA or AAS if you have two angles and a side. Enter your values and press Calculate. The tool finds all missing sides, angles, area, and perimeter.</p>

  <h2>Triangle Basics</h2>
  <p>A triangle has three sides (a, b, c) and three angles (A, B, C). The angle A is opposite side a, angle B is opposite side b, and angle C is opposite side c. This labelling is used by convention in every triangle formula.</p>
  <p>One fact is always true for every triangle: the three angles add up to exactly 180 degrees. If you know two angles, the third is always 180 minus the sum of the other two. This is a quick way to check your inputs.</p>

  <h2>The Input Modes Explained</h2>
  <table class="ta-table">
    <thead><tr><th>Mode</th><th>Stands For</th><th>What You Provide</th></tr></thead>
    <tbody>
      <tr><td>SSS</td><td>Side-Side-Side</td><td>All three side lengths</td></tr>
      <tr><td>SAS</td><td>Side-Angle-Side</td><td>Two sides and the angle between them</td></tr>
      <tr><td>ASA</td><td>Angle-Side-Angle</td><td>Two angles and the side between them</td></tr>
      <tr><td>AAS</td><td>Angle-Angle-Side</td><td>Two angles and a side not between them</td></tr>
    </tbody>
  </table>

  <h2>Key Formulas Used</h2>
  <p><strong>Law of Sines:</strong> a / sin(A) = b / sin(B) = c / sin(C). Use this when you have two angles and a side.</p>
  <p><strong>Law of Cosines:</strong> c^2 = a^2 + b^2 - 2ab x cos(C). Use this when you have three sides or two sides and the included angle.</p>
  <p><strong>Area:</strong> Area = 0.5 x a x b x sin(C). This works for any triangle, not just right triangles.</p>

  <h2>Types of Triangles</h2>
  <ul>
    <li><strong>Equilateral:</strong> All three sides equal. All angles are exactly 60 degrees.</li>
    <li><strong>Isosceles:</strong> Two sides equal. The two base angles are equal.</li>
    <li><strong>Scalene:</strong> All sides different. All angles different.</li>
    <li><strong>Right:</strong> One angle is exactly 90 degrees. The Pythagorean theorem applies.</li>
    <li><strong>Obtuse:</strong> One angle is greater than 90 degrees.</li>
  </ul>

  <h2>Common Mistakes to Avoid</h2>
  <ul>
    <li>Entering angles that do not add up to 180. The calculator will catch this, but double-check your values first.</li>
    <li>Using degrees when the formula expects radians, or vice versa. This tool uses degrees, which matches most school problems.</li>
    <li>Violating the triangle inequality: any side must be shorter than the sum of the other two sides.</li>
    <li>Confusing the included angle with a non-included angle when choosing SAS or AAS mode.</li>
  </ul>

  </section>

<div class="tool-nav-row">
  <a href="/math-tools/equation-solver" class="tool-nav-card" style="--tnc-color:#4ecdc4">
    <div class="tool-nav-icon"><i class="fa-solid fa-square-root-variable"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Previous</div><div class="tool-nav-name">Equation Solver</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-left"></i></div>
  </a>
  <a href="/math-tools/base-converter" class="tool-nav-card tool-nav-next" style="--tnc-color:#f5a623">
    <div class="tool-nav-icon"><i class="fa-solid fa-code"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Next</div><div class="tool-nav-name">Number Base Converter</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-right"></i></div>
  </a>
</div>

<div class="topic-quiz" id="tool-quiz">
  <div class="quiz-header" style="background:#ec4899">
    <i class="fa-solid fa-circle-question"></i> Quick Quiz
    <span class="quiz-sub">3 questions</span>
  </div>
  <div class="quiz-body">
    <div class="quiz-q" data-qi="0" data-correct="1">
      <p class="quiz-question"><strong>Q1.</strong> What is the sum of angles in any triangle?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">90°</button>
        <button class="quiz-opt" data-oi="1">180°</button>
        <button class="quiz-opt" data-oi="2">270°</button>
        <button class="quiz-opt" data-oi="3">360°</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="1" data-correct="0">
      <p class="quiz-question"><strong>Q2.</strong> In a right triangle with legs 3 and 4, what is the hypotenuse?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">5</button>
        <button class="quiz-opt" data-oi="1">6</button>
        <button class="quiz-opt" data-oi="2">7</button>
        <button class="quiz-opt" data-oi="3">8</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="2" data-correct="3">
      <p class="quiz-question"><strong>Q3.</strong> An equilateral triangle has how many equal sides?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">0</button>
        <button class="quiz-opt" data-oi="1">1</button>
        <button class="quiz-opt" data-oi="2">2</button>
        <button class="quiz-opt" data-oi="3">3</button>
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
