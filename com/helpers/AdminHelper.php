<?php
namespace ypl;

class AdminHelper {

	public static function createAttrs($attrs) {
		$attrString = '';
		if(!empty($attrs) && isset($attrs)) {

			foreach ($attrs as $attrName => $attrValue) {
				$attrString .= ''.$attrName.'="'.$attrValue.'" ';
			}
		}

		return $attrString;
	}

	public static function getCurrentPostType() {
		global $post_type;
		global $post;
		$currentPostType = '';

		if (is_object($post)) {
			$currentPostType = @$post->post_type;
		}

		// in some themes global $post returns null
		if (empty($currentPostType)) {
			$currentPostType = $post_type;
		}

		if (empty($currentPostType) && !empty($_GET['post'])) {
			$currentPostType = get_post_type($_GET['post']);
		}

		return $currentPostType;
	}

	public static function getIpAddress() {
		if (getenv('HTTP_CLIENT_IP'))
			$ipAddress = getenv('HTTP_CLIENT_IP');
		else if (getenv('HTTP_X_FORWARDED_FOR'))
			$ipAddress = getenv('HTTP_X_FORWARDED_FOR');
		else if (getenv('HTTP_X_FORWARDED'))
			$ipAddress = getenv('HTTP_X_FORWARDED');
		else if (getenv('HTTP_FORWARDED_FOR'))
			$ipAddress = getenv('HTTP_FORWARDED_FOR');
		else if (getenv('HTTP_FORWARDED'))
			$ipAddress = getenv('HTTP_FORWARDED');
		else if (getenv('REMOTE_ADDR'))
			$ipAddress = getenv('REMOTE_ADDR');
		else
			$ipAddress = 'UNKNOWN';

		return $ipAddress;
	}

	public static function createSelectBox($data, $selectedValue, $attrs) {
		$selected = '';
		$attrString = self::createAttrs($attrs);

		$selectBox = '<select '.$attrString.'>';

		foreach($data as $value => $label) {

			/*When is multiselect*/
			if(is_array($selectedValue)) {
				$isSelected = in_array($value, $selectedValue);
				if($isSelected) {
					$selected = 'selected';
				}
			}
			else if($selectedValue == $value) {
				$selected = 'selected';
			}
			else if(is_array($value) && in_array($selectedValue, $value)) {
				$selected = 'selected';
			}

			$selectBox .= '<option value="'.$value.'" '.$selected.'>'.$label.'</option>';
			$selected = '';
		}

		$selectBox .= '</select>';

		return $selectBox;
	}

	public static function getDatabaseEngine() {
		global $wpdb;
		$dbName = $wpdb->dbname;
		$engine = 'InnoDB';
		$engineCheckSql = "SELECT ENGINE FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$dbName'";
		$result = $wpdb->get_results($engineCheckSql, ARRAY_A);
		if (!empty($result)) {
			$engineCheckSql = "SHOW TABLE STATUS WHERE Name = '".$wpdb->prefix."users' AND Engine = 'MyISAM'";
			$result = $wpdb->get_results($engineCheckSql, ARRAY_A);
			if (isset($result[0]['Engine']) && $result[0]['Engine'] == 'MyISAM') {
				$engine = 'MyISAM';
			}
		}

		return $engine;
	}

	public static function getUserFirstAndLastName() {
		$userId = get_current_user_id();
		$details = self::getUserDetails($userId);
		
		return $details;
	}

	public static function getUserDetails($user_id = null ) {

		$userData = array('firstName' => '', 'lastName' => '');
		$user_info = $user_id ? new \WP_User( $user_id ) : wp_get_current_user();

		if ($user_info->first_name) {
			$userData['firstName'] = $user_info->first_name;
			if ($user_info->last_name ) {
				$userData['lastName'] = $user_info->last_name;
			}
		}

		return $userData;
	}

	public static function defaults() {
	    $defaults = array();

	    $defaults['classicPollAlignment'] = array(
	        'left' => __('Left', YPL_TEXT_DOMAIN),
	        'center' => __('Center', YPL_TEXT_DOMAIN),
	        'right' => __('Right', YPL_TEXT_DOMAIN)
        );
	    
	    $defaults['formWithMeasure'] = array(
	        'px' => __('Px', YPL_TEXT_DOMAIN),
	        '%' => __('%', YPL_TEXT_DOMAIN)
        );

	    return apply_filters('yplDefaults', $defaults);
    }
	
	public static function createInput($data, $selectedValue, $attrs) {
		$attrString = '';
		$savedData = $data;
		
		if (isset($selectedValue)) {
			$savedData = $selectedValue;
		}
		if (empty($savedData)) {
			$savedData = '';
		}
		
		if (!empty($attrs) && isset($attrs)) {
			
			foreach ($attrs as $attrName => $attrValue) {
				if ($attrName == 'class') {
					$attrValue .= ' ypl-full-width-events form-control';
				}
				$attrString .= ''.$attrName.'="'.$attrValue.'" ';
			}
		}
		
		$input = "<input $attrString value=\"".esc_attr($savedData)."\">";
		
		return $input;
	}
	
	public static function getResultsCountById($id) {
		global $wpdb;
		$table = $wpdb->prefix.YPL_RESULTS_TABLE;
		$whereSel = $wpdb->prepare('Select Count(id) AS count from '.$table.' WHERE poll_id=%d', array($id));
		$results = $wpdb->get_row($whereSel, ARRAY_A);

		return $results['count'];
	}

	public static function filterHistory(&$query) {

	}

	 public static function getFormattedDate($date) {
        $date = strtotime($date);
        $month = date('F', $date);
        $year = date('Y', $date);

        return $month.' '.$year;
    }
}