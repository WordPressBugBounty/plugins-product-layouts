/**
 * Product Layouts: Shortcode List page.
 * Search, page size and pagination run in the browser over every layout;
 * copy, clone and delete use the plugin's existing AJAX actions.
 */
;(function ($) {
	$(function () {
		var $root = $('.wpte-wpl-shortcodes');
		if ( ! $root.length ) {
			return;
		}

		var $rows    = $root.find('.wpte-wpl-sc-table tbody tr'),
			$search  = $('#wpte-wpl-sc-search'),
			$perPage = $('#wpte-wpl-sc-per-page'),
			$pages   = $root.find('.wpte-wpl-sc-pages'),
			$info    = $root.find('.wpte-wpl-sc-info'),
			$noMatch = $root.find('.wpte-wpl-sc-no-match'),
			page     = 1;

		// Search, page size and pagination.
		function render() {
			var term    = $.trim( $search.val() ).toLowerCase(),
				size    = parseInt( $perPage.val(), 10 ) || 0,
				matches = $rows.filter(function () {
					return ! term || -1 !== this.getAttribute('data-search').indexOf( term );
				}),
				total   = matches.length,
				pages   = size ? Math.max( 1, Math.ceil( total / size ) ) : 1;

			page = Math.min( page, pages );
			var start = size ? ( page - 1 ) * size : 0,
				end   = size ? Math.min( start + size, total ) : total;

			$rows.attr('hidden', true);
			matches.slice( start, end ).removeAttr('hidden');
			$noMatch.prop('hidden', total > 0);
			$root.find('.wpte-wpl-sc-table').toggleClass('is-empty', 0 === total);

			$info.text( total ? $root.attr('data-info').replace('%1$s', start + 1).replace('%2$s', end).replace('%3$s', total) : '' );

			$pages.empty();
			if ( pages > 1 ) {
				$pages.append( pageButton( $pages.attr('data-prev'), page - 1, 1 === page, 'is-prev' ) );
				for ( var i = 1; i <= pages; i++ ) {
					$pages.append( pageButton( String( i ), i, false, i === page ? 'is-current' : '' ) );
				}
				$pages.append( pageButton( $pages.attr('data-next'), page + 1, pages === page, 'is-next' ) );
			}
		}

		function pageButton( label, target, disabled, cls ) {
			return $('<button type="button" class="wpte-wpl-sc-page"></button>')
				.addClass( cls )
				.text( label )
				.attr('data-page', target)
				.attr('aria-current', 'is-current' === cls ? 'page' : null)
				.prop('disabled', disabled);
		}

		$search.on('input', function () {
			page = 1;
			render();
		});
		$perPage.on('change', function () {
			page = 1;
			render();
		});
		$pages.on('click', '.wpte-wpl-sc-page', function () {
			page = parseInt( $(this).attr('data-page'), 10 );
			render();
			$root.find('.wpte-wpl-sc-card')[0].scrollIntoView({ block: 'start', behavior: 'smooth' });
		});
		render();

		// Copy shortcode / PHP code.
		function copyText( text ) {
			if ( navigator.clipboard && window.isSecureContext ) {
				return navigator.clipboard.writeText( text );
			}
			return new Promise(function ( resolve, reject ) {
				var $tmp = $('<textarea readonly>').val( text ).css({ position: 'fixed', top: '-1000px' }).appendTo('body'),
					ok   = false;
				$tmp[0].select();
				try {
					ok = document.execCommand('copy');
				} catch ( e ) {
					ok = false;
				}
				$tmp.remove();
				return ok ? resolve() : reject();
			});
		}

		$root.on('click', '[data-copy]', function () {
			var $btn     = $(this),
				$label   = $btn.find('.wpte-wpl-sc-copy-text'),
				original = $btn.data('label') || $label.text();
			$btn.data('label', original);
			clearTimeout( $btn.data('timer') );
			copyText( $btn.attr('data-copy') ).then(function () {
				$btn.addClass('is-copied');
				$label.text( $root.attr('data-copied') );
			}, function () {
				$label.text( $root.attr('data-copy-failed') );
			});
			$btn.data('timer', setTimeout(function () {
				$btn.removeClass('is-copied');
				$label.text( original );
			}, 1800));
		});

		// Dialogs.
		var lastFocus = null,
			busy      = false;

		function openDialog( id, trigger ) {
			var $dialog = $('#' + id);
			lastFocus = trigger || null;
			setStatus( $dialog, '' );
			$dialog.prop('hidden', false);
			$('body').addClass('wpte-wpl-set-dialog-open');
			setTimeout(function () {
				var $focus = $dialog.find('input[type=text], .is-danger-solid').first();
				$focus.trigger('focus');
				if ( $focus.is('input[type=text]') ) {
					$focus[0].select();
				}
			}, 50);
		}

		function closeDialog() {
			if ( busy ) {
				return;
			}
			$root.find('.wpte-wpl-set-dialog').prop('hidden', true);
			$('body').removeClass('wpte-wpl-set-dialog-open');
			if ( lastFocus ) {
				lastFocus.focus();
			}
		}

		function setStatus( $dialog, state ) {
			var $status = $dialog.find('.wpte-wpl-set-dialog-status');
			if ( state ) {
				$status.attr('data-state', state).text( $status.attr('data-' + state) );
			} else {
				$status.removeAttr('data-state').text('');
			}
		}

		function setBusy( $dialog, on ) {
			busy = on;
			$dialog.find('button, input').prop('disabled', on);
		}

		$root.on('click', '[data-wpl-close]', closeDialog);
		$(document).on('keydown', function ( e ) {
			if ( 'Escape' === e.key && $root.find('.wpte-wpl-set-dialog:not([hidden])').length ) {
				closeDialog();
			}
		});

		// Clone: read the layout, then create a copy under the new name.
		var $clone = $('#wpte-wpl-clone-dialog');

		$root.on('click', '.wpte-wpl-sc-action.is-clone', function () {
			var $row  = $(this).closest('tr'),
				$name = $('#wpte-wpl-clone-name');
			$('#wpte-wpl-clone-id').val( $row.attr('data-id') );
			$name.val( ( $row.attr('data-name') + ' ' + $name.attr('data-suffix') ).substring( 0, 50 ) );
			openDialog( 'wpte-wpl-clone-dialog', this );
		});

		$('#wpte-wpl-clone-form').on('submit', function ( e ) {
			e.preventDefault();
			var name = $.trim( $('#wpte-wpl-clone-name').val() );
			if ( ! name || busy ) {
				return;
			}

			function failed() {
				setBusy( $clone, false );
				setStatus( $clone, 'error' );
			}

			setBusy( $clone, true );
			setStatus( $clone, 'saving' );

			$.post( wpteShortcodes.ajaxUrl, {
				action: 'wpte_clone_layout',
				_nonce: wpteShortcodes.createNonce,
				id: $('#wpte-wpl-clone-id').val()
			}, null, 'text').done(function ( text ) {
				var source;
				try {
					source = JSON.parse( text ).style;
				} catch ( err ) {
					failed();
					return;
				}
				if ( ! source || ! source.style_name ) {
					failed();
					return;
				}
				$.post( wpteShortcodes.ajaxUrl, {
					action: 'wpte_create_new_layout',
					_nonce: wpteShortcodes.createNonce,
					name: name,
					style_name: source.style_name,
					rawdata: source.rawdata,
					stylesheet: source.stylesheet
				}).done(function ( response ) {
					if ( response && response.success && response.data && response.data.url ) {
						document.location.href = response.data.url;
						return;
					}
					failed();
				}).fail( failed );
			}).fail( failed );
		});

		// Delete.
		var $delete    = $('#wpte-wpl-delete-sc-dialog'),
			$deleteRow = null;

		$root.on('click', '.wpte-wpl-sc-action.is-delete', function () {
			var $title = $('#wpte-wpl-delete-sc-title');
			$deleteRow = $(this).closest('tr');
			$title.text( $title.attr('data-template').replace('%s', '“' + $deleteRow.attr('data-name') + '”') );
			$delete.find('.wpte-wpl-sc-dialog-code code').text( $deleteRow.find('.wpte-wpl-sc-code code').text() );
			openDialog( 'wpte-wpl-delete-sc-dialog', this );
		});

		$('#wpte-wpl-delete-sc-submit').on('click', function () {
			if ( ! $deleteRow || busy ) {
				return;
			}

			function failed() {
				setBusy( $delete, false );
				setStatus( $delete, 'error' );
			}

			setBusy( $delete, true );
			setStatus( $delete, 'saving' );

			// The handler prints nothing on success; admin-ajax prints "0" when it refuses.
			$.post( wpteShortcodes.ajaxUrl, {
				action: 'wpte_delete_shortcode',
				_nonce: wpteShortcodes.deleteNonce,
				id: $deleteRow.attr('data-id')
			}, null, 'text').done(function ( text ) {
				if ( '' !== $.trim( text ) ) {
					failed();
					return;
				}
				setBusy( $delete, false );
				lastFocus = null;
				closeDialog();

				var $count = $root.find('.wpte-wpl-sc-count'),
					left   = Math.max( 0, parseInt( $count.text().replace(/\D/g, ''), 10 ) - 1 ),
					row    = $deleteRow;
				$count.text( left );
				$deleteRow = null;
				if ( 0 === left ) {
					window.location.reload();
					return;
				}
				row.addClass('is-removing');
				setTimeout(function () {
					$rows = $rows.not( row );
					row.remove();
					render();
				}, 250);
			}).fail( failed );
		});
	});
})(jQuery);
