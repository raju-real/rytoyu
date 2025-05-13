(function ($) {
    "use strict";
    const bas_url = AppHelpers.base_url;

    let timerInterval;

    // Start the resend code timer
    function startResendTimer(button, duration) {
        let timeRemaining = duration; // seconds
        button.prop("disabled", true).text(`Resend Code in ${timeRemaining}s`);
        timerInterval = setInterval(function () {
            timeRemaining--;
            if (timeRemaining > 0) {
                button.text(`Resend Code in ${timeRemaining}s`);
            } else {
                clearInterval(timerInterval);
                button.prop("disabled", false).text("Resend Code");
            }
        }, 1000);
    }

    // Send verification code
    $("#send-code-btn").on("click", function () {
        let sendCodeBtn = $(this);
        let mobile = $("#mobile").val();

        axios.post(bas_url+"/send-mobile-verification-code", { mobile: mobile })
            .then(function (response) {
                sendCodeBtn.prop("disabled", true);
                $('#success-message').show().empty().text(response.data.message);
                // AppHelpers.showToast("success", response.data.message);
                $("#verification-section").show();
                $(".mobile-error").text("");
                startResendTimer(sendCodeBtn, 10);
            })
            .catch(function (error) {
                let errorMessage = error.response?.data?.message || "Something went wrong.";
                let errors = error.response?.data?.errors || {};
                const errorMessageToDisplay = errors.mobile
                    ? errors.mobile[0]
                    : errorMessage;
                $(".mobile-error").text(errorMessageToDisplay);
            });
    });

    // Verify the code
    $("#verify-code-btn").on("click", function () {
        let code = $('#verification-code').val().replace(/\D/g, '');

        axios.post(bas_url+"/verify-mobile-verification-code", { verification_code: code })
            .then(function (response) {
                $('.alert-info').hide();
                $('#success-message').show().empty().text(response.data.message);
                $('#verification-section').hide();
                //location.reload();
            })
            .catch(function (error) {
                let errorMessage = error.response?.data?.message || "Something went wrong.";
                let errors = error.response?.data?.errors || {};

                const errorMessageToDisplay = errors.verification_code
                    ? errors.verification_code[0]
                    : errorMessage;
                $(".verification-code-error").text(errorMessageToDisplay);
            });
    });

    // Format verification code input
    $('#verification-code').on('input', function () {
        let value = $(this).val();
        let formattedValue = AppHelpers.formatInput(value, ' - ', 21);
        $(this).val(formattedValue);

        if (value.length === 2 || value.length === 5) {
            $(this).next('input').focus();
        }
    });

})(jQuery);
