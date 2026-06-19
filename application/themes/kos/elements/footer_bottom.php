<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
</div>

<script>
  window.INFINITY_PLAY = Object.assign({}, window.INFINITY_PLAY, {
    apiContactUrl: <?= json_encode((string) \URL::to('/api/contact')) ?>
  });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" defer></script>
<?php $globalJsPublicPath = THEMEDIR . '/assets/js/global.js'; ?>
<?php $globalJs = kos_public_path_to_filesystem($globalJsPublicPath); ?>
<?php if (file_exists($globalJs)) { ?>
  <script src="<?= h(kos_asset_url($globalJsPublicPath)) ?>" defer></script>
<?php } ?>
<?php $pageJsPublicPath = THEMEDIR . '/assets/js/' . PAGETEMPLATE . '.js'; ?>
<?php $pageJs = kos_public_path_to_filesystem($pageJsPublicPath); ?>
<?php if (PAGETEMPLATE && file_exists($pageJs)) { ?>
  <script src="<?= h(kos_asset_url($pageJsPublicPath)) ?>" defer></script>
<?php } ?>
<?php \Loader::element('footer_required'); ?>
</body>
</html>
