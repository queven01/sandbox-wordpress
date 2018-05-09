<?php
/**
 * Functions for handling WordPress templates.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;


// Add custom page template options
add_filter( 'theme_page_templates', 'cdemo\add_template_pages' );

// Override the inventory template
add_filter( 'template_include', 'cdemo\set_inventory_template' );

// Override the default single template
add_filter( 'template_include', 'cdemo\include_single_template' );


/**
 * Get arguments for configuring the template page.
 *
 * @since 1.0.0
 * @return array|false
 */
function get_template_arguments() {
    return cdemo()->get( 'template_args' );
}


/**
 * Create or restore the main inventory page.
 *
 * @since 1.0.0
 * @return void
 */
function setup_template_page() {

    $search_page = get_post( get_option( Options::SEARCH_PAGE_ID ) );

    if ( empty( $search_page ) ) {

        $args = array(
            'post_title'  => __( 'cDemo Inventory', 'cdemo' ),
            'post_name'   => 'inventory',
            'post_type'   => 'page',
            'post_status' => 'publish',
            'meta_input'  => array(
                '_wp_page_template' => 'cdemo-inventory'
            )
        );

        $id = wp_insert_post( $args );

        if ( !is_wp_error( $id ) ) {
            update_option( Options::SEARCH_PAGE_ID, $id );
        }

    } else if ( $search_page->post_status === 'trash' ) {
        wp_untrash_post( $search_page->ID );
    }

}


/**
 * Add custom inventory template to the page template options.
 *
 * @filter theme_page_templates
 *
 * @param array $templates
 *
 * @since 1.0.0
 * @return array
 */
function add_template_pages( $templates ) {

    // If we're on a page that's not the blog roll
    if ( get_the_ID() !== get_option( 'page_for_posts' ) && get_post_type() == 'page' ) {
        $templates['cdemo-inventory'] = __( 'cDemo Inventory', 'cdemo' );
    }

    return $templates;

}


/**
 * Set the inventory template on inventory pages.
 *
 * @filter template_include
 *
 * @param string $template
 *
 * @since 1.0.0
 * @return string
 */
function set_inventory_template( $template ) {

    if ( is_inventory() ) {
        $template = get_template( 'inventory', null, false );
    }

    return $template;

}


/**
 * Set the single template on listing detail pages.
 *
 * @filter template_include
 *
 * @param string $template
 *
 * @since 1.0.0
 * @return string
 */
function include_single_template( $template )  {

    $post_type = get_post_type();

	if ( !is_archive() && is_listing( $post_type ) ) {

        // Try to find if the theme is overriding the template
        if ( locate_template( "single-$post_type.php" ) == '' ) {
            $template = get_template( 'single', null, false );
        }

    }

    return $template;

}


/**
 * Check to see if the page we are on is an inventory page.
 *
 * @since 1.0.0
 * @return bool
 */
function is_inventory() {
    return is_inventory_page() || get_post_meta( get_the_ID(), '_wp_page_template', true ) == 'cdemo-inventory';
}


/**
 * Check to see if our current page is the inventory page.
 *
 * @param mixed $page
 *
 * @return bool
 * @since 1.0.0
 */
function is_inventory_page( $page = null ) {

    $page = get_post( $page );

    if ( $page && $page->ID == get_option( Options::SEARCH_PAGE_ID ) ) {
        return true;
    }

    return false;

}


/**
 * Get the page header.
 *
 * @param array $args
 *
 * @since 1.0.0
 * @return void
 */
function get_header( $args = array() ) {
	get_template( 'header', $args );
}


/**
 * Get the page footer.
 *
 * @param array $args
 *
 * @since 1.0.0
 * @return void
 */
function get_footer( $args = array() ) {
	get_template( 'footer', $args );
}
