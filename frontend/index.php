<?php
require_once __DIR__ . '/../backend/config.php';
$base_url = get_base_url();
$page_title = 'RNR - Reduce Negative Reviews | Better Ratings for Your Business';
require __DIR__ . '/../backend/includes/header.php';
?>
<!-- Hero full-width -->
<section class="page-hero hero-with-bg hero-fullwidth">
  <div class="hero-bg" aria-hidden="true" style="background-image: url('<?php echo htmlspecialchars($base_url); ?>images/homepage/hero-building.jpg');"></div>
  <div class="hero-content">
    <h1 class="hero-title">Reduce negative reviews</h1>
    <p class="subheader">Higher ratings mean more trust and increased business</p>
    <div class="hero-ctas">
      <?php if (!empty($is_logged_in)): ?>
        <a href="<?php echo htmlspecialchars($base_url); ?>frontend/dashboard.php" class="btn btn-primary">Get started</a>
      <?php else: ?>
        <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/register.php" class="btn btn-primary">Sign up your business</a>
        <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/login.php" class="hero-signin">Have an account? Sign in</a>
      <?php endif; ?>
    </div>
  </div>
</section>
<main>
  <!-- Paragraph 1: style from photo 2, content from 1_hompage -->
  <section class="section section-animate para-1-layout para-photo2">
    <div class="para-1-text">
      <h2>A 4.5+ rating builds loyalty</h2>
      <p class="para-intro">Let unhappy customers speak to you BEFORE writing a public review. Happy customers can go straight to writing a public review.</p>
      <div class="para-features">
        <div class="para-feature">
          <span class="para-feature-icon para-feature-icon-1" aria-hidden="true">✓</span>
          <div>
            <strong>Before they go public</strong>
            <p>Let unhappy customers speak to you BEFORE writing a public review.</p>
          </div>
        </div>
        <div class="para-feature">
          <span class="para-feature-icon para-feature-icon-2">◆</span>
          <div>
            <strong>Happy customers</strong>
            <p>Happy customers can go straight to writing a public review.</p>
          </div>
        </div>
        <div class="para-feature">
          <span class="para-feature-icon para-feature-icon-3">◈</span>
          <div>
            <strong>On-brand replies</strong>
            <p>Our AI enabled platform guides every new review with a thoughtful, on-brand reply that matches your own tone — helping you build credibility, boost ratings, and show customers you care.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="para-1-carousel-wrap image-carousel image-carousel-no-nav" role="region" aria-label="Ratings and reviews">
      <div class="image-carousel-track">
        <div class="image-carousel-slide"><img src="<?php echo htmlspecialchars($base_url); ?>images/homepage/1.png" alt="Customer ratings"></div>
        <div class="image-carousel-slide"><img src="<?php echo htmlspecialchars($base_url); ?>images/homepage/3.png" alt="Reviews"></div>
        <div class="image-carousel-slide"><img src="<?php echo htmlspecialchars($base_url); ?>images/homepage/6.png" alt="Better ratings"></div>
      </div>
      <div class="image-carousel-nav" aria-hidden="true">
        <button type="button" class="image-carousel-prev" aria-label="Previous">‹</button>
        <span class="image-carousel-dots"></span>
        <button type="button" class="image-carousel-next" aria-label="Next">›</button>
      </div>
    </div>
  </section>

  <!-- Paragraph 2: single image on left, text on right (italic font + animations) -->
  <section class="section section-animate para-2-layout para-2-single para-2-animate">
    <div class="para-2-image-wrap para-2-slide-in">
      <img src="<?php echo htmlspecialchars($base_url); ?>images/homepage/7.png" alt="Turn reviews into visibility and new customers">
    </div>
    <div class="para-2-text para-2-slide-in">
      <h2 class="para-2-quote-heading">Turn reviews into visibility and new customers</h2>
      <p class="para-2-quote-body">More positive reviews help your business show up higher in local search. Share your best reviews on your website or social media — turning trust into new business.</p>
    </div>
  </section>

  <!-- Paragraph #4: Client Reviews style - white cards with stars, quote, avatar, name -->
  <section class="section section-animate para-4-reviews">
    <h2 class="para-4-reviews-title">View and respond to reviews quickly</h2>
    <p class="para-4-reviews-subtitle">Access all reviews in a centralised location and ensure you never miss any.</p>
    <div class="para-4-reviews-cards">
      <div class="review-card">
        <div class="review-card-stars">★★★★★</div>
        <p class="review-card-quote">"All my reviews in one place. I never miss a thing — reply from one dashboard."</p>
        <div class="review-card-author">
          <img class="review-card-avatar-img" src="<?php echo htmlspecialchars($base_url); ?>images/avatars/sarah.jpg" alt="Sarah M." width="44" height="44">
          <div>
            <span class="review-card-name">Sarah M.</span>
            <span class="review-card-role">Owner — Local Café</span>
          </div>
        </div>
      </div>
      <div class="review-card">
        <div class="review-card-stars">★★★★★</div>
        <p class="review-card-quote">"Staying on top of feedback is so much easier. I see every review as it comes in."</p>
        <div class="review-card-author">
          <img class="review-card-avatar-img" src="<?php echo htmlspecialchars($base_url); ?>images/avatars/james.jpg" alt="James K." width="44" height="44">
          <div>
            <span class="review-card-name">James K.</span>
            <span class="review-card-role">Manager — Retail Store</span>
          </div>
        </div>
      </div>
      <div class="review-card">
        <div class="review-card-stars">★★★★★</div>
        <p class="review-card-quote">"I reply to recent and past reviews in no time. Customers notice the quick response."</p>
        <div class="review-card-author">
          <img class="review-card-avatar-img" src="<?php echo htmlspecialchars($base_url); ?>images/avatars/lisa.jpg" alt="Lisa T." width="44" height="44">
          <div>
            <span class="review-card-name">Lisa T.</span>
            <span class="review-card-role">Owner — Salon</span>
          </div>
        </div>
      </div>
    </div>
    <p class="para-4-reviews-desc">Reply swiftly and efficiently to both recent and past reviews.</p>
  </section>

  <!-- Paragraph #5: 1_hompage -->
  <section class="section section-animate">
    <h2>What do our customers say?</h2>
    <p>Our platform prioritises simplicity and offers exceptional support to every user.</p>
    <div class="testimonials-carousel" role="region" aria-label="Testimonials">
      <div class="carousel-track">
        <div class="testimonial-box">
          <p>"I've been using 1txt for a few months now and I am extremely impressed with the results. My business's visibility on Google has significantly increased, and I am getting more customers as a result. Highly recommend!"</p>
          <div class="testimonial-author">
            <img class="testimonial-avatar-img" src="<?php echo htmlspecialchars($base_url); ?>images/avatars/sophie.jpg" alt="Sophie T." width="40" height="40">
            <cite>Sophie T.</cite>
          </div>
        </div>
        <div class="testimonial-box">
          <p>"This local tool has been a game-changer for my business. It was easy to use and provided clear, actionable tasks that helped me boost my rankings on Yelp and on TripAdvisor. I highly recommend it to other small business owners."</p>
          <div class="testimonial-author">
            <img class="testimonial-avatar-img" src="<?php echo htmlspecialchars($base_url); ?>images/avatars/conor.jpg" alt="Conor C" width="40" height="40">
            <cite>Conor C</cite>
          </div>
        </div>
        <div class="testimonial-box">
          <p>"I've been using 1txt for a while now and it has been a great investment. It helped me to identify areas of my customer ratings which needed improvement and provided clear instructions on how to fix them. Thanks to this tool, I am now ranking higher on Facebook marketplace, and getting more customers!"</p>
          <div class="testimonial-author">
            <img class="testimonial-avatar-img" src="<?php echo htmlspecialchars($base_url); ?>images/avatars/dom.jpg" alt="Dom P." width="40" height="40">
            <cite>Dom P.</cite>
          </div>
        </div>
      </div>
      <div class="carousel-nav">
        <button type="button" class="carousel-prev" aria-label="Previous testimonial">‹</button>
        <span class="carousel-dots"></span>
        <button type="button" class="carousel-next" aria-label="Next testimonial">›</button>
      </div>
    </div>
  </section>

  <!-- Paragraph #3: CTA (moved under Paragraph 5) – typing effect + distinct font -->
  <section class="section section-animate para-3-cta para-3-no-bg">
    <div class="para-3-cta-content">
      <h2 class="para-3-cta-title"><span class="para-3-typing" aria-label="Start growing your business today"></span><span class="para-3-cursor" aria-hidden="true">|</span></h2>
      <div class="para-3-cta-buttons">
        <?php if (!empty($is_logged_in)): ?>
          <a href="<?php echo htmlspecialchars($base_url); ?>frontend/dashboard.php" class="btn btn-cta-primary">Get started</a>
        <?php else: ?>
          <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/register.php" class="btn btn-cta-primary">Sign up your business</a>
          <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/login.php" class="btn btn-cta-secondary">Have an account? Sign in</a>
        <?php endif; ?>
      </div>
    </div>
  </section>
