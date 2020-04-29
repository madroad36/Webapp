
<div class="modal fade product-order-detail-view" tabindex="-1" id="property-add" data-backdrop="false" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="product-form-header">
                        Order Detail
                    </div>
                    <button type="button" class="close-modal" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-lg-6">
                            <div class="order-card-details-view">
                            <div class="card card-elegant">
                                @if(file_exists('storage/'.$order->product->image) && $order->product->image != '')
                                    <img class="card-img-top" src="{{asset('storage/'.$order->product->image)}}" width="100%" height="300px" alt="Card image cap" style="opacity:.5">
                                @endif
                                <div class="card-block">
                                    <span><strong>Title:</strong>{{$order->product->title}}</span>
                                    <span><strong>Category:</strong>{{$order->product->category->title}}</span>
                                    <span><strong>Price:</strong>Rs-{{$order->product->price}} &nbsp;{{$order->product->unit}}</span>
                                    <span><strong id="stock">Stock:</strong>{{$order->product->quantity}}</span>


                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-6">
                            <div class="order-details-info">
                                <span><strong>Serial Number:</strong>{{$order->serial_number}}</span>

                                <div class="margin-line"></div>
                                <div class="owner-information">
                                    <h4>Owner Information</h4>
                                    <span><strong>Address:</strong>{{$order->owner->address}}</span>
                                    <span><strong>contact:</strong>{{$order->owner->contact}}</span>
                                </div>
                                <div class="margin-line"></div>
                                <div class="owner-information">
                                    <h4>Buyer Information</h4>
                                    <span><strong>Quantity:</strong>{{$order->quantity}}</span>
                                    <span><strong>Contact:</strong>{{$order->buyer->contact}}</span>
                                    <span><strong>Shipping Address:</strong>{{$order->location}}</span>
                                    <span><strong>Total Price:</strong>{{$order->quantity * $order->product->price}}</span>
                                    <span ><strong>Sold:</strong>
                                            @if($order->is_active == 1)
                                            <i class="fa fa-check-circle"></i>

                                        @else
                                            <i class="fa fa-close"></i>
                                        @endif

                                        </span>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>


