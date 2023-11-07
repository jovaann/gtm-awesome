<?php
// Register plugin settings
function script_awesome_register_settings() {
    // Add custom fields for head and body scripts
    register_post_meta('page', 'script_awesome_code_head', array(
        'type' => 'array',
        'single' => true,
        'show_in_rest' => true,
    ));
    
    register_post_meta('page', 'script_awesome_code_body', array(
        'type' => 'array',
        'single' => true,
        'show_in_rest' => true,
    ));
}
add_action('init', 'script_awesome_register_settings');

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
