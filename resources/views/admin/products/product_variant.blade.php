<tr>
    <td>
        <select name="sizes[]" id="size" class="form-control product_sizes select2">
            <option value="">Select Size</option>
            @foreach (allSizes() as $size)
                <option value="{{ $size->id }}">{{ $size->name ?? '' }}</option>
            @endforeach
        </select>
    </td>
    <td>
        <select name="colors[]" id="color" class="form-control select2 product_colors">
            <option value="">Select Color</option>
            @foreach (allColors() as $color)
                <option value="{{ $color->name }}">{{ $color->name ?? '' }}</option>
            @endforeach
        </select>
    </td>
    <td>
        <input type="number" name="unit_price[]" value="" class="form-control product_unit_price"
            placeholder="Unit Price">
    </td>
    <td>
        <input type="number" name="discount_price[]" value="" class="form-control product_discount_price"
            placeholder="Discount Price">
    </td>
    <td class="w-10 pull-right">
        <button type="button" class="btn btn-md btn-danger text-right remove_image">
            <i class="fa fa-trash"></i>
        </button>
    </td>
</tr>
