$(document).ready(function () {
    $('#broker-modal-close-btn').on('click',function(){
        $('#user-service').modal('hide');
    });
    $('.btn-broker').on('click',function(){
        $('#user-service').modal('hide');
    });

    $('#citizen-image').change(function(){
        $('#citizen-image-frame').css('display','none');
        readImgUrlAndPreview(this);
        function readImgUrlAndPreview(input){
            $('#hide-upload #citizenPreview').css('display','block');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#hide-upload #citizenPreview').attr('src', e.target.result);
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    });
    $('#certificate-image').on('change',function(){
        $('#certificate-image-frame').css('display','none');
        readImgUrlAndPreview(this);
        function readImgUrlAndPreview(input){
            $('#hide-upload #certificatePreview').css('display','block');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#hide-upload #certificatePreview').attr('src', e.target.result);
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    })
    $('#pan-vat-image').on('change',function(){
        $('#pan-vat-image-frame').css('display','none');
        readImgUrlAndPreview(this);
        function readImgUrlAndPreview(input){
            $('#hide-upload #pan-vatPreview').css('display','block');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#hide-upload #pan-vatPreview').attr('src', e.target.result);
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    })


    $('#broker-save').on('submit',function(e){
        $("#overlay-load").fadeIn(300);
        var  url = $('#broker-save').attr('action');
        var data = new FormData(this);

        data.append('citizen',$('#citizen-image')[0].files[0]);
        data.append('certificate',$('#certificate-image')[0].files[0]);

        $.ajax({
            type: "POST",
            url: url,
            data:  data,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData:false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(product)
            {
                $('#broker-save')[0].reset();
                $('.create-broker').hide();
                setTimeout(function(){
                    $("#overlay-load").fadeOut(500);
                },500);
                $('#user-success-form-submit').modal('show');


            },
            error: function(xhr, textStatus, errorThrown)
            {
                // console.log(xhr);
                $("#overlay-load").fadeOut(500);
                $.each(xhr.responseJSON.errors, function(key,value) {

                    $("#" + key ).css('border','1px solid red');


                });



            }
        });
        e.preventDefault();
    })

    $('#update-citizen-image').change(function(){
        $('#update-citizen-server').css('display','none');
        readImgUrlAndPreview(this);
        function readImgUrlAndPreview(input){
            $('#hide-upload #update-citizen-preview').css('display','block');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#hide-upload #update-citizen-preview').attr('src', e.target.result);
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    });
    $('#update-certificate-image').on('change',function(){
        $('#update-certificate-server').css('display','none');
        readImgUrlAndPreview(this);
        function readImgUrlAndPreview(input){
            $('#hide-upload #update-certificate-preview').css('display','block');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#hide-upload #update-certificate-preview').attr('src', e.target.result);
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    })
    $('#broker-edit').on('submit',function(e){
        $("#overlay-load").fadeIn(300);
        var  url = $('#broker-edit').attr('action');
        var data = new FormData(this);

        data.append('citizen',$('#update-citizen-image')[0].files[0]);
        data.append('certificate',$('#update-certificate-image')[0].files[0]);

        $.ajax({
            type: "POST",
            url: url,
            data:  data,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData:false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(product)
            {
                $('#broker-edit')[0].reset();
                $('.broker-update').hide();
                setTimeout(function(){
                    $("#overlay-load").fadeOut(500);
                },500);
                $('#user-success-form-submit').modal('show');


            },
            error: function(xhr, textStatus, errorThrown)
            {
                // console.log(xhr);
                $("#overlay-load").fadeOut(500);
                $.each(xhr.responseJSON.errors, function(key,value) {

                    $("#" + key ).css('border','1px solid red');


                });



            }
        });
        e.preventDefault();
    })


});