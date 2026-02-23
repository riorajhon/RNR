<?php
/**
 * Public rating page. ?u=USER_ID
 * Step 1: Rate 1-10. Step 2 (if low): Questions. Step 3 (if gift): Name/email/mobile. Then thank you.
 */
require_once __DIR__ . '/../backend/config.php';
require_once __DIR__ . '/../backend/includes/db.php';

$base_url = get_base_url();
$user_id = isset($_GET['u']) ? (int) $_GET['u'] : (isset($_POST['u']) ? (int) $_POST['u'] : 0);
$step = $_GET['step'] ?? $_POST['step'] ?? 'score';
$rating_id = isset($_GET['r']) ? (int) $_GET['r'] : (isset($_POST['rating_id']) ? (int) $_POST['rating_id'] : 0);

if ($user_id < 1) {
  header('Content-Type: text/html; charset=utf-8');
  echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Invalid link</title></head><body><p>Invalid link.</p></body></html>';
  exit;
}

$stmt = $pdo->prepare("SELECT bs.*, u.name AS business_name FROM business_settings bs JOIN users u ON u.id = bs.user_id WHERE bs.user_id = ?");
$stmt->execute([$user_id]);
$settings = $stmt->fetch();
if (!$settings) {
  header('Content-Type: text/html; charset=utf-8');
  echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Not found</title></head><body><p>Not found.</p></body></html>';
  exit;
}

$business_name = $settings['business_name'] ?? 'Us';

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['score'])) {
    $score = (int) $_POST['score'];
    if ($score >= 1 && $score <= 10) {
      $is_positive = $score >= 7 ? 1 : 0;
      $pdo->prepare("INSERT INTO ratings (user_id, score, is_positive) VALUES (?, ?, ?)")->execute([$user_id, $score, $is_positive]);
      $rating_id = (int) $pdo->lastInsertId();
      if ($is_positive) {
        $reviews_url = $base_url . 'frontend/reviews.php?u=' . $user_id;
        header('Location: ' . $reviews_url);
        exit;
      }
      $num_q = max(0, min(3, (int) ($settings['num_questions'] ?? 3)));
      $offer_gift = !empty($settings['offer_gift']);
      $q1_set = trim($settings['question_1'] ?? '') !== '';
      if ($num_q <= 0 || !$q1_set) {
        $step = $offer_gift ? 'gift' : 'thanks';
      } else {
        $step = 'questions';
      }
    }
  } elseif (isset($_POST['answer_1']) || isset($_POST['answer_2']) || isset($_POST['answer_3'])) {
    $rid = (int) ($_POST['rating_id'] ?? 0);
    $check = $pdo->prepare("SELECT id FROM ratings WHERE id = ? AND user_id = ?");
    $check->execute([$rid, $user_id]);
    if ($check->fetch()) {
      $a1 = trim($_POST['answer_1'] ?? '');
      $a2 = trim($_POST['answer_2'] ?? '');
      $a3 = trim($_POST['answer_3'] ?? '');
      $pdo->prepare("INSERT INTO responses (rating_id, answer_1, answer_2, answer_3) VALUES (?, ?, ?, ?)")->execute([$rid, $a1, $a2, $a3]);
      if (!empty($settings['offer_gift'])) {
        $step = 'gift';
        $rating_id = $rid;
      } else {
        $step = 'thanks';
      }
    }
  } elseif (isset($_POST['lead_name']) || isset($_POST['lead_skip'])) {
    $rid = (int) ($_POST['rating_id'] ?? 0);
    $check = $pdo->prepare("SELECT id FROM ratings WHERE id = ? AND user_id = ?");
    $check->execute([$rid, $user_id]);
    if ($check->fetch() && !isset($_POST['lead_skip'])) {
      $name = trim($_POST['lead_name'] ?? '');
      $email = trim($_POST['lead_email'] ?? '');
      $mobile = trim($_POST['lead_mobile'] ?? '');
      if ($name !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $pdo->prepare("INSERT INTO leads (rating_id, name, email, mobile) VALUES (?, ?, ?, ?)")->execute([$rid, $name, $email, $mobile]);
      }
    }
    $step = 'thanks';
  }
}

