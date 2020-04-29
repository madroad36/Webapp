@extends('user.layout.app')
@section('title', 'Create Service')
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
                <li class="active">Add Service</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Add Service</h3>
                    <a href="{{route('auth.service.index')}}" class=" btn btn-primary " style="float: right"><i class="fa fa-eye" aria-hidden="true"></i> &nbsp; View Service</a>

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

                            {!! Form::open(array('route'=>'auth.service.store','class'=>'','enctype'=>'multipart/form-data')) !!}
                            {{--<form role="form aling-center">--}}
                        <!-- text input -->
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="title" class="form-control" placeholder="title" value="{{ old('title') }}">
                                @if ($errors->has('title'))
                                    <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                                @endif

                            </div>



                            <div class="form-group">
                            <label>Image</label>
                            <input type="file" accept="image/x-png,image/gif,image/jpeg" id="user-image" name="image"  placeholder="Enter ...">
                            <img id="school-preview" src="#" alt="your image" style="display:none;width:200px;height:200px;margin-left:30%;margin-top: -6%;"/>
                            @if ($errors->has('image'))
                            <div class="alert alert-danger">{{ $errors->first('image') }}</div>
                            @endif

                            </div>
                                <div class="form-group">
                                    <label>Category</label>
                                    @php $cat = [] @endphp

                                    @foreach($categories as $category)

                                        @php $cat[$category->id] = $category->name @endphp
                                    @endforeach
                                    {!! Form::select('category_id',$cat,null,['class'=>'form-control','id'=>'category','placeholder'=>'Select The Category']) !!}

                                    @if ($errors->has('category_id'))
                                        <div class="alert alert-danger">{{ $errors->first('category_id') }}</div>
                                    @endif

                                </div>

                                <div class="form-group">
                                    <label>Description</label>

                                    {!! Form::textarea('description',null, array('class'=>'form-control editor', 'placeholder'=>'Please insert the description','id'=>'editor')) !!}

                                </div>
                                <div class="form-group">
                                    <label>Publish ?</label>
                                        {!! Form::checkbox('is_active', 1, true, array('class' => '',)) !!}
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
            $("#user-image").on('change', function(){
                readURL(this);
            });
            var readURL = function(input) {
                $('#school-preview').css('display','block');
                $('#delete-image').css('display','block');
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