<?php

namespace cdemo;


function get_listing_currency( $post = null ) {

    $post = get_post( $post );

    if ( $post && is_listing( $post->post_type ) ) {
        return get_post_meta( $post->ID, 'listing_currency', true ) ?: get_option( Options::CURRENCY_CODE );
    }

    return get_option( Options::CURRENCY_CODE );

}


function has_promo( $post = null ) {

    $post = get_post( $post );

    if ( $post && is_listing( $post->post_type ) ) {

        $promo = get_post_meta( $post->ID, 'sale_price', true ) ?: false;

        $start = get_post_meta( $post->ID, 'sale_price_start_dt', true ) ?: false;
        $end   = get_post_meta( $post->ID, 'sale_price_end_dt',   true ) ?: false;

        if ( $promo ) {

            if ( $start ) {

                if ( $end ) {

                    $start = strtotime( $start );
                    $end   = strtotime( $end );
                    $now   = current_time( 'timestamp' );

                    if ( $end > $start && $start <= $now && $now <= $end ) {
                        return true;
                    }

                } else {
                    return true;
                }

            } else {
                return true;
            }

        }

    }

    return false;

}


function get_listing_prices( $post = null ) {

    $post = get_post( $post );

    $prices = array(
        'msrp'          => 0,
        'discount'      => 0,
        'sale_price'    => 0,
        'listing_price' => 0,
        'actual_price'  => 0
    );

    if ( $post && is_listing( $post->post_type ) ) {

        $msrp          = sanitize_number( get_post_meta( $post->ID, 'msrp',          true ) ?: 0 );
        $sale_price    = sanitize_number( get_post_meta( $post->ID, 'sale_price',    true ) ?: 0 );
        $listing_price = sanitize_number( get_post_meta( $post->ID, 'listing_price', true ) ?: 0 );

        $actual_price   = $listing_price > 0 ? $listing_price : $msrp;
        $discount       = 0;


        // Calculate sales discounts if the vehicle has a promo
        if ( has_promo( $post ) ) {

            $discount     = $discount + $actual_price - $sale_price;
            $actual_price = $sale_price;

        }

        return array_merge( $prices, compact( 'msrp', 'listing_price', 'sale_price', 'actual_price', 'discount' ) );

    }

    return $prices;

}

/**
 * 
 * outputs formatted HTML for a listing price
 * this factors in regular and sale price
 * 
 * @param $post - accepts WP_Post object or post ID integer
 * 
 */
function listing_price_html( $post = null ) {
    
    $post = get_post( $post );
    
    if( ! $post || !is_listing( $post->post_type ) ) {
        return;
    }
    
    get_template( 'listing-price', array(
        'listing'   => $post
    ), true, false );
    
}