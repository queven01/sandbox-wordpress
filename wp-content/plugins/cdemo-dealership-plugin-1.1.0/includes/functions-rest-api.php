<?php
/**
 * Functions to handle the WordPress REST API.
 *
 * @since 1.0.0
 * @package cdemo;
 */
namespace cdemo;


// Register custom endpoints
add_action( 'rest_api_init', 'cdemo\rest_register_endpoints' );


/**
 * Register the endpoint used to retrieve values for public meta fields.
 *
 * @action rest_api_init
 *
 * @since 1.0.0
 * @return void
 */
function rest_register_endpoints() {

    /**
     * Meta field values.
     */
    register_rest_route( 'cdemo/v1', 'fields/(?P<post_type>[0-9a-z-_]+)/(?P<id>[0-9a-z-_]+)/values', array(
        'methods'  => \WP_REST_Server::READABLE,
        'callback' => 'cdemo\rest_get_field_values',
        'args'     => array(
            'id' => array(
                'required'          => true,
                'sanitize_callback' => 'sanitize_key'
            ),
            'post_type' => array(
                'required'          => true,
                'sanitize_callback' => 'sanitize_key'
            )
        )
    ) );



    /**
     * Data Driver endpoints.
     */
    register_rest_route( 'cdemo/v1', 'data-driver/sync/status', array(
        'methods'  => \WP_REST_Server::READABLE,
        'callback' => 'cdemo\rest_sync_get_state',
        'permissions_callback' => 'cdemo\user_can_manage_options'
    ) );

    register_rest_route( 'cdemo/v1', 'data-driver/sync/start', array(
        'methods'  => 'POST',
        'callback' => 'cdemo\rest_start_sync',
        'permissions_callback' => 'cdemo\user_can_manage_options'
    ) );

    register_rest_route( 'cdemo/v1', 'data-driver/sync/pause', array(
        'methods'  => 'POST',
        'callback' => 'cdemo\rest_pause_sync',
        'permissions_callback' => 'cdemo\user_can_manage_options'
    ) );

}


/**
 * Get all available values for a whitelisted field.
 *
 *
 * @param \WP_REST_Request $request
 *
 * @since 1.0.0
 * @return array|\WP_Error
 */
function rest_get_field_values( \WP_REST_Request $request ) {

    $field = $request->get_param( 'id' );
    $type  = $request->get_param( 'post_type' );

    if ( !is_listing( $type ) || $type === 'all' ) {

        if ( $type === 'all' ) {
            $type = active_listing_types();
        } else {
            return new \WP_Error( 'invalid_category', __( 'Category was invalid', 'cdemo' ) );
        }

    }

    $whitelist = array(
        'make',
        'model',
        'body_type',
        'engine',
        'transmission'
    );

    $whitelist = apply_filters( 'cdemo_autocomplete_whitelist_fields', $whitelist );

    if ( in_array( $field, $whitelist ) ) {
        return get_field_values( $field, $type, $request->get_query_params(), true );
    }

    return new \WP_Error( 'invalid_field', __( 'Field was invalid', 'cdemo' ), 400 );

}

/**
 * Start a PIM sync.
 *
 * @since 1.0.0
 * @return array
 */
function rest_start_sync() {
    return get_sync_instance()->start();
}

/**
 * Pause an in progress PIM sync.
 *
 * @since 1.0.0
 * @return array
 */
function rest_pause_sync() {
    $sync = get_sync_instance();
    $sync->pause();

    return $sync->state();
}


/**
 * Get the status of the current PIM sync.
 *
 * @since 1.0.0
 * @return array
 */
function rest_sync_get_state() {
    return get_sync_instance()->state();
}
