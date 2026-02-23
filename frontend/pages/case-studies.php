<?php
require_once __DIR__ . '/../../backend/config.php';
$base_url = get_base_url();
$page_title = 'Case Studies | 1TXT';
require __DIR__ . '/../../backend/includes/header.php';

$img = $base_url . 'images/case/';
$sections = [
  [
    'title' => 'Apex Taxi Services',
    'quote' => 'Before using 1txt, we struggled with negative reviews, and now we are top in our market.',
    'source' => 'Apex Taxi Services',
    'images' => ['1.png', '2.png', '3.png', '4.png', '5.png', '6.png'],
  ],
  [
    'title' => 'San Thome Health Clinic and Medical, Cebu City',
    'quote' => 'With 1txt we easily collect reviews across websites. Plus, our own website looks professional, so when someone engages with our website I can connect with them right away.',
    'source' => 'San Thome Health Clinic and Medical, Cebu City',
    'images' => ['7.png', '8.png', '9.png', '10.png', '11.png', '12.png'],
  ],
  [
    'title' => 'Whispering Palms Beach Resort',
    'quote' => 'Our TripAdvisor reviews increased from 151 before we signed up with 1txt to 239 reviews in just two months.',
    'source' => 'Whispering Palms Beach Resort',
    'images' => ['13.png', '14.png', '15.png', '111.png', '222.png', '333.png'],
  ],
  [
    'title' => 'How 1txt helped Telemate Improve local rankings',
    'body' => 'Telemate utilised 1txt\'s audit feature to evaluate the strength of their reviews and ratings and improve their ranking by efficiently executing the tasks recommended by 1txt.',
    'points' => [
      'Optimise their listing: Telemate used 1txt to oversee their Google Business Profile, guaranteeing consistent interaction with their audience and updating all crucial information to maintain a complete and relevant profile.',
      'Review campaigns: Telemate started using 1txt campaigns to gather customer feedback and increase the amount of positive Customer ratings.',
    ],
    'images' => ['444.png', '555.png', '666.png', '777.png', '888.png', '999.png'],
  ],
];
$contact_url = $base_url . 'frontend/pages/contact.php';
?>
<main class="page-case-studies page-case-process">
  <section class="case-process-hero">
    <h1 class="case-process-hero-title">Thousands of small businesses trust 1TXT</h1>
    <p class="case-process-hero-sub">Real results from real businesses</p>
  </section>

  <div class="case-process-wrap">
    <aside class="case-process-sidebar">
      <div class="case-process-request">
        <h3 class="case-process-request-title">Request Information</h3>
        <p class="case-process-request-text">Get in touch to see how 1TXT can help your business.</p>
        <a href="<?php echo htmlspecialchars($contact_url); ?>" class="btn btn-primary case-process-request-btn">Contact us</a>
      </div>
    </aside>

    <div class="case-process-main">
      <section class="case-process-intro">
        <h2 class="case-process-intro-title">Our Case Studies</h2>
        <p class="case-process-intro-lead">What does success with 1TXT look like? At 1TXT, it's a combination of:</p>
        <ul class="case-process-list">
          <li class="case-process-list-item"><span class="case-process-icon" aria-hidden="true"></span> Businesses turning negative reviews into top market positions.</li>
          <li class="case-process-list-item"><span class="case-process-icon" aria-hidden="true"></span> Collecting reviews across websites with a professional, connected presence.</li>
          <li class="case-process-list-item"><span class="case-process-icon" aria-hidden="true"></span> Rapid growth in ratings and visibility—like 151 to 239 reviews in two months.</li>
        </ul>
        <p class="case-process-intro-end">Below, see how real businesses use 1TXT to improve their ratings and reach.</p>
      </section>

      <?php foreach ($sections as $i => $sec): ?>
        <section class="case-process-section" id="section-<?php echo $i + 1; ?>">
          <h3 class="case-process-section-title">
            <span class="case-process-section-num" aria-hidden="true"><?php echo $i + 1; ?></span>
            <?php echo htmlspecialchars($sec['title']); ?>
          </h3>
          <?php if (!empty($sec['quote'])): ?>
            <blockquote class="case-process-quote">"<?php echo htmlspecialchars($sec['quote']); ?>"</blockquote>
            <cite class="case-process-source">— <?php echo htmlspecialchars($sec['source']); ?></cite>
          <?php else: ?>
            <p class="case-process-body"><?php echo htmlspecialchars($sec['body']); ?></p>
            <ul class="case-process-points">
              <?php foreach ($sec['points'] as $point): ?>
                <li><span class="case-process-icon" aria-hidden="true"></span><?php echo htmlspecialchars($point); ?></li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
          <div class="case-process-grid">
            <?php foreach ($sec['images'] as $name): ?>
              <div class="case-process-grid-item">
                <img src="<?php echo htmlspecialchars($img . $name); ?>" alt="" loading="lazy" class="case-process-img">
              </div>
            <?php endforeach; ?>
          </div>
        </section>
      <?php endforeach; ?>

      <section class="case-process-cta">
        <h2 class="case-process-cta-title">Contact Us</h2>
        <p class="case-process-cta-text">Ready to improve your ratings and grow your business? Contact 1TXT today to see how we can help you succeed.</p>
        <a href="<?php echo htmlspecialchars($contact_url); ?>" class="btn btn-primary case-process-cta-btn">Get in touch</a>
      </section>
    </div>
  </div>
</main>
<?php require __DIR__ . '/../../backend/includes/footer.php'; ?>
