@extends('layouts.backend.home')
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
            @if(session()->has('errors'))
            <div class="alert alert-danger">
                {{ session()->get('errors') }}
            </div>
            @endif
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active">User</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">User List</h3><hr>
                        <a href="{{route('admin.users.create')}}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Add User</a>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table datatable">
                            <thead class=" text-primary">
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    {{--<th>Address</th>--}}
                                    {{--<th>Contact</th>--}}
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Broker</th>
                                    <th>Vendor</th>
                                    <th>service</th>
                                    {{--<th>Logo</th>--}}
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
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
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Roles To User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                {!! Form::open(array('route'=>'admin.userRole.store','class'=>'Role','id'=>'add-user-role')) !!}
                <div class="form-group" data-select2-id="13">

                    <input type="hidden" id="user-id" name="id" value="">
                    <label>Role</label>
                    <select class="form-control select2 select2-hidden-accessible user-roles" name="role_id[]" multiple="" data-placeholder="Select a Roles" style="width: 100%;" data-select2-id="7" tabindex="-1" aria-hidden="true">

                    </select>

                    <span class="alert"></span>
                </div>
                <div class="form-group" data-select2-id="13">
                    <input type="submit" name="submit" class="btn btn-primary" id="add-user-role" value="Submit"  />
                </div>
                {!! Form::close() !!}
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

</div>

@endsection
@section('js_script')
<script type="text/javascript">


    $(document).ready(function() {

        $(".user-roles").select2({
            ajax: {
                url: "{{ route('admin.userRole.index') }}",
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function (response) {
                    return {
                        q: $.trim(response.roles)
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.roles, function (item) {
                            return {
                                id: item.id,
                                text: item.name
                            };
                        })
                    }
                },
                cache: true,
            }

        });
        $('#add-user-role').submit(function(e){

            if( $('.user-roles').has('option').length > 0 ) {
                var from = $(this).serialize();
                var url = $(this).attr('action');
                $.ajax({
                    type: "get",
                    url: url,
                    data: {
                        'id': id,
                        'role_id': from
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function (response) {

                    }
                });
            }
            else{
                e.preventDefault();
                $('.alert').text('Please Select the Roles')
            }


        })
        $('.datatable').on('click','.addRole',function(event){

            var id =$(this).attr('data-type');
            var url = baseUrl+"/admin/users/get-role/"+id;
            $("#user-id").val(id);
            $.ajax({
                type: "get",
                url: url,
                data: {
                    'id': id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function (response) {
                    var value = response.role;
                    console.log(value);
                    var options = '';

                    $.each(value, function (key, value) {

                        options += '<option selected="selected" value="' + value.id + '">' + value.name + '</option:selectedoption>';
                    });
                    console.log(options)
                    $('.user-roles').html(options);
                }

            });
            event.preventDefault()


        });
        $(".datatable").DataTable({
            processing: true,
            serverSide: true,

            ajax: {
                url:'{{route('admin.users.getdata')}}',
                type:"GET",

                cache: false
            },
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: "false"},
            {data: 'name', name: 'name', orderable: "false"},
                    // {data: 'address', name: 'address', orderable: "false"},
                    // {data: 'phone', name: 'phone', orderable: "false"},
                    {data: 'email', name: 'email', orderable: "false"},
                    {data: 'roles', name: 'roles', orderable: "false"},
                    {data: 'broker', name: 'broker', orderable: "false"},
                    {data: 'vendor', name: 'vendor', orderable: "false"},
                    {data: 'service', name: 'service', orderable: "false"},
                    {data: 'status', name: 'status', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false}

                    ]
                });
        $('.datatable').on('click','#delete-user',function(event){
            event.preventDefault();
            $object = $(this);
            var id  = $(this).attr('data-type');
            var url = baseUrl+"/admin/users/delete/"+id;
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
        })
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
                        url: "{{ route('admin.users.change-status') }}",
                        data: {
                            'id': id,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        success: function (response) {
                            swal("Thank You!", response.message, "success");
                            if (response.response.is_active == 1) {
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
        $(".datatable").on("click", "#broker", function () {
            $object = $(this);
            var id = $(this).attr('data-type');
            swal({
                title: 'Are you sure?',
                text: 'Do you want to assign broker ',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, change it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.users.broker') }}",
                        data: {
                            'id': id,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        success: function (response) {
                            swal("Thank You!", response.message, "success");
                            if (response.response.broker == 1) {
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
        $(".datatable").on("click", "#vendor", function () {
            $object = $(this);
            var id = $(this).attr('data-type');
            swal({
                title: 'Are you sure?',
                text: 'Do you want to assign Vendor ',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, change it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.users.vendor') }}",
                        data: {
                            'id': id,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        success: function (response) {
                            swal("Thank You!", response.message, "success");
                            if (response.response.vendor == 1) {
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
        $(".datatable").on("click", "#service", function () {
            $object = $(this);
            var id = $(this).attr('data-type');
            swal({
                title: 'Are you sure?',
                text: 'Do you want to assign service-provider ',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, change it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.users.service') }}",
                        data: {
                            'id': id,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        success: function (response) {
                            swal("Thank You!", response.message, "success");
                            if (response.response.service == 1) {
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
    });
</script>




@endsection