@extends('layouts.backend.home')
@section('title', 'Edit Slider')
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
            <li class="active">Edit Slider</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Edit Slider</h3><hr>
                <a href="{{route('admin.slider.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-8  col-xs-offset-2">


                        {!! Form::model($slider,array('route'=>['admin.slider.update',$slider->id],'class'=>'','enctype'=>'multipart/form-data')) !!}
                        <!-- text input -->      
                        <div class="form-group">
                            <label>Section</label>
                            {!! Form::select('section',[
                            'properties' => 'Properties',
                            'products' => 'Products',
                            'services' => 'Services',
                            'listing' => 'Listing',
                            'advertisement' => 'Advertisement'],
                            null,
                            ['class'=>'form-control','placeholder'=>'Select The Category']) !!}
                            @if ($errors->has('section'))
                            <div class="alert alert-danger">{{ $errors->first('section') }}</div>
                            @endif
                        </div> 

                        <div class="form-group">
                            <label>Image </label>
                            <input type="file" id="image" name="image"  placeholder="Enter ...">
                            @if(file_exists('storage/'.$slider->image) && $slider->image != '')
                            <img id="upload-image" src="{{asset('storage/'.$slider->image)}}" alt="your image" style="display:display:block;width:200px;height:200px;margin-left:30%;margin-top: -6%;"/>
                            @endif
                            <img id="preview" src="#" alt="your image" style="display:none;width:200px;height:200px;margin-left:30%;margin-top: -6%;"/>
                            @if ($errors->has('image'))
                            <div class="alert alert-danger">{{ $errors->first('image') }}</div>
                            @endif

                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                        <!-- checkbox -->
                        {!! Form::hidden('id',$slider->id) !!}
                        {!! Form::close() !!}
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
            $("#image").on('change', function(){
                readURL(this);
            });
            var readURL = function(input) {
                $('#upload-image').css('display','none');

                $('#preview').css('display','block');
                $('#delete-image').css('display','block');
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#preview').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

        });
    </script>

@endsection