<?php
/**
 *
 * @since 1.0.0
 * @package cdemo
 * @subpackage admin
 */
namespace cdemo;


// Initialize inventory view
add_action( 'cdemo_loaded', 'cdemo\InventoryView::instance' );


/**
 * Inventory management screen.
 *
 * @singleton
 *
 * @package cdemo
 * @since 1.0.0
 */
final class InventoryView {

    use Singleton;


    /**
     * @var InventoryTable $table
     *
     * @access private
     * @since 1.0.0
     */
    private $table;


    /**
     * Inventory page size screen option.
     *
     * @since 1.0.0
     */
    const INVENTORY_PAGE_SIZE = 'cdemo_inventory_page_size';


    /**
     * Setup actions and filters.
     *
     * @access public
     * @since 1.0.0
     * @return void
     */
    public function initialize() {

        // Add the inventory page to the admin menu
        add_action( 'admin_menu', array( $this, 'add_inventory_page' ), 9 );

        // Save screen options
        add_filter( 'set-screen-option', array( $this, 'set_screen_options' ), 10, 3 );

    }


    /**
     * Register the submenu page.
     *
     * @action admin_menu
     *
     * @access public
     * @since 1.0.0
     * @return void
     */
    public function add_inventory_page() {

        $page = add_submenu_page(
            'cdemo',
            __( 'Inventory', 'cdemo' ),
            __( 'Inventory', 'cdemo' ),
            'manage_options',
            'cdemo',
            array( $this, 'do_inventory_page' )
        );


        // Add page load hooks
        add_action( "load-$page", array( $this, 'add_screen_options' ) );
        add_action( "load-$page", array( $this, 'load_inventory' ) );

    }


    /**
     * Fetch the table data.
     *
     * @access public
     * @since 1.0.0
     * @return void
     */
    public function load_inventory() {
        $this->table = new InventoryTable();
        $this->table->prepare_items();

    }


    /**
     * Output the inventory page.
     *
     * @access public
     * @since 1.0.0
     * @return void
     */
    public function do_inventory_page() {

        $args = array(
            'table' => $this->table
        );

        get_template( 'admin/menu-page-inventory', $args );

    }


    /**
     * Save the screen options.
     *
     * @param $status
     * @param $value
     * @param $option
     *
     * @filter set_screen_options
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public function set_screen_options( $status, $option, $value ) {

        if ( self::INVENTORY_PAGE_SIZE === $option ) {
            return $value;
        }

        return $status;

    }


    /**
     * Add custom screen options for the admin view.
     *
     * @since 1.0.0
     * @return void
     */
    public function add_screen_options() {

        $args = array(
            'label'   => __( 'Number of items per page:', 'cdemo' ),
            'option'  => self::INVENTORY_PAGE_SIZE,
            'default' => 20
        );

        add_screen_option( 'per_page', $args );

    }

}
