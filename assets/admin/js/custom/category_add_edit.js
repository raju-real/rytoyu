(function ($) {
    "use strict";
    const methodMode = $("#method_mode").val();

    let bannerImageIndex = 0;
    if (methodMode == "PUT") {
        bannerImageIndex = $("#total_banner_images").val();
    }

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
