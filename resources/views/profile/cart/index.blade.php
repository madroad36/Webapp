@extends('frontend.app')
@section('title', 'Cart Page')

@section('main-content')
<main role="main">

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="service-banner-image " style="background: url('{{asset('frontend/img/cartpage.jpg')}}')">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-7 text-center aos-init " data-aos="fade">

                    <h1 class="service-banner-header">Product added to cart</h1>
                </div>
            </div>
        </div>

    </div>
</main>
<div class="container">

    <div class="box-body cart-page-style">
        @if ($message = Session::get('cart-message'))
        <div class="alert alert-info alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif
        @if(session()->has('flaserror'))
        <div class="alert alert-danger">
            {{ session()->get('flaserror') }}
        </div>
        @endif
        @if(!empty(Session::get('cart')))
        {!! Form::open(array('route'=>'cart.delete')) !!}
        {{ method_field('DELETE') }}
        <button id="cart-clear-btn"  type="submit">Clear Cart</button>
        {!! Form::close() !!}
        @endif
        <div class="table-responsive">
            <div class="cartlist">
              <table class="table datatable">
                <thead class=" text-primary">
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Total Stock</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Per-Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    @if(empty(Session::get('cart')))
                    <tr>
                        <td colspan="7" style="text-align: center;padding-top:20px;padding-bottom: 100px;">Product is
                            not added to the cart yet
                        </td>
                    </tr>
                    @else
                    @php $totalAmout=0; $totalquantity=0;@endphp
                    @foreach($cart->items as $key=>$value)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>{{$value['item']['title']}}</td>
                        <td>{{$value['item']['quantity']}}</td>
                        <td><img src="{{asset('../storage/app/public/'.$value['item']['image'])}}"
                           style="width:100px; height:100px;"
                           alt="{{$value['item']['title']}}"></td>
                           <td>{{$value['item']->category->title}}</td>
                           <td>{{$value['item']['price']}}</td>
                           <td>
                            <button type="button"  id="cart-add" class="cart-altera acrescimo" data-quantity="{{$value['item']['quantity']}}" data-type="{{$value['item']['id']}}" data-value="{{$value['peice']}}"><i class="fa fa-plus"></i></button>
                            <input type="text" name="quantity" id="cart-altera-input" data-quantity="{{$value['item']['quantity']}}" data-type="{{$value['item']['id']}}"  class="cart-increment-value"  value="{{$value['peice']}}">
                            <button type="button"  id="cart-sub"  class="cart-altera decrescimo" data-quantity="{{$value['item']['quantity']}}" data-type="{{$value['item']['id']}}" data-value="{{$value['peice']}}"><i class="fa fa-minus"></i></button>
                        </td>
                        <td>{{$value['price']}}</td>
                        <td>

                            <a class="btn btn-dark"  href="{{route('cart.remove',[$key])}}" ><i class="fa fa-trash"></i></a>

                        </td>
                        @php $totalAmout +=  $value['price'] @endphp
                        @php $totalquantity +=  $value['peice'] @endphp

                    </tr>
                    @if($loop->last)
                    @php $url = $value['slug']; @endphp
                    @endif
                    @endforeach
                    <tr>

                        @if(count($cart->items) > 0)
                        <td colspan="4">Total Item {{count($cart->items)}}</td>
                        <td> Total  </td>
                        <td></td>
                        <td>{{$totalquantity}}</td>
                        <td> {{$totalAmout}}</td>
                        <td></td>


                        @endif
                    </tr>
                    <tr>
                        <td colspan="2"> Shipping Address</td>
                        <td colspan="7"><input type="text" id="shipping-address" placeholder="Eg:Koteswor" name="location" style="box-shadow: 2px 1px 2px grey;"></td>
                    </tr>
                    @endif
                    <tr>

                        <td colspan="4">
                            @if(!empty($cart->items))
                            <a href="{{url('product/category/'.$url)}}"  id="cart-back" class="btn ">Shop More</a>

                            @endif
                        </td>
                        <td colspan="5">
                            @if(!empty($cart->items))
                            <a href="javascript:void(0)"  id="cart-confirm" class="btn btn-success">Checkout</a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>
<div class="modal fade cart-succee" tabindex="-1" id="cart-success" role="dialog" aria-labelledby="myLargeModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <div class="product-form-header">
                Successfull Message
            </div>
            <button type="button" id="product-message-modal"  data-dismiss="modal" aria-hidden="true">×</button>

        </div>
        <div class="modal-body">
            <P>Thank you we have received your order we will contact you soon at </P>
            @if(Auth::check())
            <p>Contact:<span id="booking-contact">{{auth()->user()->contact}}</span></p>
            <p>Email: <span id="booking-email">{{auth()->user()->email}}</span></p>
            <div class="modal-footer">
                @endif

            </div>
        </div>
    </div>
