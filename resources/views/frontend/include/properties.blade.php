 <div class="carousel-item active">
  @if($slider['property'])
  <img src="{{asset('storage/'.$slider['property'])}}" alt="Los Angeles" >
   @else
   <img src="{{asset('frontend/img/propertie.jpg')}}" alt="Chicago" >
   @endif
   <div class="carousel-caption">
    <div class="carousel-caption-heading">
      <h3>Search Properties</h3>
      <Span>Looking for a propertes? We are here for you</Span>
    </div>

    {!! Form::open(array('route'=>'property.home.search','id'=>'property-form','class'=>'col-md-12')) !!}
    <div class="row">
      <div class="form-group col-lg-6">
       @if(count($locations) > 0)
       @php $location = [] @endphp
       @foreach($locations  as $value)
       @php $location[$value->id] = $value->name @endphp
       @endforeach
       {!! Form::select('location_id',$location,null,[ 'id'=>'location','class'=>'selectpicker','data-width'=>'100%','placeholder'=>'Select Location']) !!}
       @else
       {!! Form::select('location_id',[],null,[ 'id'=>'location','class'=>'selectpicker','data-width'=>'100%','placeholder'=>'Select Location']) !!}
       @endif


       @if ($errors->has('location_id'))
       <div class="alert alert-danger">{{ $errors->first('location_id') }}</div>
       @endif
     </div>
     <div class="form-group col-lg-6">
      @if(count($places) > 0)
      @php $place = [] @endphp
      @foreach($places  as $value)
      @php $place[$value->id] = $value->name @endphp
      @endforeach
      {!! Form::select('place_id',$place,null,['id'=>'place','class'=>'selectpicker','data-width'=>'100%','placeholder'=>'Select The Area']) !!} 
      @else
      {!! Form::select('place_id',[],null,['id'=>'place','class'=>'selectpicker','data-width'=>'100%','placeholder'=>'Select The Area']) !!}
      @endif
      @if ($errors->has('place_id'))
      <div class="alert alert-danger">{{ $errors->first('place_id') }}</div>
      @endif
    </div>

    <div class="form-group col-lg-6">
      @if(count($categories) > 0)
      @foreach($categories as $category)
      @php $cat[$category->id] = $category->name @endphp
      @endforeach
      {!! Form::select('category_id',$cat,null,['class'=>'selectpicker','data-width'=>'100%','id'=>'category','placeholder'=>'Category']) !!}
      @else
      {!! Form::select('category_id',[],null,['class'=>'selectpicker','data-width'=>'100%','id'=>'category','placeholder'=>'Category']) !!}
      @endif
      @if($errors->has('category_id'))
      <div class="alert alert-danger">{{ $errors->first('category_id') }}</div>
      @endif
    </div>

    <div class="form-group col-lg-6">
      @if(count($subcategories) > 0)
      @php $subcategory = [] @endphp
      @foreach($subcategories  as $value)
      @php $subcategory[$value->id] = $value->title @endphp
      @endforeach
      {!! Form::select('subcategory_id',$subcategory,null,['class'=>'selectpicker','data-width'=>'100%','id'=>'subcategory','placeholder'=>'SubCategory']) !!}
      @else
      {!! Form::select('subcategory_id',[],null,['class'=>'selectpicker','data-width'=>'100%','id'=>'subcategory','placeholder'=>'SubCategory']) !!}
      @endif
    </div>
  </div>
  <button type="submit" class="btn btn-zprimary">Search</button>
  {!! Form::close(); !!}

</div>   
</div>