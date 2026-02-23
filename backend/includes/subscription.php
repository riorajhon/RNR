<?php
/**
 * Subscription gating: redirect to pricing (or 403 JSON for API) if user has no active subscription.
 * Call after verifying user is logged in ($_SESSION['user_id'] set).
 */
if (!defined('BASE_URL')) {
  return;
}
$base_url = get_base_url();
if (empty($_SESSION['user_id'])) {
  return;
}
if (!isset($pdo)) {
  require_once __DIR__ . '/db.php';
}
$user_id = (int) $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT email, stripe_subscription_id FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$row = $stmt->fetch();
$is_admin = defined('ADMIN_EMAIL') && ADMIN_EMAIL !== '' && $row && strtolower(trim($row['email'] ?? '')) === strtolower(trim(ADMIN_EMAIL));
$has_subscription = $row && !empty(trim($row['stripe_subscription_id'] ?? ''));
if (!$is_admin && !$has_subscription) {
  $is_api = strpos($_SERVER['SCRIPT_NAME'], '/api/') !== false
    || (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
  if ($is_api) {
    http_response_code(403);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Active subscription required', 'redirect' => $base_url . 'frontend/pages/pricing.php?required=1']);
    exit;
  }
  header('Location: ' . $base_url . 'frontend/pages/pricing.php?required=1');
  exit;
}
