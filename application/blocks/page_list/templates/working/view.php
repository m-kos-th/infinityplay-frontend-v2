<?php
defined('C5_EXECUTE') or die('Access Denied.');

$c = Page::getCurrentPage();

/** @var \Concrete\Core\Utility\Service\Text $th */
$th = Core::make('helper/text');

/**
 * Resolve the background-image URL for a page's "thumbnail" file attribute.
 */
$thumbUrl = static function ($page) {
    $thumbnail = $page->getAttribute('thumbnail');
    return is_object($thumbnail) ? $thumbnail->getURL() : '';
};

if (is_object($c) && $c->isEditMode() && $controller->isBlockEmpty()) {
    ?>
    <div class="ccm-edit-mode-disabled-item"><?php echo t('Empty Page List Block.') ?></div>
    <?php
} elseif (count($pages) == 0) {
    ?>
    <div class="ccm-block-page-list-no-pages"><?php echo h($noResultsMessage) ?></div>
    <?php
} else {

    // First page becomes the featured banner; the rest fill the grid.
    $featured = $pages[0];
    $gridPages = array_slice($pages, 1);

    $featTitle = $featured->getCollectionName();
    $featDesc = $featured->getCollectionDescription();
    $featUrl = $featured->getCollectionPointerExternalLink() != ''
        ? $featured->getCollectionPointerExternalLink()
        : $featured->getCollectionLink();
    $featImg = $thumbUrl($featured);
    ?>

    <!-- Featured project banner — sits OUTSIDE the white catalogue so it
         straddles the blue → white seam, with the hero character behind it. -->
    <div class="work-landing__feature">
        <div class="work-landing__feature-media" style="background-image:url('<?php echo h($featImg); ?>')" role="img" aria-label="<?php echo h($featTitle); ?>"></div>
    </div>

    <div class="work-landing__catalog">
        <div class="work-landing__catalog-inner">

            <!-- Featured meta -->
            <div class="work-landing__feature-meta">
                <h2 class="work-landing__feature-title"><?php echo h($featTitle); ?></h2>
                <p class="work-landing__feature-desc"><?php echo h($featDesc); ?></p>
                <a class="btn work-landing__feature-cta" href="<?php echo h($featUrl); ?>" aria-label="Discover <?php echo h($featTitle); ?>"><svg class="btn__cap btn__cap--left" width="17" height="38" viewBox="0 0 17 38" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M0 9.65686C0 8.59599 0.421427 7.57857 1.17157 6.82843L6.82843 1.17157C7.57857 0.421426 8.59599 0 9.65685 0L17 0V38H9.65685C8.59599 38 7.57857 37.5786 6.82843 36.8284L1.17157 31.1716C0.421426 30.4214 0 29.404 0 28.3431V9.65686Z" fill="#ECEAE5"/></svg><span class="btn__label">Discover</span><svg class="btn__cap btn__cap--right" xmlns="http://www.w3.org/2000/svg" width="17" height="38" viewBox="0 0 17 38" fill="none" aria-hidden="true"><path d="M17 9.65686C17 8.59599 16.5786 7.57857 15.8284 6.82843L10.1716 1.17157C9.42143 0.421426 8.40401 0 7.34315 0L0 0V38H7.34315C8.40401 38 9.42143 37.5786 10.1716 36.8284L15.8284 31.1716C16.5786 30.4214 17 29.404 17 28.3431V9.65686Z" fill="#ECEAE5"/></svg></a>
            </div>

            <div class="work-landing__grid">

                <?php foreach ($gridPages as $page) {
                    $title = $page->getCollectionName();
                    $description = $page->getCollectionDescription();
                    $url = $page->getCollectionPointerExternalLink() != ''
                        ? $page->getCollectionPointerExternalLink()
                        : $page->getCollectionLink();
                    $img = $thumbUrl($page);
                    ?>

                    <a class="work-landing__card" href="<?php echo h($url); ?>">
                        <div class="work-landing__card-media" style="background-image:url('<?php echo h($img); ?>')" role="img" aria-label="<?php echo h($title); ?>"></div>
                        <div class="work-landing__card-info">
                            <h3 class="work-landing__card-title"><?php echo h($title); ?></h3>
                            <p class="work-landing__card-desc"><?php echo h($description); ?></p>
                        </div>
                    </a>

                    <?php
                } ?>

            </div><!-- /.work-landing__grid -->

            <?php
            if ($showPagination) {
                echo $pagination;
            } ?>

        </div><!-- /.work-landing__catalog-inner -->
    </div><!-- /.work-landing__catalog -->

    <?php
}
