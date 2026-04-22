<?php require_once __DIR__ . '/../config.php'; $page_title = 'Times Table'; $page_desc = 'Interactive color-coded multiplication grid - hover to highlight rows and columns, click to find multiples.'; $body_class = 'page-article'; include __DIR__ . '/../_header.php'; ?>

<style>
.tt-page { background: #fdf4ff; min-height: 60vh; padding: 2rem 1rem; font-family: 'Segoe UI', sans-serif; border-radius: 16px; overflow: hidden; max-width: 900px; margin-left: auto; margin-right: auto; }
.tt-hero { text-align: center; margin-bottom: 1.5rem; }
.tt-hero h1 { color: #3b1a6b; font-size: 2.2rem; font-weight: 800; margin: 0; }
.tt-hero p { color: #7c3aed; font-size: 1.05rem; margin-top: .4rem; }
.tt-main { max-width: 900px; margin: 0 auto; }
.tt-controls { display: flex; gap: .8rem; align-items: center; flex-wrap: wrap; justify-content: center; margin-bottom: 1.2rem; }
.tt-size-btn { background: #fff; border: 2px solid #e9d5ff; color: #7c3aed; font-size: .82rem; font-weight: 700; border-radius: 20px; padding: .4rem 1rem; cursor: pointer; transition: all .2s; }
.tt-size-btn.active { background: #c084fc; border-color: #c084fc; color: #fff; }
.tt-search-group { display: flex; align-items: center; gap: .5rem; background: #fff; border: 2px solid #e9d5ff; border-radius: 20px; padding: .35rem .8rem; }
.tt-search-group label { font-size: .78rem; font-weight: 700; color: #7c3aed; white-space: nowrap; }
.tt-search { border: none; outline: none; font-size: .95rem; font-weight: 700; color: #3b1a6b; width: 60px; text-align: center; background: transparent; }
.tt-clear-btn { background: #f3e8ff; border: none; border-radius: 12px; color: #7c3aed; font-size: .78rem; font-weight: 700; padding: .3rem .7rem; cursor: pointer; }
.tt-wrap { overflow-x: auto; border-radius: 16px; box-shadow: 0 4px 20px #c084fc22; }
table.tt { border-collapse: collapse; width: 100%; min-width: max-content; background: #fff; border-radius: 16px; overflow: hidden; }
.tt th, .tt td { width: 48px; height: 42px; text-align: center; font-size: .88rem; font-weight: 700; border: 1.5px solid #f3e8ff; cursor: pointer; user-select: none; transition: background .15s, color .15s, transform .1s; }
.tt th { background: #f3e8ff; color: #6b21a8; font-size: .9rem; font-weight: 800; }
.tt th.corner { background: #e9d5ff; }
.tt td { color: #3b1a6b; }
/* Color bands by value */
.tt td[data-v="small"] { background: #fdf4ff; }
.tt td[data-v="med1"]  { background: #f3e8ff; }
.tt td[data-v="med2"]  { background: #e9d5ff; }
.tt td[data-v="large"] { background: #d8b4fe; }
.tt td[data-v="xlarge"]{ background: #c084fc; color: #fff; }
/* Hover highlight */
.tt td.row-hi, .tt td.col-hi { background: #fde68a !important; color: #92400e !important; transform: scale(1.05); z-index: 2; position: relative; }
.tt td.both-hi { background: #f5a623 !important; color: #fff !important; transform: scale(1.12); z-index: 3; box-shadow: 0 4px 12px #f5a62355; border-radius: 6px; }
/* Multiple highlight */
.tt td.multiple-hi { background: #4ade80 !important; color: #14532d !important; }
.tt td.search-hi { background: #f43f5e !important; color: #fff !important; border-radius: 6px; box-shadow: 0 0 8px #f43f5e55; }
/* Row/col header active */
.tt th.active-header { background: #c084fc !important; color: #fff !important; }
.tt-legend { display: flex; gap: .6rem; flex-wrap: wrap; justify-content: center; margin-top: 1rem; }
.legend-item { display: flex; align-items: center; gap: .3rem; font-size: .75rem; font-weight: 600; color: #7c3aed; }
.legend-color { width: 16px; height: 16px; border-radius: 4px; }
.tt-tip { text-align: center; font-size: .8rem; color: #9ca3af; margin-top: .6rem; }
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
  <span>Times Table</span>
</nav>
<div class="tool-page-layout" style="max-width:1100px;width:100%;margin:0 auto;padding:24px 24px 48px;box-sizing:border-box;">
<div class="tool-nav-row">
  <a href="/math-tools/roman-numeral-converter" class="tool-nav-card" style="--tnc-color:#007aff">
    <div class="tool-nav-icon"><i class="fa-solid fa-landmark"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Previous</div><div class="tool-nav-name">Roman Numeral Converter</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-left"></i></div>
  </a>
  <a href="/math-tools/equation-solver" class="tool-nav-card tool-nav-next" style="--tnc-color:#4ecdc4">
    <div class="tool-nav-icon"><i class="fa-solid fa-square-root-variable"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Next</div><div class="tool-nav-name">Equation Solver</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-right"></i></div>
  </a>
</div>
<div class="tt-page">
  <div class="tt-main">
    <div class="tt-hero">
      <h1>Times Table</h1>
    </div>

    <div class="tt-controls">
      <span style="font-size:.82rem;font-weight:700;color:#7c3aed;">Grid:</span>
      <button class="tt-size-btn" onclick="buildTable(10)" data-size="10">10×10</button>
      <button class="tt-size-btn active" onclick="buildTable(12)" data-size="12">12×12</button>
      <button class="tt-size-btn" onclick="buildTable(15)" data-size="15">15×15</button>
      <div class="tt-search-group">
        <label>Find:</label>
        <input class="tt-search" type="number" id="searchNum" placeholder="0" min="1">
        <button class="tt-clear-btn" onclick="clearHighlight()">Clear</button>
      </div>
    </div>

    <div class="tt-wrap" id="tableWrap"></div>

    <div class="tt-legend">
      <div class="legend-item"><div class="legend-color" style="background:#fdf4ff;border:1px solid #e9d5ff;"></div>1-30</div>
      <div class="legend-item"><div class="legend-color" style="background:#e9d5ff;"></div>31-80</div>
      <div class="legend-item"><div class="legend-color" style="background:#c084fc;"></div>80+</div>
      <div class="legend-item"><div class="legend-color" style="background:#fde68a;"></div>Hover highlight</div>
      <div class="legend-item"><div class="legend-color" style="background:#4ade80;"></div>Multiples</div>
      <div class="legend-item"><div class="legend-color" style="background:#f43f5e;"></div>Search result</div>
    </div>

  </div>
</div>

<script>
(function(){
  let tableSize = 12;
  let activeMultiple = null;
  let searchVal = null;

  function getColorBand(val) {
    if(val <= 30) return 'small';
    if(val <= 60) return 'med1';
    if(val <= 80) return 'med2';
    if(val <= 120) return 'large';
    return 'xlarge';
  }

  window.buildTable = function(size) {
    tableSize = size;
    document.querySelectorAll('.tt-size-btn').forEach(b => {
      b.classList.toggle('active', b.dataset.size == size);
    });

    const wrap = document.getElementById('tableWrap');
    const table = document.createElement('table');
    table.className = 'tt';
    table.id = 'mainTable';

    // Header row
    const thead = document.createElement('thead');
    const headerRow = document.createElement('tr');
    const corner = document.createElement('th');
    corner.className = 'corner';
    corner.innerHTML = '×';
    headerRow.appendChild(corner);

    for(let col = 1; col <= size; col++) {
      const th = document.createElement('th');
      th.textContent = col;
      th.dataset.col = col;
      th.style.cursor = 'pointer';
      th.addEventListener('click', () => highlightMultiple(col, 'col'));
      th.addEventListener('mouseenter', () => previewHighlight(col, 'col'));
      th.addEventListener('mouseleave', () => removePreview());
      headerRow.appendChild(th);
    }
    thead.appendChild(headerRow);
    table.appendChild(thead);

    const tbody = document.createElement('tbody');
    for(let row = 1; row <= size; row++) {
      const tr = document.createElement('tr');

      const rowTh = document.createElement('th');
      rowTh.textContent = row;
      rowTh.dataset.row = row;
      rowTh.style.cursor = 'pointer';
      rowTh.addEventListener('click', () => highlightMultiple(row, 'row'));
      rowTh.addEventListener('mouseenter', () => previewHighlight(row, 'row'));
      rowTh.addEventListener('mouseleave', () => removePreview());
      tr.appendChild(rowTh);

      for(let col = 1; col <= size; col++) {
        const td = document.createElement('td');
        const val = row * col;
        td.textContent = val;
        td.dataset.row = row;
        td.dataset.col = col;
        td.dataset.val = val;
        td.dataset.v = getColorBand(val);
        td.addEventListener('mouseenter', () => onCellHover(row, col));
        td.addEventListener('mouseleave', () => onCellLeave(row, col));
        td.addEventListener('click', () => highlightMultiple(val, 'value'));
        tr.appendChild(td);
      }
      tbody.appendChild(tr);
    }
    table.appendChild(tbody);
    wrap.innerHTML = '';
    wrap.appendChild(table);

    if(activeMultiple !== null) highlightMultiple(activeMultiple.val, activeMultiple.type);
    if(searchVal !== null) applySearch(searchVal);
  };

  function onCellHover(hRow, hCol) {
    const table = document.getElementById('mainTable');
    if(!table) return;
    table.querySelectorAll('td').forEach(td => {
      const r = parseInt(td.dataset.row), c = parseInt(td.dataset.col);
      td.classList.remove('row-hi','col-hi','both-hi');
      if(r === hRow && c === hCol) td.classList.add('both-hi');
      else if(r === hRow) td.classList.add('row-hi');
      else if(c === hCol) td.classList.add('col-hi');
    });
    // Highlight headers
    table.querySelectorAll('th[data-col]').forEach(th => {
      th.classList.toggle('active-header', parseInt(th.dataset.col) === hCol);
    });
    table.querySelectorAll('th[data-row]').forEach(th => {
      th.classList.toggle('active-header', parseInt(th.dataset.row) === hRow);
    });
  }

  function onCellLeave() {
    const table = document.getElementById('mainTable');
    if(!table) return;
    table.querySelectorAll('td').forEach(td => td.classList.remove('row-hi','col-hi','both-hi'));
    table.querySelectorAll('th').forEach(th => th.classList.remove('active-header'));
    if(activeMultiple !== null) highlightMultiple(activeMultiple.val, activeMultiple.type, true);
  }

  function previewHighlight(num, type) {}
  function removePreview() {}

  function highlightMultiple(val, type, keepActive) {
    if(!keepActive) {
      if(activeMultiple && activeMultiple.val === val) {
        activeMultiple = null;
        clearMultiples();
        return;
      }
      activeMultiple = {val, type};
    }

    clearMultiples();
    const table = document.getElementById('mainTable');
    if(!table) return;

    if(type === 'value') {
      table.querySelectorAll('td').forEach(td => {
        if(parseInt(td.dataset.val) === val) td.classList.add('multiple-hi');
      });
    } else if(type === 'row' || type === 'col') {
      table.querySelectorAll('td').forEach(td => {
        const r = parseInt(td.dataset.row), c = parseInt(td.dataset.col);
        const cellVal = r * c;
        if(cellVal % val === 0) td.classList.add('multiple-hi');
      });
    }
  }

  function clearMultiples() {
    const table = document.getElementById('mainTable');
    if(table) table.querySelectorAll('td').forEach(td => td.classList.remove('multiple-hi'));
  }

  window.clearHighlight = function() {
    activeMultiple = null;
    searchVal = null;
    clearMultiples();
    const table = document.getElementById('mainTable');
    if(table) table.querySelectorAll('td').forEach(td => td.classList.remove('search-hi'));
    document.getElementById('searchNum').value = '';
  };

  function applySearch(val) {
    const table = document.getElementById('mainTable');
    if(!table) return;
    table.querySelectorAll('td').forEach(td => {
      td.classList.toggle('search-hi', parseInt(td.dataset.val) === val);
    });
  }

  document.getElementById('searchNum').addEventListener('input', function() {
    const v = parseInt(this.value);
    if(!isNaN(v) && v > 0) {
      searchVal = v;
      applySearch(v);
    } else {
      searchVal = null;
      const table = document.getElementById('mainTable');
      if(table) table.querySelectorAll('td').forEach(td => td.classList.remove('search-hi'));
    }
  });

  buildTable(12);
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

  <h2>How to Use This Table</h2>
  <p>Click any number across the top row or down the left column to highlight that table. The matching cell for any two numbers shows their product. Use the table to look up facts quickly, or use it as a visual reference while practicing. Try to quiz yourself by covering one column at a time.</p>

  <h2>Patterns That Help You Remember</h2>
  <p>You do not have to memorise every fact separately. Patterns do most of the work for you.</p>
  <ul>
    <li><strong>5s:</strong> Always end in 0 or 5. 5, 10, 15, 20, 25...</li>
    <li><strong>9s:</strong> The digits of every multiple add up to 9. 18 (1+8=9), 27 (2+7=9), 36 (3+6=9)...</li>
    <li><strong>11s:</strong> Up to 9x11, the digit just repeats. 11, 22, 33, 44, 55...</li>
    <li><strong>2s:</strong> Always even. Just double the number.</li>
    <li><strong>10s:</strong> Just add a zero. 10, 20, 30, 40...</li>
  </ul>

  <h2>The 9s Finger Trick</h2>
  <p>Hold out all ten fingers. To find 9 x N, fold down the Nth finger from the left. Count the fingers still up on the left side for the tens digit. Count the fingers still up on the right for the ones digit. For 9 x 4: fold down the 4th finger. You see 3 fingers left and 6 fingers right. Answer: 36.</p>
  <p>This works for 9 x 1 through 9 x 10. It is a fast mental trick that never fails.</p>

  <h2>Times Tables Reference (x1 to x10)</h2>
  <table class="ta-table">
    <thead><tr><th>Table</th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th></tr></thead>
    <tbody>
      <tr><td><strong>x2</strong></td><td>2</td><td>4</td><td>6</td><td>8</td><td>10</td><td>12</td><td>14</td><td>16</td><td>18</td><td>20</td></tr>
      <tr><td><strong>x3</strong></td><td>3</td><td>6</td><td>9</td><td>12</td><td>15</td><td>18</td><td>21</td><td>24</td><td>27</td><td>30</td></tr>
      <tr><td><strong>x4</strong></td><td>4</td><td>8</td><td>12</td><td>16</td><td>20</td><td>24</td><td>28</td><td>32</td><td>36</td><td>40</td></tr>
      <tr><td><strong>x5</strong></td><td>5</td><td>10</td><td>15</td><td>20</td><td>25</td><td>30</td><td>35</td><td>40</td><td>45</td><td>50</td></tr>
      <tr><td><strong>x6</strong></td><td>6</td><td>12</td><td>18</td><td>24</td><td>30</td><td>36</td><td>42</td><td>48</td><td>54</td><td>60</td></tr>
      <tr><td><strong>x7</strong></td><td>7</td><td>14</td><td>21</td><td>28</td><td>35</td><td>42</td><td>49</td><td>56</td><td>63</td><td>70</td></tr>
      <tr><td><strong>x8</strong></td><td>8</td><td>16</td><td>24</td><td>32</td><td>40</td><td>48</td><td>56</td><td>64</td><td>72</td><td>80</td></tr>
      <tr><td><strong>x9</strong></td><td>9</td><td>18</td><td>27</td><td>36</td><td>45</td><td>54</td><td>63</td><td>72</td><td>81</td><td>90</td></tr>
    </tbody>
  </table>

  <h2>From Multiplication to Division</h2>
  <p>Every multiplication fact gives you two division facts for free. If you know 6 x 7 = 42, you also know 42 / 7 = 6 and 42 / 6 = 7. This is why learning the times table helps with division too. The relationship runs both ways.</p>

  <h2>Tips for the Harder Facts</h2>
  <ul>
    <li><strong>6 x 6 = 36:</strong> Both 6s, answer starts with 3. Six six, thirty six.</li>
    <li><strong>6 x 7 = 42:</strong> Use 6 x 6 = 36 and add 6 to get 42.</li>
    <li><strong>7 x 7 = 49:</strong> Seven squared. Think of 7-Up becoming 49.</li>
    <li><strong>7 x 8 = 56:</strong> 5, 6, 7, 8. The answer contains the digits before the problem.</li>
    <li><strong>8 x 8 = 64:</strong> Eight eights, sixty four. Rhymes help.</li>
  </ul>

  </section>

<div class="tool-nav-row">
  <a href="/math-tools/roman-numeral-converter" class="tool-nav-card" style="--tnc-color:#007aff">
    <div class="tool-nav-icon"><i class="fa-solid fa-landmark"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Previous</div><div class="tool-nav-name">Roman Numeral Converter</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-left"></i></div>
  </a>
  <a href="/math-tools/equation-solver" class="tool-nav-card tool-nav-next" style="--tnc-color:#4ecdc4">
    <div class="tool-nav-icon"><i class="fa-solid fa-square-root-variable"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Next</div><div class="tool-nav-name">Equation Solver</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-right"></i></div>
  </a>
</div>

<div class="topic-quiz" id="tool-quiz">
  <div class="quiz-header" style="background:#f97316">
    <i class="fa-solid fa-circle-question"></i> Quick Quiz
    <span class="quiz-sub">3 questions</span>
  </div>
  <div class="quiz-body">
    <div class="quiz-q" data-qi="0" data-correct="1">
      <p class="quiz-question"><strong>Q1.</strong> What is 7 × 8?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">54</button>
        <button class="quiz-opt" data-oi="1">56</button>
        <button class="quiz-opt" data-oi="2">63</button>
        <button class="quiz-opt" data-oi="3">48</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="1" data-correct="1">
      <p class="quiz-question"><strong>Q2.</strong> What is 12 × 12?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">132</button>
        <button class="quiz-opt" data-oi="1">144</button>
        <button class="quiz-opt" data-oi="2">124</button>
        <button class="quiz-opt" data-oi="3">148</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="2" data-correct="1">
      <p class="quiz-question"><strong>Q3.</strong> Which of these is 9 × 6?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">45</button>
        <button class="quiz-opt" data-oi="1">54</button>
        <button class="quiz-opt" data-oi="2">63</button>
        <button class="quiz-opt" data-oi="3">48</button>
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
