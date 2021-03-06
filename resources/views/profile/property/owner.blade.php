@extends('profile.app')
@section('title', 'Owner Property List')

@section('main-content')

    <div class="container">
        <h3 class="profile-menu-title">My Properties List</h3>
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
                                        <a href="javascript:void(0)" onclick="productDelete(this.id)" data-toggle="tooltip" title="delete-property"
                                           id="{{$property->id}}"
                                           class="card-link"><i class="fa fa-trash"></i></a>
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
                            <a href="javascript:void(0)" data-toggle="modal"
                               data-target=".property-booking-list" data-type="{{route('booking.update',[$property->id])}}" class="btn property-sold-btn">Buyer List</a>
                       @include('profile.property.bookinglist')
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
@include('profile.property.editmessage')
    @include('profile.property.image')
@endsection

@section('js_script')


    <script type="text/javascript">


        function productDelete(data) {

            $object = $(this);

            var url = baseUrl + "/property/delete/" + data;

            swal({
                title: 'Are you sure?',
                text: 'You will not be able to recover this !',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.value
                ) {

                    $.ajax({
                        type: "Delete",
                        url: url,
                        data: {
                            id: data,
                            _method: 'DELETE'
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'html',
                        success: function (properties) {


                            $('.tablist').html(properties);


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
        }


        $(document).ready(function () {


            $(".datatable").on("click", "#change-booking", function () {
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
                            url: "{{ route('booking.property.change-status') }}",
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
                                    $($object).children().removeClass('fa fa-close');
                                    $($object).children().addClass('fa fa-check-circle');
                                } else {
                                    $($object).find('.unpublished').html('<i class="fa fa-minus" aria-hidden="true"></i>');
                                    $($object).children().removeClass('fa fa-check-circle');
                                    $($object).children().addClass('fa fa-close');
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

            $(".datatable").on("click", "#paid", function () {
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
                            url: "{{ route('owner.product.paid') }}",
                            data: {
                                'id': id,
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: 'json',
                            success: function (response) {

                                swal("Thank You!", response.message, "success");
                                if (response.response.paid == 1) {
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
