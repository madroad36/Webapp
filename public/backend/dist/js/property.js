function propertyImage(id,e){

    var url = baseUrl+'/property_image/delete';
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

$('.broker').click(function() {
    $('.broker').not(this).prop('checked', false);
    $(this).val(this.checked ? 1 : 0);
});
function category(value){

    if (value == 'House') {
        $('.house').show();
        $('.land').hide();
        $(".land :input").removeClass('form-input');
        $(".house :input").addClass('form-input');
        $('.edit-house').show();
        $(".edit-house :input").addClass('edit-form-input');

    }
    if (value == 'Land') {
        $('.land').show();
        $('.house').hide();
        $(".house :input").removeClass('form-input');
        $(".land :input").addClass('form-input');
        $('.edit-house').hide();
        $(".edit-house :input").removeClass('edit-form-input');



    }
}

function subcategory(subcategory) {

    if (subcategory == 'Rent') {
        $('.rent').show();
        $(".rent :input").addClass('form-input');
        $('.price').hide();
        $(".price :input").removeClass('form-input');


    }
    if (subcategory == 'Sale') {
        $('.rent').hide();
        $(".rent :input").removeClass('form-input');
        $('.price').show();
        $(".price :input").removeClass('form-input');

    }
}
// validation error removes by this code


$(".form-input").keypress(function(){
    $(this).removeClass('invalid')
});
$(".form-input").on('change',function(){
    $(this).removeClass('invalid')
});
$(document).on('keypress', '.edit-form-input',function (){

    $(this).removeClass('invalid')
});
$(document).on('change', '.edit-form-input',function (){
    $(this).removeClass('invalid')
});

$('.radio-group .radio').click(function () {
    $(this).parent().find('.radio').removeClass('selected');
    $(this).addClass('selected');
});

///// this is for the property adding step up form


currentTab =0;
showTab(currentTab); // Display the current tab

function showTab(n) {
    // This function will display the specified tab of the form...
    var x = document.getElementsByClassName('tab');

    x[n].style.display = "block";
    //... and fix the Previous/Next buttons:
    if (n == 0) {
        document.getElementById("prevBtn").style.display = "none";
    } else {
        document.getElementById("prevBtn").style.display = "inline";
    }
    if (n == (x.length - 1)) {
        document.getElementById("nextBtn").innerHTML = "Submit";
    } else {
        document.getElementById("nextBtn").innerHTML = "Next";
    }
    //... and run a function that will display the correct step indicator:
    fixStepIndicator(n)
}

function nextPrev(n) {


    // This function will figure out which tab to display
    var x = document.getElementsByClassName('tab');
    // Exit the function if any field in the current tab is invalid:
    if (n == 1 && !validateForm()) return false;
    // Hide the current tab:
    x[currentTab].style.display = "none";
    // Increase or decrease the current tab by 1:
    currentTab = currentTab + n;

    // if you have reached the end of the form...
    if (currentTab >= x.length) {
        // ... the form gets submitted:
        $("#overlay-load").fadeIn(300);
        var url = $('#property-add-popup').attr('action');
        console.log(url,'backend')
        var form_data = new FormData(document.getElementById("property-add-popup"));
        $.ajax({
            type: "POST",
            url: url,
            data:  form_data,
            contentType: false,
            cache: false,
            processData:false,
            success: function(response) {
                window.location.reload();
                // $('.modal').modal('hide'); // closes all active pop ups.

                // $('.modal-backdrop').hide(); // removes the grey overlay.

                // if($('.modal.in').length > 0)
                // {
                //     $('body').addClass('modal-open');
                // }
                // $('#progressbar li ').removeClass('finish');
                // $('#progressbar li ').removeClass('active');
                // $('#property-add-popup')[0].reset();
                // $('#property-add-popup ').find('#first .tab').css('display','block');
                // $('#progressbar li:first-child ').addClass('active finish');
                // $('#image').val(response.property.id);
                // // $('.dropzone').attr('action',baseUrl+"/product_image/store/"+response.product.id);
                // setTimeout(function(){
                //     $("#overlay-load").fadeOut(500);

                // },500);
                // $("#property-gallery-image").modal('show');
                // $("#property-gallery-image").appendTo("body");
                // $('#property-message').modal('show');
                // $("#property-message").appendTo("body");
                // setTimeout(function(){
                //     $("#property-message").fadeOut(2000);

                // },2000);

                // //



            },
            error: function(xhr, textStatus, errorThrown)
            {
            }
        });



        return false;

    }
    // Otherwise, display the correct tab:
    showTab(currentTab);
}

function validateForm() {
    // This function deals with validation of the form fields
    var  x, y, i, valid = true;
    var x = document.getElementsByClassName('tab');
        y = x[currentTab].getElementsByClassName("form-input");


    // var aminite = ;

    // y = x[currentTab].getElementsByTagName("input");

    z =x[currentTab].getElementsByClassName('form-input option:selected');

    f =x[currentTab].getElementsByClassName("hide form-input");

    if(x[currentTab].id ==  "fourth"){

        if( document.getElementById("propertyUpload").files.length == 0 ){
            $('.propertyUpload .btn').addClass(' class-errors');
        }

    }
    if(x[currentTab].id ==  "second"){


        if($('.check-price:checkbox:checked').length <= 0){
            $('.aminites-list .w3docs').addClass('  class-errors');
            valid = false;
        }

    }


    // if(  == 0 ){
    //     $('.check-price').addClass('invalid');
    // }






    for (i = 0; i < z; i++) {
        // If a field is empty...


        if (z[i].value == "") {
            // add an "invalid" class to the field:
            z[i].addclass('  class-errors');
            // and set the current valid status to false
            valid = false;
        }else {
            z[i].className = z[i].className.replace("class-errors", "");
        }

    }

    // if(aminite.length <= 0){

    //     $('#aminite-value').addClass('invalid');
    // }
    // else{
    //     $('#aminite-value').addClass('invalid');
    // }
    // A loop that checks every input field in the current tab:
    for (i = 0; i < y.length; i++) {
        // If a field is empty...


        if (y[i].value == "") {

            // add an "invalid" class to the field:
            y[i].className += "  class-errors";
            // and set the current valid status to false
            valid = false;
        }

    }


    // If the valid status is true, mark the step as finished and valid:
    if (valid) {

        document.getElementsByClassName("step")[currentTab].className += " finish";

    }
    return valid; // return the valid status
}

function fixStepIndicator(n) {
    // This function removes the "active" class of all steps...

    var i, x = document.getElementsByClassName("step");
    for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active", "");
    }
    //... and adds the "active" class on the current step:
    x[n].className += " active";
}

