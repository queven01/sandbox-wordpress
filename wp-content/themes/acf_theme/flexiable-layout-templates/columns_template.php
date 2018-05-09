<?php
if( get_row_layout() == 'columns_row' ):

    echo '<div class="row" style="margin: 0;">';

        if( have_rows('columns') ):

            while ( have_rows('columns') ) : the_row();

                $column_title = get_sub_field('title');
                $column_content = get_sub_field('editor');

                if( have_rows('column_width') ):

                    while ( have_rows('column_width') ) : the_row();

                        $desktop_view = get_sub_field('desktop_view');
                        $tablet_view = get_sub_field('tablet_view');
                        $mobile_view = get_sub_field('mobile_view');
                        $column_padding = 'padding:'. get_sub_field('column_padding') . ';';

                        echo '<div class="column-background '. $desktop_view .' '. $tablet_view .' '. $mobile_view ;

                    endwhile;

                    while ( have_rows('background_options') ) : the_row();

                        $column_background = 'background-image: url(' . get_sub_field('background') . ');';
                        $parallax_effect = get_sub_field('parallax_effect');

                        if ($parallax_effect):
                            $fixed = 'fixed';
                            echo  ' '. $fixed;
                        endif;

                        echo '" style="'. $column_background .' '. $column_padding;


                    endwhile;

                    while ( have_rows('text_options') ) : the_row();

                        $text_alignment =  get_sub_field('text_alignment');
                        $text_color = 'color: '.get_sub_field('text_color').';';
                        $heading_size =  get_sub_field('heading_size');

                        echo ' '. $text_alignment .' ' . $text_color. '">';

                        echo '<'.$heading_size.'>'. $column_title .'</'.$heading_size.'>';
                        echo  $column_content;

                    endwhile;
                endif;

                if( have_rows('button_styles') ):

                    while ( have_rows('button_styles') ) : the_row();

                        $button_class = get_sub_field('button_class');
                        $link = get_sub_field('button');

                        echo '<a href="'.$link['url'].'" class="btn '.$button_class.'">'.$link['title'].'</a>';

                        if ($button_class == 'btn-custom'):

                            while ( have_rows('custom_button_settings') ) : the_row();

                                $color = get_sub_field('color');
                                $background_color = 'background: '. get_sub_field('background_color').';';
                                $top_bottom_padding = get_sub_field('top_bottom_padding');
                                $left_right_padding = get_sub_field('left_right_padding');
                                $padding = 'padding:'.$top_bottom_padding.' '.$left_right_padding.';';
                                $font_size = 'font-size: '.get_sub_field('font_size').';';

                                echo '<a class="btn" href="'.$link['url'].'" style="'.$background_color.' '.$padding.' '. $font_size .'">'.$link['title'].'</a>';

                            endwhile;

                        endif;

                    endwhile;

                endif;

                echo '</div>';

            endwhile;

        endif;

    echo '</div>';

endif; ?>
