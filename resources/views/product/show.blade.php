@extends('frontend.app')
@section('title', $product->title)
@section('main-content')

<div class="container-fluid">
    <div class="row mt-3">
        {{-- Left sidebar --}}
        <div class="col-md-3">
            <div class="left-sidebar">
                {{-- Sidebar card --}}
                <div class="card">
                    <div class="card-body">
                        {{-- Sidebar card heading --}}
                        <div class="title">
                            <h3 class="card-title">Category</h3>
                        </div>
                        {{-- Sibar card content --}}
                        <div class="content px-3">
                            <ul class="list-unstyled">
                                @foreach($categorylist  as $category)
                                    <li class="{{ $category->id== $product->category_id   ? 'active mb-1' : 'mb-1' }}">
                                        <a href="{{route('product.category.show',[$category->slug])}}">
                                            <i class="fas fa-chevron-right pr-2"></i>{{$category->title}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Product Listing --}}
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-4">
                    {{-- @if(file_exists('storage/'.$product->image) && $product->image !='')
                        <img src="{{asset('storage/'.$product->image)}}" alt="{{$product->title}}">
                        @endif --}}
                    <div class="single-product-img">
                        <img src="{{asset('frontend/img/singleproduct.jpg')}}"/>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="single-product">
                            <div class="single-product-title col-12">
                                <h4>{{$product->title}}</h4>
                            </div>
                            <div class="product-category col-12 pb-2">
                                <span>Category: {{$product->category->title}}</span>
                            </div>
                            <div class="line"></div>
                            <div class="product-price col-12 pt-3">
                                <p>Rs: <span>{{$product->price}} {{$product->unit}}</span></p>
                            </div>
                            <div class="col-12">
                                @if(session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                                @endif

                                {!! Form::open(array('route'=>['cart.add'])) !!}
                                <div class="d-flex">
                                    <div class="total-quantity my-auto pr-2">
                                        <span id="product-total-order-quantitly">{{$product->quantity}}</span>
                                        <span>Items left</span>
                                    </div>
                                    <input type="hidden" name="id" value="{{$product->id}}">
                                    <button type="button" class="btn btn-left altera decrescimo">-</button>
                                        <input type="number" name="quantity" id="stepper-input" placeholder="0" class="cart-increment-value" value="1">
                                    <button type="button" class="btn  btn-right altera acrescimo">+</button>
                                </div>
                                @if ($errors->has('quantity'))
                                <div class="alert alert-danger">{{ $errors->first('quantity') }}</div>
                                @endif
                                <button type="submit" id="cart-submit" class="btn btn-primary mt-3 mb-2">Add to Cart</button>
                                {!! Form::close() !!}         
                        </div>
                        <div class="line"></div>
                        <div class=" col-12 product-content-details">
                            <p style="font-weight:300;">{!! $product->description !!}</p>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>


@endsection
@section('js_script')
<script type="text/javascript">
    $(document).ready(function () {
        var quantity = $('#product-total-order-quantitly').text();
        var cartValue = $('.cart-increment-value').val();
        $('#stepper-input').focusout(function(){
            var value = $(this).val();
            if (value > parseInt(quantity) || value == 0) {
                $('.cart-increment-value').css('border','1px solid red');
                $('#cart-submit').prop("disabled", true);
                $('.decrescimo').prop("disabled", true);

            }else{
                $('.cart-increment-value').val(value);
                $('#cart-submit').removeAttr("disabled");
                $('.decrescimo').removeAttr("disabled");
            }
        });
        current = 1;
        $('.altera ').click(function(event) {
            event.stopImmediatePropagation();
            var quantity = $('#product-total-order-quantitly').text();
            var data = $('.cart-increment-value').val();
            if (data < parseInt(quantity)) {
                if ($(this).hasClass('acrescimo')) {
                    var value =Number(data)+1;
                    $('.cart-increment-value').val(value);
                    $('#cart-submit').removeAttr("disabled");
                    $('.decrescimo').removeAttr("disabled");
                    $('.cart-increment-value').css('border','1px solid #f79421').css('background','white').css('color','black'); 
                }
            }
            if (data > 0){
                if ($(this).hasClass('decrescimo')) {
                    if(data >1){
                        var value =Number(data)-1;
                        $('.cart-increment-value').val(value);
                    }else{
                        $('.cart-increment-value').css('background','#ff605c').css('color','white');  
                        $('.decrescimo').prop("disabled", true);
                    }
                }
            }
        });
        $('#add-cart').unbind("click").click(function(event){
            event.preventDefault();
            cl
            var id = $(this).attr('data-type');
            var url = '{{route('cart.add')}}';
            var quantity = $('#total-item option:selected').val();
            if (quantity == 0) {
                $('#total-item').after('<span class="error" style="color: red; display: block;margin-top: -28px;margin-bottom: 20px;">Please Select Quantity</span>');
                return false;
            }
            $.ajax({
                type:'get',
                url:url,
                data:{id:id,quantity:quantity},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'html',
                success: function (response) {
                    swal("Thank You!", response.message, "success");
                }
            });
        });
    });
</script>
@endsection