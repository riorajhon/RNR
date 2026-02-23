<?php
/**
 * Post-payment success page. Stripe redirects here with session_id.
 * We fetch the session and update the user's subscription (or rely on webhook).
 */
session_start();
require_once __DIR__ . '/../backend/config.php';
require_once __DIR__ . '/../backend/includes/db.php';

$base_url = get_base_url();
$session_id = isset($_GET['session_id']) ? trim($_GET['session_id']) : '';

if (empty($session_id) || !preg_match('/^cs_[a-zA-Z0-9_]+$/', $session_id)) {
  header('Location: ' . $base_url . 'frontend/dashboard.php');
  exit;
}

$updated = false;
$secret = defined('STRIPE_SECRET_KEY') ? STRIPE_SECRET_KEY : '';
if ($secret !== '') {
  $ch = curl_init('https://api.stripe.com/v1/checkout/sessions/' . $session_id . '?expand[]=subscription');
  curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_USERPWD => $secret . ':',
  ]);
  $response = curl_exec($ch);
  $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  if ($code === 200) {
    $data = json_decode($response, true);
    $client_ref = $data['client_reference_id'] ?? null;
    $sub_id = null;
    if (!empty($data['subscription'])) {
      $sub_id = is_string($data['subscription']) ? $data['subscription'] : ($data['subscription']['id'] ?? null);
    }
    $customer_id = $data['customer'] ?? null;
    if ($client_ref !== null && $client_ref !== '' && $sub_id) {
      $user_id = (int) $client_ref;
      $plan = 'monthly';
      if (!empty($data['subscription']) && is_array($data['subscription']) && !empty($data['subscription']['items']['data'][0])) {
        $price = $data['subscription']['items']['data'][0]['price'] ?? null;
        $price_id = is_array($price) ? ($price['id'] ?? null) : $price;
        $interval = is_array($price) && !empty($price['recurring']['interval']) ? $price['recurring']['interval'] : '';
        if ($interval === 'year') {
          $plan = 'yearly';
        } elseif ($price_id && defined('STRIPE_PRICE_ID_YEARLY') && STRIPE_PRICE_ID_YEARLY !== '' && $price_id === STRIPE_PRICE_ID_YEARLY) {
          $plan = 'yearly';
        }
      }
      $stmt = $pdo->prepare("UPDATE users SET stripe_customer_id = ?, stripe_subscription_id = ?, plan = ? WHERE id = ?");
      $stmt->execute([$customer_id ?: null, $sub_id, $plan, $user_id]);
      $updated = true;
    }
  }
}

header('Location: ' . $base_url . 'frontend/dashboard.php?payment=success');
exit;
