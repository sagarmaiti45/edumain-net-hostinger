/* ================================================================
   EduMain - Main JS
   ================================================================ */

// ── Mobile nav sidebar ────────────────────────────────────────────
(function() {
  var menuBtn  = document.getElementById('mob-menu-btn');
  var closeBtn = document.getElementById('mob-nav-close');
  var nav      = document.getElementById('mob-nav');
  var overlay  = document.getElementById('mob-overlay');
  if (!menuBtn || !nav || !overlay) return;

  function openMobNav() {
    nav.classList.add('open');
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
  }
  function closeMobNav() {
    nav.classList.remove('open');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
  }

  menuBtn.addEventListener('click', openMobNav);
  if (closeBtn) closeBtn.addEventListener('click', closeMobNav);
  overlay.addEventListener('click', closeMobNav);
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && nav.classList.contains('open')) closeMobNav();
  });
})();

// ── Escape key closes vault ───────────────────────────────────────
var _pointerLockJustReleased = false;
document.addEventListener('pointerlockchange', function() {
  if (!document.pointerLockElement) {
    _pointerLockJustReleased = true;
    setTimeout(function() { _pointerLockJustReleased = false; }, 200);
  }
});
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape' && document.getElementById('vault-overlay').classList.contains('open')) {
    if (document.fullscreenElement) { document.exitFullscreen().then(function() { closeVault(); }); return; }
    if (_pointerLockJustReleased) { _pointerLockJustReleased = false; return; }
    closeVault();
  }
});

// ── Quiz option triple-click → open vault ────────────────────────
// Count any 3 rapid clicks/touches on any .quiz-opt (same or different)
(function() {
  var _count = 0;
  var _timer = null;
  function _onQuizHit() {
    _count++;
    clearTimeout(_timer);
    _timer = setTimeout(function() { _count = 0; }, 700);
    if (_count >= 3) {
      _count = 0;
      clearTimeout(_timer);
      openVaultGrid();
    }
  }
  // pointerdown works on both mouse and touch, fires on disabled buttons
  document.addEventListener('pointerdown', function(e) {
    if (e.target.closest('.quiz-opt')) _onQuizHit();
  });
})();

// ── VAULT OVERLAY ────────────────────────────────────────────────
const overlay          = document.getElementById('vault-overlay');
const gridView         = document.getElementById('vault-grid-view');
const playView         = document.getElementById('vault-play-view');
const vaultGrid        = document.getElementById('vault-grid');
let   vaultIframe      = document.getElementById('vault-iframe');
let   _currentIframeGame = null;
const playTitle        = document.getElementById('vault-play-title');
const sidebarToggleBtn = document.getElementById('vault-sidebar-toggle');
const sideCardsL       = document.getElementById('vault-side-cards');
const sideCardsR       = document.getElementById('vault-side-cards-right');
const searchInput      = document.getElementById('vault-search');
const backBtn          = document.getElementById('vault-back-btn');
const closeBtn         = document.getElementById('vault-close-btn');
const fsBtn            = document.getElementById('vault-fs-btn');

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
  vaultGrid.innerHTML = Array(24).fill(0).map(function(_, i) {
    var featured = (i === 2 || i === 10) ? ' v-card-featured' : '';
    return '<div class="v-card v-card-skeleton' + featured + '"><div class="v-thumb"></div></div>';
  }).join('');
}