$q1 = $settings['question_1'] ?? 'What is one thing we can improve to make our business better?';
$q2 = $settings['question_2'] ?? 'Can you tell us two specific things that bothered you today?';
$q3 = $settings['question_3'] ?? 'Should we add more products or new services?';
$num_q = max(0, min(3, (int) ($settings['num_questions'] ?? 3)));
$offer_gift = !empty($settings['offer_gift']);
$footer_text = $settings['qr_footer_text'] ?? 'Rate us and win a free gift';

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rate <?php echo htmlspecialchars($business_name); ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo htmlspecialchars($base_url); ?>frontend/css/main.css">
  <style>
    :root { --rate-primary: #6366f1; --rate-primary-hover: #4f46e5; --rate-bg: #eef2ff; --rate-bg-end: #f5f3ff; --rate-card: #fff; --rate-text: #1e293b; --rate-muted: #64748b; }
    body { font-family: 'Poppins', sans-serif; min-height: 100vh; background: linear-gradient(160deg, var(--rate-bg) 0%, var(--rate-bg-end) 50%, #f0f9ff 100%); color: var(--rate-text); }
    .rate-page { max-width: 420px; margin: 2rem auto; padding: 1.5rem 1.75rem; text-align: center; animation: rateFadeIn 0.4s ease-out; background: rgba(255,255,255,0.85); border-radius: 16px; box-shadow: 0 4px 24px rgba(99,102,241,0.08); }
    @keyframes rateFadeIn { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
    .rate-page h1 { font-size: 1.5rem; margin-bottom: 0.5rem; font-weight: 600; color: var(--rate-text); }
    .rate-page .sub { color: var(--rate-muted); margin-bottom: 1.5rem; }
    .rate-stars { display: flex; justify-content: center; gap: 0.2rem; margin: 1rem 0; }
    .rate-star-btn { width: 2.5rem; height: 2.5rem; border: none; border-radius: 8px; background: transparent; color: #e2e8f0; font-size: 1.75rem; line-height: 1; cursor: pointer; padding: 0; transition: color 0.2s, transform 0.2s; }
    .rate-star-btn:hover { transform: scale(1.12); color: #fcd34d; }
    .rate-star-btn.active { color: #fbbf24; }
    .rate-star-btn:focus { outline: 2px solid #2563eb; outline-offset: 2px; }
    .rate-form label { display: block; text-align: left; margin: 1rem 0 0.25rem; font-weight: 500; }
    .rate-form input, .rate-form textarea { width: 100%; padding: 0.6rem; border: 1px solid #e2e8f0; border-radius: 8px; font-family: inherit; transition: border-color 0.2s, box-shadow 0.2s; }
    .rate-form input:focus, .rate-form textarea:focus { outline: none; border-color: var(--rate-primary); box-shadow: 0 0 0 3px rgba(99,102,241,0.15); }
    .rate-form textarea { min-height: 80px; resize: vertical; }
    .rate-form .btn { margin-top: 1rem; padding: 0.75rem; font-family: inherit; font-weight: 500; border-radius: 8px; transition: background 0.2s, transform 0.05s; }
    .rate-form .btn-primary { background: var(--rate-primary); }
    .rate-form .btn-primary:hover { background: var(--rate-primary-hover); }
    .rate-form-actions { display: flex; gap: 0.75rem; margin-top: 1rem; flex-wrap: wrap; }
    .rate-form-actions .btn-primary { flex: 1; min-width: 120px; }
    .rate-form-actions .btn-outline { flex: 0 0 auto; }
    .rate-thanks { padding: 2rem; }
    .rate-gift-image-wrap { margin: 1rem 0; }
    .rate-gift-image { max-width: 100%; height: auto; max-height: 200px; object-fit: contain; border-radius: 8px; }
    .rate-fireworks { position: fixed; top: 0; left: 0; right: 0; bottom: 0; width: 100vw; height: 100vh; min-width: 100%; min-height: 100%; pointer-events: none; z-index: 0; overflow: hidden; }
    .rate-thanks-screen { position: relative; z-index: 1; }
  </style>
</head>
<body>
<div class="rate-page">
  <?php if ($step === 'score'): ?>
    <h1>How was your experience?</h1>
    <p class="sub">Tap a star to rate <?php echo htmlspecialchars($business_name); ?> (1–10)</p>
    <form method="post" action="" id="rate-star-form">
      <input type="hidden" name="u" value="<?php echo $user_id; ?>">
      <input type="hidden" name="score" id="rate-score-input" value="">
      <div class="rate-stars" role="group" aria-label="Rating 1 to 10 stars" id="rate-stars-wrap">
        <?php for ($i = 1; $i <= 10; $i++): ?>
          <button type="button" class="rate-star-btn" data-value="<?php echo $i; ?>" title="<?php echo $i; ?> out of 10">★</button>
        <?php endfor; ?>
      </div>
    </form>
    <script>
    (function() {
      var wrap = document.getElementById('rate-stars-wrap');
      var form = document.getElementById('rate-star-form');
      var input = document.getElementById('rate-score-input');
      var stars = wrap && wrap.querySelectorAll('.rate-star-btn');
      function setActive(n) {
        if (!stars) return;
        for (var i = 0; i < stars.length; i++) {
          stars[i].classList.toggle('active', i < n);
        }
      }
      if (wrap && stars && form && input) {
        wrap.addEventListener('click', function(e) {
          var btn = e.target.closest('.rate-star-btn');
          if (!btn) return;
          var n = parseInt(btn.getAttribute('data-value'), 10);
          input.value = n;
          setActive(n);
          form.submit();
        });
        wrap.addEventListener('mouseover', function(e) {
          var btn = e.target.closest('.rate-star-btn');
          if (btn) setActive(parseInt(btn.getAttribute('data-value'), 10));
        });
        wrap.addEventListener('mouseout', function() { setActive(0); });
      }
    })();
    </script>

  <?php elseif ($step === 'questions'): ?>
    <h1>Thank you. We’d love to improve.</h1>
    <p class="sub">Please answer a few quick questions.</p>
    <form method="post" action="" class="rate-form">
      <input type="hidden" name="u" value="<?php echo $user_id; ?>">
      <input type="hidden" name="rating_id" value="<?php echo $rating_id; ?>">
      <?php if ($num_q >= 1): ?><label><?php echo htmlspecialchars($q1); ?></label><textarea name="answer_1" placeholder="Your answer"></textarea><?php endif; ?>
      <?php if ($num_q >= 2): ?><label><?php echo htmlspecialchars($q2); ?></label><textarea name="answer_2" placeholder="Your answer"></textarea><?php endif; ?>
      <?php if ($num_q >= 3): ?><label><?php echo htmlspecialchars($q3); ?></label><textarea name="answer_3" placeholder="Your answer"></textarea><?php endif; ?>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>

  <?php elseif ($step === 'gift'): ?>
    <h1>Claim your free gift</h1>
    <p class="sub">Leave your details and we’ll get in touch.</p>
    <?php
    $gift_img = !empty($settings['gift_image']) ? trim($settings['gift_image']) : '';
    if ($gift_img !== ''):
      $gift_src = $base_url . (strpos($gift_img, '/') === 0 ? ltrim($gift_img, '/') : $gift_img);
    ?>
    <div class="rate-gift-image-wrap"><img src="<?php echo htmlspecialchars($gift_src); ?>" alt="Free gift" class="rate-gift-image"></div>
    <?php endif; ?>
    <?php if (!empty($settings['gift_description'])): ?><p><?php echo htmlspecialchars($settings['gift_description']); ?></p><?php endif; ?>
    <form method="post" action="" class="rate-form">
      <input type="hidden" name="u" value="<?php echo $user_id; ?>">
      <input type="hidden" name="rating_id" value="<?php echo $rating_id; ?>">
      <label>Name *</label><input type="text" name="lead_name" placeholder="Your name">
      <label>Email *</label><input type="email" name="lead_email" placeholder="you@example.com">
      <label>Mobile</label><input type="text" name="lead_mobile" placeholder="Phone number">
      <div class="rate-form-actions">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="submit" name="lead_skip" value="1" class="btn btn-outline">Skip</button>
      </div>
    </form>

  <?php else: ?>
    <div class="rate-fireworks" id="rate-fireworks" aria-hidden="true"></div>
    <div class="rate-thanks-screen">
      <h1>Thank you!</h1>
      <p class="sub rate-thanks">We appreciate your feedback.</p>
    </div>
    <script>
    (function() {
      var container = document.getElementById('rate-fireworks');
      if (!container) return;
      var colors = ['#fbbf24','#f59e0b','#ef4444','#ec4899','#8b5cf6','#3b82f6','#10b981'];
      var particleCount = 100;
      var particles = [];
      var centerX = 0.5;
      var centerY = 0.4;
      function random(min, max) { return min + Math.random() * (max - min); }
      function createParticle() {
        var p = document.createElement('div');
        var size = random(4, 10);
        p.style.cssText = 'position:absolute;width:' + size + 'px;height:' + size + 'px;background:' + colors[Math.floor(Math.random() * colors.length)] + ';border-radius:50%;left:50%;top:50%;will-change:transform;';
        container.appendChild(p);
        var angle = random(0, Math.PI * 2);
        var speed = random(80, 220);
        return { el: p, x: 0, y: 0, vx: Math.cos(angle) * speed, vy: Math.sin(angle) * speed - 60, gravity: 0.4, life: 1, decay: random(0.008, 0.018) };
      }
      for (var i = 0; i < particleCount; i++) particles.push(createParticle());
      var w = window.innerWidth, h = window.innerHeight, cx = w * centerX, cy = h * centerY;
      function tick() {
        w = window.innerWidth; h = window.innerHeight; cx = w * centerX; cy = h * centerY;
        var allDone = true;
        for (var i = 0; i < particles.length; i++) {
          var p = particles[i];
          if (p.life <= 0) { p.el.style.opacity = 0; continue; }
          allDone = false;
          p.x += p.vx * 0.016; p.y += p.vy * 0.016;
          p.vy += p.gravity; p.vx *= 0.99;
          p.life -= p.decay;
          p.el.style.transform = 'translate(' + (cx + p.x) + 'px,' + (cy + p.y) + 'px)';
          p.el.style.opacity = p.life;
        }
        if (!allDone) requestAnimationFrame(tick);
      }
      requestAnimationFrame(tick);
    })();
    </script>
  <?php endif; ?>
</div>
</body>
</html>
