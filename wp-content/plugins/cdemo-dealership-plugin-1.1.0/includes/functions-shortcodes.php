<?php
/**
 * Functions and utilities for the WordPress shortcode API.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;


/**
 * Get all attributes in an embedded shortcode.
 *
 * @param string $text
 * @param array  $shortcodes
 *
 * @since 1.0.0
 * @return array
 */
function parse_shortcode( $text, array $shortcodes = array() ) {

    $regex = get_shortcode_regex( $shortcodes );

    $matches = array();

    if ( preg_match_all( "/$regex/s", $text, $matches ) ) {

        $attrs = array();

        for ( $ctr = 0; $ctr < count( $matches[3] ); $ctr++ ) {
            $attrs[ $matches[0][ $ctr ] ] = shortcode_parse_atts( $matches[3][ $ctr ] );
        }

        return $attrs;

    }

    return array();

}
