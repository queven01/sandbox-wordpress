/**
 * @summary Module for handling WordPress admin bar actions
 */
;(function ($, cdemo) {
    "use strict";

    /**
     * @summary Admin bar handlers and events
     */
    const admin_bar = {

        /**
         * @summary Initialize event handlers once the DOM has loaded.
         *
         * @since 1.0.0
         * @return void
         */
        bind: function () {

            // Get the admin bar link
            const $link     = $('#wp-admin-bar-cdemo-sync'),
                  $message  = $('#wp-admin-bar-cdemo-sync-status .ab-item'),
                  $progress = $link.find('.progress');


            // Initialize progress bar
            $progress.circleProgress({
                size:  60,
                value: 0
            });

            // Bind the UI to the state
            cdemo.sync.state().subscribe(function (state) {

                // Bind link class
                $link.find('.ab-item').attr('data-status', state.status);

                if (state.status === cdemo.sync.status.STARTED) {
                    $link.data('onClick', cdemo.sync.pause);

                // If there is a sync running
                } else {
                    $link.data('onClick', cdemo.sync.start);
                }

                $progress
                    .circleProgress('value', state.progress / 100)
                    .find('strong').html(state.progress + '<i>%</i>');

                // Set sync message text
                $message.html(state.message);

            });


            // Call our handler on click
            $link.click(function(e) {
                $link.data('onClick').call();
                e.preventDefault();
            });

        }

    };

    // Initialize handlers
    $(admin_bar.bind);

})(jQuery, cdemo);