@extends('admin.layouts.app')
@section('title', 'Change Order Status')
@push('css')
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Change Order Status</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.seller-orders') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-arrow-circle-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                    <span>Order Products</span>
                    <div class="btn-group btn-group-sm">
                        @if (!$order->order_products->whereIn('order_status', ['canceled', 'returned'])->count())
                            @if(!$order->order_products->whereIn('order_status', ['shipped','canceled','delivered','returned'])->count() && $order->order_products->where('order_status','!=','processing')->isNotEmpty())
                                <a href="{{ route('admin.seller-update-order-status-all', ['unique_id' => $order->unique_id, 'order_status' => 'processing']) }}"
                                   class="btn btn-info">
                                    Process All
                                </a>
                            @endif
                            @if(!$order->order_products->whereIn('order_status', ['canceled','delivered','returned'])->count() && $order->order_products->where('order_status','!=','shipped')->isNotEmpty())
                                <a href="{{ route('admin.seller-update-order-status-all', ['unique_id' => $order->unique_id, 'order_status' => 'shipped']) }}"
                                   class="btn btn-success">
                                    Shipped All
                                </a>
                            @endif
                            @if(!$order->order_products->whereIn('order_status', ['processing','shipped','delivered','returned'])->count() && $order->order_products->where('order_status','!=','canceled')->isNotEmpty())
                                <a href="{{ route('admin.seller-update-order-status-all', ['unique_id' => $order->unique_id, 'order_status' => 'canceled']) }}"
                                   class="btn btn-danger">
                                    Cancel All
                                </a>
                            @endif
                            @if(!$order->order_products->whereIn('order_status', ['canceled','returned'])->count() && $order->order_products->where('order_status','!=','delivered')->isNotEmpty())
                                <a href="{{ route('admin.seller-update-order-status-all', ['unique_id' => $order->unique_id, 'order_status' => 'delivered']) }}"
                                   class="btn btn-primary">
                                    Deliver All
                                </a>
                            @endif
                        @endif

                    </div>
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
                                <th class="text-center">Total Price</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
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
                                        <strong>
                                            <span>SKU: {{ $order_product->product->product_code ?? '' }}</span>,
                                            <span>Size: {{ $order_product->size ?? 'N/A' }}</span>,
                                            <span>Color: {{ $order_product->color ?? 'N/A' }}</span>
                                        </strong>
                                    </td>
                                    <td class="text-center">
                                        {{ numberFormat($order_product->item_total_order_price, 2) }}</td>
                                    <td class="text-center">
                                        {{ ucfirst($order_product->order_status) }}
                                    </td>
                                    <td class="text-center">
                                        @if ($order_product->order_status == 'pending')
                                            <a href="{{ route('admin.seller-update-order-status', ['id' => encrypt_decrypt($order_product->id, 'encrypt'), 'order_status' => 'processing']) }}"
                                               class="text-primary">
                                                Process Order
                                            </a>
                                            <a href="{{ route('admin.seller-update-order-status', ['id' => encrypt_decrypt($order_product->id, 'encrypt'), 'order_status' => 'canceled']) }}"
                                               class="text-danger"
                                               onclick="return confirm('Are you sure you want to mark this order as canceled?');">
                                                Cancel Order
                                            </a>
                                        @elseif ($order_product->order_status == 'processing')
                                            <a href="{{ route('admin.seller-update-order-status', ['id' => encrypt_decrypt($order_product->id, 'encrypt'), 'order_status' => 'shipped']) }}"
                                               class="text-primary">
                                                Ship Order
                                            </a>
                                        @elseif ($order_product->order_status == 'shipped')
                                            <a href="{{ route('admin.seller-update-order-status', ['id' => encrypt_decrypt($order_product->id, 'encrypt'), 'order_status' => 'delivered']) }}"
                                               class="text-primary">
                                                Deliver Order
                                            </a>
                                            <a href="{{ route('admin.seller-update-order-status', ['id' => encrypt_decrypt($order_product->id, 'encrypt'), 'order_status' => 'returned']) }}"
                                               class="text-danger"
                                               onclick="return confirm('Are you sure you want to mark this order as returned?');">
                                                Return Order
                                            </a>
                                        @else
                                            <span
                                                class="text-info font-weight-500">Order Product {{ ucfirst($order_product->order_status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <x-no-data-found/>
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
