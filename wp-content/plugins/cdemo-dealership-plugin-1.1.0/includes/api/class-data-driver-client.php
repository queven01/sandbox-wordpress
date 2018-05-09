<?php
/**
 *
 * @since 1.0.0
 * @package cdemo
 * @subpackage api
 */
namespace cdemo;


/**
 * DataDriver API Client
 *
 * @since 1.0.0
 * @package cdemo
 * @subpackage api
 */
class DataDriverClient {


    /**
     * cDemo API Base URL
     */
    const BASE_URL = 'https://api.cdemo.com/v3/';


    /**
     * Export Endpoint
     */
    const ENDPOINTS_EXPORT = 'records-export';


    /**
     * Data Driver API Key
     *
     * @since 1.0.0
     * @access private
     * @var string
     */
    private $token = '';


    /**
     * @param string $key
     *
     * @since 1.0.0
     */
    public function __construct( $key = '' ) {
        $this->token = trim( $key ? $key : get_option( Options::DATA_DRIVER_KEY ) );
    }


    /**
     * Get a list of vehicle records from the API.
     *
     * @param string|array $args
     *
     * @since 1.0.0
     * @return array|false
     */
    public function get_records( $args = '' ) {

        $args = wp_parse_args( $args );

        // Get records from the request to the export endpoint
        $res = $this->make_request( self::ENDPOINTS_EXPORT, $args );

        if ( $res && $res['status'] == 200 ) {
            $data = $res['data'];

            $prev = $this->get_page_link( $data['links']['prev'], $args );
            $next = $this->get_page_link( $data['links']['next'], $args );

            $records = array(
                'records'    => $data['paginated_results'],
                'pagination' => array(
                    'total' => $data['links']['total_results'],
                    'prev'  => $prev,
                    'next'  => $next
                ),
            );

            return $records;

        }

        return false;

    }


    /**
     * Extract the data from the HTTP response.
     *
     * @param array|\WP_Error $res
     *
     * @since 1.0.0
     * @return array|bool
     */
    private function get_response_data( $res ) {

        if ( is_wp_error( $res ) ) {
            return false;
        }

        $data = array(
            'data'   => json_decode( wp_remote_retrieve_body( $res ), true ),
            'status' => wp_remote_retrieve_response_code( $res )
        );

        return $data;

    }


    /**
     * Make a request to the API.
     *
     * @param string $uri
     * @param array  $query
     *
     * @since 1.0.0
     * @return array|\WP_Error
     */
	private function make_request( $uri, $query = array() ) {

        // Build the query string
        $query_string = strcat( self::BASE_URL, $uri, '?', build_query( $query ) );

    	$args = array(
    		'headers' => array(
    		    'Authorization' => "Bearer $this->token"
		    )
	    );

    	return $this->get_response_data( wp_remote_request( $query_string, $args ) );

    }


    /**
     * Test the connection with an API key.
     *
     * @param string $key
     *
     * @since 1.0.0
     * @return bool
     */
    public static function test_connection( $key = '' ) {

        $client = new self( $key );

        $res = $client->make_request( self::ENDPOINTS_EXPORT, null );

        if ( $res && $res['status'] == 200 ) {
            return true;
        }

        return false;

    }


    /**
     * Extract the page number from the response pagination links.
     *
     * @param string $link
     * @param array  $args
     *
     * @since 1.0.0
     * @return int|null
     */
    private function get_page_link( $link, $args = array() ) {

        $query = array();
        parse_str( parse_url( $link, PHP_URL_QUERY ), $query );

        // If we have a page link build a new args query
        if ( !empty( $query['page'] ) ) {
            return build_query( array_merge( $args, array( 'page' => $query['page'] ) ) );
        }

        return null;

    }

}
