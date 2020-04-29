@extends('profile.app')
@section('title', 'Add Product')

@section('main-content')
    <div class="container" >
        <div class="form-group">
            <div class="image-upload" >

            {!! Form::open(array('route'=>['certificate.store'],'class'=>'dropzone','id'=>'dropzone','enctype'=>'multipart/form-data')) !!}
            {{--<form role="form aling-center">--}}

                {!! Form::close() !!}




            </div>
        </div>
    {!! Form::open(array('route'=>'skill.store','class'=>'','enctype'=>'multipart/form-data')) !!}
    {{--<form role="form aling-center">--}}
    <!-- text input -->

        <div class="form-group">
            <label>Category</label>
            @php $cat = [] @endphp

            @foreach($category as $subcategory)

                @php $cat[$subcategory->id] = $subcategory->title @endphp
            @endforeach
            {!! Form::select('subcategory_id',$cat,null,['class'=>'form-control','placeholder'=>'Select The Category']) !!}

            @if ($errors->has('subcategory_id'))
                <div class="alert alert-danger">{{ $errors->first('csubcategory_id') }}</div>
            @endif

        </div>

        <div class="form-group">
            <label>Description</label>

            {!! Form::textarea('description',null, array('class'=>'form-control editor', 'placeholder'=>'Please insert the description','id'=>'editor')) !!}

        </div>


        <div class="form-group">
            <button id="form-submt" class="btn btn-primary">Submit</button>
        </div>
        <!-- checkbox -->


        {!! Form::close() !!}
    </div>
    </div>
@endsection

@section('js_script')
    <script type="text/javascript">

        Dropzone.options.dropzone =
            {
                renameFile: function(file) {
                    var dt = new Date();
                    var time = dt.getTime();
                    return time+file.name;
                },
                maxFilesize: 12,

                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                addRemoveLinks: true,
                timeout: 5000,
                removedfile: function(file)
                {
                    var name = file.upload.filename;
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '{{ url("certificate/delete/") }}',
                        data: {image: name},
                        success: function (data){
                            console.log("File has been successfully removed!!");
                        },
                        error: function(e) {
                            console.log(e);
                        }});
                    var fileRef;
                    return (fileRef = file.previewElement) != null ?
                        fileRef.parentNode.removeChild(file.previewElement) : void 0;
                },
                success: function(file, response)
                {
                    console.log(response);
                },
                error: function(file, response)
                {
                    return false;
                }
            };

        $().on('click',function(){
            $('#dropzone').remove();
        });
    </script>
@endsection