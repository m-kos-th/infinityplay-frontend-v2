<?php defined("C5_EXECUTE") or die("Access Denied."); ?>

<?php $tabs = [
    ['form-basics-' . $identifier_getString, t('Basics'), true],
    ['form-socialLinks_items-' . $identifier_getString, t('Social Links')]
];
echo Core::make('helper/concrete/ui')->tabs($tabs); ?>

<div class="tab-content">

<div role="tabpanel" class="tab-pane show active" id="form-basics-<?php echo $identifier_getString; ?>">
    <div class="form-group">
    <?php echo $form->label($view->field('title'), t("Title")); ?>
    <?php echo isset($btFieldsRequired) && in_array('title', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('title'), isset($title) ? $title : null, array (
  'maxlength' => 255,
)); ?>
</div>
</div>

<div role="tabpanel" class="tab-pane" id="form-socialLinks_items-<?php echo $identifier_getString; ?>">
    <script type="text/javascript">
    var CCM_EDITOR_SECURITY_TOKEN = "<?php echo Core::make('helper/validation/token')->generate('editor')?>";
</script>
<?php $repeatable_container_id = 'btSocialMediaNav-socialLinks-container-' . $identifier_getString; ?>
    <div id="<?php echo $repeatable_container_id; ?>">
        <div class="sortable-items-wrapper">
            <a href="#" class="btn btn-primary add-entry">
                <?php echo t('Add Entry'); ?>
            </a>

            <div class="sortable-items" data-attr-content="<?php echo htmlspecialchars(
                json_encode(
                    [
                        'items' => $socialLinks_items,
                        'order' => array_keys($socialLinks_items),
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
                        <?php echo t('Social Links') . ' ' . t("row") . ' <span>#{{id}}</span>'; ?>
                    </span>
                    <span class="sortable-item-title-generated"></span>
                </div>

                <div class="sortable-item-inner">            <?php $socialLink_ContainerID = 'btSocialMediaNav-socialLink-container-' . $identifier_getString; ?>
<div class="ft-smart-link" id="<?php echo $socialLink_ContainerID; ?>">
	<div class="form-group">
		<label for="<?php echo $view->field('socialLinks'); ?>[{{id}}][socialLink]" class="control-label"><?php echo t("Social Link"); ?></label>
	    <?php echo isset($btFieldsRequired['socialLinks']) && in_array('socialLink', $btFieldsRequired['socialLinks']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
	    <?php $socialLinksSocialLink_options = $socialLink_Options; ?>
                    <select name="<?php echo $view->field('socialLinks'); ?>[{{id}}][socialLink]" id="<?php echo $view->field('socialLinks'); ?>[{{id}}][socialLink]" class="form-control ft-smart-link-type">{{#select socialLink}}<?php foreach ($socialLinksSocialLink_options as $k => $v) {
                        echo "<option value='" . $k . "'>" . $v . "</option>";
                     } ?>{{/select}}</select>
	</div>
	
	<div class="form-group">
		<div class="ft-smart-link-options hidden d-none" style="padding-left: 10px;">
			<div class="form-group">
				<label for="<?php echo $view->field('socialLinks'); ?>[{{id}}][socialLink_Title]" class="control-label"><?php echo t("Title"); ?></label>
			    <input name="<?php echo $view->field('socialLinks'); ?>[{{id}}][socialLink_Title]" id="<?php echo $view->field('socialLinks'); ?>[{{id}}][socialLink_Title]" class="form-control" type="text" value="{{ socialLink_Title }}" />		
			</div>
			
			<div class="form-group hidden d-none" data-link-type="page">
			<label for="<?php echo $view->field('socialLinks'); ?>[{{id}}][socialLink_Page]" class="control-label"><?php echo t("Page"); ?></label>
            <small class="required"><?php echo t('Required'); ?></small>
            <div id="socialLinks-socialLink_Page-page-{{id}}" class="ft-smart-link-socialLinks-socialLink-page-selector">
   <concrete-page-input page-id="{{ socialLink_Page }}" 
                                                        input-name="<?php echo $view->field('socialLinks'); ?>[{{id}}][socialLink_Page]" 
                                                        choose-text="<?php echo t('Choose Page') ?>" 
                                                        include-system-pages="false" 
                                                        ask-include-system-pages="false">
                                </concrete-page-input>
</div>
		</div>

		<div class="form-group hidden d-none" data-link-type="url">
			<label for="<?php echo $view->field('socialLinks'); ?>[{{id}}][socialLink_URL]" class="control-label"><?php echo t("URL"); ?></label>
            <small class="required"><?php echo t('Required'); ?></small>
            <input name="<?php echo $view->field('socialLinks'); ?>[{{id}}][socialLink_URL]" id="<?php echo $view->field('socialLinks'); ?>[{{id}}][socialLink_URL]" class="form-control" type="text" value="{{ socialLink_URL }}" />
		</div>

		<div class="form-group hidden d-none" data-link-type="relative_url">
			<label for="<?php echo $view->field('socialLinks'); ?>[{{id}}][socialLink_Relative_URL]" class="control-label"><?php echo t("URL"); ?></label>
            <small class="required"><?php echo t('Required'); ?></small>
            <input name="<?php echo $view->field('socialLinks'); ?>[{{id}}][socialLink_Relative_URL]" id="<?php echo $view->field('socialLinks'); ?>[{{id}}][socialLink_Relative_URL]" class="form-control" type="text" value="{{ socialLink_Relative_URL }}" />
		</div>

		<div class="form-group hidden d-none" data-link-type="file">
		    <label for="<?php echo $view->field('socialLinks'); ?>[{{id}}][socialLink_File]" class="control-label"><?php echo t("File"); ?></label>
            <small class="required"><?php echo t('Required'); ?></small>
            <div id="socialLinks-socialLink_File-file-{{id}}" class="ft-smart-link-socialLinks-socialLink-file-selector">
<concrete-file-input file-id="{{ socialLink_File }}"
                                                     choose-text="<?php echo t('Choose File'); ?>"
                                                     input-name="<?php echo $view->field('socialLinks'); ?>[{{id}}][socialLink_File]">
                                </concrete-file-input>
</div>	
		</div>

		<div class="form-group hidden d-none" data-link-type="image">
			<label for="<?php echo $view->field('socialLinks'); ?>[{{id}}][socialLink_Image]" class="control-label"><?php echo t("Image"); ?></label>
            <small class="required"><?php echo t('Required'); ?></small>
            <div id="socialLinks-socialLink_Image-image-{{id}}" class="ft-smart-link-socialLinks-socialLink-image-selector">
<concrete-file-input file-id="{{ socialLink_Image }}"
                                                     choose-text="<?php echo t('Choose Image'); ?>"
                                                     input-name="<?php echo $view->field('socialLinks'); ?>[{{id}}][socialLink_Image]">
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
    Concrete.event.publish('btSocialMediaNav.socialLinks.edit.open', {id: '<?php echo $repeatable_container_id; ?>'});
    $.each($('#<?php echo $repeatable_container_id; ?> input[type="text"].title-me'), function () {
        $(this).trigger('keyup');
    });
</script>
</div>

</div>