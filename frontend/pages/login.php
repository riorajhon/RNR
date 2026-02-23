<?php
require_once __DIR__ . '/../../backend/config.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$base_url = get_base_url();
$login_redirect = isset($_GET['redirect']) ? trim($_GET['redirect']) : '';
$login_error = isset($_GET['error']) ? trim($_GET['error']) : '';
$_SESSION['csrf_token'] = bin2hex(random_bytes(16));
$page_title = 'Sign In | 1TXT';
require __DIR__ . '/../../backend/includes/header.php';
?>
<main class="page-auth">
  <div class="form-card">
    <h1>Sign in to your account</h1>
    <p class="form-subtitle">Welcome back. Enter your details to continue.</p>
    <div class="form-error" id="form-error" role="alert" aria-live="polite" <?php echo $login_error === '' ? 'hidden' : ''; ?>><?php echo htmlspecialchars($login_error); ?></div>
    <form action="<?php echo htmlspecialchars($base_url); ?>backend/api/auth.php" method="post" id="auth-form">
      <input type="hidden" name="action" value="login">
      <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
      <?php if ($login_redirect !== ''): ?><input type="hidden" name="redirect" value="<?php echo htmlspecialchars($login_redirect); ?>"><?php endif; ?>
      <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" id="email" name="email" required autocomplete="email" placeholder="you@example.com">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="••••••••">
      </div>
      <div class="form-options">
        <label class="form-option-label"><input type="checkbox" id="show_password" name="show_password" aria-label="Show password"> Show password</label>
        <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/forgot-password.php">Forgot password?</a>
      </div>
      <button type="submit" class="btn btn-primary">Sign In</button>
    </form>
    <p class="form-footer">Don't have an account? <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/register.php">Sign up your business</a></p>
    <p class="form-back"><a href="<?php echo htmlspecialchars($base_url); ?>frontend/index.php">← Back to Home</a></p>
  </div>
</main>
<script>
(function() {
  var form = document.getElementById('auth-form');
  var errorEl = document.getElementById('form-error');
  document.getElementById('show_password').addEventListener('change', function() {
    document.getElementById('password').type = this.checked ? 'text' : 'password';
  });
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    errorEl.hidden = true;
    errorEl.textContent = '';
    var fd = new FormData(form);
    fetch(form.action, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' }, body: fd })
      .then(function(r) { return r.json().then(function(j) { return { ok: r.ok, json: j }; }); })
      .then(function(x) {
        if (x.ok && x.json.redirect) {
          var base = '<?php echo htmlspecialchars($base_url, ENT_QUOTES, 'UTF-8'); ?>';
          var urls = { home: base + 'frontend/index.php', login: base + 'frontend/pages/login.php', dashboard: base + 'frontend/dashboard.php', pricing: base + 'frontend/pages/pricing.php' };
          var target = urls[x.json.redirect] || x.json.redirect;
          if (target.indexOf(base) === 0 || target.indexOf('/') === 0) { window.location.href = target; }
          else { window.location.href = urls.dashboard; }
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
