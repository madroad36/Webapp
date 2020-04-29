@extends('frontend.app')
@section('title', $service->title)
@section('main-content')
    <main role="main">

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="service-banner-image " style="background: url('{{asset('frontend/img/service.png')}}')">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-7 text-center aos-init " data-aos="fade">
                        <p>Service > {{$service->category->name}} </p>
                        <h1 class="service-banner-header">{{$service->title}}</h1>

                    </div>
                </div>
            </div>

        </div>
    </main>

    <div class="service-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="contain-details-img">
                        {{--<div class="details-img">--}}
                        {{--@if(file_exists('storage/'.$service->thumbnail) && $service->thumbnail !='')--}}
                        {{--<img src="{{asset('storage/'.$service->thumbnail)}}" alt="{{$service->title}}">--}}
                        {{--@endif--}}

                        {{--</div>--}}
                        <div class="service-details-content">
                            {!!  $service->description !!}
                        </div>

                        <div class="service-price-list">
                            <h3 class="product-cart-select service-price-list-head">Service Price List </h3>
                            <ul>
                                <!-- <li>By Task <span>Rs</span>{{$service->task}}</li> -->
                                <li>Hourly</i><span>Rs</span> {{$service->rate}} / {{$service->rate_type}}</li>

                            </ul>
                            <!-- <h4>Other Scheme</h4> -->

                         <!--    <div class="row">
                                <div class="col-lg-4">
                                    <div class="monthly-service-price price-for-month">
                                        <div class="price-list-header">

                                            <p><i class="fa fa-calendar" style="margin-right: 10px;"></i>Monthly </p>
                                            <span><p>Rs</p>{{$service->monthly}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="monthly-service-price price-for-year">
                                        <div class="price-list-header">
                                            <p><i class="fa fa-calendar" style="margin-right: 10px;"></i>Yearly </p>
                                            <span><p>Rs</p>{{$service->yearly}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="monthly-service-price price-for-member">
                                        <div class="price-list-header">
                                            <p><i class="fa fa-id-card" style="margin-right: 10px;"></i>Member</p>
                                            <span><p>Rs</p>{{$service->member}}</span>
                                        </div>
                                    </div>
                                </div>

                            </div> -->

                        </div>

                    </div>

                    <div class="service-request-form" style="box-shadow: 5px 4px 20px #888888; padding: 45px;">
                        <span>Book your service</span><hr><br>
                    {!! Form::open(array('route'=>['service_request.store',$service->id],'class'=>'','enctype'=>'multipart/form-data')) !!}
                    {{--<form role="form aling-center">--}}
                    <!-- text input -->
                        @if ($message = Session::get('success'))
                            <div class="alert alert-info alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        @if ($message1 = Session::get('flash_errors'))
                            <div class="alert alert-danger">{{ $message1 }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                       <!--  <div class="form-group row">

                            <ul>
                                <li>
                                    <label class="main">Hourly
                                        <input class="check-price" type="checkbox" name="hourly">
                                        <span class="w3docs"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="main">By Task
                                        <input class="check-price" type="checkbox" name="task">
                                        <span class="w3docs"></span>
                                    </label>
                                </li>

                                <li>
                                    <label class="main">Monthly
                                        <input class="check-price" type="checkbox" name="monthly">
                                        <span class="w3docs"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="main">Yearly
                                        <input class="check-price" type="checkbox" name="yearly">
                                        <span class="w3docs"></span>
                                    </label>
                                    {{--<input type="checkbox" name="yearly">--}}
                                    {{--<span class="checkboxtext">--}}
                                      {{--Yearly--}}
                                    {{--</span>--}}
                                </li>
                                <li>
                                    <label class="main">Member
                                        <input  class="check-price" type="checkbox" name="member">
                                        <span class="w3docs"></span>
                                    </label>
                                </li>
                            </ul>
                        </div> -->

                        <div class="form-group row">

                            <div class="service-request-form">
                                <label class="price-label" for="">Address </label>
                                <input type="text" name="location" id="city" class="form-control price-location"
                                       placeholder="Eg: Baneswor, Kathmandu">
                                <div class="locationId"></div>
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="service-request-form">
                                <label class="price-label" for="">Contact</label>
                                <input type="number" name="contact" id="contact" class="form-control price-location"
                                       placeholder="Eg: 9845******" min="10">
                            </div>

                        </div>


                        <div class="form-group">
                            <div class="service-request-form">
                                <button formmethod="post" class="btn btn-primary">Book Now</button>
                            </div>

                        </div>
                        <!-- checkbox -->


                        {!! Form::close() !!}

                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="product-category">
                        <h2>Service's List</h2>
                        <ul>
                            @foreach( $categories as $serve)
                                <li class="{{ $service->id == $serve->id ? 'active' : '' }}">
                                    <a href="{{route('category.show',[$serve->slug])}}">{{$serve->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="clear-fix"></div>




    <div class="google-map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d25632.32198851121!2d128.8041359!3d36.5772479!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2snp!4v1570767008267!5m2!1sen!2snp"
                width="100%" height="350" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
    </div>

@endsection
@section('js_script')
    <script type="application/javascript">
        $('.extra-fields-customer').click(function () {
            $('.customer_records').clone().appendTo('.customer_records_dynamic');
            $('.customer_records_dynamic .customer_records').addClass('single remove');
            $('.single .extra-fields-customer').remove();
            $('.single').append('<a href="#" class="remove-field btn-remove-customer">Remove Fields</a>');
            $('.customer_records_dynamic > .single').attr("class", "remove");

            $('.customer_records_dynamic input').each(function () {
                var count = 0;
                var fieldname = $(this).attr("name");
                $(this).attr('name', fieldname + count);
                count++;
            });

        });

        $(document).on('click', '.remove-field', function (e) {
            $(this).parent('.remove').remove();
            e.preventDefault();
        });
        $(document).ready(function () {
            {{--$("#city").autocomplete({--}}
                {{--source: function (request, response) {--}}
                    {{--var val = $(".search-category option:selected").val();--}}
                    {{--$.ajax({--}}
                        {{--url: "{{route('place.getlocation')}}",--}}
                        {{--data: {--}}
                            {{--term: request.term,--}}
                        {{--},--}}
                        {{--dataType: "json",--}}
                        {{--success: function (data) {--}}

                            {{--var resp = $.map(data, function (obj) {--}}
                                {{--console.log(obj.id);--}}
                                {{--return obj.name;--}}
                                {{--$('.locationId').text(obj.id);--}}
                            {{--});--}}

                            {{--response(resp);--}}
                        {{--},--}}

                        {{--error: function (data) {--}}

                        {{--}--}}
                    {{--});--}}
                {{--},--}}
                {{--minLength: 1--}}
            {{--});--}}
            {{--$("#address").autocomplete({--}}
                {{--source: function (request, response) {--}}
                    {{--var val = $('#city').val();--}}
                    {{--$.ajax({--}}
                        {{--url: "{{route('place.getaddress')}}",--}}
                        {{--data: {--}}
                            {{--term: request.term,--}}
                            {{--city: val--}}
                        {{--},--}}
                        {{--dataType: "json",--}}
                        {{--success: function (data) {--}}

                            {{--var resp = $.map(data, function (obj) {--}}
                                {{--console.log(obj.id);--}}
                                {{--return obj.name;--}}
                                {{--$('#locationId').val(obj.id);--}}
                            {{--});--}}

                            {{--response(resp);--}}
                        {{--},--}}

                        {{--error: function (data) {--}}

                        {{--}--}}
                    {{--});--}}
                {{--},--}}
                {{--minLength: 1--}}
            {{--});--}}
            $('#location').on('change', function (event) {
                var value = $(this).val();
                var url = '{{route('place.getplace')}}';
                place(value, url)
                event.stopPropagation();
            });
            $(".check-price").on('click', function() {
                $('.check-price').not(this).prop('checked', false);
            });
        });

        function place(value, url) {
            $.ajax({
                type: 'get',
                url: url,
                data: {location_id: value},
                dataType: 'json',
                success: function (response) {
                    if (response.success == true) {
                        var value = response.place;
                        var option = '';

                        $.each(value, function (key, value) {

                            option += '<option selected="selected" value="' + value.id + '">' + value.name + '</option:selectedoption>';
                        });

                        $('#place').html(option).show();
                    } else {
                        $('#place').empty();
                    }

                }
            });
        }
    </script>
@endsection