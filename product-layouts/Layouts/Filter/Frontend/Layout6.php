<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\Filter\Frontend;

use WPTE_PRODUCT_LAYOUT\Includes\Helper\Public_Render;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Layout6
 */
class Layout6 extends Public_Render {

	/**
	 * Method public_js
	 *
	 * @return void
	 */
	public function public_js() {
		$this->jshandle = 'wpte-wc-color-attribute';
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
		$attribute         = isset( $settings['wpte_filters_attribute'] ) && $settings['wpte_filters_attribute'] ? $settings['wpte_filters_attribute'] : 'color';
		$filter_for        = isset( $settings['wpte_filter_for_shortcode'] ) && $settings['wpte_filter_for_shortcode'] ? $settings['wpte_filter_for_shortcode'] : '';
		$switcher          = isset( $settings['wpte_product_filter_post_count_switcher'] ) && $settings['wpte_product_filter_post_count_switcher'] ? $settings['wpte_product_filter_post_count_switcher'] : '';
		$style             = isset( $settings['wpte_filters_attribute_style'] ) && $settings['wpte_filters_attribute_style'] ? $settings['wpte_filters_attribute_style'] : 'style_1';
		$is_text           = isset( $settings['wpte_filters_attribute_text'] ) && $settings['wpte_filters_attribute_text'] ? $settings['wpte_filters_attribute_text'] : '';
		$is_title          = isset( $settings['wpte_filters_title_show'] ) && $settings['wpte_filters_title_show'] ? $settings['wpte_filters_title_show'] : '';
		$custom_title      = isset( $settings['wpte_filters_custom_title'] ) && $settings['wpte_filters_custom_title'] ? $settings['wpte_filters_custom_title'] : '';
		$custom_title_text = isset( $settings['wpte_filters_custom_title_text'] ) && $settings['wpte_filters_custom_title_text'] ? $settings['wpte_filters_custom_title_text'] : '';
		$hide_empty        = isset( $settings['wpte_f_hide_empty'] ) && $settings['wpte_f_hide_empty'] ? true : false;

		$attribute_terms = get_terms(
            [
				'taxonomy'   => 'pa_' . $attribute,
				'hide_empty' => $hide_empty,
			]
        );

		if ( is_wp_error( $attribute_terms ) ) {
			// Handle the error, for example by displaying a message
			echo '<p>Failed to retrieve terms: ' . esc_html( $attribute_terms->get_error_message() ) . '</p>';
			return;
		}

		wp_register_style( 'wpte-wc-color-attribute', '', [], WPTE_WPL_VERSION, false );
		wp_enqueue_style( 'wpte-wc-color-attribute' );
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
											echo esc_html(ucfirst( $attribute ));
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
										echo esc_html(ucfirst( $attribute ));
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

							if ( 'style_2' === $style ) {
								echo '<div class="wpte-wc-color-attribute-filter">';
							}
							if ( ! empty( $attribute_terms ) && ! isset( $attribute_terms['errors'] ) ) {
								if ( 'color' === $attribute ) {
									?>
										
										<?php
										foreach ( $attribute_terms as $index => $attribute_term ) {
											// Generate inline style block for this color
											$bd_color = $attribute_term->name ? $attribute_term->name : '#ddd';
											$styles = "
												.wpte-check-color-attr-$index:before {
													background-color: $bd_color !important;
												}
												";
											// Add the inline styles
											wp_add_inline_style( 'wpte-wc-color-attribute', $styles );
											?>
											<label class="wpte-filter-option wpte-default-option">
												<input type="checkbox" class="wpte-filter-attribute" name="wpte_product_filter_attribute_<?php echo esc_attr( $this->wpteid ); ?>[]" layoutid="<?php echo esc_attr( $filter_for ); ?>" wpte_attribute="<?php echo esc_attr( 'pa_' . $attribute ); ?>" value="<?php echo esc_attr( $attribute_term->slug ); ?>" >
												<span class="check-label wpte-check-color-attr-<?php echo esc_html( $index ); ?>">
												<?php
												if ( $is_text ) {
													echo esc_html( $attribute_term->name );
												}
												if ( 'yes' === $switcher ) {
                                                    ?>
														<span class="cat-post"><?php echo intval( $attribute_term->count ); ?></span>
														<?php
												}
												?>
												</span>
											</label>
											<?php
										}
								} else {
									foreach ( $attribute_terms as $attribute_term ) {
										?>
										<label class="wpte-filter-option wpte-default-option">
											<input type="checkbox" class="wpte-filter-attribute" name="wpte_product_filter_attribute_<?php echo esc_attr( $this->wpteid ); ?>[]" layoutid="<?php echo esc_attr( $filter_for ); ?>" wpte_attribute="<?php echo esc_attr( 'pa_' . $attribute ); ?>" value="<?php echo esc_attr( $attribute_term->slug ); ?>" >
											<span class="check-label">
											<?php
											if ( $is_text ) {
												echo esc_html( $attribute_term->name );
											}
											if ( 'yes' === $switcher ) {
                                                ?>
													<span class="cat-post"><?php echo intval( $attribute_term->count ); ?></span>
													<?php
											}
											?>
											</span>
										</label>
										<?php
									}
								}
							} else {
								echo "<p>Color attribute isn't available in your WooCommerce attribute list. If you have any other attribute, you can use this filter :)</p>";
							}
							if ( 'style_2' === $style ) {
								echo '</div>';
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
