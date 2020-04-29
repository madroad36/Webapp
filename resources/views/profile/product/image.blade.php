





<div class="modal fade product-image"  id="product-image" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: blueviolet; color: #fff; text-align: center;">
                <div class="product-form-header">
                    Product Gallery Image
                </div>
                <button type="button" class="close-modal" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="image-upload">
                    <div class="row">
                        <div class="product-gallery-image"></div>
                        <div class="col-md-10 offset-md-1">

                        {!! Form::open(array('route'=>'product_image.store','class'=>'dropzone','id'=>'productId','enctype'=>'multipart/form-data')) !!}
                        {{--<form role="form aling-center">--}}
                        <!-- text input -->



                            <!-- checkbox -->

                            <input type="hidden" id="image" />

                            {!! Form::close() !!}
                        </div>


                    </div>
                    <a href="javascript:void(0)" class="btn btn-primary product-image-upload"> Submit</a>
                </div>
            </div>

        </div>
            <div class="modal-footer">

            </div>
        </div>
</div>



