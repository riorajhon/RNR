<?php
/**
 * Config: load .env (secrets) then set constants. No secrets in repo — use .env (see .env.example).
 * Base URL is derived from request; SITE_URL and DB/Stripe/SMTP come from env.
 */
require_once __DIR__ . '/load_env.php';

function env($key, $default = '') {
  $v = getenv($key);
  if ($v === false || $v === '') {
    $v = isset($_ENV[$key]) ? $_ENV[$key] : $default;
  }
  return is_string($v) ? $v : $default;
}

$is_test = in_array(strtolower(trim(env('ENVIRONMENT', ''))), ['test', 'local'], true);

if (!defined('BASE_URL')) {
  $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
  if (preg_match('#^(.*?)/(?:frontend|backend)/#', $script, $m)) {
    define('BASE_URL', $m[1] === '' ? '/' : $m[1] . '/');
  } else {
    define('BASE_URL', '/');
  }
}

if (!defined('SITE_URL')) {
  define('SITE_URL', $is_test ? '' : env('SITE_URL', ''));
}

if (!function_exists('get_base_url')) {
  function get_base_url() {
    if (defined('SITE_URL') && SITE_URL !== '') {
      return rtrim(SITE_URL, '/') . '/';
    }
    $b = defined('BASE_URL') ? BASE_URL : '/';
    $base = rtrim($b, '/') . ($b === '/' ? '' : '/');
    return ($base === '') ? '/' : $base;
  }
}

// Database (when ENVIRONMENT=test: local XAMPP defaults)
if (!defined('DB_HOST')) { define('DB_HOST', $is_test ? 'localhost' : env('DB_HOST', 'localhost')); }
if (!defined('DB_NAME')) { define('DB_NAME', $is_test ? 'onetxt' : env('DB_NAME', 'onetxt')); }
if (!defined('DB_USER')) { define('DB_USER', $is_test ? 'root' : env('DB_USER', 'root')); }
if (!defined('DB_PASS')) { define('DB_PASS', $is_test ? '' : env('DB_PASS', '')); }

// Stripe (when ENVIRONMENT=test: empty so no live charges)
if (!defined('STRIPE_PUBLISHABLE_KEY')) { define('STRIPE_PUBLISHABLE_KEY', $is_test ? '' : env('STRIPE_PUBLISHABLE_KEY', '')); }
if (!defined('STRIPE_SECRET_KEY'))       { define('STRIPE_SECRET_KEY',       $is_test ? '' : env('STRIPE_SECRET_KEY', '')); }
if (!defined('STRIPE_MONTHLY_LINK'))     { define('STRIPE_MONTHLY_LINK',     $is_test ? '' : env('STRIPE_MONTHLY_LINK', 'https://buy.stripe.com/your-monthly-link')); }
if (!defined('STRIPE_ANNUAL_LINK'))      { define('STRIPE_ANNUAL_LINK',      $is_test ? '' : env('STRIPE_ANNUAL_LINK', 'https://buy.stripe.com/your-annual-link')); }
if (!defined('STRIPE_PRICE_ID_MONTHLY')) { define('STRIPE_PRICE_ID_MONTHLY', $is_test ? '' : env('STRIPE_PRICE_ID_MONTHLY', '')); }
if (!defined('STRIPE_PRICE_ID_YEARLY'))  { define('STRIPE_PRICE_ID_YEARLY',  $is_test ? '' : env('STRIPE_PRICE_ID_YEARLY', '')); }
if (!defined('STRIPE_WEBHOOK_SECRET'))   { define('STRIPE_WEBHOOK_SECRET',   $is_test ? '' : env('STRIPE_WEBHOOK_SECRET', '')); }
if (!defined('STRIPE_PRODUCT_ID'))       { define('STRIPE_PRODUCT_ID',       $is_test ? '' : env('STRIPE_PRODUCT_ID', '')); }
if (!defined('STRIPE_PRODUCT_ID_MONTHLY')) { define('STRIPE_PRODUCT_ID_MONTHLY', $is_test ? '' : env('STRIPE_PRODUCT_ID_MONTHLY', '')); }
if (!defined('STRIPE_PRODUCT_ID_YEARLY'))  { define('STRIPE_PRODUCT_ID_YEARLY',  $is_test ? '' : env('STRIPE_PRODUCT_ID_YEARLY', '')); }

// Contact & admin (from .env)
if (!defined('CONTACT_EMAIL')) { define('CONTACT_EMAIL', env('CONTACT_EMAIL', 'mail@myratings.online')); }
if (!defined('ADMIN_EMAIL'))   { define('ADMIN_EMAIL',   env('ADMIN_EMAIL', 'riorajhon19930303@gmail.com')); }

// SMTP (when ENVIRONMENT=test: empty, use PHP mail())
if (!defined('CONTACT_SMTP_HOST'))   { define('CONTACT_SMTP_HOST',   $is_test ? '' : env('CONTACT_SMTP_HOST', '')); }
if (!defined('CONTACT_SMTP_PORT'))   { define('CONTACT_SMTP_PORT',   $is_test ? '587' : env('CONTACT_SMTP_PORT', '587')); }
if (!defined('CONTACT_SMTP_USER'))   { define('CONTACT_SMTP_USER',   $is_test ? '' : env('CONTACT_SMTP_USER', '')); }
if (!defined('CONTACT_SMTP_PASS'))  { define('CONTACT_SMTP_PASS',   $is_test ? '' : env('CONTACT_SMTP_PASS', '')); }
if (!defined('CONTACT_SMTP_SECURE')) { define('CONTACT_SMTP_SECURE', $is_test ? 'tls' : env('CONTACT_SMTP_SECURE', 'tls')); }
