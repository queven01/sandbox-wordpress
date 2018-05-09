<?php
/**
 * Functions for managing data driver sync.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;


// Start sync on cron hook
add_action( 'cdemo_data_driver_sync', 'cdemo\start_sync' );

// Register recipes
add_action( 'cdemo_loaded', 'cdemo\register_sync_recipes' );


/**
 * Register default sync recipes.
 *
 * @action cdemo_loaded
 *
 * @since 1.0.0
 * @return void
 */
function register_sync_recipes() {
    register_sync_recipe( 1001, 'cdemo\sync_automobile' );
    register_sync_recipe( 1009, 'cdemo\sync_motorcycle' );
    register_sync_recipe( 1064, 'cdemo\sync_snowmobile' );
    register_sync_recipe( 1060, 'cdemo\sync_atv' );
    register_sync_recipe( 1061, 'cdemo\sync_camper' );
    register_sync_recipe( 1029, 'cdemo\sync_boat' );
    register_sync_recipe( 1063, 'cdemo\sync_trailer' );
}


/**
 * Register a recipe to be executed when a Data Driver record is synced.
 *
 * @param int      $product_id The cDemo product ID.
 * @param callable $handler    A callback function to handle the record.
 *
 * @since 1.0.0
 * @return void
 */
function register_sync_recipe( $product_id, callable $handler ) {

    $cdemo   = cdemo();
    $recipes = $cdemo->get( 'sync_recipes', array() );

    if ( !isset( $recipes[ $product_id ] ) ) {
        $recipe = array(
            'handler' => $handler
        );

        $recipes[ $product_id ] = $recipe;
    }

    $cdemo->set( 'sync_recipes', $recipes );

}


/**
 * Helper to get the sync service.
 *
 * @since 1.0.0
 * @return Singleton|SyncService
 */
function get_sync_instance() {
    return SyncService::instance();
}


/**
 * Check to see if data driver sync is enabled.
 *
 * @since 1.0.0
 * @return bool
 */
function sync_enabled() {
    return !!get_option( Options::DATA_DRIVER_KEY );
}


/**
 * Try to start a sync operation.
 *
 * @action cdemo_data_driver_sync
 *
 * @since 1.0.0
 * @return void
 */
function start_sync() {

    if ( !is_sync_paused() ) {
        get_sync_instance()->start();
    }

}


/**
 * Check to see if the sync operation is paused.
 *
 * @since 1.0.0
 * @return bool
 */
function is_sync_paused() {
    return get_sync_instance()->is_paused();
}


/**
 * Get the sync recipe for a cDemo product ID.
 *
 * @param int $id
 *
 * @since 1.0.0
 * @return false|string
 */
function get_sync_recipe( $id ) {

    $recipes = cdemo()->get( 'sync_recipes' );

    if ( $recipes && isset( $recipes[ $id ] ) ) {
        return $recipes[ $id ];
    }

    return false;

}


/**
 * Sync a cDemo from the Data Driver API record with a WordPress post.
 *
 * @param array $record
 *
 * @since 1.0.0
 * @return false|mixed
 */
function sync_record( $record ) {

    if ( !pluck( $record, 'staging_flag' ) ) {
        $post_id = false;
        $listing = get_listing_by_cdemo_id( pluck( $record, 'inspection_id' ) );

        if ( $listing ) {
            $post_id = $listing->ID;
        }

        if ( !empty( $record['product'] ) ) {
            $recipe = get_sync_recipe( $record['product']['id'] );

            if ( $recipe ) {
                return call_user_func( $recipe['handler'], $post_id, $record );
            }

        }

    }

    return false;

}

/**
 * Add handler for syncing trailer records
 *
 * @param int|false $id
 * @param array     $record
 *
 * @internal
 * @since 1.1.0
 * @return int|\WP_Error
 */
