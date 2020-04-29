@extends('layouts.backend.app')
@section('content')
    <div class="container">
        <div class="login-wrapper">
            <div class="row">
                <div class="col-lg-7">
                    <div class="left-wrapper register">
                        <div class="login-left-header">
                            <h3>Register to zillicom Explore intivite Possibllities to buy/sale</h3>
                        </div>


                        <span>Why to register ?</span>
                            <ul class="register-list">

                                <li>You can easily sale your  own product from home </li>
                                <li>You can sale rent or buy land </li>
                                <li>You can sale rent or buy home </li>
                                <li>oR you can work as expertise</li>
                                <li>It easy to get different service from home</li>
                                <li>You can also work from here if you have different skills </li>

                            </ul>

                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="login-right-wrapper register-form">
                        <span class="right-header-headding">Register</span>
                        <div class="right-form ">
                            {!! Form::open(array('route'=>'register.store', 'method'=>'post')) !!}
                            <div class="form-group has-feedback row ">
                                <label class="col-lg-3">Name</label>
                                <div class="col-lg-9">
                                <input type="text" name="name" class="form-control" placeholder="Name"
                                       value="{{ old('name') }}">
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                @if ($errors->has('name'))
                                    <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                                @endif
                                </div>
                            </div>
                            <div class="form-group has-feedback row">
                                <label class="col-lg-3">Email</label>
                                    <div class="col-lg-9">
                                <input type="email" name="email" class="form-control" placeholder="Email"
                                       value="{{ old('email') }}">
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                @if ($errors->has('email'))
                                    <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                                @endif
                                        </div>
                            </div>
                            <div class="form-group has-feedback row">
                                <label class="col-lg-3">Contact</label>
                                <div class="col-lg-9">
                                <input type="number" name="contact" class="form-control" placeholder="Contact"
                                       value="{{ old('contact') }}">
                                <span class="glyphicon glyphicon-phone-alt form-control-feedback"></span>
                                @if ($errors->has('contact'))
                                    <div class="alert alert-danger">{{ $errors->first('contact') }}</div>
                                @endif
                                </div>
                            </div>

                            <div class="form-group has-feedback row">
                                <label for="" class="col-lg-3">Address</label>
                                <div class="col-lg-9">
                                <input type="text" name="address" class="form-control" placeholder="Address"
                                       value="{{ old('address') }}">
                                <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                                @if ($errors->has('address'))
                                    <div class="alert alert-danger">{{ $errors->first('address') }}</div>
                                @endif
                                </div>
                            </div>
                            <div class="form-group has-feedback row">
                                <label for="" class="col-lg-3">Password</label>
                                <div class="col-lg-9">
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                       value="{{ old('password') }}">
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                @if ($errors->has('password'))
                                    <div class="alert alert-danger">{{ $errors->first('password') }}</div>
                                @endif
                                </div>
                            </div>
                            <div class="form-group has-feedback row">
                                <label for="" class="col-lg-3"> Confirm </label>
                                <div class="col-lg-9">
                                <input type="password" name="confirm-password" class="form-control"
                                       placeholder="Confirm Password" value="{{ old('confirm-password') }}">
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                @if ($errors->has('confirm-password'))
                                    <div class="alert alert-danger">{{ $errors->first('confirm-password') }}</div>
                                @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="login-footer">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat">Register
                                        </button>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="login-footer-btn">
                                        <p>Already Registered  ?</p>
                                        <a href="{{route('login')}}">Login</a>
                                    </div>
                                    <a href="{{route('forgetpassword')}}" style="margin-top: 10px;" class="register-footer">forget Password ?</a>

                                </div>
                                {{--<div class="col-xs-4">--}}
                                    {{--<div class="checkbox icheck">--}}
                                        {{--<button type="submit" class="btn btn-primary btn-block btn-flat">Sign Up--}}
                                        {{--</button>--}}

                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-xs-8">--}}
                                    {{--<a href="{{route('login')}}" style="margin-top: 10px;"--}}
                                       {{--class="btn btn-success btn-block btn-flat">Already Have acoount</a>--}}

                                {{--</div>--}}
                                <!-- /.col -->

                                <!-- /.col -->
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
