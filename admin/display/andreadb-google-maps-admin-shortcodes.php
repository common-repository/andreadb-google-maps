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
<div class="andreadb-google-maps-codes">
    <div class="andreadb-google-maps-field">
        <label><?php _e('Your Shortcode', $this->plugin_name); ?></label>
        <input type="text" value="<?php echo $shortcode; ?>" readonly="true" class="widefat" id="andreadb-google-maps-get-shortcode" />
        <span class="note"><?php _e('Copy and paste this shortcode into any WordPress post or page.', $this->plugin_name); ?></span>
        <div class="clear"></div>
    </div>
    <div class="andreadb-google-maps-field">
        <label><?php _e('Your PHP Code', $this->plugin_name); ?></label>
        <textarea id="andreadb-google-maps-get-code" readonly="true"><?php echo $shortcodephp; ?></textarea>
        <span class="note"><?php _e('Copy and paste this code into a template file to include the slideshow.', $this->plugin_name); ?></span>
        <div class="clear"></div>
    </div>
</div>