
@extends('layouts.backend.home')
@section('title', 'Product Image List')
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
                <li class="active">Add Product</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Add Product</h3>
                    <a href="{{route('admin.product_image.create',[$product->id])}}" style="float:right">Back</a>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12 ">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                        @endif


                                <div class="panel-body gallery-image">

                                    <div class="row">
                                        @forelse($images as $image)
                                            <div class="col-sm-6 col-lg-3" id="imageItem-{{ $image->id }}">

                                                <div class="card">
                                                    <div class="card-img-actions m-1">
                                                        <img class="card-img img-fluid" src="{{ asset('storage/'.$image->image) }}" alt=""
                                                             style="width: 221px; height:165px;">
                                                        <div class="card-img-actions-overlay card-img">

                                                            <a href="javascript:void(0)" id="delete-product" data-type="{{ $image->id  }}" data-gallery= "{{ $image->id }}"
                                                               class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round ml-2 delete">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-sm-6 col-lg-3">
                                                <div class="card">
                                                    Sorry, no image has been uploaded yet.
                                                </div>
                                            </div>
                                        @endforelse

                                    </div>
                                </div>
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

            $('.gallery-image').on('click','#delete-product',function(event){
                event.preventDefault();
                $object = $(this);
                var id  = $(this).attr('data-type');
                var url = baseUrl+"/admin/product_image/delete/"+id;
                swal({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this !',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.value
                    )
                    {

                        $.ajax({
                            type: "Delete",
                            url: url,
                            data: {
                                id: id,
                                _method: 'DELETE'
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                swal("Deleted!", response.message, "success");
                                $("#imageItem-"+id).empty();
                            },
                            error: function (e) {
                                if (e.responseJSON.message) {
                                    swal('Error', e.responseJSON.message, 'error');
                                } else {
                                    swal('Error', 'Something went wrong while processing your request.', 'error')
                                }
                            }
                        });
                    }
                })
            });


        });


    </script>




@endsection