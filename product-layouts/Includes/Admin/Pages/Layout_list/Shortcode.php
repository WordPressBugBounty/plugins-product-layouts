<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin\Pages\Layout_list;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shortcode List Class
 *
 * Laid out like the Flipbox list page. Every layout is printed once and
 * shortcodes.js does the search, page size and pagination in the browser,
 * so a search covers all layouts, not just the current page.
 *
 * @since 1.0.0
 */
class Shortcode {

	/**
	 * Shortcode Constructor
	 *
	 * @return void
	 */
	public function __construct() {
		$this->shortcodes();
		$this->loader();
	}

	/**
	 * Script Loader
	 *
	 * Delete and clone reuse the plugin's existing AJAX actions and nonces.
	 *
	 * @return void
	 */
	public function loader() {
		wp_enqueue_script( 'wpte-wpl-shortcodes', WPTE_WPL_ASSETS . 'backend/js/shortcodes.js', [ 'jquery' ], filemtime( WPTE_WPL_PATH . 'assets/backend/js/shortcodes.js' ), true );
		wp_localize_script(
			'wpte-wpl-shortcodes',
			'wpteShortcodes',
			[
				'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
				'deleteNonce'  => wp_create_nonce( 'wpte-delete-nonce' ),
				'createNonce'  => wp_create_nonce( 'wpte-new-create-nonce' ),
			]
		);
	}

	/**
	 * All layouts, newest first.
	 *
	 * @return array
	 */
	private function layouts() {
		global $wpdb;
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		return (array) $wpdb->get_results( "SELECT id, name, style_name FROM {$wpdb->prefix}wpte_product_layout_style ORDER BY id DESC" );
	}

	/**
	 * Display everything in shortcode page
	 *
	 * @return void
	 */
	public function shortcodes() {
		$layouts    = $this->layouts();
		$create_url = admin_url( 'admin.php?page=product-layouts' );
		$import_url = admin_url( 'admin.php?page=product-layouts-shortcode&action=import' );
		?>
		<div class="wpte-wpl-account wpte-wpl-settings wpte-wpl-shortcodes"
			data-copied="<?php esc_attr_e( 'Copied', 'product-layouts' ); ?>"
			data-copy-failed="<?php esc_attr_e( 'Press Ctrl+C to copy', 'product-layouts' ); ?>"
			<?php /* translators: 1: first row shown, 2: last row shown, 3: total rows */ ?>
			data-info="<?php esc_attr_e( 'Showing %1$s to %2$s of %3$s', 'product-layouts' ); ?>"
			data-info-empty="<?php esc_attr_e( 'No layouts match your search.', 'product-layouts' ); ?>">

			<header class="wpte-wpl-acc-hero">
				<img class="wpte-wpl-acc-hero-logo" src="<?php echo esc_url( WPTE_WPL_URL . '/Image/wpl-icon.svg' ); ?>" alt="" width="52" height="52">
				<div class="wpte-wpl-acc-hero-text">
					<h1 class="wpte-wpl-acc-title">
						<?php esc_html_e( 'Shortcodes', 'product-layouts' ); ?>
						<span class="wpte-wpl-sc-count"><?php echo esc_html( number_format_i18n( count( $layouts ) ) ); ?></span>
					</h1>
					<p class="wpte-wpl-acc-subtitle"><?php esc_html_e( 'Copy a shortcode into any page or post, or edit, clone, export and delete your layouts.', 'product-layouts' ); ?></p>
				</div>
				<div class="wpte-wpl-sc-hero-actions">
					<a class="wpte-wpl-set-btn" href="<?php echo esc_url( $import_url ); ?>">
						<span class="dashicons dashicons-upload" aria-hidden="true"></span><?php esc_html_e( 'Import', 'product-layouts' ); ?>
					</a>
					<a class="wpte-wpl-set-btn is-primary" href="<?php echo esc_url( $create_url ); ?>">
						<span class="dashicons dashicons-plus-alt2" aria-hidden="true"></span><?php esc_html_e( 'Create new', 'product-layouts' ); ?>
					</a>
				</div>
			</header>
			<hr class="wp-header-end">

			<?php
			if ( empty( $layouts ) ) {
				$this->empty_state( $create_url, $import_url );
			} else {
				$this->layout_table( $layouts );
			}
			$this->dialogs();
			?>
		</div>
		<?php
	}

