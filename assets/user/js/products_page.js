(function ($) {
    "use strict";
    let base_url = AppHelpers.base_url;

    const $productSearch = $('#products-search');
    const urlParams = new URLSearchParams(window.location.search);
    const searchValue = urlParams.get('search_on');

    if (searchValue) {
        $productSearch.val(searchValue);
    }

    $productSearch.on('keypress', function (e) {
        if (e.which === 13) { // Enter key
            e.preventDefault();
            const value = $(this).val().trim();
            const url = new URL(window.location.href);
            const params = new URLSearchParams(url.search);
            if (value) {
                params.set('search_on', value);
            } else {
                params.delete('search_on');
            }
            window.location.href = url.pathname + '?' + params.toString();
        }
    });


    $(document).on("change", ".price-filter", function () {
        const url = new URL(window.location.href);
        const params = new URLSearchParams(url.search);
        // Mimic radio behavior: uncheck others
        $('.price-filter').not(this).prop('checked', false);
        if ($(this).is(':checked')) {
            // Set or update amount_max
            params.set('amount_max', $(this).val());
        } else {
            // If unchecked, remove the param
            params.delete('amount_max');
        }
        // Redirect to the updated URL
        window.location.href = url.pathname + '?' + params.toString();
    });

    $(document).on('keypress', '.range-filter', function (e) {
        if (e.which === 13) { // Enter key
            e.preventDefault();
            const minVal = $('#amount_min').val().trim();
            const maxVal = $('#amount_max').val().trim();

            const url = new URL(window.location.href);
            const params = new URLSearchParams(url.search);

            if (minVal) {
                params.set('amount_min', minVal);
            } else {
                params.delete('amount_min');
            }

            if (maxVal) {
                params.set('amount_max', maxVal);
            } else {
                params.delete('amount_max');
            }

            window.location.href = url.pathname + '?' + params.toString();
        }
    });

    $(document).on('change', '.category-filter', function () {
        // Uncheck the other box so only one is ever selected
        $('.category-filter').not(this).prop('checked', false);
        // If this one is now checked, redirect
        if ($(this).is(':checked')) {
            const cat = $(this).data('category');
            // Build a clean URL with only the category param
            const mainUrl = window.location.origin + window.location.pathname;
            window.location.href = `${mainUrl}?category=${encodeURIComponent(cat)}`;
        } else {
            // If they uncheck it, just go to the mainUrl URL (no category)
            window.location.href = window.location.origin + window.location.pathname;
        }
    });


})
(jQuery);
