<?php
/**
 * Sanitize callback functions.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;


/**
 * Sanitize a field's option group.
 *
 * @param mixed $value
 * @param mixed $old
 * @param Field $field
 *
 * @since 1.0.0
 * @return mixed
 */
function sanitize_option_group( $value, $old, Field $field ) {

    $values = array_map( function ( $option ) {

        return $option['attributes']['value'];

    }, $field->config['options'] );

    return in_array( $value, $values ) ? $value : $old;

}


/**
 * Sanitize a boolean value
 *
 * @param mixed $value Positive (Yes, true, 1) or Negative (No, false, 0).
 *
 * @since 1.0.0
 * @return bool
 */
function sanitize_checkbox( $value ) {

    if ( filter_var( $value, FILTER_VALIDATE_BOOLEAN ) ) {
        return $value;
    }

    return false;

}


/**
 * Sanitize a post to make sure it exists.
 *
 * @param mixed $value
 *
 * @since 1.0.0
 * @return mixed
 */
function sanitize_post_id( $value ) {

	if ( get_post( $value ) ) {
		return $value;
	}

	return 0;

}


/**
 * Sanitize a numeric value.
 *
 * @param mixed $number
 *
 * @since 1.0.0
 * @return float|int
 */
function sanitize_number( $number ) {
    return abs( $number );
}


/**
 * Sanitize stub function.
 *
 * @param $value
 *
 * @since 1.0.0
 * @return mixed
 */
function sanitize( $value ) {
    return $value;
}


/**
 * Sanitize listing condition
 *
 * @param $value
 *
 * @since 1.0.0
 * @return mixed
 */
function sanitize_condition( $value ) {
    return $value;
}


/**
 * Sanitize listing fuel economy unit.
 *
 * @param $value
 *
 * @since 1.0.0
 * @return mixed
 */
function sanitize_fuel_economy_unit( $value ) {
    return $value;
}


/**
 * Sanitize country currency code.
 *
 * @param $value
 *
 * @since 1.0.0
 * @return mixed
 */
function sanitize_currency_code( $value ) {
    return $value;
}


/**
 * Sanitizes a date timestamp.
 *
 * @param $value
 *
 * @since 1.0.0
 * @return mixed
 */
function sanitize_date( $value ) {
    return $value;
}


/**
 * Sanitize the financing base price for a listing.
 *
 * @param $value
 *
 * @since 1.0.0
 * @return mixed
 */
function sanitize_financing_price( $value ) {
    return $value;
}


/**
 * Sanitize the financing term length for a listing.
 *
 * @param $value
 *
 * @since 1.0.0
 * @return mixed
 */
function sanitize_term_length( $value ) {
    return $value;
}
