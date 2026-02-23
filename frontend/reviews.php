<?php
/**
 * Public Reviews page – shown after a high rating (7–10).
 * Displays platform logos (Google, Facebook, Yelp, TripAdvisor) linking to the business’s review URL.
 * ?u=USER_ID
 */
require_once __DIR__ . '/../backend/config.php';
require_once __DIR__ . '/../backend/includes/db.php';

$base_url = get_base_url();
$user_id = isset($_GET['u']) ? (int) $_GET['u'] : 0;

if ($user_id < 1) {
  header('Content-Type: text/html; charset=utf-8');
  echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Invalid link</title></head><body><p>Invalid link.</p></body></html>';
  exit;
}

$stmt = $pdo->prepare("SELECT bs.review_platform, u.name AS business_name FROM business_settings bs JOIN users u ON u.id = bs.user_id WHERE bs.user_id = ?");
$stmt->execute([$user_id]);
$row = $stmt->fetch();
$business_name = $row ? ($row['business_name'] ?? 'Us') : 'Us';
$review_platform_raw = $row && !empty(trim($row['review_platform'] ?? '')) ? trim($row['review_platform']) : 'google';
$review_platforms = array_values(array_intersect(
  array_map('trim', explode(',', $review_platform_raw)),
  ['google', 'yelp', 'facebook', 'tripadvisor']
));
if (empty($review_platforms)) {
  $review_platforms = ['google'];
}
$platform_defaults = [
  'google'      => 'https://search.google.com/local/writereview',
  'facebook'    => 'https://www.facebook.com/',
  'yelp'        => 'https://www.yelp.com/writeareview',
  'tripadvisor' => 'https://www.tripadvisor.com/',
];
$platform_labels = [
  'google'      => ['title' => 'Leave a review on Google', 'aria' => 'Google', 'class' => 'reviews-google'],
  'facebook'    => ['title' => 'Leave a review on Facebook', 'aria' => 'Facebook', 'class' => 'reviews-facebook'],
  'yelp'        => ['title' => 'Leave a review on Yelp', 'aria' => 'Yelp', 'class' => 'reviews-yelp'],
  'tripadvisor' => ['title' => 'Leave a review on TripAdvisor', 'aria' => 'TripAdvisor', 'class' => 'reviews-tripadvisor'],
];

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leave a review – <?php echo htmlspecialchars($business_name); ?></title>
  <link rel="stylesheet" href="<?php echo htmlspecialchars($base_url); ?>frontend/css/main.css">
  <style>
    html, body { margin: 0; padding: 0; min-height: 100vh; min-width: 100vw; background: #fff; overflow-x: hidden; }
    .reviews-fireworks { position: fixed; top: 0; left: 0; right: 0; bottom: 0; width: 100vw; height: 100vh; min-width: 100%; min-height: 100%; pointer-events: none; z-index: 0; overflow: hidden; }
    .reviews-page { position: relative; z-index: 1; max-width: 560px; margin: 2rem auto; padding: 2rem; text-align: center; }
    .reviews-page h1 { font-size: 1.5rem; margin-bottom: 0.5rem; color: #111; }
    .reviews-page .sub { color: #6b7280; margin-bottom: 2rem; }
    .reviews-platforms { display: flex; flex-wrap: wrap; justify-content: center; align-items: center; gap: 1.5rem; }
    .reviews-platforms { gap: 1.25rem; }
    .reviews-platforms a { display: flex; align-items: center; justify-content: center; width: 56px; height: 56px; border-radius: 50%; text-decoration: none; color: #fff; transition: transform 0.2s, box-shadow 0.2s; flex-shrink: 0; }
    .reviews-platforms a:hover { transform: scale(1.1); box-shadow: 0 4px 16px rgba(0,0,0,0.2); }
    .reviews-platforms a svg { width: 28px; height: 28px; fill: currentColor; }
    .reviews-google { background: linear-gradient(135deg, #4285f4 0%, #ea4335 30%, #fbbc04 60%, #34a853 100%); }
    .reviews-facebook { background: #1877f2; }
    .reviews-yelp { background: #d32323; }
    .reviews-tripadvisor { background: #00af87; }
    .reviews-platforms .reviews-label { width: 100%; flex-basis: 100%; font-size: 0.9rem; color: #374151; margin-top: 0.75rem; }
    .reviews-thanks { padding: 1rem 0 0; color: #6b7280; font-size: 0.95rem; }
  </style>
</head>
<body>
<div class="reviews-fireworks" id="fireworks" aria-hidden="true"></div>
<div class="reviews-page">
  <h1>Thank you!</h1>
  <p class="sub">Help others find us – leave a review on your preferred platform.</p>

  <div class="reviews-platforms">
    <?php
    $svgs = [
      'google'      => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#fff"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#fff"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#fff"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#fff"/></svg>',
      'facebook'    => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
      'yelp'        => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.16 12.73l-4.88 2.12 1.44 5.92c.18.72-.49 1.21-1.1.82l-4.2-2.78-4.2 2.78c-.61.4-1.28-.1-1.1-.82l1.44-5.92-4.88-2.12c-.62-.27-.45-1.1.24-1.2l5.92-.48 2.28-5.6c.28-.68 1.23-.68 1.51 0l2.28 5.6 5.92.48c.69.1.86.93.24 1.2z"/></svg>',
      'tripadvisor' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12.006 4.295c-2.67 0-5.338.784-7.645 2.353H0v12.706h4.35v-8.28c1.22-1.15 2.65-1.74 4.31-1.74 1.66 0 3.09.59 4.31 1.74v8.28h4.35V9.648c0-2.88-2.34-5.353-5.355-5.353zm12.006 0c-2.67 0-5.338.784-7.645 2.353H12v2.353h.01c1.12 0 2.23.25 3.24.73 1.01.48 1.92 1.17 2.7 2.04.78.87 1.4 1.9 1.84 3.06.44 1.16.66 2.4.66 3.7 0 2.88 2.34 5.35 5.35 5.35 2.67 0 5.34-.78 7.65-2.35V4.295h-4.35v8.28c-1.22 1.15-2.65 1.74-4.31 1.74-1.66 0-3.09-.59-4.31-1.74V4.295h-4.35z"/></svg>',
    ];
    foreach ($review_platforms as $p) {
      $info = $platform_labels[$p] ?? $platform_labels['google'];
      $url = $platform_defaults[$p] ?? $platform_defaults['google'];
      $svg = $svgs[$p] ?? $svgs['google'];
      ?>
    <a href="<?php echo htmlspecialchars($url); ?>" target="_blank" rel="noopener noreferrer" class="<?php echo htmlspecialchars($info['class']); ?>" title="<?php echo htmlspecialchars($info['title']); ?>" aria-label="<?php echo htmlspecialchars($info['aria']); ?>"><?php echo $svg; ?></a>
    <?php } ?>
  </div>
  <p class="reviews-platforms reviews-label">Click a platform above to leave your review.</p>
  <p class="reviews-thanks">We appreciate your feedback. Have a great day!</p>
</div>
<script>
(function() {
  var container = document.getElementById('fireworks');
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
    return {
      el: p,
      x: 0, y: 0,
      vx: Math.cos(angle) * speed,
      vy: Math.sin(angle) * speed - 60,
      gravity: 0.4,
      life: 1,
      decay: random(0.008, 0.018)
    };
  }

  for (var i = 0; i < particleCount; i++) particles.push(createParticle());

  var w = window.innerWidth;
  var h = window.innerHeight;
  var cx = w * centerX;
  var cy = h * centerY;

  function tick() {
    w = window.innerWidth;
    h = window.innerHeight;
    cx = w * centerX;
    cy = h * centerY;
    var allDone = true;
    for (var i = 0; i < particles.length; i++) {
      var p = particles[i];
      if (p.life <= 0) { p.el.style.opacity = 0; continue; }
      allDone = false;
      p.x += p.vx * 0.016;
      p.y += p.vy * 0.016;
      p.vy += p.gravity;
      p.vx *= 0.99;
      p.life -= p.decay;
      p.el.style.transform = 'translate(' + (cx + p.x) + 'px,' + (cy + p.y) + 'px)';
      p.el.style.opacity = p.life;
    }
    if (!allDone) requestAnimationFrame(tick);
  }
  requestAnimationFrame(tick);
})();
</script>
</body>
</html>
