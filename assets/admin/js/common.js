(function ($) {
    "use strict";
    /**
     * Ajax csrf token setup
     */
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $(".select2").select2();
    $(".select2-search-disable").select2({ minimumResultsForSearch: 1 / 0 });
    
    // Auto initialize all selects with select2 (dynamic searchable, static search disabled)
    $("select:not(.no-select2)").each(function () {
        var $this = $(this);
        if (!$this.hasClass("select2-hidden-accessible")) {
            // If more than 10 options, or has class 'searchable', enable search. Otherwise disable search.
            let isDynamic = $this.find("option").length > 10 || $this.hasClass("searchable");
            if (isDynamic) {
                $this.select2();
            } else {
                $this.select2({ minimumResultsForSearch: Infinity });
            }
        }
    });

    // Auto set placeholders for inputs and textareas
    $("input:not([type='hidden'], [type='checkbox'], [type='radio'], [type='file'], [type='submit'], [type='color']), textarea").each(function () {
        let $this = $(this);
        if (!$this.attr("placeholder")) {
            let id = $this.attr("id");
            let labelText = "";
            if (id) {
                let label = $("label[for='" + id + "']");
                if (label.length) labelText = label.text().replace("*", "").trim();
            }
            if (!labelText) {
                let parentLabel = $this.closest("label");
                if (parentLabel.length) labelText = parentLabel.text().replace("*", "").trim();
            }
            if (!labelText && $this.attr("name")) {
                labelText = $this.attr("name").replace(/_/g, " ").replace(/-/g, " ");
                labelText = labelText.charAt(0).toUpperCase() + labelText.slice(1);
            }
            if (labelText) {
                $this.attr("placeholder", "Enter " + labelText);
            }
        }
    });

    // Apply custom datepicker class everywhere
    $('input[type="date"]').addClass("custom-datepicker");

    // Init Tooltips for truncated text
    setTimeout(function() {
        $('.table tbody tr td').each(function() {
            if (this.offsetWidth < this.scrollWidth && !$(this).attr('data-bs-toggle')) {
                $(this).attr('data-bs-toggle', 'tooltip');
                $(this).attr('data-bs-placement', 'top');
                $(this).attr('title', $(this).text().trim());
            }
        });
        
        let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }, 500);

    $(document).on("click", ".view-image", function () {
        const imageUrl = $(this).data("image-url");
        $("#modalImage").attr("src", imageUrl); // Set the image URL in the modal
        $("#viewImageModal").modal("show"); // Show the modal
    });

    $(document).on("submit", "#prevent-form", function () {
        let spinTag = "<i class='fa fa-spinner fa-spin me-2 spinner'></i>";
        let text = " Please wait...";
        let buttonText = spinTag + text;
        $(".submit-button").prop("disabled", true).html(buttonText);
    });

    $(document).on("click", ".delete-data", function (e) {
        e.preventDefault();
        let target = $(this).attr("data-id");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't to delete this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $("#" + target).submit();
            }
        });
    });


})(jQuery);
