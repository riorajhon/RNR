<?php
require_once __DIR__ . '/../../backend/config.php';
$base_url = get_base_url();
$page_title = 'Data Security & GDPR | 1TXT';
require __DIR__ . '/../../backend/includes/header.php';
?>
<!-- Hero full-width (same structure as index.php) -->
<section class="page-hero hero-with-bg hero-fullwidth hero-security">
  <div class="hero-bg" aria-hidden="true" style="background-image: url('<?php echo htmlspecialchars($base_url); ?>images/security/hero3.png');"></div>
  <div class="hero-content">
    <h1 class="hero-title">Data privacy & GDPR compliance</h1>
    <p class="subheader">Customer reviews are powerful data capture tools. The great news is that 1TXT is built to be GDPR-compliant.</p>
    <div class="hero-ctas">
      <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/login.php" class="hero-signin">Have an account? Sign in</a>
    </div>
  </div>
</section>
<main class="page-data-security">
  <section class="section section-animate ds-para1 ds-para1-cards">
    <div class="ds-para1-inner">
      <div class="ds-para1-text">
        <h2 class="ds-para1-title">What does GDPR-compliance mean?</h2>
        <p class="ds-para1-subtitle">Your data, protected.</p>
        <p class="ds-para1-body">The European Union's General Data Protection Regulation (GDPR) is a comprehensive data privacy and protection law. It applies to any organization that collects or processes personal data from EU residents. Non-compliance with GDPR can result in significant fines and legal action.</p>
        <p class="ds-para1-body">GDPR is similar to global data privacy regulations like California's Consumer Privacy Act (CCPA) and Canada's Personal Information Protection and Electronic Documents Act (PIPEDA).</p>
      </div>
      <div class="ds-para1-cards-wrap">
        <div class="ds-para1-card ds-para1-card-1">
          <h3>Trusted by businesses</h3>
          <p>1TXT helps you stay compliant while collecting and managing customer reviews.</p>
        </div>
        <div class="ds-para1-card ds-para1-card-2">
          <h3>Recognition & compliance</h3>
          <hr>
          <p>Highlights of our approach to data protection:</p>
          <div class="ds-para1-badges">
            <span class="ds-para1-badge">GDPR READY</span>
            <span class="ds-para1-badge">SECURE</span>
            <span class="ds-para1-badge">ENCRYPTED</span>
          </div>
        </div>
        <div class="ds-para1-circle">
          <span class="ds-para1-circle-text">DATA PROTECTED</span>
          <span class="ds-para1-circle-value">24/7</span>
        </div>
        <div class="ds-para1-card ds-para1-card-3">
          <h3>Secure by design</h3>
          <hr>
          <p>Encrypted storage, banking-grade infrastructure, and 2FA for all logins.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Paragraph 2: Photo 1 style – purple container, image left, text + deliver banners right -->
  <section class="section section-animate ds-para2 ds-photo1">
    <div class="ds-para2-inner">
      <div class="ds-para2-image ds-para2-image-panels">
        <div class="ds-para2-panel">
          <img src="<?php echo htmlspecialchars($base_url); ?>images/security/1.png" alt="Security">
          <span class="ds-para2-overlay" aria-hidden="true"></span>
        </div>
        <div class="ds-para2-panel">
          <img src="<?php echo htmlspecialchars($base_url); ?>images/security/4.png" alt="Data protection">
          <span class="ds-para2-overlay" aria-hidden="true"></span>
        </div>
        <div class="ds-para2-panel">
          <img src="<?php echo htmlspecialchars($base_url); ?>images/security/5.png" alt="GDPR compliant">
          <span class="ds-para2-overlay" aria-hidden="true"></span>
        </div>
      </div>
      <div class="ds-para2-content">
        <h2 class="ds-para2-title">How we are GDPR-compliant</h2>
        <p class="ds-para2-body">Build compliant, reliable, and privacy-ready software with a partner trusted for secure data handling. 1TXT data is securely stored on our encrypted servers in a banking-grade data center. We deliver secure, scalable products built for regulated environments.</p>
        <p class="ds-para2-lead">What we deliver:</p>
        <div class="ds-para2-banners">
          <div class="ds-para2-banner">Encrypted servers & secure storage</div>
          <div class="ds-para2-banner">Banking-grade data center</div>
          <div class="ds-para2-banner">Secure lead data & aggregate-by-default</div>
          <div class="ds-para2-banner">Two-factor authentication (2FA) for logins</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Paragraph 3: Photo 2 style – white card, left nav pills, right content -->
  <section class="section section-animate ds-para3 ds-photo2">
    <h2 class="ds-para3-heading">Our approach to privacy</h2>
    <p class="ds-para3-subheading">Create trust with your customers using our team</p>
    <div class="ds-para3-card">
      <div class="ds-para3-nav">
        <span class="ds-para3-pill">Encryption</span>
        <span class="ds-para3-pill">Storage</span>
        <span class="ds-para3-pill ds-para3-pill-active">No tracking</span>
        <span class="ds-para3-pill">Cookies</span>
        <span class="ds-para3-pill">Control</span>
      </div>
      <div class="ds-para3-main">
        <div class="ds-para3-visual">
          <img src="<?php echo htmlspecialchars($base_url); ?>images/security/22.png" alt="No tracking">
          <img src="<?php echo htmlspecialchars($base_url); ?>images/security/55.png" alt="Privacy">
          <img src="<?php echo htmlspecialchars($base_url); ?>images/security/44.png" alt="Data protection">
        </div>
        <h3 class="ds-para3-title">No tracking and almost zero cookies →</h3>
        <p class="ds-para3-body">We do not track users' personal data. Any content you create and embed does not track: IP addresses, Google or other US-based analytics, or Google Fonts. We add just one anonymous session cookie for your embedded content, without collecting any personal data.</p>
      </div>
    </div>
  </section>

  <!-- Paragraph 4: Photo 3 style – two cols, checkmarks + button left, image right on lavender -->
  <section class="section section-animate ds-para4 ds-photo3">
    <div class="ds-para4-inner">
      <div class="ds-para4-text">
        <h2 class="ds-para4-title">We give users full control of their data</h2>
        <p class="ds-para4-body">We're transparent with our users and give them full control over their data. When users fill in lead-forms, they can opt-in to how their data will be stored, processed, and used. As a 1TXT client, you can require double-opt in with email confirmation.</p>
        <ul class="ds-para4-list">
          <li><span class="ds-para4-check">✓</span> Transparent policies</li>
          <li><span class="ds-para4-check">✓</span> Opt-in choices</li>
          <li><span class="ds-para4-check">✓</span> Secure data rooms</li>
          <li><span class="ds-para4-check">✓</span> Double opt-in option</li>
        </ul>
      </div>
      <div class="ds-para4-image-wrap">
        <img src="<?php echo htmlspecialchars($base_url); ?>images/security/33.png" alt="User control">
      </div>
    </div>
  </section>

  <!-- Paragraph 5: Photo 4 style – dark section, grid of highlight cards -->
  <section class="section section-animate ds-para5 ds-photo4">
    <h2 class="ds-para5-title">Data protection highlights</h2>
    <p class="ds-para5-subtitle">With 1TXT, you keep control of your data. We do not share or sell it, and only you can view what your customers provide.</p>
    <div class="ds-para5-grid">
      <div class="ds-para5-card">
        <span class="ds-para5-icon">◆</span>
        <h3>Your data only</h3>
        <p>Only you can view data collected from your customers, including personal data from lead forms.</p>
      </div>
      <div class="ds-para5-card">
        <span class="ds-para5-icon">▣</span>
        <h3>You own the content</h3>
        <p>You own all ratings and review data. We do not make your content searchable or repurpose it.</p>
      </div>
      <div class="ds-para5-card">
        <span class="ds-para5-icon">◇</span>
        <h3>No selling data</h3>
        <p>We do not share or sell any data. Your customer information stays with you.</p>
      </div>
      <div class="ds-para5-card">
        <span class="ds-para5-icon">◈</span>
        <h3>Secure & compliant</h3>
        <p>Encrypted storage and GDPR-aligned practices so you can trust how data is handled.</p>
      </div>
    </div>
  </section>
</main>
<?php require __DIR__ . '/../../backend/includes/footer.php'; ?>
