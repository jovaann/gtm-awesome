<?php
/*
Plugin Name: GTM Awesome
Description: Add and manage Google Tag Manager codes on specific pages and site-wide.
Version: 1.0
Author: Jovan Kitanovic
*/

// Register plugin settings
function gtm_awesome_register_settings() {
    add_option('gtm_awesome_code_head', ''); // GTM code for <head>
    add_option('gtm_awesome_code_body', ''); // GTM code for <body>
    register_setting('gtm-awesome-settings-group', 'gtm_awesome_code_head');
    register_setting('gtm-awesome-settings-group', 'gtm_awesome_code_body');
}
add_action('admin_init', 'gtm_awesome_register_settings');

// Add a menu item in the admin menu
function gtm_awesome_menu() {
    add_menu_page(
        'GTM Awesome Settings',
        'GTM Awesome',
        'manage_options',
        'gtm-awesome-settings',
        'gtm_awesome_settings_page',
        'dashicons-tag'
    );
}
add_action('admin_menu', 'gtm_awesome_menu');

// Callback to render the plugin settings page
function gtm_awesome_settings_page() {
    ?>
    <div class="wrap">
        <h2>GTM Awesome Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields('gtm-awesome-settings-group'); ?>
            <?php do_settings_sections('gtm-awesome-settings-group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">GTM Code for &lt;head&gt;</th>
                    <td>
                        <textarea name="gtm_awesome_code_head" rows="8" cols="150"><?php echo esc_textarea(get_option('gtm_awesome_code_head')); ?></textarea>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">GTM Code for &lt;body&gt;</th>
                    <td>
                        <textarea name="gtm_awesome_code_body" rows="8" cols="150"><?php echo esc_textarea(get_option('gtm_awesome_code_body')); ?></textarea>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Function to add GTM code to <head> for the entire site or page-specific
function add_google_tag_manager_code_head() {
    $page_id = get_the_ID();
    $gtm_code_head_page = get_post_meta($page_id, '_gtm_awesome_code_head', true);
    $gtm_code_head_global = get_option('gtm_awesome_code_head');

    if (!empty($gtm_code_head_page)) {
        echo $gtm_code_head_page;
    } elseif (!empty($gtm_code_head_global)) {
        echo $gtm_code_head_global;
    }
}
add_action('wp_head', 'add_google_tag_manager_code_head', 10);

// Function to add GTM code to <body> for the entire site or page-specific
function add_google_tag_manager_code_body() {
    $page_id = get_the_ID();
    $gtm_code_body_page = get_post_meta($page_id, '_gtm_awesome_code_body', true);
    $gtm_code_body_global = get_option('gtm_awesome_code_body');

    if (!empty($gtm_code_body_page)) {
        echo $gtm_code_body_page;
    } elseif (!empty($gtm_code_body_global)) {
        echo $gtm_code_body_global;
    }
}
add_action('wp_footer', 'add_google_tag_manager_code_body', 10);

// Function to add GTM code to page editor
function add_gtm_meta_box() {
    add_meta_box(
        'gtm_awesome_meta_box',
        'Google Tag Manager Code',
        'render_gtm_meta_box',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_gtm_meta_box');

// Callback to render GTM meta box
function render_gtm_meta_box($post) {
    $gtm_code_head = get_post_meta($post->ID, '_gtm_awesome_code_head', true);
    $gtm_code_body = get_post_meta($post->ID, '_gtm_awesome_code_body', true);

    ?>
    <label for="gtm_awesome_code_head">GTM Code for &lt;head&gt;:</label>
    <textarea name="gtm_awesome_code_head" id="gtm_awesome_code_head" rows="4" style="width: 100%;"><?php echo esc_textarea($gtm_code_head); ?></textarea>

    <label for="gtm_awesome_code_body">GTM Code for &lt;body&gt;:</label>
    <textarea name="gtm_awesome_code_body" id="gtm_awesome_code_body" rows="4" style="width: 100%;"><?php echo esc_textarea($gtm_code_body); ?></textarea>
    <?php
}

// Save GTM code when the page is updated or published
function save_gtm_code($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $gtm_code_head = isset($_POST['gtm_awesome_code_head']) ? $_POST['gtm_awesome_code_head'] : '';
    $gtm_code_body = isset($_POST['gtm_awesome_code_body']) ? $_POST['gtm_awesome_code_body'] : '';

    update_post_meta($post_id, '_gtm_awesome_code_head', $gtm_code_head);
    update_post_meta($post_id, '_gtm_awesome_code_body', $gtm_code_body);
}
add_action('save_post', 'save_gtm_code');

// Add a column to the page list to display GTM code status
function add_gtm_column($columns) {
    $columns['gtm_code_status'] = 'GTM Code Status';
    return $columns;
}
add_filter('manage_page_posts_columns', 'add_gtm_column');

// Display GTM code status in the column
function display_gtm_column($column_name, $post_id) {
    if ($column_name == 'gtm_code_status') {
        $gtm_code_head = get_post_meta($post_id, '_gtm_awesome_code_head', true);
        $gtm_code_body = get_post_meta($post_id, '_gtm_awesome_code_body', true);

        if (!empty($gtm_code_head) || !empty($gtm_code_body)) {
            echo 'Added';
        } else {
            echo 'Not Added';
        }
    }
}
add_action('manage_page_posts_custom_column', 'display_gtm_column', 10, 2);
