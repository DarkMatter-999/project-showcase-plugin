<?php
/**
 * Plugin Name:       Project Showcase Plugin
 * Plugin URI:        https://github.com/DarkMatter-999/project-showcase-plugin
 * Description:       Display your Github projects as posts.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            DarkMatter-999
 * Author URI:        https://github.com/DarkMatter-999/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       dm-project-plugin
 * Domain Path:       /languages
 *
 * @category Plugin
 * @package  DM_Project_Plugin
 * @author   DarkMatter-999 <darkmatter999official@gmail.com>
 * @license  GPL v2 or later <https://www.gnu.org/licenses/gpl-2.0.html>
 * @link     https://github.com/DarkMatter-999/project-showcase-plugin
 */


if (! defined('ABSPATH')) {
    exit;
}

/**
* Project plugin base directory path.
*/
define('DMPP_PLUGIN_PATH', plugin_dir_path(__FILE__));

/**
* Project plugin base directory URL.
*/
define('DMPP_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once DMPP_PLUGIN_PATH . '/inc/helpers/autoloader.php';

use DM_Project_Plugin\Plugin;

Plugin::get_instance();
