<div class="timer">
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
                                @if(file_exists('storage/'.$service->owner->image) && $service->owner->image != '')
                                    <img src="{{asset('storage/'.$service->owner->image)}}" alt="{{$service->owner->name}}">
                                @else
                                    <img src="{{asset('backend/dist/img/avatar.png')}}" class="rounded"
                                         alt="{{$service->owner->name}}">
                                @endif

                                <span><i class="fa fa-map-marker"></i> {{$service->owner->address}}</span>
                                <p><i class="fa fa-phone-square"></i> {{$service->owner->contact}}</p>

                            </div>

                        </div>

                        <div class="order-side-dash ">
                            <div class="order-sidedash-header order-sidedash-h">
                                <h4>Assign Technician </h4>
                            </div>
                            <div class="order-sidedash-image">
                                @if(!empty($service->technician_id))

                                    @if(file_exists('storage/'.$service->technician->image) && $service->technician->image != '')
                                        <img src="{{asset('storage/'.$service->technician->image)}}" alt="{{$service->technician->name}}">
                                    @else
                                        <img src="{{asset('backend/dist/img/avatar.png')}}" class="rounded"
                                             alt="{{$service->technician->name}}">
                                    @endif

                                    <span><i class="fa fa-map-marker"></i> {{$service->technician->address}}</span>
                                    <p><i class="fa fa-phone-square"></i> {{$service->technician->contact}}</p>
                                @else
                                    <span class="assign-user">Not Assign yet</span>
                                @endif

                            </div>

                        </div>
                        <div class="order-side-dash">
                            <div class="order-sidedash-header">
                                <h4>Service More Details </h4>
                            </div>
                            <div class="order-sidedash-detials">
                                start
                                <li>
                                    <label for="">Date</label>
                                    @if(!empty($service->start))
                                        @php $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $service->start)->format('Y-m-d'); @endphp
                                        <span>{{ $date  }}</span>
                                    @endif
                                </li>
                                <li>
                                    <label for="">Time</label>
                                    @if(!empty($service->start))
                                        @php $time = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $service->start)->format('H:i'); @endphp
                                        <span>{{ $time }}</span>
                                    @endif
                                </li>
                                </ul>

                            </div>
                            <div class="order-sidedash-detials">
                                End
                                <li>
                                    <label for="">Date</label>
                                    @if(!empty($service->end))
                                        @php $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $service->end)->format('Y-m-d'); @endphp
                                        <span>{{ $date  }}</span>
                                    @endif
                                </li>
                                <li>
                                    <label for="">Time</label>
                                    @if(!empty($service->end))
                                        @php $time = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $service->end)->format('H:i'); @endphp
                                        <span>{{ $time }}</span>
                                    @endif
                                </li>
                                </ul>

                            </div>

                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="task-switch-btn">
                            @if(empty($service->start))
                                <a href="javascript:void(0)" data-role="start"  data-type="{{$service->id}}" class="btn btn-large service-timer-btn" id="task-start">Start</a>
                            @endif
                            @if(empty($service->end))
                                <a href="javascript:void(0)" class="btn btn-large service-timer-btn" data-role="end"  data-type="{{$service->id}}" id="task-end">End</a>
                            @endif

                        </div>
                        <div class="line-breaker"></div>
                        @if ($message = Session::get('success'))
                            <div class="alert alert-info alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif

                        <p>{!! $service->service->description !!}</p>
                        <div class="service-request-form ">
                            <span>Price</span>
                            <ul class="ordr-content-price">
                                <li>
                                    <label class="main">Hourly
                                        <input class="check-price" type="checkbox" @if($service->hourly == 1) checked @endif name="hourly">
                                        <span class="w3docs"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="main">By Task
                                        <input class="check-price" type="checkbox" @if($service->task == 1) checked @endif  name="task">
                                        <span class="w3docs"></span>
                                    </label>
                                </li>

                                <li>
                                    <label class="main">Monthly
                                        <input class="check-price" type="checkbox" @if($service->monthly == 1) checked @endif  name="monthly">
                                        <span class="w3docs"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="main">Yearly
                                        <input class="check-price" type="checkbox" name="yearly" @if($service->yearly == 1) checked @endif >
                                        <span class="w3docs"></span>
                                    </label>




                                </li>
                                <li>
                                    <label class="main">Member
                                        <input class="check-price" type="checkbox" name="member">
                                        <span class="w3docs"></span>
                                    </label>
                                </li>
                            </ul>
                            <ul class="ordr-content-price">
                                <li>
                                    <label class="main">Rs {{$service->service->hourly}}
                                        <input class="check-price"  type="checkbox" @if($service->hourly == 1) checked @endif name="hourly">
                                        <span class="w3docs" style="display: none"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="main">Rs {{$service->service->task}}
                                        <input class="check-price"  type="checkbox" @if($service->task == 1) checked @endif name="hourly">
                                        <span class="w3docs" style="display: none"></span>
                                    </label>
                                </li>

                                <li>
                                    <label class="main">Rs{{$service->service->monthly}}
                                        <input class="check-price"  type="checkbox" @if($service->month == 1) checked @endif name="hourly">
                                        <span class="w3docs" style="display: none"></span>

                                    </label>
                                </li>
                                <li>
                                    <label class="main">Rs{{$service->service->yearly}}
                                        <input class="check-price"  type="checkbox" @if($service->yearly == 1) checked @endif name="hourly">
                                        <span class="w3docs" style="display: none"></span>

                                    </label>




                                </li>
                                <li>
                                    <label class="main">Rs{{$service->service->member}}
                                        <input class="check-price"  type="checkbox" @if($service->member == 1) checked @endif name="hourly">
                                        <span class="w3docs" style="display: none"></span>

                                    </label>
                                </li>
                            </ul>
                            <div class="line-breaker"></div>

                            <div class="order-list-extra-ticket">
                                @if(empty($service->end))
                                <span>Add task to given service</span>

                                <div class="create-ticket-for-request">

                                    {!! Form::open(array('route'=>['ticket.store',$service->id ],'id'=>'create-ticket')) !!}
                                    <div class="form-group">
                                        {{--<label for="">Add New Task</label>--}}
                                        <textarea name="ticket" class="form-control" placeholder="Please added new task"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                    {!! Form::close() !!}

                                </div>
                                @endif

                                <div class="ticket-list-view">

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
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>


        </div>
        <div class="clear-fix"></div>
    </div>
</div>