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
        <a href="{{route('admin.advertisement.index')}}" class=" btn btn-primary " style="float: right"><i class="fa fa-eye" aria-hidden="true"></i> &nbsp; View Advertisement </a>

      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-xs-8  col-xs-offset-2">
            <!-- @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif -->

            {!! Form::open(array('route'=>'admin.advertisement.store','class'=>'','enctype'=>'multipart/form-data')) !!}
            {{--<form role="form aling-center">--}}
              <!-- text input -->
              <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" placeholder="Eg: Coca Cola" value="{{ old('name') }}">
                @if ($errors->has('name'))
                <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                @endif
              </div>

               <div class="form-group">
                <label>Contact</label>
                <input type="number" name="contact" class="form-control" placeholder="Eg: 9845******" value="{{ old('contact') }}">
                @if ($errors->has('contact'))
                <div class="alert alert-danger">{{ $errors->first('contact') }}</div>
                @endif
              </div> 

              <div class="form-group">
                <label>Index</label>
                <input type="number" name="index" class="form-control" placeholder="Where You Wana Display" value="{{ old('index') }}" min="1">
                @if ($errors->has('index'))
                <div class="alert alert-danger">{{ $errors->first('index') }}</div>
                @endif
              </div>    

              <div class="form-group">
                <label>Price</label>
                <input type="number" name="price" class="form-control" placeholder="Eg: Rs 1,500 /-" value="{{ old('price') }}">
                @if ($errors->has('price'))
                <div class="alert alert-danger">{{ $errors->first('price') }}</div>
                @endif
              </div>  

              <div class="form-group">
                <label>Start Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" min="{{$date}}">
                @if ($errors->has('start_date'))
                <div class="alert alert-danger">{{ $errors->first('start_date') }}</div>
                @endif
              </div>  

              <div class="form-group">
                <label>End Date</label>
                <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" min="{{$date}}">
                @if ($errors->has('end_date'))
                <div class="alert alert-danger">{{ $errors->first('end_date') }}</div>
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
                <input type="number" name="created_by" hidden value="{{Auth::user()->id}}">
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