$(document).ready(function () {
    $('#vendor-modal-close-btn').on('click',function(){
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

    $('#vendor-save').on('submit',function(e){
        $('#user-service').modal('hide');
        $("#overlay-load").fadeIn(300);
        var  url = $('#vendor-save').attr('action');
        var data = new FormData(this);

        data.append('citizen',$('#citizen-image')[0].files[0]);
        data.append('certificate',$('#certificate-image')[0].files[0]);
        debugger

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
                $('#vendor-save')[0].reset();
                $('.create-vendor').hide();
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
    $('#update-pan-vat-image').on('change',function(){
        $('#update-pan-vatPreview-server').css('display','none');
        readImgUrlAndPreview(this);
        function readImgUrlAndPreview(input){
            $('#hide-upload #update-pan-vatPreview').css('display','block');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#hide-upload #update-pan-vatPreview').attr('src', e.target.result);
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    })

    $('#vendor-edit').on('submit',function(e){
        $("#overlay-load").fadeIn(300);
        var  url = $('#vendor-edit').attr('action');
        var data = new FormData(this);

        data.append('pan_vat_image',$('#update-pan-vat-image')[0].files[0]);

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
            success: function()
            {
                $('#vendor-edit')[0].reset();
                $('.vendor-update').hide();
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