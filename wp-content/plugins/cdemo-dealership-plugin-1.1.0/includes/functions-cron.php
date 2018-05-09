<?php
/**
 * Functions for handling WordPress cron.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;


// Schedule cron hooks
add_action( 'init', 'cdemo\schedule_cron_hooks' );


/**
 * Schedule custom cron hooks.
 *
 * @since 1.0.0
 * @return void
 */
function schedule_cron_hooks() {

    if ( !wp_next_scheduled( 'cdemo_data_driver_sync' ) ) {
        wp_schedule_event( time(), 'hourly', 'cdemo_data_driver_sync' );
    }

}


/**
 * Clear custom cron hooks.
 *
 * @since 1.0.0
 * @return void
 */
function clear_cron_hooks() {

    wp_clear_scheduled_hook( 'cdemo_data_driver_sync' );

}