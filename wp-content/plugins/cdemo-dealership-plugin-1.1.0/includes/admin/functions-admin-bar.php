<?php
/**
 * Functions for the WordPress admin bar
 *
 * @since 1.0.0
 * @package cdemo
 * @subpackage admin
 */
namespace cdemo;


// Add new listing link to the admin bar
add_action( 'admin_bar_menu', 'cdemo\admin_bar_new_listing_link', 100 );

// Add edit action to admin bar
add_action( 'admin_bar_menu', 'cdemo\admin_bar_edit_listing', 100 );

// Add sync status to the admin bar
add_action( 'admin_bar_menu', 'cdemo\admin_bar_sync', 100 );


// Enqueue admin bar scripts
add_action( 'admin_enqueue_scripts', 'cdemo\enqueue_admin_bar_scripts' );
add_action( 'wp_enqueue_scripts',    'cdemo\enqueue_admin_bar_scripts' );

// Enqueue admin bar styles
add_action( 'admin_enqueue_scripts', 'cdemo\enqueue_admin_bar_styles' );
add_action( 'wp_enqueue_scripts',    'cdemo\enqueue_admin_bar_styles' );


/**
 * Add quick link for creating listings to the admin bar.
 *
 * @action admin_bar_menu
 *
 * @param \WP_Admin_Bar $wp_admin_bar
 *
 * @since 1.0.0
 * @return void
 */
function admin_bar_new_listing_link( $wp_admin_bar ) {
    $node = array(
        'id'     => 'new-listing',
        'title'  => __( 'Listing', 'cdemo' ),
        'parent' => 'new-content',
        'href'   => admin_url( 'admin.php?page=cdemo-new-listing', false )
    );

    $wp_admin_bar->add_node( $node );
}


/**
 * Add sync status to the admin bar.
 *
 * @action admin_bar_menu
 *
 * @param \WP_Admin_Bar $wp_admin_bar
 *
 * @since 1.0.0
 * @return void
 */
function admin_bar_sync( $wp_admin_bar ) {

    if ( sync_enabled() ) {
        $menu = array(
            'id'     => 'cdemo-sync',
            'href'   => '#',
            'parent' => false,
            'title'  => sprintf(
                '<span class="ab-icon"></span> <span class="ab-label">%s</span>', __( 'cDemo PIM', 'cdemo' )
            )
        );

        $node = array(
            'id'     => 'cdemo-sync-status',
            'parent' => 'cdemo-sync',
            'meta'   => array(
                'html' => '<div class="progress"><strong></strong></div>'
            )
        );

        $wp_admin_bar->add_menu( $menu );
        $wp_admin_bar->add_node( $node );
    }
}


/**
 * Add edit action to admin bar when on single listings.
 *
 * @action admin_bar_menu
 *
 * @param \WP_Admin_Bar $wp_admin_bar
 *
 * @since 1.0.0
 * @return void
 */
function admin_bar_edit_listing( $wp_admin_bar ) {

    if ( is_listing( get_post_type() ) && current_user_can( 'edit_post', get_the_ID() ) ) {
        $node = array(
            'id'    => 'cdemo-edit-listing',
            'href'  => get_edit_post_link(),
            'title' => sprintf(
                '<span class="ab-icon"></span> <span class="ab-label">%s</span>', __( 'Edit Listing', 'cdemo' )
            )
        );

        $wp_admin_bar->add_node( $node );
    }
}


/**
 * Enqueue custom scripts for the WordPress admin bar.
 *
 * @action admin_enqueue_scripts
 * @action wp_enqueue_scripts
 *
 * @since 1.0.0
 * @return void
 */
function enqueue_admin_bar_scripts() {

    if ( user_can_manage_options() ) {

        if ( sync_enabled() && is_admin_bar_showing() ) {
            wp_enqueue_script( 'jquery' );
            wp_enqueue_script( 'cdemo' );
            wp_enqueue_script( 'circle-progress', resolve_url( 'assets/js/circle-progress.min.js' ), null, VERSION );
            wp_enqueue_script( 'cdemo-admin-bar', resolve_url( 'assets/admin/js/admin-bar.js'     ), null, VERSION );
        }
    }
}

/**
 * Enqueue custom styles for the WordPress admin bar.
 *
 * @action admin_enqueue_scripts
 * @action wp_enqueue_scripts
 *
 * @since 1.0.0
 * @return void
 */
function enqueue_admin_bar_styles() {

    if ( user_can_manage_options() ) {
        if ( sync_enabled() && is_admin_bar_showing() ) {
            wp_enqueue_style( 'cdemo-admin-bar', resolve_url( 'assets/admin/css/admin-bar.css' ), null, VERSION );
        }
    }
}