@extends('layouts.backend.home')
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
			<li class="active">Add User</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Update User</h3><hr>
				<a href="{{route('admin.users.index')}}" class="btn btn-sm btn-info"><i class="fa fa-arrow-left" aria-hidden="true"></i>
Back</a>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-xs-8  col-xs-offset-2">
						@if ($errors->any())
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
						@endif

						{!! Form::model($user,[
							'url' =>route('admin.users.update',$user->id),
							'enctype' => 'multipart/form-data',
							]) !!}
							{{--<form role="form aling-center">--}}
								<!-- text input -->
								<div class="form-group">
									{{-- Name --}}
									<label>Name:</label>
									{{Form::text("name",old("name"),
									[
									"class" => "form-control",
									"placeholder" => "Enter Name"
									])
								}}
								@if($errors->has('name'))
								<span class="text-danger">*{{$errors->first('name')}}</span>
								<br>
								@endif
							</div>

							{{-- User Types	--}}
							<div class="form-group">
								<label>User Type</label>
								{!!  Form::select('usertype_id', $select, null, ['placeholder' => 'Pick a size...', 'class'=>'form-control'])	!!}
								@if ($errors->has('usertype_id'))
								<div class="alert alert-danger">{{ $errors->first('usertype_id') }}</div>
								@endif

							</div>

							{{-- Address --}}
							<!-- textarea -->
							<div class="form-group">
								<label>address:</label>
								{{Form::text("address",old("address"),
								[
								"class" => "form-control",
								"placeholder" => "Enter Address"
								])
							}}
							@if($errors->has('address'))
							<span class="text-danger">*{{$errors->first('address')}}</span>
							<br>
							@endif
						</div>


						{{-- Contact --}}
						<!-- textarea -->
						<div class="form-group">
							<label>contact:</label>
							{{Form::text("contact",old("contact"),
							[
							"class" => "form-control",
							"placeholder" => "Enter Contact"
							])
						}}
						@if($errors->has('contact'))
						<span class="text-danger">*{{$errors->first('contact')}}</span>
						<br>
						@endif
					</div>
					<div class="form-group">
						{{-- Email --}}
						<label>Email:</label>
						{{Form::text("email",old("email"),
						[
						"class" => "form-control",
						"placeholder" => "Enter Email"
						])
					}}
					@if($errors->has('email'))
					<span class="text-danger">*{{$errors->first('email')}}</span>
					<br>
					@endif
				</div>

				<div class="form-group">
					<label>Password</label>
					<input type="password" class="form-control" name="password" rows="3" placeholder="Password" value="{{ old('password') }}" required>
					@if ($errors->has('password'))
					<div class="alert alert-danger">{{ $errors->first('password') }}</div>
					@endif

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

	});
</script>




@endsection