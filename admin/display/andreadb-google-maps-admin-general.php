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
<div class="andreadb-google-maps">
    <div class="andreadb-google-maps-general">
        <input type="hidden" id="andreadb-google-maps-id" value="<?php echo $post->ID; ?>" />
        <div class="andreadb-table">
            <div class="andreadb-row">
                <div class="andreadb-cell">
                    <button type="button" class="button" onclick="openPreview(<?php echo $post->ID; ?>)" id="andreadb-preview-google-maps"><span class="dashicons dashicons-location"></span><?php _e('Preview Google Maps', $this->plugin_name); ?></button>
                </div>
            </div>
            <div class="andreadb-row">
                <div class="andreadb-cell">
                    <label><?php _e('Width', $this->plugin_name); ?></label>
                    <span class="dashicons dashicons-info andreadb-note">
                        <span class="andreadb-tooltip"><?php _e('Insert 100% to be responsive.', $this->plugin_name); ?></span>
                    </span>
                </div>
                <div class="andreadb-cell">
                    <input id="andreadb-google-maps-width" type="number" name="dba_google_maps_general[width]" value="<?php echo esc_attr($data['width']); ?>" />
                </div>
                <div class="andreadb-cell">
                    <div class="switch-field right">
                        <input type="radio" id="px_widthm" name="dba_google_maps_general[widthm]" value="px" <?php checked($data['widthm'], 'px'); ?> /><label for="px_widthm"><?php _e('px', $this->plugin_name); ?></label>
                        <input type="radio" id="perc_widthm" name="dba_google_maps_general[widthm]" value="%" <?php checked($data['widthm'], '%'); ?> /><label for="perc_widthm"><?php _e('%', $this->plugin_name); ?></label>
                    </div>
                </div>
            </div>
            <div class="andreadb-row">
                <div class="andreadb-cell">
                    <label><?php _e('Height', $this->plugin_name); ?></label>
                </div>
                <div class="andreadb-cell">
                    <input id="andreadb-google-maps-height" type="number" name="dba_google_maps_general[height]" value="<?php echo esc_attr($data['height']); ?>" />
                </div>
                <div class="andreadb-cell">
                    <div class="switch-field">
                        <span class="note-switch-transparent"></span>
                        <span class="note-switch"><?php _e('px', $this->plugin_name); ?></span>
                    </div>
                </div>
            </div>
            <div class="andreadb-row">
                <div class="andreadb-cell">
                    <label><?php _e('Zoom Level', $this->plugin_name); ?></label>
                </div>
                <div class="andreadb-cell">
                    <select id="andreadb-google-maps-effect" name="dba_google_maps_general[zoom]">
                        <?php for ($i = 1; $i <= 21; $i++): ?>
                            <option <?php selected($data['zoom'], $i); ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="andreadb-row">
                <div class="andreadb-cell">
                    <label><?php _e('Map Type', $this->plugin_name); ?></label>
                </div>
                <div class="andreadb-cell">
                    <div class="switch-field">
                        <input type="radio" id="roadmap_type" name="dba_google_maps_general[type]" value="roadmap" <?php checked($data['type'], 'roadmap'); ?> /><label for="roadmap_type"><?php _e('Roadmap', $this->plugin_name); ?></label>
                        <input type="radio" id="satellite_type" name="dba_google_maps_general[type]" value="satellite" <?php checked($data['type'], 'satellite'); ?> /><label for="satellite_type"><?php _e('Satellite', $this->plugin_name); ?></label>
                        <input type="radio" id="hybrid_type" name="dba_google_maps_general[type]" value="hybrid" <?php checked($data['type'], 'hybrid'); ?> /><label for="hybrid_type"><?php _e('Hybrid', $this->plugin_name); ?></label>
                        <input type="radio" id="terrain_type" name="dba_google_maps_general[type]" value="terrain" <?php checked($data['type'], 'terrain'); ?> /><label for="terrain_type"><?php _e('Terrain', $this->plugin_name); ?></label>
                    </div>
                </div>
            </div>
            <div class="andreadb-row">
                <div class="andreadb-cell">
                    <label><?php _e('45° Imagery', $this->plugin_name); ?></label>
                    <span class="dashicons dashicons-info andreadb-note">
                        <span class="andreadb-tooltip"><?php _e('Available only for map type Satellite and Hybrid.', $this->plugin_name); ?></span>
                    </span>
                </div>
                <div class="andreadb-cell">
                    <div class="switch-field">
                        <input type="radio" id="enable_imagery" name="dba_google_maps_general[imagery]" value="true" <?php checked($data['imagery'], 'true'); ?> /><label for="enable_imagery"><?php _e('Enabled', $this->plugin_name); ?></label>
                        <input type="radio" id="disable_imagery" name="dba_google_maps_general[imagery]" value="false" <?php checked($data['imagery'], 'false'); ?> /><label for="disable_imagery"><?php _e('Disabled', $this->plugin_name); ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>