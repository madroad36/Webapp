@extends('profile.app')
@section('title', 'Add Product')

@section('main-content')
    <div class="container">
    {!! Form::open(array('route'=>'product.store','class'=>'','enctype'=>'multipart/form-data')) !!}
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
            <label>Paid ?</label>
            {!! Form::checkbox('paid', 1, true, array('class' => '',)) !!}
        </div>
        <div class="form-group">
            <label>Publish ?</label>
            {!! Form::checkbox('is_active', 1, true, array('class' => '',)) !!}
        </div>
        <div class="form-group">
            <label>Price</label>
            <input type="number" name="price" class="form-control" placeholder="Price" value="{{ old('price') }}">
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
            {!! Form::select('category_id',$cat,null,['class'=>'form-control','placeholder'=>'Select The Category']) !!}

            @if ($errors->has('category_id'))
                <div class="alert alert-danger">{{ $errors->first('clategory_id') }}</div>
            @endif

        </div>

        <div class="form-group">
            <label>Image</label>
            <input type="file" id="product-image" accept="image/x-png,image/gif,image/jpeg"  name="image11"  placeholder="Enter ...">
            <img id="product-preview" src="#" alt="your image" style="display:none;width:200px;height:200px;margin-left:30%;margin-top: -6%;"/>
            @if ($errors->has('image'))
                <div class="alert alert-danger">{{ $errors->first('image') }}</div>
            @endif



        </div>

        <div class="form-group">
            <label>Description</label>

            {!! Form::textarea('description',null, array('class'=>'form-control editor', 'placeholder'=>'Please insert the description','id'=>'editor')) !!}

        </div>

        <div class="form-group">
            <button class="btn btn-primary">Submit</button>
        </div>
        <!-- checkbox -->



        {!! Form::close() !!}
    </div>
@endsection

@section('js_script')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#product-image").on('change', function(){
                readURL(this);
            });
            var readURL = function(input) {
                $('#product-preview').css('display','block');
                $('#delete-image').css('display','block');
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#product-preview').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
            $('#delete-image').click(function(){
                $('#product-preview').attr('src','');
                $('#delete-image').css('display','none');

            });

        });
        </script>
@endsection