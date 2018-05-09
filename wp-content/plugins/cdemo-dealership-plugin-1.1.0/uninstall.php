<?php

namespace cdemo;


if( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}


include_once 'cdemo.php';


cdemo();

// Clear cron
clear_cron_hooks();


if ( get_option( Options::ERASE_CONTENT ) ) {

	register_listing_post_types();
	register_lead_post_type();

	$post_types = active_listing_types();
	$post_types[] = 'lead';


    $args = array(
        'posts_per_page' => -1,
        'post_type'      => $post_types
    );

    // Trash all posts
    $posts = new \WP_Query( $args );

    foreach ( $posts as $post ) {
        wp_trash_post( $post->ID );
    }

}


if ( get_option( Options::ERASE_OPTIONS ) ) {

    $options = new \ReflectionClass( '\cdemo\Options' );

    foreach ( $options->getConstants() as $option ) {
        delete_option( $option );
    }

}
