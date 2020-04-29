<div class="modal fade update-technician" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
            {!! Form::open(array('route'=>'technician.update','class'=>'','id'=>'technician-edit','enctype'=>'multipart/form-data')) !!}
            {{--<form role="form aling-center">--}}
            <!-- text input -->
                @if(!empty($technician))
                @if(!empty(auth()->user()->technician))
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Service</label>
                            @php $cat = [] @endphp

                            @foreach($serviceCategories as $category)

                                @php $cat[$category->id] = $category->name @endphp
                            @endforeach
                            {!! Form::select('category_id',$cat,Auth::user()->technician->category_id,['class'=>'form-control','id'=>'category_id','placeholder'=>'Select The Category']) !!}


                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Year of Experience</label>
                            <input type="text" id="experience" name="experience" class="form-control" placeholder="Year of experience" value="{{ auth()->user()->technician->experience }}" required>
                            <div id="title"></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Citizen No</label>
                            <input type="text" id="citizen_no" name="citizen_no" class="form-control" placeholder="Citizen Number" value="{{  auth()->user()->technician->citizen_no }}" required>


                        </div>
                    </div>

                    <div class="col-lg-6" >
                        <div id="hide-upload">
                            <input type="file" id="technician-citizen-image" name="citizen_upload"  class="hide" />
                            <label for="technician-citizen-image" id="citizen_upload" class="btn btn-large">Upload Citizen</label><br/><br/>
                            <img src="" id="technician-citizenPreview" alt="Preview Image" style="display:none;width:80px;height:80px; position: absolute; top: 5px;    right: 24%;"/>
                            @if(file_exists('storage/'.auth()->user()->technician->citizen) && auth()->user()->technician->citizen != '' )
                                <img src="{{asset('storage/'.auth()->user()->technician->citizen)}}" id="technician-citizen-server" alt="Preview Image" style="display:block;width:80px;height:80px; position: absolute; top: 5px;    right: 24%;"/>

                            @endif

                        </div>
                        <div id="image"></div>
                    </div>
                    <div class="col-lg-6" >
                        <div id="hide-upload">
                            <input type="file" id="technician-certificate-image" name="certificate_upload"  class="hide" />
                            <label for="technician-certificate-image" id="certificate_upload" class="btn btn-large">Upload Certificate</label><br/><br/>
                            <img src="" id="technician-certificatePreview" alt="Preview Image" style="display:none;width:80px;height:80px; position: absolute; top: 5px;    right: 24%;"/>
                            @if(file_exists('storage/'.auth()->user()->technician->certificate) && auth()->user()->technician->certificate != '' )
                                <img src="{{asset('storage/'.auth()->user()->technician->certificate)}}" id="technician-certificate-server" alt="Preview Image" style="display:block;width:80px;height:80px; position: absolute; top: 5px;    right: 24%;"/>

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