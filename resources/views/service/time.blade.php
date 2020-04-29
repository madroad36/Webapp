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


                                        