<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Bhupendra Sapkota">
    <link rel="icon" href="{{asset('frontend/img/favicon.png')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="canonical" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.3.0/css/all.css">

    <!-- Bootstrap core CSS -->
    <link href="{{asset('css/profile.css')}}" rel="stylesheet">

    {{-- font-awesome --}}
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{asset('frontend/css/owl.carousel.css')}}" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.css"
    integrity="sha256-a2tobsqlbgLsWs7ZVUGgP5IvWZsx8bTNQpzsqCSm5mk=" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prettyPhoto/3.1.6/css/prettyPhoto.css"
    integrity="sha256-anKqsNPTTlbt8ji5cRlPbdHLdtpkIInxgXfAnAH90mU=" crossorigin="anonymous"/>
    <!-- Custom styles for this template -->

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('backend/bower_components/morris.js/morris.css')}}">

    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">


    <!-- Google Font -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
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
                        @endif
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
                    <img src="{{asset('frontend/img/zillicom_logo.svg')}}" alt="logo-image" style="height: 100%; width:100px;">
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
                    <a href="{{route('cart.index')}}" id="home-cart" class="justify-content-end">
                        <strong>Cart </strong><i class="fa fa-shopping-cart"></i>
                        @if(!empty($data->items))
                            <span class="badge">{{count($data->items)}}</span>
                        @endif
                    </a>
                </div>
                </div>
            </div>
        </nav>
    </header>

