 <div class="carousel-item">
 	@if($slider['advertisement'])
	<img src="{{asset('storage/'.$slider['advertisement'])}}" alt="Los Angeles" >
	@else
 	<img src="{{asset('frontend/img/advertisment.jpg')}}" alt="New York" >
	@endif
 	<div class="carousel-caption">
 		<h3>Advertising with Zillicom.com</h3>
 		<p>Contact us for properties, product and service advertisment</p>
 		<button class="btn btn-zcta">Contact Now</button>
 	</div>    
 </div>