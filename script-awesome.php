<?php
/*
Plugin Name: Script Awesome
Description: Add and manage JS codes on specific pages and site-wide.
Version: 1.1
Author: Jovan Kitanovic
*/

// Register plugin settings
function script_awesome_register_settings() {
    add_option('script_awesome_code_head', ''); // Code for <head>
    add_option('script_awesome_code_body', ''); // Code for <body>
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

// Callback to render the plugin settings page
function script_awesome_settings_page() {
    ?>
    <div class="wrap">
        <h2>Script Awesome <?php esc_html_e('Settings', 'script-awesome'); ?></h2>
        <form method="post" action="options.php">
            <?php settings_fields('script-awesome-settings-group'); ?>
            <?php do_settings_sections('script-awesome-settings-group'); ?>
            <table class="form-table">
                <tr valign="top">
                <th scope="row"><?php esc_html_e('Code for <head>', 'script-awesome'); ?></th>
                    <td>
                        <textarea name="script_awesome_code_head" rows="8" cols="150"><?php echo esc_textarea(get_option('script_awesome_code_head')); ?></textarea>
                    </td>
                </tr>
                <tr valign="top">
                <th scope="row"><?php esc_html_e('Code for <body>', 'script-awesome'); ?></th>
                    <td>
                        <textarea name="script_awesome_code_body" rows="8" cols="150"><?php echo esc_textarea(get_option('script_awesome_code_body')); ?></textarea>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Function to add Code to <head> for the entire site or page-specific
function add_script_awesome_code_head() {
    $page_id = get_the_ID();
    $script_code_head_page = get_post_meta($page_id, '_script_awesome_code_head', true);
    $script_code_head_global = get_option('script_awesome_code_head');

    if (!empty($script_code_head_page)) {
        echo $script_code_head_page;
    } elseif (!empty($script_code_head_global)) {
        echo $script_code_head_global;
    }
}
add_action('wp_head', 'add_script_awesome_code_head', 10);

// Function to add Code to <body> for the entire site or page-specific
function add_script_awesome_code_body() {
    $page_id = get_the_ID();
    $script_code_body_page = get_post_meta($page_id, '_script_awesome_code_body', true);
    $script_code_body_global = get_option('script_awesome_code_body');

    if (!empty($script_code_body_page)) {
        echo $script_code_body_page;
    } elseif (!empty($script_code_body_global)) {
        echo $script_code_body_global;
    }
}
add_action('wp_footer', 'add_script_awesome_code_body', 10);

// Function to add Code to page editor
function add_script_meta_box() {
    add_meta_box(
        'script_awesome_meta_box',
        'Script Awesome Code',
        'render_script_meta_box',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_script_meta_box');

// Callback to render script meta box
function render_script_meta_box($post) {
    $script_code_head = get_post_meta($post->ID, '_script_awesome_code_head', true);
    $script_code_body = get_post_meta($post->ID, '_script_awesome_code_body', true);

    ?>
    <label for="script_awesome_code_head"><?php esc_html_e('Code for <head>', 'script-awesome'); ?>:</label>
    <textarea name="script_awesome_code_head" id="script_awesome_code_head" rows="4" style="width: 100%;"><?php echo esc_textarea($script_code_head); ?></textarea>

    <label for="script_awesome_code_body"><?php esc_html_e('Code for <body>', 'script-awesome'); ?>:</label>
    <textarea name="script_awesome_code_body" id="script_awesome_code_body" rows="4" style="width: 100%;"><?php echo esc_textarea($script_code_body); ?></textarea>
    <?php
}

// Save Code when the page is updated or published
function save_script_code($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $script_code_head = isset($_POST['script_awesome_code_head']) ? $_POST['script_awesome_code_head'] : '';
    $script_code_body = isset($_POST['script_awesome_code_body']) ? $_POST['script_awesome_code_body'] : '';

    update_post_meta($post_id, '_script_awesome_code_head', $script_code_head);
    update_post_meta($post_id, '_script_awesome_code_body', $script_code_body);
}
add_action('save_post', 'save_script_code');

// Add a column to the page list to display Code status
function add_script_column($columns) {
    $columns['script_code_status'] = esc_html_e('Code Status', 'script-awesome');
    return $columns;
}
add_filter('manage_page_posts_columns', 'add_script_column');

// Display Code status in the column
function display_script_column($column_name, $post_id) {
    if ($column_name == 'script_code_status') {
        $script_code_head = get_post_meta($post_id, '_script_awesome_code_head', true);
        $script_code_body = get_post_meta($post_id, '_script_awesome_code_body', true);

        if (!empty($script_code_head) || !empty($script_code_body)) {
            esc_html_e('Added', 'script-awesome');
        } else {
            esc_html_e('Not added', 'script-awesome');
        }
    }
}
add_action('manage_page_posts_custom_column', 'display_script_column', 10, 2);
