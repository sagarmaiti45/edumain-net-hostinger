/* ================================================================
   EduMain - Calculator + Vault System
   ================================================================ */

// ── Calculator state ─────────────────────────────────────────────
let expr          = '';
let lastResult    = null;
let vaultMode     = false;
let vaultCode     = '';
let calcAngleMode = 'DEG';
let calcLastExpr  = '';

const display   = document.getElementById('calc-display');
const exprLine  = document.getElementById('calc-expr');
const toggleBtn = document.getElementById('vault-toggle'); // checkbox

function updateDisplay(val) { display.textContent = val === '' ? '0' : val; }
function updateExpr(val)    { exprLine.textContent = val; }

// ── Calculator functions ──────────────────────────────────────────
function calcDigit(d) {
  if (vaultMode) { enterVaultDigit(d); return; }
  if (lastResult !== null) { expr = d; lastResult = null; }
  else expr += d;
  updateDisplay(expr); updateExpr('');
}

function calcDot() {
  if (vaultMode) return;
  // Only add dot if last number doesn't already have one
  const parts = expr.split(/[+\-×÷]/);
  if (parts[parts.length - 1].includes('.')) return;
  expr += expr === '' ? '0.' : '.';
  updateDisplay(expr); lastResult = null;
}

function calcOp(op) {
  if (vaultMode) return;
  lastResult = null;
  if (expr === '' && op !== '-') return;
  // Replace trailing operator
  if (expr && '+-×÷'.includes(expr.slice(-1))) expr = expr.slice(0, -1);
  expr += op;
  updateDisplay(expr);
}

function calcParen(p) {
  if (vaultMode) return;
  lastResult = null;
  expr += p;
  updateDisplay(expr);
}

function calcConst(c) {
  if (vaultMode) return;
  lastResult = null;
  const val = c === 'Math.PI' ? '\u03C0' : 'e';
  expr += val;
  updateDisplay(expr);
}

function calcFn(fn) {
  if (vaultMode) return;
  const raw = expr === '' ? '0' : expr;
  try {
    const num = evalExpr(raw);
    if (isNaN(num)) { flashError(); return; }
    const x = num;
    const result = Function('"use strict"; var x = ' + x + '; return (' + fn + ');')();
    const rounded = roundResult(result);
    updateExpr(raw);
    updateDisplay(String(rounded));
    expr = String(rounded);
    lastResult = rounded;
  } catch(e) { flashError(); }
}

function calcTrig(name) {
  if (vaultMode) return;
  const raw = expr === '' ? '0' : expr;
  try {
    const num = evalExpr(raw);
    if (isNaN(num)) { flashError(); return; }
    const rad = calcAngleMode === 'RAD';
    let result;
    if (name === 'sin')  result = rad ? Math.sin(num)  : Math.sin(num * Math.PI / 180);
    else if (name === 'cos')  result = rad ? Math.cos(num)  : Math.cos(num * Math.PI / 180);
    else if (name === 'tan')  result = rad ? Math.tan(num)  : Math.tan(num * Math.PI / 180);
    else if (name === 'asin') result = rad ? Math.asin(num) : Math.asin(num) * 180 / Math.PI;
    else if (name === 'acos') result = rad ? Math.acos(num) : Math.acos(num) * 180 / Math.PI;
    else if (name === 'atan') result = rad ? Math.atan(num) : Math.atan(num) * 180 / Math.PI;
    else return;
    const rounded = roundResult(result);
    updateExpr(raw);
    updateDisplay(String(rounded));
    expr = String(rounded);
    lastResult = rounded;
  } catch(e) { flashError(); }
}

// Shift toggles DEG/RAD angle mode for the trig buttons above
function calcToggleShift() {
  if (vaultMode) return;
  calcAngleMode = calcAngleMode === 'DEG' ? 'RAD' : 'DEG';
  const btn = document.getElementById('cs-shift-btn');
  if (btn) btn.classList.toggle('active', calcAngleMode === 'RAD');
  const modeEl = document.getElementById('cs-angle-mode');
  if (modeEl) modeEl.textContent = calcAngleMode;
}

// Alpha recalls the last answer into the current expression (like a physical Ans key)
function calcAlphaAns() {
  if (vaultMode) return;
  if (lastResult === null && calcLastExpr === '') return;
  const ans = lastResult !== null ? String(lastResult) : expr;
  expr += ans;
  lastResult = null;
  updateDisplay(expr);
}

// Replay restores the last full expression (before it was evaluated) for editing
function calcReplay() {
  if (vaultMode) return;
  if (!calcLastExpr) return;
  expr = calcLastExpr;
  lastResult = null;
  updateDisplay(expr);
  updateExpr('');
}

function calcClear() {
  if (vaultMode) { vaultCode = ''; updateDisplay('0'); return; }
  expr = ''; lastResult = null;
  updateDisplay('0'); updateExpr('');
}

function calcBack() {
  if (vaultMode) {
    vaultCode = vaultCode.slice(0, -1);
    updateDisplay(vaultCode || '0');
    return;
  }
  lastResult = null;
  expr = expr.slice(0, -1);
  updateDisplay(expr || '0');
}

function calcEquals() {
  if (vaultMode) return;
  if (!expr) return;
  try {
    const result = evalExpr(expr);
    if (isNaN(result) || !isFinite(result)) { flashError(); return; }
    const rounded = roundResult(result);
    calcLastExpr = expr;
    updateExpr(expr + ' =');
    updateDisplay(String(rounded));
    expr = String(rounded);
    lastResult = rounded;
  } catch(e) { flashError(); }
}

