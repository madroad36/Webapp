 <div class="jumbotron" style="background: url({{asset('frontend/img/earn-with-zillicom.jpg')}}) fixed;">
    <div class="container">
        <div class="jumbotron-content">
            <div class="title">
                <small>be with us</small>
                <h1 class="jumbotron-heading">Earn With zillicom</h1>
            </div>
            <div class="content">
                <h2 class="jumbotron-heading-two">What you want to be?</h2>
                <p>Property broker, Product seller or Service provider</p>
            </div>
            @if(Auth::check())
            <a href="{{route('view.profile')}}" class="btn btn-secondary">Apply Now </a>
            @else
            <a href="{{url('/login')}}" class="btn btn-secondary">Apply Now </a>
            @endif
        </div>
    </div>
</div>