<div class="modal fade product-edit-{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: blueviolet; color: #fff; text-align: center;">
                <div class="product-form-header">
                    Editproduct
                </div>
                <button type="button" class="close-modal" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
            {!! Form::open(array('route'=>['product.update',$product->id],'class'=>'product-edit','enctype'=>'multipart/form-data')) !!}
            {{--<form role="form aling-center">--}}
            <!-- text input -->
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" placeholder="title" value="{{ $product->title }}" required>
                    <div id="title"></div>
                    @if ($errors->has('title'))
                        <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                    @endif

                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <label>Paid ?</label>
                            {!! Form::checkbox('paid', 1, true, array('class' => '',)) !!}
                        </div>
                        <div class="col-lg-6">
                            <label>Publish ?</label>
                            {!! Form::checkbox('is_active', 1, true, array('class' => '',)) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-4">
                            <label>Price</label>
                            <input type="number" name="price" class="form-control" placeholder="Price"
                                   value="{{ $product->price }}" required>
                            @if ($errors->has('price'))
                                <div class="alert alert-danger">{{ $errors->first('price') }}</div>
                            @endif
                            <div id="price"></div>

                        </div>

                        <div class="col-lg-4">
                            <label>Unit</label><br>
                            <select name="unit" id="" class="form-control" >
                                <option value="0" selected>Select the unit</option>
                                <option value="per piece"  @if($product->unit == 'per piece') selected @endif>Per Piece</option>
                                <option value="dozen" @if($product->unit == 'dozen') selected @endif>Dozen</option>
                            </select>
                            <div id="unit"></div>
                        </div>

                        <div class="col-lg-4">
                            <label>Quantity</label>
                            <input type="number" name="quantity" class="form-control" placeholder="Quantity"
                                   value="{{ $product->quantity }}" required>
                            @if ($errors->has('price'))
                                <div class="alert alert-danger">{{ $errors->first('quantity') }}</div>
                            @endif
                            <div id="quantity"></div>
                        </div>

                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <label>Category</label>
                            @php $cat = [] @endphp

                            @foreach($productCategories as $category)

                                @php $cat[$category->id] = $category->title @endphp
                            @endforeach
                            {!! Form::select('category_id',$cat,$product->category_id,['class'=>'form-control','placeholder'=>'Select The Category']) !!}

                            @if ($errors->has('category_id'))
                                <div class="alert alert-danger">{{ $errors->first('clategory_id') }}</div>
                            @endif
                            <div id="category_id"></div>
                        </div>
                        <div class="col-lg-6" >
                            <div id="hide-upload">
                                <input type="file" name="image" id="imageUpload" class="hide" />
                                <label for="imageUpload" class="btn btn-large">Select Product Image</label><br/><br/>
                                @if(file_exists('storage/'.$product->image) && $product->image != '')
                                <img src="{{asset('storage/'.$product->image)}}" id="imagePreview" alt="Preview Image" style="width:80px;height:80px; position: absolute; top: 5px;    right: 24%;"/>
                                @else
                                    <img src="" id="imagePreview" alt="Preview Image" style="display:none;width:80px;height:80px; position: absolute; top: 5px;    right: 24%;"/>

                                @endif
                            </div>
                            <div id="image"></div>
                            <input class="product-edit-id" type="hidden" value="{{$product->id}}"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Description</label>

                    {!! Form::textarea('description',$product->description, array('class'=>'form-control ','rows'=>'10', 'cols'=>'50', 'placeholder'=>'Product Details','id'=>'editor','required')) !!}
                    <div id="description"></div>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary">Submit</button>
                </div>
                <!-- checkbox -->


                {!! Form::close() !!}
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