function evalExpr(e) {
  // Replace display symbols with JS operators
  const safe = e
    .replace(/×/g, '*')
    .replace(/÷/g, '/')
    .replace(/\u03C0/g, 'Math.PI')
    .replace(/\be\b/g, 'Math.E')
    .replace(/[^0-9+\-*/.()%MathPIE\s]/g, '');
  return Function('"use strict"; return (' + safe + ')')();
}

function roundResult(n) {
  if (!isFinite(n)) return n;
  // Round to 10 significant digits to avoid float garbage
  return parseFloat(n.toPrecision(10));
}

function flashError() {
  const old = display.textContent;
  display.textContent = 'Error';
  display.classList.add('shake');
  setTimeout(() => {
    display.classList.remove('shake');
    if (vaultMode) updateDisplay(vaultCode || '0');
    else updateDisplay(expr || '0');
  }, 600);
  expr = ''; lastResult = null;
}

// ── Vault toggle (checkbox) ───────────────────────────────────────
toggleBtn.addEventListener('change', () => {
  vaultMode = toggleBtn.checked;
  vaultCode = '';
  if (!vaultMode) {
    updateDisplay(expr || '0');
  }
});
// Sync state in case the toggle was clicked before this listener was attached
// (can happen when main.js is still downloading while the page is already visible)
if (toggleBtn.checked) vaultMode = true;

function enterVaultDigit(d) {
  if (vaultCode.length >= 4) return;
  vaultCode += d;
  updateDisplay(vaultCode || '0');
  if (vaultCode.length === 4) {
    const capturedCode = vaultCode; // capture by value - avoids stale-ref if reset during the delay
    setTimeout(() => handleVaultCode(capturedCode), 120);
  }
}

// ── Custom vault unlock code (client-side only, localStorage - nothing is
// ever sent to a server) ───────────────────────────────────────────
function _vaultUnlockCode() {
  try {
    const v = localStorage.getItem('sc_vault_code');
    return (v && /^\d{4}$/.test(v)) ? v : '0000';
  } catch (e) { return '0000'; }
}
(function () {
  const btn = document.getElementById('vault-code-btn');
  const panel = document.getElementById('vault-code-panel');
  const input = document.getElementById('vault-code-input');
  const msg = document.getElementById('vault-code-panel-msg');
  const saveBtn = document.getElementById('vault-code-save');
  const resetBtn = document.getElementById('vault-code-reset');
  const cancelBtn = document.getElementById('vault-code-cancel');
  if (!btn || !panel || !input) return;

  function closePanel() { panel.style.display = 'none'; }
  btn.addEventListener('click', () => {
    input.value = '';
    msg.textContent = '';
    msg.className = 'vault-code-panel-msg';
    panel.style.display = 'flex';
    input.focus();
  });
  cancelBtn && cancelBtn.addEventListener('click', closePanel);
  panel.addEventListener('click', (e) => { if (e.target === panel) closePanel(); });
  input.addEventListener('input', function () {
    this.value = this.value.replace(/\D/g, '').slice(0, 4);
  });
  resetBtn && resetBtn.addEventListener('click', () => {
    try { localStorage.removeItem('sc_vault_code'); } catch (e) {}
    msg.textContent = 'Reset to 0000.';
    msg.className = 'vault-code-panel-msg ok';
  });
  saveBtn && saveBtn.addEventListener('click', () => {
    const v = (input.value || '').trim();
    if (!/^\d{4}$/.test(v)) {
      msg.textContent = 'Enter exactly 4 digits.';
      msg.className = 'vault-code-panel-msg';
      return;
    }
    try { localStorage.setItem('sc_vault_code', v); } catch (e) {}
    msg.textContent = 'Saved. Use ' + v + ' to open the vault from now on.';
    msg.className = 'vault-code-panel-msg ok';
  });
})();

function handleVaultCode(code) {
  const dataReady = window.VAULT_DATA && window.VAULT_DATA.length;

  if (code === _vaultUnlockCode()) {
    exitVaultMode();
    openVaultGrid();
    return;
  }

  if (dataReady) {
    // Fast path - data already cached, respond instantly
    const game = code !== '0000' ? window.VAULT_DATA.find(g => g.code === code) : null;
    if (game) {
      exitVaultMode();
      openVaultPlay(game);
    } else {
      display.classList.add('shake');
      display.textContent = '? ? ? ?';
      setTimeout(() => {
        display.classList.remove('shake');
        vaultCode = '';
        updateDisplay('0');
      }, 700);
    }
    return;
  }

  // Data not loaded yet - show overlay with skeleton immediately so user gets feedback
  exitVaultMode();
  overlay.classList.add('open');
  overlay.classList.remove('vault-in-play');
  overlay.style.display = 'flex';
  gridView.style.display = 'flex';
  playView.style.display = 'none';
  backBtn.style.display = 'none';
  if (sidebarToggleBtn) sidebarToggleBtn.style.display = '';
  searchInput.value = '';
  _renderSkeletonGrid();
  loadVaultData(function() {
    const game = code !== '0000' ? (window.VAULT_DATA || []).find(g => g.code === code) : null;
    if (game) {
      openVaultPlay(game);
    } else {
      closeVault();
    }
  });
}

function exitVaultMode() {
  vaultMode = false;
  vaultCode = '';
  toggleBtn.checked = false;
  updateDisplay(expr || '0');
}

