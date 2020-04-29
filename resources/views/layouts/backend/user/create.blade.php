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
                <h3 class="box-title">Add User</h3>
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

                        {!! Form::open(array('route'=>'admin.users.store','class'=>'','enctype'=>'multipart/form-data')) !!}
                        {{--<form role="form aling-center">--}}
                            <!-- text input -->
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label>User Type</label>
                                <select name="usertype_id" class="form-control">
                                    <option>Select The User Type</option>
                                    @foreach($usertype as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('usertype_id'))
                                <div class="alert alert-danger">{{ $errors->first('usertype_id') }}</div>
                                @endif

                            </div>

                            <!-- textarea -->
                            {{--<div class="form-group">--}}
                                {{--<label>Address</label>--}}
                                {{--<input class="form-control" name="address" rows="3" placeholder="Address" value="{{ old('address') }}">--}}
                                {{--@if ($errors->has('address'))--}}
                                {{--<div class="alert alert-danger">{{ $errors->first('address') }}</div>--}}
                                {{--@endif--}}

                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                                {{--<label>Phone</label>--}}
                                {{--<input class="form-control" name="phone" rows="3" placeholder="Phone" value="{{ old('phone') }}">--}}
                                {{--@if ($errors->has('phone'))--}}
                                {{--<div class="alert alert-danger">{{ $errors->first('phone') }}</div>--}}
                                {{--@endif--}}

                            {{--</div>--}}
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" name="email" rows="3" placeholder="Email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                                @endif

                            </div>
                            {{--<div class="form-group">--}}
                                {{--<label>Logo</label>--}}
                                {{--<input type="file" id="user-image" name="image"  placeholder="Enter ...">--}}
                                {{--<img id="user-preview" src="#" alt="your image" style="display:none;width:200px;height:200px;margin-left:30%;margin-top: -6%;"/>--}}
                                {{--@if ($errors->has('image'))--}}
                                {{--<div class="alert alert-danger">{{ $errors->first('image') }}</div>--}}
                                {{--@endif--}}

                            {{--</div>--}}
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" rows="3" placeholder="Password" value="{{ old('password') }}">
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