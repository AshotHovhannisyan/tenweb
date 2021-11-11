<?php
/**
 * Plugin Name:  Contact form
 * Description: This is contact form plugin .
 * Version: 1.0
 * Author: Ashot Hovhannisyan
 * License: GPLv3
 * Text Domain:  10web
 */

if (!defined('WPINC')) {
    die;
}

if (!defined('TWEBCF_FILE_NAME')) {
    define('TWEBCF_FILE_NAME', plugin_basename(__FILE__));
}

if (!defined('TWEBCF_FOLDER_NAME')) {
    define('TWEBCF_FOLDER_NAME', plugin_basename(dirname(__FILE__)));
}

require_once(dirname(__FILE__).'/config.php');
require_once(dirname(__FILE__).'/TWEBCFInitialize.php');
