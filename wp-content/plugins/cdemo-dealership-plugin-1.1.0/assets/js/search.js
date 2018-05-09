/**
 * Module for controlling fields in the search form.
 *
 * @since 1.0.0
 */
;(function ($, localize) {
    "use strict";

    /**
     * @summary Initialize DOM and event handlers
     *
     * @since 1.0.0
     * @return void
     */
    function init() {

        $('#vehicle-category').change(function () {
            location.href = localize.search_url + '?vehicle_category=' + $(this).val();
        });

        /**
         * @summary Initialize fields that can autocomplete with selectize.js
         * @since 1.0.0
         */
        $('.select-multiple').each(function (i, el) {
            var deps = $(el).data('dependencies') || [];

            // Get all dependency selectors
            if (typeof deps === 'string') {
                deps = deps.split(',');
            }

            $(el).selectize({
                plugins: ['remove_button'],
                labelField:  'item',
                valueField:  'item',
                searchField: 'item',
                preload: 'focus',
                load: function (query, callback) {
                    const data = {};

                    // Collect all dependant values
                    deps.forEach(function (dep) {
                        const $dep = $(dep);
                        data[ $dep.attr('name') ] = $dep.val();
                    });

                    $.ajax({
                        url: localize.api.endpoints.fields + "/" + $('[name="vehicle_category"]').val() + '/' + $(el).attr('name') + '/values',
                        data: data
                    })
                    .fail(function () {
                        callback();
                    })
                    .then(function (res) {
                        callback(res.map(function (field) {
                            return { item: field };
                        }));
                    });

                }
            });


            // Copy the placeholder text to the selectize input
            $(el)[0].selectize.on('change', set_placeholder);

            // Initialize placeholders
            set_placeholder.call($(el)[0].selectize);

            // Copy the placeholder text to the selectize input
            function set_placeholder() {
                const $input          = $(this)[0].$input,
                      $control_input  = $(this)[0].$control_input;

                $control_input.attr('placeholder', $input.attr('placeholder'));
            }


            // Reset the field whenever one of its dependencies has changed
            deps.forEach(function (dep) {
                $(dep).on('change', function () {
                    $(el).val('');
                    $(el)[0].selectize.clearOptions();
                });
            });

        });

        /**
         * @summary Initialize plain selectize fields.
         */
        $('[data-selectize]').selectize();


        /**
         * @summary Initialize the year slider.
         * @since 1.0.0
         */
        const $year = $('#year-range-slider');

        if ($year.length > 0) {

            const min = $year.data('min'),
                  max = $year.data('max'),
                  val = $('#vehicle-year').val(),
                  rng = val ? val.split('-') : [ min, max ];
          
            $year.slider({
                range: true,
                values: rng,
                min: min,
                max: max,
                create: function () {
                    $('#display-year-min').html(rng[0]);
                    $('#display-year-max').html(rng[1]);
                },
                slide: function (e, ui) {
                    $('#display-year-min').html(ui.values[0]);
                    $('#display-year-max').html(ui.values[1]);
                    $('#vehicle-year').val(ui.values[0] + '-' + ui.values[1]);
                }
            });

        }


        /**
         * @summary Initialize the price slider.
         * @since 1.0.0
         */
        const $price = $('#price-range-slider');

        if ($price.length > 0) {

            const format = function (val) {
                return Number(val).toLocaleString(localize.locale.replace('_', '-'), {
                    style: 'currency',
                    currencyDisplay: 'symbol',
                    currency: $price.data('currency')
                });
            };

            const min = $price.data('min'),
                  max = $price.data('max'),
                  val = $('#price-range').val(),
                  rng = val ? val.split('-') : [ min, max ];

            $price.slider({
                range: true,
                values: rng,
                step: $price.data('step'),
                min: min,
                max: max,
                create: function () {
                    $('#display-price-min').html(format(rng[0]));
                    $('#display-price-max').html(format(rng[1]));
                },
                slide: function (e, ui) {
                    $('#display-price-min').html(format(ui.values[0]));
                    $('#display-price-max').html(format(ui.values[1]));
                    $('#price-range').val(ui.values[0] + '-' + ui.values[1]);
                }
            });



        }


        /**
         * @summary Adjust the search margin when user scrolls on mobile if admin bar is showing.
         */
        $(window).scroll(function () {
            const $body     = $('body'),
                  $form     = $('#cdemo-search-form'),
                  $adminbar = $('#wpadminbar');

            if ($body.width() <= 600) {

                if ($body.hasClass('has-admin-bar')) {
                    const offset = $form.offset().top - $adminbar.outerHeight(),
                          margin = Number($form.css('margin-top').replace('px', '')) - offset;

                    if (margin >= 0 && margin <= $adminbar.outerHeight()) {
                        $form.css('margin-top', margin);
                    } else {
                        $form.css('margin-top', 0);
                    }

                } else {
                    $form.css('margin-top', 0);
                }

            }

        });


        /**
         * @summary Toggles and controls for the search view
         */
        $('select.search-view-control').change(change_view);
        $('button.search-view-control').click(change_view);

        function change_view(e) {
            const value = $(this).val();
            const name  = $(this).attr('name');

            if ($(this).is('button')) {
                var icon = $(this).find('span.glyphicon');

                icon.removeClass();
                icon.addClass(icon.data(value === 'desc' ? 'sort-asc' : 'sort-desc'));

                $(this).val($(this).data('order-' + value));
            }

            var regex = new RegExp(name + '=([a-z0-9]+)');

            if (regex.exec(location.href)) {
                location.href = location.href.replace(regex, name + '=' + value);
            } else {
                location.href = location.href + (location.href.indexOf('?') > -1 ? '&' : '?') + name + '=' + value;
            }

            e.preventDefault();
        }

        $('.cdemo-search-result .show-link').click(function (e) {
            $('.cdemo-search-result .details .mobile-hide').slideToggle('fast', function () {
                var link = $('.cdemo-search-result .details .show-link a');
                link.text(link.data($(this).is(':hidden') ? 'text-more' : 'text-less'));
            });
            e.preventDefault();
        });

    }

    /**
     * @summary Initialize the module once the DOM has loaded.
     */
    $(document).ready(init);

})(jQuery, cdemo_search_l10n);