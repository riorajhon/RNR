<?php
/**
 * Export ratings and leads as CSV. GET ?type=ratings|leads. Requires session.
 */
session_start();
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/subscription.php';

if (empty($_SESSION['user_id'])) {
  http_response_code(401);
  header('Content-Type: text/plain');
  echo 'Unauthorized';
  exit;
}
$user_id = (int) $_SESSION['user_id'];

$type = $_GET['type'] ?? 'ratings';
if (!in_array($type, ['ratings', 'leads'], true)) {
  $type = 'ratings';
}

if ($type === 'ratings') {
  $stmt = $pdo->prepare("SELECT r.id, r.score, r.is_positive, r.created_at, res.answer_1, res.answer_2, res.answer_3 FROM ratings r LEFT JOIN responses res ON res.rating_id = r.id WHERE r.user_id = ? ORDER BY r.created_at DESC");
  $stmt->execute([$user_id]);
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  header('Content-Type: text/csv; charset=utf-8');
  header('Content-Disposition: attachment; filename="ratings_' . date('Y-m-d') . '.csv"');
  $out = fopen('php://output', 'w');
  fprintf($out, "\xEF\xBB\xBF"); // UTF-8 BOM for Excel
  fputcsv($out, ['ID', 'Score', 'Positive (7-10)', 'Date', 'Answer 1', 'Answer 2', 'Answer 3']);
  foreach ($rows as $r) {
    fputcsv($out, [
      $r['id'],
      $r['score'],
      $r['is_positive'] ? 'Yes' : 'No',
      $r['created_at'] ?? '',
      $r['answer_1'] ?? '',
      $r['answer_2'] ?? '',
      $r['answer_3'] ?? '',
    ]);
  }
  fclose($out);
  exit;
}

$stmt = $pdo->prepare("SELECT l.name, l.email, l.mobile, l.created_at FROM leads l INNER JOIN ratings r ON r.id = l.rating_id WHERE r.user_id = ? ORDER BY l.created_at DESC");
$stmt->execute([$user_id]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="leads_' . date('Y-m-d') . '.csv"');
$out = fopen('php://output', 'w');
fprintf($out, "\xEF\xBB\xBF");
fputcsv($out, ['Name', 'Email', 'Mobile', 'Date']);
foreach ($rows as $r) {
  fputcsv($out, [$r['name'], $r['email'], $r['mobile'] ?? '', $r['created_at'] ?? '']);
}
fclose($out);
