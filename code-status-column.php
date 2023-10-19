<?php
// Add a column to the page list to display Code status
function add_script_column($columns) {
    $columns['script_code_status'] = esc_html('Code Status', 'script-awesome');
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