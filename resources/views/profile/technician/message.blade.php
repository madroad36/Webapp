<div class="modal fade technician-message-modal" tabindex="-1" id="technician-message-modal" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="product-form-header">
                    Successfull Message
                </div>
                <button type="button" class="close-modal" data-dismiss="modal" aria-hidden="true">×</button>

            </div>
            <div class="modal-body">
                @if(!empty(Auth::user()->technician))
                    <h5>You Have Already register as {{Auth::user()->technician->category->name}}</h5>
                    @else
                <h5>Thank you for form submittion we will contact you soon </h5>
                @endif
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
</div>

