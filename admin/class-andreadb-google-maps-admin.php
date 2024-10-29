<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Andreadb_Google_Maps
 * @subpackage Andreadb_Google_Maps/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Andreadb_Google_Maps
 * @subpackage Andreadb_Google_Maps/admin
 * @author     Andreadb <andreadb91@gmail.com>
 */
class Andreadb_Google_Maps_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function dba_google_maps_enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Andreadb_Google_Maps_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Andreadb_Google_Maps_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/andreadb-google-maps-admin.css', array(), null, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function dba_google_maps_enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Andreadb_Google_Maps_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Andreadb_Google_Maps_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_media();
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/andreadb-google-maps-admin.js', array('jquery'), null, false);
        wp_localize_script($this->plugin_name, 'andreadb_google_maps', array(
            'url' => __('URL', 'andreadb-google-maps'),
            'confirm' => __('Are you sure?', 'andreadb-google-maps'),
            'ajaxurl' => admin_url('admin-ajax.php'),
            'addmarker_nonce' => wp_create_nonce('dba_google_maps_addmarker'),
            'iframeurl' => admin_url('admin-ajax.php?action=dba_google_maps_preview')
                )
        );
    }

    /**
     * Register dba_google_maps post type.
     *
     * @since 	1.0.0
     * @access 	public
     * @uses 	register_post_type()
     */
    public static function register_dba_google_maps_post_type() {

        $labels = array(
            'name' => __('Google Maps', 'andreadb-google-maps'),
            'singular_name' => __('Google Maps', 'andreadb-google-maps'),
            'menu_name' => _x('Google Maps', 'Admin menu name', 'andreadb-google-maps'),
            'name_admin_bar' => _x('Google Maps', 'add new on admin bar', 'andreadb-google-maps'),
            'add_new' => __('Add Google Maps', 'andreadb-google-maps'),
            'add_new_item' => __('Add New Google Maps', 'andreadb-google-maps'),
            'new_item' => __('New Google Maps', 'andreadb-google-maps'),
            'edit_item' => __('Edit Google Maps', 'andreadb-google-maps'),
            'view_item' => __('View Google Maps', 'andreadb-google-maps'),
            'all_items' => __('Google Maps', 'andreadb-google-maps'),
            'search_items' => __('Search Google Maps', 'andreadb-google-maps'),
            'not_found' => __('No Google Maps found', 'andreadb-google-maps'),
            'not_found_in_trash' => __('No Google Maps found in trash', 'andreadb-google-maps')
        );

        $args = array(
            'labels' => $labels,
            'description' => __('Description.', 'andreadb-google-maps'),
            'public' => true,
            'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => false,
            'rewrite' => false,
            'exclude_from_search' => true,
            'menu_position' => 100,
            'menu_icon' => 'dashicons-location',
            'supports' => array(
                'title',
                'thumbnail'
            ),
        );

        register_post_type('dba_google_maps', $args);
    }

    /**
     * Add columns in dba_google_maps.
     *
     * @since 	1.0.0
     * @param mixed $columns
     * @return array
     */
    public function dba_google_maps_columns($columns) {

        unset($columns['title'], $columns['date']);
        $columns['dba-google-maps-id'] = __('ID', 'andreadb-google-maps');
        $columns['title'] = __('Title', 'andreadb-google-maps');
        $columns['dba-google-maps-address'] = __('Address', 'andreadb-google-maps');
        $columns['dba-google-maps-shortcode'] = __('Shortcode', 'andreadb-google-maps');
        $columns['date'] = __('Date', 'andreadb-google-maps');
        return $columns;
    }

    /**
     * Column value added to dba_google_maps.
     *
     * @since 	1.0.0
     * @param string $column
     */
    public function dba_google_maps_column($column) {

        global $post;
        $post_id = $post->ID;
        $google_maps_markers = get_post_meta($post_id, 'dba_google_maps_markers', true);

        switch ($column) {
            case 'dba-google-maps-id' :
                echo $post_id;
                break;
            case 'dba-google-maps-address' :
                foreach ($google_maps_markers as $marker) {
                    echo "<div>" . $marker["address"] . "</div>";
                }
                break;
            case 'dba-google-maps-shortcode' :
                echo '<input type="text" style="width:100%" value="[andreadb_google_maps id=&quot;' . $post_id . '&quot;]" readonly="true" />';
                break;
        }
    }

    /**
     * Add preview action row.
     *
     * @since 	1.0.0
     * @param $actions $post
     */
    public function dba_google_maps_action_row($actions, $post) {

        if ($post->post_type == "dba_google_maps") {
            $preview_button = __('Preview', 'andreadb-google-maps');
            array_splice($actions, 2, 0, '<a href="#" onclick="openPreview(' . $post->ID . ')">' . $preview_button . '</a>');
        }
        return $actions;
    }

    /**
     * Add metaboxes Google Maps.
     *
     * @since 	1.0.0
     * @access 	public
     */
    public function add_meta_boxes_dba_google_maps() {

        // add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );

        add_meta_box(
                'dba_google_maps_general', __('General', 'andreadb-google-maps'), array($this, 'render_dba_google_maps_general'), 'dba_google_maps', 'normal', 'high'
        );
        add_meta_box(
                'dba_google_maps_markers', __('Markers', 'andreadb-google-maps'), array($this, 'render_dba_google_maps_markers'), 'dba_google_maps', 'normal', 'default'
        );
        add_meta_box(
                'dba_google_maps_controls', __('Controls', 'andreadb-google-maps'), array($this, 'render_dba_google_maps_controls'), 'dba_google_maps', 'normal', 'default'
        );
        add_meta_box(
                'dba_google_maps_shortcodes', __('Shortcodes', 'andreadb-google-maps'), array($this, 'render_dba_google_maps_shortcodes'), 'dba_google_maps', 'side', 'low'
        );
        remove_meta_box('postimagediv', 'dba_google_maps', 'side');
    }

    /**
     * Render google maps shortcodes
     *
     * @since 	1.0.0
     * @access 	public
     * @param $post
     */
    public function render_dba_google_maps_shortcodes($post) {

        $status = get_post_status($post->ID);
        $shortcode = $shortcodephp = '';
        if ($status == 'publish') {
            $shortcode = '[andreadb_google_maps id=&quot;' . $post->ID . '&quot;]';
            $shortcodephp = '&lt;?php &#13;&#10; echo do_shortcode("[andreadb_google_maps id="' . $post->ID . '"]"); &#13;&#10;?>';
        }

        include( plugin_dir_path(__FILE__) . 'display/' . $this->plugin_name . '-admin-shortcodes.php' );
    }

    /**
     * Render google maps general
     *
     * @since 	1.0.0
     * @access 	public
     * @param $post
     */
    public function render_dba_google_maps_general($post) {

        wp_nonce_field('dba_google_maps_nonce', 'meta_box_nonce');

        $default = $this->dba_google_maps_general_defaults();
        $stored = $this->dba_google_maps_general($post);

        $data = array();
        $data['width'] = ($stored['width'] ? $stored['width'] : $default['width']);
        $data['widthm'] = ($stored['widthm'] ? $stored['widthm'] : $default['widthm']);
        $data['height'] = ($stored['height'] ? $stored['height'] : $default['height']);
        $data['zoom'] = ($stored['zoom'] ? $stored['zoom'] : $default['zoom']);
        $data['type'] = ($stored['type'] ? $stored['type'] : $default['type']);
        $data['imagery'] = ($stored['imagery'] ? $stored['imagery'] : $default['imagery']);

        include( plugin_dir_path(__FILE__) . 'display/' . $this->plugin_name . '-admin-general.php' );
    }

    /**
     * Gets the Google Maps default general.
     *
     * @since 	1.0.0
     * @access 	public
     * @return array The array of Google Maps defaults
     */
    public function dba_google_maps_general_defaults() {

        return array(
            'width' => '100',
            'widthm' => '%',
            'height' => '400',
            'zoom' => '8',
            'type' => 'roadmap',
            'imagery' => 'false'
        );
    }

    /**
     * Gets the Google Maps general.
     *
     * @since 	1.0.0
     * @access 	public
     * @param $post
     * @return array The array of Google Maps general
     */
    public function dba_google_maps_general($post) {

        $post_id = $post->ID;
        $general = get_post_meta($post_id, 'dba_google_maps_general', true);
        if (empty($general)) {
            $this->dba_google_maps_general_defaults();
        } else {
            return $general;
        }
    }

    /**
     * Render google maps markers
     *
     * @since 	1.0.0
     * @access 	public
     * @param $post
     */
    public function render_dba_google_maps_markers($post) {

        wp_nonce_field('dba_google_maps_nonce', 'meta_box_nonce');

        $icon_deafult = plugin_dir_url(__FILE__) . 'images/marker.png';
        include( plugin_dir_path(__FILE__) . 'display/' . $this->plugin_name . '-admin-markers.php' );
    }

    /**
     * Gets the Google Maps markers.
     *
     * @since 	1.0.0
     * @access 	public
     * @param $post_id
     * @return array The array of Google Maps markers
     */
    public function dba_google_maps_markers($post_id) {

        $markers = get_post_meta($post_id, 'dba_google_maps_markers', true);
        if (empty($markers)) {
            return array(
                '0' => array(
                    'address' => 'Colosseo, Roma, RM, Italia',
                    'latitude' => '41.890210',
                    'longitude' => '12.492231',
                    'icon' => '',
                    'animation' => 'DROP',
                    'info_window' => '',
                    'info_window_open' => 'Onclick',
                    'info_window_width' => ''
                ),
            );
        } else {
            return $markers;
        }
    }

    /**
     * Add a new marker tab.
     *
     * @since 	1.0.0
     * @access 	public
     */
    public function ajax_add_dba_google_maps_marker_tab() {

        // security check
        if (!wp_verify_nonce($_REQUEST['_wpnonce'], 'dba_google_maps_addmarker')) {
            _e("Security check failed. Refresh page and try again.", $this->plugin_name);
            wp_die();
        }

        $element = $_POST['element'];
        ?>

        <li id="tabl-<?php echo $element; ?>" class="tab-link selected" data-tab="tab-<?php echo $element; ?>">
            <span><?php _e("Marker", $this->plugin_name); ?>&nbsp;<span class="num"><?php echo $element + 1; ?></span></span>
        </li>
        <?php
        wp_die();
    }

    /**
     * Add a new marker content.
     *
     * @since 	1.0.0
     * @access 	public
     */
    public function ajax_add_dba_google_maps_marker_content() {

        // security check
        if (!wp_verify_nonce($_REQUEST['_wpnonce'], 'dba_google_maps_addmarker')) {
            _e("Security check failed. Refresh page and try again.", $this->plugin_name);
            wp_die();
        }

        $element = $_POST['element'];
        $icon_deafult = plugin_dir_url(__FILE__) . 'images/marker.png';
        add_filter('wp_default_editor', create_function('', 'return "tinymce";'));
        ?>

        <div id="tab-<?php echo $element; ?>" class="tab-content selected">
            <div class="andreadb-table">
                <div class="andreadb-row">
                    <div class="andreadb-cell">
                        <label><?php _e('Address', $this->plugin_name); ?></label>
                        <span class="dashicons dashicons-info andreadb-note">
                            <span class="andreadb-tooltip"><?php _e('You can find latitude and longitude of your address <a href="http://www.mapcoordinates.net/" target="_blank">here</a>.', $this->plugin_name); ?></span>
                        </span>
                    </div>
                    <div class="andreadb-cell">
                        <input id="andreadb-google-maps-address" type="text" name="dba_google_maps_markers[<?php echo $element; ?>][address]" value="" />
                    </div>
                </div>
                <div class="andreadb-row">
                    <div class="andreadb-cell">
                        <label><?php _e('Latitude', $this->plugin_name); ?></label>
                    </div>
                    <div class="andreadb-cell">    
                        <input id="andreadb-google-maps-latitude" type="text" name="dba_google_maps_markers[<?php echo $element; ?>][latitude]" value="41.890210" />
                    </div>
                </div>
                <div class="andreadb-row">
                    <div class="andreadb-cell">
                        <label><?php _e('Longitude', $this->plugin_name); ?></label>
                    </div>
                    <div class="andreadb-cell">
                        <input id="andreadb-google-maps-longitude" type="text" name="dba_google_maps_markers[<?php echo $element; ?>][longitude]" value="12.492231" />
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
                        <input type="hidden" name="dba_google_maps_markers[<?php echo $element; ?>][icon]" id="andreadb-google-maps-icon-id-<?php echo $element; ?>" value="" />
                        <div id="andreadb-google-maps-icon-marker-<?php echo $element; ?>" class="andreadb-icon-marker"><?php echo '<img src="' . $icon_deafult . '" alt="marker" />'; ?></div>
                        <button type="button" id="andreadb-add-image-<?php echo $element; ?>" onclick="addImage(<?php echo $element; ?>)"  class="button"><?php _e('Add Icon', $this->plugin_name); ?></button>
                        <button type="button" id="andreadb-remove-image-<?php echo $element; ?>" onclick="removeImage(<?php echo $element; ?>)" class="button hidden"><?php _e('Remove Icon', $this->plugin_name); ?></button>
                    </div>
                </div>
                <div class="andreadb-row">
                    <div class="andreadb-cell">
                        <label><?php _e('Animation', $this->plugin_name); ?></label>
                    </div>
                    <div class="andreadb-cell">
                        <div class="switch-field">
                            <input type="radio" id="drop_animation_<?php echo $element; ?>" name="dba_google_maps_markers[<?php echo $element; ?>][animation]" value="DROP" checked="checked" /><label for="drop_animation_<?php echo $element; ?>"><?php _e('Drop', $this->plugin_name); ?></label>
                            <input type="radio" id="bounce_animation_<?php echo $element; ?>" name="dba_google_maps_markers[<?php echo $element; ?>][animation]" value="BOUNCE" /><label for="bounce_animation_<?php echo $element; ?>"><?php _e('Bounce', $this->plugin_name); ?></label>
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
                            'textarea_name' => 'dba_google_maps_markers[' . $element . '][info_window]',
                            'textarea_rows' => 7,
                            'quicktags' => array('buttons' => 'strong,em,link,block,del,ins,img,ul,ol,li,code,close')
                        );
                        wp_editor('', 'andreadb-google-maps-info-content-' . $element . '', $settings);
                        ?>
                        <script src="<?php echo get_site_url(); ?>/wp-includes/js/quicktags.min.js"></script>
                    </div>
                </div>
                <div class="andreadb-row">
                    <div class="andreadb-cell">
                        <label><?php _e('Info Window Open', $this->plugin_name); ?></label>
                    </div>
                    <div class="andreadb-cell">
                        <div class="switch-field">
                            <input type="radio" id="onclick_info_window_open_<?php echo $element; ?>" name="dba_google_maps_markers[<?php echo $element; ?>][info_window_open]" value="Onclick" checked="checked" /><label for="onclick_info_window_open_<?php echo $element; ?>"><?php _e('Onclick', $this->plugin_name); ?></label>
                            <input type="radio" id="onload_info_window_open_<?php echo $element; ?>" name="dba_google_maps_markers[<?php echo $element; ?>][info_window_open]" value="Onload" /><label for="onload_info_window_open_<?php echo $element; ?>"><?php _e('Onload', $this->plugin_name); ?></label>
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
                        <input id="andreadb-google-maps-info-content-width" type="number" name="dba_google_maps_markers[<?php echo $element; ?>][info_window_width]" value="" />
                    </div>
                </div>
                <div class="andreadb-row">
                    <div class="andreadb-cell">
                        <button type="button" class="button button-primary button-large" data-remove="<?php echo $element; ?>" id="andreadb-remove-marker"><span class="dashicons dashicons-minus"></span><?php _e('Remove Marker', $this->plugin_name); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <?php
        wp_die();
    }

    /**
     * Render google maps controls
     *
     * @since 	1.0.0
     * @access 	public
     * @param $post
     */
    public function render_dba_google_maps_controls($post) {

        wp_nonce_field('dba_google_maps_nonce', 'meta_box_nonce');

        $default = $this->dba_google_maps_controls_defaults();
        $stored = $this->dba_google_maps_controls($post);

        $position = $this->dba_google_maps_controls_position();

        $data = array();
        $data['map_type_control_position'] = ($stored['map_type_control_position'] ? $stored['map_type_control_position'] : $default['map_type_control_position']);
        $data['map_type_control_style'] = ($stored['map_type_control_style'] ? $stored['map_type_control_style'] : $default['map_type_control_style']);
        $data['map_type_control'] = ($stored['map_type_control'] ? $stored['map_type_control'] : $default['map_type_control']);
        $data['zoom_control_position'] = ($stored['zoom_control_position'] ? $stored['zoom_control_position'] : $default['zoom_control_position']);
        $data['zoom_control'] = ($stored['zoom_control'] ? $stored['zoom_control'] : $default['zoom_control']);
        $data['street_view_control_position'] = ($stored['street_view_control_position'] ? $stored['street_view_control_position'] : $default['street_view_control_position']);
        $data['street_view_control'] = ($stored['street_view_control'] ? $stored['street_view_control'] : $default['street_view_control']);
        $data['rotate_control'] = ($stored['rotate_control'] ? $stored['rotate_control'] : $default['rotate_control']);
        $data['scale_control'] = ($stored['scale_control'] ? $stored['scale_control'] : $default['scale_control']);
        $data['fullscreen_control'] = ($stored['fullscreen_control'] ? $stored['fullscreen_control'] : $default['fullscreen_control']);
        $data['scrollwheel_control'] = ($stored['scrollwheel_control'] ? $stored['scrollwheel_control'] : $default['scrollwheel_control']);
        $data['default_ui_control'] = ($stored['default_ui_control'] ? $stored['default_ui_control'] : $default['default_ui_control']);

        include( plugin_dir_path(__FILE__) . 'display/' . $this->plugin_name . '-admin-controls.php' );
    }

    /**
     * Gets the Google Maps default controls.
     *
     * @since 	1.0.0
     * @access 	public
     * @return array The array of Google Maps defaults
     */
    public function dba_google_maps_controls_defaults() {

        return array(
            'map_type_control_position' => 'TOP_CENTER',
            'map_type_control_style' => 'HORIZONTAL_BAR',
            'map_type_control' => 'true',
            'zoom_control_position' => 'LEFT_CENTER',
            'zoom_control' => 'true',
            'street_view_control_position' => 'LEFT_TOP',
            'street_view_control' => 'true',
            'rotate_control' => 'false',
            'scale_control' => 'false',
            'fullscreen_control' => 'true',
            'scrollwheel_control' => 'true',
            'default_ui_control' => 'false'
        );
    }

    /**
     * Gets the Google Maps controls.
     *
     * @since 	1.0.0
     * @access 	public
     * @param $post
     * @return array The array of Google Maps controls
     */
    public function dba_google_maps_controls($post) {

        $post_id = $post->ID;
        $controls = get_post_meta($post_id, 'dba_google_maps_controls', true);
        if (empty($controls)) {
            $this->dba_google_maps_controls_defaults();
        } else {
            return $controls;
        }
    }

    /**
     * Gets the Google Maps controls position.
     *
     * @since 	1.0.0
     * @access 	public
     * @return array The array of Google Maps controls
     */
    public function dba_google_maps_controls_position() {

        $position = array(
            'TOP_LEFT' => 'Top Left',
            'TOP_RIGHT' => 'Top Right',
            'TOP_CENTER' => 'Top Center',
            'BOTTOM_LEFT' => 'Bottom Left',
            'BOTTOM_RIGHT' => 'Bottom Right',
            'BOTTOM_CENTER' => 'Bottom Center',
            'LEFT_TOP' => 'Left Top',
            'LEFT_CENTER' => 'Left Center',
            'LEFT_BOTTOM' => 'Left Bottom',
            'RIGHT_TOP' => 'Right Top',
            'RIGHT_CENTER' => 'Right Center',
            'RIGHT_BOTTOM' => 'Right Bottom'
        );

        return $position;
    }

    /**
     * Save metaboxes Google Maps
     *
     * @since 	1.0.0
     * @param $post_id
     * @access 	public
     */
    public function save_metaboxes_dba_google_maps($post_id) {

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'dba_google_maps_nonce')) {
            return;
        }

        if (!current_user_can('edit_post')) {
            return;
        }

        // update dba_google_maps_general
        if (isset($_POST['dba_google_maps_general'])) {
            $general = $_POST['dba_google_maps_general'];
            update_post_meta($post_id, 'dba_google_maps_general', $general);
        }

        // update dba_google_maps_controls
        if (isset($_POST['dba_google_maps_controls'])) {
            $controls = $_POST['dba_google_maps_controls'];
            update_post_meta($post_id, 'dba_google_maps_controls', $controls);
        }

        // update dba_google_maps_markers
        if (isset($_POST['dba_google_maps_markers'])) {
            $markers = $_POST['dba_google_maps_markers'];
            update_post_meta($post_id, 'dba_google_maps_markers', $markers);
        }
    }

    public function ajax_dba_google_maps_preview() {

        if (isset($_GET['andreadb_google_maps_id']) && absint($_GET['andreadb_google_maps_id']) > 0) {
            $id = absint($_GET['andreadb_google_maps_id']);
            ?>
            <!DOCTYPE html>
            <html>
                <head>
                    <meta charset="utf-8" />
                    <title><?php _e('Andreadb Google Maps Preview', $this->plugin_name); ?></title>
                    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
                    <meta http-equiv="Pragma" content="no-cache" />
                    <meta http-equiv="Expires" content="0" />
                    <?php wp_head(); ?>
                    <style type='text/css'>
                        body, html {
                            overflow: hidden;
                            margin: 0;
                            padding: 0;
                        }
                    </style>
                </head>
                <body>
                    <div id="andreadb-preview-google-maps">
                        <?php echo do_shortcode('[andreadb_google_maps id="' . $id . '"]'); ?>
                    </div>
                    <?php wp_footer(); ?>
                </body>
            </html>
            <?php
        }

        wp_die();
    }

    /**
     * Register dba_google_maps widget.
     *
     * @since 	1.0.0
     * @access 	public
     * @uses 	register_widget()
     */
    public function register_dba_google_maps_widgets() {

        register_widget('Andreadb_Google_Maps_Widget');
    }

    /**
     * Adds a settings page link to a menu
     *
     * @link 		https://codex.wordpress.org/Administration_Menus
     * @since 		1.0.0
     * @return 		void
     */
    public function add_dba_google_maps_admin_menu() {

        // Top-level page
        // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
        // Submenu Page
        // add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);

        add_submenu_page(
                'edit.php?post_type=dba_google_maps', esc_html__('Andreadb Google Maps Settings', $this->plugin_name), esc_html__('Settings', $this->plugin_name), 'manage_options', 'andreadb-google-maps-settings', array($this, 'dba_google_maps_settings'));
        add_submenu_page(
                'edit.php?post_type=dba_google_maps', esc_html__('Donate', $this->plugin_name), esc_html__('Donate', $this->plugin_name), 'manage_options', 'andreadb-google-maps-donate', array($this, 'dba_google_maps_donate'));
    }

    /**
     * Create andreadb google maps settings page
     *
     * @since 		1.0.0
     * @return 		void
     */
    public function dba_google_maps_settings() {

        include( plugin_dir_path(__FILE__) . 'display/andreadb-google-maps-admin-settings.php' );
    }

    /**
     * Register and add settings
     *
     * @since 		1.0.0
     */
    public function dba_google_maps_settings_init() {

        // Create settings section
        // add_settings_section( $id, $title, $callback, $page );
        add_settings_section(
                'dba_google_maps_section_settings', null, null, 'dba-google-maps-options'
        );

        // Create settings field
        // add_settings_field( $id, $title, $callback, $page, $section = 'default', $args = array() );
        add_settings_field(
                'dba_google_maps_api_key', 'Api Key', array($this, 'display_dba_google_maps_api_key'), 'dba-google-maps-options', 'dba_google_maps_section_settings'
        );

        // Register Settings
        // register_setting( $option_group, $option_name, $sanitize_callback = '' );
        register_setting(
                'dba_google_maps_section_settings', 'dba_google_maps_api_key'
        );
    }

    /**
     * Get the settings option array and print one of its values
     * 
     * @since 		1.0.0
     */
    public function display_dba_google_maps_api_key() {

        echo '<input type="text" id="dba_google_maps_api_key" class="regular-text" name="dba_google_maps_api_key" value="' . get_option('dba_google_maps_api_key') . '" />';
        echo "<p class='description'>" . translate('Get here <a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key"> Api Key </a> and insert here.', $this->plugin_name) . "</p>";
    }

    /**
     * Create andreadb google maps donate page
     *
     * @since 		1.0.0
     * @return 		void
     */
    public function dba_google_maps_donate() {

        include( plugin_dir_path(__FILE__) . 'display/andreadb-google-maps-admin-donate.php' );
    }

}
