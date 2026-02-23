<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$base_url = isset($base_url) ? $base_url : get_base_url();
$page_title = isset($page_title) ? $page_title : 'RNR - Better Ratings for Your Business';
$is_logged_in = !empty($_SESSION['user_id']);
$logout_url = $base_url . 'backend/logout.php';

// Load current profile photo and name from DB so header always shows latest (e.g. after avatar upload)
$header_profile_photo = null;
$header_user_name = $_SESSION['user_name'] ?? 'User';
if ($is_logged_in && !empty($_SESSION['user_id'])) {
  require_once __DIR__ . '/db.php';
  $stmt = $pdo->prepare("SELECT name, profile_photo FROM users WHERE id = ?");
  $stmt->execute([(int) $_SESSION['user_id']]);
  $row = $stmt->fetch();
  if ($row) {
    $header_user_name = $row['name'] ?? $header_user_name;
    $header_profile_photo = !empty(trim($row['profile_photo'] ?? '')) ? trim($row['profile_photo']) : null;
    $_SESSION['profile_photo'] = $header_profile_photo;
    $_SESSION['user_name'] = $header_user_name;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($page_title); ?></title>
  <link rel="icon" href="<?php echo htmlspecialchars($base_url); ?>images/homepage/mark.png" type="image/png">
  <link rel="stylesheet" href="<?php echo htmlspecialchars($base_url); ?>frontend/css/main.css">
  <link rel="stylesheet" href="<?php echo htmlspecialchars($base_url); ?>frontend/css/modern-pages.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Lora:ital,wght@0,400;0,600;1,400;1,600&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
</head>
<body>
<header class="site-header">
  <div class="site-header-inner">
    <button class="menu-toggle" aria-label="Menu" type="button">☰</button>
    <nav class="site-nav">
      <a href="<?php echo htmlspecialchars($base_url); ?>frontend/index.php">Home</a>
      <div class="nav-dropdown">
        <button class="nav-dropdown-trigger" type="button">More ▾</button>
        <div class="nav-dropdown-menu">
          <?php if ($is_logged_in): ?>
            <a href="<?php echo htmlspecialchars($base_url); ?>frontend/dashboard.php">Dashboard</a>
            <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/settings.php">Settings</a>
          <?php else: ?>
            <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/register.php">Sign Up</a>
            <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/login.php">Sign In</a>
          <?php endif; ?>
          <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/data-security.php">Data Security</a>
          <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/pricing.php">Pricing</a>
          <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/case-studies.php">Case Studies</a>
        </div>
      </div>
      <?php if ($is_logged_in): ?>
        <div class="header-user-dropdown">
          <button type="button" class="header-user-trigger" id="header-user-trigger" aria-expanded="false" aria-haspopup="true" aria-label="Account menu">
            <?php
            $photo = $header_profile_photo;
            $name = $header_user_name;
            $initial = mb_substr(trim($name), 0, 1);
            if ($photo): 
              $avatar_src = $base_url . (strpos($photo, '/') === 0 ? ltrim($photo, '/') : $photo);
            ?>
              <img src="<?php echo htmlspecialchars($avatar_src); ?>" alt="" class="header-avatar-img" width="36" height="36">
            <?php else: ?>
              <span class="header-avatar-initial"><?php echo htmlspecialchars(mb_strtoupper($initial)); ?></span>
            <?php endif; ?>
          </button>
          <div class="header-user-menu" id="header-user-menu" hidden>
            <a href="<?php echo htmlspecialchars($base_url); ?>frontend/dashboard.php">Dashboard</a>
            <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/settings.php">Settings</a>
            <a href="<?php echo htmlspecialchars($logout_url); ?>">Logout</a>
          </div>
        </div>
      <?php else: ?>
        <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/login.php" class="btn btn-outline">Sign In</a>
        <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/register.php" class="btn btn-primary">Get Started</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
<?php if ($is_logged_in): ?>
<script>
(function() {
  var trigger = document.getElementById('header-user-trigger');
  var menu = document.getElementById('header-user-menu');
  if (trigger && menu) {
    trigger.addEventListener('click', function(e) {
      e.stopPropagation();
      var open = menu.hidden;
      menu.hidden = !open;
      trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    document.addEventListener('click', function() {
      menu.hidden = true;
      trigger.setAttribute('aria-expanded', 'false');
    });
  }
})();
</script>
<?php endif; ?>
