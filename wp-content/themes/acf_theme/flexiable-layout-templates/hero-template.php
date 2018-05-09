<?php if( get_row_layout() == 'hero' ):

	//Variables
    while ( have_rows('text_input') ) : the_row();
        $enable_editor = get_sub_field('enable_custom_editor');
        $main_title = get_sub_field('main_title');
        $secondary_title = get_sub_field('secondary_title');
        $add_class = get_sub_field('add_class');
	endwhile;

    $editor = get_sub_field('editor');

    while ( have_rows('background_options') ) : the_row();
        $background_image = get_sub_field('background');
        $overlay = get_sub_field('overlay');
        $video_id = get_sub_field('video');
        $video_position = get_sub_field('display_options');
        $overlay_level = get_sub_field('overlay_level');
    endwhile;

?>

<div class="hero-section <?php echo $add_class .' '. $video_position ?>" style="background-image: url(<?php echo $background_image; ?>);">

    <?php
    //Overlay
    if( $overlay ):
        echo '<div class="overlay-style '. $overlay_level .'"></div>';?>
    <?php endif; ?>

	<!--iFrame Video-->
    <?php if( $video_id ): ?>
        <div class="iframe-no-click"></div>
        <iframe class="hero-video <?php echo $video_position; ?>" width="100%" height="100%" src="https://www.youtube.com/embed/<?php echo $video_id; ?>?autoplay=1&controls=0&showinfo=0&mute=1&version=3&loop=1&playlist=<?php echo $video_id; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
    <?php endif; ?>

	<!--Hero Container-->
	<div class="container hero-content">

		<?php if( $enable_editor == false ):

//			Text Option
            if( have_rows('text_options') ):
	            while ( have_rows('text_options') ) : the_row();

	                //Variables
	                $text_alignment = get_sub_field('text_alignment');
                    $button_alignment = get_sub_field('button_alignment');
	                $main_title_color = 'color:'.get_sub_field('main_title_color').';';
	                $secondary_title_color = get_sub_field('secondary_title_color');
                    $heading_title = get_sub_field('heading_size');
                    $heading_secondary = get_sub_field('heading_size_two');

					echo '<div class="'.$text_alignment.'">';
                    echo '<'. $heading_title.' style="'.$main_title_color .'">'. $main_title .'</'.$heading_title.'>';
	                echo '<'. $heading_secondary.' style="'.$main_title_color.'">'.$secondary_title.'</'.$heading_secondary.'>';
	                echo '</div>';

	            endwhile;
            endif; ?>

        <?php else: ?>

			<div><?php echo $editor; ?></div>

        <?php endif;

        //Button Row
        if( have_rows('button_row') ):

            echo '<ul class="cta '. $button_alignment . '">';

            while ( have_rows('button_row') ) : the_row();

                //Variables
                $button = get_sub_field('button');
                $color_class = get_sub_field('color_class');

                    echo '<li>';

                    if($color_class == 'btn-custom'):

                        if( have_rows('custom_button_settings') ):

                            while ( have_rows('custom_button_settings') ) : the_row();

                                $color = get_sub_field('color');
                                $background_color = get_sub_field('background_color');
                                $top_bottom_padding = get_sub_field('top_bottom_padding');
                                $left_right_padding = get_sub_field('left_right_padding');
                                $font_size = get_sub_field('font_size');
//                                $custom_button_font .= get_sub_field('font_family');
//                                $custom_fontFamily = $json_data[items][$custom_button_font][family];

                                echo '<a class="btn" href="'.$button['url'].'" ';
                                echo 'style="color:' . $color . '; background-color:' . $background_color . '; font-size:' . $font_size . 'px; padding:'. $top_bottom_padding .'rem '. $left_right_padding  .'rem';
                                echo ' '. $top_bottom_padding.'rem '. $left_right_padding .'rem;">'.$button['title'].'</a>';

                            endwhile;

                        endif;

                    else:

                        echo '<a class="btn ' . $color_class .' " href="' . $button['url'] . '">' . $button['title'] . '</a>';

                    endif;

                    echo '</li>';

            endwhile;

            echo '</ul>';

        endif; ?>

    </div>

</div> <!--Close Hero Section -->

<?php endif; ?>