///// this code is for select the category

$(document).on('change','#category', function () {


    $('.price').hide();
    var value = $('#category option:selected').text();
    var id = $(this).val();


    // slect option to choose the house or land form
    category(value)

    getcategory(id);
});


/// this code is to select the subcategory

$(document).on('change', '#subcategory',function (){
var sub =  $('#subcategory option:selected').text();
subcategory(sub);

});

//// this is to remove and reset the both edit and add form

$('#property-edit-popup').on('change','#category', function () {


    $('.price').hide();
    var value = $('#category option:selected').text();
    var id = $(this).val();

    // slect option to choose the house or land form
    category(value)


});
$('#property-add-popup').on('change','#category', function () {


    $('.price').hide();
    var value = $('#category option:selected').text();
    var id = $(this).val();
    // slect option to choose the house or land form
    category(value)


});



$(document).delegate('#property-edit-popup #subcategory','change', function (){

    var sub =  $('#subcategory option:selected').text();


    subcategory(sub);

});

$(document).on('keypress', '#city-edit', function(e){
    var url = baseUrl + "/place/getlocation";
    var val = $(this).val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'Post',
        url: url,
        data: {
            term: val,
        },
        dataType: "json",
        success: function (data) {


            if(data.length >= 1){

                var li = '';

                $.each(data, function(key, value) {

                    li  +='<li><a href="javascript:void(0)" class="city-select" data-type='+value.id+'>'+value.name+'</a></li>';
                });

                $('#property-edit-popup .city-list').html(li).show();
            }else{
                $('.city-list').empty();
            }


        },

        error: function (data) {

        }
    });
});
$(document).on('click','#property-edit-popup .city-select',function(){

     var value = $(this).text();
     $('#city-edit').val(value);
    $('.city-list').empty();
    $('#location-address').val('');
});
$(document).on('keyup', '#location-address', function(e){

    var value = this.value;
    // var id =  this.id;
    var city = $('#city-edit').val();
    var url = baseUrl + "/place/getaddress";


    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'Post',
        url: url,
        data: {
            term: value,
            city: city
        },
        dataType: "json",
        success: function (data) {


            if(data.length >= 1){

                var li = '';

                $.each(data, function(key, value) {

                    li  +='<li><a href="javascript:void(0)" class="address-select">'+value.name+'</a></li>';
                });

                $('#property-edit-popup .address-list').html(li).show();
            }else{
                $('.address-list').empty();
            }


        },

        error: function (data) {

        }
    });
});
$(document).on('click','.address-select',function(){

    var value = $(this).text();
    $('#location-address').val(value);
    $('.address-list').empty();
    $('.address-list').val('');
});
$(document).on('keypress', '#city', function(e){
    var url = baseUrl + "/place/getlocation";
    var val = $(this).val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'Post',
        url: url,
        data: {
            term: val,
        },
        dataType: "json",
        success: function (data) {


            if(data.length >= 1){

                var li = '';

                $.each(data, function(key, value) {

                    li  +='<li><a href="javascript:void(0)" class="city-select-add" data-type='+value.id+'>'+value.name+'</a></li>';
                });

                $('#property-add-popup .city-list').html(li).show();
            }else{
                $('.city-list').empty();
            }


        },

        error: function (data) {

        }
    });
});
$(document).on('click','#property-add-popup .city-select-add',function(){

     var value = $(this).text();
     $('#city').val(value);
    $('#property-add-popup .city-list').empty();
    $('#property-add-popup #address').val('');
});
$(document).on('keyup', '#address', function(e){

    var value = this.value;
    // var id =  this.id;
    var city = $('#city').val();
    var url = baseUrl + "/place/getaddress";


    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'Post',
        url: url,
        data: {
            term: value,
            city: city
        },
        dataType: "json",
        success: function (data) {


            if(data.length >= 1){

                var li = '';

                $.each(data, function(key, value) {

                    li  +='<li><a href="javascript:void(0)" class="address-select-add">'+value.name+'</a></li>';
                });

                $('#property-add-popup .address-list').html(li).show();
            }else{
                $('.address-list').empty();
            }


        },

        error: function (data) {

        }
    });
});
$(document).on('click','.address-select-add',function(){

    var value = $(this).text();
    $('#address').val(value);
    $('#property-add-popup .address-list').empty();
    $('#property-add-popup .address-list').val('');
});

