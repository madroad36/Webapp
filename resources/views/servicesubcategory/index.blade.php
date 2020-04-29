@extends('frontend.app')
@section('title', 'Service Subcategory List')
@section('main-content')
<style type="text/css">
  .form-group{
    padding: 8px !important; width: 100% !important;
  }
</style>
    <main role="main">

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="service-banner-image " style="background: url('{{asset('frontend/img/service.png')}}')">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-7 text-center aos-init " data-aos="fade">

                        <h1 class="service-banner-header">Service </h1>
                        <p> {{ucfirst($category->name)}} List</p>
                    </div> 
                </div>
            </div>

        </div>
    </main>



    <div class="service-page">
       <div class="row">
           <div class="col-xs-12 col-md-4 col-lg-3">
               <div class="product-search-bar">
                   <h4>Advanced Filter</h4>
                    <div class="main">
                        {!! Form::open(array('route'=>'service.search','class'=>'form-inline')) !!}
                        <div class="form-group">
                            <input type="text" name="category" id="service-category" class="form-control"
                                   placeholder="Search by Category" id="search-form-input">
                            <div class="service-category"></div>
                        </div>
                        <div class="form-group">
                            <input type="text" name="title" id="service-title" placeholder="Service Title"
                                   class="form-control" id="search-form-title">
                        </div>
                        <button type="submit" id="product-search-submit-btn" class="btn btn-default">Submit</button>
                        {!! Form::close() !!}
                    </div>
               </div>
           </div>
           <div class="col-xs-12 col-md-8 col-lg-9">
               <div class="col-lg-12">

                   <div class="form-group row">
                       <div class="col-lg-9">
                       </div>
                       <div class="col-lg-3">
                           <label for="" class="item-page">Item Per Page</label>
                           <select id="properties-lists" class="" style="margin-bottom: 10px;">
                               <option value="8" selected="">8</option>
                               <option value="10">10</option>
                               <option value="25">25</option>
                               <option value="50">50</option>
                               <option value="100">100</option>
                           </select>
                       </div>

                   </div>
               </div>
                    @if ($message = Session::get('service-order'))
                        <div class="alert alert-info alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
            <div class="row">

                @foreach($services as $service)
                    <div class="col-xs-12 col-md-4 col-lg-4">
                        <div class="service-lists">
                        <a href="javascript:void(0)" class="service-name">
                            @if(file_exists('storage/'.$service->thumbnail) && $service->thumbnail !='')
                                <img src="{{asset('storage/'.$service->thumbnail)}}" alt="{{$service->title}}">
                            @endif
{{--                            <div class="overlay">--}}
{{--                                <div class="text">{{$service->title}}</div>--}}
{{--                            </div>--}}
                        </a>
                            <div class="service-details">
                                <div class="service-content">
                                    <p>Title: <span>{{$service->title}}</span></p>
                                    <p>Rate: <span>{{$service->rate}} / {{$service->rate_type}}</span></p>
                                </div>
                                <div class="service-brnt">


                                    <a href="javascript:void(0)" onclick="Order({{$service->id}})">Order Service</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <nav aria-label="Page navigation example mx-auto" style="width: 400px; margin:0 auto;">
                {{  $services->links('vendor.pagination.default') }}

            </nav>
           </div>
        </div>
    </div>
    <div class="modal fade " style="" id="service-request-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <div class="product-form-header"  >
                        Service Order From
                    </div>

                    <button type="button" id="service-order-form" class="close-modal" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                {!! Form::open(array('url'=>'servicerequest/details', 'method'=>'post','class'=>'service-order-modal')) !!}
                <div class="modal-body">
                    @if(auth()->check())
                    <input type="hidden" name="login" >
                    @endif
                        <input type="hidden" name="id" id="serviceId">
                    <div class="form-group row">
                        <div class="col-lg-2">
                            <label for="">Location</label>
                        </div>
                        <div class="col-lg-10">
                            <input type="text" id="location" name="location" class="form-control" placeholder="Location">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-2">
                            <label for="">Contact</label>
                        </div>
                        <div class="col-lg-10">
                            <input type="number" id="contact" name="contact" class="form-control" placeholder="contact number only">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>


                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12">
                          <label for="">Preffered Date: </label>
                          <input type="text" class="form-control" id="pereffered_date" name="pereffered_date">
                        </div>


                    </div>
                    <div class="form-group ">
                            <label for="">Briefly define your problem ?</label>
                            <textarea id="description" name="description" class="form-control" cols="5" rows="5" ></textarea>
                    </div>


                </div>
                <div class="modal-footer">
                    <div class="login-footer-btn-right">
                        <button type="submit" id="order-service-btn"  class="btn btn-info btn-block btn-flat">Book Service</button>
                    </div>
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>
    <div class="modal fade " tabindex="-1" id="order-success" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="product-form-header">
                        Successfull Message
                    </div>
                    <button type="button" id="order-success-service"  data-dismiss="modal" aria-hidden="true">×</button>

                </div>
                <div class="modal-body">
                    <P>Thank you we have received your order we will contact you soon at </P>
                    <p>Contact:<span id="booking-contact"></span></p>
                    <p id="already-booked"></p>

                <a href="{{route('servicerequest.index')}}" class="btn btn-block btn-flat" style="width:300px;color:#fff;background: #ee5335;"> Check Your Order</a>


                        </div>
                </div>
            </div>
        </div>
    <div class="clear-fix"></div>
    {{--<div class="property-list">--}}

    {{--<h2 class="property-list-title">Properties for the sale</h2>--}}

    {{--<nav>--}}
    {{--<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">--}}
    {{--@foreach($categories as $cat)--}}
    {{--<a class="nav-item nav-link active" id="nav-home-tab" data-type="{{$cat->id}}" data-toggle="tab" href="#{{$cat->id}}" role="tab" aria-controls="nav-home" aria-selected="true">{{$cat->name}} </a>--}}
    {{--@endforeach--}}
    {{--</div>--}}
    {{--</nav>--}}
    {{--<div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">--}}
    {{--@foreach($categories as $category)--}}
    {{--<div class="tab-pane fade show active" id="{{$category->id}}" role="tabpanel" aria-labelledby="nav-home-tab">--}}
    {{--<div class="row property-list-home">--}}
    {{--@foreach($category->service as $cat)--}}
    {{--<div class=" col-md-4 col-lg-3">--}}
    {{--<div class="card" >--}}
    {{--@if(file_exists('storage/'.$cat->thumbnail) && $cat->thumbnail != '')--}}
    {{--<img class="card-img-top" src="{{asset('storage/'.$cat->thumbnail)}}" alt="{{$cat->title}}">--}}
    {{--@endif--}}
    {{--<div class="card-body">--}}
    {{--<h5 class="card-title">{{$cat->title}}</h5>--}}
    {{--<p class="price">Price:{{$cat->price}}</p>--}}
    {{--<p class="location">location:{{$cat->location->name}}</p>--}}

    {{--<a href="{{route('property.show',[$cat->slug])}}" class="btn btn-info">View Details</a>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--@endforeach--}}


    {{--</div>--}}
    {{--</div>--}}
    {{--@endforeach--}}
    {{--</div>--}}
    {{--</div>--}}
@endsection
@section('js_script')
    <script type="application/javascript">
        function Order(id){
            $("#overlay-load").fadeIn(300);
            $('#service-request-form').modal('show');
            $('#serviceId').val(id);
            setTimeout(function(){
                $("#overlay-load").fadeOut(300);

            },500);
        }
        $(document).ready(function () {
                  var dateToday = new Date();
            $( "#pereffered_date" ).datepicker(
                {
                    dateFormat: 'dd-mm-yy',
                    startDate: dateToday,  // disable past date

                }
            );
           $('.service-order-modal').on('submit',function(e){
               e.preventDefault();
               e.stopImmediatePropagation();
               $("#overlay-load").fadeIn(300);
               var url = $('.service-order-modal').attr('action');
               console.log(url,'url')
               var from = $('.service-order-modal').serialize();
               $.ajax({
                   type:'POST',
                   url: url,
                   data: from,
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   },
                   dataType: "json",
                   success: function (data) {
                       $('.service-order-modal')[0].reset();
                       $('#service-request-form').modal('hide');
                       if(data.success == true){
                           $("#overlay-load").fadeOut(300);
                           var id =$('#serviceId').val();
                           $('#login').modal('show');
                           $('#login-url').val(baseUrl + "/service_request/store/"+id);

                       }
                       if(data.login == true) {

                           $("#overlay-load").fadeOut(300);

                            $('#order-success').modal('show');
                            $('#booking-contact').text(data.contact);
                       }
                       if(data.booked == true) {
                            $("#overlay-load").fadeOut(300);
                            $('#order-success').modal('show');
                            $('#booking-contact').text(data.contact);
                            $('#already-booked').text('Already booked we will contact you soom');
                        }

                   },

                   error: function (jqXhr) {
                       $("#overlay-load").fadeOut(300);
                
                       if( jqXhr.status === 422 ) {
                           $.each(jqXhr.responseJSON.errors, function (value, key) {
                               console.log(value);
                               $('#'+value).css('border','1px solid red');
                           });
                       }
                   }
               });
                    return false;

           })

            $('#order-success').on('click',function(){
                $('#service-request-form').modal('hide');
                window.location.reload();
            });
           $('#order-success-service').on('click',function(){
               $('#service-request-form').modal('hide');
               window.location.reload();
           });
           $('#service-order-form').on('click',function(){
               $('#service-request-form').modal('hide');
               window.location.reload();
           });

        });
        </script>
@endsection