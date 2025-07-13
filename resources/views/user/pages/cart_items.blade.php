@if(count($cart_items['items']))
    @foreach($cart_items['items'] as $item)
        <div class="media">
            <a class="pull-left" href="#">
                <img class="media-object item-image"
                     src="{{ asset($item['product_thumbnail']) }}"
                     alt="">
            </a>
            <p class="pull-right item-price">TK: {{ numberFormat($item['order_price']) ?? 0 }}</p>
            <div class="media-body">
                <h4 class="media-heading item-title"><a href="#">{{ $item['quantity'] ?? 0 }}
                        x {{ $item['product_name'] ?? '' }}</a></h4>
                {{--            <p class="item-desc">Lorem ipsum dolor</p>--}}
            </div>
        </div>
    @endforeach

    <div class="media">
        <p class="pull-right item-price" id="subtotal">{{ numberFormat($cart_items['item_total']) ?? 0 }}</p>
        <div class="media-body">
            <h4 class="media-heading item-title summary">Subtotal</h4>
        </div>
    </div>

    <div class="media">
        <div class="media-body">
            <div>
                <a href="#" class="btn btn-theme bg-red" data-dismiss="modal">Close</a>
                <a href="{{ route('checkout') }}"
                   class="btn btn-theme btn-theme-transparent btn-call-checkout chek-orange">Checkout</a>
            </div>
            <!-- hopping-cart.html -->
        </div>
    </div>
@else
    <div class="alert alert-danger p-2">No item found!</div>
@endif
