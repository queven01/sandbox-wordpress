<?php

namespace cdemo;


?>

<div class="modal fade cdemo-gform-modal" id="gform-modal-<?php esc_attr_e( $id ); ?>" role="dialog">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close pull-right" data-dismiss="modal">&times;</button>

                <h4 class="modal-title"><?php esc_html_e( $form['title'] ); ?></h4>

            </div>

            <div class="modal-body"><?php gravity_form( $form_id, false, true, false, null, true ); ?></div>

        </div>

    </div>

</div>

