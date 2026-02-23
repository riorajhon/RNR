<?php
require_once __DIR__ . '/../../backend/config.php';
$base_url = get_base_url();
$page_title = 'Contact | 1TXT';
require __DIR__ . '/../../backend/includes/header.php';

$icon_email = '<svg class="contact-icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>';
$icon_phone = '<svg class="contact-icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>';
$icon_chat = '<svg class="contact-icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>';
$icon_pin = '<svg class="contact-icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>';
$icon_send = '<svg class="contact-btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>';
?>
<main class="page-contact page-contact-cervei">
  <section class="contact-hero-cervei">
    <nav class="contact-breadcrumb" aria-label="Breadcrumb">
      <a href="<?php echo htmlspecialchars($base_url); ?>frontend/index.php">HOME</a>
      <span class="contact-breadcrumb-sep" aria-hidden="true">»</span>
      <span>CONTACT US</span>
    </nav>
    <h1 class="contact-hero-title">Get in Touch</h1>
    <p class="contact-hero-sub">We're here to help you succeed with better ratings</p>
  </section>

  <div class="contact-content-cervei">
    <div class="contact-two-col">
      <div class="contact-card contact-card-info">
        <h2 class="contact-card-title">Contact Information</h2>
        <p class="contact-card-intro">Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
        <div class="contact-methods">
          <div class="contact-method">
            <span class="contact-method-icon" aria-hidden="true"><?php echo $icon_email; ?></span>
            <div class="contact-method-body">
              <h3 class="contact-method-label">Email Support</h3>
              <p class="contact-method-value"><a href="mailto:support@1txt.co">support@1txt.co</a></p>
              <p class="contact-method-note">We typically respond within 24 hours</p>
            </div>
          </div>
          <div class="contact-method">
            <span class="contact-method-icon" aria-hidden="true"><?php echo $icon_phone; ?></span>
            <div class="contact-method-body">
              <h3 class="contact-method-label">Phone Support</h3>
              <p class="contact-method-value"><a href="tel:+1234567890">+1 (234) 567-890</a></p>
              <p class="contact-method-note">Monday – Friday, 9 AM – 6 PM EST</p>
            </div>
          </div>
          <div class="contact-method">
            <span class="contact-method-icon" aria-hidden="true"><?php echo $icon_chat; ?></span>
            <div class="contact-method-body">
              <h3 class="contact-method-label">Live Chat</h3>
              <p class="contact-method-value">Available on our website</p>
              <p class="contact-method-note">Get instant help from our support team</p>
            </div>
          </div>
          <div class="contact-method">
            <span class="contact-method-icon" aria-hidden="true"><?php echo $icon_pin; ?></span>
            <div class="contact-method-body">
              <h3 class="contact-method-label">Office Address</h3>
              <p class="contact-method-value">123 Survey Street<br>Tech City, TC 12345<br>United States</p>
            </div>
          </div>
        </div>
      </div>

      <div class="contact-card contact-card-form">
        <h2 class="contact-card-title">Send us a Message</h2>
        <form action="<?php echo htmlspecialchars($base_url); ?>backend/api/contact.php" method="post" id="contact-form" class="contact-form">
          <div class="contact-form-row">
            <div class="form-group">
              <label for="contact_name">Your Name *</label>
              <input type="text" id="contact_name" name="name" required minlength="2" maxlength="50" placeholder="Please enter your name (2-50 characters)">
            </div>
            <div class="form-group">
              <label for="contact_email">Your Email *</label>
              <input type="email" id="contact_email" name="email" required placeholder="Please enter a valid email address">
            </div>
          </div>
          <div class="form-group">
            <label for="contact_subject">Subject *</label>
            <input type="text" id="contact_subject" name="subject" required minlength="5" maxlength="100" placeholder="Please enter a subject (5-100 characters)">
          </div>
          <div class="form-group">
            <label for="contact_message">Your Message *</label>
            <textarea id="contact_message" name="message" required minlength="10" maxlength="1000" rows="5" placeholder="Please enter your message (10-1000 characters)"></textarea>
            <small class="contact-char-count">Characters: <span id="char_count">0</span>/1000</small>
          </div>
          <div class="form-group contact-checkbox">
            <label>
              <input type="checkbox" name="agree_privacy" required>
              <span class="contact-checkbox-text">I agree to the <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/privacy.php">Privacy Policy</a> and consent to being contacted regarding my inquiry.</span>
            </label>
          </div>
          <button type="submit" class="contact-submit-btn"><?php echo $icon_send; ?> Send Message</button>
        </form>
      </div>
    </div>

    <section class="contact-faq-cervei">
      <h2 class="contact-faq-heading">Frequently Asked Questions</h2>
      <p class="contact-faq-intro">Find quick answers to common questions about ratings and reviews</p>
      <div class="contact-faq-list">
        <details class="contact-faq-item">
          <summary class="contact-faq-question"><span class="contact-faq-plus" aria-hidden="true"></span>How do I get more reviews for my business?</summary>
          <p class="contact-faq-answer">Ask customers at the right moment—after a positive experience. Use 1TXT to send personalized review invites by text, add a review link to your website and emails, and make it easy with a short link or QR code. Many businesses see a big increase in reviews within the first few weeks.</p>
        </details>
        <details class="contact-faq-item">
          <summary class="contact-faq-question"><span class="contact-faq-plus" aria-hidden="true"></span>How do I respond to negative reviews?</summary>
          <p class="contact-faq-answer">Respond quickly and professionally. Thank the customer, apologize if appropriate, and offer to resolve the issue offline. Keep your tone calm and solution-focused. Remember that your response is visible to future customers and shows how you handle feedback.</p>
        </details>
        <details class="contact-faq-item">
          <summary class="contact-faq-question"><span class="contact-faq-plus" aria-hidden="true"></span>Can I use 1TXT on my website?</summary>
          <p class="contact-faq-answer">Yes. You can add a review widget or link to your website, embed ratings on key pages, and include a call-to-action in your footer. Putting reviews in text form (not just screenshots) can also help with SEO.</p>
        </details>
        <details class="contact-faq-item">
          <summary class="contact-faq-question"><span class="contact-faq-plus" aria-hidden="true"></span>Can I export or manage my reviews in one place?</summary>
          <p class="contact-faq-answer">Yes. With 1TXT you can collect and manage reviews, respond from one place, and use the audit feature to see how strong your ratings are and what to improve. We help you stay on top of your Google Business Profile and other platforms.</p>
        </details>
        <details class="contact-faq-item">
          <summary class="contact-faq-question"><span class="contact-faq-plus" aria-hidden="true"></span>Is my data secure?</summary>
          <p class="contact-faq-answer">Yes. We take data security seriously. Your business and customer data are protected with secure hosting and we do not share your information with third parties without your consent.</p>
        </details>
      </div>
    </section>
  </div>
</main>
<script>
  document.getElementById('contact_message').addEventListener('input', function() {
    document.getElementById('char_count').textContent = this.value.length;
  });
  document.getElementById('contact-form').addEventListener('submit', function(e) {
    e.preventDefault();
    var form = this;
    fetch(form.action, { method: 'POST', body: new FormData(form) })
      .then(function(r) { return r.json(); })
      .then(function(j) {
        if (j.success) { alert(j.message || 'Thank you. We will respond soon.'); form.reset(); document.getElementById('char_count').textContent = '0'; }
        else alert(j.error || 'Something went wrong.');
      })
      .catch(function() { form.submit(); });
  });
</script>
<?php require __DIR__ . '/../../backend/includes/footer.php'; ?>
