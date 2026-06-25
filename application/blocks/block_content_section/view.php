<?php defined("C5_EXECUTE") or die("Access Denied."); ?>
<div class="block-section-content__content">
    <?php if (isset($title) && trim($title) != "") { ?>
        <div class="btn__badge-wrap">
            <span class="btn__badge">
                <span class="btn__badge-text"><?php echo h($title); ?></span>
            </span>
            <span class="btn__sparkles" aria-hidden="true"></span>
        </div>
    <?php } ?>
    <?php if (isset($mainTitle) && trim($mainTitle) != "") { ?>
        <div class="block-section-content__title">
            <?php echo $mainTitle; ?>
        </div>
    <?php } ?>
    <?php if (isset($description_1) && trim($description_1) != "") { ?>
        <div class="block-section-content__description">
            <?php echo $description_1; ?>
        </div>
    <?php } ?>
</div>