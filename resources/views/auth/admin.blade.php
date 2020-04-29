@extends('layouts.backend.app')
@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="../../index2.html"><b>Login</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
            @endif
            @if(session()->has('warning'))
            <div class="alert alert-danger">
                 {{ session()->get('warning') }}
            </div>
            @endif
            {!! Form::open(array('url'=>'admin/login', 'method'=>'post')) !!}
            <div class="form-group has-feedback">
                <input type="email" name="email" class="form-control" placeholder="Email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox"> Remember Me
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
                <!-- /.col -->
            </div>
            {!! Form::close() !!}


            <!-- /.social-auth-links -->

            <a href="{{route('forgetpassword')}}">I forgot my password</a><br>


        </div>
        <!-- /.login-box-body -->
    </div>

    @endsection
