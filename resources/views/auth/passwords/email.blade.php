@extends('layouts.backend.app') 

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html"><b>Nagarpalika Login</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
            {!! Form::open(array('route'=>['sendlink'])) !!}

                <div class="form-group has-feedback">
                    <input type="email" name="email" class="form-control" placeholder="Email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <a href="{{url('admin/login')}}">Login</a><br>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-6">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Send Email</button>
                    </div>
                    <!-- /.col -->
                </div>
            {!! Form::close() !!}


            <!-- /.social-auth-links -->




        </div>
        <!-- /.login-box-body -->
    </div>
@endsection
