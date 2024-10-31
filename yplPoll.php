<?php
/**
 * Plugin Name: Poll Builder
 * Description: WordPress Poll plugin allow to create many poll functionality.
 * Version: 1.3.5
 * Author: Felix Moira
 * Author URI: 
 * License: GPLv2
 */
if(!defined('WPINC')) {
    wp_die();
}

if(!defined('YPL_FILE_NAME')) {
    define('YPL_FILE_NAME', plugin_basename(__FILE__));
}

if(!defined('YPL_FOLDER_NAME')) {
    define('YPL_FOLDER_NAME', plugin_basename(dirname(__FILE__)));
}
define('YPL_PREF', plugin_basename(__FILE__));
require_once(dirname(__FILE__).'/com/boot.php');
require_once(dirname(__FILE__).'/config.php');
require_once(YPL_CLASS_PATH.'YplInit.php');