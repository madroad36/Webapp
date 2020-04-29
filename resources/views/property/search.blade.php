@extends('frontend.app')
@section('title', 'Property search lists')
@section('main-content')

<main role="main">

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="service-banner-image " style="background: url('{{asset('frontend/img/product.jpg')}}')">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-7 text-center aos-init " data-aos="fade">
                    <p>Property </p><br>
                    <p>Search Lists</p>
                </div>
            </div>
        </div>

    </div>
</main>
<div class="clear-fix"></div>
<div class="property-list">


    <div class="row">


        <div class="col-lg-3">
            <div class="product-search-bar" style="margin-left: 15px;">
                <h4>Advanced Filter</h4>
                <div class="main">

                    <div class="content">
                            {!! Form::open(array('route'=>'property.search','id'=>'property-search-form')) !!}
                              <!--   <div class="form-group">
                                    <label for="location">location</label>
                                    <select name="location" id="location" class="selectpicker form-control" title="Choose Location">
                                        <option value="Kathmandu">kathmandu</option>
                                        <option value="Bhakatapur">Bhakatapur</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="area">Area</label>
                                    <select name="area" id="area" class="selectpicker form-control" title="Choose Area">
                                        <option value="koteshwor">Koteshwor</option>
                                        <option value="Tinkune">Tinkune</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select name="category" id="category" class="selectpicker form-control" title="Choose Category">
                                        <option value="house">House</option>
                                        <option value="land">Land</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="subCategory">Sub Category</label>
                                    <select name="subCategory" id="subCategory" class="selectpicker form-control" title="Choose Sub Category">
                                        <option value="rent">rent</option>
                                        <option value="sale">sale</option>
                                    </select>
                                </div> -->
                                <div class="form-group">
                                    <label for="propertyName">City Name</label>
                                    <input type="text" name="city" id="city" class="form-control form-input" placeholder="city">
                                </div> 

                                <div class="form-group">
                                    <label for="propertyName">Address</label>
                                    <input type="text" name="address" id="city" class="form-control form-input" placeholder="Address">
                                </div>
                                
                                <div class="form-group">
                                    <label for="minPrice">Min Price</label>
                                    <input type="number" name="lowest_price" class="form-control" placeholder="Min Price">
                                </div>
                                <div class="form-group">
                                    <label for="maxPrice">Max Price</label>
                                    <input type="number" name="higest_price" class="form-control" placeholder="Max Price">
                                </div>
                                <div class="form-group ">
                                    <div class="checkbox">
                                        <label><input class="" name="lowest" type="checkbox" value="">Lowest To Highest</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input class="" name="higest" type="checkbox" value=""> Highest To Lowest </label>
                                    </div>
                                </div>
                                <input type="text" name="category" value="{{$category->name}}" hidden>
                                <button type="submit" class="btn btn-primary">Search</button>
                            {!! Form::close() !!}
                        </div>
                </div>
            </div>
            <div class="page-content">
                <div class="row property-list-home">
                </div>
            </div>

        </div>
        <div class="col-xs-12 col-lg-9">
            <div class="col-lg-12">

                <div class="form-group row">
                    <div class="col-lg-9">
                    </div>
                    <div class="col-lg-3">
                        <label for="" class="item-page">Item Per Page</label>
                        <select id="properties-lists" class="" style="margin-bottom: 10px;">
                            <option value="8" selected>8</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>

                </div>

            </div>

            <div class=" search-property-list-home" id="list-page-scroll">
                <div class="tablist proprety-form">
                    <div class="row">
                    @if(!empty($message))
                    {{$message}}
                    @endif
                    @if($properties->isEmpty())
                    <p style="margin-left: 50px; color: red;">Result not found</p>
                    @endif

                    @foreach($properties as $property)

                    <div class="col-lg-4 ">
                        <div id="property-{{$property->id}}">
                            <div class="card">
                                @if(file_exists('storage/'. $property->thumbnail) &&  $property->thumbnail != '')
                                <img class="card-img-top" style=" height:200px;"
                                src="{{asset('storage/'. $property->thumbnail)}}" alt="{{ $property->title}}">
                                @endif
                                <div class="car-btn-link">
                                    <span>{{$property->category->name}}</span>
                                    <span class="span-sub">{{$property->subcategory['title']}}</span>
                                </div>
                                <div class="card-creaed-date">

                                    @php $year = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $property->created_at)->year; @endphp
                                    @php $month = $property->created_at->format('M'); @endphp
                                    @php $day = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $property->created_at)->day;@endphp
                                    <span>{{$day}} {{$month}} {{$year}}</span>

                                </div>
                                <div class="property-detial-btn">

                                    <a href="{{route('property.show',[$property->slug])}}" data-toggle="tooltip" title="view-property" id="propert-view-frontend-btn" class="card-link">View More</a>

                                </div>
                                <div class="card-body property-edit">


                                    <h5 class="card-title">{{str_limit($property->title,'26','.')}}</h5>
                                    <p><i class="fa fa-map-marker"></i>{{$property->location->name}} <span>:</span> @if(!empty($property->place_id)) {{$property->place->name}} @endif</p>
                                    {{--<h6 class="card-subtitle mb-2 text-muted" style="margin-top: 20px;">{{$property->category->title}}</h6>--}}
                                    {{--<p class="card-text">{!! str_limit($product->description,'100','....') !!}.</p>--}}
                                    <span>Rs</span>{{number_format($property->price)}}

                                </div>
                            </div>
                        </div>

                    </div>

                    @endforeach


                    {{--                            <nav class="pagination-nav" aria-label="Page navigation">--}}
                        {{--                                {{  $properties->links('vendor.pagination.default') }}--}}
                    {{--                            </nav>--}}

                    <div class="property-ajax-edit">

                    </div>

                </div>
            </div>
            {{--<div class="row">--}}

                {{--@foreach( $properties as $property)--}}
                {{--<div class="col-md-4 col-lg-4">--}}

                    {{--<div class="card">--}}
                        {{--@if(file_exists('storage/'.$property->thumbnail) && $property->thumbnail != '')--}}
                        {{--<img class="card-img-top"--}}
                        {{--src="{{asset('storage/'.$property->thumbnail)}}"--}}
                        {{--alt="{{$property->title}}">--}}
                        {{--@endif--}}
                        {{--<div class="card-body">--}}
                            {{--<h5 class="card-title">{{$property->title}}</h5>--}}
                            {{--<p class="price">Price:{{$property->price}}</p>--}}
                            {{--<p class="price">Category:{{$property->category->name}}</p>--}}
                            {{--<p class="location">location:{{$property->location->name}}</p>--}}

                            {{--<a href="{{route('property.show',[$property->slug])}}"--}}
                                {{--class="btn btn-info">View Details</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                    {{--</div>--}}
                    {{--@endforeach--}}
                    {{--<nav class="pagination-nav" aria-label="Page navigation  ">--}}
                        {{--{{  $properties->links('vendor.pagination.default') }}--}}
                    {{--</nav>--}}
                {{--</div>--}}
            </div>
        </div>

    </div>


</div>




@endsection
@section('js_script')
<script type="application/javascript">
    $(document).ready(function () {

    });
</script>
@endsection