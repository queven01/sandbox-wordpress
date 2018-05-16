<?php /* Template Name: Flexible Layout */ ?>

<?php get_header(); ?>

    <div id="primary" class="content-area">

        <main id="main" class="site-main">

            <?php

            if( have_rows('flexible_layout') ):

                while ( have_rows('flexible_layout') ) : the_row();

                    include 'flexiable-layout-templates/hero-template.php';
                    include 'flexiable-layout-templates/columns_template.php';
                    include 'flexiable-layout-templates/call_to_action_template.php';
                    include 'flexiable-layout-templates/image-carousel-template.php';

                 endwhile;

            endif; ?>

        </main><!-- #main -->

    </div><!-- #primary -->

<?php
get_footer();
