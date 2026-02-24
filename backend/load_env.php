<?php
/**
 * Load .env from project root into $_ENV and putenv() for getenv().
 * Call once at start of config. .env is never committed (add to .gitignore).
 */
$env_file = dirname(__DIR__) . '/.env';
if (!is_file($env_file) || !is_readable($env_file)) {
  return;
}
$lines = file($env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
if ($lines === false) {
  return;
}
foreach ($lines as $line) {
  $line = trim($line);
  if ($line === '' || strpos($line, '#') === 0) {
    continue;
  }
  $eq = strpos($line, '=');
  if ($eq === false) {
    continue;
  }
  $key = trim(substr($line, 0, $eq));
  $value = trim(substr($line, $eq + 1));
  if ($key === '') {
    continue;
  }
  if (preg_match('/^(["\'])(.*)\\1$/', $value, $m)) {
    $value = str_replace(['\\n', '\\r'], ["\n", "\r"], $m[2]);
  }
  $_ENV[$key] = $value;
  putenv($key . '=' . $value);
}
