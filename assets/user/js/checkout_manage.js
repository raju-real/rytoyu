(function ($) {
    "use strict";
    let base_url = AppHelpers.base_url;

    loadMiniCartItem();
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


    // Trigger for add to cart button
    $(document).on('click', '.add-t-c-2', addToCart);

    function addToCart(event) {
        event.preventDefault(); // prevent default form submission if inside a form

        const button = $(event.currentTarget);
        const productId = button.data('product-id');
        const colorId = $('.color-radio:checked').val() || null;
        const sizeId = $('.size-radio:checked').val() || null;
        const quantity = $('.qty').val() || 1;

        axios.post(base_url + '/add-to-cart', {
            product_id: productId,
            color_id: colorId,
            size_id: sizeId,
            quantity: quantity
        }).then(function (response) {
            if (response.data.status === 'success') {
                alert(response.data.message); // Or use toast/notification
                loadMiniCartItem();
            } else {
                alert(response.data.message);
            }
        }).catch(function (error) {
            console.error(error);
            alert('Something went wrong!');
        });
    }

    function loadMiniCartItem() {
        axios.get(base_url + '/load-cart-items').then((response) => {
            const total = Number(response.data.item_summary.item_total || 0);
            $('#cart-item-total').text(total.toLocaleString());
            $('#mini-cart-item').empty().html(response.data.html);
        });
    }


    // Only checkout page activity
    if (AppHelpers.current_page === 'checkout') {
        reloadCartTable();
        toggleDeleteButton();
        reloadPriceSummery();

        // Delete button enable and disabled
        function toggleDeleteButton() {
            const anyChecked = $('.select-all-item:checked').length > 0;
            if (anyChecked) {
                $('#delete-selected').removeClass('disabled').css({'pointer-events': 'auto', 'opacity': '1'});
            } else {
                $('#delete-selected').addClass('disabled').css({'pointer-events': 'none', 'opacity': '0.6'});
            }
        }

        // Select All
        $(document).on('change', '#select-all', function () {
            const isChecked = $(this).is(':checked');
            $('.select-all-item').prop('checked', isChecked);
            toggleDeleteButton();
        });
        // Single checkbox selection
        $(document).on('change', '.select-all-item', function () {
            const allChecked = $('.select-all-item').length === $('.select-all-item:checked').length;
            $('#select-all').prop('checked', allChecked);
            toggleDeleteButton();
        });
        // Delete selected items
        $(document).on('click', '#delete-selected', function () {
            if ($(this).hasClass('disabled')) return;

            const selectedIds = [];
            $('.select-all-item:checked').each(function () {
                selectedIds.push($(this).data('id'));
            });

            if (selectedIds.length === 0) return;

            if (!confirm('Are you sure you want to delete selected items?')) return;

            $.ajax({
                url: base_url + '/remove-item-from-cart',
                method: 'DELETE',
                data: {
                    ids: selectedIds,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    loadMiniCartItem();
                    reloadCartTable();
                    reloadPriceSummery();
                },
                error: function (error) {
                    console.log(error);
                    alert('Something went wrong!');
                }
            });
        });

        $(document).on('click', '.update-quantity', function () {
            const itemKey = $(this).data('id');
            const action = $(this).data('action');

            // Send request to update the cart item quantity
            axios.post(base_url + '/update-cart-quantity', {
                item_key: itemKey,
                action: action
            })
                .then(response => {
                    loadMiniCartItem();
                    reloadCartTable();
                    reloadPriceSummery();
                })
                .catch(error => {
                    console.error(error);
                });
        });

        // Remove single item (Cross icon)
        $(document).on('click', '.remove-item', function () {
            const id = $(this).data('id');

            if (!confirm('Are you sure you want to remove this item?')) return;

            $.ajax({
                url: base_url + '/remove-item-from-cart',
                method: 'DELETE',
                data: {
                    ids: [id], // send as array
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    loadMiniCartItem();
                    reloadCartTable();
                    reloadPriceSummery();
                    toggleDeleteButton();
                },
                error: function (error) {
                    console.log(error);
                    alert('Something went wrong!');
                }
            });
        });

        // Reload Cart Table Function
        function reloadCartTable() {
            axios.get(base_url + '/checkout-products')
                .then(response => {
                    $('#cart-items-tbody').html(response.data.html);
                })
                .catch(error => {
                    console.error(error);
                    alert('Failed to reload cart data.');
                });
        }

        function reloadPriceSummery() {
            axios.get(base_url + '/load-price-summery')
                .then(response => {
                    $('#checkout-summery').html(response.data.html);
                })
                .catch(error => {
                    console.error(error);
                    alert('Failed to reload price summery data data.');
                });
        }

        $(document).on('click', '#order-submit', function (event) {
            event.preventDefault();

            const submitButton = $(this);
            const buttonText = " Please wait...";

            // Disable button and show loading state
            submitButton
                .addClass('disabled')
                .css({'pointer-events': 'none', 'opacity': '0.6'})
                .html(buttonText);

            const form = $('#order-form')[0];
            const formData = new FormData(form);

            const selectedPayment = $('#accordion .panel-collapse.in').prev().find('a').data('value') || 'cash-on-delivery';
            ;
            formData.append('payment_method', selectedPayment); // If using FormData

            axios.post(base_url + '/submit-order', formData)
                .then(function (response) {
                    if (response.data.status === 'success') {
                        const message = encodeURIComponent(response.data.message);
                        window.location.href = base_url + '/order-list?message=' + message;
                    }
                })
                .catch(function (error) {
                    if (error.response && error.response.status === 422) {
                        // Handle validation errors
                        console.log(error.response.data.errors);
                    }
                    // Re-enable button on error
                    submitButton
                        .removeClass('disabled')
                        .css({'pointer-events': '', 'opacity': ''})
                        .html('Submit Order');
                });
        });

    }
})(jQuery);
