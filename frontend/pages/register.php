<?php
require_once __DIR__ . '/../../backend/config.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$base_url = get_base_url();
$register_error = isset($_GET['error']) ? trim($_GET['error']) : '';
$_SESSION['csrf_token'] = bin2hex(random_bytes(16));
$page_title = 'Sign Up | 1TXT';
require __DIR__ . '/../../backend/includes/header.php';
?>
<main class="page-auth">
  <div class="form-card">
    <h1>Sign up your business</h1>
    <p class="form-subtitle">Create your account to get started with better ratings.</p>
    <div class="form-error" id="form-error" role="alert" aria-live="polite" <?php echo $register_error === '' ? 'hidden' : ''; ?>><?php echo htmlspecialchars($register_error); ?></div>
    <form action="<?php echo htmlspecialchars($base_url); ?>backend/api/auth.php" method="post" id="auth-form">
      <input type="hidden" name="action" value="signup">
      <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
      <div class="form-group">
        <label for="name">Full name</label>
        <input type="text" id="name" name="name" required minlength="2" maxlength="100" autocomplete="name" placeholder="Your name">
      </div>
      <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" id="email" name="email" required autocomplete="email" placeholder="you@example.com">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required minlength="8" autocomplete="new-password" placeholder="••••••••">
        <span class="form-hint">At least 8 characters</span>
      </div>
      <div class="form-group">
        <label for="password_confirm">Confirm password</label>
        <input type="password" id="password_confirm" name="password_confirm" required minlength="8" autocomplete="new-password" placeholder="••••••••">
      </div>
      <button type="submit" class="btn btn-primary">Sign Up</button>
    </form>
    <p class="form-footer">Have an account? <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/login.php">Sign in</a></p>
    <p class="form-back"><a href="<?php echo htmlspecialchars($base_url); ?>frontend/index.php">← Back to Home</a></p>
  </div>
</main>
<script>
(function() {
  var form = document.getElementById('auth-form');
  var errorEl = document.getElementById('form-error');
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    errorEl.hidden = true;
    errorEl.textContent = '';
    var p = document.getElementById('password').value;
    var pc = document.getElementById('password_confirm').value;
    if (p !== pc) {
      errorEl.textContent = 'Passwords do not match.';
      errorEl.hidden = false;
      return;
    }
    if (p.length < 8) {
      errorEl.textContent = 'Password must be at least 8 characters.';
      errorEl.hidden = false;
      return;
    }
    var fd = new FormData(form);
    fetch(form.action, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' }, body: fd })
      .then(function(r) { return r.json().then(function(j) { return { ok: r.ok, json: j }; }); })
      .then(function(x) {
        if (x.ok && x.json.redirect) {
          var base = '<?php echo htmlspecialchars($base_url, ENT_QUOTES, 'UTF-8'); ?>';
          var urls = { home: base + 'frontend/index.php', login: base + 'frontend/pages/login.php', dashboard: base + 'frontend/dashboard.php', pricing: base + 'frontend/pages/pricing.php' };
          window.location.href = urls[x.json.redirect] || (base + x.json.redirect);
        } else if (x.json.error) {
          errorEl.textContent = x.json.error;
          errorEl.hidden = false;
        }
      })
      .catch(function() { form.submit(); });
  });
})();
</script>
<?php require __DIR__ . '/../../backend/includes/footer.php'; ?>
