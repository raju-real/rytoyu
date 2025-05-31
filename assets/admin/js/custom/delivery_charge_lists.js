(function ($) {
    "use strict";
    let base_url = AppHelpers.base_url;

    $(document).on('change', '.charge-status', function () {
        const charge_id = $(this).data('id');
        axios.put(`${base_url}/update-delivery-charge-status/${charge_id}`)
            .catch(error => {
                const errorMessage = error.response?.data?.message || 'An error occurred. Please try again.';
                AppHelpers.showAlert("error", "Error", errorMessage);
            });
    });

})(jQuery);
