<?php
/**
 * Functions for the main inventory search.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;


// Initialize the search page
add_action( 'wp', 'cdemo\clean_query_vars' );

// Initialize the inventory when WordPress loads
add_action( 'cdemo_inventory_init', 'cdemo\inventory_init' );


/**
 * Strip out all empty query vars to cleanup URL.
 *
 * @action wp
 *
 * @since 1.0.0
 * @return void
 */
function clean_query_vars() {

    if ( is_inventory() ) {

        // Cleanup empty URL query vars
        $remove = array();
        $ignore = array(
            'page'
        );

        foreach ( $_GET as $var => $value ) {

            if ( $value === '' && !in_array( $var, $ignore ) ) {
                $remove[] = $var;
            }

        }

        if ( !empty( $remove ) ) {
            wp_safe_redirect( remove_query_arg( $remove ) );
        }

        do_action( 'cdemo_inventory_init' );

    }

}


/**
 * Initializes the main query when WordPress loads.
 *
 * @action cdemo_init
 *
 * @since 1.0.0
 * @return void
 */
function inventory_init() {

    // Available shortcode arguments
    $atts = array(

        // Display
        'show_filters'      => true,
        'show_sort'         => true,

        // Data
        'category'          => '',

        // Meta
        'condition'         => '',
        'year'              => '',
        'make'              => '',
        'model'             => '',
        'trim'              => '',
        'body_style'        => '',
        'transmission'      => '',
        'fuel_type'         => '',
        'stock_number'      => '',
        'days_in_stock'     => '',
        'price'             => '',
        'fuel_economy_city' => '',
        'fuel_economy_hwy'  => '',
        'features'          => '',
        'keyword'           => '',
        'limit'             => get_option( Options::RESULTS_PER_PAGE )
    );

    // If we're on a search view get the shortcode attributes
    if ( !is_inventory_page() ) {
        $parsed = parse_shortcode( get_post()->post_content, (array) INVENTORY_SHORTCODE );
        $atts = shortcode_atts( $atts, current( array_values( $parsed ) ), INVENTORY_SHORTCODE );
    }

    // Store the parsed page arguments
    cdemo()->set( 'template_args', $atts );


    // Initialize the search query
    $search = array(
        'page_num'         => get_request_var( 'page_num', 1 ),
        'vehicle_category' => get_request_var( 'vehicle_category', $atts['category'] ) ?: active_listing_types()
    );

    // Map a list of the query vars passable via shortcode
    $query_vars_map = array(
        'condition'         => 'condition',
        'year'              => 'year_manufactured',
        'make'              => 'make',
        'model'             => 'model',
        'trim'              => 'trim_level',
        'body_style'        => 'body_type',
        'transmission'      => 'transmission',
        'fuel_type'         => 'fuel_type',
        'stock_number'      => 'stocknumber',
        'days_in_stock'     => 'days_in_stock',
        'price'             => 'price',
        'fuel_economy_hwy'  => 'fuel_economy_hwy',
        'fuel_economy_city' => 'fuel_economy_city',
        'features'          => 'features',
        'keyword'           => 'keyword',
        'limit'             => 'limit'
    );


    // Copy shortcode attributes to the search query
    foreach ( $query_vars_map as $var => $mapped ) {
        $search[ $mapped ] = $atts[ $var ];
    }

    // Combine query params with the request and initialize the query
    cdemo()->set( 'the_query', new VehicleQuery( wp_parse_args( $_GET, $search ) ) );
}

/**
 * Get the main query.
 *
 * @since 1.0.0
 * @return mixed
 */
function get_the_query() {
    return cdemo()->get( 'the_query' );
}


/**
 * Get and append arguments to the search URL.
 *
 * @param array|string $args
 *
 * @since 1.0.0
 * @return string
 */
function search_url( $args = '' ) {
    return add_query_arg( wp_parse_args( $args ), get_the_permalink( get_option( Options::SEARCH_PAGE_ID ) ) );
}
