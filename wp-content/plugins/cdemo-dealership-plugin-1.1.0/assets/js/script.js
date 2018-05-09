jQuery(document).ready(function ($) {
    "use strict";

    $('#cdemo .nav-pills.tabs a').click(function(){
        $(this).tab('show');
    });





    $('.datetime-picker').datetimepicker({
        format: 'MM/DD/YYYY h:mm A',
        defaultDate: moment(),
        showTodayButton: true
    });


    $('.contact-form input[name="contact[preferred]"]').change(function () {
        $(this).parents('form')
                .find('.preferred-contact')
                .toggle()
                .each(function () {
                    $(this).prop('required', !$(this).prop('required'));
                });
    });

    $('.contact-form .comments').keyup(function () {
        $(this).parent()
                .find('.current-count')
                .text($(this).val().length)
    });



    $('#cdemo-advanced-search-form').submit(function (e) {

        var action = $(this).attr('action') + '?';
        var query  = {};


        $(this).serializeArray().forEach(function (arg) {

            if (arg.value) {

                if (!query[arg.name]) {
                    query[arg.name] = arg.value;
                } else {

                    if (!Array.isArray(query[arg.name])) {
                        query[arg.name] = [ query[arg.name] ];
                    }

                    query[arg.name].push(arg.value);

                }

            }

        });

        Object.keys(query).forEach(function (key) {

            if (Array.isArray(query[key])) {
                query[key] = query[key].join($('[name="' + key + '"').data('join'));
            }

        });


        // Cleanup array keys
        const regex = new RegExp(/(\[])$/g);

        Object.keys(query).forEach(function (key) {

            if (regex.test(key)) {
                query[key.replace(regex, '')] = query[key];
                delete(query[key]);
            }

        });

        e.preventDefault();

        // Redirect to the new query
        location.href = action + $.param(query);

    });


});