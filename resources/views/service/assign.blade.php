
@extends('frontend.app')
@section('title', 'order-service-'.$servicerequest->service->title)
@section('main-content')
    
        <main role="main">

            <!-- Main jumbotron for a primary marketing message or call to action -->
            <div class="service-banner-image " style="background: url('{{asset('frontend/img/service.png')}}')">
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-7 text-center aos-init " data-aos="fade">
                            <h1 class="service-banner-header">{{$servicerequest->serviceRequest->service->category->name}}</h1>
                            <p>{{$servicerequest->serviceRequest->service->title}}</p>

                        </div>
                    </div>
                </div>

            </div>
        </main>

        <div class="service-page">
            <div class="container">

                <div class="contain-details-img">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="order-side-dash">
                                <div class="order-sidedash-header">
                                    <h4>Service Order By </h4>
                                </div>
                                <div class="order-sidedash-image">
                                    @if(file_exists('storage/'.$servicerequest->serviceRequest->owner->image) && $servicerequest->serviceRequest->owner->image != '')
                                        <img src="{{asset('storage/'.$servicerequest->serviceRequest->owner->image)}}"
                                             alt="{{$servicerequest->serviceRequest->owner->name}}">
                                    @else
                                        <img src="{{asset('backend/dist/img/avatar.png')}}" class="rounded"
                                             alt="{{$servicerequest->serviceRequest->owner->name}}">
                                    @endif
                                   
                                        <span><i class="fa fa-map-marker"></i> {{$servicerequest->serviceRequest->owner->name}}</span>
                                        <p><i class="fa fa-phone-square"></i> {{$servicerequest->serviceRequest->owner->contact}}</p>
                                   

                                </div>

                            </div>
                        </div>
                       
                        <div class="col-lg-4">


                            <div class="order-service-design">

                                <ul>
                                 
                                        <li>Location: <span>{{$servicerequest->location}}</span></li>
                                        <li>Contact: <span>{{$servicerequest->contact}}</span></li>
                                        <li>Preffered Date:
                                            <sapn>{{\Carbon\Carbon::parse($servicerequest->date)->format('d-M-Y')}}</sapn>
                                        </li>
                                        <li>Description:<br>
                                            <sapn>{!! $servicerequest->description !!}</sapn>
                                        </li>
                                   
                                </ul>
                            </div>

                        </div>
                        <div>
                        </div>
                        <div class="col-lg-4">
                            <div class="order-side-dash ">
                                <div class="order-sidedash-header order-sidedash-h">
                                    <h4>Assign Technician </h4>
                                </div>
                                <div class="order-sidedash-image">
                                   
                                        @if(file_exists('storage/'.$servicerequest->technician->image) && $servicerequest->technician->image != '')
                                            <img src="{{asset('storage/'.$servicerequest->technician->image)}}"
                                                 alt="{{$servicerequest->technician->name}}">
                                        @else
                                            <img src="{{asset('backend/dist/img/avatar.png')}}" class="rounded"
                                                 alt="{{$servicerequest->technician->name}}">
                                        @endif

                                        <span><i class="fa fa-map-marker"></i> {{$servicerequest->technician->address}}</span>
                                        <p><i class="fa fa-phone-square"></i> {{$servicerequest->technician->contact}}</p>
                                

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="stop-watch-wrapper">
                                @if($servicerequest->is_active =='0')
                                    @if($servicerequest->servicerequest->service->rate_type !== 'per-day')
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="stop-watch-container">
                                                        <div class="stop-watch-icon">
                                                            <i class="fa fa-clock-o"></i>
                                                            <span class="stop-watch-header">
                                                                Start Time
                                                                    <p id="start-time">{{$servicerequest->start}}</p>
                                                                </span>
                                                        </div>
                                                    
                                                            @if(empty($servicerequest->count) && empty($servicerequest->start))
                                                                <a href="javascript:void(0)" onclick="start()" role="start"
                                                                id="stop-watch-start" data-type="{{$servicerequest->id}}" class="stop-watch-btn">Start</a>
                                                                <span class="stop-watch-time">
                    
                                                            </span>
                                                            @endif
                                                            @if(!empty($servicerequest->start) && !empty($servicerequest->end))
                                                                <a href="javascript:void(0)" onclick="start()" role="start"
                                                                id="stop-watch-start" data-type="{{$servicerequest->id}}" class="stop-watch-btn">Restart</a>
                                                                <span class="stop-watch-time">
                    
                                                            </span>
                                                            @endif
                                                    
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="stop-watch-container">
                                                        <div class="stop-watch-icon">
                                                            <i class="fa fa-clock-o"></i>
                                                            <span class="stop-watch-header">
                                                            Duration
                                                                <p id="pause-time" data-type="{{$servicerequest->id}}">
                                                                    @if(!empty($servicerequest->duration))
                                                                        {{$servicerequest->duration}}
                                                                    @endif
                                                                </p>
                                                            </span>
                                                        </div>
                                                        @if(auth()->user()->id == $servicerequest->technician_id)
                                                            @if(!empty($servicerequest->start) && empty($servicerequest->end))
                                                                <a h href="javascript:void(0)" onclick="pause()" role="pause"
                                                                data-type="{{$servicerequest->id}}" id="stop-watch-pause" class="stop-watch-btn">Pause</a>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="stop-watch-container">
                                                        <div class="stop-watch-icon">
                                                            <i class="fa fa-clock-o"></i>
                                                            <span class="stop-watch-header">
                                                                End Time
                                                                <p id="end-time">{{$servicerequest->end}}</p>
                                                            </span>
                                                        </div>
                                                        @if(!empty($servicerequest->start) && !empty($servicerequest->end))
                                                            <a href="javascript:void(0)" onclick="end()" role="end"
                                                            data-type="{{$servicerequest->id}}" id="stop-watch-end" class="stop-watch-btn">End</a>
                                                    @endif
                                                    </div>
                    
                                                </div>
                                            </div>
                                        
                                            <div class="service-complete-btn">
                                                
                                                @if(!empty($servicerequest->WorkingHour->isNotEmpty()))
                                                <a href="javascript:void(0)" id="service-finished-time" onclick="finished()" role="finished"
                                                    data-type="{{$servicerequest->id}}" class="btn btn-primary">Finished Task   </a>
                                                @endif
 
                                            </div>
                                    @else 
                                    <a href="javascript:void(0)" id="service-finished-day" onclick="finishedtime()" role="finished"
                                    data-type="{{$servicerequest->id}}" class="btn btn-primary">Finished Task </a>
                                    @endif
                                    @endif
                                    

                            
                            
                                <div class="working-schedule">
                                    @if($servicerequest->servicerequest->service->rate_type == 'per-day')
                                    <p>This is Per day work and it rate is Rs.{{$servicerequest->servicerequest->service->rate}}</p>
                                    @else
                                    @if(!empty($servicerequest->WorkingHour))
                                        <table class="table datatable">
                                            <thead class=" text-primary">
                                            <tr>
                                                <th>session</th>
                                                <th>Start</th>
                                                <th>End</th>
                                                <th>Duration</th>
                                            </tr>
                                            </thead>
                                            
                                                <tbody>
                                                @php $sum = strtotime('00:00:00'); $sum2=0;  @endphp
                                                @foreach($servicerequest->WorkingHour as $key=>$task)
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{$task->start}}</td>
                                                        <td>{{$task->end}}</td>
                                                        <td>{{$task->duration}}</td>
                                                    </tr>
                                                    @php $sum1=strtotime($task->duration)-$sum; @endphp

                                                    @php  $sum2 = $sum2+$sum1; @endphp

                                                @endforeach
                                                <tr>
                                                    <td colspan="3">Total Time</td>
                                                    @php $time = $servicerequest->WorkingHour->pluck('duration') @endphp
                                                    <td> {{ $time = date('H:i:s', $sum+$sum2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Cost of the work</td>
                                                    <td>
                                                        @php $hms = explode(":", $time) @endphp
                                                        @if($servicerequest->serviceRequest->service->rate_type == 'half-hour' )
                                                            @php $totaltime =  ($hms[0]*60) + ($hms[1]) + ($hms[2]/60); @endphp
                                                            @php round($totaltime,3)/30*$servicerequest->serviceRequest->service->rate; @endphp
                                                        @else
                                                        @php  $totaltime = $hms[0] + ($hms[1]/60) + ($hms[2]/3600); @endphp
                                                        @php round($totaltime * $servicerequest->serviceRequest->service->rate,2); @endphp
                                                            @if($servicerequest->serviceRequest->service->rate_type == 'hourly')

                                                                @php $totaltime = $hms[0] + ($hms[1]/60) + ($hms[2]/3600)@endphp
                                                                @endif
                                                        {{$totaltime * $servicerequest->serviceRequest->service->rate }}
                                                            {{-- @if(date('H', $time ) == '0')
                                                            {{ date('i', $sum+$sum2)/60 * $servicerequest->serviceRequest->service->rate}}
                                                                @else
                                                                {{strtotime($sum+$sum2)/60}}
                                                                {{ date('H', $sum+$sum2)/60 *$servicerequest->serviceRequest->service->rate}}
                                                            @endif --}}
                                                    
                                                        @endif 
                                                        
                                                    </td>
                                                </tr>
                                                </tbody>
                                        
                                        </table>
                                        @endif  
                                        @endif  


                                        
                   
                                </div>
                    </div>
            </div>

            </div>
        

               
            </div>
            <div class="clear-fix"></div>
        </div>

        {{--</div>--}}




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