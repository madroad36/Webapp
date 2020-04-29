@extends('frontend.app')
@section('title', 'Product List')
@section('main-content')
{{-- New Layout Products list --}}
{{-- Product Category Listing--}}
<div class="container-fluid">
    <section class="product-category">
        <div class="home-display py-3"> 
            <div class="content pt-3">
                <ul id="productCategory">
                    <li>
                        @if($category)
                        @foreach($category as $categories)
                        @if($categories->id != $productCategory->id)
                        <a href="{{route('product.category.show',[$categories->slug])}}">
                            <div class="box">
                                <img src="{{asset('frontend/img/furniture.jpg')}}" alt="Avatar" class="image">
                                <div class="overlay"></div>
                                <h4 class="text">{{$categories->title}}</h4>
                            </div>
                        </a>
                        @endif
                        @endforeach
                        @else
                        <a href="#!">
                            <div class="box">
                                <img src="{{asset('frontend/img/furniture.jpg')}}" alt="Avatar" class="image">
                                <div class="overlay"></div>
                                <h4 class="text">Desk</h4>
                            </div>
                        </a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </section><hr>
    {{-- Sidebar and Product listing --}}
    <div class="row">
        {{-- Left sidebar --}}
        <div class="col-md-3">
            <div class="left-sidebar">
                {{-- Sidebar card --}}
                <div class="card">
                    <div class="card-body">
                        {{-- Sidebar card heading --}}
                        <div class="title">
                            <h3 class="card-title">Advance Search</h3>
                        </div>
                        {{-- Sibar card content --}}
                        <div class="content">
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
                            <input type="text" name="category" value="{{$productCategory->id}}" hidden>
                            <button type="submit" id="product-search-submit-btn" class="btn btn-primary mt-3">Submit</button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Product Listing --}}
        <div class="col-md-9">
            <section class="products">
                <div class="home-display">
                    {{-- Page title --}}
                    <div class="title">
                        <div class="row">
                            <div class="col-6">
                                <h2>Products</h2>
                            </div>
                            <div class="col-6">
                                {{-- sorting form / auto submit on seleting the option --}}
                                <div class="filter float-right">
                                    <form action="">
                                        <select name="sort" id="sort" class="form-control">
                                            <option hidden >Sort By:</option>
                                            <option value="Newest">Newest</option>
                                            <option value="Oldest">Oldest</option>
                                            <option value="Price Low to High">Price Low to High</option>
                                            <option value="Price High to Low">Price High to Low</option>
                                        </select>
                                        <i class="fas fa-chevron-down"></i>
                                    </form>
                                </div>
                            </div>  
                        </div>
                    </div>
                    {{-- product listing --}}
                    <div class="content pt-3">
                        <div class="row">
                            @if($products)
                            @foreach($products as $product)
                            <div class="col-6 col-sm-6 col-md-4 col-lg-3 py-2">
                                <div class="row">
                                    <div class="col-12">
                                        <a href="#">
                                            <div class="card">
                                                <div class="card-image">
                                                    @if(file_exists('storage/'. $product->image) &&  $product->image != '')
                                                    <img class="img-fluid" src="{{asset('storage/'. $product->image)}}"
                                                    alt="{{ $product->title}}">
                                                    @else
                                                    <img class="img-fluid" src="{{asset('frontend/img/product1.jpg')}}" alt="Alternate Text" />
                                                    @endif
                                                </div>
                                                <div class="card-body">
                                                    <div class="title">
                                                        <h3>{{$product->title}}</h5>
                                                            <div class="sub-title">
                                                                <p>{{str_limit($product->description,20)}}</p>
                                                            </div>
                                                        </div>
                                                        <div class="price">
                                                          <!--   <p class="actual">
                                                                <span class="currencty">Rs.</span>
                                                                <span class="actual-price">5000</span>
                                                                <span class="discount-percentage">50%</span>
                                                            </p> -->
                                                            <p class="current-price">Rs: {{$product->price}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif

                                {{-- pagination --}}
                                <nav aria-label="Page navigation ">
                                    {{   $products->links('vendor.pagination.default') }}
                                </nav>
                            </div>
                        </div>
                    </section>
                </div>    
            </div>
        </div>

        <!-- old Code -->

       <!--  <main role="main">
           Main jumbotron for a primary marketing message or call to action
           <div class="service-banner-image " style="background: url('{{asset('frontend/img/product.jpg')}}')">
               <div class="container">
                   <div class="row align-items-center justify-content-center">
                       <div class="col-md-7 text-center aos-init " data-aos="fade">
                           <h1 class="service-banner-header">Product Category</h1>
                           <p>{{$productCategory->title}} Lists</p>
                       </div>
                   </div>
               </div>
           </div>
       </main>
       
       <div class="container-fluid">
           <div class="property-single-list">
       
               {{-- Main Row start --}}
               <div class="row">
                   <div class="col-lg-3">
                       <div class="product-search-bar">
                           <h4>Advanced Filter</h4>
                           <div class="main">
                               {!! Form::open(array('route'=>'product.search','class'=>'form-inline')) !!}
                               <input type="hidden" name="category" value="{{$productCategory->id}}" />
                               <div class="form-group">
                                   <input type="text" name="category_id" class="form-control" placeholder="    Search by category" id="search-form-input"  style="padding: 8px !important;">
                                   <div class="productId"></div>
                               </div>
                               <div class="form-group">
                                   <input type="text" name="title" placeholder="   Product title" class="form-control" id="search-form-title" style="padding: 8px !important;">
                               </div>
                               <div class="search-by-price">
                                   <h4>Filter By Price</h4>
                               </div>
                               <div class="row">
                                   <div class="col-lg-12">
                                       <div class="form-group ">
                                           <div class="checkbox">
                                               <label><input class="" name="lowest" type="checkbox" value="">Lowest To Highest</label>
                                           </div>
                                           <div class="checkbox">
                                               <label><input class="" name="higest" type="checkbox" value=""> Highest To Lowest </label>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <div class="row">
                                   <div class="col-lg-6">
                                       <div class="form-group ">
                                           <input id="property-lowest" name="low" class="form-control " type="number"
                                           placeholder="From">
                                       </div>
                                   </div>
                                   <div class="col-lg-6">
                                       <div class="form-group ">
                                           <input id="property-higest" name="high" class="form-control " type="number"
                                           placeholder="To">
                                       </div>
                                   </div>
                               </div>
                               <button type="submit" id="product-search-submit-btn" class="btn btn-default">Submit</button>
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
                           @foreach( $products as $product)
                           <div class="col-md-3 col-lg-4">
       
                               <div class="card">
                                   @if(file_exists('storage/'. $product->image) &&  $product->image != '')
                                   <img class="card-img-top" src="{{asset('storage/'. $product->image)}}"
                                   alt="{{ $product->title}}">
                                   @endif
                                   <div class="overlay">
                                       <div class="text">
                                           <a href="{{route('product.show',[$product->slug])}}">View More</a>
                                       </div>
                                   </div>
                                   <div class="card-body">
                                       <div class="card-title-product">
                                           <span>  {{$product->title}}</span>
                                           <span><strong>Rs</strong>{{number_format($product->price)}} {{$product->unit}}</span>
                                           {{--<span><i class="fa fa-clipboard"></i>{{$product->quantity}}</span>--}}
                                       </div>
                                       {{--<a href="{{route('product.show',[$product->slug])}}" class="btn btn-info">View Details</a>--}}
                                   </div>
       
                               </div>
       
                           </div>
                           @endforeach
       
       
                       </div>
       
                       <nav aria-label="Page navigation example mx-auto" style="width: 340px; margin:0 auto;">
                           {{   $products->links('vendor.pagination.default') }}
                       </nav>
                   </div>
               </div>
               {{-- Main Row end --}}
       
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
   {{--</div>--}} -->
   @endsection
   @section('js_script')
   <script type="application/javascript">
    $(document).ready(function () {

    });
</script>

@endsection