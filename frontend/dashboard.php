<?php
session_start();
require_once __DIR__ . '/../backend/config.php';
require_once __DIR__ . '/../backend/includes/db.php';
require_once __DIR__ . '/../backend/includes/subscription.php';
$base_url = get_base_url();
if (empty($_SESSION['user_id'])) {
  header('Location: ' . $base_url . 'frontend/pages/login.php');
  exit;
}
$user_id = (int) $_SESSION['user_id'];
// Use absolute URL for QR code so it works when scanned (and after deploy). Set SITE_URL in config.cpanel.php to force (e.g. https://myratings.online).
if (defined('SITE_URL') && SITE_URL !== '') {
  $rate_url = rtrim(SITE_URL, '/') . '/frontend/rate.php?u=' . $user_id;
} else {
  $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
  $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
  $path = trim((strpos($base_url, '/') === 0 ? $base_url : '/' . $base_url), '/');
  $full_base = $scheme . '://' . $host . ($path !== '' ? '/' . $path : '');
  $rate_url = $full_base . '/frontend/rate.php?u=' . $user_id;
}
$qr_image_url = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($rate_url);
$page_title = 'Dashboard | 1TXT';
require __DIR__ . '/../backend/includes/header.php';
?>
<main class="dashboard-app">
  <nav class="dashboard-tabs" role="tablist" aria-label="Dashboard sections">
    <div class="dashboard-tabs-left">
      <button type="button" class="dashboard-tab active" role="tab" id="tab-overview" aria-selected="true" aria-controls="panel-overview" data-tab="overview">Overview</button>
      <button type="button" class="dashboard-tab" role="tab" id="tab-settings" aria-selected="false" aria-controls="panel-settings" data-tab="settings">Settings</button>
      <button type="button" class="dashboard-tab" role="tab" id="tab-ratings" aria-selected="false" aria-controls="panel-ratings" data-tab="ratings">Ratings</button>
      <button type="button" class="dashboard-tab" role="tab" id="tab-leads" aria-selected="false" aria-controls="panel-leads" data-tab="leads">Leads</button>
    </div>
    <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/pricing.php" class="btn btn-outline dashboard-plan-btn">Change payment plan</a>
  </nav>

  <div id="panel-overview" class="dashboard-panel active" role="tabpanel" aria-labelledby="tab-overview">
  <section class="dashboard-section dashboard-overview-grid">
    <div class="dashboard-overview-left">
      <h2>Your QR code</h2>
      <p class="dashboard-desc">Customers scan this to rate you (1–10). Display it at your counter.</p>
      <div class="dashboard-qr-wrap">
        <img src="<?php echo htmlspecialchars($qr_image_url); ?>" alt="QR code" width="200" height="200" class="dashboard-qr-img">
        <p class="dashboard-qr-footer" id="qr-footer-preview"><?php echo htmlspecialchars($_SESSION['qr_footer_preview'] ?? 'Rate us and win a free gift'); ?></p>
        <p class="dashboard-qr-url"><small>Link: <a href="<?php echo htmlspecialchars($rate_url); ?>" target="_blank" rel="noopener"><?php echo htmlspecialchars($rate_url); ?></a></small></p>
        <button type="button" class="btn btn-outline" onclick="window.print()">Print QR code</button>
      </div>
    </div>
    <div class="dashboard-overview-right">
      <h2>Responses</h2>
      <div class="dashboard-pie-wrap">
        <div class="dashboard-pie" id="stats-pie" role="img" aria-label="Response breakdown"></div>
        <div class="dashboard-pie-legend">
          <span class="dashboard-stat-value" id="stat-total">0</span> total
        </div>
      </div>
      <div class="dashboard-stats-grid">
        <div class="dashboard-stat-card">
          <span class="dashboard-stat-value" id="stat-positive">0</span>
          <span class="dashboard-stat-label">Positive (7–10)</span>
        </div>
        <div class="dashboard-stat-card negative">
          <span class="dashboard-stat-value" id="stat-negative">0</span>
          <span class="dashboard-stat-label">Negative (1–6)</span>
        </div>
      </div>
    </div>
  </section>
  </div>

  <div id="panel-settings" class="dashboard-panel" role="tabpanel" aria-labelledby="tab-settings" hidden>
  <section class="dashboard-section dashboard-settings">
    <h2>Settings</h2>
    <p class="dashboard-desc">Edit the URL customers see after a high rating, your follow-up questions, and gift option.</p>
    <div class="dashboard-settings-grid">
      <div class="dashboard-settings-form-wrap">
    <form id="dashboard-settings-form" class="dashboard-form">
      <div class="form-group">
        <label for="qr_footer_text">Text below QR code (e.g. “Rate us and win a free gift”)</label>
        <input type="text" id="qr_footer_text" name="qr_footer_text" maxlength="255" placeholder="Help us improve and win a free gift">
      </div>
      <div class="form-group">
        <span class="form-label">Send happy customers to (selected platforms are shown on the thank-you page)</span>
        <div class="review-platforms-multi" role="group" aria-label="Review platforms">
          <label class="platform-option">
            <input type="checkbox" name="review_platforms[]" value="google">
            <span class="platform-icon platform-google" aria-hidden="true"><svg viewBox="0 0 24 24" width="20" height="20"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg></span>
            <span>Google</span>
          </label>
          <label class="platform-option">
            <input type="checkbox" name="review_platforms[]" value="facebook">
            <span class="platform-icon platform-facebook" aria-hidden="true"><svg viewBox="0 0 24 24" width="20" height="20"><path fill="#1877F2" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></span>
            <span>Facebook</span>
          </label>
          <label class="platform-option">
            <input type="checkbox" name="review_platforms[]" value="yelp">
            <span class="platform-icon platform-yelp" aria-hidden="true"><svg viewBox="0 0 24 24" width="20" height="20"><path fill="#D32323" d="M20.16 12.73l-4.88 2.12 1.44 5.92c.18.72-.49 1.21-1.1.82l-4.2-2.78-4.2 2.78c-.61.4-1.28-.1-1.1-.82l1.44-5.92-4.88-2.12c-.62-.27-.45-1.1.24-1.2l5.92-.48 2.28-5.6c.28-.68 1.23-.68 1.51 0l2.28 5.6 5.92.48c.69.1.86.93.24 1.2z"/></svg></span>
            <span>Yelp</span>
          </label>
          <label class="platform-option">
            <input type="checkbox" name="review_platforms[]" value="tripadvisor">
            <span class="platform-icon platform-tripadvisor" aria-hidden="true"><svg viewBox="0 0 24 24" width="20" height="20"><path fill="#00AF87" d="M12.006 4.295c-2.67 0-5.338.784-7.645 2.353H0v12.706h4.35v-8.28c1.22-1.15 2.65-1.74 4.31-1.74 1.66 0 3.09.59 4.31 1.74v8.28h4.35V9.648c0-2.88-2.34-5.353-5.355-5.353zm12.006 0c-2.67 0-5.338.784-7.645 2.353H12v2.353h.01c1.12 0 2.23.25 3.24.73 1.01.48 1.92 1.17 2.7 2.04.78.87 1.4 1.9 1.84 3.06.44 1.16.66 2.4.66 3.7 0 2.88 2.34 5.35 5.35 5.35 2.67 0 5.34-.78 7.65-2.35V4.295h-4.35v8.28c-1.22 1.15-2.65 1.74-4.31 1.74-1.66 0-3.09-.59-4.31-1.74V4.295h-4.35z"/></svg></span>
            <span>TripAdvisor</span>
          </label>
        </div>
      </div>
      <div class="form-group">
        <label for="num_questions">How many follow-up questions for low ratings (0–3)</label>
        <select id="num_questions" name="num_questions">
          <option value="0">0 (no questions)</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3" selected>3</option>
        </select>
      </div>
      <div class="form-group question-group" data-question="1">
        <label for="question_1">Question 1</label>
        <input type="text" id="question_1" name="question_1" placeholder="What is one thing we can improve?">
      </div>
      <div class="form-group question-group" data-question="2">
        <label for="question_2">Question 2</label>
        <input type="text" id="question_2" name="question_2" placeholder="What bothered you today?">
      </div>
      <div class="form-group question-group" data-question="3">
        <label for="question_3">Question 3</label>
        <input type="text" id="question_3" name="question_3" placeholder="Add more products or services?">
      </div>
      <div class="form-group form-group-checkbox">
        <label class="checkbox-label">
          <input type="checkbox" id="offer_gift" name="offer_gift" value="1"> Offer a free gift for feedback
        </label>
      </div>
      <div class="form-group">
        <label for="gift_description">Gift description (shown to customer)</label>
        <input type="text" id="gift_description" name="gift_description" placeholder="e.g. Free coffee on your next visit">
      </div>
      <div class="form-group">
        <label for="gift_image_file">Gift image (optional)</label>
        <input type="file" id="gift_image_file" name="gift_image_file" accept="image/*">
      </div>
      <button type="submit" class="btn btn-primary">Save settings</button>
      <span class="dashboard-save-status" id="save-status"></span>
    </form>
      </div>
      <div class="dashboard-settings-preview">
        <h3>Live preview</h3>
        <div class="settings-preview-card" id="settings-preview-card">
          <p class="preview-label">Rate page</p>
          <div class="preview-qr-block">
            <p class="preview-qr-footer" id="settings-preview-footer">Rate us and win a free gift</p>
            <p class="preview-stars">★ ★ ★ ★ ★ ★ ★ ★ ★ ★</p>
          </div>
          <div class="preview-questions" id="settings-preview-questions"></div>
          <div class="preview-gift" id="settings-preview-gift"></div>
          <div class="preview-gift-image-wrap" id="settings-preview-gift-image-wrap" style="display:none;"><img id="settings-preview-gift-image" src="" alt="Gift" class="settings-preview-gift-img"></div>
        </div>
      </div>
    </div>
  </section>
  </div>

  <div id="panel-ratings" class="dashboard-panel" role="tabpanel" aria-labelledby="tab-ratings" hidden>
  <section class="dashboard-section dashboard-ratings-leads">
    <div class="dashboard-table-wrap">
      <table class="dashboard-table" id="ratings-table">
        <thead>
          <tr>
            <th class="sortable" data-sort="date">Date</th>
            <th class="sortable" data-sort="score">Score</th>
            <th class="sortable" data-sort="answers">Answers</th>
            <th class="th-download"><a href="<?php echo htmlspecialchars($base_url); ?>backend/api/export.php?type=ratings" class="btn btn-icon" title="Download CSV" aria-label="Download CSV"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg></a></th>
          </tr>
        </thead>
        <tbody></tbody>
        <tfoot id="ratings-table-footer"><tr><td colspan="4" class="table-footer-cell"><div class="dashboard-pagination" id="ratings-pagination"></div></td></tr></tfoot>
      </table>
    </div>
  </section>
  </div>

  <div id="panel-leads" class="dashboard-panel" role="tabpanel" aria-labelledby="tab-leads" hidden>
  <section class="dashboard-section dashboard-leads">
    <div class="dashboard-table-wrap">
      <table class="dashboard-table" id="leads-table">
        <thead>
          <tr>
            <th class="sortable" data-sort="date">Date</th>
            <th class="sortable" data-sort="score">Score</th>
            <th class="sortable" data-sort="answers">Answers</th>
            <th class="sortable" data-sort="name">Name</th>
            <th class="sortable" data-sort="email">Email</th>
            <th class="sortable" data-sort="mobile">Mobile</th>
            <th class="th-download"><a href="<?php echo htmlspecialchars($base_url); ?>backend/api/export.php?type=leads" class="btn btn-icon" title="Download leads CSV" aria-label="Download leads CSV"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg></a></th>
          </tr>
        </thead>
        <tbody></tbody>
        <tfoot id="leads-table-footer"><tr><td colspan="7" class="table-footer-cell"><div class="dashboard-pagination" id="leads-pagination"></div></td></tr></tfoot>
      </table>
    </div>
  </section>
  </div>
