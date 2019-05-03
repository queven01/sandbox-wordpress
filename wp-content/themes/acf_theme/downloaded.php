<?php /* Template Name: Download Library Layout */?>

<?php get_header();?>

	<?php include 'media-library-navigation.php';?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main graphics-display-page">

            <?php if ( have_posts() ) : ?>
	        <header>
		        <h1 class="page-title"><?php single_post_title(); ?></h1>
	        </header>

			<!--ACF Field Input-->
            <?php
                $order_by = get_field('order_by');
                $asc_desc = get_field('asc_desc');
            ?>

            <div class="row">
                <?php
                /* Start the Loop */
                $args = array( 'post_type' => 'wpdmpro', 'posts_per_page' => 13, 'meta_key' => '__wpdm_download_count', 'orderby' => $order_by, 'order' => $asc_desc);
                $loop = new WP_Query( $args );
                while ($loop->have_posts() ) : $loop->the_post();

                    /* Other Ways to ORDER_BY find here
                       $META_ATTRIBUTES = get_metadata( 'post', get_the_ID(), '', true );
                       print_r($META_ATTRIBUTES);


                        * Include the Post-Type-specific template for the content.
                        * If you want to override this in a child theme, then include a file
                        * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                        */
                    get_template_part( 'template-parts/custom-content', get_post_type() );

                endwhile;

                the_posts_navigation();

                else :

                    get_template_part( 'template-parts/content', 'none' );

                endif; ?>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
