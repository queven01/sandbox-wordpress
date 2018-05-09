<?php
/**
 * Functions for managing the Motorcycle listing post type.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;


/**
 * Register the motorcycle post type.
 *
 * @since 1.0.0
 * @return \WP_Error|\WP_Post_Type
 */
function register_post_type_motorcycle() {

    $labels = array(
        'name'               => _x( 'Motorcycles', 'post type general name', 'cdemo' ),
        'singular_name'      => _x( 'Motorcycle', 'post type singular name', 'cdemo' ),
        'add_new'            => __( 'Add New', 'cdemo' ),
        'add_new_item'       => __( 'Add New Motorcycle', 'cdemo' ),
        'new_item'           => __( 'New Motorcycle', 'cdemo' ),
        'edit_item'          => __( 'Edit Motorcycle', 'cdemo' ),
        'view_item'          => __( 'View Motorcycle', 'cdemo' ),
        'all_items'          => __( 'All Motorcycles', 'cdemo' ),
        'search_items'       => __( 'Search Motorcycles', 'cdemo' ),
        'not_found'          => __( 'No motorcycles found.', 'cdemo' ),
        'not_found_in_trash' => __( 'No motorcycles found in Trash.', 'cdemo' ),
        'archives'           => __( 'Motorcycle Archives', 'cdemo' ),
        'attributes'         => __( 'Motorcycle Attributes', 'cdemo' )
    );

    $args = array(
        'labels'    => $labels,
        'rest_base' => 'motorcycles',
    );

    return register_listing_type( 'motorcycle', $args );

}