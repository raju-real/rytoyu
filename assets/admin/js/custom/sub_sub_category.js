(function ($) {
    "use strict";
    let base_url = AppHelpers.base_url;
    const methodMode = $("#method_mode").val();

    let bannerImageIndex = 0;
    if (methodMode == "PUT") {
        bannerImageIndex = $("#total_banner_images").val();
    }
    const subCategorySelector = $('#subcategory');

    const category_id = $('#category').val();
    if (category_id) {
        appendSubCategory(category_id);
    }

    $(document).on('change', '#category', function () {
        const category_id = $(this).val();
        if (category_id) {
            appendSubCategory(category_id);
        } else {
            subCategorySelector.empty().append('<option value="">Select Subcategory</option>');
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

    $(document).on('change', '.sub-subcategory-status', function () {
        const sub_subcategory_id = $(this).data('id');
        axios.put(`${base_url}/update-sub-subcategory-status/${sub_subcategory_id}`)
            .catch(error => {
                // Display an error message if the request fails
                const errorMessage = error.response?.data?.message || 'An error occurred. Please try again.';
                AppHelpers.showAlert("error", "Error", errorMessage);
            });
    });

    $(".sort_section").sortable({
        handle: '.handle',
        placeholder: 'highlight',
        axis: "y",
        update: function () {
            const sortData = $(this).sortable('toArray', {attribute: 'data-id'});
            const category_id = $(this).find("tr").data("category-id");
            const subcategory_id = $(this).find("tr").data("subcategory-id");
            // Send sorted data to the server
            axios.post(`${base_url}/sort-sub-subcategories`, {
                category: category_id,
                subcategory: subcategory_id,
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

    $(document).on("click", "#add_image", function () {
        let newRow = `<tr data-index="${bannerImageIndex}">
            <td>
                <input type="hidden" name="banner_images[${bannerImageIndex}][index_no]" value="${bannerImageIndex}">
                <input type="hidden" name="banner_images[${bannerImageIndex}][is_new]" value="1">
                <input type="file"  name="banner_images[${bannerImageIndex}][image]" id="banner_image_${bannerImageIndex}"  class="form-control" accept=".jpg,.jpeg,.png">
                <small class="text-danger font-weight-500 banner-image-error-message" id="banner_image_${bannerImageIndex}_error"></small>
            </td>
            <td class="float-end">
                <button type="button" class="btn btn-md btn-danger text-right remove_image">
                <i class="fa fa-trash"></i>
            </button>
            </td>
        </tr>`;

        $(newRow).appendTo("#banner_image_table tbody");
        bannerImageIndex++;
    });

    $(document).on("click", ".remove_image", function () {
        let event = this;
        $(event).parent().parent().remove();
    });

})(jQuery);
