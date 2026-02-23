<?php
require_once __DIR__ . '/../../backend/config.php';
$base_url = get_base_url();
$page_title = 'Forgot Password | 1TXT';
require __DIR__ . '/../../backend/includes/header.php';
?>
<main class="page-auth">
  <div class="form-card">
    <h1>Forgot your password?</h1>
    <p class="form-subtitle">Enter your email and we'll send you a reset link.</p>
    <div class="form-error" id="form-error" role="alert" aria-live="polite" hidden></div>
    <div class="form-success" id="form-success" role="status" aria-live="polite" hidden></div>
    <form action="<?php echo htmlspecialchars($base_url); ?>backend/api/auth.php" method="post" id="forgot-form">
      <input type="hidden" name="action" value="forgot">
      <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" id="email" name="email" required autocomplete="email" placeholder="you@example.com">
      </div>
      <button type="submit" class="btn btn-primary">Send reset link</button>
    </form>
    <p class="form-footer"><a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/login.php">Back to Sign in</a></p>
    <p class="form-back"><a href="<?php echo htmlspecialchars($base_url); ?>frontend/index.php">← Back to Home</a></p>
  </div>
</main>
<script>
(function() {
  var form = document.getElementById('forgot-form');
  var errorEl = document.getElementById('form-error');
  var successEl = document.getElementById('form-success');
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    errorEl.hidden = true;
    successEl.hidden = true;
    errorEl.textContent = '';
    successEl.textContent = '';
    var fd = new FormData(form);
    fetch(form.action, { method: 'POST', body: fd })
      .then(function(r) { return r.json().then(function(j) { return { ok: r.ok, json: j }; }); })
      .then(function(x) {
        if (x.ok && x.json.message) {
          successEl.textContent = x.json.message;
          successEl.hidden = false;
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
