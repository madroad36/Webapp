@extends('frontend.app')
@section('title', $property->title)
@section('main-content')

{{-- <main role="main">

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="service-banner-image " style="background: url('{{asset('frontend/img/product.jpg')}}')">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-7 text-center aos-init " data-aos="fade">
                    <h1 class="service-banner-header">{{$property->category->name}}</h1>
                    <p> {{$property->title}}</p>
                </div>
            </div>
        </div>

    </div>
</main> --}}
<div class="container-fluid">
    <div class="single-product">
        @if ($message = Session::get('success'))
        <div class="alert alert-info alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif
        @if ($message1 = Session::get('flash_errors'))
        <div class="alert alert-danger">{{ $message1 }}</div>
        @endif
        <div class="row">
            <div class="col-12 col-md-6 col-lg-5 mt-3">
                <div class="single-post-img">
                    @if(file_exists('storage/'.$property->thumbnail) && $property->thumbnail != '')
                    <a rel="prettyPhoto[myGallery]" class="carsoule-img" title="{{$property->title}}" href="{{asset('storage/'.$property->thumbnail)}}">

                        <img src="{{asset('storage/'.$property->thumbnail)}}" alt="{{$property->title}}">
                    </a>
                    @else
                    <img src="{{asset('frontend/img/singleproduct.jpg')}}" />
                    @endif

                </div>
                <div class="owl-carousel owl-theme">
                    @foreach($property->image as $img)
                    <div class="item">
                        <a rel="prettyPhoto[myGallery]" id="wrapper" class="carsoule-img" title="{{$property->title}}" href="{{asset('storage/'.$img->image)}}">
                            <img src="{{asset('storage/'.$img->image)}}" alt="{{$property->title}}">
                        </a>
                    </div>
                    @endforeach


                </div>
             <!--    <div class="single-product-img">
                    <img src="{{asset('frontend/img/singleproduct.jpg')}}" />
                </div> -->
            </div>
            <div class="col-12 col-md-6 col-lg-7 mt-3">
                <div class="product-short-detail">
                    <div class="singlie-product-title col-12">
                        <h4>{{$property->title}}</h4>
                    </div>
                    <div class="product-category col-12">
                        <span>Category: <strong>{{$property->category->name}}</strong></span>
                        <span class="pl-3">Sub-Category: <strong>{{$property->subcategory->title}}</strong></span>
                    </div>
                    <div class="line"></div>
                    <div class="product-location col-12">
                        <i class="fas fa-map-marker-alt"></i>  <span class="pl-2">{{$property->location->name}}</span>
                    </div>
                    <div class="product-landmark col-12">
                        <i class="fas fa-landmark"></i><span class="pl-2">Near by {{$property->near_by}}</span>
                    </div>
                    <div class="product-price col-12 pt-3">
                        <p>Rs: 
                            <span>
                                @if($property->subcategory->title == 'Rent')
                                {{number_format($property->price)}}  {{$property->rent_option}}
                                @else
                                {{number_format($property->price)}}
                                @endif
                            </span>
                        </p>
                    </div>
                    <div class="single-post-checkout col-12">
                        <strong>Proceed further for final dealing</strong>
                        <span id="login-error" style="display:block; margin-bottom: 15px;"></span>
                        @if(Auth::check())
                        @if(Auth::user()->order->contains('property_id', $property->id))
                        <a href="javascript:void(0)" id="property-order-booked" data-role="login" data-id="{{$property->id}}" data-type="{{route('booking.store')}}" class="btn btn-primary">
                            @if($property->book->contains('is_active', 1))
                            Sold
                            @else
                            Booked
                            @endif
                        </a>

                        @else
                        <a href="javascript:void(0)" id="property-order" data-role="login" data-id="{{$property->id}}" data-type="{{route('booking.store')}}" class="btn btn-primary">confirm</a>

                        @endif

                        @else
                        <a href="javascript:void(0)" id="property-order-login" data-role="not-login" data-id="{{$property->id}}" data-type="{{route('booking.store',[$property->id])}}" class="btn btn-primary">confirm</a>

                        @endif
                    </div>
                </div>
                <div class="line"></div>
                <div class="description" >
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="{{$property->overview}}" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Overview </a>
                            <a class="nav-item nav-link" id="owner->image" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Owner Information</a>
                            <a class="nav-item nav-link" id="{{$property->feature}}" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false">Details</a>
                            <a class="nav-item nav-link " id="nav-home1-tab" data-toggle="tab" href="#nav-amminites" role="tab" aria-controls="nav-home" aria-selected="true">Ammineties</a>
                        </div>
                    </nav>
                    <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                        {{-- Overview --}}
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="{{$property->overview}}">
                            <p>{!!  $property->overview !!}</p>
                        </div>
                        {{-- Owner Information --}}
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="owner->image">
                            <div class="property-owner-information">
                                <div class="row">
                                    <div class="col-4 col-lg-3">
                                        @if(file_exists('storage/'.$property->owner_image) && $property->owner_image != '')
                                        <img src="{{asset('storage/'.$property->owner_image)}}" class="img-thumbnail rounded-circle" alt="{{$property->title}}">
                                        @else
                                        <img src="{{asset('frontend/img/singleproduct.jpg')}}" class="img-thumbnail rounded-circle"/>
                                        @endif
                                    </div>
                                    <div class="col-8 col-lg-9">
                                        <h4>{{$property->name}}</h4>
                                        <div class="d-flex flex-column">
                                            <div><strong>Phone: </strong>{{$property->contact}}</div>
                                            <div><strong>Citizenship No: </strong>{{$property->citizen}}</div>
                                        </div>
                                        <div class="property-paper">
                                            <div class="col-4  mt-3">
                                                @if(file_exists('storage/'.$property->property_image) && $property->property_image != '')
                                                <img src="{{asset('storage/'.$property->property_image)}}" alt="{{$property->title}}" >
                                                @else
                                                <img src="{{asset('frontend/img/singleproduct.jpg')}}" class="img-thumbnail rounded-circle"/>
                                                @endif
                                            </div>
                                        </div>     
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Details of the properties --}}
                        <div class="tab-pane fade" id="nav-about" role="tabpanel" aria-labelledby="{{$property->feature}}">
                            <div class="property-details">
                                <div class="property-wrapper">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="propety-content-detail">
                                                <label for="">Face: </label>
                                                <strong>{{$property->face}}</strong>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="propety-content-detail">
                                                <label for="">Road Size: </label>
                                                <strong>{{$property->road_size}}</strong>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="propety-content-detail">
                                                    <label for="">Plot No: </label>
                                                    <strong>{{$property->plot_no}}</strong>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="propety-content-detail">
                                                    <label for="">Area: </label>
                                                    <strong>{{$property->area}} / {{$property->land_unit}}</strong>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    @if($property->category_id != 2)
                                    <div class="house">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <div class="propety-content-detail">
                                                    <label for="">Room:</label>
                                                    <strong>{{$property->total_room}}</strong>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="propety-content-detail">
                                                    <label for="">kitchen:</label>
                                                    <strong>{{$property->kitchen}}</strong>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="propety-content-detail">
                                                    <label for="">Store: </label>
                                                    <strong>{{$property->store}}</strong>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="propety-content-detail">
                                                    <label for="">Bathroom: </label>
                                                    <strong>{{$property->bathroom}}</strong>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="propety-content-detail">
                                                    <label for="">Living</label>
                                                    <strong>{{$property->living_room}}</strong>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="propety-content-detail">
                                                    <label for="">Hall</label>
                                                    <strong>{{$property->hall}}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="house price">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="propety-content-detail">
                                                    <label for="">House Type: </label>
                                                    <strong>{{$property->house_type}}</strong>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="propety-content-detail">
                                                    <label for="">Drainage: </label>
                                                    <strong>{{$property->drainage}}</strong>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="propety-content-detail">
                                                    <label for="">Build Year: </label>
                                                    <strong>{{$property->build}} {{$property->date_type}}</strong>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="propety-content-detail">
                                                    <label for="">Shape: </label>
                                                    <strong>{{$property->shape}}</strong>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                        {{-- Ammineties --}}
                        <div class="tab-pane fade" id="nav-amminites" role="tabpanel" aria-labelledby="{{$property->ammenities}}">
                            @foreach($property->aminites->chunk(2) as $aminite)
                            <ul class="aminites-list">
                                @foreach($aminite as $value)


                                <li>
                                    <label class="main">{{$value->name}}
                                        <input class="check-price" @if($value->is_active =='1')checked @endif type="checkbox" >
                                        <span  class="w3docs"></span>
                                    </label>
                                </li>
                                @endforeach

                            </ul>
                            @endforeach


                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    @include('property.success')
