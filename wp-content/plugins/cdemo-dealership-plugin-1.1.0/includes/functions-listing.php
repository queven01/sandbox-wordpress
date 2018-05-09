<?php
/**
 * General purpose functions for listing post types.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;


// Register custom post statuses
add_action( 'init', 'cdemo\register_custom_post_status' );

// Register listing post types
add_action( 'init', 'cdemo\register_listing_post_types' );

// print JS and CSS in a listing page
add_action( 'wp_head', 'cdemo\print_listing_scripts' );

/**
 * Get the post type objects for each active listing.
 *
 * @since 1.0.0
 * @return array
 */
function get_listing_post_type_objects() {
    $types = array();

    foreach ( active_listing_types() as $type ) {
        $type = get_post_type_object( $type );

        if ( $type ) {
            array_push( $types, $type );
        }
    }

    return $types;
}


/**
 * Get plugin builtin listing post types and configs.
 *
 * @since 1.0.0
 * @return array
 */
function default_post_types() {
    $slugs = array(
        'automobile' => array(
            'slug' => 'inventory/automobiles'
        ),
        'motorcycle' => array(
            'slug' => 'inventory/motorcycles'
        ),
        'snowmobile' => array(
            'slug' => 'inventory/snowmobiles'
        ),
        'atv' => array(
            'slug' => 'inventory/atvs',
        ),
        'camper' => array(
            'slug' => 'inventory/campers'
        ),
        'boat' => array(
            'slug' => 'inventory/boats'
        ),
        'trailer' => array(
            'slug' => 'inventory/trailers'
        )
    );

    return $slugs;
}


/**
 * Check to see if a posting is a valid listing post type.
 *
 * @param $type
 *
 * @since 1.0.0
 * @return bool
 */
function is_listing( $type ) {
    if ( in_array( $type, active_listing_types() ) ) {
        return $type;
    }

    return false;
}


/**
 * Get all currently active listing post types.
 *
 * @since 1.0.0
 * @return array
 */
function active_listing_types() {
    $types = array(
        'atv',
        'automobile',
        'motorcycle',
        'snowmobile',
        'camper',
        'boat',
        'trailer'
    );

    return $types;
}


/**
 * Get the URL for the listing featured image.
 *
 * @param mixed  $post
 * @param string $size
 *
 * @since 1.0.0
 * @return mixed
 */
function get_post_image_url( $post = null, $size = 'post-thumbnail' ) {

    $url = get_the_post_thumbnail_url( $post, $size );

    if ( empty( $url ) ) {
        return apply_filters( 'cdemo_featured_image_placeholder', resolve_url( 'assets/images/placeholder-image.png' ), $post, $size );
    }

    return $url;

}


/**
 * Get custom statuses for listing post types.
 *
 * @since 1.0.0
 * @return array
 */
function listing_custom_statuses() {

    $statuses = array(
        'hidden' => array(
            'label'    => __( 'Hidden', 'cdemo' ),
            'private'  => true
        ),
        'sold' => array(
            'label'    => __( 'Sold', 'cdemo' ),
            'public'   => true
        )
    );

    return $statuses;

}


/**
 * Register custom post statuses for listing post types.
 *
 * @action init
 *
 * @since 1.0.0
 * @return void
 */
function register_custom_post_status() {

    foreach ( listing_custom_statuses() as $status => $args ) {
        register_post_status( $status, $args );
    }

}


/**
 * Register a listing post type with common args.
 *
 * @param string $post_type
 * @param array  $args
 *
 * @since 1.0.0
 * @return \WP_Error|\WP_Post_Type
 */
function register_listing_type( $post_type, $args ) {
    $config = array_merge( default_post_types(), get_option( Options::POST_TYPE_CONFIG, array() ) );

    $defaults = array(
        'map_meta_cap'         => true,
        'capability_type'      => 'post',
        'supports'             => array( 'title', 'thumbnail', 'editor' ),
        'publicly_queryable'   => true,
        'public'               => true,
        'show_in_rest'         => true,
        'show_in_menu'         => false,
        'register_meta_box_cb' => 'cdemo\register_listing_metaboxes',
        'rewrite' => array(
            'slug' => $config[ $post_type ]['slug']
        )
    );

    register_post_type( $post_type, array_merge_recursive( $defaults, $args ) );
}