function sync_trailer( $id, $record ) {
    $detail = pluck( $record, 'detail' );

    $post_data = array(
        'ID' => $id,
        'post_type'    => 'trailer',
        'post_status'  => 'publish',
        'post_title'   => pluck( $record, 'title' ),
        'post_content' => pluck( $record, 'listing_comment', '' ),
        'meta_input'   => array(

            // Link with cDemo Record
            'cdemo_record_id'         => pluck( $record, 'inspection_id' ),

            // Pulled from record details
            'serial_number'           => pluck( $detail, 'serial_number' ),
            'make'                    => pluck( $detail, 'make' ),
            'model'                   => pluck( $detail, 'model' ),
            'year_manufactured'       => pluck( $detail, 'year' ),
            'length'                  => pluck( $detail, 'length' ),
            'hitch_type'              => pluck( $detail, 'hitch_type' ),
            'deck_type'               => pluck( $detail, 'deck_type' ),
            'exterior_color'          => pluck( $detail, 'primary_color' ),
            'number_of_axles'         => pluck( $detail, 'axle_count' ),

            // Condition
            'condition'               => _sync_condition( $record ),

            // Pricing fields
            'listing_currency'        => strtolower( pluck( $record, 'listing_currency', '' ) ),
            'listing_price'           => pluck( $record, 'listing_price' ),
            'sale_price'              => pluck( $record, 'sale_price' ),
            'msrp'                    => pluck( $record, 'msrp' ),
            'sale_price_start_dt'     => _sync_format_date( pluck( $record, 'sale_price_start_dt' ) ),
            'sale_price_end_dt'       => _sync_format_date( pluck( $record, 'sale_price_end_dt'   ) ),

            // Financing fields
            'weekly_finance_price'    => pluck( $record, 'weekly_finance_price' ),
            'bi_weekly_finance_price' => pluck( $record, 'bi_weekly_finance_price' ),
            'monthly_finance_price'   => pluck( $record, 'monthly_finance_price' ),
            'down_payment'            => pluck( $record, 'down_payment' ),
            'monthly_period'          => pluck( $record, 'monthly_period' ),
            'percent_apr'             => pluck( $record, 'percent_apr' ),
            'financing_disclaimer'    => pluck( $record, 'financing_comment' ),

            // Media
            'media'                   => _sync_record_media( $record )
        )
    );

    $id = wp_insert_post( $post_data );
    _sync_record_featured_image( $id, $record );

    return $id;
}

/**
 * Add handler for syncing boat records
 *
 * @param int|false $id
 * @param array     $record
 *
 * @internal
 * @since 1.1.0
 * @return int|\WP_Error
 */
function sync_boat( $id, $record ) {
    $detail = pluck( $record, 'detail' );

    $post_data = array(
        'ID' => $id,
        'post_type'    => 'boat',
        'post_status'  => 'publish',
        'post_title'   => pluck( $record, 'title' ),
        'post_content' => pluck( $record, 'listing_comment', '' ),
        'meta_input'   => array(

            // Link with cDemo Record
            'cdemo_record_id'         => pluck( $record, 'inspection_id' ),

            // Pulled from record details
            'serial_number'           => pluck( $detail, 'serial_number' ),
            'make'                    => pluck( $detail, 'make' ),
            'model'                   => pluck( $detail, 'model' ),
            'year_manufactured'       => pluck( $detail, 'year' ),
            'hull_shape'              => pluck( $detail, 'hull_shape' ),
            'length'                  => pluck( $detail, 'length' ),
            'propulsion_type'         => pluck( $detail, 'propulsion_type' ),

            // Condition
            'condition'               => _sync_condition( $record ),

            // Pricing fields
            'listing_currency'        => strtolower( pluck( $record, 'listing_currency', '' ) ),
            'listing_price'           => pluck( $record, 'listing_price' ),
            'sale_price'              => pluck( $record, 'sale_price' ),
            'msrp'                    => pluck( $record, 'msrp' ),
            'sale_price_start_dt'     => _sync_format_date( pluck( $record, 'sale_price_start_dt' ) ),
            'sale_price_end_dt'       => _sync_format_date( pluck( $record, 'sale_price_end_dt'   ) ),

            // Financing fields
            'weekly_finance_price'    => pluck( $record, 'weekly_finance_price' ),
            'bi_weekly_finance_price' => pluck( $record, 'bi_weekly_finance_price' ),
            'monthly_finance_price'   => pluck( $record, 'monthly_finance_price' ),
            'down_payment'            => pluck( $record, 'down_payment' ),
            'monthly_period'          => pluck( $record, 'monthly_period' ),
            'percent_apr'             => pluck( $record, 'percent_apr' ),
            'financing_disclaimer'    => pluck( $record, 'financing_comment' ),

            // Media
            'media'                   => _sync_record_media( $record )
        )
    );

    $id = wp_insert_post( $post_data );
    _sync_record_featured_image( $id, $record );

    return $id;
}


/**
 * Handler for syncing camper records
 *
 * @param int|false $id
 * @param array     $record
 *
 * @internal
 * @since 1.1.0
 * @return int|\WP_Error
 */
