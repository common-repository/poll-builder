<?php
use ypl\AdminHelper;

$default = AdminHelper::defaults();
?>
<div class="ypl-bootstrap-wrapper">
    <div class="row form-group">
        <div class="col-md-6">
            <label for="poll-question"><?php _e('Question', YPL_TEXT_DOMAIN)?></label>
        </div>
        <div class="col-md-6">
            <input type="text" name="ypl-classic-question" class="form-control" value="<?php echo esc_attr($this->getOptionValue('ypl-classic-question')); ?>">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label for="ypl-vote-button"><?php _e('Alignment', YPL_TEXT_DOMAIN)?></label>
        </div>
        <div class="col-md-6">
            <?php echo AdminHelper::createSelectBox($default['classicPollAlignment'], $this->getOptionValue('ypl-poll-alignment'), array('name' => 'ypl-poll-alignment', 'class' => 'js-ypl-select'))?>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label for="ypl-form-width"><?php _e('Form Witdh', YPL_TEXT_DOMAIN)?></label>
        </div>
        <div class="col-md-2">
            <input type="text" name="ypl-form-width" id="ypl-form-width" class="form-control" value="<?php echo esc_attr($this->getOptionValue('ypl-form-width')); ?>">
        </div>
        <div class="col-md-2">
            <?php echo AdminHelper::createSelectBox($default['formWithMeasure'], $this->getOptionValue('ypl-form-width-measure'), array('name' => 'ypl-form-width-measure', 'class' => 'js-ypl-select'))?>
        </div>
    </div>
	<div class="row form-group">
		<div class="col-md-6">
			<label for="ypl-vote-button"><?php _e('Options Style', YPL_TEXT_DOMAIN)?></label>
		</div>
		<div class="col-md-6">
		</div>
	</div>
	<div class="ypl-sub-options">
	<div class="row form-group">
		<div class="col-md-6">
			<label for="ypl-options-label-font-size"><?php _e('Label Font Size', YPL_TEXT_DOMAIN)?></label>
		</div>
		<div class="col-md-6">
			<input type="text" name="ypl-options-label-font-size" id="ypl-options-label-font-size" class="form-control" placeholder="<?php _e('Font Size', YPL_TEXT_DOMAIN)?>" value="<?php echo esc_attr($this->getOptionValue('ypl-options-label-font-size')); ?>">
		</div>
	</div>
	</div>
    <div class="row form-group">
        <div class="col-md-6">
            <label for="ypl-vote-button"><?php _e('Vote button', YPL_TEXT_DOMAIN)?></label>
        </div>
        <div class="col-md-6">
        </div>
    </div>
    <div class="ypl-sub-options">
    <div class="row form-group">
        <div class="col-md-6">
            <label for="ypl-vote-button"><?php _e('Title', YPL_TEXT_DOMAIN)?></label>
        </div>
        <div class="col-md-6">
            <input type="text" name="ypl-vote-button" id="ypl-vote-button" class="form-control" value="<?php echo esc_attr($this->getOptionValue('ypl-vote-button')); ?>">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label for="ypl-vote-button-progress-title"><?php _e('In Progress Title', YPL_TEXT_DOMAIN)?></label>
        </div>
        <div class="col-md-6">
            <input type="text" name="ypl-vote-button-progress-title" id="ypl-vote-button-progress-title" class="form-control" value="<?php echo esc_attr($this->getOptionValue('ypl-vote-button-progress-title')); ?>">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label for="ypl-vote-button-border-radius"><?php _e('Border Radius', YPL_TEXT_DOMAIN)?></label>
        </div>
        <div class="col-md-6">
            <input type="text" name="ypl-vote-button-border-radius" placeholder="<?php _e('Border Radius', YPL_TEXT_DOMAIN)?>" id="ypl-vote-button-border-radius" class="form-control" value="<?php echo esc_attr($this->getOptionValue('ypl-vote-button-border-radius')); ?>">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label for="ypl-vote-button-font-size"><?php _e('Font Size', YPL_TEXT_DOMAIN)?></label>
        </div>
        <div class="col-md-6">
            <input type="number" name="ypl-vote-button-font-size" id="ypl-vote-button-font-size" placeholder="<?php _e('Font Size', YPL_TEXT_DOMAIN)?>" class="form-control" value="<?php echo esc_attr($this->getOptionValue('ypl-vote-button-font-size')); ?>">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-4">
            <label for="ypl-vote-button"><?php _e('Margin', YPL_TEXT_DOMAIN)?></label>
        </div>
        <div class="col-md-2">
            <label for="ypl-vote-button-margin-top"><?php _e('Top'); ?></label>
            <input type="text" name="ypl-vote-button-margin-top" id="ypl-vote-button-margin-top" class="form-control" value="<?php echo esc_attr($this->getOptionValue('ypl-vote-button-margin-top')); ?>">
        </div>
        <div class="col-md-2">
            <label for="ypl-vote-button-margin-right"><?php _e('Right'); ?></label>
            <input type="text" name="ypl-vote-button-margin-right" id="ypl-vote-button-margin-right" class="form-control" value="<?php echo esc_attr($this->getOptionValue('ypl-vote-button-margin-right')); ?>">
        </div>
        <div class="col-md-2">
            <label for="ypl-vote-button-margin-bottom"><?php _e('Bottom'); ?></label>
            <input type="text" name="ypl-vote-button-margin-bottom" id="ypl-vote-button-margin-bottom" class="form-control" value="<?php echo esc_attr($this->getOptionValue('ypl-vote-button-margin-bottom')); ?>">
        </div>
        <div class="col-md-2">
            <label for="ypl-vote-button-margin-left"><?php _e('Left'); ?></label>
            <input type="text" name="ypl-vote-button-margin-left" id="ypl-vote-button-margin-left" class="form-control" value="<?php echo esc_attr($this->getOptionValue('ypl-vote-button-margin-left')); ?>">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label for="ypl-vote-button-font-size"><?php _e('Custom Dimensions', YPL_TEXT_DOMAIN)?></label>
        </div>
        <div class="col-md-6">
            <label class="ypl-switch">
                <input type="checkbox" id="ypl-poll-button-dimension" name="ypl-poll-button-dimension" class="ypl-accordion-checkbox" <?php echo $this->getOptionValue('ypl-poll-button-dimension'); ?>>
                <span class="ypl-slider ypl-round"></span>
            </label>
        </div>
    </div>
    <div class="ypl-accordion-content ypl-hide-content">
        <div class="row form-group">
            <div class="col-md-6">
                <label for="ypl-vote-button-width"><?php _e('Width', YPL_TEXT_DOMAIN)?></label>
            </div>
            <div class="col-md-6">
                <input type="text" name="ypl-vote-button-width" id="ypl-vote-button-width" placeholder="<?php _e('Width', YPL_TEXT_DOMAIN)?>" class="form-control" value="<?php echo esc_attr($this->getOptionValue('ypl-vote-button-width')); ?>">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <label for="ypl-vote-button-height"><?php _e('Height', YPL_TEXT_DOMAIN)?></label>
            </div>
            <div class="col-md-6">
                <input type="text" name="ypl-vote-button-height" placeholder="<?php _e('Height', YPL_TEXT_DOMAIN); ?>" id="ypl-vote-button-height" class="form-control" value="<?php echo esc_attr($this->getOptionValue('ypl-vote-button-height')); ?>">
            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label for="ypl-poll-button-padding"><?php _e('Custom Padding', YPL_TEXT_DOMAIN)?></label>
        </div>
        <div class="col-md-6">
            <label class="ypl-switch">
                <input type="checkbox" id="ypl-poll-button-padding" name="ypl-poll-button-padding" class="ypl-accordion-checkbox" <?php echo $this->getOptionValue('ypl-poll-button-padding'); ?>>
                <span class="ypl-slider ypl-round"></span>
            </label>
        </div>
    </div>
    <div class="ypl-accordion-content ypl-hide-content">
    <div class="row form-group">
        <div class="col-md-4">
            <label for="ypl-vote-button"><?php _e('Padding', YPL_TEXT_DOMAIN)?></label>
        </div>
        <div class="col-md-2">
            <label for="ypl-vote-button-padding-top"><?php _e('Top'); ?></label>
            <input type="text" name="ypl-vote-button-padding-top" id="ypl-vote-button-padding-top" class="form-control" value="<?php echo esc_attr($this->getOptionValue('ypl-vote-button-padding-top')); ?>">
        </div>
        <div class="col-md-2">
            <label for="ypl-vote-button-padding-right"><?php _e('Right'); ?></label>
            <input type="text" name="ypl-vote-button-padding-right" id="ypl-vote-button-padding-right" class="form-control" value="<?php echo esc_attr($this->getOptionValue('ypl-vote-button-padding-right')); ?>">
        </div>
        <div class="col-md-2">
            <label for="ypl-vote-button-padding-bottom"><?php _e('Bottom'); ?></label>
            <input type="text" name="ypl-vote-button-padding-bottom" id="ypl-vote-button-padding-bottom" class="form-control" value="<?php echo esc_attr($this->getOptionValue('ypl-vote-button-padding-bottom')); ?>">
        </div>
        <div class="col-md-2">
            <label for="ypl-vote-button-padding-left"><?php _e('Left'); ?></label>
            <input type="text" name="ypl-vote-button-padding-left" id="ypl-vote-button-padding-left" class="form-control" value="<?php echo esc_attr($this->getOptionValue('ypl-vote-button-padding-left')); ?>">
        </div>
    </div>
    </div>
    </div>
</div>