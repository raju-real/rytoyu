@extends('admin.layouts.app')
@section('title', 'Change Order Status')
@push('css')
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4><i class="bx bx-transfer"></i> Change Order Status</h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.order-summary', $order->unique_id) }}" class="btn btn-soft-info btn-sm"
                        {!! tooltip('View Order Details') !!}>
                        <i class="bx bx-receipt"></i> Order Details
                    </a>
                    <a href="{{ route('admin.manage-orders') }}" class="btn btn-soft-primary btn-sm">
                        <i class="bx bx-arrow-back"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Order Products Status Control --}}
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between py-2">
                    <span class="card-title"><i class="bx bx-cart"></i> Order Products</span>
                    <div class="d-flex gap-2">
                        @if (!$order->order_products->whereIn('order_status', ['canceled', 'delivered', 'returned'])->count())
                            <a href="{{ route('admin.update-order-status-all', ['unique_id' => $order->unique_id, 'order_status' => 'processing']) }}"
                                class="btn btn-soft-info btn-sm" {!! tooltip('Mark all as Processing') !!}>
                                <i class="bx bx-loader"></i> Process All
                            </a>
                            <a href="{{ route('admin.update-order-status-all', ['unique_id' => $order->unique_id, 'order_status' => 'shipped']) }}"
                                class="btn btn-soft-success btn-sm" {!! tooltip('Mark all as Shipped') !!}>
                                <i class="bx bx-package"></i> Ship All
                            </a>
                            <a href="{{ route('admin.update-order-status-all', ['unique_id' => $order->unique_id, 'order_status' => 'canceled']) }}"
                                class="btn btn-soft-danger btn-sm"
                                onclick="return confirm('Cancel all products in this order?')" {!! tooltip('Cancel all products') !!}>
                                <i class="bx bx-x"></i> Cancel All
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="overflow-x:auto !important;">
                        <table class="table table-bordered table-striped mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:50px;">#</th>
                                    <th>Seller</th>
                                    <th class="text-center" style="width:70px;">Image</th>
                                    <th>Product</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($order->order_products as $order_product)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            <strong>{{ $order_product->seller->shop->shop_name ?? '' }}</strong>
                                            <br><small
                                                class="text-muted">{{ $order_product->seller->shop->mobile ?? ($order_product->seller->mobile ?? '') }}</small>
                                        </td>
                                        <td class="text-center">
                                            @if (
                                                $order_product->product &&
                                                    $order_product->product->thumbnail_path &&
                                                    file_exists($order_product->product->thumbnail_path))
                                                <img src="{{ asset($order_product->product->thumbnail_path) }}"
                                                    style="width:46px;height:46px;object-fit:cover;border-radius:6px;">
                                            @else
                                                <img src="{{ asset('assets/common/images/ecommerce.png') }}"
                                                    style="width:46px;height:46px;object-fit:cover;border-radius:6px;">
                                            @endif
                                        </td>
                                        <td>
                                            {{ $order_product->product->name ?? '' }}
                                            <br><small class="text-muted">SKU:
                                                {{ $order_product->product->product_code ?? '' }} | Size:
                                                {{ $order_product->size ?? 'N/A' }} | Color:
                                                {{ $order_product->color ?? 'N/A' }}</small>
                                        </td>
                                        <td class="text-center">৳
                                            {{ numberFormat($order_product->item_total_order_price, 2) }}</td>
                                        <td class="text-center">
                                            @php $st = strtolower($order_product->order_status ?? ''); @endphp
                                            <span
                                                class="badge
                                                @if ($st == 'pending') bg-warning
                                                @elseif($st == 'processing') bg-info
                                                @elseif($st == 'shipped') bg-primary
                                                @elseif($st == 'delivered') bg-success
                                                @elseif($st == 'canceled') bg-danger
                                                @else bg-secondary @endif">
                                                {{ ucFirst($st) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if ($order_product->order_status == 'pending')
                                                <a href="{{ route('admin.update-order-status', ['id' => $order_product->id, 'order_status' => 'processing']) }}"
                                                    class="btn btn-soft-info btn-sm mb-1" {!! tooltip('Mark as Processing') !!}>
                                                    <i class="bx bx-loader"></i> Process
                                                </a>
                                                <a href="{{ route('admin.update-order-status', ['id' => $order_product->id, 'order_status' => 'canceled']) }}"
                                                    class="btn btn-soft-danger btn-sm"
                                                    onclick="return confirm('Cancel this item?')" {!! tooltip('Cancel this item') !!}>
                                                    <i class="bx bx-x"></i> Cancel
                                                </a>
                                            @elseif($order_product->order_status == 'processing')
                                                <a href="{{ route('admin.update-order-status', ['id' => $order_product->id, 'order_status' => 'shipped']) }}"
                                                    class="btn btn-soft-primary btn-sm" {!! tooltip('Mark as Shipped') !!}>
                                                    <i class="bx bx-package"></i> Ship
                                                </a>
                                            @elseif($order_product->order_status == 'shipped')
                                                <a href="{{ route('admin.update-order-status', ['id' => $order_product->id, 'order_status' => 'delivered']) }}"
                                                    class="btn btn-soft-success btn-sm mb-1" {!! tooltip('Mark as Delivered') !!}>
                                                    <i class="bx bx-check"></i> Deliver
                                                </a>
                                                <a href="{{ route('admin.update-order-status', ['id' => $order_product->id, 'order_status' => 'returned']) }}"
                                                    class="btn btn-soft-warning btn-sm"
                                                    onclick="return confirm('Mark as returned?')" {!! tooltip('Mark as Returned') !!}>
                                                    <i class="bx bx-undo"></i> Return
                                                </a>
                                            @else
                                                <span class="text-muted"
                                                    style="font-size:12px;">{{ ucFirst($order_product->order_status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7"><x-no-data-found /></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Courier Settings Card --}}
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <span class="card-title"><i class="bx bx-package"></i> Courier / Delivery Settings</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.update-courier', $order->unique_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Courier Name {!! starSign() !!}</label>
                                <select name="courier_name" class="form-select">
                                    <option value="">-- Select Courier --</option>
                                    @foreach (['Steadfast', 'Pathao', 'RedX', 'Paperfly', 'eCourier', 'Sundarban', 'SA Paribahan', 'Continental', 'Other'] as $courier)
                                        <option value="{{ $courier }}"
                                            {{ $order->courier_name == $courier ? 'selected' : '' }}>
                                            {{ $courier }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tracking ID</label>
                                <input type="text" name="courier_tracking_id" class="form-control"
                                    value="{{ $order->courier_tracking_id }}" placeholder="e.g. BD123456789">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Courier Status</label>
                                <select name="courier_status" class="form-select">
                                    <option value="">-- Select Status --</option>
                                    @foreach (['Pending', 'Picked Up', 'In Transit', 'Out for Delivery', 'Delivered', 'Returned'] as $cs)
                                        <option value="{{ $cs }}"
                                            {{ $order->courier_status == $cs ? 'selected' : '' }}>
                                            {{ $cs }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mt-3 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save"></i> Save Courier Info
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
