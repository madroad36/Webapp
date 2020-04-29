<div class="modal fade create-technician" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" >
                <div class="product-form-header">
                    Technician Form
                </div>
                <button type="button" id="technician-modal-close-btn" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
            {!! Form::open(array('route'=>'technician.store','class'=>'','id'=>'technician-save','enctype'=>'multipart/form-data')) !!}
            {{--<form role="form aling-center">--}}
            <!-- text input -->
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Service</label>
                            @php $cat = [] @endphp

                            @foreach($serviceCategories as $category)

                                @php $cat[$category->id] = $category->name @endphp
                            @endforeach
                            {!! Form::select('category_id',$cat,null,['class'=>'form-control','id'=>'category_id','placeholder'=>'Select The Category']) !!}


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
                            <input type="file" id="citizen-image" name="citizen_upload"  class="hide" />
                            <label for="citizen-image" id="citizen_upload" class="btn btn-large">Upload Citizen</label><br/><br/>
                            <img src="" id="citizenPreview" alt="Preview Image" style="display:none;width:80px;height:80px; position: absolute; top: 5px;    right: 24%;"/>
                            <input type="hidden" id="citizen-image-frame" name="citizen">

                        </div>
                        <div id="image"></div>
                    </div>
                    <div class="col-lg-6" >
                        <div id="hide-upload">
                            <input type="file" id="certificate-image" name="certificate_upload"  class="hide" />
                            <label for="certificate-image" id="certificate_upload" class="btn btn-large">Upload Certificate</label><br/><br/>
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