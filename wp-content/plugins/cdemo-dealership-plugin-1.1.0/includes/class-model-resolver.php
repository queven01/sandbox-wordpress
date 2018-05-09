<?php

namespace cdemo;


class ModelResolver {


    private $type = '';

    private $makes = array();

    private $models = array();


    public function __construct( $type ) {

        if ( is_listing( $type ) ) {
            $this->init( $type );
        }

    }


    private function init( $type ) {

        $this->type = $type;

        $this->load_makes();
        $this->load_models();

    }


    private function load_makes() {

        $makes = include dirname( __FILE__ ) . "/vehicle-makes.php";

        if ( isset( $makes[ $this->type ] ) ) {
            $this->makes = $makes[ $this->type ];
        }

    }


    private function load_models() {
        $this->models = include dirname( __FILE__ ) . "/vehicle-models-{$this->type}.php";
    }


    public function get_models( $make ) {

        $models = array();

        if ( !empty( $make ) && isset( $this->models[ $make ] ) ) {
            $models = $this->models[ $make ];
        }

        return apply_filters( 'cdemo_models', $models, $this->type, $make );

    }


    public function get_all_models() {

        $models = array();

        foreach ( $this->models as $make => $models ) {

            foreach ( $models as $name => $model ) {
                $models[] = $model;
            }

        }

        return apply_filters( 'cdemo_models', $models, $this->type );

    }


    public function get_makes() {
        return apply_filters( 'cdemo_vehicle_makes', $this->makes, $this->type );
    }


}