</div>
{{--<div class="property-list">--}}
    {{--<h2>Similar Category Property</h2>--}}
    {{--<div class="row property-list-home">--}}
        {{--@foreach($propertyList as $property)--}}
        {{--<div class="col-md-4 col-lg-3">--}}

            {{--<div class="card" >--}}
                {{--@if(file_exists('storage/'.$property->thumbnail) && $property->thumbnail != '')--}}
                {{--<img class="card-img-top" src="{{asset('storage/'.$property->thumbnail)}}" alt="{{$property->title}}">--}}
                {{--@endif--}}
                {{--<div class="card-body">--}}
                    {{--<h5 class="card-title">{{$property->title}}</h5>--}}
                    {{--<p class="price">Price:{{$property->price}}</p>--}}
                    {{--<p class="location">location:{{$property->location->name}}</p>--}}

                    {{--<a href="{{route('property.show',[$property->slug])}}" class="btn btn-info">View Details</a>--}}
                {{--</div>--}}
            {{--</div>--}}

        {{--</div>--}}
        {{--@endforeach--}}

    {{--</div>--}}
{{--</div>--}}
{{--<div class="property-list">--}}
    {{--<h2>Similar Location Property</h2>--}}
    {{--<div class="row property-list-home">--}}
        {{--@foreach($similarLocation as $property)--}}
        {{--<div class="col-md-4 col-lg-3">--}}

            {{--<div class="card" >--}}
                {{--@if(file_exists('storage/'.$property->thumbnail) && $property->thumbnail != '')--}}
                {{--<img class="card-img-top" src="{{asset('storage/'.$property->thumbnail)}}" alt="{{$property->title}}">--}}
                {{--@endif--}}
                {{--<div class="card-body">--}}
                    {{--<h5 class="card-title">{{$property->title}}</h5>--}}
                    {{--<p class="price">Price:{{$property->price}}</p>--}}
                    {{--<p class="location">location:{{$property->location->name}}</p>--}}

                    {{--<a href="{{route('property.show',[$property->slug])}}" class="btn btn-info">View Details</a>--}}
                {{--</div>--}}
            {{--</div>--}}

        {{--</div>--}}
        {{--@endforeach--}}
    {{--</div>--}}
{{--</div>--}}
{{--<div class="service-page">--}}
    {{--<h2 class="service-page-heading">Our Services</h2>--}}
    {{--<div class="row">--}}
        {{--@foreach($services as $service)--}}
        {{--<div class="col-lg-3">--}}
            {{--<a href="{{route('service.show',[$service->slug])}}" class="service-name">--}}
                {{--@if(file_exists('storage/'.$service->thumbnail) && $service->thumbnail !='')--}}
                {{--<img src="{{asset('storage/'.$service->thumbnail)}}" alt="{{$service->title}}">--}}
                {{--@endif--}}
                {{--<div class="overlay">--}}
                    {{--<div class="text">{{$service->title}}</div>--}}
                {{--</div>--}}
            {{--</a>--}}
        {{--</div>--}}
        {{--@endforeach--}}
    {{--</div>--}}
{{--</div>--}}
@endsection
@section('js_script')

