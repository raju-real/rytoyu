@foreach($cart_items['items'] as $item)
    <tr>
        <td class="text-center vert-m">
            <input class="select-all-item" type="checkbox" data-id="{{ $item['item_key'] }}">
        </td>
        <td class="image">
            <a class="media-link" href="#"><i class="fa fa-plus"></i>
                <img src="{{ asset($item['product_thumbnail']) }}" height="100" width="100" alt=""/>
            </a>
        </td>
        <td class="quantity">
            <button class="btn btn-sm btn-outline-secondary update-quantity" data-id="{{ $item['item_key'] }}" data-action="decrease">-</button>
            x{{ $item['quantity'] }}
            <button class="btn btn-sm btn-outline-secondary update-quantity" data-id="{{ $item['item_key'] }}" data-action="increase">+</button>
        </td>
        <td class="description">
            <h4>
                <a href="{{ route('product-details', $item['product_slug']) }}">{{ $item['product_name'] }}</a>
            </h4>
            by {{ productCategoryNameById($item['product_id']) }}
        </td>
        <td class="total">
            TK:{{ numberFormat($item['order_price']) ?? 0 }}
            <a href="javascript:void(0);" class="remove-item" data-id="{{ $item['item_key'] }}">
                <i class="fa fa-close"></i>
            </a>
        </td>
    </tr>
@endforeach
