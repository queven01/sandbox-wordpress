<?php

namespace cdemo;

?>

<li class="cdemo-gf-form-config">

    <span class="header">
        <a href="#" class="remove" data-id="<?php esc_attr_e( $id ); ?>">
            <span class="dashicons dashicons-trash"></span>
        </a>
    </span>

    <div class="inner">

        <p>

            <label for="form-button-label-<?php esc_attr_e( $id ); ?>"><?php _e( 'Label', 'cdemo' ); ?></label>

            <input type="text"
                   class="regular-text"
                   id="form-button-label-<?php esc_attr_e( $id ); ?>"
                   name="<?php esc_attr_e( Options::GF_FORMS_CONFIG ); ?>[<?php esc_attr_e( $id ); ?>][label]"
                   value="<?php esc_attr_e( $label ); ?>"
                   required="required">

        </p>

        <p>
            <label for="form-id-<?php esc_attr_e( $id ); ?>"><?php _e( 'Form', 'cdemo' ); ?></label>

            <select id="form-id-<?php esc_attr_e( $id ); ?>"
                    class="regular-text"
                    name="<?php esc_attr_e( Options::GF_FORMS_CONFIG ); ?>[<?php esc_attr_e( $id ); ?>][form_id]"
                    required="required">

                <option value=""><?php _e( 'Select a Form', 'cdemo' ); ?></option>

                <?php foreach ( \GFAPI::get_forms( true ) as $form ) : ?>

                    <option value="<?php esc_attr_e( $form['id'] ); ?>" <?php selected( $form['id'], $form_id ); ?> >

                        <?php esc_html_e( $form['title'] ); ?>

                    </option>

                <?php endforeach; ?>

            </select>

        </p>

        <p>

            <label for="shortcode-<?php esc_attr_e( $id ); ?>">
                <?php _e( 'Shortcode', 'cdemo' ); ?>
            </label>

            <span>

                <input class="regular-text"
                       readonly="readonly"
                       type="text"
                       id="shortcode-<?php esc_attr_e( $id ); ?>"
                       value='[gform target="<?php esc_attr_e( $id ); ?>"]' />

                <span class="description"><?php _e( 'Paste this shortcode into the Form Content editor', 'cdemo' ); ?></span>

            </span>

        </p>

    </div>

</li>
