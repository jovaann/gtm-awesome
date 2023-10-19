<?php
// Register plugin settings
function script_awesome_register_settings() {
    add_option('script_awesome_code_head', []); // Code for <head>
    add_option('script_awesome_code_body', []); // Code for <body>
    register_setting('script-awesome-settings-group', 'script_awesome_code_head');
    register_setting('script-awesome-settings-group', 'script_awesome_code_body');
}
add_action('admin_init', 'script_awesome_register_settings');

// Add a menu item in the admin menu
function script_awesome_menu() {
    add_menu_page(
        'Script Awesome Settings',
        'Script Awesome',
        'manage_options',
        'script-awesome-settings',
        'script_awesome_settings_page',
        'dashicons-tag'
    );
}
add_action('admin_menu', 'script_awesome_menu');