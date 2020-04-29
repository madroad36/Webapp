@extends('layouts.backend.home')
@section('title', 'Technician Lists')
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
                <li class="active">Technician</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Vendor List</h3>
                            {{--                            <a href="{{route('admin.category.create')}}" class=" btn btn-primary " style="float: right"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Add Property Category </a>--}}


                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table datatable">
                                <thead class=" text-primary">
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>contact</th>
                                    <th>category</th>
                                    <th>Citizen No</th>
                                    <th>citizen</th>
                                    <th>Status</th>
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


@endsection
@section('js_script')
    <script type="text/javascript">
        $(document).ready(function() {



            $(".datatable").DataTable({
                processing: true,
                serverSide: true,

                ajax: {
                    url:'{{route('admin.technician.getdata')}}',
                    type:"GET",
                    cache: false
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: "false"},
                    {data: 'name', name: 'name', orderable: "false"},
                    {data: 'contact', name: 'contact', orderable: "false"},
                    {data: 'category', name: 'category', orderable: "false"},
                    {data: 'citizen_no', name: 'citizen_no', orderable: "false"},
                    {data: 'citizen', name: 'citizen', orderable: "false"},
                    {data: 'status', name: 'status', orderable: "false"},
                ]
            });
            // $('.datatable').on('click','#delete-category',function(event){
            //     event.preventDefault();
            //     $object = $(this);
            //     var id  = $(this).attr('data-type');
            //     var url = baseUrl+"/admin/category/delete/"+id;
            //     swal({
            //         title: 'Are you sure?',
            //         text: 'You will not be able to recover this !',
            //         type: 'warning',
            //         showCancelButton: true,
            //         confirmButtonText: 'Yes, delete it!',
            //         cancelButtonText: 'No, keep it'
            //     }).then((result) => {
            //         if (result.value
            //         )
            //         {
            //
            //             $.ajax({
            //                 type: "Delete",
            //                 url: url,
            //                 data: {
            //                     id: id,
            //                     _method: 'DELETE'
            //                 },
            //                 headers: {
            //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //                 },
            //                 success: function (response) {
            //                     swal("Deleted!", response.message, "success");
            //
            //                     var nRow = $($object).parents('tr')[0];
            //                     nRow.remove();
            //                 },
            //                 error: function (e) {
            //                     if (e.responseJSON.message) {
            //                         swal('Error', e.responseJSON.message, 'error');
            //                     } else {
            //                         swal('Error', 'Something went wrong while processing your request.', 'error')
            //                     }
            //                 }
            //             });
            //         }
            //     })
            // })
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
                            url: "{{ route('admin.technician.change-status') }}",
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


        });
    </script>




@endsection