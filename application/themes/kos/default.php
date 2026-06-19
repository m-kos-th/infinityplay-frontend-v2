<?php
defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Core\Area\Area;

$pageTitle = $pageTitle ?? $c->getCollectionName() . ' | Infinity Play';
$pageDescription = $pageDescription ?? (string) $c->getCollectionDescription();
$this->inc('elements/header.php');
?>
<main class="policy" id="main-content">
  <section class="policy__section">
    <h1 class="policy__section-title"><?= h($c->getCollectionName()) ?></h1>
    <?php
    $area = new Area('Main');
    $area->display($c);
    ?>
  </section>
</main>
<?php $this->inc('elements/footer.php'); ?>
