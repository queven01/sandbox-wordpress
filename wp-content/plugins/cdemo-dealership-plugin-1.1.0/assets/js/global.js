/**
 * @summary Module for site wide functionality.
 *
 * @since 1.0.0
 */
;(function ($) {
    "use strict";

    /**
     * @summary Initialize click handlers and listeners when the DOM loads.
     *
     * @since 1.0.0
     * @return {void}
     */
    function init() {

        /**
         * @summary Initialize Owl Carousel
         */
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            dots: false,
            lazyLoad : true,
            animateOut: 'fadeOut',
            autoplay: true,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 4
                }
            }
        });



    }

    // Initialize module
    $(init);

})(jQuery);