<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Andreadb_Google_Maps
 * @subpackage Andreadb_Google_Maps/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Andreadb_Google_Maps
 * @subpackage Andreadb_Google_Maps/public
 * @author     Andreadb <andreadb91@gmail.com>
 */
class Andreadb_Google_Maps_Public {

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
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
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
        $api_key = get_option('dba_google_maps_api_key');
        wp_enqueue_script($this->plugin_name, 'https://maps.googleapis.com/maps/api/js?key=' . $api_key, array('jquery'), null, false);
    }

    /**
     * Register the andreadb_google_maps shortcode.
     * 
     * @since 	1.0.0
     * @access 	public
     * @uses 	add_shortcode()
     */
    public function register_dba_google_maps_shortcodes() {

        add_shortcode('andreadb_google_maps', array($this, 'dba_google_maps_shortcode'));
    }

    /**
     * Displays shortcode on pages
     *
     * @since    1.0.0
     * @param array $atts Array of shortcode parameters
     * @return string Slider HTML
     */
    public function dba_google_maps_shortcode($atts) {

        extract(shortcode_atts(
                        array('id' => 0), $atts, 'andreadb_google_maps'
        ));

        if (!$id) {
            return false;
        }

        $google_maps_general = get_post_meta($id, 'dba_google_maps_general', true);
        $google_maps_markers = get_post_meta($id, 'dba_google_maps_markers', true);
        $google_maps_controls = get_post_meta($id, 'dba_google_maps_controls', true);

        $html = '<!-- andreadb google maps -->
        <div id="andreadb-google-maps-' . $id . '" style="width:' . $google_maps_general["width"] . $google_maps_general["widthm"] . ';height:' . $google_maps_general["height"] . 'px"></div>
        <script>
        google.maps.event.addDomListener(window, "load", function() {
            var mapDiv = document.getElementById("andreadb-google-maps-' . $id . '");
            var map = new google.maps.Map(mapDiv, {
                center: new google.maps.LatLng(' . $google_maps_markers[0]["latitude"] . ', ' . $google_maps_markers[0]["longitude"] . '),
                zoom: ' . $google_maps_general["zoom"] . ',
                mapTypeId: "' . $google_maps_general["type"] . '",
                disableDefaultUI: ' . $google_maps_controls["default_ui_control"] . ',';
        if ($google_maps_controls["default_ui_control"] === 'false') {
            $html .= 'mapTypeControl: ' . $google_maps_controls["map_type_control"] . ',
                        mapTypeControlOptions: {
                            style: google.maps.MapTypeControlStyle.' . $google_maps_controls["map_type_control_style"] . ',
                            position: google.maps.ControlPosition.' . $google_maps_controls["map_type_control_position"] . ',
                        },';
            $html .= 'zoomControl: ' . $google_maps_controls["zoom_control"] . ',';
            if ($google_maps_controls["zoom_control"] === 'true') {
                $html .= 'zoomControlOptions: {
                            position: google.maps.ControlPosition.' . $google_maps_controls["zoom_control_position"] . ',
                        },';
            }
            $html .= 'streetViewControl: ' . $google_maps_controls["street_view_control"] . ',';
            if ($google_maps_controls["street_view_control"] === 'true') {
                $html .= 'streetViewControlOptions: {
                            position: google.maps.ControlPosition.' . $google_maps_controls["street_view_control_position"] . ',
                       },';
            }
            $html .= 'rotateControl: ' . $google_maps_controls["rotate_control"] . ',
                    fullscreenControl: ' . $google_maps_controls["fullscreen_control"] . ',
                    scaleControl: ' . $google_maps_controls["scale_control"] . ',
                    scrollwheel: ' . $google_maps_controls["scrollwheel_control"] . ',';
        }
        $html .= '});';
        if ($google_maps_general['imagery'] === 'true') {
            $html .= 'map.setTilt(45);';
        }
        foreach ($google_maps_markers as $marker) {
            $icon = wp_get_attachment_image_src($marker["icon"]);
            $content = preg_replace("/\r|\n/", "", $marker["info_window"]);
            if ($content) {
                $html .= 'var infowindow = new google.maps.InfoWindow({
                        content: "' . html_entity_decode($content) . '",';
                if ($marker["info_window_width"]) {
                    $html .= 'maxWidth: ' . $marker["info_window_width"] . ',';
                }
                $html .= '});';
            }
            $html .= 'var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(' . $marker["latitude"] . ', ' . $marker["longitude"] . '),
                        map: map,
                        title: "' . $marker["address"] . '",
                        animation: google.maps.Animation.' . $marker["animation"] . ',';
            if ($content) {
                $html .= 'infowindow: infowindow,';
            }
            if ($icon[0]) {
                $html .= 'icon: "' . $icon[0] . '",';
            }
            $html .= '});';
            if ($content && $marker['info_window_open'] === 'Onclick') {
                $html .= 'google.maps.event.addListener(marker, "click", function() {
                        this.infowindow.open(map, this);
                    });';
            } else if ($content && $marker['info_window_open'] === 'Onload') {
                $html .= 'infowindow.open(map, marker);';
            }
        }
        $html .= '});
        </script>
        <!--// andreadb google maps-->';

        return $html;
    }

}
