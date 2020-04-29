
@extends('user.layout.app')
@section('title', 'Edit Product')

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
                <li class="active">Edit Product</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Edit Product</h3>
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

                        {!! Form::open(array('route'=>['auth.product.update',$product->id],'class'=>'','enctype'=>'multipart/form-data')) !!}
                        {{--<form role="form aling-center">--}}
                        <!-- text input -->
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="title" class="form-control" placeholder="title" value="{{ $product->title }}">
                                    @if ($errors->has('title'))
                                        <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                                    @endif

                                </div>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="price" class="form-control" placeholder="Price" value="{{ $product->price }}">
                                    @if ($errors->has('price'))
                                        <div class="alert alert-danger">{{ $errors->first('price') }}</div>
                                    @endif

                                </div>

                                <div class="form-group">
                                    <label>Category</label>
                                    @php $cat = [] @endphp

                                    @foreach($categories as $category)

                                        @php $cat[$category->id] = $category->title @endphp
                                    @endforeach
                                    {!! Form::select('category_id',$cat,$product->category_id,['class'=>'form-control','placeholder'=>'Select The Category']) !!}

                                    @if ($errors->has('category_id'))
                                        <div class="alert alert-danger">{{ $errors->first('clategory_id') }}</div>
                                    @endif

                                </div>




                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" accept="image/x-png,image/gif,image/jpeg" id="school-image" name="image"  placeholder="Enter ...">

                                    @if(file_exists('storage/'.$product->image) && $product->image != '')
                                        <img id="delete-image" src="{{asset('storage/'.$product->image)}}" alt="{{$product->title}}" style="margin-top: 20px;">
                                    @endif
                                    <img id="school-preview" src="#" alt="your image" style="display:none;width:200px;height:200px;margin-left:30%;margin-top: -6%;"/>
                                    @if ($errors->has('image'))
                                        <div class="alert alert-danger">{{ $errors->first('image') }}</div>
                                    @endif

                                </div>

                                <div class="form-group">
                                    <label>Description</label>

                                    {!! Form::textarea('description',$product->description, array('class'=>'form-control editor', 'placeholder'=>'Please insert the description','id'=>'editor')) !!}

                                </div>

                            <div class="form-group">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                            <!-- checkbox -->
                            {!! Form::hidden('id',$product->id) !!}
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
                $('#delete-image').css('display','none');

            });
            var readURL = function(input) {
                $('#user-preview').css('display','block');
                $('#delete-image').css('display','block');
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#user-preview').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
            $('#delete-image').click(function(){
                $('#user-preview').attr('src','');
                $('#delete-image').css('display','none');

            });

        });




        {{--onload = function() {--}}
            {{--var value = $('#class').find('option:selected').val();--}}
            {{--var url = '{{route('user.section.getsection')}}';--}}
            {{--select(value, url);--}}
        {{--}--}}
        // function select(value,url){
        //
        //     $.ajax({
        //         type:'get',
        //         url:url,
        //         data:{class_id:value},
        //         dataType:'json',
        //         success:function(response){
        //             console.log(response.sections);
        //             if(response.status == true){
        //                 var value = response.sections;
        //                 var option = '';
        //
        //                 $.each(value, function(key, value) {
        //
        //                     option  +='<option selected="selected" value="'+value.id+'">'+value.name+'</option:selectedoption>';
        //                 });
        //
        //                 $('#section').append(option).show();
        //             }else{
        //                 $('#section').empty();
        //             }
        //
        //         }
        //     });
        // }
    </script>




@endsection