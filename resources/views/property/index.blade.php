@extends('frontend.app')
@section('title', 'Property List')
@section('main-content')

<div class="container-fluid">
    <section class="product-category">
        <div class="home-display py-3">
            <div class="content pt-3">
                <ul id="productCategory">
                    @if(count($categories) > 0)
                    @foreach($categories as $category)
                    <li>
                        <a href="{{url('/property/'.$category->slug)}}">
                            <div class="box">
                                <img src="{{asset('frontend/img/furniture.jpg')}}" alt="Avatar" class="image">
                                <div class="overlay"></div>
                                <h4 class="text">{{$category->name}}</h4>
                            </div>
                        </a>
                    </li>
                    @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </section>
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
                                        <label><input class="" name="lowest" type="checkbox" value=""> Lowest To Highest</label>
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
                                <h2>Properties</h2>
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
                            @if(count($properties) > 0)
                            @foreach($properties as $property)
                            <div class="col-6 col-sm-6 col-md-4 col-lg-4 py-2">
                                <div class="row">
                                    <div class="col-12">
                                      <a href="{{route('property.show',[$property->slug])}}">
                                        <div class="card">
                                          <div class="card-image">
                                            <div class="card-notify">
                                              <ul class="list-unstyled">
                                                <li class="premium">Premium</li>
                                                <li class="sale">Sale</li>
                                              </ul>
                                            </div>
                                            @if(file_exists('storage/'. $property->thumbnail) &&  $property->thumbnail != '')
                                            <img class="card-img-top" style=" height:200px;"
                                            src="{{asset('storage/'. $property->thumbnail)}}" alt="{{ $property->title}}">
                                            @else
                                            <img class="img-fluid" src="{{asset('frontend/img/house1.jpg')}}" alt="Alternate Text" />
                                            @endif
                                          </div>
                                          
                                          <div class="card-body">
                                            <div class="title">
                                              <h3>{{$property->title}}</h5>
                                                <div class="sub-title">
                                                  <i class="fas fa-map-marker-alt"></i><strong>{{$property->place->name}},{{$property->location->name}} </strong><br>
                                                  <i class="fas fa-ruler-combined"></i><strong>{{$property->area}} / {{$property->land_unit}}</strong>
                                                </div>
                                              </div>
                                              @if($property->category_id != 2)
                                              <div class="features">
                                                <ul class="list-unstyled list-inline">
                                                  <li class="list-inline-item">
                                                    <i class="fas fa-bed"></i><span>3</span>
                                                  </li>
                                                  <li class="list-inline-item">
                                                    <i class="fas fa-car"></i><span>1</span>
                                                  </li>
                                                  <li class="list-inline-item">
                                                    <i class="fas fa-couch"></i><span>1</span>
                                                  </li>
                                                  <li  class="list-inline-item">
                                                    <i class="fas fa-toilet"></i><span>2</span>
                                                  </li>
                                                  <li  class="list-inline-item">
                                                    <i class="fas fa-utensils"></i><span>1</span>
                                                  </li>
                                                </ul>
                                              </div>
                                              @endif
                                              <div class="price">
                                                <strong>Rs: {{$property->price}} /-</strong>
                                              </div>
                                            </div>
                                          </div>
                                      </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <strong> No Property To Display. </strong>
                            @endif
                        </div>
                        {{-- pagination --}}
                        <nav>
                            @if(count($properties) > 0)
                            {{  $properties->links() }}
                            @endif
                        </nav>
                    </div>
                </div>
            </section>
        </div>    
    </div>
</div>

@endsection
@section('js_script')
    <script type="text/javascript">

        $('input:checkbox').click(function() {
            $('input:checkbox').not(this).prop('checked', false);
            $(this).val(this.checked ? 1 : 0);
        });
        $(window).on('hashchange', function () {
            if (window.location.hash) {
                var page = window.location.hash.replace('#', '');
                var pageNumber = $("#properties-lists option:selected").val();
                var slug = '{{ Request::segment(2) }}';
                debugger
                if (page == Number.NaN || page <= 0) {
                    return false;
                } else {
                    $.ajax(
                        {
                            url: '/property/' + slug + '/?page=' + page,
                            type: "get",
                            data: {slug: slug, item: pageNumber},
                            datatype: 'html',
                            success: function (properties) {
                                event.preventDefault();

                                $('.search-property-list-home').html(properties);

                            },
                            error: function (data) {

                            }

                        }).fail(function (jqXHR, ajaxOptions, thrownError) {
                        alert('No response from server');
                    });
                }
            }
        });
        $('#properties-lists').on('change', function () {
            var pageNumber = $(this).val();
            var slug = '{{ Request::segment(2) }}';
            var url = '/property/' + slug;
            $.ajax({
                type: 'get',
                url: url,
                data: {slug: slug, item: pageNumber},
                dataType: 'html',
                success: function (properties) {

                    $('.search-property-list-home').html(properties);

                },
                error: function (data) {

                }
            });
        });

        var rangeSlider = function () {
            var slider = $('.range-slider'),
                range = $('.range-slider__range'),
                value = $('.range-slider__value');

            slider.each(function () {

                value.each(function () {
                    var value = $(this).prev().attr('value');
                    $(this).html(value);
                });

                range.on('input', function () {
                    $(this).next(value).html(this.value);
                });
            });
        };

        rangeSlider();


    </script>
@endsection
