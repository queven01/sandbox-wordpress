<?php
/**
 * Functions for managing the snowmobile post type.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;


/**
 * Register the snowmobile post type.
 *
 * @since 1.0.0
 * @return \WP_Error|\WP_Post_Type
 */
function register_post_type_snowmobile() {

    $labels = array(
        'name'               => _x( 'Snowmobiles', 'post type general name', 'cdemo' ),
        'singular_name'      => _x( 'Snowmobile', 'post type singular name', 'cdemo' ),
        'add_new'            => __( 'Add New', 'cdemo' ),
        'add_new_item'       => __( 'Add New Snowmobile', 'cdemo' ),
        'new_item'           => __( 'New Snowmobile', 'cdemo' ),
        'edit_item'          => __( 'Edit Snowmobile', 'cdemo' ),
        'view_item'          => __( 'View Snowmobile', 'cdemo' ),
        'all_items'          => __( 'All Snowmobiles', 'cdemo' ),
        'search_items'       => __( 'Search Snowmobiles', 'cdemo' ),
        'not_found'          => __( 'No snowmobiles found.', 'cdemo' ),
        'not_found_in_trash' => __( 'No Snowmobiles found in Trash.', 'cdemo' ),
        'archives'           => __( 'Snowmobile Archives', 'cdemo' ),
        'attributes'         => __( 'Snowmobile Attributes', 'cdemo' )
    );

    $args = array(
        'labels'    => $labels,
        'rest_base' => 'snowmobiles',
    );

    return register_listing_type( 'snowmobile', $args );

}
