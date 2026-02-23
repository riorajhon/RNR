<?php
/**
 * Contact form submission. POST: name, email, subject, message, agree_privacy.
 * Saves to DB and sends email to CONTACT_EMAIL (default mail@myratings.online).
 */
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['error' => 'Method not allowed']);
  exit;
}

require_once __DIR__ . '/../config.php';

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');
$agree = !empty($_POST['agree_privacy']);

if (strlen($name) < 2 || strlen($name) > 50) {
  http_response_code(400);
  echo json_encode(['error' => 'Name must be 2-50 characters']);
  exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  http_response_code(400);
  echo json_encode(['error' => 'Valid email required']);
  exit;
}
if (strlen($subject) < 5 || strlen($subject) > 100) {
  http_response_code(400);
  echo json_encode(['error' => 'Subject must be 5-100 characters']);
  exit;
}
if (strlen($message) < 10 || strlen($message) > 1000) {
  http_response_code(400);
  echo json_encode(['error' => 'Message must be 10-1000 characters']);
  exit;
}
if (!$agree) {
  http_response_code(400);
  echo json_encode(['error' => 'You must agree to the Privacy Policy']);
  exit;
}

$contact_to = defined('CONTACT_EMAIL') ? CONTACT_EMAIL : 'mail@myratings.online';

try {
  require_once __DIR__ . '/../includes/db.php';
  $stmt = $pdo->prepare("INSERT INTO contact_submissions (name, email, subject, message) VALUES (?, ?, ?, ?)");
  $stmt->execute([$name, $email, $subject, $message]);
} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode(['error' => 'Could not send message. Please try emailing ' . $contact_to . '.']);
  exit;
}

$email_subject = 'Contact form: ' . $subject;
$email_body = "Name: " . $name . "\n";
$email_body .= "Email: " . $email . "\n";
$email_body .= "Subject: " . $subject . "\n\n";
$email_body .= "Message:\n" . $message . "\n";

$sent = false;
if (defined('CONTACT_SMTP_HOST') && CONTACT_SMTP_HOST !== '' && defined('CONTACT_SMTP_USER') && CONTACT_SMTP_USER !== '') {
  require_once __DIR__ . '/../includes/smtp_send.php';
  $from_email = defined('CONTACT_SMTP_FROM') ? CONTACT_SMTP_FROM : CONTACT_SMTP_USER;
  $reply_to = $name !== '' ? $name . ' <' . $email . '>' : $email;
  $sent = smtp_send_email($contact_to, $email_subject, $email_body, $from_email, 'Contact Form', $reply_to);
} else {
  $headers = [
    'MIME-Version: 1.0',
    'Content-type: text/plain; charset=utf-8',
    'From: Contact Form <noreply@myratings.online>',
    'Reply-To: ' . $name . ' <' . $email . '>',
    'X-Mailer: PHP/' . phpversion(),
  ];
  $sent = @mail($contact_to, $email_subject, $email_body, implode("\r\n", $headers));
}

echo json_encode(['success' => true, 'message' => 'Thank you. We will respond soon.']);
