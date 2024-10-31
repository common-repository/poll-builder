<?php
use ypl\Poll;
use ypl\AdminHelper;

// Creating the widget
class YPL_WIDGET extends WP_Widget {
	
	function __construct() {
		parent::__construct(
// Base ID of your widget
			YPL_WIDGET,
// Widget name will appear in UI
			__('Poll Builder', YPL_TEXT_DOMAIN),
// Widget description
			array('description' => __('Poll Builder widget', YPL_TEXT_DOMAIN),)
		);
	}

// Creating widget front-end
	public function widget($args, $instance) {
		$cdId = @$instance['yplOption'];
		echo do_shortcode('[ypl_poll id='.$cdId.']');
	}

// Widget Backend
	public function form($instance) {
		$popups = Poll::getPollsObj();
		$idTitle = Poll::shapeIdTitleData($popups);
		// Widget admin form
		$optionSaved = @$this->get_field_name('yplOption');
		$optionName = @$instance['yplOption'];
		?>
		<p>
			<label><?php _e('Select poll', YPL_TEXT_DOMAIN); ?>:</label>
			<?php echo AdminHelper::createSelectBox($idTitle, $optionName, array('name' => $optionSaved)); ?>
		</p>
		<?php
	}

// Updating widget replacing old instances with new
	public function update($new_instance, $old_instance = array()) {
		
		$instance = array();
		$instance['yplOption'] = $new_instance['yplOption'];
		return $instance;
	}
} // Class wpb_widget ends here
