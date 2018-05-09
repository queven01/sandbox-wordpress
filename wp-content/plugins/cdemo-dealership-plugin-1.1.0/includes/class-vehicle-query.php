<?php
/**
 *
 * @package cdemo
 * @since 1.0.0
 */
namespace cdemo;


/**
 * Main query class for searching for vehicle listings.
 *
 * @since 1.0.0
 */
class VehicleQuery extends \WP_Query {


    /**
     * Parsed query args.
     *
     * @var array
     */
    public $vars = array();


    /**
     * Initializes the query and passes the arguments on to \WP_Query.
     *
     * @param array|string $query
     *
     * @access public
     * @since 1.0.0
     */
    public function __construct( $query = '' ) {

        $defaults = array(
            'keyword'             => '',
            'limit'               => -1,
            'page_num'            => 0,
            'sortby'              => 'title',
            'sort'                => 'desc',
            'vehicle_category'    => active_listing_types(),
            'make'                => '',
            'model'               => '',
            'body_type'           => '',
            'engine'              => '',
            'transmission'        => '',
            'trim'                => '',
            'condition'           => '',
            'features'            => array(),
            'year_manufactured'   => '',
            'price'               => 0,
            'stocknumber'         => '',
            'trim_level'          => '',
            'days_in_stock'       => '',
            'fuel_type'           => '',
            'fuel_economy_hwy'    => '',
            'fuel_economy_city'   => '',
            'sale_price_start_dt' => date( 'Y-m-d' ),
            'sale_price_end_dt'   => date( 'Y-m-d' ),
            
        );

        // Extract matching arguments from the query
        $this->fill_vars( wp_parse_args( $query, $defaults ) );


        // Configure some standard WP_Query arguments
        $q = array(
            's'              => $this->get( 'keyword' ),
            'paged'          => $this->get( 'page_num' ),
            'posts_per_page' => $this->get( 'limit' ),
            'order'          => $this->get( 'sort' ),
            'orderby'        => $this->orderby( $this->get( 'sortby' ) ),
            'post_type'      => $this->post_type( $this->get( 'vehicle_category' ) ),
            'meta_query'     => array()
        );

        // Pass the query off to the WP_Query constructor
        parent::__construct( $this->merge_vars( $q ) );
    }


    /**
     * Parse the listing post type.
     *
     * @param string $type
     *
     * @since 1.0.0
     * @return array|string
     */
    private function post_type( $type = '' ) {
        $type = maybe_parse_list( $type );

        if ( !is_listing( $type ) ) {
            $type = active_listing_types();
        }

        return $type;
    }


    /**
     * Fill the query vars array.
     *
     * @param $vars
     *
     * @since 1.0.0
     * @return void
     */
    private function fill_vars( $vars ) {

        $keys = array(
            'keyword'
            ,'sortby'
            ,'sort'
            ,'trim_level'
            ,'condition'
            ,'stocknumber'
            ,'days_in_stock'
            ,'limit'
            ,'page_num'
            ,'fuel_economy_hwy'
            ,'fuel_economy_city'
            ,'body_type'
            ,'year_manufactured'
            ,'make'
            ,'model'
            ,'engine'
            ,'transmission'
            ,'fuel_type'
            ,'features'
            ,'price'
            ,'vehicle_category'
            ,'sale_price_start_dt'
            ,'sale_price_end_dt'
        );

        foreach ( $keys as $key ) {
            $this->vars[ $key ] = $vars[ $key ];
        }
    }


    /**
     * Merge custom query vars into \WP_Query args.
     *
     * @param array $q
     *
     * @since 1.0.0
     * @return array
     */
    private function merge_vars( array $q ) {

        // Add query numerical values
        $number_fields = array(
            'days_in_stock'
        );

        foreach ( $number_fields as $key ) {
            $val = $this->get( $key );

            if ( !empty( $val ) ) {
                $this->meta_query_var( $q, $key, sanitize_number($val ) );
            }
        }

        // Add query string values
        $string_fields = array(
            'trim_level'
            ,'stocknumber'
            ,'condition'
        );

        // Map meta that can be copied as is
        foreach ( $string_fields as $key ) {
            $val = $this->get( $key );

            if ( !empty( $val ) ) {
                $this->meta_query_var( $q, $key, sanitize_text_field( $val ) );
            }
        }

        // Add query vars for list type values
        $list_fields = array(
            'body_type'
            ,'make'
            ,'model'
            ,'engine'
            ,'transmission'
            ,'fuel_type'
        );

        foreach ( $list_fields as $var ) {
            $this->meta_query_list( $q, $var, $this->get( $var ) );
        }


        // Add query vars for range type values
        $range_fields = array(
            'fuel_economy_hwy'
            ,'fuel_economy_city'
            ,'year_manufactured'
        );

        foreach ( $range_fields as $var ) {
            $this->meta_query_range( $q, $var, $this->get( $var ) );
        }


        // Parse price fields to find a matching price.
        $this->price_query( $q );


        // Return our configured WordPress query
        return $q;
    }


