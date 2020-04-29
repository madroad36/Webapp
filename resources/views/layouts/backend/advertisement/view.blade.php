@extends('layouts.backend.home')
@section('title', 'View Property Category')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Dashboard
			<small>Control panel</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
			<li class="active">Advertisement List</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Ads List</h3>
						<a href="{{route('admin.advertisement.create')}}" class=" btn btn-primary " style="float: right"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Add Advertisement</a>


					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<table class="table datatable">
							<thead class="text-primary">
								<tr>
									<th>Id</th>
									<th>Name</th>
									<th>Image</th>
									<th>Contact</th>
									<th>Price</th>
									<th>Index</th>
									<th>Started Date</th>
									<th>End Date</th>
									<th>Created By</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody style="margin-left: 5px;">

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



		$(".datatable").dataTable({
			processing: true,
			serverSide: true,

			ajax: {
				url:'{{route('admin.advertisement.getdata')}}',
				type:"GET",
				dataType:'json',
				cache: false
			},
			columns: [
			{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: "false"},
			{data: 'name', name: 'name', orderable: "false"},
			{data: 'image', name: 'image', orderable: "false"},
			{data: 'contact', name: 'contact', orderable: "false"},
			{data: 'price', name: 'price', orderable: "false", render: function(price){ return "Rs " + price + " /-"}},
			{data: 'index', name: 'index', orderable: "false"},
			{data: 'start_date', name: 'start_date', orderable: "false"},
			{data: 'end_date', name: 'end_date', orderable: "false"},
			{data: 'created_by', name: 'created_by', orderable: "false"},
			{data: 'status', name: 'status', orderable: "false"},
			{data: 'action', name: 'action', orderable: "false", searchable: "false"}

			]
		});
		$('.datatable').on('click','#delete-advertisement',function(event){
			event.preventDefault();
			$object = $(this);
			var id  = $(this).attr('data-type');
			var url = baseUrl+"/admin/advertisement/delete/"+id;
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
						url: "{{ route('admin.advertisement.change-status') }}",
						data: {
							'id': id,
						},
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						dataType: 'json',
						success: function (response) {
							swal("Thank You!", response.message, "success");
							if (response.property.status == 1) {
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