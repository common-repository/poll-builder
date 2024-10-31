<?php
namespace ypl;

class Installer {

    public static function uninstall() {

        if (!get_option('ypl-delete-data')) {
            return false;
        }

        self::deletePolls();
    }

    /**
     * Delete all countdown builder post types posts
     *
     * @since 1.2.2
     *
     * @return void
     *
     */
    private static function deletePolls()
    {
        $polls = get_posts(
            array(
                'post_type' => YPL_POST_TYPE,
                'post_status' => array(
                    'publish',
                    'pending',
                    'draft',
                    'auto-draft',
                    'future',
                    'private',
                    'inherit',
                    'trash'
                )
            )
        );

        foreach ($polls as $poll) {
            if (empty($poll)) {
                continue;
            }
            wp_delete_post($poll->ID, true);
        }
    }

    public static function install() {
        self::createTables();

        if(is_multisite() && get_current_blog_id() == 1) {
            global $wp_version;

            if($wp_version > '4.6.0') {
                $sites = get_sites();
            }
            else {
                $sites = wp_get_sites();
            }

            foreach($sites as $site) {

                if($wp_version > '4.6.0') {
                    $blogId = $site->blog_id."_";
                }
                else {
                    $blogId = $site['blog_id']."_";
                }
                if($blogId != 1) {
                    self::createTables($blogId);
                }
            }
        }
    }

    public static function createTables($blogId = '') {
        global $wpdb;
        $createTableHeader = 'CREATE TABLE IF NOT EXISTS '.$wpdb->prefix.$blogId;
        $engine = AdminHelper::getDatabaseEngine();

        $tabelSql = $createTableHeader.YPL_RESULTS_TABLE.' (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`poll_id` int(11) NOT NULL,
			`user_id` int(11) NOT NULL,
			`vote` varchar(255) NOT NULL,
			`cDate` date,
			`options` text,
			PRIMARY KEY (id)
		) ENGINE='.$engine.' DEFAULT CHARSET=utf8; ';

        $wpdb->query($tabelSql);

        $tabelSql = $createTableHeader.YPL_USER_DETAILS_TABLE.' (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`ip` varchar(255) NOT NULL,
			`first_name` varchar(255) NULL,
			`last_name` varchar(255) NULL,
			`options` text,
			PRIMARY KEY (id)
		) ENGINE='.$engine.' DEFAULT CHARSET=utf8; ';

        $wpdb->query($tabelSql);
    }
}