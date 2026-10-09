<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin\Pages;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Description of Create
 *
 * @author wpkin
 */
class Create {

	/**
	 * Database Parent Table
	 *
	 * @var $parent_table
	 * @since 1.0.0
	 */
	public $parent_table;

	/**
	 * Define $wpdb
	 *
	 * @var $wpdb
	 * @since 1.0.0
	 */
	public $wpdb;

	/**
	 * Define layout
	 *
	 * @var $layouts
	 * @since 1.0.0
	 */
	public $layouts;

	/**
	 * Define $wpltype
	 *
	 * @var $wpltype
	 * @since 1.0.0
	 */
	public $wpltype;

	/**
	 * Define $TEMPLATE
	 *
	 * @var $TEMPLATE
	 * @since 1.0.0
	 */
	public $TEMPLATE = [];

	/**
	 * Create Constructor
	 *
	 * @return void
	 */
	public function __construct() {
		global $wpdb;
		$this->wpdb         = $wpdb;
		$this->parent_table = $wpdb->prefix . 'wpte_product_layout_style';

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$this->layouts = ( ! empty( $_GET['layouts'] ) ? sanitize_text_field( wp_unslash( $_GET['layouts'] ) ) : '' );
		$this->wpltype = $this->layouts . '-layout';
		$this->assets_loader();
		$this->json_data();
		$this->render();
	}

	/**
	 * Assets Loader
	 *
	 * @return void
	 */
	public function assets_loader() {

		wp_enqueue_script( 'wpte-wpl-bootstrap-js' );
		$this->admin_create_js();
		$this->wpte_compare_script_loader();
		$this->wpte_quickview_script_loader();
	}

	/**
	 * Admin Compare script loader
	 *
	 * @since 1.0.1
	 */
	public function wpte_compare_script_loader() {
		wp_enqueue_script( 'wpte-product-compare' );
	}

	/**
	 * QuickView Script Loader
	 *
	 * @return void
	 */
	public function wpte_quickview_script_loader() {
		if ( version_compare( WC()->version, '3.0.0', '>=' ) ) {
			if ( current_theme_supports( 'wc-product-gallery-zoom' ) ) {
				wp_enqueue_script( 'zoom' );
			}
			if ( current_theme_supports( 'wc-product-gallery-slider' ) ) {
				wp_enqueue_script( 'flexslider' );
			}
			wp_enqueue_script( 'wc-add-to-cart-variation' );
			wp_enqueue_script( 'wc-single-product' );
		}

		wp_enqueue_script( 'wpte-quick-view-js' );
	}

	/**
	 * Enqueue create js
	 *
	 * @return void
	 */
	public function admin_create_js() {
		wp_enqueue_script( 'wpte-wpl-admin-js' );
		wp_enqueue_script( 'wpte-wpl-create-js' );
		wp_localize_script(
            'wpte-wpl-create-js', 'wpteLayout', [
				'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
				'wpte_nonce' => wp_create_nonce( 'wpte-new-create-nonce' ),
				'error'      => __( 'Something Went Wrong!', 'product-layouts' ),
			]
        );
		wp_enqueue_script( 'wpte-global-js' );
		wp_localize_script(
            'wpte-global-js', 'wpteGlobal', [
				'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
				'wpte_nonce' => wp_create_nonce( 'wpte-global-nonce' ),
				'error'      => __( 'Something Went Wrong!', 'product-layouts' ),
			]
        );
	}

	/**
	 * Render
	 *
	 * The design previews are the real frontend layouts, rendered exactly as
	 * before; only the page frame around them is this plugin's admin design.
	 *
	 * @return void
	 */
	public function render() {
		apply_filters( 'wpte_product_layout_admin_menu', true );
		?>
		<?php // Quick view in the previews opens inside this element (wpte-quickview.js). ?>
		<div class="wpte-popup-display"></div>
		<div class="wpte-wpl-account wpte-wpl-settings wpte-wpl-lay"
			data-error="<?php esc_attr_e( 'Could not create the layout. Reload the page and try again.', 'product-layouts' ); ?>">
			<?php
				$this->admin_header();
				$this->template();
				$this->create_new();
			?>
		</div>
		<?php
	}

	/**
	 * Links for this layout type (tutorial, docs, demo, icon), read from the
	 * layout picker's list so both pages stay in sync. Built without the
	 * picker's constructor, which would render the picker page.
	 *
	 * @since 1.4.5
	 * @return array
	 */
	private function type_info() {
		try {
			$picker   = ( new \ReflectionClass( ProductLayout::class ) )->newInstanceWithoutConstructor();
			$elements = $picker->elements();
			foreach ( $elements as $group ) {
				if ( isset( $group[ $this->layouts ] ) && is_array( $group[ $this->layouts ] ) ) {
					return $group[ $this->layouts ];
				}
			}
		} catch ( \Throwable $e ) {
			return [];
		}
		return [];
	}

