<?php defined("C5_EXECUTE") or die("Access Denied."); ?>
<header class="services__head">
    <?php if (isset($title) && trim($title) != "") { ?>
    <span class="pill"><?php echo h($title); ?></span>
    <?php } ?>
    <?php if (isset($mainTitle) && trim($mainTitle) != "") { ?>
        <h3 class="services__head-title">
            <?php echo $mainTitle; ?>
        </h3>
    <?php } ?>
</header>