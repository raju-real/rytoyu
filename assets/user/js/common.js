(function ($) {
    "use strict";
    let base_url = AppHelpers.base_url;

    // On click of search button
    $('.searchBtn').on('click', function (e) {
        e.preventDefault();
        const relatedInput = $(this).closest('.search-container').find('.searchInput');
        performSearch(relatedInput);
    });

    // On Enter key press inside search input
    $('.searchInput').on('keypress', function (e) {
        if (e.which === 13) { // Enter key
            e.preventDefault();
            performSearch(this);
        }
    });

    function performSearch(inputElement) {
        let query = $(inputElement).val().trim();

        if (query !== '') {
            const url = new URL(base_url + '/product-lists'); // Base URL
            url.searchParams.set('search', query); // Set search param
            window.location.href = url.toString(); // Redirect to URL
        }
    }


    $(document).on("click", '.product-type-btn', function () {
        const typeSlug = $(this).data('type');     // type slug
        const categorySlug = $(this).data('slug'); // category slug
        const url = new URL(base_url + '/product-lists'); // Base URL

        if (typeSlug) {
            url.searchParams.set('type', typeSlug); // Set type param
        }
        if (categorySlug) {
            url.searchParams.set('category', categorySlug); // Set category param
        }
        window.location.href = url.toString(); // Redirect to URL
    });

    // Redirect to a Route
    $(document).on("click", '.redirect-to-link', function () {
        const redirectRoute = $(this).data('route');
        if (redirectRoute) {
            const url = new URL(redirectRoute);
            window.location.href = url.toString();
        }
    });


    $(document).on("click", ".product-view", function () {
        const productId = $(this).data("product-id");

        axios.get(base_url + '/single-product-info/' + productId)
            .then(function (response) {
                $('#productInfo').empty().html(response.data.html);
                // Re-init Owl Carousel
                $('#productInfo .owl-carousel').owlCarousel({
                    items: 1,
                    loop: true,
                    margin: 10,
                    nav: true,
                    dots: true,
                    autoplay: true,
                    autoplayTimeout: 3000,
                    navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"]
                });
                // Re-init PrettyPhoto
                $('#productInfo a[data-gal="prettyPhoto"]').prettyPhoto({
                    theme: 'facebook',
                    social_tools: false
                });
                // Show the modal
                $("#productView").modal("show");
                // Get selected color name from title
                const selectedColorName = $('.color-radio:checked')
                    .siblings('label')
                    .find('span')
                    .attr('title') || '—';
                // Get selected size name from label text
                const selectedSizeName = $('.size-radio:checked')
                    .siblings('label')
                    .text()
                    .trim() || '—';

                // Update DOM with selected color and size names
                $('h4.color-list span').text(selectedColorName);
                $('h4.margin-size span').text(selectedSizeName);
            })
            .catch(function (error) {
                console.error("Error loading product view:", error);
            });
    });

    function assetUrl(path) {
        return base_url + '/' + path.replace(/^\/+/, '');
    }

})(jQuery);