// ── Keyboard support ──────────────────────────────────────────────
let _pointerLockJustReleased = false;
document.addEventListener('pointerlockchange', () => {
  if (!document.pointerLockElement) _pointerLockJustReleased = true;
  setTimeout(() => { _pointerLockJustReleased = false; }, 200);
});
document.addEventListener('keydown', (e) => {
  if (document.getElementById('vault-overlay').classList.contains('open')) {
    if (e.key === 'Escape') {
      if (document.fullscreenElement) { document.exitFullscreen().then(() => closeVault()); return; }
      // If iframe had pointer lock, Escape releases it first - don't close vault yet
      if (_pointerLockJustReleased) { _pointerLockJustReleased = false; return; }
      closeVault();
    }
    if ((e.key === 'f' || e.key === 'F') && fsBtn && fsBtn.style.display !== 'none') { fsBtn.click(); }
    return;
  }
  if (e.key >= '0' && e.key <= '9') calcDigit(e.key);
  else if (e.key === '.') calcDot();
  else if (e.key === '+') calcOp('+');
  else if (e.key === '-') calcOp('-');
  else if (e.key === '*') calcOp('×');
  else if (e.key === '/') { e.preventDefault(); calcOp('÷'); }
  else if (e.key === 'Enter' || e.key === '=') calcEquals();
  else if (e.key === 'Backspace') calcBack();
  else if (e.key === 'Escape') calcClear();
  else if (e.key === '(') calcParen('(');
  else if (e.key === ')') calcParen(')');
  else if (e.key === '%') calcOp('%');
});

// ── VAULT OVERLAY ────────────────────────────────────────────────
const overlay      = document.getElementById('vault-overlay');
const gridView     = document.getElementById('vault-grid-view');
const playView     = document.getElementById('vault-play-view');
const vaultGrid    = document.getElementById('vault-grid');
let vaultIframe    = document.getElementById('vault-iframe');
let _currentIframeGame = null;
const playTitle    = document.getElementById('vault-play-title');
const sidebarToggleBtn = document.getElementById('vault-sidebar-toggle');
const sideCardsL   = document.getElementById('vault-side-cards');
const sideCardsR   = document.getElementById('vault-side-cards-right');
const searchInput  = document.getElementById('vault-search');
const backBtn      = document.getElementById('vault-back-btn');
const closeBtn     = document.getElementById('vault-close-btn');
const fsBtn        = document.getElementById('vault-fs-btn');

// ── Vault sidebar collapse toggle ────────────────────────────────
(function() {
  var toggleBtn = document.getElementById('vault-sidebar-toggle');
  var sidebar   = document.querySelector('.vault-cat-sidebar');
  if (!toggleBtn || !sidebar) return;
  var SIDEBAR_KEY = 'vault-sidebar-collapsed';

  function applySidebarState(collapsed) {
    if (collapsed) {
      sidebar.classList.add('sidebar-collapsed');
      toggleBtn.setAttribute('title', 'Show sidebar');
    } else {
      sidebar.classList.remove('sidebar-collapsed');
      toggleBtn.setAttribute('title', 'Hide sidebar');
    }
  }

  applySidebarState(localStorage.getItem(SIDEBAR_KEY) !== '0');

  toggleBtn.addEventListener('click', function() {
    var collapsed = sidebar.classList.contains('sidebar-collapsed');
    localStorage.setItem(SIDEBAR_KEY, collapsed ? '0' : '1');
    applySidebarState(!collapsed);
  });
})();

// ── Vault theme toggle ────────────────────────────────────────────
(function() {
  var themeBtn = document.getElementById('vault-theme-btn');
  if (!themeBtn) return;
  var VAULT_THEME_KEY = 'vault-theme';

  function applyVaultTheme(theme) {
    if (theme === 'light') {
      overlay.classList.add('vault-light');
      themeBtn.textContent = 'Dark';
    } else {
      overlay.classList.remove('vault-light');
      themeBtn.textContent = 'Light';
    }
  }

  applyVaultTheme(localStorage.getItem(VAULT_THEME_KEY) || 'light');

  themeBtn.addEventListener('click', function() {
    var newTheme = overlay.classList.contains('vault-light') ? 'dark' : 'light';
    localStorage.setItem(VAULT_THEME_KEY, newTheme);
    applyVaultTheme(newTheme);
  });
})();

function _renderSkeletonGrid() {
  // Calculate how many cards fill the visible grid area
  var sidebar  = window.innerWidth > 900 ? 200 : 0;
  var gridW    = Math.max(300, window.innerWidth - sidebar);
  var cardW    = window.innerWidth <= 480 ? (gridW / 3) : (window.innerWidth <= 768 ? 130 : 150);
  var cols     = Math.max(3, Math.floor(gridW / cardW));
  var rowH     = window.innerWidth <= 768 ? (gridW / 3) : 128;
  var rows     = Math.max(3, Math.ceil((window.innerHeight - 50) / rowH));
  var count    = cols * rows;
  vaultGrid.innerHTML = Array(count).fill(0).map(function() {
    return '<div class="v-card v-card-skeleton"><div class="v-thumb"></div></div>';
  }).join('');
}

function openVaultGrid() {
  overlay.classList.add('open');
  overlay.classList.remove('vault-in-play');
  overlay.style.display = 'flex';
  overlay.removeAttribute('aria-hidden');
  gridView.style.display = 'flex';
  playView.style.display = 'none';
  backBtn.style.display = 'none';
  if (sidebarToggleBtn) sidebarToggleBtn.style.display = '';
  searchInput.value = '';
  if (window.VAULT_DATA && window.VAULT_DATA.length) {
    renderGrid(getItems());
  } else {
    _renderSkeletonGrid();
    loadVaultData(function() { renderGrid(getItems()); });
  }
}