<script type="text/javascript">
    $(document).ready(function () {
        $('#property-order').on('click',function(){
            var url = $(this).attr('data-type');
            var id = $(this).attr('data-id');
            debugger
            $.ajax(
            {
                type: "POST",
                url: url,
                data:{property_id:id},
                datatype: 'html',
                headers: {
                    'X-CSRF-TOKEN': '<?= csrf_token() ?>'
                },
                success: function (response) {

                    $('#booking-success').modal('show');
                    $('#message').text(response.message);
                    $('#booking-contact').text(response.user.contact);
                    $('#booking-email').text(response.user.email);

                },
                error: function (data) {
                    $('#login').modal('show');
                    $('#login-url').val('{{route('booking.store')}}');
                            // $('#login-error').addClass('alert-danger');
                            // $('#login-error').text(data.responseJSON.message)
                            //
                            // setTimeout(function(){
                            //     $("#login-error").fadeOut(3000);
                            //
                            // },3000);

                        }

                    }).fail(function (jqXHR, ajaxOptions, thrownError) {

                    });
                });
        $('#property-order-login').on('click',function(){
            var url = $(this).attr('data-type');
            var id = $(this).attr('data-id');
            $.ajax(
            {
                type: "Get",
                url: url,
                data:{property_id:id},
                datatype: 'html',
                headers: {
                    'X-CSRF-TOKEN': '<?= csrf_token() ?>'
                },
                success: function (response) {

                    $('#booking-success').modal('show');
                    $('#booking-contact').text(response.user.contact);
                    $('#booking-email').text(response.user.email);

                },
                error: function (data) {
                    $('#login').modal('show');
                    $('#login-url').val(baseUrl+"/booking/order/"+id);
                            // $('#login-error').addClass('alert-danger');
                            // $('#login-error').text(data.responseJSON.message)
                            //
                            // setTimeout(function(){
                            //     $("#login-error").fadeOut(3000);
                            //
                            // },3000);

                        }

                    }).fail(function (jqXHR, ajaxOptions, thrownError) {

                    });
                });


    });
</script>
@endsection