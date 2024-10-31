<?php
namespace ypl;

class RegisterPostType {
    private $typeObj;
    private $type;
    private $id;

    public function __construct() {
        $this->init();

        return true;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return (int)$this->id;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getType() {
        return $this->type;
    }

    public function setTypeObj($typeObj) {
        $this->typeObj = $typeObj;
    }

    public function getTypeObj() {
        return $this->typeObj;
    }

    public function init() {
        $postType = YPL_POST_TYPE;

        $args = $this->getPostTypeArgs();

        register_post_type($postType, $args);
        flush_rewrite_rules(false);
        YplOptionsConfig::optionsValues();
        $this->registerTaxonomy();

        $this->createTypeObj();
    }

    private function createTypeObj() {
        $obj = new ClassicPoll();
        if(!empty($_GET['post'])) {
            $obj->setId($_GET['post']);
        }
    }

    public function getPostTypeArgs()
    {
        $labels = $this->getPostTypeLabels();

        $args = array(
            'labels'             => $labels,
            'description'        => __('Description.', YPL_TEXT_DOMAIN),
            //Exclude_from_search
            'public'             => true,
            'has_archive'        => true,
            //Where to show the post type in the admin menu
            'show_ui'            => true,
            'query_var'          => false,
            // post preview button
            'publicly_queryable' => true,
            'map_meta_cap'       => true,
            'menu_position'      => 10,
            'supports'           => apply_filters('YPLPostTypeSupport', array('title')),
            'menu_icon'          => 'dashicons-chart-bar'
        );

        return $args;
    }

    public function getPostTypeLabels()
    {
        $labels = array(
            'name'               => _x(YPL_MENU_TITLE, 'post type general name', YPL_TEXT_DOMAIN),
            'singular_name'      => _x(YPL_MENU_TITLE, 'post type singular name', YPL_TEXT_DOMAIN),
            'menu_name'          => _x(YPL_MENU_TITLE, 'admin menu', YPL_TEXT_DOMAIN),
            'name_admin_bar'     => _x('Countdown', 'add new on admin bar', YPL_TEXT_DOMAIN),
            'add_new'            => _x('Add New', 'Poll', YPL_TEXT_DOMAIN),
            'add_new_item'       => __('Add New Poll', YPL_TEXT_DOMAIN),
            'new_item'           => __('New Poll', YPL_TEXT_DOMAIN),
            'edit_item'          => __('Edit Poll', YPL_TEXT_DOMAIN),
            'view_item'          => __('View Poll', YPL_TEXT_DOMAIN),
            'all_items'          => __('All '.YPL_MENU_TITLE, YPL_TEXT_DOMAIN),
            'search_items'       => __('Search '.YPL_MENU_TITLE, YPL_TEXT_DOMAIN),
            'parent_item_colon'  => __('Parent '.YPL_MENU_TITLE.':', YPL_TEXT_DOMAIN),
            'not_found'          => __('No '.YPL_MENU_TITLE.' found.', YPL_TEXT_DOMAIN),
            'not_found_in_trash' => __('No '.YPL_MENU_TITLE.' found in Trash.', YPL_TEXT_DOMAIN)
        );

        return $labels;
    }

    public function addSubMenu() {

        add_submenu_page(
            'edit.php?post_type='.YPL_POST_TYPE,
            __('Support', YPL_TEXT_DOMAIN),
            __('Support', YPL_TEXT_DOMAIN),
            'read',
            'YPL-support-page',
            array($this, 'supportPage')
        );

        add_submenu_page(
            'edit.php?post_type='.YPL_POST_TYPE,
            __('More Ideas?', YPL_TEXT_DOMAIN),
            __('More Ideas?', YPL_TEXT_DOMAIN),
            'read',
            'YPL-more-ideas',
            array($this, 'moreIdeasPage')
        );

         add_submenu_page(
            'edit.php?post_type='.YPL_POST_TYPE,
            __('Results', YPL_TEXT_DOMAIN),
            __('Results', YPL_TEXT_DOMAIN),
            'read',
            YPL_RESULTS_PAGE,
            array($this, 'results')
        );
    }

    public function results() {
        if (empty($_GET['currentPollId'])) {
            require_once(YPL_PAGES_VIEWS_PATH.'results.php');
        }
        else {
            require_once(YPL_PAGES_VIEWS_PATH.'pollResult.php');
        }
        
    }

    public function supportPage() {

    }

    public function moreIdeasPage() {

    }
	
	public function registerTaxonomy() {
		$labels = array(
			'name'                       => _x('Categories', 'taxonomy general name', YPL_TEXT_DOMAIN),
			'singular_name'              => _x('Categories', 'taxonomy singular name', YPL_TEXT_DOMAIN),
			'search_items'               => __('Search Categories', YPL_TEXT_DOMAIN),
			'popular_items'              => __('Popular Categories', YPL_TEXT_DOMAIN),
			'all_items'                  => __('All Categories', YPL_TEXT_DOMAIN),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __('Edit Category', YPL_TEXT_DOMAIN),
			'update_item'                => __('Update Category', YPL_TEXT_DOMAIN),
			'add_new_item'               => __('Add New Category', YPL_TEXT_DOMAIN),
			'new_item_name'              => __('New Category Name', YPL_TEXT_DOMAIN),
			'separate_items_with_commas' => __('Separate Categories with commas', YPL_TEXT_DOMAIN),
			'add_or_remove_items'        => __('Add or remove Categories', YPL_TEXT_DOMAIN),
			'choose_from_most_used'      => __('Choose from the most used Categories', YPL_TEXT_DOMAIN),
			'not_found'                  => __('No Categories found.', YPL_TEXT_DOMAIN),
			'menu_name'                  => __('Categories', YPL_TEXT_DOMAIN),
		);
		
		$args = array(
			'hierarchical'          => true,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'sort'                  => 12,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'capabilities' => array(
			)
		);
		
		register_taxonomy(YPL_CATEGORY_TAXONOMY, YPL_POST_TYPE, $args);
		register_taxonomy_for_object_type(YPL_CATEGORY_TAXONOMY, YPL_POST_TYPE);
	}
}