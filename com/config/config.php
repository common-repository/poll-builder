<?php
namespace ypl;

class Config {
    public static function addDefine($name, $value) {
        if(!defined($name)) {
            define($name, $value);
        }
    }

    public static function init() {
        self::addDefine('YPL_URL', plugins_url().'/'.YPL_FOLDER_NAME.'/');
        self::addDefine('YPL_ADMIN_URL', admin_url());
        self::addDefine('YPL_WP_ADMIN_POST_URL', admin_url('admin-post.php'));
        self::addDefine('YPL_PUBLIC_URL', YPL_URL.'public/');
        self::addDefine('YPL_CSS_URL', YPL_PUBLIC_URL.'css/');
        self::addDefine('YPL_ADMIN_CSS_URL', YPL_CSS_URL.'admin/');
        self::addDefine('YPL_FRONT_CSS_URL', YPL_CSS_URL.'front/');
        self::addDefine('YPL_JS_URL', YPL_PUBLIC_URL.'js/');
        self::addDefine('YPL_ADMIN_JS_URL', YPL_JS_URL.'admin/');
        self::addDefine('YPL_FRONT_JS_URL', YPL_JS_URL.'front/');
        self::addDefine('YPL_PATH', WP_PLUGIN_DIR.'/'.YPL_FOLDER_NAME.'/');

        self::addDefine('YPL_COM_PATH', YPL_PATH.'com/');
        self::addDefine('YPL_PUBLIC_PATH', YPL_PATH.'public/');
        self::addDefine('YPL_VIEWS_PATH', YPL_PUBLIC_PATH.'views/');
        self::addDefine('YPL_PAGES_VIEWS_PATH', YPL_VIEWS_PATH.'pages/');
        self::addDefine('YPL_CLASS_PATH', YPL_COM_PATH.'classes/');
        self::addDefine('YPL_ADMIN_CLASS_PATH', YPL_CLASS_PATH.'admin/');
        self::addDefine('YPL_DATA_TABLE_PATH', YPL_CLASS_PATH.'dataTable/');
        self::addDefine('YPL_FRONT_CLASS_PATH', YPL_CLASS_PATH.'front/');
        self::addDefine('YPL_CLASS_ADMIN_PATH', YPL_CLASS_PATH.'admin/');
        self::addDefine('YPL_TYPES_CLASS_PATH', YPL_CLASS_PATH.'types/');
        self::addDefine('YPL_RESULTS_CLASS_PATH', YPL_CLASS_PATH.'results/');
        self::addDefine('YPL_HELPERS_PATH', YPL_COM_PATH.'helpers/');
        self::addDefine('YPL_HELPERS_DATATABLE_PATH', YPL_HELPERS_PATH.'dataTable/');
        self::addDefine('YPL_SUPPORT_URL', 'https://wordpress.org/support/plugin/poll-builder/');
        self::addDefine('YPL_DOWNLOADS_HISTORY', 'YPL_downloads_history');
        self::addDefine('YPL_POST_TYPE', 'yplpoll');
        self::addDefine('YPL_CATEGORY_TAXONOMY', 'yplpoll-category');
        self::addDefine('YPL_TEXT_DOMAIN', 'YPLDownloader');
        self::addDefine('YPL_RESULTS_PAGE', 'yplResults');
        self::addDefine('YPL_HISTORY_PAGE', 'yplHistory');
        self::addDefine('YPL_VERSION', '1.35');
        self::addDefine('YPL_VERSION_TEXT', '1.3.5');
        self::addDefine('YPL_LAST_UPDATE', 'Jan 23');
        self::addDefine('YPL_NEXT_UPDATE', 'Feb 23');
        self::addDefine('YPL_TABLE_LIMIT', 15);
        self::addDefine('YPL_WIDGET', 'YPL_WIDGET');
        self::addDefine('YPL_MENU_TITLE', 'Poll Builder');
        self::addDefine('YPL_RESULTS_TABLE', 'ypl_results');
        self::addDefine('YPL_USER_DETAILS_TABLE', 'ypl_user_details');

        self::addDefine('YPL_AJAX_TRUE', 1);
        self::addDefine('YPL_AJAX_FALSE', 0);
        self::addDefine('YPL_PKG_VERSION', 1);
    }
}

Config::init();

class YplOptionsConfig {
	
	public static function getOptionsDefaultOptions() {
		$option1 = array(
			array(
				'adminSide' => array('label' => 'Answer', 'fieldType' => 'text','frontElement' => 'value', 'attrs' => array('value' => 'Yes', 'class' => 'ypl-question-input'))
			)
		);
		$option2 = array(
			array(
				'adminSide' => array('label' => 'Answer 2', 'fieldType' => 'text', 'frontElement' => 'value', 'attrs' => array('value' => 'No','class' => 'ypl-question-input'))
			)
		);
		
		$options = array(
			$option1,
			$option2
		);
		
		return $options;
	}
	
    public static function optionsValues() {
        global $YPL_OPTIONS;
        $options = array();
        $options[] = array('name' => 'ypl-classic-answer', 'type' => 'array', 'defaultValue' => array(0 => 'Yes', 1 => 'No'));
        $options[] = array('name' => 'ypl-vote-button', 'type' => 'array', 'defaultValue' => 'Vote');
        $options[] = array('name' => 'ypl-vote-button-progress-title', 'type' => 'text', 'defaultValue' => 'Vote...');
        $options[] = array('name' => 'ypl-form-width', 'type' => 'text', 'defaultValue' => '500');
        $options[] = array('name' => 'ypl-optionsBuilder', 'type' => 'array', 'defaultValue' => self::getOptionsDefaultOptions());
        $options[] = array('name' => 'ypl-vote-button-margin-left', 'type' => 'text', 'defaultValue' => '0px');
        $options[] = array('name' => 'ypl-vote-button-margin-top', 'type' => 'text', 'defaultValue' => '0px');
        $options[] = array('name' => 'ypl-vote-button-margin-right', 'type' => 'text', 'defaultValue' => '0px');
        $options[] = array('name' => 'ypl-vote-button-margin-bottom', 'type' => 'text', 'defaultValue' => '0px');
        $options[] = array('name' => 'ypl-vote-button-padding-left', 'type' => 'text', 'defaultValue' => '0px');
        $options[] = array('name' => 'ypl-vote-button-padding-top', 'type' => 'text', 'defaultValue' => '0px');
        $options[] = array('name' => 'ypl-vote-button-padding-right', 'type' => 'text', 'defaultValue' => '0px');
        $options[] = array('name' => 'ypl-vote-button-padding-bottom', 'type' => 'text', 'defaultValue' => '0px');
        $options[] = array('name' => 'ypl-poll-button-padding', 'type' => 'checkbox', 'defaultValue' => '');
        $options[] = array('name' => 'ypl-poll-button-dimension', 'type' => 'checkbox', 'defaultValue' => '');
        $options[] = array('name' => 'ypl-vote-button-border-radius', 'type' => 'text', 'defaultValue' => '0px');

        $YPL_OPTIONS = apply_filters('yplpDefaultOptions', $options);
    }
}