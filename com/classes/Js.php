<?php
namespace ypl;

class Js {
	public function __construct() {
		$this->init();
	}

	private function init() {
		add_action('admin_enqueue_scripts', array($this, 'scripts'));
	}
	
	private function gutenbergParams() {
		$settings = array(
			'allCountdowns' => Poll::shapeIdTitleData(),
			'title'   => __('Poll builder', YPL_TEXT_DOMAIN),
			'description'   => __('This block will help you to add countdown’s shortcode inside the page content', YPL_TEXT_DOMAIN),
			'logo_classname' => 'ypl-gutenberg-logo',
			'poll_select' => __('Select Poll', YPL_TEXT_DOMAIN)
		);
		
		return $settings;
	}

	public function scripts() {
		$postType = $this->getPostTyp();
		$blockSettings = $this->gutenbergParams();
		ScriptsIncluder::registerScript('WpYplBlockMin.js', array('dirUrl' => YPL_ADMIN_JS_URL));
		ScriptsIncluder::localizeScript('WpYplBlockMin.js', 'YPL_GUTENBERG_PARAMS', $blockSettings);
		ScriptsIncluder::enqueueScript('WpYplBlockMin.js');
		if ((!empty($_GET['post_type']) && $_GET['post_type'] == YPL_POST_TYPE) || $postType == YPL_POST_TYPE) {
			wp_register_script('YplAdmin', YPL_ADMIN_JS_URL.'YplAdmin.js');
			wp_localize_script('YplAdmin', 'YPL_ADMIN_DATA', array(
				'nonce' => wp_create_nonce('YPL_ADMIN_NONCE'),
				'copied' => __('Copied', YPL_TEXT_DOMAIN),
				'copyToClipboard' => __('Copy to clipboard', YPL_TEXT_DOMAIN)
			));
			if(function_exists('wp_enqueue_code_editor')) {
				wp_enqueue_code_editor(array( 'type' => 'text/html'));
			}
			wp_enqueue_script('YplAdmin');
			wp_register_script('select2', YPL_ADMIN_JS_URL.'select2.js');
			wp_enqueue_script('select2');
		}
	}

	private function getPostTyp() {
		$postType = '';

		if(empty($_GET['post'])) {
			return $postType;
		}

		return get_post_type($_GET['post']);
	}
}

new Js();