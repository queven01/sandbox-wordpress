<?php

namespace cdemo;

?>

<div id="cdemo-gf-forms-config">

    <ul>

        <?php foreach ( get_option( Options::GF_FORMS_CONFIG ) as $id => $config ) : ?>

            <?php get_template( 'settings-contact-form-config', array_merge( array( 'id' => $id ), $config ), true, false ); ?>

        <?php endforeach; ?>

        <li id="cdemo-add-form">

            <p class="header"><?php _e( 'Add New Gravity Form', 'cdemo' ); ?></p>

            <div class="inner">

                <p>
                    <label for="form-button-label"><?php _e( 'Label', 'cdemo' ); ?></label>
                    <input type="text" id="form-button-label" class="regular-text">
                </p>

                <p>
                    <label for="form-id"><?php _e( 'Form', 'cdemo' ); ?></label>

                    <select id="form-id" class="regular-text">

                        <option value=""><?php _e( 'Select a Form', 'cdemo' ); ?></option>

                        <?php foreach ( \GFAPI::get_forms( true ) as $form ) : ?>

                            <option value="<?php esc_attr_e( $form['id'] ); ?>"><?php esc_html_e( $form['title'] ); ?></option>

                        <?php endforeach; ?>

                    </select>

                    <button id="cdemo-add-form-submit" type="button" class="button"><?php _e( 'Add Form', 'cdemo' ); ?></button>
                </p>

            </div>

        </li>

    </ul>

</div>


<script>

    <?php $ajax_url   = admin_url( 'admin-ajax.php' );
          $ajax_nonce = wp_create_nonce( 'cdemo_ajax' ); ?>

    jQuery(document).ready(function ($) {
        const form  = $('#form-id'),
              label = $('#form-button-label');

        $('#cdemo-add-form-submit').click(function () {
            form.prop('required', true);
            label.prop('required', true);

            if (form[0].checkValidity() && label[0].checkValidity()) {
                $.ajax({
                    method: 'post',
                    url: '<?php echo esc_url( $ajax_url ); ?>',
                    data: {
                        action:      'cdemo_add_gravity_form',
                        _ajax_nonce: '<?php echo esc_js( $ajax_nonce ); ?>',
                        label:       label.val(),
                        form_id:     form.find(':selected').val()
                    },
                    success: function (res) {
                        if (res.success) {

                            $(res.data.template.rendered)
                                .hide()
                                .insertBefore('#cdemo-add-form')
                                .slideToggle();

                        }

                        form.val('');
                        label.val('');
                    }
                });
            }

            form.prop('required', false);
            label.prop('required', false);
        });


        $(document).on('click', '.cdemo-gf-form-config .remove', function (e) {
            e.preventDefault();

            $.ajax({
                method: 'post',
                url: '<?php echo esc_url( $ajax_url ); ?>',
                data: {
                    action:      'cdemo_remove_gravity_form',
                    _ajax_nonce: '<?php echo esc_js( $ajax_nonce ); ?>',
                    id:          $(this).data('id')
                },
                success: function (res) {
                    if (res.success) {
                        $(e.target)
                            .parents('.cdemo-gf-form-config')
                            .slideToggle('slow', function () {
                            $(this).remove();
                        });
                    }
                }
            });
        });
    });

</script>