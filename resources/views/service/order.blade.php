@extends('frontend.app')
@section('title', 'order-service-'.$servicerequest->service->title)
@section('main-content')
    <div class="stop-watch-wrapper">
        <main role="main">

            <!-- Main jumbotron for a primary marketing message or call to action -->
            <div class="service-banner-image " style="background: url('{{asset('frontend/img/service.png')}}')">
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-7 text-center aos-init " data-aos="fade">
                            <h1 class="service-banner-header">{{$servicerequest->service->category->name}}</h1>
                            <p>{{$servicerequest->service->title}}</p>

                        </div>
                    </div>
                </div>

            </div>
        </main>

        <div class="service-page">
            <div class="container">

                <div class="contain-details-img">
                    
                    <div class="service-previous-work">
                        

                </div>

                <div class="servious-previous-work">
                    <div class="servious-previous-work-wrapper">
                        <h5>Previous record </h5>

                      @foreach( $orders as $order)
                          <div class="recor-list-service">
                            <ul class="previous-service-details">

                                <li>
                                    <div class="service-date-time">
                                        <span>Location:</span>{{ $order->location }}
                                    </div>
                                    <span>Contact:</span>{{ $order->contact }}

                                </li>
                                <li>
                                    <div class="service-date-time">
                                        <span>Date:</span>{{  Carbon\Carbon::parse($order->date)->format('d F Y')}}
                                    </div>
                                        <span>Time:</span>{{  Carbon\Carbon::parse($order->date)->format('H:i')}}
                                        

                                </li>
                                <li>
                                    <span>Status</span>
                                        @if(empty($order->technician_id))
                                        Pending
                                        @elseif($order->is_active == '1')
                                        finished
                                        @else 
                                        On Progress
                                        @endif
                                </li>
                                <li>
                                    {{$order->description}}
                                </li>
                            </ul>
                              <div class="table-responsive">
                                @if($servicerequest->service->rate_type == 'per-day')
                                     <p>This is Per day work and it rate is Rs.{{$servicerequest->service->rate}}</p>
                                @else
                                   @if($order->WorkingHour()->exists())
                                    <table class="table datatable ">
                                        <thead class=" text-primary">
                                        <tr>
                                            <th>Session {{$order->WorkingHour()->exists()}}</th>
                                            <th>Start</th>
                                            <th>End</th>
                                            <th>Duration</th>
                                            <th>Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $sum = strtotime('00:00:00'); @endphp
                                        @php $sum2=0; $totalamount=0; @endphp
                                        @foreach($order->WorkingHour as $key=>$value)
                                            <tr>


                                                <td>{{$key+1}} Session</td>
                                                <td>{{$value->start}}</td>
                                                <td>{{$value->end}}</td>

                                                <td>{{$value->duration}}</td>
                                                <td>{{$value->amount}}</td>
                                            </tr>
                                            @php $sum1=strtotime($value->duration)-$sum; @endphp
                                            @php $sum2 = $sum2+$sum1; @endphp
                                            @php $totalamount += $value->amount @endphp
                                        @endforeach
                                        <tr>
                                            <td>Total</td>
                                            <td></td>
                                            <td></td>
                                            <td>{{ date('H:i:s', $sum+$sum2)}}</td>
                                            <td>{{$totalamount}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    @endif
                                     @endif
                              </div>

                          </div>

                          @endforeach

                    </div>
                </div>
            </div>
            <div class="clear-fix"></div>
        </div>

        {{--</div>--}}

    </div>


    <div class="google-map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d25632.32198851121!2d128.8041359!3d36.5772479!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2snp!4v1570767008267!5m2!1sen!2snp"
                width="100%" height="350" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
    </div>

@endsection
@section('js_script')
    <script type="application/javascript">
        $('#create-ticket').submit(function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var form = $(this).serialize();
            var url = $(this).attr('action');
            $.ajax({
                type: 'post',
                url: url,
                data: form,
                dataType: 'html',
                success: function (service) {


                    $('.ticket-list-view').html(service);

                },
                error: function (data) {

                }
            });
            return false;
        });

        $('#trash').click(function () {
            var id = $(this).attr('data-type');
            var url = baseUrl + "/ticket/delete/" + id;
            var service_id = $(this).attr('data-role');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "Delete",
                url: url,
                data: {
                    id: id,
                    service_id: service_id,
                    _method: 'DELETE'
                },

                dataType: 'html',
                success: function (service) {


                    $('.ticket-list-view').html(service);

                },
                error: function (data) {

                }
            });

        });
        $(".ticket-list-view").on("click", '#change-status', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var id = $(this).attr('data-type');
            var service_id = $(this).attr('data-role')

            $.ajax({
                type: "POST",
                url: "{{ route('ticket.change-status') }}",
                data: {
                    'id': id,
                    service_id: service_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'html',
                success: function (service, servicerequest) {
                    $('.ticket-list-view').html(service, servicerequest);
                },
                error: function (e) {

                }
            });
            return false;

        });
        $(document).ready(function () {
            $('.check-price').on('click', function () {
                $(this).not(':checked').prop('disabled', true)
            });
            $('.check-price').click(function (e) {
                e.preventDefault();
                e.stopPropagation();
            });

            var interval = setInterval(refresh, 9000);
            // $('#stop-watch-start').on('click',function(event){
            //     event.preventDefault();
            //     $("#overlay-load").fadeIn(300);
            //     var value = $(this).attr('role');
            //     var id = $(this).attr('data-type');
            //     timer(id,value);
            // });
            // $('#stop-watch-end').on('click',function(event){
            //     event.preventDefault();
            //     $("#overlay-load").fadeIn(300);
            //     var value = $(this).attr('role');
            //     var id = $(this).attr('data-type');
            //     timer(id,value)
            // });
            // $('#stop-watch-pause').on('click',function(event){
            //     event.preventDefault();
            //     $("#overlay-load").fadeIn(300);
            //     var value = $(this).attr('role');
            //     var id = $(this).attr('data-type');
            //     timer(id,value)
            // });


        });

        function start() {
            $("#overlay-load").fadeIn(300);
            var value = $('#stop-watch-start').attr('role');
            var id = $('#stop-watch-start').attr('data-type');
            timer(id, value);
        }

        function end() {
            $("#overlay-load").fadeIn(300);
            var value = $('#stop-watch-end').attr('role');
            var id = $('#stop-watch-end').attr('data-type');
            timer(id, value);
        }

        function pause() {
            $("#overlay-load").fadeIn(300);
            var value = $('#stop-watch-pause').attr('role');
            var id = $('#pause-time').attr('data-type');
            timer(id, value);
        }

        function finished() {
            $("#overlay-load").fadeIn(300);
            var value = $('#service-finished-time').attr('role');
            var id = $('#service-finished-time').attr('data-type');
            timer(id, value);
        }
        function finishedtime(){
            $("#overlay-load").fadeIn(300);
            var id = $('#service-finished-day').attr('data-type');
            $.ajax({
                type: 'post',
                url: '{{route('request.finished')}}',
                data: {id: id},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'html',
                success: function (service) {
                    $('.stop-watch-wrapper').html(service);
                    setTimeout(function () {
                        $("#overlay-load").fadeOut(300);
                    }, 500);

                },
                error: function (data) {

                }
            });
        }

        function refresh() {
            var id = $('#pause-time').attr('data-type');
            var value = 'pause';
            $.ajax({
                type: 'post',
                url: '{{route('request.count')}}',
                data: {id: id, type: value},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function (response) {
                    console.log(response.pause);
                    if (response.type = "pause") {
                        if (response.pause != null) {
                            $("#pause-time").text(response.pause);
                        }


                    }

                },
                error: function (data) {
                }

            });
        }

        function timer(id, value) {
            $.ajax({
                type: 'post',
                url: '{{route('request.timer')}}',
                data: {id: id, type: value},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'html',
                success: function (service) {
                    $('.stop-watch-wrapper').html(service);
                    setTimeout(function () {
                        $("#overlay-load").fadeOut(300);
                    }, 500);

                },
                error: function (data) {

                }
            });
        }

    </script>
@endsection