<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin\Pages;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Brands the Freemius Affiliation page.
 *
 * Same approach as the Account page: Freemius' "/forms/affiliation.php"
 * filter wraps its template with the plugin header, a hero and a
 * "How it works" card, and assets/backend/css/affiliation.css restyles the
 * template inside that wrapper. The SDK is not edited, so its application
 * form and AJAX submit keep working as shipped.
 *
 * @since 1.4.5
 */
class Affiliation {

	/**
	 * Affiliation class constructor
	 *
	 * @since 1.4.5
	 */
	public function __construct() {
		if ( ! function_exists( 'wpl_fs' ) ) {
			return;
		}
		wpl_fs()->add_filter( '/forms/affiliation.php', [ $this, 'wrap' ] );
		add_filter( 'admin_body_class', [ $this, 'body_class' ] );
	}

	/**
	 * Mark the page so account.css makes the header full width.
	 *
	 * @param string $classes Admin body classes.
	 * @return string
	 */
	public function body_class( $classes ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( isset( $_GET['page'] ) && 'product-layouts-affiliation' === $_GET['page'] ) {
			$classes .= ' wpte-wpl-account-page wpte-wpl-affiliation-page';
		}
		return $classes;
	}

	/**
	 * Wrap the Freemius affiliation template.
	 *
	 * @param string $html Rendered Freemius template.
	 * @return string
	 */
	public function wrap( $html ) {
		$fs        = wpl_fs();
		$terms     = $fs->get_affiliate_terms();
		$affiliate = $fs->get_affiliate();

		// Freemius formats it, e.g. "30%" or "$20".
		$commission = is_object( $terms ) ? $terms->get_formatted_commission() : '';
		$is_active  = is_object( $affiliate ) && $affiliate->is_active();

		ob_start();
		// The plugin's header menu, same as on the other Product Layouts pages.
		apply_filters( 'wpte_product_layout_admin_menu', true );
		?>
		<div class="wpte-wpl-account wpte-wpl-affiliation">
			<header class="wpte-wpl-acc-hero">
				<img class="wpte-wpl-acc-hero-logo" src="<?php echo esc_url( WPTE_WPL_URL . '/Image/wpl-icon.svg' ); ?>" alt="" width="52" height="52">
				<div class="wpte-wpl-acc-hero-text">
					<h1 class="wpte-wpl-acc-title"><?php esc_html_e( 'Affiliate Program', 'product-layouts' ); ?></h1>
					<p class="wpte-wpl-acc-subtitle">
						<?php
						if ( '' !== $commission ) {
							/* translators: %s: commission, e.g. 30% */
							echo esc_html( sprintf( __( 'Recommend Product Layouts and earn %s commission on every sale you refer.', 'product-layouts' ), $commission ) );
						} else {
							esc_html_e( 'Recommend Product Layouts and earn a commission on every sale you refer.', 'product-layouts' );
						}
						?>
					</p>
				</div>
				<?php if ( '' !== $commission ) : ?>
					<div class="wpte-wpl-aff-rate">
						<span class="wpte-wpl-aff-rate-value"><?php echo esc_html( $commission ); ?></span>
						<span class="wpte-wpl-aff-rate-label"><?php esc_html_e( 'commission', 'product-layouts' ); ?></span>
					</div>
				<?php endif; ?>
			</header>
			<hr class="wp-header-end">
			<div class="wpte-wpl-aff-layout">
				<div class="wpte-wpl-aff-main">
		<?php
		$before = ob_get_clean();

		ob_start();
		?>
				</div>
				<aside class="wpte-wpl-aff-aside">
					<div class="wpte-wpl-aff-card">
						<h2 class="wpte-wpl-aff-card-title"><?php esc_html_e( 'How it works', 'product-layouts' ); ?></h2>
						<ol class="wpte-wpl-aff-steps">
							<li>
								<strong><?php esc_html_e( 'Apply', 'product-layouts' ); ?></strong>
								<span><?php esc_html_e( 'Fill in the short application form and accept the program terms.', 'product-layouts' ); ?></span>
							</li>
							<li>
								<strong><?php esc_html_e( 'Get approved', 'product-layouts' ); ?></strong>
								<span><?php esc_html_e( 'We review every application and reply within 14 days.', 'product-layouts' ); ?></span>
							</li>
							<li>
								<strong><?php esc_html_e( 'Share and earn', 'product-layouts' ); ?></strong>
								<span><?php esc_html_e( 'Get your referral link from the affiliate area. Commissions are paid monthly in USD via PayPal.', 'product-layouts' ); ?></span>
							</li>
						</ol>
						<?php if ( $is_active ) : ?>
							<a class="wpte-wpl-acc-btn is-primary" href="https://users.freemius.com/login" target="_blank" rel="noopener">
								<span class="dashicons dashicons-external" aria-hidden="true"></span><?php esc_html_e( 'Open affiliate area', 'product-layouts' ); ?>
							</a>
						<?php endif; ?>
					</div>
				</aside>
			</div>
		</div>
		<?php
		return $before . $html . ob_get_clean();
	}
}
