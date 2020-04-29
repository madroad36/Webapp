<div class="modal fade vendor-update" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" >
                <div class="product-form-header">
                    Vendor Form
                </div>
                <button type="button" id="vendor-modal-close-btn" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
            {!! Form::open(array('route'=>'vendor.update','class'=>'','id'=>'vendor-edit','enctype'=>'multipart/form-data')) !!}
            {{--<form role="form aling-center">--}}
            <!-- text input -->
                @if(!empty($vendor))
                @if($vendor->is_active == 1)
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Compnay Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="company name" value="{{ auth()->user()->vendors->name }}" required>

                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Location</label>
                            <input type="text" id="location" name="location" class="form-control" placeholder="location" value="{{ auth()->user()->vendors->location }}" required>

                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Pan/Vat No</label>
                            <input type="text" id="pan_vat" name="pan_vat" class="form-control" placeholder="pan vat number" value="{{auth()->user()->vendors->pan_vat}}" required>


                        </div>
                    </div>

                    <div class="col-lg-6" >
                        <div id="hide-upload">
                            <input type="file" id="update-pan-vat-image" name="pan_vat_image"  class="hide" />
                            <label for="update-pan-vat-image" id="pan_vat_image" class="btn btn-large">Upload Pan Vat Document</label><br/><br/>
                            <img src="" id="update-pan-vatPreview" alt="Preview Image" style="display:none;width:80px;height:80px; position: absolute; top: 5px;    right: 24%;"/>

                            @if(file_exists('storage/'.auth()->user()->vendors->pan_vat_image) && auth()->user()->vendors->pan_vat_image != '' )
                                <img src="{{asset('storage/'.auth()->user()->vendors->pan_vat_image)}}" id="update-pan-vatPreview-server" alt="Preview Image" style="display:block;width:80px;height:80px; position: absolute; top: 5px;    right: 24%;"/>

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