function sync_camper( $id, $record ) {
    $detail = pluck( $record, 'detail' );

    $post_data = array(
        'ID' => $id,
        'post_type'    => 'camper',
        'post_status'  => 'publish',
        'post_title'   => pluck( $record, 'title' ),
        'post_content' => pluck( $record, 'listing_comment', '' ),
        'meta_input'   => array(

            // Link with cDemo Record
            'cdemo_record_id'         => pluck( $record, 'inspection_id' ),

            // Pulled from record details
            'serial_number'           => pluck( $detail, 'serial_number' ),
            'make'                    => pluck( $detail, 'make' ),
            'model'                   => pluck( $detail, 'model' ),
            'year_manufactured'       => pluck( $detail, 'year' ),
            'exterior_color'          => pluck( $detail, 'primary_colour' ),
            'length'                  => pluck( $detail, 'length' ),
            'axle_count'              => pluck( $detail, 'number_of_axles' ),
            'sleeping_capacity'       => pluck( $detail, 'sleeping_capacity' ),
            'pushout_count'           => pluck( $detail, 'number_of_push_outs' ),

            // Condition
            'condition'               => _sync_condition( $record ),

            // Pricing fields
            'listing_currency'        => strtolower( pluck( $record, 'listing_currency', '' ) ),
            'listing_price'           => pluck( $record, 'listing_price' ),
            'sale_price'              => pluck( $record, 'sale_price' ),
            'msrp'                    => pluck( $record, 'msrp' ),
            'sale_price_start_dt'     => _sync_format_date( pluck( $record, 'sale_price_start_dt' ) ),
            'sale_price_end_dt'       => _sync_format_date( pluck( $record, 'sale_price_end_dt'   ) ),

            // Financing fields
            'weekly_finance_price'    => pluck( $record, 'weekly_finance_price' ),
            'bi_weekly_finance_price' => pluck( $record, 'bi_weekly_finance_price' ),
            'monthly_finance_price'   => pluck( $record, 'monthly_finance_price' ),
            'down_payment'            => pluck( $record, 'down_payment' ),
            'monthly_period'          => pluck( $record, 'monthly_period' ),
            'percent_apr'             => pluck( $record, 'percent_apr' ),
            'financing_disclaimer'    => pluck( $record, 'financing_comment' ),

            // Media
            'media'                   => _sync_record_media( $record )
        )
    );

    $id = wp_insert_post( $post_data );
    _sync_record_featured_image( $id, $record );

    return $id;
}


/**
 * Handler for syncing snowmobile records.
 *
 * @param int|false $id
 * @param array     $record
 *
 * @internal
 * @since 1.0.0
 * @return int|\WP_Error
 */
function sync_snowmobile( $id, $record ) {
    $detail = pluck( $record, 'detail' );

    $post_data = array(
        'ID' => $id,
        'post_type'    => 'snowmobile',
        'post_status'  => 'publish',
        'post_title'   => pluck( $record, 'title' ),
        'post_content' => pluck( $record, 'listing_comment', '' ),
        'meta_input'   => array(

            // Link with cDemo Record
            'cdemo_record_id'         => pluck( $record, 'inspection_id' ),

            // Pulled from record details
            'serial_number'           => pluck( $detail, 'serial_number' ),
            'make'                    => pluck( $detail, 'make' ),
            'model'                   => pluck( $detail, 'model' ),
            'year_manufactured'       => pluck( $detail, 'year' ),
            'engine_disp'             => pluck( $detail, 'engine' ),
            'exterior_color'          => pluck( $detail, 'primary_colour' ),
            'odometer_reading'        => pluck( $detail, 'odometer_reading' ),
            'track_length'            => pluck( $detail, 'track_length' ),

            // Record style
            'body_type'               => pluck( pluck( $record, 'style' ), 'description' ),

            // Condition
            'condition'               => _sync_condition( $record ),

            // Pricing fields
            'listing_currency'        => strtolower( pluck( $record, 'listing_currency', '' ) ),
            'listing_price'           => pluck( $record, 'listing_price' ),
            'sale_price'              => pluck( $record, 'sale_price' ),
            'msrp'                    => pluck( $record, 'msrp' ),
            'sale_price_start_dt'     => _sync_format_date( pluck( $record, 'sale_price_start_dt' ) ),
            'sale_price_end_dt'       => _sync_format_date( pluck( $record, 'sale_price_end_dt'   ) ),

            // Financing fields
            'weekly_finance_price'    => pluck( $record, 'weekly_finance_price' ),
            'bi_weekly_finance_price' => pluck( $record, 'bi_weekly_finance_price' ),
            'monthly_finance_price'   => pluck( $record, 'monthly_finance_price' ),
            'down_payment'            => pluck( $record, 'down_payment' ),
            'monthly_period'          => pluck( $record, 'monthly_period' ),
            'percent_apr'             => pluck( $record, 'percent_apr' ),
            'financing_disclaimer'    => pluck( $record, 'financing_comment' ),

            // Media
            'media'                   => _sync_record_media( $record )
        )
    );

    $id = wp_insert_post( $post_data );
    _sync_record_featured_image( $id, $record );

    return $id;
}