<div class="clearfix"></div>
<div class="container-fluid">
    <div class="profile-page-details my-4">
        <div class="row">
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                <div class="card p-3">
                    <div class="profile-image d-flex justify-content-center">
                        @if(file_exists('storage/'.auth()->user()->image) && auth()->user()->image != '')
                        <img src="{{asset('storage/'.auth()->user()->image)}}" class="rounded-circle img-fluid"
                        alt="{{auth()->user()->name}}">
                        @else
                        <img src="{{asset('backend/dist/img/avatar.png')}}" class="rounded-circle img-fluid"
                        alt="{{auth()->user()->name}}">
                        @endif
                        @if(Auth::user()->service =='1')
                        @endif
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <button class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target=".profile-update"
                        id="profile-update-btn">Profile Update</button>
                    </div>
                    <div class="line"></div>
                    <div class="status">
                            <strong>Status:</strong>
                            @if(Auth::user()->is_active =='1')
                            <span class="verify">Verified</span>
                            @else
                            <span class="not-varify">Not Verified </span>
                            @endif
                    </div>
                    <div class="status">
                            <strong>Role:</strong>
                            @if(empty($broker) && empty($vendor) && empty($technician) )
                            Not assigned yet
                            @else
                            You are assigned as-
                            <!-- Broker -->
                            @if(!empty($broker))
        
                            @if($broker->is_active != 1)
                            <span class="not-varify">Broker-not-approved </span>
                            @else
                            <span class="verify">Broker </span>
                            @endif
                            @endif
        
                            <!-- Vendor -->
                            @if(!empty($vendor))
        
                            @if($vendor->is_active != 1)
                            <span class="not-varify">Vendor-not-approved </span>
                            @else
                            <span class="varify">Vendor </span>
                            @endif
                            @endif
        
                            <!-- Technician -->
                            @if(!empty($technician))
                            @if($technician->is_active != 1)
                            <span>Service Provider-not-approved </span>
                            @else
                            <span>Service Provider</span>
                            @endif
                            @endif
                            @endif
                    </div>
                 </div>
                @include('profile.profile')
                @include('profile.broker.edit')
                @include('profile.message')
                @include('profile.vendor.edit')
                @include('profile.technician.edit')
            </div>
            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                <div class="profile-details">
                 <h3> Hi {{ucfirst(Auth::user()->name)}} ! <span>Welcome to Zillicom</span></h3> 
             </div>
            <div class="profile-status-full-width">
                <div class="profile-status-nav">
                    <div class="jumbotron" style="background: url({{asset('frontend/img/earn-with-zillicom.jpg')}}) fixed;">
                        <div class="container">
                            <div class="jumbotron-content">
                                <div class="title">
                                    <small>be with us</small>
                                    <h2 class="jumbotron-heading">Do you Know ?</h2>
                                </div>
                                <div class="content">
                                    <h3 class="jumbotron-heading-two">You can Earn with Zillicom</h3>
                                    <p>Property broker, Product seller or Service provider</p>
                                </div>
                                <a 
                                    href="javascript:void(0)" 
                                    class="btn btn-primary" 
                                    data-toggle="modal"
                                    data-target="#user-service">
                                    Start Earning
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="user-service" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Please Select The Role</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-xs-12 col-md-4 col-lg-4">
                                        <div class="service-provider-form">
                                            @if(!empty($broker))
                                            @if($broker->is_active == '1')
                                            <a href="javascript:void(0)" class="btn">Broker <i
                                                class="fa fa-check-circle"></i></a>
                                                @else
                                                <a href="javascript:void(0)" class="btn">Broker <i class="fa fa-spinner" aria-hidden="true"></i></a>

                                                @endif
                                                @else
                                                <a href="javascript:void(0)" data-toggle="modal"
                                                data-target=".create-broker"
                                                class="btn btn-broker">Broker </a>

                                                @endif
                                                @include('profile.broker.create')
                                                @include('profile.broker.message')
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-4 col-lg-4">
                                            <div class="service-provider-form">
                                                @if(!empty($vendor))

                                                @if($vendor->is_active == '1')
                                                <a href="javascript:void(0)" class="btn">Vendor <i
                                                    class="fa fa-check-circle"></i></a>
                                                    @else
                                                    <a href="javascript:void(0)" class="btn">Vendor <i class="fa fa-spinner" aria-hidden="true"></i></a>
                                                    @endif
                                                    @else
                                                    <a href="javascript:void(0)" class="btn btn-vendor"
                                                    data-toggle="modal" data-target=".create-vendor">Vendor</a>
                                                    @endif
                                                    @include('profile.vendor.create')
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-md-4 col-lg-4">
                                                <div class="service-provider-form">
                                                    @if(!empty($technician))
                                                    @if($technician->is_active == '1')
                                                    <a href="javascript:void(0)" class="btn">Technician <i
                                                        class="fa fa-check-circle"></i></a>
                                                        @else
                                                        <a href="javascript:void(0)" class="btn">Technician <i class="fa fa-spinner" aria-hidden="true"></i></a>
                                                        @endif
                                                        @else
                                                        <a href="javascript:void(0)" data-toggle="modal"
                                                        data-target=".create-technician" class="btn btn-technician">Technician</a>
                                                        @endif
                                                        @include('profile.technician.create')
                                                        @include('profile.technician.message')
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="profile-chart">
        <div class="container">
            <div class="row">

                <div class="col-xs-3 col-md-3 col-lg-2">
                    <ul id="accordion">
                        <li><span>Property</span>
                            <div>
                                <ul>
                                    <li><a href="#" data-toggle="modal" data-target=".add-property">Add Property</a></li>
                                    <li><a href="{{route('owner.property.index')}}">My List</a></li>
                                    <li><a href="{{route('ordered.property')}}">My Orderd </a></li>

                                    @if($broker != '' && $broker->is_active ==1 )
                                    <li><a href="{{route('broker.property.index')}}">Broker List</a></li>
                                    @endif
                                </ul>

                            </div>
                        </li>
                        <li>
                            <span>Product</span>
                            <div>
                                <ul>
                                    @if($vendor != '' && $vendor->is_active ==1 )
                                    <li><a href="#" data-toggle="modal" data-target=".add-product">Add Product</a></li>
                                    @endif
                                    <li><a href="{{route('owner.product.index')}}">My List</a></li>
                                    <li><a href="{{route('order.product')}}">My Order</a></li>
                                    <li><a href="{{route('sold.product')}}">Selling Report</a></li>
                                </ul>
                            </div>

                        </li>

                        <li><span>Service</span>
                            <div>
                                <ul>
                                    @if( $technician != '' && $technician->is_active == 1)
                                    <li><a href="{{route('servicerequest.technician')}}">My Assign</a></li>
                                    @endif
                                    <li><a href="{{route('servicerequest.index')}}">My Order </a></li>
                                </ul>
                            </div>


                        </li>

                    </ul>
                </div>
                <div class="col-xs-9 col-md-9 col-lg-10">
                    @yield('main-content')
                </div>

            </div>
        </div>
    </div>
    @include('profile.product.form')
    @include('profile.product.image')
    @include('profile.product.message')
    @include('profile.product.gallery')
    @include('profile.property.create')
    @include('profile.property.image')
    @include('profile.property.message')

    <div id="overlay-load">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>

  
