<div class="tablist proprety-form">
    <div class="row">

        @foreach($properties as $property)

            <div class="col-lg-3 ">
                <div id="property-{{$property->id}}">
                    <div class="card">
                        @if(file_exists('storage/'. $property->thumbnail) &&  $property->thumbnail != '')
                            <img class="card-img-top" style=" height:200px;"
                                 src="{{asset('storage/'. $property->thumbnail)}}" alt="{{ $property->title}}">
                        @endif
                        <div class="car-btn-link">
                            <span>{{$property->category->name}}</span>
                            <span class="span-sub">{{$property->subcategory['title']}}</span>
                        </div>
                        <div class="card-creaed-date">

                            @php $year = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $property->created_at)->year; @endphp
                            @php $month = $property->created_at->format('M'); @endphp
                            @php $day = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $property->created_at)->day;@endphp
                            <span>{{$day}} {{$month}} {{$year}}</span>

                        </div>
                        <div class="property-detial-btn">


                            <a href="{{route('property.show',[$property->slug])}}" data-toggle="tooltip" title="view-property" class="card-link"><i class="fa fa-eye"></i></a>

                        </div>
                        <div class="card-body property-edit">


                            <h5 class="card-title">{{str_limit($property->title,'26','.')}}</h5>
                            <p><i class="fa fa-map-marker"></i>{{$property->location->name}} <span>:</span> @if(!empty($property->place_id)) {{$property->place->name}} @endif</p>
                            {{--<h6 class="card-subtitle mb-2 text-muted" style="margin-top: 20px;">{{$property->category->title}}</h6>--}}
                            {{--<p class="card-text">{!! str_limit($product->description,'100','....') !!}.</p>--}}
                            <span>Rs</span>{{number_format($property->price)}}

                        </div>
                    </div>
                </div>

            </div>

        @endforeach


        <nav class="pagination-nav" aria-label="Page navigation">
            {{  $properties->links('vendor.pagination.default') }}
        </nav>

        <div class="property-ajax-edit">

        </div>

    </div>
</div>