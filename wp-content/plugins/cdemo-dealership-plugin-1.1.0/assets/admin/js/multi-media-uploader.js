/**
 *
 * wpMediaUploader v1.0 2016-11-05
 * Copyright (c) 2016 Smartcat
 *
 */
( function( $ ) {

    $.cdemo_multi_media = function( options ) {

        var settings = $.extend({

            target : '.multiple-uploader',
            uploaderTitle : 'Select or upload image',
            uploaderButton : 'Set image',
            multiple : true,
            modal : false,
            callback: ''

        }, options );

        $( 'body' ).on( 'click', settings.target, function( e ) {

            e.preventDefault();

            var custom_uploader = wp.media({
                title: settings.uploaderTitle,
                multiple: settings.multiple,
                button: {
                    text: settings.uploaderButton
                }
            })
            .on( 'select', function() {

                custom_uploader
                    .state()
                    .get( 'selection' )
                    .toJSON()
                    .forEach(function ( attachment ) {

                        $( settings.target ).parents( 'ul' ).append(
                            '<li class="sortable">' +
                                '<span class="remove dashicons dashicons-trash"></span>' +
                                '<input name="media[]" value="' + attachment.url + '" type="hidden" />' +
                                '<div class="media-thumbnail" style="background: url(' + attachment.url + ')"></div>' +
                            '</li>'
                        );

                    });


                if ( settings.modal ) {
                    $( '.modal' ).css( 'overflowY', 'auto' );
                }

                if  ( settings.callback ) {
                    settings.callback();
                }

            })
            .open();

        });

    };

})( jQuery );
