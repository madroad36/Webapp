@extends('layouts.backend.home')
@section('title', 'Create Place')
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
                <li class="active">Add Place</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Add Place</h3>
                    <a href="{{route('admin.place.index')}}" class=" btn btn-primary " style="float: right"><i class="fa fa-eye" aria-hidden="true"></i> &nbsp; View Place </a>

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

                        {!! Form::open(array('route'=>'admin.place.store','class'=>'','enctype'=>'multipart/form-data')) !!}
                        {{--<form role="form aling-center">--}}
                        <!-- text input -->
                           
                                <div class="form-group">
                                    <label>City</label>
                                    @php $location = [] @endphp

                                    @foreach( $locations  as $value)

                                        @php $location[$value->id] = $value->name @endphp
                                    @endforeach
                                    {!! Form::select('location_id',$location,null,['class'=>'form-control','placeholder'=>'Select The Location']) !!}

                                    @if ($errors->has('location_id'))
                                        <div class="alert alert-danger">{{ $errors->first('location_id') }}</div>
                                    @endif

                                </div>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                        <div class="alert alert-danger">{{ $errors->first('name') }}</div>
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


        });
    </script>




@endsection