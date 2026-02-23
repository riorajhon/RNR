<?php
/**
 * Stripe webhook endpoint. Configure in Stripe Dashboard → Developers → Webhooks.
 * Events: checkout.session.completed, customer.subscription.updated, customer.subscription.deleted
 * Signing secret must be set in config.stripe.php as STRIPE_WEBHOOK_SECRET.
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/db.php';

$secret = defined('STRIPE_WEBHOOK_SECRET') ? STRIPE_WEBHOOK_SECRET : '';
if ($secret === '') {
  http_response_code(500);
  exit;
}

$payload = @file_get_contents('php://input');
$sig = isset($_SERVER['HTTP_STRIPE_SIGNATURE']) ? $_SERVER['HTTP_STRIPE_SIGNATURE'] : '';
if ($payload === false || $sig === '') {
  http_response_code(400);
  exit;
}

// Verify signature (HMAC SHA256 with webhook secret)
$parts = explode(',', $sig);
$timestamp = null;
$v1 = null;
foreach ($parts as $part) {
  $kv = explode('=', trim($part), 2);
  if (count($kv) === 2) {
    if ($kv[0] === 't') {
      $timestamp = $kv[1];
    }
    if ($kv[0] === 'v1') {
      $v1 = $kv[1];
    }
  }
}
$signed = $timestamp . '.' . $payload;
$expected = hash_hmac('sha256', $signed, $secret);
if (!hash_equals($expected, $v1)) {
  http_response_code(400);
  exit;
}

$event = json_decode($payload, true);
if (!$event || !isset($event['type'], $event['data']['object'])) {
  http_response_code(400);
  exit;
}

$type = $event['type'];
$obj = $event['data']['object'];

if ($type === 'checkout.session.completed') {
  $client_ref = $obj['client_reference_id'] ?? null;
  $sub_id = $obj['subscription'] ?? null;
  $customer_id = $obj['customer'] ?? null;
  if ($client_ref !== null && $client_ref !== '' && $sub_id) {
    $user_id = (int) $client_ref;
    $plan = 'monthly';
    $stmt = $pdo->prepare("UPDATE users SET stripe_customer_id = ?, stripe_subscription_id = ?, plan = ? WHERE id = ?");
    $stmt->execute([$customer_id ?: null, $sub_id, $plan, $user_id]);
  }
  http_response_code(200);
  exit;
}

if ($type === 'customer.subscription.updated' || $type === 'customer.subscription.deleted') {
  $sub_id = $obj['id'] ?? null;
  $status = $obj['status'] ?? '';
  if ($sub_id && ($status === 'canceled' || $status === 'unpaid' || $status === 'incomplete_expired')) {
    $stmt = $pdo->prepare("UPDATE users SET stripe_subscription_id = NULL WHERE stripe_subscription_id = ?");
    $stmt->execute([$sub_id]);
  }
  http_response_code(200);
  exit;
}

http_response_code(200);
exit;
