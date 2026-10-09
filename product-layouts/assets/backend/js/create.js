/**
 * Product Layouts: layout type page (Create New).
 * "Use this design" asks for a name, then sends the design's saved settings
 * (the hidden textarea next to its preview) to wpte_create_new_layout and
 * opens the new layout in the editor.
 */
;(function ($) {

    var $dialog   = $('#wpte-product-layout-create-modal'),
        $form     = $('#wpte-wpl-create-modal-form'),
        $name     = $('#style-name'),
        $status   = $dialog.find('.wpte-wpl-set-dialog-status'),
        lastFocus = null,
        busy      = false;

    if ( ! $dialog.length ) {
        return;
    }

    function setStatus( state ) {
        if ( state ) {
            $status.attr('data-state', state).text( $status.attr('data-' + state) );
        } else {
            $status.removeAttr('data-state').text('');
        }
    }

    function setBusy( on ) {
        busy = on;
        $form.find('button, input').prop('disabled', on);
    }

    function openDialog( trigger ) {
        lastFocus = trigger;
        setStatus('');
        $dialog.prop('hidden', false);
        $('body').addClass('wpte-wpl-set-dialog-open');
        setTimeout(function () {
            $name.trigger('focus')[0].select();
        }, 50);
    }

    function closeDialog() {
        if ( busy ) {
            return;
        }
        $dialog.prop('hidden', true);
        $('body').removeClass('wpte-wpl-set-dialog-open');
        if ( lastFocus ) {
            lastFocus.focus();
        }
    }

    $('.wpte-product-layout-template-create').on('click', function (e) {
        e.preventDefault();
        $('#wptestyledata').val( $(this).attr('layouts-data') );
        $name.val( $(this).attr('data-name') || '' );
        openDialog( this );
    });

    $dialog.on('click', '[data-wpl-close]', closeDialog);
    $(document).on('keydown', function (e) {
        if ( 'Escape' === e.key && ! $dialog.prop('hidden') ) {
            closeDialog();
        }
    });

    $form.on('submit', function (e) {
        e.preventDefault();
        var name = $.trim( $name.val() ),
            data;

        if ( busy ) {
            return;
        }
        if ( ! name ) {
            $name.trigger('focus');
            return;
        }

        // getElementById, not a jQuery selector: the id is only ever looked up, never parsed.
        var source = document.getElementById( $('#wptestyledata').val() );
        try {
            data = source ? JSON.parse( source.value ) : null;
        } catch ( err ) {
            data = null;
        }
        if ( ! data || ! data.style ) {
            setStatus('error');
            return;
        }

        function failed() {
            setBusy( false );
            setStatus('error');
        }

        setBusy( true );
        setStatus('saving');

        $.ajax({
            type: 'POST',
            url : wpteLayout.ajaxUrl,
            data: {
                action: 'wpte_create_new_layout',
                _nonce: wpteLayout.wpte_nonce,
                name: name,
                style_name: data.style.style_name,
                rawdata: data.style.rawdata,
                stylesheet: data.style.stylesheet,
            }
        }).done(function ( response ) {
            if ( response && response.success && response.data && response.data.url ) {
                setStatus('saved');
                document.location.href = response.data.url;
                return;
            }
            failed();
        }).fail( failed );
    });

})(jQuery);
