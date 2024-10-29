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
$post_id = $post->ID;
$markers = $this->dba_google_maps_markers($post_id);
?>
<div class="andreadb-google-maps">
    <div class="andreadb-google-maps-markers">
        <ul class="andreadb-tabs">
            <?php
            if (is_array($markers) and count($markers) > 0) :
                $key = 0;
                foreach ($markers as $marker) :
                    ?>
                    <li id="tabl-<?php echo $key; ?>" class="tab-link<?php echo ($key == 0 ? ' selected' : ''); ?>" data-tab="tab-<?php echo $key; ?>">
                        <span><?php _e("Marker", $this->plugin_name); ?>&nbsp;<span class="num"><?php echo $key + 1; ?></span></span>
                    </li>
                    <?php
                    $key++;
                endforeach;
            endif;
            ?>
            <li class="no-back" data-tab="tab-n">
                <button type="button" id="andreadb-add-marker"><span class="dashicons dashicons-plus"></span><?php _e('Add Marker', $this->plugin_name); ?></button>
            </li>
        </ul>
        <div class="andreadb-tabs-content">
            <?php
            if (is_array($markers) and count($markers) > 0) :
                $key = 0;
                foreach ($markers as $marker) :
                    $data = array();
                    $data['marker'] = $marker;
                    ?>
                    <div id="tab-<?php echo $key; ?>" class="tab-content<?php echo ($key == 0 ? ' selected' : ''); ?>">
                        <div class="andreadb-table">
                            <div class="andreadb-row">
                                <div class="andreadb-cell">
                                    <label><?php _e('Address', $this->plugin_name); ?></label>
                                    <span class="dashicons dashicons-info andreadb-note">
                                        <span class="andreadb-tooltip"><?php _e('You can find latitude and longitude of your address <a href="http://www.mapcoordinates.net/" target="_blank">here</a>.', $this->plugin_name); ?></span>
                                    </span>
                                </div>
                                <div class="andreadb-cell">
                                    <input id="andreadb-google-maps-address" type="text" name="dba_google_maps_markers[<?php echo $key; ?>][address]" value="<?php echo esc_attr($marker['address']); ?>" />
                                </div>
                            </div>
                            <div class="andreadb-row">
                                <div class="andreadb-cell">
                                    <label><?php _e('Latitude', $this->plugin_name); ?></label>
                                </div>
                                <div class="andreadb-cell">    
                                    <input id="andreadb-google-maps-latitude" type="text" name="dba_google_maps_markers[<?php echo $key; ?>][latitude]" value="<?php echo esc_attr($marker['latitude']); ?>" />
                                </div>
                            </div>
                            <div class="andreadb-row">
                                <div class="andreadb-cell">
                                    <label><?php _e('Longitude', $this->plugin_name); ?></label>
                                </div>
                                <div class="andreadb-cell">
                                    <input id="andreadb-google-maps-longitude" type="text" name="dba_google_maps_markers[<?php echo $key; ?>][longitude]" value="<?php echo esc_attr($marker['longitude']); ?>" />
                                </div>
                            </div>
                            <div class="andreadb-row">
                                <div class="andreadb-cell">
                                    <label><?php _e('Icon Marker', $this->plugin_name); ?></label>
                                    <span class="dashicons dashicons-info andreadb-note">
                                        <span class="andreadb-tooltip"><?php _e('If you did not set marker, the default marker will be used. You can download marker <a href="https://mapicons.mapsmarker.com/" target="_blank">here</a>.', $this->plugin_name); ?></span>
                                    </span>
                                </div>
                                <div class="andreadb-cell">
                                    <input type="hidden" name="dba_google_maps_markers[<?php echo $key; ?>][icon]" id="andreadb-google-maps-icon-id-<?php echo $key; ?>" value="<?php echo esc_attr($marker['icon']); ?>" />
                                    <div id="andreadb-google-maps-icon-marker-<?php echo $key; ?>" class="andreadb-icon-marker"><?php
                                        if ($marker['icon']) {
                                            echo wp_get_attachment_image($marker['icon'], 'thumbnail', true);
                                        } else {
                                            echo '<img class="default-marker" src="' . $icon_deafult . '" alt="marker" />';
                                        }
                                        ?></div>
                                    <button type="button" id="andreadb-add-image-<?php echo $key; ?>" onclick="addImage(<?php echo $key; ?>)" class="button"><?php _e('Add Icon', $this->plugin_name); ?></button>
                                    <button type="button" id="andreadb-remove-image-<?php echo $key; ?>" onclick="removeImage(<?php echo $key; ?>)" class="button<?php echo ($marker['icon'] ? '' : ' hidden'); ?>"><?php _e('Remove Icon', $this->plugin_name); ?></button>
                                </div>
                            </div>
                            <div class="andreadb-row">
                                <div class="andreadb-cell">
                                    <label><?php _e('Animation', $this->plugin_name); ?></label>
                                </div>
                                <div class="andreadb-cell">
                                    <div class="switch-field">
                                        <input type="radio" id="drop_animation_<?php echo $key; ?>" name="dba_google_maps_markers[<?php echo $key; ?>][animation]" value="DROP" <?php checked($marker['animation'], 'DROP'); ?> /><label for="drop_animation_<?php echo $key; ?>"><?php _e('Drop', $this->plugin_name); ?></label>
                                        <input type="radio" id="bounce_animation_<?php echo $key; ?>" name="dba_google_maps_markers[<?php echo $key; ?>][animation]" value="BOUNCE" <?php checked($marker['animation'], 'BOUNCE'); ?> /><label for="bounce_animation_<?php echo $key; ?>"><?php _e('Bounce', $this->plugin_name); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="andreadb-row">
                                <div class="andreadb-cell">
                                    <label><?php _e('Info Window', $this->plugin_name); ?></label>
                                </div>
                                <div class="andreadb-cell editor">
                                    <?php
                                    $settings = array(
                                        'media_buttons' => false,
                                        'textarea_name' => 'dba_google_maps_markers[' . $key . '][info_window]',
                                        'textarea_rows' => 7,
                                        'teeny' => false,
                                        'quicktags' => true
                                    );
                                    wp_editor(esc_attr($marker['info_window']), 'andreadb-google-maps-info-content-' . $key . '', $settings);
                                    ?>
                                </div>
                            </div>
                            <div class="andreadb-row">
                                <div class="andreadb-cell">
                                    <label><?php _e('Info Window Open', $this->plugin_name); ?></label>
                                </div>
                                <div class="andreadb-cell">
                                    <div class="switch-field">
                                        <input type="radio" id="onclick_info_window_open_<?php echo $key; ?>" name="dba_google_maps_markers[<?php echo $key; ?>][info_window_open]" value="Onclick" <?php checked($marker['info_window_open'], 'Onclick'); ?> /><label for="onclick_info_window_open_<?php echo $key; ?>"><?php _e('Onclick', $this->plugin_name); ?></label>
                                        <input type="radio" id="onload_info_window_open_<?php echo $key; ?>" name="dba_google_maps_markers[<?php echo $key; ?>][info_window_open]" value="Onload" <?php checked($marker['info_window_open'], 'Onload'); ?> /><label for="onload_info_window_open_<?php echo $key; ?>"><?php _e('Onload', $this->plugin_name); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="andreadb-row">
                                <div class="andreadb-cell">
                                    <label><?php _e('Info Window Width', $this->plugin_name); ?></label>
                                    <span class="dashicons dashicons-info andreadb-note">
                                        <span class="andreadb-tooltip"><?php _e('To default max width setted otherwise insert px width.', $this->plugin_name); ?></span>
                                    </span>
                                </div>
                                <div class="andreadb-cell">
                                    <input id="andreadb-google-maps-info-content-width" type="number" name="dba_google_maps_markers[<?php echo $key; ?>][info_window_width]" value="<?php echo esc_attr($marker['info_window_width']); ?>" />
                                </div>
                            </div>
                            <?php if ($key > 0): ?>
                                <div class="andreadb-row">
                                    <div class="andreadb-cell">
                                        <button type="button" class="button button-primary button-large" data-remove="<?php echo $key; ?>" id="andreadb-remove-marker"><span class="dashicons dashicons-minus"></span><?php _e('Remove Marker', $this->plugin_name); ?></button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php
                    $key++;
                endforeach;
            endif;
            ?>
        </div>
    </div>
</div>
