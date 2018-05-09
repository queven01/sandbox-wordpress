<?php

namespace cdemo;


function ajax_add_gravity_form() {

    if ( check_ajax_referer( 'cdemo_ajax' ) ) {

        $forms = get_option( Options::GF_FORMS_CONFIG );

        $args = array(
            'id'      => max( array_keys( $forms ) ) + 1,
            'label'   => sanitize_text_field( $_POST['label'] ),
            'form_id' => absint( $_POST['form_id'] )
        );

        $forms[ $args['id'] ] = array(
            'label'   => $args['label'],
            'form_id' => $args['form_id']
        );

        // Merge in the new form config
        update_option( Options::GF_FORMS_CONFIG, $forms );

        $data = array(
            'template' => array(
                'rendered' => buffer_template( 'settings-contact-form-config', $args )
            )

        );

        wp_send_json_success( $data );

    }

}

add_action( 'wp_ajax_cdemo_add_gravity_form', 'cdemo\ajax_add_gravity_form' );


function ajax_remove_gravity_form() {

    if ( check_ajax_referer( 'cdemo_ajax' ) ) {

        $forms = get_option( Options::GF_FORMS_CONFIG );

        if ( isset( $forms[ $_POST['id'] ] ) ) {
            unset( $forms[ $_POST['id'] ] );
        }

        // Merge in the new form config
        update_option( Options::GF_FORMS_CONFIG, $forms );

        wp_send_json_success();

    }

}

add_action( 'wp_ajax_cdemo_remove_gravity_form', 'cdemo\ajax_remove_gravity_form' );


function ajax_autocomplete_field() {

    if ( check_ajax_referer( 'cdemo_ajax' ) ) {
        wp_send_json_success( apply_filters( 'cdemo_autocomplete_field_values', array(), $_GET['field'], $_GET['args'] ) );
    }

}

add_action( 'wp_ajax_cdemo_autocomplete_field', 'cdemo\ajax_autocomplete_field' );


function ajax_format_listing_currency() {

    if ( check_ajax_referer( 'cdemo_ajax' ) ) {
        wp_send_json_success( format_currency( $_GET['value'], get_listing_currency( $_GET['id'] ) ) ?: '' );
    }

}

add_action( 'wp_ajax_cdemo_format_currency', 'cdemo\ajax_format_listing_currency' );


function ajax_add_listing_feature() {

    if ( check_ajax_referer( 'cdemo_ajax' ) ) {

        $post_id = absint( $_POST['post_id'] );
        $section = sanitize_text_field( $_POST['section_id'] );
        $feature = sanitize_text_field( $_POST['feature'] );

        if ( add_listing_feature( $section, $feature , $post_id, true ) ) {

            $args = array(
                'section' => $section,
                'feature' => $feature,
                'enabled' => true
            );

            $data = array(
                'template' => array(
                    'rendered' => buffer_template( 'feature-toggle', $args )
                )
            );

            wp_send_json_success( $data );

        } else {
            wp_send_json_error( new \WP_Error( -1, __( 'Feature could not be added', 'cdemo' ) ) );
        }

    }

}

add_action( 'wp_ajax_cdemo_add_feature', 'cdemo\ajax_add_listing_feature' );


function ajax_remove_listing_feature() {

    if ( check_ajax_referer( 'cdemo_ajax' ) ) {

        $post_id = absint( $_POST['post_id'] );
        $section = sanitize_text_field( $_POST['section_id'] );
        $feature = sanitize_text_field( $_POST['feature'] );

        delete_feature( $section, $feature, $post_id );
        wp_send_json_success( '' );

    }

}

add_action( 'wp_ajax_cdemo_remove_feature', 'cdemo\ajax_remove_listing_feature' );