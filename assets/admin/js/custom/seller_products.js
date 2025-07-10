(function ($) {
    "use strict";
    let base_url = AppHelpers.base_url;

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