function _renderTopGames() {
  var el = document.getElementById('vault-top-games');
  if (!el || el.childElementCount > 0) return;
  var _topCodes = ['1095','2007','1002','1063','1090','2535','1097','2165'];
  var _all = (window.VAULT_DATA || []);
  var games = _topCodes.map(function(c) { return _all.find(function(g) { return g.code === c; }); }).filter(Boolean);
  el.innerHTML = '<span class="vtg-label">Top 8</span>' + games.map(function(g, i) {
    return '<div class="vtg-avatar' + (i === 0 ? ' vtg-first' : '') + '" title="' + escHtml(g.name) + '" data-code="' + escHtml(g.code) + '">'
      + '<img src="' + escHtml(g.thumb) + '" alt="' + escHtml(g.name) + '" loading="lazy">'
      + '</div>';
  }).join('');
  el.querySelectorAll('.vtg-avatar').forEach(function(av) {
    av.addEventListener('click', function() {
      var game = (window.VAULT_DATA || []).find(function(g) { return g.code === av.dataset.code; });
      if (game) openVaultPlay(game);
    });
  });
}

var _vaultLoading = false;
var _vaultQueue = [];
function loadVaultData(cb) {
  if (window.VAULT_DATA && window.VAULT_DATA.length) { cb(); return; }
  _vaultQueue.push(cb);
  if (_vaultLoading) return;
  _vaultLoading = true;
  fetch('/api/vault.php')
    .then(function(r) { return r.json(); })
    .then(function(data) {
      window.VAULT_DATA = [{ code: '0000', name: 'All', iframe: '', thumb: '' }].concat(data);
      _renderTopGames();
      _vaultLoading = false;
      var q = _vaultQueue.splice(0); q.forEach(function(fn) { fn(); });
    })
    .catch(function() {
      _vaultLoading = false;
      var q = _vaultQueue.splice(0); q.forEach(function(fn) { fn(); });
    });
}

let _savedScrollTop = 0;
var _pendingGame = null;

function _showSplash(game) {
  var splash  = document.getElementById('vault-splash');
  var titleEl = document.getElementById('vault-splash-title');
  var img     = document.getElementById('vault-splash-thumb');
  var playBtn = document.getElementById('vault-splash-play-btn');
  if (!splash) return;
  if (titleEl) titleEl.textContent = game.name;
  if (img)     { img.src = game.thumb || ''; img.alt = game.name; }
  if (playBtn) playBtn.disabled = false;

  // Pick 3 thumbs for blurred background: current + 2 random others
  var bgThumbs = [game.thumb || ''];
  if (window.VAULT_DATA && window.VAULT_DATA.length > 1) {
    var pool = window.VAULT_DATA.filter(function(g) { return g.code !== game.code && g.thumb; });
    for (var i = pool.length - 1; i > 0; i--) {
      var j = Math.floor(Math.random() * (i + 1));
      var tmp = pool[i]; pool[i] = pool[j]; pool[j] = tmp;
    }
    bgThumbs = bgThumbs.concat(pool.slice(0, 2).map(function(g) { return g.thumb; }));
  }
  ['vsb-img-1', 'vsb-img-2', 'vsb-img-3'].forEach(function(id, idx) {
    var el = document.getElementById(id);
    if (el) el.src = bgThumbs[idx] || bgThumbs[0] || '';
  });

  splash.classList.add('active');
  vaultIframe.style.display = 'none';
  if (fsBtn) fsBtn.style.display = 'none';

}

function _hideSplash() {
  var splash = document.getElementById('vault-splash');
  if (!splash) return;
  splash.classList.remove('active');
}

function _hideSplashAndLaunch() {
  _hideSplash();
  var adLoader = document.getElementById('vault-ad-loader');
  if (adLoader) adLoader.classList.remove('active');
  if (!_pendingGame) return;
  var game = _pendingGame;
  _pendingGame = null;
  _currentIframeGame = game;
  vaultIframe.style.display = '';
  vaultIframe.referrerPolicy = (game.iframe.startsWith('https://mathlibassets.calcmath.net') || game.iframe.includes('wgplayground.com')) ? 'origin' : 'no-referrer';
  vaultIframe.onload = function() { vaultIframe.focus(); vaultLoaderComplete(); };
  vaultIframe.src = game.iframe;
  if (fsBtn) fsBtn.style.display = '';
  vaultLoaderStart();
}

// Fire-and-forget play counter for the admin panel. keepalive lets it survive
// the game taking over the tab, and every failure is swallowed - a counter
// must never get in the way of launching a game.
function _trackPlay() {}

