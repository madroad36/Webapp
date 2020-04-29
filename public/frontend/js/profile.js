$(document).ready(function () {
    $('.btn-update').on('click',function(){
        $('.profile-update').modal('hide');
    });
    $('.update-profile-bnt').on('click',function(){
        $('.profile-update').modal('hide');
        $('#profile-update-form')[0].reset();
    });

    $('#upload-image').change(function(){
        $('#uploadPreview11').css('display','none');
        readImgUrlAndPreview(this);
        function readImgUrlAndPreview(input){
            $('#hide-upload #uploadPreview').css('display','block');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                console.log(reader,'reader')
                reader.onload = function (e) {
                    $('#hide-upload #uploadPreview').attr('src', e.target.result);
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    });


    $('#profile-update-form').on('submit',function(e){

        $("#overlay-load").fadeIn(300);
        var  url = $('#profile-update-form').attr('action');
        var data = new FormData(this);

        data.append('image',$('#upload-image')[0].files[0]);
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
                $('#profile-update-form')[0].reset();
                setTimeout(function(){
                    $("#overlay-load").fadeOut(500);
                },500);
                $('.profile-update').modal('hide');
                $('.profile-message-modal').modal('show');


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