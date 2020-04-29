
function productImage(id,e){

    var url = baseUrl+'/product_image/delete';
    var id  = id;
;
    swal({
        title: 'Are you sure?',
        text: 'You will not be able to recover this !',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, keep it'
    }).then((result) => {
        if (result.value
        )
        {

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    id: id,

                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    swal("Deleted!", response.image.image, "success");
                    console.log(response.image.image);
                    var nRow = document.getElementById(response.image.id);
                    nRow.remove();
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
    e.preventDefault();
}
$(document).ready(function () {




    $('#productUpload').change(function(){
        $('#imageUpload-product').css('display','none');
        readImgUrlAndPreview(this);
        function readImgUrlAndPreview(input){
            $('#imagePreview').css('display','block');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#imagePreview').attr('src', e.target.result);
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    });

//    form submit form the ajax
  $('.product-image-upload').on('click',function(){
    $("#overlay-load").fadeIn(300);
    setTimeout(function(){
        $("#overlay-load").fadeOut(300);
    },300);


    $('.product-gallery-message').modal('show');
      $('.dropzone')[0].reset();
      $(".product-image").modal('toggle');
      $(".property-image").modal('toggle');
      $('.product-gallery-image').empty();
      $(' #productId .dz-complete').empty();
      $('.dz-default .dz-message:before').css('display','block');
      
     
     

      

      setTimeout(function(){
        ('.product-gallery-message').fadeOut(5000);
    },5000);


      window.location.reload();


  })
  $(document).on('click','.close-modal-product',function(){
      $('.product-message').modal('toggle');
  })
    $('#product-store').on('submit',function(e){
        e.preventDefault();
        var  url = $('#product-store').attr('action');
        var data = new FormData(this);

            data.append('image',$('#productUpload')[0].files[0]);




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
                    
                    $('#product-store')[0].reset();
                    $('#imagePreview').css('display','none');
                    $('#product-store').hide(); //or
                    $(".add-product").modal('toggle');
                    $('#image').val(product.id);
                    $("#product-message").modal('show');
                    setTimeout(function(){
                        $("#product-message").fadeOut(5000);
                    },5000);
                    // $('.dropzone').attr('action',baseUrl+"/product_image/store/"+response.product.id);
                    $(".product-image").modal('show');

                },
                error: function(xhr, textStatus, errorThrown)
                {
                    // console.log(xhr.responseJSON.errors);
                    $.each(xhr.responseJSON.errors, function(key,value) {

                        $("#" + key ).css('border','1px solid red');

                        if(key == 'image'){
                        $('#hide-upload #image').css('border','1px solid red');
                        }


                    });
                }
            });
        e.preventDefault();

    });


  $('.product-edit').submit(function(e){
      var modal = $(this).attr('data-target');
      var theForm = $('#product-store');
      var url = $(this).attr('action');
      var data = new FormData(this);

      data.append('image',$('#imageUpload')[0].files[0]);


      $.ajax({
          type: "POST",
          url: url,
          data:  data,
          contentType: false,
          cache: false,
          processData:false,
          success: function(response) {
              $('.modal').modal('hide'); // closes all active pop ups.
              $('.modal-backdrop').remove(); // removes the grey overlay.

              if($('.modal.in').length > 0)
              {
                  $('body').addClass('modal-open');
              }
              $("#product-message").modal('show');
                    setTimeout(function(){
                        $("#product-message").fadeOut(5000);
                    },5000);
              // $('.product-edit')[0].reset();
              // $('#imagePreview').css('display','none');
              // $('#product-store').modal('toggle');
              // $('.add-product').modal('toggle');
              // $('.product-edit-'+response.images.product_id).modal('toggle');

              if (response.images.length >= 1){
                  var option = '';
              option += '<div class="image-wrapper">';
              option += ' <div class="row">';
              //
              $.each(response.images, function (key, value) {
                  option += '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12" id="' + value.id + '">';
                  option += '<div class="hovereffect">';
                  option += ' <img class="card-img img-fluid" src="' + baseUrl + '/storage/' + value.image + '" alt="' + value.id + '" >';
                  option += '<div class="overlay">';
                  option += ' <a class="info" onclick="productImage('+value.id+')" data-type="' + value.id + '" href="javascript:void(0)">';
                  option += '<i class="fa fa-trash"></i>';
                  option += '</a>';

                  option += '</div>';
                  option += '</div>';
                  option += '</div>';

              });
              option += '</div>';
              option += '</div>';

                  $('.product-gallery-image').html(option);
              }
              // $('.product-gallery-image').html(option);






              $('#image').val(response.product.id);
              // $('.dropzone').attr('action',baseUrl+"/product_image/store/"+response.product.id);
              $(".product-image").modal('show');

          },
          error: function(xhr, textStatus, errorThrown)
          {
              console.log(xhr.responseJSON.errors);
              $.each(xhr.responseJSON.errors, function(key,value) {

                  $('input').removeAttr("disabled");
                  $('select').removeAttr("disabled");
                  $('textarea').removeAttr("disabled");
                  $("#" + key ).addClass('alert alert-danger');
                  $("#" + key ).text(value);
                  setTimeout(function () {
                      jQuery("#" + key + "").removeClass('alert alert-danger');
                      jQuery("#" + key + "").text('');

                  }, 6000);
              });
          }
      });
      e.preventDefault();

  });


    // product image delete


    $("#search-form-input").autocomplete({
        source: function (request, response) {

            $.ajax({
                url: baseUrl+"/product/category",
                data: {
                    term: request.term,
                },
                dataType: "json",
                success: function (data) {

                    var resp = $.map(data, function (obj) {

                        return obj.title;
                        $('.productId').text(obj.id);
                    });

                    response(resp);
                },

                error: function (data) {

                }
            });
        },
        minLength: 1
    });
    $("#search-form-title").autocomplete({
        source: function (request, response) {
            var category = $('#search-form-input').val();
            debugger

            $.ajax({
                url: baseUrl+"/product/title",
                data: {
                    category:category,
                    term: request.term,
                },
                dataType: "json",
                success: function (data) {

                    var resp = $.map(data, function (obj) {

                        // display the selected text
                        // save selected id to hidden input
                        return obj.title;
                    });

                    response(resp);
                },
                select: function (event, ui) {
                    // Prevent value from being put in the input:
                    this.value = ui.item.label;
                    // Set the next input's value to the "value" of the item.
                    $(this).next("input").val(ui.item.value);
                    event.preventDefault();
                },

                error: function (data) {

                }
            });
        },
        minLength: 1
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
                url: baseUrl+"/product_image/delete",
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
    };


