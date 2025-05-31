<!-- Customer Info Card -->
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
                            <td>{{ ucFirst($order->district) ?? '' }}</td>
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
                Order Info
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
                                {{ $order->service_charge.' + '.$order->total_vat .' = '.$order->service_charge + $order->total_vat }}
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
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Additional Note
            </div>
            <div class="card-body p-1">
                {{ $order->additional_information ?? 'N/A' }}
            </div>
        </div>
    </div>
</div>

<!-- Order Products Card -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                Order Products
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
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
