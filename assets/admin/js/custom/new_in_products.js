(function ($) {
    "use strict";
    let base_url = AppHelpers.base_url;
    loadProducts();

    const $searchInput = $('#product-search');
    const $resultsContainer = $('#product-search-results');

// Debounce to reduce excessive API calls
    let debounceTimeout;
    $searchInput.on('input', function () {
        clearTimeout(debounceTimeout);
        const query = $.trim($(this).val());
        if (query.length > 2) { // Minimum 3 characters to trigger search
            debounceTimeout = setTimeout(() => fetchProducts(query), 300);
        } else {
            $resultsContainer.hide();
        }
    });

    function fetchProducts(query) {
        axios.get(`${base_url}/api/search-products`, {params: {query: query}})
            .then(response => {
                const products = response.data.products;
                renderSearchResults(products);
            })
            .catch(error => {
                console.error('Error fetching products:', error);
                $resultsContainer.hide();
            });
    }

    function renderSearchResults(products) {
        $resultsContainer.empty(); // Clear previous results
        if (products.length === 0) {
            $resultsContainer.append('<div class="list-group-item">No products found</div>');
        } else {
            products.forEach(product => {
                const productItem = `
                <div class="list-group-item d-flex align-items-center justify-content-between" id="item_product_${product.id}">
                    <div class="d-flex align-items-center">
                        <img src="${base_url + '/' + product.thumbnail_path}" alt="${product.name}" class="me-3" style="width: 50px; height: 50px; object-fit: cover;">
                        <div>
                            <div><strong>${product.name}</strong></div>
                            <div class="text-muted">Vendor: ${product.seller_shop_name} || SKU: ${product.product_code}</div>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-sm add-product-btn" data-id="${product.id}">Add</button>
                </div>
            `;
                $resultsContainer.append(productItem);
            });
        }
        $resultsContainer.show();

        // Attach click event to "Add" buttons
        $('.add-product-btn').off('click').on('click', function () {
            const productId = $(this).data('id');
            addProductToSection(productId);
        });
    }

    function addProductToSection(productId) {
        axios.post(`${base_url}/add-new-in-product`, {
            product_id: productId
        })
            .then(response => {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: response.data.message,
                    showConfirmButton: false,
                    timer: 3000
                });
                // Remove added item
                $('#item_product_'+productId).remove();
                // Optionally, refresh the product list or UI to reflect changes
                loadProducts();
            })
            .catch(error => {
                if (error.response && error.response.data) {
                    // Show the error message from the backend
                    AppHelpers.showAlert(
                        "error",
                        "Error",
                        error.response.data.message
                    );
                } else {
                    console.error('An unexpected error occurred:', error);
                }
            });
    }

    function loadProducts() {
        axios.get(`${base_url}/get-new-in-products`)
            .then(response => {
                const products = response.data; // Extract the products from the response
                const tableBody = document.querySelector('#new-in-products-table tbody');
                tableBody.innerHTML = ''; // Clear the existing table content

                if (products.length > 0) {
                    products.forEach(product => {
                        const productRow = `
                        <tr data-id="${product.id}">
                            <td class="handle sorting-serial w-5">${product.sorting_serial}</td>
                            <td class="handle">
                                <img src="${product.product.thumbnail_path ? `${base_url + '/' + product.product.thumbnail_path}` : `${base_url}/assets/common/images/ecommerce.png`}"
                                     class="avatar-sm rounded-3 d-block">
                            </td>
                            <td class="handle">
                                ${product.product.name || ''}
                                <br>
                                <small>
                                    Seller: ${product.product.seller_shop_name} <br>
                                    SKU: ${product.product.product_code || ''}
                                </small>
                            </td>
                            <td class="w-5">
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                   class="btn btn-sm btn-soft-danger delete-new-in-product"
                                   data-product-id="${product.product_id}"
                                   href="javascript:void(0);">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>

                        </tr>
                    `;
                        tableBody.insertAdjacentHTML('beforeend', productRow); // Append the row to the table
                    });
                } else {
                    tableBody.innerHTML = '<tr><td colspan="5"><x-no-data-found></x-no-data-found></td></tr>';
                }
            })
            .catch(error => {
                console.error('Error loading new-in products:', error);
            });
    }

    $('#new-in-products-table tbody').sortable({
        handle: '.handle',
        update: function (event, ui) {
            // passed id to array
            const sortedIds = $(this).sortable('toArray', {attribute: 'data-id'});
            axios.post(`${base_url}/update-new-in-product-sorting`, {ids: sortedIds})
                .then(response => {
                    $(".sort_new-in tr").each(function (index) {
                        $(this).find('.sorting-serial').text(index + 1); // Update sorting_serial column
                    });
                })
                .catch(error => {
                    console.error('Error updating sorting:', error);
                });
        }
    });

    // Event delegation to handle dynamic rows
    $('#new-in-products-table tbody').on('click', '.delete-new-in-product', function () {
        const deleteButton = $(this); // The clicked button
        const productId = deleteButton.data('product-id'); // Get product ID

        if (productId) {
            deleteSectionProduct(productId);
        }
    });

    // Function to delete new-in product
    function deleteSectionProduct(productId) {
            axios.delete(`${base_url}/delete-new-in-product`, {
                data: {product_id: productId} // Pass data in the request body
            })
                .then(response => {
                    if (response.data.status === 'success') {
                        //alert('Product deleted successfully!');
                        loadProducts(); // Reload new-in products after deletion
                    } else {
                        alert(response.data.message || 'Failed to delete product!');
                    }
                })
                .catch(error => {
                    console.error('Error deleting product:', error);
                    alert('An error occurred while trying to delete the product.');
                });

    }


})(jQuery);