/**
 * Register default listing types.
 *
 * @action init
 *
 * @since 1.0.0
 * @return array
 */
function register_listing_post_types() {
    register_post_type_atv();
    register_post_type_automobile();
    register_post_type_motorcycle();
    register_post_type_snowmobile();
    register_post_type_camper();
    register_post_type_boat();
    register_post_type_trailer();


    // Return a list of registered post types
    $types = array(
        'atv',
        'automobile',
        'motorcycle',
        'snowmobile',
        'camper',
        'boat',
        'trailer'
    );

    return $types;
}


/**
 * Get a vehicle listing by its inspection ID.
 *
 * @global $wpdb
 *
 * @param string $id
 *
 * @since 1.0.0
 * @return false|\WP_Post
 */
function get_listing_by_cdemo_id( $id ) {

    global $wpdb;

    $types = implode( ', ', wrap_quotes( esc_sql( active_listing_types() ) ) );

    $sql = "SELECT p.ID
            FROM $wpdb->posts p
            INNER JOIN $wpdb->postmeta m
              ON m.post_id = p.ID
            WHERE p.post_type IN ( $types )
                AND m.meta_key = 'cdemo_record_id'
                AND m.meta_value = %s";

    $result = $wpdb->get_var( $wpdb->prepare( $sql, $id ) );

    if ( !empty( $result ) ) {
        return get_post( $result );
    }

    return false;

}

/**
 * 
 * Prints dynamic scripts used in single.php
 * 
 * @todo Move this to a seperate template
 * 
 */
function print_listing_scripts() {
    
    $colors = get_colors();
    
    if ( styles_enabled() ) : 
        
        get_template( 
            'dynamic-css-single', array(
            'colors'    => $colors
        ), true);
    
        endif; ?>

<?php }


/**
 * Get photos for a listing.
 *
 * @param null|int|\WP_Post $listing
 *
 * @since 1.0.0
 * @return array|false
 */
function get_listing_media( $listing = null ) {

    $listing = get_post( $listing );

    if ( $listing ) {
        return get_post_meta( $listing->ID, 'media', true ) ?: array();
    }

    return false;

}


/**
 * Output a dropdown of listings.
 *
 * @param string $selected
 * @param array  $attributes
 *
 * @since 1.0.0
 * @return void
 */
function listing_dropdown( $selected = '', $attributes = array() ) {

    $args = array(
        'posts_per_page' => -1,
        'post_type'      => active_listing_types()
    );

    $listings = get_posts( $args );

    echo '<select ' . parse_attrs( wp_parse_args( $attributes ) ) . '>';

        foreach ( $listings as $listing ) {
            echo '<option value="' . esc_attr( $listing->ID ) . '"' .
                selected( $listing->ID, $selected, false ) . '>' . esc_html( $listing->post_title ) . '</option>';
        }

    echo '</select>';

}

/**
 * Get the available makes for a listing type.
 *
 * @global $wpdb
 *
 * @param array|string $type
 * @param string       $order
 *
 * @since 1.0.0
 * @return array
 */
function get_available_makes_for_type( $type, $order = 'asc' ) {

    global $wpdb;

    $escaped = maybe_implode( wrap_quotes( esc_sql( $type ) ), ',' );

    $sql = "SELECT DISTINCT m.meta_value 
            FROM $wpdb->postmeta m
            INNER JOIN $wpdb->posts p
               ON p.ID = m.post_id
            WHERE p.post_type IN( $escaped )
              AND m.meta_key = 'make'
              AND TRIM(m.meta_value) != ''
            ORDER BY m.meta_value " . ( strtolower( $order ) == 'asc' ? 'ASC' : 'DESC' );

    return $wpdb->get_col( $sql );

}
