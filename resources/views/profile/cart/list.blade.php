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
        @php $count=0; @endphp
        @php $totalAmout=0; $totalquantity=0;@endphp
        @foreach($cart->items as $key=>$value)
            <tr>
                <td>{{ $count = $count+1}}</td>

                <td>{{$value['item']['title']}}</td>
                <td>{{$value['item']['quantity']}}</td>
                <td><img src="{{asset('storage/'.$value['item']['image'])}}"
                         style="width:100px; height:100px;"
                         alt="{{$value['item']['title']}}"></td>
                <td>{{$value['item']->category->title}}</td>
                <td>{{$value['item']['price']}}</td>
                <td>
                    <button type="button"  id="cart-add" class="cart-altera acrescimo" data-quantity="{{$value['item']['quantity']}}" data-type="{{$value['item']['id']}}" data-value="{{$value['peice']}}"><i class="fa fa-plus"></i></button>
                    <input type="text" name="quantity" id="cart-altera-input" data-quantity="{{$value['item']['quantity']}}" data-type="{{$value['item']['id']}}"  class="cart-increment-value"  value="{{$value['peice']}}">
                    <button type="button"  id="cart-sub"  class="cart-altera decrescimo" data-quantity="{{$value['item']['quantity']}}" data-type="{{$value['item']['id']}}" data-value="{{$value['peice']}}"><i class="fa fa-minus"></i></button>
                </td>

                {{--                            <td><input type="number" min="0" data-type="{{$value['item']['id']}}" class="product-stepper" id="product-stepper" value="{{$value['quantity']}}"></td>--}}
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
            <td colspan="7"><input type="text" id="shipping-address" name="location"></td>
        </tr>
    @endif
    <tr>

        <td colspan="4">
            @if(!empty($cart->items))
                <a href="{{url('product/category/'.$url)}}" id="cart-back" class="btn ">Shop More</a>
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