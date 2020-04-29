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
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                <li class="active">Role</li>

            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Role List</h3>
                            <a href="{{route('admin.role.create')}}" class=" btn btn-primary " style="float: right"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Add Role</a>



                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table datatable">
                                <thead class=" text-primary">
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Permission</th>
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
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Permissions To Roles </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    {!! Form::open(array('route'=>'admin.role.permissionstore','class'=>'permission','id'=>'add-role-permission')) !!}
                    <div class="form-group" data-select2-id="13">

                        <input type="hidden" id="role-id" name="id" value="">
                        <label>Permission</label>
                        <select class="form-control select2 select2-hidden-accessible role-permission" name="permission_id[]" multiple="" data-placeholder="Select a Permissions" style="width: 100%;" data-select2-id="7" tabindex="-1" aria-hidden="true">

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

@endsection
@section('js_script')
    <script type="text/javascript">
        $(document).ready(function() {


            $(".role-permission").select2({
                ajax: {
                    url: "{{ route('admin.role.getpermission') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function (response) {
                        return {
                            q: $.trim(response.permissions)
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data.permissions, function (item) {
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
            $('#add-role-permission').submit(function(e){

                if( $('.role-permission').has('option').length > 0 ) {
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
                    $('.alert').text('Please Select the Permission')
                }


            })

            $('.datatable').on('click','.addPermission',function(event){

                var id =$(this).attr('data-type');
                var url = baseUrl+"/admin/role/get-permission/"+id;
                $("#role-id").val(id);
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
                        var value = response.perms;
                        console.log(value);
                        var options = '';

                        $.each(value, function (key, value) {

                            options += '<option selected="selected" value="' + value.id + '">' + value.name + '</option:selectedoption>';
                        });
                        console.log(options)
                        $('.role-permission').html(options);
                    }

                });
                event.preventDefault()


            });

            $(".datatable").DataTable({
                processing: true,
                serverSide: true,

                ajax: {
                    url:'{{route('admin.role.getdata')}}',
                    type:"GET",
                    cache: false
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: "false"},
                    {data: 'name', name: 'name', orderable: "false"},
                    {data: 'slug', name: 'slug', orderable: "false"},
                    {data: 'permission', name: 'permission', orderable: "false"},
                    {data: 'action', name: 'action', orderable: false, searchable: false}

                ]
            });
            $('.datatable').on('click','#delete-role',function(event){
                event.preventDefault();
                $object = $(this);
                var id  = $(this).attr('data-type');
                var url = baseUrl+"/admin/role/delete/"+id;
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

        });
    </script>




@endsection