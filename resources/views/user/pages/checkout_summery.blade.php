<table>
    <tr>
        <td>Sub-total:</td>
        <td>TK:{{ numberFormat($price_summery['total_item_price']) ?? 0 }}</td>
    </tr>
    @if(!empty($price_summery['applied_coupon']))
    <tr>
        <td>Applied Coupon:</td>
        <td>{{ $price_summery['applied_coupon']  }}</td>
    </tr>
    <tr>
        <td>Coupon Discount:</td>
        <td>TK:{{ numberFormat($price_summery['coupon_discount']) ?? 0 }} (-)</td>
    </tr>
    @endif
    <tr>
        <td>Shipping:</td>
        <td>TK:{{ numberFormat($price_summery['shipping_fee']) ?? 0 }} (+)</td>
    </tr>
    <tfoot>
    <tr>
        <td>Total:</td>
        <td>TK:{{ $price_summery['total_order_price'] ?? 0 }}</td>
    </tr>
    </tfoot>

</table>

<div class="form-group">
    <textarea class="form-control" name="order_note" placeholder="Send a Message"></textarea>
</div>
<div class="form-group">
    <input class="form-control" type="text" placeholder="Enter your coupon code"/>
</div>
<button class="btn btn-theme btn-theme-dark btn-block orange-bg apl-c">Apply Coupon
</button>
