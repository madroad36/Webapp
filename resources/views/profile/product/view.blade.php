@extends('profile.app')
@section('title', 'Product List')

@section('main-content')

    <div class="container">
        <h3 class="profile-menu-title">My Product List</h3>
        <div class="line-margin"></div>
        <div class="tablist">
            <div class="row">

                @foreach($products as $product)
                    <div class="col-lg-4 ">
                        <div id="product-{{$product->id}}">
                            <div class="card" style="width: 18rem; border: 1px solid #000000;">
                                @if(file_exists('storage/'. $product->image) &&  $product->image != '')
                                    <img class="card-img-top" style=" height:200px;"
                                         src="{{asset('storage/'. $product->image)}}" alt="{{ $product->title}}">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{$product->title}}</h5>

                                    <div class="car-content">
                                        <div class="card-content-left">
                                            <p>Piece <span>{{$product->quantity}}</span></p>
                                        </div>
                                        <div class="card-content-rigth">
                                            <p>Rs- <span>{{$product->price}}</span></p>
                                        </div>
                                    </div>
                                    <div class="car-price-list"></div>

                                    {{--                                    <h6 class="card-subtitle mb-2 text-muted"--}}
                                    {{--                                        style="margin-top: 20px;">{{$order->product->category->title}}</h6>--}}
                                    {{--                                    <span>Bill No <p>{{$order->serial_number}}</p></span>--}}
                                    {{--                                    <span>{{$order->quantity}}</span>--}}
                                    {{--                                    <span>Price<P>Rs-{{$order->quantity*$order->product->price}}</P></span>--}}

                                    {{--                                    <a href="javascript:void(0)" onclick="productDelete(this.id)"--}}
                                    {{--                                       id="{{$order->id}}"--}}
                                    {{--                                       class="card-link">Remove</a>--}}
                                    {{--                                    <a href="{{route('product.show',[$order->slug])}}" class="card-link" data-toggle="modal"  data-target=".product-edit-{{$order->id}}">Edit</a>--}}
                                    <a href="javascript:void(0)" onclick="productDelete(this.id)"
                                       id="{{$product->id}}"
                                       class="card-link">Remove</a>
                                    <a href="{{route('product.show',[$product->slug])}}" class="card-link" data-toggle="modal"  data-target=".product-edit-{{$product->id}}">Edit</a>
                                    <a href="{{route('product.show',[$product->slug])}}" class="card-link">View
                                    </a>
                                </div>
                            </div>
                            @include('profile.product.edit')
                        </div>
                    </div>

{{--                    <div class="col-lg-4 ">--}}
{{--                        <div id="product-{{$product->id}}">--}}
{{--                            <div class="card" style="width: 18rem; border: 1px solid #000000;">--}}
{{--                                <div class="card-body">--}}


{{--                                    @if(file_exists('storage/'. $product->image) &&  $product->image != '')--}}
{{--                                        <img class="card-img-top" style=" height:200px;"--}}
{{--                                             src="{{asset('storage/'. $product->image)}}" alt="{{ $product->title}}">--}}
{{--                                    @endif--}}
{{--                                        <h5 class="card-title">{{$product->title}}</h5>--}}
{{--                                    <h6 class="card-subtitle mb-2 text-muted"--}}
{{--                                        style="margin-top: 20px;">{{$product->category->title}}</h6>--}}

{{--                                    <a href="javascript:void(0)" onclick="productDelete(this.id)"--}}
{{--                                       id="{{$product->id}}"--}}
{{--                                       class="card-link">Remove</a>--}}
{{--                                    <a href="{{route('product.show',[$product->slug])}}" class="card-link" data-toggle="modal"  data-target=".product-edit-{{$product->id}}">Edit</a>--}}
{{--                                    <a href="{{route('product.show',[$product->slug])}}" class="card-link">View--}}
{{--                                        </a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        --}}
{{--                    </div>--}}

                @endforeach


                <nav class="pagination-nav" aria-label="Page navigation  ">
                    {{  $products->links('vendor.pagination.default') }}
                </nav>

            </div>
        </div>
    </div>

@endsection

@section('js_script')
    <script type="text/javascript">
        function productDelete(data) {

            $object = $(this);

            var url = baseUrl + "/product/delete/" + data;

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
                        success: function (products) {


                            $('.tablist').html(products);


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
                            url: "{{ route('owner.product.change-status') }}",
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
            // $('.image-wrapper').on('click','.hovereffect a.info',function(event){
            //     event.preventDefault();
            //     alert('hello this is check');
            //     $object = $(this);
            //     var id  = $(this).attr('data-type');
            //     var url = baseUrl+'product_image/delete';
            //     swal({
            //         title: 'Are you sure?',
            //         text: 'You will not be able to recover this !',
            //         type: 'warning',
            //         showCancelButton: true,
            //         confirmButtonText: 'Yes, delete it!',
            //         cancelButtonText: 'No, keep it'
            //     }).then((result) => {
            //         if (result.value
            //         )
            //         {
            //
            //             $.ajax({
            //                 type: 'POST',
            //                 url: url,
            //                 data: {
            //                     id: id,
            //
            //                 },
            //                 headers: {
            //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //                 },
            //                 success: function (response) {
            //                     swal("Deleted!", response.image.image, "success");
            //                     console.log(response.image.image);
            //                     var nRow = document.getElementById(response.image.id);
            //                     nRow.remove();
            //                 },
            //                 error: function (e) {
            //                     if (e.responseJSON.message) {
            //                         swal('Error', e.responseJSON.message, 'error');
            //                     } else {
            //                         swal('Error', 'Something went wrong while processing your request.', 'error')
            //                     }
            //                 }
            //             });
            //         }
            //     })
            // });

        });
    </script>
@endsection