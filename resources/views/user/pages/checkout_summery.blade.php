<table>
    <tr>
        <td>Sub-total:</td>
        <td>TK:{{ numberFormat($cart_items['item_total']) ?? 0 }}</td>
    </tr>
    <tr>
        <td>Shipping:</td>
        <td>TK:{{ shippingFee() }}</td>
    </tr>
    <tfoot>
    <tr>
        <td>Total:</td>
        <td>TK:{{ $cart_items['total_price'] ?? 0 }}</td>
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
