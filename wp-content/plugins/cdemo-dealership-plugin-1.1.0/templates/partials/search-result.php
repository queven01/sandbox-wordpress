<?php
/**
 * Template for a single result in the search results list.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;

?>

<div class="cdemo-search-result">

    <div class="row inner">

        <!-- price -->
        <div class="item-price">

            <?php listing_price_html( get_the_ID() ); ?>

            <div class="clearfix"></div>

        </div>
        <!-- /price -->

        <div class="col-lg-4">

            <!-- image -->
            <a class="thumbnail" href="<?php the_permalink(); ?>">
                <img class="img-thumbnail img-responsive" src="<?php echo esc_url( get_post_image_url() ); ?>">
            </a>
            
            <!-- identification -->
            <div class="identification">

                <?php if ( get_post_meta( get_the_ID(), 'stocknumber', true ) ) : ?>
                
                    <span class="stock-no number">
                        <span class="text-muted label"><?php _e( 'Stock ', 'cdemo' ); ?></span>
                        <span class="value"><?php echo esc_html( get_post_meta( get_the_ID(), 'stocknumber', true ) ); ?></span>
                    </span>
                
                <?php endif; ?>

                <?php if ( get_post_meta( get_the_ID(), 'vin', true ) ) : ?>

                    <span class="vin-no number">
                        <span class="text-muted label"><?php _e( 'VIN ', 'cdemo' ); ?></span>
                        <span class="value"><?php echo esc_html( get_post_meta( get_the_ID(), 'vin', true ) ); ?></span>
                    </span>
                
                <?php endif; ?>

            </div>

        </div>

        <div class="col-lg-8">

            <?php $fields = get_results_page_fields_for_output( get_post_type() ); ?>

            <!-- title -->
            <h2 class="item-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
            <!-- /title -->
            
            <!-- details -->
            <div class="details">

                <table class="details-table">

                    <tr>

                        <?php foreach ( array_slice( $fields, 0, 4 ) as $id => $field ) : ?>

                            <td class="detail">
                                <span class="label text-muted"><?php esc_html_e( $field['label'] ); ?></span>
                                <span class="value"><?php call_user_func( $field['render_callback'], $id ); ?></span>
                            </td>

                        <?php endforeach; ?>

                    </tr>

                </table>

                <?php $more = array_slice( $fields, 5, 4 ); ?>

                <?php if ( !empty( $more ) ) : ?>

                    <div class="mobile-hide">

                        <table class="details-table">

                            <tr>

                                <?php foreach ( $more as $id => $field ) : ?>

                                    <td class="detail">
                                        <span class="label text-muted"><?php esc_html_e( $field['label'] ); ?></span>
                                        <span class="value"><?php call_user_func( $field['render_callback'], $id ); ?></span>
                                    </td>

                                <?php endforeach; ?>

                            </tr>

                        </table>

                    </div>

                    <div class="show-link">
                        <a href="#"
                           data-text-more="<?php _e( 'Show More', 'cdemo' ); ?>"
                           data-text-less="<?php _e( 'Show Less', 'cdemo' ); ?>"><?php _e( 'Show More', 'cdemo' ); ?></a>
                    </div>

                <?php endif; ?>

            </div><!-- /details -->
            
            <!-- blurb -->
            <?php if ( get_the_content() ) : ?>
                <div class="blurb">
                    <?php echo esc_html( wp_trim_words( strip_tags( strip_shortcodes( get_the_content() ) ), 25 ) ); ?>
                </div>
            <?php endif; ?>
            
        </div>

    </div>

</div>