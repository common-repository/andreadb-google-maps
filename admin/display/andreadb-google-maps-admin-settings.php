<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Andreadb_Google_Maps
 * @subpackage Andreadb_Google_Maps/admin/display
 */
?>
<div class="andreadb-google-maps-settings">
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form method="post" action="options.php">
            <?php
            // output security fields for the registered setting
            settings_fields('dba_google_maps_section_settings');
            // output setting sections and their fields
            do_settings_sections('dba-google-maps-options');
            // output save settings button
            submit_button('Save Settings');
            ?>
        </form>
    </div>
</div>