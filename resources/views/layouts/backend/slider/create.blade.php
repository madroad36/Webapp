@extends('layouts.backend.home')
@section('title', 'Create Slider')
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
      <li class="active">Add Slider</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Add Slider</h3>
        <a href="{{route('admin.slider.index')}}" class=" btn btn-primary " style="float: right"><i class="fa fa-eye" aria-hidden="true"></i> &nbsp; View Slider </a>

      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-xs-8  col-xs-offset-2">
            {!! Form::open(array('route'=>'admin.slider.store','class'=>'','enctype'=>'multipart/form-data')) !!}
              <!-- text input -->
              <div class="form-group">
                <label>Section</label>
                {!! Form::select('section', [
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
                <label>Image</label>
                <input type="file" id="image" name="image"  placeholder="Enter ...">
                <img id="preview" src="#" alt="your image" style="display:none;width:200px;height:200px;margin-left:30%;margin-top: -6%;"/>
                @if ($errors->has('image'))
                <div class="alert alert-danger">{{ $errors->first('image') }}</div>
                @endif
              </div>

              <div class="form-group">
                <input type="number" name="created_by" hidden value="{{Auth::user()->id}}">
                <button class="btn btn-primary">Submit</button>
              </div>
              <!-- checkbox -->

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