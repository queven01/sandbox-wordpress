<?php
/**
 * Functions for managing scripts loaded on the front-end.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;


// Print dynamic scripts
add_action( 'cdemo_footer', 'cdemo\print_dynamic_scripts' );

// Print dynamic styles
add_action( 'cdemo_header', 'cdemo\print_dynamic_styles' );

// Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'cdemo\enqueue_scripts' );

// Register available dependencies
add_action( 'wp_enqueue_scripts', 'cdemo\register_script_dependencies', 9 );



/**
 * Register common dependencies for other scripts.
 *
 * @action wp_enqueue_scripts
 *
 * @since 1.0.0
 * @return void
 */
function register_script_dependencies() {

    // Register core js modules
    register_core_scripts();

    /**
     * Bootstrap
     */
    wp_register_style(  'bootstrap', resolve_url( 'assets/lib/bootstrap/css/bootstrap.min.css' ), null, VERSION );
    wp_register_script( 'bootstrap', resolve_url( 'assets/lib/bootstrap/js/bootstrap.min.js'   ), array( 'jquery' ), VERSION );

    /**
     * Light gallery
     */
    wp_register_style(  'lightgallery', resolve_url( 'assets/lib/lightgallery/css/lightgallery.min.css'   ), null, VERSION );
    wp_register_script( 'lightgallery', resolve_url( 'assets/lib/lightgallery/js/lightgallery-all.min.js' ), array( 'jquery' ), VERSION );

    /**
     * Light Slider
     */
    wp_register_style(  'lightslider', resolve_url( 'assets/lib/lightslider/css/lightslider.min.css' ), null, VERSION );
    wp_register_script( 'lightslider', resolve_url( 'assets/lib/lightslider/js/lightslider.min.js' ), array( 'jquery' ), VERSION );

    /**
     * Owl Carousel
     */
    wp_register_script( 'owl-carousel', resolve_url( 'assets/lib/owl-carousel/js/owl.carousel.min.js' ), array( 'jquery' ), VERSION );
    wp_register_style(  'owl-carousel', resolve_url( 'assets/lib/owl-carousel/css/owl.carousel.min.css' ), null, VERSION );

    // Owl theme
    wp_register_style(  'owl-carousel-theme', resolve_url( 'assets/lib/owl-carousel/css/owl.theme.default.min.css' ), array( 'owl-carousel' ), VERSION );

    /**
     * Selectize
     */
    wp_register_script( 'selectize', resolve_url( 'assets/lib/selectize/js/selectize.min.js' ), array( 'jquery' ), VERSION );
    wp_register_style(  'selectize', resolve_url( 'assets/lib/selectize/css/selectize.css'   ), null, VERSION );

    // Bootstrap theme
    wp_register_style( 'selectize-bootstrap3', resolve_url( 'assets/lib/selectize/css/selectize.bootstrap3.css' ), array( 'selectize', 'bootstrap' ), VERSION );

    /**
     * Moment.js
     */
    wp_register_script( 'moment', resolve_url( 'assets/lib/moment/moment.min.js' ), array( 'jquery' ), VERSION );

    /**
     * jQuery UI
     */
    wp_register_style( 'jquery-ui', resolve_url( 'assets/css/jquery-ui.css' ), null, VERSION );

    /**
     * Bootstrap date-time picker
     */
    $deps = array(
        'jquery',
        'moment',
        'bootstrap'
    );

    wp_register_script( 'bootstrap-datetime-picker', resolve_url( 'assets/lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js'   ), $deps, VERSION );
    wp_register_style(  'bootstrap-datetime-picker', resolve_url( 'assets/lib/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css' ), array( 'bootstrap' ), VERSION );
}


/**
 * Enqueue scripts and styles.
 *
 * @action wp_enqueue_scripts
 *
 * @since 1.0.0
 * @return void
 */
function enqueue_scripts() {

    if ( is_inventory() || is_listing( get_post_type() ) ) {

        if ( styles_enabled() ) {
            $deps = array(
                'jquery-ui',
                'bootstrap',
                'selectize',
                'selectize-bootstrap3',
                'owl-carousel',
                'owl-carousel-theme',
                'bootstrap-datetime-picker'
            );

            wp_enqueue_style( 'cdemo', resolve_url( 'assets/css/style.css' ), $deps, VERSION );
        }

        wp_enqueue_script( 'bootstrap' );
    }

    if ( is_inventory() ) {
        $l10n = array(
            'api' => array(
                'endpoints' => array(
                    'fields' => rest_url( 'cdemo/v1/fields' )
                )
            ),
            'search_url' => search_url(),
            'locale'     => esc_js( get_locale() )
        );

        $deps = array(
            'bootstrap',
            'selectize',
            'jquery-ui-slider'
        );

        wp_register_script( 'cdemo-search', resolve_url( 'assets/js/search.js' ), $deps, VERSION );
        wp_localize_script( 'cdemo-search', 'cdemo_search_l10n', $l10n );

        wp_enqueue_script( 'cdemo-search' );

    } else if ( is_listing( get_post_type() ) ) {
        $deps = array(
            'lightslider',
            'lightgallery'
        );

        wp_enqueue_script( 'cdemo-listing', resolve_url( 'assets/js/listing.js' ), $deps, VERSION );

        wp_enqueue_style( 'lightgallery' );
        wp_enqueue_style( 'lightslider' );
    }


    wp_enqueue_script( 'cdemo-global', resolve_url( 'assets/js/global.js' ), array( 'jquery', 'owl-carousel' ), VERSION );
}


/**
 * Register core plugin scripts and modules.
 *
 * @since 1.0.0
 * @return void
 */
function register_core_scripts() {

    // Core plugin module
    $cdemo_l10n = array(
        'api' => array(
            'nonce'     => wp_create_nonce( 'wp_rest' ),
            'endpoints' => array(
                'sync' => rest_url( 'cdemo/v1/data-driver/sync' )
            )
        )
    );

    // Core plugin namespace
    wp_register_script( 'cdemo', resolve_url( 'assets/js/cdemo.js' ), array( 'jquery' ), VERSION );
    wp_localize_script( 'cdemo', 'cdemo_l10n', $cdemo_l10n );
}


/**
 * Output user controlled styles.
 *
 * @action cdemo_header
 *
 * @since 1.0.0
 * @return void
 */
function print_dynamic_styles() {
    if ( styles_enabled() ) {
        get_template( 'dynamic-styles' );
    }
}


/**
 * Output user controlled scripts.
 *
 * @action cdemo_footer
 *
 * @since 1.0.0
 * @return void
 */
function print_dynamic_scripts() {
    get_template( 'dynamic-scripts' );
}


/**
 * Check to see if default styles are enabled.
 *
 * @since 1.0.0
 * @return bool
 */
function styles_enabled() {
    return get_option( Options::STYLES_ENABLED );
}
