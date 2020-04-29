@extends('frontend.app')
@section('title', 'Contact')
@section('main-content')

<div class="page-banner-image " style="background: url('{{asset('frontend/img/service.jpeg')}}')">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-7 text-center py-5">
                <h1>Contact us</h1>
                <span class="sub-heading">Any inquiry ? Contact us now</span>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="page mt-4"> 
        <div class="row">
            <div class="col-lg-6">
                {{-- Contact us --}}
                <div class="card my-3">
                    <div class="card-body contact-us">
                        <h4 class="page-heading">Contact us</h4>
                        @if($setting)
                        <div class="d-flex justify-content-around flex-wrap">
                            <div class="text-center">
                                <i class="fas fa-phone fa-2x mb-3" aria-hidden="true"></i>
                                <h6 class="text-uppercase mb-2">call us</h6>
                                <ul class="list-unstyled">
                                    <li>+{{$setting->contact}}</li>
                                    <!-- <li>+977-04123568</li> -->
                                </ul>
                            </div>
                            <div class="text-center">
                                <i class="fas fa-map-marker-alt fa-2x mb-3" aria-hidden="true"></i>
                                <h6 class="text-uppercase mb-2">address</h6>
                                <ul class="list-unstyled">
                                    <li>{{$setting->address}}</li>
                                    <!--  <li>Baneshwor</li> -->
                                </ul>
                            </div>
                            <div class="text-center">
                                <i class="fas fa-envelope fa-2x mb-3" aria-hidden="true"></i>
                                <h6 class="text-uppercase mb-2">Email</h6>
                                <ul class="list-unstyled">
                                    <li>{{$setting->email}}</li>
                                    <!-- <li>info@zillicom.com</li> -->
                                </ul>
                            </div>
                        </div>
                        @else
                        <div class="d-flex justify-content-around flex-wrap">
                            <div class="text-center">
                                <i class="fas fa-phone fa-2x mb-3" aria-hidden="true"></i>
                                <h6 class="text-uppercase mb-2">call us</h6>
                                <ul class="list-unstyled">
                                    <li>+977-04123568</li>
                                    <li>+977-04123568</li>
                                </ul>
                            </div>
                            <div class="text-center">
                                <i class="fas fa-map-marker-alt fa-2x mb-3" aria-hidden="true"></i>
                                <h6 class="text-uppercase mb-2">address</h6>
                                <ul class="list-unstyled">
                                    <li>Kathmandu</li>
                                    <li>Baneshwor</li>
                                </ul>
                            </div>
                            <div class="text-center">
                                <i class="fas fa-envelope fa-2x mb-3" aria-hidden="true"></i>
                                <h6 class="text-uppercase mb-2">Email</h6>
                                <ul class="list-unstyled">
                                    <li>info.zillicom@gmail.com</li>
                                    <li>info@zillicom.com</li>
                                </ul>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                {{-- Find us on and Social media --}}
                <div class="row">
                    {{-- Find us on --}}
                    @if($setting)
                    <div class="col-12 col-sm-6">
                        <div class="card my-3">
                            <div class="card-body find-us-on">
                                <h4 class="page-heading">Find us on</h4>
                                <div class="d-flex flex-column my-4 justify-content-center">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fab fa-viber fa-2x  mr-2" aria-hidden="true"></i> 
                                        + {{$setting->contact}}
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fab fa-facebook-messenger fa-2x  mr-2" aria-hidden="true"></i> 
                                       + {{$setting->contact}}
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fab fa-whatsapp fa-2x mr-2" aria-hidden="true"></i> + {{$setting->contact}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="col-12 col-sm-6">
                        <div class="card my-3">
                            <div class="card-body find-us-on">
                                <h4 class="page-heading">Find us on</h4>
                                <div class="d-flex flex-column my-4 justify-content-center">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fab fa-viber fa-2x  mr-2" aria-hidden="true"></i> 
                                        +977-12345678
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fab fa-facebook-messenger fa-2x  mr-2" aria-hidden="true"></i> 
                                        +977-12345678
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fab fa-whatsapp fa-2x mr-2" aria-hidden="true"></i> +977-12345678
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    {{-- Social Media --}}
                    <div class="col-12 col-sm-6">
                        <div class="card my-3">
                            <div class="card-body">
                                <h4 class="page-heading">Social Media</h4>
                                <div class=" d-flex m-2">
                                    <div class="mb-2">
                                        <a href="#!">
                                            <i class="fab fa-facebook fa-2x  mr-3" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                    <div class="mb-2"> 
                                        <a href="#!">
                                            <i class="fab fa-instagram fa-2x  mr-3" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                    <div class="mb-2"> 
                                        <a href="#!">
                                            <i class="fab fa-twitter fa-2x mr-3" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="contact-form">
                    <p><strong>Have any question ?</strong></p>
                    {!! Form::open(array('route'=>'contact.store','class'=>'','enctype'=>'multipart/form-data')) !!}
                    @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                    @endif
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}">
                        @if ($errors->has('name'))
                        <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                        @endif

                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('Email') }}">
                        @if ($errors->has('email'))
                        <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                        @endif

                    </div>
                    <div class="form-group">
                        <label>Contact</label>
                        <input type="text" name="contact" class="form-control" placeholder="Contact" value="{{ old('contact') }}">
                        @if ($errors->has('contact'))
                        <div class="alert alert-danger">{{ $errors->first('contact') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea type="text" name="message" class="form-control" rows="4" cols="50" placeholder="Message" value="{{ old('contact') }}"></textarea>
                        @if ($errors->has('message'))
                        <div class="alert alert-danger">{{ $errors->first('message') }}</div>
                        @endif

                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                    <!-- checkbox -->



                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js_script')
@endsection