	/**
	 * Readable layout type, e.g. "call_to_action" becomes "Call To Action".
	 *
	 * @since 1.4.5
	 * @return string
	 */
	private function type_label() {
		return ucwords( str_replace( [ '_', '-' ], ' ', (string) $this->layouts ) );
	}

	/**
	 * Whether a design needs Pro on this site.
	 *
	 * Same rule as before the redesign: the design is marked premium, or its
	 * first file carries status_po "p".
	 *
	 * @since 1.4.5
	 * @param array $value Design entry from json_data().
	 * @return bool
	 */
	private function is_locked( $value ) {
		if ( wpte_version_control() ) {
			return false;
		}
		$file = isset( $value['files'][0] ) ? json_decode( $value['files'][0], true ) : [];
		$p    = isset( $file['style'] ) && is_array( $file['style'] ) && array_key_exists( 'status_po', $file['style'] ) ? $file['style']['status_po'] : '';
		return ( isset( $value['status'] ) && 'premium' === $value['status'] ) || 'p' === $p;
	}

	/**
	 * Get JSON DATA
	 *
	 * @return void
	 */
	public function json_data() {
	}

	/**
	 * Admin Header
	 *
	 * @return void
	 */
	public function admin_header() {
		$info  = $this->type_info();
		$count = count( $this->TEMPLATE );
		$icon  = ! empty( $info['icon'] ) ? $info['icon'] : WPTE_WPL_URL . '/Image/wpl-icon.svg';
		$links = [
			'video' => [ __( 'Tutorial', 'product-layouts' ), 'video-alt3' ],
			'doc'   => [ __( 'Docs', 'product-layouts' ), 'media-document' ],
			'demo'  => [ __( 'Live demo', 'product-layouts' ), 'visibility' ],
		];
		?>
		<header class="wpte-wpl-acc-hero">
			<img class="wpte-wpl-acc-hero-logo" src="<?php echo esc_url( $icon ); ?>" alt="" width="52" height="52">
			<div class="wpte-wpl-acc-hero-text">
				<h1 class="wpte-wpl-acc-title">
					<?php
					/* translators: %s: layout type, e.g. "General" */
					echo esc_html( sprintf( __( '%s layouts', 'product-layouts' ), $this->type_label() ) );
					?>
					<span class="wpte-wpl-lay-count">
						<?php
						/* translators: %s: number of designs */
						echo esc_html( sprintf( _n( '%s design', '%s designs', $count, 'product-layouts' ), number_format_i18n( $count ) ) );
						?>
					</span>
				</h1>
				<p class="wpte-wpl-acc-subtitle"><?php esc_html_e( 'Pick a design to start from. You can change products, colors and everything else in the editor afterwards.', 'product-layouts' ); ?></p>
				<?php
				$has_links = false;
				foreach ( array_keys( $links ) as $key ) {
					$has_links = $has_links || ! empty( $info[ $key ] );
				}
				if ( $has_links ) :
					?>
					<p class="wpte-wpl-lay-links">
						<?php foreach ( $links as $key => $link ) : ?>
							<?php if ( ! empty( $info[ $key ] ) ) : ?>
								<a href="<?php echo esc_url( $info[ $key ] ); ?>" target="_blank" rel="noopener">
									<span class="dashicons dashicons-<?php echo esc_attr( $link[1] ); ?>" aria-hidden="true"></span><?php echo esc_html( $link[0] ); ?>
								</a>
							<?php endif; ?>
						<?php endforeach; ?>
					</p>
				<?php endif; ?>
			</div>
			<a class="wpte-wpl-set-btn" href="<?php echo esc_url( admin_url( 'admin.php?page=product-layouts' ) ); ?>">
				<span class="dashicons dashicons-arrow-left-alt" aria-hidden="true"></span><?php esc_html_e( 'All layout types', 'product-layouts' ); ?>
			</a>
		</header>
		<hr class="wp-header-end">
		<?php
	}

