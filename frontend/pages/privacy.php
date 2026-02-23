<?php
require_once __DIR__ . '/../../backend/config.php';
$base_url = get_base_url();
$page_title = 'Privacy Policy | 1TXT';
require __DIR__ . '/../../backend/includes/header.php';
?>
<main class="page-privacy-modern">
  <section class="privacy-hero">
    <div class="privacy-hero-badge">
      <svg class="privacy-badge-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
      </svg>
      <span>GDPR & CCPA Compliant</span>
    </div>
    <h1 class="privacy-hero-title">Privacy Policy</h1>
    <p class="privacy-hero-subtitle">Your privacy matters. We're committed to protecting your data and being transparent about how we use it.</p>
    <div class="privacy-hero-meta">
      <span class="privacy-meta-item">
        <svg class="privacy-meta-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
          <line x1="16" y1="2" x2="16" y2="6"/>
          <line x1="8" y1="2" x2="8" y2="6"/>
          <line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
        Last Updated: February 2026
      </span>
      <span class="privacy-meta-item">
        <svg class="privacy-meta-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/>
          <polyline points="12 6 12 12 16 14"/>
        </svg>
        5 min read
      </span>
    </div>
  </section>

  <div class="privacy-content-wrapper">
    <aside class="privacy-sidebar">
      <nav class="privacy-nav" aria-label="Privacy policy sections">
        <h3 class="privacy-nav-title">Quick Navigation</h3>
        <ul class="privacy-nav-list">
          <li><a href="#intro" class="privacy-nav-link">Introduction</a></li>
          <li><a href="#scope" class="privacy-nav-link">Scope</a></li>
          <li><a href="#collection" class="privacy-nav-link">Data Collection</a></li>
          <li><a href="#usage" class="privacy-nav-link">How We Use Data</a></li>
          <li><a href="#security" class="privacy-nav-link">Security</a></li>
          <li><a href="#rights" class="privacy-nav-link">Your Rights</a></li>
          <li><a href="#updates" class="privacy-nav-link">Policy Updates</a></li>
          <li><a href="#contact" class="privacy-nav-link">Contact Us</a></li>
        </ul>
      </nav>
      <div class="privacy-cta-box">
        <h4>Questions?</h4>
        <p>Our team is here to help clarify any privacy concerns.</p>
        <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/contact.php" class="btn btn-outline btn-sm">Contact Support</a>
      </div>
    </aside>

    <div class="privacy-main-content">
      <section class="privacy-section" id="intro">
        <div class="privacy-section-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 2L2 7l10 5 10-5-10-5z"/>
            <path d="M2 17l10 5 10-5M2 12l10 5 10-5"/>
          </svg>
        </div>
        <h2>Our Commitment to Your Privacy</h2>
        <p>At 1TXT, we're committed to protecting your privacy and the information you share with us. We recognize how important privacy is to you and we take great care to ensure the information you provide is secure. This Privacy Policy describes how 1TXT handles and protects your data when using our online services.</p>
      </section>

      <section class="privacy-section" id="scope">
        <div class="privacy-section-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="2" y1="12" x2="22" y2="12"/>
            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
          </svg>
        </div>
        <h2>Scope of This Policy</h2>
        <p>This Privacy Statement explains how 1TXT handles and protects your information when you use our platform. It does not cover how your information may be handled by third parties with whom you choose to share it.</p>
        <div class="privacy-highlight-box">
          <strong>Important:</strong> We strongly encourage you to take great care in choosing what information to share with third parties and to review their privacy policies.
        </div>
      </section>

      <section class="privacy-section" id="collection">
        <div class="privacy-section-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
          </svg>
        </div>
        <h2>Information We Collect</h2>
        <p>To provide you with excellent service, 1TXT collects personally identifiable information (PII) from you only with your knowledge and consent.</p>
        
        <div class="privacy-data-grid">
          <div class="privacy-data-card">
            <h4>Account Information</h4>
            <ul>
              <li>Name</li>
              <li>Email address</li>
              <li>Password (encrypted)</li>
              <li>Business address</li>
            </ul>
          </div>
          <div class="privacy-data-card">
            <h4>Business Data</h4>
            <ul>
              <li>Customer ratings</li>
              <li>Feedback responses</li>
              <li>QR code settings</li>
              <li>Review analytics</li>
            </ul>
          </div>
          <div class="privacy-data-card">
            <h4>Contact Details</h4>
            <ul>
              <li>Phone numbers</li>
              <li>Support inquiries</li>
              <li>Communication preferences</li>
            </ul>
          </div>
        </div>
      </section>

      <section class="privacy-section" id="usage">
        <div class="privacy-section-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
          </svg>
        </div>
        <h2>How We Use Your Information</h2>
        <p>We collect and use your information for the following purposes:</p>
        <ul class="privacy-list-styled">
          <li>To provide access to our products, services, and applications</li>
          <li>To complete transactions and manage your subscription</li>
          <li>To send important service updates and newsletters (with your consent)</li>
          <li>To provide customer support and respond to your inquiries</li>
          <li>To improve our services and develop new features</li>
          <li>To ensure platform security and prevent fraud</li>
        </ul>
      </section>

      <section class="privacy-section" id="security">
        <div class="privacy-section-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
          </svg>
        </div>
        <h2>Security Measures</h2>
        <p>1TXT is committed to keeping your personal information secure. We employ multiple layers of protection:</p>
        
        <div class="privacy-security-grid">
          <div class="privacy-security-item">
            <div class="privacy-security-icon">🔒</div>
            <h4>Encryption</h4>
            <p>All data is encrypted in transit and at rest using industry-standard protocols</p>
          </div>
          <div class="privacy-security-item">
            <div class="privacy-security-icon">🛡️</div>
            <h4>Access Controls</h4>
            <p>Strict internal controls limit access to your non-public information</p>
          </div>
          <div class="privacy-security-item">
            <div class="privacy-security-icon">🔐</div>
            <h4>Two-Factor Auth</h4>
            <p>Optional 2FA adds an extra layer of security to your account</p>
          </div>
          <div class="privacy-security-item">
            <div class="privacy-security-icon">🏢</div>
            <h4>Secure Infrastructure</h4>
            <p>Banking-grade data centers with physical and electronic safeguards</p>
          </div>
        </div>
      </section>

      <section class="privacy-section" id="rights">
        <div class="privacy-section-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
        </div>
        <h2>Your Privacy Rights</h2>
        
        <div class="privacy-rights-accordion">
          <details class="privacy-accordion-item">
            <summary class="privacy-accordion-header">
              <span>Access & Correction</span>
              <svg class="privacy-accordion-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="6 9 12 15 18 9"/>
              </svg>
            </summary>
            <div class="privacy-accordion-content">
              <p>You can view and edit the information in your active 1TXT account at any time by logging in and visiting your profile settings. You have the right to request a copy of all personal data we hold about you.</p>
            </div>
          </details>

          <details class="privacy-accordion-item">
            <summary class="privacy-accordion-header">
              <span>Data Deletion</span>
              <svg class="privacy-accordion-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="6 9 12 15 18 9"/>
              </svg>
            </summary>
            <div class="privacy-accordion-content">
              <p>If you close your account, all of your information will become inaccessible. Your earlier actions may remain on the site but will not be associated with your account. You can request complete deletion of your data by contacting our support team.</p>
            </div>
          </details>

          <details class="privacy-accordion-item">
            <summary class="privacy-accordion-header">
              <span>Data Portability</span>
              <svg class="privacy-accordion-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="6 9 12 15 18 9"/>
              </svg>
            </summary>
            <div class="privacy-accordion-content">
              <p>You have the right to export your data in a machine-readable format. This includes all ratings, responses, and customer feedback collected through your account.</p>
            </div>
          </details>

          <details class="privacy-accordion-item">
            <summary class="privacy-accordion-header">
              <span>Opt-Out Rights</span>
              <svg class="privacy-accordion-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="6 9 12 15 18 9"/>
              </svg>
            </summary>
            <div class="privacy-accordion-content">
              <p>You can opt out of marketing communications at any time by clicking the unsubscribe link in our emails or updating your preferences in your account settings.</p>
            </div>
          </details>
        </div>
      </section>

      <section class="privacy-section" id="updates">
        <div class="privacy-section-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/>
          </svg>
        </div>
        <h2>Policy Updates</h2>
        <p>Any updates to this Privacy Statement will be dated and posted on this page. If material changes are needed, we will inform you through:</p>
        <ul class="privacy-list-styled">
          <li>Email notification to your registered address</li>
          <li>A prominent notice on our website</li>
          <li>In-app notification when you log in</li>
        </ul>
        <p>We will provide at least seven days' notice before any new statement takes effect, giving you time to review the changes.</p>
      </section>

      <section class="privacy-section privacy-section-contact" id="contact">
        <div class="privacy-contact-card">
          <div class="privacy-contact-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
              <polyline points="22,6 12,13 2,6"/>
            </svg>
          </div>
          <h2>Questions About Your Privacy?</h2>
          <p>If you have any questions or concerns regarding our Privacy Policy, our dedicated team is here to help.</p>
          <div class="privacy-contact-details">
            <p><strong>Email:</strong> <a href="mailto:support@1txt.co">support@1txt.co</a></p>
            <p><strong>Response Time:</strong> Within 24 hours</p>
          </div>
          <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/contact.php" class="btn btn-primary">Contact Privacy Team</a>
        </div>
      </section>

      <div class="privacy-footer-note">
        <p><strong>Effective Date:</strong> This Privacy Statement is effective as of February 2026 and applies to all users of the 1TXT platform.</p>
      </div>
    </div>
  </div>
</main>
<?php require __DIR__ . '/../../backend/includes/footer.php'; ?>
