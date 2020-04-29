@extends('layouts.backend.home')

@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
            <!-- @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
            @endif -->
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
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
                        @can('isAdmin')
                        <a href="#" data-toggle="modal" data-target=".add-property" class=" btn btn-primary" style="float: right"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Add Property</a>
                        @endcan
                        
                        @include('layouts.backend.property.create')

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table datatable">
                            <thead class="text-primary">
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Location</th>
                                    <th>Created By</th>
                                    <th>Price</th>
                                    <th>Broker Name</th>
                                    <th>Broker</th>
                                    <th>Sold</th>
                                    <th>Paid</th>
                                    <th>Stauts</th>
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
                {{-- @include('layouts.backend.property.edit') --}}
                <div class="admin-edit-property-modal">

                </div>

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
            {!! Form::open(array('route'=>'admin.property.assignUsertype','id'=>'assignUsertype','class'=>'','enctype'=>'multipart/form-data')) !!}

            <div class="modal-header">


                <div class="form-group">
                    <label>Broker Lists</label>
                    {!! Form::select('broker_id',[],null,['class'=>'form-control','id'=>'usertype','placeholder'=>'Select The Category']) !!}

                </div>
                <input type="hidden" class="broker-assign"  id="property_id" name="id">
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-primary">Assign</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection
@section('js_script')
<script src="{{asset('backend/dist/js/property.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {

        $
        $(".datatable").DataTable({
            processing: true,
            serverSide: true,

            ajax: {
                url:'{{route('admin.property.getdata')}}',
                type:"GET",
                cache: false
            },
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: "false"},
            {data: 'title', name: 'title', orderable: "false"},
            {data: 'category', name: 'category', orderable: "false"},
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
        $("#city-edit").autocomplete({

            source: function (request, response) {
                var url = baseUrl + "/place/getlocation";
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'Post',
                    url: url,
                    data: {
                        term: request.term,
                    },
                    dataType: "json",
                    success: function (data) {

                        var resp = $.map(data, function (obj) {
                            return obj.name;
                            $('.locationId').text(obj.id);
                        });

                        response(resp);
                    },

                    error: function (data) {

                    }
                });
            },
            minLength: 1
        });

        $('#property-add').on('click',function(){
            $('.admin-property-store').modal('show');
        })

        $('.datatable').on('click','#admin-edit-property',function(event){
            var url  = $(this).attr('data-type');
            $.ajax({
                type: "get",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'html',
                success: function (response) {
                    $('.admin-edit-property-modal').html(response);
                    $('.admn-property-edit').modal('show');
                    $('#property-edit-popup .edit:first').show()
                    $('#property-edit-popup #progressbar li:nth(0)').addClass('active')
                    const subcategory =  $('#property-edit-popup #subcategory option:selected').text();
                    const category =  $('#property-edit-popup #category option:selected').text();
                    if (category == 'House') {
                        $('.house').show();
                        $('.land').hide();
                        $(".land :input").removeClass('edit-form-input');
                        $(".house :input").addClass('edit-form-input');
                        $('.edit-house').show();
                        $(".edit-house :input").addClass('edit-form-input');

                    }
                    if (category == 'Land') {
                        $('.land').show();
                        $('.house').hide();
                        $(".house :input").removeClass('edit-form-input');
                        $(".land :input").addClass('edit-form-input');
                        $('.edit-house').hide();
                        $(".edit-house :input").removeClass('edit-form-input');
                    }
                    if(subcategory == 'Rent'){
                        $('.rent').show();
                        $(".rent :input").addClass('edit-form-input');

                    }else{
                        $('.rent').hide();
                        $(".rent :input").removeClass('edit-form-input');

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
        })

        $('.datatable').on('click','#delete-property',function(event){
            event.preventDefault();
            $object = $(this);
            var id  = $(this).attr('data-type');
            var url = baseUrl+"/admin/property/delete/"+id;
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
                        url: "{{ route('admin.property.change-status') }}",
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
                        url: "{{ route('admin.property.sold') }}",
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
                        url: "{{ route('admin.property.paid') }}",
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
            var url = "{{route('admin.property.getusertype')}}";
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
                    console.log(response.data);
                    if(response.success == true){
                            // var value = response.usertype;
                            // var option = '';
                            //
                            // $.each(value, function(key, value) {
                            //
                            //     option  +='<option selected="selected" value="'+value.id+'">'+value.name+'</option:selectedoption>';
                            // });

                            $('#usertype').html(response.data);
                        }else{
                            $('#usertype').empty();
                        }

                    }
                })
        }

        $("#usertype").on("change", function(){
            var id =  $(this).val();
            var url = "{{route('admin.property.getuser')}}";
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
        $('#propertyUpload').change(function(){
            $('.propertyUpload  label').removeClass('invalid');
            readImgUrlAndPreview(this);
            function readImgUrlAndPreview(input){
                $('#hide-upload #propertyPreview').css('display','block');
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#hide-upload #propertyPreview').attr('src', e.target.result);
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        })

        $('#paperUpload').change(function(){

            readImgUrlAndPreview(this);
            function readImgUrlAndPreview(input){
                $('#hide-upload #paperPreview').css('display','block');
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#hide-upload #paperPreview').attr('src', e.target.result);
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        })
        $('#ownerUpload').change(function(){

            readImgUrlAndPreview(this);
            function readImgUrlAndPreview(input){
                $('#hide-upload #ownerPreview').css('display','block');
                $('#hide-upload #ownerPreview-edit').css('display','none');
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#hide-upload #ownerPreview').attr('src', e.target.result);
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        })
        $('#lalapurjaUpload').change(function(){

            readImgUrlAndPreview(this);
            function readImgUrlAndPreview(input){
                $('#hide-upload #lalapurjaPreview').css('display','block');
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#hide-upload #lalapurjaPreview').attr('src', e.target.result);
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        })
    });
</script>




@endsection