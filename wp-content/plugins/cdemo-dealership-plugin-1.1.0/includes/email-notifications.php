<?php

namespace cdemo;


function notify_lead_created( $id, $data ) {

	if ( get_option( Options::SEND_CONTACT_NOTIFICATION ) ) {

		$lead     = get_post( $id );
		$template = trim( get_option( Options::CONTACT_EMAIL ) );

		// Additional replace vars
		$replace  = array(
			'comments' => $lead->post_content,
			'listing'  => get_post( $data['listing_id'] )->post_title
		);

		$replace = array_merge( $data, $replace );


		foreach( $replace as $var => $value ) {

			// Filter the value of the variable
			$value = apply_filters( 'cdemo_replace_email_var', $value, $var );

			// Replace the var in the template
			$template = str_replace( "[$var]", $value, $template );

		}

		$sender_address = get_option( Options::OUTGOING_EMAIL_ADDRESS );
		$sender_name    = get_option( Options::OUTGOING_EMAIL_NAME );

		$subject = trim( get_option( Options::CONTACT_EMAIL_SUBJECT ) );

		$headers = array(
			'Content-Type: text/html; charset=UTF-8',
			"From: $sender_name <$sender_address>"
		);

		wp_mail( get_option( Options::EMAIL_ADDRESS ), $subject, $template, $headers );

	}

}

add_action( 'cdemo_lead_created', 'cdemo\notify_lead_created', 10, 2 );
