<?php
session_start();
require_once __DIR__ . '/../../backend/config.php';
require_once __DIR__ . '/../../backend/includes/db.php';
$base_url = get_base_url();
if (empty($_SESSION['user_id'])) {
  header('Location: ' . $base_url . 'frontend/pages/login.php');
  exit;
}
$user_id = (int) $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT name, profile_photo FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
$user_name = $user ? ($user['name'] ?? $_SESSION['user_name'] ?? '') : ($_SESSION['user_name'] ?? '');
$user_photo = $user && !empty(trim($user['profile_photo'] ?? '')) ? trim($user['profile_photo']) : null;
$page_title = 'Account Settings | 1TXT';
require __DIR__ . '/../../backend/includes/header.php';
?>
<main class="page-auth">
  <div class="form-card" style="max-width: 480px;">
    <h1>Account settings</h1>
    <p class="form-subtitle">Update your profile and password.</p>
    <div class="form-error" id="form-error" role="alert" hidden></div>
    <div class="form-success" id="form-success" role="status" hidden></div>

    <div class="settings-avatar-wrap" style="margin-bottom: 1.5rem;">
      <?php
      $photo_url = $user_photo ? ($base_url . (strpos($user_photo, '/') === 0 ? ltrim($user_photo, '/') : $user_photo)) : '';
      $initial = mb_substr(trim($user_name), 0, 1);
      if ($photo_url): ?>
        <img src="<?php echo htmlspecialchars($photo_url); ?>" alt="Profile" class="settings-avatar-img" id="settings-avatar-preview" width="80" height="80">
      <?php else: ?>
        <span class="settings-avatar-initial" id="settings-avatar-preview"><?php echo htmlspecialchars(mb_strtoupper($initial)); ?></span>
      <?php endif; ?>
    </div>

    <form id="profile-form">
      <div class="form-group">
        <label for="name">Full name</label>
        <input type="text" id="name" name="name" required minlength="2" value="<?php echo htmlspecialchars($user_name); ?>">
      </div>
      <div class="form-group">
        <label for="profile_photo">Profile photo (optional)</label>
        <input type="file" id="profile_photo" name="profile_photo" accept="image/*">
      </div>
      <button type="submit" class="btn btn-primary">Save profile</button>
    </form>

    <hr style="margin: 2rem 0; border: none; border-top: 1px solid var(--color-border);">

    <h2 style="font-size: 1.1rem; margin-bottom: 0.5rem;">Change password</h2>
    <form id="password-form">
      <div class="form-group">
        <label for="current_password">Current password</label>
        <input type="password" id="current_password" name="current_password" required>
      </div>
      <div class="form-group">
        <label for="new_password">New password</label>
        <input type="password" id="new_password" name="new_password" required minlength="8">
      </div>
      <button type="submit" class="btn btn-outline">Update password</button>
    </form>

    <hr style="margin: 2rem 0; border: none; border-top: 1px solid var(--color-border);">

    <h2 style="font-size: 1.1rem; margin-bottom: 0.5rem;">Delete account</h2>
    <p class="form-subtitle" style="margin-bottom: 1rem;">Permanently delete your account and all data. This cannot be undone.</p>
    <form id="delete-form">
      <div class="form-group">
        <label for="confirm_delete">Type DELETE to confirm</label>
        <input type="text" id="confirm_delete" name="confirm" placeholder="DELETE" required>
      </div>
      <button type="submit" class="btn btn-outline" style="border-color: #dc2626; color: #dc2626;">Delete my account</button>
    </form>

    <p class="form-back" style="margin-top: 2rem;"><a href="<?php echo htmlspecialchars($base_url); ?>frontend/dashboard.php">← Back to Dashboard</a></p>
  </div>
</main>
<script>
(function() {
  var base = '<?php echo htmlspecialchars($base_url, ENT_QUOTES, 'UTF-8'); ?>';
  function msg(el, text, isError) {
    var err = document.getElementById('form-error');
    var ok = document.getElementById('form-success');
    err.hidden = true; ok.hidden = true;
    (isError ? err : ok).textContent = text;
    (isError ? err : ok).hidden = false;
  }
  document.getElementById('profile-form').addEventListener('submit', function(e) {
    e.preventDefault();
    var fd = new FormData(this);
    fd.append('action', 'profile');
    fetch(base + 'backend/api/account.php', { method: 'POST', credentials: 'same-origin', body: fd })
      .then(function(r) { return r.json(); })
      .then(function(j) {
        msg(null, j.error ? j.error : 'Profile saved.', !!j.error);
        if (j.success) window.location.reload();
      })
      .catch(function() { msg(null, 'Error', true); });
  });
  document.getElementById('password-form').addEventListener('submit', function(e) {
    e.preventDefault();
    var fd = new FormData(this);
    fd.append('action', 'password');
    fd.append('current_password', document.getElementById('current_password').value);
    fd.append('new_password', document.getElementById('new_password').value);
    fetch(base + 'backend/api/account.php', { method: 'POST', credentials: 'same-origin', body: fd })
      .then(function(r) { return r.json(); })
      .then(function(j) {
        msg(null, j.error ? j.error : 'Password updated.', !!j.error);
        if (j.success) document.getElementById('password-form').reset();
      })
      .catch(function() { msg(null, 'Error', true); });
  });
  document.getElementById('delete-form').addEventListener('submit', function(e) {
    e.preventDefault();
    if (!confirm('Really delete your account and all data? This cannot be undone.')) return;
    var fd = new FormData(this);
    fd.append('action', 'delete');
    fd.append('confirm', document.getElementById('confirm_delete').value);
    fetch(base + 'backend/api/account.php', { method: 'POST', credentials: 'same-origin', body: fd })
      .then(function(r) { return r.json(); })
      .then(function(j) {
        if (j.success && j.redirect) window.location.href = base + 'frontend/index.php';
        else msg(null, j.error || 'Error', true);
      })
      .catch(function() { msg(null, 'Error', true); });
  });
})();
</script>
<?php require __DIR__ . '/../../backend/includes/footer.php'; ?>
