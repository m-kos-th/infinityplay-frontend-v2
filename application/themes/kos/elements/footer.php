<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<!-- ════════════════════════════════════════════════════════════════
     FOOTER
═════════════════════════════════════════════════════════════════ -->
<footer class="site-footer" role="contentinfo">

  <div class="footer">
    <div class="footer__bg" aria-hidden="true"></div>

    <div class="footer__head">
      <h2 class="footer__headline">
        Let's Build Something
        <span class="footer__headline-highlight">Legendary</span>
      </h2>
    </div>

    <div class="footer__cols">
      <nav class="footer__col" aria-label="Site pages">
        <?php
        $footer = new GlobalArea('Footer Menu');
        $footer->display();
        ?>
      </nav>
      <nav class="footer__col" aria-label="Social media — coming soon">
        <?php
        $footer = new GlobalArea('Footer Social Media');
        $footer->display();
        ?>
      </nav>
    </div>

    <div class="footer__character" role="img" aria-label="Decorative samurai character"></div>

    <div class="footer__bottom">
      <p class="footer__giant-text">INFINITYPLAY</p>

      <div class="footer__bar">
        <small>© Infinity Play 2026. All rights reserved &nbsp;·&nbsp; Designed by KOS Design</small>
        <nav class="footer__links" aria-label="Legal">
          <a href="/privacy-policy">PRIVACY POLICY</a>
          <a href="/terms">TERMS</a>
        </nav>
      </div>
    </div>
  </div>

</footer>
<?php $this->inc('elements/footer_bottom.php'); ?>
