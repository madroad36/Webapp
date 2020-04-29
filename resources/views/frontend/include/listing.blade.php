<div class="carousel-item">
	@if($slider['listing'])
	<img src="{{asset('storage/'.$slider['listing'])}}" alt="Los Angeles" >
	@else
	<img src="{{asset('frontend/img/listing.jpg')}}" alt="New York" >
	@endif
	<div class="carousel-caption">
		<h3>Post your Properties with Zillicom</h3>
		<p>Free list your properties on zillicom and sell without worry.</p>
		@if(Auth::check())
		<a href="{{route('view.profile')}}" class="btn btn-zcta">Apply Now </a>
		@else
		<a href="{{url('/login')}}" class="btn btn-zcta">Apply Now </a>
		@endif
	</div>   
</div>