	/**
	 * Templates
	 *
	 * @return void
	 */
	public function template() {
		?>
		<div class="wpte-wpl-lay-list">
			<?php
			foreach ( $this->TEMPLATE as $key => $value ) {
				$id     = explode( '-', $key )[1];
				$locked = $this->is_locked( $value );
				?>
				<section class="wpte-wpl-set-card wpte-wpl-lay-card<?php echo $locked ? ' is-locked' : ''; ?>" id="<?php echo esc_attr( $key ); ?>">
					<div class="wpte-wpl-lay-head">
						<div class="wpte-wpl-lay-title">
							<h2><?php echo esc_html( $value['name'] ); ?></h2>
							<?php if ( $locked ) : ?>
								<span class="wpte-wpl-set-pill is-pro"><span class="dashicons dashicons-lock" aria-hidden="true"></span><?php esc_html_e( 'Pro', 'product-layouts' ); ?></span>
							<?php endif; ?>
						</div>
						<?php if ( $locked ) : ?>
							<button type="button" class="wpte-wpl-set-btn wpte-product-layout-premium wpte-po-element">
								<span class="dashicons dashicons-unlock" aria-hidden="true"></span><?php esc_html_e( 'Get Pro', 'product-layouts' ); ?>
							</button>
						<?php else : ?>
							<button type="button" class="wpte-wpl-set-btn is-primary wpte-product-layout-template-create" layouts-data="wptestyle<?php echo esc_attr( $id ); ?>data" data-name="<?php echo esc_attr( $value['name'] ); ?>">
								<span class="dashicons dashicons-plus-alt2" aria-hidden="true"></span><?php esc_html_e( 'Use this design', 'product-layouts' ); ?>
							</button>
						<?php endif; ?>
					</div>
					<?php // Unchanged preview markup: the real frontend layout with its saved demo settings. ?>
					<div class="wpte-product-style-preview-top wpte-product-center">
						<?php
						foreach ( $value['files'] as $file_data ) {
							$decode_data = json_decode( $file_data, true );
							$s           = explode( '-', $decode_data['style']['style_name'] );
							echo '<div class="wpte-bt-col-lg-4 wpte-bt-col-md-6 wpte-bt-col-sm-12 p-3">';

							$CLASS = 'WPTE_PRODUCT_LAYOUT\Layouts\\' . ucfirst( $s[0] ) . '\Frontend\Layout' . $s[1];

							if ( class_exists( $CLASS ) ) :
								new $CLASS( $decode_data['style'] );
							else :
								printf( '<div class="wpte_product_layout_premium_img"><img src="%s"/></div>', esc_url( $value['src'] ) );
							endif;

							echo '<textarea style="display:none" id="wptestyle' . esc_attr( $id ) . 'data">' . esc_html( htmlentities( wp_json_encode( $decode_data ) ) ) . '</textarea>';
							echo '</div>';
						}
						?>
					</div>
				</section>
				<?php
			}
			?>
		</div>
		<?php
	}

	/**
	 * Create New Layout
	 *
	 * @return void
	 */
	public function create_new() {
		?>
		<div class="wpte-wpl-set-dialog" id="wpte-product-layout-create-modal" hidden>
			<div class="wpte-wpl-set-dialog-backdrop" data-wpl-close></div>
			<form class="wpte-wpl-set-dialog-box" method="post" id="wpte-wpl-create-modal-form" role="dialog" aria-modal="true" aria-labelledby="wpte-wpl-create-title">
				<span class="wpte-wpl-set-dialog-icon is-brand dashicons dashicons-plus-alt2" aria-hidden="true"></span>
				<h2 class="wpte-wpl-set-dialog-title" id="wpte-wpl-create-title"><?php esc_html_e( 'New product layout', 'product-layouts' ); ?></h2>
				<p class="wpte-wpl-set-dialog-text"><?php esc_html_e( 'Give it a name you will recognize in the Shortcode List. The editor opens next.', 'product-layouts' ); ?></p>
				<label class="wpte-wpl-set-dialog-label" for="style-name"><?php esc_html_e( 'Name', 'product-layouts' ); ?></label>
				<input class="wpte-wpl-set-input" type="text" value="" id="style-name" name="style-name" maxlength="50" required autocomplete="off">
				<input type="hidden" id="wptestyledata" name="wptestyledata" value="">
				<p class="wpte-wpl-set-dialog-status" role="status" aria-live="polite"
					data-saving="<?php esc_attr_e( 'Creating your layout', 'product-layouts' ); ?>"
					data-saved="<?php esc_attr_e( 'Created. Opening the editor.', 'product-layouts' ); ?>"
					data-error="<?php esc_attr_e( 'Could not create the layout. Reload the page and try again.', 'product-layouts' ); ?>"></p>
				<div class="wpte-wpl-set-dialog-actions">
					<button type="button" class="wpte-wpl-set-btn" data-wpl-close><?php esc_html_e( 'Cancel', 'product-layouts' ); ?></button>
					<button type="submit" class="wpte-wpl-set-btn is-primary" id="addonsdatasubmit"><?php esc_html_e( 'Create layout', 'product-layouts' ); ?></button>
				</div>
			</form>
		</div>
		<?php
	}
}



