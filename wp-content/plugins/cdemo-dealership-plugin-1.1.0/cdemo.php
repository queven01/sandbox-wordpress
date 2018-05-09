<?php
/**
 * Plugin Name: cDemo - Vehicle Dealer Inventory Management
 * Version: 1.1.0
 * Author: cDemo, Smartcat
 * Author URI: http://www.cdemo.com/
 * Plugin URI: http://#
 * Description: Turn your website into a vehicle dealership.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;


// Pull in constant definitions
include_once 'constants.php';


/**
 * PHP Version check. PHP version 5.4+ is required to run this plugin.
 *
 * @since 1.0.0
 */
if ( PHP_VERSION >= MIN_PHP_VERSION ) {


    // Pull in some immediate dependencies
    include_once dirname( __FILE__ ) . '/includes/trait-data.php';
    include_once dirname( __FILE__ ) . '/includes/trait-singleton.php';


    // Boot the plugin
    add_action( 'plugins_loaded', 'cdemo\cdemo' );
    
    // load text domain
    add_action( 'plugins_loaded', 'cdemo\load_text_domain' );

    // Add custom action links
    add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'cdemo\add_action_links' );

    // Register activation handler
    register_activation_hook( __FILE__, 'cdemo\CDemo::activate' );

    // Register deactivation handler
    register_deactivation_hook( __FILE__, 'cdemo\CDemo::deactivate' );


    /**
     * Main plugin class
     *
     * @singleton
     *
     * @package cdemo
     * @since 1.0.0
     */
    final class CDemo {

        use Data;
        use Singleton;


        /**
         * Initialize the plugin.
         *
         * @access protected
         * @since 1.0.0
         * @return void
         */
        protected function initialize() {

            $this->do_includes();
            $this->do_defines();

            // Ready to go
            do_action( 'cdemo_loaded', $this );

        }


        /**
         * Include plugin modules.
         *
         * @access private
         * @since 1.0.0
         * @return void
         */
        private function do_includes() {
            include_once dirname( __FILE__ ) . '/includes/library/class-bootstrap-nav-walker.php';

            include_once dirname( __FILE__ ) . '/includes/class-vehicle-query.php';
            include_once dirname( __FILE__ ) . '/includes/class-field.php';
	        include_once dirname( __FILE__ ) . '/includes/class-model-resolver.php';
	        include_once dirname( __FILE__ ) . '/includes/class-sync-buffer.php';
            include_once dirname( __FILE__ ) . '/includes/class-sync-service.php';

            // Widgets
            include_once dirname( __FILE__ ) . '/includes/widgets/class-widget-listings.php';


            include_once dirname( __FILE__ ) . '/includes/functions-settings.php';
            include_once dirname( __FILE__ ) . '/includes/functions-formatting.php';
            include_once dirname( __FILE__ ) . '/includes/functions-shortcodes.php';
            include_once dirname( __FILE__ ) . '/includes/functions-scripts.php';
            include_once dirname( __FILE__ ) . '/includes/functions-search.php';
            include_once dirname( __FILE__ ) . '/includes/functions-ui-fields.php';
            include_once dirname( __FILE__ ) . '/includes/functions-rest-api.php';
            include_once dirname( __FILE__ ) . '/includes/functions-template.php';
            include_once dirname( __FILE__ ) . '/includes/functions-template-general.php';
            include_once dirname( __FILE__ ) . '/includes/functions-widgets.php';
            include_once dirname( __FILE__ ) . '/includes/functions-sanitize.php';
            include_once dirname( __FILE__ ) . '/includes/functions-user.php';
            include_once dirname( __FILE__ ) . '/includes/functions-sync.php';
            include_once dirname( __FILE__ ) . '/includes/functions-cron.php';
            include_once dirname( __FILE__ ) . '/includes/functions-listing.php';
            include_once dirname( __FILE__ ) . '/includes/functions-metadata.php';
            include_once dirname( __FILE__ ) . '/includes/functions-post-type-atv.php';
            include_once dirname( __FILE__ ) . '/includes/functions-post-type-automobile.php';
            include_once dirname( __FILE__ ) . '/includes/functions-post-type-snowmobile.php';
            include_once dirname( __FILE__ ) . '/includes/functions-post-type-motorcycle.php';
            include_once dirname( __FILE__ ) . '/includes/functions-post-type-camper.php';
            include_once dirname( __FILE__ ) . '/includes/functions-post-type-trailer.php';
            include_once dirname( __FILE__ ) . '/includes/functions-post-type-boat.php';
            include_once dirname( __FILE__ ) . '/includes/functions-autocomplete.php';

            include_once dirname( __FILE__ ) . '/includes/api/class-data-driver-client.php';

            include_once dirname( __FILE__ ) . '/includes/functions.php';
            include_once dirname( __FILE__ ) . '/includes/helpers.php';
            include_once dirname( __FILE__ ) . '/includes/setup-wizard.php';
            include_once dirname( __FILE__ ) . '/includes/seo-metadata.php';
            include_once dirname( __FILE__ ) . '/includes/email-notifications.php';
            include_once dirname( __FILE__ ) . '/includes/gravity-forms.php';
            include_once dirname( __FILE__ ) . '/includes/autocomplete.php';
            include_once dirname( __FILE__ ) . '/includes/features.php';
            include_once dirname( __FILE__ ) . '/includes/functions-pricing.php';

            if ( using_default_leads() ) {
                include_once dirname( __FILE__ ) . '/includes/functions-post-type-lead.php';
            }


            include_once dirname( __FILE__ ) . '/includes/admin/functions-admin-bar.php';

            // Include dependencies for the WordPress admin
            if ( is_admin() ) {
                include_once dirname( __FILE__ ) . '/includes/admin/class-metabox.php';
                include_once dirname( __FILE__ ) . '/includes/admin/class-inventory-view.php';
                include_once dirname( __FILE__ ) . '/includes/admin/class-list-table.php';
                include_once dirname( __FILE__ ) . '/includes/admin/class-inventory-table.php';

                include_once dirname( __FILE__ ) . '/includes/admin/functions-manage-ui-fields.php';
                include_once dirname( __FILE__ ) . '/includes/admin/functions-menu.php';
                include_once dirname( __FILE__ ) . '/includes/admin/functions-lead.php';
                include_once dirname( __FILE__ ) . '/includes/admin/functions-metabox.php';
                include_once dirname( __FILE__ ) . '/includes/admin/functions-scripts.php';
                include_once dirname( __FILE__ ) . '/includes/admin/functions-settings.php';
                include_once dirname( __FILE__ ) . '/includes/admin/functions-listing.php';
                include_once dirname( __FILE__ ) . '/includes/admin/functions-admin-ajax.php';
                include_once dirname( __FILE__ ) . '/includes/admin/functions-admin-post.php';
            }
        }


        /**
         * Define global constants.
         *
         * @access private
         * @since 1.0.0
         * @return void
         */
        private function do_defines() {

            define( 'CDEMO_PATH', resolve_path() );
            define( 'CDEMO_INC_PATH', resolve_path( 'includes/' ) );
            define( 'CDEMO_ADMIN_PATH', resolve_path( 'includes/admin/' ) );
            define( 'CDEMO_TEMPLATES_PATH', resolve_path( 'templates/' ) );
            define( 'CDEMO_PARTIALS_PATH', resolve_path( 'templates/partials/' ) );

            define( 'CDEMO_URL', resolve_url() );
            define( 'CDEMO_ASSETS_URL', resolve_url( 'assets/' ) );
            define( 'CDEMO_ADMIN_ASSETS_URL', resolve_url( 'assets/admin/' ) );

        }

        /**
         * Do plugin activation routine.
         *
         * @access public
         * @since 1.0.0
         * @return void
         */
        public static function activate() {

            cdemo();

            // Fix rewrite rules for post types & categories
            register_listing_post_types();

            flush_rewrite_rules();

            // Create our template page
            setup_template_page();

        }


        /**
         * Perform plugin deactivation routine.
         *
         * @access public
         * @since 1.0.0
         * @return void
         */
        public static function deactivate() {

            cdemo();

            register_listing_post_types();

            $post_types = active_listing_types();
            $post_types[] = 'lead';

            foreach ( $post_types as $type ) {
                unregister_post_type( $type );
            }

            flush_rewrite_rules();

        }

    }

     /** Action to load the plugin text domain.
     *
     * @action plugins_loaded
     *
     * @since 1.0.0
     * @return void
     */
    function load_text_domain() {
        load_plugin_textdomain( 'cdemo', false, dirname( plugin_basename( __FILE__ ) ) . '/i18n/languages' );
    }

    /**
     * Get our plugin instance.
     *
     * @action plugins_loaded
     *
     * @since 1.0.0
     * @return Data|Singleton|cDemo
     */
    function cdemo() {
    	return CDemo::instance();
    }


    /**
     * Add custom links for the plugin to the Plugins table in the WordPress admin.
     *
     * @action plugin_action_links_{__FILE__}
     *
     * @param $links
     *
     * @since 1.0.0
     * @return array
     */
    function add_action_links( $links ) {

    	$custom = array(
    	    sprintf( '<a href="%s">%s</a>', menu_page_url( 'cdemo-settings', false ), __( 'Settings', 'cdemo' ) ),
    	    sprintf( '<a href="%s">%s</a>', menu_page_url( 'cdemo-settings', false ) . '&tab=pim-sync', __( 'cDemo PIM', 'cdemo' ) ),
	    );

    	return array_merge( $links, $custom );

    }


} else {
    make_admin_notice( sprintf( __( 'Your version of PHP (%s) does not meet the minimum required version (5.4+) to run cDemo' ), PHP_VERSION ) );
}


/**
 * Resolve a file path relative to the plugin root.
 *
 * @param string $path
 *
 * @since 1.0.0
 * @return string
 */
function resolve_path( $path = '' ) {
    return plugin_dir_path( __FILE__ ) . ltrim( $path, '/' );
}


/**
 * Resolve a URL relative from the plugin root.
 *
 * @param string $path
 *
 * @since 1.0.0
 * @return string
 */
function resolve_url( $path = '' ) {
    return plugin_dir_url( __FILE__ ) . ltrim( $path, '/' );
}


/**
 * Display a notice in the admin area.
 *
 * @param string $message
 * @param string $type
 * @param bool   $dismissible
 *
 * @since 1.0.0
 * @return void
 */
function make_admin_notice( $message, $type = 'error', $dismissible = true ) {

    add_action( 'admin_notices', function () use ( $message, $type, $dismissible ) {

        printf( '<div class="notice notice-%1$s %2$s"><p>%3$s</p></div>',
            esc_attr( $type ), $dismissible ? 'is-dismissible' : '', stripslashes( $message )
        );

    } );

}
