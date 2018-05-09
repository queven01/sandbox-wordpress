<?php

namespace cdemo;

?>

<div class="feature">

    <div class="inner">

        <label>

            <input type="checkbox"
                   name="features-<?php esc_attr_e( $section ); ?>[]"
                   value="<?php esc_attr_e( $feature ); ?>" <?php checked( true, $enabled ); ?> />

            <?php esc_html_e( $feature ); ?>

        </label>

    </div>

    <a href="#"
       class="remove-feature"
       data-section="<?php esc_attr_e( $section ); ?>"
       data-feature="<?php esc_attr_e( $feature ); ?>">

        <span class="dashicons dashicons-trash"></span>

    </a>

</div>