(function ($) {
    "use strict";
    let base_url = AppHelpers.base_url;

    loadMiniCartItem();
    updateVariantName();

    $(document).on("change", ".color-radio, .size-radio", function () {
        updateVariantName();

        const productId = $("#product-id").val();
        const colorId = $(".color-radio:checked").val() || null;
        const sizeId = $(".size-radio:checked").val() || null;

        getProductVariantInfo(productId, colorId, sizeId);
    });

    function updateVariantName() {
        // Get selected color name from title
        const selectedColorName =
            $(".color-radio:checked")
                .siblings("label")
                .find("span")
                .attr("title") || "—";

        // Get selected size name from label text
        const selectedSizeName =
            $(".size-radio:checked").siblings("label").text().trim() || "—";

        // Update DOM with selected color and size names
        $("h4.color-list span").text(selectedColorName);
        $("h4.margin-size span").text(selectedSizeName);
    }

    function getProductVariantInfo(product_id, color_id, size_id) {
        axios
            .get(base_url + "/api/product-variant-info", {
                params: {
                    product_id,
                    color_id,
                    size_id,
                },
            })
            .then(function (response) {
                const variant = response.data;
                if (variant) {
                    $("#product-price-sec").show();
                    // Update availability
                    $("#stock-status").text(variant.stock_status ?? "N/A");
                    $("#inventory").text(variant.inventory ?? "0");
                    // Update price
                    if (variant.discount_price > 0) {
                        $("#unit-price").text(variant.discount_price ?? 0);
                        $("#discount-price")
                            .html("<del>" + variant.unit_price + "</del>")
                            .show();
                    } else {
                        $("#unit-price").text(variant.unit_price ?? 0);
                        $("#discount-price").hide();
                    }
                    // Enable quantity & Add to Cart
                    $(".quantity button, .quantity input").prop(
                        "disabled",
                        false
                    );
                    $(".add-t-c-2")
                        .prop("disabled", false)
                        .html(
                            '<i class="fa fa-shopping-cart"></i> Add to cart'
                        );
                } else {
                    $("#product-price-sec").hide();
                    $("#stock-status").text("Out of Stock");
                    $("#inventory").text("0");
                    $("#unit-price").text(0);
                    $("#discount-price").hide();
                    // Disable quantity & Add to Cart
                    $(".quantity button, .quantity input").prop(
                        "disabled",
                        true
                    );
                    $(".add-t-c-2")
                        .prop("disabled", true)
                        .html('<i class="fa fa-ban"></i> No Variant Found!');
                }
            })
            .catch(function (error) {
                console.error("Error fetching variant info:", error);
            });
    }

    $(document).on("click", ".qty-btn", function (e) {
        e.preventDefault();

        var $button = $(this);
        var $input = $button.closest(".quantity").find(".qty");
        var oldValue = parseInt($input.val()) || 1;
        var type = $button.data("type");

        if (type === "minus") {
            if (oldValue > 1) {
                $input.val(oldValue - 1);
            }
        } else if (type === "plus") {
            $input.val(oldValue + 1);
        }
    });


    // Trigger for add to wishlist button
    $(document).on("click", ".add-to-wishlist", addToWishlist);
    function addToWishlist(event) {
        event.preventDefault(); // prevent default form submission if inside a form

        const button = $(event.currentTarget);
        const productId = button.data("product-id");

        axios
            .post(base_url + "/add-to-wishlist", {
                product_id: productId
            })
            .then(function (response) {
                if (response.data.status === "success") {
                    AppHelpers.showToast("success", response.data.message);
                    loadMiniCartItem();

                } else {
                    AppHelpers.showToast("error",'Invalid Request', response.data.message);
                }
            })
            .catch(function (error) {
                console.error(error);
                AppHelpers.showToast("danger",'Invalid Request', error);
            });
    }

    // Trigger for add to cart button
    $(document).on("click", ".add-t-c-2", addToCart);

    function addToCart(event) {
        event.preventDefault(); // prevent default form submission if inside a form

        const button = $(event.currentTarget);
        const productId = button.data("product-id");
        const colorId = $(".color-radio:checked").val() || null;
        const sizeId = $(".size-radio:checked").val() || null;
        const quantity = $(".qty").val() || 1;

        axios
            .post(base_url + "/add-to-cart", {
                product_id: productId,
                color_id: colorId,
                size_id: sizeId,
                quantity: quantity,
            })
            .then(function (response) {
                if (response.data.status === "success") {
                    AppHelpers.showToast("success", response.data.message);
                    loadMiniCartItem();

                } else {
                    AppHelpers.showToast("danger",'Invalid Request', response.data.message);
                }
            })
            .catch(function (error) {
                console.error(error);
                AppHelpers.showToast("danger",'Invalid Request', error);
            });
    }

    function loadMiniCartItem() {
        axios.get(base_url + "/load-cart-items").then((response) => {
            const total = Number(response.data.item_summary.item_total || 0);
            $("#cart-item-total").text(total.toLocaleString());
            $("#mini-cart-item").empty().html(response.data.html);
        });
    }

    // Only checkout page activity
    if (AppHelpers.current_page === "checkout") {
        setShippingFee();
        reloadCartTable();
        toggleDeleteButton();
        reloadPriceSummery();
        setPaymentMethod();

        // Delete button enable and disabled
        function toggleDeleteButton() {
            const anyChecked = $(".select-all-item:checked").length > 0;
            if (anyChecked) {
                $("#delete-selected")
                    .removeClass("disabled")
                    .css({ "pointer-events": "auto", opacity: "1" });
            } else {
                $("#delete-selected")
                    .addClass("disabled")
                    .css({ "pointer-events": "none", opacity: "0.6" });
            }
        }

        // Select All
        $(document).on("change", "#select-all", function () {
            const isChecked = $(this).is(":checked");
            $(".select-all-item").prop("checked", isChecked);
            toggleDeleteButton();
        });
        // Single checkbox selection
        $(document).on("change", ".select-all-item", function () {
            const allChecked =
                $(".select-all-item").length ===
                $(".select-all-item:checked").length;
            $("#select-all").prop("checked", allChecked);
            toggleDeleteButton();
        });
        // Delete selected items
        $(document).on("click", "#delete-selected", function () {
            if ($(this).hasClass("disabled")) return;

            const selectedIds = [];
            $(".select-all-item:checked").each(function () {
                selectedIds.push($(this).data("id"));
            });

            if (selectedIds.length === 0) return;

            if (!confirm("Are you sure you want to delete selected items?"))
                return;

            $.ajax({
                url: base_url + "/remove-item-from-cart",
                method: "DELETE",
                data: {
                    ids: selectedIds,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    loadMiniCartItem();
                    reloadCartTable();
                    reloadPriceSummery();
                },
                error: function (error) {
                    console.log(error);

                    AppHelpers.showToast("danger", "Something went wrong!");
                },
            });
        });
        // Update cart quantity
        $(document).on("click", ".update-quantity", function () {
            const itemKey = $(this).data("id");
            const action = $(this).data("action");

            // Send request to update the cart item quantity
            axios
                .post(base_url + "/update-cart-quantity", {
                    item_key: itemKey,
                    action: action,
                })
                .then((response) => {
                    loadMiniCartItem();
                    reloadCartTable();
                    reloadPriceSummery();
                })
                .catch((error) => {
                    console.error(error);
                });
        });
        // Remove single item (Cross icon)
        $(document).on("click", ".remove-item", function () {
            const id = $(this).data("id");

            if (!confirm("Are you sure you want to remove this item?")) return;

            $.ajax({
                url: base_url + "/remove-item-from-cart",
                method: "DELETE",
                data: {
                    ids: [id], // send as array
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    loadMiniCartItem();
                    reloadCartTable();
                    reloadPriceSummery();
                    toggleDeleteButton();
                },
                error: function (error) {
                    console.log(error);
                    AppHelpers.showToast("danger", "Something went wrong!");
                },
            });
        });
        // Set shipping fee
        $(document).on("change", "#district", function () {
            setShippingFee();
        });
        // Set shipping fee
        function setShippingFee() {
            const district = $("#district").val();
            axios
                .get(base_url + "/set-shipping-fee?district=" + district)
                .then((response) => {
                    if (response.data.status === "error") {
                        $("#order_district_error").text(response.data.message);
                    }
                    reloadPriceSummery();
                })
                .catch((error) => {
                    console.error(error);
                    AppHelpers.showToast(
                        "danger",
                        "Failed to set district."
                    );
                });
        }
        // Set cash on delivery as default
        function setPaymentMethod() {
            const $target = $('#accordion a[data-value="cash-on-delivery"]');
            const $panel = $target.closest(".panel");
            // Remove `.selected` from all other options
            $("#accordion a").removeClass("selected");
            // Add `.selected` to the current target
            $target.addClass("selected");
            // Expand only this panel
            $(".panel-collapse").collapse("hide"); // Collapse all others first
            $panel.find(".panel-collapse").collapse("show");
            setServiceCharge();
        }
        // Set payment method
        $("#accordion a").on("click", function (e) {
            e.preventDefault();
            // Remove selected class from all
            $("#accordion a").removeClass("selected");
            // Add selected class to the clicked one
            $(this).addClass("selected");
            // Collapse all panels and expand the one clicked
            $(".panel-collapse").collapse("hide");
            $(this).closest(".panel").find(".panel-collapse").collapse("show");
            setServiceCharge();
        });

        function setServiceCharge() {
            const selected_method = $("#accordion a.selected").data("value") || "cash-on-delivery";
            $('#order_payment_method_error').empty();

            axios
                .get(base_url + "/set-payment-method?payment_method=" + selected_method)
                .then((response) => {
                    if (response.data.status === "error") {
                        $("#order_payment_method_error").addClass('alert alert-danger').text(response.data.message);
                    } else if(response.data.status === 'success' && response.data.payment_method === 'online-payment') {
                        $('#order_payment_method_error').text("Extra " + response.data.service_charge + ' Tk will bed added with your total amount.')
                    }
                    reloadPriceSummery();
                })
                .catch((error) => {
                    AppHelpers.showToast(
                        "danger",
                        "Failed to set payment method."
                    );
                });
        }

        // Reload Cart Table Function
        function reloadCartTable() {
            axios
                .get(base_url + "/checkout-products")
                .then((response) => {
                    $("#cart-items-tbody").html(response.data.html);
                })
                .catch((error) => {
                    console.error(error);
                    AppHelpers.showToast(
                        "danger",
                        "Failed to reload cart data."
                    );
                });
        }
        // Reload price summery
        function reloadPriceSummery() {
            axios
                .get(base_url + "/load-price-summery")
                .then((response) => {
                    $("#checkout-summery").html(response.data.html);
                })
                .catch((error) => {
                    console.error(error);
                    AppHelpers.showToast(
                        "danger",
                        "Failed to reload price summery data data."
                    );
                });
        }
        // Submit order
        $(document).on("click", "#order-submit", function (event) {
            event.preventDefault();

            const submitButton = $(this);
            const buttonText = " Please wait...";

            // Disable button and show loading state
            submitButton
                .addClass("disabled")
                .css({ "pointer-events": "none", opacity: "0.6" })
                .html(buttonText);

            const form = $("#order-form")[0];
            const formData = new FormData(form);

            // If using FormData
            const selectedPayment =  $("#accordion a.selected").data("value") || "cash-on-delivery";

            formData.append("payment_method", selectedPayment);

            axios
                .post(base_url + "/submit-order", formData)
                .then(function (response) {
                    if (response.data.status === "success") {
                        const message = encodeURIComponent(
                            response.data.message
                        );
                        window.location.href =
                            base_url + "/order-list?message=" + message;
                    }
                })
                .catch(function (error) {
                    if (error.response && error.response.status === 422) {
                        $(".form-control").css("border", "solid 1px #E9E9E9"); // Clear previous error styles and messages
                        //$(".order-error-message").empty(); // Remove all input error message

                        let errors = error.response.data.errors; // Handle validation errors
                        // General field errors
                        $.each(errors, function (field, messages) {
                            console.log("field", field, "message", messages[0]);
                            $(`#${field}`).css("border", "1px solid red");
                            //$(`#order_${field}_error`).text(messages[0]);
                        });
                    }
                    // Re-enable button on error
                    submitButton
                        .removeClass("disabled")
                        .css({ "pointer-events": "", opacity: "" })
                        .html("Submit Order");
                });
        });
    }
})(jQuery);
