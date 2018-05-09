<?php
/**
 * Functions for WordPress widgets.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;


// Register widget areas
add_action( 'widgets_init', 'cdemo\register_widget_sidebars' );

// Register widgets
add_action( 'widgets_init', 'cdemo\register_custom_widgets' );


/**
 * Register custom widget areas.
 *
 * @action widgets_init
 *
 * @since 1.0.0
 * @return void
 */
function register_widget_sidebars() {

	$args = array(
		'id'            => 'listing-widget-area',
		'name'          => __( 'cDemo - Below Listing', 'cdemo' ),
		'description'   => __( 'Widget area displayed on listing detail pages', 'cdemo' ),
		'before_widget' => '<div id="%1$s" class="col-md-4 cdemo-listing-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>'
	);

	register_sidebar( $args );

}


/**
 * Register plugin widgets.
 *
 * @action widgets_init
 *
 * @since 1.0.0
 * @return void
 */
function register_custom_widgets() {

    register_widget( 'cdemo\WidgetListings' );

}
