(function ($) {
    "use strict";
    let base_url = AppHelpers.base_url;

    $(document).on('change', '.category-status', function () {
        const category_id = $(this).data('id');
        axios.put(`${base_url}/update-category-status/${category_id}`)
            .catch(error => {
                // Display an error message if the request fails
                const errorMessage = error.response?.data?.message || 'An error occurred. Please try again.';
                AppHelpers.showAlert("error", "Error", errorMessage);
            });
    });
})(jQuery);
