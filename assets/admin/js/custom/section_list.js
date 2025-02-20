(function ($) {
    "use strict";
    let base_url = AppHelpers.base_url;

    $(".sort_section").sortable({
        handle: '.handle',
        placeholder: 'highlight',
        axis: "y",
        update: function (e, ui) {
            let sortData = $(".sort_section").sortable('toArray', {attribute: 'data-id'});
            axios.post(base_url + '/sort-section', {
                ids: sortData.join(',')
            });
            // Dynamically update sorting_serial in the table (want to show)
            $(".sort_section tr").each(function (index) {
                $(this).find('.sorting-serial').text(index + 1); // Update sorting_serial column
            });
        }
    });

    $(document).on('change', '.section-status', function () {
        const section_id = $(this).data('id');
        axios.put(`${base_url}/update-section-status/${section_id}`)
            .catch(error => {
                // Display an error message if the request fails
                const errorMessage = error.response?.data?.message || 'An error occurred. Please try again.';
                AppHelpers.showAlert("error", "Error", errorMessage);
            });
    });

})(jQuery);
