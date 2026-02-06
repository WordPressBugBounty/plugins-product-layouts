<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin\Pages;

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
	 * Support
	 *
	 * @since 1.0.2 -beta
	 */
	public function wpte_support() {

		?>
			<div class="wpte-wpl-row">
				<div class="wpte-wpl-wrapper">
					<div class="wpte-wpl-create-layouts text-center p-5">
						<h1><?php echo esc_html__( 'Welcome to Product Layouts for WooCommerce', 'product-layouts' ); ?></h1>
						<p><?php echo esc_html__( 'Thank you for installiing Product Layouts for WooCommerce. Let\'s start decorating your shop!', 'product-layouts' ); ?></p>
					</div>
					<div class="wpte-feature-section">
						<div class="wpte-about-container">
							<div class="wpte-about-addons-videos">
								<iframe src="https://www.youtube.com/embed/rYcP_MGE2X4" frameborder="0" allowfullscreen="" class="wpte-about-video" allowfullscreen></iframe>
							</div>
						</div>
					</div>
					<div class="wpte-pl-support-column-wrapper">
						<div class="wpte-row">
							<div>
								<div class="wpte-pl-support-card-wrapper">
									<div class="wpte-pl-support-card">
										<div class="wpte-pl-support-icon">
											<span class="dashicons dashicons-format-aside"></span>
										</div>
										<div class="wpte-pl-support-content">
											<h4><?php echo esc_html__( 'Documentation', 'product-layouts' ); ?></h4>
											<p><?php echo esc_html__( 'Get started by spending some time with the documentation to get familiar with Product Layouts for Woocommerce. Build awesome Product layouts for you or your clients with ease.', 'product-layouts' ); ?></p>
											<a href="https://wpkin.com/docs-category/product-layouts/" class="wpte-support-button" target="_blank"><?php echo esc_html__( 'Documentation', 'product-layouts' ); ?></a>
										</div>
									</div>
								</div>
							</div>
							<div>
								<div class="wpte-pl-support-card-wrapper">
									<div class="wpte-pl-support-card">
										<div class="wpte-pl-support-icon">
											<span class="dashicons dashicons-thumbs-up"></span>
										</div>
										<div class="wpte-pl-support-content">
											<h4><?php echo esc_html__( 'Contribute to Product Layouts', 'product-layouts' ); ?></h4>
											<p><?php echo esc_html__( 'You can contribute to make Product Layouts better reporting bugs & creating issues. Our Development team always try to make more powerfull Plugins day by day with solved Issues.', 'product-layouts' ); ?></p>
											<a href="https://wordpress.org/support/plugin/product-layouts/" class="wpte-support-button" target="_blank"><?php echo esc_html__( 'Report a bug', 'product-layouts' ); ?></a>
										</div>
									</div>
								</div>
							</div>
							<div>
								<div class="wpte-pl-support-card-wrapper">
									<div class="wpte-pl-support-card">
										<div class="wpte-pl-support-icon">
											<span class="dashicons dashicons-video-alt2"></span>
										</div>
										<div class="wpte-pl-support-content">
											<h4><?php echo esc_html__( 'Video Tutorials', 'product-layouts' ); ?></h4>
											<p><?php echo esc_html__( 'Unable to use Product Layouts for Woocommerce? Don\'t worry you can check your web tutorials to make easier to use.', 'product-layouts' ); ?></p>
											<a href="https://www.youtube.com/playlist?list=PLnr-_fYXIk0UrNZ3-xEKeLVtZPFJadOIX" class="wpte-support-button" target="_blank"><?php echo esc_html__( 'Video Tutorials', 'product-layouts' ); ?></a>
										</div>
									</div>
								</div>
							</div>
							<div>
								<div class="wpte-pl-support-card-wrapper">
									<div class="wpte-pl-support-card">
										<div class="wpte-pl-support-icon">
											<span class="dashicons dashicons-phone"></span>
										</div>
										<div class="wpte-pl-support-content">
											<h4><?php echo esc_html__( 'Support', 'product-layouts' ); ?></h4>
											<p><?php echo esc_html__( 'Do you need our support? don\'t worry, Our exprienced developer will help you.', 'product-layouts' ); ?></p>
											<a href="https://wordpress.org/support/plugin/product-layouts/" class="wpte-support-button" target="_blank"><?php echo esc_html__( 'Get Support', 'product-layouts' ); ?></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
	}
}
