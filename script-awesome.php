<?php
/*
Plugin Name: Script Awesome
Description: Add and manage JS codes on specific pages and site-wide.
Version: 1.2
Author: Jovan Kitanovic
*/

require_once plugin_dir_path(__FILE__) . 'admin-settings.php';
require_once plugin_dir_path(__FILE__) . 'global-settings.php';
require_once plugin_dir_path(__FILE__) . 'meta-box.php';
require_once plugin_dir_path(__FILE__) . 'save-settings.php';
require_once plugin_dir_path(__FILE__) . 'code-status-column.php';
require_once plugin_dir_path(__FILE__) . 'loop-logic.php';

function enqueue_admin_script() {
    wp_enqueue_script('script-awesome', plugin_dir_url(__FILE__) . 'assets/js/script-awesome.js', array('jquery'), '1.0', true);
}

add_action('admin_enqueue_scripts', 'enqueue_admin_script');