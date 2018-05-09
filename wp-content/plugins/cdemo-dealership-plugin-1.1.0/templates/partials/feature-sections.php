<?php

namespace cdemo;

?>

<?php foreach ( $sections as $id => $section ) : ?>

    <div class="form-field feature-section metabox-group" >

        <h4 class="feature-section-title"><?php esc_html_e( $section ); ?> <span class="toggle"></span></h4>

        <div class="features-wrap" style="display: none">

            <div class="add-feature" data-section-id="<?php esc_attr_e( $id ); ?>">
                <input type="text" class="feature-name">
                <button class="button add-feature-submit" type="button"><?php _e( 'Add Feature', 'cdemo' ); ?></button>
            </div>

            <?php $features = get_post_meta( get_the_ID(), "available_features-$id", true ) ?: array(); ?>

            <?php $enabled = get_post_meta( get_the_ID(), "features-$id" ); ?>

            <fieldset class="select-features">

                <?php foreach ( $features as $feature ) : ?>

                    <?php

                        $args = array(
                            'section' => $id,
                            'feature' => $feature,
                            'enabled' => in_array( $feature, $enabled )
                        );

                    ?>

                    <?php get_template( 'feature-toggle', $args, true, false ); ?>

                <?php endforeach; ?>

            </fieldset>

        </div>

    </div>

<?php endforeach; ?>
