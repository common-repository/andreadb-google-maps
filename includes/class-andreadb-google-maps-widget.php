<?php
/**
 * The widget functionality of the plugin
 *
 * @since      1.0.0
 *
 * @package    Andreadb_Google_Maps
 * @subpackage Andreadb_Google_Maps/includes
 */

/**
 * Fired during plugin activation.
 *
 * The widget functionality of the plugin.
 *
 * @since      1.0.0
 * @package    Andreadb_Google_Maps
 * @subpackage Andreadb_Google_Maps/includes
 * @author     Andreadb <andreadb91@gmail.com>
 */
class Andreadb_Google_Maps_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {

        parent::__construct(
                'andreadb_google_maps_widget', // Base ID
                __('Andreadb Google Maps', 'andreadb-google-maps'), // Name
                array('description' => __('Display andreadb google maps', 'andreadb-google-maps')) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see	WP_Widget::widget()
     *
     * @uses	apply_filters
     * @uses	get_widget_layout
     *
     * @param	array	$args		Widget arguments.
     * @param 	array	$instance	Saved values from database.
     */
    public function widget($args, $instance) {

        extract($args);

        if (isset($instance['google_maps_id'])) {
            $google_maps_id = $instance['google_maps_id'];

            $title = apply_filters('widget_title', $instance['title']);

            echo $before_widget;
            if (!empty($title)) {
                echo $before_title . $title . $after_title;
            }

            echo do_shortcode('[andreadb_google_maps id="' . $google_maps_id . '"]');
            echo $after_widget;
        }
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see		WP_Widget::update()
     *
     * @param	array	$new_instance	Values just sent to be saved.
     * @param	array	$old_instance	Previously saved values from database.
     *
     * @return 	array	$instance		Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {

        $instance = $old_instance;
        $instance['google_maps_id'] = strip_tags($new_instance['google_maps_id']);
        $instance['title'] = strip_tags($new_instance['title']);

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see		WP_Widget::form()
     *
     * @uses	wp_parse_args
     * @uses	esc_attr
     * @uses	get_field_id
     * @uses	get_field_name
     * @uses	checked
     *
     * @param	array	$instance	Previously saved values from database.
     */
    public function form($instance) {

        $selected_slider = 0;
        $title = "";
        $sliders = false;

        if (isset($instance['google_maps_id'])) {
            $selected_slider = $instance['google_maps_id'];
        }

        if (isset($instance['title'])) {
            $title = $instance['title'];
        }


        $posts = get_posts(array(
            'post_type' => 'dba_google_maps',
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'ASC',
            'posts_per_page' => -1
        ));

        foreach ($posts as $post) {
            $active = $selected_slider == $post->ID ? true : false;

            $sliders[] = array(
                'active' => $active,
                'title' => $post->post_title,
                'id' => $post->ID
            );
        }
        ?>
        <p>
            <?php if ($sliders) { ?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'andreadb-google-maps'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('google_maps_id'); ?>"><?php _e('Select Slider:', 'andreadb-google-maps'); ?></label>
                <select class="widefat" id="<?php echo $this->get_field_id('google_maps_id'); ?>" name="<?php echo $this->get_field_name('google_maps_id'); ?>">
                    <?php
                    foreach ($sliders as $slider) {
                        $selected = $slider['active'] ? 'selected=selected' : '';
                        echo "<option value='{$slider['id']}' {$selected}>{$slider['title']}</option>";
                    }
                    ?>
                </select>
            </p>
            <?php
        } else {
            _e('No Google Maps found', 'andreadb-google-maps');
        }
        ?>
        </p>
        <?php
    }

}
