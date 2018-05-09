<?php
/**
 * Functions for managing assets in the WordPress admin.
 *
 * @since 1.0.0
 * @package cdemo
 * @subpackage admin
 */
namespace cdemo;


// Register deps
add_action( 'admin_enqueue_scripts', 'cdemo\register_admin_dependencies', 9 );

// Enqueue scripts
add_action( 'admin_enqueue_scripts', 'cdemo\enqueue_admin_scripts' );


/**
 * Register common dependencies for other scripts.
 *
 * @action admin_enqueue_scripts
 *
 * @since 1.0.0
 * @return void
 */
function register_admin_dependencies() {

    // Additional stylesheets
    wp_register_style( 'jquery-ui',          resolve_url( 'assets/css/jquery-ui.css'          ), null, VERSION );
    wp_register_style( 'cdemo-admin',        resolve_url( 'assets/admin/css/admin.css'        ), null, VERSION );
    wp_register_style( 'bootstrap-tooltips', resolve_url( 'assets/css/bootstrap-tooltips.css' ), null, VERSION );

    // Custom skin for jQuery date picker
    wp_register_style( 'jquery-ui-datepicker', resolve_url( 'assets/css/jquery-ui-datepicker.css' ), null, VERSION );

    // Additional JS libs
    wp_register_script( 'bootstrap-tooltips', resolve_url( 'assets/js/bootstrap-tooltips.js'  ), array( 'jquery' ), VERSION );
    wp_register_script( 'cdemo-media', resolve_url( 'assets/admin/js/cdemo-media-uploader.js' ), array( 'jquery' ), VERSION );

    // Register core modules
    register_core_scripts();

    wp_register_script( 'cdemo-admin', resolve_url( 'assets/admin/js/admin.js' ), array(  'bootstrap-tooltips' ), VERSION );
}


/**
 * Enqueue admin scripts.
 *
 * @action admin_enqueue_scripts
 *
 * @since 1.0.0
 * @return void
 */
function enqueue_admin_scripts() {

    // Global admin
    wp_enqueue_style(  'cdemo-admin' );
    wp_enqueue_script( 'cdemo-admin' );
    wp_enqueue_script( 'jquery' );


    if ( is_listing( get_post_type() ) ) {
        $js = array(
            'jquery-ui-core',
            'jquery-ui-datepicker',
            'jquery-ui-tabs',
            'jquery-ui-autocomplete',
            'jquery-ui-sortable',
            'bootstrap-tooltips',
        );

        $css = array(
            'bootstrap-tooltips',
            'jquery-ui-datepicker'
        );

        $l10n = array(
            'media_uploader_title'  => __( 'Select or upload image', 'cdemo' ),
            'media_uploader_button' => __( 'Set image', 'cdemo' ),
            'media_upload_button'   => __( 'Upload image', 'cdemo' ),

            // Additional variables
            'ajax_url'   => admin_url( 'admin-ajax.php' ),
            'ajax_nonce' => wp_create_nonce( 'cdemo_ajax' )
        );

        wp_enqueue_script( 'cdemo-metabox-media', resolve_url( 'assets/admin/js/multi-media-uploader.js' ), null, VERSION );

        wp_register_script( 'cdemo-metabox', resolve_url( 'assets/admin/js/metabox.js'   ), $js,  VERSION );
        wp_localize_script( 'cdemo-metabox', 'cdemo_metabox_l10n', $l10n );

        wp_enqueue_script( 'cdemo-metabox' );
        wp_enqueue_style(  'cdemo-metabox', resolve_url( 'assets/admin/css/metabox.css' ), $css, VERSION );



    // Load base metabox stylesheet
    } else if ( get_post_type() === 'lead' ) {
        wp_enqueue_style(  'cdemo-metabox', resolve_url( 'assets/admin/css/metabox.css' ), null, VERSION );
    }
}


/**
 * Register scripts for for the WordPress admin.
 *
 * @since 1.0.0
 * @return void
 */
function enqueue_admin_settings_scripts() {

    wp_enqueue_media();
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'cdemo-media' );

    // WP Color Picker styles
    wp_enqueue_style( 'wp-color-picker' );


    /**
     * Settings
     */
    $l10n = array(
        'media_uploader_title'  => __( 'Select or upload image', 'cdemo' ),
        'media_uploader_button' => __( 'Set image', 'cdemo' ),
        'media_upload_button'   => __( 'Upload image', 'cdemo' ),

        // Additional variables
        'ajax_url'   => admin_url( 'admin-ajax.php' ),
        'ajax_nonce' => wp_create_nonce( 'cdemo_ajax' )
    );

    $deps = array(
        'jquery',
        'cdemo-media',
        'wp-color-picker',
        'bootstrap-tooltips'
    );

    wp_register_script( 'cdemo-settings', resolve_url( 'assets/admin/js/settings.js' ), $deps, VERSION );
    wp_localize_script( 'cdemo-settings', 'cdemo_admin_l10n', $l10n );

    wp_enqueue_script( 'cdemo-settings' );


    /**
     * Manage UI fields
     */
    $deps = array(
        'jquery',
        'jquery-ui-draggable',
        'jquery-ui-droppable',
        'jquery-ui-sortable',
    );

    wp_enqueue_script( 'cdemo-manage-ui', resolve_url( 'assets/admin/js/manage-ui.js'   ), $deps, VERSION, true );
    wp_enqueue_style(  'cdemo-manage-ui', resolve_url( 'assets/admin/css/manage-ui.css' ),  null, VERSION );

    /**
     * Sync
     */
    $deps = array(
        'cdemo',
        'jquery-ui-progressbar'
    );

    wp_enqueue_script( 'cdemo-api-sync', resolve_url( 'assets/admin/js/api-sync.js' ), $deps, VERSION );
    wp_enqueue_style(  'cdemo-api-sync', resolve_url( 'assets/admin/css/api-sync.css' ), array( 'jquery-ui' ), VERSION );
}
