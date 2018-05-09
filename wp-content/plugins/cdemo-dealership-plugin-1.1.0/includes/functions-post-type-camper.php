<?php
/**
 * Functions for the Camper/RV post type.
 *
 * @since 1.1.0
 * @package cdemo
 */
namespace cdemo;

/**
 * Register the camper post type.
 *
 * @since 1.1.0
 * @return \WP_Error|\WP_Post_Type
 */
function register_post_type_camper() {
    $labels = array(
        'name'               => _x( 'Campers/RVs', 'post type general name', 'cdemo' ),
        'singular_name'      => _x( 'Camper/RV', 'post type singular name', 'cdemo' ),
        'add_new'            => __( 'Add New', 'cdemo' ),
        'add_new_item'       => __( 'Add New Camper/RV', 'cdemo' ),
        'new_item'           => __( 'New Camper/RV', 'cdemo' ),
        'edit_item'          => __( 'Edit Camper/RV', 'cdemo' ),
        'view_item'          => __( 'View Camper/RV', 'cdemo' ),
        'all_items'          => __( 'All Campers/RVs', 'cdemo' ),
        'search_items'       => __( 'Search Campers/RVs', 'cdemo' ),
        'not_found'          => __( 'No Campers/RVs found.', 'cdemo' ),
        'not_found_in_trash' => __( 'No Campers/RVs found in Trash.', 'cdemo' ),
        'archives'           => __( 'Camper/RV Archives', 'cdemo' ),
        'attributes'         => __( 'Camper/RV Attributes', 'cdemo' )
    );

    $args = array(
        'labels'    => $labels,
        'rest_base' => 'campers',
    );

    return register_listing_type( 'camper', $args );
}
