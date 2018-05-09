<?php 
namespace cdemo;

?>

<style>
    
    .cdemo-vdp .panel-primary,
    .cdemo-vdp .panel-heading {
        border-color: <?php esc_attr_e( $colors[ 'primary' ] ); ?>;
    }

    .cdemo-vdp .panel-primary th,
    .cdemo-vdp .panel-primary td {
        border-bottom: 1px solid <?php esc_attr_e( hex2rgba( $colors[ 'primary' ], 0.4 ) ); ?> !important;
    }

    .cdemo-vdp .panel-primary th {
        background: <?php esc_attr_e( hex2rgba( $colors[ 'primary' ], 0.2 ) ); ?>;
        border-right: 1px solid <?php esc_attr_e( hex2rgba( $colors[ 'primary' ], 0.4 ) ); ?> !important;
    }

    .cdemo-vdp .panel-primary .panel-heading {
        background: <?php esc_attr_e( $colors[ 'primary' ] ); ?>;
    }

    .cdemo-vdp .panel-primary .list-group-item {
        border-top-color: <?php esc_attr_e( hex2rgba( $colors[ 'primary' ], 0.4 ) ); ?> !important;
    }

    .cdemo-gform-modal input[type=submit] {
        background: <?php esc_attr_e( $colors[ 'primary' ] ); ?>;
        color: <?php esc_attr_e( $colors[ 'primary_text' ] ); ?>;
    }

    .cdemo-gform-modal input[type=submit]:hover {
        background-color: <?php esc_attr_e( $colors[ 'hover' ] ); ?>;
    }
    
    .owl-carousel .owl-item .listing-item img {
        width: auto;
    }

</style>