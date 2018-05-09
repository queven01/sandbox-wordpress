<?php
/**
 * Functions for handling post metadata.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;


// Register metadata for listing post types
add_action( 'init', 'cdemo\_register_meta_fields' );

// Check if a meta field can be updated before saving
add_action( 'update_post_metadata', 'cdemo\check_meta_lock', 10, 3 );


/**
 * Register a post meta field.
 *
 * @param string $type
 * @param string $meta_key
 * @param array  $args {
 *      Data used to describe the meta key when registered.
 *
 *      @type bool     $single            Whether the meta key has one value per object, or an array of values per object.
 *      @type bool     $lockable          Whether the meta field is lockable and can prevent updates.
 *      @type callable $sanitize_callback The callback to sanitize the field when saving to the database.
 * }
 *
 * @since 1.0.0
 * @return bool
 */
function register_post_meta( $type, $meta_key, $args = array() ) {

    $fields = get_registered_meta();

    $defaults = array(
        'single'   => true,
        'lockable' => false,
        'sanitize_callback' => 'cdemo\sanitize',
    );

    $args = wp_parse_args( $args, $defaults );

    if ( empty( $fields[ $type ] ) ) {
        $fields[ $type ] = array();
    }

    if ( !in_array( $meta_key, $fields[ $type ] ) ) {
        $fields[ $type ][ $meta_key ] = $args;

        // Add the sanitize callback only for posts of this type
        add_filter( "sanitize_post_meta_{$meta_key}", function ( $value ) use ( $args,  $fields, $type ) {

            if ( in_array( $type, $fields ) ) {
                return call_user_func_array( $args['sanitize_callback'], $value );
            }

            return $value;

        } );

        _set_registered_meta( $fields );

        return true;

    }

    return false;

}


/**
 * Update non unique meta key arrays.
 *
 * @param $post
 * @param $key
 * @param $data
 *
 * @since 1.0.0
 * @return bool
 */
function update_meta_array( $post, $key, $data ) {

    $post = get_post( $post );

    if ( $post && !is_meta_locked( $post, $key ) ) {
        $fields = get_registered_meta( $post->post_type );

        // Make sure the meta is not single
        if ( isset( $fields[ $key ] ) && !$fields[ $key ]['single'] ) {
            delete_post_meta( $post->ID, $key );

            foreach ( $data as $value ) {
                add_post_meta( $post->ID, $key, $value );
            }

        }

    }

    return false;

}


/**
 * Check to see if a meta field has been registered as lockable.
 *
 * @param $post_or_type
 * @param $field
 *
 * @since 1.0.0
 * @return bool
 */
function is_meta_field_lockable( $post_or_type, $field ) {
    $type = false;

    if ( is_string( $post_or_type ) ) {
        $type = $post_or_type;
    } else {
        $post = get_post( $post_or_type );

        if ( $post ) {
            $type = $post->post_type;
        }

    }

    if ( $type ) {
        $fields = get_registered_meta( $type );

        if ( $fields && array_key_exists( $field, $fields ) ) {
            return $fields[ $field ]['lockable'];
        }

    }

    return false;

}


/**
 * Check to see if a meta field is locked.
 *
 * @param $post
 * @param $key
 *
 * @since 1.0.0
 * @return bool
 */
function is_meta_locked( $post, $key ) {

    $post = get_post( $post );

    if ( $post && is_meta_field_lockable( $post, $key ) ) {
        return (bool) get_post_meta( $post->ID, "{$key}_locked", true );
    }

    return false;

}


/**
 * Set the lock field for a meta field.
 *
 * @param \WP_Post|int $post
 * @param string       $key
 * @param bool         $locked
 *
 * @since 1.0.0
 * @return bool|int
 */
function set_meta_lock( $post, $key, $locked ) {

    $post = get_post( $post );

    if ( $post && is_meta_field_lockable( $post, $key ) ) {
        return update_post_meta( $post->ID, "{$key}_locked", $locked );
    }

    return false;

}


