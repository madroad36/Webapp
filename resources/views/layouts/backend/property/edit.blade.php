<div class="modal admn-property-edit  " tabindex="-1" id="property-edit-{{$property->id}}" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true" style="margin-right: 0px;">
   <div class="modal-dialog modal-lg">
       <div class="modal-content">
           <div class="modal-header">
               <div class="product-form-header">
                   Edit Property
               </div>
               <button type="button" class="close-modal" data-dismiss="modal" aria-hidden="true">×</button>
           </div>
           <div class="modal-body">
                   <div class="container-fluid" id="grad1">
                       <div class="row justify-content-center mt-0">
                           <div class="col-lg-12 ">
                               {!! Form::open(array('route'=>['admin.property.update',$property->id],'method'=>'Post','id'=>'property-edit-popup','enctype'=>'multipart/form-data')) !!}
                               <ul id="progressbar">
                                   <li class="step active" id="account"><strong>Basic Information</strong></li>
                                   <li class="step" id="personal"><strong>Ammenities</strong></li>
                                   <li class="step" id="personal"><strong>Owner Details</strong></li>
                                   <li class="step" id="payment"><strong>Property Image</strong></li>
                                   <li class="step" id="confirm"><strong>Finish</strong></li>
                               </ul> <!-- fieldsets -->
                               <fieldset id="first" class="edit">
                                   <div class="title" style="padding-bottom: 33px;">
                                       <div class="row">

                                           <div class=" col-lg-6 ">
                                               <div class="form-group">
                                                   <label>Type</label>
                                                   @php $cat = [] @endphp

                                                   @foreach($categories as $category)

                                                       @php $cat[$category->id] = $category->name @endphp
                                                   @endforeach

                                                   {!! Form::select('category_id',$cat,$property->category_id,['class'=>'form-control edit-form-input','id'=>'category','placeholder'=>'Choose house/land']) !!}
                                                   @if ($errors->has('title'))
                                                       <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                                                   @endif
                                               </div>
                                           </div>
                                           <div class="col-lg-6">
                                               <div class="form-group">

                                                   <label>Purpose</label>


                                                   @php $sub = [] @endphp

                                                   @foreach($subcategories as $subcategory)

                                                   @php $sub[$subcategory->id] = $subcategory->title @endphp
                                                   @endforeach

                                                   {{--{!! Form::select('subcategory_id',[],['class'=>'form-control edit-form-input','id'=>'subcategory','placeholder'=>'Select The Sub-Category']) !!}--}}
                                                   {!! Form::select('subcategory_id',$sub,$property->subcategory_id,['class'=>'form-control edit-form-input','id'=>'subcategory','placeholder'=>'Choose sale/rent']) !!}
                                                   <input type="hidden" nmae="subcategory" id="property-subcategory"
                                                          class="form-control edit-form-input"
                                                          value="{{$property->subcategory->title}}">
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
                                                       <input type="text" name="title"
                                                              class="form-control edit-form-input"
                                                              placeholder="Title of property"
                                                              value="{{ $property->title }}">
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
                                                   <input type="text" name="city" id="city-edit"
                                                          class="form-control edit-form-input" placeholder="city"
                                                          value="{{$property->location->name}}">
                                                   <ul class="city-list">

                                                   </ul>
                                                   @if ($errors->has('title'))
                                                       <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                                                   @endif
                                               </div>
                                           </div>
                                           <div class="col-lg-3">
                                               <div class="form-group">

                                                   <label>Address</label>
                                                   <input type="text" name="address" id="location-address"
                                                          class="form-control edit-form-input" placeholder="address"
                                                          value="{{$property->place->name}}">
                                                   <ul class="address-list">

                                                       @if ($errors->has('title'))
                                                           <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                                                   @endif
                                               </div>
                                           </div>
                                           <div class="col-lg-3">
                                               <div class="form-group">

                                                   <label>LandMark</label>
                                                   <input type="text" name="near_by"
                                                          class="form-control edit-form-input"
                                                          placeholder="near location" value="{{ $property->near_by }}"
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
                                                   <select name="face" id="" class="form-control edit-form-input">
                                                       <option value="" selected="">Select Face</option>
                                                       <option value="East"
                                                               @if($property->face == "East") selected @endif>East
                                                       </option>
                                                       <option value="West"
                                                               @if($property->face == "West")selected @endif>West
                                                       </option>
                                                       <option value="North"
                                                               @if($property->face == "North")selected @endif>North
                                                       </option>
                                                       <option value="South"
                                                               @if($property->face == "South")selected @endif>South
                                                       </option>

                                                   </select>


                                               </div>

                                           </div>
                                       </div>
                                   </div>
                                   <div class="title edit-house" style="padding-bottom: 33px; padding-top: 20px;">
                                       <div class="row">

                                           <div class="col-lg-2">
                                               <div class="form-group">

                                                   <label>Total Room</label>
                                                   <input type="number" min="0" name="total_room"
                                                          class="form-control edit-form-input" placeholder="total room"
                                                          value="{{ $property->total_room }}" required>
                                                   <div id="title"></div>

                                               </div>
                                           </div>
                                           <div class="col-lg-2">
                                               <div class="form-group">

                                                   <label>Kitchen</label>
                                                   <input type="number" min="0" name="kitchen"
                                                          class="form-control edit-form-input" placeholder="kitchen"
                                                          value="{{ $property->kitchen }}" required>
                                                   <div id="title"></div>

                                               </div>
                                           </div>
                                           <div class="col-lg-2">
                                               <div class="form-group">

                                                   <label>Store</label>
                                                   <input type="number" min="0" name="store"
                                                          class="form-control edit-form-input" placeholder="store"
                                                          value="{{ $property->store }}" required>
                                                   <div id="title"></div>

                                               </div>
                                           </div>
                                           <div class="col-lg-2">
                                               <div class="form-group">

                                                   <label>Bathroom</label>
                                                   <input type="number" min="0" name="bathroom"
                                                          class="form-control edit-form-input" placeholder="bath"
                                                          value="{{ $property->bathroom }}" required>
                                                   <div id="title"></div>

                                               </div>
                                           </div>
                                           <div class="col-lg-2">
                                               <div class="form-group">

                                                   <label>Living</label>
                                                   <input type="number" min="0" name="living_room"
                                                          class="form-control edit-form-input" placeholder="living "
                                                          value="{{ $property->living_room }}" required>
                                                   <div id="title"></div>

                                               </div>
                                           </div>
                                           <div class="col-lg-2">
                                               <div class="form-group">

                                                   <label>Hall</label>
                                                   <input type="number" min="0" name="hall"
                                                          class="form-control edit-form-input" placeholder="hall"
                                                          value="{{ $property->hall }}" required>
                                                   <div id="title"></div>

                                               </div>
                                           </div>
                                       </div>
                                   </div>

                                   <div class="title edit-house" style="padding-bottom: 33px;">
                                       <div class="row ">
                                           <div class="col-lg-3">
                                               <div class=" form-group">
                                                   <label>House Type</label>
                                                   <select name="house_type" id=""
                                                           class="form-control edit-form-input">
                                                       <option value="">House Type</option>
                                                       <option value="Commerical"
                                                               @if($property->house_type == 'Commerical')selected @endif>
                                                           Commerical
                                                       </option>
                                                       <option value="Residental"
                                                               @if($property->house_type == 'Residental')selected @endif>
                                                           Residential
                                                       </option>
                                                   </select>

                                               </div>
                                           </div>

                                           <div class="col-lg-3">
                                               <div class=" form-group">
                                                   <label>Drainage</label>
                                                   <select name="drainage" id="" class="form-control edit-form-input">
                                                       <option value="">Drainage</option>
                                                       <option value="Sewage"
                                                               @if($property->drainage == 'Sewage')selected @endif>
                                                           Sewage
                                                       </option>
                                                       <option value="Septic Tank"
                                                               @if($property->drainage == 'Septic Tank')selected @endif>
                                                           Septic Tank
                                                       </option>
                                                   </select>
                                               </div>
                                           </div>
                                           <div class="col-lg-3">
                                               <div class=" form-group ">
                                                   <label for="">Built Year </label>
                                                   <input type="number" id="build-on" name="build" placeholder="1918"
                                                          class="form-control edit-form-input" max="0"
                                                          value="{{$property->build}}">
                                                   <select name="date_type" id="property-date"
                                                           class="form-control edit-form-input">
                                                       <option value="">&#10003;</option>
                                                       <option value="A.D"
                                                               @if($property->date_type == 'A.D')selected @endif>A.D
                                                       </option>
                                                       <option value="B.S"
                                                               @if($property->date_type == 'B.S')selected @endif>B.S
                                                       </option>
                                                   </select>

                                               </div>
                                           </div>
                                           <div class="col-lg-3">
                                               <div class=" form-group">
                                                   <label for="">Shape</label>
                                                   <select name="shape" id="" class="form-control edit-form-input">
                                                       <option value="">Select Shape</option>
                                                       <option value="Round"
                                                               @if($property->shape == 'Round')selected @endif>Round
                                                       </option>
                                                       <option value="Square"
                                                               @if($property->shape == 'Square')selected @endif>Square
                                                       </option>
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
                                                          class="form-control edit-form-input "
                                                          value="{{$property->plot_no}}">
                                                   <span class="text-danger"></span>

                                               </div>

                                           </div>

                                           <div class="col-lg-4">
                                               <div class=" form-group ">
                                                   <label for="">Area</label>
                                                   <input type="text" name="area" placeholder="0-0-0-0"
                                                          class="form-control edit-form-input"
                                                          value="{{$property->area}}">


                                               </div>
                                           </div>
                                           <div class="col-lg-4">
                                               <label for="">Unit</label>
                                               <select name="land_unit" class="form-control edit-form-input">
                                                   <option value="">Select Unit</option>
                                                   <option value="dhur"
                                                           @if($property->land_unit == 'dhur')selected @endif>dhur
                                                   </option>
                                                   <option value="anna"
                                                           @if($property->land_unit == 'anna')selected @endif>anna
                                                   </option>
                                                   <option value="ropani"
                                                           @if($property->land_unit == 'ropani')selected @endif>ropani
                                                   </option>
                                                   <option value="kattha"
                                                           @if($property->land_unit == 'kattha')selected @endif>kattha
                                                   </option>

                                               </select>
                                           </div>
                                       </div>
                                       <div class="title " style="padding-bottom: 33px;">
                                           <div class="row">
                                               <div class="col-lg-4">
                                                   <div class=" form-group">
                                                       <label for="">Road Size</label>
                                                       <input type="text" name="road_size" placeholder="Road Size"
                                                              class=" form-control edit-form-input "
                                                              value="{{$property->road_size}}">
                                                       <span class="text-danger"></span>
                                                   </div>
                                               </div>
                                               <div class="col-lg-4">
                                                   <div class="rent">
                                                       <label for="">Payment Period</label>

                                                       <select name="rent_option" class="form-control edit-form-input">
                                                           <option value="" selected>Choose</option>
                                                           <option value="monthly"
                                                                   @if($property->rent_option == 'monthly') selected @endif>
                                                               Monthly
                                                           </option>
                                                           <option value="annualy"
                                                                   @if($property->rent_option == 'annualy') selected @endif>
                                                               Annualy
                                                           </option>
                                                       </select>
                                                   </div>

                                               </div>
                                               <div class="col-lg-4">
                                                   <div class="form-group">

                                                       <label>Price</label>
                                                       <input type="number" min="0" name="price"
                                                              class="form-control edit-form-input" placeholder="price"
                                                              value="{{ $property->price }}" required>
                                                       <div id="title"></div>


                                                   </div>
                                               </div>


                                           </div>
                                       </div>
                                       <div class="row">
                                           <div class="col-lg-12">
                                               <div class="form-group">
                                                   <label for="">OverView</label>
                                                   <textarea name="short_description"
                                                             class="form-control edit-form-input"
                                                             placeholder="Overview of your property" id="edit-textarea" cols="30"
                                                             rows="10">
                                                           {{ $property->overview }}
                                                       </textarea>
                                               </div>
                                           </div>
                                       </div>


                               </fieldset>
                               <fieldset id="second" class="edit">
                                   <div class="row">


                                       @php $propertyKey = [] @endphp
                                       @foreach($property->property_amminites as $key)
                                           @php  $propertyKey [] = [ 'aminities_id' => $key->aminities_id, 'is_active'=>$key->is_active ];  @endphp
                                       @endforeach


                                           <ul class="aminites-list">
                                                @foreach($aminites->chunk(3) as $aminite)
                                               @foreach($aminite as $value)

                                                   <li>
                                                       <label class="main">{{$value->name}}
                                                           <input class="check-price edit-form-input"
                                                                  @if(array_search($value->id, array_column($propertyKey, 'aminities_id')) !== false )checked
                                                                  @endif type="checkbox"
                                                                  name="aminites[{{$value->id}}] ">
                                                           <span class="w3docs"></span>
                                                       </label>
                                                   </li>

                                               @endforeach
                                               @endforeach
                                           </ul>

                                      


                                   </div>
                               </fieldset>
                               <fieldset id="third" class="edit">
                                   <div class="form-card">
                                       <div class="title" style="padding-bottom: 33px;">
                                           <div class="row">
                                               <div class="col-lg-6">
                                                   <div class="form-group {{$errors->has('name') ?  'has-error' :''}}">

                                                       <input type="text" name="name" placeholder="Name"
                                                              class="form-control form-input"
                                                              value="{{$property->name}}"/>
                                                       <span class="text-danger">{{ $errors->first('name') }}</span>

                                                   </div>
                                               </div>
                                               <div class="col-lg-6">
                                                   <div class="form-group {{$errors->has('contact') ?  'has-error' :''}}">

                                                       <input type="number" name="contact" placeholder="Contact Number"
                                                              class=" form-control form-input"
                                                              value="{{$property->contact}}"
                                                       />
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
                                                              placeholder="Citizenship Number" value="{{$property->citizen}}"
                                                       />
                                                       <span class="text-danger">{{ $errors->first('citizen') }}</span>
                                                   </div>
                                               </div>

                                               <div class="col-lg-6">
                                                   <div id="hide-upload" class="ownerUpload">
                                                       <input type="file" name="owner_image" id="ownerUpload-edit"
                                                              class="hide "/>
                                                       <label for="ownerUpload-edit" class="btn btn-large ">Citizenship
                                                           Image</label><br/><br/>
                                                       <img src="" id="ownerPreview-edit" alt="Preview Image"
                                                            style="display:none;width:100px;height:100px;  padding-top: 20px;    right: 24%;"/>
                                                       @if(file_exists('../storage/app/public/'.$property->owner_image) && $property->owner_image !=='')
                                                           <img src="{{asset('../storage/app/public/'.$property->owner_image)}}"
                                                                id="ownerPreview-edit-view" alt="Preview Image"
                                                                style="width:100px;height:100px;  padding-top: 20px;    right: 24%;"/>
                                                       @endif
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>

                               </fieldset>

                               <fieldset id="fourth" class="edit">
                                   <div class="form-card">
                                       <div class="title" style="padding-bottom: 33px;">
                                           <div class="row">

                                               <div class="col-lg-4">
                                                   <div class="form-group {{$errors->has('image') ?  'has-error' :''}}">
                                                       <div id="hide-upload" class="propertyUpload">
                                                           <input type="file" name="image" id="propertyUpload-edit"
                                                                  class="hide form-input"/>
                                                           <label for="propertyUpload-edit"
                                                                  class="btn btn-large form-control edit-form-input">Thumbnail</label><br/><br/>
                                                                  <img src=""
                                                                    id="propertyPreview-edit" alt="Preview Image"
                                                                    style="width:100px;height:100px;display:none;  padding-top: 20px; display:none    right: 24%;"/>
                                                           @if(file_exists('../storage/app/public/'.$property->thumbnail) && $property->thumbnail !=='')
                                                               <img src="{{asset('../storage/app/public/'.$property->thumbnail)}}"
                                                                    id="propertyPreview-edit-view" alt="Preview Image"
                                                                    style="width:100px;height:100px;  padding-top: 20px;    right: 24%;"/>
                                                           @endif

                                                       </div>
                                                       <div id="image"></div>
                                                   </div>
                                               </div>
                                               <div class="col-lg-4">


                                                   <div id="hide-upload" class="paperUpload">
                                                       <input type="file" name="property_image" id="paperUpload-edit"
                                                              class="hide"/>
                                                       <label for="paperUpload-edit" class="btn btn-large form-control">Upload
                                                           goverment Paper</label><br/><br/>
                                                       <img src="" id="paperPreview-edit" alt="Preview Image"
                                                            style="display:none;width:100px;height:100px;  padding-top: 20px;    right: 15%;"/>
                                                       @if(file_exists('../storage/app/public/'.$property->property_image) && $property->property_image !=='')
                                                           <img src="{{asset('../storage/app/public/'.$property->property_image)}}"
                                                                id="paperPreview-edit-view" alt="Preview Image"
                                                                style="width:100px;height:100px;  padding-top: 20px;    right: 24%;"/>
                                                       @endif
                                                   </div>


                                               </div>
                                               <div class="col-lg-4">


                                                   <div id="hide-upload" class="paperUpload">
                                                       <input type="file" name="property_paper" id="lalapurjaUpload-edit"
                                                              class="hide "/>
                                                       <label for="lalapurjaUpload-edit" class="btn btn-large form-control">Lalapurja</label><br/><br/>
                                                       <img src="" id="lalapurjaPreview-edit" alt="Preview Image"
                                                            style="display:none;width:100px;height:100px;  padding-top: 20px;    right: 15%;"/>
                                                    
                                                       @if(file_exists('../storage/app/public/'.$property->property_paper) && $property->property_paper !=='')
                                                               <img src="{{asset('../storage/app/public/'.$property->property_paper)}}"
                                                                    id="lalapurjaPreview-edit-view" alt="Preview Image"
                                                                    style="width:100px;height:100px;  padding-top: 20px;    right: 24%;"/>
                                                           @endif
                                                   </div>


                                               </div>
                                           </div>
                                       </div>
                                   </div>

                               </fieldset>
                               <fieldset id="fifth" class="edit">
                                   <div class="row">
                                      <div class="col-lg-4">
                                            <div class="form-group {{$errors->has('broker') ?  'has-error' :''}}">
                                                    <ul class="aminites-list">
                                                        <span>Do you want Broker ?</span>
                                                        <li>
                                                            <label class="main">
                                                                <input type="checkbox" @if($property->broker == '1') checked
                                                                       @endif) class="broker" name="broker">Yes
                                                                <span class="w3docs"></span>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="main">
                                                                <input type="checkbox" @if($property->broker == '0') checked
                                                                       @endif) class="broker" name="broker" value="0">No
                                                                <span class="w3docs"></span>
                                                            </label>
                                                        </li>
                                                    </ul>
         
                                                </div>
                                      </div>
                                      <div class="col-lg-8">

                                      </div>

                                   </div>
                               </fieldset>
                               <div style="overflow:auto;">


                               </div>
                               <div style="align-items: center;" class="footerbtn">
                                   <button type="button" id="previousBtn" class="action-button-previous"
                                           style="display: none" onclick="EditnextPrev(-1)">Previous
                                   </button>
                                   <button type="button" id="EditnextBtn" class="action-button"
                                           onClick="EditnextPrev(1)">Next
                                   </button>
                               </div>
                               {!! Form::close() !!}
                           </div>
                           <!-- Circles which indicates the steps of the form: -->
                           {{--{!! Form::hidden('id',$property->id) !!}--}}

                       </div>
                   </div>
               
           </div>
       </div>
       <div class="modal-footer">

       </div>
   </div>
</div>

