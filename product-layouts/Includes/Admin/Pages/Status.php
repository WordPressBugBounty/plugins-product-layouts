<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin\Pages;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Status Class
 *
 * @since 1.1.7
 */
class Status {

	/**
	 * Minimum max_input_vars the layout editor needs to save every setting.
	 */
	const MIN_INPUT_VARS = 1200;

	/**
	 * Status Constructor
	 *
	 * @since 1.1.7
	 */
	public function __construct() {
		$this->wpte_product_layouts_status();
	}

	/**
	 * Requirement checks: each has the value found here and the minimum.
	 *
	 * @since 1.4.5
	 * @return array
	 */
	private function requirements() {
		global $wp_version;

		$wc_version = defined( 'WC_VERSION' ) ? WC_VERSION : '';
		$input_vars = (int) ini_get( 'max_input_vars' );

		return [
			[
				'label' => __( 'WordPress version', 'product-layouts' ),
				'value' => $wp_version,
				/* translators: %s: minimum version number */
				'need'  => sprintf( __( '%s or newer', 'product-layouts' ), WPTE_WPL_MINIMUM_WP_VERSION ),
				'ok'    => version_compare( $wp_version, WPTE_WPL_MINIMUM_WP_VERSION, '>=' ),
				/* translators: %s: minimum version number */
				'fix'   => sprintf( __( 'Update WordPress to %s or newer.', 'product-layouts' ), WPTE_WPL_MINIMUM_WP_VERSION ),
			],
			[
				'label' => __( 'PHP version', 'product-layouts' ),
				'value' => PHP_VERSION,
				/* translators: %s: minimum version number */
				'need'  => sprintf( __( '%s or newer', 'product-layouts' ), WPTE_WPL_MINIMUM_PHP_VERSION ),
				'ok'    => version_compare( PHP_VERSION, WPTE_WPL_MINIMUM_PHP_VERSION, '>=' ),
				/* translators: %s: minimum version number */
				'fix'   => sprintf( __( 'Ask your host to update PHP to %s or newer.', 'product-layouts' ), WPTE_WPL_MINIMUM_PHP_VERSION ),
			],
			[
				'label' => __( 'WooCommerce version', 'product-layouts' ),
				'value' => '' !== $wc_version ? $wc_version : __( 'Not active', 'product-layouts' ),
				/* translators: %s: minimum version number */
				'need'  => sprintf( __( '%s or newer', 'product-layouts' ), WPTE_WPL_MINIMUM_WC_VERSION ),
				'ok'    => '' !== $wc_version && version_compare( $wc_version, WPTE_WPL_MINIMUM_WC_VERSION, '>=' ),
				/* translators: %s: minimum version number */
				'fix'   => sprintf( __( 'Install or update WooCommerce to %s or newer.', 'product-layouts' ), WPTE_WPL_MINIMUM_WC_VERSION ),
			],
			[
				'label' => 'max_input_vars',
				'value' => (string) $input_vars,
				/* translators: %s: minimum number */
				'need'  => sprintf( __( '%s or more', 'product-layouts' ), self::MIN_INPUT_VARS ),
				'ok'    => $input_vars >= self::MIN_INPUT_VARS,
				/* translators: %s: minimum number */
				'fix'   => sprintf( __( 'Ask your host to raise max_input_vars to %s or more, or the layout editor may not save every setting.', 'product-layouts' ), self::MIN_INPUT_VARS ),
			],
		];
	}

	/**
	 * Environment details. "key" is the exact setting a value comes from,
	 * shown under the label so support can tell the memory limits apart.
	 *
	 * @since 1.4.5
	 * @return array
	 */
	private function environment() {
		$pro = wpte_version_control();

		return [
			[
				'label' => __( 'Site URL', 'product-layouts' ),
				'key'   => '',
				'value' => get_site_url(),
			],
			[
				'label' => __( 'Product Layouts', 'product-layouts' ),
				'key'   => '',
				'value' => WPTE_WPL_VERSION . ( $pro ? ' (Pro)' : ' (Free)' ),
			],
			[
				// WP_CACHE loads the advanced-cache.php drop-in that page cache plugins use.
				'label' => __( 'Page cache', 'product-layouts' ),
				'key'   => 'WP_CACHE',
				'value' => WP_CACHE ? __( 'Enabled', 'product-layouts' ) : __( 'Disabled', 'product-layouts' ),
			],
			[
				'label' => __( 'PHP memory limit', 'product-layouts' ),
				'key'   => 'memory_limit',
				'value' => (string) ini_get( 'memory_limit' ),
			],
			[
				'label' => __( 'WordPress memory limit', 'product-layouts' ),
				'key'   => 'WP_MEMORY_LIMIT',
				'value' => WP_MEMORY_LIMIT,
			],
			[
				'label' => __( 'WordPress admin memory limit', 'product-layouts' ),
				'key'   => 'WP_MAX_MEMORY_LIMIT',
				'value' => WP_MAX_MEMORY_LIMIT,
			],
		];
	}

