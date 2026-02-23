<?php
session_start();
$_SESSION = [];
if (ini_get('session.use_cookies')) {
  $p = session_get_cookie_params();
  setcookie(session_name(), '', time() - 3600, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}
session_destroy();
$script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
$base = preg_match('#^(.*?)/backend/#', $script, $m) ? ($m[1] === '' ? '/' : $m[1] . '/') : '/';
$home = $base . 'frontend/index.php';
header('Location: ' . $home);
exit;
