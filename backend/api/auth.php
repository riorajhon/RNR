<?php
/**
 * Auth API: login, signup, forgot password.
 * POST: action=login|signup|forgot, email, password (and name, password_confirm for signup).
 * login/signup require csrf_token from session.
 * If request is not AJAX (no X-Requested-With header), outputs HTML that redirects so form POST works without JS.
 */
session_start();

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/db.php';

$is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

function auth_send_json($data) {
  header('Content-Type: application/json');
  echo json_encode($data);
}

function auth_redirect_url($key) {
  $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
  if (preg_match('#^(.*?)/backend/#', $script, $m)) {
    $base = ($m[1] === '' ? '/' : $m[1] . '/');
  } else {
    $base = get_base_url();
  }
  $urls = [
    'home' => $base . 'frontend/index.php',
    'login' => $base . 'frontend/pages/login.php',
    'register' => $base . 'frontend/pages/register.php',
    'dashboard' => $base . 'frontend/dashboard.php',
    'pricing' => $base . 'frontend/pages/pricing.php',
  ];
  return isset($urls[$key]) ? $urls[$key] : $base . 'frontend/index.php';
}

function auth_send_redirect_page($url) {
  header('Content-Type: text/html; charset=utf-8');
  $url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
  echo '<!DOCTYPE html><html><head><meta charset="utf-8"><meta http-equiv="refresh" content="0;url=' . $url . '"><script>location.href=' . json_encode($url) . ';</script></head><body><p>Redirecting… <a href="' . $url . '">Continue</a></p></body></html>';
}

function auth_send_error($message, $code = 400, $redirect_key = 'login') {
  global $is_ajax;
  if ($is_ajax) {
    http_response_code($code);
    auth_send_json(['error' => $message]);
  } else {
    header('Location: ' . auth_redirect_url($redirect_key) . '?error=' . urlencode($message));
  }
  exit;
}

$action = $_POST['action'] ?? '';
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$name = trim($_POST['name'] ?? '');
$password_confirm = $_POST['password_confirm'] ?? '';
$csrf = $_POST['csrf_token'] ?? '';

if (!in_array($action, ['login', 'signup', 'forgot'], true)) {
  auth_send_error('Invalid action', 400);
}

if ($action === 'login' || $action === 'signup') {
  if (empty($_SESSION['csrf_token']) || !hash_equals((string) $_SESSION['csrf_token'], (string) $csrf)) {
    auth_send_error('Invalid request. Please refresh the page and try again.', 403);
  }
}

if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
  auth_send_error('Please enter a valid email address.', 400);
}

if ($action === 'signup') {
  if (strlen($name) < 2) {
    auth_send_error('Please enter your name.', 400, 'register');
  }
  if (strlen($password) < 8) {
    auth_send_error('Password must be at least 8 characters.', 400, 'register');
  }
  if ($password !== $password_confirm) {
    auth_send_error('Passwords do not match.', 400, 'register');
  }
  $hash = password_hash($password, PASSWORD_DEFAULT);
  try {
    $stmt = $pdo->prepare("INSERT INTO users (email, password_hash, name) VALUES (?, ?, ?)");
    $stmt->execute([$email, $hash, $name]);
    $userId = $pdo->lastInsertId();
    $pdo->prepare("INSERT INTO business_settings (user_id) VALUES (?)")->execute([$userId]);
    $_SESSION['user_id'] = (int) $userId;
    $_SESSION['user_name'] = $name;
    session_regenerate_id(true);
    $url = auth_redirect_url('pricing');
    if ($is_ajax) {
      auth_send_json(['success' => true, 'redirect' => 'pricing']);
    } else {
      auth_send_redirect_page($url);
    }
  } catch (PDOException $e) {
    if ($e->getCode() == 23000 || (isset($e->errorInfo[1]) && $e->errorInfo[1] == 1062)) {
      auth_send_error('This email is already registered. Sign in or use a different email.', 409, 'register');
    } else {
      auth_send_error('Registration failed. Please try again.', 500, 'register');
    }
  }
  exit;
}

if ($action === 'forgot') {
  // TODO: send reset email; for now just acknowledge
  auth_send_json(['success' => true, 'message' => 'If an account exists with this email, you will receive a reset link.']);
  exit;
}

// login
$stmt = $pdo->prepare("SELECT id, password_hash, name, profile_photo FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();
if (!$user || !password_verify($password, $user['password_hash'])) {
  $msg = 'Invalid email or password.';
  http_response_code(401);
  if ($is_ajax) {
    auth_send_json(['error' => $msg]);
  } else {
    header('Location: ' . auth_redirect_url('login') . '?error=' . urlencode($msg));
  }
  exit;
}

session_regenerate_id(true);
$_SESSION['user_id'] = (int) $user['id'];
$_SESSION['user_name'] = $user['name'];
$_SESSION['profile_photo'] = !empty($user['profile_photo']) ? $user['profile_photo'] : null;
$redirect_param = trim($_POST['redirect'] ?? '');
$base = (preg_match('#^(.*?)/backend/#', str_replace('\\', '/', $_SERVER['SCRIPT_NAME']), $m) ? ($m[1] === '' ? '/' : $m[1] . '/') : get_base_url());
$safe_redirect = ($redirect_param !== '' && (strpos($redirect_param, $base) === 0 || strpos($redirect_param, '/') === 0));
$url = $safe_redirect ? $redirect_param : auth_redirect_url('dashboard');
if ($is_ajax) {
  auth_send_json(['success' => true, 'redirect' => $url]);
} else {
  auth_send_redirect_page($url);
}
