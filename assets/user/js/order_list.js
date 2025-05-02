(function ($) {
    "use strict";
    let base_url = AppHelpers.base_url;
    // Press Enter key in input
    $('#searchOrder').on('keypress', function (e) {
        if (e.which === 13) { // Enter key
            e.preventDefault();
            let query = $('#searchOrder').val().trim();
            if (query !== '') {
                window.location.href = base_url + '/order-list?search=' + encodeURIComponent(query);
            }
        }
    });
})(jQuery);
