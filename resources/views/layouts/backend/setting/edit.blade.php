@extends('layouts.backend.home')
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
            <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active">Edit Setting</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <a href="{{route('admin.dashboard')}}" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a><br><br>
                <h3 class="box-title">Setting</h3><hr>
            </div>
            <div class="box-body">
                <div class="row" style="box-shadow: 2px 3px 20px gray; margin: 15px; padding-top: 10px;">
                    {!! Form::model($setting, array('route'=>['admin.setting.update',$setting->id],'enctype'=>'multipart/form-data')) !!}
                    <!-- text input -->

                    <div class="col-sm-12 form-group">
                        <label>Logo</label>
                        @if(file_exists('storage/'.$setting->image) && $setting->image != '')
                        <img src="{{asset('storage/'.$setting->image)}}" alt="your image" style="display:block; float: right; width:200px; height:200px;"/>
                        @endif
                        <input type="file" id="image" name="image">
                        <img id="preview" src="#" alt="your image" style="display:none; width:200px; height:200px; margin-top: 5px; float: left;"/>
                        @if ($errors->has('image'))
                        <div class="alert alert-danger">{{ $errors->first('image') }}</div>
                        @endif
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Company</label>
                        <input type="text" name="company" class="form-control" placeholder="Company Name" value="{{ $setting->company }}">
                        @if ($errors->has('company'))
                        <div class="alert alert-danger">{{ $errors->first('company') }}</div>
                        @endif

                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" placeholder="Eg: Baneswor, Kathmandu" value="{{ $setting->address }}">
                        @if ($errors->has('address'))
                        <div class="alert alert-danger">{{ $errors->first('address') }}</div>
                        @endif

                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Contact</label>
                        <input type="number" name="contact" class="form-control" placeholder="Eg: 9845******" value="{{ $setting->contact }}">
                        @if ($errors->has('contact'))
                        <div class="alert alert-danger">{{ $errors->first('contact') }}</div>
                        @endif
                    </div> 

                    <div class="col-sm-6 form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Eg: info@gmail.com" value="{{ $setting->email }}">
                        @if ($errors->has('email'))
                        <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                        @endif
                    </div> 

                    <div class="col-sm-6 form-group">
                        <label>Official Website</label>
                        <input type="text" name="website" class="form-control" placeholder="Eg: www.zillicom.com" value="{{ $setting->website }}">
                        @if ($errors->has('website'))
                        <div class="alert alert-danger">{{ $errors->first('website') }}</div>
                        @endif
                    </div> 


                    <div class="col-sm-12 form-group">
                        <label>What We Do?</label>
                        {!! Form::textarea('description',null, array('class'=>'form-control editor', 'placeholder'=>'Please insert the description','id'=>'editor')) !!}
                    </div>

                    <div class="col-sm-6 form-group">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                    <!-- checkbox -->
                    {!! Form::hidden('id',$setting->id) !!}
                    {!! Form::close() !!}

                    <!-- /.box -->
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