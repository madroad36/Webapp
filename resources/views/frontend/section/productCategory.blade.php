 <section class="product-category">
    <div class="home-display py-3">
        <div class="title">
            <h2>Product Category</h2>
            <span>What do you need?</span>
            <a href="#">view all products</a>
        </div>
        <div class="content pt-3">
            <ul id="productCategory">
             @if(count($productCategories) > 0)
             @foreach($productCategories as $key=>$category)
             @if($key < 6)
             <li>
              <div class="box">
                <a href="{{route('product.category.show',[$category->slug])}}">
                  <img src="{{asset('frontend/img/furniture.jpg')}}" alt="Avatar" class="image">
                  <div class="overlay"></div>
                  <input class="text" type="submit" name="submit" value="{{ucfirst($category->title)}}">
               </a>
            </div>
            </li>
            @endif
            @endforeach
            @endif 
        </ul>
    </div>
</div>
</section>