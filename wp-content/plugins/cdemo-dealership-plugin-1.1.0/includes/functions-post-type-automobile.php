<?php
/**
 * Functions for managing the automobile post type.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;


/**
 * Register the automobile post type.
 *
 * @since 1.0.0
 * @return \WP_Error|\WP_Post_Type
 */
function register_post_type_automobile() {
    $labels = array(
        'name'               => _x( 'Automobiles', 'post type general name', 'cdemo' ),
        'singular_name'      => _x( 'Automobile', 'post type singular name', 'cdemo' ),
        'add_new'            => __( 'Add New', 'cdemo' ),
        'add_new_item'       => __( 'Add New Listing', 'cdemo' ),
        'new_item'           => __( 'New Automobile', 'cdemo' ),
        'edit_item'          => __( 'Edit Automobile', 'cdemo' ),
        'view_item'          => __( 'View Automobile', 'cdemo' ),
        'all_items'          => __( 'All Automobiles', 'cdemo' ),
        'search_items'       => __( 'Search Automobiles', 'cdemo' ),
        'not_found'          => __( 'No automobiles found.', 'cdemo' ),
        'not_found_in_trash' => __( 'No automobiles found in Trash.', 'cdemo' ),
        'archives'           => __( 'Automobile Archives', 'cdemo' ),
        'attributes'         => __( 'Automobile Attributes', 'cdemo' )
    );

    $args = array(
        'labels'    => $labels,
        'rest_base' => 'automobiles',
    );

    return register_listing_type( 'automobile', $args );
}
