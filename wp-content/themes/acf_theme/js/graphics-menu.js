jQuery(function($) {
$(document).ready(function(){
    $('.widget_wpdm_newpacks_widget').hover(function(){
        $('.widget_wpdm_newpacks_widget .w3eden').toggleClass('closed');
    })
    $('.widget_wpdm_topdls_widget').hover(function(){
        $('.widget_wpdm_topdls_widget .w3eden').toggleClass('closed');
    })
    $('.widget_wpdm_categories_widget').hover(function(){
        $('.widget_wpdm_categories_widget .w3eden').toggleClass('closed');
    })
    $('.widget_tag_cloud').hover(function(){
        $('.widget_tag_cloud .tagcloud').toggleClass('closed');
    })
    $('.widget_search').hover(function(){
        $('.widget_search .search-form').toggleClass('closed');
    })
});
});

//
// jQuery(function($) {
//     $(document).ready(function(){
//         $('.widget_tag_cloud .tagcloud a').click(function (event) {
//             event.preventDefault();
//
//             var string = $(this).text();
//             var newString = string.replace(/\s/g, '-');
//             var location = window.location.href.slice(0,-1)
//             var newURL = location + ',' + newString;
//
//             window.location.href = newURL;
//         })
//     });
// });
//
jQuery(function($) {
    $(document).ready(function(){
        if(window.location.href.indexOf("?downloaded=true") > -1) {
            window.location = window.location.href.slice(0, -16)
        }
        $('.custom_download_link').click(function(event) {

            var location = window.location.href
            var newURL = location + '?downloaded=true';
            window.location.href = newURL;

        });
    });
});

jQuery(function($) {
    $(document).ready(function(){
        $('.media-library-search ul li h4:contains("Categories")').parent().addClass('categories_dropdown dropdown_menu');
        $('.media-library-search ul li h4:contains("Tags")').parent().addClass('tags_dropdown dropdown_menu');
    });
});
