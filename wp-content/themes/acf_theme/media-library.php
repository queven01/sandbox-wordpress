<?php /* Template Name: Media Library Layout */ ?>

<?php get_header(); ?>

<?php include 'media-library-navigation.php';?>

    <div id="primary" class="container">

        <main id="main" class="site-main" style="padding-top: 1rem;">

	        <?php

            if ( have_posts() ) :

                while ( have_posts() ) : the_post();

                    the_content();

                    $META_ATTRIBUTES = get_metadata( 'post', get_the_ID(), '__wpdm_download_count', true );
                    $add_one = $META_ATTRIBUTES + 1;

                    if (isset($_GET['downloaded'])) {
                        update_post_meta( get_the_ID(), '__wpdm_download_count', $add_one, $META_ATTRIBUTES );
                    }
                    ?>

	                <?php

                    if( have_rows('slides') ):

                        while( have_rows('slides') ): the_row();

                            while( have_rows('large_slide') ): the_row();

	                            $preview_large = get_sub_field('preview_image');
                                $file_large = get_sub_field('file');

                                echo '<div class="row">'; ?>

	                            <?php

	                            if( $preview_large || $file_large ): ?>
	                                <div class="col-md-4">
		                                <div class="thePreview">
			                                <a target="_blank" href="<?php echo $preview_large['url']; ?>"><img src="<?php echo $preview_large['url']; ?>"></a>
		                                </div>
		                                <div class="theFile">
			                                <a class="custom_download_link" href="<?php echo $file_large['url']; ?>" download>Run PHP Function</a>
		                                </div>
	                                </div>
	                            <?php endif;

                                if( $preview_large || $file_large ): ?>
		                            <div class="col-md-4">
			                            <div class="thePreview">
				                            <a target="_blank" href="<?php echo $preview_large['url']; ?>"><img src="<?php echo $preview_large['url']; ?>"></a>
			                            </div>
			                            <div class="theFile">
				                            <a href="<?php echo $file_large['url']; ?>">Download PSD</a>
			                            </div>
		                            </div>
                                <?php endif;

                                if( $preview_large || $file_large ): ?>
		                            <div class="col-md-4">
			                            <div class="thePreview">
				                            <a target="_blank" href="<?php echo $preview_large['url']; ?>"><img src="<?php echo $preview_large['url']; ?>"></a>
			                            </div>
			                            <div class="theFile">
				                            <a href="<?php echo $file_large['url']; ?>">Download PSD</a>
			                            </div>
		                            </div>
                                <?php endif;

                                if( $preview_large || $file_large ): ?>
		                            <div class="col-md-4">
			                            <div class="thePreview">
				                            <a target="_blank" href="<?php echo $preview_large['url']; ?>"><img src="<?php echo $preview_large['url']; ?>"></a>
			                            </div>
			                            <div class="theFile">
				                            <a href="<?php echo $file_large['url']; ?>">Download PSD</a>
			                            </div>
		                            </div>
                                <?php endif;

                                if( $preview_large || $file_large ): ?>
		                            <div class="col-md-4">
			                            <div class="thePreview">
				                            <a target="_blank" href="<?php echo $preview_large['url']; ?>"><img src="<?php echo $preview_large['url']; ?>"></a>
			                            </div>
			                            <div class="theFile">
				                            <a href="<?php echo $file_large['url']; ?>">Download PSD</a>
			                            </div>
		                            </div>
                                <?php endif;

                                echo '</div>';

	                            $skinny_slide = get_sub_field('skinny_slide');

	                            if( $skinny_slide ): echo 'ok';?>

			                        <a href="<?php echo $skinny_slide['url']; ?>"><?php echo $skinny_slide['filename']; ?></a>

	                            <?php endif;

                            endwhile;

                        endwhile;

                    endif;

                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();

                    endif;

                endwhile;

            endif;

	        ?>

        </main><!-- #main -->

    </div><!-- #primary -->

<?php
get_footer();