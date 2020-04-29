
$(document).ready(function () {

    $("#city").autocomplete({

        source: function (request, response) {
            var url = baseUrl + "/place/getlocation";
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'Post',
                url: url,
                data: {
                    term: request.term,
                },
                dataType: "json",
                success: function (data) {

                    var resp = $.map(data, function (obj) {
                        return obj.name;
                        $('.locationId').text(obj.id);
                    });

                    response(resp);
                },

                error: function (data) {

                }
            });
        },
        minLength: 1
    });
    $("#address").autocomplete({
        source: function (request, response) {

            var val = $('#city').val();
            var url = baseUrl + "/place/getaddress";
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'Post',
                url: url,
                data: {
                    term: request.term,
                    city: val
                },
                dataType: "json",
                success: function (data) {

                    var resp = $.map(data, function (obj) {

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



    $(".modal #city").autocomplete({


        source: function (request, response) {
            var url = baseUrl + "/place/getlocation";
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'Post',
                url: url,
                data: {
                    term: request.term,
                },
                dataType: "json",
                success: function (data) {
                  

                    var resp = $.map(data, function (obj) {
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
    $(".modal #address").autocomplete({
        source: function (request, response) {

            var val = $('#city').val();
            var url = baseUrl + "/place/getaddress";
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'Post',
                url: url,
                data: {
                    term: request.term,
                    city: val
                },
                dataType: "json",
                success: function (data) {

                    var resp = $.map(data, function (obj) {

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


    $(".modal #city-edit").autocomplete({

        source: function (request, response) {
            var url = baseUrl + "/place/getlocation";
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'Post',
                url: url,
                data: {
                    term: request.term,
                },
                dataType: "json",
                success: function (data) {

                    var resp = $.map(data, function (obj) {
                        return obj.name;
                        $('.locationId').text(obj.id);
                    });

                    response(resp);
                },

                error: function (data) {

                }
            });
        },
        minLength: 1
    });
    $(".modal #address-edit").autocomplete({
        source: function (request, response) {

            var val = $('#city').val();
            var url = baseUrl + "/place/getaddress";
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'Post',
                url: url,
                data: {
                    term: request.term,
                    city: val
                },
                dataType: "json",
                success: function (data) {

                    var resp = $.map(data, function (obj) {

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


    $("#city-edit").on("autocomplete", function(event,ui) {
        alert($(this).val());
    });
    $(".modal #city-edit").keypress(function(){
       alert('hrllo nepla');
    });


});