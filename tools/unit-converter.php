<?php require_once __DIR__ . '/../config.php'; $page_title = 'Unit Converter'; $page_desc = 'Convert length, weight, temperature, volume and speed units instantly with live results.'; $body_class = 'page-article'; include __DIR__ . '/../_header.php'; ?>

<style>
.uc-page { background: #fff; min-height: 60vh; padding: 2rem 1rem; font-family: 'Segoe UI', sans-serif; border-radius: 16px; overflow: hidden; max-width: 900px; margin-left: auto; margin-right: auto; }
.uc-hero { text-align: center; margin-bottom: 2rem; }
.uc-hero h1 { color: #111827; font-size: 2.2rem; font-weight: 800; margin: 0; }
.uc-hero p { color: #6b7280; font-size: 1.05rem; margin-top: .4rem; }
.uc-main { max-width: 720px; margin: 0 auto; }
.uc-cats { display: flex; gap: .5rem; overflow-x: auto; padding-bottom: .3rem; margin-bottom: 1.5rem; scrollbar-width: none; }
.uc-cats::-webkit-scrollbar { display: none; }
.uc-cat-btn { display: flex; flex-direction: column; align-items: center; gap: .3rem; padding: .75rem 1.2rem; border: 2px solid #e5e7eb; border-radius: 14px; cursor: pointer; font-size: .75rem; font-weight: 700; color: #6b7280; background: #fff; transition: all .2s; white-space: nowrap; min-width: 72px; }
.uc-cat-btn i { font-size: 1.4rem; }
.uc-cat-btn.active { border-color: #6366f1; color: #6366f1; background: #eef2ff; box-shadow: 0 4px 12px #6366f122; }
.uc-cat-btn:hover:not(.active) { border-color: #6366f1; color: #6366f1; }
.uc-card { background: #fff; border: 1.5px solid #e5e7eb; border-radius: 20px; padding: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,.06); }
.uc-converter { display: grid; grid-template-columns: 1fr 60px 1fr; align-items: center; gap: 1rem; margin-bottom: 1.5rem; }
.uc-side { display: flex; flex-direction: column; gap: .6rem; }
.uc-side label { font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #6366f1; }
.uc-side input { font-size: 1.8rem; font-weight: 800; color: #111827; border: 2px solid #e5e7eb; border-radius: 12px; padding: .6rem 1rem; outline: none; transition: border-color .2s; width: 100%; box-sizing: border-box; }
.uc-side input:focus { border-color: #6366f1; box-shadow: 0 0 0 3px #6366f122; }
.uc-side select { font-size: .95rem; font-weight: 600; color: #374151; border: 2px solid #e5e7eb; border-radius: 10px; padding: .55rem .8rem; outline: none; background: #f9fafb; cursor: pointer; transition: border-color .2s; width: 100%; box-sizing: border-box; }
.uc-side select:focus { border-color: #6366f1; }
.swap-btn { width: 52px; height: 52px; background: linear-gradient(135deg, #6366f1, #4f46e5); border: none; border-radius: 50%; cursor: pointer; color: #fff; font-size: 1.2rem; display: flex; align-items: center; justify-content: center; transition: all .3s; box-shadow: 0 4px 14px #6366f144; align-self: center; margin-top: 1.6rem; }
.swap-btn:hover { transform: rotate(180deg) scale(1.1); box-shadow: 0 8px 20px #6366f166; }
.uc-visual { margin-top: 1.5rem; border-top: 1.5px solid #e5e7eb; padding-top: 1.5rem; }
.visual-ruler { display: flex; align-items: center; gap: 0; height: 40px; border-radius: 8px; overflow: hidden; border: 2px solid #6366f1; }
.ruler-filled { background: linear-gradient(90deg, #6366f1, #818cf8); height: 100%; transition: width .6s cubic-bezier(.4,0,.2,1); display: flex; align-items: center; justify-content: flex-end; padding-right: 8px; min-width: 0; }
.ruler-filled span { color: #fff; font-size: .75rem; font-weight: 700; white-space: nowrap; overflow: hidden; }
.ruler-empty { flex: 1; background: #f3f4f6; height: 100%; }
.ruler-label { display: flex; justify-content: space-between; font-size: .75rem; color: #9ca3af; margin-top: .4rem; }
.visual-title { font-size: .8rem; font-weight: 700; text-transform: uppercase; color: #6366f1; letter-spacing: .06em; margin-bottom: .6rem; }
.formula-box { background: #f5f3ff; border: 1.5px solid #ddd6fe; border-radius: 10px; padding: .75rem 1rem; margin-top: 1rem; font-size: .85rem; color: #4338ca; font-weight: 600; text-align: center; }
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
  <span>Unit Converter</span>
</nav>
<div class="tool-page-layout" style="max-width:1100px;width:100%;margin:0 auto;padding:24px 24px 48px;box-sizing:border-box;">
<div class="tool-nav-row">
  <a href="/math-tools/percentage-calculator" class="tool-nav-card" style="--tnc-color:#14b8a6">
    <div class="tool-nav-icon"><i class="fa-solid fa-percent"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Previous</div><div class="tool-nav-name">Percentage Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-left"></i></div>
  </a>
  <a href="/math-tools/geometry-calculator" class="tool-nav-card tool-nav-next" style="--tnc-color:#007aff">
    <div class="tool-nav-icon"><i class="fa-solid fa-shapes"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Next</div><div class="tool-nav-name">Geometry Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-right"></i></div>
  </a>
</div>
<div class="uc-page">
  <div class="uc-main">
    <div class="uc-hero">
      <h1>Unit Converter</h1>
    </div>

    <div class="uc-cats">
      <button class="uc-cat-btn active" data-cat="length"><i class="fa-solid fa-ruler"></i>Length</button>
      <button class="uc-cat-btn" data-cat="weight"><i class="fa-solid fa-weight-hanging"></i>Weight</button>
      <button class="uc-cat-btn" data-cat="temperature"><i class="fa-solid fa-temperature-half"></i>Temp</button>
      <button class="uc-cat-btn" data-cat="volume"><i class="fa-solid fa-flask"></i>Volume</button>
      <button class="uc-cat-btn" data-cat="speed"><i class="fa-solid fa-gauge-high"></i>Speed</button>
    </div>

    <div class="uc-card">
      <div class="uc-converter">
        <div class="uc-side">
          <label>From</label>
          <input type="number" id="valFrom" value="1" step="any">
          <select id="unitFrom"></select>
        </div>
        <button class="swap-btn" id="swapBtn" title="Swap units"><i class="fa-solid fa-arrows-left-right"></i></button>
        <div class="uc-side">
          <label>To</label>
          <input type="number" id="valTo" step="any" readonly style="background:#f9fafb; color:#6366f1;">
          <select id="unitTo"></select>
        </div>
      </div>
      <div class="uc-visual">
        <div class="visual-title" id="visualTitle">Visual Comparison</div>
        <div class="visual-ruler">
          <div class="ruler-filled" id="rulerFilled" style="width:50%"><span id="rulerFromLabel">1 m</span></div>
          <div class="ruler-empty"></div>
        </div>
        <div class="ruler-label"><span id="rulerMin">0</span><span id="rulerMax"></span></div>
        <div class="formula-box" id="formulaBox">Formula: multiply by 1</div>
      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const UNITS = {
    length: {
      units: ['meter','kilometer','centimeter','millimeter','mile','yard','foot','inch','nautical mile'],
      factors: { meter:1, kilometer:1e3, centimeter:0.01, millimeter:0.001, mile:1609.344, yard:0.9144, foot:0.3048, inch:0.0254, 'nautical mile':1852 },
      display: ['m','km','cm','mm','mi','yd','ft','in','nmi']
    },
    weight: {
      units: ['kilogram','gram','milligram','pound','ounce','ton (metric)','stone'],
      factors: { kilogram:1, gram:0.001, milligram:1e-6, pound:0.453592, ounce:0.0283495, 'ton (metric)':1000, stone:6.35029 },
      display: ['kg','g','mg','lb','oz','t','st']
    },
    temperature: {
      units: ['Celsius','Fahrenheit','Kelvin'],
      factors: null,
      display: ['°C','°F','K']
    },
    volume: {
      units: ['liter','milliliter','gallon (US)','quart (US)','pint (US)','cup (US)','fluid ounce (US)','cubic meter','tablespoon'],
      factors: { liter:1, milliliter:0.001, 'gallon (US)':3.78541, 'quart (US)':0.946353, 'pint (US)':0.473176, 'cup (US)':0.236588, 'fluid ounce (US)':0.0295735, 'cubic meter':1000, tablespoon:0.0147868 },
      display: ['L','mL','gal','qt','pt','cup','fl oz','m³','tbsp']
    },
    speed: {
      units: ['meters/second','kilometers/hour','miles/hour','feet/second','knots','mach'],
      factors: { 'meters/second':1, 'kilometers/hour':1/3.6, 'miles/hour':0.44704, 'feet/second':0.3048, knots:0.514444, mach:343 },
      display: ['m/s','km/h','mph','ft/s','kn','M']
    }
  };

  let currentCat = 'length';

  function convertTemp(val, from, to) {
    let celsius;
    if(from === 'Celsius') celsius = val;
    else if(from === 'Fahrenheit') celsius = (val - 32) * 5/9;
    else celsius = val - 273.15;
    if(to === 'Celsius') return celsius;
    if(to === 'Fahrenheit') return celsius * 9/5 + 32;
    return celsius + 273.15;
  }

  function populateSelects(cat) {
    const data = UNITS[cat];
    const from = document.getElementById('unitFrom');
    const to = document.getElementById('unitTo');
    from.innerHTML = ''; to.innerHTML = '';
    data.units.forEach((u, i) => {
      const opt1 = new Option(`${data.display[i]} - ${u}`, u);
      const opt2 = new Option(`${data.display[i]} - ${u}`, u);
      from.appendChild(opt1);
      to.appendChild(opt2);
    });
    from.selectedIndex = 0;
    to.selectedIndex = 1;
  }

  function convert() {
    const cat = currentCat;
    const data = UNITS[cat];
    const valFrom = parseFloat(document.getElementById('valFrom').value);
    const fromUnit = document.getElementById('unitFrom').value;
    const toUnit = document.getElementById('unitTo').value;

    if(isNaN(valFrom)) { document.getElementById('valTo').value = ''; return; }

    let result;
    if(cat === 'temperature') {
      result = convertTemp(valFrom, fromUnit, toUnit);
    } else {
      const inMeters = valFrom * data.factors[fromUnit];
      result = inMeters / data.factors[toUnit];
    }

    const precision = Math.abs(result) >= 1000 ? 2 : Math.abs(result) >= 1 ? 4 : 8;
    document.getElementById('valTo').value = parseFloat(result.toPrecision(precision));

    // Update visual
    const fromIdx = data.units.indexOf(fromUnit);
    const toIdx = data.units.indexOf(toUnit);
    const fromDisp = data.display[fromIdx] || fromUnit;
    const toDisp = data.display[toIdx] || toUnit;

    let ratio;
    if(cat === 'temperature') {
      ratio = 0.5;
    } else {
      const fromFactor = data.factors[fromUnit];
      const toFactor = data.factors[toUnit];
      ratio = fromFactor / (fromFactor + toFactor);
      ratio = Math.max(0.05, Math.min(0.95, ratio));
    }

    document.getElementById('rulerFilled').style.width = (ratio * 100) + '%';
    document.getElementById('rulerFromLabel').textContent = valFrom + ' ' + fromDisp;
    document.getElementById('rulerMax').textContent = parseFloat(result.toPrecision(4)) + ' ' + toDisp;

    let formula = '';
    if(cat === 'temperature') {
      if(fromUnit === 'Celsius' && toUnit === 'Fahrenheit') formula = '°F = °C × 9/5 + 32';
      else if(fromUnit === 'Fahrenheit' && toUnit === 'Celsius') formula = '°C = (°F − 32) × 5/9';
      else if(fromUnit === 'Celsius' && toUnit === 'Kelvin') formula = 'K = °C + 273.15';
      else if(fromUnit === 'Kelvin' && toUnit === 'Celsius') formula = '°C = K − 273.15';
      else formula = 'Conversion formula applied';
    } else {
      const factor = data.factors[fromUnit] / data.factors[toUnit];
      formula = `1 ${fromDisp} = ${parseFloat(factor.toPrecision(6))} ${toDisp}`;
    }
    document.getElementById('formulaBox').textContent = 'Formula: ' + formula;
  }

  document.querySelectorAll('.uc-cat-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.uc-cat-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      currentCat = btn.dataset.cat;
      populateSelects(currentCat);
      convert();
    });
  });

  document.getElementById('valFrom').addEventListener('input', convert);
  document.getElementById('unitFrom').addEventListener('change', convert);
  document.getElementById('unitTo').addEventListener('change', convert);

  document.getElementById('swapBtn').addEventListener('click', () => {
    const from = document.getElementById('unitFrom');
    const to = document.getElementById('unitTo');
    const fromVal = from.value, toVal = to.value;
    const inputVal = parseFloat(document.getElementById('valTo').value);
    from.value = toVal;
    to.value = fromVal;
    if(!isNaN(inputVal)) document.getElementById('valFrom').value = inputVal;
    convert();
  });

  populateSelects('length');
  convert();
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

  <h2>How to Use This Converter</h2>
  <p>Select a category at the top, such as Length, Weight, or Temperature. Then type your value in the left box and pick the unit you are converting from. Choose the unit you want on the right. The converted value appears instantly. Hit the swap button in the middle to reverse the conversion direction.</p>

  <h2>The Two Main Measurement Systems</h2>
  <p>Most countries use the metric system, also called SI (International System of Units). It is built on powers of 10, which makes it easy to work with. 1 kilometer is exactly 1,000 meters. 1 kilogram is exactly 1,000 grams. The pattern is consistent.</p>
  <p>The United States uses the US customary system. Its relationships are less tidy. There are 5,280 feet in a mile and 16 ounces in a pound. Scientists everywhere prefer metric because consistency matters in research. But knowing both systems is genuinely useful in everyday life.</p>

  <h2>Key Conversion Facts</h2>
  <table class="ta-table">
    <thead><tr><th>From</th><th>To</th><th>Multiply By</th></tr></thead>
    <tbody>
      <tr><td>1 inch</td><td>centimeters</td><td>2.54</td></tr>
      <tr><td>1 foot</td><td>centimeters</td><td>30.48</td></tr>
      <tr><td>1 mile</td><td>kilometers</td><td>1.609</td></tr>
      <tr><td>1 kilogram</td><td>pounds</td><td>2.205</td></tr>
      <tr><td>1 ounce</td><td>grams</td><td>28.35</td></tr>
      <tr><td>1 US gallon</td><td>liters</td><td>3.785</td></tr>
      <tr><td>0°C</td><td>Fahrenheit</td><td>= 32°F (freezing)</td></tr>
    </tbody>
  </table>

  <h2>How Unit Conversion Works</h2>
  <p>Every conversion comes down to one idea: multiply by a conversion factor. A conversion factor is a ratio that equals exactly 1. For example, 2.54 cm / 1 inch is a conversion factor because 1 inch and 2.54 cm are the same length.</p>
  <p>To convert 5 inches to centimeters, you multiply 5 inches by (2.54 cm / 1 inch). The inch units cancel out and you are left with 12.7 cm. This approach, called dimensional analysis, works for every unit in every category.</p>

  <h2>Common Mistakes to Avoid</h2>
  <ul>
    <li>Confusing kilograms and pounds. 1 kg is about 2.2 lbs, not 1 lb.</li>
    <li>Treating temperature conversion as a simple multiply. You must add or subtract an offset too.</li>
    <li>Dividing instead of multiplying when going the wrong direction. Use the swap button to be safe.</li>
    <li>Mixing up fluid ounces (volume) and ounces (weight). They measure different things.</li>
  </ul>

  </section>

<div class="tool-nav-row">
  <a href="/math-tools/percentage-calculator" class="tool-nav-card" style="--tnc-color:#14b8a6">
    <div class="tool-nav-icon"><i class="fa-solid fa-percent"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Previous</div><div class="tool-nav-name">Percentage Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-left"></i></div>
  </a>
  <a href="/math-tools/geometry-calculator" class="tool-nav-card tool-nav-next" style="--tnc-color:#007aff">
    <div class="tool-nav-icon"><i class="fa-solid fa-shapes"></i></div>
    <div class="tool-nav-text"><div class="tool-nav-dir">Next</div><div class="tool-nav-name">Geometry Calculator</div></div>
    <div class="tool-nav-arrow"><i class="fa-solid fa-chevron-right"></i></div>
  </a>
</div>

<div class="topic-quiz" id="tool-quiz">
  <div class="quiz-header" style="background:#22c55e">
    <i class="fa-solid fa-circle-question"></i> Quick Quiz
    <span class="quiz-sub">3 questions</span>
  </div>
  <div class="quiz-body">
    <div class="quiz-q" data-qi="0" data-correct="1">
      <p class="quiz-question"><strong>Q1.</strong> How many centimetres are in 1 metre?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">10</button>
        <button class="quiz-opt" data-oi="1">100</button>
        <button class="quiz-opt" data-oi="2">1000</button>
        <button class="quiz-opt" data-oi="3">1</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="1" data-correct="3">
      <p class="quiz-question"><strong>Q2.</strong> How many millilitres are in 1 litre?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">10</button>
        <button class="quiz-opt" data-oi="1">100</button>
        <button class="quiz-opt" data-oi="2">500</button>
        <button class="quiz-opt" data-oi="3">1000</button>
      </div>
      <div class="quiz-feedback" style="display:none"></div>
    </div>
    <div class="quiz-q" data-qi="2" data-correct="2">
      <p class="quiz-question"><strong>Q3.</strong> How many grams are in 1 kilogram?</p>
      <div class="quiz-options">
        <button class="quiz-opt" data-oi="0">100</button>
        <button class="quiz-opt" data-oi="1">500</button>
        <button class="quiz-opt" data-oi="2">1000</button>
        <button class="quiz-opt" data-oi="3">10000</button>
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
