@extends('user.layouts.app')
@section('title', 'Checkout')
@push('css')
    <style>
        a.disabled {
            pointer-events: none;
            opacity: 0.6;
        }
    </style>
@endpush

@section('content')
    <!-- BREADCRUMBS -->
    <section class="page-section breadcrumbs">
        <div class="container">
            <div class="page-header">
                <h1>Checkout</h1>
            </div>
            <ul class="breadcrumb">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('home') }}">Shop</a></li>
                <li class="active">Shopping Cart</li>
            </ul>
        </div>
    </section>
    <!-- /BREADCRUMBS -->
    <!-- PAGE -->
    <section class="page-section color">
        <div class="container">
            <h3 class="block-title alt item-row">
                <label class="che-lab">
                    <input type="checkbox" id="select-all"> Select All ({{ count($cart_items['items']) }} item(s))
                </label>
                <label class="de-item">
                    <a href="javascript:void(0);" id="delete-selected" class="disabled">
                        <i class="fas fa-trash-alt"></i> Delete
                    </a>
                </label>
            </h3>

            <section class="sec-shopping">
                <div class="row orders">
                    <div class="col-md-8">
                        <table class="table table-custom">
                            <thead>
                                <tr>
                                    <th class="text-center"></th>
                                    <th>Image</th>
                                    <th>Quantity</th>
                                    <th>Product Name</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody id="cart-items-tbody">

                            </tbody>

                        </table>
                    </div>
                    <div class="col-md-4">
                        <h3 class="block-title"><span>Shopping cart</span></h3>
                        <div class="shopping-cart" id="checkout-summery">

                        </div>
                    </div>
                </div>
            </section>


            <section class="sec-shopping add-b">
                <h3 class="block-title alt"><label class="icon-all"><i class="fas fa-map-marker-alt"></i></label>2.
                    Delivery address</h3>
                <form action="{{ route('submit-order') }}" class="form-delivery" id="order-form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input name="first_name" id="first_name" class="form-control" type="text"
                                    placeholder="First Name" value="{{ $user->first_name ?? '' }}">
                                <span id="order_first_name_error"
                                    class="text-danger font-weight-500 order-error-message"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input name="last_name" id="last_name" class="form-control" type="text"
                                    placeholder="Last Name" value="{{ $user->last_name ?? '' }}">
                                <span id="order_last_name_error"
                                    class="text-danger font-weight-500 order-error-message"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <input name="email" id="email" class="form-control" type="text" placeholder="Email"
                                    value="{{ $user->email ?? '' }}">
                                <span id="order_email_error" class="text-danger font-weight-500 order-error-message"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input name="mobile" id="mobile" class="form-control" type="text"
                                    placeholder="Phone Number" value="{{ $user->mobile ?? '' }}">
                            </div>
                            <span id="order_mobile_error" class="text-danger font-weight-500 order-error-message"></span>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group selectpicker-wrapper">
                                <select id="district" name="district" class="form-control sel-bg">
                                    @foreach (deliveryDistricts() as $district)
                                        <option value="{{ $district->slug }}"
                                            {{ $user->district_id == $district->id ? 'selected' : '' }}>
                                            {{ $district->district_name ?? '' }}</option>
                                    @endforeach
                                </select>
                                <span id="order_district_error"
                                    class="text-danger font-weight-500 order-error-message"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <input name="city" id="city" class="form-control" type="text" placeholder="City"
                                    value="{{ $user->city ?? '' }}">
                                <span id="order_city_error" class="text-danger font-weight-500 order-error-message"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input name="zip_code" id="zip_code" class="form-control" type="text"
                                    placeholder="Postcode/ZIP" value="{{ $user->zip_code ?? '' }}">
                                <span id="order_zip_code_error"
                                    class="text-danger font-weight-500 order-error-message"></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <input name="address" id="address" class="form-control" type="text"
                                    placeholder="Address" value="{{ $user->delivery_address ?? '' }}">
                                <span id="order_address_error"
                                    class="text-danger font-weight-500 order-error-message"></span>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea name="additional_information" id="additional_information" class="form-control"
                                    placeholder="Addıtıonal Informatıon" cols="30" rows="4"></textarea>
                            </div>
                            <span id="order_additional_information_error"
                                class="text-danger font-weight-500 order-error-message"></span>
                        </div>

                    </div>
                </form>
            </section>


            <section class="sec-shopping add-b">
                <h3 class="block-title alt"><label class="icon-all"><i class="fas fa-money-check"></i></label>3.
                    Payments options</h3>
                <div class="panel-group payments-options" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse2"
                                    aria-expanded="false" aria-controls="collapse2" data-value="cash-on-delivery">
                                    <span class="dot"></span> Cash on Delivery
                                </a>
                            </h4>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2">
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse3"
                                    aria-expanded="false" aria-controls="collapse3" data-value="online-payment">
                                    <span class="dot"></span> Online Payment
                                </a>
                                <span class="overflowed pull-right">
                                    <img src="{{ asset('assets/user/img/preview/payments/mastercard-2.jpg') }}"
                                        alt="" />
                                    <img src="{{ asset('assets/user/img/preview/payments/visa-2.jpg') }}"
                                        alt="" />
                                    <img src="{{ asset('assets/user/img/preview/payments/american-express-2.jpg') }}"
                                        alt="" />
                                    <img src="{{ asset('assets/user/img/preview/payments/discovery-2.jpg') }}"
                                        alt="" />
                                    <img src="{{ asset('assets/user/img/preview/payments/eheck-2.jpg') }}"
                                        alt="" />
                                </span>
                            </h4>
                        </div>
                        <div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3">
                        </div>
                    </div>
                </div>
                <span id="order_payment_method_error" class="text-danger font-weight-500 order-error-message"></span>
            </section>

            <div class="clearfix"></div>
            <div class="overflowed">
                <a class="btn btn-theme pull-right orange-bg place-btn" href="javascript:void(0)"
                    id="order-submit">Submit
                    Order</a>
            </div>
        </div>
    </section>
    <!-- /PAGE -->
@endsection

@push('js')
@endpush
