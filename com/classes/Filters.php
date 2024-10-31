<?php
namespace ypl;

class Filters {
    public function __construct() {
        $this->init();
    }

    public function init() {
        add_filter('manage_'.YPL_POST_TYPE.'_posts_columns' , array($this, 'tableColumns'));
	    add_filter('post_row_actions', array($this, 'duplicatePost'), 10, 2);
    }
	
	public function duplicatePost($actions, $post) {
		if (current_user_can('edit_posts') && $post->post_type == YPL_POST_TYPE) {
			$actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=ypl_duplicate_post_as_draft&post=' . $post->ID, YPL_POST_TYPE, 'duplicate_nonce' ) . '" title="Duplicate this item" rel="permalink">Clone</a>';
		}
		
		return $actions;
	}
	
    public function tableColumns($columns) {
    	unset($columns['date']);
	    $columns['count'] = __('Count', YPL_TEXT_DOMAIN);
        $columns['shortcode'] = __('Shortcode', YPL_TEXT_DOMAIN);
	    
        return $columns;
    }
}

new Filters();