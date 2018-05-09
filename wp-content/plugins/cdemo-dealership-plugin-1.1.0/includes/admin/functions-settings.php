<?php
/**
 * Functions for managing admin settings pages.
 *
 * @since 1.0.0
 * @package cdemo
 * @subpackage admin
 */
namespace cdemo;


// Output settings tabs
add_action( 'cdemo_menu_page-cdemo-settings-tab', 'cdemo\do_menu_page_settings_tabs' );

// Output settings page sections
add_action( 'cdemo-menu_page-templates-section', 'cdemo\do_templates_settings_page_sections' );

// Add settings sections
add_action( 'admin_init', 'cdemo\add_settings_sections' );

// Add settings fields
add_action( 'admin_init', 'cdemo\add_settings_fields' );

// Validate the API key
add_filter( 'pre_update_option_' . Options::DATA_DRIVER_KEY, 'cdemo\filter_api_key', 10, 2 );


/**
 * Output settings page tabs.
 *
 * @param $tab
 *
 * @action cdemo_menu_page-cdemo-settings-tab
 *
 * @since 1.0.0
 * @return void
 */
function do_menu_page_settings_tabs( $tab ) {

    switch ( $tab ) {

        case 'display':
            $args = array(
                'page'         => 'cdemo_display',
                'option_group' => 'cdemo-display'
            );

            get_template( 'admin/tab-settings-generic', $args );

            break;



        case 'appearance':
            $args = array(
                'page'         => 'cdemo_appearance',
                'option_group' => 'cdemo-appearance'
            );

            get_template( 'admin/tab-settings-generic', $args );

            break;


        case 'advanced':
            $args = array(
                'page'         => 'cdemo_advanced',
                'option_group' => 'cdemo-advanced'
            );

            get_template( 'admin/tab-settings-generic', $args );

            break;


        case 'leads':
            $args = array(
                'page'         => 'cdemo_leads',
                'option_group' => 'cdemo-leads'
            );

            get_template( 'admin/tab-settings-generic', $args );

            break;

        /**
         * Templates tab has custom sub-sections.
         */
        case 'templates':
            $sections = array(
                'manage-results-page' => __( 'Results Page', 'cdemo' ),
                'manage-details-page' => __( 'Details Page', 'cdemo' ),
                'manage-search-form'  => __( 'Search Form', 'cdemo' )
            );

            do_menu_page_sections( 'templates', $sections );

            break;

        /**
         * Data Driver integration
         */
        case 'pim-sync':
            $args = array(
                'page'         => 'cdemo_data_driver',
                'option_group' => 'cdemo-data-driver'
            );

            get_template( 'admin/tab-settings-data-driver', $args );

            break;

        /**
         * Always fallback to the general tab if no tab is passed.
         */
        default:
        case 'general':
            $args = array(
                'page'         => 'cdemo_general',
                'option_group' => 'cdemo-general'
            );

            get_template( 'admin/tab-settings-generic', $args );

            break;

    }

}


/**
 * Output the sections for the templates settings page.
 *
 * @param $section
 *
 * @action cdemo-menu_page-templates-section
 *
 * @since 1.0.0
 * @return void
 */
function do_templates_settings_page_sections( $section ) {

    // Get all listing types
    $categories = get_listing_post_type_objects();

    // Get the current category
    $context = get_request_var( 'category', current( $categories )->name );

    $defaults = array(
        'categories' => $categories,
        'context'    => $context,
        'fields'     => get_manage_ui_fields( $context ),
    );

    switch ( $section ) {

        case 'manage-details-page':
            $args = array(
                'option'       => Options::UI_FIELDS_DETAILS_PAGE_CONFIG,
                'config'       => get_ui_fields_config( Options::UI_FIELDS_DETAILS_PAGE_CONFIG, $context ),
                'option_group' => 'cdemo-manage-details-page'
            );

            get_template( 'admin/manage-ui-fields', wp_parse_args( $args, $defaults ) );

            break;

        case 'manage-results-page':
            $args = array(
                'option'       => Options::UI_FIELDS_RESULTS_PAGE_CONFIG,
                'config'       => get_ui_fields_config( Options::UI_FIELDS_RESULTS_PAGE_CONFIG, $context ),
                'option_group' => 'cdemo-manage-results-page'
            );

            get_template( 'admin/manage-ui-fields', wp_parse_args( $args, $defaults ) );

            break;

        case 'manage-search-form':
            $context = get_request_var( 'context', 'global' );

            $args = array(
                'option'       => Options::UI_FIELDS_SEARCH_FORM_CONFIG,
                'fields'       => get_manage_ui_fields_search_form( $context ),
                'config'       => get_ui_fields_config_search_form( $context ),
                'context'      => get_request_var( 'context', 'global' ),
                'option_group' => 'cdemo-manage-search-form'
            );

            get_template( 'admin/manage-ui-search-form', wp_parse_args( $args, $defaults ) );

            break;

    }

}