/**
 * Lock a meta field to prevent updates.
 *
 * @param \WP_Post|int $listing
 * @param string       $key
 *
 * @since 1.0.0
 * @return bool|int
 */
function lock_meta_field( $listing, $key ) {
    return set_meta_lock( $listing, $key, true );
}


/**
 * Unlock a meta field to allow updates.
 *
 * @param \WP_Post|int $listing
 * @param string       $key
 *
 * @since 1.0.0
 * @return bool|int
 */
function unlock_meta_field( $listing, $key ) {
    return set_meta_lock( $listing, $key, false );
}


/**
 * Check if a meta field is locked before updating.
 *
 * @action update_post_metadata
 *
 * @param null|bool $allow
 * @param int       $post_id
 * @param string    $meta_key
 *
 * @since 1.0.0
 * @return null|true
 */
function check_meta_lock( $allow, $post_id, $meta_key ) {
    $obj = get_post( $post_id );

    if ( $obj ) {

        if ( is_meta_field_lockable( $post_id, $meta_key ) ) {
            $allow = is_meta_locked( $obj, $meta_key ) ? false : $allow;
        }

    }

    return $allow;

}


/**
 * Get registered meta fields.
 *
 * @param string $type
 *
 * @since 1.0.0
 * @return array|false
 */
function get_registered_meta( $type = '' ) {
    $fields = cdemo()->get( 'meta_fields', array() );

    if ( !empty( $type ) ) {

        if ( array_key_exists( $type, $fields ) ) {
            return $fields[ $type ];
        }

        return false;

    }

    return $fields;

}


/**
 * Helper for get_post_meta that works in the loop.
 *
 * @param string            $key
 * @param bool              $single
 * @param null|int|\WP_Post $post
 * @param mixed             $default
 *
 * @since 1.0.0
 * @return bool|mixed
 */
function get_metadata( $key, $single = true, $post = null, $default = false ) {

    $post = get_post( $post );

    if ( $post ) {
        return get_post_meta( $post->ID, $key, $single );
    }

    return $default;

}


/**
 * Set registered meta fields.
 *
 * @param array $fields
 *
 * @internal
 * @since 1.0.0
 * @return void
 */
function _set_registered_meta( array $fields ) {
    cdemo()->set( 'meta_fields', $fields );
}


/**
 * Register default metadata fields.
 *
 * @action init
 *
 * @internal
 * @since 1.0.0
 * @return void
 */
function _register_meta_fields() {
    _register_default_meta_lead();
    _register_default_meta_automobile();
    _register_default_meta_motorcycle();
    _register_default_meta_snowmobile();
    _register_default_metadata_camper();
    _register_default_metadata_boat();
    _register_default_meta_atv();
    _register_default_metadata_trailer();
}

/**
 * Register default meta for trailer listings
 *
 * @internal
 * @since 1.1.0
 * @return void
 */
