<div class="modal fade add-property" tabindex="-1" id="property-add" data-backdrop="false" role="dialog" aria-labelledby="myLargeModalLabel"
aria-hidden="true" style="margin-right: 0px;">
<div class="modal-dialog modal-lg"> 
    <div class="modal-content">
        <div class="modal-header">
            <div class="product-form-header">
                Add New Property
            </div>
            <button type="button" class="close-modal" data-dismiss="modal" aria-hidden="true">×</button>

        </div>
        <div class="modal-body">
                <div class="container-fluid" id="grad1">
                    <div class="row justify-content-center mt-0">
                        <div class="col-lg-12  text-center">
                            {!! Form::open(array('route'=>['property.store'],'method'=>'Post','id'=>'property-add-popup','enctype'=>'multipart/form-data')) !!}
                                <ul id="progressbar">
                                    <li class="step active" id="account"><strong>Basic Information</strong></li>
                                    <li class="step" id="personal"><strong>Ammenities</strong></li>
                                    <li class="step" id="personal"><strong>Owner Details</strong></li>
                                    <li class="step" id="payment"><strong>Property Image</strong></li>
                                    <li class="step" id="confirm"><strong>Finish</strong></li>
                                </ul> <!-- fieldsets -->
                                <!-- One "tab" for each step in the form: -->
                                <fieldset id="first" class="tab">
                                    <div class="title" style="padding-bottom: 33px;">
                                        <div class="row">

                                            <div class=" col-lg-6 ">
                                                <div class="form-group">
                                                    <label>Type</label>
                                                    @php $cat = [] @endphp

                                                    @foreach($categories as $category)

                                                    @php $cat[$category->id] = $category->name @endphp
                                                    @endforeach

                                                    {!! Form::select('category_id',$cat,[],['class'=>'form-control form-input','id'=>'category','placeholder'=>'Choose house/land']) !!}
                                                    @if ($errors->has('title'))
                                                    <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">

                                                    <label>Purpose</label>
                                                    {!! Form::select('subcategory_id',[],[],['class'=>'form-control form-input','id'=>'subcategory','placeholder'=>'Choose sale/rent']) !!}

                                                    <div id="title"></div>
                                                    @if ($errors->has('title'))
                                                    <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class=" col-lg-12 ">
                                                <div class="title " style="padding-bottom: 33px; ">
                                                    <div class="form-group">
                                                        <label>Title</label>
                                                        <input type="text" name="title" class="form-control form-input"
                                                        placeholder="Title of property"
                                                        value="{{ old('title') }}">
                                                        <div id="title"></div>
                                                        @if ($errors->has('title'))
                                                        <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">

                                                    <label>City</label>
                                                    <input type="text" name="city" id="city"
                                                    class="form-control form-input" placeholder="city">

                                                    @if ($errors->has('title'))
                                                    <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">

                                                    <label>Address</label>
                                                    <input type="text" name="address" id="address"
                                                    class="form-control form-input" placeholder="address">


                                                    @if ($errors->has('title'))
                                                    <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">

                                                    <label>LandMark</label>
                                                    <input type="text" name="near_by" class="form-control form-input"
                                                    placeholder="near location" value="{{ old('title') }}"
                                                    required>
                                                    <div id="title"></div>
                                                    @if ($errors->has('title'))
                                                    <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class=" form-group ">
                                                    <label for="">Face Direction</label>
                                                    <select name="face" id="" class="form-control form-input">
                                                        <option value="" selected="">Select Face</option>
                                                        <option value="East">East</option>
                                                        <option value="West">West</option>
                                                        <option value="West">North</option>
                                                        <option value="West">South</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="title house" style="padding-bottom: 33px; padding-top: 20px;">
                                            <div class="row">

                                                <div class="col-lg-2">
                                                    <div class="form-group">

                                                        <label>Total Room</label>
                                                        <input type="number" min="0" name="total_room"
                                                        class="form-control form-input" placeholder="total room"
                                                        value="{{ old('title') }}" required>
                                                        <div id="title"></div>

                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">

                                                        <label>Kitchen</label>
                                                        <input type="number" min="0" name="kitchen"
                                                        class="form-control form-input" placeholder="kitchen"
                                                        value="{{ old('title') }}" required>
                                                        <div id="title"></div>

                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">

                                                        <label>Store</label>
                                                        <input type="number" min="0" name="store"
                                                        class="form-control form-input" placeholder="store"
                                                        value="{{ old('title') }}" required>
                                                        <div id="title"></div>

                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">

                                                        <label>Bathroom</label>
                                                        <input type="number" min="0" name="bathroom"
                                                        class="form-control form-input" placeholder="bath"
                                                        value="{{ old('title') }}" required>
                                                        <div id="title"></div>

                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">

                                                        <label>Living</label>
                                                        <input type="number" min="0" name="living_room"
                                                        class="form-control form-input" placeholder="living "
                                                        value="{{ old('title') }}" required>
                                                        <div id="title"></div>

                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">

                                                        <label>Hall</label>
                                                        <input type="number" min="0" name="hall"
                                                        class="form-control form-input" placeholder="hall"
                                                        value="{{ old('title') }}" required>
                                                        <div id="title"></div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="title house " style="padding-bottom: 33px;">
                                            <div class="row ">
                                                <div class="col-lg-3">
                                                    <div class=" form-group">
                                                        <label>House Type</label>
                                                        <select name="house_type" id="" class="form-control form-input">
                                                            <option value="" selected="0">House Type</option>
                                                            <option value="Commerical">Commerical</option>
                                                            <option value="Residental">Residential</option>
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <div class=" form-group">
                                                        <label>Drainage</label>
                                                        <select name="drainage" id="" class="form-control form-input">
                                                            <option value="" selected="0">Drainage</option>
                                                            <option value="Sewage">Sewage</option>
                                                            <option value="Septic Tank">Septic Tank</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class=" form-group ">
                                                        <label for="">Built Year </label>
                                                        <input type="number" id="build-on" name="build"
                                                        placeholder="1918" class="form-control form-input"
                                                        max="0">
                                                        <select name="date_type" id="property-date"
                                                        class="form-control form-input">
                                                        <option value="" selected="">&#10003;</option>
                                                        <option value="A.D">A.D</option>
                                                        <option value="B.S">B.S</option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class=" form-group">
                                                    <label for="">Shape</label>
                                                    <select name="shape" id="" class="form-control form-input">
                                                        <option value="" selected="">Select Shape</option>
                                                        <option value="Round">Round</option>
                                                        <option value="Square">Square</option>
                                                    </select>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="title " style="padding-bottom: 33px;">
                                        <div class="row ">
                                            <div class="col-lg-4">
                                                <div class=" form-group ">
                                                    <label for="">Plot Number</label>
                                                    <input type="text" name="plot_no" placeholder="Plot number"
                                                    class="form-control form-input " value="">
                                                    <span class="text-danger"></span>

                                                </div>

                                            </div>

                                            <div class="col-lg-4">
                                                <div class=" form-group ">
                                                    <label for="">Area</label>
                                                    <input type="text" name="area" placeholder="0-0-0-0"
                                                    class="form-control form-input">


                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="">Unit</label>
                                                <select name="land_unit" class="form-control form-input">
                                                    <option value="" selected="">Select Unit</option>
                                                    <option value="dhur">dhur</option>
                                                    <option value="anna">anna</option>
                                                    <option value="ropani">ropani</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="title " style="padding-bottom: 33px;">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class=" form-group">
                                                    <label for="">Road Size</label>
                                                    <input type="text" name="road_size" placeholder="Road Size"
                                                    class=" form-control form-input " value="">
                                                    <span class="text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="rent">
                                                    <label for="">Payment Period</label>

                                                    <select name="rent_option" class="form-control form-input">
                                                        <option selected="" value="">Choose</option>
                                                        <option value="monthly">Monthly</option>
                                                        <option value="annualy">Annualy</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">

                                                    <label>Price</label>
                                                    <input type="number" min="0" name="price"
                                                    class="form-control form-input" placeholder="price"
                                                    value="{{ old('price') }}" required>
                                                    <div id="title"></div>


                                                </div>
                                            </div>


                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="">OverView</label>
                                                    <textarea name="short_description"
                                                    class="form-control form-input"
                                                    placeholder="Overview of your property" id=""
                                                    cols="30" rows="10"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </fieldset>
                                <fieldset id="second" class="tab">
                                    <div class="row">


                                        @foreach($aminites->chunk(3,true) as $chunk)
                                        <ul class="aminites-list">
                                            @foreach($chunk as $value)
                                            <li>
                                                <label class="main">{{$value->name}}
                                                    <input class="check-price edit-form-input" type="checkbox"
                                                    name="aminites[{{$value->id}}] ">
                                                    <span class="w3docs"></span>
                                                </label>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @endforeach


                                    </div>
                                </fieldset>
                                <fieldset id="third" class="tab">
                                    <div class="form-card">
                                        <div class="title" style="padding-bottom: 33px;">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group {{$errors->has('name') ?  'has-error' :''}}">

                                                        <input type="text" name="name" placeholder="Name"
                                                        class="form-control form-input"/>
                                                        <span class="text-danger">{{ $errors->first('name') }}</span>

                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group {{$errors->has('contact') ?  'has-error' :''}}">

                                                        <input type="number" name="contact" placeholder="Contact Number"
                                                        class=" form-control form-input"/>
                                                        <span class="text-danger">{{ $errors->first('contact') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="title sell" style="padding-bottom: 33px;">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group {{$errors->has('citizen') ?  'has-error' :''}}">

                                                        <input type="number" name="citizen" class="form-control"
                                                        placeholder="Citizenship Number" required/>
                                                        <span class="text-danger">{{ $errors->first('citizen') }}</span>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div id="hide-upload" class="ownerUpload">
                                                        <input type="file" name="owner_image" id="ownerUpload"
                                                        class="hide" required />
                                                        <label for="ownerUpload" class="btn btn-large form-control">Citizenship
                                                        Image</label><br/><br/>
                                                        <img src="" id="ownerPreview" alt="Preview Image"
                                                        style="display:none;width:100px;height:100px; padding-top: 20px;    right: 24%;"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </fieldset>

                                <fieldset id="fourth" class="tab">
                                    <div class="form-card">
                                        <div class="title" style="padding-bottom: 33px;">
                                            <div class="row">

                                                <div class="col-lg-4">
                                                    <div class="form-group {{$errors->has('image') ?  'has-error' :''}}">
                                                        <div id="hide-upload" class="propertyUpload">
                                                            <input type="file" name="image" id="propertyUpload"
                                                            class="hide form-input"/>
                                                            <label for="propertyUpload"
                                                            class="btn btn-large form-control">Thumbnail</label><br/><br/>
                                                            <img src="" id="propertyPreview" alt="Preview Image"
                                                            style="display:none;width:100px;height:100px; padding-top: 20px;    right: 24%;"/>

                                                        </div>
                                                        <div id="image"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">


                                                    <div id="hide-upload" class="paperUpload">
                                                        <input type="file" name="property_image" id="paperUpload"
                                                        class="hide"/>
                                                        <label for="paperUpload" class="btn btn-large form-control">Upload
                                                        goverment Paper</label><br/><br/>
                                                        <img src="" id="paperPreview" alt="Preview Image"
                                                        style="display:none;width:100px;height:100px; padding-top: 20px;    right: 15%;"/>
                                                    </div>


                                                </div>
                                                <div class="col-lg-4">


                                                    <div id="hide-upload" class="paperUpload">
                                                        <input type="file" name="property_paper" id="lalapurjaUpload"
                                                        class="hide "/>
                                                        <label for="lalapurjaUpload" class="btn btn-large form-control">Lalapurja</label><br/><br/>
                                                        <img src="" id="lalapurjaPreview" alt="Preview Image"
                                                        style="display:none;width:100px;height:100px; padding-top: 20px;    right: 15%;"/>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset id="fifth" class="tab">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group {{$errors->has('broker') ?  'has-error' :''}}">
                                                <ul class="aminites-list">
                                                    <span>Do you want Broker ?</span>
                                                    <li>
                                                        <label class="main">
                                                            <input type="checkbox" class="broker" name="broker">Yes
                                                            <span class="w3docs"></span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="main">
                                                            <input type="checkbox" class="broker" name="broker" value="0">No
                                                            <span class="w3docs"></span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>
                                        <div class="col-lg-8"></div>
                                        
                                    </div>
                                </fieldset>


                                <div style="overflow:auto;">


                                </div>
                                <div style="align-items: center;" class="footerbtn">
                                    <button type="button" id="prevBtn" class="action-button-previous"
                                    onclick="nextPrev(-1)">
                                    Previous
                                </button>
                                <button type="button" id="nextBtn" class="action-button" onClick="nextPrev(1)">
                                    Next
                                </button>

                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>

            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
</div>


