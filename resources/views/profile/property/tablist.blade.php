<div class="row">

    @foreach($properties as $property)

        <div class="col-lg-4 ">
            <div id="property-{{$property->id}}">
                <div class="card" style="width: 18rem; border: 1px solid #000000;">
                    <div class="card-body property-edit">
                        <h5 class="card-title">{{$property->title}}</h5>

                        @if(file_exists('storage/'. $property->thumbnail) &&  $property->thumbnail != '')
                            <img class="card-img-top" style=" height:200px;"
                                 src="{{asset('storage/'. $property->thumbnail)}}" alt="{{ $property->title}}">
                        @endif

                        <h6 class="card-subtitle mb-2 text-muted"
                            style="margin-top: 20px;">{{$property->category->title}}</h6>
                        {{--<p class="card-text">{!! str_limit($product->description,'100','....') !!}.</p>--}}
                        <a href="javascript:void(0)" onclick="productDelete(this.id)"
                           id="{{$property->id}}"
                           class="card-link">Remove</a>
                        <a href="javascript:void(0)" class="card-link property-edit-form" onclick="propertyModal(this)" data-category-name="{{$property->category->name}}" data-category="{{$property->category_id}}" role="{{route('property.edit',[$property->slug])}}"  data-type="property-edit-{{$property->id}}" data-toggle="modal">Edit</a>
                        <a href="{{route('property.show',[$property->slug])}}" class="card-link">View
                        </a>
                    </div>
                </div>
            </div>

        </div>

    @endforeach


    <nav class="pagination-nav" aria-label="Page navigation">
        {{--{{  $properties->links('vendor.pagination.default') }}--}}
    </nav>

    <div class="property-ajax-edit">

    </div>

</div>