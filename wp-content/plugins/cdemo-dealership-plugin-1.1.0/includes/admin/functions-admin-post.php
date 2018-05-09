<?php

namespace cdemo;



function submit_contact_form() {

    if ( check_request_nonce( 'contact_form_nonce', 'contact_form_submit' ) ) {

        $contact = $_POST['contact'];

        // Trim down the comments section
        if ( isset( $contact['comments'] ) ) {
            $contact['comments'] = substr( $contact['comments'], 0, get_option( Options::CONTACT_FORM_MAXLENGTH, 0 ) );
        }

        // Fire off the submission event
        do_action( 'cdemo_contact_form_submit', $_POST['type'], $_POST['id'], $contact );

        // Redirect back to the vdp
        wp_safe_redirect( add_query_arg( 'request', 'sent', wp_get_referer() ) );

    }

}

add_action( 'admin_post_cdemo_submit_contact_form', 'cdemo\submit_contact_form' );
add_action( 'admin_post_nopriv_cdemo_submit_contact_form', 'cdemo\submit_contact_form' );
