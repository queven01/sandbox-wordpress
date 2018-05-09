<?php

namespace cdemo;

/**
 * Safely pluck a value from an object or array.
 *
 * @param object|array $obj
 * @param string       $field
 * @param mixed        $default
 *
 * @since 1.0.0
 * @return mixed
 */
function pluck( $obj, $field, $default = false ) {

    if ( empty( $obj ) ) {
        return $default;
    }

    $data = $obj;

    if ( is_object( $obj ) ) {
        $data = clone $obj;
    }

    $data = (array) $data;

    if ( isset( $data[ $field ] ) ) {
        return $data[ $field ];
    }

    return $default;

}


function parse_attrs( array $attrs ) {

    $str = '';

    foreach ( $attrs as $name => $attr ) {
        $str .= $name . '="' . ( is_array( $attr ) ? implode( ' ', $attr ) : esc_attr( $attr ) ) . '" ';
    }

    return $str;

}


function render_text_field( $field ) {

    if ( is_array( $field ) ) {
        $field = new Field( $field );
    }

    echo '<input ' . parse_attrs( $field->attributes ) . 'value="'. esc_attr( $field->value ) .'" />';

    if ( !empty( $field->description ) ) {
        echo '<p class="description">' . esc_html( $field->description ) . '</p>';
    }

}


function render_textarea( $field ) {

    if ( is_array( $field ) ) {
        $field = new Field( $field );
    }

    echo '<textarea ' . parse_attrs( $field->attributes ) . '>' . esc_textarea( $field->value ) . '</textarea>';

    if ( !empty( $field->description ) ) {
        echo '<p class="description">' . esc_html( $field->description ) . '</p>';
    }

}


function render_select_box( $field ) {

    if ( is_array( $field ) ) {
        $field = new Field( $field );
    }

    echo '<select ' . parse_attrs( $field->attributes ) . '>';

    foreach ( $field->config['options'] as $option ) {

        echo '<option ' . parse_attrs( $option['attributes'] ) . ' ';
        echo selected( $option['attributes']['value'], $field->value, false ) . '>';
        echo esc_html( $option['title'] );
        echo '</option>';

    }

    echo '</select>';

    if ( !empty( $field->description ) ) {
        echo '<p class="description">' . esc_html( $field->description ) . '</p>';
    }

}


function render_radio_group( $field ) {

    if ( is_array( $field ) ) {
        $field = new Field( $field );
    }

    echo '<fieldset ' . parse_attrs( $field->attributes ) . '">';

    foreach ( $field->config['options'] as $option ) {

        $option['attributes']['name'] = $field->attributes['name'];
        $option['attributes']['type'] = 'radio';

        echo '<label><input ' . parse_attrs( $option['attributes'] ) . ' ';
        echo checked( $option['attributes']['value'], $field->value, false );
        echo '/>' . esc_html( $option['description'] ) . '</label><br/>';

    }

    echo '</fieldset>';

}


function render_check_box( $field ) {

    if ( is_array( $field ) ) {
        $field = new Field( $field );
    }

    $defaults = array(
        'checked' => 'on'
    );

    $config = wp_parse_args( $field->config, $defaults );

    echo '<label>';
    echo '<input type="checkbox" ' . parse_attrs( $field->attributes ) . checked( $config['checked'], $field->value, false ) . '/> ';
    echo  $field->description;
    echo '</label>';

}


function render_media_field( $field ) {

    if ( is_array( $field ) ) {
        $field = new Field( $field );
    }

    $name = $field->attributes['name'];

    unset( $field->attributes['name'] );

    echo '<div ' . parse_attrs( $field->attributes ) . '>';
    echo '<input type="hidden" name="' . esc_attr( $name ) .  '" value="'. esc_attr( $field->value ) .'" />';

    if ( !empty( $field->description ) ) {
        echo '<p class="description">' . esc_html( $field->description ) . '</p>';
    }

    echo '</div>';

}


function render_editor( $field ) {

	if ( is_array( $field ) ) {
		$field = new Field( $field );
	}

	wp_editor( $field->value, $field->id, $field->config );

}


