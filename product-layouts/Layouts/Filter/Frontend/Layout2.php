<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\Filter\Frontend;

use WPTE_PRODUCT_LAYOUT\Includes\Helper\Public_Render;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Layout2
 */
class Layout2 extends Public_Render {

	/**
	 * Method public_js
	 *
	 * @return void
	 */
	public function public_js() {
		echo '';
	}

	/**
	 * Method layout_render
	 *
	 * @param mixed  $settings .
	 * @param string $user .
	 * @return void
	 */
	public function layout_render( $settings, $user ) {

		$preset            = isset( $settings['wpte_filters_preset'] ) && $settings['wpte_filters_preset'] ? $settings['wpte_filters_preset'] : '';
		$filter_for        = isset( $settings['wpte_filter_for_shortcode'] ) && $settings['wpte_filter_for_shortcode'] ? $settings['wpte_filter_for_shortcode'] : '';
		$is_title          = isset( $settings['wpte_filters_title_show'] ) && $settings['wpte_filters_title_show'] ? $settings['wpte_filters_title_show'] : '';
		$custom_title      = isset( $settings['wpte_filters_custom_title'] ) && $settings['wpte_filters_custom_title'] ? $settings['wpte_filters_custom_title'] : '';
		$custom_title_text = isset( $settings['wpte_filters_custom_title_text'] ) && $settings['wpte_filters_custom_title_text'] ? $settings['wpte_filters_custom_title_text'] : '';
		?>
		<div class="wpte-product-filter-wrapper">
			<form class="wpte-product-filter-form wpte-product-filter-form-<?php echo esc_attr( $this->wpteid ); ?>" classid = "wpte-product-filter-form-<?php echo esc_attr( $this->wpteid ); ?>" dataid="<?php echo esc_attr( $this->wpteid ); ?>" action="" method="POST">
				<div class="wpte-product-filter-items">
					<div class="wpte-product-filter-item wpte-prduct-filter-sort-by">
						<?php
						if ( 'normal' === $preset ) {
							$wpte_dropdown = 'wpte-product-filter-normal';
							if ( $is_title ) {
								?>
								<div class="wpte-product-filter-heading-normal">
									<span>
										<?php
										if ( $custom_title ) {
											echo $this->text_render( 'wpte_filters_custom_title_text', $custom_title_text );
										} else {
											echo esc_html__( 'Show per page', 'wpte-product-layout' );
										}
										?>
									</span>
								</div>
								<?php
							}
						} else {
							$wpte_dropdown = 'wpte-product-filter-dropdown';
							?>
							<div class="wpte-product-filter-heading">
								<span>
									<?php
									if ( $custom_title ) {
										echo $this->text_render( 'wpte_filters_custom_title_text', $custom_title_text );
									} else {
										echo esc_html__( 'Show per page', 'wpte-product-layout' );
									}
									?>
								</span>
								<span class="wpte-icon icon-arrow-5"></span>
							</div>
							<?php
						}
						?>
						<div class="<?php echo esc_attr( $wpte_dropdown ); ?>">
							<label class="wpte-filter-option">
								<input type="radio" name="wpte_product_filter_show_per_page_<?php echo esc_attr( $this->wpteid ); ?>" layoutid="<?php echo esc_attr( $filter_for ); ?>" value="">
								<span class="radio-label"><?php echo esc_html__( 'Default', 'wpte-product-layout' ); ?></span>
							</label>
							<label class="wpte-filter-option">
								<input type="radio" name="wpte_product_filter_show_per_page_<?php echo esc_attr( $this->wpteid ); ?>" layoutid="<?php echo esc_attr( $filter_for ); ?>" value="10">
								<span class="radio-label"><?php echo esc_html__( '10 per page', 'wpte-product-layout' ); ?></span>
							</label>
							<label class="wpte-filter-option">
								<input type="radio" name="wpte_product_filter_show_per_page_<?php echo esc_attr( $this->wpteid ); ?>" layoutid="<?php echo esc_attr( $filter_for ); ?>" value="20">
								<span class="radio-label"><?php echo esc_html__( '20 per page', 'wpte-product-layout' ); ?></span>
							</label>
							<label class="wpte-filter-option">
								<input type="radio" name="wpte_product_filter_show_per_page_<?php echo esc_attr( $this->wpteid ); ?>" layoutid="<?php echo esc_attr( $filter_for ); ?>" value="30">
								<span class="radio-label"><?php echo esc_html__( '30 per page', 'wpte-product-layout' ); ?></span>
							</label>
						</div>
					</div>
				</div>
			</form>
		</div>
		<?php
	}
}
