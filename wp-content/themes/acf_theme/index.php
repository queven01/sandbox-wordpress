<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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
				$args = array( 'post_type' => 'wpdmpro', 'posts_per_page' => 13, 'orderby' => 'publish_date', 'order' => 'DESC');
				$loop = new WP_Query( $args );
				while ($loop->have_posts() ) : $loop->the_post();

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
		</main>
	</div>

<?php
get_footer();
