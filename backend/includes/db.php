<?php
/**
 * Database connection (MySQL). Set credentials in config.cpanel.php (cPanel)
 * or via environment variables.
 */
if (file_exists(__DIR__ . '/../config.cpanel.php')) {
  require_once __DIR__ . '/../config.cpanel.php';
}
$db_config = [
  'host' => defined('DB_HOST') ? DB_HOST : (getenv('DB_HOST') ?: 'localhost'),
  'name' => defined('DB_NAME') ? DB_NAME : (getenv('DB_NAME') ?: 'onetxt'),
  'user' => defined('DB_USER') ? DB_USER : (getenv('DB_USER') ?: 'root'),
  'pass' => defined('DB_PASS') ? DB_PASS : (getenv('DB_PASS') ?: ''),
  'charset' => 'utf8mb4',
];

$dsn = "mysql:host={$db_config['host']};dbname={$db_config['name']};charset={$db_config['charset']}";
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
  $pdo = new PDO($dsn, $db_config['user'], $db_config['pass'], $options);
} catch (PDOException $e) {
  if (php_sapi_name() === 'cli') {
    throw $e;
  }
  $is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
  if ($is_ajax) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['error' => 'Database unavailable']);
    exit;
  }
  $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
  $base = (preg_match('#^(.*?)/backend/#', $script, $m)) ? ($m[1] === '' ? '/' : $m[1] . '/') : '/';
  $home_link = htmlspecialchars($base . 'frontend/index.php', ENT_QUOTES, 'UTF-8');
  $login_link = htmlspecialchars($base . 'frontend/pages/login.php', ENT_QUOTES, 'UTF-8');
  header('Content-Type: text/html; charset=utf-8');
  http_response_code(503);
  $msg = htmlspecialchars('Database unavailable. Please try again later.', ENT_QUOTES, 'UTF-8');
  echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Error</title><style>
  body { font-family: system-ui, -apple-system, sans-serif; margin: 0; padding: 2rem; min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #f5f5f5; }
  .notification { background: #fff; padding: 1.5rem 2rem; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); max-width: 400px; text-align: center; border-left: 4px solid #dc2626; }
  .notification h2 { margin: 0 0 0.5rem; font-size: 1.25rem; color: #111; }
  .notification p { margin: 0 0 1rem; color: #555; }
  .notification a { color: #2563eb; text-decoration: none; margin: 0 0.5rem; }
  .notification a:hover { text-decoration: underline; }
  </style></head><body><div class="notification"><h2>Something went wrong</h2><p>' . $msg . '</p><p><a href="' . $home_link . '">Home</a><a href="' . $login_link . '">Sign In</a></p></div></body></html>';
  exit;
}
