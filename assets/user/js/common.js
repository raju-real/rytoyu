(function ($) {
    "use strict";
    let base_url = AppHelpers.base_url;

    loadCartItems();

    /**
     * Ajax csrf token setup
     */
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $(document).on("click", ".product-view", function () {
        const productId = $(this).data("product-id");

        axios.get(base_url + '/single-product-info/' + productId)
            .then(function (response) {
                const product = response.data.product;
                const images = product.images;

                let carouselItems = '';
                let thumbnails = '';

                images.forEach((image, index) => {
                    carouselItems += `
                    <div class="item">
                        <a class="btn btn-theme btn-theme-transparent btn-zoom" href="${image.image_path}"
                           data-gal="prettyPhoto"><i class="fa fa-plus"></i></a>
                        <a href="${image.image_path}" data-gal="prettyPhoto">
                            <img class="img-responsive" src="${image.image_path}" alt=""/>
                        </a>
                    </div>`;

                    thumbnails += `
                    <div class="col-xs-2 col-sm-2 col-md-3">
                        <a href="#" onclick="jQuery('.img-carousel').trigger('to.owl.carousel', [${index}, 300]);">
                            <img src="${image.image_path}" alt=""/>
                        </a>
                    </div>`;
                });

                const productInfo = `
                <div class="row product-single">
                    <div class="col-md-6">
                        <div class="owl-carousel img-carousel img-carousel2">${carouselItems}</div>
                        <div class="row product-thumbnails">${thumbnails}</div>
                    </div>
                    <div class="col-md-6">
                        <!-- You can dynamically insert product.title, price, etc. here -->
                        <h2 class="product-title">${product.name}</h2>
                        <div class="product-price">TK: ${product.price}</div>
                        <!-- more dynamic content here... -->
                    </div>
                </div>`;

                $('#productInfo').html(productInfo);

                // re-init carousel
                $(".img-carousel").owlCarousel({
                    items: 1,
                    nav: true,
                    dots: false,
                    autoplay: true,
                    loop: true
                });

                $("#productView").modal("show");
            })
            .catch(function (error) {
                console.error("Error loading product view:", error);
            });
    });


    function assetUrl(path) {
        return base_url + '/' + path.replace(/^\/+/, '');
    }

    // Trigger for add to cart button
    $(document).on('click', '.add-t-c-2', addToCart);

    function addToCart(event) {
        event.preventDefault(); // prevent default form submission if inside a form

        const button = $(event.currentTarget);
        const productId = button.data('product-id');
        const colorId = $('.color-radio:checked').val() || null;
        const sizeId = $('.size-radio:checked').val() || null;
        const quantity = $('.qty').val() || 1;

        $.ajax({
            url: base_url + '/add-to-cart',
            type: 'POST',
            data: {
                product_id: productId,
                color_id: colorId,
                size_id: sizeId,
                quantity: quantity
            },
            success: function (response) {
                if (response.status === 'success') {
                    alert(response.message); // Or use toast/notification
                    loadCartItems();
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr) {
                alert('Something went wrong!');
            }
        });
    }

    function loadCartItems() {
        axios.get(base_url + '/load-cart-items').then((response) => {
            const total = Number(response.data.item_summary.item_total || 0);
            $('#cart-item-total').text(total.toLocaleString());
            $('#mini-cart-item').empty().html(response.data.cart_view);
        });
    }


})(jQuery);
