<?php
defined('C5_EXECUTE') or die('Access Denied.');

$pageTitle = $pageTitle ?? $c->getCollectionName() . ' | Infinity Play';
$pageDescription = $pageDescription ?? (string) $c->getCollectionDescription();
$this->inc('elements/header.php');
?>
<main class="policy" id="main-content">
  <section class="policy__section">
    <?= $innerContent ?>
  </section>
</main>
<?php $this->inc('elements/footer.php'); ?>
