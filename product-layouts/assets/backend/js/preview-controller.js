/**
 * Preview Controller
 * Manages iframe-based preview with device switching and live style updates
 *
 * @package product-layouts
 * @since 1.3.7
 */

(function($) {
    'use strict';

    window.PreviewController = {
        iframe: null,
        iframeDoc: null,
        iframeWindow: null,
        currentDevice: 'desktop',
        isIframeReady: false,
        resizeObserver: null,
        styleCache: {
            desktop: '',
            tablet: '',
            mobile: ''
        },
        pendingStyles: [],

        /**
         * Initialize the preview controller
         */
        init: function() {
            this.iframe = document.getElementById('wpte-preview-iframe');
            
            if (!this.iframe) {
                console.warn('Preview iframe not found');
                return;
            }

            this.bindEvents();
            this.waitForIframeLoad();
        },

        /**
         * Wait for iframe to load completely
         */
        waitForIframeLoad: function() {
            const self = this;
            
            $(this.iframe).on('load', function() {
                try {
                    self.iframeWindow = self.iframe.contentWindow;
                    self.iframeDoc = self.iframe.contentDocument || self.iframeWindow.document;
                    self.isIframeReady = true;

                    // Initialize cart icons (replace text with icons if needed)
                    self.initializeCartIcons();

                    // Initialize tooltips
                    self.initializeTooltips();

                    // Initialize compare functionality
                    self.initializeCompare();

                    self.applyIframeScrollbarStyles();

                    // Process any pending styles
                    self.processPendingStyles();

                    // Setup resize observer
                    self.setupResizeObserver();
                    
                    // Initial resize
                    self.resizeIframe();
                    if (self.currentDevice === 'mobile' || self.currentDevice === 'tablet') {
                        self.updateMobileTabletViewportHeight();
                    }
                    
                    // Hide the preloader once the iframe and its contents have completely loaded
                    $('.wpte-product-layouts-editor-preloader').addClass('loaded');
                    
                } catch (error) {
                    console.error('Error accessing iframe:', error);
                }
            });
        },

        /**
         * Bind event listeners
         */
        bindEvents: function() {
            // Event binding removed - device buttons are handled in editor.js
            // which calls PreviewController.switchDevice() directly
        },

        /**
         * Switch preview device
         * @param {string} device - desktop, tablet, or mobile
         */
        switchDevice: function(device) {
            if (!device || !['desktop', 'tablet', 'mobile'].includes(device)) {
                console.error('Invalid device:', device);
                return;
            }

            this.currentDevice = device;
            
            // Update wrapper data attribute
            const $wrapper = $('#wpte-preview-wrapper');
           
            if ($wrapper.length) {
                $wrapper.attr('data-device', device);
               } else {
                console.error('Preview wrapper not found!');
            }

            // Update active button state
            $('.wpte-device-btn').removeClass('active');
            $('.wpte-device-btn[data-device="' + device + '"]').addClass('active');

            // Handle main browser scrollbar based on device
            if (device === 'mobile' || device === 'tablet') {
                $('html, body').css('overflow', 'hidden');
                this.updateMobileTabletViewportHeight();
                $('#wpte-preview-wrapper').css({ 'overflow': 'hidden' });
                if (this.iframeDoc && this.iframeDoc.body && this.iframeDoc.documentElement) {
                    this.iframeDoc.documentElement.style.overflow = 'auto';
                    this.iframeDoc.body.style.overflow = 'auto';
                }
                this.applyIframeScrollbarStyles();

            } else {
                $('html, body').css('overflow', '');
                $('#wpte-preview-wrapper').css({ 'height': '', 'overflow': '' });
                if (this.iframe) { this.iframe.style.height = ''; }
                if (this.iframeDoc && this.iframeDoc.body && this.iframeDoc.documentElement) {
                    this.iframeDoc.documentElement.style.overflow = '';
                    this.iframeDoc.body.style.overflow = '';
                }
            }

            this.resizeIframe();
        },

        updateMobileTabletViewportHeight: function() {
            const $wrapper = $('#wpte-preview-wrapper');
            if (!$wrapper.length) return;
            // Calculate available height from current viewport to bottom
            const rect = $wrapper[0].getBoundingClientRect();
            const viewportH = window.innerHeight || document.documentElement.clientHeight;
            // Reserve 16px buffer to avoid overlap with page footer/edges
            const available = Math.max(200, Math.floor(viewportH - rect.top - 16));
            $wrapper.css('height', available + 'px');
            if (this.iframe) {
                this.iframe.style.height = available + 'px';
            }
        },

        applyIframeScrollbarStyles: function() {
            if (!this.iframeDoc) { return; }
            try {
                var style = this.iframeDoc.getElementById('wpte-iframe-scrollbar-style');
                if (!style) {
                    style = this.iframeDoc.createElement('style');
                    style.id = 'wpte-iframe-scrollbar-style';
                    style.type = 'text/css';
                    style.textContent = ''
                        + 'html,body{scrollbar-gutter:stable both-edges;scrollbar-width:thin;scrollbar-color:transparent transparent;}'
                        + 'html:hover,body:hover{scrollbar-color:#555 transparent;}'
                        + '::-webkit-scrollbar{width:8px;height:8px;}'
                        + '::-webkit-scrollbar-track{background:transparent;}'
                        + '::-webkit-scrollbar-thumb{background-color:transparent;border-radius:4px;}'
                        + 'html:hover::-webkit-scrollbar-thumb,body:hover::-webkit-scrollbar-thumb{background-color:#555;}';
                    this.iframeDoc.head.appendChild(style);
                }
            } catch (e) {}
        },
        /**
         * Setup resize observer for iframe content
         */
        setupResizeObserver: function() {
            if (!this.isIframeReady || !this.iframeDoc) {
                return;
            }

            // Disconnect existing observer if any
            if (this.resizeObserver) {
                this.resizeObserver.disconnect();
            }

            const self = this;
            
            try {
                // Create new ResizeObserver
                this.resizeObserver = new ResizeObserver(entries => {
                    // We only care about the first entry (body)
                    self.resizeIframe();
                });

                // Observe the body of the iframe
                if (this.iframeDoc.body) {
                    this.resizeObserver.observe(this.iframeDoc.body);
                }

            } catch (error) {
                console.warn('ResizeObserver not supported or error:', error);
            }
        },

        /**
         * Resize iframe to fit visible area (for all devices)
         * The iframe stays at the wrapper's visible height and scrolls its own content internally.
         * This ensures position:fixed modals inside the iframe work correctly.
         */
        resizeIframe: function() {
            if (!this.iframe || !this.iframeDoc) {
                return;
            }

            // Disconnect observer temporarily to prevent loops
            if (this.resizeObserver) {
                this.resizeObserver.disconnect();
            }

            if (this.currentDevice === 'desktop') {
                // Keep iframe at wrapper's visible height — iframe scrolls internally
                const $wrapper = $('#wpte-preview-wrapper');
                if ($wrapper.length) {
                    const available = $wrapper[0].clientHeight;
                    if (available > 0) {
                        this.iframe.style.height = available + 'px';
                    } else {
                        this.iframe.style.height = '100%';
                    }
                } else {
                    this.iframe.style.height = '100%';
                }

                // Re-enable the resize observer for content changes
                this.setupResizeObserver();
            } else {
                // For mobile/tablet, reset to default behavior (handled by updateMobileTabletViewportHeight)
                this.iframe.style.height = '';

                // Restore scrollbars
                if (this.iframeDoc.body) {
                    this.iframeDoc.body.style.overflow = '';
                }
                if (this.iframeDoc.documentElement) {
                    this.iframeDoc.documentElement.style.overflow = '';
                }
            }
        },

        /**
         * Inject styles into iframe
         * @param {string} css - CSS property value
         * @param {string} selector - CSS selector
         * @param {string} responsive - desktop, tablet, or mobile
         */
        injectStyles: function(css, selector, responsive) {

            if (!this.isIframeReady) {
                // Queue styles if iframe not ready
                this.pendingStyles.push({ css: css, selector: selector, responsive: responsive });
                return;
            }

            // Normalize device to supported types
            let device = responsive;
            if (device !== 'tablet' && device !== 'mobile') {
                device = 'desktop';
            }

            let styleString = '';

            // Build CSS string based on device
            if (device === 'tablet') {
                styleString = '@media only screen and (min-width: 669px) and (max-width: 993px) { ' + 
                             selector + ' { ' + css + ' } }';
            } else if (device === 'mobile') {
                styleString = '@media only screen and (max-width: 668px) { ' + 
                             selector + ' { ' + css + ' } }';
            } else {
                styleString = selector + ' { ' + css + ' }';
            }

            // Append to device cache
            this.styleCache[device] += styleString + '\n';

            // Update iframe styles
            this.updateIframeStyles();
        },

        /**
         * Process pending styles after iframe loads
         */
        processPendingStyles: function() {
            if (this.pendingStyles.length === 0) {
                return;
            }
            this.pendingStyles.forEach(function(style) {
                this.injectStyles(style.css, style.selector, style.responsive);
            }, this);

            this.pendingStyles = [];
        },

        /**
         * Update iframe styles by injecting cached CSS
         */
        updateIframeStyles: function() {
            if (!this.isIframeReady || !this.iframeDoc) {
                return;
            }

            try {
                let styleTag = this.iframeDoc.getElementById('pl-dynamic-styles');
                
                if (!styleTag) {
                    styleTag = this.iframeDoc.createElement('style');
                    styleTag.id = 'pl-dynamic-styles';
                    this.iframeDoc.head.appendChild(styleTag);
                }

                // Combine all device styles
                const allStyles = this.styleCache.desktop + 
                                 this.styleCache.tablet + 
                                 this.styleCache.mobile;

                styleTag.textContent = allStyles;

            } catch (error) {
                console.error('Error updating iframe styles:', error);
            }
        },

        /**
         * Update element classes in iframe
         * @param {string} selector - CSS selector
         * @param {Array} removeClasses - Array of classes to remove
         * @param {string} addClass - Class to add
         */
        updateClasses: function(selector, removeClasses, addClass) {
            if (!this.isIframeReady || !this.iframeDoc) {
                return;
            }

            try {
                const $elements = $(this.iframeDoc).find(selector);
                
                if ($elements.length) {
                    // Remove classes
                    if (removeClasses && removeClasses.length) {
                        removeClasses.forEach(function(cls) {
                            $elements.removeClass(cls);
                        });
                    }
                    
                    // Add class
                    if (addClass) {
                        $elements.addClass(addClass);
                    }
                } else {
                    console.warn('PreviewController: Element not found for class update:', selector);
                }
            } catch (error) {
                console.error('Error updating classes:', error);
            }
        },

        /**
         * Update iframe content inner HTML
         * @param {string} html - New HTML content
         */
        updateContent: function(html) {
            if (!this.isIframeReady || !this.iframeDoc) {
                return;
            }

            try {
                // Find the product container in the iframe
                // Using a broad selector to catch the wrapper
                const $container = $(this.iframeDoc).find('.wpte-product-load');
                
                if ($container.length) {
                    $container.html(html);
                   
                    // Re-initialize cart icons after content update
                    this.initializeCartIcons();

                    // Re-initialize tooltips
                    this.initializeTooltips();

                    // Re-initialize compare functionality
                    this.initializeCompare();

                    // Re-initialize any scripts if needed (like sliders)
                    // This might require triggering a custom event in the iframe
                    $(this.iframeDoc).trigger('wpte_preview_updated');
                } else {
                    console.warn('PreviewController: Content container .wpte-product-load not found');
                }
            } catch (error) {
                console.error('Error updating iframe content:', error);
            }
        },

        /**
         * Update element HTML in iframe
         * @param {string} selector - CSS selector
         * @param {string} html - HTML content
         */
        updateHtml: function(selector, html) {
            if (!this.isIframeReady || !this.iframeDoc) {
                return;
            }

            try {
                const $elements = $(this.iframeDoc).find(selector);
                
                if ($elements.length) {
                    $elements.html(html);
                } else {
                    console.warn('PreviewController: Element not found for HTML update:', selector);
                }
            } catch (error) {
                console.error('Error updating HTML:', error);
            }
        },

        /**
         * Update element attribute in iframe
         * @param {string} selector - CSS selector
         * @param {string} attr - Attribute name
         * @param {string} value - Attribute value
         */
        updateAttribute: function(selector, attr, value) {
            if (!this.isIframeReady || !this.iframeDoc) {
                return;
            }

            try {
                const $elements = $(this.iframeDoc).find(selector);
                
                if ($elements.length) {
                    $elements.attr(attr, value);
                } else {
                    // console.warn('PreviewController: Element not found for attribute update:', selector);
                }
            } catch (error) {
                console.error('Error updating attribute:', error);
            }
        },

        /**
         * Initialize cart icons in iframe (replacing text with icons if needed)
         */
        initializeCartIcons: function() {
            if (!this.isIframeReady || !this.iframeDoc) {
                return;
            }

            try {
                const $doc = $(this.iframeDoc);
                
                if ($doc.find(".wpte-product-add-cart-icon").hasClass('wpte-cart-icon')) {
                    const $iconContainer = $doc.find(".wpte-product-add-cart-icon");
                    const cart_icon = $iconContainer.attr('add_cart');
                    const groupde_icon = $iconContainer.attr('groupde_icon');
                    const external_icon = $iconContainer.attr('external_icon');
                    const variable_icon = $iconContainer.attr('variable_icon');
                    
                    $doc.find(".wpte-product-add-cart-icon .ajax_add_to_cart").html(`<i class='${cart_icon}'></i>`);
                    $doc.find(".wpte-product-add-cart-icon .product_type_simple").html(`<i class='${cart_icon}'></i>`);
                    $doc.find(".wpte-product-add-cart-icon .product_type_grouped").html(`<i class='${groupde_icon}'></i>`);
                    $doc.find(".wpte-product-add-cart-icon .product_type_external").html(`<i class='${external_icon}'></i>`);
                    $doc.find(".wpte-product-add-cart-icon .product_type_variable").html(`<i class='${variable_icon}'></i>`);
                
                } else if ($doc.find('.wpte-product-add-cart-text').hasClass('wpte-cart-text')) {
                    const $textContainer = $doc.find('.wpte-product-add-cart-text');
                    const cart_text = $textContainer.attr('add_cart_text');
                    const groupde_text = $textContainer.attr('groupde_text');
                    const external_text = $textContainer.attr('external_text');
                    const variable_text = $textContainer.attr('variable_text');

                    $doc.find(".wpte-product-add-cart-text .ajax_add_to_cart").html(`${cart_text}`);
                    $doc.find(".wpte-product-add-cart-text .product_type_simple").html(`${cart_text}`);
                    $doc.find(".wpte-product-add-cart-text .product_type_grouped").html(`${groupde_text}`);
                    $doc.find(".wpte-product-add-cart-text .product_type_external").html(`${external_text}`);
                    $doc.find(".wpte-product-add-cart-text .product_type_variable").html(`${variable_text}`);
                
                } else {
                    const $bothContainer = $doc.find(".wpte-product-add-cart-icon-text");
                    const cart_icon = $bothContainer.attr('add_cart');
                    const groupde_icon = $bothContainer.attr('groupde_icon');
                    const external_icon = $bothContainer.attr('external_icon');
                    const variable_icon = $bothContainer.attr('variable_icon');
                    const cart_text = $bothContainer.attr('add_cart_text');
                    const groupde_text = $bothContainer.attr('groupde_text');
                    const external_text = $bothContainer.attr('external_text');
                    const variable_text = $bothContainer.attr('variable_text');

                    $doc.find(".wpte-product-add-cart-icon-text .ajax_add_to_cart").html(`<i class='${cart_icon}'></i><span class='wpte-cart-text'>${cart_text}</span>`);
                    $doc.find(".wpte-product-add-cart-icon-text .product_type_simple").html(`<i class='${cart_icon}'></i><span class='wpte-cart-text'>${cart_text}</span>`);
                    $doc.find(".wpte-product-add-cart-icon-text .product_type_grouped").html(`<i class='${groupde_icon}'></i><span class='wpte-groupde-text'>${groupde_text}</span>`);
                    $doc.find(".wpte-product-add-cart-icon-text .product_type_external").html(`<i class='${external_icon}'></i><span class='wpte-external-text'>${external_text}</span>`);
                    $doc.find(".wpte-product-add-cart-icon-text .product_type_variable").html(`<i class='${variable_icon}'></i><span class='wpte-variable-text'>${variable_text}</span>`);
                }

            } catch (error) {
                console.error('Error initializing cart icons:', error);
            }
        },

        /**
         * Initialize tooltips in iframe
         * Adds helper class to parent of tooltip elements
         */
        initializeTooltips: function() {
            if (!this.isIframeReady || !this.iframeDoc) {
                return;
            }

            try {
                const $doc = $(this.iframeDoc);
                
                $doc.find('.wpte-product-tooltip').each(function() {
                    $(this).parent().addClass('wpte-product-tooltip-area');
                });

             } catch (error) {
                console.error('Error initializing tooltips:', error);
            }
        },

        /**
         * Initialize compare functionality in iframe
         */
        initializeCompare: function() {
            if (!this.isIframeReady || !this.iframeDoc) {
                return;
            }

            const self = this;
            const $doc = $(this.iframeDoc);
            const iframeWin = this.iframe.contentWindow;

            // Check if wpteGlobal exists in iframe
            if (!iframeWin || !iframeWin.wpteGlobal) {
                console.warn('PreviewController: wpteGlobal not found in iframe');
                return;
            }

            const wpteGlobal = iframeWin.wpteGlobal;

            // Detach existing handlers to avoid duplicates
            $doc.off('click', '.wpte-product-layouts-compare a');
            $doc.off('click', '.wpte-compare-product-remove');
            $doc.off('click', '.wpte-product-popup-close');

            // Attach Click Handler for Compare Button
            $doc.on('click', '.wpte-product-layouts-compare a', function(e) {
                e.preventDefault();
                
                const $btn = $(this);
                const product_id = $btn.attr('product_id');

                $btn.addClass('loading');

                $.ajax({
                    type: 'POST',
                    url: wpteGlobal.ajaxUrl,
                    data: {
                        action: "wpte_product_compare_popup",
                        _nonce: wpteGlobal.wpte_nonce,
                        product_id: product_id,
                    },
                    success: function (response) {
                        $btn.removeClass('loading');
                        
                        if ( response.data.data ) {
                            const icon = (typeof($btn.attr('compare_added_icon')) != "undefined" && $btn.attr('compare_added_icon') !== null) ? `<i class="${$btn.attr('compare_added_icon')}"></i>` : '';
                            const ctext = (typeof($btn.attr('compare_added_text')) != "undefined" && $btn.attr('compare_added_text') !== null) ? $btn.attr('compare_added_text') : '';
                            
                            // Make sure popup container exists
                            if ($doc.find('.wpte-popup-display').length === 0) {
                                $doc.find('body').append('<div class="wpte-popup-display"></div>');
                            }

                            const $popup = $doc.find('.wpte-popup-display');
                            $popup.addClass('wpte-popup-display-block').html(''); // Clear previous
                            $popup.append(response.data.data);
                            
                            $btn.html( icon + ctext );
                        } else {
                            console.error('Compare Error:', response);
                        }
                    },
                    error: function (err) {
                        $btn.removeClass('loading');
                        console.error('Compare AJAX Error:', err);
                    }
                });
            });

            // Handle Remove Button
            $doc.on('click', '.wpte-compare-product-remove', function(e) {
                e.preventDefault();
                const $btn = $(this);
                const product_id = $btn.attr('product_id');

                $.ajax({
                    type: 'POST',
                    url: wpteGlobal.ajaxUrl,
                    data: {
                        action: "wpte_compare_product_remove",
                        _nonce: wpteGlobal.wpte_nonce,
                        product_id: product_id,
                    },
                    beforeSend: function () {
                        $doc.find('.wpte-remove-'+product_id).css('opacity', '0.6');
                    },
                    success: function (response) {
                        $doc.find('.wpte-remove-'+product_id).hide();
                    }
                });
            });

            // Handle Close Button
            $doc.on('click', '.wpte-product-popup-close', function() {
                $doc.find('.wpte-popup-display').removeClass('wpte-popup-display-block').empty();
            });

          },

        /**
         * Clear all cached styles
         */
        clearStyles: function() {
            this.styleCache = {
                desktop: '',
                tablet: '',
                mobile: ''
            };
            this.updateIframeStyles();
        },

        /**
         * Reload iframe preview
         */
        reloadPreview: function() {
            if (this.iframe) {
                this.isIframeReady = false;
                this.clearStyles();
                this.iframe.src = this.iframe.src;
            }
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        PreviewController.init();
    });

})(jQuery);