function openVaultPlay(game, fromGrid) {
  // Project I.G.I. needs a cross-origin-isolated page. The first click reloads the site (served
  // isolated); there the vault opens straight into the normal game screen and runs it in the frame.
  var _IGI = '5232';
  if (game && game.code === _IGI && !window.crossOriginIsolated) {
    if (typeof _trackPlay === 'function') _trackPlay(game.code);
    // One-shot cookie (the server serves the next load of / isolated and clears it): no URL parameter.
    document.cookie = 'sc_igi=1; Max-Age=60; Path=/; SameSite=Lax';
    window.location.assign('/?')   /* '/?' skips the browser's cached copy of '/' (it is cached for hours); the bare '?' is removed again once the page is up */;
    return;
  }
  _trackPlay(game && game.code);
  const mainArea = document.querySelector('.vault-main-area');
  if (mainArea) _savedScrollTop = mainArea.scrollTop;
  overlay.classList.add('open');
  overlay.style.display = 'flex';
  overlay.removeAttribute('aria-hidden');
  overlay.classList.add('vault-in-play');
  gridView.style.display = 'none';
  playView.style.display = 'flex';
  const sideL = document.getElementById('vault-sidebar');
  const sideR = document.getElementById('vault-sidebar-right');
  if (sidebarToggleBtn) sidebarToggleBtn.style.display = 'none';
  if (fromGrid) {
    backBtn.style.display = 'inline-flex';
    if (sideL) sideL.style.display = '';
    if (sideR) sideR.style.display = '';
    const others = getItems().filter(g => g.code !== game.code).sort(() => Math.random() - 0.5);
    sideCardsL.innerHTML = others.slice(0, 8).map(g => sideCardHTML(g)).join('');
    sideCardsR.innerHTML = others.slice(8, 16).map(g => sideCardHTML(g)).join('');
  } else {
    backBtn.style.display = 'none';
    if (sideL) sideL.style.display = 'none';
    if (sideR) sideR.style.display = 'none';
  }

  // Replace iframe element (no src yet - loaded after ad completes)
  const oldFrame = document.getElementById('vault-iframe');
  const newFrame = document.createElement('iframe');
  newFrame.id = 'vault-iframe';
  newFrame.allow = 'autoplay; fullscreen; gamepad';
  if (game && game.code === _IGI) {
    newFrame.allow += '; cross-origin-isolated; accelerometer; gyroscope';
    newFrame.removeAttribute('credentialless'); try { newFrame.credentialless = false; } catch (e) {}
  }
  newFrame.style.display = 'none';
  oldFrame.parentNode.replaceChild(newFrame, oldFrame);
  vaultIframe = newFrame;

  // Store game and show splash screen
  _pendingGame = game;
  _showSplash(game);

  playTitle.textContent = game.name;
  // Sync play-view fav button
  const pfb = document.getElementById('vault-play-fav-btn');
  if (pfb) {
    pfb.dataset.code = game.code;
    const on = _favs.has(game.code);
    pfb.classList.toggle('active', on);
    pfb.querySelector('i').className = on ? 'fa-solid fa-heart' : 'fa-regular fa-heart';
  }
}

function _restorePlaySidebars() {
  const sideL = document.getElementById('vault-sidebar');
  const sideR = document.getElementById('vault-sidebar-right');
  if (sideL) sideL.style.display = '';
  if (sideR) sideR.style.display = '';
}

function closeVault() {
  // I.G.I. session: leaving the vault returns to the normal (non-isolated) site.
  if (window.__igiSession) { window.location.replace('/'); return; }
  _restorePlaySidebars();
  _hideSplash();
  _pendingGame = null;
  overlay.classList.remove('open', 'ios-fs');
  overlay.style.display = 'none';
  overlay.setAttribute('aria-hidden', 'true');
  vaultIframe.src = '';
  vaultIframe.style.display = '';
  const exitBtn = document.getElementById('vault-ios-exit-btn');
  if (exitBtn) exitBtn.remove();
  const header = overlay.querySelector('.vault-frame-header');
  if (header) header.style.display = '';
}

// ── Favourites ────────────────────────────────────────────────────
const FAV_KEY = 'sc_game_favs';
let _favs = new Set(JSON.parse(localStorage.getItem(FAV_KEY) || '[]'));

function _saveFavs() {
  localStorage.setItem(FAV_KEY, JSON.stringify([..._favs]));
  _updateFavCounts();
}

function _updateFavCounts() {
  const n = _favs.size;
  const topCount = document.getElementById('vault-fav-count');
  const sideCount = document.getElementById('vault-fav-count-side');
  if (topCount)  { topCount.textContent = n;  topCount.style.display  = n ? 'inline-flex' : 'none'; }
  if (sideCount) { sideCount.textContent = n; sideCount.style.display = n ? 'inline-flex' : 'none'; }
}

function toggleFav(code) {
  if (_favs.has(code)) _favs.delete(code); else _favs.add(code);
  _saveFavs();
  // Update all heart buttons for this game currently in the grid
  document.querySelectorAll(`.v-fav-btn[data-fav="${code}"]`).forEach(btn => {
    btn.classList.toggle('active', _favs.has(code));
    btn.querySelector('i').className = _favs.has(code) ? 'fa-solid fa-heart' : 'fa-regular fa-heart';
    btn.classList.remove('pop');
    void btn.offsetWidth; // reflow to restart animation
    btn.classList.add('pop');
  });
  // Sync play-view fav button if it matches
  const pfb = document.getElementById('vault-play-fav-btn');
  if (pfb && pfb.dataset.code === code) {
    pfb.classList.toggle('active', _favs.has(code));
    pfb.querySelector('i').className = _favs.has(code) ? 'fa-solid fa-heart' : 'fa-regular fa-heart';
  }
  // If currently viewing favourites, re-render
  const activeLink = document.querySelector('.vault-cat-link.active');
  if (activeLink && activeLink.dataset.cat === '__favs__') renderGrid(getItems());
}

_updateFavCounts();

// Favourites topbar button - toggle favs / all
(function() {
  var btn = document.getElementById('vault-fav-btn');
  if (!btn) return;
  btn.addEventListener('click', function() {
    var favLink = document.getElementById('vault-fav-cat');
    if (!favLink) return;
    var isActive = favLink.classList.contains('active');
    if (isActive) {
      // Toggle back to All
      document.querySelectorAll('.vault-cat-link').forEach(l => l.classList.remove('active'));
      var allLink = document.querySelector('.vault-cat-link[data-cat=""]');
      if (allLink) allLink.classList.add('active');
      btn.classList.remove('active');
      loadVaultData(function() { renderGrid(getItems()); });
    } else {
      document.querySelectorAll('.vault-cat-link').forEach(l => l.classList.remove('active'));
      favLink.classList.add('active');
      btn.classList.add('active');
      loadVaultData(function() { renderGrid(getItems()); });
    }
    overlay.classList.remove('vault-in-play');
    gridView.style.display = 'flex';
    playView.style.display = 'none';
    backBtn.style.display = 'none';
  });
})();

