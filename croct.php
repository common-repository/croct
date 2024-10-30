<?php

namespace Croct\WordPress;

/**
 * Plugin Name:       Croct
 * Plugin URI:        https://croct.com/wordpress
 * Version:           1.1.1
 * Description:       Content Personalization for WordPress.
 * Requires at least: 4.0
 * Requires PHP:      5.6
 * Author:            Croct
 * Author URI:        https://croct.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       croct
 * Domain Path:       /languages
 *
 * @link              https://croct.com/wordpress
 *
 * @since             1.0.0
 *
 * @wordpress-plugin
 */

\define('CROCT_MIN_PHP_VERSION', '5.6.0');

if (!\function_exists('add_action')) {
    if (!\headers_sent()) {
        if (\function_exists('http_response_code')) {
            \http_response_code(403);
        } else {
            \header('HTTP/1.1 403 Forbidden', true, 403);
        }
    }

    exit('A WordPress plugin is not meant to be addressed directly.');
}

if (\version_compare(\PHP_VERSION, \CROCT_MIN_PHP_VERSION, '<')) {
    // possibly display a notice, trigger error
    \add_action('admin_init', static function () {
        \add_action('admin_notices', static function () {
            echo '<div class="notice error is-dismissible">';

            echo \sprintf(
                '<p>The Croct plugin for WordPress requires PHP version %s or greater.</p>',
                \CROCT_MIN_PHP_VERSION
            );

            echo '</div>';
        });
    });

    return;
}

require_once \dirname(__FILE__) . '/autoload.php';

\add_action(
    'plugins_loaded',
    [new Plugin(\plugin_dir_url(__FILE__), $GLOBALS['wpdb']), 'initialize'],
    0,
    0
);
