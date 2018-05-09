<?php
/**
 * Functions for WordPress Settings API.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;


// Register settings with the Settings API
add_action( 'init', 'cdemo\register_settings' );

// Flush permalinks
add_action( 'add_option_'    . Options::POST_TYPE_CONFIG, 'cdemo\set_post_rewrite_rules' );
add_action( 'update_option_' . Options::POST_TYPE_CONFIG, 'cdemo\set_post_rewrite_rules' );


/**
 * Register settings with the WordPress Settings API.
 *
 * @action init
 *
 * @since 1.0.0
 * @return void
 */
function register_settings() {

    /**
     * General settings
     *
     * @since 1.0.0
     */
    register_setting( 'cdemo-general', Options::COMPANY_NAME, array(
        'type'              => 'string',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_setting( 'cdemo-general', Options::COMPANY_LOGO, array(
        'type'              => 'string',
        'default'           => resolve_url( 'assets/images/cdemo-logo.png' ),
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_setting( 'cdemo-general', Options::COPYRIGHT, array(
        'type'              => 'string',
        'default'           => __( 'Copyright © cDemo Mobile Solutions', 'cdemo' ),
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_setting( 'cdemo-general', Options::FAVICON, array(
        'type'              => 'string',
        'default'           => resolve_url( 'assets/images/favicon.ico' ),
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_setting( 'cdemo-general', Options::CURRENCY_CODE, array(
        'type'              => 'string',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_setting( 'cdemo-general', Options::MEASUREMENT_UNITS, array(
        'type'              => 'string',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_setting( 'cdemo-general', Options::TERMS_TEXT, array(
        'type'              => 'string',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_setting( 'cdemo-general', Options::TERMS_URL, array(
        'type'              => 'string',
        'sanitize_callback' => 'esc_url_raw'
    ) );


    /**
     * Display settings
     *
     * @since 1.0.0
     */
    register_setting( 'cdemo-display', Strings::PRICE_MSRP, array(
        'type'              => 'string',
        'default'           => __( 'MSRP', 'cdemo' ),
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_setting( 'cdemo-display', Strings::PRICE_LISTING, array(
        'type'              => 'string',
        'default'           => __( 'Our Price', 'cdemo' ),
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    register_setting( 'cdemo-display', Strings::PRICE_LISTING_DISCOUNT, array(
        'type'              => 'string',
        'default'           => __( 'Savings', 'cdemo' ),
        'sanitize_callback' => 'sanitize_text_field'
    ) );


    /**
     * Appearance settings
     *
     * @since 1.0.0
     */
    register_setting( 'cdemo-appearance', Options::USE_THEME_HEADER, array(
        'type'              => 'string',
        'default'           => 'on',
        'sanitize_callback' => 'cdemo\sanitize_checkbox'
    ) );
    
    register_setting( 'cdemo-appearance', Options::SHOW_HEADER, array(
        'type'              => 'string',
        'default'           => 'on',
        'sanitize_callback' => 'cdemo\sanitize_checkbox',
    ) );

    register_setting( 'cdemo-appearance', Options::SHOW_FOOTER, array(
        'type'              => 'string',
        'default'           => '',
        'sanitize_callback' => 'cdemo\sanitize_checkbox',
    ) );

    register_setting( 'cdemo-appearance', Options::PRIMARY_COLOR, array(
        'type'              => 'string',
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    register_setting( 'cdemo-appearance', Options::DEFAULT_COLOR, array(
        'type'              => 'string',
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    register_setting( 'cdemo-appearance', Options::HOVER_COLOR, array(
        'type'              => 'string',
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color'
    ) );

    register_setting( 'cdemo-appearance', Options::PRIMARY_TEXT_COLOR, array(
        'type'              => 'string',
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color'
    ) );

    register_setting( 'cdemo-appearance', Options::DEFAULT_TEXT_COLOR, array(
        'type'              => 'string',
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color'
    ) );


    /**
     * Leads settings
     *
     * @since 1.0.0
     */
    register_setting( 'cdemo-leads', Options::LEAD_COLLECTION, array(
        'type'              => 'string',
        'default'           => 'default',
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    // Contact form
    if ( using_default_leads() ) {

        register_setting( 'cdemo-leads', Options::EMAIL_ADDRESS, array(
            'type'              => 'string',
            'default'           => get_option( 'admin_email' ),
            'sanitize_callback' => 'sanitize_email'
        ) );

        register_setting( 'cdemo-leads', Options::OUTGOING_EMAIL_ADDRESS, array(
            'type'              => 'string',
            'default'           => get_option( 'admin_email' ),
            'sanitize_callback' => 'sanitize_email'
        ) );

        register_setting( 'cdemo-leads', Options::OUTGOING_EMAIL_NAME, array(
            'type'              => 'string',
            'default'           => __( 'Site Administrator', 'cdemo' ),
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        register_setting( 'cdemo-leads', Options::SEND_CONTACT_NOTIFICATION, array(
            'type'              => 'string',
            'default'           => 'on',
            'sanitize_callback' => 'cdemo\sanitize_checkbox'
        ) );

        register_setting( 'cdemo-leads', Options::CONTACT_FORM_MSG, array(
            'type'              => 'string',
            'default'           => __( 'Thank you, Your contact request has been sent', 'cdemo' ),
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        register_setting( 'cdemo-leads', Options::CONTACT_FORM_MAXLENGTH, array(
            'type'              => 'int',
            'default'           => 250,
            'sanitize_callback' => 'absint'
        ) );

        register_setting( 'cdemo-leads', Options::CONTACT_EMAIL_SUBJECT, array(
            'type'              => 'string',
            'default'           => __( 'New contact form submission', 'cdemo' ),
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        register_setting( 'cdemo-leads', Options::CONTACT_EMAIL, array(
            'type'              => 'string',
            'default'           => file_get_contents( resolve_path( 'resources/email-templates/contact-form.html' ) ),
            'sanitize_callback' => 'wp_kses_post'
        ) );

    } else {

        register_setting( 'cdemo-leads', Options::GF_CONTACT_HTML, array(
            'type'              => 'string',
            'default'           => file_get_contents( resolve_path( 'resources/forms/gf-contact-form.html' ) ),
            'sanitize_callback' => 'wp_kses_post'
        ) );

        register_setting( 'cdemo-leads', Options::GF_FORMS_CONFIG, array(
            'type'              => 'string',
            'default'           => array(),
            'sanitize_callback' => 'cdemo\sanitize'
        ) );

    }


    /**
     * Advanced Settings
     *
     * @since 1.0.0
     */
    register_setting( 'cdemo-advanced', Options::ERASE_OPTIONS, array(
        'type'              => 'string',
        'sanitize_callback' => 'cdemo\sanitize_checkbox'
    ) );

    register_setting( 'cdemo-advanced', Options::STYLES_ENABLED, array(
        'type'              => 'string',
        'default'           => 'on',
        'sanitize_callback' => 'cdemo\sanitize_checkbox',
    ) );

    register_setting( 'cdemo-advanced', Options::ERASE_CONTENT, array(
        'type'              => 'string',
        'sanitize_callback' => 'cdemo\sanitize_checkbox'
    ) );

    register_setting( 'cdemo-advanced', Options::SEARCH_PAGE_ID, array(
        'type'              => 'integer',
        'sanitize_callback' => 'cdemo\sanitize_post_id'
    ) );

    register_setting( 'cdemo-advanced', Options::POST_TYPE_CONFIG, array(
        'type'              => 'string',
        'default'           => default_post_types(),
        'sanitize_callback' => 'cdemo\sanitize'
    ) );


    /**
     * Manage UI
     *
     * @since 1.0.0
     */
    register_setting( 'cdemo-manage-results-page', Options::UI_FIELDS_RESULTS_PAGE_CONFIG, array(
        'default' => get_default_results_page_field_config(),
        'sanitize_callback' => 'cdemo\sanitize'
    ) );

    register_setting( 'cdemo-manage-details-page', Options::UI_FIELDS_DETAILS_PAGE_CONFIG, array(
        'default' => get_default_details_page_field_config(),
        'sanitize_callback' => 'cdemo\sanitize'
    ) );

    register_setting( 'cdemo-manage-search-form', Options::UI_FIELDS_SEARCH_FORM_CONFIG, array(
        'default' => get_default_search_form_field_config(),
        'sanitize_callback' => 'cdemo\sanitize'
    ) );

    /**
     * Data Driver
     *
     * @since 1.0.0
     */
    register_setting( 'cdemo-data-driver', Options::DATA_DRIVER_KEY, array(
        'type'              => 'string',
        'sanitize_callback' => 'sanitize_text_field'
    ) );


}


/**
 * Get the default settings value for the results page fields.
 *
 * @since 1.0.0
 * @return array
 */
function get_default_results_page_field_config() {

    $defaults = array();

    foreach ( ui_fields() as $id => $field ) {

        foreach ( $field['context'] as $context ) {
            $defaults[ $context ][ $id ] = $field['default'];
        }

    }

    foreach ( $defaults as $context => $config ) {
        $defaults[ $context ] = array_slice( $config, 0, 9 );
    }

    return $defaults;

}


/**
 * Get the default settings value for the details page fields.
 *
 * @since 1.0.0
 * @return array
 */
function get_default_details_page_field_config() {

    $defaults = array();

    foreach ( ui_fields() as $id => $field ) {

        foreach ( $field['context'] as $context ) {
            $defaults[ $context ][ $id ] = $field['default'];
        }

    }

    return $defaults;

}


/**
 * Get the default settings for the search form configuration.
 *
 * @since 1.0.0
 * @return array
 */
function get_default_search_form_field_config() {

    $defaults = array();

    foreach ( ui_fields_search_form() as $id => $field ) {

        foreach ( $field['context'] as $context ) {

            if ( empty( $defaults[ $context ] ) ) {
                $defaults[ $context ] = array();
            }

            $defaults[ $context ][ $id ] = $field['defaults'];

        }

    }

    return $defaults;

}


/**
 * Flush the WordPress rewrite rules.
 *
 * @action add_option_cdemo_post_type_config
 * @action update_option_cdemo_post_type_config
 *
 * @since 1.0.0
 * @return void
 */
function set_post_rewrite_rules() {

    // Register all post types with new slugs
    register_listing_post_types();

    // Update the permalink cache
    flush_rewrite_rules();

}