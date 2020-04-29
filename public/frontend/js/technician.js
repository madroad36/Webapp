$(document).ready(function () {
    $('#technician-modal-close-btn').on('click',function(){
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

    $('#technician-save').on('submit',function(e){
        $('#user-service').modal('hide');
        $("#overlay-load").fadeIn(300);
        var  url = $('#technician-save').attr('action');
        var data = new FormData(this);

        data.append('citizen_upload',$('#citizen-image')[0].files[0]);
        data.append('certificate_upload',$('#certificate-image')[0].files[0]);

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
                $('#technician-save')[0].reset();
                $('.create-technician').hide();
                setTimeout(function(){
                    $("#overlay-load").fadeOut(500);
                },500);
                $('#technician-message-modal').modal('show');


            },
            error: function(xhr, textStatus, errorThrown)
            {
                // console.log(xhr);
                $("#overlay-load").fadeOut(500);
                $.each(xhr.responseJSON.errors, function(key,value) {
                    console.log(key);
                    $("#" + key ).css('border','1px solid red');


                });



            }
        });
        e.preventDefault();
    })
    $('#technician-citizen-image').change(function(){
        $('#technician-citizen-server').css('display','none');
        readImgUrlAndPreview(this);
        function readImgUrlAndPreview(input){
            $('#hide-upload #technician-citizenPreview').css('display','block');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#hide-upload #technician-citizenPreview').attr('src', e.target.result);
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    });
    $('#technician-certificate-image').on('change',function(){
        $('#technician-certificate-server').css('display','none');
        readImgUrlAndPreview(this);
        function readImgUrlAndPreview(input){
            $('#hide-upload #technician-certificatePreview').css('display','block');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#hide-upload #technician-certificatePreview').attr('src', e.target.result);
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    })

    $('#technician-edit').on('submit',function(e){

        $("#overlay-load").fadeIn(300);
        var  url = $('#technician-edit').attr('action');
        var data = new FormData(this);

        data.append('citizen_upload',$('#technician-citizen-image')[0].files[0]);
        data.append('certificate_upload',$('#technician-certificate-image')[0].files[0]);

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
                $('#technician-edit')[0].reset();
                $('.update-technician').hide();
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
                    console.log(key);
                    $("#" + key ).css('border','1px solid red');


                });



            }
        });
        e.preventDefault();
    })

});