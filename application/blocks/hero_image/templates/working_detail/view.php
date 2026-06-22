<?php

defined('C5_EXECUTE') or die('Access Denied.');

/**
 * @var Concrete\Core\Block\View\BlockView $this
 * @var Concrete\Core\Block\View\BlockView $view
 * @var Concrete\Core\Area\Area $a
 * @var Concrete\Core\Block\Block $b
 * @var Concrete\Core\Entity\Block\BlockType\BlockType $bt
 * @var Concrete\Block\HeroImage\Controller $controller
 * @var Concrete\Core\Form\Service\Form $form
 * @var int $bID
 *
 * @var string|null $title
 * @var string|null $body
 * @var string|null $buttonText
 * @var string|null $buttonExternalLink
 * @var int|null $buttonInternalLinkCID
 * @var int|null $buttonFileLinkID
 * @var string|null $height
 * @var string|null $buttonStyle
 * @var string|null $buttonColor
 * @var string|null $buttonSize
 *
 * @var Concrete\Core\Entity\File\File|null $image
 * @var HtmlObject\Link|null $button
 */

if ($image === null) {
    return;
}

$height = (int) $height;

/**
 * Back-button icon — a Font Awesome class string (font-awesome asset is
 * required by the theme). Override $icon to swap, e.g. 'fas fa-arrow-left'.
 * The blue chamfered button itself is drawn in SCSS; this only supplies
 * the glyph (colour/size come from CSS).
 */
$icon = $icon ?? 'fas fa-arrow-circle-up';

/**
 * Building the button — append the globe icon after the label.
 */
$globeIcon = '<svg class="ccm-block-hero-image-btn-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">'
    . '<path d="M7.99967 14.6673C4.31767 14.6673 1.33301 11.6827 1.33301 8.00065C1.33301 4.31865 4.31767 1.33398 7.99967 1.33398C11.6817 1.33398 14.6663 4.31865 14.6663 8.00065C14.6663 11.6827 11.6817 14.6673 7.99967 14.6673ZM6.47301 13.112C5.81528 11.7169 5.43426 10.2075 5.35101 8.66732H2.70767C2.8374 9.69325 3.26229 10.6594 3.93072 11.4485C4.59915 12.2375 5.48235 12.8154 6.47301 13.112ZM6.68634 8.66732C6.78701 10.2933 7.25167 11.8207 7.99967 13.1687C8.76789 11.785 9.21664 10.247 9.31301 8.66732H6.68634ZM13.2917 8.66732H10.6483C10.5651 10.2075 10.1841 11.7169 9.52634 13.112C10.517 12.8154 11.4002 12.2375 12.0686 11.4485C12.7371 10.6594 13.162 9.69325 13.2917 8.66732ZM2.70767 7.33398H5.35101C5.43426 5.79384 5.81528 4.28444 6.47301 2.88932C5.48235 3.1859 4.59915 3.76382 3.93072 4.55285C3.26229 5.34188 2.8374 6.30805 2.70767 7.33398ZM6.68701 7.33398H9.31234C9.21618 5.75438 8.76765 4.21634 7.99967 2.83265C7.23146 4.21628 6.78271 5.75433 6.68634 7.33398H6.68701ZM9.52634 2.88932C10.1841 4.28444 10.5651 5.79384 10.6483 7.33398H13.2917C13.162 6.30805 12.7371 5.34188 12.0686 4.55285C11.4002 3.76382 10.517 3.1859 9.52634 2.88932Z" fill="currentColor"/>'
    . '</svg>';

if (isset($button)) {
    $button->addClass('btn ccm-block-hero-image-btn');
    if ($buttonSize) {
        $button->addClass('btn-' . $buttonSize);
    }
    // Label on the left, globe icon on the right (matching the design).
    $button->setValue('<span class="ccm-block-hero-image-btn-label">' . $button->getValue() . '</span>' . $globeIcon);
}

?>
<div data-transparency="element" class="ccm-block-hero-image ccm-block-hero-image--working-detail" <?php if ($height) { ?>style="min-height: <?=$height?>vh"<?php } ?>>
    <div class="ccm-block-hero-image-cover" <?php if ($height) { ?>style="min-height: <?=$height?>vh"<?php } ?>></div>
    <div style="background-image: url(<?= h("\"{$image->getURL()}\"") ?>); <?php if ($height) { ?>min-height: <?=$height?>vh<?php } ?>" class="ccm-block-hero-image-image"></div>

    <div class="ccm-block-hero-image-overlay">
        <!-- Bottom-left: back button + title -->
        <div class="ccm-block-hero-image-lead">
            <a class="ccm-block-hero-image-back" href="/working" aria-label="<?= t('Back') ?>"><i class="<?= h($icon) ?>" aria-hidden="true"></i></a>
            <?php if ($title) { ?>
                <<?=$titleFormat?> class="ccm-block-hero-image-title"><?=$title?></<?=$titleFormat?>>
            <?php } ?>
        </div>

        <!-- Bottom-right: visit-site button -->
        <?php if (isset($button)) { ?>
            <div class="ccm-block-hero-image-action"><?= $button ?></div>
        <?php } ?>
    </div>

    <?php if ((string) $body !== '') { ?>
        <div class="ccm-block-hero-image-body"><?= $body ?></div>
    <?php } ?>
</div>
