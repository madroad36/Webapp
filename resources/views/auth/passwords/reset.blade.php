@extends('layouts.backend.app')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{route('home')}}" style="color: white !important;"><b>Nagarpalika Login</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">

            {!! Form::open(array('route'=>'storepassword','method'=>'post')) !!}
                <div class="form-group has-feedback">
                    <input type="email" name="email" class="form-control" placeholder="Email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="confrimpassword" class="form-control" placeholder="Confrim Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">

                    <!-- /.col -->
                    <div class="col-xs-6">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Reset Password</button>
                    </div>
                    <!-- /.col -->
                </div>
        {{ Form::hidden('token', $token) }}
         {{Form::close()}}


            <!-- /.social-auth-links -->



        </div>
        <!-- /.login-box-body -->
    </div>
@endsection
