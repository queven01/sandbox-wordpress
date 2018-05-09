/**
 * Module for managing listing metaboxes.
 *
 * @since 1.0.0
 */
;(function ($, localize) {
    "use strict";

    /**
     * @summary Initialize module and event handlers after DOM has loaded
     *
     * @since 1.0.0
     * @return void
     */
    function init() {

        /**
         * @summary Initialize metabox tabs.
         */
        $('.postbox .cdemo-tabs').tabs({
            activate: media.resize
        });

        /**
         * @summary Initialize tooltips
         */
        $('.meta-field-tooltip').tooltip({
            container: 'body',
            delay: {
                show: 1000,
                hide: 100
            }
        });

        /**
         * @summary Make media thumbnails sortable.
         */
        $('.cdemo-media ul').sortable({
            items: '.sortable'
        })
        .disableSelection();


        /**
         * @summary Adjust media thumbnails on window resize.
         */
        $(window).resize(media.resize);


        /**
         * @summary Initialize the media uploader.
         */
        $.cdemo_multi_media({
            target: '.upload-media',
            multiple: true,
            callback: media.resize,
            uploaderTitle: localize.media_uploader_title,
            uploaderButton: localize.media_uploader_button
        });


        /**
         * @summary Initialize the date picker.
         */
        $('.ui-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        });


        /**
         * @summary Handle removing media.
         */
        $(document).on('click', '.cdemo-media li .remove', function () {
            return media.remove($(this).parents('li'));
        });


        /**
         * @summary Initialize autocomplete fields.
         */
        $('.ui-auto-complete').autocomplete({
            autoFocus: true,
            source: autocomplete
        });


        /**
         * @summary Initialize hide-show for feature sections.
         */
        $('.feature-section-title').click(function () {
            features.toggle($(this));
        });


        /**
         * @summary Add handler for creating new features.
         */
        $('.add-feature-submit').click(function () {
            const section_id = $(this).parent().data('section-id'),
                  $name      = $(this).siblings('.feature-name'),
                  $features  = $(this).parents('.features-wrap').find('.select-features');

            features.add(section_id, $name, $features);
        });


        /**
         * @summary Remove a feature from a feature section.
         */
        $(document).on('click', '.remove-feature', function (e) {
            const name     = $(this).data('feature'),
                  section  = $(this).data('section'),
                  $feature = $(this).parents('.feature');

            features.remove(section, name, $feature);
            e.preventDefault();
        });


        /**
         * @summary Calculate financing payments
         */
        $('#cdemo-calc-payments').click(function (e) {
            financing.calculate();
            e.preventDefault();
        });


        /**
         * @summary Set the display for the finance calculation base price.
         */
        $('#cdemo-financing-price').change(function () {
            financing.set_base_price($('[name="' + $(this).val() + '"]').val() || 0);
        });

        financing.set_base_price($('[name="' + $('#cdemo-financing-price').val() + '"]').val() || 0);

    }

    /**
     * Field autocomplete handler.
     *
     * @param request
     * @param response
     *
     * @since 1.0.0
     * @return void
     */
    function autocomplete(request, response) {

        const data = {
            field: $(this.element).attr('name'),
            action: 'cdemo_autocomplete_field',
            _ajax_nonce: localize.ajax_nonce,
            args: request
        };

        const dep = $($(this.element).data('field-depend'));

        // Pass dependency fields as args
        if (dep.length) {
            dep.each(function (i, el) {
                data.args[$(el).attr('name')] = $(el).val();
            });
        }

        $.ajax({
            url: localize.ajax_url + '?' + $.param(data),
            success: function (res) {
                if (res.success) {
                    response(res.data);
                }
            }
        });

    }


    /**
     * Handlers for listing media
     *
     * @since 1.0.0
     */
    const media = {

        /**
         * Resize media thumbnails to fit inside the viewport.
         *
         * @since 1.0.0
         * @return void
         */
        resize: function () {

            $('.cdemo-media li').each(function (i, el) {
                $(el).css({height: $(el).width()});
            });

        },

        /**
         * Remove a media thumbnail.
         *
         * @param $media
         *
         * @since 1.0.0
         * @return {boolean}
         */
        remove: function ($media) {

            $media.animate({
                width: 'toggle',
                height: 'toggle'
            }, function () {
                $media.remove();
            });

            return true;

        }

    };


    /**
     * Handlers for listing features.
     *
     * @since 1.0.0
     */
    const features = {

        /**
         * Add a new custom feature to the list of features.
         *
         * @param section_id
         * @param $name
         * @param $features
         *
         * @since 1.0.0
         * @return void
         */
        add: function (section_id, $name, $features) {

            if ($name.val()) {

                $.ajax({
                    url: localize.ajax_url,
                    method: 'post',
                    data: {
                        action: 'cdemo_add_feature',
                        _ajax_nonce: localize.ajax_nonce,
                        feature: $name.val(),
                        post_id: $('#post_ID').val(),
                        section_id: section_id
                    },
                    success: function (res) {

                        if (res.success) {
                            const $toggle = $(res.data.template.rendered).hide();

                            $features.append($toggle);
                            $toggle.slideToggle('fast');
                            $name.val('');
                        }
                    }
                });

            }

        },


        /**
         * Remove a feature from the list of available features.
         *
         * @param section_id
         * @param name
         * @param $feature
         *
         * @since 1.0.0
         * @return void
         */
        remove: function (section_id, name, $feature) {

            $.ajax({
                url: localize.ajax_url,
                method: 'post',
                data: {
                    action: 'cdemo_remove_feature',
                    _ajax_nonce: localize.ajax_nonce,
                    section_id: section_id,
                    feature: name,
                    post_id: $('#post_ID').val()
                },
                success: function (res) {

                    if (res.success) {
                        $feature.slideToggle('fast', function () {
                            $feature.remove();
                        });
                    }

                }
            });

        },

        /**
         * Toggle the display of a feature section.
         *
         * @param $feature
         *
         * @since 1.0.0
         * @return void
         */
        toggle: function ($feature) {
            $feature.toggleClass('expanded').next('.features-wrap').slideToggle('fast');
        },

    };


    /**
     * Handlers for the financing calculator.
     *
     * @since 1.0.0
     */
    const financing = {


        /**
         * Run calculations.
         *
         * @since 1.0.0
         * @return void
         */
        calculate: function () {
            const price   = parseFloat($('[name="' + $('#cdemo-financing-price').val() + '"]').val()) || 0,
                  initial = parseFloat($('#cdemo-down-payment').val()),

                  // Calculate present value as the price - % down
                  pv = price - ( price * ( initial ? initial / 100 : 0 ) ),

                  // The APR
                  r = parseFloat($('#cdemo-percent-apr').val()) || 0,

                  // The total number of months in the term
                  n = parseFloat($('#cdemo-monthly-period').val()) || 0;

            // The monthly finance price
            $('#cdemo-monthly-finance-price').val(financing.payments(pv, r, n).toFixed(2));

            // The Bi-Weekly finance price
            $('#cdemo-bi-weekly-finance-price').val(financing.payments(pv, r, n / 12 * 26).toFixed(2));

            // The weekly finance price
            $('#cdemo-weekly-finance-price').val(financing.payments(pv, r, n / 12 * 52).toFixed(2));

        },


        /**
         * Set the calculation base price display.
         *
         * @param value
         *
         * @since 1.0.0
         * @return void
         */
        set_base_price: function (value) {
            $('#cdemo-finance-price-preview').val(parseFloat(value).toFixed(2));
        },


        /**
         * Calculate the payment amount for a number of payments.
         *
         * @param pv
         * @param r
         * @param n
         *
         * @since 1.0.0
         * @return {number}
         */
        payments: function (pv, r, n) {
            return ((r / 100) * pv) / (1 - Math.pow(1 + (r / 100), -n));
        }

    };


    /**
     * @summary Initialize the module when the DOM has loaded
     */
    $(document).ready(init);

})(jQuery, cdemo_metabox_l10n);
