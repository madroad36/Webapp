@extends('frontend.app')
@section('title', config('app.name') )
@section('main-content')

<div class="container-fluid">
  <!-- Slider banner start -->
  <div id="zbanner" class="carousel slide" data-ride="carousel" data-interval=false>
    <div class="carousel-indicators">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div id="banner">
          <!-- slider banner indicator start -->
          @include('frontend.include.navbar')
          <!-- slider banner indicator end -->
        </div>
      </nav>
    </div>
    <div class="carousel-inner">
     <!-- Properties -->
     @include('frontend.include.properties')
     <!-- Properties End -->

     <!-- Product -->
     @include('frontend.include.product')
     <!-- Product Ends -->

     <!-- Services -->
     @include('frontend.include.service')
     <!-- Services End -->

     <!-- Listing -->
     @include('frontend.include.listing')
     <!-- Listing Ends -->

     <!-- Ads Form -->
     @include('frontend.include.advertisement')
     <!-- Ads Form Ends -->
   </div>
 </div>
 <!-- Slider banner end -->
 
 <!-- Advertisment Start  -->
 @include('frontend.section.runningAds')
 <!-- Advertisment End  -->

 <!-- Properties By Places -->
 @include('frontend.section.propertiesByPlace')
 <!-- Properties By Places  Ends-->

 <!-- Feature Properties  -->
 @include('frontend.section.featuredProperties')
 <!-- Feature Properties Ends  -->

 <!-- Listing  -->
 @include('frontend.section.listing')
 <!-- Listing Ends  -->

 <!--  Product Category  -->
 @include('frontend.section.productCategory')
 <!-- {{-- Product Category end --}} -->

 <!-- {{-- Popular Products Start --}} -->
 @include('frontend.section.featuredProducts')
 <!-- {{-- Feature Properties end --}} -->

 <!-- {{-- Advertisement --}} -->
 @include('frontend.section.advertisement')
 <!-- {{-- Advertisement Ends --}} -->

 <!-- Services -->
 @include('frontend.section.services')
 <!-- Services End -->

 <!-- About Section -->
 @include('frontend.section.aboutSection')
 <!-- About Section Ends -->
</div>

@endsection

@section('js_script')
<script type="text/javascript">
  $(document).ready(function () {
    $('#property').click(function (event) {
      $('.item-list').hide();
      $('.home-form').show();
      $('.property-form').show();
      $('.product-form').hide();
      $('.service-form').hide();
      event.stopPropagation();
    });
    $('#service').click(function (event) {
      $('.item-list').hide();
      $('.home-form').show();
      $('.property-form').hide();
      $('.product-form').hide();
      $('.service-form').show();
      event.stopPropagation();

    });
    $('#product').click(function (event) {
      $('.item-list').hide();
      $('.home-form').show();
      $('.property-form').hide();
      $('.service-form').hide();
      $('.product-form').show();
      event.stopPropagation();
    });
    $('#close').click(function (event) {
      $('#property-form ')[0].reset();
      $('#service-form ')[0].reset();
      var option = '';
      option += '<option selected="selected" value="0">Select  the area</option:selectedoption>';
      $('.home-form #place').html(option).show();
      $('.item-list').show();
      $('.property-form').hide();
      $('.home-form').hide();
      event.stopPropagation();
    })

    $('.home-form ').on('change', '#location', function (event) {
      var value = $(this).val();
      var url = '{{route('place.getplace')}}';
      place(value, url)
      event.stopPropagation();
    });


    function place(value, url) {
      $.ajax({
        type: 'get',
        url: url,
        data: {location_id: value},
        dataType: 'json',
        success: function (response) {
          if (response.success == true) {
            var value = response.place;
            var option = '';

            $.each(value, function (key, value) {

              option += '<option selected="selected" value="' + value.id + '">' + value.name + '</option:selectedoption>';
            });

            $('.home-form #place').html(option).show();
          } else {
            $('.home-form #place').empty();
          }

        }
      });
    }

    $('#category').on('change', function () {
      $('#subcategory').empty();
      var value = $(this).val();
      var url = '{{route('getsubcategory')}}';
      select(value, url);
    });

    function select(value, url) {
      $.ajax({
        type: 'get',
        url: url,
        data: {category_id: value},
        dataType: 'json',
        success: function (response) {
          if (response.success == true) {
            var value = response.subcategory;
            var option = '';

            $.each(value, function (key, value) {

              option += '<option selected="selected" value="' + value.id + '">' + value.title + '</option:selectedoption>';
            });

            $('#subcategory').html(option).show();
          } else {
            $('#subcategory').empty();
          }

        }
      })
    }

    $('#product-category').on('change', function () {
      $('#product-details').empty();
      var value = $(this).val();
      var url = '{{route('getcategory')}}';
      selectCategory(value, url);
    });

    function selectCategory(value, url) {
      $.ajax({
        type: 'get',
        url: url,
        data: {category_id: value},
        dataType: 'json',
        success: function (response) {
          if (response.success == true) {
            var value = response.category;
            var option = '';
            option += '<option value="0">Select the product </option>';
            $.each(value, function (key, value) {

              option += '<option selected="selected" value="' + value.slug + '">' + value.title + '</option:selectedoption>';
            });

            $('#product-details').append(option).show();
          } else {
            $('#product-details').empty();
          }

        }
      })
    }

    $("#property-search").autocomplete({
      source: function (request, response) {
        var val = $("#product-category option:selected").val();
        $.ajax({
          url: "{{url('/product_autocomplete')}}" + '/' + val,
          data: {
            term: request.term,
          },
          dataType: "json",
          success: function (data) {

            var resp = $.map(data, function (obj) {
              console.log(obj.title);
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
    $("#search-form-input").autocomplete({
      source: function (request, response) {
        var val = $(".search-category option:selected").val();
        $.ajax({
          url: "{{url('/home_autocomplete')}}" + '/' + val,
          data: {
            term: request.term,
          },
          dataType: "json",
          success: function (data) {

            var resp = $.map(data, function (obj) {
              console.log(obj.title);
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
  });

</script>
@endsection