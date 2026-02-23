<?php
/**
 * Account API: update profile (name, password, profile_photo), delete account.
 */
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/subscription.php';

if (empty($_SESSION['user_id'])) {
  http_response_code(401);
  echo json_encode(['error' => 'Unauthorized']);
  exit;
}
$user_id = (int) $_SESSION['user_id'];

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'profile' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name'] ?? '');
  if (strlen($name) < 2) {
    http_response_code(400);
    echo json_encode(['error' => 'Name must be at least 2 characters']);
    exit;
  }
  $pdo->prepare("UPDATE users SET name = ? WHERE id = ?")->execute([$name, $user_id]);
  $_SESSION['user_name'] = $name;
  if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
    $ext = strtolower(pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION));
    if (in_array($ext, ['jpg','jpeg','png','gif','webp'], true)) {
      $dir = dirname(__DIR__, 2) . '/images/uploads';
      if (!is_dir($dir)) mkdir($dir, 0755, true);
      $path = 'images/uploads/profile_' . $user_id . '_' . time() . '.' . $ext;
      if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], dirname(__DIR__, 2) . '/' . $path)) {
        $pdo->prepare("UPDATE users SET profile_photo = ? WHERE id = ?")->execute([$path, $user_id]);
        $_SESSION['profile_photo'] = $path;
      }
    }
  }
  echo json_encode(['success' => true]);
  exit;
}

if ($action === 'password' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $current = $_POST['current_password'] ?? '';
  $new = $_POST['new_password'] ?? '';
  if (strlen($new) < 8) {
    http_response_code(400);
    echo json_encode(['error' => 'New password must be at least 8 characters']);
    exit;
  }
  $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE id = ?");
  $stmt->execute([$user_id]);
  $hash = $stmt->fetchColumn();
  if (!password_verify($current, $hash)) {
    http_response_code(400);
    echo json_encode(['error' => 'Current password is incorrect']);
    exit;
  }
  $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?")->execute([password_hash($new, PASSWORD_DEFAULT), $user_id]);
  echo json_encode(['success' => true]);
  exit;
}

if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $confirm = trim($_POST['confirm'] ?? '');
  if (strtoupper($confirm) !== 'DELETE') {
    http_response_code(400);
    echo json_encode(['error' => 'Type DELETE to confirm']);
    exit;
  }
  $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$user_id]);
  $_SESSION = [];
  if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 3600, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
  }
  session_destroy();
  echo json_encode(['success' => true, 'redirect' => 'home']);
  exit;
}

http_response_code(400);
echo json_encode(['error' => 'Invalid action']);