function getItems() {
  const all = (window.VAULT_DATA || []).filter(g => g.code !== '0000');
  const activeLink = document.querySelector('.vault-cat-link.active');
  const cat = activeLink ? activeLink.dataset.cat : '';
  if (cat === '__favs__') return all.filter(g => _favs.has(g.code));
  let items = cat ? all.filter(g => g.category === cat) : all;
  return items;
}

function escHtml(s) {
  return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

// ── Infinite-scroll grid ──────────────────────────────────────────
const GRID_PAGE = 40;          // cards per batch
let _gridGames  = [];          // full filtered list
let _gridOffset = 0;           // how many have been rendered
let _gridSentinel = null;      // IntersectionObserver target
let _gridObserver = null;      // the observer
let _imgObserver  = null;      // lazy-image observer (uses scroll container as root)
function _initImgObserver() {
  if (_imgObserver) _imgObserver.disconnect();
  const scrollRoot = document.querySelector('.vault-main-area');
  _imgObserver = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        const img = e.target;
        img.src = img.dataset.src;
        _imgObserver.unobserve(img);
      }
    });
  }, { root: scrollRoot, rootMargin: '500px 0px' });
}

function _cardHTML(g, idx) {
  const eager = idx < 20;
  const imgAttr = eager
    ? `src="${escHtml(g.thumb)}" fetchpriority="${idx < 8 ? 'high' : 'auto'}"`
    : `data-src="${escHtml(g.thumb)}"`;
  const isFav = _favs.has(g.code);
  return `<div class="v-card" data-code="${escHtml(g.code)}">
    <div class="v-thumb">
      <img ${imgAttr} alt="${escHtml(g.name)}" onload="this.classList.add('loaded');this.parentElement.classList.add('loaded')" onerror="this.style.display='none'">
      <button class="v-fav-btn${isFav ? ' active' : ''}" data-fav="${escHtml(g.code)}" aria-label="Favourite"><i class="fa-${isFav ? 'solid' : 'regular'} fa-heart"></i></button>
      <div class="v-card-overlay"><div class="v-play-btn">
        <svg fill="currentColor" viewBox="0 0 24 24"><path d="M5 3l14 9-14 9V3z"/></svg>
      </div></div>
      <div class="v-card-info"><h3 class="v-card-name">${escHtml(g.name)}</h3></div>
    </div>
  </div>`;
}

function _appendBatch() {
  if (_gridOffset >= _gridGames.length) {
    if (_gridSentinel) { _gridSentinel.remove(); _gridSentinel = null; }
    return;
  }
  const startIdx = _gridOffset;
  const batch = _gridGames.slice(_gridOffset, _gridOffset + GRID_PAGE);
  _gridOffset += batch.length;
  const frag = document.createDocumentFragment();
  batch.forEach((g, i) => {
    const globalIdx = startIdx + i;
    const div = document.createElement('div');
    div.innerHTML = _cardHTML(g, globalIdx);
    frag.appendChild(div.firstChild);
  });
  // Remove old sentinel before appending batch
  if (_gridSentinel) _gridSentinel.remove();
  vaultGrid.appendChild(frag);
  // Observe new images for lazy loading
  vaultGrid.querySelectorAll('img[data-src]:not([src])').forEach(img => _imgObserver.observe(img));
  // Add sentinel if more to load
  if (_gridOffset < _gridGames.length) {
    _gridSentinel = document.createElement('div');
    _gridSentinel.className = 'vault-grid-sentinel';
    vaultGrid.appendChild(_gridSentinel);
    _gridObserver.observe(_gridSentinel);
  }
}

function _initGridObserver() {
  if (_gridObserver) _gridObserver.disconnect();
  _gridObserver = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        _gridObserver.unobserve(e.target);
        _appendBatch();
      }
    });
  }, { rootMargin: '300px 0px' });
}



function renderGrid(games) {
  _initGridObserver();
  _initImgObserver();
  _gridGames  = games;
  _gridOffset = 0;
  vaultGrid.innerHTML = '';
  _gridSentinel = null;
  if (!games.length) {
    vaultGrid.innerHTML = '<p class="v-card-empty">No results found.</p>';
    return;
  }
  _appendBatch();
  // Load a second batch immediately so the full viewport is filled on first render
  if (_gridOffset < _gridGames.length) _appendBatch();
}

function sideCardHTML(g) {
  return `<div class="vault-side-card" data-code="${escHtml(g.code)}">
    <div class="vault-side-thumb" style="background-image:url('${escHtml(g.thumb)}')"></div>
    <div class="vault-side-info"><span class="vault-side-title">${escHtml(g.name)}</span></div>
  </div>`;
}

// Event delegation for grid clicks
vaultGrid.addEventListener('click', e => {
  // Heart toggle
  const favBtn = e.target.closest('.v-fav-btn');
  if (favBtn) { e.stopPropagation(); toggleFav(favBtn.dataset.fav); return; }
  const card = e.target.closest('.v-card');
  if (!card) return;
  const game = (window.VAULT_DATA || []).find(g => g.code === card.dataset.code);
  if (game) openVaultPlay(game, true);
});

// Event delegation for side card clicks
[sideCardsL, sideCardsR].forEach(el => {
  el.addEventListener('click', e => {
    const card = e.target.closest('.vault-side-card');
    if (!card) return;
    const game = (window.VAULT_DATA || []).find(g => g.code === card.dataset.code);
    if (game) openVaultPlay(game, true);
  });
});

// Category sidebar links
document.querySelectorAll('.vault-cat-link').forEach(link => {
  link.addEventListener('click', e => {
    e.preventDefault();
    document.querySelectorAll('.vault-cat-link').forEach(l => l.classList.remove('active'));
    link.classList.add('active');
    renderGrid(getItems());
  });
});