</div>
</div>

@endsection

@section('js_script')
<script type="text/javascript">
    $(document).ready(function () {

        $(document).on('focusout','.cartlist .datatable .cart-increment-value',function(){

            var id = $(this).attr('data-type');
            var quantity = $(this).val();
            var stock = $(this).attr('data-quantity');
            var url = baseUrl+"/cart/add/"+id;
            if(parseInt(quantity) <= parseInt(stock) && parseInt(quantity) != ''){

                cartupdate(id,quantity,url);
            }
            setTimeout(function(){
                $("#overlay-load").fadeOut(300);

            },500);
            $(this).css('border','1px solid red');


        });
            // $('.cart-altera ').click(function(event) {
            //
            //     event.stopImmediatePropagation();
            //     $("#overlay-load").fadeIn(300);
            //     var data = $(this).attr('data-value');
            //     var stock = $(this).attr('data-quantity');
            //     var id = $(this).attr('data-type');
            //     var url = baseUrl+"/cart/add/";
            //
            //
            //     if (parseInt(data) < parseInt(stock)) {
            //         console.log(Number(data)+1);
            //         if ($(this).hasClass('acrescimo')) {
            //             var quantity =Number(data)+1;
            //             debugger
            //             cartupdate(id,quantity,url);
            //         }
            //     }
            //     if (parseInt(data) > 0){
            //         if ($(this).hasClass('decrescimo')) {
            //             var quantity =Number(data)-1;
            //             cartupdate(id,quantity,url);
            //
            //         }
            //     }
            //
            // });



            $(document).on('click','.cartlist .datatable #cart-confirm',function(event) {
                event.stopImmediatePropagation();
                $("#overlay-load").fadeIn(5000);

                var url = baseUrl+"/cart/checkout";

                $.ajax({
                    type:'get',
                    url:url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'html',
                    success: function (response) {
                        setTimeout(function(){
                            $("#overlay-load").fadeOut(300);

                        },500);
                        $('#cart-success').modal('show');
                        $('#home-cart span').empty();
                        $('.cartlist').html(response);
                        event.preventDefault();
                    },error: function (xhr) {
                        console.log(xhr,'response')
                        setTimeout(function(){
                            $("#overlay-load").fadeOut(200);

                        },200);
                        $('#login').modal('show');
                        $('#login-url').val(baseUrl + "/cart/checkout/");
                    }


                });
            })
            $(document).on('focusout','.cartlist .datatable #shipping-address',function(){
                var location = $(this).val();
                $.ajax({
                    type:'Post',
                    url:'{{route('cart.location')}}',
                    data:{location:location},

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function (response) {

                    }
                });
            });
            $('#product-message-modal').on('click',function(){
                $('#cart-success').modal('toggle');
                $('#home-cart span').empty();
            });
        });
    $(document).on('click','.cartlist .datatable #cart-add',function(){
        $("#overlay-load").fadeIn(300);
        var data = $(this).attr('data-value');

        var stock = $(this).attr('data-quantity');
        var id = $(this).attr('data-type');
        var url = baseUrl+"/cart/add/";

        if (parseInt(data) <= parseInt(stock) && parseInt(data) != '') {
            var quantity = Number(data) + 1;
            cartupdate(id, quantity);

        }
        setTimeout(function(){
            $("#overlay-load").fadeOut(300);

        },500);
        $('#cart-altera-input').css('border','1px solid red');

    });
    $(document).on('click','.cartlist .datatable  #cart-sub',function(){
        $("#overlay-load").fadeIn(300);
        var data = $(this).attr('data-value');
        var stock = $(this).attr('data-quantity');

        var id = $(this).attr('data-type');
        var url = baseUrl+"/cart/add/";


        if (parseInt(data) <= parseInt(stock) && parseInt(data) != '') {
            var quantity =Number(data)-1;
            cartupdate(id,quantity);

        }
        setTimeout(function(){
            $("#overlay-load").fadeOut(300);

        },500);
        $('#cart-altera-input').css('border','1px solid red');

    });
    function cartupdate(id,quantity){

        $.ajax({
            type:'Post',
            url:baseUrl+"/cart/add/",
            data:{id:id,quantity:quantity},

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'html',
            success: function (cart) {
                $('.cartlist').html(cart);
                setTimeout(function(){
                    $("#overlay-load").fadeOut(300);

                },500);
                    // $('#cart-success').modal('show');
                }
            });
    }
</script>
@endsection