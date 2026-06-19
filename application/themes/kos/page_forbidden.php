<?php
defined('C5_EXECUTE') or die('Access Denied.');
$this->inc('elements/header.php');
?>
<main class="policy" id="main-content">
  <section class="policy__section">
    <h1 class="policy__section-title"><?= t('403 Error') ?></h1>
    <p><?= t('You are not allowed to access this page.') ?></p>
  </section>
</main>
<?php $this->inc('elements/footer.php'); ?>
