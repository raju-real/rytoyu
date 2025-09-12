(function ($) {
    "use strict";

    // This checks if the script is loaded and executed correctly.
    console.log("Chatbot script loaded.");

    // API URL setup using the base URL from your helpers file
    let base_url = window.AppHelpers ? window.AppHelpers.base_url : '';
    const API_URL = base_url + '/chat-bot-query';

    // Cache DOM elements
    const $chatContainer = $('#chat-container');
    const $messagesContainer = $('#chat-messages');
    const $userInput = $('#user-input');
    const $sendButton = $('#send-button');
    const $chatbotIcon = $('#chatbot-icon');
    const $closeButton = $('#close-chat-button');

    // Event handlers
    $chatbotIcon.on('click', function () {
        $chatContainer.toggle();
        if ($chatContainer.is(':visible')) {
            $userInput.focus();
        }
    });

    $closeButton.on('click', function () {
        $chatContainer.toggle();
    });

    $sendButton.on('click', function () {
        handleSendMessage();
    });

    $userInput.on('keypress', function (e) {
        if (e.which === 13) { // 13 is the Enter key code
            handleSendMessage();
        }
    });


    /**
     * Handles the process of sending a user message.
     * It sends the query to the backend and handles the response.
     */
    function handleSendMessage() {
        const userText = $userInput.val().trim();
        if (!userText) {
            return;
        }

        addMessage(userText, 'user');
        $userInput.val('');
        $sendButton.prop('disabled', true);
        showTypingIndicator();

        // Use Axios to make the request
        axios.post(API_URL, {
            query: userText
        })
            .then(function (response) {
                const result = response.data;
                if (result.type === 'products') {
                    // Pass the entire result object to the display function
                    if(result.data.length > 0) {
                        displayProductList(result);
                    } else {
                        addMessage("Sorry! No items found by your search criteria.", 'bot');
                    }
                } else {
                    addMessage(result.data, 'bot');
                }
            })
            .catch(function (error) {
                let errorMessage = "An unexpected error occurred. Please try again later.";
                if (error.response) {
                    // The request was made and the server responded with a status code
                    // that falls out of the range of 2xx
                    errorMessage = `API Error: ${error.response.status} - ${error.response.statusText}. Please try again later.`;
                } else if (error.request) {
                    // The request was made but no response was received
                    errorMessage = "Network Error: Could not connect to the server. Please check your connection.";
                } else {
                    // Something happened in setting up the request that triggered an Error
                    errorMessage = "Error: " + error.message;
                }
                addMessage(errorMessage, 'bot');
                console.error('Axios Error:', error);
            })
            .finally(function () {
                removeTypingIndicator();
                $sendButton.prop('disabled', false);
            });
    }

    /**
     * Adds a message to the chat interface.
     * @param {string} text - The content of the message.
     * @param {string} sender - 'user' or 'bot'.
     */
    function addMessage(text, sender) {
        const $messageDiv = $('<div>').addClass('message').addClass(sender + '-message').text(text);
        $messagesContainer.append($messageDiv);
        $messagesContainer.scrollTop($messagesContainer.prop("scrollHeight"));
    }

    /**
     * Displays a list of products in the chatbox with improved pricing.
     * @param {Object} result - The full API response object containing products and link.
     */
    function displayProductList(result) {
        const products = result.data;
        const allResultsLink = result.all_results_link;

        const $productListDiv = $('<div>').addClass('message bot-message product-list');
        $productListDiv.append($('<h5>').text('Here are some products I found:'));

        products.forEach(product => {
            let product_price = '';
            if (product.discount_price && product.discount_price > 0) {
                product_price = `Price: ${product.discount_price}`;
                if (product.unit_price > product.discount_price) {
                    // Display original price with a strikethrough for a clear discount indication.
                    product_price += ` <span style="text-decoration: line-through; color: #a0aec0;">${product.unit_price}</span>`;
                }
            } else {
                product_price = `Price: ${product.unit_price}`;
            }

            const productHtml = `
                    <div class="product-item">
                        <img src="${product.thumbnail_path || 'https://placehold.co/60x60?text=Product'}"
                             alt="${product.name}"
                             onerror="this.onerror=null;this.src='https://placehold.co/60x60?text=Product';">
                        <div class="product-info">
                            <h6>${product.name}</h6>
                            <p>${product_price}</p>
<!--                            <button class="view-details-btn" data-product-slug="${product.slug}">View Details</button>-->
                            <button class="view-detils-btn product-view"
                                        data-product-id="${product.id}"><i class="fa-regular fa-eye"></i></button>
                            <a class="view-detils-btn" href="${product.details_link}" target="_blank">View Details</a>
                        </div>
                    </div>
                `;
            $productListDiv.append(productHtml);
        });

        // Add a "Show All Results" button at the bottom of the product list
        $productListDiv.append(`
                <a href="${allResultsLink}" target="_blank" class="show-all-btn">
                    Show All Results
                </a>
            `);

        $messagesContainer.append($productListDiv);
        $messagesContainer.scrollTop($messagesContainer.prop("scrollHeight"));
    }

    /**
     * Shows a typing indicator.
     */
    function showTypingIndicator() {
        const $typingIndicator = $('<div>').attr('id', 'typing-indicator').addClass('message bot-message loading-dots');
        $typingIndicator.html('<span>•</span><span>•</span><span>•</span>');
        $messagesContainer.append($typingIndicator);
        $messagesContainer.scrollTop($messagesContainer.prop("scrollHeight"));
    }

    /**
     * Removes the typing indicator.
     */
    function removeTypingIndicator() {
        $('#typing-indicator').remove();
    }

})(jQuery);
