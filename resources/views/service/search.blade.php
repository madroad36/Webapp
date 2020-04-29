@extends('frontend.app')
@section('title', 'Service search lists')
@section('main-content')
    <main role="main">

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="service-banner-image " style="background: url('{{asset('frontend/img/service.jpeg')}}')">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-7 text-center aos-init " data-aos="fade">

                        <h1 class="">Service Search Lists</h1>
                    </div>
                </div>
            </div>

        </div>
    </main>
    <div class="service-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    @if(!empty($message))
                        {{$message}}
                    @endif
                    @if(count($services) == 0)
                        <p>Result not found</p>
                    @endif
                    <ul class="list-unstyled search">
                        @foreach( $services as $service)
                            <a href="{{route('service.show',[$service->slug])}}" >
                                <li class="media">

                                    @if(file_exists('storage/'.$service->thumbnail) && $service->thumbnail != '')
                                        <img class="mr-3" style="width: 100px; height: 100px;" src="{{asset('storage/'.$service->thumbnail)}}" alt="{{$service->title}}">
                                    @endif
                                    <div class="media-body">
                                        <h5 class="mt-0 mb-1">{{ucfirst($service->title)}}</h5>
                                        <p class="price"> Category:&nbsp;&nbsp;&nbsp; Price:{{$service->price}} &nbsp;&nbsp;&nbsp;&nbsp;location:{{$service->location->name}}</p>
                                        <p>{!!  str_limit($service->description,'180','......') !!}</p>
                                    </div>

                                </li>
                            </a>
                            {{--<li class="media">--}}
                            {{--<a href="{{route('property.show',[$property->slug])}}" >--}}

                            {{--@if(file_exists('storage/'.$property->thumbnail) && $property->thumbnail != '')--}}
                            {{--<img class="mr-3" src="{{asset('storage/'.$property->thumbnail)}}" alt="{{$property->title}}">--}}
                            {{--@endif--}}
                            {{--<div class="media-body">--}}
                            {{--<h5 class="mt-0 mb-1">{{$property->title}}</h5>--}}
                            {{--<p class="price"> Category:{{$property->category->name}}&nbsp;&nbsp;&nbsp; Price:{{$property->price}} &nbsp;&nbsp;&nbsp;&nbsp;location:{{$property->location->name}}</p>--}}
                            {{--<p>{!!  str_limit($property->description,'180','......') !!}</p>--}}

                            {{--</div>--}}
                            {{--</a>--}}
                            {{--</li>--}}

                        @endforeach
                    </ul>

                </div>
                <div class="col-lg-4">
                    <div class="product-category">
                        <h2>Service Category Lists</h2>
                        <ul>
                            @foreach( $servicecategories as $serve)
                                <li class="">
                                    <a href="{{route('category.show',[$serve->slug])}}">{{$serve->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="clear-fix"></div>




@endsection
@section('js_script')
    <script type="application/javascript">
        $(document).ready(function () {

        });
    </script>
@endsection