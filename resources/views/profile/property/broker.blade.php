@extends('profile.app')
@section('title', 'Broker Property  List')

@section('main-content')

    <div class="container">

        <h3 class="profile-menu-title">Broker Properties List</h3>
        <div class="line-margin"></div>
        <div class="tablist proprety-form">
            <div class="row">

                @foreach($properties as $property)

                    <div class="col-lg-4 ">
                        <div id="property-{{$property->id}}">
                            <div class="card">
                                @if(file_exists('storage/'. $property->thumbnail) &&  $property->thumbnail != '')
                                    <img class="card-img-top" style=" height:200px;"
                                         src="{{asset('storage/'. $property->thumbnail)}}" alt="{{ $property->title}}">
                                @endif
                                <div class="car-btn-link">
                                    <span>{{$property->category->name}}</span>
                                    <span class="span-sub">{{$property->subcategory->title}}</span>
                                </div>
                                <div class="card-creaed-date">

                                    @php $year = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $property->created_at)->year; @endphp
                                    @php $month = $property->created_at->format('M'); @endphp
                                    @php $day = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $property->created_at)->day;@endphp
                                    <span>{{$day}} {{$month}} {{$year}}</span>

                                </div>
                                <div class="property-detial-btn">
                                    <a href="javascript:void(0)" data-toggle="tooltip" title="edit-property"  class="card-link property-edit-form" onclick="propertyModal(this)" data-category-name="{{$property->category->name}}" data-category="{{$property->category_id}}" role="{{route('property.edit',[$property->slug])}}"  data-type="property-edit-{{$property->id}}" data-toggle="modal"><i class="fa fa-edit"></i></a>
                                    <a href="{{route('property.show',[$property->slug])}}" data-toggle="tooltip" title="view-property" class="card-link"><i class="fa fa-eye"></i></a>

                                </div>
                                <div class="card-body property-edit">


                                    <h5 class="card-title">{{str_limit($property->title,'26','.')}}</h5>
                                    <p><i class="fa fa-map-marker"></i>{{$property->location->name}} <span>:</span> {{$property->place->name}}</p>
                                    {{--<h6 class="card-subtitle mb-2 text-muted" style="margin-top: 20px;">{{$property->category->title}}</h6>--}}
                                    {{--<p class="card-text">{!! str_limit($product->description,'100','....') !!}.</p>--}}
                                    <span>Rs</span>{{number_format($property->price)}}

                                </div>
                            </div>
                        </div>

                    </div>

                @endforeach


                <nav class="pagination-nav" aria-label="Page navigation">
                    {{  $properties->links('vendor.pagination.default') }}
                </nav>

                <div class="property-ajax-edit">

                </div>

            </div>
        </div>
    </div>
@endsection
@section('js_script')
    <script type="text/javascript">
        $(document).ready(function() {


            $(".datatable").DataTable({
                processing: true,
                serverSide: true,

                ajax: {
                    url:'{{route('broker.property.getdata')}}',
                    type:"GET",
                    cache: false
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: "false"},
                    {data: 'title', name: 'title', orderable: "false"},
                    {data: 'category', name: 'category', orderable: "false"},
                    {data: 'subcategory', name: 'subcategory', orderable: "false"},
                    {data: 'location', name: 'location', orderable: "false"},
                    {data: 'place', name: 'place', orderable: "false"},
                    {data: 'price', name: 'price', orderable: "false"},
                    {data: 'broker_name', name: 'broker_name', orderable: "false"},
                    {data: 'sold', name: 'sold', orderable: "false"},
                    {data: 'status', name: 'status', orderable: "false"},

                    {data: 'action', name: 'action', orderable: false, searchable: false}

                ]
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
                            url: "{{ route('auth.property.sold') }}",
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







        });

    </script>
@endsection