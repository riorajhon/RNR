<?php
/**
 * Dashboard API: get settings, save settings, get stats, get ratings/leads for export.
 * Requires session user_id.
 */
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/subscription.php';

if (empty($_SESSION['user_id'])) {
  http_response_code(401);
  echo json_encode(['error' => 'Unauthorized']);
  exit;
}
$user_id = (int) $_SESSION['user_id'];

$action = $_GET['action'] ?? $_POST['action'] ?? '';

if ($action === 'settings') {
  $stmt = $pdo->prepare("SELECT qr_footer_text, redirect_url_positive, review_platform, review_url_google, review_url_facebook, review_url_yelp, review_url_tripadvisor, review_url_other, review_label_other, question_1, question_2, question_3, num_questions, offer_gift, gift_description, gift_image FROM business_settings WHERE user_id = ?");
  $stmt->execute([$user_id]);
  $row = $stmt->fetch();
  if (!$row) {
    echo json_encode(['error' => 'No settings']);
    exit;
  }
  echo json_encode($row);
  exit;
}

if ($action === 'save_settings' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $qr_footer_text = trim($_POST['qr_footer_text'] ?? '');
  $redirect_url_positive = '';
  $review_platforms_raw = $_POST['review_platforms'] ?? [];
  $allowed = ['google', 'yelp', 'facebook', 'tripadvisor', 'other'];
  $review_platforms_filtered = array_values(array_unique(array_filter(array_map('trim', is_array($review_platforms_raw) ? $review_platforms_raw : (array) $review_platforms_raw), function ($v) use ($allowed) { return in_array($v, $allowed, true); })));
  $review_platform = count($review_platforms_filtered) > 0 ? implode(',', $review_platforms_filtered) : 'google';
  $review_url_google = trim($_POST['review_url_google'] ?? '');
  $review_url_facebook = trim($_POST['review_url_facebook'] ?? '');
  $review_url_yelp = trim($_POST['review_url_yelp'] ?? '');
  $review_url_tripadvisor = trim($_POST['review_url_tripadvisor'] ?? '');
  $review_url_other = trim($_POST['review_url_other'] ?? '');
  $review_label_other = trim($_POST['review_label_other'] ?? '');
  $question_1 = trim($_POST['question_1'] ?? '');
  $question_2 = trim($_POST['question_2'] ?? '');
  $question_3 = trim($_POST['question_3'] ?? '');
  $num_questions = max(0, min(3, (int) ($_POST['num_questions'] ?? 3)));
  $offer_gift = isset($_POST['offer_gift']) && $_POST['offer_gift'] ? 1 : 0;
  $gift_description = trim($_POST['gift_description'] ?? '');
  $cur = $pdo->prepare("SELECT gift_image FROM business_settings WHERE user_id = ?");
  $cur->execute([$user_id]);
  $gift_image = $cur->fetchColumn() ?: '';
  if (isset($_FILES['gift_image_file']) && $_FILES['gift_image_file']['error'] === UPLOAD_ERR_OK) {
    $ext = strtolower(pathinfo($_FILES['gift_image_file']['name'], PATHINFO_EXTENSION));
    if (in_array($ext, ['jpg','jpeg','png','gif','webp'], true)) {
      $dir = dirname(__DIR__, 2) . '/images/uploads';
      if (!is_dir($dir)) mkdir($dir, 0755, true);
      $name = 'gift_' . $user_id . '_' . time() . '.' . $ext;
      if (move_uploaded_file($_FILES['gift_image_file']['tmp_name'], $dir . '/' . $name)) {
        $gift_image = 'images/uploads/' . $name;
      }
    }
  }
  $pdo->prepare("UPDATE business_settings SET qr_footer_text=?, redirect_url_positive=?, review_platform=?, review_url_google=?, review_url_facebook=?, review_url_yelp=?, review_url_tripadvisor=?, review_url_other=?, review_label_other=?, question_1=?, question_2=?, question_3=?, num_questions=?, offer_gift=?, gift_description=?, gift_image=? WHERE user_id = ?")
    ->execute([$qr_footer_text, $redirect_url_positive, $review_platform, $review_url_google ?: null, $review_url_facebook ?: null, $review_url_yelp ?: null, $review_url_tripadvisor ?: null, $review_url_other ?: null, $review_label_other ?: null, $question_1, $question_2, $question_3, $num_questions, $offer_gift, $gift_description, $gift_image !== '' ? $gift_image : null, $user_id]);
  echo json_encode(['success' => true]);
  exit;
}

if ($action === 'stats') {
  $stmt = $pdo->prepare("SELECT COUNT(*) AS total, SUM(is_positive) AS positive FROM ratings WHERE user_id = ?");
  $stmt->execute([$user_id]);
  $row = $stmt->fetch();
  $total = (int) ($row['total'] ?? 0);
  $positive = (int) ($row['positive'] ?? 0);
  echo json_encode(['total' => $total, 'positive' => $positive, 'negative' => $total - $positive]);
  exit;
}

if ($action === 'ratings') {
  $stmt = $pdo->prepare("SELECT question_1, question_2, question_3 FROM business_settings WHERE user_id = ?");
  $stmt->execute([$user_id]);
  $qrow = $stmt->fetch(PDO::FETCH_ASSOC);
  $questions = ['question_1' => $qrow['question_1'] ?? '', 'question_2' => $qrow['question_2'] ?? '', 'question_3' => $qrow['question_3'] ?? ''];
  $stmt = $pdo->prepare("SELECT r.id, r.score, r.is_positive, r.created_at FROM ratings r WHERE r.user_id = ? ORDER BY r.created_at DESC LIMIT 500");
  $stmt->execute([$user_id]);
  $ratings = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt2 = $pdo->prepare("SELECT rating_id, answer_1, answer_2, answer_3 FROM responses WHERE rating_id = ?");
  foreach ($ratings as &$r) {
    $stmt2->execute([$r['id']]);
    $r['responses'] = $stmt2->fetch(PDO::FETCH_ASSOC);
  }
  echo json_encode(['questions' => $questions, 'ratings' => $ratings]);
  exit;
}

if ($action === 'leads') {
  $stmt = $pdo->prepare("SELECT l.id, l.rating_id, l.name, l.email, l.mobile, l.created_at FROM leads l INNER JOIN ratings r ON r.id = l.rating_id WHERE r.user_id = ? ORDER BY l.created_at DESC");
  $stmt->execute([$user_id]);
  echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
  exit;
}

http_response_code(400);
echo json_encode(['error' => 'Invalid action']);
