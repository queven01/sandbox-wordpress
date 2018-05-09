/**
 * Module for handling the UI for data driver sync.
 *
 * @since 1.0.0
 */
;(function ($, cdemo) {
    "use strict";

    /**
     * @summary Sync controls in the admin menu.
     */
    const admin = {

        /**
         * @summary Initialize handlers and events after the DOM has loaded.
         *
         * @since 1.0.0
         * @return void
         */
        bind: function () {

            const $wrapper  = $('#data-driver'),
                  $progress = $('.sync-progress').progressbar(),
                  $message  = $wrapper.next('.sync-message'),
                  $control  = $wrapper.find('.control-sync');

            /**
             * @summary Subscribe to sync events.
             */
            cdemo.sync.state().subscribe(function (state) {

                // Bind wrapper class
                $wrapper.attr('class', state.status);


                // Bind the progressbar
                $progress.progressbar('value', state.progress);


                // Bind the message text
                $message.text(function () {
                    return state.message || $message.text();
                });


                // Set our sync action handlers
                if (state.status === cdemo.sync.status.STARTED) {
                    $control.data('onClick', cdemo.sync.pause);

                // If there is a sync running
                } else {
                    $control.data('onClick', cdemo.sync.start);
                }

                // Disable the button while buffering
                $control.prop('disabled', state.status === cdemo.sync.status.BUFFERING);

            });

            /**
             * @summary Call our sync handler callback.
             */
            $control.click(function () {
                $control.data('onClick').call();
            });

        },

    };


    /**
     * @summary Initialize the module
     */
    $(admin.bind);

})(jQuery, cdemo);