function render_posts_dropdown( $field ) {

	if ( is_array( $field ) ) {
		$field = new Field( $field );
	}

	// Create an empty option with this title
	if ( !empty( $field->config['default_option_title'] ) ) {

		$empty = array(
			'title'       => $field->config['default_option_title'],
			'attributes' => array(
				'value' => ''
			)
		);

		$field->config['options'][] = $empty;

	}

	$args = array(
		'posts_per_page' => -1,
	);

	$q = new \WP_Query( array_merge( $args, $field->config ) );


	foreach ( $q->posts as $post ) {

		$option = array(
			'title'      => $post->post_title,
			'attributes' => array(
				'value' => $post->ID
			)
		);

		$field->config['options'][] = $option;

	}


	render_select_box( $field );

}


function render_listing_media() {

    get_template( 'listing-media', array( 'post' => get_post() ) );

}


function render_field( $field ) {

    if ( is_array( $field ) ) {
        $field = new Field( $field );
    }

    call_user_func( $field->render_callback, $field );

}


function render_post_type_options( $field ) {

    if ( is_array( $field ) ) {
        $field = new Field( $field );
    }

    echo '<fieldset id="' . esc_attr( $field->attributes['id'] ) . '">';

    foreach ( $field->value as $type => $config ) {

        $type = get_post_type_object( $type );

        echo '<h4>' . $type->label . '</h4><p>';

        echo '<label for="post_type_slug-' . esc_attr( $type->name ) . '">' . __( 'Base Slug', 'cdemo' ) . '</label>';

        echo '<input type="text"
                     id="post_type_slug-' . esc_attr( $type->name ) . '"
                     class="regular-text"
                     name="' . esc_attr( $field->attributes['name'] ) . '[' . esc_attr( $type->name ) .'][slug]" 
                     value="' . esc_attr( $config['slug'] ) . '"/></p>';

    }

    echo '</fieldset>';

}


function render_financing_price( $field ) {

    if ( is_array( $field ) ) {
        $field = new Field( $field );
    }

    echo '<div id="cdemo-finance-price-field" class="meta-field">';

    echo '<select id="cdemo-financing-price"
                  name="financing_price"
                  class="meta-field" ' . parse_attrs( $field->attributes ) . '>';

    foreach ( $field->config['options'] as $option ) {

        echo '<option ' . parse_attrs( $option['attributes'] ) . ' ';
        echo selected( $option['attributes']['value'], $field->value, false ) . '>';
        echo esc_html( $option['title'] );
        echo '</option>';

    }

    echo '</select>';

    echo '<input type="text" 
                 id="cdemo-finance-price-preview"
                 readonly="readonly" 
                 class="meta-field" />';

    echo '</div>';

}


function render_listing_features( $field ) {

    if ( is_array( $field ) ) {
        $field = new Field( $field );
    }

    get_template( 'feature-sections', array( 'sections' => $field->config['feature_sections'] ) );

}


function render_gf_forms_config() {

    get_template( 'settings-contact-forms' );

}


function get_colors() {

	$colors = array(
		'primary'      => get_option( Options::PRIMARY_COLOR ),
		'default'      => get_option( Options::DEFAULT_COLOR ),
		'hover'        => get_option( Options::HOVER_COLOR ),
		'primary_text' => get_option( Options::PRIMARY_TEXT_COLOR ),
		'default_text' => get_option( Options::DEFAULT_TEXT_COLOR )
	);

	return apply_filters( 'cdemo_colors', $colors );

}


function maybe_parse_range( $range ) {
    return parse_string( $range, '-', 'cdemo\sanitize_number' );
}


function maybe_parse_list( $list ) {
    return parse_string( $list, ',', 'sanitize_text_field' );
}


function parse_string( $input, $delimiter = ' ', $sanitize = '' ) {

    $output = $input;

    if ( is_string( $output ) ) {
        $output = explode( $delimiter, $output );
    }

    if ( is_array( $output ) && is_callable( $sanitize ) ) {

        for ( $ctr = 0; $ctr < count( $output ); $ctr++ ) {
            $output[ $ctr ] = call_user_func( $sanitize, $output[ $ctr ] );
        }

    }
    
    
    $output = (array) $output;
    // If we only have 1 element, unwrap it
    return count( $output ) > 1 ? $output : current( $output );

}


function maybe_implode( $data, $delimiter = ' ' ) {

    if ( is_array( $data ) ) {
        return implode( $delimiter, $data );
    }

    return $data;

}