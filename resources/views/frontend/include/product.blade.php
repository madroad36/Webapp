<div class="carousel-item">
  @if($slider['product'])
      <img src="{{asset('storage/'.$slider['product'])}}" alt="Los Angeles" >
  @else
  <img src="{{asset('frontend/img/product.jpg')}}" alt="Chicago" >
  @endif
  <div class="carousel-caption">
    <div class="carousel-caption-heading">
      <h3>Home and Office Products</h3>
      <Span>Looking for a Home and Office Products? We are here for you</Span>
    </div>

    {!! Form::open(array('route'=>'product.home.search','id'=>'property-form')) !!}
    <div class="row">
      <div class="form-group col-lg-12">
        @if(count($productCategories) > 0)
        @php $cat = [] @endphp
        @foreach($productCategories as $category)
        @php $cat[$category->id] = $category->title @endphp
        @endforeach
        {!! Form::select('category_id',$cat,null,['class'=>'selectpicker','data-width'=>'100%','id'=>'product-category']) !!}
        @else
        <select name="product-category" id="product-category" class="selectpicker" data-width="100%" title="Select a Category">
          <option value="office-chairs">Office Chairs</option>
          <option value="bed">Bed</option>
        </select>
        @endif
        @if ($errors->has('category_id'))
        <div class="alert alert-danger">{{ $errors->first('category_id') }}</div>
        @endif
      </div>
      <div class="form-group col-lg-12">
        <input type="text" class="form-control" name="title" id="product-name" placeholder="what you are looking for?">
      </div>
      <div class="form-group col-lg-12">
        <button type="submit" class="btn btn-zprimary">Search</button>
      </div>
    </div>
    {!! Form::close(); !!}
  </div>   
</div>