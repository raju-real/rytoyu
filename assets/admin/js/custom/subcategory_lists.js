(function ($) {
    "use strict";
    let base_url = AppHelpers.base_url;

    $(document).on('change', '.subcategory-status', function () {
        const subcategory_id = $(this).data('id');
        axios.put(`${base_url}/update-subcategory-status/${subcategory_id}`)
            .catch(error => {
                const errorMessage = error.response?.data?.message || 'An error occurred. Please try again.';
                AppHelpers.showAlert("error", "Error", errorMessage);
            });
    });
})(jQuery);
