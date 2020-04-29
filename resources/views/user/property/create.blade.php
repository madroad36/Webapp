@extends('user.layout.app')
@section('title', 'Add Property')
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
                <li class="active">Add Property</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Add Property</h3>
                    <a href="{{route('auth.property.index')}}" class=" btn btn-primary " style="float: right"><i class="fa fa-eye" aria-hidden="true"></i> &nbsp; View Property </a>

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

                            {!! Form::open(array('route'=>'auth.property.store','class'=>'','enctype'=>'multipart/form-data')) !!}
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
                                    <label>Plot Number</label>
                                    <input type="text" name="plot_no" class="form-control" placeholder="Plot Number" value="{{ old('plot_no') }}">
                                    @if ($errors->has('plot_no'))
                                        <div class="alert alert-danger">{{ $errors->first('plot_no') }}</div>
                                    @endif

                                </div>
                                <div class="form-group">
                                    <label>Area</label>
                                    <input type="text" name="area" class="form-control" placeholder="Area" value="{{ old('area') }}">
                                    @if ($errors->has('area'))
                                        <div class="alert alert-danger">{{ $errors->first('area') }}</div>
                                    @endif

                                </div>
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="text" name="price" class="form-control" placeholder="Price" value="{{ old('price') }}">
                                    @if ($errors->has('price'))
                                        <div class="alert alert-danger">{{ $errors->first('price') }}</div>
                                    @endif

                                </div>
                                <div class="form-group">
                                    <label>Service Charge</label>
                                    <input type="text" name="service_charge" class="form-control" placeholder="Service Charge" value="{{ old('service_charge') }}">
                                    @if ($errors->has('service_charge'))
                                        <div class="alert alert-danger">{{ $errors->first('service_charge') }}</div>
                                    @endif

                                </div>
                                <div class="form-group">
                                    <label>Broker ?</label>
                                    {!! Form::checkbox('broker', 1, true, array('class' => '',)) !!}

                                @if ($errors->has('broker'))
                                        <div class="alert alert-danger">{{ $errors->first('broker') }}</div>
                                    @endif

                                </div>
                                <div class="form-group">
                                    <label>Paid ?</label>
                                    {!! Form::checkbox('paid', 1, true, array('class' => '',)) !!}


                                @if ($errors->has('paid'))
                                        <div class="alert alert-danger">{{ $errors->first('paid') }}</div>
                                    @endif

                                </div>
                                {{--<div class="form-group">--}}
                                    {{--<label>Publish ?</label>--}}
                                    {{--{!! Form::checkbox('publish', 1, true, array('class' => '',)) !!}--}}

                                {{--@if ($errors->has('publish'))--}}
                                        {{--<div class="alert alert-danger">{{ $errors->first('publish') }}</div>--}}
                                    {{--@endif--}}

                                {{--</div>--}}

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
                                    <label>Sub-Category</label>
                                    {!! Form::select('subcategory_id',[],null,['class'=>'form-control','id'=>'subcategory','placeholder'=>'Select The Category']) !!}

                                </div>
                                <div class="form-group">
                                    <label>Location</label>
                                    @php $location = [] @endphp

                                    @foreach( $locations  as $value)

                                        @php $location[$value->id] = $value->name @endphp
                                    @endforeach
                                    {!! Form::select('location_id',$location,null,['id'=>'location','class'=>'form-control','placeholder'=>'Select The Location']) !!}

                                    @if ($errors->has('location_id'))
                                        <div class="alert alert-danger">{{ $errors->first('location_id') }}</div>
                                    @endif

                                </div>
                                <div class="form-group">
                                    <label>Area</label>
                                    {!! Form::select('place_id',[],null,['class'=>'form-control','id'=>'place','placeholder'=>'Select The Area']) !!}

                                </div>
                                <div class="form-group">
                                    <label>Near By</label>
                                    <input type="text" name="near_by" class="form-control" placeholder="Near By" value="{{ old('near_by') }}">
                                    @if ($errors->has('near_by'))
                                        <div class="alert alert-danger">{{ $errors->first('near_by') }}</div>
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
                                    <label>Owner Image</label>
                                    <input type="file" id="owner-image" name="owner_image"  placeholder="Enter ...">
                                    <img id="owner-preview-image" src="#" alt="your image" style="display:none;width:200px;height:200px;margin-left:30%;margin-top: -6%;"/>
                                    @if ($errors->has('owner-image'))
                                        <div class="alert alert-danger">{{ $errors->first('owner-image') }}</div>
                                    @endif

                                </div>
                                <div class="form-group">
                                    <label>Features</label>
                                    <input type="text" name="feature" class="form-control" placeholder="Feature" value="{{ old('feature') }}">
                                    @if ($errors->has('feature'))
                                        <div class="alert alert-danger">{{ $errors->first('feature') }}</div>
                                    @endif

                                </div>

                                <div class="form-group">
                                    <label>Description</label>

                                    {!! Form::textarea('description',null, array('class'=>'form-control editor', 'placeholder'=>'Please insert the description','id'=>'editor')) !!}

                                </div>
                                <div class="form-group">
                                    <label>Overview</label>

                                    {!! Form::textarea('short_description',null, array('class'=>'form-control mini-editor', 'placeholder'=>'Please insert the overview','id'=>'editor')) !!}

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
            $("#owner-image").on('change', function(){
                readURLImage(this);
            });
            var readURLImage = function(input) {
                $('#owner-preview-image').css('display','block');
                $('#delete-image').css('display','block');
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#owner-preview-image').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
            $('#delete-image').click(function(){
                $('#user-preview').attr('src','');
                $('#delete-image').css('display','none');

            });
            $('#category').on('change', function() {
                $('#section').empty();
                var value = $(this).val();
                var url = '{{route('auth.property.getsubcategory')}}';
                select(value, url);
            });
            function select(value, url ){
                $.ajax({
                    type:'get',
                    url:url,
                    data:{category_id:value},
                    dataType:'json',
                    success:function(response){
                        if(response.success == true){
                            var value = response.sucategory;
                            var option = '';

                            $.each(value, function(key, value) {

                                option  +='<option selected="selected" value="'+value.id+'">'+value.title+'</option:selectedoption>';
                            });

                            $('#subcategory').append(option).show();
                        }else{
                            $('#subcategory').empty();
                        }

                    }
                })
            }
            $('#location').on('change', function() {
                var value = $(this).val();
                var url = '{{route('auth.property.getplace')}}';
                getplace(value, url);
            });
            function getplace(value, url ){
                $.ajax({
                    type:'get',
                    url:url,
                    data:{location_id:value},
                    dataType:'json',
                    success:function(response){
                        console.log(response);
                        if(response.success == true){
                            var value = response.place;
                            var option = '';

                            $.each(value, function(key, value) {

                                option  +='<option selected="selected" value="'+value.id+'">'+value.name+'</option:selectedoption>';
                            });

                            $('#place').append(option).show();
                        }else{
                            $('#place').empty();
                        }

                    }
                })
            }

        });


    </script>




@endsection