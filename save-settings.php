<?php
// Save Code when the page is updated or published
function save_script_code($post_id) {
    // Check for autosave and user permissions
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    // Define the post meta keys
    $meta_keys = array(
        'script_awesome_code_head' => '_script_awesome_code_head',
        'script_awesome_code_body' => '_script_awesome_code_body',
    );

    // Iterate through the meta keys and update their values
    foreach ($meta_keys as $input_key => $meta_key) {
        if (isset($_POST[$input_key])) {
            $script_code = $_POST[$input_key];
            update_post_meta($post_id, $meta_key, $script_code);
        }
    }
}
add_action('save_post', 'save_script_code');
