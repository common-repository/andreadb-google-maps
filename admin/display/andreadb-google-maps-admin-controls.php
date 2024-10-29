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
    <div class="andreadb-google-maps-controls">
        <div class="andreadb-table">
            <div class="andreadb-row">
                <div class="andreadb-cell">
                    <label><?php _e('Map Type Control', $this->plugin_name); ?></label>
                    <span class="dashicons dashicons-info andreadb-note">
                        <span class="andreadb-tooltip"><?php _e('The Map Type control is available in a dropdown or horizontal button bar style, allowing the user to choose a map type (Roadmap, Satellite, Hybrid, or Terrain). This control appears by default in the top left corner of the map.', $this->plugin_name); ?></span>
                    </span>
                </div>
                <div class="andreadb-cell">
                    <select id="andreadb-google-maps-type-control-position" name="dba_google_maps_controls[map_type_control_position]">
                        <?php foreach ($position as $key => $value): ?>
                            <option <?php selected($data['map_type_control_position'], $key); ?> value="<?php echo $key; ?>"><?php _e($value, $this->plugin_name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="andreadb-cell padding">
                    <select id="andreadb-google-maps-type-control-style" name="dba_google_maps_controls[map_type_control_style]">
                        <option <?php selected($data['map_type_control_style'], 'HORIZONTAL_BAR'); ?> value="HORIZONTAL_BAR"><?php _e('Horizontal Bar', $this->plugin_name); ?></option>
                        <option <?php selected($data['map_type_control_style'], 'DROPDOWN_MENU'); ?> value="DROPDOWN_MENU"><?php _e('Dropdown Menu', $this->plugin_name); ?></option>
                        <option <?php selected($data['map_type_control_style'], 'DEFAULT'); ?> value="DEFAULT"><?php _e('Default', $this->plugin_name); ?></option>
                    </select>
                </div>
                <div class="andreadb-cell">
                    <div class="switch-field right">
                        <input type="radio" id="enable_map_type_control" name="dba_google_maps_controls[map_type_control]" value="true" <?php checked($data['map_type_control'], 'true'); ?> /><label for="enable_map_type_control"><?php _e('Enabled', $this->plugin_name); ?></label>
                        <input type="radio" id="disable_map_type_control" name="dba_google_maps_controls[map_type_control]" value="false" <?php checked($data['map_type_control'], 'false'); ?> /><label for="disable_map_type_control"><?php _e('Disabled', $this->plugin_name); ?></label>
                    </div>
                </div>
            </div>
            <div class="andreadb-row">
                <div class="andreadb-cell">
                    <label><?php _e('Zoom Control', $this->plugin_name); ?></label>
                    <span class="dashicons dashicons-info andreadb-note">
                        <span class="andreadb-tooltip"><?php _e('The Zoom control displays "+" and "-" buttons for changing the zoom level of the map. This control appears by default in the bottom right corner of the map.', $this->plugin_name); ?></span>
                    </span>
                </div>
                <div class="andreadb-cell">
                    <select id="andreadb-google-maps-zoom-control-position" name="dba_google_maps_controls[zoom_control_position]">
                        <?php foreach ($position as $key => $value): ?>
                            <option <?php selected($data['zoom_control_position'], $key); ?> value="<?php echo $key; ?>"><?php _e($value, $this->plugin_name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="andreadb-cell"></div>
                <div class="andreadb-cell">
                    <div class="switch-field right">
                        <input type="radio" id="enable_zoom_control" name="dba_google_maps_controls[zoom_control]" value="true" <?php checked($data['zoom_control'], 'true'); ?> /><label for="enable_zoom_control"><?php _e('Enabled', $this->plugin_name); ?></label>
                        <input type="radio" id="disable_zoom_control" name="dba_google_maps_controls[zoom_control]" value="false" <?php checked($data['zoom_control'], 'false'); ?> /><label for="disable_zoom_control"><?php _e('Disabled', $this->plugin_name); ?></label>
                    </div>
                </div>
            </div>
            <div class="andreadb-row">
                <div class="andreadb-cell">
                    <label><?php _e('Street View Control', $this->plugin_name); ?></label>
                    <span class="dashicons dashicons-info andreadb-note">
                        <span class="andreadb-tooltip"><?php _e('The Street View control contains a Pegman icon which can be dragged onto the map to enable Street View. This control appears by default near the bottom right of the map.', $this->plugin_name); ?></span>
                    </span>
                </div>
                <div class="andreadb-cell">
                    <select id="andreadb-google-maps-street-view-control-position" name="dba_google_maps_controls[street_view_control_position]">
                        <?php foreach ($position as $key => $value): ?>
                            <option <?php selected($data['street_view_control_position'], $key); ?> value="<?php echo $key; ?>"><?php _e($value, $this->plugin_name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="andreadb-cell"></div>
                <div class="andreadb-cell">
                    <div class="switch-field right">
                        <input type="radio" id="enable_street_view_control" name="dba_google_maps_controls[street_view_control]" value="true" <?php checked($data['street_view_control'], 'true'); ?> /><label for="enable_street_view_control"><?php _e('Enabled', $this->plugin_name); ?></label>
                        <input type="radio" id="disable_street_view_control" name="dba_google_maps_controls[street_view_control]" value="false" <?php checked($data['street_view_control'], 'false'); ?> /><label for="disable_street_view_control"><?php _e('Disabled', $this->plugin_name); ?></label>
                    </div>
                </div>
            </div>
			<div class="andreadb-row">
                <div class="andreadb-cell">
                    <label><?php _e('Fullscreen Control', $this->plugin_name); ?></label>
                    <span class="dashicons dashicons-info andreadb-note">
                        <span class="andreadb-tooltip"><?php _e('The Fullscreen control offers the option to open the map in fullscreen mode. This control is enabled by default on mobile devices, and is disabled by default on desktop. iOS does not support the fullscreen feature.', $this->plugin_name); ?></span>
                    </span>
                </div>
                <div class="andreadb-cell"></div>
                <div class="andreadb-cell"></div>
                <div class="andreadb-cell">
                    <div class="switch-field right">
                        <input type="radio" id="enable_fullscreen_control" name="dba_google_maps_controls[fullscreen_control]" value="true" <?php checked($data['fullscreen_control'], 'true'); ?> /><label for="enable_fullscreen_control"><?php _e('Enabled', $this->plugin_name); ?></label>
                        <input type="radio" id="disable_fullscreen_control" name="dba_google_maps_controls[fullscreen_control]" value="false" <?php checked($data['fullscreen_control'], 'false'); ?> /><label for="disable_fullscreen_control"><?php _e('Disabled', $this->plugin_name); ?></label>
                    </div>
                </div>
            </div>
            <div class="andreadb-row">
                <div class="andreadb-cell">
                    <label><?php _e('Scrollwheel', $this->plugin_name); ?></label>
                    <span class="dashicons dashicons-info andreadb-note">
                        <span class="andreadb-tooltip"><?php _e('You can choose if you enable or disable scrollwheel zooming on the map.', $this->plugin_name); ?></span>
                    </span>
                </div>
                <div class="andreadb-cell"></div>
                <div class="andreadb-cell"></div>
                <div class="andreadb-cell">
                    <div class="switch-field right">
                        <input type="radio" id="enable_scrollwheel_control" name="dba_google_maps_controls[scrollwheel_control]" value="true" <?php checked($data['scrollwheel_control'], 'true'); ?> /><label for="enable_scrollwheel_control"><?php _e('Enabled', $this->plugin_name); ?></label>
                        <input type="radio" id="disable_scrollwheel_control" name="dba_google_maps_controls[scrollwheel_control]" value="false" <?php checked($data['scrollwheel_control'], 'false'); ?> /><label for="disable_scrollwheel_control"><?php _e('Disabled', $this->plugin_name); ?></label>
                    </div>
                </div>
            </div>
            <div class="andreadb-row">
                <div class="andreadb-cell">
                    <label><?php _e('Rotate Control', $this->plugin_name); ?></label>
                    <span class="dashicons dashicons-info andreadb-note">
                        <span class="andreadb-tooltip"><?php _e('The Rotate control show when zoom greater than 18 and provides a combination of tilt and rotate options for maps containing oblique imagery. This control appears by default near the bottom right of the map. You cannot make the control appear if no 45° imagery is currently available.', $this->plugin_name); ?></span>
                    </span>
                </div>
                <div class="andreadb-cell"></div>
                <div class="andreadb-cell"></div>
                <div class="andreadb-cell">
                    <div class="switch-field right">
                        <input type="radio" id="enable_rotate_control" name="dba_google_maps_controls[rotate_control]" value="true" <?php checked($data['rotate_control'], 'true'); ?> /><label for="enable_rotate_control"><?php _e('Enabled', $this->plugin_name); ?></label>
                        <input type="radio" id="disable_rotate_control" name="dba_google_maps_controls[rotate_control]" value="false" <?php checked($data['rotate_control'], 'false'); ?> /><label for="disable_rotate_control"><?php _e('Disabled', $this->plugin_name); ?></label>
                    </div>
                </div>
            </div>
            <div class="andreadb-row">
                <div class="andreadb-cell">
                    <label><?php _e('Scale Control', $this->plugin_name); ?></label>
                    <span class="dashicons dashicons-info andreadb-note">
                        <span class="andreadb-tooltip"><?php _e('The Scale control displays a map scale element. This control is disabled by default.', $this->plugin_name); ?></span>
                    </span>
                </div>
                <div class="andreadb-cell"></div>
                <div class="andreadb-cell"></div>
                <div class="andreadb-cell">
                    <div class="switch-field right">
                        <input type="radio" id="enable_scale_control" name="dba_google_maps_controls[scale_control]" value="true" <?php checked($data['scale_control'], 'true'); ?> /><label for="enable_scale_control"><?php _e('Enabled', $this->plugin_name); ?></label>
                        <input type="radio" id="disable_scale_control" name="dba_google_maps_controls[scale_control]" value="false" <?php checked($data['scale_control'], 'false'); ?> /><label for="disable_scale_control"><?php _e('Disabled', $this->plugin_name); ?></label>
                    </div>
                </div>
            </div>
            <div class="andreadb-row">
                <div class="andreadb-cell">
                    <label><?php _e('Disabling Controls', $this->plugin_name); ?></label>
                    <span class="dashicons dashicons-info andreadb-note">
                        <span class="andreadb-tooltip"><?php _e('You can choose if you enable or disable controls.', $this->plugin_name); ?></span>
                    </span>
                </div>
                <div class="andreadb-cell"></div>
                <div class="andreadb-cell"></div>
                <div class="andreadb-cell">
                    <div class="switch-field right">
                        <input type="radio" id="enable_default_ui_control" name="dba_google_maps_controls[default_ui_control]" value="true" <?php checked($data['default_ui_control'], 'true'); ?> /><label for="enable_default_ui_control"><?php _e('Enabled', $this->plugin_name); ?></label>
                        <input type="radio" id="disable_default_ui_control" name="dba_google_maps_controls[default_ui_control]" value="false" <?php checked($data['default_ui_control'], 'false'); ?> /><label for="disable_default_ui_control"><?php _e('Disabled', $this->plugin_name); ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>