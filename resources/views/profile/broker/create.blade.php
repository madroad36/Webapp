<div class="modal fade create-broker" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" >
                <div class="product-form-header">
                    Broker Form
                </div>
                <button type="button" id="broker-modal-close-btn" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
            {!! Form::open(array('route'=>'broker.store','class'=>'','id'=>'broker-save','enctype'=>'multipart/form-data')) !!}
            {{--<form role="form aling-center">--}}
            <!-- text input -->
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Service</label>
                            <select name="service" id="service" class="form-control">
                                <option value="0">Select the area</option>
                                <option value="Land">Land</option>
                                <option value="House">House</option>
                                <option value="Land/House">Land/House</option>
                            </select>

                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Year of Experience</label>
                            <input type="text" id="experience" name="experience" class="form-control" placeholder="Year of experience" value="{{ old('title') }}" required>
                            <div id="title"></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Citizen No</label>
                            <input type="text" id="citizen_no" name="citizen_no" class="form-control" placeholder="Citizen Number" value="{{ old('title') }}" required>


                        </div>
                    </div>

                        <div class="col-lg-6" >
                            <div id="hide-upload">
                                <input type="file" id="citizen-image" name="citizen"  class="hide" />
                                <label for="citizen-image" id="citizen" class="btn btn-large">Upload Citizen</label><br/><br/>
                                <img src="" id="citizenPreview" alt="Preview Image" style="display:none;width:80px;height:80px; position: absolute; top: 5px;    right: 24%;"/>
                                <input type="hidden" id="citizen-image-frame" name="citizen">

                            </div>
                            <div id="image"></div>
                        </div>
                        <div class="col-lg-6" >
                            <div id="hide-upload">
                                <input type="file" id="certificate-image" name="certificate"  class="hide" />
                                <label for="certificate-image" id="certificate" class="btn btn-large">Upload Certificate</label><br/><br/>
                                <img src="" id="certificatePreview" alt="Preview Image" style="display:none;width:80px;height:80px; position: absolute; top: 5px;    right: 24%;"/>
                                <input type="hidden" id="certificate-image-frame" name="certificate">
                            </div>
                            <div id="image"></div>
                        </div>

                </div>



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