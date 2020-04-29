<div class="modal fade broker-update" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" >
                <div class="product-form-header">
                    Broker Edit  Form
                </div>
                <button type="button" id="broker-modal-close-btn" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
            {!! Form::open(array('route'=>'broker.update','class'=>'','id'=>'broker-edit','enctype'=>'multipart/form-data')) !!}
            {{--<form role="form aling-center">--}}
            <!-- text input -->
                 @if(!empty($broker))
                @if($broker->is_active == 1)
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Service</label>
                            <select name="service" id="service" class="form-control">
                                <option value="0">Select the area</option>
                                <option @if(auth()->user()->brokers->service == 'Land') selected @endif value="Land">Land</option>
                                <option @if(auth()->user()->brokers->service == 'House') selected @endif value="House">House</option>
                                <option @if(auth()->user()->brokers->service == 'Land/House') selected @endif value="Land/House">Land/House</option>
                            </select>

                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Year of Experience</label>
                            <input type="text" id="experience" name="experience" class="form-control" placeholder="Year of experience" value="{{auth()->user()->brokers->experience }}" required>
                            <div id="title"></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Citizen No</label>
                            <input type="text" id="citizen_no" name="citizen_no" class="form-control" placeholder="Citizen Number" value="{{ auth()->user()->brokers->citizen_no }}" required>


                        </div>
                    </div>

                    <div class="col-lg-6" >
                        <div id="hide-upload">
                            <input type="file" id="update-citizen-image" name="citizen"  class="hide" />
                            <label for="update-citizen-image" id="citizen" class="btn btn-large">Upload Citizen </label><br/><br/>
                            <img src="" id="update-citizen-preview" alt="Preview Image" style="display:none;width:80px;height:80px; position: absolute; top: 5px;    right: 24%;"/>
                            @if(file_exists('storage/'.auth()->user()->brokers->citizen) && auth()->user()->brokers->citizen != '' )
                                <img src="{{asset('storage/'.auth()->user()->brokers->citizen)}}" id="update-citizen-server" alt="Preview Image" style="display:block;width:80px;height:80px; position: absolute; top: 5px;    right: 24%;"/>

                            @endif

                        </div>
                        <div id="image"></div>
                    </div>
                    <div class="col-lg-6" >
                        <div id="hide-upload">
                            <input type="file" id="update-certificate-image" name="certificate"  class="hide" />
                            <label for="update-certificate-image" id="certificate" class="btn btn-large">Upload Certificate</label><br/><br/>
                            <img src="" id="update-certificate-preview" alt="Preview Image" style="display:none;width:80px;height:80px; position: absolute; top: 5px;    right: 24%;"/>

                            @if(file_exists('storage/'.auth()->user()->brokers->certificate) && auth()->user()->brokers->certificate != '' )
                                <img src="{{asset('storage/'.auth()->user()->brokers->certificate)}}" id="update-certificate-server alt="Preview Image" style="display:block;width:80px;height:80px; position: absolute; top: 5px;    right: 24%;"/>

                            @endif
                        </div>
                        <div id="image"></div>
                    </div>

                </div>
                @endif
                @endif



                <div class="form-group">
                    <button type="submit" name="submit" id="product-store-btn" class="btn btn-primary">Submit</button>
                </div>
                <!-- checkbox -->


                {!! Form::close() !!}
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>