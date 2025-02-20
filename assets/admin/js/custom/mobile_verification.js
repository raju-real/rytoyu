(function ($) {
    "use strict";

    let timerInterval;
    // Start the resend code timer
    function startResendTimer(button, duration) {
        let timeRemaining = duration; // Time in seconds
        button.prop("disabled", true).text(`Resend Code in ${timeRemaining}s`);
        timerInterval = setInterval(function () {
            timeRemaining--;
            if (timeRemaining > 0) {
                button.text(`Resend Code in ${timeRemaining}s`);
            } else {
                clearInterval(timerInterval);
                button.prop("disabled", false).text("Resend Code");
            }
        }, 1000); // Update every second
    }

    // Send verification code
    $("#send-code-btn").on("click", function () {
        let sendCodeBtn = $(this); // Reference to the button
        // Simulating an API call (use your AppHelper or actual Ajax here)
        AppHelpers.ajaxRequest(
            "/send-verification-code", // URL
            "POST", // Method
            { mobile: $("#mobile").val() }, // Data
            function (response) {
                sendCodeBtn.prop("disabled", true); // Disable button
                // Success Callback
                AppHelpers.showAlert("success", "Success", response.message);
                $("#verification-section").show(); // Show the verification section
                $(".mobile-error").text(""); // Clear any existing error
                // Start the resend timer (2 minutes)
                startResendTimer(sendCodeBtn, 120);
            },
            function (errorMessage, errors) {
                // Error Callback
                AppHelpers.showAlert("error", "Error", errorMessage);
                const errorMessageToDisplay = errors.mobile
                    ? errors.mobile[0]
                    : errorMessage;
                $(".mobile-error").text(errorMessageToDisplay); // Display error under mobile field
            }
        );
    });

    // Verify the code
    $("#verify-code-btn").on("click", function () {
        let code = $('#verification-code').val();
        // Remove the dashes before sending to backend
        code = code.replace(/\D/g, ''); // Remove any non-digit characters
        // Call the AppHelper to verify the code
        AppHelpers.ajaxRequest(
            "/verify-code", // URL
            "POST", // Method
            { verification_code: code }, // Data
            function (response) {
                AppHelpers.showAlert("success", "Verified", response.message);
                location.reload(); // Reload the page to reflect verification status
            },
            function (errorMessage, errors) {
                console.log(errorMessage,errors);
                // Error Callback
                AppHelpers.showAlert("error", "Error", errorMessage);
                const errorMessageToDisplay = errors.verification_code
                    ? errors.verification_code[0]
                    : errorMessage;
                $(".verification-code-error").text(errorMessageToDisplay); 
            }
        );
    });

    // Restrict verification code input to exactly 6 digits and display in the format 6 - 9 - 8 - 7
    $('#verification-code').on('input', function () {
        let value = $(this).val();
        let formattedValue = AppHelpers.formatInput(value, ' - ', 21); // Format input as 2 - 5 - 8 - 7
        $(this).val(formattedValue);

        // Auto-focus on next input after 2 digits
        if (value.length === 2 || value.length === 5) {
            // Move cursor to the next part of the input after 2nd and 5th character
            $(this).next('input').focus();
        }
    });
})(jQuery);
