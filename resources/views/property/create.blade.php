@extends('frontend.app')
@section('title', 'Add Property')
@section('main-content')
    <main role="main">

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="service-banner-image " style="background: url('{{asset('/frontend/img/service.jpeg')}}')">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-7 text-center aos-init " data-aos="fade">

                        <h1 class="">Property-Details</h1>
                        <span class="caption mb-3">{{$property->title}}</span>
                    </div>
                </div>
            </div>

        </div>
    </main>
    <div class="single-post">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <div class="single-post-img">
                        @if(file_exists('storage/'.$property->thumbnail) && $property->thumbnail != '')
                            <a rel="prettyPhoto[myGallery]" class="carsoule-img" title="{{$property->title}}" href="{{asset('storage/'.$property->thumbnail)}}">

                                <img src="{{asset('storage/'.$property->thumbnail)}}" alt="{{$property->title}}">
                            </a>
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

                </div>
                <div class="col-md-12 col-lg-6">
                    <h3 class="singlie-post-title">{{$property->title}}</h3>
                    <div class="details" style="border: 1px solid #000000; padding: 20px;">
                        <p>Contact:{{$property->user->contact}}</p>
                        <p>Broker No:{{$property->user->batch_number}}</p>
                        <p>Location:{{$property->location->name}}</p>
                        <p>Price:{{$property->price}}</p>
                        <p>Area:{{$property->area}}</p>
                        <p>Category:{{$property->category->name}}</p>
                        <p>Plot no:{{$property->plot_no}}</p>
                        @if(!empty($property->subcategory_id))
                            <p>SubCategory:{{$property->subcategory->title}}</p>
                        @endif

                    </div>
                    <div class="description" style="margin-top: 30px;">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="{{$property->overview}}" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Overview </a>
                                <a class="nav-item nav-link" id="owner->image" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Owner-Image</a>
                                <a class="nav-item nav-link" id="{{$property->feature}}" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false">Features</a>
                                <a class="nav-item nav-link " id="nav-home1-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Description</a>
                            </div>
                        </nav>
                        <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="{{$property->overview}}">

                                {!!  $property->overview !!}
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="owner->image">
                                <img src="{{asset('storage/'.$property->property_image)}}" alt="{{$property->title}}">
                            </div>

                            <div class="tab-pane fade" id="nav-about" role="tabpanel" aria-labelledby="{{$property->feature}}">
                                {{$property->feature}}
                            </div>
                            <div class="tab-pane fade" id="nav-about" role="tabpanel" aria-labelledby="{{$property->description}}">
                                {!!  $property->description !!}
                            </div>
                        </div>


                        <div class="single-post-checkout">
                            <p>Proceed further for final dealing</p>

                            <a href="" class="btn single-confirm-btn">confirm</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="property-list">
        <h2>Similar Category Property</h2>
        <div class="row property-list-home">
            @foreach($propertyList as $property)
                <div class="col-md-4 col-lg-3">

                    <div class="card" >
                        @if(file_exists('storage/'.$property->thumbnail) && $property->thumbnail != '')
                            <img class="card-img-top" src="{{asset('storage/'.$property->thumbnail)}}" alt="{{$property->title}}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{$property->title}}</h5>
                            <p class="price">Price:{{$property->price}}</p>
                            <p class="location">location:{{$property->location->name}}</p>

                            <a href="{{route('property.show',[$property->slug])}}" class="btn btn-info">View Details</a>
                        </div>
                    </div>

                </div>
            @endforeach

        </div>
    </div>
    <div class="property-list">
        <h2>Similar Location Property</h2>
        <div class="row property-list-home">
            @foreach($similarLocation as $property)
                <div class="col-md-4 col-lg-3">

                    <div class="card" >
                        @if(file_exists('storage/'.$property->thumbnail) && $property->thumbnail != '')
                            <img class="card-img-top" src="{{asset('storage/'.$property->thumbnail)}}" alt="{{$property->title}}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{$property->title}}</h5>
                            <p class="price">Price:{{$property->price}}</p>
                            <p class="location">location:{{$property->location->name}}</p>

                            <a href="{{route('property.show',[$property->slug])}}" class="btn btn-info">View Details</a>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
    <div class="service-page">
        <h2 class="service-page-heading">Our Services</h2>
        <div class="row">
            @foreach($services as $service)
                <div class="col-lg-3">
                    <a href="{{route('service.show',[$service->slug])}}" class="service-name">
                        @if(file_exists('storage/'.$service->thumbnail) && $service->thumbnail !='')
                            <img src="{{asset('storage/'.$service->thumbnail)}}" alt="{{$service->title}}">
                        @endif
                        <div class="overlay">
                            <div class="text">{{$service->title}}</div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('js_script')
@endsection