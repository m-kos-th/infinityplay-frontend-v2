<?php defined("C5_EXECUTE") or die("Access Denied."); ?>
<?php if (!empty($servicesList_items)) { ?>
<div class="services__deck">
    <nav class="services__nav" aria-label="Services navigation">
        <span class="services__nav-marker" aria-hidden="true"></span>
        <div class="services__nav-track">
            <?php foreach ($servicesList_items as $servicesList_item_key => $servicesList_item) {
                $title = isset($servicesList_item["title"]) && trim($servicesList_item["title"]) !== "" ? h($servicesList_item["title"]) : t('Service');
                $activeClass = $servicesList_item_key === 0 ? ' services__nav-link--active active' : '';
            ?>
                <a href="#" class="services__nav-link<?php echo $activeClass; ?>" data-slide="<?php echo $servicesList_item_key; ?>"><?php echo $title; ?></a>
            <?php } ?>
        </div>
    </nav>

    <figure class="services__stage" aria-hidden="true">
        <div class="services__frame">
            <?php foreach ($servicesList_items as $servicesList_item_key => $servicesList_item) {
                $hasVideo = isset($servicesList_item["videoPreview"]) && $servicesList_item["videoPreview"] !== false;
                $hasImage = isset($servicesList_item["imagePreview"]) && $servicesList_item["imagePreview"] !== false;
                if ($hasVideo) {
                    $poster = $hasImage ? h($servicesList_item["imagePreview"]->getURL()) : '';
                    $posterAttr = $poster !== '' ? ' poster="' . $poster . '"' : '';
                    $videoSrc = h($servicesList_item["videoPreview"]->urls["relative"]);
            ?>
                <video class="services__img services__img--video" data-img="<?php echo $servicesList_item_key; ?>" autoplay loop muted playsinline<?php echo $posterAttr; ?>>
                    <source src="<?php echo $videoSrc; ?>" />
                </video>
            <?php } elseif ($hasImage) {
                $imageUrl = h($servicesList_item["imagePreview"]->getURL());
            ?>
                <div class="services__img" data-img="<?php echo $servicesList_item_key; ?>" style="background-image:url('<?php echo $imageUrl; ?>')"></div>
            <?php } ?>
            <?php } ?>
        </div>
    </figure>

    <div class="services__texts">
        <?php foreach ($servicesList_items as $servicesList_item_key => $servicesList_item) {
            $title = isset($servicesList_item["title"]) && trim($servicesList_item["title"]) !== "" ? h($servicesList_item["title"]) : t('Service');
            $content = isset($servicesList_item["content"]) && trim($servicesList_item["content"]) !== "" ? ($servicesList_item["content"]) : '';
            $supportBy = isset($servicesList_item["supportBy"]) && trim($servicesList_item["supportBy"]) !== "" ? $servicesList_item["supportBy"] : null;
        ?>
            <article class="services__text" data-text="<?php echo $servicesList_item_key; ?>">
                <div class="services__desc"><?php echo nl2br($content); ?></div>
                <?php if ($supportBy) { ?>
                    <div class="services__supported"><?php echo $supportBy; ?></div>
                <?php } ?>
            </article>
        <?php } ?>
    </div>
</div>
<?php } ?>