<?php

/**
 * Plugin Name: Custom Plugin Test
 * Plugin URI: https://customplugin.com/
 * Description: Custom plugin for testing purposes.
 * Requires at least: 5.0
 * Requires PHP: 7.0
 * Version: 1.0.0
 * Author: Kalkidan T.
 * Author URI: https://kalkidan.com/
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: custom-plugin
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

// Define plugin constants
define('CP_DIR_PATH', __DIR__ . '/');
define('CP_DIR_URL', plugin_dir_url(__FILE__) . '/');

// Include required files
require_once CP_DIR_PATH . 'inc/init.php';

// Initialize the plugin
new Init();
