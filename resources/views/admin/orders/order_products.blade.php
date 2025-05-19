<table class="table table-striped table-bordered mb-0">
    <thead>
        <tr class="text-nowrap">
            <th>Sl.no</th>
            <th>Seller</th>
            <th>Product</th>
            <th>Variant</th>
            <th>Item Price</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($order->order_products as $order_product)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>
                    {{ $order_product->seller->shop->shop_name ?? '' }}
                    <br>
                    <strong>
                        {{ $order_product->seller->shop->mobile ?? $order_product->seller->mobile ?? $order_product->seller->shop->phone ?? '' }}
                    </strong>
                </td>
                <td>
                    {{ $order_product->product->name ?? '' }}
                    <br>
                    <strong>
                        SKU: {{ $order_product->product->product_code ?? '' }}
                    </strong>
                </td>
                <td class="text-nowrap">
                    <span>Size: {{ $order_product->size ?? 'N/A' }}</span> <br>
                    <span>Color: {{ $order_product->color ?? 'N/A' }}</span>
                </td>
                <td>{{ numberFormat($order_product->item_order_price, 2) }}</td>
                <td class="text-center">{{ $order_product->quantity ?? 0 }}</td>
                <td>{{ numberFormat($order_product->item_total_order_price, 2) }}</td>
                <td>{{ ucFirst($order_product->order_status) }}</td>
            </tr>
        @empty
            <x-no-data-found></x-no-data-found>
        @endforelse
    </tbody>
</table>
