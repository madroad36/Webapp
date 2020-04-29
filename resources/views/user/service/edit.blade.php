@extends('user.layout.app')
@section('title', 'Edit Service')
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
                <li class="active">Edit Service</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Edit Service</h3>
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

                        {!! Form::open(array('route'=>['auth.service.update',$service->id],'class'=>'','enctype'=>'multipart/form-data')) !!}
                        {{--<form role="form aling-center">--}}
                        <!-- text input -->
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="title" class="form-control" placeholder="title" value="{{ $service->title }}">
                                @if ($errors->has('title'))
                                    <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                                @endif

                            </div>

                                <div class="form-group">
                                    <label>Category</label>
                                    @php $cat = [] @endphp

                                    @foreach($categories as $category)

                                        @php $cat[$category->id] = $category->name @endphp
                                    @endforeach
                                    {!! Form::select('category_id',$cat,$service->category_id,['class'=>'form-control','id'=>'category','placeholder'=>'Select The Category']) !!}

                                    @if ($errors->has('category_id'))
                                        <div class="alert alert-danger">{{ $errors->first('category_id') }}</div>
                                    @endif

                                </div>

                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" accept="image/x-png,image/gif,image/jpeg" id="school-image" name="image"  placeholder="Enter ...">
                               @if(file_exists('storage/'.$service->thumbnail) && $service->thumbnail != '')
                                    <img id="delete-image" src="{{asset('storage/'.$service->thumbnail)}}" alt="{{$service->title}}" style="width:200px; height:200px;margin-top: 20px;">
                                   @endif
                                <img id="school-preview" src="#" alt="your image" style="display:none;width:200px;height:200px;margin-left:30%;margin-top: -6%;"/>
                                @if ($errors->has('image'))
                                    <div class="alert alert-danger">{{ $errors->first('image') }}</div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label>Description</label>

                                {!! Form::textarea('description',$service->description, array('class'=>'form-control editor', 'placeholder'=>'Please insert the description','id'=>'editor')) !!}

                            </div>


                            <div class="form-group">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                            <!-- checkbox -->


                            {!! Form::hidden('id',$service->id) !!}

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
            $("#school-image").on('change', function(){
                readURL(this);
                $('#delete-image').css('display','none');

            });
            var readURL = function(input) {
                $('#school-preview').css('display','block');
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#school-preview').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
            $('#delete-image').click(function(){
                $('#school-preview').attr('src','');
                $('#delete-image').css('display','none');

            });

        });


    </script>




@endsection