/**
 * Handler for syncing automobile records.
 *
 * @param int|false $id
 * @param array     $record
 *
 * @internal
 * @since 1.0.0
 * @return int|\WP_Error
 */
function sync_automobile( $id, $record ) {

    $detail = pluck( $record, 'detail' );

    $post_data = array(
        'ID' => $id,
        'post_type'    => 'automobile',
        'post_status'  => 'publish',
        'post_title'   => pluck( $record, 'title' ),
        'post_content' => pluck( $record, 'listing_comment', '' ),
        'meta_input'   => array(

            // Link with cDemo Record
            'cdemo_record_id'         => pluck( $record, 'inspection_id' ),

            // Pulled from record details
            'vin'                     => pluck( $detail, 'vin' ),
            'make'                    => pluck( $detail, 'make' ),
            'model'                   => pluck( $detail, 'model' ),
            'trim_level'              => pluck( $detail, 'trim_level' ),
            'number_passenger_doors'  => pluck( $detail, 'number_passenger_doors' ),
            'seating_capacity'        => pluck( $detail, 'seating_capacity' ),
            'year_manufactured'       => pluck( $detail, 'year_manufactured' ),
            'engine'                  => pluck( $detail, 'engine' ),
            'engine_disp'             => pluck( $detail, 'engine_disp' ),
            'cylinders'               => pluck( $detail, 'cylinders' ),
            'horse_power'             => pluck( $detail, 'horse_power' ),
            'drivetrain'              => pluck( $detail, 'drivetrain' ),
            'transmission'            => pluck( $detail, 'transmission' ),
            'odometer_reading'        => pluck( $detail, 'odometer_reading' ),
            'interior_color'          => pluck( $detail, 'interior_colour' ),
            'exterior_color'          => pluck( $detail, 'exterior_colour' ),
            'fuel_type'               => pluck( $detail, 'fuel_type' ),
            'fuel_economy_unit'       => _sync_fuel_economy_unit( pluck( $detail, 'fuel_economy_unit' ) ),

            // Record style
            'body_type'               => pluck( pluck( $record, 'style' ), 'description' ),

            // Condition
            'condition'               => _sync_condition( $record ),

            // Pricing fields
            'listing_currency'        => strtolower( pluck( $record, 'listing_currency', '' ) ),
            'listing_price'           => pluck( $record, 'listing_price' ),
            'sale_price'              => pluck( $record, 'sale_price' ),
            'msrp'                    => pluck( $record, 'msrp' ),
            'sale_price_start_dt'     => _sync_format_date( pluck( $record, 'sale_price_start_dt' ) ),
            'sale_price_end_dt'       => _sync_format_date( pluck( $record, 'sale_price_end_dt'   ) ),

            // Financing fields
            'weekly_finance_price'    => pluck( $record, 'weekly_finance_price' ),
            'bi_weekly_finance_price' => pluck( $record, 'bi_weekly_finance_price' ),
            'monthly_finance_price'   => pluck( $record, 'monthly_finance_price' ),
            'down_payment'            => pluck( $record, 'down_payment' ),
            'monthly_period'          => pluck( $record, 'monthly_period' ),
            'percent_apr'             => pluck( $record, 'percent_apr' ),
            'financing_disclaimer'    => pluck( $record, 'financing_comment' ),

            // Media
            'media'                   => _sync_record_media( $record )
        )
    );

    $id = wp_insert_post( $post_data );

    _sync_fuel_economy( $id, $record );
    _sync_record_featured_image( $id, $record );

    return $id;

}


/**
 * Handler for syncing motorcycle records.
 *
 * @param int|false $id
 * @param array     $record
 *
 * @internal
 * @since 1.0.0
 * @return int|\WP_Error
 */
