 <section class="services">
    <div class="home-display py-3">
        <div class="title">
            <h2>Services</h2>
            <span>Find what kind of professional service you need.</span>
            <a href="#">view all services</a>
        </div>
        <div class="content pt-3">
            <ul id="services">
                @if(count($servicecategories) > 0)
                @foreach($servicecategories as $key=>$service)
                @if($key < 6)
                <li>
                    <div class="box">
                        <form action="{{route('service.search')}}" method="post">
                          @csrf
                          <input type="text" name="category" value="{{$service->name}}" hidden>
                          <img src="{{asset('frontend/img/200x100.jpg')}}" alt="Avatar" class="image">
                          <div class="overlay"></div>
                            <input class="text" type="submit" name="submit" value="{{ucfirst($service->name)}}">
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