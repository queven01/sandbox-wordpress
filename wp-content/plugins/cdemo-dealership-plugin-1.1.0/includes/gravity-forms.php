<?php

namespace cdemo;


function gf_contact_form() {

    $html  = get_option( Options::GF_CONTACT_HTML );
    $forms = get_option( Options::GF_FORMS_CONFIG );

    $shortcodes = parse_shortcode( $html, array( 'gform' ) );

    foreach ( $shortcodes as $shortcode => $attrs ) {

        // If the contact form config exists
        if ( isset( $attrs['target'] ) && !empty( $forms[ $attrs['target'] ] ) ) {

            $config = $forms[ $attrs['target'] ];

            // Pull the  target out from the attributes
            $id = $attrs['target'];
            unset( $attrs['target'] );

            // Create a button to trigger the form modal
            $button = sprintf(

                '<button data-toggle="modal" data-target="#gform-modal-%1$s" %2$s>%3$s</button>',

                $id,
                parse_attrs( $attrs ),
                $config['label']

            );

            $html = str_replace( $shortcode, $button, $html );

        }

    }

    echo $html;

}


function print_gravity_forms() {

    if ( !using_default_leads() && class_exists( '\GFAPI' )) {

        foreach ( get_option( Options::GF_FORMS_CONFIG ) as $id => $config ) {

            $args = array(
                'id'      => $id,
                'form_id' => $config['form_id'],
                'form'      => \GFAPI::get_form( $config['form_id'] )
            );

            ?><script>

                jQuery(document).ready(function ($) {
                    $('body').append($(<?php echo json_encode( buffer_template( "gform-modal", $args, false ) ); ?>));
                });

            </script><?php

        }

    }

}

add_action( 'cdemo_footer', 'cdemo\print_gravity_forms' );
