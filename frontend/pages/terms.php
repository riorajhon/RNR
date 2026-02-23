<?php
require_once __DIR__ . '/../../backend/config.php';
$base_url = get_base_url();
$page_title = 'Terms and Conditions | 1TXT';
require __DIR__ . '/../../backend/includes/header.php';
?>
<main class="page-terms-modern">
  <section class="terms-hero">
    <div class="terms-hero-badge">
      <svg class="terms-badge-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
        <polyline points="14 2 14 8 20 8"/>
        <line x1="16" y1="13" x2="8" y2="13"/>
        <line x1="16" y1="17" x2="8" y2="17"/>
        <polyline points="10 9 9 9 8 9"/>
      </svg>
      <span>Legal Agreement</span>
    </div>
    <h1 class="terms-hero-title">Terms and Conditions</h1>
    <p class="terms-hero-subtitle">Please read these terms carefully before using our services. By accessing 1TXT, you agree to be bound by these terms.</p>
    <div class="terms-hero-meta">
      <span class="terms-meta-item">
        <svg class="terms-meta-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
          <line x1="16" y1="2" x2="16" y2="6"/>
          <line x1="8" y1="2" x2="8" y2="6"/>
          <line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
        Last Updated: February 2026
      </span>
      <span class="terms-meta-item">
        <svg class="terms-meta-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/>
          <polyline points="12 6 12 12 16 14"/>
        </svg>
        7 min read
      </span>
    </div>
  </section>

  <div class="terms-content-wrapper">
    <aside class="terms-sidebar">
      <nav class="terms-nav" aria-label="Terms sections">
        <h3 class="terms-nav-title">Table of Contents</h3>
        <ul class="terms-nav-list">
          <li><a href="#intro" class="terms-nav-link">Introduction</a></li>
          <li><a href="#scope" class="terms-nav-link">Scope of Services</a></li>
          <li><a href="#eligibility" class="terms-nav-link">Eligibility</a></li>
          <li><a href="#account" class="terms-nav-link">Your Account</a></li>
          <li><a href="#acceptable-use" class="terms-nav-link">Acceptable Use</a></li>
          <li><a href="#subscription" class="terms-nav-link">Subscription & Payment</a></li>
          <li><a href="#intellectual-property" class="terms-nav-link">Intellectual Property</a></li>
          <li><a href="#privacy" class="terms-nav-link">Privacy</a></li>
          <li><a href="#termination" class="terms-nav-link">Termination</a></li>
          <li><a href="#liability" class="terms-nav-link">Limitation of Liability</a></li>
          <li><a href="#contact" class="terms-nav-link">Contact</a></li>
        </ul>
      </nav>
      <div class="terms-help-box">
        <h4>Need Clarification?</h4>
        <p>Our legal team is available to answer any questions about these terms.</p>
        <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/contact.php" class="btn btn-outline btn-sm">Get Help</a>
      </div>
    </aside>

    <div class="terms-main-content">
      <section class="terms-section" id="intro">
        <div class="terms-section-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <path d="M12 16v-4M12 8h.01"/>
          </svg>
        </div>
        <h2>Welcome to 1TXT</h2>
        <p>These Terms and Conditions ("Terms") govern your use of the 1TXT platform and services. By creating an account or using our services, you agree to these Terms and our <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/privacy.php">Privacy Policy</a>.</p>
        <div class="terms-important-box">
          <strong>Important:</strong> Please read these Terms carefully. If you do not agree with any part of these Terms, you should not use our services.
        </div>
      </section>

      <section class="terms-section" id="scope">
        <div class="terms-section-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
          </svg>
        </div>
        <h2>Scope of Our Services</h2>
        <p>1TXT is a platform that helps small businesses collect customer ratings and feedback via QR codes, manage reviews, and improve their online reputation.</p>
        
        <div class="terms-feature-list">
          <h3>Our Services Include:</h3>
          <ul>
            <li>QR code generation for customer rating collection</li>
            <li>Rating page customization and management</li>
            <li>Customer feedback collection and analysis</li>
            <li>Review management dashboard</li>
            <li>Data export and reporting tools</li>
            <li>Customer support and guidance</li>
          </ul>
        </div>

        <p class="terms-disclaimer">The site and content are provided on an "as is, as available" basis. We reserve the right to modify, suspend, or discontinue any part of our services at any time.</p>
      </section>

      <section class="terms-section" id="eligibility">
        <div class="terms-section-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
          </svg>
        </div>
        <h2>Who Can Use Our Services</h2>
        <p>By using 1TXT, you represent and warrant that:</p>
        <ul class="terms-list-styled">
          <li>You are at least eighteen (18) years old</li>
          <li>You have the legal capacity to form a binding contract</li>
          <li>You are using the service for legitimate business purposes</li>
          <li>You will comply with all applicable laws and regulations</li>
          <li>All information you provide is accurate and truthful</li>
        </ul>
        <p>We reserve the right to terminate access to our services at our discretion if these requirements are not met.</p>
      </section>

      <section class="terms-section" id="account">
        <div class="terms-section-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
          </svg>
        </div>
        <h2>Your Account Responsibilities</h2>
        
        <details class="terms-accordion-item" open>
          <summary class="terms-accordion-header">
            <span>Account Information</span>
            <svg class="terms-accordion-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="6 9 12 15 18 9"/>
            </svg>
          </summary>
          <div class="terms-accordion-content">
            <p>All information in your account is provided by you. It is your obligation to keep your profile information accurate, complete, and current. You are responsible for:</p>
            <ul>
              <li>Maintaining the confidentiality of your password</li>
              <li>All activities that occur under your account</li>
              <li>Notifying us immediately of any unauthorized use</li>
              <li>Ensuring your contact information is up to date</li>
            </ul>
          </div>
        </details>

        <details class="terms-accordion-item">
          <summary class="terms-accordion-header">
            <span>Account Security</span>
            <svg class="terms-accordion-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="6 9 12 15 18 9"/>
            </svg>
          </summary>
          <div class="terms-accordion-content">
            <p>You must take reasonable steps to protect your account credentials. We recommend:</p>
            <ul>
              <li>Using a strong, unique password</li>
              <li>Enabling two-factor authentication</li>
              <li>Not sharing your login credentials with others</li>
              <li>Logging out from shared devices</li>
            </ul>
          </div>
        </details>

        <details class="terms-accordion-item">
          <summary class="terms-accordion-header">
            <span>Account Termination</span>
            <svg class="terms-accordion-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="6 9 12 15 18 9"/>
            </svg>
          </summary>
          <div class="terms-accordion-content">
            <p>You may close your account at any time through your account settings or by contacting support. Upon termination, your access to the services will cease, and your data will be handled according to our Privacy Policy.</p>
          </div>
        </details>
      </section>

      <section class="terms-section" id="acceptable-use">
        <div class="terms-section-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="15" y1="9" x2="9" y2="15"/>
            <line x1="9" y1="9" x2="15" y2="15"/>
          </svg>
        </div>
        <h2>Acceptable Use Policy</h2>
        <p>You agree not to use the Services for any unlawful or prohibited purpose. Specifically, you may not:</p>
        
        <div class="terms-prohibited-grid">
          <div class="terms-prohibited-item">
            <div class="terms-prohibited-icon">⚠️</div>
            <h4>Illegal Activities</h4>
            <p>Use our services for any illegal purpose or in violation of any laws</p>
          </div>
          <div class="terms-prohibited-item">
            <div class="terms-prohibited-icon">🚫</div>
            <h4>Harmful Content</h4>
            <p>Upload or transmit viruses, malware, or any harmful code</p>
          </div>
          <div class="terms-prohibited-item">
            <div class="terms-prohibited-icon">🔓</div>
            <h4>Unauthorized Access</h4>
            <p>Attempt to gain unauthorized access to our systems or other users' accounts</p>
          </div>
          <div class="terms-prohibited-item">
            <div class="terms-prohibited-icon">📧</div>
            <h4>Spam & Abuse</h4>
            <p>Send unsolicited communications or abuse our communication features</p>
          </div>
          <div class="terms-prohibited-item">
            <div class="terms-prohibited-icon">⚙️</div>
            <h4>System Interference</h4>
            <p>Damage, disable, or impair the functionality of our services</p>
          </div>
          <div class="terms-prohibited-item">
            <div class="terms-prohibited-icon">🤖</div>
            <h4>Automated Abuse</h4>
            <p>Use bots or automated systems to manipulate ratings or reviews</p>
          </div>
        </div>
      </section>

      <section class="terms-section" id="subscription">
        <div class="terms-section-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
            <line x1="1" y1="10" x2="23" y2="10"/>
          </svg>
        </div>
        <h2>Subscription & Payment Terms</h2>
        
        <div class="terms-pricing-info">
          <h3>Our Pricing Plans</h3>
          <div class="terms-pricing-cards">
            <div class="terms-pricing-card">
              <h4>Monthly Plan</h4>
              <div class="terms-price">$2<span>/month</span></div>
              <p>Billed monthly, cancel anytime</p>
            </div>
            <div class="terms-pricing-card terms-pricing-featured">
              <h4>Annual Plan</h4>
              <div class="terms-price">$20<span>/year</span></div>
              <p>Save 20% with annual billing</p>
            </div>
          </div>
        </div>

        <h3>Payment Terms</h3>
        <ul class="terms-list-styled">
          <li>All fees are in USD and exclude applicable taxes</li>
          <li>Subscriptions automatically renew unless cancelled</li>
          <li>You can cancel your subscription at any time</li>
          <li>Refunds are provided on a case-by-case basis</li>
          <li>We use Stripe for secure payment processing</li>
          <li>You authorize us to charge your payment method for recurring fees</li>
        </ul>

        <div class="terms-note-box">
          <strong>Note:</strong> If payment fails, we'll notify you and may suspend your account until payment is received. You remain responsible for any outstanding fees.
        </div>
      </section>

      <section class="terms-section" id="intellectual-property">
        <div class="terms-section-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 2L2 7l10 5 10-5-10-5z"/>
            <path d="M2 17l10 5 10-5M2 12l10 5 10-5"/>
          </svg>
        </div>
        <h2>Intellectual Property Rights</h2>
        
        <h3>Our Content</h3>
        <p>All content, features, and functionality of the 1TXT platform, including but not limited to text, graphics, logos, icons, images, and software, are the exclusive property of 1TXT and are protected by copyright, trademark, and other intellectual property laws.</p>

        <h3>Your Content</h3>
        <p>You retain all rights to the content you create and collect through our platform, including:</p>
        <ul class="terms-list-styled">
          <li>Customer ratings and feedback</li>
          <li>Business information and settings</li>
          <li>Custom questions and responses</li>
          <li>Exported data and reports</li>
        </ul>

        <p>By using our services, you grant us a limited license to use your content solely for the purpose of providing and improving our services.</p>
      </section>

      <section class="terms-section" id="privacy">
        <div class="terms-section-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
          </svg>
        </div>
        <h2>Privacy & Data Protection</h2>
        <p>Your privacy is important to us. Our collection, use, and protection of your personal information is governed by our <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/privacy.php">Privacy Policy</a>.</p>
        
        <div class="terms-privacy-highlights">
          <div class="terms-privacy-item">
            <h4>🔒 GDPR Compliant</h4>
            <p>We meet EU data protection standards</p>
          </div>
          <div class="terms-privacy-item">
            <h4>🛡️ Secure Storage</h4>
            <p>Banking-grade encryption for all data</p>
          </div>
          <div class="terms-privacy-item">
            <h4>👤 Your Data Rights</h4>
            <p>Access, export, or delete your data anytime</p>
          </div>
        </div>
      </section>

      <section class="terms-section" id="termination">
        <div class="terms-section-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="15" y1="9" x2="9" y2="15"/>
            <line x1="9" y1="9" x2="15" y2="15"/>
          </svg>
        </div>
        <h2>Termination of Services</h2>
        
        <h3>Your Right to Terminate</h3>
        <p>You may cancel your subscription and close your account at any time through your account settings or by contacting our support team at <a href="mailto:support@1txt.co">support@1txt.co</a>.</p>

        <h3>Our Right to Terminate</h3>
        <p>We reserve the right to suspend or terminate your access to our services if:</p>
        <ul class="terms-list-styled">
          <li>You violate these Terms of Service</li>
          <li>Your account shows suspicious or fraudulent activity</li>
          <li>You fail to pay applicable fees</li>
          <li>We're required to do so by law</li>
          <li>We discontinue the service (with reasonable notice)</li>
        </ul>

        <h3>Effect of Termination</h3>
        <p>Upon termination, your right to use the services will immediately cease. We may delete your account data in accordance with our data retention policies, though some information may be retained as required by law.</p>
      </section>

      <section class="terms-section" id="liability">
        <div class="terms-section-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
            <line x1="12" y1="9" x2="12" y2="13"/>
            <line x1="12" y1="17" x2="12.01" y2="17"/>
          </svg>
        </div>
        <h2>Limitation of Liability</h2>
        
        <div class="terms-liability-box">
          <p><strong>Disclaimer:</strong> The 1TXT platform is provided "as is" and "as available" without warranties of any kind, either express or implied.</p>
        </div>

        <p>To the maximum extent permitted by law, 1TXT shall not be liable for:</p>
        <ul class="terms-list-styled">
          <li>Any indirect, incidental, special, or consequential damages</li>
          <li>Loss of profits, revenue, data, or business opportunities</li>
          <li>Service interruptions or technical issues</li>
          <li>Actions or content of third parties</li>
          <li>Unauthorized access to your account due to your negligence</li>
        </ul>

        <p>Our total liability to you for any claims arising from your use of our services shall not exceed the amount you paid us in the twelve (12) months preceding the claim.</p>
      </section>

      <section class="terms-section" id="contact">
        <div class="terms-contact-card">
          <div class="terms-contact-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
            </svg>
          </div>
          <h2>Questions About These Terms?</h2>
          <p>If you have any questions or concerns about these Terms and Conditions, please don't hesitate to reach out to our team.</p>
          <div class="terms-contact-details">
            <p><strong>Email:</strong> <a href="mailto:support@1txt.co">support@1txt.co</a></p>
            <p><strong>Phone:</strong> <a href="tel:+1234567890">+1 (234) 567-890</a></p>
            <p><strong>Hours:</strong> Monday - Friday, 9 AM - 6 PM EST</p>
          </div>
          <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/contact.php" class="btn btn-primary">Contact Legal Team</a>
        </div>
      </section>

      <div class="terms-footer-note">
        <p><strong>Effective Date:</strong> These Terms and Conditions are effective as of February 2026 and apply to all users of the 1TXT platform.</p>
        <p><strong>Changes to Terms:</strong> We reserve the right to modify these Terms at any time. We will notify you of any material changes via email or through a prominent notice on our website.</p>
      </div>
    </div>
  </div>
</main>
<?php require __DIR__ . '/../../backend/includes/footer.php'; ?>