	/**
	 * System Status.
	 *
	 * @since 1.1.7
	 */
	public function wpte_product_layouts_status() {
		$requirements = $this->requirements();
		$environment  = $this->environment();
		$failed       = count( array_filter( array_column( $requirements, 'ok' ), function ( $ok ) {
			return ! $ok;
		} ) );

		// Plain-text copy for support requests.
		$report = "### Product Layouts System Status ###\n\n";
		foreach ( $requirements as $row ) {
			$report .= $row['label'] . ': ' . $row['value'] . ( $row['ok'] ? '' : ' (needs ' . $row['need'] . ')' ) . "\n";
		}
		$report .= "\n";
		foreach ( $environment as $row ) {
			$report .= $row['label'] . ( $row['key'] ? ' [' . $row['key'] . ']' : '' ) . ': ' . $row['value'] . "\n";
		}
		?>
		<div class="wpte-wpl-account wpte-wpl-status">
			<header class="wpte-wpl-acc-hero">
				<img class="wpte-wpl-acc-hero-logo" src="<?php echo esc_url( WPTE_WPL_URL . '/Image/wpl-icon.svg' ); ?>" alt="" width="52" height="52">
				<div class="wpte-wpl-acc-hero-text">
					<h1 class="wpte-wpl-acc-title"><?php esc_html_e( 'System Status', 'product-layouts' ); ?></h1>
					<p class="wpte-wpl-acc-subtitle"><?php esc_html_e( 'Check that this site meets what Product Layouts needs, and copy the details for a support request.', 'product-layouts' ); ?></p>
				</div>
				<?php if ( 0 === $failed ) : ?>
					<span class="wpte-wpl-status-badge is-ok">
						<span class="dashicons dashicons-yes-alt" aria-hidden="true"></span><?php esc_html_e( 'All checks passed', 'product-layouts' ); ?>
					</span>
				<?php else : ?>
					<span class="wpte-wpl-status-badge is-warn">
						<span class="dashicons dashicons-warning" aria-hidden="true"></span>
						<?php
						/* translators: %d: number of failed checks */
						echo esc_html( sprintf( _n( '%d check needs attention', '%d checks need attention', $failed, 'product-layouts' ), $failed ) );
						?>
					</span>
				<?php endif; ?>
				<button type="button" class="wpte-wpl-acc-btn" id="wpte-wpl-copy-report" data-done="<?php esc_attr_e( 'Copied', 'product-layouts' ); ?>">
					<span class="dashicons dashicons-clipboard" aria-hidden="true"></span><span class="wpte-wpl-copy-label"><?php esc_html_e( 'Copy report', 'product-layouts' ); ?></span>
				</button>
			</header>
			<hr class="wp-header-end">

			<div class="wpte-wpl-status-grid">
				<section class="wpte-wpl-status-card">
					<h2 class="wpte-wpl-status-card-title">
						<span class="dashicons dashicons-yes-alt" aria-hidden="true"></span><?php esc_html_e( 'Requirements', 'product-layouts' ); ?>
					</h2>
					<ul class="wpte-wpl-status-list">
						<?php foreach ( $requirements as $row ) : ?>
							<li class="wpte-wpl-status-row <?php echo $row['ok'] ? 'is-ok' : 'is-warn'; ?>">
								<span class="wpte-wpl-status-icon dashicons <?php echo $row['ok'] ? 'dashicons-yes' : 'dashicons-warning'; ?>" aria-hidden="true"></span>
								<span class="wpte-wpl-status-name">
									<strong><?php echo esc_html( $row['label'] ); ?></strong>
									<?php /* translators: %s: requirement, e.g. "6.2 or newer" */ ?>
									<small><?php echo esc_html( sprintf( __( 'Requires %s', 'product-layouts' ), $row['need'] ) ); ?></small>
									<?php if ( ! $row['ok'] ) : ?>
										<em><?php echo esc_html( $row['fix'] ); ?></em>
									<?php endif; ?>
								</span>
								<span class="wpte-wpl-status-value"><?php echo esc_html( $row['value'] ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</section>

				<section class="wpte-wpl-status-card">
					<h2 class="wpte-wpl-status-card-title">
						<span class="dashicons dashicons-admin-site-alt3" aria-hidden="true"></span><?php esc_html_e( 'Environment', 'product-layouts' ); ?>
					</h2>
					<ul class="wpte-wpl-status-list">
						<?php foreach ( $environment as $row ) : ?>
							<li class="wpte-wpl-status-row">
								<span class="wpte-wpl-status-name">
									<strong><?php echo esc_html( $row['label'] ); ?></strong>
									<?php if ( $row['key'] ) : ?>
										<code><?php echo esc_html( $row['key'] ); ?></code>
									<?php endif; ?>
								</span>
								<span class="wpte-wpl-status-value"><?php echo esc_html( $row['value'] ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</section>
			</div>

			<textarea id="wpte-wpl-status-report" class="screen-reader-text" readonly tabindex="-1" aria-hidden="true"><?php echo esc_textarea( $report ); ?></textarea>
		</div>
		<script>
			( function () {
				var button = document.getElementById( 'wpte-wpl-copy-report' );
				var report = document.getElementById( 'wpte-wpl-status-report' );
				if ( ! button || ! report ) {
					return;
				}
				var label = button.querySelector( '.wpte-wpl-copy-label' );
				var text  = label.textContent;
				function done() {
					label.textContent = button.getAttribute( 'data-done' );
					button.classList.add( 'is-done' );
					setTimeout( function () {
						label.textContent = text;
						button.classList.remove( 'is-done' );
					}, 2000 );
				}
				button.addEventListener( 'click', function () {
					if ( navigator.clipboard && window.isSecureContext ) {
						navigator.clipboard.writeText( report.value ).then( done );
						return;
					}
					report.select();
					document.execCommand( 'copy' );
					done();
				} );
			} )();
		</script>
		<?php
	}
}
