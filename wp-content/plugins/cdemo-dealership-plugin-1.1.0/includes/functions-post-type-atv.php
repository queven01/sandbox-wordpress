<?php
/**
 * Functions for managing the ATV post type.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;


/**
 * Register the ATV post type.
 *
 * @since 1.0.0
 * @return \WP_Error|\WP_Post_Type
 */
function register_post_type_atv() {

    $labels = array(
        'name'               => _x( 'ATVs', 'post type general name', 'cdemo' ),
        'singular_name'      => _x( 'ATV', 'post type singular name', 'cdemo' ),
        'add_new'            => __( 'Add New', 'cdemo' ),
        'add_new_item'       => __( 'Add New ATV', 'cdemo' ),
        'new_item'           => __( 'New ATV', 'cdemo' ),
        'edit_item'          => __( 'Edit ATV', 'cdemo' ),
        'view_item'          => __( 'View ATV', 'cdemo' ),
        'all_items'          => __( 'All ATVs', 'cdemo' ),
        'search_items'       => __( 'Search ATVs', 'cdemo' ),
        'not_found'          => __( 'No ATVs found.', 'cdemo' ),
        'not_found_in_trash' => __( 'No ATVs found in Trash.', 'cdemo' ),
        'archives'           => __( 'ATV Archives', 'cdemo' ),
        'attributes'         => __( 'ATV Attributes', 'cdemo' )
    );

    $args = array(
        'labels'       => $labels,
        'rest_base'    => 'atvs'
    );

    return register_listing_type( 'atv', $args );

}