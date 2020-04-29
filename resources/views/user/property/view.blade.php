
@extends('user.layout.app')
@section('title', 'View Property')
@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small>Control panel</small>
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('auth.home')}}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                <li class="active">Staff</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Property List</h3>
                            <a href="{{route('auth.property.create')}}" class=" btn btn-primary " style="float: right"><i class="fa fa-eye" aria-hidden="true"></i> &nbsp; Add Property </a>



                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table datatable">
                                <thead class=" text-primary">
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>SubCategory</th>
                                    <th>Location</th>
                                    <th>Created By</th>
                                    <th>Price</th>
                                    <th>Broker Name</th>
                                    <th>Broker</th>
                                    <th>Sold</th>
                                    <th>Paid</th>
                                    <th>Stauts</th>
                                    <th>Action</th>
                                </tr></thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->


                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- The Modal -->

    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(array('route'=>'auth.property.assignUsertype','id'=>'assignUsertype','class'=>'','enctype'=>'multipart/form-data')) !!}

                <div class="modal-header">


                    <div class="form-group">
                        <label>User Type</label>
                        {!! Form::select('usertype_id',[],null,['class'=>'form-control','id'=>'usertype','placeholder'=>'Select The Category']) !!}

                    </div>
                    <div class="form-group">
                        <label>User Type</label>
                        {!! Form::select('broker_id',[],null,['class'=>'form-control','id'=>'assign-broker','placeholder'=>'Select The Category']) !!}

                    </div>
                    <input type="hidden" class="broker-assign"  id="property_id" name="id">
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Save changes</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection
@section('js_script')
    <script type="text/javascript">
        $(document).ready(function() {


            $(".datatable").DataTable({
                processing: true,
                serverSide: true,

                ajax: {
                    url:'{{route('auth.property.getdata')}}',
                    type:"GET",
                    cache: false
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: "false"},
                    {data: 'title', name: 'title', orderable: "false"},
                    {data: 'category', name: 'category', orderable: "false"},
                    {data: 'subcategory', name: 'subcategory', orderable: "false"},
                    {data: 'location', name: 'location', orderable: "false"},
                    {data: 'created_by', name: 'created_by', orderable: "false"},
                    {data: 'price', name: 'price', orderable: "false"},
                    {data: 'broker_name', name: 'broker_name', orderable: "false"},
                    {data: 'broker', name: 'broker', orderable: "false"},
                    {data: 'sold', name: 'sold', orderable: "false"},
                    {data: 'paid', name: 'paid', orderable: "false"},
                    {data: 'status', name: 'status', orderable: "false"},
                    {data: 'action', name: 'action', orderable: false, searchable: false}

                ]
            });
            $('.datatable').on('click','#delete-property',function(event){
                event.preventDefault();
                $object = $(this);
                var id  = $(this).attr('data-type');
                var url = baseUrl+"/auth/property/delete/"+id;
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

                                var nRow = $($object).parents('tr')[0];
                                nRow.remove();
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
            $(".datatable").on("click", "#change-status", function () {
                $object = $(this);
                var id = $(this).attr('data-type');
                swal({
                    title: 'Are you sure?',
                    text: 'Do you want to change the status',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, change it!',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('auth.property.change-status') }}",
                            data: {
                                'id': id,
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: 'json',
                            success: function (response) {
                                console.log(response.property.is_active);
                                swal("Thank You!", response.message, "success");
                                if (response.property.is_active == 1) {
                                    $($object).children().removeClass('fa fa-minus');
                                    $($object).children().addClass('fa fa-check');
                                } else {
                                    $($object).find('.unpublished').html('<i class="fa fa-minus" aria-hidden="true"></i>');
                                    $($object).children().removeClass('fa fa-check');
                                    $($object).children().addClass('fa fa-minus');
                                }
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

            $(".datatable").on("click", "#item-sold", function () {
                $object = $(this);
                var id = $(this).attr('data-type');
                swal({
                    title: 'Are you sure?',
                    text: 'Do you want to change the status',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, change it!',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('auth.property.sold') }}",
                            data: {
                                'id': id,
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: 'json',
                            success: function (response) {
                                swal("Thank You!", response.message, "success");
                                if (response.property.is_active == 1) {
                                    $($object).children().removeClass('fa fa-minus');
                                    $($object).children().addClass('fa fa-check');
                                } else {
                                    $($object).find('.unpublished').html('<i class="fa fa-minus" aria-hidden="true"></i>');
                                    $($object).children().removeClass('fa fa-check');
                                    $($object).children().addClass('fa fa-minus');
                                }
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
            $(".datatable").on("click", "#item-paid", function () {
                $object = $(this);
                var id = $(this).attr('data-type');
                swal({
                    title: 'Are you sure?',
                    text: 'Do you want to change the status',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, change it!',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('auth.property.paid') }}",
                            data: {
                                'id': id,
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: 'json',
                            success: function (response) {
                                console.log(response.property.paid);
                                swal("Thank You!", response.message, "success");
                                if (response.property.paid == 1) {
                                    $($object).children().removeClass('fa fa-minus');
                                    $($object).children().addClass('fa fa-check');
                                } else {
                                    $($object).find('.unpublished').html('<i class="fa fa-minus" aria-hidden="true"></i>');
                                    $($object).children().removeClass('fa fa-check');
                                    $($object).children().addClass('fa fa-minus');
                                }
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

            $(".datatable").on("click","#add-broker", function(){
                var id = $(this).attr('data-type');
                var url = "{{route('auth.property.getusertype')}}";
                var value = $('#property_id').val(id);
                broker(id, url )
            })
            function broker(id, url ){
                $.ajax({
                    type:'get',
                    url:url,
                    data:{id:id},
                    dataType:'json',
                    success:function(response){
                        $('.broker-assign').val(id);
                        if(response.success == true){
                            var value = response.usertype;
                            var option = '';

                            $.each(value, function(key, value) {

                                option  +='<option selected="selected" value="'+value.id+'">'+value.name+'</option:selectedoption>';
                            });

                            $('#usertype').append(option).show();
                        }else{
                            $('#usertype').empty();
                        }

                    }
                })
            }

            $("#usertype").on("change", function(){
                var id =  $(this).val();
                var url = "{{route('auth.property.getuser')}}";
                getuser(id, url )
            })
            function  getuser(id, url ){
                $.ajax({
                    type:'get',
                    url:url,
                    data:{usertype_id:id},
                    dataType:'json',
                    success:function(response){

                        if(response.success == true){
                            var value = response.users;
                            var option = '';

                            $.each(value, function(key, value) {

                                option  +='<option  value="'+value.id+'">'+value.name+'</option:selectedoption>';
                            });

                            $('#assign-broker').append(option).show();
                        }else{
                            $('#assign-broker').empty();
                        }

                    }
                })
            }




        });
    </script>




@endsection