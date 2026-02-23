<?php
require_once __DIR__ . '/../../backend/config.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$base_url = get_base_url();
$error = isset($_GET['error']) ? trim($_GET['error']) : '';
$page_title = 'Pricing | 1TXT';
require __DIR__ . '/../../backend/includes/header.php';
?>
<main>
  <section class="page-hero">
    <h1>Attract and convert more customers</h1>
    <p class="subheader">Join the 6,000+ local businesses who use us</p>
  </section>

  <section class="section pricing-section">
    <?php if ($error): ?>
    <p class="pricing-notice pricing-notice-error"><?php echo htmlspecialchars($error); ?> Please try again or contact support.</p>
    <?php endif; ?>
    <p class="text-center" style="margin-bottom: 2rem; text-align: center; max-width: 560px; margin-left: auto; margin-right: auto;">Both payment plans give access to all features. The only difference is auto-renewal duration (Monthly vs Annually).</p>
    <div class="pricing-grid">
      <div class="pricing-card">
        <h3>$2 per month</h3>
        <div class="price">$2<span style="font-size:1rem; font-weight:400;">/month</span></div>
        <p>Billed monthly. Cancel anytime.</p>
        <ul>
          <li>QR code and Rating page</li>
          <li>Edit URL for ratings 7+</li>
          <li>3 editable questions</li>
          <li>Response & positive/negative stats</li>
          <li>Free gift option (text + image)</li>
          <li>Customer email, mobile, name database</li>
          <li>Export data (Excel/CSV)</li>
        </ul>
        <a href="<?php echo htmlspecialchars($base_url); ?>backend/create-checkout.php?plan=monthly" class="btn btn-primary">Buy Now</a>
      </div>
      <div class="pricing-card featured">
        <h3>$20 per year</h3>
        <div class="price">$20<span style="font-size:1rem; font-weight:400;">/year</span></div>
        <p>20% discount over the monthly plan. Billed annually.</p>
        <ul>
          <li>QR code and Rating page</li>
          <li>Edit URL for ratings 7+</li>
          <li>3 editable questions</li>
          <li>Response & positive/negative stats</li>
          <li>Free gift option (text + image)</li>
          <li>Customer email, mobile, name database</li>
          <li>Export data (Excel/CSV)</li>
        </ul>
        <a href="<?php echo htmlspecialchars($base_url); ?>backend/create-checkout.php?plan=yearly" class="btn btn-primary">Buy Now</a>
      </div>
    </div>
  </section>

  <section class="section pricing-faq-section">
    <h2 class="pricing-faq-title">FAQ</h2>
    <div class="pricing-faq-accordion">
      <div class="pricing-faq-item open" data-faq>
        <button type="button" class="pricing-faq-trigger" aria-expanded="true" aria-controls="faq-1" id="faq-trigger-1">
          <span class="pricing-faq-num" aria-hidden="true">1</span>
          <span class="pricing-faq-question">How do I get started?</span>
          <span class="pricing-faq-chevron" aria-hidden="true">^</span>
        </button>
        <div class="pricing-faq-answer" id="faq-1" role="region" aria-labelledby="faq-trigger-1">
          <p>Sign up now by clicking the "Start now" button above and gain instant access. All you need to provide is your name and email address.</p>
        </div>
      </div>
      <div class="pricing-faq-item" data-faq>
        <button type="button" class="pricing-faq-trigger" aria-expanded="false" aria-controls="faq-2" id="faq-trigger-2">
          <span class="pricing-faq-num" aria-hidden="true">2</span>
          <span class="pricing-faq-question">What payment methods are accepted?</span>
          <span class="pricing-faq-chevron" aria-hidden="true">v</span>
        </button>
        <div class="pricing-faq-answer" id="faq-2" role="region" aria-labelledby="faq-trigger-2">
          <p>We currently accept all major debit and credit cards (via Stripe).</p>
        </div>
      </div>
      <div class="pricing-faq-item" data-faq>
        <button type="button" class="pricing-faq-trigger" aria-expanded="false" aria-controls="faq-3" id="faq-trigger-3">
          <span class="pricing-faq-num" aria-hidden="true">3</span>
          <span class="pricing-faq-question">Can I cancel my subscription at any time?</span>
          <span class="pricing-faq-chevron" aria-hidden="true">v</span>
        </button>
        <div class="pricing-faq-answer" id="faq-3" role="region" aria-labelledby="faq-trigger-3">
          <p>Yes. Our team are also available by email to support you or if you have any questions before or after cancelling.</p>
        </div>
      </div>
    </div>
  </section>
</main>
<style>
.pricing-section { text-align: center; }
.pricing-notice { display: block; max-width: 560px; margin-left: auto; margin-right: auto; margin-bottom: 1.5rem; padding: 0.75rem 1rem; border-radius: 8px; font-size: 0.95rem; text-align: center; }
.pricing-notice-info { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }
.pricing-notice-error { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
.pricing-faq-section { max-width: 720px; margin-left: auto; margin-right: auto; }
.pricing-faq-title { text-align: center; font-size: clamp(1.75rem, 4vw, 2.25rem); font-weight: 700; color: #111; margin-bottom: 2rem; }
.pricing-faq-accordion { display: flex; flex-direction: column; gap: 0.75rem; }
.pricing-faq-item { background: #f9fafb; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden; }
.pricing-faq-item.open { background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
.pricing-faq-trigger { display: flex; align-items: center; gap: 1rem; width: 100%; padding: 1rem 1.25rem; text-align: left; background: none; border: none; font: inherit; color: #111; font-weight: 600; cursor: pointer; }
.pricing-faq-trigger:hover { background: rgba(0,0,0,0.02); }
.pricing-faq-num { display: flex; align-items: center; justify-content: center; width: 28px; height: 28px; min-width: 28px; border-radius: 50%; background: var(--color-primary, #6366f1); color: #fff; font-size: 0.9rem; font-weight: 700; }
.pricing-faq-question { flex: 1; }
.pricing-faq-chevron { color: #9ca3af; font-size: 1rem; line-height: 1; transition: transform 0.2s; }
.pricing-faq-item.open .pricing-faq-chevron { transform: rotate(0deg); }
.pricing-faq-item:not(.open) .pricing-faq-chevron { transform: rotate(-180deg); }
.pricing-faq-answer { display: none; padding: 0 1.25rem 1rem; padding-left: calc(1.25rem + 28px + 1rem); }
.pricing-faq-item.open .pricing-faq-answer { display: block; }
.pricing-faq-answer p { margin: 0; font-size: 0.95rem; color: #374151; line-height: 1.6; }
@media (max-width: 640px) { .pricing-faq-answer { padding-left: 1.25rem; } }
</style>
<script>
(function() {
  var items = document.querySelectorAll('.pricing-faq-item[data-faq]');
  items.forEach(function(item) {
    var btn = item.querySelector('.pricing-faq-trigger');
    var chevron = item.querySelector('.pricing-faq-chevron');
    if (!btn || !chevron) return;
    btn.addEventListener('click', function() {
      var isOpen = item.classList.contains('open');
      items.forEach(function(i) { i.classList.remove('open'); i.querySelector('.pricing-faq-trigger').setAttribute('aria-expanded', 'false'); i.querySelector('.pricing-faq-chevron').textContent = 'v'; });
      if (!isOpen) {
        item.classList.add('open');
        btn.setAttribute('aria-expanded', 'true');
        chevron.textContent = '^';
      }
    });
  });
})();
</script>
<?php require __DIR__ . '/../../backend/includes/footer.php'; ?>
