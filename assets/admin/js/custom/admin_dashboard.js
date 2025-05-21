(function ($) {
    "use strict";
    let base_url = AppHelpers.base_url;

    function loadLatestOrders() {
        const search = $('')
    }

    $(document).on('click', '.show-order-products', function () {
        $('#data-view-modal-dialog').addClass('modal-fullscreen');
        $('#data-view-modal').modal('show');
        const tbody = $('#data-view-modal-body'); // Target the tbody element
        const unique_id = $(this).data('id');
        // Clear existing content and set a loading row
        tbody.html('<tr><td colspan="5">Loading...</td></tr>');
        // Make an Axios request
        axios.get(`${base_url}/order-infos/${unique_id}`)
            .then(response => {
                if (response.data) {
                    $('.data-view-modal-header').empty().text(response.data.title);
                    tbody.empty(); // Clear tbody content
                    tbody.html(response.data.html); // Append new data
                } else {
                    tbody.html('<p class="alert alert-danger">No Data Found!.</p>');
                }
            })
            .catch(error => {
                tbody.html('<p class="alert alert-danger">Error loading products. Please try again.</p>');
                console.error(error);
            });
    });

})(jQuery);
