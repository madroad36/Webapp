@extends('profile.app')
@section('title', 'Add Service')

@section('main-content')
<div class="container"> 
    <div class="row">
        <div class="col-xs-8  col-xs-offset-4" style="box-shadow: 5px 10px 18px #888888; padding: 15px;">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {!! Form::open(array('route'=>'admin.service.store','class'=>'','enctype'=>'multipart/form-data')) !!}
            <!-- text input -->
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="title" class="form-control" placeholder="title" value="{{ old('title') }}">
                @if ($errors->has('title'))
                <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                @endif

            </div>

            <div class="form-group">
                <label>Category</label>
                @php $cat = [] @endphp

                @foreach($categories as $category)

                @php $cat[$category->id] = ucfirst($category->name) @endphp
                @endforeach
                {!! Form::select('category_id',$cat,null,['class'=>'form-control','id'=>'category','placeholder'=>'Select The Category']) !!}

                @if ($errors->has('category_id'))
                <div class="alert alert-danger">{{ $errors->first('category_id') }}</div>
                @endif

            </div>
            {{--                                <div class="form-group">--}}
                {{--                                    <label>Subcategory</label>--}}
                {{--                                    {!! Form::select('subcategory_id',[],null,['class'=>'form-control','id'=>'subcategory','placeholder'=>'Select The Subcategory']) !!}--}}

            {{--                                </div>--}}
            {{--<div class="form-group">--}}
                {{--<label>Location</label>--}}
                {{--@php $location = [] @endphp--}}

                {{--@foreach( $locations  as $value)--}}

                {{--@php $location[$value->id] = $value->name @endphp--}}
                {{--@endforeach--}}
                {{--{!! Form::select('location_id',$location,null,['id'=>'location','class'=>'form-control','placeholder'=>'Select The Location']) !!}--}}

                {{--@if ($errors->has('location_id'))--}}
                {{--<div class="alert alert-danger">{{ $errors->first('location_id') }}</div>--}}
                {{--@endif--}}

            {{--</div>--}}
            {{--<div class="form-group">--}}
                {{--<label>Place</label>--}}
                {{--{!! Form::select('place_id',[],null,['class'=>'form-control','id'=>'place','placeholder'=>'Select The Area']) !!}--}}

            {{--</div>--}}
            <div class="form-group">
                <label>Image</label>
                <input type="file" accept="image/x-png,image/gif,image/jpeg" id="user-image" name="image"  placeholder="Enter ...">
                <img id="school-preview" src="#" alt="your image" style="display:none;width:200px;height:200px;margin-left:30%;margin-top: -6%;"/>
                @if ($errors->has('image'))
                <div class="alert alert-danger">{{ $errors->first('image') }}</div>
                @endif

            </div>
            <div class="form-group">
                <label>Rate</label>
                <input type="number" name="rate" placeholder="Please insert rate" min="0" class="form-control">
            </div>
            <div class="form-group">
                <label>Rate Type</label>
                <select name="rate_type" class="form-control" id="">
                    <option value="0" selected> Rate Type</option>
                    <option value="half-hour" >Half-Hourly</option>
                    <option value="hourly" >Hourly</option>
                    <option value="per-day">Per-Day</option>


                </select>
                {{--                                    <input type="number" name="task" placeholder="Please insert task rate" min="0" class="form-control">--}}
            </div>
            {{--                                <div class="form-group">--}}
                {{--                                    <label>Monthly Rate</label>--}}
                {{--                                    <input type="number" name="monthly" placeholder="Please insert monthly rate" min="0" class="form-control">--}}
            {{--                                </div>--}}
            {{--                                <div class="form-group">--}}
                {{--                                    <label>Yearly Rate</label>--}}
                {{--                                    <input type="number" name="yearly" placeholder="Please insert yearly rate" min="0" class="form-control">--}}
            {{--                                </div>--}}
            {{--                                <div class="form-group">--}}
                {{--                                    <label>Member Rate</label>--}}
                {{--                                    <input type="number" name="member" placeholder="Please insert member rate" min="0" class="form-control">--}}
            {{--                                </div>--}}
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
@endsection

@section('js_script')
<script type="text/javascript">
    $(document).ready(function () {

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




        $('#category').on('change', function() {
            var value = $(this).val();

            getsubcategory(value,);
        });
        window.onload = function(){
            var categoryValue = $('#category option:selected').text();

            getsubcategory(categoryValue);
        }
        function getsubcategory(value ){
            var url = '{{route('service.subcategory.getsubcategory')}}';
            $.ajax({
                type:'get',
                url:url,
                data:{category_id:value},
                dataType:'json',
                success:function(response){
                    console.log(response);
                    if(response.success == true){
                        var value = response.subcategory;
                        var option = '';

                        $.each(value, function(key, value) {

                            option  +='<option selected="selected" value="'+value.id+'">'+value.title+'</option:selectedoption>';
                        });

                        $('#subcategory').html(option).show();
                    }else{
                        $('#subcategory').empty();
                    }

                }
            })
        }

    });
</script>
@endsection