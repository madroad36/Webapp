@extends('layouts.backend.home')
@section('title', 'Service Request list')
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
            <li class="active">Service Request</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Service Request List</h3>



                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table datatable">
                            <thead class=" text-primary">
                                <tr>
                                    <th>Id</th>
                                    <th>Title</th>
                                    <th>Order By</th>
                                    <th>Assign To</th>
                                    <th>Amount</th>
                                    <th>Time</th>
                                    <th>Stauts</th>
                                    {{--                                    <th>Paid</th>--}}
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
        <div class="modal fade" id="technician">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Add  To Service</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        {!! Form::open(array('route'=>'admin.servicerequest.assignTechnician','class'=>'Role','id'=>'add-user-role')) !!}
                        <div class="form-group" data-select2-id="13">

                            <input type="hidden" id="serviceId" name="id" value="">
                            <label>Technician</label>
                            <select id="technician-name" name="technician_id" class="form-control" required></select>
                          <!--   {!! Form::select('technician_id',[],null,['class'=>'form-control','id'=>'technician-name','placeholder'=>'Select The Category']) !!} -->

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
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- The Modal -->

</div>

@endsection
@section('js_script')
<script type="text/javascript">
    $(document).ready(function() {


        $(".datatable").DataTable({
            processing: true,
            serverSide: true,

            ajax: {
                url:'{{route('admin.servicerequest.getdata')}}',
                type:"GET",
                cache: false
            },
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: "false"},
            {data: 'title', name: 'title', orderable: "false"},
            {data: 'order_by', name: 'order_by', orderable: "false"},
            {data: 'technician', name: 'technician', orderable: "false"},
            {data: 'amount', name: 'amount', orderable: "false"},
            {data: 'duration', name: 'duration', orderable: "false"},
                    // {data: 'paid', name: 'paid', orderable: "false"},
                    {data: 'status', name: 'status', orderable: "false"},
                    {data: 'action', name: 'action', orderable: false, searchable: false}

                    ]
                });
        {{--$('.datatable').on('click','#delete-service',function(event){--}}
            {{--event.preventDefault();--}}
            {{--$object = $(this);--}}
            {{--var id  = $(this).attr('data-type');--}}
            {{--var url = baseUrl+"/admin/service/delete/"+id;--}}
            {{--swal({--}}
                {{--title: 'Are you sure?',--}}
                {{--text: 'You will not be able to recover this !',--}}
                {{--type: 'warning',--}}
                {{--showCancelButton: true,--}}
                {{--confirmButtonText: 'Yes, delete it!',--}}
                {{--cancelButtonText: 'No, keep it'--}}
                {{--}).then((result) => {--}}
                {{--if (result.value--}}
                    {{--)--}}
                {{--{--}}

                {{--$.ajax({--}}
                    {{--type: "Delete",--}}
                    {{--url: url,--}}
                    {{--data: {--}}
                    {{--id: id,--}}
                    {{--_method: 'DELETE'--}}
                    {{--},--}}
                    {{--headers: {--}}
                    {{--'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
                    {{--},--}}
                    {{--success: function (response) {--}}
                    {{--swal("Deleted!", response.message, "success");--}}

                    {{--var nRow = $($object).parents('tr')[0];--}}
                    {{--nRow.remove();--}}
                    {{--},--}}
                    {{--error: function (e) {--}}
                    {{--if (e.responseJSON.message) {--}}
                    {{--swal('Error', e.responseJSON.message, 'error');--}}
                    {{--} else {--}}
                    {{--swal('Error', 'Something went wrong while processing your request.', 'error')--}}
                    {{--}--}}
                    {{--}--}}
                    {{--});--}}
                {{--}--}}
                {{--})--}}
                {{--});--}}
        $(".datatable").on("click", ".checkout", function () {
            $object = $(this);
            var id = $(this).attr('data-type');
            var value = $(this).attr('id');
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
                        url: "{{ route('admin.servicerequest.change-status') }}",
                        data: {
                            'id': id,
                            'value':value
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        success: function (response) {
                            console.log(response.service);
                            swal("Thank You!", response.message, "success");
                            if (response.service.is_active == 1) {
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

        $(".datatable").on("click", "#assign-technician", function (event) {
            event.preventDefault();
            var serviceId = $(this).attr('data-id');
            var category = $(this).attr('data-type');
            $.ajax({
                type: "get",
                url: baseUrl+"/admin/skill/getcategory/"+category,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function (response) {
                    var category = response.data;
                    var options = '';

                    $.each(category, function (key, category) {

                        options += '<option  value="' + category.id + '">' + category.name+ '</option:selectedoption>';
                    });
                    $('#technician-name').html(options);
                    $('#serviceId').val(serviceId);

                },
                error: function (e) {
                    if (e.responseJSON.message) {
                        swal('Error', e.responseJSON.message, 'error');
                    } else {
                        swal('Error', 'Something went wrong while processing your request.', 'error')
                    }
                }
            });


        });

    });
</script>




@endsection