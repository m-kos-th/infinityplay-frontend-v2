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
	} ?><?php $repeatable_container_id = 'btBlockWorkFeatured-workList-container-' . $identifier_getString; ?>
    <div id="<?php echo $repeatable_container_id; ?>">
        <div class="sortable-items-wrapper">
            <a href="#" class="btn btn-primary add-entry">
                <?php echo t('Add Entry'); ?>
            </a>

            <div class="sortable-items" data-attr-content="<?php echo htmlspecialchars(
                json_encode(
                    [
                        'items' => $workList_items,
                        'order' => array_keys($workList_items),
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
                        <?php echo t('Work List') . ' ' . t("row") . ' <span>#{{id}}</span>'; ?>
                    </span>
                    <span class="sortable-item-title-generated"></span>
                </div>

                <div class="sortable-item-inner">            <div class="form-group">
    <label for="<?php echo $view->field('workList'); ?>[{{id}}][gameName]" class="control-label"><?php echo t("Game Name"); ?></label>
    <?php echo isset($btFieldsRequired['workList']) && in_array('gameName', $btFieldsRequired['workList']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <input name="<?php echo $view->field('workList'); ?>[{{id}}][gameName]" id="<?php echo $view->field('workList'); ?>[{{id}}][gameName]" class="form-control" type="text" value="{{ gameName }}" maxlength="255" />
</div>            <div class="form-group">
    <label for="<?php echo $view->field('workList'); ?>[{{id}}][logo]" class="control-label"><?php echo t("Logo"); ?></label>
    <?php echo isset($btFieldsRequired['workList']) && in_array('logo', $btFieldsRequired['workList']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <div id="workList-logo-image-{{id}}" class="ccm-file-selector ft-image-workList-logo-file-selector">
<concrete-file-input file-id="{{ logo }}"
                                                     choose-text="<?php echo t('Choose Image'); ?>"
                                                     input-name="<?php echo $view->field('workList'); ?>[{{id}}][logo]">
                                </concrete-file-input>
</div>
</div>            
<div class="form-group">
    <label for="<?php echo $view->field('workList'); ?>[{{id}}][videoGamePreview]" class="control-label"><?php echo t("Video Game Preview"); ?></label>
    <?php echo isset($btFieldsRequired['workList']) && in_array('videoGamePreview', $btFieldsRequired['workList']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <div id="workList-videoGamePreview-file-{{id}}" class="ccm-file-selector ft-file-workList-videoGamePreview-file-selector">
<concrete-file-input file-id="{{ videoGamePreview }}"
                                                     choose-text="<?php echo t('Choose File'); ?>"
                                                     input-name="<?php echo $view->field('workList'); ?>[{{id}}][videoGamePreview]">
                                </concrete-file-input>
</div>
</div>            <div class="form-group">
    <label for="<?php echo $view->field('workList'); ?>[{{id}}][content]" class="control-label"><?php echo t("Content"); ?></label>
    <?php echo isset($btFieldsRequired['workList']) && in_array('content', $btFieldsRequired['workList']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <textarea name="<?php echo $view->field('workList'); ?>[{{id}}][content]" id="<?php echo $view->field('workList'); ?>[{{id}}][content]" class="ft-workList-content">{{ content }}</textarea>
</div>            <?php $button_ContainerID = 'btBlockWorkFeatured-button-container-' . $identifier_getString; ?>
<div class="ft-smart-link" id="<?php echo $button_ContainerID; ?>">
	<div class="form-group">
		<label for="<?php echo $view->field('workList'); ?>[{{id}}][button]" class="control-label"><?php echo t("Button"); ?></label>
	    <?php echo isset($btFieldsRequired['workList']) && in_array('button', $btFieldsRequired['workList']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
	    <?php $workListButton_options = $button_Options; ?>
                    <select name="<?php echo $view->field('workList'); ?>[{{id}}][button]" id="<?php echo $view->field('workList'); ?>[{{id}}][button]" class="form-control ft-smart-link-type">{{#select button}}<?php foreach ($workListButton_options as $k => $v) {
                        echo "<option value='" . $k . "'>" . $v . "</option>";
                     } ?>{{/select}}</select>
	</div>
	
	<div class="form-group">
		<div class="ft-smart-link-options hidden d-none" style="padding-left: 10px;">
			<div class="form-group">
				<label for="<?php echo $view->field('workList'); ?>[{{id}}][button_Title]" class="control-label"><?php echo t("Title"); ?></label>
			    <input name="<?php echo $view->field('workList'); ?>[{{id}}][button_Title]" id="<?php echo $view->field('workList'); ?>[{{id}}][button_Title]" class="form-control" type="text" value="{{ button_Title }}" />		
			</div>
			
			<div class="form-group hidden d-none" data-link-type="page">
			<label for="<?php echo $view->field('workList'); ?>[{{id}}][button_Page]" class="control-label"><?php echo t("Page"); ?></label>
            <small class="required"><?php echo t('Required'); ?></small>
            <div id="workList-button_Page-page-{{id}}" class="ft-smart-link-workList-button-page-selector">
   <concrete-page-input page-id="{{ button_Page }}" 
                                                        input-name="<?php echo $view->field('workList'); ?>[{{id}}][button_Page]" 
                                                        choose-text="<?php echo t('Choose Page') ?>" 
                                                        include-system-pages="false" 
                                                        ask-include-system-pages="false">
                                </concrete-page-input>
</div>
		</div>

		<div class="form-group hidden d-none" data-link-type="url">
			<label for="<?php echo $view->field('workList'); ?>[{{id}}][button_URL]" class="control-label"><?php echo t("URL"); ?></label>
            <small class="required"><?php echo t('Required'); ?></small>
            <input name="<?php echo $view->field('workList'); ?>[{{id}}][button_URL]" id="<?php echo $view->field('workList'); ?>[{{id}}][button_URL]" class="form-control" type="text" value="{{ button_URL }}" />
		</div>

		<div class="form-group hidden d-none" data-link-type="relative_url">
			<label for="<?php echo $view->field('workList'); ?>[{{id}}][button_Relative_URL]" class="control-label"><?php echo t("URL"); ?></label>
            <small class="required"><?php echo t('Required'); ?></small>
            <input name="<?php echo $view->field('workList'); ?>[{{id}}][button_Relative_URL]" id="<?php echo $view->field('workList'); ?>[{{id}}][button_Relative_URL]" class="form-control" type="text" value="{{ button_Relative_URL }}" />
		</div>

		<div class="form-group hidden d-none" data-link-type="file">
		    <label for="<?php echo $view->field('workList'); ?>[{{id}}][button_File]" class="control-label"><?php echo t("File"); ?></label>
            <small class="required"><?php echo t('Required'); ?></small>
            <div id="workList-button_File-file-{{id}}" class="ft-smart-link-workList-button-file-selector">
<concrete-file-input file-id="{{ button_File }}"
                                                     choose-text="<?php echo t('Choose File'); ?>"
                                                     input-name="<?php echo $view->field('workList'); ?>[{{id}}][button_File]">
                                </concrete-file-input>
</div>	
		</div>

		<div class="form-group hidden d-none" data-link-type="image">
			<label for="<?php echo $view->field('workList'); ?>[{{id}}][button_Image]" class="control-label"><?php echo t("Image"); ?></label>
            <small class="required"><?php echo t('Required'); ?></small>
            <div id="workList-button_Image-image-{{id}}" class="ft-smart-link-workList-button-image-selector">
<concrete-file-input file-id="{{ button_Image }}"
                                                     choose-text="<?php echo t('Choose Image'); ?>"
                                                     input-name="<?php echo $view->field('workList'); ?>[{{id}}][button_Image]">
                                </concrete-file-input>
</div>
		</div>
		</div>
	</div>
</div>
</div>

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
    Concrete.event.publish('btBlockWorkFeatured.workList.edit.open', {id: '<?php echo $repeatable_container_id; ?>'});
    $.each($('#<?php echo $repeatable_container_id; ?> input[type="text"].title-me'), function () {
        $(this).trigger('keyup');
    });
</script>