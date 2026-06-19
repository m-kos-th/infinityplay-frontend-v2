<?php
defined('C5_EXECUTE') or die('Access Denied.');

$pageTitle = t('404 Error') . ' | Infinity Play';
$pageDescription = t('Page not found.');
$this->inc('elements/header.php');
?>
<main class="policy" id="main-content">
  <section class="policy__section">
    <h1 class="policy__section-title"><?= t('404 Error') ?></h1>
    <p><?= t('Page not found.') ?></p>
  </section>
</main>
<?php $this->inc('elements/footer.php'); ?>
