<?php
/**
 * ACF Theme Theme Customizer
 *
 * @package ACF_Theme
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function acf_theme_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
    $wp_customize->get_setting( 'background_color' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'acf_theme_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'acf_theme_customize_partial_blogdescription',
		) );
	}

    /**
     *-------------------- Button Options-----------------------------*
     */
    $wp_customize->add_panel( 'button_options', array(
        'title' => __( 'Button Options' ),
        'description' => $description, // Include html tags such as <p>.
        'priority' => 2, // Mixed with top-level-section hierarchy.
    ) );

	include 'button_classes/primarycolor.php';
    include 'button_classes/secondarycolor.php';
    include 'button_classes/ghostcolor.php';

    /**
     *-------------------- Title Header Options-----------------------------*
     */
    $wp_customize->add_panel( 'heading_options', array(
        'title' => __( 'Title Heading Options' ),
        'description' => $description,
        'priority' => 3,
    ) );

    include 'heading_options/heading_one.php';
    include 'heading_options/heading_two.php';
    include 'heading_options/heading_three.php';

    /**
     *-------------------- Header View Options -----------------------------*
     */

    include 'heading_view/heading_view.php';

}
add_action( 'customize_register', 'acf_theme_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function acf_theme_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function acf_theme_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function acf_theme_customize_preview_js() {
	wp_enqueue_script( 'acf_theme-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'acf_theme_customize_preview_js' );