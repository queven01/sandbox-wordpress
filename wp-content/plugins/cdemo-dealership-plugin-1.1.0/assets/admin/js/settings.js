/**
 * Module for the plugin settings page
 */
;(function ($, localize) {
    "use strict";

    $(function () {

        $('.cdemo-color-picker').wpColorPicker();

        $.cdemo_media({
            target: '.cdemo-media-uploader',
            uploaderTitle: localize.media_uploader_title,
            uploaderButton: localize.media_uploader_button,
            multiple: false,
            buttonText: localize.media_uploader_button,
            buttonClass: '.cdemo-upload-media',
            previewSize: '150px',
            modal: false
        });

    });

})(jQuery, cdemo_admin_l10n);