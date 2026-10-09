<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin\Pages;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Brands the Freemius Account page.
 *
 * Freemius renders this page from its own template, so nothing in the SDK
 * is edited. Its "templates/account.php" filter (meant for wrapping the
 * template) adds the plugin header and a scoping wrapper, and
 * assets/backend/css/account.css restyles the page inside that wrapper.
 *
 * @since 1.4.5
 */
class Account {

	/**
	 * Whether billing_and_payments() added the Billing and Payments cards.
	 *
	 * @var bool
	 */
	private $added_billing = false;

	/**
	 * Account class constructor
	 *
	 * @since 1.4.5
	 */
	public function __construct() {
		if ( ! function_exists( 'wpl_fs' ) ) {
			return;
		}
		$fs = wpl_fs();
		// The page only has one tab, so the tab bar adds nothing.
		$fs->add_filter( 'hide_account_tabs', '__return_true' );
		$fs->add_filter( 'templates/account.php', [ $this, 'wrap' ] );
		$fs->add_action( 'after_account_details', [ $this, 'billing_and_payments' ] );
		add_filter( 'admin_body_class', [ $this, 'body_class' ] );
	}

	/**
	 * Show the Billing and Payments cards for every licensed site.
	 *
	 * Freemius only shows them when the connected Freemius user has payments
	 * for this plugin, so a license bought with another account leaves the
	 * page with a single card. This runs inside the card grid, after Account
	 * Details, and adds Freemius' own Billing template (it loads and saves the
	 * address by itself) plus a Payments card with an empty state.
	 *
	 * @return void
	 */
	public function billing_and_payments() {
		$fs = wpl_fs();
		if ( $fs->is_whitelabeled() || $fs->apply_filters( 'hide_billing_and_payments_info', false ) ) {
			return;
		}
		$license = $fs->_get_license();
		if ( ! is_object( $license ) ) {
			return;
		}
		// Same request Freemius made a moment ago, answered from its API cache.
		$payments = $fs->_fetch_payments();
		if ( ! is_array( $payments ) || count( $payments ) > 0 ) {
			// Error: Freemius shows nothing either. Payments: Freemius shows both cards.
			return;
		}

		$this->added_billing = true;
		$slug                = $fs->get_slug();
		$user                = $fs->get_user();
		$other_owner         = is_object( $user ) && (string) $license->user_id !== (string) $user->id;

		// Freemius takes the template params by reference, so they need a variable.
		$view_params = [ 'id' => $fs->get_id() ];
		fs_require_once_template( 'account/billing.php', $view_params );
		?>
		<div class="postbox">
			<div id="fs_payments">
				<h3><span class="dashicons dashicons-paperclip"></span> <?php echo esc_html( fs_text_inline( 'Payments', 'payments', $slug ) ); ?></h3>
				<div class="inside">
					<table class="widefat">
						<thead>
						<tr>
							<th><?php echo esc_html( fs_text_inline( 'ID', 'id', $slug ) ); ?></th>
							<th><?php echo esc_html( fs_text_inline( 'Date', 'date', $slug ) ); ?></th>
							<th><?php echo esc_html( fs_text_inline( 'Amount', 'amount', $slug ) ); ?></th>
							<th><?php echo esc_html( fs_text_inline( 'Invoice', 'invoice', $slug ) ); ?></th>
						</tr>
						</thead>
					</table>
					<p class="wpte-wpl-acc-empty">
						<?php
						if ( $other_owner ) {
							esc_html_e( 'This license was bought with a different account, so its payments and invoices are listed in that account.', 'product-layouts' );
						} else {
							esc_html_e( 'No payments yet.', 'product-layouts' );
						}
						?>
					</p>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Mark the Account page so account.css can make the header full width.
	 *
	 * @param string $classes Admin body classes.
	 * @return string
	 */
	public function body_class( $classes ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( isset( $_GET['page'] ) && 'product-layouts-account' === $_GET['page'] ) {
			$classes .= ' wpte-wpl-account-page';
		}
		return $classes;
	}

	/**
	 * Wrap the Freemius account template.
	 *
	 * @param string $html Rendered Freemius template.
	 * @return string
	 */
	public function wrap( $html ) {
		if ( $this->added_billing ) {
			$html = $this->add_billing_link( $html );
		}

		ob_start();
		// The plugin's header menu, same as on the other Product Layouts pages.
		apply_filters( 'wpte_product_layout_admin_menu', true );

		// account.css shows this label after the version number, as a CSS
		// string, so it needs CSS string escaping before HTML escaping.
		$is_premium = wpte_version_control();
		$label      = '"' . addcslashes( __( 'Premium version', 'product-layouts' ), '"\\' ) . '"';
		?>
		<div class="wpte-wpl-account<?php echo $is_premium ? ' is-premium' : ''; ?>" style="<?php echo esc_attr( '--wpl-premium-label: ' . $label ); ?>">
			<header class="wpte-wpl-acc-hero">
				<img class="wpte-wpl-acc-hero-logo" src="<?php echo esc_url( WPTE_WPL_URL . '/Image/wpl-icon.svg' ); ?>" alt="" width="52" height="52">
				<div class="wpte-wpl-acc-hero-text">
					<h1 class="wpte-wpl-acc-title"><?php esc_html_e( 'Account', 'product-layouts' ); ?></h1>
					<p class="wpte-wpl-acc-subtitle"><?php esc_html_e( 'Your Product Layouts license, billing details and invoices.', 'product-layouts' ); ?></p>
				</div>
				<a class="wpte-wpl-acc-btn" href="<?php echo esc_url( admin_url( 'admin.php?page=product-layouts-settings' ) ); ?>">
					<span class="dashicons dashicons-admin-generic" aria-hidden="true"></span><?php esc_html_e( 'Settings', 'product-layouts' ); ?>
				</a>
			</header>
			<hr class="wp-header-end">
		<?php
		return ob_get_clean() . $html . '</div>';
	}

	/**
	 * Add the "Billing & Invoices" link Freemius shows with its own cards.
	 *
	 * Freemius prints the header actions before after_account_details runs,
	 * so the link goes into the rendered template here instead.
	 *
	 * @param string $html Rendered Freemius template.
	 * @return string
	 */
	private function add_billing_link( $html ) {
		$actions = strpos( $html, '<div class="fs-header-actions">' );
		$list    = false === $actions ? false : strpos( $html, '<ul>', $actions );
		if ( false === $list ) {
			return $html;
		}
		$label = fs_text_inline( 'Billing & Invoices', 'billing-invoices', wpl_fs()->get_slug() );
		$link  = '<li><a href="#fs_billing"><i class="dashicons dashicons-portfolio"></i> ' . esc_html( $label ) . '</a></li><li>&nbsp;&bull;&nbsp;</li>';
		return substr_replace( $html, $link, $list + 4, 0 );
	}
}
