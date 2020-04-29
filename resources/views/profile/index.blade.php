@extends('profile.app')
@section('title', 'Profile Page')

@section('main-content')
    {{--<div class="container">--}}
    {{--<div class="profile-page-details">--}}

            {{--<div class="row">--}}
                {{--<div class="col-lg-4">--}}
                    {{--<div class="profile-image">--}}
                        {{--@if(file_exists('storage/'.auth()->user()->image) && auth()->user()->image != '')--}}
                            {{--<img src="{{asset('storage/'.auth()->user()->image)}}" class="rounded"--}}
                                 {{--alt="{{auth()->user()->name}}">--}}
                        {{--@else--}}

                            {{--<img src="{{asset('backend/dist/img/avatar.png')}}" class="rounded"--}}
                                 {{--alt="{{auth()->user()->name}}">--}}

                        {{--@endif--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-lg-8">--}}
                    {{--<div class="profile-details">--}}
                        {{--<h3> Hi {{Auth::user()->name}} !</h3>--}}
                        {{--<p>Wel Come to Zillicom</p>--}}
                    {{--</div>--}}
                    {{--<div class="profile-status">--}}
                        {{--@if(Auth::user()->is_active =='1')--}}
                            {{--<p>--}}
                                {{--You are--}}
                                {{--@if(Auth::user()->broker =='1')--}}
                                    {{--Broker--}}
                                {{--@endif--}}
                                {{--@if(Auth::user()->vendor =='1')--}}
                                    {{--Vendor--}}
                                {{--@endif--}}
                                {{--@if(Auth::user()->service =='1')--}}
                                    {{--Service Provider--}}
                                {{--@endif--}}
                            {{--</p>--}}
                        {{--@endif--}}
                            {{--@if(Auth::user()->is_active =='0')--}}
                        {{--<span>Profile Status:: <a href="javascript:void(0)"--}}
                                                  {{--class="btn btn-primary">Waiting for approvel </a></span>--}}
                                {{--@endif--}}
                    {{--</div>--}}
                    {{--<div class="profile-status-full-width">--}}
                        {{--<div class="profile-status-nav">--}}
                            {{--<div class="profile-status-nav-left">--}}
                                {{--<h3>Do you Know ?<br>--}}
                                    {{--<span>You can Earn with Zillicom</span>--}}
                                {{--</h3>--}}
                            {{--</div>--}}
                            {{--<div class="profile-status-nav-right">--}}
                                {{--<a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal"--}}
                                   {{--data-target="#user-service">Join Us</a>--}}
                            {{--</div>--}}
                            {{--<div class="modal fade" id="user-service" tabindex="-1" role="dialog"--}}
                                 {{--aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
                                {{--<div class="modal-dialog" role="document">--}}
                                    {{--<div class="modal-content">--}}
                                        {{--<div class="modal-header">--}}
                                            {{--<h5 class="modal-title" id="exampleModalLabel">What do you want to be ?</h5>--}}
                                            {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                                                {{--<span aria-hidden="true">&times;</span>--}}
                                            {{--</button>--}}
                                        {{--</div>--}}
                                        {{--{!! Form::open(array('route'=>'home.assign')) !!}--}}
                                        {{--<div class="modal-body">--}}

                                            {{--<label class="container">Broker--}}
                                                {{--<input type="checkbox" name="broker"--}}
                                                       {{--@if(auth()->user()->broker == '1') checked @endif >--}}
                                                {{--<span class="checkmark"></span>--}}
                                            {{--</label>--}}
                                            {{--<label class="container">Vendor--}}
                                                {{--<input type="checkbox" name="vendor"--}}
                                                       {{--@if(auth()->user()->vendor == '1') checked @endif>--}}
                                                {{--<span class="checkmark"></span>--}}
                                            {{--</label>--}}
                                            {{--<label class="container">Service-Provider--}}
                                                {{--<input type="checkbox" name="service"--}}
                                                       {{--@if(auth()->user()->service == '1') checked @endif>--}}
                                                {{--<span class="checkmark"></span>--}}
                                            {{--</label>--}}
                                        {{--</div>--}}
                                        {{--<div class="modal-footer">--}}
                                            {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close--}}
                                            {{--</button>--}}
                                            {{--<button type="submit" class="btn btn-primary">Save changes</button>--}}
                                            {{--{!! Form::close() !!}--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    {{--<div class="profile-chart">--}}
        {{--<div class="container">--}}
            {{--<div class="row">--}}

                {{--<div class="col-lg-4">--}}
                    {{--<ul>--}}
                        {{--<li><a href="">Transaction</a></li>--}}
                        {{--<li><a href="{{route('owner.property.index')}}">My Property</a></li>--}}
                        {{--@if(auth()->user()->broker ==1)--}}
                            {{--<li><a href="{{route('broker.property.index')}}">Broker Property List</a></li>--}}
                        {{--@endif--}}
                        {{--<li><a href="{{route('property.create')}}">Add Property</a></li>--}}
                        {{--<li><a href="">My Product</a></li>--}}
                        {{--<li><a href="">Add Product</a></li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
                {{--<div class="col-lg-8">--}}

                {{--</div>--}}
                {{--<div class="col-lg-3">--}}
                    {{--<div class="small-box bg-aqua">--}}
                        {{--<div class="inner">--}}
                            {{--<h3>{{$user->owner->count()}}</h3>--}}

                            {{--<p>Total Property</p>--}}
                        {{--</div>--}}
                        {{--<div class="icon">--}}
                            {{--<i class="fa fa-home"></i>--}}
                        {{--</div>--}}
                        {{--<a href="{{route('owner.property.index')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-lg-3">--}}
                    {{--<div class="small-box bg-aqua">--}}
                        {{--<div class="inner">--}}
                            {{--<h3>{{$user->brokerList->count()}}</h3>--}}

                            {{--<p>As a Broker</p>--}}
                        {{--</div>--}}
                        {{--<div class="icon">--}}
                            {{--<i class="fa fa-home"></i>--}}
                        {{--</div>--}}
                        {{--@if(auth()->user()->broker == 1)--}}
                        {{--<a href="{{route('broker.property.index')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
                        {{--@endif--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-lg-3">--}}
                    {{--<div class="chart-wrap">--}}

                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-lg-3">--}}
                    {{--<div class="chart-wrap">--}}

                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

    {{--</div>--}}
@endsection
@section('js_script')
@endsection