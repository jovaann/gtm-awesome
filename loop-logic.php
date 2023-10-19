<?php
// Function to add Code to <head> for the entire site or page-specific
function add_script_awesome_code_head() {
    $page_id = get_the_ID();
    $script_code_head_page = get_post_meta($page_id, '_script_awesome_code_head', true);
    $script_code_head_global = get_option('script_awesome_code_head', []);

    if (!empty($script_code_head_page)) {
        foreach ((array) $script_code_head_page as $code) {
            echo $code;
        }
    } elseif (!empty($script_code_head_global)) {
        foreach ((array) $script_code_head_global as $code) {
            echo $code;
        }
    }
}
add_action('wp_head', 'add_script_awesome_code_head', 10);

// Function to add Code to <body> for the entire site or page-specific
function add_script_awesome_code_body() {
    $page_id = get_the_ID();
    $script_code_body_page = get_post_meta($page_id, '_script_awesome_code_body', true);
    $script_code_body_global = get_option('script_awesome_code_body', []);

    if (!empty($script_code_body_page)) {
        foreach ((array) $script_code_body_page as $code) {
            echo $code;
        }
    } elseif (!empty($script_code_body_global)) {
        foreach ((array) $script_code_body_global as $code) {
            echo $code;
        }
    }
}
add_action('wp_footer', 'add_script_awesome_code_body', 10);