// Vault controls
document.getElementById('vault-frame-back-btn').addEventListener('click', () => backBtn.click());
backBtn.addEventListener('click', () => {
  _hideSplash();
  _pendingGame = null;
  overlay.classList.remove('vault-in-play');
  playView.style.display = 'none';
  gridView.style.display = 'flex';
  backBtn.style.display  = 'none';
  if (sidebarToggleBtn) sidebarToggleBtn.style.display = '';
  vaultIframe.src = '';
  vaultIframe.style.display = '';
  requestAnimationFrame(() => {
    const mainArea = document.querySelector('.vault-main-area');
    if (mainArea) mainArea.scrollTop = _savedScrollTop;
  });
});

closeBtn.addEventListener('click', closeVault);

// Play-view fav button
(function() {
  const pfb = document.getElementById('vault-play-fav-btn');
  if (!pfb) return;
  pfb.addEventListener('click', function() {
    const code = pfb.dataset.code;
    if (!code) return;
    toggleFav(code);
    pfb.classList.remove('pop');
    void pfb.offsetWidth;
    pfb.classList.add('pop');
  });
})();

var _escHint  = document.getElementById('vault-esc-hint');
var _escClose = document.getElementById('vault-esc-close');
if (_escHint && localStorage.getItem('sc_esc_hint_dismissed') === '1') _escHint.style.display = 'none';
if (_escClose) _escClose.addEventListener('click', function() {
  if (_escHint) _escHint.style.display = 'none';
  localStorage.setItem('sc_esc_hint_dismissed', '1');
});

const _isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) ||
               (navigator.maxTouchPoints > 1 && /Mac/.test(navigator.platform));

function _iosFakeFS(overlay) {
  const header = overlay.querySelector('.vault-frame-header');
  let exitBtn = document.getElementById('vault-ios-exit-btn');
  if (overlay.classList.contains('ios-fs')) {
    overlay.classList.remove('ios-fs');
    if (header) header.style.display = '';
    if (exitBtn) exitBtn.remove();
  } else {
    overlay.classList.add('ios-fs');
    if (header) header.style.display = 'none';
    exitBtn = document.createElement('button');
    exitBtn.id = 'vault-ios-exit-btn';
    exitBtn.textContent = '⛶';
    exitBtn.title = 'Exit Fullscreen';
    exitBtn.style.cssText = 'position:fixed;top:max(10px,env(safe-area-inset-top,10px));right:10px;z-index:99999;background:rgba(0,0,0,0.65);color:#fff;border:1px solid rgba(255,255,255,0.25);border-radius:8px;padding:6px 10px;font-size:1rem;cursor:pointer;touch-action:manipulation;';
    exitBtn.addEventListener('click', () => _iosFakeFS(overlay));
    overlay.appendChild(exitBtn);
  }
}

if (fsBtn) fsBtn.addEventListener('click', () => {
  const frame = document.getElementById('vault-iframe');
  if (_isIOS) {
    _iosFakeFS(document.getElementById('vault-overlay'));
  } else if (frame && frame.requestFullscreen) {
    // Focus the iframe afterwards: going fullscreen leaves keyboard focus on
    // this button, so key presses never reach the game until the player clicks.
    frame.requestFullscreen().then(function(){ _focusFrame(frame); }, function(){});
  } else if (frame && frame.webkitRequestFullscreen) {
    frame.webkitRequestFullscreen();
    setTimeout(function(){ _focusFrame(frame); }, 80);
  }
});

function _focusFrame(frame) {
  if (!frame) return;
  try {
    frame.focus();
    // cross-origin games can't be reached into, but focusing their window works
    if (frame.contentWindow) frame.contentWindow.focus();
  } catch (e) {}
}

// covers Esc-exit and any browser-initiated fullscreen change too
document.addEventListener('fullscreenchange', function () {
  if (document.fullscreenElement) _focusFrame(document.getElementById('vault-iframe'));
});

// Top loader bar for iframe navigation
var _loaderTimer = null;
var _loaderEl = (function() {
  var el = document.createElement('div');
  el.id = 'vault-loader-bar';
  var inner = document.createElement('div');
  inner.id = 'vault-loader-fill';
  el.appendChild(inner);
  var header = document.querySelector('.vault-frame-header');
  if (header) header.appendChild(el);
  return inner;
})();

function vaultLoaderStart() {
  if (!_loaderEl) return;
  clearTimeout(_loaderTimer);
  _loaderEl.parentElement.classList.remove('vault-loader-done');
  _loaderEl.style.transition = 'none';
  _loaderEl.style.width = '0%';
  _loaderEl.parentElement.style.opacity = '1';
  requestAnimationFrame(function() {
    requestAnimationFrame(function() {
      _loaderEl.style.transition = 'width 8s cubic-bezier(0.1, 0.5, 0.3, 1)';
      _loaderEl.style.width = '85%';
    });
  });
}

function vaultLoaderComplete() {
  if (!_loaderEl) return;
  clearTimeout(_loaderTimer);
  _loaderEl.style.transition = 'width 0.2s ease';
  _loaderEl.style.width = '100%';
  _loaderTimer = setTimeout(function() {
    _loaderEl.parentElement.style.opacity = '0';
    _loaderEl.style.width = '0%';
  }, 300);
}


// Search
const searchClear = document.getElementById('vault-search-clear');

function updateSearchClear() {
  searchClear.style.display = searchInput.value ? 'block' : 'none';
}

searchClear.addEventListener('click', () => {
  searchInput.value = '';
  updateSearchClear();
  renderGrid(getItems());
  searchInput.focus();
});

let searchTimer;
searchInput.addEventListener('input', () => {
  updateSearchClear();
  clearTimeout(searchTimer);
  searchTimer = setTimeout(() => {
    if (playView.style.display === 'none' || playView.style.display === '') renderGrid(filterItems(searchInput.value));
  }, 180);
});