	/**
	 * The list of layouts.
	 *
	 * @param array $layouts Rows with id, name and style_name.
	 */
	private function layout_table( $layouts ) {
		?>
		<section class="wpte-wpl-set-card wpte-wpl-sc-card">
			<div class="wpte-wpl-sc-toolbar">
				<label class="wpte-wpl-sc-search">
					<span class="screen-reader-text"><?php esc_html_e( 'Search layouts', 'product-layouts' ); ?></span>
					<span class="dashicons dashicons-search" aria-hidden="true"></span>
					<input type="search" id="wpte-wpl-sc-search" placeholder="<?php esc_attr_e( 'Search layouts', 'product-layouts' ); ?>" autocomplete="off">
				</label>
				<label class="wpte-wpl-sc-per-page">
					<select class="wpte-wpl-set-select" id="wpte-wpl-sc-per-page">
						<option value="10">10</option>
						<option value="25">25</option>
						<option value="50">50</option>
						<option value="0"><?php esc_html_e( 'All', 'product-layouts' ); ?></option>
					</select>
					<span><?php esc_html_e( 'per page', 'product-layouts' ); ?></span>
				</label>
			</div>

			<table class="wpte-wpl-sc-table">
				<thead>
					<tr>
						<th scope="col"><?php esc_html_e( 'Name', 'product-layouts' ); ?></th>
						<th scope="col"><?php esc_html_e( 'Shortcode', 'product-layouts' ); ?></th>
						<th scope="col" class="wpte-wpl-sc-actions-col"><span class="screen-reader-text"><?php esc_html_e( 'Actions', 'product-layouts' ); ?></span></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ( $layouts as $layout ) :
						$id         = (int) $layout->id;
						$type       = explode( '-', $layout->style_name )[0];
						// "general-1" becomes "General 1", as the old Templates column showed it.
						$template   = ucwords( str_replace( [ '-', '_' ], ' ', $layout->style_name ) );
						$shortcode  = '[wpte_product_layout id="' . $id . '"]';
						$php        = "<?php echo do_shortcode('" . $shortcode . "'); ?>";
						$edit_url   = admin_url( 'admin.php?page=product-layouts&layouts=' . rawurlencode( $type ) . '&styleid=' . $id );
						$export_url = admin_url( 'admin.php?page=product-layouts-shortcode&action=export&id=' . $id );
						?>
						<tr data-id="<?php echo esc_attr( $id ); ?>" data-name="<?php echo esc_attr( $layout->name ); ?>" data-search="<?php echo esc_attr( strtolower( $layout->name . ' ' . $template . ' #' . $id ) ); ?>">
							<td class="wpte-wpl-sc-name">
								<a class="wpte-wpl-sc-title" href="<?php echo esc_url( $edit_url ); ?>"><?php echo esc_html( $layout->name ); ?></a>
								<span class="wpte-wpl-sc-meta">
									<span class="wpte-wpl-sc-id">#<?php echo esc_html( $id ); ?></span>
									<span class="wpte-wpl-sc-template"><?php echo esc_html( $template ); ?></span>
								</span>
							</td>
							<td class="wpte-wpl-sc-code-cell">
								<div class="wpte-wpl-sc-code">
									<code><?php echo esc_html( $shortcode ); ?></code>
									<button type="button" class="wpte-wpl-sc-copy" data-copy="<?php echo esc_attr( $shortcode ); ?>" aria-label="<?php esc_attr_e( 'Copy shortcode', 'product-layouts' ); ?>">
										<span class="dashicons dashicons-admin-page" aria-hidden="true"></span><span class="wpte-wpl-sc-copy-text"><?php esc_html_e( 'Copy', 'product-layouts' ); ?></span>
									</button>
								</div>
								<button type="button" class="wpte-wpl-sc-copy-php" data-copy="<?php echo esc_attr( $php ); ?>">
									<span class="wpte-wpl-sc-copy-text"><?php esc_html_e( 'Copy PHP code', 'product-layouts' ); ?></span>
								</button>
							</td>
							<td class="wpte-wpl-sc-actions">
								<div class="wpte-wpl-sc-actions-wrap">
									<?php /* translators: %s: layout name */ ?>
									<a class="wpte-wpl-sc-action is-edit" href="<?php echo esc_url( $edit_url ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Edit %s', 'product-layouts' ), $layout->name ) ); ?>">
										<span class="dashicons dashicons-edit" aria-hidden="true"></span><?php esc_html_e( 'Edit', 'product-layouts' ); ?>
									</a>
									<?php /* translators: %s: layout name */ ?>
									<button type="button" class="wpte-wpl-sc-action is-clone" aria-label="<?php echo esc_attr( sprintf( __( 'Clone %s', 'product-layouts' ), $layout->name ) ); ?>">
										<span class="dashicons dashicons-admin-page" aria-hidden="true"></span><?php esc_html_e( 'Clone', 'product-layouts' ); ?>
									</button>
									<?php /* translators: %s: layout name */ ?>
									<a class="wpte-wpl-sc-action is-export" href="<?php echo esc_url( $export_url ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Export %s', 'product-layouts' ), $layout->name ) ); ?>">
										<span class="dashicons dashicons-download" aria-hidden="true"></span><?php esc_html_e( 'Export', 'product-layouts' ); ?>
									</a>
									<?php /* translators: %s: layout name */ ?>
									<button type="button" class="wpte-wpl-sc-action is-delete" aria-label="<?php echo esc_attr( sprintf( __( 'Delete %s', 'product-layouts' ), $layout->name ) ); ?>">
										<span class="dashicons dashicons-trash" aria-hidden="true"></span><?php esc_html_e( 'Delete', 'product-layouts' ); ?>
									</button>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<p class="wpte-wpl-sc-no-match" hidden><?php esc_html_e( 'No layouts match your search.', 'product-layouts' ); ?></p>

			<div class="wpte-wpl-sc-footer">
				<span class="wpte-wpl-sc-info" aria-live="polite"></span>
				<nav class="wpte-wpl-sc-pages" aria-label="<?php esc_attr_e( 'Pages', 'product-layouts' ); ?>"
					data-prev="<?php esc_attr_e( 'Previous', 'product-layouts' ); ?>"
					data-next="<?php esc_attr_e( 'Next', 'product-layouts' ); ?>"></nav>
			</div>
		</section>
		<?php
	}

