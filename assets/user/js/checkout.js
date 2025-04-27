(function ($) {
    "use strict";
    let base_url = AppHelpers.base_url;

    reloadCartTable();
    toggleDeleteButton();

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
                reloadCartTable();
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
                // Update the table with new data
                reloadCartTable(); // Reload the cart with the updated data
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
                reloadCartTable(); // reload the tbody
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
                // Update cart items section
                $('#cart-items-tbody').html(response.data.cart_item_view);
                // Update checkout summary section
                $('#checkout-summery').html(response.data.summery_view);
                loadCartItems();
            })
            .catch(error => {
                console.error(error);
                alert('Failed to reload cart data.');
            });
    }

    // Itms duplicating on common js fix it.. by making a common js file for cart and checkout
    function loadCartItems() {
        axios.get(base_url + '/load-cart-items').then((response) => {
            const total = Number(response.data.item_summary.item_total || 0);
            $('#cart-item-total').text(total.toLocaleString());
            $('#mini-cart-item').empty().html(response.data.cart_view);
        });
    }


    $(document).on('click', '#order-submit', function (event) {
        event.preventDefault();

        const submitButton = $(this);
        // const spinTag = "<i class='fa fa-spinner fa-spin me-2 spinner'></i>"; // You commented it earlier
        const buttonText = " Please wait...";

        submitButton
            .addClass('disabled')      // Add a disabled class
            .css({'pointer-events': 'none', 'opacity': '0.6'}) // Prevent click and change look
            .html(buttonText);

        const form = $('#order-form');
        const formData = new FormData(form[0]);

        $.ajax({
            url: base_url + '/submit-order',
            method: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                // you can redirect or show success
            },
            error: function (error) {
                if (error.status === 422) {
                    // handle validation errors
                }
                // Re-enable button on error
                submitButton
                    .removeClass('disabled')
                    .css({'pointer-events': '', 'opacity': ''})
                    .html('Submit Order');
            }
        });
    });

})(jQuery);
