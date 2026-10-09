;(function($){

	var $page = $('.wpte-wpl-settings');
	if ( ! $page.length ) {
		return;
	}

	var timers = {};

	// The wpte_settings_form action replaces the whole wpte_pl_settings
	// option, so every save sends all fields, not just the one that changed.
	// Disabled (Pro only) selects are read too, so their saved values stay.
	function collect() {
		return [
			{ name: 'wpte_google_font', value: $('#wpte_google_font').is(':checked') ? 'yes' : 'no' },
			{ name: 'wpte-settings-category-select', value: $('#wpte-settings-category-select').val() || '' },
			{ name: 'wpte-settings-filter-select', value: $('#wpte-settings-filter-select').val() || '' }
		];
	}

	function setStatus( name, state ) {
		var $status = $page.find('[data-status-for="' + name + '"]');
		clearTimeout( timers[ name ] );
		$status.attr('data-state', state).text( $page.data( state ) );
		if ( 'saved' === state ) {
			timers[ name ] = setTimeout(function () {
				$status.removeAttr('data-state').text('');
			}, 2000);
		}
	}

	function save( name ) {
		setStatus( name, 'saving' );
		$.ajax({
			type: 'POST',
			url: wpteSettings.ajaxUrl,
			data: {
				action: 'wpte_settings_form',
				_nonce: wpteSettings.wpte_nonce,
				data: collect()
			}
		}).done(function ( response ) {
			setStatus( name, response && response.success ? 'saved' : 'error' );
		}).fail(function () {
			setStatus( name, 'error' );
		});
	}

	// Danger zone switch: its own option and AJAX action, not part of wpte_pl_settings.
	function saveOwn( input ) {
		setStatus( input.id, 'saving' );
		$.ajax({
			type: 'POST',
			url: wpteSettings.ajaxUrl,
			data: {
				action: $(input).data('action'),
				_nonce: wpteSettings.wpte_nonce,
				value: input.checked ? 'yes' : 'no'
			}
		}).done(function ( response ) {
			setStatus( input.id, response && response.success ? 'saved' : 'error' );
		}).fail(function () {
			setStatus( input.id, 'error' );
		});
	}

	$('#wpte-settings-form').on('change', 'input[type="checkbox"], select', function () {
		if ( $(this).data('action') ) {
			saveOwn( this );
		} else {
			save( this.name );
		}
	}).on('submit', function ( e ) {
		e.preventDefault();
	});

	// Danger zone: "Delete all data" asks for DELETE to be typed first.
	var $dialog       = $('#wpte-wpl-delete-dialog'),
		$confirm      = $('#wpte-wpl-delete-confirm'),
		$submit       = $('#wpte-wpl-delete-submit'),
		$dialogStatus = $dialog.find('.wpte-wpl-set-dialog-status'),
		lastFocus     = null,
		deleting      = false;

	function openDialog( trigger ) {
		lastFocus = trigger;
		$confirm.val('');
		$submit.prop('disabled', true);
		$dialogStatus.removeAttr('data-state').text('');
		$dialog.prop('hidden', false);
		$('body').addClass('wpte-wpl-set-dialog-open');
		setTimeout(function () {
			$confirm.trigger('focus');
		}, 50);
	}

	function closeDialog() {
		if ( deleting ) {
			return;
		}
		$dialog.prop('hidden', true);
		$('body').removeClass('wpte-wpl-set-dialog-open');
		if ( lastFocus ) {
			lastFocus.focus();
		}
	}

	$page.on('click', '[data-wpl-open]', function () {
		openDialog( this );
	});

	$dialog.on('click', '[data-wpl-close]', closeDialog);

	$(document).on('keydown', function ( e ) {
		if ( 'Escape' === e.key && ! $dialog.prop('hidden') ) {
			closeDialog();
		}
	});

	$confirm.on('input', function () {
		$submit.prop('disabled', 'DELETE' !== $confirm.val().trim());
	}).on('keydown', function ( e ) {
		if ( 'Enter' === e.key && ! $submit.prop('disabled') ) {
			$submit.trigger('click');
		}
	});

	$submit.on('click', function () {
		if ( 'DELETE' !== $confirm.val().trim() || deleting ) {
			return;
		}
		deleting = true;
		$submit.prop('disabled', true);
		$confirm.prop('disabled', true);
		$dialogStatus.attr('data-state', 'saving').text( $dialogStatus.data('deleting') );

		function failed() {
			deleting = false;
			$confirm.prop('disabled', false);
			$submit.prop('disabled', false);
			$dialogStatus.attr('data-state', 'error').text( $dialogStatus.data('error') );
		}

		$.ajax({
			type: 'POST',
			url: wpteSettings.ajaxUrl,
			data: {
				action: 'wpte_delete_all_data',
				_nonce: wpteSettings.wpte_nonce,
				confirm: 'DELETE'
			}
		}).done(function ( response ) {
			if ( ! response || ! response.success ) {
				failed();
				return;
			}
			$dialogStatus.attr('data-state', 'saved').text( $dialogStatus.data('done') );
			setTimeout(function () {
				window.location.reload();
			}, 1200);
		}).fail( failed );
	});

	// Copy the category page shortcode.
	$page.on('click', '.wpte-wpl-set-copy-btn', function () {
		var $button = $(this),
			$label  = $button.find('.wpte-wpl-set-copy-label'),
			text    = $label.text(),
			input   = $( $button.data('copy') ).get(0);

		function done() {
			$label.text( $page.data('copied') );
			setTimeout(function () {
				$label.text( text );
			}, 2000);
		}

		if ( navigator.clipboard && window.isSecureContext ) {
			navigator.clipboard.writeText( input.value ).then( done );
		} else {
			input.select();
			document.execCommand('copy');
			done();
		}
	});

})(jQuery);
