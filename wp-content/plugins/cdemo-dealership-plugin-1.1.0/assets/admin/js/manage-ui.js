/**
 * @summary manage meta fields output for each vehicle category with a jQuery drag and drop UI.
 *
 * @since 1.0.0
 */
(function ($) {
    "use strict";

    const module = {

        /**
         * @summary Initialize DOM and event handlers.
         *
         * @since 1.0.0
         * @return {void}
         */
        init: function () {

            /**
             * @summary Initialize two way sortable
             */
            $('#cdemo-available-fields, #cdemo-fields-configuration').sortable({
                handle: '.field-title',
                appendTo: 'body',
                revert: 'invalid',
                tolerance: 'pointer',
                items: 'li:not(.empty-message)',
                connectWith: '.ui-fields',
                start: function (e, ui) {

                    if (ui.item.hasClass('expanded')) {

                        // Collapse the field
                        ui.item.find('.content').slideUp(100);
                        module.toggle_field(ui.item);

                        // Resize the field placeholder
                        ui.placeholder.animate({
                            height: ui.item.find('.field-title').outerHeight(true)
                        }, 'fast');

                    }

                },
                over: function (e, ui) {

                    const $target = $(e.target),
                          $sender = ui.sender;

                    if ($sender) {

                        // If this was the last element in the sending list
                        if ($sender.find('li:not(.empty-message)').length === 1) {
                            $sender.find('.empty-message').slideDown();
                        } else {
                            $sender.find('.empty-message').slideUp();
                        }

                    }

                    // If there is elements in the receiving list
                    if ($target.find('li:not(.empty-message)').length > 0) {
                        $target.find('.empty-message').slideUp();
                    } else {
                        $target.find('.empty-message').slideDown();
                    }

                    // Toggle whether or not editing is available
                    ui.item.toggleClass('editable', $target.parents('.ui-edit-fields').length > 0);

                    // Resize the width to match the target width
                    if (!ui.item.find('.content').is(':visible')) {
                        ui.item.animate({ width: $target.width() }, 100);
                    }

                },
                receive: function (e, ui) {

                    if (ui.sender) {

                        if (ui.sender.parents('.ui-edit-fields').length > 0) {
                            module.revert_field(ui.item);
                        } else {
                            module.enable_field(ui.item);
                            module.toggle_field(ui.item);
                        }

                    }

                }
            })
            .disableSelection();

            /**
             * @summary Expand the field details when toggled.
             */
            $(document).on('click', '.field-title', function () {

                if ($(this).parent().hasClass('editable')) {
                    module.toggle_field($(this).parents('.ui-field'));
                }

            });

            /**
             * @summary disable all fields in the palette by default.
             */
            $('.ui-fields-palette').find(':input').prop('disabled', true);

        },

        /**
         * Revert a field to its inert state.
         *
         * @param $field
         *
         * @since 1.0.0
         * @return void
         */
        revert_field: function ($field) {
            $field.find(':input').prop('disabled', true);
        },


        /**
         * Renable all inputs on a reverted field.
         *
         * @param $field
         *
         * @since 1.0.0
         * @return void
         */
        enable_field: function ($field) {
            $field.find(':input').prop('disabled', false);
        },


        /**
         * Toggle the display of editable properties for a field.
         *
         * @param $field
         *
         * @since 1.0.0
         * @return void
         */
        toggle_field: function ($field) {

            if ($field.hasClass('expanded')) {

                $field.removeClass('expanded')
                    .find('.content')
                    .slideUp('fast');

            } else {

                $field.addClass('expanded')
                    .find('.content')
                    .slideDown('fast');

            }

        },

    };

    /**
     * @summary Initialize the module once the DOM is ready
     */
    $(document).ready(function () { module.init(); });

})(jQuery);