</main>
<script>
(function() {
  var sections = document.querySelectorAll('.section-animate');
  if (sections.length) {
    var observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(e) {
        if (e.isIntersecting) e.target.classList.add('visible');
      });
    }, { rootMargin: '0px 0px -60px 0px', threshold: 0.1 });
    sections.forEach(function(s) { observer.observe(s); });
  }
  function initImageCarousel(el) {
    var track = el.querySelector('.image-carousel-track');
    var slides = el.querySelectorAll('.image-carousel-slide');
    var prev = el.querySelector('.image-carousel-prev');
    var next = el.querySelector('.image-carousel-next');
    var dotsEl = el.querySelector('.image-carousel-dots');
    if (!track || !slides.length || !dotsEl) return;
    var n = slides.length;
    var idx = 0;
    var autoTimer = null;
    function goTo(i) {
      idx = (i + n) % n;
      track.style.transform = 'translateX(-' + (idx * 100) + '%)';
      var dots = el.querySelectorAll('.image-carousel-dot');
      dots.forEach(function(d, j) { d.classList.toggle('active', j === idx); });
    }
    function startAuto() {
      if (autoTimer) return;
      autoTimer = setInterval(function() { goTo(idx + 1); }, 4500);
    }
    function stopAuto() { if (autoTimer) { clearInterval(autoTimer); autoTimer = null; } }
    for (var i = 0; i < n; i++) {
      var dot = document.createElement('button');
      dot.type = 'button';
      dot.className = 'image-carousel-dot' + (i === 0 ? ' active' : '');
      dot.setAttribute('aria-label', 'Slide ' + (i + 1));
      dot.addEventListener('click', function(k) { return function() { goTo(k); }; }(i));
      dotsEl.appendChild(dot);
    }
    prev.addEventListener('click', function() { goTo(idx - 1); });
    next.addEventListener('click', function() { goTo(idx + 1); });
    el.addEventListener('mouseenter', stopAuto);
    el.addEventListener('mouseleave', startAuto);
    var startX = 0;
    el.addEventListener('touchstart', function(e) { startX = e.touches[0].clientX; }, { passive: true });
    el.addEventListener('touchend', function(e) {
      var dx = e.changedTouches[0].clientX - startX;
      if (Math.abs(dx) > 50) goTo(idx + (dx < 0 ? 1 : -1));
    }, { passive: true });
    startAuto();
  }
  document.querySelectorAll('.image-carousel').forEach(initImageCarousel);
  var carousel = document.querySelector('.testimonials-carousel');
  if (carousel) {
    var track = carousel.querySelector('.carousel-track');
    var slides = carousel.querySelectorAll('.testimonial-box');
    var prev = carousel.querySelector('.carousel-prev');
    var next = carousel.querySelector('.carousel-next');
    var dotsEl = carousel.querySelector('.carousel-dots');
    var n = slides.length;
    var idx = 0;
    var autoTimer = null;
    function goTo(i) {
      idx = (i + n) % n;
      track.style.transform = 'translateX(-' + (idx * 100) + '%)';
      var dots = carousel.querySelectorAll('.carousel-dot');
      dots.forEach(function(d, j) { d.classList.toggle('active', j === idx); });
    }
    function startAuto() {
      if (autoTimer) return;
      autoTimer = setInterval(function() { goTo(idx + 1); }, 5000);
    }
    function stopAuto() { if (autoTimer) { clearInterval(autoTimer); autoTimer = null; } }
    slides.forEach(function(_, i) {
      var dot = document.createElement('button');
      dot.type = 'button';
      dot.className = 'carousel-dot' + (i === 0 ? ' active' : '');
      dot.setAttribute('aria-label', 'Testimonial ' + (i + 1));
      dot.addEventListener('click', function() { goTo(i); });
      dotsEl.appendChild(dot);
    });
    prev.addEventListener('click', function() { goTo(idx - 1); });
    next.addEventListener('click', function() { goTo(idx + 1); });
    carousel.addEventListener('mouseenter', stopAuto);
    carousel.addEventListener('mouseleave', startAuto);
    var startX = 0;
    carousel.addEventListener('touchstart', function(e) { startX = e.touches[0].clientX; }, { passive: true });
    carousel.addEventListener('touchend', function(e) {
      var dx = e.changedTouches[0].clientX - startX;
      if (Math.abs(dx) > 50) goTo(idx + (dx < 0 ? 1 : -1));
    }, { passive: true });
    startAuto();
  }
  // Typing effect for "Start growing your business today" (runs when section is visible)
  var para3 = document.querySelector('.para-3-cta');
  var typingEl = document.querySelector('.para-3-typing');
  var cursorEl = document.querySelector('.para-3-cursor');
  var typingText = 'Start growing your business today';
  if (para3 && typingEl && cursorEl) {
    var typed = false;
    var charDelay = 160;
    var pauseBeforeRepeat = 2200;
    function runTyping() {
      var i = 0;
      typingEl.textContent = '';
      function type() {
        if (i < typingText.length) {
          typingEl.textContent += typingText.charAt(i);
          i++;
          setTimeout(type, charDelay);
        } else {
          setTimeout(function() {
            runTyping();
          }, pauseBeforeRepeat);
        }
      }
      type();
    }
    var obs = new IntersectionObserver(function(entries) {
      entries.forEach(function(e) {
        if (!e.isIntersecting || typed) return;
        typed = true;
        runTyping();
      });
    }, { threshold: 0.2 });
    obs.observe(para3);
  }
})();
</script>
<?php require __DIR__ . '/../backend/includes/footer.php'; ?>