function _register_default_metadata_trailer() {
    register_post_meta( 'trailer', 'serial_number', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'trailer', 'stocknumber', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'trailer', 'condition', array(
        'lockable' => true,
        'sanitize_callback' => 'cdemo\sanitize_condition'
    ) );

    register_post_meta( 'trailer', 'year_manufactured', array(
        'lockable' => true,
        'sanitize_callback' => 'absint'
    ) );

    register_post_meta( 'trailer', 'make', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'trailer', 'model', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'trailer', 'length', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'trailer', 'deck_type', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'trailer', 'hitch_type', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'trailer', 'axle_count', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'trailer', 'exterior_color', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    _register_common_meta_for_listing_type( 'trailer' );
}


/**
 * Register default meta for boat listings
 *
 * @internal
 * @since 1.1.0
 * @return void
 */
function _register_default_metadata_boat() {
    register_post_meta( 'boat', 'serial_number', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'boat', 'stocknumber', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'boat', 'condition', array(
        'lockable' => true,
        'sanitize_callback' => 'cdemo\sanitize_condition'
    ) );

    register_post_meta( 'boat', 'year_manufactured', array(
        'lockable' => true,
        'sanitize_callback' => 'absint'
    ) );

    register_post_meta( 'boat', 'make', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'boat', 'model', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'boat', 'length', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'boat', 'hull_shape', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'boat', 'propulsion_type', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    _register_common_meta_for_listing_type( 'boat' );
}


/**
 * Register default meta for Camper/RV listings.
 *
 * @since 1.1.0
 * @return void
 */
function _register_default_metadata_camper() {
    register_post_meta( 'camper', 'serial_number', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'camper', 'stocknumber', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'camper', 'condition', array(
        'lockable' => true,
        'sanitize_callback' => 'cdemo\sanitize_condition'
    ) );

    register_post_meta( 'camper', 'year_manufactured', array(
        'lockable' => true,
        'sanitize_callback' => 'absint'
    ) );

    register_post_meta( 'camper', 'make', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'camper', 'model', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'camper', 'exterior_color', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'camper', 'sleeping_capacity', array(
        'lockable' => true,
        'sanitize_callback' => 'absint'
    ) );

    register_post_meta( 'camper', 'axle_count', array(
        'lockable' => true,
        'sanitize_callback' => 'absint'
    ) );

    register_post_meta( 'camper', 'pushout_count', array(
        'lockable' => true,
        'sanitize_callback' => 'absint'
    ) );

    register_post_meta( 'camper', 'length', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    _register_common_meta_for_listing_type( 'camper' );
}


/**
 * Register default meta for atv listings.
 *
 * @internal
 * @since 1.0.0
 * @return void
 */
function _register_default_meta_atv() {

    register_post_meta( 'atv', 'serial_number', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'atv', 'stocknumber', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'atv', 'condition', array(
        'lockable' => true,
        'sanitize_callback' => 'cdemo\sanitize_condition'
    ) );

    register_post_meta( 'atv', 'year_manufactured', array(
        'lockable' => true,
        'sanitize_callback' => 'absint'
    ) );

    register_post_meta( 'atv', 'make', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'atv', 'model', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'atv', 'body_type', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'atv', 'odometer_reading', array(
        'lockable' => true,
        'sanitize_callback' => 'absint'
    ) );

    register_post_meta( 'atv', 'engine', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'atv', 'engine_disp', array(
        'lockable' => true,
        'sanitize_callback' => 'abs'
    ) );

    register_post_meta( 'atv', 'transmission', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'atv', 'drivetrain', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'atv', 'exterior_color', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );


    _register_common_meta_for_listing_type( 'atv' );

}

/**
 * Register default meta for snowmobile listings.
 *
 * @internal
 * @since 1.0.0
 * @return void
 */
function _register_default_meta_snowmobile() {

    register_post_meta( 'snowmobile', 'serial_number', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'snowmobile', 'stocknumber', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'snowmobile', 'condition', array(
        'lockable' => true,
        'sanitize_callback' => 'cdemo\sanitize_condition'
    ) );

    register_post_meta( 'snowmobile', 'year_manufactured', array(
        'lockable' => true,
        'sanitize_callback' => 'absint'
    ) );

    register_post_meta( 'snowmobile', 'make', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'snowmobile', 'model', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'snowmobile', 'body_type', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'snowmobile', 'odometer_reading', array(
        'lockable' => true,
        'sanitize_callback' => 'absint'
    ) );

    register_post_meta( 'snowmobile', 'engine', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'snowmobile', 'engine_disp', array(
        'lockable' => true,
        'sanitize_callback' => 'abs'
    ) );

    register_post_meta( 'snowmobile', 'exterior_color', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'snowmobile', 'track_length', array(
        'lockable' => true,
        'sanitize_callback' => 'abs'
    ) );

    register_post_meta( 'snowmobile', 'reverse_gear', array(
        'lockable' => true,
        'sanitize_callback' => 'cdemo\sanitize_checkbox'
    ) );

    register_post_meta( 'snowmobile', 'electric_start', array(
        'lockable' => true,
        'sanitize_callback' => 'cdemo\sanitize_checkbox'
    ) );

    register_post_meta( 'snowmobile', 'trim_level', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );


    _register_common_meta_for_listing_type( 'snowmobile' );

}


/**
 * Register default meta for motorcycle listings.
 *
 * @internal
 * @since 1.0.0
 * @return void
 */
function _register_default_meta_motorcycle() {

    register_post_meta( 'motorcycle', 'vin', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'motorcycle', 'stocknumber', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'motorcycle', 'condition', array(
        'lockable' => true,
        'sanitize_callback' => 'cdemo\sanitize_condition'
    ) );

    register_post_meta( 'motorcycle', 'year_manufactured', array(
        'lockable' => true,
        'sanitize_callback' => 'absint'
    ) );

    register_post_meta( 'motorcycle', 'make', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'motorcycle', 'model', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'motorcycle', 'trim_level', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'motorcycle', 'body_type', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'motorcycle', 'exterior_color', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'motorcycle', 'interior_color', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'motorcycle', 'odometer_reading', array(
        'lockable' => true,
        'sanitize_callback' => 'absint'
    ) );

    register_post_meta( 'motorcycle', 'engine', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'motorcycle', 'engine_disp', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'motorcycle', 'cylinders', array(
        'lockable' => true,
        'sanitize_callback' => 'absint'
    ) );

    register_post_meta( 'motorcycle', 'horse_power', array(
        'lockable' => true,
        'sanitize_callback' => 'abs'
    ) );

    register_post_meta( 'motorcycle', 'transmission', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'motorcycle', 'fuel_type', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'motorcycle', 'fuel_economy_unit', array(
        'lockable' => true,
        'sanitize_callback' => 'cdemo\sanitize_fuel_economy_unit'
    ) );

    register_post_meta( 'motorcycle', 'fuel_economy_city', array(
        'lockable' => true,
        'sanitize_callback' => 'abs'
    ) );

    register_post_meta( 'motorcycle', 'fuel_economy_hwy', array(
        'lockable' => true,
        'sanitize_callback' => 'abs'
    ) );


    _register_common_meta_for_listing_type( 'motorcycle' );

}


/**
 * Register default meta for the automobile listings.
 *
 * @internal
 * @since 1.0.0
 * @return void
 */
function _register_default_meta_automobile() {

    register_post_meta( 'automobile', 'vin', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'automobile', 'stocknumber', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'automobile', 'condition', array(
        'lockable' => true,
        'sanitize_callback' => 'cdemo\sanitize_condition'
    ) );

    register_post_meta( 'automobile', 'year_manufactured', array(
        'lockable' => true,
        'sanitize_callback' => 'absint'
    ) );

    register_post_meta( 'automobile', 'make', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'automobile', 'model', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'automobile', 'trim_level', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'automobile', 'body_type', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'automobile', 'interior_color', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'automobile', 'exterior_color', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'automobile', 'number_passenger_doors', array(
        'lockable' => true,
        'sanitize_callback' => 'absint'
    ) );

    register_post_meta( 'automobile', 'odometer_reading', array(
        'lockable' => true,
        'sanitize_callback' => 'absint'
    ) );

    register_post_meta( 'automobile', 'engine', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'automobile', 'cylinders', array(
        'lockable' => true,
        'sanitize_callback' => 'absint'
    ) );

    register_post_meta( 'automobile', 'seating_capacity', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'automobile', 'engine_disp', array(
        'lockable' => true,
        'sanitize_callback' => 'abs'
    ) );

    register_post_meta( 'automobile', 'horse_power', array(
        'lockable' => true,
        'sanitize_callback' => 'abs'
    ) );

    register_post_meta( 'automobile', 'drivetrain', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'automobile', 'transmission', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'automobile', 'fuel_type', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'automobile', 'fuel_economy_unit', array(
        'lockable' => true,
        'sanitize_callback' => 'cdemo\sanitize_fuel_economy_unit'
    ) );

    register_post_meta( 'automobile', 'fuel_economy_city', array(
        'lockable' => true,
        'single'   => false,
        'sanitize_callback' => 'abs'
    ) );

    register_post_meta( 'automobile', 'fuel_economy_hwy', array(
        'lockable' => true,
        'single'   => false,
        'sanitize_callback' => 'abs'
    ) );


    // Register general fields
    _register_common_meta_for_listing_type( 'automobile' );

}


/**
 * Register default meta for leads.
 *
 * @internal
 * @since 1.0.0
 * @return void
 */
function _register_default_meta_lead() {

    register_post_meta( 'lead', 'listing_id', array(
        'sanitize_callback' => 'cdemo\sanitize_post_id'
    ) );

    register_post_meta( 'lead', 'type', array(
        'sanitize_callback' => function ( $value ) {
            return $value;
        }
    ) );

    register_post_meta( 'lead', 'requested_time', array(
        'sanitize_callback' => 'cdemo\sanitize_date'
    ) );

    register_post_meta( 'lead', 'name', array(
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'lead', 'preferred', array(
        'sanitize_callback' => function ( $value ) {
            return $value;
        }
    ) );

    register_post_meta( 'lead', 'phone', array(
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( 'lead', 'email', array(
        'sanitize_callback' => 'sanitize_email'
    ) );

}


/**
 * Register common meta fields for a listing.
 *
 * @param string $type
 *
 * @internal
 * @since 1.0.0
 * @return void
 */
function _register_common_meta_for_listing_type( $type ) {

    register_post_meta( $type, 'media' );

    register_post_meta( $type, 'listing_currency', array(
        'lockable' => true,
        'sanitize_callback' => 'cdemo\sanitize_currency_code'
    ) );

    register_post_meta( $type, 'msrp', array(
        'lockable' => true,
        'sanitize_callback' => 'abs'
    ) );

    register_post_meta( $type, 'listing_price', array(
        'lockable' => true,
        'sanitize_callback' => 'abs'
    ) );

    register_post_meta( $type, 'sale_price', array(
        'lockable' => true,
        'sanitize_callback' => 'abs'
    ) );

    register_post_meta( $type, 'listing_price', array(
        'lockable' => true,
        'sanitize_callback' => 'abs'
    ) );

    register_post_meta( $type, 'sale_price_start_dt', array(
        'lockable' => true,
        'sanitize_callback' => 'cdemo\sanitize_date'
    ) );

    register_post_meta( $type, 'sale_price_end_dt', array(
        'lockable' => true,
        'sanitize_callback' => 'cdemo\sanitize_date'
    ) );

    register_post_meta( $type, 'misc_price_1', array(
        'lockable' => true,
        'sanitize_callback' => 'abs'
    ) );

    register_post_meta( $type, 'misc_price_2', array(
        'lockable' => true,
        'sanitize_callback' => 'abs'
    ) );

    register_post_meta( $type, 'misc_price_3', array(
        'lockable' => true,
        'sanitize_callback' => 'abs'
    ) );

    register_post_meta( $type, 'financing_enabled', array(
        'lockable' => true,
        'sanitize_callback' => 'cdemo\sanitize_checkbox'
    ) );

    register_post_meta( $type, 'financing_price', array(
        'lockable' => true,
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_post_meta( $type, 'down_payment', array(
        'lockable' => true,
        'sanitize_callback' => 'abs'
    ) );

    register_post_meta( $type, 'monthly_period', array(
        'lockable' => true,
        'sanitize_callback' => 'cdemo\sanitize_term_length'
    ) );

    register_post_meta( $type, 'percent_apr', array(
        'lockable' => true,
        'sanitize_callback' => 'abs'
    ) );

    register_post_meta( $type, 'monthly_finance_price', array(
        'lockable' => true,
        'sanitize_callback' => 'abs'
    ) );

    register_post_meta( $type, 'bi_weekly_finance_price', array(
        'lockable' => true,
        'sanitize_callback' => 'abs'
    ) );

    register_post_meta( $type, 'weekly_finance_price', array(
        'lockable' => true,
        'sanitize_callback' => 'abs'
    ) );

    register_post_meta( $type, 'financing_disclaimer', array(
        'lockable' => true,
        'sanitize_callback' => 'wp_kses_post'
    ) );

}
