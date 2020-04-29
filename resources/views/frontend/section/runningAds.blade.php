 <section class="advertisment">
  <div class="row">
    <div class="col-md-12 py-3 text-center">
      <div class="carousel slide carousel-fade" data-ride="carousel">
        <div class="carousel-inner">
          @if(count($ads)>0)
          @for($i=0; $i < 1; $i++)
          <div class="carousel-item active">
            <a href="#">
              <img src="{{asset('storage/'.$ads[$i])}}" alt="#">
            </a>
          </div>
          @endfor
          @endif
          @if(count($ads)>0)
          @for($i=1; $i < count($ads); $i++)
          <div class="carousel-item">
           <a href="#">
            <img src="{{asset('storage/'.$ads[$i])}}" alt="#">
          </a>
        </div>
        @endfor
        @endif
      </div>
    </div>
  </div>
</section>