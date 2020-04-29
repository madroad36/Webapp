

$('#productUpload').change(function(){
    $('#imageUpload-product').css('display','none');
    readImgUrlAndPreview(this);
    function readImgUrlAndPreview(input){
        $('#hide-upload #imagePreview').css('display','block');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#hide-upload #imagePreview').attr('src', e.target.result);
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
});


$('#propertyUpload').change(function(){
    $('.propertyUpload  label').removeClass('invalid');
    readImgUrlAndPreview(this);
    function readImgUrlAndPreview(input){
        $('#hide-upload #propertyPreview').css('display','block');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#hide-upload #propertyPreview').attr('src', e.target.result);
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
})
$('#paperUpload').change(function(){

    readImgUrlAndPreview(this);
    function readImgUrlAndPreview(input){
        $('#hide-upload #paperPreview').css('display','block');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#hide-upload #paperPreview').attr('src', e.target.result);
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
})
$('#ownerUpload').change(function(){

    readImgUrlAndPreview(this);
    function readImgUrlAndPreview(input){
        $('#hide-upload #ownerPreview').css('display','block');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#hide-upload #ownerPreview').attr('src', e.target.result);
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
})
$('#lalapurjaUpload').change(function(){

    readImgUrlAndPreview(this);
    function readImgUrlAndPreview(input){
        $('#hide-upload #lalapurjaPreview').css('display','block');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#hide-upload #lalapurjaPreview').attr('src', e.target.result);
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
})
$(document).on('click','.order-view-list-btn', function(){
    event.preventDefault();
    $object = $(this);
    var id  = $(this).attr('data-type');
    var url = baseUrl+"/order/show/"+id;
    $.ajax({
        type: "get",
        url: url,
        data: {
            id: id,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType:'html',
        success: function (order) {
            $('.product-detail-modal').html(order);
            $('.product-order-detail-view').modal('show');
        },
        error: function (e) {
            if (e.responseJSON.message) {
                swal('Error', e.responseJSON.message, 'error');
            } else {
                swal('Error', 'Something went wrong while processing your request.', 'error')
            }
        }
    });
});



Dropzone.options.productId =

    {


        renameFile: function(file) {
            var dt = new Date();
            var time = dt.getTime();
            return time+file.name;
        },
        sending: function(file, xhr, formData){
            formData.append('id', $('#image').val());
        },
        maxFilesize: 12,

        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        addRemoveLinks: true,
        timeout: 5000,
        removedfile: function(file)
        {
            var name = file.upload.filename;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url("product_image/delete") }}',
                data: {image: name},
                success: function (data){
                    console.log("File has been successfully removed!!");
                },
                error: function(e) {
                    console.log(e);
                }});
            var fileRef;
            return (fileRef = file.previewElement) != null ?
                fileRef.parentNode.removeChild(file.previewElement) : void 0;
        },
        success: function(file, response)
        {

        },
        error: function(file, response)
        {
            return false;
        }
    }
$(document).on("click", "#change-status", function () {
    $object = $(this);
    var id = $(this).attr('data-type');
    swal({
        title: 'Are you sure?',
        text: 'Do you want to change the status',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, change it!',
        cancelButtonText: 'No, keep it'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: baseUrl+"/order/change-status",
                data: {
                    'id': id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function (response) {

                    swal("Thank You!", response.message, "success");
                    if (response.response.is_active == 1) {
                        $($object).text('sold')
                        $($object).removeClass('sold');
                        $($object).addClass('unsold');
                    } else {
                        $($object).text('unsold')
                        $($object).removeClass('unsold');
                        $($object).addClass('sold');
                    }
                },
                error: function (e) {
                    if (e.responseJSON.message) {
                        swal('Error', e.responseJSON.message, 'error');
                    } else {
                        swal('Error', 'Something went wrong while processing your request.', 'error')
                    }
                }
            });

        }
    })
});


