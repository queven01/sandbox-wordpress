<?php

namespace cdemo;


class Field {

    public $id;
    public $title;
    public $description;

    public $value;

    public $config;
    public $attributes;

    public $render_callback;
    public $sanitize_callback;


    public function __construct( array $args ) {

        $defaults = array(
            'id'                => null,
            'title'             => '',
            'config'            => array(),
            'attributes'        => array(),
            'render_callback'   => '',
            'sanitize_callback' => '',
            'description'       => '',
            'value'             => ''
        );

        $args = wp_parse_args( $args, $defaults );

        $this->id    = $args['id'];
        $this->title = $args['title'];
        $this->value = $args['value'];

        $this->description = $args['description'];

        $this->render_callback   = $args['render_callback'];
        $this->sanitize_callback = $args['sanitize_callback'];

        $this->config     = $args['config'];
        $this->attributes = $args['attributes'];

    }

}
