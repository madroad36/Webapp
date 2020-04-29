<div class="modal fade property-gal-image" tabindex="-1" data-backdrop="false" id="property-gallery-image" role="dialog"
     aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="product-form-header">
                    Property Gallery Image
                </div>
                <button type="button" class="close-modal" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="image-upload">
                    <div class="row">
                        <div class="edit-property-gallery-image"></div>
                        <div class="col-md-10 offset-md-1">

                            {!! Form::open(array('route'=>'property_image.store','class'=>'dropzone','id'=>'propertyId','enctype'=>'multipart/form-data')) !!}
                            <input type="hidden" id="image"/>

                            {!! Form::close() !!}
                        </div>


                    </div>
                    <a href="javascript:void(0)" class="btn btn-primary image-upload-btn"> Upload Image</a>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



