<?php
namespace ypl;

abstract class Poll {
	private $id;
	private $type;
	private $title;
	private $savedData;
	private $sanitizedData;

	public abstract function setExtraOptions();
	public abstract function getViewForm();
	public abstract function getPollQuestion();

	public function setId($id) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id;
	}

	public function setType($type) {
		$this->type = $type;
	}

	public function getType() {
		return $this->type;
	}

	public function setTitle($title) {
		$this->title = $title;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setSavedData($savedData) {
		$this->savedData = $savedData;
	}

	public function getSavedData() {
		return $this->savedData;
	}

	public function getSanitizedData() {
		return $this->sanitizedData;
	}

	public function insertIntoSanitizedData($sanitizedData) {
		if (!empty($sanitizedData)) {
			$this->sanitizedData[$sanitizedData['name']] = $sanitizedData['value'];
		}
	}

	public function __construct() {
		add_action('add_meta_boxes', array($this, 'yplMetaboxes'), 100);
		$this->metaboxes();
	}

	public function metaboxes() {

	}


	public function generalMetaboxes() {
        $metaboxes = array();

        $metaboxes['yplGeneral'] = array(
            'key' => 'yplGeneral',
            'displayName' => 'General',
            'filePath' => YPL_PAGES_VIEWS_PATH.'general.php',
            'context' => 'normal',
            'priority' => 'high'
        );
        $metaboxes['yplSupport'] = array(
            'key' => 'yplSupport',
            'displayName' => 'Info',
            'filePath' => YPL_PAGES_VIEWS_PATH.'support.php',
            'context' => 'side',
            'priority' => 'high'
        );
        $metaboxes['shortcode'] = array(
            'key' => 'yplShortcode',
            'displayName' => 'Shortcode',
            'filePath' => YPL_PAGES_VIEWS_PATH.'shortcodeMetabox.php',
            'context' => 'side',
            'priority' => 'high'
        );

        return $metaboxes;
    }

	public function yplMetaboxes() {
		$metaboxes = array();

		$additionalMetaboxes = apply_filters('yplAdditionalMetaboxes', $metaboxes);

		if (empty($additionalMetaboxes)) {
			return false;
		}
		$generalMetabox = $this->generalMetaboxes();

        $additionalMetaboxes += $generalMetabox;

		foreach ($additionalMetaboxes as $additionalMetabox) {
			if (empty($additionalMetabox)) {
				continue;
			}
			$context = 'normal';
			$priority = 'low';
			$filepath = $additionalMetabox['filePath'];
			// $popupTypeObj = $this->getPopupTypeObj();

			if (!empty($additionalMetabox['context'])) {
				$context = $additionalMetabox['context'];
			}
			if (!empty($additionalMetabox['priority'])) {
				$priority = $additionalMetabox['priority'];
			}

			add_meta_box(
				$additionalMetabox['key'],
				__($additionalMetabox['displayName'], YPL_TEXT_DOMAIN),
				function() use ($filepath) {
					require_once $filepath;
				},
				YPL_POST_TYPE,
				$context,
				$priority
			);
		}
	}

	public function getOptionValue($optionName, $forceDefaultValue = false) {
		$savedData = PollModel::getDataById($this->getId());
		$this->setSavedData($savedData);

		return $this->getOptionValueFromSavedData($optionName, $forceDefaultValue);
	}

	public function getOptionValueFromSavedData($optionName, $forceDefaultValue = false) {

		$defaultData = $this->getDefaultDataByName($optionName);
		$savedData = $this->getSavedData();

		$optionValue = null;

		if (empty($defaultData['type'])) {
			$defaultData['type'] = 'string';
		}

		if (!empty($savedData)) { //edit mode
			if (isset($savedData[$optionName])) { //option exists in the database
				$optionValue = $savedData[$optionName];
			}
			/* if it's a checkbox, it may not exist in the db
			 * if we don't care about it's existence, return empty string
			 * otherwise, go for it's default value
			 */
			else if ($defaultData['type'] == 'checkbox' && !$forceDefaultValue) {
				$optionValue = '';
			}
		}

		if (($optionValue === null && !empty($defaultData['defaultValue'])) || ($defaultData['type'] == 'number' && !isset($optionValue))) {
			$optionValue = $defaultData['defaultValue'];
		}

		if ($defaultData['type'] == 'checkbox') {
			$optionValue = $this->boolToChecked($optionValue);
		}

		if(isset($defaultData['ver']) && $defaultData['ver'] > YPL_PKG_VERSION) {
			if (empty($defaultData['allow'])) {
				return $defaultData['defaultValue'];
			}
			else if (!in_array($optionValue, $defaultData['allow'])) {
				return $defaultData['defaultValue'];
			}
		}

		return $optionValue;
	}

	public function boolToChecked($var) {
		return ($var ? 'checked' : '');
	}

	public static function getPostSavedData($postId) {
		$savedData = get_post_meta($postId, 'ypl_options', true);

		if (empty($savedData)) {
			return array();
		}

		return $savedData;
	}

	public function getDefaultDataByName($optionName) {
		global $YPL_OPTIONS;

		if (empty($YPL_OPTIONS)) {
			return array();
		}

		foreach ($YPL_OPTIONS as $option) {
			if ($option['name'] == $optionName) {
				return $option;
			}
		}

		return array();
	}

	public static function parseYplDataFromData($data) {
		$cdData = array();

		if(empty($data)) {
			return $cdData;
		}

		foreach ($data as $key => $value) {
			if (strpos($key, 'ypl') === 0) {
				$cdData[$key] = $value;
			}
		}

		return $cdData;
	}

	public static function create($data = array()) {
		$obj = new static();
		$id = $data['ypl-post-id'];
		$obj->setId($id);
		// set up apply filter
		YplOptionsConfig::optionsValues();

		foreach ($data as $name => $value) {
			$defaultData = $obj->getDefaultDataByName($name);
			if (empty($defaultData['type'])) {
				$defaultData['type'] = 'string';
			}
			$sanitizedValue = $obj->sanitizeValueByType($value, $defaultData['type']);
			$obj->insertIntoSanitizedData(array('name' => $name,'value' => $sanitizedValue));
		}

		$obj->save();
	}

	private function save() {
		$options = $this->getSanitizedData();
		$options = apply_filters('yplSavedOptions', $options);

		$postId = $this->getId();
		$this->saveOptionsBuilder($options);
		update_post_meta($postId, 'ypl_options', $options);
	}
	
	private function saveOptionsBuilder($options) {
		$settings = $options['ypl-options-settings'];
		$settings = json_decode($settings, true);
		$savedSettings = $options['ypl-optionsBuilder'];
		
		foreach ($savedSettings as $optionKey => $option) {
			foreach ($option as $settingsKey => $setting) {
				$key = key($setting);
				$value = $setting[$key];
				$optionKey -= 1;
				
				$settings[$optionKey][$settingsKey]['adminSide']['attrs'][$key] = $value;
			}
		}
		$id = $this->getId();
		
		update_post_meta($id, 'YPL_SAVED_SETTINGS', $settings);
	}

	public function sanitizeValueByType($value, $type) {
		switch ($type) {
			case 'string':
			case 'number':
				$sanitizedValue = sanitize_text_field($value);
				break;
			case 'html':
				$sanitizedValue = $value;
				break;
			case 'array':
				$sanitizedValue = $this->recursiveSanitizeTextField($value);
				break;
			case 'ypl':
				$sanitizedValue = $value;
				break;
			case 'email':
				$sanitizedValue = sanitize_email($value);
				break;
			case "checkbox":
				$sanitizedValue = sanitize_text_field($value);
				break;
			default:
				$sanitizedValue = sanitize_text_field($value);
				break;
		}

		return $sanitizedValue;
	}

	public function recursiveSanitizeTextField($array) {
		if (!is_array($array)) {
			return $array;
		}

		foreach ($array as $key => &$value) {
			if (is_array($value)) {
				$value = $this->recursiveSanitizeTextField($value);
			}
			else {
				/*get simple field type and do sensitization*/
				$defaultData = $this->getDefaultDataByName($key);
				if (empty($defaultData['type'])) {
					$defaultData['type'] = 'string';
				}
				$value = $this->sanitizeValueByType($value, $defaultData['type']);
			}
		}

		return $array;
	}

	public static function findById($id) {
		$savedData = PollModel::getDataById($id);

		if(empty($savedData)) {
			return false;
		}
		$type = 'classic';

		if(!empty($savedData['ypl-type'])) {
			$type = $savedData['ypl-type'];
		}

		$className = self::getClassNameFromType($type);
		require_once(YPL_TYPES_CLASS_PATH.$className.'.php');
		$className = __NAMESPACE__.'\\'.$className;

		if (!class_exists($className)) {
			wp_die(__($className.' class does not exist', YPL_TEXT_DOMAIN));
		}
		$postTitle = get_the_title($id);

		$obj = new $className();
		$obj->setId($id);
		$obj->setType($type);
		$obj->setTitle($postTitle);

		return $obj;
	}

	public static function getClassNameFromType($type) {
		return ucfirst($type).substr(strrchr(__CLASS__, '\\'), 1);
	}

	public function getFormHeader() {
		$id = $this->getId();
		$form = '<form class="ypl-poll ypl-poll-'.esc_attr($id).'" data-id="'.esc_attr($id).'">';

		return $form;
	}

	public function getFormFooter() {

	    $voteButton = $this->getOptionValue('ypl-vote-button');
	    $progressButton = $this->getOptionValue('ypl-vote-button-progress-title');
		$form = '<div class="ypl-submit-wrapper">
				<input type="submit" value="'.esc_attr($voteButton).'" data-title="'.esc_attr($voteButton).'" data-progress-title="'.esc_attr($progressButton).'" class="ypl-vote">
			</div>';
		$form .= '</form>';

		return $form;
	}


	public static function saveUserData() {
		global $wpdb;
		$ip = AdminHelper::getIpAddress();
		$userDetails = AdminHelper::getUserFirstAndLastName();

		$st = $wpdb->prepare('INSERT INTO '.$wpdb->prefix.YPL_USER_DETAILS_TABLE.' (ip, first_name, last_name, options) VALUES (%s, %s, %s, %s)', $ip, $userDetails['firstName'], $userDetails['lastName'], '');
		$wpdb->query($st);

		$lastid = $wpdb->insert_id;

		return $lastid;
	}

	public static function savePollResults($args) {
		global $wpdb;
		$date = date("Y-m-d h:i:sa");

		$st = $wpdb->prepare('INSERT INTO '.$wpdb->prefix.YPL_RESULTS_TABLE.' (poll_id, user_id, vote, cDate, options) VALUES (%s, %s, %s, %s, %s)', $args['pollId'], $args['userId'], $args['answer'], $date, '');
		return $wpdb->query($st);
	}

	protected function enequeGeneralData() {
        wp_register_style('poll.css', YPL_FRONT_CSS_URL . 'poll.css');
        wp_enqueue_style('poll.css');
    }

	public function results()
    {
        $type = 'classic';
        $className = $type.'Results';
        require_once YPL_RESULTS_CLASS_PATH.$className.'.php';

        $resultClass = __NAMESPACE__.'\\'.$className;
        $obj = new $resultClass();
        $obj->setPoll($this);
        $obj->prepare();
        $results = $obj->resultView();

        return $results;
    }

	public function renderForm()
	{
        $id = $this->getId();
	    $content = '<div class="poll-content-wrapper poll-content-wrapper-'.$id.'">';
	    $content .= '<div class="poll-before-content">'.$this->getOptionValue('ypl-before-poll').'</div>';
	    $content .= '<div class="poll-content">';
        $content .= $this->getPollQuestion();
        $content .= $this->getViewForm();
        $content .= '<div class="poll-results-wrapper ypl-hide">'.$this->results().'</div>';
        $content .= '</div>';
		$content .= '<div class="poll-after-content">'.$this->getOptionValue('ypl-after-poll').'</div>';
		$content .= '<div class="ypl-poll-custom-css"><style type="text/css">'.$this->getOptionValue('ypl-custom-css').'</style></div>';
        $content .= '</div>';

	    return $content;
    }
	
	public static function getPollsObj($agrs = array()) {
		$postStatus = array('publish');
		$polls = array();
		
		if (!empty($agrs['postStatus'])) {
			$postStatus = $agrs['postStatus'];
		}
		
		$posts = get_posts(array(
			'post_type' => YPL_POST_TYPE,
			'post_status' => $postStatus,
			'numberposts' => -1
			// 'order'	=> 'ASC'
		));
		
		if(empty($posts)) {
			return $polls;
		}
		
		foreach ($posts as $post) {
			$pollObj = self::findById($post->ID);
			
			if(empty($pollObj)) {
				continue;
			}
			$polls[] = $pollObj;
		}
		
		return $polls;
	}
	
	public static function shapeIdTitleData($objs = false) {
		
		if (empty($objs)) {
			$objs = self::getPollsObj();
		}
		$idTitle = array();
		
		if(empty($objs)) {
			return $idTitle;
		}
		
		foreach ($objs as $obj) {
			$title = $obj->getTitle();
			$id = $obj->getId();
			
			if(empty($title)) {
				$title = __('(no title)', YPL_TEXT_DOMAIN);
			}
			
			$idTitle[$id] = $title .' - '. $obj->getType();
		}
		
		return $idTitle;
	}
}