</main>
<script>
(function() {
  var base = '<?php echo htmlspecialchars($base_url, ENT_QUOTES, 'UTF-8'); ?>';

  // Tabs
  function showPanel(tabId) {
    var panels = document.querySelectorAll('.dashboard-panel');
    var tabs = document.querySelectorAll('.dashboard-tab');
    panels.forEach(function(p) {
      var isActive = p.id === 'panel-' + tabId;
      p.classList.toggle('active', isActive);
      p.hidden = !isActive;
    });
    tabs.forEach(function(t) {
      var isActive = t.getAttribute('data-tab') === tabId;
      t.classList.toggle('active', isActive);
      t.setAttribute('aria-selected', isActive ? 'true' : 'false');
    });
    try { window.history.replaceState(null, '', '#' + tabId); } catch (e) {}
  }
  document.querySelectorAll('.dashboard-tab').forEach(function(btn) {
    btn.addEventListener('click', function() { showPanel(this.getAttribute('data-tab')); });
  });
  var hash = (window.location.hash || '').replace(/^#/, '');
  if (['overview', 'settings', 'ratings', 'leads'].indexOf(hash) >= 0) showPanel(hash);
  else showPanel('overview');

  function api(path, opts) {
    opts = opts || {};
    var url = base + 'backend/api/' + path;
    return fetch(url, { credentials: 'same-origin', headers: opts.headers || {}, method: opts.method || 'GET', body: opts.body || null }).then(function(r) { return r.json(); });
  }
  function loadSettings() {
    api('dashboard.php?action=settings').then(function(s) {
      if (s.error) return;
      document.getElementById('qr_footer_text').value = s.qr_footer_text || '';
      var rpList = (s.review_platform || 'google').split(',').map(function(x) { return x.trim(); }).filter(function(x) { return ['google','yelp','facebook','tripadvisor'].indexOf(x) >= 0; });
      if (rpList.length === 0) rpList = ['google'];
      document.querySelectorAll('input[name="review_platforms[]"]').forEach(function(cb) {
        cb.checked = rpList.indexOf(cb.value) >= 0;
      });
      document.getElementById('num_questions').value = String(s.num_questions ?? 3);
  updateQuestionVisibility();
      document.getElementById('question_1').value = s.question_1 || '';
      document.getElementById('question_2').value = s.question_2 || '';
      document.getElementById('question_3').value = s.question_3 || '';
      document.getElementById('offer_gift').checked = !!s.offer_gift;
      document.getElementById('gift_description').value = s.gift_description || '';
      var footerPreview = document.getElementById('qr-footer-preview');
      if (footerPreview) footerPreview.textContent = s.qr_footer_text || 'Rate us and win a free gift';
      var giftImgWrap = document.getElementById('settings-preview-gift-image-wrap');
      var giftImg = document.getElementById('settings-preview-gift-image');
      if (giftImgWrap && giftImg && s.gift_image) {
        giftImg.src = base + (s.gift_image.indexOf('/') === 0 ? s.gift_image.slice(1) : s.gift_image);
        giftImgWrap.style.display = 'block';
      } else if (giftImgWrap) giftImgWrap.style.display = 'none';
      updateSettingsPreview();
    });
  }
  function loadStats() {
    api('dashboard.php?action=stats').then(function(d) {
      var total = d.total || 0;
      var pos = d.positive || 0;
      var neg = d.negative || 0;
      document.getElementById('stat-total').textContent = total;
      document.getElementById('stat-positive').textContent = pos;
      document.getElementById('stat-negative').textContent = neg;
      var pie = document.getElementById('stats-pie');
      if (pie && total > 0) {
        var pct = (pos / total) * 100;
        pie.style.background = 'conic-gradient(#22c55e 0deg ' + (pct * 3.6) + 'deg, #ef4444 ' + (pct * 3.6) + 'deg 360deg)';
      } else if (pie) {
        pie.style.background = 'var(--color-border)';
      }
    });
  }
  var ratingsData = { questions: {}, list: [] };
  var leadsData = [];
  var ratingsSort = { col: 'date', dir: -1 };
  var leadsSort = { col: 'date', dir: -1 };
  var ratingsPage = 1;
  var leadsPage = 1;
  var pageSize = 10;

  function escapeHtml(s) {
    var div = document.createElement('div');
    div.textContent = s;
    return div.innerHTML;
  }
  function buildRatingsMap() {
    var map = {};
    (ratingsData.list || []).forEach(function(r) { map[r.id] = r; });
    return map;
  }
  function buildLeadRows() {
    var ratingsMap = buildRatingsMap();
    return (leadsData || []).map(function(lead) {
      return { lead: lead, rating: ratingsMap[lead.rating_id] || null };
    }).filter(function(row) { return row.rating; });
  }
  function renderRatingsPage() {
    var tbody = document.querySelector('#ratings-table tbody');
    if (!tbody) return;
    tbody.innerHTML = '';
    var arr = ratingsData.list;
    var start = (ratingsPage - 1) * pageSize;
    var slice = arr.slice(start, start + pageSize);
    slice.forEach(function(r) {
      var res = r.responses || {};
      var a1 = (res.answer_1 || '').trim();
      var a2 = (res.answer_2 || '').trim();
      var a3 = (res.answer_3 || '').trim();
      var parts = [];
      if (a1) parts.push(escapeHtml(a1));
      if (a2) parts.push(escapeHtml(a2));
      if (a3) parts.push(escapeHtml(a3));
      var answersHtml = parts.length ? parts.join(' · ') : '—';
      var score = Math.max(0, Math.min(10, parseInt(r.score, 10) || 0));
      var starHtml = '';
      for (var s = 0; s < 10; s++) starHtml += s < score ? '<span class="rating-star filled">★</span>' : '<span class="rating-star">☆</span>';
      var tr = document.createElement('tr');
      tr.innerHTML = '<td>' + escapeHtml(r.created_at || '') + '</td><td class="rating-score-cell"><span class="rating-stars" title="' + score + ' out of 10">' + starHtml + '</span></td><td class="qa-cell">' + answersHtml + '</td><td></td>';
      tbody.appendChild(tr);
    });
    renderPagination('ratings-pagination', arr.length, ratingsPage, function(p) { ratingsPage = p; renderRatingsPage(); });
  }
  function applyLeadsSort(rows) {
    var col = leadsSort.col;
    var dir = leadsSort.dir;
    rows.sort(function(a, b) {
      var ra = a.rating; var rb = b.rating;
      var la = a.lead; var lb = b.lead;
      var va, vb;
      if (col === 'date') { va = (ra && ra.created_at) || ''; vb = (rb && rb.created_at) || ''; return dir * (va < vb ? -1 : va > vb ? 1 : 0); }
      if (col === 'score') { va = (ra && parseInt(ra.score, 10)) || 0; vb = (rb && parseInt(rb.score, 10)) || 0; return dir * (va - vb); }
      if (col === 'answers') {
        var resa = (ra && ra.responses) || {}; var resb = (rb && rb.responses) || {};
        va = [resa.answer_1, resa.answer_2, resa.answer_3].filter(Boolean).join(' ');
        vb = [resb.answer_1, resb.answer_2, resb.answer_3].filter(Boolean).join(' ');
        return dir * (va < vb ? -1 : va > vb ? 1 : 0);
      }
      if (col === 'name' || col === 'email' || col === 'mobile') {
        va = (la && (la[col] || '').toString()) || '';
        vb = (lb && (lb[col] || '').toString()) || '';
        return dir * (va < vb ? -1 : va > vb ? 1 : 0);
      }
      return 0;
    });
  }
  function renderLeadsPage() {
    var tbody = document.querySelector('#leads-table tbody');
    if (!tbody) return;
    tbody.innerHTML = '';
    var rows = buildLeadRows();
    applyLeadsSort(rows);
    var start = (leadsPage - 1) * pageSize;
    var slice = rows.slice(start, start + pageSize);
    slice.forEach(function(row) {
      var r = row.rating;
      var l = row.lead;
      var res = r.responses || {};
      var a1 = (res.answer_1 || '').trim();
      var a2 = (res.answer_2 || '').trim();
      var a3 = (res.answer_3 || '').trim();
      var parts = [];
      if (a1) parts.push(escapeHtml(a1));
      if (a2) parts.push(escapeHtml(a2));
      if (a3) parts.push(escapeHtml(a3));
      var answersHtml = parts.length ? parts.join(' · ') : '—';
      var score = Math.max(0, Math.min(10, parseInt(r.score, 10) || 0));
      var starHtml = '';
      for (var s = 0; s < 10; s++) starHtml += s < score ? '<span class="rating-star filled">★</span>' : '<span class="rating-star">☆</span>';
      var tr = document.createElement('tr');
      tr.innerHTML = '<td>' + escapeHtml(r.created_at || '') + '</td><td class="rating-score-cell"><span class="rating-stars" title="' + score + ' out of 10">' + starHtml + '</span></td><td class="qa-cell">' + answersHtml + '</td><td>' + escapeHtml(l.name || '') + '</td><td>' + escapeHtml(l.email || '') + '</td><td>' + escapeHtml(l.mobile || '') + '</td><td></td>';
      tbody.appendChild(tr);
    });
    renderPagination('leads-pagination', rows.length, leadsPage, function(p) { leadsPage = p; renderLeadsPage(); });
  }
  function renderPagination(id, total, page, setPage) {
    var el = document.getElementById(id);
    var tfoot = id === 'ratings-pagination' ? document.getElementById('ratings-table-footer') : document.getElementById('leads-table-footer');
    if (tfoot) tfoot.style.display = total === 0 ? 'none' : '';
    if (!el) return;
    var totalPages = Math.max(1, Math.ceil(total / pageSize));
    if (total === 0) { el.innerHTML = ''; return; }
    var maxShow = 5;
    var startPage = Math.max(1, Math.min(page - Math.floor(maxShow / 2), totalPages - maxShow + 1));
    if (totalPages <= maxShow) startPage = 1;
    var endPage = Math.min(totalPages, startPage + maxShow - 1);
    var html = '<span class="pagination-nav">';
    html += '<button type="button" class="pagination-btn pagination-first" ' + (page <= 1 ? 'disabled' : '') + ' aria-label="First page">&#124;&lt;</button>';
    html += '<button type="button" class="pagination-btn pagination-prev" ' + (page <= 1 ? 'disabled' : '') + ' aria-label="Previous">&#60;</button>';
    html += '<span class="pagination-pages">';
    for (var i = startPage; i <= endPage; i++) {
      html += '<button type="button" class="pagination-btn pagination-page' + (i === page ? ' active' : '') + '" data-page="' + i + '">' + i + '</button>';
    }
    html += '</span>';
    html += '<button type="button" class="pagination-btn pagination-next" ' + (page >= totalPages ? 'disabled' : '') + ' aria-label="Next">&#62;</button>';
    html += '<button type="button" class="pagination-btn pagination-last" ' + (page >= totalPages ? 'disabled' : '') + ' aria-label="Last page">&#62;&#124;</button>';
    html += '</span>';
    el.innerHTML = html;
    el.querySelectorAll('.pagination-page').forEach(function(btn) {
      btn.addEventListener('click', function() { var p = parseInt(this.getAttribute('data-page'), 10); setPage(p); });
    });
    el.querySelector('.pagination-first').addEventListener('click', function() { if (page > 1) setPage(1); });
    el.querySelector('.pagination-prev').addEventListener('click', function() { if (page > 1) setPage(page - 1); });
    el.querySelector('.pagination-next').addEventListener('click', function() { if (page < totalPages) setPage(page + 1); });
    el.querySelector('.pagination-last').addEventListener('click', function() { if (page < totalPages) setPage(totalPages); });
  }
  function applyRatingsSort() {
    var col = ratingsSort.col;
    var dir = ratingsSort.dir;
    ratingsData.list.sort(function(a, b) {
      var va, vb;
      if (col === 'date') { va = a.created_at || ''; vb = b.created_at || ''; return dir * (va < vb ? -1 : va > vb ? 1 : 0); }
      if (col === 'score') { va = parseInt(a.score, 10) || 0; vb = parseInt(b.score, 10) || 0; return dir * (va - vb); }
      if (col === 'answers') {
        var ra = (a.responses || {}); var rb = (b.responses || {});
        va = [ra.answer_1, ra.answer_2, ra.answer_3].filter(Boolean).join(' ');
        vb = [rb.answer_1, rb.answer_2, rb.answer_3].filter(Boolean).join(' ');
        return dir * (va < vb ? -1 : va > vb ? 1 : 0);
      }
      return 0;
    });
  }
  function sortRatings(col) {
    if (ratingsSort.col === col) ratingsSort.dir = -ratingsSort.dir;
    else { ratingsSort.col = col; ratingsSort.dir = 1; }
    ratingsPage = 1;
    applyRatingsSort();
    renderRatingsPage();
  }
  function sortLeads(col) {
    if (leadsSort.col === col) leadsSort.dir = -leadsSort.dir;
    else { leadsSort.col = col; leadsSort.dir = 1; }
    leadsPage = 1;
    renderLeadsPage();
  }
  function loadRatings() {
    api('dashboard.php?action=ratings').then(function(data) {
      ratingsData.questions = (data && data.questions) ? data.questions : {};
      ratingsData.list = (data && data.ratings) ? data.ratings : [];
      ratingsPage = 1;
      ratingsSort.col = 'date';
      ratingsSort.dir = -1;
      applyRatingsSort();
      renderRatingsPage();
      renderLeadsPage();
    });
  }
  function loadLeads() {
    api('dashboard.php?action=leads').then(function(arr) {
      leadsData = arr || [];
      leadsPage = 1;
      leadsSort.col = 'date';
      leadsSort.dir = -1;
      renderLeadsPage();
    });
  }
  document.querySelector('#ratings-table thead').addEventListener('click', function(e) {
    var th = e.target.closest('th.sortable');
    if (th) sortRatings(th.getAttribute('data-sort'));
  });
  document.querySelector('#leads-table thead').addEventListener('click', function(e) {
    var th = e.target.closest('th.sortable');
    if (th) sortLeads(th.getAttribute('data-sort'));
  });
  document.getElementById('dashboard-settings-form').addEventListener('submit', function(e) {
    e.preventDefault();
    var form = this;
    var fd = new FormData(form);
    fd.append('action', 'save_settings');
    var checked = form.querySelectorAll('input[name="review_platforms[]"]:checked');
    if (checked.length === 0) fd.append('review_platforms[]', 'google');
    var status = document.getElementById('save-status');
    status.textContent = 'Saving…';
    fetch(base + 'backend/api/dashboard.php', { method: 'POST', credentials: 'same-origin', body: fd })
      .then(function(r) { return r.json(); })
      .then(function(j) {
        status.textContent = j.success ? 'Saved.' : (j.error || 'Error');
        if (j.success) {
          var qrFooter = document.getElementById('qr_footer_text').value;
          var preview = document.getElementById('qr-footer-preview');
          if (preview) preview.textContent = qrFooter || 'Rate us and win a free gift';
        }
      })
      .catch(function() { status.textContent = 'Error'; });
  });
  document.getElementById('qr_footer_text').addEventListener('input', function() {
    var p = document.getElementById('qr-footer-preview');
    if (p) p.textContent = this.value || 'Rate us and win a free gift';
    updateSettingsPreview();
  });
  function updateSettingsPreview() {
    var footer = document.getElementById('settings-preview-footer');
    var questions = document.getElementById('settings-preview-questions');
    var gift = document.getElementById('settings-preview-gift');
    if (footer) footer.textContent = (document.getElementById('qr_footer_text') && document.getElementById('qr_footer_text').value) || 'Rate us and win a free gift';
    var n = parseInt(document.getElementById('num_questions').value, 10) || 0;
    if (questions) {
      if (n < 1) { questions.innerHTML = ''; questions.style.display = 'none'; }
      else {
        questions.style.display = 'block';
        var q1 = (document.getElementById('question_1') && document.getElementById('question_1').value) || 'What is one thing we can improve?';
        var q2 = (document.getElementById('question_2') && document.getElementById('question_2').value) || 'What bothered you today?';
        var q3 = (document.getElementById('question_3') && document.getElementById('question_3').value) || 'Add more products or services?';
        var html = '<p class="preview-label">Follow-up questions (low rating)</p>';
        if (n >= 1) html += '<p class="preview-q">' + escapeHtml(q1) + '</p>';
        if (n >= 2) html += '<p class="preview-q">' + escapeHtml(q2) + '</p>';
        if (n >= 3) html += '<p class="preview-q">' + escapeHtml(q3) + '</p>';
        questions.innerHTML = html;
      }
    }
    var offer = document.getElementById('offer_gift') && document.getElementById('offer_gift').checked;
    var desc = (document.getElementById('gift_description') && document.getElementById('gift_description').value) || '';
    if (gift) {
      if (!offer || !desc) { gift.innerHTML = ''; gift.style.display = 'none'; }
      else { gift.style.display = 'block'; gift.innerHTML = '<p class="preview-label">Gift offer</p><p class="preview-gift-desc">' + escapeHtml(desc) + '</p>'; }
    }
  }
  function updateQuestionVisibility() {
    var n = parseInt(document.getElementById('num_questions').value, 10) || 0;
    document.querySelectorAll('.question-group').forEach(function(el) {
      var q = parseInt(el.getAttribute('data-question'), 10);
      el.style.display = (q <= n && n >= 1) ? '' : 'none';
    });
  }
  document.getElementById('num_questions').addEventListener('change', function() { updateQuestionVisibility(); updateSettingsPreview(); });
  ['question_1','question_2','question_3','gift_description'].forEach(function(id) {
    var el = document.getElementById(id);
    if (el) el.addEventListener('input', updateSettingsPreview);
  });
  document.getElementById('offer_gift').addEventListener('change', updateSettingsPreview);
  var giftFileInput = document.getElementById('gift_image_file');
  if (giftFileInput) giftFileInput.addEventListener('change', function() {
    var wrap = document.getElementById('settings-preview-gift-image-wrap');
    var img = document.getElementById('settings-preview-gift-image');
    if (!wrap || !img) return;
    if (this.files && this.files[0]) {
      img.src = URL.createObjectURL(this.files[0]);
      wrap.style.display = 'block';
    }
  });
  loadSettings();
  loadStats();
  loadRatings();
  loadLeads();
})();
</script>
<style>
/* Same padding as index / main content (main.css) */
main.dashboard-app { max-width: 100%; padding-left: 3.5rem; padding-right: 3.5rem; padding-top: 1.5rem; padding-bottom: 2rem; background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%); min-height: 60vh; }
@media (min-width: 769px) {
  main.dashboard-app { padding-left: 6rem; padding-right: 6rem; }
}
.dashboard-app { margin: 0 auto; }
.dashboard-tabs { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 0.75rem; margin-bottom: 1.5rem; padding: 0.25rem; background: var(--color-bg-alt, #f3f4f6); border-radius: 10px; }
.dashboard-tabs-left { display: flex; flex-wrap: wrap; gap: 0.25rem; }
.dashboard-plan-btn { flex-shrink: 0; padding: 0.5rem 1rem; font-size: 0.875rem; border-radius: 8px; text-decoration: none; }
.dashboard-tab { padding: 0.6rem 1.1rem; font-size: 0.9rem; font-weight: 500; color: var(--color-text-muted); background: transparent; border: none; border-radius: 8px; cursor: pointer; transition: color 0.2s, background 0.2s; }
.dashboard-tab:hover { color: var(--color-text); background: rgba(255,255,255,0.7); }
.dashboard-tab.active { color: #fff; background: var(--color-primary, #6366f1); }
.dashboard-table-section-title { font-size: 1.1rem; margin: 2rem 0 0.75rem; font-weight: 600; }
.dashboard-panel { display: block; }
.dashboard-panel[hidden] { display: none; }
.dashboard-panel.active { display: block; }
.dashboard-section { margin-bottom: 2rem; }
.dashboard-section h2 { font-size: 1.25rem; font-weight: 600; margin: 0 0 0.5rem; letter-spacing: -0.01em; }
.dashboard-desc { color: var(--color-text-muted); margin: 0 0 1rem; font-size: 0.9rem; line-height: 1.45; }
.dashboard-overview-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; align-items: start; }
.dashboard-overview-left .dashboard-qr-wrap { margin-top: 0.5rem; }
.dashboard-overview-right h2 { margin-bottom: 0.75rem; }
.dashboard-qr-wrap { text-align: center; padding: 1rem; background: #fff; border-radius: 16px; border: 1px solid var(--color-border); box-shadow: 0 1px 3px rgba(0,0,0,0.06); }
.dashboard-qr-img { display: block; margin: 0 auto 0.5rem; border-radius: 8px; }
.dashboard-qr-footer { font-weight: 600; margin: 0.5rem 0; font-size: 0.95rem; }
.dashboard-qr-url { margin: 0.5rem 0 1rem; word-break: break-all; font-size: 0.8rem; }
.dashboard-pie-wrap { display: flex; flex-direction: column; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem; }
.dashboard-pie { width: 160px; height: 160px; border-radius: 50%; background: var(--color-border); transition: background 0.3s; }
.dashboard-pie-legend { font-size: 0.9rem; color: var(--color-text-muted); }
.dashboard-stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; }
.dashboard-stat-card { padding: 1rem 1.25rem; background: #fff; border-radius: 12px; text-align: center; border: 1px solid var(--color-border); box-shadow: 0 1px 3px rgba(0,0,0,0.05); transition: box-shadow 0.2s; }
.dashboard-stat-card:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
.dashboard-stat-card.positive { border-color: rgba(34,197,94,0.4); background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); }
.dashboard-stat-card.negative { border-color: rgba(239,68,68,0.4); background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); }
.dashboard-stat-value { display: block; font-size: 1.5rem; font-weight: 700; letter-spacing: -0.02em; }
.dashboard-stat-label { font-size: 0.8rem; color: var(--color-text-muted); margin-top: 0.15rem; }
.btn.btn-icon { display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; padding: 0; border-radius: 10px; border: 1px solid var(--color-border); background: #fff; color: var(--color-text); transition: background 0.2s, border-color 0.2s; }
.btn.btn-icon:hover { background: var(--color-bg-alt, #f3f4f6); border-color: var(--color-primary, #6366f1); color: var(--color-primary, #6366f1); }
.dashboard-form .form-group { margin-bottom: 1rem; }
.dashboard-form .form-label { display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem; }
.dashboard-form label { display: block; margin-bottom: 0.25rem; font-weight: 500; font-size: 0.9rem; }
.review-platforms-multi { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-top: 0.25rem; }
.review-platforms-multi .platform-option { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 0.75rem; border: 1px solid var(--color-border); border-radius: 10px; background: #fff; cursor: pointer; font-size: 0.9rem; transition: border-color 0.2s, background 0.2s; }
.review-platforms-multi .platform-option:hover { border-color: var(--color-primary, #6366f1); background: var(--color-bg-alt, #f8fafc); }
.review-platforms-multi .platform-option input { margin: 0; width: 1rem; height: 1rem; accent-color: var(--color-primary, #6366f1); }
.review-platforms-multi .platform-icon { display: inline-flex; width: 24px; height: 24px; flex-shrink: 0; }
.review-platforms-multi .platform-icon svg { width: 100%; height: 100%; }
.dashboard-form .form-group-checkbox label.checkbox-label { display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 0; cursor: pointer; }
.dashboard-form .form-group-checkbox input[type="checkbox"] { width: 1.1rem; height: 1.1rem; margin: 0; flex-shrink: 0; accent-color: var(--color-primary, #6366f1); }
.dashboard-form input[type="text"], .dashboard-form input[type="url"], .dashboard-form select { width: 100%; max-width: 480px; padding: 0.55rem 0.75rem; border: 1px solid var(--color-border); border-radius: 10px; font-size: 0.95rem; }
.dashboard-form input:focus, .dashboard-form select:focus { outline: none; border-color: var(--color-primary, #6366f1); box-shadow: 0 0 0 3px rgba(99,102,241,0.15); }
.dashboard-save-status { margin-left: 0.5rem; color: var(--color-text-muted); font-size: 0.9rem; }
.dashboard-table-wrap { overflow-x: auto; border-radius: 12px; border: 1px solid var(--color-border); box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
.dashboard-table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
.dashboard-table th, .dashboard-table td { padding: 0.7rem 1rem; text-align: left; border-bottom: 1px solid var(--color-border); }
.dashboard-table th { background: var(--color-bg-alt, #f9fafb); font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.03em; color: var(--color-text-muted); }
.dashboard-table th.sortable { cursor: pointer; user-select: none; }
.dashboard-table th.sortable:hover { color: var(--color-text); }
.dashboard-table th.th-download { width: 48px; text-align: center; }
.dashboard-table th.th-download .btn-icon { width: 32px; height: 32px; }
.dashboard-table tbody tr:last-child td { border-bottom: none; }
.dashboard-table tbody tr:hover { background: rgba(0,0,0,0.02); }
.table-footer-cell { padding: 0.75rem 1rem; background: var(--color-bg-alt, #f9fafb); border-top: 1px solid var(--color-border); }
.dashboard-pagination { display: flex; align-items: center; justify-content: center; gap: 0.25rem; flex-wrap: wrap; }
.dashboard-pagination .pagination-nav { display: flex; align-items: center; gap: 0.2rem; }
.dashboard-pagination .pagination-btn { min-width: 2rem; height: 2rem; padding: 0 0.5rem; border: 1px solid var(--color-border); background: #fff; border-radius: 6px; font-size: 0.875rem; cursor: pointer; color: var(--color-text); }
.dashboard-pagination .pagination-btn:hover:not(:disabled) { background: var(--color-bg-alt, #f3f4f6); border-color: var(--color-primary, #6366f1); }
.dashboard-pagination .pagination-btn:disabled { opacity: 0.5; cursor: not-allowed; color: var(--color-text-muted); }
.dashboard-pagination .pagination-btn.active { background: var(--color-primary, #6366f1); border-color: var(--color-primary, #6366f1); color: #fff; }
.dashboard-pagination .pagination-pages { display: flex; gap: 0.2rem; }
.dashboard-settings-grid { display: grid; grid-template-columns: 1fr 320px; gap: 2rem; align-items: start; }
.dashboard-settings-preview { position: sticky; top: 1rem; }
.dashboard-settings-preview h3 { font-size: 1rem; margin: 0 0 0.75rem; color: var(--color-text-muted); }
.settings-preview-card { padding: 1.25rem; background: #fff; border: 1px solid var(--color-border); border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); font-size: 0.85rem; }
.settings-preview-card .preview-label { font-weight: 600; margin: 0 0 0.35rem; color: var(--color-text-muted); font-size: 0.75rem; text-transform: uppercase; }
.settings-preview-card .preview-qr-footer { margin: 0.5rem 0; font-weight: 600; }
.settings-preview-card .preview-stars { color: #fbbf24; letter-spacing: 0.1em; margin: 0.5rem 0; }
.settings-preview-card .preview-questions { margin-top: 1rem; }
.settings-preview-card .preview-q { margin: 0.35rem 0; padding-left: 0.5rem; border-left: 2px solid var(--color-border); color: var(--color-text); }
.settings-preview-card .preview-gift { margin-top: 1rem; }
.settings-preview-card .preview-gift-desc { margin: 0.25rem 0; }
.preview-gift-image-wrap { margin-top: 0.75rem; }
.settings-preview-gift-img { max-width: 100%; height: auto; max-height: 120px; border-radius: 8px; display: block; }
@media (max-width: 900px) { .dashboard-settings-grid { grid-template-columns: 1fr; } }
.rating-score-cell { white-space: nowrap; }
.rating-stars { font-size: 1rem; letter-spacing: 0.02em; }
.rating-star { color: #e5e7eb; }
.rating-star.filled { color: #fbbf24; }
.qa-cell { max-width: 320px; }
.qa-cell .qa-pair { margin-bottom: 0.35rem; font-size: 0.85rem; }
.qa-cell .qa-pair:last-child { margin-bottom: 0; }
@media (max-width: 768px) {
  .dashboard-overview-grid { grid-template-columns: 1fr; }
  .dashboard-stats-grid { grid-template-columns: 1fr; }
}
@media (max-width: 640px) { .dashboard-stats-grid { grid-template-columns: 1fr; } }
@media print {
  .dashboard-tabs { display: none !important; }
  .dashboard-plan-btn { display: none !important; }
  .dashboard-panel[hidden] { display: none !important; }
  .site-header, .site-footer, .back-to-top, .dashboard-overview-right { display: none !important; }
  .dashboard-qr-wrap { box-shadow: none; }
}
</style>
<?php require __DIR__ . '/../backend/includes/footer.php'; ?>