function openVaultGrid() {
  overlay.classList.add('open');
  overlay.classList.remove('vault-in-play');
  overlay.style.display = 'flex';
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

var _savedScrollTop = 0;

function openVaultPlay(game, fromGrid) {
  const mainArea = document.querySelector('.vault-main-area');
  if (mainArea) _savedScrollTop = mainArea.scrollTop;
  overlay.classList.add('open');
  overlay.style.display = 'flex';
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
  _currentIframeGame = game;
  const oldFrame = document.getElementById('vault-iframe');
  const newFrame = document.createElement('iframe');
  newFrame.id = 'vault-iframe';
  newFrame.setAttribute('allowfullscreen', '');
  newFrame.allow = 'autoplay; fullscreen; gamepad';
  newFrame.referrerPolicy = 'no-referrer';
  newFrame.src = game.iframe;
  newFrame.onload = function() { newFrame.focus(); vaultLoaderComplete(); };
  oldFrame.parentNode.replaceChild(newFrame, oldFrame);
  vaultIframe = newFrame;
  vaultLoaderStart();

  playTitle.textContent = game.name;
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
  _restorePlaySidebars();
  overlay.classList.remove('open');
  overlay.style.display = 'none';
  vaultIframe.src = '';
}

// ── Favourites ────────────────────────────────────────────────────
const FAV_KEY = 'em_game_favs';
let _favs = new Set(JSON.parse(localStorage.getItem(FAV_KEY) || '[]'));

function _saveFavs() {
  localStorage.setItem(FAV_KEY, JSON.stringify([..._favs]));
  _updateFavCounts();
}

function _updateFavCounts() {
  const n = _favs.size;
  const topCount  = document.getElementById('vault-fav-count');
  const sideCount = document.getElementById('vault-fav-count-side');
  if (topCount)  { topCount.textContent  = n; topCount.style.display  = n ? 'inline-flex' : 'none'; }
  if (sideCount) { sideCount.textContent = n; sideCount.style.display = n ? 'inline-flex' : 'none'; }
}

function toggleFav(code) {
  if (_favs.has(code)) _favs.delete(code); else _favs.add(code);
  _saveFavs();
  document.querySelectorAll('.v-fav-btn[data-fav="' + code + '"]').forEach(function(btn) {
    btn.classList.toggle('active', _favs.has(code));
    btn.querySelector('i').className = _favs.has(code) ? 'fa-solid fa-heart' : 'fa-regular fa-heart';
    btn.classList.remove('pop');
    void btn.offsetWidth;
    btn.classList.add('pop');
  });
  const pfb = document.getElementById('vault-play-fav-btn');
  if (pfb && pfb.dataset.code === code) {
    pfb.classList.toggle('active', _favs.has(code));
    pfb.querySelector('i').className = _favs.has(code) ? 'fa-solid fa-heart' : 'fa-regular fa-heart';
  }
  const activeLink = document.querySelector('.vault-cat-link.active');
  if (activeLink && activeLink.dataset.cat === '__favs__') renderGrid(getItems());
}

_updateFavCounts();

// Favourites topbar button
(function() {
  var btn = document.getElementById('vault-fav-btn');
  if (!btn) return;
  btn.addEventListener('click', function() {
    var favLink = document.getElementById('vault-fav-cat');
    if (!favLink) return;
    var isActive = favLink.classList.contains('active');
    if (isActive) {
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
  items.sort((a, b) => {
    const na = parseInt(a.code) >= 4000 ? 1 : 0;
    const nb = parseInt(b.code) >= 4000 ? 1 : 0;
    return nb - na;
  });
  const vcIdx = items.findIndex(g => g.code === '4014');
  if (vcIdx > 0) { const g = items.splice(vcIdx, 1)[0]; items.unshift(g); }
  const idx2048 = items.findIndex(g => g.name === '2048');
  if (idx2048 > 0) { const g = items.splice(idx2048, 1)[0]; items.push(g); }
  return items;
}

function escHtml(s) {
  return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

// ── Infinite-scroll grid ──────────────────────────────────────────
const GRID_PAGE = 40;
let _gridGames        = [];
let _gridOffset       = 0;
let _gridSentinel     = null;
let _gridObserver     = null;
let _imgObserver      = null;
let _adInsertCount    = 0;
let _nativeAdInserted = false;

function _initImgObserver() {
  if (_imgObserver) _imgObserver.disconnect();
  const scrollRoot = document.querySelector('.vault-main-area');
  _imgObserver = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) { const img = e.target; img.src = img.dataset.src; _imgObserver.unobserve(img); }
    });
  }, { root: scrollRoot, rootMargin: '500px 0px' });
}

const FEATURED_SLOTS = new Set([2, 10, 19, 28, 37, 46, 55, 64, 73, 82, 91, 100, 110, 120]);

function _cardHTML(g, idx) {
  const eager    = idx < 20;
  const imgAttr  = eager
    ? `src="${escHtml(g.thumb)}" fetchpriority="${idx < 8 ? 'high' : 'auto'}"`
    : `data-src="${escHtml(g.thumb)}"`;
  const featured = FEATURED_SLOTS.has(idx);
  const isFav    = _favs.has(g.code);
  return `<div class="v-card${featured ? ' v-card-featured' : ''}" data-code="${escHtml(g.code)}">
    <div class="v-thumb">
      <img ${imgAttr} alt="${escHtml(g.name)}" onload="this.classList.add('loaded');this.parentElement.classList.add('loaded')" onerror="this.style.display='none'">
      ${featured ? '<div class="v-shine"></div>' : ''}
      <button class="v-fav-btn${isFav ? ' active' : ''}" data-fav="${escHtml(g.code)}" aria-label="Favourite"><i class="fa-${isFav ? 'solid' : 'regular'} fa-heart"></i></button>
      <div class="v-card-overlay"><div class="v-play-btn">
        <svg fill="currentColor" viewBox="0 0 24 24"><path d="M5 3l14 9-14 9V3z"/></svg>
      </div></div>
      <div class="v-card-info"><h3 class="v-card-name">${escHtml(g.name)}</h3></div>
    </div>
  </div>`;
}

function _createAdCard() {
  const n = _adInsertCount++;
  let type;
  if (n % 3 === 0) type = '300x250';
  else if (n % 3 === 1) { type = _nativeAdInserted ? '160x300' : 'native'; if (type === 'native') _nativeAdInserted = true; }
  else type = '160x300';

  const wrap = document.createElement('div');
  if (type === '300x250') {
    wrap.className = 'v-card-ad v-card-ad-300x250';
    const s1 = document.createElement('script');
    s1.textContent = "atOptions={'key':'f093d96a9666c21a7ab93bfc887fd236','format':'iframe','height':250,'width':300,'params':{}};";
    const s2 = document.createElement('script');
    s2.src = 'https://www.highperformanceformat.com/f093d96a9666c21a7ab93bfc887fd236/invoke.js';
    wrap.appendChild(s1); wrap.appendChild(s2);
  } else if (type === '160x300') {
    wrap.className = 'v-card-ad v-card-ad-160x300';
    const s1 = document.createElement('script');
    s1.textContent = "atOptions={'key':'f942d0c6515398bb20bcb59c82781b61','format':'iframe','height':300,'width':160,'params':{}};";
    const s2 = document.createElement('script');
    s2.src = 'https://www.highperformanceformat.com/f942d0c6515398bb20bcb59c82781b61/invoke.js';
    wrap.appendChild(s1); wrap.appendChild(s2);
  } else {
    wrap.className = 'v-card-ad v-card-ad-native';
    const s = document.createElement('script');
    s.async = true; s.dataset.cfasync = 'false';
    s.src = 'https://pl29223878.profitablecpmratenetwork.com/9e7f11281adcc579755f8757bf17e0dc/invoke.js';
    const container = document.createElement('div');
    container.id = 'container-9e7f11281adcc579755f8757bf17e0dc';
    wrap.appendChild(s); wrap.appendChild(container);
  }
  return wrap;
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
    const div = document.createElement('div');
    div.innerHTML = _cardHTML(g, startIdx + i);
    frag.appendChild(div.firstChild);
    if (i === 19) frag.appendChild(_createAdCard());
  });
  if (_gridSentinel) _gridSentinel.remove();
  vaultGrid.appendChild(frag);
  vaultGrid.querySelectorAll('img[data-src]:not([src])').forEach(img => _imgObserver.observe(img));
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
    entries.forEach(e => { if (e.isIntersecting) { _gridObserver.unobserve(e.target); _appendBatch(); } });
  }, { rootMargin: '300px 0px' });
}

