(function($){
    "use strict";

    // Professional Chatbot Class
    function ProfessionalChatbot() {
        this.init();
    }

    ProfessionalChatbot.prototype = {
        init: function() {
            this.container = $('#chatbot-container');
            this.toggle = $('#chatbot-toggle');
            this.close = $('#chatbot-close');
            this.messages = $('#chatbot-messages');
            this.input = $('#chatbot-input');
            this.send = $('#chatbot-send');

            this.base_url = AppHelpers.base_url;
            this.csrfToken = $('meta[name="csrf-token"]').attr('content');
            this.hasProducts = false; // Track if products were found in current conversation

            console.log('Chatbot initialized');

            this.setupEventListeners();
            this.showWelcomeMessage();
        },

        setupEventListeners: function() {
            var self = this;

            // Toggle chat
            this.toggle.on('click', function(e) {
                e.preventDefault();
                self.toggleChat();
            });

            // Close chat
            this.close.on('click', function(e) {
                e.preventDefault();
                self.hideChat();
            });

            // Send message on button click
            this.send.on('click', function(e) {
                e.preventDefault();
                self.sendMessage();
            });

            // Send message on Enter key
            this.input.on('keydown', function(e) {
                if (e.keyCode === 13 && !e.shiftKey) {
                    e.preventDefault();
                    self.sendMessage();
                    return false;
                }
                return true;
            });

            // Handle suggestion clicks
            $(document).on('click', '.suggestion-chip', function(e) {
                e.preventDefault();
                var suggestion = $(this).data('suggestion');
                if (suggestion) {
                    self.input.val(suggestion);
                    self.sendMessage();
                }
            });
        },

        toggleChat: function() {
            this.container.toggleClass('active');
            if (this.container.hasClass('active')) {
                this.input.focus();
            }
        },

        hideChat: function() {
            this.container.removeClass('active');
        },

        sendMessage: function() {
            var message = this.input.val().trim();
            if (message) {
                this.addMessage(message, 'user');
                this.input.val('');
                this.showTypingIndicator();
                this.hasProducts = false; // Reset product flag for new message
                this.sendToBot(message);
            }
        },

        sendToBot: function(message) {
            var self = this;
            var url = this.base_url + '/botman';

            // Use URL encoded form data
            var formData = new URLSearchParams();
            formData.append('message', message);
            formData.append('driver', 'web');
            formData.append('_token', this.csrfToken);

            axios.post(url, formData, {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                timeout: 30000 // 30 second timeout
            })
            .then(function(response) {
                console.log('Bot response received:', response.data);
                self.handleBotResponse(response.data);
            })
            .catch(function(error) {
                console.error('Request error:', error);
                self.handleBotError(error);
            });
        },

        handleBotResponse: function(responseData) {
            this.removeTypingIndicator();

            if (!responseData) {
                this.addMessage('Sorry, I received an empty response. Please try again.', 'bot');
                return;
            }

            // Process all messages
            if (Array.isArray(responseData)) {
                var self = this;
                responseData.forEach(function(messageObj) {
                    self.processSingleMessage(messageObj);
                });
            } else if (responseData.messages && Array.isArray(responseData.messages)) {
                var self = this;
                responseData.messages.forEach(function(messageObj) {
                    self.processSingleMessage(messageObj);
                });
            } else if (responseData.type === 'message' || responseData.text) {
                this.processSingleMessage(responseData);
            }

            // If no products were found in this response, show the search suggestion
            if (!this.hasProducts) {
                this.maybeShowNoProductsMessage();
            }
        },

        processSingleMessage: function(messageObj) {
            if (messageObj.text && messageObj.text.startsWith('PRODUCT_CARD:')) {
                try {
                    var jsonStr = messageObj.text.replace('PRODUCT_CARD:', '');
                    var productData = JSON.parse(jsonStr);
                    this.displayProductCard(productData);
                    this.hasProducts = true; // Mark that products were found
                } catch (e) {
                    console.error('Error parsing product data:', e);
                }
            } else if (messageObj.text) {
                // Don't show certain messages if products were found
                if (!this.hasProducts || !this.isRedundantMessage(messageObj.text)) {
                    this.addMessage(messageObj.text, 'bot');
                }
            }
        },

        // Check if message is redundant when products are shown
        isRedundantMessage: function(text) {
            const redundantPatterns = [
                /found \d+ product/i,
                /products between/i,
                /products matching/i,
                /sorry.*no product/i
            ];

            return redundantPatterns.some(pattern => pattern.test(text));
        },

        // Show "no products found" message if appropriate
        maybeShowNoProductsMessage: function() {
            // Check if the last message was a search-related message without products
            var lastMessage = this.messages.find('.bot-message .message-content').last();

            if (lastMessage.length && (
                lastMessage.text().includes('search') ||
                lastMessage.text().includes('find') ||
                lastMessage.text().includes('product')
            )) {
                this.showNoProductsMessage();
            }
        },

        showNoProductsMessage: function() {
            var noProductsMsg = $('<div>').addClass('no-products-message').html(
                'I couldn\'t find any products matching your search. ' +
                'Please try <a href="' + this.base_url + '/products" class="search-website-link" target="_blank">searching on our website</a> ' +
                'for more options.'
            );

            this.messages.append(noProductsMsg);
            this.scrollToBottom();
        },

        handleBotError: function(error) {
            this.removeTypingIndicator();

            var errorMessage = 'Sorry, there was an error processing your request. ';

            if (error.response && error.response.status === 419) {
                errorMessage += 'Please refresh the page and try again.';
            } else if (error.code === 'ECONNABORTED') {
                errorMessage = 'The request took too long. Please try again.';
            } else {
                errorMessage += 'Please try again later.';
            }

            this.addMessage(errorMessage, 'bot');
        },

        addMessage: function(text, type) {
            var messageDiv = $('<div>').addClass('message ' + type + '-message');

            if (type === 'bot') {
                var avatar = $('<div>').addClass('message-avatar').html(
                    '<svg viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/></svg>'
                );
                messageDiv.append(avatar);
            }

            var content = $('<div>').addClass('message-content').text(text);
            messageDiv.append(content);

            this.messages.append(messageDiv);
            this.scrollToBottom();
        },

        displayProductCard: function(product) {
            var imageUrl = product.image || 'https://via.placeholder.com/80x80?text=No+Image';
            var price = product.price || product.unit_price || 'N/A';
            var description = product.description || product.short_description || 'No description available';
            var link = product.link || this.base_url + '/products';

            var productCard = $('<div>').addClass('product-card').html(
                '<img src="' + imageUrl + '" alt="' + product.name + '" class="product-image" onerror="this.src=\'https://via.placeholder.com/80x80?text=No+Image\'">' +
                '<div class="product-details">' +
                '<h4 class="product-name">' + (product.name || 'Unnamed Product') + '</h4>' +
                '<p class="product-price">$' + price + '</p>' +
                '<p class="product-description">' + (description.length > 70 ? description.substring(0, 70) + '...' : description) + '</p>' +
                '<a href="' + link + '" class="product-link" target="_blank">' +
                '<svg viewBox="0 0 24 24" width="14" height="14"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>' +
                'View Details</a>' +
                '</div>'
            );

            this.messages.append(productCard);
            this.scrollToBottom();
        },

        showTypingIndicator: function() {
            var typingIndicator = $('<div>')
                .addClass('typing-indicator')
                .attr('id', 'typing-indicator')
                .html('<span></span><span></span><span></span>');
            this.messages.append(typingIndicator);
            this.scrollToBottom();
        },

        removeTypingIndicator: function() {
            $('#typing-indicator').remove();
        },

        scrollToBottom: function() {
            // Smooth scroll to bottom
            setTimeout(function() {
                var messages = document.getElementById('chatbot-messages');
                if (messages) {
                    messages.scrollTo({
                        top: messages.scrollHeight,
                        behavior: 'smooth'
                    });
                }
            }, 100);
        },

        showWelcomeMessage: function() {
            var self = this;
            setTimeout(function() {
                var welcomeMsg = $('<div>').addClass('message bot-message');
                var avatar = $('<div>').addClass('message-avatar').html(
                    '<svg viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/></svg>'
                );
                welcomeMsg.append(avatar);

                var content = $('<div>').addClass('message-content welcome-message').html(
                    'Hello! 👋 I\'m your product assistant. <strong>Please type the product name you\'re searching for</strong>, ' +
                    'or ask me about products by price range.'
                );
                welcomeMsg.append(content);

                self.messages.append(welcomeMsg);
                self.scrollToBottom();
                self.showSuggestions();
            }, 1000);
        },

        showSuggestions: function() {
            var suggestions = $('<div>').addClass('chat-suggestions');

            var suggestionChips = [
                'Show me products under $50',
                'Find shoes',
                'Search for electronics',
                'Laptops under $1000'
            ];

            var self = this;
            $.each(suggestionChips, function(index, chipText) {
                var chip = $('<button>')
                    .addClass('suggestion-chip')
                    .text(chipText)
                    .attr('data-suggestion', chipText);
                suggestions.append(chip);
            });

            this.messages.append(suggestions);
            this.scrollToBottom();
        }
    };

    // Initialize chatbot when document is ready
    if ($('#chatbot-container').length && $('#chatbot-toggle').length) {
            window.chatbot = new ProfessionalChatbot();
        }

})(jQuery);
