<?php
/**
 * Base URL for links and assets. Document root is project folder (new/).
 * Links use: BASE_URL . 'frontend/...' or BASE_URL . 'image/...'
 */
if (file_exists(__DIR__ . '/config.cpanel.php')) {
  require_once __DIR__ . '/config.cpanel.php';
}
if (!defined('BASE_URL')) {
  $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
  // Match both /frontend/ and /backend/ so BASE_URL is correct when create-checkout.php or webhook runs
  if (preg_match('#^(.*?)/(?:frontend|backend)/#', $script, $m)) {
    define('BASE_URL', $m[1] === '' ? '/' : $m[1] . '/');
  } else {
    define('BASE_URL', '/');
  }
}
// Optional: full public URL for QR code and links (e.g. https://myratings.online). Set in config.cpanel.php so QR works after deploy.
if (!defined('SITE_URL')) {
  define('SITE_URL', '');
}

/**
 * Base URL for links and redirects (never empty). Use this so localhost with BASE_URL '/' gets '/' not '', avoiding frontend/frontend/ double path.
 */
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

// Stripe (optional). Copy backend/config.stripe-sample.php to config.stripe.php and set keys + Payment Link URLs.
$stripe_config = __DIR__ . '/config.stripe.php';
if (file_exists($stripe_config)) {
  require_once $stripe_config;
}
if (!defined('STRIPE_MONTHLY_LINK')) {
  define('STRIPE_MONTHLY_LINK', 'https://buy.stripe.com/your-monthly-link');
}
if (!defined('STRIPE_ANNUAL_LINK')) {
  define('STRIPE_ANNUAL_LINK', 'https://buy.stripe.com/your-annual-link');
}
if (!defined('STRIPE_PRICE_ID_MONTHLY')) {
  define('STRIPE_PRICE_ID_MONTHLY', '');
}
if (!defined('STRIPE_PRICE_ID_YEARLY')) {
  define('STRIPE_PRICE_ID_YEARLY', '');
}
if (!defined('STRIPE_WEBHOOK_SECRET')) {
  define('STRIPE_WEBHOOK_SECRET', '');
}
if (!defined('STRIPE_PRODUCT_ID_MONTHLY')) {
  define('STRIPE_PRODUCT_ID_MONTHLY', '');
}
if (!defined('STRIPE_PRODUCT_ID_YEARLY')) {
  define('STRIPE_PRODUCT_ID_YEARLY', '');
}
// One product with two prices: set this and leave PRODUCT_ID_MONTHLY/YEARLY empty, or set PRODUCT_ID_MONTHLY only
if (!defined('STRIPE_PRODUCT_ID')) {
  define('STRIPE_PRODUCT_ID', '');
}

// Contact form: submissions are emailed to this address
if (!defined('CONTACT_EMAIL')) {
  define('CONTACT_EMAIL', 'mail@myratings.online');
}

// Admin email: this user can access dashboard and all features without a subscription
if (!defined('ADMIN_EMAIL')) {
  define('ADMIN_EMAIL', 'riorajhon19930303@gmail.com');
}
// Optional SMTP (use when PHP mail() doesn't deliver, e.g. localhost or strict hosting)
// Set in config.cpanel.php: CONTACT_SMTP_HOST, CONTACT_SMTP_PORT (587), CONTACT_SMTP_USER, CONTACT_SMTP_PASS, CONTACT_SMTP_SECURE ('tls')
if (!defined('CONTACT_SMTP_HOST')) {
  define('CONTACT_SMTP_HOST', '');
}
if (!defined('CONTACT_SMTP_PORT')) {
  define('CONTACT_SMTP_PORT', 587);
}
if (!defined('CONTACT_SMTP_USER')) {
  define('CONTACT_SMTP_USER', '');
}
if (!defined('CONTACT_SMTP_PASS')) {
  define('CONTACT_SMTP_PASS', '');
}
if (!defined('CONTACT_SMTP_SECURE')) {
  define('CONTACT_SMTP_SECURE', 'tls');
}
