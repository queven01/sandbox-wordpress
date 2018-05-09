<?php
/**
 * Functions for formatting data and output.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;


/**
 * Concatenate pieces of a string together.
 *
 * @param string       $glue   The characters to place between each piece or a piece of a string.
 * @param string|array $pieces If an array, the value of $glue will be used to concat the strings together, else all
 *                             parameters will be concatenated together using the default glue: ''.
 *
 * @since 1.0.0
 * @return string
 */
function strcat() {

    $args = func_get_args();
    $glue = '';
    $pieces = $args;

    if ( is_string( $args[0] ) & is_array( $args[1] ) ) {
        $glue = $args[0];
        $pieces = $args[1];
    }

    return join( $glue, $pieces );

}


/**
 *  Wrap a string or array of strings in quotes.
 *
 * @param string|array $arg
 * @param string       $quote
 *
 * @since 1.0.0
 * @return array|string
 */
function wrap_quotes( $arg, $quote = '\'' ) {

    if ( is_array( $arg ) ) {
        $res = array();

        foreach ( $arg as $str ) {
            array_push( $res, strcat( $quote, trim( $str, '\'' ), $quote ) );
        }

        return $res;

    }

    return strcat( $quote, trim( $arg, '\'' ), $quote ) ;

}


/**
 * Format currency output.
 *
 * @param float $value
 * @param string $code
 *
 * @since 1.0.0
 * @return string
 */
function format_currency( $value, $code ) {
    return strcat( '$', number_format( $value, 2 ), ' ', strtoupper( $code ) );
}
