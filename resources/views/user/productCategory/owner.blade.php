@extends('user.layout.app')

@section('title', 'View Owner-Product-Category')

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
                <li class="active">Product Category</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Product Category List</h3>
                            <a href="{{route('auth.product_category.create')}}" class=" btn btn-primary " style="float: right"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Create Product Category</a>


                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table datatable">
                                <thead class=" text-primary">
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Created By</th>
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
                    url:'{{route('auth.product_category.createdBy',[Auth::user()->id])}}',
                    type:"GET",
                    cache: false
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: "false"},
                    {data: 'title', name: 'title', orderable: "false"},
                    {data: 'created_by', name: 'created_by', orderable: "false"},


                ]
            });



        });
    </script>




@endsection