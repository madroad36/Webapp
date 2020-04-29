<ul class="ordr-content-price">

    @foreach($service->ticket as $service)
        <li>
            <label class="main">{{$service->ticket}}
                @if($service->is_active == 1)
                    <input class="service-request-ticket" type="checkbox" @if($service->is_active == 1) checked @endif name="hourly">
                    <span class="w3docs"></span>
                @else
                    <input class="service-request-ticket" type="checkbox"  name="hourly">
                    <span class="w3docs"></span>

                @endif

            </label>
        </li>
    @endforeach
</ul>