function renderGrid(games) {
  _initGridObserver();
  _initImgObserver();
  _gridGames        = games;
  _gridOffset       = 0;
  _adInsertCount    = 0;
  _nativeAdInserted = false;
  vaultGrid.innerHTML = '';
  _gridSentinel = null;
  if (!games.length) {
    vaultGrid.innerHTML = '<p class="v-card-empty">No results found.</p>';
    return;
  }
  _appendBatch();
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
  const favBtn = e.target.closest('.v-fav-btn');
  if (favBtn) { e.stopPropagation(); toggleFav(favBtn.dataset.fav); return; }
  const card = e.target.closest('.v-card');
  if (!card) return;
  const game = (window.VAULT_DATA || []).find(g => g.code === card.dataset.code);
  if (game) openVaultPlay(game, true);
});

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
  overlay.classList.remove('vault-in-play');
  playView.style.display = 'none';
  gridView.style.display = 'flex';
  backBtn.style.display  = 'none';
  if (sidebarToggleBtn) sidebarToggleBtn.style.display = '';
  vaultIframe.src = '';
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

fsBtn.addEventListener('click', () => {
  const frame = document.getElementById('vault-iframe');
  if (frame.requestFullscreen) frame.requestFullscreen();
  else if (frame.webkitRequestFullscreen) frame.webkitRequestFullscreen();
});