Dropzone.options.propertyId =

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
                url: baseUrl+"/property_image/delete",
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



/// second form





$(document).on('click', '.property-edit-form', function(e)
{
    e.preventDefault();

    var current = 0;
    var document = $(this).attr('data-type');




    $('.'+document).find('#progressbar li ').removeClass('active');
    $('.'+document).find('#progressbar li ').removeClass('finish');
    $('.'+document).find("#progressbar li:first-child").addClass('active');
    $('.'+document).find('#prevBtn').css('display','none');
    $('.'+document).find('#nextBtn').innerHTML = "Next";

    $('.'+document).find(' #first').css('display','block');
    //     $('#property-edit #first').css('display','block');

});


$(document).on('click','.image-upload-btn',function(){

    $("#overlay-load").fadeIn(300);

    setTimeout(function(){
        $("#overlay-load").fadeOut(1000);
        $('#property-message').modal('show');
    },8000);





    $('#progressbar li ').removeClass('finish');
    $('#progressbar li ').removeClass('active');
    $('#property-add-popup')[0].reset();
    $('#property-add #first').css('display','block');
    $('#progressbar li:first-child ').addClass('active finish');


    // $('#property-edit #property-edit-popup')[0].reset();
    // $('#property-edit #first').css('display','block');


    $('.dropzone')[0].reset();
    $('.modal').modal('hide'); // closes all active pop ups.
    $('.modal-backdrop').remove(); // removes the grey overlay.

    if($('.modal.in').length > 0)
    {
        $('body').addClass('modal-open');
    }
    $('.property-gallery-image').empty();
    $(' #propertyId .dz-complete').empty();
    $('.dz-default .dz-message:before').css('display','block');


})
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
                console.log(data)

                var resp = $.map(data, function (obj) {

                    $('#property-add-popup #city').text(obj.id);
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

                    response($('#address').val(obj.name));
                });

                response(resp);
            },

            error: function (data) {

            }
        });
    },
    minLength: 1
});

