<?php
if( get_row_layout() == 'call_to_action_row' ):

    $container = get_sub_field('container');
	$body_color= '';

    if( $container ):
        echo '<div class="container">';
    endif;

    echo '<div class="row">';

    if( have_rows('call_to_action') ):

        $effect = 0;

        while ( have_rows('call_to_action') ) : the_row();

            $effect++;
            $title = get_sub_field('title');
            $content = get_sub_field('content');
            $background_image = get_sub_field('background_image');
            $background_color  = get_sub_field('background_color');
            $effect_speed = get_sub_field('effect_speed');
            $hover_effect = get_sub_field('hover_effect');
            $padding = get_sub_field('padding');

            if( $hover_effect && in_array('Size', $hover_effect) ):
                while ( have_rows('size') ) : the_row();

		            $grow_or_shrink = get_sub_field('grow_or_shrink');
		            $starting_size = get_sub_field('starting_size');
		            $ending_size = get_sub_field('ending_size');

				endwhile;
            endif;

            if( $hover_effect && in_array('Drop Shadow', $hover_effect) ):
                while ( have_rows('drop_shadow') ) : the_row();

                    $shadow_color = get_sub_field('shadow_color');
                    $shadow_size = get_sub_field('shadow_size');
                    $shadow_x = get_sub_field('x_axis');
                    $shadow_y = get_sub_field('y_axis');
                    $shadow_blur = get_sub_field('shadow_blur');

                endwhile;
            endif;

            if( $hover_effect && in_array('Fade', $hover_effect) ):
                while ( have_rows('fade') ) : the_row();

                    $body_color = 'background:'. get_sub_field('body_color').' !important;';

                endwhile;
            endif;

            if( $hover_effect && in_array('Fade', $hover_effect) || $hover_effect && in_array('Size', $hover_effect) || $hover_effect && in_array('Drop Shadow', $hover_effect) ):
                ?>
	            <style>
		            .effect_<?php echo $effect; ?>
		            {
			            margin: 10px;
		            }
		            <?php if( $hover_effect && in_array('Fade', $hover_effect)): ?>
		            .effect_<?php echo $effect; ?>
		            {
		                -webkit-transition: box-shadow 0.5s;
			            -moz-transition: box-shadow 0.5s;
			            transition: box-shadow 0.5s;
			            -o-transition:color .2s ease-out, background .1s ease-in;
			            -ms-transition:color .2s ease-out, background .1s ease-in;
			            -moz-transition:color .2s ease-out, background .1s ease-in;
			            -webkit-transition:color .2s ease-out, background .1s ease-in;
			            transition:color .2s ease-out, background .1s ease-in;
		            }
		            <?php endif; ?>

		            .effect_<?php echo $effect; ?>:hover
		            {
			            <?php if ($hover_effect && in_array('Drop Shadow', $hover_effect)): ?>
		                    box-shadow: <?php echo $shadow_y?>px <?php echo $shadow_x?>px <?php echo $shadow_blur?>px <?php echo $shadow_size?>px <?php echo $shadow_color?>;
                        <?php endif ?>
		                <?php echo $body_color; ?>
		            }

		            .effect_<?php echo $effect; ?>:hover i {
			            color: #9ebaa0;
		            }
	            </style>

                <?php
            endif;

            while ( have_rows('image_options') ) : the_row();

                $insert_icon = get_sub_field('insert_icon');
                $insert_custom_icon = get_sub_field('insert_custom_icon');
                $icon_color = 'color:'. get_sub_field('icon_color').';';
                $icon_size = 'font-size:'. get_sub_field('icon_size').'rem;';

            endwhile;

            echo '<div class="col-md aligncenter effect_'.$effect;
            echo '" style="';

            if ($background_image == true):

                echo 'background: url('.$background_image.');';

            endif;

            if ($background_color == true):

                echo 'background:'.$background_color.';';

            endif;

            echo ' padding:'. $padding .'">';

            while ( have_rows('button_styles') ) : the_row();

                $link = get_sub_field('link');
                $color_class = get_sub_field('color_class');

                if($color_class == 'btn-custom'):

                    if( have_rows('custom_button_settings') ):

                        while ( have_rows('custom_button_settings') ) : the_row();

                            $color = get_sub_field('color');
                            $background_color = get_sub_field('background_color');
                            $top_bottom_padding = get_sub_field('top_bottom_padding');
                            $left_right_padding = get_sub_field('left_right_padding');
                            $font_size = get_sub_field('font_size');

                        endwhile;

                    endif;

                else:

                echo '<a class="btn-block" style="text-decoration: none;" href="'. $link['url'] .'" >';

                endif;

            endwhile;

            if( $buttons_only != true ):

                if($insert_icon == true):

                    if ($insert_custom_icon != true):

                        echo '<span style="'.$icon_color. $icon_size.' width: 100%; display: block;"><i class="'. $insert_icon .'"></i></span>';

                    endif;

                endif;

                 if ($insert_custom_icon == true):

                     echo '<img src="'. $insert_custom_icon .'" style="width: 100%;"/>';

                 endif;

            endif;

            if ($title  == true):

                echo '<h3>'.$title.'</h3>';

            endif;

            if ($content  == true):

                echo '<h4>'.$content.'</h4>';

            endif;

            echo '<span style="width: 96%;" href="'. $link['title'].'" class="btn '. $color_class .'">'. $link['title'] .'</span>';
            echo '</a>';
            echo '</div>';

        endwhile;

    endif;

    echo '</div>';
    if( $container ):
        echo '</div>';
    endif;

endif; ?>


