<?php

namespace cdemo;


function add_listing_feature( $section_id, $feature, $post = null, $enable = false ) {

    $post = get_post( $post );

    if ( is_listing( $post->post_type ) ) {

        // Get a list of all features
        $features = get_post_meta( $post->ID, "available_features-$section_id", true ) ?: array();

        // Add the feature to the list of available features
        if ( !in_array( $feature, $features ) ) {
            array_push( $features, $feature );
        }

        $added = update_post_meta( $post->ID, "available_features-$section_id", $features );

        if ( $enable ) {

            // Get an array of all enabled features
            $enabled = get_post_meta( $post->ID, "features-$section_id" );

            // Push the new feature to the enabled list
            array_push( $enabled, $feature );


            delete_post_meta( $post->ID, "features-$section_id" );

            foreach ( $enabled as $feature ) {
                add_post_meta( $post->ID, "features-$section_id", $feature );
            }

        }

        return $added !== false;

    }

    return false;

}


function set_listing_features( $section_id, $features, $post = null ) {

    $post = get_post( $post );

    if ( is_listing( $post->post_type ) ) {

        if ( is_string( $features ) ) {
            $features = array( $features );
        }

        // Get all available features
        $available = get_post_meta( $post->ID, "available_features-$section_id", true ) ?: array();

        // Filter values to only those that are available for this listing
        $features = array_filter( $features, function ( $feature ) use ( $available ) {
            return in_array( $feature, $available );
        } );


        // Overwrite the enabled features
        delete_post_meta( $post->ID, "features-$section_id" );

        foreach ( array_unique( $features ) as $feature ) {
            add_post_meta( $post->ID, "features-$section_id", $feature );
        }

    }

}


function delete_feature( $section_id, $feature, $post = null ) {

    $post = get_post( $post );

    if ( $post && is_listing( $post->post_type ) ) {

        // Get all available features
        $available = get_post_meta( $post->ID, "available_features-$section_id", true ) ?: array();

        $index = array_search( $feature, $available );

        if ( $index ) {
            unset( $available[ $index ] );
            update_post_meta( $post->ID, "available_features-$section_id", $available );
        }

        return delete_post_meta( $post->ID, "features-$section_id", $feature );

    }

    return true;

}


function save_vehicle_features( MetaBox $metabox ) {

    if ( !empty( $metabox->fields['features'] ) ) {

        foreach ( $metabox->fields['features']->config['feature_sections'] as $id => $name ) {

            $enabled   = isset( $_POST["features-$id"] ) ? $_POST["features-$id"] : array();
            $sanitized = array();

            foreach ( $enabled as $value ) {
                array_push( $sanitized, sanitize_text_field( $value ) );
            }

            set_listing_features( $id, $sanitized );

        }

    }

}

add_action( 'cdemo_save_metabox', 'cdemo\save_vehicle_features' );


function feature_sections( $type ) {

    $sections = array(
        'automobile' => array(
            672  => __( 'Upholstery Material', 'cdemo' ),
            4184 => __( 'Vehicle Fuel Type', 'cdemo' ),
            7983 => __( 'Exterior Options', 'cdemo' ),
            4129 => __( 'Roof Type & Equipment', 'cdemo' ),
            4235 => __( 'Wheel Type Options', 'cdemo' ),
            7982 => __( 'Interior Options', 'cdemo' ),
            7985 => __( 'Audio & Entertainment Options', 'cdemo' )
        )
    );

    if ( isset( $sections[ $type ] ) ) {
        return $sections[ $type ];
    }

    return false;

}