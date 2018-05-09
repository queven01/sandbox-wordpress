/**
 * Module for single listing view.
 *
 * @since 1.0.0
 */
;(function ($) {
    "use strict";

    $(function () {

        /**
         * @summary Initialize image gallery
         */
        $('#gallery').lightSlider({
            gallery: true,
            item: 1,
            auto: true,
            loop: true,
            pauseOnHover: true,
            slideMargin: 0,
            thumbItem: 4,
            onSliderLoad: function(el) {
                el.lightGallery({
                    selector: '#gallery .lslide'
                });
            }
        });

    });

})(jQuery);