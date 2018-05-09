<?php

namespace cdemo;

function show_setup_wizard() {

    if ( !get_option( Options::SETUP_COMPLETE ) && !isset( $_GET['step'] ) ) {

        // Send the user to the setup page
        wp_safe_redirect( admin_url( "admin-post.php?action=cdemo_setup_wizard&step=1" ) );

    }

}

add_action( 'admin_init', 'cdemo\show_setup_wizard' );


function setup_wizard_step() {

    if ( isset( $_POST['setup_wizard_nonce'] ) &&
         wp_verify_nonce( $_POST['setup_wizard_nonce'], 'setup_wizard_next' ) ) {

        $step = $_POST['step'];

        if ( !isset( $_POST['skip'] ) ) {

            switch ( $step ) {

                case 2 :

                    update_option( Options::CURRENCY_CODE, sanitize_text_field( $_POST['currency_code'] ) );
                    update_option( Options::MEASUREMENT_UNITS, sanitize_text_field( $_POST['measurement_units'] ) );

                    break;

                case 1 :
                default :

                    update_option( Options::COMPANY_NAME, sanitize_text_field( $_POST['company_name'] ) );

                    break;

            }

        }


        if ( $step < 2 ) {

            $step++;

            // Redirect to next step
            wp_safe_redirect( admin_url( "admin-post.php?action=cdemo_setup_wizard&step=$step" ) );

        } else {

            // Save that setup wizard has completed
            update_option( Options::SETUP_COMPLETE, true );

            // Redirect back to the inventory page
            wp_safe_redirect( admin_url( '?page=cdemo' ) );
            exit();

        }

    }

    // Get the wizard template
    get_template( 'setup-wizard' );

}

add_action( 'admin_post_cdemo_setup_wizard', 'cdemo\setup_wizard_step' );
