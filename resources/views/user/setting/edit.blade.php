@extends('user.layout.app')

@section('title', 'Edit Setting')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('auth.home')}}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                <li class="active">Edit Setting</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Edit Setting</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-8  col-xs-offset-2">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                        @endif

                        {!! Form::open(array('route'=>['setting.update',$setting->id],'class'=>'','enctype'=>'multipart/form-data')) !!}
                        {{--<form role="form aling-center">--}}
                        <!-- text input -->
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="title" class="form-control" placeholder="Title" value="{{ $setting->title }}">
                                @if ($errors->has('title'))
                                    <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                                @endif

                            </div>
                                <div class="form-group">
                                    <label>Value</label>
                                    <input type="text" name="value" class="form-control" placeholder="Value" value="{{ $setting->value }}">
                                    @if ($errors->has('value'))
                                        <div class="alert alert-danger">{{ $errors->first('value') }}</div>
                                    @endif

                                </div>
                            <div class="form-group">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                            <!-- checkbox -->


                        {!! Form::hidden('id',$setting->id) !!}
                        {!! Form::close() !!}

                        {{--</form>--}}
                        <!-- /.box -->


                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                    </div>
                </div>

                <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>

@endsection
@section('js_script')
    <script type="text/javascript">
        $(document).ready(function() {


        });
    </script>




@endsection