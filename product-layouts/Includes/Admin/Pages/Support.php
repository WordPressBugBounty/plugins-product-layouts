<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin\Pages;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Support Class
 *
 * @since 1.0.2 -beta
 */
class Support {

	/**
	 * Support Constructor
	 *
	 * @since 1.0.2 -beta
	 */
	public function __construct() {
		$this->wpte_support();
	}

	/**
	 * Help and support links shown as cards.
	 *
	 * @since 1.4.5
	 * @return array
	 */
	private function resources() {
		return [
			[
				'icon'   => 'dashicons-media-document',
				'title'  => __( 'Documentation', 'product-layouts' ),
				'text'   => __( 'Step by step guides for every layout type, the editor settings and the page builder integrations.', 'product-layouts' ),
				'link'   => 'https://oxilab.dev/docs/product-layouts/',
				'button' => __( 'Read the docs', 'product-layouts' ),
			],
			[
				'icon'   => 'dashicons-video-alt3',
				'title'  => __( 'Video Tutorials', 'product-layouts' ),
				'text'   => __( 'Watch how each layout is built, from picking a design to placing it on a page.', 'product-layouts' ),
				'link'   => 'https://www.youtube.com/playlist?list=PLnr-_fYXIk0UrNZ3-xEKeLVtZPFJadOIX',
				'button' => __( 'Watch tutorials', 'product-layouts' ),
			],
			[
				'icon'   => 'dashicons-flag',
				'title'  => __( 'Report a Bug', 'product-layouts' ),
				'text'   => __( 'Found something that does not work as expected? Tell us and help make Product Layouts better.', 'product-layouts' ),
				'link'   => 'https://wordpress.org/support/plugin/product-layouts/',
				'button' => __( 'Report a bug', 'product-layouts' ),
			],
			[
				'icon'   => 'dashicons-sos',
				'title'  => __( 'Get Support', 'product-layouts' ),
				'text'   => __( 'Stuck on something? Ask in the support forum and our developers will help you out.', 'product-layouts' ),
				'link'   => 'https://wordpress.org/support/plugin/product-layouts/',
				'button' => __( 'Get support', 'product-layouts' ),
			],
		];
	}

	/**
	 * Support
	 *
	 * @since 1.0.2 -beta
	 */
	public function wpte_support() {
		$create_url = admin_url( 'admin.php?page=product-layouts' );
		?>
		<div class="wpte-wpl-account wpte-wpl-start">
			<header class="wpte-wpl-acc-hero">
				<img class="wpte-wpl-acc-hero-logo" src="<?php echo esc_url( WPTE_WPL_URL . '/Image/wpl-icon.svg' ); ?>" alt="" width="52" height="52">
				<div class="wpte-wpl-acc-hero-text">
					<h1 class="wpte-wpl-acc-title"><?php esc_html_e( 'Welcome to Product Layouts', 'product-layouts' ); ?></h1>
					<p class="wpte-wpl-acc-subtitle"><?php esc_html_e( 'Thank you for installing Product Layouts for WooCommerce. Let\'s start decorating your shop!', 'product-layouts' ); ?></p>
				</div>
				<a class="wpte-wpl-acc-btn is-primary" href="<?php echo esc_url( $create_url ); ?>">
					<span class="dashicons dashicons-plus-alt2" aria-hidden="true"></span><?php esc_html_e( 'Create a layout', 'product-layouts' ); ?>
				</a>
			</header>
			<hr class="wp-header-end">

			<div class="wpte-wpl-start-grid">
				<section class="wpte-wpl-start-card wpte-wpl-start-video">
					<div class="wpte-wpl-start-video-frame">
						<iframe src="https://www.youtube.com/embed/rYcP_MGE2X4" title="<?php esc_attr_e( 'Product Layouts for WooCommerce overview', 'product-layouts' ); ?>" loading="lazy" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>
				</section>

				<section class="wpte-wpl-start-card wpte-wpl-start-steps">
					<h2 class="wpte-wpl-start-card-title"><?php esc_html_e( 'Quick start', 'product-layouts' ); ?></h2>
					<ol class="wpte-wpl-start-list">
						<li>
							<strong><?php esc_html_e( 'Pick a layout type', 'product-layouts' ); ?></strong>
							<span><?php esc_html_e( 'Open Product Layouts, choose a type such as General, Product Table or Carousel, and pick a design.', 'product-layouts' ); ?></span>
						</li>
						<li>
							<strong><?php esc_html_e( 'Customize and save', 'product-layouts' ); ?></strong>
							<span><?php esc_html_e( 'Choose the products and adjust colors, typography and spacing in the editor, then click Save.', 'product-layouts' ); ?></span>
						</li>
						<li>
							<strong><?php esc_html_e( 'Add it to your shop', 'product-layouts' ); ?></strong>
							<span><?php esc_html_e( 'Use the Product Layouts block or Elementor widget, or paste the layout\'s shortcode:', 'product-layouts' ); ?></span>
							<code>[wpte_product_layout id="ID"]</code>
						</li>
					</ol>
					<a class="wpte-wpl-acc-btn is-primary" href="<?php echo esc_url( $create_url ); ?>">
						<?php esc_html_e( 'Create your first layout', 'product-layouts' ); ?><span class="dashicons dashicons-arrow-right-alt" aria-hidden="true"></span>
					</a>
				</section>
			</div>

			<h2 class="wpte-wpl-start-heading"><?php esc_html_e( 'Help and resources', 'product-layouts' ); ?></h2>
			<div class="wpte-wpl-start-resources">
				<?php foreach ( $this->resources() as $card ) : ?>
					<section class="wpte-wpl-start-card wpte-wpl-start-resource">
						<span class="wpte-wpl-start-icon dashicons <?php echo esc_attr( $card['icon'] ); ?>" aria-hidden="true"></span>
						<h3><?php echo esc_html( $card['title'] ); ?></h3>
						<p><?php echo esc_html( $card['text'] ); ?></p>
						<a href="<?php echo esc_url( $card['link'] ); ?>" target="_blank" rel="noopener">
							<?php echo esc_html( $card['button'] ); ?><span class="dashicons dashicons-arrow-right-alt" aria-hidden="true"></span>
						</a>
					</section>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}
}
