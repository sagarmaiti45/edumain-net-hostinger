<?php if (!defined('SITE_NAME')) require_once __DIR__ . '/config.php'; ?>
</div><!-- /page-wrap -->

<footer class="site-footer">
  <div class="footer-inner">
    <div class="footer-brand">
      <span class="footer-logo"><i class="fa-solid fa-graduation-cap"></i> Edu<span class="footer-logo-accent">Main</span></span>
      <p class="footer-tagline">School topics explained simply<br>for students aged 6–16.</p>
    </div>
    <div class="footer-links-group">
      <h4 class="footer-group-title">Quick Links</h4>
      <nav class="footer-nav">
        <a href="/about">About</a>
        <a href="/privacy">Privacy</a>
        <a href="/terms">Terms</a>
        <a href="/contact">Contact</a>
        <a href="/math-tools">Math Tools</a>
      </nav>
    </div>
    <div class="footer-links-group">
      <h4 class="footer-group-title">Subjects</h4>
      <nav class="footer-nav">
        <a href="/maths">Maths</a>
        <a href="/science">Science</a>
        <a href="/history">History</a>
        <a href="/english">English</a>
        <a href="/geography">Geography</a>
      </nav>
    </div>
  </div>
  <div class="footer-bottom">
    <span class="footer-copy">© <?= SITE_YEAR ?> EduMain.net — All rights reserved.</span>
  </div>
</footer>

<!-- Mobile nav toggle -->
<script>
(function(){
  var btn = document.getElementById('mob-menu-btn');
  var nav = document.getElementById('mob-nav');
  var overlay = document.getElementById('mob-overlay');
  if (btn) btn.addEventListener('click', function(){
    nav.classList.toggle('open');
    overlay.classList.toggle('active');
  });
  if (overlay) overlay.addEventListener('click', function(){
    nav.classList.remove('open');
    overlay.classList.remove('active');
  });
})();
</script>

<!-- Priority nav: ··· dropdown toggle -->
<script>
(function() {
  var moreBtn  = document.getElementById('nav-more-btn');
  var dropdown = document.getElementById('nav-more-dropdown');
  if (!moreBtn || !dropdown) return;
  moreBtn.addEventListener('click', function(e) {
    e.stopPropagation();
    dropdown.classList.toggle('open');
  });
  document.addEventListener('click', function() {
    dropdown.classList.remove('open');
  });
})();
</script>

<!-- Cookie Consent -->
<div id="sc-cookie-banner" role="dialog" aria-label="Cookie consent" style="display:none;position:fixed;bottom:0;left:0;right:0;z-index:99999;background:#fff;color:#374151;padding:14px 20px;align-items:center;gap:14px;flex-wrap:wrap;justify-content:center;box-shadow:0 -2px 14px rgba(0,0,0,0.10);border-top:1px solid #e5e7eb;font-size:0.88rem;line-height:1.5;">
  <span>We use cookies to improve your experience. See our <a href="/privacy" style="color:#0369a1;text-decoration:underline;">Privacy Policy</a>.</span>
  <div style="display:flex;gap:8px;flex-shrink:0;">
    <button id="sc-cookie-accept" style="background:#16a34a;color:#fff;border:none;border-radius:8px;padding:7px 18px;font-size:0.85rem;font-weight:500;cursor:pointer;">Accept</button>
    <button id="sc-cookie-decline" style="background:transparent;color:#6b7280;border:1px solid #d1d5db;border-radius:8px;padding:7px 18px;font-size:0.85rem;font-weight:500;cursor:pointer;">Decline</button>
  </div>
</div>
<script>
(function() {
  var KEY = 'sc_cookie_consent';
  if (localStorage.getItem(KEY) === null) {
    document.getElementById('sc-cookie-banner').style.display = 'flex';
  }
  document.getElementById('sc-cookie-accept').addEventListener('click', function() {
    localStorage.setItem(KEY, '1');
    document.getElementById('sc-cookie-banner').style.display = 'none';
  });
  document.getElementById('sc-cookie-decline').addEventListener('click', function() {
    localStorage.setItem(KEY, '0');
    document.getElementById('sc-cookie-banner').style.display = 'none';
  });
})();
</script>

