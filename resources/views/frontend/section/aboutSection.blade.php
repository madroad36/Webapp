<section class="about-zillicom">
	<div class="row">
		@if($setting)
		<div class="col-md-12 text-center m-auto py-5">
			<h2 class="pb-3">{{$setting->company}}</h2>
			<p class="mx-auto" style="max-width: 728px">{!! nl2br($setting->description) !!}</p>
		</div>
		@else
		<div class="col-md-12 text-center m-auto py-5">
			<h2 class="pb-3">Zillicom Real Estate</h2>
			<p class="mx-auto" style="max-width: 728px">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut laboreita kasd gubergren, no sea takimata sanctus est Lorem ipsu dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore</p>
		</div>
		@endif
	</div>
</section>