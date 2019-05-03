<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ACF_Theme
 */
?>

<div class="col-lg-4 col-md-4 col-sm-6">
	<div class="theGraphic">
		<a href="<?php echo get_post_permalink(); ?>">
			<img src="<?php echo get_the_post_thumbnail_url(); ?>">
			<span class="theGraphic-content">
				<h2><?php the_title(); ?></h2>
				<h5><?php echo wpdm_get_package($id)['package_size'];?></h5>
				<h5>Download Count: <?php echo wpdm_get_package($id)['download_count']; ?></h5>
			</span>
		</a>
		<span class="download-button">
			<?php
            echo wpdm_get_package($id)['download_link'];
            ?>
		</span>
	</div><!-- .entry-content -->
</div>