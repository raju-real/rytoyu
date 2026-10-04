@extends('user.layouts.app')
@section('title', $order->invoice ?? ($order->order_no ?? ''))
@push('css')
@endpush

@section('content')
    <section class="page-section">
        <div class="wrap container">
            <div class="row">
                <!--start sidebar-->
                <div class="col-lg-3 col-md-3 col-sm-4">
                    <div class="widget account-details">
                        <h2 class="widget-title">Account</h2>
                        @include('user.account.menus')
                    </div>
                </div>
                <!--end sidebar-->
                <!--start main contain of page-->
                <div class="col-lg-9 col-md-9 col-sm-8">
                    <div class="information-title">Order #{{ $order->invoice ?? ($order->order_no ?? '') }}</div>

                    <div class="order-status-area">
                        @if (Session::has('message'))
                            <p class="alert alert-info">{{ Session::get('message') }}</p>
                        @endif
                        <!-- order-status-area-inner -->
                        <div class="order-status-area-inner">
                            <!-- Ship To -->
                            <div class="order-row">
                                <h4>Ship To</h4>
                                <p>
                                    {{ $order->city_town ?? '' }} {{ $order->post_code ?? '' }}
                                    , {{ $order->district->district_name ?? '' }}
                                    <br>
                                    {{ $order->address ?? '' }}
                                </p>
                            </div>
                            <!-- Order Date -->
                            <div class="order-row">
                                <h4>Order Date</h4>
                                <p>{{ dateFormat($order->created_at, 'd, M y') }}</p>
                            </div>
                            <!-- Order Status -->
                            <br>
                            {{--                            <h4 class="order-activities">Order Status</h4> --}}
                            {{--                            <ul id="progressbar"> --}}
                            {{--                                <li class="done_item"> --}}
                            {{--                                    <div class="oder-status-list"> --}}
                            {{--                                        <h3>Order Confirmed</h3> --}}
                            {{--                                        <span>Congratulations! You've matched with a seller.</span> --}}
                            {{--                                    </div> --}}
                            {{--                                </li> --}}
                            {{--                                <li class="done_item"> --}}
                            {{--                                    <div class="oder-status-list"> --}}
                            {{--                                        <h3>Seller preparing shipment</h3> --}}
                            {{--                                        <span>The seller has received their shipment label and is preparing item for shipment.</span> --}}
                            {{--                                    </div> --}}
                            {{--                                </li> --}}
                            {{--                                <li class="done_item"> --}}
                            {{--                                    <div class="oder-status-list"> --}}
                            {{--                                        <h3>Order On It's Way to StockX</h3> --}}
                            {{--                                        <span>One step closer! Your order is heading to one of our verification centers for verification!.</span> --}}
                            {{--                                    </div> --}}
                            {{--                                </li> --}}
                            {{--                                <li class=""> --}}
                            {{--                                    <div class="oder-status-list"> --}}
                            {{--                                        <h3>Order Received at StockX for Verification</h3> --}}
                            {{--                                        <span>A tracking link has been generated and available for you to view. </span> --}}
                            {{--                                    </div> --}}
                            {{--                                </li> --}}
                            {{--                                <li class=""> --}}
                            {{--                                    <div class="oder-status-list"> --}}
                            {{--                                        <h3>Order Delivered!</h3> --}}
                            {{--                                        <span>Enjoy! Don't forget to use #GotltOnStockX when sharing unboxing pics.</span> --}}
                            {{--                                    </div> --}}
                            {{--                                </li> --}}
                            {{--                            </ul> --}}
                            <!-- Price Details -->
                            <h5 class="price-h5">Price Details</h5>
                            <div class="price-row">
                                <h4>Purchase Price</h4>
                                <p>{{ numberFormat($order->total_item_order_price) ?? 0 }} BDT</p>
                            </div>
                            <div class="price-row">
                                <h4>Shipping</h4>
                                <p>(+) {{ numberFormat($order->shipping_fee) ?? 0 }} BDT</p>
                            </div>
                            <div class="price-row">
                                <h4>Coupon Discount</h4>
                                <p>(-) {{ numberFormat($order->coupon_discount_amount) ?? 0 }} BDT</p>
                            </div>
                            <div class="price-row">
                                <h4>Service charge + vat</h4>
                                <p>
                                    (+)
                                    {{ $order->service_charge . ' + ' . $order->total_vat . ' = ' . $order->service_charge + $order->total_vat }}
                                    BDT</p>
                            </div>
                            <div class="price-row total-row">
                                <h4>Total</h4>
                                <p>{{ numberFormat($order->total_order_price) ?? 0 }} BDT</p>
                            </div>
                            <h4 class="order-activities marg-20"><strong>Payment Method</strong></h4>
                            <p class="payment-met-status">{{ paymentMethodName($order->payment_method) }}</p>
                        </div>
                        <h5 class="price-h5">Item Details</h5>
                        <div class="row orders">
                            <div class="col-md-12">
                                @foreach ($order->order_products as $item)
                                    <table class="table table-custom table-order">
                                        <thead>
                                            <tr>
                                                <th colspan="3">
                                                    <div class="brn-span"><i
                                                            class="fas fa-laptop-house"></i>{{ $item->product->seller->shop->shop_name ?? (siteSettings()['company_name'] ?? '') }}
                                                    </div>
                                                </th>
                                                <th>
                                                    <span class="span-s">{{ $item->order_status ?? '' }}</span>
                                                </th>
                                                @if ($item->order_status === 'delivered')
                                                    <th>
                                                        <a
                                                            href="{{ route('submit-review', $item->order_id . '-' . $item->id . '-' . $item->seller_id) }}">Review</a>
                                                    </th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="image">
                                                    <a class="media-link"
                                                        href="{{ route('product-details', $item->product->slug) }}"><i
                                                            class="fa fa-plus"></i><img
                                                            src="{{ asset($item->product->thumbnail_path) }}"
                                                            height="80" width="100" alt="" />
                                                    </a>
                                                </td>

                                                <td class="description">
                                                    <h4>
                                                        <a
                                                            href="{{ route('product-details', $item->product->slug) }}">{{ $item->product->name ?? '' }}</a>
                                                    </h4>
                                                    by {{ $item->product->category->name ?? '' }}
                                                    {{ $item->size ? ', Size: ' . $item->size : 'N/A' }} and
                                                    {{ $item->color ? ' Color: ' . $item->color : 'N/A' }}

                                                    @if ($item->order_status === 'delivered')
                                                        @php
                                                            $existingRefund = \App\Models\RefundRequest::where(
                                                                'order_product_id',
                                                                $item->id,
                                                            )->first();
                                                        @endphp
                                                        <div class="mt-2">
                                                            @if ($existingRefund)
                                                                <span class="badge badge-warning">Refund
                                                                    {{ ucfirst($existingRefund->status) }}</span>
                                                            @else
                                                                <button type="button" class="btn btn-sm btn-danger mt-1"
                                                                    data-toggle="modal"
                                                                    data-target="#refundModal{{ $item->id }}"
                                                                    style="padding: 2px 10px; font-size: 12px; background: #dc3545; color: #fff; border:none; border-radius:3px;">Request
                                                                    Refund</button>

                                                                <!-- Refund Modal -->
                                                                <div class="modal fade" id="refundModal{{ $item->id }}"
                                                                    tabindex="-1" role="dialog" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <form
                                                                            action="{{ route('request-refund', $item->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">Request Refund
                                                                                    </h5>
                                                                                    <button type="button" class="close"
                                                                                        data-dismiss="modal"
                                                                                        aria-label="Close">
                                                                                        <span
                                                                                            aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="form-group">
                                                                                        <label>Reason for Refund</label>
                                                                                        <textarea name="reason" class="form-control" rows="4" required
                                                                                            placeholder="Please describe why you are requesting a refund for this item..."></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-dismiss="modal">Cancel</button>
                                                                                    <button type="submit"
                                                                                        class="btn btn-danger">Submit
                                                                                        Request</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="description">
                                                    <span><strong>TK:</strong></span>{{ numberFormat($item->item_order_price, 2) }}
                                                </td>
                                                <td class="description">
                                                    <span><strong>Qty:</strong></span>{{ $item->quantity ?? 0 }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
                <!--end main contain of page-->
            </div>
        </div>
    </section>
@endsection

@push('js')
@endpush
