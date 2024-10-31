<?php
namespace ypl;

class Css {

    public function __construct() {
        $this->init();
    }

    public function init() {
        add_action('admin_enqueue_scripts', array($this, 'adminEenqueScripts'));
    }

    public function allowedPages() {
        $pages = array(
            YPL_POST_TYPE.'_page_'.YPL_HISTORY_PAGE,
        );

        return $pages;
    }

    public function adminEenqueScripts($hook) {

        $currentPostType = AdminHelper::getCurrentPostType();

        ScriptsIncluder::loadStyle('select2.css');
        ScriptsIncluder::loadStyle('yplAdmin.css');
        ScriptsIncluder::loadStyle('yplBootstrap.css');

        $pages = $this->allowedPages();
        if (empty($currentPostType) && !in_array($hook, $pages)) {
            return '';
        }

        if(!empty($currentPostType) && $currentPostType != YPL_POST_TYPE) {
            return '';
        }

    }
}

new Css();