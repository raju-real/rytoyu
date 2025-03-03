(function ($) {
    "use strict";
    let base_url = AppHelpers.base_url;
    // $(".select2").select2({
    //     width: "100%", // Ensures the dropdown spans the full width of the container
    // });

    let config = {
        toolbar: [
            [
                "Bold",
                "Italic",
                "Strike",
                "JustifyLeft",
                "JustifyCenter",
                "JustifyRight",
                "NumberedList",
                "BulletedList",
            ],
        ],
    };

    CKEDITOR.config.allowedContent = true;
    CKEDITOR.replace("product_details", config);
    CKEDITOR.replace("product_specification", config);
    CKEDITOR.replace("product_compare", config);

    const methodMode = $("#method_mode").val();
    const subCategorySelector = $("#subcategory");
    const subSubcategorySelector = $("#sub_subcategory");

    const category_id = $("#category").val();
    if (category_id) {
        appendSubCategory(category_id);
    }

    const subcategory_id = subCategorySelector.data("old-value");
    if (subcategory_id) {
        appendSubSubCategory(subcategory_id);
    }

    if (methodMode === "POST") {
        appendProductVariant(); // Initialize the first row on page load
        // Automatically check the first checkbox if there's only one variant
        if ($(".variant-is-default").length === 1) {
            $(".variant-is-default").prop("checked", true);
        }
    }

    $(document).on("change", "#category", function () {
        subCategorySelector
            .empty()
            .append('<option value="">Select Subcategory</option>');
        const category_id = $(this).val();
        appendSubCategory(category_id);
    });

    $(document).on("change", "#subcategory", function () {
        subSubcategorySelector
            .empty()
            .append('<option value="">Select Sub Subcategory</option>');
        const subcategory_id = $(this).val();
        appendSubSubCategory(subcategory_id);
    });

    function appendSubCategory(category_id) {
        $.ajax({
            url: base_url + "/api/category-wise-subcategories/" + category_id,
            success: function (response) {
                const appendValueKey = response.append_value || "id";
                $.each(response.subcategories, function (i, subcategory) {
                    const optionValue =
                        appendValueKey === "id"
                            ? subcategory.id
                            : subcategory.slug;
                    const option = $("<option>", {
                        value: optionValue,
                        text: subcategory.name,
                    });

                    const oldSelectedValue =
                        subCategorySelector.data("old-value");
                    if (
                        oldSelectedValue !== undefined &&
                        oldSelectedValue !== null &&
                        oldSelectedValue === subcategory.id
                    ) {
                        option.attr("selected", "selected");
                    }

                    subCategorySelector.append(option);
                });
            },
        });
    }

    function appendSubSubCategory(subcategory_id) {
        $.ajax({
            url:
                base_url +
                "/api/subcategory-wise-sub-subcategories/" +
                subcategory_id,
            success: function (response) {
                const appendValueKey = response.append_value || "id";
                $.each(
                    response.sub_subcategories,
                    function (i, sub_subcategory) {
                        const optionValue =
                            appendValueKey === "id"
                                ? sub_subcategory.id
                                : sub_subcategory.slug;
                        const option = $("<option>", {
                            value: optionValue,
                            text: sub_subcategory.name,
                        });

                        const oldSelectedValue =
                            subSubcategorySelector.data("old-value");
                        if (
                            oldSelectedValue !== undefined &&
                            oldSelectedValue !== null &&
                            oldSelectedValue === sub_subcategory.id
                        ) {
                            option.attr("selected", "selected");
                        }

                        subSubcategorySelector.append(option);
                    }
                );
            },
        });
    }

    $(document).on("click", ".brand-add-button", function (event) {
        event.preventDefault();
        const formData = new FormData($("#brand-add-form")[0]);

        $.ajax({
            url: base_url + "/brands",
            method: "POST",
            data: formData,
            contentType: false, // Set content type to false for FormData
            processData: false, // Prevent jQuery from processing the data
            dataType: "json",
            success: function (response) {
                $(".brand-form-control").removeClass("border-danger");
                $(".brand-error-message").empty();
                const brandSelector = $("#brand");
                const newBrand = response; // or use response.value if available

                if ($('#brand option[value="' + newBrand + '"]').length === 0) {
                    const option = $("<option>", {
                        value: newBrand.id,
                        text: newBrand.name,
                    });
                    option.attr("selected", "selected");
                    brandSelector.append(option);
                }

                $("#brand-add-form").trigger("reset");
                $("#brand-add-modal").modal("hide");
            },
            error: function (error) {
                if (error.status === 422) {
                    let errors = error.responseJSON.errors;
                    $(".brand-form-control").removeClass("border-danger");
                    $(".brand-error-message").empty();
                    $.each(errors, function (field, messages) {
                        $(".brand-" + field + "-input").addClass(
                            "border-danger"
                        );
                        $("#brand_" + field + "_error")
                            .empty()
                            .text(messages[0]);
                    });
                }
            },
        });
    });

    $(document).on("click", ".unit-add-button", function (event) {
        event.preventDefault();
        $.ajax({
            url: base_url + "/units",
            method: "POST",
            data: $("#unit-add-form").serialize(),
            dataType: "json",
            success: function (response) {
                $(".unit-form-input").removeClass("is-invalid");
                $("#unit_name_error").empty();
                const unitSelector = $("#unit");
                const newUnit = response.data; // or use response.value if available

                if ($('#unit option[value="' + newUnit.id + '"]').length === 0) {
                    const option = $("<option>", {
                        value: newUnit.id,
                        text: newUnit.name,
                    });
                    option.attr("selected", "selected");
                    unitSelector.append(option);
                }

                $("#unit-add-form").trigger("reset");
                $("#unit-add-modal").modal("hide");
            },
            error: function (error) {
                if (error.status === 422) {
                    let errors = error.responseJSON.errors;
                    $(".unit-form-input").removeClass("is-invalid");
                    $.each(errors, function (field, messages) {
                        $(".unit-form-input").addClass("is-invalid");
                        $("#unit_name_error").empty().text(messages[0]);
                    });
                }
            },
        });
    });

    $(document).on("click", ".size-add-button", function (event) {
        event.preventDefault();
        $.ajax({
            url: base_url + "/sizes",
            method: "POST",
            data: $("#size-add-form").serialize(),
            dataType: "json",
            success: function (response) {
                $(".size-form-input").removeClass("is-invalid");
                $("#size_name_error").empty();

                const newSize = response.data; // Assuming the API returns the new size as { id: <size_id>, name: <size_name> }

                // Add the new size to all size selectors
                $(".product_sizes").each(function () {
                    if (
                        $(this).find(`option[value="${newSize.id}"]`).length ===
                        0
                    ) {
                        $(this).append(
                            $("<option>", {
                                value: newSize.id,
                                text: newSize.name,
                            })
                        );
                    }
                });

                // Add the new size to the last added variant's size selector and select it
                const lastSizeSelector = $(
                    "#product-variant-table tbody tr:last .product_sizes"
                );
                if (lastSizeSelector.length > 0) {
                    lastSizeSelector.val(newSize.id).trigger("change");
                }

                $("#size-add-form").trigger("reset");
                $("#size-add-modal").modal("hide");
            },
            error: function (error) {
                if (error.status === 422) {
                    let errors = error.responseJSON.errors;
                    $(".size-form-input").removeClass("is-invalid");
                    $.each(errors, function (field, messages) {
                        $(".size-form-input").addClass("is-invalid");
                        $("#size_name_error").empty().text(messages[0]);
                    });
                }
            },
        });
    });

    $(document).on("click", ".color-add-button", function (event) {
        event.preventDefault();
        $.ajax({
            url: base_url + "/colors", // Adjust the endpoint if necessary
            method: "POST",
            data: $("#color-add-form").serialize(),
            dataType: "json",
            success: function (response) {
                $(".color-form-input").removeClass("is-invalid");
                $("#color_name_error").empty();

                const newColor = response.data; // Assuming the API returns the new color as { id: <color_id>, name: <color_name> }

                // Add the new color to all color selectors
                $(".product_colors").each(function () {
                    if (
                        $(this).find(`option[value="${newColor.id}"]`)
                            .length === 0
                    ) {
                        $(this).append(
                            $("<option>", {
                                value: newColor.id,
                                text: newColor.name,
                            })
                        );
                    }
                });

                // Add the new color to the last added variant's color selector and select it
                const lastColorSelector = $(
                    "#product-variant-table tbody tr:last .product_colors"
                );
                if (lastColorSelector.length > 0) {
                    lastColorSelector.val(newColor.id).trigger("change");
                }

                // Reset the form and close the modal
                $("#color-add-form").trigger("reset");
                $("#color-add-modal").modal("hide");
            },
            error: function (error) {
                if (error.status === 422) {
                    let errors = error.responseJSON.errors;
                    $(".color-form-input").removeClass("is-invalid");
                    $.each(errors, function (field, messages) {
                        $(".color-form-input").addClass("is-invalid");
                        $("#color_name_error").empty().text(messages[0]);
                    });
                }
            },
        });
    });

    $(document).on("change", ".product_sizes, .product_colors", function () {
        $(this).select2({
            width: "100%", // Reapply width after change
        });
    });

    $(document).on("click", ".tag-add-button", function (event) {
        event.preventDefault();
        $.ajax({
            url: base_url + "/tags",
            method: "POST",
            data: $("#tag-add-form").serialize(),
            dataType: "json",
            success: function (response) {
                $(".tag-form-input").removeClass("is-invalid");
                $("#tag_name_error").empty();
                const tagSelector = $("#tag");
                const newTag = response.data; // or use response.value if available

                if ($('#tag option[value="' + newTag + '"]').length === 0) {
                    tagSelector.append(
                        $("<option>", {
                            value: newTag,
                            text: newTag,
                        })
                    );
                }

                tagSelector.val(tagSelector.val().concat(newTag)); // Select the newly added option
                tagSelector.trigger("change");
                $("#tag-add-form").trigger("reset");
                $("#tag-add-modal").modal("hide");
            },
            error: function (error) {
                if (error.status === 422) {
                    let errors = error.responseJSON.errors;
                    $(".tag-form-input").removeClass("is-invalid");
                    $.each(errors, function (field, messages) {
                        $(".tag-form-input").addClass("is-invalid");
                        $("#tag_name_error").empty().text(messages[0]);
                    });
                }
            },
        });
    });

    let productImageIndex = 0;
    if (methodMode == "PUT") {
        productImageIndex = $("#total_images").val();
    }

    $(document).on("click", "#add_image", function () {
        let newRow = `<tr data-index="${productImageIndex}">
            <td>
                <input type="hidden" name="images[${productImageIndex}][index_no]" value="${productImageIndex}">
                <input type="hidden" name="images[${productImageIndex}][is_new]" value="1">
                <input type="file"  name="images[${productImageIndex}][image]" id="product_image_${productImageIndex}"  class="form-control" accept=".jpg,.jpeg,.png">
                <small class="text-danger font-weight-500 product-image-error-message" id="product_image_${productImageIndex}_error"></small>
            </td>
            <td class="float-end">
                <button type="button" class="btn btn-md btn-danger text-right remove_image">
                <i class="fa fa-trash"></i>
            </button>
            </td>
        </tr>`;

        $(newRow).appendTo("#product_image_table tbody");
        productImageIndex++;
    });

    $(document).on("click", ".remove_image", function () {
        let event = this;
        $(event).parent().parent().remove();
    });

    $(document).on("click", "#add-variant", function (event) {
        event.preventDefault();
        appendProductVariant(); // Add more rows on button click
    });

    let variantIndex = 0;
    if (methodMode == "PUT") {
        variantIndex = $("#total_variant").val();
    }

    function appendProductVariant() {
        $.ajax({
            url: base_url + "/get-product-variants-data",
            type: "GET",
            success: function (response) {
                let sizes = response.sizes;
                let colors = response.colors;

                let isFirstRow =
                    $("#product-variant-table tbody tr").length === 0;

                let newRow = `
                    <tr data-index="${variantIndex}">
                        <td>
                            <input type="hidden" name="variants[${variantIndex}][index_no]" value="${variantIndex}">
                            <input type="hidden" name="variants[${variantIndex}][is_new]" value="1">
                            <input type="radio" name="variants[${variantIndex}][is_default]" id="variant_is_default_${variantIndex}" class="variant-is-default" value="1"
                                   class="variant-is-default" ${
                    isFirstRow ? "checked" : ""
                }>
                            <label for="variant_is_default_${variantIndex}"></label>
                            <small class="text-danger variant-error-message" id="variant_is_default_${variantIndex}_error"></small>
                        </td>
                        <td>
                            <select name="variants[${variantIndex}][size]" id="variant_size_${variantIndex}"
                                    class="form-control product_sizes select2">
                                <option value="">Select Size</option>
                                ${sizes
                    .map(
                        (size) =>
                            `<option value="${size.id}">${size.name}</option>`
                    )
                    .join("")}
                            </select>
                            <small class="text-danger variant-error-message" id="variant_size_${variantIndex}_error"></small>
                        </td>
                        <td>
                            <select name="variants[${variantIndex}][color]" id="variant_color_${variantIndex}"
                                    class="form-control select2 product_colors">
                                <option value="">Select Color</option>
                                ${colors
                    .map(
                        (color) =>
                            `<option value="${color.id}">${color.name}</option>`
                    )
                    .join("")}
                            </select>
                            <small class="text-danger variant-error-message" id="variant_color_${variantIndex}_error"></small>
                        </td>
                        <td class="inherit-box">
                            <input type="number" value="0" name="variants[${variantIndex}][unit_price]" id="variant_unit_price_${variantIndex}"
                                   class="form-control product_unit_price" placeholder="Unit Price">
                            <small class="text-danger variant-error-message" id="variant_unit_price_${variantIndex}_error"></small>
                        </td>
                        <td class="inherit-box">
                            <input type="number" value="0" name="variants[${variantIndex}][discount_price]" id="variant_discount_price_${variantIndex}"
                                   class="form-control product_discount_price" placeholder="Discount Price">
                            <small class="text-danger variant-error-message" id="variant_discount_price_${variantIndex}_error"></small>
                        </td>
                        <td class="inherit-box">
                            <input type="number" value="0" name="variants[${variantIndex}][inventory]" id="variant_inventory_${variantIndex}"
                                   class="form-control product_inventory" placeholder="Discount Price">
                            <small class="text-danger variant-error-message" id="variant_inventory_${variantIndex}_error"></small>
                        </td>
                        <td class="w-10 pull-right">
                            <button type="button" class="btn btn-md btn-danger text-right remove_variant">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;

                let $newRow = $(newRow).appendTo(
                    "#product-variant-table tbody"
                );

                $newRow.find(".select2").select2({width: "100%"});

                $newRow.find(".variant-is-default").on("change", function () {
                    $("#product-variant-table tbody .variant-is-default")
                        .not(this)
                        .prop("checked", false);
                });

                variantIndex++;

                let $rows = $("#product-variant-table tbody tr");
                if ($rows.length === 1) {
                    $rows.find(".remove_variant").prop("disabled", true).hide();
                }
            },
            error: function () {
                alert("Failed to fetch product variant data.");
            },
        });
    }

    // Handle the checkbox behavior
    $(".variant-is-default").on("change", function () {
        const currentCheckbox = $(this);
        if (currentCheckbox.is(":checked")) {
            currentCheckbox.val(1);
            // Uncheck all other checkboxes
            $(".variant-is-default")
                .not(currentCheckbox)
                .prop("checked", false).val(0);
        }
    });

    // Remove the variant row
    $(document).on("click", ".remove_variant", function () {
        let row = $(this).closest("tr");
        let totalRows = $("#product-variant-table tbody tr").length;
        if (totalRows > 1) {
            row.remove();
            // Check if only one row remains
            let remainingRows = $("#product-variant-table tbody tr");
            if (remainingRows.length === 1) {
                // Disable the remove button for the last row
                remainingRows
                    .find(".remove_variant")
                    .prop("disabled", true)
                    .hide();
                // Automatically set the last remaining variant as default
                let remainingIndex = remainingRows.data("index");
                $(`#variant_is_default_${remainingIndex}`).prop(
                    "checked",
                    true
                );
            }
        } else {
            AppHelpers.showAlert(
                "error",
                "Error",
                "At least one variant must be added."
            );
        }
    });
    // Product variant part end

    $(document).on("click", "#product-submit", function (event) {
        event.preventDefault();

        const submitButton = $(this); // Reference to the submit button
        const spinTag = "<i class='fa fa-spinner fa-spin me-2 spinner'></i>";
        const text = " Please wait...";
        const buttonText = spinTag + text;
        // Disable button and show spinner
        submitButton.prop("disabled", true).html(buttonText);

        const form = $("#product-form"); // Form element
        const formData = new FormData(form[0]);

        // Retrieve method and action dynamically
        const method = form.attr("method") || "POST"; // Default to POST if method not defined
        const action = form.attr("action"); // Action URL from form

        // Add CKEditor data to FormData
        const productDetails = CKEDITOR.instances["product_details"].getData();
        formData.append("product_details", productDetails);
        const productSpecification =
            CKEDITOR.instances["product_specification"].getData();
        formData.append("product_specification", productSpecification);

        // If the method is PUT, append `_method` for Laravel compatibility
        if (method.toUpperCase() === "PUT") {
            formData.append("_method", "PUT");
        }

        $.ajax({
            url: action, // Dynamic URL
            method: method, // Dynamic method
            data: formData,
            dataType: "json",
            contentType: false, // Set content type to false for FormData
            processData: false, // Prevent jQuery from processing the data
            success: function (response) {
                // Reset form styling and error messages
                rmoveErrorMessage();

                if (response.status === "success") {
                    if (response.type === "added") {
                        Swal.fire({
                            text: response.message,
                            icon: "success",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#6495ed",
                            confirmButtonText: "Go to product lists",
                            cancelButtonText: "Add More",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = base_url + "/products";
                            } else {
                                // Re-enable button when adding more products
                                submitButton.prop("disabled", false).html("Submit");
                                window.location.href =
                                    base_url + "/products/create";
                            }
                        });
                    } else {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: response.message,
                            showConfirmButton: false,
                            timer: 3000
                        });
                        window.location.href = base_url + "/products";
                    }

                } else {
                    AppHelpers.showAlert("error", "Error", response.message);
                    // Re-enable button on error
                    submitButton.prop("disabled", false).html("Submit");
                }
            },
            error: function (error) {
                if (error.status === 422) {
                    // Reset form styling and error messages
                    rmoveErrorMessage();
                    // Display errors
                    let errors = error.responseJSON.errors;
                    // Display errors
                    $.each(errors, function (field, messages) {
                        if (field.startsWith("images.")) {
                            // Handle index-based errors for variants
                            const imgParts = field.split(".");
                            const index = imgParts[1]; // Extract index
                            const imageField = imgParts[2];

                            const imgInput = $(
                                `#product_${imageField}_${index}_error`
                            );
                            const imageError = imgInput.next(
                                ".product-image-error-message"
                            );
                            // If there is an error, show it
                            if (messages && messages.length > 0) {
                                imgInput.addClass("border-danger");
                                imgInput.text(messages[0]); // Show the error message
                            } else {
                                // If no error, remove the border-danger class and clear the error message
                                imgInput.removeClass("border-danger");
                                // N:B Error message not clearing
                                imgInput.text(""); // Clear the error message text
                            }
                        }

                        if (
                            field === "need_one_variant" ||
                            field == "min_max_one_default"
                        ) {
                            AppHelpers.showAlert("error", "Error", messages[0]);
                        }

                        if (field.startsWith("variants.")) {
                            // Handle index-based errors for variants
                            const fieldParts = field.split(".");
                            const index = fieldParts[1]; // Extract index
                            const variantField = fieldParts[2]; // Extract variant field (e.g., size, color)
                            // Find the input element and the error message element for this specific variant
                            const inputField = $(
                                `#variant_${variantField}_${index}`
                            );
                            // Display error by common class using next or by field wise id
                            // const errorMessageElement = inputField.next(".variant-error-message");
                            const errorMessageElement = $(
                                `#variant_${variantField}_${index}_error`
                            );
                            // If there is an error, show it
                            if (messages && messages.length > 0) {
                                inputField.addClass("border-danger");
                                errorMessageElement.text(messages[0]); // Show the error message
                            } else {
                                // If no error, remove the border-danger class and clear the error message
                                inputField.removeClass("border-danger");
                                // N:B Error message not clearing
                                errorMessageElement.text(""); // Clear the error message text
                            }
                        }
                        // General field errors
                        $(`#product_${field}`).addClass("border-danger");
                        $(`#product_${field}_error`).text(messages[0]);
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Something went wrong!",
                        text: "Please try again later.",
                    });
                }
                // Re-enable button on error
                submitButton.prop("disabled", false).html("Submit");
            },
        });
    });

    function rmoveErrorMessage() {
        // Clear previous error styles and messages
        $(".form-control").removeClass("border-danger");
        // Remove all input error message
        $(".product-error-message").empty();
        // making all variant error message empty
        $(".variant-error-message").empty();
        // making all product image error message empty
        $(".product-image-error-message").empty();
    }
})(jQuery);
