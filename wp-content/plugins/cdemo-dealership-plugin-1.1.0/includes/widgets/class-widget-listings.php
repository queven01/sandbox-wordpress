<?php
/**
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;


/**
 * Widget to display preview of listings.
 *
 * @since 1.0.0
 * @package cdemo
 */
class WidgetListings extends \WP_Widget {


    /**
     * @since 1.0.0
     */
    public function __construct() {

        $options = array(
            'classname' => 'cdemo-listings-widget'
        );
        
        parent::__construct( 'cdemo-listings-widget', __( 'cDemo Listings', 'cdemo' ),  $options );
        
    }


    /**
     * Initialize a new query with set widget args.
     *
     * @param $args
     * @param $instance
     *
     * @since 1.0.0
     * @return VehicleQuery
     */
    public function get_listings( $args, $instance ) {

        $query = array(
            'vehicle_category' => $instance['vehicle_category'],
            'limit'            => $instance['count'],
            'sortby'           => $instance['order_by'],
            'sort'             => $instance['order']
        );

        if ( $query['sortby'] === 'random' ) {
            $query['sortby'] = wp_rand() % 2 === 0 ? 'price' : 'date';
        }
        
        return new VehicleQuery( $query );
        
    }


    public function widget( $args, $instance ) {

        $listings = $this->get_listings( $args, $instance );

        if ( $listings->have_posts() ) {
            $args = array(
                'listings'  => $listings,
                'instance'  => $instance,
                'arguments' => $args
            );

            // Get our listings widget template
            get_template( 'widgets/listings', $args, true, false, true, $this );

        }

    }


    /**
     * Output the widget configuraton form.
     *
     * @param array $instance
     *
     * @since 1.0.0
     * @return void
     */
    public function form( $instance ) {

        $defaults = array(
            'title'             => __( 'Vehicle Listings', 'cdemo' ),
            'vehicle_category'  => active_listing_types(),
            'count'             => 6,
            'order_by'          => 'price',
            'order'             => 'desc'
        );
        
        $instance = wp_parse_args( $instance, $defaults );

        $args = array(
            'instance' => $instance
        );

        get_template( 'admin/widgets/widget-form-listings', $args, true, false, true, $this );
        
    }


    /**
     * Sanitize and validate the widget configuration.
     *
     * @param array $new_instance
     * @param array $old_instance
     *
     * @since 1.0.0
     * @return array
     */
    public function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        $instance['count'] = absint( pluck( $new_instance, 'count' ) );
        $instance['title'] = sanitize_text_field( pluck( $new_instance, 'title' ) );

        if ( array_key_exists( pluck( $new_instance, 'order' ), $this->order_options() ) ) {
            $instance['order'] = $new_instance['order'];
        }

        if ( array_key_exists( pluck( $new_instance, 'order_by' ), $this->order_by_options() ) ) {
            $instance['order_by'] = $new_instance['order_by'];
        }

        $instance['vehicle_category'] = array();
        $available = active_listing_types();

        foreach ( pluck( $new_instance, 'vehicle_category', array() ) as $category ) {

            if ( in_array( $category, $available ) ) {
                array_push( $instance['vehicle_category'], $category );
            }

        }

        return $instance;
        
    }


    /**
     * Get available order field options.
     *
     * @since 1.0.0
     * @return array
     */
    private function order_by_options() {

        $options = array(
            'date'   => __( 'Date', 'cdemo' ),
            'price'  => __( 'Price', 'cdemo' ),
            'random' => __( 'Random', 'cdemo' )
        );

        return $options;

    }


    /**
     * Get available order options.
     *
     * @since 1.0.0
     * @return array
     */
    private function order_options() {

        $options = array(
            'asc'  => __( 'Ascending', 'cdemo' ),
            'desc' => __( 'Descending', 'cdemo' )
        );

        return $options;
    }
    
}
