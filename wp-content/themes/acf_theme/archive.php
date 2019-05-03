<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ACF_Theme
 */

get_header();?>

	<?php include 'media-library-navigation.php';?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main graphics-display-page">

			<?php if ( have_posts() ) : ?>
			<header>
				<h1 class="page-title"><?php single_post_title(); ?></h1>
			</header>

			<div class="row">
				<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					/*
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
