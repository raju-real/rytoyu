(function ($) {
    "use strict";
    let base_url = AppHelpers.base_url;

    $(document).on('change', '.seller-status', function () {
        const seller_id = $(this).data('id');
        axios.put(`${base_url}/update-seller-status/${seller_id}`)
            .catch(error => {
                // Display an error message if the request fails
                const errorMessage = error.response?.data?.message || 'An error occurred. Please try again.';
                AppHelpers.showAlert("error", "Error", errorMessage);
            });
    });

     $(document).on('change', '.request-status', function () {
        const seller_id = $(this).data('id');
        axios.put(`${base_url}/update-seller-request-status/${seller_id}`)
            .catch(error => {
                // Display an error message if the request fails
                const errorMessage = error.response?.data?.message || 'An error occurred. Please try again.';
                AppHelpers.showAlert("error", "Error", errorMessage);
            });
    });
})(jQuery);