/**
 * Register plugin settings page sections.
 *
 * @action admin_init
 *
 * @since 1.0.0
 * @return void
 */
function add_settings_sections() {

    add_settings_section( 'general',    __( 'General',    'cdemo' ), '', 'cdemo_general' );
    add_settings_section( 'appearance', __( 'Appearance', 'cdemo' ), '', 'cdemo_appearance' );
    add_settings_section( 'advanced',   __( 'Advanced',   'cdemo' ), '', 'cdemo_advanced' );

    add_settings_section( 'data-driver-api', __( 'cDemo PIM API',    'cdemo' ), '', 'cdemo_data_driver' );
    add_settings_section( 'strings',         __( 'Strings & Labels', 'cdemo' ), '', 'cdemo_display' );

    // TODO: Separate this into a module
    if ( class_exists( '\GFAPI' ) ) {
        add_settings_section( 'leads', __( 'Leads', 'cdemo' ), '', 'cdemo_leads' );
    }

    add_settings_section( 'contact-form', __( 'Contact Form', 'cdemo' ), '', 'cdemo_leads' );

}


/**
 * Register plugin settings page fields.
 *
 * @action admin_init
 *
 * @since 1.0.0
 * @return void
 */
function add_settings_fields() {

    /**
     * General plugin settings
     *
     * @since 1.0.0
     */
    add_settings_field(
        'cdemo_company_logo',
        __( 'Company Logo', 'cdemo' ),
        'cdemo\render_media_field',
        'cdemo_general',
        'general',
        array(
            'value'      => get_option( Options::COMPANY_LOGO ),
            'attributes' => array(
                'id'    => 'cdemo-company-logo',
                'name'  => Options::COMPANY_LOGO,
                'class' => 'cdemo-media-uploader'
            )
        )
    );

    add_settings_field(
        'cdemo_favicon',
        __( 'Favicon', 'cdemo' ),
        'cdemo\render_media_field',
        'cdemo_general',
        'general',
        array(
            'value'      => get_option( Options::FAVICON ),
            'attributes' => array(
                'id'    => 'cdemo-favicon',
                'name'  => Options::FAVICON,
                'class' => 'cdemo-media-uploader'
            )
        )
    );

    add_settings_field(
        'cdemo_company_name',
        __( 'Company Name', 'cdemo' ),
        'cdemo\render_text_field',
        'cdemo_general',
        'general',
        array(
            'value'      => get_option( Options::COMPANY_NAME ),
            'attributes' => array(
                'id'    => 'cdemo-company-name',
                'name'  => Options::COMPANY_NAME,
                'class' => 'regular-text',
                'type'  => 'text'
            )
        )
    );

	add_settings_field(
		'cdemo_copyright',
		__( 'Copyright', 'cdemo' ),
		'cdemo\render_text_field',
        'cdemo_general',
		'general',
		array(
			'value'      => get_option( Options::COPYRIGHT ),
			'attributes' => array(
				'id'    => 'cdemo-copyright',
				'name'  => Options::COPYRIGHT,
				'class' => 'regular-text',
                                'type'  => 'text'
			)
		)
	);

    add_settings_field(
        'cdemo_currency_code',
        __( 'Currency Code', 'cdemo' ),
        'cdemo\render_select_box',
        'cdemo_general',
        'general',
        array(
            'value'      => get_option( Options::CURRENCY_CODE ),
            'attributes' => array(
                'id'    => 'cdemo-currency-code',
                'name'  => Options::CURRENCY_CODE,
                'class' => 'regular-text'
            ),
            'config' => array(
                'options' => array(
                    array(
                        'title'      => __( 'Dollars (Canadian)', 'cdemo' ),
                        'attributes' => array(
                            'value' => 'cad'
                        )
                    ),
                    array(
                        'title'      => __( 'Dollars (United States)', 'cdemo' ),
                        'attributes' => array(
                            'value' => 'usd'
                        )
                    )
                )
            )
        )
    );

    add_settings_field(
        'cdemo_measurement_units',
        __( 'Unit of Measurement', 'cdemo' ),
        'cdemo\render_select_box',
        'cdemo_general',
        'general',
        array(
            'value'      => get_option( Options::MEASUREMENT_UNITS ),
            'attributes' => array(
                'id'    => 'cdemo-measurement-units',
                'name'  => Options::MEASUREMENT_UNITS,
                'class' => 'regular-text'
            ),
            'config' => array(
                'options' => array(
                    array(
                        'title'      => __( 'Metric', 'cdemo' ),
                        'attributes' => array(
                            'value' => 'metric'
                        )
                    ),
                    array(
                        'title'      => __( 'Imperial', 'cdemo' ),
                        'attributes' => array(
                            'value' => 'imperial'
                        )
                    )
                )
            )
        )
    );

    add_settings_field(
        'cdemo_terms_url',
        __( 'Terms & Conditions URL', 'cdemo' ),
        'cdemo\render_text_field',
        'cdemo_general',
        'general',
        array(
            'value'      => get_option( Options::TERMS_URL ),
            'attributes' => array(
                'id'    => 'cdemo-terms-url',
                'name'  => Options::TERMS_URL,
                'class' => 'regular-text',
                'type'  => 'url'
            )
        )
    );

    add_settings_field(
        'cdemo_terms_text',
        __( 'Terms & Conditions Text', 'cdemo' ),
        'cdemo\render_text_field',
        'cdemo_general',
        'general',
        array(
            'value'      => get_option( Options::TERMS_TEXT ),
            'attributes' => array(
                'id'    => 'cdemo-terms-text',
                'name'  => Options::TERMS_TEXT,
                'class' => 'regular-text',
                'type'  => 'text'
            )
        )
    );


    /**
     * Display settings
     *
     * @since 1.0.0
     */
    add_settings_field(
        'cdemo_price_msrp',
        __( 'MSPR', 'cdemo' ),
        'cdemo\render_text_field',
        'cdemo_display',
        'strings',
        array(
            'value'      => get_option( Strings::PRICE_MSRP ),
            'attributes' => array(
                'id'    => 'cdemo-price-msrp',
                'name'  => Strings::PRICE_MSRP,
                'class' => 'regular-text',
                'type'  => 'text'
            )
        )
    );

    add_settings_field(
        'cdemo_price_listing',
        __( 'Listing Price', 'cdemo' ),
        'cdemo\render_text_field',
        'cdemo_display',
        'strings',
        array(
            'value'      => get_option( Strings::PRICE_LISTING ),
            'attributes' => array(
                'id'    => 'cdemo-price-listing',
                'name'  => Strings::PRICE_LISTING,
                'class' => 'regular-text',
                'type'  => 'text'
            )
        )
    );

    add_settings_field(
        'cdemo_price_listing_discount',
        __( 'Listing Discount', 'cdemo' ),
        'cdemo\render_text_field',
        'cdemo_display',
        'strings',
        array(
            'value'      => get_option( Strings::PRICE_LISTING_DISCOUNT ),
            'attributes' => array(
                'id'    => 'cdemo-price-listing-discount',
                'name'  => Strings::PRICE_LISTING_DISCOUNT,
                'class' => 'regular-text',
                'type'  => 'text'
            )
        )
    );

    /**
     * Appearance settings
     *
     * @since 1.0.0
     */
    add_settings_field(
        'cdemo_use_wp_head',
        __( 'Use Theme Header', 'cdemo' ),
        'cdemo\render_check_box',
        'cdemo_appearance',
        'appearance',
        array(
            'value'           => get_option( Options::USE_THEME_HEADER ),
            'description'     => __( 'Use the theme\'s header and footer', 'cdemo' ),
            'attributes'      => array(
                'id'    => 'cdemo-use-theme-header',
                'name'  => Options::USE_THEME_HEADER
            )
        )
    );
    
    add_settings_field(
        'cdemo_show_header',
        __( 'Plugin Custom Header', 'cdemo' ),
        'cdemo\render_check_box',
        'cdemo_appearance',
        'appearance',
        array(
            'value'       => get_option( Options::SHOW_HEADER ),
            'description' => __( 'Toggle the plugin\'s default page header', 'cdemo' ),
            'attributes' => array(
                'id'    => 'cdemo-show-header',
                'name'  => Options::SHOW_HEADER
            )
        )
    );

    add_settings_field(
        'cdemo_show_footer',
        __( 'Plugin Custom Footer', 'cdemo' ),
        'cdemo\render_check_box',
        'cdemo_appearance',
        'appearance',
        array(
            'value'       => get_option( Options::SHOW_FOOTER ),
            'description' => __( 'Toggle the plugin\'s default page footer', 'cdemo' ),
            'attributes' => array(
                'id'    => 'cdemo-show-footer',
                'name'  => Options::SHOW_FOOTER
            )
        )
    );

    add_settings_field(
        'cdemo_primary_color',
        __( 'Primary Color', 'cdemo' ),
        'cdemo\render_text_field',
        'cdemo_appearance',
        'appearance',
        array(
            'value'      => get_option( Options::PRIMARY_COLOR ),
            'attributes' => array(
                'id'    => 'cdemo-primary-color',
                'name'  => Options::PRIMARY_COLOR,
                'class' => 'cdemo-color-picker',
            )
        )
    );

    add_settings_field(
        'cdemo_default_color',
        __( 'Default Color', 'cdemo' ),
        'cdemo\render_text_field',
        'cdemo_appearance',
        'appearance',
        array(
            'value'      => get_option( Options::DEFAULT_COLOR ),
            'attributes' => array(
                'id'    => 'cdemo-default-color',
                'name'  => Options::DEFAULT_COLOR,
                'class' => 'cdemo-color-picker'
            )
        )
    );

    add_settings_field(
        'cdemo_hover_color',
        __( 'Hover Color', 'cdemo' ),
        'cdemo\render_text_field',
        'cdemo_appearance',
        'appearance',
        array(
            'value'      => get_option( Options::HOVER_COLOR ),
            'attributes' => array(
                'id'    => 'cdemo-hover-color',
                'name'  => Options::HOVER_COLOR,
                'class' => 'cdemo-color-picker'
            )
        )
    );

	add_settings_field(
		'cdemo_primary_text_color',
		__( 'Primary Text Color', 'cdemo' ),
		'cdemo\render_text_field',
        'cdemo_appearance',
		'appearance',
		array(
			'value'      => get_option( Options::PRIMARY_TEXT_COLOR ),
			'attributes' => array(
				'id'    => 'cdemo-primary-text-color',
				'name'  => Options::PRIMARY_TEXT_COLOR,
				'class' => 'cdemo-color-picker'
			)
		)
	);

	add_settings_field(
		'cdemo_default_text_color',
		__( 'Default Text Color', 'cdemo' ),
		'cdemo\render_text_field',
        'cdemo_appearance',
		'appearance',
		array(
			'value'      => get_option( Options::DEFAULT_TEXT_COLOR ),
			'attributes' => array(
				'id'    => 'cdemo-default-text-color',
				'name'  => Options::DEFAULT_TEXT_COLOR,
				'class' => 'cdemo-color-picker'
			)
		)
	);


    /**
     * Leads settings
     *
     * @todo Separate gravity forms settings
     * @since 1.0.0
     */
    if ( class_exists( '\GFAPI' ) ) {

        add_settings_field(
            'cdemo_lead_collection',
            __( 'Lead Collection', 'cdemo' ),
            'cdemo\render_select_box',
            'cdemo_leads',
            'leads',
            array(
                'value'      => get_option( Options::LEAD_COLLECTION ),
                'attributes' => array(
                    'id'    => 'cdemo-lead-collection',
                    'name'  => Options::LEAD_COLLECTION,
                    'class' => 'regular-text'
                ),
                'config' => array(
                    'options' => array(
                        array(
                            'title' => __( 'Default', 'cdemo' ),
                            'attributes' => array(
                                'value' => 'default'
                            )
                        ),
                        array(
                            'title' => __( 'Gravity Forms', 'cdemo' ),
                            'attributes' => array(
                                'value' => 'gravity_forms'
                            )
                        )
                    )
                )
            )
        );

    }

    if ( using_default_leads() ) {

        // Contact Form Settings
        add_settings_field(
            'cdemo_email_address',
            __( 'Email Address', 'cdemo' ),
            'cdemo\render_text_field',
            'cdemo_leads',
            'contact-form',
            array(
                'value'      => get_option( Options::EMAIL_ADDRESS ),
                'attributes' => array(
                    'id'    => 'cdemo-email-address',
                    'name'  => Options::EMAIL_ADDRESS,
                    'class' => 'regular-text',
                    'type'  => 'email'
                )
            )
        );

        add_settings_field(
            'cdemo_outgoing_email_address',
            __( 'Outgoing Email Address', 'cdemo' ),
            'cdemo\render_text_field',
            'cdemo_leads',
            'contact-form',
            array(
                'value'      => get_option( Options::OUTGOING_EMAIL_ADDRESS ),
                'attributes' => array(
                    'id'    => 'cdemo-outgoing-email-address',
                    'name'  => Options::OUTGOING_EMAIL_ADDRESS,
                    'class' => 'regular-text',
                    'type'  => 'email'
                )
            )
        );

        add_settings_field(
            'cdemo_outgoing_email_name',
            __( 'Outgoing Email Name', 'cdemo' ),
            'cdemo\render_text_field',
            'cdemo_leads',
            'contact-form',
            array(
                'value'      => get_option( Options::OUTGOING_EMAIL_NAME ),
                'attributes' => array(
                    'id'    => 'cdemo-outgoing-email-name',
                    'name'  => Options::OUTGOING_EMAIL_NAME,
                    'class' => 'regular-text',
                    'type'  => 'text'
                )
            )
        );

        add_settings_field(
            'cdemo_send_contact_notification',
            __( 'Send Notification', 'cdemo' ),
            'cdemo\render_check_box',
            'cdemo_leads',
            'contact-form',
            array(
                'value'       => get_option( Options::SEND_CONTACT_NOTIFICATION ),
                'attributes'  => array(
                    'id'   => 'cdemo-send-contact-notification',
                    'name' => Options::SEND_CONTACT_NOTIFICATION
                ),
                'description' => __( 'Send email notification on contact form submission', 'cdemo' )
            )
        );

        add_settings_field(
            'cdemo_contact_form_message',
            __( 'Confirmation Message', 'cdemo' ),
            'cdemo\render_text_field',
            'cdemo_leads',
            'contact-form',
            array(
                'value'      => get_option( Options::CONTACT_FORM_MSG ),
                'attributes' => array(
                    'id'    => 'cdemo-contact-form-msg',
                    'name'  => Options::CONTACT_FORM_MSG,
                    'class' => 'regular-text',
                    'type'  => 'text'
                )
            )
        );

        add_settings_field(
            'cdemo_contact_form_max_length',
            __( 'Comments Max Characters', 'cdemo' ),
            'cdemo\render_text_field',
            'cdemo_leads',
            'contact-form',
            array(
                'value'      => get_option( Options::CONTACT_FORM_MAXLENGTH ),
                'attributes' => array(
                    'id'    => 'cdemo-contact-form-max-length',
                    'name'  => Options::CONTACT_FORM_MAXLENGTH,
                    'class' => 'regular-text',
                    'type'  => 'number'
                )
            )
        );

        add_settings_field(
            'cdemo_contact_form_email_subject',
            __( 'Email Subject', 'cdemo' ),
            'cdemo\render_text_field',
            'cdemo_leads',
            'contact-form',
            array(
                'value'      => get_option( Options::CONTACT_EMAIL_SUBJECT ),
                'attributes' => array(
                    'id'    => 'cdemo-contact-form-email-subject',
                    'name'  => Options::CONTACT_EMAIL_SUBJECT,
                    'class' => 'regular-text',
                    'type'  => 'text'
                )
            )
        );

        add_settings_field(
            'cdemo_contact_email',
            __( 'Email Template', 'cdemo' ),
            'cdemo\render_editor',
            'cdemo_leads',
            'contact-form',
            array(
                'id'         => 'cdemo_contact_email',
                'value'      => get_option( Options::CONTACT_EMAIL ),
                'config' => array(
                    'textarea_name' => Options::CONTACT_EMAIL
                )
            )
        );

    } else {

        add_settings_field(
            'cdemo_gf_forms_config',
            __( 'Gravity Forms', 'cdemo' ),
            'cdemo\render_gf_forms_config',
            'cdemo_leads',
            'contact-form',
            array(
                'value' => get_option( Options::GF_FORMS_CONFIG )
            )
        );

        add_settings_field(
            'cdemo_gf_contact_form_html',
            __( 'Form Content', 'cdemo' ),
            'cdemo\render_editor',
            'cdemo_leads',
            'contact-form',
            array(
                'id'     => 'cdemo-gf-contact-form-html',
                'value'  => get_option( Options::GF_CONTACT_HTML ),
                'config' => array(
                    'textarea_name' => Options::GF_CONTACT_HTML,
                    'textarea_rows' => 8
                )
            )
        );

    }


    /**
     * Advanced settings
     *
     * @since 1.0.0
     */

    add_settings_field(
        'cdemo_styles_enabled',
        __( 'Plugin CSS', 'cdemo' ),
        'cdemo\render_check_box',
        'cdemo_advanced',
        'advanced',
        array(
            'value'       => get_option( Options::STYLES_ENABLED ),
            'description' => __( 'Uncheck this if you plan on css-ing the frontend appearance', 'cdemo' ),
            'attributes' => array(
                'id'    => 'cdemo-styles-enabled',
                'name'  => Options::STYLES_ENABLED
            )
        )
    );

    add_settings_field(
        'cdemo_search_page_id',
        __( 'Inventory Page', 'cdemo' ),
        'cdemo\render_posts_dropdown',
        'cdemo_advanced',
        'advanced',
        array(
            'value'           => get_option( Options::SEARCH_PAGE_ID ),
            'attributes'      => array(
                'id'    => 'cdemo-search-page-id',
                'name'  => Options::SEARCH_PAGE_ID,
                'class' => 'regular-text'
            ),
            'description' => __( 'This is the page that all search results will lead to', 'cdemo' ),
            'config' => array(
                'post_type' => 'page',
                'default_option_title' => __( 'Select a Page', 'cdemo' )
            )
        )
    );

    add_settings_field(
        'cdemo_post_types',
        __( 'Categories', 'cdemo' ),
        'cdemo\render_post_type_options',
        'cdemo_advanced',
        'advanced',
        array(
            'value' => array_merge(
                default_post_types(), get_option( Options::POST_TYPE_CONFIG, array() )
            ),
            'attributes' => array(
                'id'    => 'cdemo-post-types',
                'name'  => Options::POST_TYPE_CONFIG,
                'class' => 'regular-text'
            )
        )
    );

    add_settings_field(
        'cdemo_erase_options',
        __( 'Erase Options', 'cdemo' ),
        'cdemo\render_check_box',
        'cdemo_advanced',
        'advanced',
        array(
            'value'           => get_option( Options::ERASE_OPTIONS ),
            'description'     => __( 'Erase all plugin settings on uninstall', 'cdemo' ),
            'attributes'      => array(
                'id'    => 'cdemo-erase-options',
                'name'  => Options::ERASE_OPTIONS
            )
        )
    );

    add_settings_field(
        'cdemo_erase_content',
        __( 'Erase Content', 'cdemo' ),
        'cdemo\render_check_box',
        'cdemo_advanced',
        'advanced',
        array(
            'value'      => get_option( Options::ERASE_CONTENT ),
            'description'     => __( 'Erase all plugin content and listings on plugin install', 'cdemo' ),
            'attributes' => array(
                'id'    => 'cdemo-erase-content',
                'name'  => Options::ERASE_CONTENT
            )
        )
    );


    /**
     * Data Driver settings.
     *
     * @since 1.0.0
     */
    add_settings_field(
        'cdemo_data_driver_key',
        __( 'API Key', 'cdemo' ),
        'cdemo\render_text_field',
        'cdemo_data_driver',
        'data-driver-api',
        array(
            'value'       => get_option( Options::DATA_DRIVER_KEY ),
            'description' => __( 'cDemo PIM API Key', 'cdemo' ),
            'attributes'  => array(
                'id'    => 'cdemo-data-driver-key',
                'class' => 'regular-text',
                'type'  => 'text',
                'name'  => Options::DATA_DRIVER_KEY
            )
        )
    );

}


/**
 * Filter the Data Driver API key to ensure that it is correct.
 *
 * @filter pre_update_option_cdemo_data_driver_key
 *
 * @param string $new
 * @param string $old
 *
 * @since 1.0.0
 * @return string
 */
function filter_api_key( $new, $old ) {

    $key = trim( $new );

    if ( !empty( $key ) && $key != $old ) {
        $key = DataDriverClient::test_connection( $key ) ? $key : '';

        if ( empty( $key ) && is_admin() ) {
            add_settings_error( 'cdemo', 'data-driver--key', __( 'We were unable to verify your API key' ) );
        }

    }

    return $key;

}



function settings_field( $args ) {

    if ( isset( $args['field'] ) ) {
        call_user_func( $args['field']->render_callback, $args['field'] );
    }

}


function filter_lead_collection( $method ) {

    if ( !class_exists( '\GFAPI' ) ) {
        return 'default';
    }

    return $method;

}

add_filter( 'option_' . Options::LEAD_COLLECTION, 'cdemo\filter_lead_collection' );
