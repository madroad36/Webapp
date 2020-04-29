<div class="row">

    @foreach($products as $product)

        <div class="col-lg-4 ">
            <div id="product-{{$product->id}}">
                <div class="card" style="width: 18rem; border: 1px solid #000000;">
                    <div class="card-body">
                        <h5 class="card-title">{{$product->title}}</h5>

                        @if(file_exists('storage/'. $product->image) &&  $product->image != '')
                            <img class="card-img-top" style=" height:200px;"
                                 src="{{asset('storage/'. $product->image)}}" alt="{{ $product->title}}">
                        @endif

                        <h6 class="card-subtitle mb-2 text-muted"
                            style="margin-top: 20px;">{{$product->category->title}}</h6>
                        <p class="card-text">{!! str_limit($product->description,'100','....') !!}.</p>
                        <a href="javascript:void(0)" onclick="productDelete(this.id)"
                           id="{{$product->id}}"
                           class="card-link">Remove</a>
                        <a href="{{route('product.show',[$product->sllug])}}" class="card-link">View
                            Details</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <nav class="pagination-nav" aria-label="Page navigation  ">
        {{  $products->links('vendor.pagination.default') }}
    </nav>

</div>