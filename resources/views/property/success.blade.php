<div class="modal fade booking-success" tabindex="-1" id="booking-success" role="dialog" aria-labelledby="myLargeModalLabel"
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
                <div class="booking-success-message">
                    <P id="message"></P>
                    <p>Contact:<span id="booking-contact"></span></p>
                    <p>Email: <span id="booking-email"></span></p>
{{--                    <a href="{{route('ordered.property')}}" id="property" class="btn">Contitnute Property Listing</a>--}}
                    <a href="{{url('/view/profile/')}}" id="profile" class="btn btn-primary">Show My Profile</a>
                </div>

                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
</div>

