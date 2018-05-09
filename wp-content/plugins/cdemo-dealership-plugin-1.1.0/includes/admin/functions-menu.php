<?php
/**
 * Functions for configuring menu pages in the WordPress admin.
 *
 * @since 1.0.0
 * @package cdemo
 * @subpackage admin
 */
namespace cdemo;


// Register menu pages
add_action( 'admin_menu', 'cdemo\add_menu_pages', 9 );

// Register submenu pages
add_action( 'admin_menu', 'cdemo\add_submenu_pages' );

// Insert Documentation submenu page
add_action( 'admin_menu', 'cdemo\add_docs_menu' );

// Manually set active menu items
add_filter( 'submenu_file', 'cdemo\set_admin_menu_item' );

// add header to settings page
add_action( 'cdemo_admin_header', 'cdemo\get_admin_header' );


/**
 * Register top level menu pages.
 *
 * @action admin_menu
 *
 * @since 1.0.0
 * @return void
 */
function add_menu_pages() {
	add_menu_page(
		__( 'cDemo', 'cdemo' ),
		__( 'cDemo', 'cdemo' ),
		'manage_options',
		'cdemo',
		'',
		resolve_url( 'assets/images/cdemo-logo.png' ),
		50
	);
}


/**
 * Register submenu pages.
 *
 * @action admin_menu
 *
 * @since 1.0.0
 * @return void
 */
function add_submenu_pages() {
	add_submenu_page(
		'cdemo',
		__( 'Add Listing', 'cdemo' ),
		__( 'Add Listing', 'cdemo' ),
		'manage_options',
		'cdemo-new-listing',
		'cdemo\do_new_listing_menu_page'
	);


	$hook = add_submenu_page(
		'cdemo',
		__( 'Settings', 'cdemo' ),
		__( 'Settings', 'cdemo' ),
		'manage_options',
		'cdemo-settings',
		'cdemo\do_settings_menu_page'
	);

	add_action( "load-$hook", 'cdemo\enqueue_admin_settings_scripts' );


	if ( using_default_leads() ) {
        add_submenu_page(
            'cdemo',
            __( 'Leads', 'cdemo' ),
            __( 'Leads', 'cdemo' ),
            'edit_posts',
            'edit.php?post_type=lead'
        );
    }
}

/**
 * 
 * Append a submenu item for the documentation page
 * 
 * @global array $submenu
 * 
 * @since 1.0.0
 * @return void
 */
function add_docs_menu() {
    global $submenu;
    $submenu['cdemo'][] = array( __( 'Documentation', 'cdemo' ), 'manage_options', DOCS_URL );
}

/**
 * Force the admin menu to highlight custom menu items.
 *
 * @global $parent_file
 * @global $current_screen
 *
 * @param $submenu_file
 *
 * @filter submenu_file
 *
 * @since 1.0.0
 * @return string
 */
function set_admin_menu_item( $submenu_file ) {
	global $parent_file, $current_screen;

	if ( $current_screen->base == 'post' ) {

		if ( in_array( get_post_type(), active_listing_types() ) ) {

			if ( $current_screen->action == 'add' ) {
				$parent_file  = 'cdemo';
				$submenu_file = 'cdemo-new-listing';
			} else {
				$parent_file  = 'cdemo';
				$submenu_file = 'cdemo';
			}

		} else if ( get_post_type() == 'lead' ) {
			$parent_file = 'cdemo';
			$submenu_file = 'edit.php?post_type=lead';
		}
	}

	return $submenu_file;
}


/**
 * Output the plugin settings menu page.
 *
 * @since 1.0.0
 * @return void
 */
function do_settings_menu_page() {
    $tabs = array(
        'general'     => __( 'General', 'cdemo' ),
        'appearance'  => __( 'Appearance', 'cdemo' ),
        'display'     => __( 'Display', 'cdemo' ),
        'leads'       => __( 'Leads', 'cdemo' ),
        'templates'   => __( 'Fields', 'cdemo' ),
        'advanced'    => __( 'Advanced', 'cdemo' ),
        'pim-sync'    => __( 'cDemo PIM', 'cdemo' )
    );

   do_menu_page_tabs( 'cdemo-settings', $tabs );
}


/**
 * Output the new listing menu page.
 *
 * @since 1.0.0
 * @return void
 */
function do_new_listing_menu_page() {
    get_template( 'admin/menu-page-new-listing' );
}


/**
 * Output a tabbed menu page.
 *
 * @param string $page
 * @param array  $tabs
 *
 * @since 1.0.0
 * @return void
 */
function do_menu_page_tabs( $page, $tabs ) {
    $tabs = apply_filters( "cdemo_menu_page-$page-tabs", $tabs );
    reset( $tabs );

    $current = get_request_var( 'tab', false );
    $active  = $current && array_key_exists( $current, $tabs ) ? $current : key( $tabs );

    $args = array(
        'tabs'    => $tabs,
        'active'  => $active,
        'page'    => $page,
        'baseurl' => menu_page_url( $page, false )
    );

    get_template( 'admin/menu-page-tabbed', $args );
}


/**
 * Output the selected menu page tab.
 *
 * @param string $tab
 * @param string $page
 *
 * @since 1.0.0
 * @return void
 */
function do_menu_page_tab( $page, $tab ) {
    do_action( "cdemo_menu_page-$page-tab", $tab );
}


/**
 * Output sections for a menu page.
 *
 * @param string $page     The page to output the sections for.
 * @param array  $sections The sections that the page contains.
 *
 * @since 1.0.0
 * @return void
 */
function do_menu_page_sections( $page, $sections ) {
    $sections = apply_filters( "cdemo_menu_page_sections-$page", $sections );
    reset( $sections );

    $current = get_request_var( 'section', false );

    $remove = array(
        'category',
        'context'
    );

    $args = array(
        'page'     => $page,
        'sections' => $sections,
        'baseurl'  => remove_query_arg( $remove ),
        'current'  => $current && array_key_exists( $current, $sections ) ? $current : key( $sections )
    );

    get_template( 'admin/menu-page-sections', $args );
}


/**
 * Output the selected menu page section.
 *
 * @param string $page
 * @param string $section
 *
 * @since 1.0.0
 * @return void
 */
function do_menu_page_section( $page, $section ) {
    do_action( "cdemo-menu_page-$page-section", $section );
}

/**
 * Output the template for settings header
 * 
 * @since 1.0.0
 * @return void
 */
function get_admin_header() {
    get_template( 'admin/settings-header.php' );
}
