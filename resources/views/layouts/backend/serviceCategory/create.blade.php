@extends('layouts.backend.home')
@section('title', 'Create Property Category')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                <li class="active">Add Service Category</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Add Service Category</h3>
                    <a href="{{route('admin.service_category.index')}}" class=" btn btn-primary " style="float: right"><i class="fa fa-eye" aria-hidden="true"></i> &nbsp; View Service Category </a>

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

                        {!! Form::open(array('route'=>'admin.service_category.store','class'=>'','enctype'=>'multipart/form-data')) !!}
                        {{--<form role="form aling-center">--}}
                        <!-- text input -->
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                                @endif

                            </div>
                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" id="property-image" name="image"  placeholder="Enter ...">
                                    <img id="property-preview" src="#" alt="your image" style="display:none;width:200px;height:200px;margin-left:30%;margin-top: -6%;"/>
                                    @if ($errors->has('image'))
                                        <div class="alert alert-danger">{{ $errors->first('image') }}</div>
                                    @endif

                                </div>
                            <div class="form-group">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                            <!-- checkbox -->



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
            $("#property-image").on('change', function(){
                readURL(this);
            });
            var readURL = function(input) {
                $('#property-preview').css('display','block');
                $('#delete-image').css('display','block');
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#property-preview').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

        });
    </script>




@endsection