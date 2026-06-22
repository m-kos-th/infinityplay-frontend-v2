<?php
defined('C5_EXECUTE') or die('Access Denied.');

$page = \Concrete\Core\Page\Page::getCurrentPage();
$link = $page->getCollectionLink();
$pageTitle = t('Search') . ' | Infinity Play';
$pageDescription = t('Search results.');

if (isset($_GET['query'])) {
    $link .= '?query=' . h($_GET['query']);
}

$this->inc('elements/header.php');
?>
<main class="policy" id="main-content">
  <section class="policy__section">
    <?php if (isset($error)) { ?>
      <p><?= $error ?></p>
    <?php } ?>
    <?php
    if (!isset($query) || !is_string($query)) {
        $query = '';
    }

    if (isset($do_search) && $do_search) {
        ?>
        <h1 class="policy__section-title"><?= t('Search Results for:') ?> "<?= h($query) ?>"</h1>
        <?php
        if (count($results) === 0) {
            ?>
            <p><?= t('There were no results found. Please try another keyword or phrase.') ?></p>
            <?php
        } else {
            $textHelper = Core::make('helper/text');
            foreach ($results as $result) {
                $currentPageBody = $this->controller->highlightedExtendedMarkup($result->getPageIndexContent(), $query);
                ?>
                <section class="policy__section">
                  <h2 class="policy__section-title"><a href="<?= $result->getCollectionLink() ?>"><?= h($result->getCollectionName()) ?></a></h2>
                  <p>
                    <?php
                    if ($result->getCollectionDescription()) {
                        echo $this->controller->highlightedMarkup($textHelper->shortText($result->getCollectionDescription()), $query);
                    }
                    echo $currentPageBody;
                    ?>
                  </p>
                </section>
                <?php
            }
        }
    }
    ?>
  </section>
</main>
<?php $this->inc('elements/footer.php'); ?>
