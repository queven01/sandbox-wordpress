<?php

namespace cdemo; ?>

<?php get_header(); ?>


<?php while ( have_posts() ) : the_post(); ?>

    <div class="cdemo-vdp">

        <section class="spec-section">

            <div class="container">

                <h1 class="listing-title"><?php the_title(); ?></h1>

                <div class="row">

                    <div class="col-sm-12 col-md-7">

                        <div class="gallery">

                            <?php $images = get_post_meta( get_the_ID(), 'media', true ) ?: array(); ?>

                            <ul id="gallery">

                                <?php foreach ( $images as $image ) : ?>

                                    <li data-thumb="<?php echo esc_url( $image ); ?>" data-src="<?php echo esc_url( $image ); ?>">
                                        <img src="<?php echo esc_url( $image ); ?>" />
                                    </li>

                                <?php endforeach; ?>

                            </ul>

                        </div>

                    </div>

                    <div class="col-sm-6 col-md-4 col-md-offset-1 col-sm-push-6 col-md-push-0">

                        <div class="panel panel-default">

                            <div class="panel-body">

                                <div class="pricing">

                                    <?php $currency = get_listing_currency(); ?>
                                    <?php $pricing  = get_listing_prices(); ?>

                                    <?php if ( !empty( $pricing['msrp'] ) ) : ?>

                                        <div class="price-block">
                                            <p class="price-title"><?php esc_html_e( get_option( Strings::PRICE_MSRP ) ); ?></p>
                                            <p class="price price-msrp">
                                                <?php echo format_currency( $pricing['msrp'] ?: 0, $currency ); ?>
                                            </p>
                                        </div>

                                        <hr>

                                    <?php endif; ?>

                                    <?php if ( $pricing['listing_price'] < $pricing['msrp'] ) : ?>

                                        <div class="price-block cdemo-primary-color">
                                            <p class="price-title"><?php esc_html_e( get_option( Strings::PRICE_LISTING_DISCOUNT ) ); ?></p>
                                            <p class="price price-msrp">
                                                <?php echo format_currency( $pricing['msrp'] - $pricing['listing_price'], $currency ); ?>
                                            </p>
                                        </div>

                                    <?php endif; ?>

                                    <?php if ( $pricing['discount'] > 0 ) : ?>

                                        <div class="price-block">
                                            <p class="price price-listing strike-through">
                                                <?php echo format_currency( $pricing['listing_price'], $currency ); ?>
                                            </p>
                                        </div>

                                        <div class="price-block">
                                            <p class="price-title"><?php esc_html_e( get_option( Strings::PRICE_LISTING ) ); ?></p>
                                            <p class="price price-listing">
                                                <?php echo format_currency( $pricing['actual_price'], $currency ); ?>
                                            </p>
                                        </div>

                                    <?php else : ?>

                                        <div class="price-block">
                                            <p class="price-title"><?php esc_html_e( get_option( Strings::PRICE_LISTING ) ); ?></p>
                                            <p class="price price-listing">
                                                <?php echo format_currency( $pricing['actual_price'], $currency ); ?>
                                            </p>
                                        </div>

                                    <?php endif; ?>

                                </div>

                                <hr>

                                <div class="contact-form">

                                    <?php get_template( 'contact-form-' . get_option( Options::LEAD_COLLECTION ) ); ?>

                                </div>

                                <hr>

                                <div>
                                    <div>
                                        <span class="text-uppercase"><?php _e( 'Stock', 'cdemo' ); ?></span>:
                                        <span class="pull-right"><?php esc_html_e( get_post_meta( get_the_ID(), 'stocknumber', true ) ); ?></span>
                                    </div>
                                    <div>
                                        <span class="text-uppercase"><?php _e( 'VIN', 'cdemo' ); ?></span>:
                                        <span class="pull-right"><?php esc_html_e( get_post_meta( get_the_ID(), 'vin', true ) ); ?></span>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="media fuel-efficiency">

                            <div class="media-left">
                                <img class="media-object" src="<?php echo esc_url( resolve_url( 'assets/images/icon-fuel.png' ) ); ?>">
                            </div>

                            <div class="media-body">

                                <span>
                                    <strong><?php esc_html_e( get_post_meta( get_the_ID(), 'fuel_economy_city', true ) ); ?></strong> <small><?php _e( 'CITY', 'cdemo' ); ?></small>
                                </span>

                                <span>
                                    <strong><?php esc_html_e( get_post_meta( get_the_ID(), 'fuel_economy_hwy', true ) ); ?></strong> <small><?php _e( 'HWY', 'cdemo' ); ?></small>
                                </span>

                                <?php $units = get_post_meta( get_the_ID(), 'fuel_economy_unit', true ) ?: get_option( Options::MEASUREMENT_UNITS ); ?>

                                <?php if ( $units == 'metric' ) : ?>

                                    <p><?php _e( 'L/100km', 'cdemo' ); ?></p>

                                <?php else : ?>

                                    <p><?php _e( 'MPG', 'cdemo' ); ?></p>

                                <?php endif; ?>

                            </div>

                        </div>

                    </div>

                    <div class="col-sm-6 col-md-12 col-sm-pull-6 col-md-pull-0">

                        <?php $fields = get_details_page_fields_for_output( get_post_type() ); ?>

                        <!-- specs -->
                        <div class="specs">

                            <div class="panel panel-primary">

                                <div class="panel-heading">
                                    <p><?php _e( 'Vehicle Specifications', 'cdemo' ); ?></p>
                                </div>

                                <table class="spec-table table">

                                    <?php foreach ( $fields as $id => $field ) : ?>

                                        <tr>
                                            <th><?php esc_html_e( $field['label'] ); ?></th>
                                            <td><?php call_user_func( $field['render_callback'], $id ); ?></td>
                                        </tr>

                                    <?php endforeach; ?>

                                </table>

                            </div>

                        </div><!-- /specs -->

                    </div>

                </div>

            </div>

        </section>

        <section class="description-section cdemo-text-default">

            <div class="container">
                <div class="row">
                    <div class="col-sm-12"><?php the_content(); ?></div>
                </div>
            </div>

        </section>

        <section class="details-section">

            <div class="container">

                <?php get_template( 'vdp-details-' . get_post_type() ); ?>

            </div>

        </section>

        <?php $related = get_related_listings(); ?>

        <?php if ( $related->have_posts() ) : ?>

        
            <!-- This HTML structure is being replicated in widget-listings.php partial -->
            <!-- Consider this when making changes to html structure or classes -->
            <section class="relatives-section">

                <div class="container">

                    <div class="row">

                        <div class="col-sm-6">

                            <h4 class="cdemo-text-default">

                                <?php _e( 'Similar Vehicles', 'cdemo' );?>
                                <a href="<?php the_permalink( get_option( Options::SEARCH_PAGE_ID ) ); ?>"
                                   class="btn btn-primary view-more-link"><?php _e( 'View More', 'cdemo' ); ?>
                                </a>

                            </h4>

                        </div>

                        <div class="col-sm-12">

                            <div class="cdemo-carousel owl-carousel owl-theme">

                                <?php while ( $related->have_posts() ) : $related->the_post(); ?>

                                    <div class="item">
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

                </div>

            </section>

        <?php endif; ?>


        <section class="widget-section cdemo-bg-default">

            <div class="container">
                <div class="row">
                    <?php dynamic_sidebar( 'listing-widget-area' ); ?>
                </div>
            </div>

        </section>

    </div>

    <?php wp_reset_postdata(); ?>

<?php endwhile; ?>

<?php get_footer(); ?>
