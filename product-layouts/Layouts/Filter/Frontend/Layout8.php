<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\Filter\Frontend;

use WPTE_PRODUCT_LAYOUT\Includes\Helper\Public_Render;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Layout8
 */
class Layout8 extends Public_Render {

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
		$switcher          = isset( $settings['wpte_product_filter_post_count_switcher'] ) && $settings['wpte_product_filter_post_count_switcher'] ? $settings['wpte_product_filter_post_count_switcher'] : '';
		$is_title          = isset( $settings['wpte_filters_title_show'] ) && $settings['wpte_filters_title_show'] ? $settings['wpte_filters_title_show'] : '';
		$custom_title      = isset( $settings['wpte_filters_custom_title'] ) && $settings['wpte_filters_custom_title'] ? $settings['wpte_filters_custom_title'] : '';
		$custom_title_text = isset( $settings['wpte_filters_custom_title_text'] ) && $settings['wpte_filters_custom_title_text'] ? $settings['wpte_filters_custom_title_text'] : '';
		$hide_empty        = isset( $settings['wpte_f_hide_empty'] ) && $settings['wpte_f_hide_empty'] ? true : false;

		// WooCommerce registers brands in core from 9.4; older stores use a plugin taxonomy.
		$brand_taxonomy = wpte_get_brand_taxonomy();

		if ( ! $brand_taxonomy ) {
			echo '<p>' . esc_html__( 'Brands are not available on this store. Brands require WooCommerce 9.4 or a brands plugin.', 'product-layouts' ) . '</p>';
			return;
		}

		$product_brands = get_terms(
            [
				'taxonomy'   => $brand_taxonomy,
				'hide_empty' => $hide_empty,
				'orderby'    => 'name',
				'order'      => 'ASC',
			]
        );

		if ( is_wp_error( $product_brands ) ) {
			echo '<p>Failed to retrieve brands: ' . esc_html( $product_brands->get_error_message() ) . '</p>';
			return;
		}

		if ( empty( $product_brands ) ) {
			echo '<p>' . esc_html__( 'No product brands found. Assign brands to your products to use this filter.', 'product-layouts' ) . '</p>';
			return;
		}
		?>
		<div class="wpte-product-filter-wrapper">
			<form class="wpte-product-filter-form wpte-product-filter-form-<?php echo esc_attr( $this->wpteid ); ?>" classid="wpte-product-filter-form-<?php echo esc_attr( $this->wpteid ); ?>" dataid="<?php echo esc_attr( $this->wpteid ); ?>" action="" method="POST">
				<div class="wpte-product-filter-items">
					<div class="wpte-product-filter-item">
						<?php
						if ( 'normal' === $preset ) {
							$wpte_dropdown = 'wpte-product-filter-normal';
							if ( $is_title ) {
								?>
								<div class="wpte-product-filter-heading-normal">
									<span>
										<?php
										if ( $custom_title ) {
											echo wp_kses(
												$this->text_render(
													'wpte_filters_custom_title_text',
													$custom_title_text
												), wpte_plugins_allowedtags()
											);
										} else {
											echo esc_html__( 'Brands', 'product-layouts' );
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
										echo wp_kses(
											$this->text_render(
												'wpte_filters_custom_title_text',
												$custom_title_text
											), wpte_plugins_allowedtags()
										);
									} else {
										echo esc_html__( 'Brands', 'product-layouts' );
									}
									?>
								</span>
								<span class="wpte-icon icon-arrow-5"></span>
							</div>
							<?php
						}
						?>
						<div class="<?php echo esc_attr( $wpte_dropdown ); ?>">
							<?php
							// Loop through each product brand.
							foreach ( $product_brands as $product_brand ) {
								?>
								<label class="wpte-filter-option">
									<input type="checkbox" name="wpte_product_filter_brand_<?php echo esc_attr( $this->wpteid ); ?>[]" layoutid="<?php echo esc_attr( $filter_for ); ?>" value="<?php echo esc_attr( $product_brand->term_id ); ?>" >
									<span class="check-label"><?php echo esc_html( ucfirst( $product_brand->name ) ); ?></span>
									<?php if ( 'yes' === $switcher ) { ?>
										<span class="cat-post"><?php echo intval( $product_brand->count ); ?></span>
									<?php } ?>
								</label>
								<?php
							}
							?>
						</div>
					</div>
				</div>
			</form>
		</div>
		<?php
	}
}
