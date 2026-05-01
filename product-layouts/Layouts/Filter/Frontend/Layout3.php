<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\Filter\Frontend;

use WPTE_PRODUCT_LAYOUT\Includes\Helper\Public_Render;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Layout3
 */
class Layout3 extends Public_Render {

	/**
	 * Method public_js
	 *
	 * @return void
	 */
	public function public_js() {
		echo '';
	}

	/**
	 * Recursively render all nested subcategories at any depth.
	 *
	 * @param int    $parent_id            Parent term ID.
	 * @param array  $sub_category_ids     Allowed subcategory IDs (empty = all).
	 * @param string $is_custom_sub_category 'yes' if custom filter is on.
	 * @param array  $custom_sub_categories Full list of allowed sub IDs.
	 * @param string $filter_for           Layout ID this filter targets.
	 * @param string $switcher             'yes' to show product counts.
	 * @return void
	 */
	private function render_nested_categories( $parent_id, $sub_category_ids, $is_custom_sub_category, $custom_sub_categories, $filter_for, $switcher ) {
		if ( 'yes' === $is_custom_sub_category && empty( $custom_sub_categories ) ) {
			return;
		}

		$args = [
			'taxonomy' => 'product_cat',
			'parent'   => $parent_id,
		];

		if ( 'yes' === $is_custom_sub_category ) {
			$args['include'] = $sub_category_ids;
		}

		$children = get_terms( $args );

		if ( empty( $children ) || is_wp_error( $children ) ) {
			return;
		}
		?>
		<div class="wpte-product-filter-subcategory">
			<?php foreach ( $children as $child ) : ?>
				<label class="wpte-filter-option">
					<input type="checkbox" name="wpte_product_filter_cat_<?php echo esc_attr( $this->wpteid ); ?>[]" layoutid="<?php echo esc_attr( $filter_for ); ?>" value="<?php echo esc_attr( $child->term_id ); ?>" >
					<span class="check-label"><?php echo esc_html( ucfirst( $child->name ) ); ?></span>
					<?php if ( 'yes' === $switcher ) : ?>
						<span class="cat-post"><?php echo intval( $child->count ); ?></span>
					<?php endif; ?>
				</label>
				<?php $this->render_nested_categories( $child->term_id, $sub_category_ids, $is_custom_sub_category, $custom_sub_categories, $filter_for, $switcher ); ?>
			<?php endforeach; ?>
		</div>
		<?php
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

		$is_custom_category     = isset( $settings['wpte_product_f_custom_category'] ) && $settings['wpte_product_f_custom_category'] ? $settings['wpte_product_f_custom_category'] : '';
		$is_custom_sub_category = isset( $settings['wpte_f_custom_subcategory'] ) && $settings['wpte_f_custom_subcategory'] ? $settings['wpte_f_custom_subcategory'] : '';

		$custom_categories     = isset( $settings['wpte_f_category_list'] ) && $settings['wpte_f_category_list'] ? $settings['wpte_f_category_list'] : [];
		$custom_sub_categories = isset( $settings['wpte_f_sub_category_list'] ) && $settings['wpte_f_sub_category_list'] ? $settings['wpte_f_sub_category_list'] : [];

		$category_ids     = 'yes' === $is_custom_category ? $custom_categories : [];
		$sub_category_ids = 'yes' === $is_custom_sub_category ? $custom_sub_categories : [];

		$product_categories = get_terms(
			[
				'taxonomy'   => 'product_cat',
				'parent'     => 0,
				'include'    => $category_ids,
			]
		);

		?>
		<div class="wpte-product-filter-wrapper">
			<form class="wpte-product-filter-form wpte-product-filter-form-<?php echo esc_attr( $this->wpteid ); ?>" classid="wpte-product-filter-form-<?php echo esc_attr( $this->wpteid ); ?>" dataid="<?php echo esc_attr( $this->wpteid ); ?>" action="" method="POST">
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
											echo wp_kses( 
												$this->text_render(
													'wpte_filters_custom_title_text',
													$custom_title_text
												), wpte_plugins_allowedtags() 
											);
										} else {
											echo esc_html__( 'Category', 'product-layouts' );
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
										echo esc_html__( 'Category', 'product-layouts' );
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
							if ( 'yes' === $is_custom_category ) {
								if ( empty( $custom_categories ) ) {
									return;
								}
							}
							// Loop through each top-level product category.
							foreach ( $product_categories as $category ) {

								?>
								<label class="wpte-filter-option">
									<input type="checkbox" name="wpte_product_filter_cat_<?php echo esc_attr( $this->wpteid ); ?>[]" layoutid="<?php echo esc_attr( $filter_for ); ?>" value="<?php echo esc_attr( $category->term_id ); ?>" >
									<span class="check-label"><?php echo esc_html( ucfirst( $category->name ) ); ?></span>
									<?php if ( 'yes' === $switcher ) { ?>
										<span class="cat-post"><?php echo intval( $category->count ); ?></span>
									<?php } ?>
								</label>
								<?php

								$this->render_nested_categories( $category->term_id, $sub_category_ids, $is_custom_sub_category, $custom_sub_categories, $filter_for, $switcher );
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