$(document).on('change','#ownerUpload-edit',function(){
readImgUrlAndPreview(this);
function readImgUrlAndPreview(input){
    $('#hide-upload #ownerPreview-edit-view').css('display','none')
    $('#hide-upload #ownerPreview-edit').css('display','block');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#hide-upload #ownerPreview-edit').attr('src', e.target.result);
        }
    };
    reader.readAsDataURL(input.files[0]);
}
});

    $(document).on('change','#propertyUpload-edit',function(){
    $('.propertyUpload  label').removeClass('invalid');
    readImgUrlAndPreview(this);
    function readImgUrlAndPreview(input){
        $('#hide-upload #propertyPreview-edit').css('display','block');
        $('#hide-upload #propertyPreview-edit-view').css('display','none');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#hide-upload #propertyPreview-edit').attr('src', e.target.result);
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
})


$(document).on('change','#paperUpload-edit',function(){
    readImgUrlAndPreview(this);
    function readImgUrlAndPreview(input){
        $('#hide-upload #paperPreview-edit').css('display','block');
        $('#hide-upload #paperPreview-edit-view').css('display','none');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#hide-upload #paperPreview-edit').attr('src', e.target.result);
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
})


$(document).on('change','#lalapurjaUpload-edit',function(){
    readImgUrlAndPreview(this);
    function readImgUrlAndPreview(input){
        $('#hide-upload #lalapurjaPreview-edit').css('display','block');
        $('#hide-upload #lalapurjaPreview-edit-view').css('display','none');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#hide-upload #lalapurjaPreview-edit').attr('src', e.target.result);
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
})


$(document).on('click', '.close-modal', function(e)
{
    e.preventDefault();


    // $('#progressbar li ').removeClass('finish');
    // $('#progressbar li ').removeClass('active');
    // $('#property-edit-popup')[0].reset();
    // $('#property-edit-popup ').find('#first .tab').css('display','block');
    // $('#progressbar li:first-child ').addClass('active finish');
    //     $('#property-edit #first').css('display','block');

    $('#progressbar li ').removeClass('active');
    $('#progressbar li ').removeClass('finish');
    $("#progressbar li:first-child").addClass('active');
    $('#prevBtn').css('display','none');
    $('#nextBtn').innerHTML = "Next";

    $(' #first').css('display','block');
    // var controlForm = $('.controls.rpt:first'),
    //     currentEntry = $(this).parents('.entry:first'),
    //     newEntry = $(currentEntry.clone()).appendTo(controlForm);
    //
    // newEntry.find('input').val('');
    // controlForm.find('.entry:not(:last) .btn-add')
    //     .removeClass('btn-add').addClass('btn-remove')
    //     .removeClass('btn-success').addClass('btn-danger')
    //     .html('Remove Friend');
    window.location.reload();
});

function propertyModal(obj){


    $("#overlay-load").fadeIn(300);
    var value =$(obj).attr('data-type');
    var url =$(obj).attr('role');
    var categoryId = $(obj).attr('data-category');
    var name = $(obj).attr('data-category-name');
    console.log(name);
    $.ajax({
        type: 'get',
        url: url,
        dataType: 'html',
        success: function (response) {
            $('.property-ajax-edit').html(response);

            $('#'+value).modal("show");
            $('#'+value).find('#progressbar li ').removeClass('finish');
            $('#'+value).find('#progressbar li ').removeClass('active');
            $('#'+value).find('#first ').css('display','block');
            $('#'+value).find('#progressbar li:first-child ').addClass('active finish');

            getcategory(categoryId);
            category(name)
            setTimeout(function(){
                $("#overlay-load").fadeOut(300);
            },500);

        }


    })


}



function getcategory(id){

    var url = baseUrl + "/property_sub/getsubcategory";
    $.ajax({
        type: 'get',
        url: url,
        data: {category_id: id},
        dataType: 'json',
        success: function (response) {
            if (response.success == true) {

                var value = response.sucategory;
                var option = '';

                $.each(value, function (key, value) {

                    option += '<option selected="selected" value="' + value.id + '">' + value.title + '</option:selectedoption>';
                });

                $('#property-edit-popup #subcategory').html(option).show();
                $('#property-add-popup #subcategory').html(option).show();

                // var sub = $('#property-edit-popup #subcategory option:selected').text();
                // var cat = $('#property-add-popup #subcategory option:selected').text();
                // if(empty(cat)){
                //     subcategory(sub);
                // }else{
                //     subcategory(cat);
                // }
                

            } else {
                $('#property-edit-popup #subcategory').empty();
                $('#property-add-popup #subcategory').empty();
            }

        }
    })
}


current =0;
EditshowTab(current); // Display the current tab

function EditshowTab(n) {

    // This function will display the specified tab of the form...
    var x =  document.getElementsByClassName('edit');

    if( x.length == 0 ){
        return;
    }

    x[n].style.display = "block";
    if(n !== 0){
        x[n].style.display = "block";
    }
    if (n == 0) {

        // document.getElementById("previousBtn").style.display = "none";
        $('#EditprevBtn').attr('style','display:none');
        // document.getElementById("EditprevBtn").style.display = "none";
    } else {
        document.getElementById("previousBtn").style.display = "inline";

    }


    if (n == (x.length - 1)) {
        document.getElementById("EditnextBtn").innerHTML = "Submit";
    } else {
        // document.getElementById("EditnextBtn").innerHTML = "Next";
        $("#EditnextBtn").html('Next');
    }
    //... and run a function that will display the correct step indicator:
    // EditfixStepIndicator(n)
}

function EditnextPrev(n) {

    // This function will figure out which tab to display
    var x = document.getElementsByClassName('edit');
    console.log(x.length);
    // Exit the function if any field in the current tab is invalid:
    if (n == 1 && !EditvalidateForm()) return false;

    


    x[current].style.display = "none";
    $('#property-edit-popup #progressbar li:nth('+current+')').removeClass('active')

    // Hide the current tab:
    // Increase or decrease the current tab by 1:
    current = current + n;
    current = current > 0 ? current : 0
    
    if (current == x.length   ) {
        // ... the form gets submitted:


        $("#overlay-load").fadeIn(300);
        var url = $('#property-edit-popup').attr('action');
        var form_data = new FormData(document.getElementById("property-edit-popup"));
        $.ajax({
            type: "POST",
            url: url,
            data:  form_data,
            contentType: false,
            cache: false,
            processData:false,
            success: function(response) {
           
                window.location.reload();
            },
            error: function(xhr, textStatus, errorThrown)
            {
            }
        });



        return true;

    }   

    x[current].style.display = "block";
    $('#property-edit-popup #progressbar li:nth('+current+')').addClass('active')
    

    
    // if you have reached the end of the form...
   
    // Otherwise, display the correct tab:
    EditshowTab(current);
}

function EditvalidateForm()
{


    // This function deals with validation of the form fields
    var  x, y, i,z, valid = true;


    y = $('.edit')[current].getElementsByClassName('edit-form-input');

    z =$('.edit')[current].getElementsByClassName('edit-form-input option:selected');

    console.log(z.length);

    for (i = 0; i < z; i++) {
        // If a field is empty...


        if (z[i].value == "") {
            // add an "invalid" class to the field:
            z[i].addclass('class-errors');
            // and set the current valid status to false
            valid = false;
        }else {
            z[i].className = z[i].className.replace(" class-errors", "");
        }

    }

    // if(aminite.length <= 0){

    //     $('#aminite-value').addClass('invalid');
    // }
    // else{
    //     $('#aminite-value').addClass('invalid');
    // }
    // A loop that checks every input field in the current tab:
    for (i = 0; i < y.length; i++) {
        // If a field is empty...
        const value = y[i].value;
        console.log(y[i].name);
        if (y[i].value == "") {



            // add an "invalid" class to the field:
            y[i].className += " class-errors";
            // and set the current valid status to false
            valid = false;
        }

    }


    // If the valid status is true, mark the step as finished and valid:
    if (valid) {

        document.getElementsByClassName("step")[current].className += " finish";
    }
    return valid; // return the valid status
}

function EditfixStepIndicator(current) {
    // This function removes the "active" class of all steps...

    var i, x = document.getElementsByClassName("step");
    for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active", "");
    }
    //... and adds the "active" class on the current step:
    x[current].className += " active";
}

$(document).on('change','#property-edit-popup #category', function () {


    $('.price').hide();
    var value = $('#property-edit-popup #category option:selected').text();
    var id = $('#property-edit-popup #category').val();


    // slect option to choose the house or land form
    editcategory(value)

    editgetcategory(id);
});

function editcategory(value){

    if (value == 'House') {
        $('.house').show();
        $('.land').hide();
        $(".land :input").removeClass('edit-form-input');
        $(".house :input").addClass('edit-form-input');
        $('.edit-house').show();
        $(".edit-house :input").addClass('edit-form-input');

    }
    if (value == 'Land') {
        $('.land').show();
        $('.house').hide();
        $(".house :input").removeClass('edit-form-input');
        $(".land :input").addClass('edit-form-input');
        $('.edit-house').hide();
        $(".edit-house :input").removeClass('edit-form-input');



    }
}
$(document).on('change','#property-edit-popup #subcategory', function () {


    $('.price').hide();
    var value = $('#property-edit-popup #subcategory option:selected').text();
    var id = $('#property-edit-popup #category').val();


    // slect option to choose the house or land form
    editsubcategory(value)

});
function editsubcategory(subcategory) {

    if (subcategory == 'Rent') {
        $('.rent').show();
        $(".rent :input").addClass('edit-form-input');
        $('.price').hide();
        $(".price :input").removeClass('edit-form-input');


    }
    if (subcategory == 'Sale') {
        $('.rent').hide();
        $(".rent :input").removeClass('edit-form-input');
        $('.price').show();
        $(".price :input").removeClass('edit-form-input');

    }
}


function editgetcategory(id){

    var url = baseUrl + "/property_sub/getsubcategory";
    $.ajax({
        type: 'get',
        url: url,
        data: {category_id: id},
        dataType: 'json',
        success: function (response) {
            if (response.success == true) {

                var value = response.sucategory;
                var option = '';

                $.each(value, function (key, value) {

                    option += '<option selected="selected" value="' + value.id + '">' + value.title + '</option:selectedoption>';
                });

                $('#property-edit-popup #subcategory').html(option).show();
                

                var sub = $('#property-edit-popup #subcategory option:selected').text();
                editsubcategory(sub);
                // var cat = $('#property-add-popup #subcategory option:selected').text();
                // if(empty(cat)){
                //     subcategory(sub);
                // }else{
                //     subcategory(cat);
                // }
                

            } else {
                $('#property-edit-popup #subcategory').empty();
               
            }

        }
    })
}

 





