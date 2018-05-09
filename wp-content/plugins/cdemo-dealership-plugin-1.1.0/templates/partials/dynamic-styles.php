<?php

namespace cdemo;


$colors = get_colors();


?>

<style>

    /*--- Utility Classes ---*/
    .cdemo-bg-primary {
        background: <?php esc_attr_e( $colors['primary'] ); ?>;
    }

    .cdemo-bg-hover:hover {
        background: <?php esc_attr_e( $colors['hover'] ); ?>;
    }

    .cdemo-text-primary {
        color: <?php esc_attr_e( $colors['primary_text'] ); ?>;
    }

    .cdemo-text-default {
        color: <?php esc_attr_e( $colors['default'] ); ?>;
    }

    .cdemo-text-hover:hover {
        color: <?php esc_attr_e( $colors['hover'] ); ?>;
    }

    .cdemo-primary-color {
        color: <?php esc_attr_e( $colors['primary'] ); ?>;
    }

    .cdemo-default-color {
        color: <?php esc_attr_e( $colors['default'] ); ?>;
    }

    /*--- Bootstrap Overrides ---*/
    #cdemo .btn-primary,
    #cdemo .nav-pills li.active a,
    #cdemo .datepicker .active,
    #cdemo .pagination .page-numbers.current {
        background: <?php esc_attr_e( $colors['primary'] ); ?>;
        color: <?php esc_attr_e( $colors['primary_text'] ); ?>;
    }

    #cdemo .btn-primary:hover {
        background-color: <?php esc_attr_e( $colors['hover'] ); ?>;
    }

    #cdemo .btn-default:hover {
        background-color: <?php esc_attr_e( $colors['default'] ); ?>;
    }

    #cdemo .pagination .page-numbers.current {
        border-color: <?php esc_attr_e( $colors['primary'] ); ?>;
    }
    
    .panel-primary>.panel-heading {
        background-color: <?php esc_attr_e( $colors[ 'primary' ] ); ?>;
    }
    
    /*--- Other ---*/
    .cdemo-carousel.owl-theme .owl-prev,
    .cdemo-carousel.owl-theme .owl-next,
    .ui-state-default, .ui-widget-content .ui-state-default,
    .ui-state-active, .ui-widget-content .ui-state-active{
        background-color: <?php esc_attr_e( $colors[ 'primary' ] ); ?>;
    }
    .cdemo-carousel.owl-theme .owl-prev:hover,
    .cdemo-carousel.owl-theme .owl-next:hover{
        background-color: <?php esc_attr_e( $colors[ 'hover' ] ); ?>;
    }

    .ui-state-default, .ui-widget-content .ui-state-default,
    .ui-state-active, .ui-widget-content .ui-state-active {
    }
    
    .selectize-control.single .selectize-input.dropdown-active:after{
        border-color: transparent transparent <?php esc_attr_e( $colors[ 'primary' ] ); ?> transparent;
    }
    
    .selectize-control.single .selectize-input:after {
        border-color: <?php esc_attr_e( $colors[ 'primary' ] ); ?> transparent transparent transparent
    }
    
    
</style>
