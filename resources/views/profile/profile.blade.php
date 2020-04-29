<div class="modal fade profile-update" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" >
                <div class="product-form-header">
                    Update Profile
                </div>
                <button type="button" class="close-modal" id="update-profile-close-btn" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
            {!! Form::open(array('route'=>'profile.update','class'=>'','id'=>'profile-update-form','enctype'=>'multipart/form-data')) !!}
            {{--<form role="form aling-center">--}}
            <!-- text input -->
                <div class="row">
                    <div class="col-xs-6 col-md-6 col-lg-6">
                        <div class="form-group ">
                            <label>name</label>
                            <input id="name" type="text" name="name" class="form-control" placeholder="name" value="{{ auth()->user()->name }}" required>

                        </div>
                    </div>
                    <div class="col-xs-6 col-md-6 col-lg-6">
                        <div class="form-group ">
                            <label>Contact</label>
                            <input id="contact" min="0" type="number" name="contact" class="form-control" placeholder="contact" value="{{ auth()->user()->contact }}" required>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-6 col-lg-6">
                        <div class="form-group ">
                            <label>Email</label>
                            <input id="email" type="email" name="email" class="form-control" placeholder="email" value="{{ auth()->user()->email }}" required>

                        </div>
                    </div>
                    <div class="col-xs-6 col-md-6 col-lg-6">
                        <div class="form-group ">
                            <label>Address</label>
                            <input id="address"  type="text" name="address" class="form-control" placeholder="title" value="{{ auth()->user()->address }}" required>

                        </div>
                    </div>
                </div>
                <div class="row">

                        <div class="col-lg-6" >
                            <div id="hide-upload">
                                <input type="file" id="upload-image" name="image"  class="hide" />
                                <label for="upload-image" id="image" class="btn btn-large">Upload Image </label><br/><br/>
                                <img src="" id="uploadPreview" alt="Preview Image" style="display:none;width:80px;height:80px; position: absolute; top: 5px;    right: 24%;"/>
                                @if(file_exists('storage/'.auth()->user()->image) && auth()->user()->image != '' )
                                    <img src="{{asset('storage/'.auth()->user()->image)}}" id="uploadPreview11" alt="Preview Image" style="display:block;width:80px;height:80px; position: absolute; top: 5px;    right: 24%;"/>

                                @endif
                            </div>
                        </div>
                </div>
                <div class="update-btn-class">
                    <div class="row">
                        @if(!empty($broker))
                        @if($broker->is_active == '1' )
                        <div class="col-xs-4 col-md-4 col-lg-4">
                            <div class="service-provider-form">
                                <a href="javascript:void(0)"  data-toggle="modal" data-target=".broker-update" class="btn update-profile-bnt">Update Broker</a>
                            </div>
                        </div>
                        @endif
                        @endif
                            @if(!empty($vendor))
                            @if($vendor->is_active == '1')
                        <div class="col-xs-4 col-md-4 col-lg-4">
                            <div class="service-provider-form">
                                <a href="javascript:void(0)"  data-toggle="modal" data-target=".vendor-update" class="btn update-profile-bnt">Update Vendor</a>
                            </div>
                        </div>
                            @endif
                            @endif
                            @if(!empty($technician))
                            @if($technician->is_active == 1)
                        <div class="col-xs-4 col-md-4 col-lg-4">
                            <div class="service-provider-form">
                                <a href="javascript:void(0)"  data-toggle="modal" data-target=".update-technician" class="btn update-profile-bnt">Service Provider</a>
                            </div>
                        </div>
                                @endif
                                @endif
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
