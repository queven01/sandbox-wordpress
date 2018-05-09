<?php
/**
 * Functions for trailers post type
 *
 * @since 1.1.0
 * @package cdemo
 */
namespace cdemo;

/**
 * Register the trailer post type.
 *
 * @since 1.1.0
 * @return \WP_Error|\WP_Post_Type
 */
function register_post_type_trailer() {
    $labels = array(
        'name'               => _x( 'Trailers', 'post type general name', 'cdemo' ),
        'singular_name'      => _x( 'Trailer', 'post type singular name', 'cdemo' ),
        'add_new'            => __( 'Add New', 'cdemo' ),
        'add_new_item'       => __( 'Add New Trailer', 'cdemo' ),
        'new_item'           => __( 'New Trailer', 'cdemo' ),
        'edit_item'          => __( 'Edit Trailer', 'cdemo' ),
        'view_item'          => __( 'View Trailer', 'cdemo' ),
        'all_items'          => __( 'All Trailers', 'cdemo' ),
        'search_items'       => __( 'Search Trailers', 'cdemo' ),
        'not_found'          => __( 'No Trailers found.', 'cdemo' ),
        'not_found_in_trash' => __( 'No Trailers found in Trash.', 'cdemo' ),
        'archives'           => __( 'Trailer Archives', 'cdemo' ),
        'attributes'         => __( 'Trailer Attributes', 'cdemo' )
    );

    $args = array(
        'labels'    => $labels,
        'rest_base' => 'trailers',
    );

    return register_listing_type( 'trailer', $args );
}
