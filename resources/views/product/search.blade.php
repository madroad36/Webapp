@extends('frontend.app')
@section('title', 'Product Search List')
@section('main-content')
<main role="main">

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="service-banner-image " style="background: url('{{asset('frontend/img/product.jpg')}}')">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-7 text-center aos-init " data-aos="fade">
                    <h1 class="service-banner-header">{{$productCategory->title}} Category</h1>
                    <p> Search Lists</p>
                </div>
            </div>
        </div>

    </div>
</main>

<div class="property-list">

    <div class="row">
        <div class="col-lg-3">
            <div class="product-search-bar" style="margin-left: 15px;">
                <h4>Advanced Filter</h4>
                <div class="main" style="padding: 10px !important;">
                   {!! Form::open(array('route'=>'product.search','class'=>'form-inline')) !!}
                   <div class="form-group">
                    <label for="productName">Product Name</label>
                    <input type="text" name="title" placeholder="Product title" class="form-control" id="search-form-title">
                </div>
                <div class="form-group ">
                    <label for="productName">Min Price</label>
                    <input id="property-lowest" name="low" class="form-control " type="number"
                    placeholder="Min Price">
                </div>
                <div class="form-group ">
                    <label for="productName">Max Price</label>
                    <input id="property-higest" name="high" class="form-control " type="number"
                    placeholder="Max Price">
                </div>
                <div class="search-by-price">
                    <h4>Filter By Price</h4>
                </div>
                <div class="form-group ">
                    <div class="checkbox">
                        <label><input class="" name="lowest" type="checkbox" value="">Lowest To Highest</label>
                    </div>
                    <div class="checkbox">
                        <label><input class="" name="higest" type="checkbox" value=""> Highest To Lowest </label>
                    </div>
                </div>
                <br>
                <input type="text" name="category" value="{{$productCategory->id}}" hidden>
                <button type="submit" id="product-search-submit-btn" class="btn btn-primary mt-3">Submit</button>
                {!! Form::close() !!}
            </div>


        </div>
    </div>

    <div class="col-lg-9">
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
        <div class="row property-list-home">
            @if(!empty($message))
            {{$message}}
            @endif
            @if($products->isEmpty())
            <p style="margin-left: 50px; color: red;">Result not found</p>
            @endif
            @foreach( $products as $product)
            <div class="col-md-3 col-lg-4">

                <div class="card">
                    @if(file_exists('storage/'. $product->image) &&  $product->image != '')
                    <img class="card-img-top" src="{{asset('storage/'. $product->image)}}"
                    alt="{{ $product->title}}">
                    @endif
                    <div class="overlay">
                        <div class="text">
                            <a href="{{route('product.show',[$product->slug])}}">
                                <i class="fa fa-shopping-cart"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-title-product">
                                <span >  {{$product->title}}</span>
                                <span><strong>Rs</strong>{{number_format($product->price)}} {{$product->unit}}</span>
                                {{--<span><i class="fa fa-clipboard"></i>{{$product->quantity}}</span>--}}
                            </div>


                            {{--<a href="{{route('product.show',[$product->slug])}}" class="btn btn-info">View Details</a>--}}
                        </div>

                    </div>

                </div>
                @endforeach
                <nav aria-label="Page navigation example mx-auto" style="width: 340px; margin:0 auto;">
                    {{   $products->links('vendor.pagination.default') }}
                </nav>


            </div>

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
        {{--$("#search-form-input").autocomplete({--}}
            {{--source: function (request, response) {--}}
            {{--var val = $(".search-category option:selected").val();--}}
            {{--$.ajax({--}}
                {{--url: "{{route('product.category')}}",--}}
                {{--data: {--}}
                {{--term: request.term,--}}
                {{--},--}}
                {{--dataType: "json",--}}
                {{--success: function (data) {--}}

                {{--var resp = $.map(data, function (obj) {--}}
                    {{--console.log(obj.id);--}}
                    {{--return obj.title;--}}
                    {{--$('#search-form-input').val(object.id);--}}
                    {{--});--}}

                {{--response(resp);--}}
                {{--},--}}

                {{--error: function (data) {--}}

                {{--}--}}
                {{--});--}}
            {{--},--}}
            {{--minLength: 1--}}
            {{--});--}}
        {{--$("#search-form-title").autocomplete({--}}
            {{--source: function (request, response) {--}}
            {{--var val = $(".search-category option:selected").val();--}}
            {{--$.ajax({--}}
                {{--url: "{{route('product.title')}}",--}}
                {{--data: {--}}
                {{--term: request.term,--}}
                {{--},--}}
                {{--dataType: "json",--}}
                {{--success: function (data) {--}}

                {{--var resp = $.map(data, function (obj) {--}}

                                {{--// display the selected text--}}
                                {{--$("#search-form-title").value(obj.id); // save selected id to hidden input--}}
                                {{--return obj.title;--}}
                                {{--});--}}

                {{--response(resp);--}}
                {{--},--}}
                {{--select: function (event, ui) {--}}
                            {{--// Prevent value from being put in the input:--}}
                            {{--this.value = ui.item.label;--}}
                            {{--// Set the next input's value to the "value" of the item.--}}
                            {{--$(this).next("input").val(ui.item.value);--}}
                            {{--event.preventDefault();--}}
                            {{--},--}}

                            {{--error: function (data) {--}}

                            {{--}--}}
                            {{--});--}}
            {{--},--}}
            {{--minLength: 1--}}
            {{--});--}}
    });
</script>

@endsection