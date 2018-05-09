<?php
/**
 * Constant definitions used throughout the plugin.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;

/**
 * @since 1.0.0
 */
const VERSION = '1.1.0';

/**
 * @since 1.0.0
 */
const PLUGIN_ID = 'cdemo';

/**
 * @since 1.0.0
 */
const MIN_PHP_VERSION = '5.4';

/**
 * @since 1.0.0
 */
const INVENTORY_SHORTCODE = 'cdemo-inventory';

/**
 * @since 1.0.0
 */
const DOCS_URL = 'http://inventory.cdemo.com/knowledge-base/';

/**
 * @since 1.0.0
 */
const SUPPORT_URL = 'http://cdemo.com';

/**
 * @since 1.0.0
 */
const PIM_URL = 'http://cdemo.com';


/**
 * Keys for plugin options
 *
 * @since 1.0.0
 */
interface Options {

    /**
     * @since 1.0.0
     */
   const DATA_DRIVER_KEY = 'cdemo_data_driver_key';

    /**
     * @since 1.0.0
     */
   const CURRENCY_CODE = 'cdemo_currency_code';

    /**
     * @since 1.0.0
     */
   const MEASUREMENT_UNITS = 'cdemo_measurement_units';

    /**
     * @since 1.0.0
     */
   const COMPANY_NAME = 'cdemo_company_name';

    /**
     * @since 1.0.0
     */
   const COMPANY_LOGO = 'cdemo_company_logo';

    /**
     * @since 1.0.0
     */
   const PRIMARY_COLOR = 'cdemo_primary_color';

    /**
     * @since 1.0.0
     */
   const HOVER_COLOR = 'cdemo_hover_color';

    /**
     * @since 1.0.0
     */
   const DEFAULT_COLOR = 'cdemo_default_color';

    /**
     * @since 1.0.0
     */
   const PRIMARY_TEXT_COLOR = 'cdemo_primary_text_color';

    /**
     * @since 1.0.0
     */
   const DEFAULT_TEXT_COLOR = 'cdemo_default_text_color';

    /**
     * @since 1.0.0
     */
   const ERASE_OPTIONS = 'cdemo_erase_options';

    /**
     * @since 1.0.0
     */
   const ERASE_CONTENT = 'cdemo_erase_content';

    /**
     * @since 1.0.0
     */
   const SETUP_COMPLETE = 'cdemo_setup_complete';

    /**
     * @since 1.0.0
     */
   const FAVICON = 'cdemo_favicon';

    /**
     * @since 1.0.0
     */
   const COPYRIGHT_TEXT = 'cdemo_copyright_text';

    /**
     * @since 1.0.0
     */
   const TERMS_URL = 'cdemo_terms_conditions_url';

    /**
     * @since 1.0.0
     */
   const TERMS_TEXT = 'cdemo_terms_conditions_text';

    /**
     * @since 1.0.0
     */
   const RECENT_CATEGORIES = 'cdemo_recent_categories';

    /**
     * @since 1.0.0
     */
   const ITEMS_PER_PAGE = 'cdemo_items_per_page';

    /**
     * @since 1.0.0
     */
   const RESULTS_PER_PAGE = 'cdemo_results_per_page';

    /**
     * @since 1.0.0
     */
   const COPYRIGHT = 'cdemo_copyright';

    /**
     * @since 1.0.0
     */
   const STYLES_ENABLED = 'cdemo_styles_enabled';

    /**
     * @since 1.0.0
     */
   const CONTACT_EMAIL = 'cdemo_contact_email';

    /**
     * @since 1.0.0
     */
   const EMAIL_ADDRESS = 'cdemo_email_address';

    /**
     * @since 1.0.0
     */
   const CONTACT_FORM_MSG = 'cdemo_contact_form_message';

    /**
     * @since 1.0.0
     */
   const CONTACT_FORM_MAXLENGTH = 'cdemo_contact_form_max_length';

    /**
     * @since 1.0.0
     */
   const SEND_CONTACT_NOTIFICATION = 'cdemo_send_Contact_notification';

    /**
     * @since 1.0.0
     */
   const CONTACT_EMAIL_SUBJECT = 'cdemo_contact_email_subject';

    /**
     * @since 1.0.0
     */
   const OUTGOING_EMAIL_ADDRESS = 'cdemo_outgoing_email_address';

    /**
     * @since 1.0.0
     */
   const OUTGOING_EMAIL_NAME = 'cdemo_outgoing_email_name';

    /**
     * @since 1.0.0
     */
   const USE_THEME_HEADER = 'cdemo_use_wp_head';

    /**
     * @since 1.0.0
     */
   const SHOW_HEADER = 'cdemo_show_header';

    /**
     * @since 1.0.0
     */
   const SHOW_FOOTER = 'cdemo_show_footer';

    /**
     * @since 1.0.0
     */
   const SEARCH_PAGE_ID = 'cdemo_search_page_id';

    /**
     * @since 1.0.0
     */
   const POST_TYPE_CONFIG = 'cdemo_post_type_config';

    /**
     * @since 1.0.0
     */
   const LEAD_COLLECTION = 'cdemo_lead_collection';

    /**
     * @since 1.0.0
     */
   const GF_CONTACT_HTML = 'cdemo_gf_contact_html';

    /**
     * @since 1.0.0
     */
   const GF_FORMS_CONFIG = 'cdemo_gf_forms_config';

    /**
     * @since 1.0.0
     */
   const UI_FIELDS_RESULTS_PAGE_CONFIG = 'cdemo_ui_fields_results_page_config';

    /**
     * @since 1.0.0
     */
   const UI_FIELDS_DETAILS_PAGE_CONFIG = 'cdemo_ui_fields_details_page_config';

    /**
     * @since 1.0.0
     */
   const UI_FIELDS_SEARCH_FORM_CONFIG = 'cdemo_ui_fields_search_form_config';

    /**
     * @since 1.0.0
     */
   const LAST_SYNC = 'cdemo_last_sync_timestamp';
}


/**
 * Option keys for customizable strings.
 *
 * @since 1.0.0
 */
interface Strings {

    /**
     * @since 1.0.0
     */
    const PRICE_MSRP = 'cdemo_string_price_msrp';

    /**
     * @since 1.0.0
     */
    const PRICE_LISTING = 'cdemo_string_price_listing';

    /**
     * @since 1.0.0
     */
    const PRICE_LISTING_DISCOUNT = 'cdemo_string_price_listing_discount';
}