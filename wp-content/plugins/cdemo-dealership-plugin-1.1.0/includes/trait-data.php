<?php
/**
 *
 * @package cdemo
 * @since 1.0.0
 */
namespace cdemo;


/**
 * Add an object cache to an object.
 *
 * @package cdemo
 * @since 1.0.0
 */
trait Data {

    /**
     * @var array $data The object cache.
     * @access private
     * @since 1.0.0
     */
    protected $data = array();


    /**
     * Get a value from the cache.
     *
     * @param string $var     The name of the variable to get.
     * @param string $default The default to return if not found.
     *
     * @return mixed
     * @since 1.0.0
     * @access public
     */
    public function get( $var, $default = '' ) {

        if ( isset( $this->data[ $var ] ) ) {
            return $this->data[ $var ];
        }

        return $default;

    }

    /**
     * Set a value in the cache.
     *
     * @param string $key   The name of the variable to set.
     * @param mixed  $value The value of the variable.
     *
     * @since 1.0.0
     * @access public
     * @return void
     */
    public function set( $key, $value ) {
        $this->data[ $key ] = $value;
    }

}