function sync_motorcycle( $id, $record ) {

    $detail = pluck( $record, 'detail' );

    $post_data = array(
        'ID' => $id,
        'post_type'    => 'motorcycle',
        'post_status'  => 'publish',
        'post_title'   => pluck( $record, 'title' ),
        'post_content' => pluck( $record, 'listing_comment', '' ),
        'meta_input'   => array(

            // Link with cDemo Record
            'cdemo_record_id'         => pluck( $record, 'inspection_id' ),

            // Pulled from record details
            'vin'                     => pluck( $detail, 'vin' ),
            'make'                    => pluck( $detail, 'make' ),
            'model'                   => pluck( $detail, 'model' ),
            'trim_level'              => pluck( $detail, 'trim_level' ),
            'year_manufactured'       => pluck( $detail, 'year_manufactured' ),
            'engine'                  => pluck( $detail, 'engine' ),
            'engine_disp'             => pluck( $detail, 'engine_disp' ),
            'cylinders'               => pluck( $detail, 'cylinders' ),
            'horse_power'             => pluck( $detail, 'horse_power' ),
            'transmission'            => pluck( $detail, 'transmission' ),
            'odometer_reading'        => pluck( $detail, 'odometer_reading' ),
            'exterior_color'          => pluck( $detail, 'exterior_colour' ),
            'fuel_type'               => pluck( $detail, 'fuel_type' ),
            'fuel_economy_unit'       => _sync_fuel_economy_unit( pluck( $detail, 'fuel_economy_unit' ) ),

            // Record style
            'body_type'               => pluck( pluck( $record, 'style' ), 'description' ),

            // Condition
            'condition'               => _sync_condition( $record ),

            // Pricing fields
            'listing_currency'        => strtolower( pluck( $record, 'listing_currency', '' ) ),
            'listing_price'           => pluck( $record, 'listing_price' ),
            'sale_price'              => pluck( $record, 'sale_price' ),
            'msrp'                    => pluck( $record, 'msrp' ),
            'sale_price_start_dt'     => _sync_format_date( pluck( $record, 'sale_price_start_dt' ) ),
            'sale_price_end_dt'       => _sync_format_date( pluck( $record, 'sale_price_end_dt'   ) ),

            // Financing fields
            'weekly_finance_price'    => pluck( $record, 'weekly_finance_price' ),
            'bi_weekly_finance_price' => pluck( $record, 'bi_weekly_finance_price' ),
            'monthly_finance_price'   => pluck( $record, 'monthly_finance_price' ),
            'down_payment'            => pluck( $record, 'down_payment' ),
            'monthly_period'          => pluck( $record, 'monthly_period' ),
            'percent_apr'             => pluck( $record, 'percent_apr' ),
            'financing_disclaimer'    => pluck( $record, 'financing_comment' ),

            // Media
            'media'                   => _sync_record_media( $record )
        )
    );

    $id = wp_insert_post( $post_data );

    _sync_fuel_economy( $id, $record );
    _sync_record_featured_image( $id, $record );

    return $id;

}


/**
 * Handler for syncing atv records.
 *
 * @param int|false $id
 * @param array     $record
 *
 * @internal
 * @since 1.0.0
 * @return int|\WP_Error
 */
function sync_atv( $id, $record ) {

    $detail = pluck( $record, 'detail' );

    $post_data = array(
        'ID' => $id,
        'post_type'    => 'atv',
        'post_status'  => 'publish',
        'post_title'   => pluck( $record, 'title' ),
        'post_content' => pluck( $record, 'listing_comment', '' ),
        'meta_input'   => array(

            // Link with cDemo Record
            'cdemo_record_id'         => pluck( $record, 'inspection_id' ),

            // Pulled from record details
            'serial_number'           => pluck( $detail, 'serial_number' ),
            'make'                    => pluck( $detail, 'make' ),
            'model'                   => pluck( $detail, 'model' ),
            'engine'                  => pluck( $detail, 'engine' ),
            'year_manufactured'       => pluck( $detail, 'year' ),
            'exterior_color'          => pluck( $detail, 'primary_colour' ),
            'odometer_reading'        => pluck( $detail, 'odometer_reading' ),

            // Record style
            'body_type'               => pluck( pluck( $record, 'style' ), 'description' ),

            // Condition
            'condition'               => _sync_condition( $record ),

            // Pricing fields
            'listing_currency'        => strtolower( pluck( $record, 'listing_currency', '' ) ),
            'listing_price'           => pluck( $record, 'listing_price' ),
            'sale_price'              => pluck( $record, 'sale_price' ),
            'msrp'                    => pluck( $record, 'msrp' ),
            'sale_price_start_dt'     => _sync_format_date( pluck( $record, 'sale_price_start_dt' ) ),
            'sale_price_end_dt'       => _sync_format_date( pluck( $record, 'sale_price_end_dt'   ) ),

            // Financing fields
            'weekly_finance_price'    => pluck( $record, 'weekly_finance_price' ),
            'bi_weekly_finance_price' => pluck( $record, 'bi_weekly_finance_price' ),
            'monthly_finance_price'   => pluck( $record, 'monthly_finance_price' ),
            'down_payment'            => pluck( $record, 'down_payment' ),
            'monthly_period'          => pluck( $record, 'monthly_period' ),
            'percent_apr'             => pluck( $record, 'percent_apr' ),
            'financing_disclaimer'    => pluck( $record, 'financing_comment' ),

            // Media
            'media'                   => _sync_record_media( $record )
        )
    );

    return wp_insert_post( $post_data );

}

