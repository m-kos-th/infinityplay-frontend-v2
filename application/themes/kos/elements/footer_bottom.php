<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" defer></script>
<script src="<?php echo THEMEDIR; ?>/assets/libs/lenis/lenis.min.js?v=<?php echo time(); ?>"></script>
<script src="<?php echo THEMEDIR; ?>/assets/js/global.js?v=<?php echo time(); ?>"></script>

<?php $pagejs = $_SERVER['DOCUMENT_ROOT'] . THEMEDIR . '/assets/js/' . PAGETEMPLATE . '.js'; ?>
<?php if (file_exists($pagejs)) : ?>
	<script src="<?php echo THEMEDIR; ?>/assets/js/<?php echo PAGETEMPLATE; ?>.js?v=<?php echo time(); ?>"></script>
<?php endif; ?>

<?php Loader::element('footer_required'); ?>
</body>

</html>
