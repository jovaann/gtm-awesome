<?php
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
                        <?php
                        $head_codes = get_option('script_awesome_code_head', []);
                        foreach ($head_codes as $index => $code) {
                            echo "<textarea name='script_awesome_code_head[]' rows='8' cols='150'>" . esc_textarea($code) . "</textarea><br>";
                        }
                        ?>
                        <button type="button" class="add-new-code" data-type="head">Add New Code</button>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Code for <body>', 'script-awesome'); ?></th>
                    <td>
                        <?php
                        $body_codes = get_option('script_awesome_code_body', []);
                        foreach ($body_codes as $index => $code) {
                            echo "<textarea name='script_awesome_code_body[]' rows='8' cols='150'>" . esc_textarea($code) . "</textarea><br>";
                        }
                        ?>
                        <button type="button" class="add-new-code" data-type="body">Add New Code</button>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}