searchInput.addEventListener('keydown', (e) => {
  if (e.key === 'Enter' && playView.style.display === 'flex') {
    overlay.classList.remove('vault-in-play');
    playView.style.display = 'none';
    gridView.style.display = 'flex';
    backBtn.style.display = 'none';
    if (sidebarToggleBtn) sidebarToggleBtn.style.display = '';
    vaultIframe.src = '';
    renderGrid(filterItems(searchInput.value));
  }
});

function filterItems(q) {
  if (!q) return getItems();
  const lq = q.toLowerCase();
  return getItems().filter(g =>
    g.name.toLowerCase().includes(lq) || g.code.includes(lq)
  );
}


// Prefetch vault data in the background so it's ready when the user opens the vault
(window.requestIdleCallback || function(fn){ setTimeout(fn, 800); })(function() {
  loadVaultData(function() {});
});

// ── Secret Codes Feature ──────────────────────────────────────────
(function() {
  var codesTab    = document.getElementById('vault-codes-tab');
  var codesPanel  = document.getElementById('vault-codes-panel');
  var codesList   = document.getElementById('codes-list');
  var codesSearch = document.getElementById('codes-search');
  if (!codesTab) return;

  function renderCodesList(filter) {
    var games = (window.VAULT_DATA || []).filter(function(g) { return g.code !== '0000'; });
    if (filter) {
      var lf = filter.toLowerCase();
      games = games.filter(function(g) { return g.name.toLowerCase().includes(lf) || g.code.includes(lf); });
    }
    if (!games.length) {
      codesList.innerHTML = '<div class="codes-empty">No games found.</div>';
      return;
    }
    codesList.innerHTML = games.map(function(g) {
      return '<div class="codes-row" data-code="' + g.code + '">'
        + '<img class="codes-thumb" src="' + escHtml(g.thumb) + '" alt="" loading="lazy">'
        + '<span class="codes-name">' + escHtml(g.name) + '</span>'
        + '<span class="codes-code">' + g.code + '</span>'
        + '</div>';
    }).join('');
    codesList.querySelectorAll('.codes-row').forEach(function(row) {
      row.addEventListener('click', function() {
        openVaultPlay((window.VAULT_DATA || []).find(function(g) { return g.code === row.dataset.code; }));
      });
    });
  }

  function showCodesPanel() {
    document.getElementById('vault-grid').style.display = 'none';
    codesPanel.style.display = 'flex';
    codesTab.classList.add('active');
    document.querySelectorAll('.vault-cat-link:not(#vault-codes-tab)').forEach(function(l) { l.classList.remove('active'); });
    loadVaultData(function() { renderCodesList(codesSearch.value); });
  }

  function hideCodesPanel() {
    document.getElementById('vault-grid').style.display = '';
    codesPanel.style.display = 'none';
    codesTab.classList.remove('active');
    document.querySelectorAll('.vault-cat-link').forEach(function(l) {
      l.classList.toggle('active', l.dataset.cat === '');
    });
    renderGrid(getItems());
  }

  codesTab.addEventListener('click', function(e) {
    e.preventDefault();
    if (codesPanel.style.display === 'none') showCodesPanel();
    else hideCodesPanel();
  });

  codesSearch.addEventListener('input', function() {
    renderCodesList(codesSearch.value);
  });

  document.querySelectorAll('.vault-cat-link:not(#vault-codes-tab)').forEach(function(link) {
    link.addEventListener('click', function() {
      if (codesPanel.style.display !== 'none') hideCodesPanel();
    });
  });

  document.getElementById('vault-close-btn').addEventListener('click', hideCodesPanel);
})();

// Project I.G.I. could not start (a browser without cross-origin isolation, or a stale cached page): say so instead of silently showing the homepage.
(function () {
  var failed = window.__IGI_FAILED || (/(?:^|;\s*)sc_igi=1(?:;|$)/.test(document.cookie) && !window.crossOriginIsolated);
  if (!failed) return;
  try { document.cookie = 'sc_igi=; Max-Age=0; Path=/; SameSite=Lax'; history.replaceState(null, '', location.pathname); } catch (e) {}
  function show() {
    var d = document.createElement('div');
    d.setAttribute('role', 'status');
    d.style.cssText = 'position:fixed;left:50%;top:16px;transform:translateX(-50%);z-index:2147483600;max-width:min(92vw,520px);padding:12px 18px;border-radius:12px;background:#0f172a;color:#e2e8f0;font:600 15px/1.4 system-ui,sans-serif;box-shadow:0 8px 28px rgba(0,0,0,.35);text-align:center';
    d.textContent = 'Project I.G.I. needs a recent Chrome or Edge on a computer. Open this site there to play it.';
    document.body.appendChild(d);
    setTimeout(function () { d.remove(); }, 14000);
  }
  if (document.body) show(); else document.addEventListener('DOMContentLoaded', show);
})();

// Project I.G.I. session (the server serves / isolated for one load after the card sets its cookie): open the vault straight into the game screen.
(function () {
  if (!window.crossOriginIsolated || !window.__IGI_SESSION) return;
  try { history.replaceState(null, '', location.pathname); } catch (e) {}
  function go() {
    loadVaultData(function () {
      var g = (window.VAULT_DATA || []).find(function (x) { return x.code === '5232'; });
      if (!g) return;
      openVaultGrid();
      openVaultPlay(g, true);
      window.__igiSession = true;
      // Uncover the page: the splash screen is showing.
      document.documentElement.classList.remove('igi-boot');
      // The vault's normal splash screen (with its Start button) stays up, exactly like every other game.
    });
  }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', go); else go();
})();
