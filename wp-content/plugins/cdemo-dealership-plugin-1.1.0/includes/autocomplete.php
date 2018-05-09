<?php

namespace cdemo;


function autocomplete_makes( $values, $field, $args ) {

    if ( $field === 'make' ) {

        $resolver = new ModelResolver( $args['post_type'] );

        $makes = array_filter( $resolver->get_makes(), function ( $make ) use ( $args ) {
            return str_compare( $args['term'], $make, 75 );
        } );

        return array_merge( $values, $makes );

    }

    return $values;

}

add_filter( 'cdemo_autocomplete_field_values', 'cdemo\autocomplete_makes', 10, 3 );


function autocomplete_models( $values, $field, $args ) {

    if ( $field === 'model' ) {

        $resolver = new ModelResolver( $args['post_type'] );

        $models = array_filter( $resolver->get_models( $args['make'] ), function ( $model ) use ( $args ) {
            return str_compare( $args['term'], $model, 75 );
        } );

        return array_merge( $values, $models );

    }

    return $values;

}

add_filter( 'cdemo_autocomplete_field_values', 'cdemo\autocomplete_models', 10, 3 );


function autocomplete_fields( $values, $field, $args ) {

    if ( $field !== 'model' && $field !== 'make' ) {

        $suggestions = array_filter( get_field_values( $field, $args['post_type'] ), function ( $suggestion ) use ( $args ) {
            return str_compare( $args['term'], $suggestion, 75 );
        } );

        return array_merge( $values, $suggestions );

    }

    return $values;

}

add_filter( 'cdemo_autocomplete_field_values', 'cdemo\autocomplete_fields', 10, 3 );


// Ensure no duplicates
add_filter( 'cdemo_autocomplete_field_values', 'array_unique', 100 );


function append_custom_makes( $makes, $type ) {

    return array_unique( array_merge( $makes, get_field_values( 'make', $type ) ) );

}

add_filter( 'cdemo_vehicle_makes', 'cdemo\append_custom_makes', 10, 2 );


function append_custom_models( $models, $type, $make = false ) {

    return array_unique( array_merge( $models, get_field_values( 'model', $type, $make ? array( 'make' => $make ) : '' ) ) );

}

add_filter( 'cdemo_models', 'cdemo\append_custom_models', 10, 3 );
