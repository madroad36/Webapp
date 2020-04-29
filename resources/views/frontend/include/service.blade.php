  <div class="carousel-item">
   @if($slider['service'])
   <img src="{{asset('storage/'.$slider['service'])}}" alt="Los Angeles" >
   @else
   <img src="{{asset('frontend/img/service.jpg')}}" alt="New York" >
   @endif
   <div class="carousel-caption">
    <div class="carousel-caption-heading">
      <h3>Professinal Services</h3>
      <Span>Want any Home and office Services?</Span>
    </div>
    {!! Form::open(array('route'=>'service.home.search','id'=>'service-form')) !!}
    <div class="row">
      <div class="form-group col-lg-12">
        @if(count($servicecategories) > 0)
        @php $cat = [] @endphp

        @foreach($servicecategories as $category)

        @php $cat[$category->id] = $category->name @endphp
        @endforeach
        {!! Form::select('category_id',$cat,null,['class'=>'selectpicker','data-width'=>'100%','id'=>'service-category','placeholder'=>'Category']) !!}
        @else
        <select name="service-category" id="service-category" class="selectpicker" data-width="100%" title="Select a Category">
          <option value="gardener">Gardener</option>
          <option value="carpenter">carpenter</option>
        </select>
        @endif
        @if ($errors->has('category_id'))
        <div class="alert alert-danger">{{ $errors->first('category_id') }}</div>
        @endif
      </div>
      <div class="form-group col-lg-12">
        <input type="text" name="title" class="form-control" id="service-name" placeholder="what you are looking for?">
      </div>
      <div class="form-group col-lg-12">
        <button type="submit" class="btn btn-zprimary">Search</button>
      </div>
    </div>
    {!! Form::close(); !!}
  </div> 
</div>