/**
 * Overlay Scrollbar Implementation using OverlayScrollbars library
 * Creates true overlay scrollbars that don't create layout shift
 * Only applied to sidebar — preview area scrolls naturally via iframe
 */
(function($) {
    'use strict';

    $(document).ready(function() {
        if (typeof OverlayScrollbarsGlobal === 'undefined') {
            console.warn('OverlayScrollbars library not loaded. Falling back to standard scrollbar.');
            return;
        }

        const { OverlayScrollbars } = OverlayScrollbarsGlobal;
        
        // Configuration for OverlayScrollbars
        const config = {
            scrollbars: {
                theme: 'os-theme-dark',
                visibility: 'auto',
                autoHide: 'leave',
                autoHideDelay: 100
            },
            overflow: {
                x: 'hidden',
                y: 'scroll'
            }
        };

        // Initialize for editor sidebar only (matches image-hover approach)
        const sidebar = document.querySelector('.wpte-single-settings-card-body-wrapper');
        if (sidebar) {
            OverlayScrollbars(sidebar, config);
        }

        // Initialize for preview iframe body (if we're inside an iframe)
        if (window.self !== window.top) {
            OverlayScrollbars(document.body, {
                ...config,
                cancel: {
                    body: null
                }
            });
        }
    });
    
})(jQuery);
