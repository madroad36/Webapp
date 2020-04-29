@extends('frontend.app')
@section('title', 'Service Category List')
@section('main-content')
 
<div class="container-fluid">
    <div class="row mt-4">
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
                              {!! Form::open(array('route'=>'service.search')) !!}
                              <div class="form-group">
                                <label>Service Category</label>
                                <input type="text" name="category" id="service-category" class="form-control"
                                placeholder="Search by Category" id="search-form-input">
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title" id="service-title" placeholder="Service Title"
                                class="form-control" id="search-form-title">
                            </div>
                            <button type="submit" id="product-search-submit-btn" class="btn btn-primary">Submit</button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Product Listing --}}
        <div class="col-md-9">
            <section class="properties">
                <div class="home-display">
                    {{-- Page title --}}
                    <div class="title">
                        <div class="row">
                            <div class="col-6">
                                <h2>Services</h2>
                            </div>
                        </div>
                    </div>
                    @if(!empty($message))
                    {{$message}}
                    @endif
                    @if($categories->isEmpty())
                    <p style="margin-left: 50px; color: red;">Result not found</p>
                    @endif
                    {{-- product listing --}}
                    <div class="content pt-3">
                        <div class="row">
                            @if(isset($categories))
                            @foreach($categories as $service)
                            <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                                <a href="{{route('category.show',[$service->slug])}}">
                                    <div class="box">
                                        @if(file_exists('storage/'.$service->image) && $service->image !='')
                                        <img src="{{asset('storage/'.$service->image)}}" alt="{{$service->name}}">
                                        @else
                                        <img src="{{asset('frontend/img/refrigerator.jpg')}}" alt="Avatar" class="image">
                                        @endif
                                        <div class="overlay-img"></div>
                                        <h4 class="text">{{ucfirst($service->name)}}</h4>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>

                    <nav aria-label="Page navigation example mx-auto" style="width: 400px; margin:0 auto;">
                        {{  $categories->links('vendor.pagination.default') }}

                    </nav>
                </div>
            </section>
        </div>    
    </div>
</div>
  <!--   <main role="main">
  
      Main jumbotron for a primary marketing message or call to action
      <div class="service-banner-image " style="background: url('{{asset('frontend/img/service.png')}}')">
          <div class="container">
              <div class="row align-items-center justify-content-center">
                  <div class="col-md-7 text-center aos-init " data-aos="fade">
                      <h1 class="service-banner-header">Service</h1>
                      <p> Category List </p>
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
              @if(!empty($message))
              {{$message}}
              @endif
              @if($categories->isEmpty())
              <p style="margin-left: 50px; color: red;">Result not found</p>
              @endif
                  <div class="row">
                  @foreach($categories as $service)
                      <div class="col-xs-12 col-md-4 col-lg-3">
  
                          <a href="{{route('category.show',[$service->slug])}}" class="service-name">
                              <div class="service-listing-wrap">
                                  @if(file_exists('storage/'.$service->image) && $service->image !='')
                                      <img src="{{asset('storage/'.$service->image)}}" alt="{{$service->name}}">
                                  @endif
                                  <div class="overlay">
                                      <div class="text">{{ucfirst($service->name)}}</div>
                                  </div>
                              </div>
                          </a>
                      </div>
                  @endforeach
              </div>
          </div>
  
          <nav aria-label="Page navigation example mx-auto" style="width: 400px; margin:0 auto;">
              {{  $categories->links('vendor.pagination.default') }}
  
          </nav>
      </div>
  </div>
  <div class="clear-fix"></div>
  <div class="clear-fix"></div>
   -->
@endsection
@section('js_script')

    <script type="text/javascript">


    </script>

@endsection