    /**
     * Force ORDER BY clause to sort post either by list_price or by sale_price meta query tag.
     *
     * @param string $orderby
     *
     * @since 1.0.0
     * @return string
     */
    private function orderby( $orderby = '' ) {
        if ( $orderby === 'price' ) {
            return 'list_price sale_price';
        }

        return $orderby;
    }


    private function price_query( &$q ) {
        $price = maybe_parse_range( $this->get( 'price' ) );

        $mq = array();

        // If price is passed as a range
        if ( is_array( $price ) ) {
            $mq = array(
                'relation'   => 'OR',

                // OR condition will force posts to be either sorted by list_price MQ tag OR sale_price MQ tag
                'list_price' => array(
                    'key'     => 'listing_price',
                    'value'   => $price,
                    'type'    => 'NUMERIC',
                    'compare' => 'BETWEEN',
                ),
                'sale_price' => array(
                    'relation' => 'AND',

                    // If sale and valid date
                    array(
                        'key'     => 'sale_price',
                        'value'   => $price,
                        'type'    => 'NUMERIC',
                        'compare' => 'BETWEEN',
                    ),
                    array(
                        'key'     => 'sale_price_start_dt',
                        'value'   => $this->get( 'sale_price_start_dt' ),
                        'type'    => 'DATE',
                        'compare' => '<='
                    ),
                    array(
                        'key'     => 'sale_price_end_dt',
                        'value'   => $this->get( 'sale_price_end_dt' ),
                        'type'    => 'DATE',
                        'compare' => '>='
                    )
                )
            );

        // If price is passed as a single var
        } else if ( !empty( $price ) ) {
            $mq = array(
                'relation'   => 'OR',
                'list_price' => array(
                    'key'     => 'listing_price',
                    'value'   => $price,
                ),
                'sale_price' => array(

                    // If sale and valid date
                    'relation' => 'AND',
                    array(
                        'key'     => 'sale_price',
                        'value'   => $price,
                    ),
                    array(
                        'key'     => 'sale_price_start_dt',
                        'value'   => $this->get( 'sale_price_start_dt' ),
                        'compare' => '<='
                    ),
                    array(
                        'key'     => 'sale_price_end_dt',
                        'value'   => $this->get( 'sale_price_end_dt' ),
                        'compare' => '>='
                    )
                )
            );

        } else if ( $this->get( 'sortby' ) === 'price' ) {

            // Include results with a listing price value if sorting by price
            $mq = array(
                'list_price' => array(
                    'key'     => 'listing_price',
                    'value'   => 0,
                    'type'    => 'NUMERIC',
                    'compare' => '>='
                ),
            );
        }

        array_push( $q['meta_query'], $mq );
    }


    /**
     * Merge regular meta query vars
     *
     * @param array  $q
     * @param string $field
     * @param string $data
     *
     * @since 1.0.0
     * @return void
     */
    private function meta_query_var( array &$q, $field, $data = '' ) {
        $mq = array(
            'key'   => $field,
            'value' => $data
        );

        array_push( $q['meta_query'], $mq );
    }


    /**
     * Parse query vars that can be passed in range format: 132-3242
     *
     * @param array  $q
     * @param string $field
     * @param string $data
     *
     * @since 1.0.0
     * @return void
     */
    private function meta_query_range( array &$q, $field, $data = '' ) {
        $data = maybe_parse_range( $data );

        if ( is_array( $data ) ) {
            $mq = array(
                'key'     => $field,
                'value'   => $data,
                'compare' => 'BETWEEN',
                'type'    => 'NUMERIC'
            );

            array_push( $q['meta_query'], $mq );

        } else if ( !empty( $data ) ) {
            $this->meta_query_var( $q, $field, $data );
        }
    }


    /**
     * Parse query vars that can be passed in list format: 123,1324,543
     *
     * @param array  $q
     * @param string $field
     * @param string $data
     *
     * @since 1.0.0
     * @return void
     */
    private function meta_query_list( array &$q, $field, $data = '' ) {
        $data = maybe_parse_list( $data );

        if ( is_array( $data ) ) {
            $mq = array(
                'key'     => $field,
                'value'   => $data,
                'compare' => 'IN'
            );

            array_push( $q['meta_query'], $mq );

        } else if ( !empty( $data ) ) {
            $this->meta_query_var( $q, $field, $data );
        }
    }


    /**
     * Get a value from the query vars array. If not found will try to find it in the parent $query_vars array.
     *
     * @param string $var
     * @param string $default
     *
     * @since 1.0.0
     * @return mixed
     */
    public function get( $var, $default = '' ) {
        if ( isset( $this->vars[ $var ] ) ) {
            return $this->vars[ $var ];
        } else {
            return parent::get( $var, $default );
        }
    }

}
