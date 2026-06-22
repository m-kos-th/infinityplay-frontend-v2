<?php
defined('C5_EXECUTE') or die('Access Denied.');
$this->inc('elements/header.php');
?>

<main id="main-content">
  <section class="contact" aria-labelledby="contact-title">
    <div class="contact__media" aria-hidden="true">
      <video class="contact__video" autoplay muted loop playsinline preload="metadata">
        <source src="video/shadow.mp4" type="video/mp4">
      </video>
    </div>

    <div class="contact__inner">
      <?php
      $contactInfoArea = new Area('Contact Info');
      $contactInfoArea->display($c);
      ?>

      <div class="contact__form">
        <?php
        $contactFormArea = new Area('Contact Form');
        $contactFormArea->display($c);
        ?>
      </div>
    </div>
  </section>
</main>

<?php $this->inc('elements/footer.php'); ?>