	/**
	 * Shown when there are no layouts yet.
	 *
	 * @param string $create_url Layout picker.
	 * @param string $import_url Import page.
	 */
	private function empty_state( $create_url, $import_url ) {
		?>
		<section class="wpte-wpl-set-card wpte-wpl-sc-empty">
			<span class="wpte-wpl-sc-empty-icon dashicons dashicons-screenoptions" aria-hidden="true"></span>
			<h2 class="wpte-wpl-set-card-title"><?php esc_html_e( 'No layouts yet', 'product-layouts' ); ?></h2>
			<p class="wpte-wpl-set-card-sub"><?php esc_html_e( 'Pick a layout type and a design, and its shortcode will appear here ready to copy.', 'product-layouts' ); ?></p>
			<div class="wpte-wpl-set-actions">
				<a class="wpte-wpl-set-btn is-primary" href="<?php echo esc_url( $create_url ); ?>">
					<span class="dashicons dashicons-plus-alt2" aria-hidden="true"></span><?php esc_html_e( 'Create your first layout', 'product-layouts' ); ?>
				</a>
				<a class="wpte-wpl-set-btn" href="<?php echo esc_url( $import_url ); ?>">
					<span class="dashicons dashicons-upload" aria-hidden="true"></span><?php esc_html_e( 'Import a JSON file', 'product-layouts' ); ?>
				</a>
			</div>
		</section>
		<?php
	}

