<div class="ypl-bootstrap-wrapper">
	<div class="row form-group">
		<div class="col-md-6">
			<label class="ypl-label-of-input" for="ypl-before-poll"><?php _e('Before poll', YPL_TEXT_DOMAIN); ?></label>
		</div>
		<div class="col-md-12">
			<?php
			$editorId = 'ypl-before-poll';
			$beforePoll = $this->getOptionValue($editorId);
			$settings = array(
				'wpautop' => false,
				'tinymce' => array(
					'width' => '100%'
				),
				'textarea_rows' => '6',
				'media_buttons' => true
			);
			wp_editor($beforePoll, $editorId, $settings);
			?>
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-6">
			<label class="ypl-label-of-input" for="ypl-after-poll"><?php _e('After poll', YPL_TEXT_DOMAIN); ?></label>
		</div>
		<div class="col-md-12">
			<?php
			$editorId = 'ypl-after-poll';
			$afterPoll = $this->getOptionValue($editorId);
			$settings = array(
				'wpautop' => false,
				'tinymce' => array(
					'width' => '100%'
				),
				'textarea_rows' => '6',
				'media_buttons' => true
			);
			wp_editor($afterPoll, $editorId, $settings);
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div>
				<label for="ypl-edtitor-css" class="ypl-label-of-switch"><?php _e('Custom CSS', YRM_LANG); ?>:</label>
				<textarea id="ypl-edtitor-css" rows="5" name="ypl-custom-css" class="widefat textarea"><?php echo esc_attr($this->getOptionValue('ypl-custom-css')); ?></textarea>
			</div>
		</div>
	</div>
</div>