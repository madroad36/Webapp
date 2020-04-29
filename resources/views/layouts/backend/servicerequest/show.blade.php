@extends('layouts.backend.home')
@section('title', 'Service Request list')
@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small>Control panel</small>
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                <li class="active">Service</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
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
                                        @if(file_exists('storage/'.$servicerequest->owner->image) && $servicerequest->owner->image != '')
                                            <img src="{{asset('storage/'.$servicerequest->owner->image)}}" alt="{{$servicerequest->owner->name}}">
                                        @else
                                            <img src="{{asset('backend/dist/img/avatar.png')}}" class="rounded"
                                                 alt="{{$servicerequest->owner->name}}">
                                        @endif
                                        @if(!empty($order))
                                            <span><i class="fa fa-map-marker"></i> {{$order->location}}</span>
                                            <p><i class="fa fa-phone-square"></i> {{$order->contact}}</p>
                                        @endif

                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-4">


                                <div class="order-service-design">

                                    <ul>
                                        @if(!empty($order))
                                            <li>Location: <span>{{$order->location}}</span></li>
                                            <li>Contact: <span>{{$order->contact}}</span></li>
                                            <li>Preffered Date: <sapn>{{$order->date}}</sapn></li>
                                            <li>Description:<br> <sapn>{!! $order->description !!}</sapn></li>
                                        @endif
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
                                        @if(!empty($order->technician_id))

                                            @if(file_exists('storage/'.$order->technician->image) && $order->technician->image != '')
                                                <img src="{{asset('storage/'.$order->technician->image)}}" alt="{{$order->technician->name}}">
                                            @else
                                                <img src="{{asset('backend/dist/img/avatar.png')}}" class="rounded"
                                                     alt="{{$order->technician->name}}">
                                            @endif

                                            <span><i class="fa fa-map-marker"></i> {{$order->technician->address}}</span>
                                            <p><i class="fa fa-phone-square"></i> {{$order->technician->contact}}</p>
                                        @else
                                            <span class="assign-user">Not Assign yet</span>
                                        @endif

                                    </div>

                                </div>
                            </div>

                        </div>

                        @if(!empty($order))
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="stop-watch-container">
                                        <div class="stop-watch-icon">
                                            <i class="fa fa-clock-o"></i>
                                            <span class="stop-watch-header">
                                            Start Time
                                                <p id="start-time">{{$order->start}}</p>
                                            </span>
                                        </div>
                                        @if(auth()->user()->id == $order->technician_id)
                                            @if(empty($order->count))
                                                <a  href="javascript:void(0)" onclick="start()" role="start" id="stop-watch-start"  data-type="{{$order->id}}" class="stop-watch-btn">Start</a>
                                                <span class="stop-watch-time">

                                        </span>
                                            @endif
                                            @if(!empty($order->start) && !empty($order->end))
                                                <a  href="javascript:void(0)" onclick="start()" role="start" id="stop-watch-start"  data-type="{{$order->id}}" class="stop-watch-btn">Restart</a>
                                                <span class="stop-watch-time">

                                        </span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="stop-watch-container">
                                        <div class="stop-watch-icon">
                                            <i class="fa fa-clock-o"></i>
                                            <span class="stop-watch-header">
                                          Duration
                                             <p id="pause-time"  data-type="{{$order->id}}">
                                                 @if(!empty($order->duration))
                                                     {{$order->duration}}
                                                 @endif
                                             </p>
                                        </span>
                                        </div>
                                        @if(auth()->user()->id == $order->technician_id)
                                            @if(empty($order->end))
                                                <a h href="javascript:void(0)" onclick="pause()" role="pause"   data-type="{{$order->id}}"  id="stop-watch-pause" class="stop-watch-btn">Pause</a>
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
                                             <p id="end-time">{{$order->end}}</p>
                                        </span>
                                        </div>
                                        @if(auth()->user()->id == $order->technician_id)
                                            <a href="javascript:void(0)"  onclick="end()" role="end" data-type="{{$order->id}}" id="stop-watch-end"  class="stop-watch-btn">End</a>
                                        @endif
                                    </div>

                                </div>
                            </div>
                            <div class="service-complete-btn">
                                <a href="javascript:void(0)" id="service-finished-time" onclick="finished()" role="finished" data-type="{{$order->id}}" class="btn btn-primary">Finished Task</a>
                            </div>

                            <div class="working-schedule">
                                <table class="table datatable">
                                    <thead class=" text-primary">
                                    <tr>
                                        <th>session</th>
                                        <th>Start</th>
                                        <th>End</th>
                                        <th>Duration</th>
                                    </tr>
                                    </thead>
                                    @if(!empty($order->WorkingHour))
                                        <tbody>
                                        @php $sum = strtotime('00:00:00'); $sum2=0;  @endphp
                                        @foreach($order->WorkingHour as $key=>$task)
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
                                            {{--                                            @php $time = $order->WorkingHour->pluck('duration') @endphp--}}
                                            <td> {{ $time = date('H:i:s', $sum+$sum2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Cost of the work </td>
                                            <td>
                                                @php $hms = explode(":", $time) @endphp
                                                @if($order->service->service->rate_type == 'half-hour' )
                                                    @php $totaltime =  ($hms[0]*60) + ($hms[1]) + ($hms[2]/60)@endphp
                                                    {{round($totaltime,3)/30*$order->service->service->rate}}
                                                @elseif($order->service->service->rate_type == 'hourly' )
                                                    {{--                                                @if($order->service->service->rate_type == 'hourly')--}}

                                                    @php $totaltime = $hms[0] + ($hms[1]/60) + ($hms[2]/3600)@endphp
                                                    {{$totaltime * $order->service->service->rate }}
                                                    {{--                                                    @if(date('H', $time ) == 0)--}}
                                                    {{--                                                    {{ date('i', $sum+$sum2)/60 * $order->service->service->rate}}--}}
                                                    {{--                                                        @else--}}
                                                    {{--                                                        {{strtotime($sum+$sum2)/60}}--}}
                                                    {{--                                                        {{ date('H', $sum+$sum2)/60 * $order->service->service->rate}}--}}
                                                    {{--                                                    @endif--}}
                                                @else
                                                    {{$order->service->service->rate}}
                                                @endif
                                            </td>
                                        </tr>
                                        </tbody>
                                    @endif
                                </table>
                            </div>
                        @endif
                        <div class="service-previous-work">
                            <table class="table datatable">
                                <thead class=" text-primary">
                                <tr>
                                    <th>Session</th>
                                    <th>Duration</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($servicerequest->active as $key=>$value)
                                    <tr>


                                        <td>{{$key+1}} Order</td>
                                        <td>{{$value->duration}}</td>
                                        <td>{{$value->amount}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>





                    </div>


                </div>
                <div class="clear-fix"></div>
            </div>
            <!-- /.row -->
        </section>

        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- The Modal -->


@endsection
@section('js_script')
    <script type="text/javascript">
        $(document).ready(function() {




        });
    </script>




@endsection