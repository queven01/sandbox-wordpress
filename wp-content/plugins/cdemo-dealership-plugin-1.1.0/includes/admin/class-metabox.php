<?php

namespace cdemo;


class MetaBox {

    public $id;
    public $title;
    public $fields;
    public $config;

    public function __construct( array $args ) {

        $defaults = array(
            'fields' => array(),
            'config' => array()
        );

        $args = wp_parse_args( $args, $defaults );

        $this->id    = $args['id'];
        $this->title = $args['title'];

        $this->config = $args['config'];


        foreach ( $args['fields'] as $field ) {
            $this->add_field( $field );
        }

    }

    public function add_field( $field ) {

        if ( is_a( $field, 'cdemo\Field' ) ) {
            $this->fields[ $field->id ] = $field;
        } else {
            $this->fields[ $field['id'] ] = new Field( $field );
        }

    }

}