@extends('layouts.backend.app')
@section('content')
<div class="container">
    <div class="login-wrapper">
        <div class="row">
            <div class="col-lg-7">
                <div class="left-wrapper">
                    <div class="login-left-header">
                        <h3>Zillicom Service</h3>
                    </div>
                    <ul>
                        <li><i class="fa fa-home"></i><span>Property</span></li>
                        <li><i class="fa fa-external-link"></i><span>Service</span></li>
                        <li><i class="fa-product-hunt"> </i><span>Product</span></li>
                    </ul>

                    <ul>

                        <ul class="left-wrapper-list">
                            <span>Either You Can</span>
                            <li><span>Broker</span></li>
                            <li><span>Vendor</span></li>
                            <li><span>Service provider</span></li>
                            <li><span> <i class="fa fa-question-circle"></i></span></li>
                        </ul>
                    </ul>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="login-right-wrapper">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-info alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    <div class="right-header">
                        <i class="fa fa-lock"></i>
                    </div>
                    <span class="right-header-headding">Welcome to Zillicom</span>
                    <div class="right-form">
                        {!! Form::open(array('url'=>'login', 'method'=>'post')) !!}
                        <div class="form-group has-feedback row">

                            <label for="" class="col-lg-3">Email</label>
                            <div class="col-lg-9">
                                <input type="email" name="email" class="form-control  " placeholder="Email">
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group has-feedback row">
                            <label for="" class="col-lg-3">Password</label>
                            <div class="col-lg-9">
                                <input type="password" name="password" class="form-control" placeholder="Password">
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="login-footer">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat">Login in
                                    </button>
                                    <a href="{{route('forgetpassword')}}" style="margin-top: 10px;"
                                    class="">forget Password ?</a>
                                </div>
                                <div class="clearfix"></div>
                                <div class="login-footer-btn">
                                    <p>Not Registered Yet ?</p>
                                    <a href="{{route('register.index')}}" >Register Now</a>
                                </div>
                            </div>
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
