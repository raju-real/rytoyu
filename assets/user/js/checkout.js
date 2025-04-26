(function ($) {
    "use strict";
    let base_url = AppHelpers.base_url;

    $(document).on('click', '#order-submit', function (event) {
        event.preventDefault();

        const submitButton = $(this);
        // const spinTag = "<i class='fa fa-spinner fa-spin me-2 spinner'></i>"; // You commented it earlier
        const text = " Please wait...";
        const buttonText = text;

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