/***********************************************************************************************************************
 *
 * Sync Helper functions.
 *
 * @internal
 * @since 1.0.0
 */

/**
 * Get the value for listing fuel economy units.
 *
 * @param string $data
 *
 * @internal
 * @since 1.0.0
 * @return string
 */
function _sync_fuel_economy_unit( $data ) {

    if ( strtolower( $data ) === 'mpg' ) {
        return 'imperial';
    }

    return 'metric';

}


/**
 * Sync media URLs from a cDemo Record.
 *
 * @param $record
 *
 * @internal
 * @since 1.0.0
 * @return array
 */
function _sync_record_media( $record ) {

    $photos = array();

    // Loop through each inspection point with a photo flag
    foreach ( pluck( $record, 'inspection_points', array() ) as $inspection_point ) {

        if ( pluck( $inspection_point, 'photo_point_flag' ) ) {
            $photo = pluck( $inspection_point, 'photo_url' );

            if ( !empty( $photo ) ) {
                array_push( $photos, $photo );
            }

        }

    }

    return $photos;

}


/**
 * Download and assign the featured image from a cDemo Record.
 *
 * @param $id
 * @param $record
 *
 * @internal
 * @since 1.0.0
 * @return bool|int
 */
function _sync_record_featured_image( $id, $record ) {

    if ( !is_wp_error( $id ) ) {
        require_once( ABSPATH . 'wp-admin/includes/media.php' );
        require_once( ABSPATH . 'wp-admin/includes/file.php'  );
        require_once( ABSPATH . 'wp-admin/includes/image.php' );

        $attachment = media_sideload_image( pluck( $record, 'primary_photo_url' ), $id, '', 'id' );

        if ( !is_wp_error( $attachment ) ) {
            return set_post_thumbnail( $id, $attachment );
        }

    }

    return false;

}


/**
 * Get the condition from a cDemo record.
 *
 * @param $record
 *
 * @internal
 * @since 1.0.0
 * @return bool|string
 */
function _sync_condition( $record ) {

    $detail = pluck( $record, 'detail' );

    if ( strtolower( pluck( $detail, 'certified_program_flag' ) ) === 'yes' ) {
       return 'certified_pre-owned';
    } else {
        $condition = pluck( $record, 'item_condition', array() );
        $cond_id   = pluck( $condition, 'id' );

        if ( $cond_id === 1 ) {
            return 'new';
        } else if ( $cond_id === 2 ) {
            return 'used';
        }

    }

    return false;

}


/**
 * Format record UTC date as MySQL GMT date.
 *
 * @param $date
 *
 * @internal
 * @since 1.0.0
 * @return string|false
 */
function _sync_format_date( $date ) {

    $time = strtotime( $date );

    if ( $time ) {
        return date( 'Y-m-d', $time );
    }

    return false;

}


/**
 * Split up fuel economy range and insert it as meta.
 *
 * @param $post_id
 * @param $record
 *
 * @internal
 * @since 1.0.0
 * @return void
 */
function _sync_fuel_economy( $post_id, $record ) {

    $detail = pluck( $record, 'detail' );

    $data = array(
        'fuel_economy_city' => pluck( $detail, 'fuel_economy_city', '' ),
        'fuel_economy_hwy'  => pluck( $detail, 'fuel_economy_hwy',  '' )
    );

    foreach ( $data as $key => $value ) {
        update_meta_array( $post_id, $key, explode( ' - ', $value ) );
    }

}
