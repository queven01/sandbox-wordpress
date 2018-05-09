<?php

namespace cdemo;

?>

<?php if ( sanitize_checkbox( get_option( Options::USE_THEME_HEADER ) ) ) : ?>

    <?php \get_header(); ?>

    <?php do_action( 'cdemo_header', $args ); ?>

<?php else : ?>

    <!doctype html>

    <!-- Start Document -->
    <html class="cdemo">
        <head>

            <meta name="viewport" content="width=device-width, initial-scale=1">

            <link rel="icon" href="<?php echo esc_url( get_option( Options::FAVICON ) ); ?>" type="image/x-icon" />

            <?php wp_head(); ?>

            <?php do_action( 'cdemo_header', $args ); ?>

        </head>

        <!-- Start Body -->
        <body class="<?php echo is_admin_bar_showing() ? 'has-admin-bar' : ''; ?>">

<?php endif; ?>


    <!-- Start Page Container -->
    <div id="cdemo">

        <?php if ( sanitize_checkbox( get_option( Options::SHOW_HEADER ) ) ) : ?>

            <?php get_template( 'navbar', $args ); ?>

        <?php endif; ?>

        <!-- Start Page Wrapper -->
        <div class="wrapper content">
