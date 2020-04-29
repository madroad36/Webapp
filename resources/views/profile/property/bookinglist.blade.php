
<div class="modal fade property-booking-list" tabindex="-1" id="booking-list" data-backdrop="false" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="product-form-header">
                   Buyer List
                </div>
                <button type="button" class="close-modal" data-dismiss="modal" aria-hidden="true">×</button>

            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="container-fluid" id="grad1">
                        <div class="row justify-content-center mt-0">
                            <div class="col-lg-12  text-center ">



                                    <table class="table datatable">
                                        <thead class=" text-primary">
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Contact</th>
                                            <th>Address</th>
                                            <th>Action</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($property->book as $key=>$booking)
                                            <tr>
                                                <td>{{ $key+1}}</td>
                                                <td>{{$booking->user->name}}</td>
                                                <td>{{$booking->user->contact}}</td>
                                                <td>{{$booking->user->address}}</td>
                                                <td>
                                                    @if($booking->is_active == 1)
                                                    <a href="javascript:void(0)" id="change-booking" data-type="{{$booking->id}}" class="btn btn-primary">
                                                        <i class="fa fa-check-circle"></i>
                                                    </a>
                                                        @else
                                                        <a href="javascript:void(0)" id="change-booking" data-type="{{$booking->id}}" class="btn btn-primary">
                                                            <i class="fa fa-close"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>


                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
</div>


