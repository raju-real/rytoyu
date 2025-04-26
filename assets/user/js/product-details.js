(function ($) {
    "use strict";
    let base_url = AppHelpers.base_url;

    updateVariantName();

    $(document).on('change', '.color-radio, .size-radio', function () {
        updateVariantName();

        const productId = $('#product-id').val();
        const colorId = $('.color-radio:checked').val() || null;
        const sizeId = $('.size-radio:checked').val() || null;

        getProductVariantInfo(productId, colorId, sizeId);
    });

    function updateVariantName() {
        // Get selected color name from title
        const selectedColorName = $('.color-radio:checked')
            .siblings('label')
            .find('span')
            .attr('title') || '—';

        // Get selected size name from label text
        const selectedSizeName = $('.size-radio:checked')
            .siblings('label')
            .text()
            .trim() || '—';

        // Update DOM with selected color and size names
        $('h4.color-list span').text(selectedColorName);
        $('h4.margin-size span').text(selectedSizeName);
    }

    function getProductVariantInfo(product_id, color_id, size_id) {
        axios.get(base_url + '/api/product-variant-info', {
            params: {
                product_id,
                color_id,
                size_id
            }
        })
            .then(function (response) {
                const variant = response.data;
                if (variant) {
                    $('#product-price-sec').show();
                    // Update availability
                    $('#stock-status').text(variant.stock_status ?? 'N/A');
                    $('#inventory').text(variant.inventory ?? '0');
                    // Update price
                    if (variant.discount_price > 0) {
                        $('#unit-price').text(variant.discount_price ?? 0);
                        $('#discount-price').html('<del>' + variant.unit_price + '</del>').show();
                    } else {
                        $('#unit-price').text(variant.unit_price ?? 0);
                        $('#discount-price').hide();
                    }
                    // Enable quantity & Add to Cart
                    $('.quantity button, .quantity input').prop('disabled', false);
                    $('.add-t-c-2').prop('disabled', false).html('<i class="fa fa-shopping-cart"></i> Add to cart');

                } else {
                    $('#product-price-sec').hide();
                    $('#stock-status').text('Out of Stock');
                    $('#inventory').text('0');
                    $('#unit-price').text(0);
                    $('#discount-price').hide();
                    // Disable quantity & Add to Cart
                    $('.quantity button, .quantity input').prop('disabled', true);
                    $('.add-t-c-2').prop('disabled', true).html('<i class="fa fa-ban"></i> No Variant Found!');
                }
            })
            .catch(function (error) {
                console.error("Error fetching variant info:", error);
            });
    }

    $(document).on('click', '.qty-btn', function (e) {
        e.preventDefault();

        var $button = $(this);
        var $input = $button.closest('.quantity').find('.qty');
        var oldValue = parseInt($input.val()) || 1;
        var type = $button.data('type');

        if (type === 'minus') {
            if (oldValue > 1) {
                $input.val(oldValue - 1);
            }
        } else if (type === 'plus') {
            $input.val(oldValue + 1);
        }
    });


})(jQuery);
