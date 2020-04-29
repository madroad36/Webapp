  <section class="properties">
    <div class="home-display py-3">
      <div class="title">
        <h2>Properties by place</h2>
        <span>View properties by places</span>
        <a href="#">view all places</a>
      </div>
      <div class="content pt-3">
        <ul id="lightSlider">
         @if(count($locations) > 0)
         @foreach($locations as $key=>$location)
         @if($key < 6)
         <li>
          <div class="box">
            <form action="{{route('property.search')}}" method="post">
              @csrf
              <input type="text" name="city" value="{{$location->name}}" hidden>
              <img src="{{asset('frontend/img/content.png')}}" alt="Avatar" class="image">
              <div class="overlay"> </div>
              <input class="text" type="submit" name="submit" value="{{ucfirst($location->name)}}">
            </form>
          </div>
        </li>
        @endif
        @endforeach
        @endif
      </ul>
    </div>
  </div>
</section>