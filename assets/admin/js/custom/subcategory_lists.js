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

    $(".sort_section").sortable({
        handle: '.handle',
        placeholder: 'highlight',
        axis: "y",
        update: function () {
            const sortData = $(this).sortable('toArray', {attribute: 'data-id'}); // Retrieve sorted IDs
            const category_id = $(this).find("tr").data("category-id"); // Get category ID from .sort_section
            // Send sorted data to the server
            axios.post(`${base_url}/sort-subcategories`, {
                category: category_id,
                ids: sortData
            }).then(() => {
                // Update UI with the new sorting serial numbers
                $(this).find('tr').each((index, row) => {
                    $(row).find('.sorting-serial').text(index + 1); // Update the serial number
                });
                console.log('Sorting updated successfully');
            }).catch(error => {
                console.error('Error while updating sorting:', error);
            });
        }
    });

})(jQuery);
