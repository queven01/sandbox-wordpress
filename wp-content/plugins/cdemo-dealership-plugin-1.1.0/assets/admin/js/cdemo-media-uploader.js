/**
 * 
 * wpMediaUploader v1.0 2016-11-05
 * Copyright (c) 2016 Smartcat
 * 
 */
( function( $) {
    $.cdemo_media = function( options ) {
        
        var settings = $.extend( {
            
            target : '.smartcat-uploader', // The class wrapping the textbox
            uploaderTitle : 'Select or upload image', // The title of the media upload popup
            uploaderButton : 'Set image', // the text of the button in the media upload popup
            multiple : false, // Allow the user to select multiple images
            buttonText : 'Upload image', // The text of the upload button
            buttonClass : '.smartcat-upload', // the class of the upload button
            previewSize : '150px', // The preview image size
            modal : false // is the upload button within a bootstrap modal ?
            
        }, options );

        $( settings.target ).each( function () {

            var input = $( this ).find( 'input' );

            $( this ).append( '<a href="#" class="button button-default ' + settings.buttonClass.replace('.','') + '">' + settings.buttonText + '</a>' );
            $( this ).prepend('<div><img src="' + input.val() + '" style="width: ' + settings.previewSize + '"/></div><br>')

            $('body').on('click', settings.buttonClass, function(e) {

                e.preventDefault();
                var selector = $(this).parent( this );
                var custom_uploader = wp.media({
                    title: settings.uploaderTitle,
                    multiple: settings.multiple,
                    button: {
                        text: settings.uploaderButton
                    }
                })
                    .on('select', function() {
                        var attachment = custom_uploader.state().get('selection').first().toJSON();
                        selector.find( 'img' ).attr( 'src', attachment.url).show();
                        selector.find( 'input' ).val(attachment.url);
                        if( settings.modal ) {
                            $('.modal').css( 'overflowY', 'auto');
                        }
                    })
                    .open();
            });

        } );


        
        
    }
})(jQuery);
