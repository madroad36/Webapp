@extends('frontend.app')
@section('title', 'Service List')
@section('main-content')
    <main role="main">

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="service-banner-image " style="background: url('{{asset('frontend/img/service.png')}}')">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-7 text-center aos-init " data-aos="fade">
                        <p>Service > {{$subcategory->category->name}}</p>
                        <h1 class="service-banner-header">{{$subcategory->title}} List</h1>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <div class="property-list">
        <div class="container">
            <div class="product-search-bar">
                <div class="main">
                    {!! Form::open(array('route'=>'service.search','class'=>'form-inline')) !!}
                    <div class="form-group">
                        <label for="email">Category</label>
                        <input type="text" name="category" id="service-category" class="form-control" placeholder="search by service category" id="search-form-input">
                        <div class="service-category"></div>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Subcategory</label>
                        <input type="text" name="subcategory" id="service-subcategory" placeholder="service subcatgory" class="form-control"  id="search-form-title">
                        <div class="service-subcategory"></div>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Title</label>
                        <input type="text" name="title" id="service-title" placeholder="service title" class="form-control"  id="search-form-title">
                    </div>



                    <button type="submit" id="product-search-submit-btn" class="btn btn-default">Submit</button>
                    {!! Form::close() !!}
                </div>





            </div>
            <div class="row property-list-home">
                @foreach($services as $service)
                    <div class="col-md-4 col-lg-3">

                        <div class="card" >
                            @if(file_exists('storage/'. $service->thumbnail) &&  $service->thumbnail != '')
                                <img class="card-img-top" src="{{asset('storage/'. $service->thumbnail)}}" alt="{{ $service->title}}">
                            @endif
                            <div class="overlay">
                                <div class="text">
                                    <a href="{{route('service.show',[$service->slug])}}" class="service-view">More Details</a>
                                    <span class="service-monthly-tag">Monthly</span>
                                    <span class="service-yearly-tag">Yearly</span>

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-title-product">
                                    <span style="color: #0b58a2; font-size: 16px;">  {{$service->title}}</span>
                                    {{--<span><strong>Rs</strong>{{number_format($product->price)}} {{$product->unit}}</span>--}}
                                    {{--<span><i class="fa fa-clipboard"></i>{{$product->quantity}}</span>--}}
                                </div>





                            </div>

                        </div>

                    </div>
                @endforeach
                <nav aria-label="Page navigation example mx-auto" style="width: 340px; margin:0 auto;">
                    {{   $services->links('vendor.pagination.default') }}
                </nav>

            </div>
        </div>

    </div>
    {{--<div class="service-page">--}}

    {{--<h2 class="property-page-service-heading">Our Services</h2>--}}
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
    {{--<nav aria-label="Page navigation example mx-auto" style="width: 340px; margin:0 auto;">--}}
    {{--{{  $services->links('vendor.pagination.default') }}--}}
    {{--</nav>--}}
    {{--</div>--}}
@endsection
@section('js_script')
    <script type="application/javascript">
        $(document).ready(function () {
            $("#search-form-input").autocomplete({
                source: function (request, response) {
                    var val = $(".search-category option:selected").val();
                    $.ajax({
                        url: "{{route('product.category')}}",
                        data: {
                            term: request.term,
                        },
                        dataType: "json",
                        success: function (data) {

                            var resp = $.map(data, function (obj) {
                                console.log(obj.id);
                                return obj.title;
                                $('#search-form-input').val(object.id);
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
                    var val = $(".search-category option:selected").val();
                    $.ajax({
                        url: "{{route('product.title')}}",
                        data: {
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
    </script>

@endsection