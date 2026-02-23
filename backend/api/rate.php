<?php
/**
 * Submit rating step: score (1-10), or answers for low rating, or lead (gift claim).
 * POST: step=score|answers|lead, u=user_id, and step-specific fields.
 */
header('Content-Type: application/json');
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/db.php';

$step = $_POST['step'] ?? $_GET['step'] ?? '';
$user_id = isset($_POST['u']) ? (int) $_POST['u'] : (isset($_GET['u']) ? (int) $_GET['u'] : 0);

if (!in_array($step, ['score', 'answers', 'lead'], true) || $user_id < 1) {
  http_response_code(400);
  echo json_encode(['error' => 'Invalid request']);
  exit;
}

$stmt = $pdo->prepare("SELECT id, redirect_url_positive, question_1, question_2, question_3, num_questions, offer_gift FROM business_settings WHERE user_id = ?");
$stmt->execute([$user_id]);
$settings = $stmt->fetch();
if (!$settings) {
  http_response_code(404);
  echo json_encode(['error' => 'Not found']);
  exit;
}

if ($step === 'score') {
  $score = isset($_POST['score']) ? (int) $_POST['score'] : 0;
  if ($score < 1 || $score > 10) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid score']);
    exit;
  }
  $is_positive = $score >= 7 ? 1 : 0;
  $pdo->prepare("INSERT INTO ratings (user_id, score, is_positive) VALUES (?, ?, ?)")->execute([$user_id, $score, $is_positive]);
  $rating_id = (int) $pdo->lastInsertId();
  if ($is_positive) {
    $redirect = !empty(trim($settings['redirect_url_positive'] ?? '')) ? trim($settings['redirect_url_positive']) : null;
    echo json_encode(['success' => true, 'rating_id' => $rating_id, 'positive' => true, 'redirect_url' => $redirect]);
  } else {
    $n = max(1, min(3, (int) $settings['num_questions']));
    $questions = array_filter([
      $settings['question_1'] ?? '',
      $settings['question_2'] ?? '',
      $settings['question_3'] ?? '',
    ]);
    $questions = array_slice($questions, 0, $n);
    echo json_encode(['success' => true, 'rating_id' => $rating_id, 'positive' => false, 'questions' => $questions, 'offer_gift' => (bool) ($settings['offer_gift'] ?? 0)]);
  }
  exit;
}

if ($step === 'answers') {
  $rating_id = isset($_POST['rating_id']) ? (int) $_POST['rating_id'] : 0;
  if ($rating_id < 1) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid rating']);
    exit;
  }
  $check = $pdo->prepare("SELECT id FROM ratings WHERE id = ? AND user_id = ?");
  $check->execute([$rating_id, $user_id]);
  if (!$check->fetch()) {
    http_response_code(404);
    echo json_encode(['error' => 'Not found']);
    exit;
  }
  $a1 = trim($_POST['answer_1'] ?? '');
  $a2 = trim($_POST['answer_2'] ?? '');
  $a3 = trim($_POST['answer_3'] ?? '');
  $pdo->prepare("INSERT INTO responses (rating_id, answer_1, answer_2, answer_3) VALUES (?, ?, ?, ?)")->execute([$rating_id, $a1, $a2, $a3]);
  $offer_gift = (bool) ($settings['offer_gift'] ?? 0);
  echo json_encode(['success' => true, 'offer_gift' => $offer_gift]);
  exit;
}

if ($step === 'lead') {
  $rating_id = isset($_POST['rating_id']) ? (int) $_POST['rating_id'] : 0;
  if ($rating_id < 1) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid rating']);
    exit;
  }
  $check = $pdo->prepare("SELECT id FROM ratings WHERE id = ? AND user_id = ?");
  $check->execute([$rating_id, $user_id]);
  if (!$check->fetch()) {
    http_response_code(404);
    echo json_encode(['error' => 'Not found']);
    exit;
  }
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $mobile = trim($_POST['mobile'] ?? '');
  if ($name === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Valid name and email required']);
    exit;
  }
  $pdo->prepare("INSERT INTO leads (rating_id, name, email, mobile) VALUES (?, ?, ?, ?)")->execute([$rating_id, $name, $email, $mobile]);
  echo json_encode(['success' => true]);
  exit;
}
