<?php
/**
 * Functions for the boats post type.
 *
 * @since 1.1.0
 * @package cdemo
 */
namespace cdemo;


/**
 * Register the boats post type.
 *
 * @since 1.1.0
 * @return \WP_Error|\WP_Post_Type
 */
function register_post_type_boat() {
    $labels = array(
        'name'               => _x( 'Boats', 'post type general name', 'cdemo' ),
        'singular_name'      => _x( 'Boat', 'post type singular name', 'cdemo' ),
        'add_new'            => __( 'Add New', 'cdemo' ),
        'add_new_item'       => __( 'Add New Boat', 'cdemo' ),
        'new_item'           => __( 'New Boat', 'cdemo' ),
        'edit_item'          => __( 'Edit Boat', 'cdemo' ),
        'view_item'          => __( 'View Boat', 'cdemo' ),
        'all_items'          => __( 'All Boats', 'cdemo' ),
        'search_items'       => __( 'Search Boats', 'cdemo' ),
        'not_found'          => __( 'No Boats found.', 'cdemo' ),
        'not_found_in_trash' => __( 'No Boats found in Trash.', 'cdemo' ),
        'archives'           => __( 'Boat Archives', 'cdemo' ),
        'attributes'         => __( 'Boat Attributes', 'cdemo' )
    );

    $args = array(
        'labels'    => $labels,
        'rest_base' => 'boats',
    );

    return register_listing_type( 'boat', $args );
}
