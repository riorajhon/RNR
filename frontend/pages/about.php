<?php
require_once __DIR__ . '/../../backend/config.php';
$base_url = get_base_url();
$page_title = 'About Us | 1TXT';
require __DIR__ . '/../../backend/includes/header.php';
?>
<main class="page-about-modern">
  <section class="about-hero">
    <div class="about-hero-content">
      <span class="about-hero-badge">Est. 2024</span>
      <h1 class="about-hero-title">Helping Small Businesses Thrive</h1>
      <p class="about-hero-subtitle">We're on a mission to help small businesses improve through customer feedback, turning insights into growth and negative experiences into opportunities.</p>
    </div>
  </section>

  <section class="about-story">
    <div class="about-story-grid">
      <div class="about-story-text">
        <span class="about-section-label">Our Story</span>
        <h2>Built for Small Business Success</h2>
        <p>Innovation and passion are at the heart of everything we do. We understand the challenges small businesses face when managing their online reputation.</p>
        <p>That's why we created 1TXT—a simple, powerful platform that helps you collect customer feedback before it becomes a public review. Our QR-based rating system gives you the insights you need to improve while protecting your online reputation.</p>
        <p>We believe every business deserves the tools to succeed, which is why we've made our platform affordable, easy to use, and incredibly effective.</p>
      </div>
      <div class="about-story-stats">
        <div class="about-stat-card">
          <div class="about-stat-number">6,000+</div>
          <div class="about-stat-label">Businesses Trust Us</div>
        </div>
        <div class="about-stat-card">
          <div class="about-stat-number">500K+</div>
          <div class="about-stat-label">Customer Ratings Collected</div>
        </div>
        <div class="about-stat-card">
          <div class="about-stat-number">4.8★</div>
          <div class="about-stat-label">Average Rating Improvement</div>
        </div>
        <div class="about-stat-card">
          <div class="about-stat-number">24/7</div>
          <div class="about-stat-label">Customer Support</div>
        </div>
      </div>
    </div>
  </section>

  <section class="about-mission">
    <div class="about-mission-content">
      <span class="about-section-label">Our Mission</span>
      <h2>Empowering Businesses Through Feedback</h2>
      <p class="about-mission-lead">To help small businesses become better by asking their customers what specific things they can improve.</p>
      
      <div class="about-mission-grid">
        <div class="about-mission-card">
          <div class="about-mission-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M12 2L2 7l10 5 10-5-10-5z"/>
              <path d="M2 17l10 5 10-5M2 12l10 5 10-5"/>
            </svg>
          </div>
          <h3>Prevent Negative Reviews</h3>
          <p>Let unhappy customers speak to you privately before they post publicly, giving you a chance to make things right.</p>
        </div>
        
        <div class="about-mission-card">
          <div class="about-mission-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
            </svg>
          </div>
          <h3>Boost Positive Ratings</h3>
          <p>Direct happy customers straight to your public review platforms, increasing your visibility and credibility.</p>
        </div>
        
        <div class="about-mission-card">
          <div class="about-mission-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
            </svg>
          </div>
          <h3>Actionable Insights</h3>
          <p>Get specific feedback on what to improve, helping you make data-driven decisions to enhance your business.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="about-values">
    <span class="about-section-label">Our Values</span>
    <h2>What Drives Us</h2>
    <div class="about-values-grid">
      <div class="about-value-item">
        <div class="about-value-icon">🎯</div>
        <h3>Customer-First</h3>
        <p>Every feature we build starts with understanding what small businesses need to succeed.</p>
      </div>
      <div class="about-value-item">
        <div class="about-value-icon">🔒</div>
        <h3>Privacy & Security</h3>
        <p>We're GDPR and CCPA compliant, ensuring your data and your customers' data is always protected.</p>
      </div>
      <div class="about-value-item">
        <div class="about-value-icon">⚡</div>
        <h3>Simplicity</h3>
        <p>Powerful tools shouldn't be complicated. We make reputation management simple and accessible.</p>
      </div>
      <div class="about-value-item">
        <div class="about-value-icon">💡</div>
        <h3>Innovation</h3>
        <p>We continuously improve our platform with AI-powered features and smart automation.</p>
      </div>
      <div class="about-value-item">
        <div class="about-value-icon">🤝</div>
        <h3>Transparency</h3>
        <p>Clear pricing, honest communication, and no hidden fees. What you see is what you get.</p>
      </div>
      <div class="about-value-item">
        <div class="about-value-icon">🌱</div>
        <h3>Growth-Focused</h3>
        <p>Your success is our success. We're invested in helping your business grow and thrive.</p>
      </div>
    </div>
  </section>

  <section class="about-team">
    <div class="about-team-content">
      <span class="about-section-label">Our Team</span>
      <h2>Meet the People Behind 1TXT</h2>
      <p class="about-team-intro">We're a diverse, passionate team of developers, designers, and customer success specialists dedicated to helping small businesses succeed.</p>
      
      <div class="about-team-grid">
        <div class="about-team-member">
          <div class="about-team-avatar">
            <img src="<?php echo htmlspecialchars($base_url); ?>images/avatars/sarah.jpg" alt="Sarah Mitchell" width="120" height="120">
          </div>
          <h3>Sarah Mitchell</h3>
          <p class="about-team-role">Co-Founder & CEO</p>
          <p class="about-team-bio">Former small business owner who experienced the pain of managing online reviews firsthand.</p>
        </div>
        
        <div class="about-team-member">
          <div class="about-team-avatar">
            <img src="<?php echo htmlspecialchars($base_url); ?>images/avatars/james.jpg" alt="James Chen" width="120" height="120">
          </div>
          <h3>James Chen</h3>
          <p class="about-team-role">Co-Founder & CTO</p>
          <p class="about-team-bio">Tech entrepreneur with 15+ years building scalable SaaS platforms.</p>
        </div>
        
        <div class="about-team-member">
          <div class="about-team-avatar">
            <img src="<?php echo htmlspecialchars($base_url); ?>images/avatars/lisa.jpg" alt="Lisa Thompson" width="120" height="120">
          </div>
          <h3>Lisa Thompson</h3>
          <p class="about-team-role">Head of Customer Success</p>
          <p class="about-team-bio">Passionate about helping businesses maximize their potential with our platform.</p>
        </div>
        
        <div class="about-team-member">
          <div class="about-team-avatar">
            <img src="<?php echo htmlspecialchars($base_url); ?>images/avatars/dom.jpg" alt="Dominic Rodriguez" width="120" height="120">
          </div>
          <h3>Dominic Rodriguez</h3>
          <p class="about-team-role">Lead Product Designer</p>
          <p class="about-team-bio">Creating intuitive experiences that make reputation management effortless.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="about-locations">
    <div class="about-locations-content">
      <span class="about-section-label">Global Presence</span>
      <h2>Where We Are</h2>
      <p>We're proud to serve small businesses around the world with local support teams in key regions.</p>
      
      <div class="about-locations-grid">
        <div class="about-location-card">
          <div class="about-location-icon">🇺🇸</div>
          <h3>United States</h3>
          <p>San Francisco, CA</p>
          <p class="about-location-detail">Headquarters</p>
        </div>
        <div class="about-location-card">
          <div class="about-location-icon">🇸🇬</div>
          <h3>Singapore</h3>
          <p>Marina Bay</p>
          <p class="about-location-detail">Asia-Pacific Hub</p>
        </div>
        <div class="about-location-card">
          <div class="about-location-icon">🇳🇿</div>
          <h3>New Zealand</h3>
          <p>Auckland</p>
          <p class="about-location-detail">Support Center</p>
        </div>
        <div class="about-location-card">
          <div class="about-location-icon">🇮🇳</div>
          <h3>India</h3>
          <p>Bangalore</p>
          <p class="about-location-detail">Development Center</p>
        </div>
      </div>
    </div>
  </section>

  <section class="about-cta">
    <div class="about-cta-content">
      <h2>Ready to Improve Your Business?</h2>
      <p>Join thousands of small businesses using 1TXT to boost their ratings and grow their customer base.</p>
      <div class="about-cta-buttons">
        <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/register.php" class="btn btn-primary btn-lg">Get Started Free</a>
        <a href="<?php echo htmlspecialchars($base_url); ?>frontend/pages/contact.php" class="btn btn-outline btn-lg">Contact Us</a>
      </div>
    </div>
  </section>

  <section class="about-contact-info">
    <div class="about-contact-grid">
      <div class="about-contact-card">
        <svg class="about-contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
          <polyline points="22,6 12,13 2,6"/>
        </svg>
        <h3>Email Us</h3>
        <p><a href="mailto:support@1txt.co">support@1txt.co</a></p>
        <p class="about-contact-note">We respond within 24 hours</p>
      </div>
      
      <div class="about-contact-card">
        <svg class="about-contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/>
        </svg>
        <h3>Call Us</h3>
        <p><a href="tel:+1234567890">+1 (234) 567-890</a></p>
        <p class="about-contact-note">Mon-Fri, 9 AM - 6 PM EST</p>
      </div>
      
      <div class="about-contact-card">
        <svg class="about-contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
        </svg>
        <h3>Live Chat</h3>
        <p>Available on our website</p>
        <p class="about-contact-note">Instant support from our team</p>
      </div>
    </div>
  </section>
</main>
<?php require __DIR__ . '/../../backend/includes/footer.php'; ?>
