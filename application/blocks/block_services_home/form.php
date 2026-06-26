<?php defined("C5_EXECUTE") or die("Access Denied."); ?>

<script type="text/javascript">
    var CCM_EDITOR_SECURITY_TOKEN = "<?php echo Core::make('helper/validation/token')->generate('editor')?>";
</script>
            <?php
	$core_editor = Core::make('editor');
	if (method_exists($core_editor, 'outputStandardEditorInitJSFunction')) {
		/* @var $core_editor \Concrete\Core\Editor\CkeditorEditor */
		?>
		<script type="text/javascript">var blockDesignerEditor = <?php echo $core_editor->outputStandardEditorInitJSFunction(); ?>;</script>
	<?php
	} else {
	/* @var $core_editor \Concrete\Core\Editor\RedactorEditor */
	if(method_exists($core_editor, 'requireEditorAssets')){
		$core_editor->requireEditorAssets();
	} ?>
		<script type="text/javascript">
			var blockDesignerEditor = function (identifier) {$(identifier).redactor(<?php echo json_encode(array('plugins' => ['concrete5magic'] + $core_editor->getPluginManager()->getSelectedPlugins(), 'minHeight' => 300,'concrete5' => array('filemanager' => $core_editor->allowFileManager(), 'sitemap' => $core_editor->allowSitemap()))); ?>).on('remove', function () {$(this).redactor('core.destroy');});};
		</script>
		<?php
	} ?><?php $repeatable_container_id = 'btBlockServicesHome-servicesList-container-' . $identifier_getString; ?>
    <div id="<?php echo $repeatable_container_id; ?>">
        <div class="sortable-items-wrapper">
            <a href="#" class="btn btn-primary add-entry">
                <?php echo t('Add Entry'); ?>
            </a>

            <div class="sortable-items" data-attr-content="<?php echo htmlspecialchars(
                json_encode(
                    [
                        'items' => $servicesList_items,
                        'order' => array_keys($servicesList_items),
                    ]
                )
            ); ?>">
            </div>

            <a href="#" class="btn btn-primary add-entry add-entry-last">
                <?php echo t('Add Entry'); ?>
            </a>
        </div>

        <script class="repeatableTemplate" type="text/x-handlebars-template">
            <div class="sortable-item" data-id="{{id}}">
                <div class="sortable-item-title">
                    <span class="sortable-item-title-default">
                        <?php echo t('Services List') . ' ' . t("row") . ' <span>#{{id}}</span>'; ?>
                    </span>
                    <span class="sortable-item-title-generated"></span>
                </div>

                <div class="sortable-item-inner">            <div class="form-group">
    <label for="<?php echo $view->field('servicesList'); ?>[{{id}}][title]" class="control-label"><?php echo t("Title"); ?></label>
    <?php echo isset($btFieldsRequired['servicesList']) && in_array('title', $btFieldsRequired['servicesList']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <input name="<?php echo $view->field('servicesList'); ?>[{{id}}][title]" id="<?php echo $view->field('servicesList'); ?>[{{id}}][title]" class="form-control" type="text" value="{{ title }}" maxlength="255" />
</div>            <div class="form-group">
    <label for="<?php echo $view->field('servicesList'); ?>[{{id}}][imagePreview]" class="control-label"><?php echo t("Image Preview"); ?></label>
    <?php echo isset($btFieldsRequired['servicesList']) && in_array('imagePreview', $btFieldsRequired['servicesList']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <div id="servicesList-imagePreview-image-{{id}}" class="ccm-file-selector ft-image-servicesList-imagePreview-file-selector">
<concrete-file-input file-id="{{ imagePreview }}"
                                                     choose-text="<?php echo t('Choose Image'); ?>"
                                                     input-name="<?php echo $view->field('servicesList'); ?>[{{id}}][imagePreview]">
                                </concrete-file-input>
</div>
</div>            
<div class="form-group">
    <label for="<?php echo $view->field('servicesList'); ?>[{{id}}][videoPreview]" class="control-label"><?php echo t("Video Preiview"); ?></label>
    <?php echo isset($btFieldsRequired['servicesList']) && in_array('videoPreview', $btFieldsRequired['servicesList']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <div id="servicesList-videoPreview-file-{{id}}" class="ccm-file-selector ft-file-servicesList-videoPreview-file-selector">
<concrete-file-input file-id="{{ videoPreview }}"
                                                     choose-text="<?php echo t('Choose File'); ?>"
                                                     input-name="<?php echo $view->field('servicesList'); ?>[{{id}}][videoPreview]">
                                </concrete-file-input>
</div>
</div>            <div class="form-group">
    <label for="<?php echo $view->field('servicesList'); ?>[{{id}}][content]" class="control-label"><?php echo t("Content"); ?></label>
    <?php echo isset($btFieldsRequired['servicesList']) && in_array('content', $btFieldsRequired['servicesList']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <textarea name="<?php echo $view->field('servicesList'); ?>[{{id}}][content]" id="<?php echo $view->field('servicesList'); ?>[{{id}}][content]" class="ft-servicesList-content">{{ content }}</textarea>
</div>            <div class="form-group">
    <label for="<?php echo $view->field('servicesList'); ?>[{{id}}][supportBy]" class="control-label"><?php echo t("Supported by (Optional)"); ?></label>
    <?php echo isset($btFieldsRequired['servicesList']) && in_array('supportBy', $btFieldsRequired['servicesList']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <textarea name="<?php echo $view->field('servicesList'); ?>[{{id}}][supportBy]" id="<?php echo $view->field('servicesList'); ?>[{{id}}][supportBy]" class="ft-servicesList-supportBy">{{ supportBy }}</textarea>
</div></div>

                <span class="sortable-item-collapse-toggle"></span>

                <a href="#" class="sortable-item-delete" data-attr-confirm-text="<?php echo t('Are you sure'); ?>">
                    <i class="fa fa-times"></i>
                </a>

                <div class="sortable-item-handle">
                    <i class="fa fa-sort"></i>
                </div>
            </div>
        </script>
    </div>

<script type="text/javascript">
    Concrete.event.publish('btBlockServicesHome.servicesList.edit.open', {id: '<?php echo $repeatable_container_id; ?>'});
    $.each($('#<?php echo $repeatable_container_id; ?> input[type="text"].title-me'), function () {
        $(this).trigger('keyup');
    });
</script>