<?php
require_once __DIR__ . '/../../backend/config.php';
$base_url = get_base_url();
if (isset($_GET['signup']) && $_GET['signup'] === '1') {
  header('Location: ' . $base_url . 'frontend/pages/register.php');
  exit;
}
header('Location: ' . $base_url . 'frontend/pages/login.php');
exit;
