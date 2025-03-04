(function ($) {
    "use strict";
    let base_url = AppHelpers.base_url;

    $(document).on('change', '.product-status', function () {
        const product_id = $(this).data('id');
        axios.put(`${base_url}/update-product-status/${product_id}`)
            .catch(error => {
                // Display an error message if the request fails
                const errorMessage = error.response?.data?.message || 'An error occurred. Please try again.';
                AppHelpers.showAlert("error", "Error", errorMessage);
            });
    });

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

    const subCategorySelector = $('#subcategory');
    const subSubCategorySelector = $('#sub_subcategory');

    const category_id = $('#category').val();
    if (category_id) {
        appendSubCategory(category_id);
    }

    const subcategory_id = subCategorySelector.val();
    if (subcategory_id) {
        appendSubSubCategory(subcategory_id);
    }

    $(document).on('change', '#category', function () {
        const category_id = $(this).val();
        if (category_id) {
            appendSubCategory(category_id);
        } else {
            subCategorySelector.empty().append('<option value="">Select Subcategory</option>');
            subSubCategorySelector.empty().append('<option value="">Select Sub Subcategory</option>');
        }
    });

    $(document).on('change', '#subcategory', function () {
        const subcategory_id = $(this).val();
        if (subcategory_id) {
            appendSubSubCategory(subcategory_id);
        } else {
            subSubCategorySelector.empty().append('<option value="">Select Sub Subcategory</option>');
        }
    });

    function appendSubCategory(category_id) {
        subCategorySelector.empty().append('<option value="">Select Subcategory</option>');
        $.ajax({
            url: base_url + "/api/category-wise-subcategories/" + category_id,
            success: function (response) {
                const appendValueKey = response.append_value || 'id';
                $.each(response.subcategories, function (i, subcategory) {
                    const optionValue = appendValueKey === 'id' ? subcategory.id : subcategory.slug;
                    const option = $('<option>', {
                        value: optionValue,
                        text: subcategory.name
                    });

                    const oldSelectedValue = subCategorySelector.data('old-value');
                    if (oldSelectedValue !== undefined && oldSelectedValue !== null && oldSelectedValue === subcategory.id) {
                        option.attr('selected', 'selected');
                    }

                    subCategorySelector.append(option);
                });
            }
        });
    }

    function appendSubSubCategory(subcategory_id) {
        subSubCategorySelector.empty().append('<option value="">Select Sub Subcategory</option>');
        $.ajax({
            url: base_url + "/api/subcategory-wise-sub-subcategories/" + subcategory_id,
            success: function (response) {
                const appendValueKey = response.append_value || 'id';
                $.each(response.sub_subcategories, function (i, subcategory) {
                    const optionValue = appendValueKey === 'id' ? subcategory.id : subcategory.slug;
                    const option = $('<option>', {
                        value: optionValue,
                        text: subcategory.name
                    });

                    const oldSelectedValue = subSubCategorySelector.data('old-value');
                    if (oldSelectedValue !== undefined && oldSelectedValue !== null && oldSelectedValue === subcategory.id) {
                        option.attr('selected', 'selected');
                    }

                    subSubCategorySelector.append(option);
                });
            }
        });
    }

})(jQuery);
