(function ($) {
    "use strict";
    let base_url = AppHelpers.base_url;

    $(document).on('click', '.view-product-variants', function () {
        const tbody = $('#product-variants-container'); // Target the tbody element
        const product_id = $(this).data('id');
        // Clear existing content and set a loading row
        tbody.html('<tr><td colspan="5">Loading...</td></tr>');
        // Make an Axios request
        axios.get(`${base_url}/get-product-variants/${product_id}`)
            .then(response => {
                if (response.data.success) {
                    $('.product-modal-header').empty().text(response.data.product_name);
                    $('#category_name').empty().text(response.data.category_name);
                    $('#subcategory_name').empty().text(response.data.subcategory_name);
                    $('#sub_subcategory_name').empty().text(response.data.sub_subcategory_name);
                    const variants = response.data.variants;

                    // Clear tbody content
                    tbody.empty();

                    // Append rows dynamically
                    if (variants.length > 0) {
                        variants.forEach(variant => {
                            tbody.append(`
                            <tr>
                                <td>${variant.size_name ?? 'N/A'}</td>
                                <td>${variant.color_name ?? '0'}</td>
                                <td>${variant.unit_price ?? '0'}</td>
                                <td>${variant.discount_price ?? '0'}</td>
                                <td>${variant.inventory ?? '0'}</td>
                            </tr>
                        `);
                        });
                    } else {
                        tbody.append('<tr><td colspan="5"><p class="alert alert-danger">No variants available for this product.</p></td></tr>');
                    }
                } else {
                    tbody.html('<tr><td colspan="5"><p class="alert alert-danger">No variants available for this product.</p></td></tr>');
                }
            })
            .catch(error => {
                tbody.html('<tr><td colspan="5"><p class="alert alert-danger">Error loading variants. Please try again.</p></td></tr>');
                console.error(error);
            });
    });

    

})(jQuery);
