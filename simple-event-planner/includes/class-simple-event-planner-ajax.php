<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
/**
 * Simple_Event_Planner_Ajax Class
 *
 * This file is used to save event planner settings options. Also for searching
 * events in calendar listing.
 * 
 * @link        https://wordpress.org/plugins/simple-event-planner/
 * @since       1.1.0
 * 
 * @package     Simple_Event_Planner
 * @subpackage  Simple_Event_Planner/includes
 * @author      PressTigers <support@presstigers.com>
 */

Class Simple_Event_Planner_Ajax {

    /**
     * Initialize the class and set its properties.
     * 
     * @since   1.1.0
     */
    public function __construct() {

        // Hook -> Ajax Call -> Saving Event's Settings
        add_action('wp_ajax_nopriv_sep_event_option_save', array($this, 'sep_event_option_save'));
        add_action('wp_ajax_sep_event_option_save', array(&$this, 'sep_event_option_save'));

        // Hook -> Ajax Call -> Search Events on Calendar Search Box
        add_action('wp_ajax_nopriv_sep_search_events', array($this, 'sep_search_events'));
        add_action('wp_ajax_sep_search_events', array($this, 'sep_search_events'));
    }

    /**
     * Saving Color Values into Wp Options 
     * 
     * @since    1.1.0
     * 
     * @global   array $_POST typography colors for event calendar & listing.
     * 
     * return    void
     */
    public function sep_event_option_save() {

        // Checking nonce
        check_ajax_referer('sep_security_nonce', 'sep_nonce');

        // Make sure $_POST are set before
        $setting_options = isset( $_POST ) ? array_map( 'sanitize_text_field', wp_unslash( (array) $_POST ) ) : array(); // phpcs.ignore - Sanitized on line 57
        $visual_options = isset( $_POST['sep_visual_layout'] ) ? array_map( 'sanitize_text_field', wp_unslash( (array) $_POST['sep_visual_layout'] ) ) : array(); // phpcs.ignore - Sanitized on line 57

        // Save Settings Options
        update_option( 'sep_visual_layout', $visual_options ); // phpcs.ignore - Sanitized on line 53
        update_option( 'sep_event_options', $setting_options ); // phpcs.ignore - Sanitized on line 54
    }

    /**
     * Search Events on Calendar Search Box 
     *
     * @since   1.0.0
     * 
     * @global  array $_POST  containing event address indexes.
     * 
     * @return  void 
     */
    public function sep_search_events() {
        
        //Checking Nonce
        check_ajax_referer('sep_cal_security_nonce', 'security');
        $obj = new Simple_Event_Planner_Shortcode_Event_Calendar();
        $_POST['events_limit'] = '-1';
        $event_calendar = $obj->sep_calendar_output( $_POST );
        echo $event_calendar; // phpcs.ignore - it's a JSON String
        wp_die();
    }

}

new Simple_Event_Planner_Ajax();