<?php
namespace ypl;

class YplInit {

    private static $instance = null;

    public function __construct() {
        $this->init();
    }

    public static function getInstance() {
        if(!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

	public function init() {
        $this->includeFiles();
        $this->hooks();
	}
	
	public function hooks() {
		register_deactivation_hook(YPL_FILE_NAME, array($this, 'deactivate'));
		add_action('admin_init', array($this, 'pluginRedirect'));
	}

    private function includeFiles() {
        require_once(YPL_HELPERS_PATH.'AdminHelper.php');
        require_once(YPL_ADMIN_CLASS_PATH.'Installer.php');
        require_once(YPL_ADMIN_CLASS_PATH.'PollResults.php');
        require_once(YPL_HELPERS_PATH.'ScriptsIncluder.php');
        require_once(YPL_TYPES_CLASS_PATH.'ClassicPoll.php');
        require_once(YPL_ADMIN_CLASS_PATH.'OptionsBuilder.php');
        require_once(YPL_ADMIN_CLASS_PATH.'OptionsData.php');
        require_once(YPL_CLASS_PATH.'Shortcode.php');
        require_once(YPL_CLASS_PATH.'Ajax.php');
        require_once(YPL_CLASS_PATH.'Js.php');
        require_once(YPL_CLASS_PATH.'Css.php');
        require_once(YPL_CLASS_PATH.'Actions.php');
        require_once(YPL_CLASS_PATH.'Filters.php');
        require_once(YPL_CLASS_PATH.'PollModel.php');
        require_once(YPL_CLASS_PATH.'RegisterPostType.php');
        require_once(YPL_ADMIN_CLASS_PATH.'Widget.php');
    }
	
	public function pluginRedirect() {
		if (!get_option('ypl_redirect')) {
			update_option('ypl_redirect', 1);
			exit(wp_redirect(admin_url('edit.php?post_type='.YPL_POST_TYPE)));
		}
	}
	
	public function deactivate() {
		delete_option('ypl_redirect');
	}
}

YplInit::getInstance();