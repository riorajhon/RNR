<?php
/**
 * Send email via SMTP (no Composer). Use when PHP mail() doesn't deliver (e.g. localhost or strict hosts).
 * Requires CONTACT_SMTP_HOST, CONTACT_SMTP_USER, CONTACT_SMTP_PASS. Optional: CONTACT_SMTP_PORT (587), CONTACT_SMTP_SECURE ('tls').
 *
 * @return bool True if sent, false otherwise
 */
function smtp_send_email($to, $subject, $body_plain, $from_email, $from_name, $reply_to) {
  $host = defined('CONTACT_SMTP_HOST') ? CONTACT_SMTP_HOST : '';
  $port = defined('CONTACT_SMTP_PORT') ? (int) CONTACT_SMTP_PORT : 587;
  $secure = defined('CONTACT_SMTP_SECURE') ? strtolower(CONTACT_SMTP_SECURE) : 'tls';
  $user = defined('CONTACT_SMTP_USER') ? CONTACT_SMTP_USER : '';
  $pass = defined('CONTACT_SMTP_PASS') ? CONTACT_SMTP_PASS : '';
  if ($host === '' || $user === '' || $pass === '') {
    return false;
  }
  $errno = 0;
  $errstr = '';
  if ($port === 465 && $secure === 'ssl') {
    $sock = @stream_socket_client('ssl://' . $host . ':' . $port, $errno, $errstr, 15, STREAM_CLIENT_CONNECT);
  } else {
    $sock = @stream_socket_client('tcp://' . $host . ':' . $port, $errno, $errstr, 15, STREAM_CLIENT_CONNECT);
  }
  if (!$sock) {
    return false;
  }
  stream_set_timeout($sock, 15);
  $read = function () use ($sock) {
    $line = @fgets($sock, 512);
    return $line !== false ? trim($line) : '';
  };
  $expect = function ($code) use ($sock, $read) {
    $line = $read();
    $ok = (int) substr($line, 0, 3) === (int) $code;
    while ($line !== '' && substr($line, 3, 1) === '-') {
      $line = $read();
    }
    return $ok;
  };
  if (!$expect(220)) {
    fclose($sock);
    return false;
  }
  $send = function ($cmd) use ($sock) {
    fwrite($sock, $cmd . "\r\n");
  };
  $send('EHLO ' . (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'localhost'));
  if (!$expect(250)) {
    fclose($sock);
    return false;
  }
  if ($port === 587 && $secure === 'tls') {
    $send('STARTTLS');
    if (!$expect(220)) {
      fclose($sock);
      return false;
    }
    if (!@stream_socket_enable_crypto($sock, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
      fclose($sock);
      return false;
    }
    $send('EHLO ' . (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'localhost'));
    if (!$expect(250)) {
      fclose($sock);
      return false;
    }
  }
  $send('AUTH LOGIN');
  if (!$expect(334)) {
    fclose($sock);
    return false;
  }
  $send(base64_encode($user));
  if (!$expect(334)) {
    fclose($sock);
    return false;
  }
  $send(base64_encode($pass));
  if (!$expect(235)) {
    fclose($sock);
    return false;
  }
  $from_addr = $from_email;
  $send('MAIL FROM:<' . $from_addr . '>');
  if (!$expect(250)) {
    fclose($sock);
    return false;
  }
  $send('RCPT TO:<' . $to . '>');
  if (!$expect(250)) {
    fclose($sock);
    return false;
  }
  $send('DATA');
  if (!$expect(354)) {
    fclose($sock);
    return false;
  }
  $headers = 'From: ' . ($from_name !== '' ? '"' . str_replace(['"', "\r", "\n"], ['\"', '', ''], $from_name) . '" <' . $from_addr . '>' : $from_addr) . "\r\n";
  $headers .= 'To: ' . $to . "\r\n";
  $headers .= 'Reply-To: ' . $reply_to . "\r\n";
  $headers .= 'Subject: ' . $subject . "\r\n";
  $headers .= 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-Type: text/plain; charset=utf-8' . "\r\n";
  $headers .= "\r\n";
  $body_crlf = str_replace(["\r\n", "\r", "\n"], "\r\n", $body_plain);
  $body_crlf = preg_replace('/^\./m', '..', $body_crlf);
  $data = $headers . $body_crlf;
  $send($data);
  $send('.');
  if (!$expect(250)) {
    fclose($sock);
    return false;
  }
  $send('QUIT');
  fclose($sock);
  return true;
}