<!-- ══ OVERLAY ══ -->
<div id="vault-overlay" class="vault-overlay" aria-hidden="true">

  <!-- Top bar -->
  <div class="vault-topbar">
    <button class="vault-sidebar-toggle" id="vault-sidebar-toggle" title="Toggle sidebar" aria-label="Toggle sidebar">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 3v18"/></svg>
    </button>
    <span class="vault-esc-hint" id="vault-esc-hint"><kbd>Esc</kbd> to exit<button class="vault-esc-close" id="vault-esc-close" aria-label="Dismiss">✕</button></span>
    <button class="vault-topbar-btn" id="vault-back-btn" title="Back to grid" style="display:none">← Back</button>
    <div class="vault-topbar-center">
      <div class="vault-top-games" id="vault-top-games"></div>
      <div class="vault-search-wrap">
        <svg class="vault-search-icon" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        <input type="text" id="vault-search" class="vault-search" placeholder="Search games…" autocomplete="off" spellcheck="false">
        <button id="vault-search-clear" class="vault-search-clear" aria-label="Clear search" style="display:none">✕</button>
      </div>
    </div>
    <button class="vault-topbar-btn vault-fav-topbar-btn" id="vault-fav-btn" title="Favourites"><i class="fa-solid fa-heart"></i><span class="vault-fav-count" id="vault-fav-count" style="display:none">0</span></button>
    <button class="vault-topbar-btn" id="vault-theme-btn" title="Toggle theme">Dark</button>
    <button class="vault-topbar-btn" id="vault-close-btn" title="Close">✕<span class="vault-close-label">Exit</span></button>
  </div>

  <!-- Grid view -->
  <div id="vault-grid-view" class="vault-body">
    <aside class="vault-cat-sidebar">
      <a class="vault-cat-link active" href="#" data-cat=""><i class="fa-solid fa-gamepad"></i>All</a>
      <a class="vault-cat-link vault-fav-link" href="#" id="vault-fav-cat" data-cat="__favs__"><i class="fa-solid fa-heart"></i>Favourites<span class="vault-fav-count-side" id="vault-fav-count-side" style="display:none">0</span></a>
      <a class="vault-cat-link" href="#" data-cat="action"><i class="fa-solid fa-bolt"></i>Action<span class="v-cat-badge v-cat-badge-hot">Hot</span></a>
      <a class="vault-cat-link" href="#" data-cat="adventure"><i class="fa-solid fa-compass"></i>Adventure</a>
      <a class="vault-cat-link" href="#" data-cat="arcade"><i class="fa-solid fa-dice"></i>Arcade<span class="v-cat-badge v-cat-badge-top">Top</span></a>
      <a class="vault-cat-link" href="#" data-cat="casual"><i class="fa-solid fa-face-smile"></i>Casual</a>
      <a class="vault-cat-link" href="#" data-cat="horror"><i class="fa-solid fa-ghost"></i>Horror<span class="v-cat-badge v-cat-badge-new">New</span></a>
      <a class="vault-cat-link" href="#" data-cat="idle"><i class="fa-solid fa-clock"></i>Idle</a>
      <a class="vault-cat-link" href="#" data-cat="io"><i class="fa-solid fa-globe"></i>IO<span class="v-cat-badge v-cat-badge-top">Top</span></a>
      <a class="vault-cat-link" href="#" data-cat="platformer"><i class="fa-solid fa-person-running"></i>Platformer</a>
      <a class="vault-cat-link" href="#" data-cat="puzzle"><i class="fa-solid fa-puzzle-piece"></i>Puzzle</a>
      <a class="vault-cat-link" href="#" data-cat="racing"><i class="fa-solid fa-flag-checkered"></i>Racing<span class="v-cat-badge v-cat-badge-new">New</span></a>
      <a class="vault-cat-link" href="#" data-cat="shooter"><i class="fa-solid fa-crosshairs"></i>Shooter<span class="v-cat-badge v-cat-badge-hot">Hot</span></a>
      <a class="vault-cat-link" href="#" data-cat="sports"><i class="fa-solid fa-futbol"></i>Sports</a>
      <a class="vault-cat-link" href="#" data-cat="strategy"><i class="fa-solid fa-chess"></i>Strategy</a>
      <a class="vault-cat-link" href="#" data-cat="open-world"><i class="fa-solid fa-map-location-dot"></i>Open World</a>
      <a class="vault-cat-link" href="#" data-cat="multiplayer"><i class="fa-solid fa-tower-broadcast"></i>Multiplayer</a>
      <button class="vault-cat-exit-btn" onclick="closeVault()"><i class="fa-solid fa-right-from-bracket"></i>Exit</button>
    </aside>
    <div class="vault-main-area">
      <div id="vault-grid" class="vault-grid"></div>
    </div>
  </div>

  <!-- Play view -->
  <div id="vault-play-view" class="vault-play-view" style="display:none">
    <div class="vault-split">
      <div class="vault-side-left" id="vault-sidebar">
        <p class="vault-side-label">More</p>
        <div id="vault-side-cards"></div>
      </div>
      <div class="vault-main-frame">
        <div class="vault-frame-header">
          <div class="vault-frame-left">
            <button class="vault-topbar-btn" id="vault-frame-back-btn" title="Back to grid">← Back</button>
          </div>
          <div class="vault-frame-center">
            <span id="vault-play-title" class="vault-play-title"></span>
          </div>
          <div class="vault-frame-btns">
            <button class="vault-play-fav-btn" id="vault-play-fav-btn" aria-label="Favourite" title="Favourite"><i class="fa-regular fa-heart"></i></button>
            <button class="vault-fs-btn" id="vault-fs-btn" title="Fullscreen">⛶</button>
          </div>
        </div>
        <iframe id="vault-iframe" src="" allowfullscreen allow="autoplay; fullscreen; gamepad; cross-origin-isolated" referrerpolicy="no-referrer"></iframe>
      </div>
      <div class="vault-side-right" id="vault-sidebar-right">
        <p class="vault-side-label">Up Next</p>
        <div id="vault-side-cards-right"></div>
      </div>
    </div>
  </div>

</div><!-- /vault-overlay -->
<script src="/assets/js/main.js?v=1"></script>
</body>
</html>
