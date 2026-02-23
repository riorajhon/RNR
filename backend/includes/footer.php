  <a href="#" class="back-to-top" id="back-to-top" aria-label="Back to top">↑</a>
  <footer class="site-footer">
    <div class="footer-inner">
      <div class="footer-col">
        <h4 class="footer-logo-text">RNR</h4>
        <p>Help small businesses get better by asking customers what to improve. QR-based ratings and reviews.</p>
      </div>
      <div class="footer-col">
        <h4>Articles</h4>
        <ul>
          <li><a href="<?php echo htmlspecialchars($base_url ?? '/'); ?>frontend/pages/articles.php#article-1">How To Respond to Customer Reviews</a></li>
          <li><a href="<?php echo htmlspecialchars($base_url ?? '/'); ?>frontend/pages/articles.php#article-2">6 Benefits of Customer ratings</a></li>
          <li><a href="<?php echo htmlspecialchars($base_url ?? '/'); ?>frontend/pages/articles.php#article-3">How To improve your customer ratings: 9 Tips &amp; Best Practices</a></li>
          <li><a href="<?php echo htmlspecialchars($base_url ?? '/'); ?>frontend/pages/articles.php#article-4">How To improve your customer ratings: 9 MORE Tips &amp; Best Practices</a></li>
          <li><a href="<?php echo htmlspecialchars($base_url ?? '/'); ?>frontend/pages/articles.php#article-5">How To improve your customer ratings: YET 9 MORE Tips &amp; Best Practices</a></li>
          <li><a href="<?php echo htmlspecialchars($base_url ?? '/'); ?>frontend/pages/articles.php#article-6">How to ask for customer ratings</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Contact</h4>
        <p>support@1txt.co</p>
        <p>+1 (234) 567-890</p>
        <p><a href="<?php echo htmlspecialchars($base_url ?? '/'); ?>frontend/pages/contact.php">Get in Touch</a></p>
      </div>
      <div class="footer-col">
        <h4>Legal</h4>
        <ul>
          <li><a href="<?php echo htmlspecialchars($base_url ?? '/'); ?>frontend/pages/privacy.php">Privacy Policy</a></li>
          <li><a href="<?php echo htmlspecialchars($base_url ?? '/'); ?>frontend/pages/about.php">About Us</a></li>
          <li><a href="<?php echo htmlspecialchars($base_url ?? '/'); ?>frontend/pages/terms.php">Terms</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      Copyright © <?php echo date('Y'); ?> RNR. All rights reserved.
    </div>
  </footer>
  <script>
    document.querySelector('.menu-toggle')?.addEventListener('click', function() {
      document.querySelector('.site-nav').classList.toggle('open');
    });
    document.querySelector('.nav-dropdown-trigger')?.addEventListener('click', function() {
      document.querySelector('.nav-dropdown').classList.toggle('open');
    });
    (function() {
      var btn = document.getElementById('back-to-top');
      if (!btn) return;
      function toggle() {
        btn.classList.toggle('visible', window.pageYOffset > 300);
      }
      window.addEventListener('scroll', toggle);
      toggle();
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
      });
    })();
  </script>
</body>
</html>
