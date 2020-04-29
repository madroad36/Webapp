<?php
header("Cache-Control: no-store, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Zillicom">
    <link rel="icon" href="{{asset('frontend/img/favicon.png')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet"> 
    <!-- Bootstrap core CSS -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    
    {{-- Font Awesome Min --}}
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    
    {{-- owl carousel --}}
    {{-- <link href="{{asset('frontend/css/owl.carousel.css')}}" rel="stylesheet" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.min.css" /> --}}

    {{-- Pretty Photo --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prettyPhoto/3.1.6/css/prettyPhoto.css" integrity="sha256-anKqsNPTTlbt8ji5cRlPbdHLdtpkIInxgXfAnAH90mU=" crossorigin="anonymous" />

    <!-- Js CSS -->    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('backend/bower_components/morris.js/morris.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.min.css">
    <link rel="stylesheet" href="https://trentrichardson.com/examples/timepicker/jquery-ui-timepicker-addon.css">
</head>
<body>
    <header> 
        <div class="container-fluid top-bar">
            <div class="row align-item-center">
                {{-- left top-bar --}}
                <div class="col-6 top-header-text">
                    <p class="my-3">
                        Need Help? Call US: <Strong>+977-04123568</Strong>
                    </p>
                </div>
                <div class="col-6 text-right">
                    {{-- right top-bar --}}
                    <div class="top-header-text">
                        @if(Auth::check())
                        <div class="my-2 btn-group">
                            <button class="btn border dropdown-toggle" 
                            data-toggle="dropdown"
                            aria-haspopup="ture"
                            aria-expanded="false">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item text-right" href="{{route('view.profile')}}">View Profile</a>
                            <a class="dropdown-item text-right" href="{{route('logout')}}">Logout</a>
                        </div>
                    </div>
                    @else
                    <p class="my-3 justify-content-center">
                        <a class="px-2" href="{{url('/login')}}" data-toggle="modal" data-target="#login">Login</a>
                        {{-- <a  class="px-1"  href="{{url('register')}}">Register</a> --}}
                        <a class="px-1" href="#!" data-toggle="modal" data-target="#register">Register</a>
                    </p>
                    @endif
                </div>

                {{-- Pop up Register --}}
                <div class="modal fade text-left" id="register" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            {{-- Modal Title --}}
                            <div class="modal-header">
                                <div class="title align-self-center">
                                    <span>Register to Zillicom</span>
                                </div>
                                <button type="button" class="close-modal" data-dismiss="modal" aria-hidden="true">
                                    <i class="far fa-times-circle"></i>
                                </button>
                            </div>

                            {{-- register --}}
                            <div class="container modal-body">
                                <div class="row flex-column-reverse flex-md-row">
                                    {{-- Why to register information --}}
                                    <div class="col-lg-6 mt-4">
                                        <div class="register-header">
                                            <h3 class="mb-4">Explore intivite Possibllities to buy/sale</h3>
                                            <span>Why to register ?</span>
                                        </div>
                                        <ul class="register-list">
                                            <li>You can easily sale your  own product from home </li>
                                            <li>You can sale rent or buy land </li>
                                            <li>You can sale rent or buy home </li>
                                            <li>you can work as expertise</li>
                                            <li>Easy to get different service from home</li>
                                            <li>You can also work from here if you have different skills </li>
                                        </ul>
                                    </div>
                                    {{-- Register Form --}}
                                    <div class="col-lg-6 mt-4">
                                        <div class="register-form">
                                            {!! Form::open(array('route'=>'register.store', 'method'=>'post')) !!}

                                            {{-- Full Name --}}
                                            <div class="col-md-10 col-lg-10 mb-4">
                                                <div class="input-group has-feedback"> 
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                    </div>
                                                    <input type="text" name="name" class="form-control" placeholder="Name"
                                                    value="{{ old('name') }}">
                                                </div>
                                                @if ($errors->has('name'))
                                                <div class="invalid">{{ $errors->first('name') }}</div>
                                                @endif
                                            </div>

                                            {{-- Email --}}
                                            <div class="col-md-10 col-lg-10 mb-4">
                                                <div class="input-group has-feedback"> 
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                    </div>
                                                    <input type="email" name="email" class="form-control" placeholder="Email"
                                                    value="{{ old('email') }}">
                                                </div>
                                                @if ($errors->has('email'))
                                                <div class="invalid">{{ $errors->first('email') }}</div>
                                                @endif
                                            </div>

                                            {{-- Number --}}
                                            <div class="col-md-10 col-lg-10 mb-4">
                                                <div class="input-group has-feedback"> 
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                                    </div>
                                                    <input type="tel" name="contact" class="form-control" placeholder="Contact"
                                                    value="{{ old('contact') }}">
                                                </div>
                                                @if ($errors->has('contact'))
                                                <div class="invalid">{{ $errors->first('contact') }}</div>
                                                @endif
                                            </div>

                                            {{-- Address --}}
                                            <div class="col-md-10 col-lg-10 mb-4">
                                                <div class="input-group has-feedback"> 
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                                    </div>
                                                    <input type="text" name="address" class="form-control" placeholder="Address"
                                                    value="{{ old('address') }}">
                                                </div>
                                                @if ($errors->has('address'))
                                                <div class="invalid">{{ $errors->first('address') }}</div>
                                                @endif
                                            </div>

                                            {{-- Password --}}
                                            <div class="col-md-10 col-lg-10 mb-4">
                                                <div class="input-group has-feedback"> 
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                    </div>
                                                    <input type="password" name="password" class="form-control" placeholder="Password"
                                                    value="{{ old('password') }}">
                                                </div>
                                                @if ($errors->has('password'))
                                                <div class="invalid">{{ $errors->first('password') }}</div>
                                                @endif
                                            </div>

                                            {{-- Confirm Password --}}
                                            <div class="col-md-10 col-lg-10 mb-4">
                                                <div class="input-group has-feedback"> 
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                    </div>
                                                    <input type="password" name="confirm-password" class="form-control"
                                                    placeholder="Confirm Password" value="{{ old('confirm-password') }}">
                                                </div>
                                                @if ($errors->has('confirm-password'))
                                                <div class="invalid">{{ $errors->first('confirm-password') }}</div>
                                                @endif
                                            </div>

                                            {{-- Register Footer --}}
                                            <div class="col-md-10 col-lg-10 mb-4">
                                                <div class="register-footer">
                                                    <div class="row">    
                                                        <div class="col-md-6">
                                                            <button id="registerSubmit" type="submit" class="btn btn-primary" data-toggle="modal" data-target="#register">Register
                                                            </button>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <span>Already Registered ?</span><br>
                                                            <span>
                                                                <i class="far fa-id-card"></i>
                                                                <a href="#!" data-toggle="modal" data-target="#login" data-dismiss="modal">Login</a>
                                                            </span><br>
                                                            <span>
                                                                <i class="far fa-question-circle"></i>
                                                                <a href="{{route('forgetpassword')}}" style="margin-top: 10px;" class="register-footer">
                                                                Forget Password ?</a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pop up Login --}}
                <div class="modal fade " style="" id="login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">

                            {{-- Modal Title --}}
                            <div class="modal-header">
                                <div class="title align-self-center">
                                    <span>Login to Zillicom</span>
                                </div>
                                <button type="button" class="close-modal" data-dismiss="modal" aria-hidden="true">
                                    <i class="far fa-times-circle"></i>
                                </button>
                            </div>

                            {!! Form::open(array('url'=>'login', 'method'=>'post','class'=>'login-modal')) !!}
                            <div class="modal-body">

                                {{-- Login Email --}}
                                <div class="input-group mb-3 has-feedback">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" class="form-control" placeholder="Email" id="email" name="email">
                                </div>
                                {{-- Login Password --}}
                                <div class="input-group mb-3 has-feedback">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                                </div>
                                {{-- Login Footer --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Sign in</button>
                                            {{-- <a href="{{route('register.index')}}"  class="btn btn-info">Sign up</a> --}}
                                            <a class="btn btn-info" href="#!" data-toggle="modal" data-target="#register" data-dismiss="modal">Register</a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="#!" class="text-right small">Forget password?</a>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a class="navbar-brand" href="{{route('home')}}">
                        @if(file_exists('storage/'.$setting->image) && $setting->image != '')
                        <img src="{{asset('storage/'.$setting->image)}}" alt="your image" style="height: 100%; width:100px;"/>
                        @else
                        <img src="{{asset('frontend/img/zillicom_logo.svg')}}" alt="logo-image" style="height: 100%; width:100px;">
                        @endif
                    </a>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto ml-auto mt-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link {{ (request()->segment(1) == 'property') ? 'active' : '' }}" href="#" id="navbardrop" data-toggle="dropdown">
                                    Properties
                                </a>
                                <div class="dropdown-menu"> 
                                    @foreach($categories as $category)
                                    <a class="dropdown-item" href="{{url('/property/'.$category->slug)}}">{{$category->name}}</a>
                                    @endforeach
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link {{ (request()->segment(1) == 'product') ? 'active' : '' }}" href="#" id="navbardrop" data-toggle="dropdown">
                                    Products
                                </a>
                                <div class="dropdown-menu">
                                    @foreach($productCategories as $product)
                                    <a class="dropdown-item" href="{{route('product.category.show',[$product->slug])}}">{{$product->title}}</a>
                                    @endforeach
                                </div>
                            </li>
                            <li class="nav-item "><a class="nav-link {{ (request()->segment(1) == 'service') ? 'active' : '' }}" href="{{route('service.index')}}">Services </a></li>

                            {{--<li class="nav-item active"><a class="nav-link" href="{{route('contact.index')}}">Contact Us </a></li>--}}       
                        </ul>
                        <a class="nav-link" href="{{route('view.profile')}}">
                            <button class="btn btn-primary">Free Listing</button>
                        </a>
                        <a href="{{route('cart.index')}}" id="home-cart" class="justify-content-end">
                            <strong>Cart </strong><i class="fa fa-shopping-cart"></i>
                            @if(!empty($data->items))
                            <span class="badge">{{count($data->items)}}</span>
                            @endif
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    @yield('main-content')

    <footer class="page-footer pt-4">
        <div class="footer-top-image"></div>
        <div class="container-fluid">
            <div class="row  px-3  pt-5">
                <div class="col-md-3 col-6">
                    <div class="title text-center">
                        @if($setting && file_exists('storage/'.$setting->image) && $setting->image != '')
                        <img src="{{asset('storage/'.$setting->image)}}" alt="your image" style="height: 100%; width:100px;"/>
                        @else
                        <img src="{{asset('frontend/img/zillicom_logo.svg')}}" alt="logo-image" style="height: 100%; width:100px;">
                        @endif
                    </div>
                    <ul class="list-unstyled">
                        @if($setting)
                        <li><i class="fa fa-envelope" aria-hidden="true"><span class="pl-3">{{$setting->email}}</span></i></li>
                        <li><i class="fa fa-phone" aria-hidden="true"><span class="pl-3">+{{$setting->contact}}</span></i></li>
                        <li><i class="fa fa-address-book" aria-hidden="true"><span class="pl-3">{{$setting->address}}</span></i></li>
                        @else
                        <li><i class="fa fa-envelope" aria-hidden="true"><span class="pl-3">info.zillicom@gmail.com</span></i></li>
                        <li><i class="fa fa-phone" aria-hidden="true"><span class="pl-3">+977-9843188753</span></i></li>
                        <li><i class="fa fa-address-book" aria-hidden="true"><span class="pl-3">Baneshwor, Kathmandu</span></i></li>
                        @endif
                    </ul>
                </div>
                <div class="col-md-2 col-6">
                    <div class="title">
                        <h5>About</h5>
                    </div>
                    <div class="content">
                        <ul class="list-unstyled">
                            <li> <a href="#">About us</a></li>
                            <li> <a href="#">Our Team</a></li>
                            <li> <a href="#">What we do?</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="title">
                        <h5>Quick Links</h5>
                    </div>
                    <div class="content">
                        <ul class="list-unstyled">
                            <li> <a href="#">Properties</a></li>
                            <li> <a href="#">Products</a></li>
                            <li> <a href="#">Services</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="title">
                        <h5>Important Links</h5>
                    </div>
                    <div class="content">
                        <ul class="list-unstyled">
                            <li> <a href="#">Terms and Conditions</a></li>
                            <li> <a href="#">Privacy Policy</a></li>
                            <li> <a href="#">Pricing Policy</a></li>
                            <li> <a href="#">Adding Properties Policy</a></li>
                            <li> <a href="#">Buying and Selling Guide</a></li>
                            <li> <a href="#">Payment Method</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="single">
                        <div class="title">
                            <h5>Subscribe Us</h5>
                        </div>
                        <div class="content">
                            <p>Subcribe to our email newsletter today  to receive updates on latest properties, products and services
                            </p>
                            <form action="#">
                                <div class="input-group">
                                    <input type="email" class="form-control" placeholder="Enter your email">
                                    <button class="btn btn-subscrive" type="submit"><i class="fa fa-chevron-right" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <hr><p>Image and information use in this website is strictly prohibited to copy or reproduce in any way <br>
                        Copy right 2019 | All right reserved. Site develop and maintance by Zillicom
                    </p>
                </div>
            </div>
        </div>
    </footer>

<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{asset('frontend/js/jquery.min.js')}}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prettyPhoto/3.1.6/js/jquery.prettyPhoto.js"></script>


    <script type="text/javascript" src="https://trentrichardson.com/examples/timepicker/jquery-ui-timepicker-addon.js"></script>
    <script type="text/javascript" src="https://trentrichardson.com/examples/timepicker/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
    <script type="text/javascript" src="https://trentrichardson.com/examples/timepicker/jquery-ui-sliderAccess.js"></script>

    {{--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>--}}


    <script src="{{asset('js/app.js')}}"></script>
    <script src="https://kit.fontawesome.com/79723e8ee0.js" crossorigin="anonymous"></script>
    <script src="{{asset('frontend/js/custom.js')}}"></script>
    <script src="{{asset('frontend/js/service.js')}}"></script>
    <script src="{{asset('frontend/js/design.js')}}"></script>
    <script src="{{asset('frontend/js/location.js')}}"></script>
    {{-- p --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker-en-CA.min.js"></script>


    @yield('js_script')
    <script type="text/javascript">

        var baseUrl = '{!! url('') !!}';
    // if (window.history && window.history.pushState) {
    //     // window.history.pushState('forward', null, './#forward');
    //     debugger
    //     $(window).on('popstate', function() {
    //         alert('hello test');
    //         window.location.reload();
    //
    //     });
    //
    // }

    $(document).ready(function() {
        $("#custom-search-input #property-search").autocomplete({

            source: function (request, response) {
                $.ajax({
                    url: "{{route('property_autocomplete')}}",
                    data: {
                        term: request.term
                    },
                    dataType: "json",
                    success: function (data) {
                        var resp = $.map(data, function (obj) {
                            console.log(obj.title);
                            return obj.title;
                        });

                        response(resp);
                    }
                });
            },
            minLength: 1
        });

        $('#location').on('change', function (event) {
            var value = $(this).val();
            var url = '{{route('place.getplace')}}';
            place(value, url)
            event.stopPropagation();
        });


        function place(value, url) {
            $.ajax({
                type: 'get',
                url: url,
                data: {location_id: value},
                dataType: 'json',
                success: function (response) {
                    if (response.success == true) {
                        var value = response.place;
                        var option = '';

                        $.each(value, function (key, value) {

                            option += '<option selected="selected" value="' + value.id + '">' + value.name + '</option:selectedoption>';
                        });

                        $('#place').html(option).show();
                    } else {
                        $('#place').empty();
                    }

                }
            });
        }
        $('.modal').modal('hide');
        $('body').removeClass('modal-open');
        $(".modal").appendTo("body");

        // $('.dropdown').click(function(event){
        //     event.stopPropagation();
        // });
        $("a[rel^='prettyPhoto']").prettyPhoto();

        $(".property-list .nav-tabs a").click(function(e){
            e.preventDefault()
            $('.tab-content .tab-pane').removeClass('active');
            $('.tab-content .tab-pane').removeClass('show');
            var id  = $(this).attr('data-type');
            $('.tab-content #'+id).tab('show');
            $('.tab-content #'+id).addClass('active');
        });
        $('.owl-carousel').owlCarousel({
            loop: true,
            autoplayTimeout:2000,
            autoplayHoverPause:true,
            margin:0,
            dots:false,
            autoWidth:false,
            responsiveClass: true,
            nav:true,
            navText : ['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
            pagination : true,
            paginationNumbers: true,
            responsive: {
                0: {
                    items: 1,
                },
                600: {
                    items: 1,
                },
                768: {
                    items: 2,
                },
                1000: {
                    items: 3,
                    margin: 0
                }
            }
        })
        $('.check-price').on('click',function(){
            $(this).not(':checked').prop('disabled', true)
        });
        $('.check-price').click(function(e) {
            e.preventDefault();
            e.stopPropagation();
        });
        $('input:checkbox').click(function() {
            $('input:checkbox').not(this).prop('checked', false);
            $(this).val(this.checked ? 1 : 0);
        });
        window.onload= function (){
            var value = $('#propety-category').text();
            var sub = $('#subcategory').text();
            category(value);
            subcategory(sub);
        }


        $('.modal').on('click','.close-modal',function(e)
        {
            e.preventDefault();

            // $('#progressbar li ').removeClass('finish');
            // $('#progressbar li ').removeClass('active');
            // $('#property-edit-popup')[0].reset();
            // $('#property-edit-popup ').find('#first .tab').css('display','block');
            // $('#progressbar li:first-child ').addClass('active finish');
            //     $('#property-edit #first').css('display','block');

            $('#progressbar li ').removeClass('active');
            $('#progressbar li ').removeClass('finish');
            $("#progressbar li:first-child").addClass('active');
            $('#prevBtn').css('display','none');
            $('#nextBtn').innerHTML = "Next";

            $(' #first').css('display','block');
            // var controlForm = $('.controls.rpt:first'),
            //     currentEntry = $(this).parents('.entry:first'),
            //     newEntry = $(currentEntry.clone()).appendTo(controlForm);
            //
            // newEntry.find('input').val('');
            // controlForm.find('.entry:not(:last) .btn-add')
            //     .removeClass('btn-add').addClass('btn-remove')
            //     .removeClass('btn-success').addClass('btn-danger')
            //     .html('Remove Friend');
            window.location.reload();
        });

    })
function category(value){

    if (value == 'House') {
        console.log(value);
        $('.house').show();
        $('.land').hide();
        $(".land :input").removeClass('form-input');
        $(".house :input").addClass('form-input');

    }
    if (value == 'Land') {
        console.log(value);
        $('.land').show();
        $('.house').hide();
        $(".house :input").removeClass('form-input');
        $(".land :input").addClass('form-input');



    }
}
function subcategory(sub) {

    if (sub == 'Rent') {
        $('.rent').show();
        $(".rent :input").addClass('form-input');
        $('.price').hide();
        $(".price :input").removeClass('form-input');


    }
    if (subcategory == 'Sale') {
        $('.rent').hide();
        $(".rent :input").removeClass('form-input');
        $('.price').show();
        $(".price :input").removeClass('form-input');

    }
}
</script>
@yield('js_script')

</body>
</html>
