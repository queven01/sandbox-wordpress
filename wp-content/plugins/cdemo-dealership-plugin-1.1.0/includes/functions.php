<?php
/**
 * General purpose functions and utilities.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;


/**
 * Quickly print a list of items.
 *
 * @param array  $items
 * @param string $before
 * @param string $after
 * @param bool   $echo
 *
 * @since 1.0.0
 * @return string|false
 */
function print_list( $items, $before = '', $after = '', $echo = true ) {
    if ( !is_array( $items ) ) {
        return false;
    }

    $html = '';
    foreach ( $items as $item ) {
        $html .= stripslashes( $before . $item . $after );
    }

    if ( $echo ) {
        echo $html;
    }

    return $html;
}


function get_related_listings( $post = null ) {

    $post = get_post( $post );



    if ( $post ) {

        $args = array(
            'post_type'         => get_post_type(),
            'posts_per_page'    => -1,
            'post__not_in'      => array( $post->ID ),
            'make'              => get_metadata( 'make' ),          
        );

        return new VehicleQuery( $args );

    }

    return false;

}


function get_request_var( $var, $default = '' ) {

    return isset( $_REQUEST[ $var ] ) ? $_REQUEST[ $var ] : $default;

}


function check_request_nonce( $nonce = '_wpnonce', $action = -1 ) {

    return isset( $_REQUEST[ $nonce ] ) &&
           wp_verify_nonce( $_REQUEST[ $nonce ], $action );

}


function using_default_leads() {
    return get_option( Options::LEAD_COLLECTION, 'default' ) == 'default';
}



function str_compare( $str1, $str2, $percent ) {

    $similarity = 0;

    $str1 = strtolower( $str1 );
    $str2 = strtolower( $str2 );

    // Compare strings
    similar_text( $str1, substr( $str2, 0, strlen( $str1 ) ), $similarity );

    if ( $similarity >= $percent ) {
        return true;
    }

    return false;

}


function hex2rgba( $color, $opacity = false ) {

    $default = 'rgb(0,0,0)';

    //Return default if no color provided
    if ( empty( $color ) )
        return $default;

    //Sanitize $color if "#" is provided
    if ( $color[0] == '#' ) {
        $color = substr( $color, 1 );
    }

    //Check if color has 6 or 3 characters and get values
    if ( strlen( $color ) == 6) {
        $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
    } elseif ( strlen( $color ) == 3 ) {
        $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
    } else {
        return $default;
    }

    // Convert hexadec to rgb
    $rgb =  array_map( 'hexdec', $hex );

    // Check if opacity is set(rgba or rgb)
    if( $opacity ){
        if( abs( $opacity ) > 1 )
            $opacity = 1.0;
        $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
    } else {
        $output = 'rgb('.implode(",",$rgb).')';
    }

    //Return rgb(a) color string
    return $output;

}


