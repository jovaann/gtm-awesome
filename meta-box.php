<?php
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

    $script_code_head = is_array($script_code_head) ? array_filter($script_code_head) : array('');
    $script_code_body = is_array($script_code_body) ? array_filter($script_code_body) : array('');

    // Ensure that at least one textarea is always visible
    if (empty($script_code_head)) {
        $script_code_head = array('');
    }

    if (empty($script_code_body)) {
        $script_code_body = array('');
    }

    ?>
    <label for="script_awesome_code_head"><?php esc_html_e('Code for <head>', 'script-awesome'); ?>:</label>
    <?php
    foreach ($script_code_head as $index => $code) {
        echo "<textarea name='script_awesome_code_head[]' rows='4' style='width: 100%;'>" . esc_textarea($code) . "</textarea>";
    }
    ?>
    <button type="button" class="add-new-code-head">Add New Code</button><br><br>

    <label for="script_awesome_code_body"><?php esc_html_e('Code for <body>', 'script-awesome'); ?>:</label>
    <?php
    foreach ($script_code_body as $index => $code) {
        echo "<textarea name='script_awesome_code_body[]' rows='4' style='width: 100%;'>" . esc_textarea($code) . "</textarea>";
    }
    ?>
    <button type="button" class="add-new-code-body">Add New Code</button>
<?php
}