	/**
	 * Clone and Delete dialogs.
	 */
	private function dialogs() {
		?>
		<div class="wpte-wpl-set-dialog" id="wpte-wpl-clone-dialog" hidden>
			<div class="wpte-wpl-set-dialog-backdrop" data-wpl-close></div>
			<form class="wpte-wpl-set-dialog-box" id="wpte-wpl-clone-form" role="dialog" aria-modal="true" aria-labelledby="wpte-wpl-clone-title">
				<span class="wpte-wpl-set-dialog-icon is-brand dashicons dashicons-admin-page" aria-hidden="true"></span>
				<h2 class="wpte-wpl-set-dialog-title" id="wpte-wpl-clone-title"><?php esc_html_e( 'Clone layout', 'product-layouts' ); ?></h2>
				<p class="wpte-wpl-set-dialog-text"><?php esc_html_e( 'Makes a copy with the same design and settings, then opens it in the editor.', 'product-layouts' ); ?></p>
				<label class="wpte-wpl-set-dialog-label" for="wpte-wpl-clone-name"><?php esc_html_e( 'Name for the copy', 'product-layouts' ); ?></label>
				<input type="text" class="wpte-wpl-set-input" id="wpte-wpl-clone-name" maxlength="50" required data-suffix="<?php esc_attr_e( 'copy', 'product-layouts' ); ?>">
				<input type="hidden" id="wpte-wpl-clone-id" value="">
				<p class="wpte-wpl-set-dialog-status" role="status" aria-live="polite"
					data-saving="<?php esc_attr_e( 'Cloning', 'product-layouts' ); ?>"
					data-error="<?php esc_attr_e( 'Could not clone. Reload the page and try again.', 'product-layouts' ); ?>"></p>
				<div class="wpte-wpl-set-dialog-actions">
					<button type="button" class="wpte-wpl-set-btn" data-wpl-close><?php esc_html_e( 'Cancel', 'product-layouts' ); ?></button>
					<button type="submit" class="wpte-wpl-set-btn is-primary"><?php esc_html_e( 'Clone', 'product-layouts' ); ?></button>
				</div>
			</form>
		</div>

		<div class="wpte-wpl-set-dialog" id="wpte-wpl-delete-sc-dialog" hidden>
			<div class="wpte-wpl-set-dialog-backdrop" data-wpl-close></div>
			<div class="wpte-wpl-set-dialog-box" role="alertdialog" aria-modal="true" aria-labelledby="wpte-wpl-delete-sc-title" aria-describedby="wpte-wpl-delete-sc-desc">
				<span class="wpte-wpl-set-dialog-icon dashicons dashicons-trash" aria-hidden="true"></span>
				<?php /* translators: %s: layout name */ ?>
				<h2 class="wpte-wpl-set-dialog-title" id="wpte-wpl-delete-sc-title" data-template="<?php esc_attr_e( 'Delete %s?', 'product-layouts' ); ?>"></h2>
				<div id="wpte-wpl-delete-sc-desc">
					<p class="wpte-wpl-set-dialog-text"><?php esc_html_e( 'Pages that use this shortcode will show nothing in its place. This cannot be undone.', 'product-layouts' ); ?></p>
					<p class="wpte-wpl-sc-dialog-code"><code></code></p>
				</div>
				<p class="wpte-wpl-set-dialog-status" role="status" aria-live="polite"
					data-saving="<?php esc_attr_e( 'Deleting', 'product-layouts' ); ?>"
					data-error="<?php esc_attr_e( 'Could not delete. Reload the page and try again.', 'product-layouts' ); ?>"></p>
				<div class="wpte-wpl-set-dialog-actions">
					<button type="button" class="wpte-wpl-set-btn" data-wpl-close><?php esc_html_e( 'Cancel', 'product-layouts' ); ?></button>
					<button type="button" class="wpte-wpl-set-btn is-danger-solid" id="wpte-wpl-delete-sc-submit"><?php esc_html_e( 'Delete', 'product-layouts' ); ?></button>
				</div>
			</div>
		</div>
		<?php
	}
}