<footer class="page-footer pt-4">
    <div class="footer-top-image"></div>
    <div class="container-fluid">
        <div class="row  px-3  pt-5">
            <div class="col-md-3 col-6">
                <div class="title text-center">
                    <img src="{{asset('frontend/img/zillicom_logo.svg')}}" alt="logo-image" style="height: 100%; width:100px;">
                </div>
                <ul class="list-unstyled">
                    <li><i class="fa fa-envelope" aria-hidden="true"><span class="pl-3">info.zillicom@gmail.com</span></i></li>
                    <li><i class="fa fa-phone" aria-hidden="true"><span class="pl-3">+977-9843188753</span></i></li>
                    <li><i class="fa fa-address-book" aria-hidden="true"><span class="pl-3">Baneshwor, Kathmandu</span></i></li>
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
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>--}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js"></script>
    <script src="{{asset('js/profile.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>

    {{--<script src="{{asset('frontend/js/jquery.min.js')}}"></script>--}}

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prettyPhoto/3.1.6/js/jquery.prettyPhoto.js"></script>

    {{--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>--}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>

    <script src="{{asset('frontend/js/custom.js')}}"></script>


    <script src="{{asset('frontend/js/owl.carousel.js')}}"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>

    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script src="{{asset('frontend/js/design.js')}}"></script>
    <script src="{{asset('frontend/js/service.js')}}"></script>
    <script src="{{asset('frontend/js/location.js')}}"></script>
    <script src="{{asset('frontend/js/broker.js')}}"></script>
    <script src="{{asset('frontend/js/vendor.js')}}"></script>
    <script src="{{asset('frontend/js/technician.js')}}"></script>
    <script src="{{asset('frontend/js/profile.js')}}"></script>
    <script src="{{asset('js/property.js')}}"></script>
    <script src="{{asset('frontend/js/product.js')}}"></script>
    <link rel="stylesheet" href="{{asset('backend/custom.css')}}">
    @yield('js_script')
    <script type="text/javascript">

        var baseUrl = '{!! url('') !!}';

        $('.modal').modal('hide');
        $('body').removeClass('modal-open');
        $(".modal").appendTo("body");

        $(document).ready(function () {
            $("#accordion > li > span").click(function() {
                $(this).closest('li').siblings().find('span').removeClass('active').next('div').slideUp(250);
                $(this).toggleClass("active").next('div').slideToggle(250);
            });

            $(window).load(function () {

                $('#progressbar li ').removeClass('active');
                $('#progressbar li ').removeClass('finish');
                $("#progressbar li:first-child").addClass('active');
            // document.getElementById("prevBtn").style.display = "none";
            $("#nextBtn").innerHTML = "Next";
            $(".modal #first").css('display', 'block');
            // console.log($("fieldset #first"));
            $(".modal #prevBtn").css('display', 'none');

        });


            $('.dropdown').click(function (event) {
                event.stopPropagation();
            });


            $("a[rel^='prettyPhoto']").prettyPhoto();

            $(".property-list .nav-tabs a").click(function (e) {
                e.preventDefault()
                $('.tab-content .tab-pane').removeClass('active');
                $('.tab-content .tab-pane').removeClass('show');
                var id = $(this).attr('data-type');
                $('.tab-content #' + id).tab('show');
                $('.tab-content #' + id).addClass('active');
            });
            $('.owl-carousel').owlCarousel({
                loop: true,
                autoplayTimeout: 2000,
                autoplayHoverPause: true,
                margin: 0,
                dots: false,
                autoWidth: false,
                responsiveClass: true,
                nav: true,
                navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
                pagination: true,
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
        })

        $(document).ready(function () {
            var editor_config = {
                path_absolute: "http://localhost:8000/",
                images_upload_credentials: true,
                selector: ".editor[name=description] ,.mini-editor[name=short_description]",

                plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
                relative_urls: false,
                file_browser_callback: function (field_name, url, type, win) {
                    var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                    var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

                    var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                    if (type == 'image') {
                        cmsURL = cmsURL + "&type=Images";
                    } else {
                        cmsURL = cmsURL + "&type=Files";
                    }

                    tinyMCE.activeEditor.windowManager.open({
                        file: cmsURL,
                        title: 'Filemanager',
                        width: x * 0.8,
                        height: y * 0.8,
                        resizable: "yes",
                        close_previous: "no",

                    });
                },

            //  Add Bootstrap Image Responsive class for inserted images
            image_class_list: [
            {title: 'None', value: ''},
            {title: 'Bootstrap responsive image', value: 'img-responsive'},
            ]

        };

        tinymce.init(editor_config);


        $('.modal').on('click', '.close-modal', function (e) {
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
            $('#prevBtn').css('display', 'none');
            $('#nextBtn').innerHTML = "Next";

            $(' #first').css('display', 'block');
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
    });


    // var OneSignal = window.OneSignal || [];
    // OneSignal.push(function () {
    //     OneSignal.init({
    //         appId: "f04be9cf-7553-42dc-8a7d-0faa61b2811c",
    //     });

    {{--OneSignal.isPushNotificationsEnabled(function (isEnabled) {--}}
        {{--if (isEnabled) {--}}
    {{--// user has subscribed--}}
    {{--OneSignal.getUserId(function (userId) {--}}
        {{--var app_id = userId;--}}
        {{--console.log(app_id)--}}
        {{--$.ajax({--}}
            {{--headers: {--}}
            {{--'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
            {{--},--}}
            {{--url: '{{route('device.store')}}',--}}
            {{--type: 'POST',--}}
            {{--data: {--}}
            {{--'device_id': app_id--}}
            {{--},--}}
            {{--dataType: 'json',--}}
            {{--success: function (response) {--}}

            {{--}--}}
            {{--});--}}
        {{--});--}}
    {{--}--}}
    {{--});--}}


    // });


    // $('.image-upload-btn').on('click',function(){
    //
    //
    // });


    /// this is for the borker  jquery


</script>


</body>
</html>