// Top loader bar for iframe
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
function updateSearchClear() { searchClear.style.display = searchInput.value ? 'block' : 'none'; }
searchClear.addEventListener('click', () => { searchInput.value = ''; updateSearchClear(); renderGrid(getItems()); searchInput.focus(); });
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
  return getItems().filter(g => g.name.toLowerCase().includes(lq) || g.code.includes(lq));
}

// Prefetch vault data on page load
loadVaultData(function() {});

// ── Shared Quiz Logic ─────────────────────────────────────────────
(function() {
  document.querySelectorAll('.topic-quiz').forEach(function(container) {
    var questions = container.querySelectorAll('.quiz-q');
    var scoreEl   = container.querySelector('.quiz-score');
    var scoreNum  = container.querySelector('.quiz-score-num');
    var retryBtn  = container.querySelector('.quiz-retry-btn');
    var answered  = 0;
    var correct   = 0;

    questions.forEach(function(qEl) {
      var correctIdx = parseInt(qEl.dataset.correct);
      var opts = qEl.querySelectorAll('.quiz-opt');
      var feedback = qEl.querySelector('.quiz-feedback');
      opts.forEach(function(btn) {
        btn.addEventListener('click', function() {
          if (qEl.classList.contains('quiz-done')) return;
          qEl.classList.add('quiz-done');
          var chosen = parseInt(btn.dataset.oi);
          opts.forEach(function(b) { b.disabled = true; });
          if (chosen === correctIdx) {
            btn.classList.add('quiz-correct');
            feedback.textContent = '✓ Correct!';
            feedback.className = 'quiz-feedback quiz-ok';
            correct++;
          } else {
            btn.classList.add('quiz-wrong');
            opts[correctIdx].classList.add('quiz-correct');
            feedback.textContent = '✗ Not quite - the correct answer is highlighted.';
            feedback.className = 'quiz-feedback quiz-err';
          }
          feedback.style.display = 'block';
          answered++;
          if (answered === questions.length) {
            setTimeout(function() {
              if (scoreNum) scoreNum.textContent = correct;
              if (scoreEl) scoreEl.style.display = 'block';
            }, 600);
          }
        });
      });
    });

    if (retryBtn) {
      retryBtn.addEventListener('click', function() {
        answered = 0; correct = 0;
        questions.forEach(function(qEl) {
          qEl.classList.remove('quiz-done');
          var opts = qEl.querySelectorAll('.quiz-opt');
          opts.forEach(function(b) {
            b.disabled = false;
            b.classList.remove('quiz-correct', 'quiz-wrong');
          });
          var fb = qEl.querySelector('.quiz-feedback');
          if (fb) { fb.style.display = 'none'; fb.textContent = ''; fb.className = 'quiz-feedback'; }
        });
        if (scoreEl) scoreEl.style.display = 'none';
      });
    }
  });
})();

