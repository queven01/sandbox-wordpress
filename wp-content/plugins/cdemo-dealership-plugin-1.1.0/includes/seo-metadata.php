<?php

namespace cdemo;


function search_page_json_ld( $args ) {

	if ( is_inventory() ) {
		get_template( 'json-ld-search-page', $args );
	}

}

add_action( 'cdemo_header', 'cdemo\search_page_json_ld' );


function details_page_json_ld( $args ) {

	if ( is_single() && is_listing( get_post_type() ) ) {
		get_template( 'json-ld-details-page', $args );
	}

}

add_action( 'cdemo_header', 'cdemo\details_page_json_ld' );
