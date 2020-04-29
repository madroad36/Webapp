@extends('profile.app')
@section('title', 'Service order List')

@section('main-content')
    <div class="container">
        <h3>List of order services</h3>
        <div class="row">
            @php $totalnumber  =0; @endphp
            @foreach($services as $servicerequest)
                <div class="col-lg-4">
                    <div class="service-lists">
                        <a href="{{route('subcategory.show',[$servicerequest->service->slug])}}" class="service-name">
                            @if(file_exists('storage/'.$servicerequest->service->thumbnail) && $servicerequest->service->thumbnail !='')
                                <img src="{{asset('storage/'.$servicerequest->service->thumbnail)}}" alt="{{$servicerequest->service->title}}">
                            @endif
                            {{--                            <div class="overlay">--}}
                            {{--                                <div class="text">{{$service->title}}</div>--}}
                            {{--                            </div>--}}
                        </a>
                        <div class="service-details">
                            <div class="service-content">
                                <p>Title: <span>{{$servicerequest->service->title}}</span></p>
                                <p>Rate: <span>{{$servicerequest->service->rate}} / {{$servicerequest->service->rate_type}}</span></p>
                            </div>
                            <div class="service-brnt auth-order-service">
                                <a href="{{route('servicerequest.delete',[$servicerequest->id])}}" class="btn  remove-btn">Remove</a>
                                <a href="{{route('order.service.show',[$servicerequest->service->id])}}" class="btn  edit-btn">View Details</a>
                            </div>
                        </div>
                    </div>
                    {{--                    <div class="card" style="width: 18rem; border: 1px solid #000000;">--}}
                    {{--                        <div class="card-body">--}}
                    {{--                            <h5 class="card-title">{{$service->service->title}}</h5>--}}
                    {{--                            <h6 class="card-subtitle mb-2 text-muted">{{$service->service->subcategory->title}}</h6>--}}
                    {{--                            @if($service->is_active == 1)--}}
                    {{--                                <span>Closed</span>--}}
                    {{--                            @else--}}

                    {{--                                <span>Running</span>--}}
                    {{--                            @endif--}}


                    {{--                            <span>{{$service->created_at->todatestring()}}</span>--}}
                    {{--                            <p class="card-text">{!! str_limit($service->service->description,'100','....') !!}.</p>--}}
                    {{--                            <a href="{{route('servicerequest.delete',[$service->id])}}" class="card-link">Remove</a>--}}
                    {{--                            <a href="{{route('order.service.show',[$service->id])}}" class="card-link">View Details</a>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                </div>
            @endforeach

        </div>
        <nav aria-label="Page navigation example mx-auto" style="width: 400px; margin:0 auto;">
            {{  $services->links('vendor.pagination.default') }}

        </nav>
    </div>
@endsection
@section('js_script')
    <script type="text/javascript">
        {{--$(document).ready(function () {--}}


        {{--    $(".datatable").DataTable({--}}
        {{--        processing: true,--}}
        {{--        serverSide: true,--}}

        {{--        ajax: {--}}
        {{--            url: '{{route('broker.property.getdata')}}',--}}
        {{--            type: "GET",--}}
        {{--            cache: false--}}
        {{--        },--}}
        {{--        columns: [--}}
        {{--            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: "false"},--}}
        {{--            {data: 'title', name: 'title', orderable: "false"},--}}
        {{--            {data: 'category', name: 'category', orderable: "false"},--}}
        {{--            {data: 'subcategory', name: 'subcategory', orderable: "false"},--}}
        {{--            {data: 'location', name: 'location', orderable: "false"},--}}
        {{--            {data: 'place', name: 'place', orderable: "false"},--}}
        {{--            {data: 'price', name: 'price', orderable: "false"},--}}
        {{--            {data: 'broker_name', name: 'broker_name', orderable: "false"},--}}
        {{--            {data: 'sold', name: 'sold', orderable: "false"},--}}
        {{--            {data: 'status', name: 'status', orderable: "false"},--}}

        {{--            {data: 'action', name: 'action', orderable: false, searchable: false}--}}

        {{--        ]--}}
        {{--    });--}}


        {{--    $(".datatable").on("click", "#item-sold", function () {--}}
        {{--        $object = $(this);--}}
        {{--        var id = $(this).attr('data-type');--}}
        {{--        swal({--}}
        {{--            title: 'Are you sure?',--}}
        {{--            text: 'Do you want to change the status',--}}
        {{--            type: 'warning',--}}
        {{--            showCancelButton: true,--}}
        {{--            confirmButtonText: 'Yes, change it!',--}}
        {{--            cancelButtonText: 'No, keep it'--}}
        {{--        }).then((result) => {--}}
        {{--            if (result.value) {--}}
        {{--                $.ajax({--}}
        {{--                    type: "POST",--}}
        {{--                    url: "{{ route('auth.property.sold') }}",--}}
        {{--                    data: {--}}
        {{--                        'id': id,--}}
        {{--                    },--}}
        {{--                    headers: {--}}
        {{--                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--                    },--}}
        {{--                    dataType: 'json',--}}
        {{--                    success: function (response) {--}}
        {{--                        swal("Thank You!", response.message, "success");--}}
        {{--                        if (response.property.is_active == 1) {--}}
        {{--                            $($object).children().removeClass('fa fa-minus');--}}
        {{--                            $($object).children().addClass('fa fa-check');--}}
        {{--                        } else {--}}
        {{--                            $($object).find('.unpublished').html('<i class="fa fa-minus" aria-hidden="true"></i>');--}}
        {{--                            $($object).children().removeClass('fa fa-check');--}}
        {{--                            $($object).children().addClass('fa fa-minus');--}}
        {{--                        }--}}
        {{--                    },--}}
        {{--                    error: function (e) {--}}
        {{--                        if (e.responseJSON.message) {--}}
        {{--                            swal('Error', e.responseJSON.message, 'error');--}}
        {{--                        } else {--}}
        {{--                            swal('Error', 'Something went wrong while processing your request.', 'error')--}}
        {{--                        }--}}
        {{--                    }--}}
        {{--                });--}}

        {{--            }--}}
        {{--        })--}}
        {{--    });--}}


        {{--});--}}

    </script>
@endsection