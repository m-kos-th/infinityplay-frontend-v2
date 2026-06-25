<?php defined("C5_EXECUTE") or die("Access Denied."); ?>

<div class="form-group">
    <?php echo $form->label($view->field('content'), t("Content")); ?>
    <?php echo isset($btFieldsRequired) && in_array('content', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make('editor')->outputBlockEditModeEditor($view->field('content'), isset($content) ? $content : null); ?>
</div>

<?php $button_ContainerID = 'btBlockStats-button-container-' . $identifier_getString; ?>
<div class="ft-smart-link" id="<?php echo $button_ContainerID; ?>">
	<div class="form-group">
		<?php echo $form->label($view->field('button'), t("Button")); ?>
	    <?php echo isset($btFieldsRequired) && in_array('button', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
	    <?php echo $form->select($view->field('button'), $button_Options, isset($button) ? $button : null, array (
  'class' => 'form-control ft-smart-link-type',
)); ?>
	</div>
	
	<div class="form-group">
		<div class="ft-smart-link-options hidden d-none" style="padding-left: 10px;">
			<div class="form-group">
				<?php echo $form->label($view->field('button_Title'), t("Title")); ?>
			    <?php echo $form->text($view->field('button_Title'), isset($button_Title) ? $button_Title : null, []); ?>		
			</div>
			
			<div class="form-group hidden d-none" data-link-type="page">
			<?php echo $form->label($view->field('button_Page'), t("Page")); ?>
            <small class="required"><?php echo t('Required'); ?></small>
            <?php echo Core::make("helper/form/page_selector")->selectPage($view->field('button_Page'), isset($button_Page) ? $button_Page : null); ?>
		</div>

		<div class="form-group hidden d-none" data-link-type="url">
			<?php echo $form->label($view->field('button_URL'), t("URL")); ?>
            <small class="required"><?php echo t('Required'); ?></small>
            <?php echo $form->text($view->field('button_URL'), isset($button_URL) ? $button_URL : null, []); ?>
		</div>

		<div class="form-group hidden d-none" data-link-type="relative_url">
			<?php echo $form->label($view->field('button_Relative_URL'), t("URL")); ?>
            <small class="required"><?php echo t('Required'); ?></small>
            <?php echo $form->text($view->field('button_Relative_URL'), isset($button_Relative_URL) ? $button_Relative_URL : null, []); ?>
		</div>

		<div class="form-group hidden d-none" data-link-type="file">
			<?php
			if (isset($button_File) && $button_File > 0) {
				$button_File_o = File::getByID($button_File);
				if (!is_object($button_File_o)) {
					unset($button_File_o);
				}
			} ?>
		    <?php echo $form->label($view->field('button_File'), t("File")); ?>
            <small class="required"><?php echo t('Required'); ?></small>
            <?php echo Core::make("helper/concrete/asset_library")->file('ccm-b-block_stats-button_File-' . $identifier_getString, $view->field('button_File'), t("Choose File"), isset($button_File_o) ? $button_File_o : null); ?>	
		</div>

		<div class="form-group hidden d-none" data-link-type="image">
			<?php
			if (isset($button_Image) && $button_Image > 0) {
				$button_Image_o = File::getByID($button_Image);
				if (!is_object($button_Image_o)) {
					unset($button_Image_o);
				}
			} ?>
			<?php echo $form->label($view->field('button_Image'), t("Image")); ?>
            <small class="required"><?php echo t('Required'); ?></small>
            <?php echo Core::make("helper/concrete/asset_library")->image('ccm-b-block_stats-button_Image-' . $identifier_getString, $view->field('button_Image'), t("Choose Image"), isset($button_Image_o) ? $button_Image_o : null); ?>
		</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	Concrete.event.publish('btBlockStats.button.open', {id: '<?php echo $button_ContainerID; ?>'});
	$('#<?php echo $button_ContainerID; ?> .ft-smart-link-type').trigger('change');
</script>