<?php if( get_row_layout() == 'image_carousel' ):

    $images = get_sub_field('carousel');

    while ( have_rows('options') ) : the_row();
        $container = get_sub_field('container');
        $padding = get_sub_field('padding');
        $add_class = get_sub_field('add_class');
    endwhile;


    if( $container ):
        echo '<div class="container">';
    endif; ?>

    <div class="carousel-section <?php echo $add_class; ?>" style="padding: <?php echo $padding; ?>;">
        <div id="carouselIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselIndicators" data-slide-to="1"></li>
                <li data-target="#carouselIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
	            <?php if( $images ): ?>
	                <?php $first_slide = true;
                        foreach( $images as $image ): ?>
				                <div class="carousel-item <?php if( $first_slide ){ echo 'active';}?>">
					                <a href="<?php echo $image['url']; ?>" style="width: 100%;">
				                        <img class="d-block w-100" src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>">
					                </a>
					                <p><?php echo $image['caption']; ?></p>
				                </div>
                                <?php $first_slide = false; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div> <!--Close Carousel Section -->

	<?php
	if( $container ):
		echo '</div>';
	endif; ?>

<?php endif; ?>