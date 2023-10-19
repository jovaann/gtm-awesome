
<?php
// Save Code when the page is updated or published
function save_script_code($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $script_code_head = isset($_POST['script_awesome_code_head']) ? $_POST['script_awesome_code_head'] : [];
    $script_code_body = isset($_POST['script_awesome_code_body']) ? $_POST['script_awesome_code_body'] : [];

    update_post_meta($post_id, '_script_awesome_code_head', $script_code_head);
    update_post_meta($post_id, '_script_awesome_code_body', $script_code_body);
}
add_action('save_post', 'save_script_code');