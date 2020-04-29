@extends('profile.app')
@section('title', 'Transaction List')

@section('main-content')

    <div class="container">
        <h3>Transaction list</h3>

        <div class="row">
            <div class="col-lg-6">
                <div class="transaction-wrapper">
                    <div class="property-transaction-report">
                        <div class="transaction-content">
                            <h4>Property</h4>
                            <div class="transaction-details">
                                <div class="transaction-details-left">
                                    <span class="total-number">{{  $propertypending}}</span>
                                    <span>Pending</span>
                                </div>
                                <div class="transaction-details-right">
                                    <span class="total-number">{{  $totalproperty}}</span>
                                    <span>Total</span>

                                </div>
                            </div>
                            <i class="fa fa-home"></i>
                            <a href="">More Details</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="transaction-wrapper">
                    <div class="product-transaction-report">
                        <div class="transaction-content">
                            <h4>Product</h4>
                            <div class="transaction-details">
                                <div class="transaction-details-left">
                                    <span class="total-number">{{  $productpending}}</span>
                                    <span>Pending</span>
                                </div>
                                <div class="transaction-details-right">
                                    <span class="total-number">{{  $totalproduct}}</span>
                                    <span>Total</span>

                                </div>
                            </div>
                            <i class="fa fa-shopping-cart"></i>
                            <a href="">More Details</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection

@section('js_script')


    <script type="text/javascript">

        $(document).ready(function () {





        });

    </script>
@endsection
