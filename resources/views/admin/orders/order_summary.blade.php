@extends('admin.layouts.app')
@section('title', 'Order Details')
@push('css')
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4><i class="bx bx-receipt"></i> Order Details</h4>
                <div>
                    <a href="{{ route('admin.manage-orders') }}" class="btn btn-soft-primary btn-sm">
                        <i class="bx bx-arrow-back"></i> Back to Orders
                    </a>
                    <a href="{{ route('admin.order-invoice', $order->unique_id) }}" target="_blank"
                        class="btn btn-soft-info btn-sm" {!! tooltip('Download Invoice') !!}>
                        <i class="bx bx-download"></i> Invoice
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Row 1: Order Info + Customer Info ── --}}
    <div class="row mb-3">
        <div class="col-md-6 mb-3 mb-md-0">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <span class="card-title text-white"><i class="bx bx-info-circle text-white"></i> Order
                        Information</span>
                </div>
                <div class="card-body p-0">
                    <table class="info-table">
                        <tbody>
                            <tr>
                                <th>Order Date</th>
                                <td>{{ dateFormat($order->created_at, 'd M, Y') }}</td>
                            </tr>
                            <tr>
                                <th>Order Number</th>
                                <td><strong>#{{ $order->order_number }}</strong></td>
                            </tr>
                            <tr>
                                <th>Invoice</th>
                                <td>
                                    <a href="{{ route('admin.order-invoice', $order->unique_id) }}" target="_blank">
                                        {{ $order->invoice }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>Payment Method</th>
                                <td>{{ ucFirst($order->payment_method_name) }}</td>
                            </tr>
                            <tr>
                                <th>Payment Status</th>
                                <td>
                                    @php $ps = strtolower($order->payment_status ?? 'pending'); @endphp
                                    <span class="status-badge status-{{ $ps === 'paid' ? 'delivered' : 'pending' }}">
                                        {{ ucFirst($ps) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Transaction ID</th>
                                <td>{{ $order->transaction->transaction_id ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Card Type</th>
                                <td>{{ $order->transaction->card_type ?? 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-secondary text-white">
                    <span class="card-title text-white"><i class="bx bx-user text-white"></i> Customer Information</span>
                </div>
                <div class="card-body p-0">
                    <table class="info-table">
                        <tbody>
                            <tr>
                                <th>Full Name</th>
                                <td>{{ $order->customer_full_name }}</td>
                            </tr>
                            <tr>
                                <th>Mobile</th>
                                <td>{{ $order->mobile }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $order->email }}</td>
                            </tr>
                            <tr>
                                <th>District</th>
                                <td>{{ $order->district->district_name ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>City / Town</th>
                                <td>{{ $order->city_town }}</td>
                            </tr>
                            <tr>
                                <th>Post Code</th>
                                <td>{{ $order->post_code }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $order->address }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Row 2: Price Info + Courier Info ── --}}
    <div class="row mb-3">
        <div class="col-md-6 mb-3 mb-md-0">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <span class="card-title text-white"><i class="bx bx-money text-white"></i> Price Information</span>
                </div>
                <div class="card-body p-0">
                    <table class="info-table">
                        <tbody>
                            <tr>
                                <th>Item's Price</th>
                                <td>৳ {{ numberFormat($order->total_item_unit_price) }}</td>
                            </tr>
                            <tr>
                                <th>Item's Discount</th>
                                <td class="text-danger">- ৳ {{ numberFormat($order->total_item_discount) }}</td>
                            </tr>
                            <tr>
                                <th>Item Order Price</th>
                                <td>৳ {{ numberFormat($order->total_item_order_price) }}</td>
                            </tr>
                            <tr>
                                <th>Shipping Fee</th>
                                <td>৳ {{ numberFormat($order->shipping_fee) }}</td>
                            </tr>
                            <tr>
                                <th>Coupon ({{ $order->coupon_code ?? 'N/A' }})</th>
                                <td class="text-danger">- ৳ {{ numberFormat($order->coupon_discount_amount) }}</td>
                            </tr>
                            <tr>
                                <th>Service + VAT</th>
                                <td>৳ {{ $order->service_charge + $order->total_vat }}</td>
                            </tr>
                            <tr>
                                <th><strong>Total Order Price</strong></th>
                                <td><strong class="text-success" style="font-size:1.05rem;">৳
                                        {{ numberFormat($order->total_order_price) }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-secondary text-white">
                    <span class="card-title text-white"><i class="bx bx-package text-white"></i> Courier / Delivery</span>
                </div>
                <div class="card-body p-0">
                    @if ($order->courier_name || $order->courier_tracking_id)
                        <table class="info-table">
                            <tbody>
                                <tr>
                                    <th>Courier</th>
                                    <td>
                                        <span class="courier-badge courier-{{ strtolower($order->courier_name ?? '') }}">
                                            <i class="bx bx-car"></i> {{ $order->courier_name ?? 'N/A' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tracking ID</th>
                                    <td><code>{{ $order->courier_tracking_id ?? 'N/A' }}</code></td>
                                </tr>
                                <tr>
                                    <th>Courier Status</th>
                                    <td>
                                        @php $cs = strtolower($order->courier_status ?? 'pending'); @endphp
                                        <span
                                            class="status-badge status-{{ in_array($cs, ['delivered']) ? 'delivered' : (in_array($cs, ['cancelled']) ? 'cancelled' : 'processing') }}">
                                            {{ ucFirst($order->courier_status ?? 'Pending') }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="bx bx-package" style="font-size:2.5rem;opacity:.3;"></i>
                            <p class="mt-2 mb-0">No courier assigned yet.</p>
                            <a href="{{ route('admin.change-order-status', $order->unique_id) }}"
                                class="btn btn-sm btn-soft-primary mt-3">
                                <i class="bx bx-edit"></i> Update Order & Assign Courier
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ── Commission Logs ── --}}
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <span class="card-title text-white"><i class="bx bx-percentage text-white"></i> Commission Logs</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Seller</th>
                                    <th class="text-center">Order Amount</th>
                                    <th class="text-center">Commission Rate</th>
                                    <th class="text-center">Commission</th>
                                    <th class="text-center">Seller Amount</th>
                                    <th class="text-center">Pay To</th>
                                    <th class="text-center">Payment Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($order->seller_order_logs as $log)
                                    <tr>
                                        <td>{{ $log->seller->shop->shop_name ?? '' }}</td>
                                        <td class="text-center">৳ {{ numberFormat($log->order_amount, 2) }}</td>
                                        <td class="text-center">{{ $log->commission_rate ?? 0 }} %</td>
                                        <td class="text-center">৳ {{ numberFormat($log->total_commission ?? 0, 2) }}</td>
                                        <td class="text-center">৳ {{ numberFormat($log->seller_amount ?? 0, 2) }}</td>
                                        <td class="text-center">{{ ucFirst($log->pay_to ?? '') }}</td>
                                        <td class="text-center">
                                            @php $ps2 = strtolower($log->payment_status ?? 'pending'); @endphp
                                            <span
                                                class="status-badge status-{{ $ps2 === 'paid' ? 'delivered' : 'pending' }}">
                                                {{ ucFirst($ps2) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-3 text-muted">No commission logs found.
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

    {{-- ── Order Products ── --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <span class="card-title text-white"><i class="bx bx-cart text-white"></i> Order Products</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="overflow-x:auto !important;">
                        <table class="table table-bordered table-striped w-100 mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:50px;">#</th>
                                    <th>Seller</th>
                                    <th class="text-center" style="width:70px;">Image</th>
                                    <th>Product</th>
                                    <th>Variant</th>
                                    <th class="text-center">Price × Qty</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($order->order_products as $order_product)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            <strong>{{ $order_product->seller->shop->shop_name ?? '' }}</strong><br>
                                            <small
                                                class="text-muted">{{ $order_product->seller->shop->mobile ?? ($order_product->seller->mobile ?? '') }}</small>
                                        </td>
                                        <td class="text-center">
                                            @if (
                                                $order_product->product &&
                                                    $order_product->product->thumbnail_path &&
                                                    file_exists($order_product->product->thumbnail_path))
                                                <img src="{{ asset($order_product->product->thumbnail_path) }}"
                                                    alt="{{ $order_product->product->name }}" class="rounded"
                                                    style="width:46px;height:46px;object-fit:cover;">
                                            @else
                                                <img src="{{ asset('assets/common/images/ecommerce.png') }}"
                                                    class="rounded" style="width:46px;height:46px;object-fit:cover;">
                                            @endif
                                        </td>
                                        <td>
                                            {{ $order_product->product->name ?? '' }}<br>
                                            <small class="text-muted">SKU:
                                                {{ $order_product->product->product_code ?? '' }}</small>
                                        </td>
                                        <td>
                                            <small>Size: <strong>{{ $order_product->size ?? 'N/A' }}</strong></small><br>
                                            <small>Color: <strong>{{ $order_product->color ?? 'N/A' }}</strong></small>
                                        </td>
                                        <td class="text-center">
                                            ৳{{ numberFormat($order_product->item_order_price, 2) }}
                                            × {{ $order_product->quantity }}
                                        </td>
                                        <td class="text-center">
                                            <strong>৳{{ numberFormat($order_product->item_total_order_price, 2) }}</strong>
                                        </td>
                                        <td class="text-center">
                                            @php $st = strtolower($order_product->order_status ?? 'pending'); @endphp
                                            <span
                                                class="status-badge status-{{ $st }}">{{ ucFirst($st) }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8"><x-no-data-found /></td>
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
