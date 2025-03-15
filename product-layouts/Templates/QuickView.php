<?php

namespace WPTE_PRODUCT_LAYOUT\Templates;

/**
 * Quick View Class
 *
 * @since 1.0.1
 */
class QuickView {

	/**
	 * Construct
	 *
	 * @param int $product_id .
	 * @since 1.0.1
	 */
	public function __construct( $product_id ) {
		add_action( 'wpte_woo_single_product_image', 'woocommerce_show_product_images', 20 );
		add_action( 'wpte_woo_single_product_title', 'woocommerce_template_single_title', 5 );
		add_action( 'wpte_woo_single_product_price', 'woocommerce_template_single_price', 15 );
		add_action( 'wpte_woo_single_product_excerpt', 'woocommerce_template_single_excerpt', 20 );
		add_action( 'wpte_woo_single_product_cart', 'woocommerce_template_single_add_to_cart', 25 );
		add_action( 'wpte_woo_single_product_meta', 'woocommerce_template_single_meta', 30 );
		$this->wpte_product_quick_view_template( $product_id );
	}

	/**
	 * Method wpte_product_quick_view_template.
	 *
	 * @param int $product_id .
	 * @since 1.0.1
	 */
	public function wpte_product_quick_view_template( $product_id ) {

		if ( version_compare( \WC()->version, '2.2.0', '<' ) ) {
			$product = get_product( $product_id );
		} else {
			$product = wc_get_product( $product_id );
		}

		$product_url         = get_permalink( $product_id );
		$in_stock            = get_post_meta( $product_id, '_stock', true ) ? get_post_meta( $product_id, '_stock', true ) : '';
		$hide_quick_view_qty = $in_stock > 1 ? '' : 'wpte-hide-qty';
		?>
			<div class="wpte-quick-view-image-area">
				<?php
				do_action( 'wpte_woo_single_product_image' );
				?>
			</div>
			<div class="wpte-quick-view-content-area">
				<?php if ( $in_stock || get_post_meta( $product_id, '_stock_status', true ) === 'instock' ) { ?>
					<div class="wpte-quick-view-stock">
						<?php echo wp_kses_post( $in_stock ) . esc_html__( 'In Stock', 'wpte-product-layout' ); ?>
					</div>
					<?php
				}
				if ( get_post_meta( $product_id, '_stock_status', true ) === 'outofstock' ) {
					?>
					<div class="wpte-quick-view-stock out-stock">
						<?php echo esc_html__( 'Out of stock', 'wpte-product-layout' ); ?>
					</div>
				<?php } ?>
				<div class="wpte-quick-view-category">
					<?php
					$product_categories = wc_get_product_category_list( $product_id );
					echo wp_kses( $product_categories, true );
					?>
				</div>

				<div class="wpte-quick-view-title">
					<a href="<?php echo esc_url( $product_url ); ?>">
						<?php do_action( 'wpte_woo_single_product_title' ); ?>
					</a>
				</div>
				<div class="wpte-quick-view-description">
					<?php do_action( 'wpte_woo_single_product_excerpt' ); ?>
				</div>
				<div class="wpte-quick-view-rating">
					<?php echo wp_kses_post( product_rating_render( $product ) ); ?>
					<?php
						$review = $product->get_rating_count() ? $product->get_rating_count() : 0;
						printf( '<a href="%s/#reviews">%s</a>', esc_url( $product_url ), '( ' . intval( $review ) . ' ' . esc_html__( 'review', 'wpte-product-layout' ) . ')' );
					?>
				</div>
				<div class="wpte-quick-view-price">
					<?php do_action( 'wpte_woo_single_product_price' ); ?>
				</div>
				<div class="wpte_quick_view_product_simple_addtocart_container wpte_quick_view_product_addtocart_button_container <?php echo esc_attr( $hide_quick_view_qty ); ?>">
					<?php do_action( 'wpte_woo_single_product_cart' ); ?>
				</div>
				<div class="wpte-quick-view-meta-content">
					<?php do_action( 'wpte_woo_single_product_meta' ); ?>
				</div>
			</div>
		<?php
	}
}