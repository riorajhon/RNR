<?php
/**
 * Create Stripe Checkout Session for subscription (monthly or yearly).
 * Requires login. Redirects to Stripe Checkout; on success Stripe redirects back to success_url.
 * Query: plan=monthly|yearly
 */
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/db.php';

$base_url = get_base_url();

if (empty($_SESSION['user_id'])) {
  header('Location: ' . $base_url . 'frontend/pages/login.php?redirect=' . urlencode($base_url . 'frontend/pages/pricing.php'));
  exit;
}

$plan = isset($_GET['plan']) ? strtolower(trim($_GET['plan'])) : '';
if (!in_array($plan, ['monthly', 'yearly'], true)) {
  header('Location: ' . $base_url . 'frontend/pages/pricing.php?error=invalid_plan');
  exit;
}

$secret = defined('STRIPE_SECRET_KEY') ? STRIPE_SECRET_KEY : '';
$price_id = $plan === 'monthly' ? (defined('STRIPE_PRICE_ID_MONTHLY') ? trim(STRIPE_PRICE_ID_MONTHLY) : '') : (defined('STRIPE_PRICE_ID_YEARLY') ? trim(STRIPE_PRICE_ID_YEARLY) : '');
// One product with two prices: use STRIPE_PRODUCT_ID for both, or STRIPE_PRODUCT_ID_MONTHLY/YEARLY
$product_id = trim(defined('STRIPE_PRODUCT_ID') ? STRIPE_PRODUCT_ID : '');
if ($product_id === '') {
  $product_id = $plan === 'monthly' ? (defined('STRIPE_PRODUCT_ID_MONTHLY') ? trim(STRIPE_PRODUCT_ID_MONTHLY) : '') : (defined('STRIPE_PRODUCT_ID_YEARLY') ? trim(STRIPE_PRODUCT_ID_YEARLY) : '');
  if ($product_id === '' && $plan === 'yearly' && defined('STRIPE_PRODUCT_ID_MONTHLY')) {
    $product_id = trim(STRIPE_PRODUCT_ID_MONTHLY);
  }
}

// If no Price ID, try to get it from Product ID (list prices for product, pick matching interval)
if ($price_id === '' && $product_id !== '' && preg_match('/^prod_[a-zA-Z0-9]+$/', $product_id)) {
  $ch_list = curl_init('https://api.stripe.com/v1/prices?product=' . urlencode($product_id) . '&limit=20');
  curl_setopt_array($ch_list, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_USERPWD => $secret . ':',
  ]);
  $list_resp = curl_exec($ch_list);
  $list_code = curl_getinfo($ch_list, CURLINFO_HTTP_CODE);
  curl_close($ch_list);
  if ($list_code === 200) {
    $list_data = json_decode($list_resp, true);
    $want_interval = $plan === 'yearly' ? 'year' : 'month';
    foreach (isset($list_data['data']) ? $list_data['data'] : [] as $p) {
      $interval = isset($p['recurring']['interval']) ? $p['recurring']['interval'] : '';
      if ($interval === $want_interval && !empty($p['id'])) {
        $price_id = $p['id'];
        break;
      }
    }
  }
  if ($price_id === '' && $list_resp !== false) {
    $err_data = json_decode($list_resp, true);
    $stripe_msg = isset($err_data['error']['message']) ? $err_data['error']['message'] : 'Price not found for this plan';
    header('Location: ' . $base_url . 'frontend/pages/pricing.php?error=' . urlencode($stripe_msg));
    exit;
  }
}

if ($secret === '' || $price_id === '') {
  $msg = $secret === '' ? 'Stripe secret key not set' : 'No price for this plan (check Product ID in config)';
  header('Location: ' . $base_url . 'frontend/pages/pricing.php?error=' . urlencode($msg));
  exit;
}

$user_id = (int) $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT email FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
if (!$user || empty($user['email'])) {
  header('Location: ' . $base_url . 'frontend/pages/pricing.php?error=user');
  exit;
}

// Stripe requires full absolute URLs. Use SITE_URL when set (deploy); else build from request. Never use base_url when it's a full URL.
if (defined('SITE_URL') && SITE_URL !== '') {
  $full_base = rtrim(SITE_URL, '/');
} else {
  $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
  $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
  $path_part = (strpos($base_url, '://') !== false) ? '' : trim((strpos($base_url, '/') === 0 ? $base_url : '/' . $base_url), '/');
  $full_base = $scheme . '://' . $host . ($path_part !== '' ? '/' . $path_part : '');
}
$success_url = $full_base . '/frontend/payment-success.php?session_id={CHECKOUT_SESSION_ID}';
$cancel_url = $full_base . '/frontend/pages/pricing.php?canceled=1';

$params = [
  'mode' => 'subscription',
  'success_url' => $success_url,
  'cancel_url' => $cancel_url,
  'client_reference_id' => (string) $user_id,
  'customer_email' => $user['email'],
  'line_items[0][price]' => $price_id,
  'line_items[0][quantity]' => '1',
];

$ch = curl_init('https://api.stripe.com/v1/checkout/sessions');
curl_setopt_array($ch, [
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_POST => true,
  CURLOPT_POSTFIELDS => http_build_query($params),
  CURLOPT_USERPWD => $secret . ':',
  CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
]);
$response = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($code !== 200) {
  $err = json_decode($response, true);
  $msg = isset($err['error']['message']) ? $err['error']['message'] : 'Checkout failed';
  header('Location: ' . $base_url . 'frontend/pages/pricing.php?error=' . urlencode($msg));
  exit;
}

$data = json_decode($response, true);
$url = isset($data['url']) ? $data['url'] : '';
if ($url === '') {
  header('Location: ' . $base_url . 'frontend/pages/pricing.php?error=no_url');
  exit;
}
header('Location: ' . $url);
exit;
