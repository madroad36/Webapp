$(document).ready(function () {

    $("#service-category").autocomplete({
        source: function (request, response) {
            var val = $(".search-category option:selected").val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'Post',
                url: baseUrl+'/category/getcategory',
                data: {
                    term: request.term,
                },
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    var resp = $.map(data, function (obj) {

                        // display the selected text
                        // save selected id to hidden input
                        return obj.name;

                    });

                    response(resp);
                },

                error: function (data) {

                }
            });
        },
        minLength: 1
    });
    $("#service-subcategory").autocomplete({
        source: function (request, response) {
            var category = $('#service-category').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'Post',
                url: baseUrl+'/category/getsubcategory',
                data: {
                    category:category,
                    term: request.term,
                },
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    var resp = $.map(data, function (obj) {

                        // display the selected text
                        // save selected id to hidden input
                        return obj.title;

                    });

                    response(resp);
                },

                error: function (data) {

                }
            });
        },
        minLength: 1
    });
    $("#service-title").autocomplete({
        source: function (request, response) {
            var category = $('#service-category').val();
            var subcategory = $('.service-subcategory').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'Post',
                url: baseUrl+'/category/getTitle',
                data: {
                    subcategory:subcategory,
                    category:category,
                    term: request.term,
                },
                dataType: "json",
                success: function (service) {
                    console.log(service);
                    var resp = $.map(service, function (obj) {

                        // display the selected text
                        // save selected id to hidden input
                        return obj.title;
                        $('.service-subcategory').text(obj.id);
                    });

                    response(resp);
                },

                error: function (data) {

                }
            });
        },
        minLength: 1
    });


});