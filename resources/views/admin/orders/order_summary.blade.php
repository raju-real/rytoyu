@extends('admin.layouts.app')
@section('title', 'Order Details')
@push('css')
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Order Details</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.manage-orders') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-arrow-circle-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    Order Info
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0">
                        <tbody>
                            <tr>
                                <th class="w-25">Order Date</th>
                                <td>{{ dateFormat($order->created_at,'d M, Y') ?? '' }}</td>
                                <th class="w-25">Order Number</th>
                                <td>{{ $order->order_number ?? '' }}</td>
                            </tr>
                            <tr>
                                <th class="w-25">Invoice</th>
                                <td>
                                    <a target="_blank" href="{{ route('admin.order-invoice', $order->unique_id) }}">{{ $order->invoice ?? '' }}</a>
                                </td>
                                <th class="w-25">Payment Method</th>
                                <td>{{ ucFirst($order->payment_method_name) ?? '' }}</td>
                            </tr>
                            <tr>
                                <th class="w-25">Payment Status</th>
                                <td>{{ ucFirst($order->payment_status) ?? '' }}</td>
                                <th class="w-25">Transaction ID</th>
                                <td>{{ $order->transaction->transaction_id ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="w-25">Card Type</th>
                                <td>{{ $order->transaction->card_type ?? 'N/A' }}</td>
                                <th class="w-25">Card Brand</th>
                                <td>{{ $order->transaction->card_brand ?? 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    Customer Information
                </div>
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-md-6"></div>
                    </div>
                    <table class="table table-bordered mb-0">
                        <tbody>
                            <tr>
                                <th class="w-25">Name</th>
                                <td>{{ $order->customer_full_name ?? '' }}</td>
                                <th class="w-25">Mobile</th>
                                <td>{{ $order->mobile ?? '' }}</td>
                            </tr>
                            <tr>
                                <th class="w-25">Email</th>
                                <td>{{ $order->email ?? '' }}</td>
                                <th class="w-25">District</th>
                                <td>{{ $order->district->district_name ?? '' }}</td>
                            </tr>
                            <tr>
                                <th class="w-25">City/Town</th>
                                <td>{{ $order->city_town ?? '' }}</td>
                                <th class="w-25">Post Code</th>
                                <td>{{ $order->post_code ?? '' }}</td>
                            </tr>
                            <tr>
                                <th class="w-25">Address</th>
                                <td colspan="3">{{ $order->address ?? '' }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    Price Info
                </div>
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-md-6"></div>
                    </div>
                    <table class="table table-bordered mb-0">
                        <tbody>
                            <tr>
                                <th style="width: 150px;">Item's Price</th>
                                <td>{{ numberFormat($order->total_item_unit_price) ?? 0 }}</td>
                                <th style="width: 150px;">Item's Discount</th>
                                <td>{{ numberFormat($order->total_item_discount) ?? 0 }}</td>
                            </tr>
                            <tr>
                                <th style="width: 150px;">Item's Order Price</th>
                                <td>{{ numberFormat($order->total_item_order_price) ?? 0 }}</td>
                                <th style="width: 150px;">Shipping Fee</th>
                                <td>{{ numberFormat($order->shipping_fee) ?? 0 }}</td>
                            </tr>
                            <tr>
                                <th style="width: 150px;">Coupon Code</th>
                                <td>{{ $order->coupon_code ?? '' }}</td>
                                <th style="width: 150px;">Coupon Discount</th>
                                <td>{{ numberFormat($order->coupon_discount_amount) ?? 0 }}</td>
                            </tr>
                            <tr>
                                <th style="width: 150px;">Service + Vat</th>
                                <td>
                                    {{ $order->service_charge . ' + ' . $order->total_vat . ' = ' . $order->service_charge + $order->total_vat }}
                                </td>
                                <th style="width: 150px;">Order Price</th>
                                <td class="bg-success text-white">{{ numberFormat($order->total_order_price) ?? 0 }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    Commission Logs
                </div>
                <div class="card-body p-0">
                    <div class="">
                        <table class="table table-striped table-bordered table-md mb-0 text-nowrap text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Seller</th>
                                    <th>Order Amount</th>
                                    <th>C Rate</th>
                                    <th>Commission</th>
                                    <th>Seller Amount</th>
                                    <th>Pay To</th>
                                    <th>Payment Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->seller_order_logs as $index => $log)
                                    <tr>
                                        <td>
                                            <a>
                                                {{ $log->seller->shop->shop_name ?? '' }}
                                            </a>
                                        </td>
                                        {{-- Financial Info --}}
                                        <td>{{ numberFormat($log->order_amount, 2) }}</td>
                                        <td>{{ $log->commission_rate ?? 0 }} %</td>
                                        <td>{{ numberFormat($log->total_commission ?? 0, 2) }}</td>
                                        <td>{{ numberFormat($log->seller_amount ?? 0, 2) }}</td>
                                        <td>{{ ucFirst($log->pay_to ?? '') }}</td>
                                        <td>{{ ucFirst($log->payment_status ?? '') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    Order Products
                </div>
                <div class="card-body p-0">
                    <div class="">
                        <table class="table table-striped table-bordered mb-0">
                            <thead>
                                <tr class="text-nowrap">
                                    <th class="text-center">Sl.no</th>
                                    <th>Seller</th>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Variant</th>
                                    <th class="text-center">Price X Quantity</th>
                                    <th class="text-center">Total Price</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($order->order_products as $order_product)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $order_product->seller->shop->shop_name ?? '' }}<br>
                                            <strong>
                                                {{ $order_product->seller->shop->mobile ?? ($order_product->seller->mobile ?? ($order_product->seller->shop->phone ?? '')) }}
                                            </strong>
                                        </td>
                                        <td>
                                            @if ($order_product->product->thumbnail_path && file_exists($order_product->product->thumbnail_path))
                                                <img src="{{ asset($order_product->product->thumbnail_path) }}"
                                                    class="avatar-sm rounded-3 d-block">
                                            @else
                                                <img src="{{ asset('assets/common/images/ecommerce.png') }}"
                                                    class="avatar-sm rounded-3 d-block">
                                            @endif
                                        </td>
                                        <td>
                                            {{ $order_product->product->name ?? '' }}<br>
                                            <strong>SKU: {{ $order_product->product->product_code ?? '' }}</strong>
                                        </td>
                                        <td class="text-nowrap">
                                            <span>Size: {{ $order_product->size ?? 'N/A' }}</span><br>
                                            <span>Color: {{ $order_product->color ?? 'N/A' }}</span>
                                        </td>
                                        <td class="text-center">
                                            {{ numberFormat($order_product->item_order_price, 2) }} X
                                            {{ $order_product->quantity ?? 0 }}
                                        </td>
                                        <td class="text-center">
                                            {{ numberFormat($order_product->item_total_order_price, 2) }}</td>
                                        <td class="text-center">{{ ucfirst($order_product->order_status) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">
                                            <x-no-data-found />
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
@endpush
