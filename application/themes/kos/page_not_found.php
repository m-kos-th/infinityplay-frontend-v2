<?php
defined('C5_EXECUTE') or die('Access Denied.');
$this->inc('elements/header.php');
?>
<main class="error-page" id="main-content" aria-labelledby="error-page-title">
  <div class="error-page__media" aria-hidden="true">
    <video class="error-page__video" autoplay muted loop playsinline preload="metadata">
      <source src="/application/themes/kos/assets/video/shadow.mp4" type="video/mp4">
    </video>
  </div>
  <div class="error-page__content">
    <h1 class="error-page__title" id="error-page-title"><?= t('404') ?></h1>
    <p class="error-page__text"><?= t('This page may have moved, been removed, or is still loading in another dimension.') ?></p>
    <a class="btn error-page__cta" href="/">
      <svg class="btn__cap btn__cap--left" width="17" height="38" viewBox="0 0 17 38" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
        <path d="M0 9.65686C0 8.59599 0.421427 7.57857 1.17157 6.82843L6.82843 1.17157C7.57857 0.421426 8.59599 0 9.65685 0L17 0V38H9.65685C8.59599 38 7.57857 37.5786 6.82843 36.8284L1.17157 31.1716C0.421426 30.4214 0 29.404 0 28.3431V9.65686Z" fill="#ECEAE5" />
      </svg>
      <span class="btn__label"><?= t('Back to homepage') ?></span>
      <svg class="btn__cap btn__cap--right" width="17" height="38" viewBox="0 0 17 38" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
        <path d="M17 9.65686C17 8.59599 16.5786 7.57857 15.8284 6.82843L10.1716 1.17157C9.42143 0.421426 8.40401 0 7.34315 0L0 0V38H7.34315C8.40401 38 9.42143 37.5786 10.1716 36.8284L15.8284 31.1716C16.5786 30.4214 17 29.404 17 28.3431V9.65686Z" fill="#ECEAE5" />
      </svg>
    </a>
  </div>
</main>
<?php $this->inc('elements/footer_bottom.php'); ?>
