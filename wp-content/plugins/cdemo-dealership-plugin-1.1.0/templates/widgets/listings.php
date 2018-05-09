<?php
/**
 * Template for the listings widget.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;

?>

<div class="row">

    <div class="col-sm-12">

        <div class="owl-carousel owl-theme">

            <?php while ( $listings->have_posts() ) : $listings->the_post(); ?>


                <div class="item listing-item">

                    <a href="<?php the_permalink(); ?>">
                        <h4><?php the_title(); ?></h4>
                        <img title="<?php the_title(); ?>" src="<?php echo esc_url( get_post_image_url() ); ?>" />
                    </a>

                </div>

                <?php wp_reset_postdata(); ?>

           <?php endwhile; ?>

        </div>

    </div>

</div>
