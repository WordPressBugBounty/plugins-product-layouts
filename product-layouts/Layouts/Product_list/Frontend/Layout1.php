<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\Product_list\Frontend;

use WPTE_PRODUCT_LAYOUT\Includes\Helper\Public_Render;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Layout1
 */
class Layout1 extends Public_Render {

	/**
	 * Method public_js
	 *
	 * @return void
	 */
	public function public_js() {
		wp_enqueue_style( 'wpte-Product_list-style1', WPTE_WPL_ASSETS . 'layouts/Product_list/css/layout1.css', null, filemtime( WPTE_WPL_PATH . 'assets/layouts/Product_list/css/layout1.css' ), false );
	}

	/**
	 * Method layout_render
	 *
	 * @param mixed  $settings .
	 * @param string $user .
	 * @return void
	 */
	public function layout_render( $settings, $user ) {

		$args = $this->wpte_get_woo_products( $settings ) ?? [];

		$title_tag   = isset( $settings['wpte_product_layout_list_title_tag'] ) ? $settings['wpte_product_layout_list_title_tag'] : 'h2';
		$_hyperlink  = isset( $settings['wpte-product-list-image-hyperlink'] ) ? $settings['wpte-product-list-image-hyperlink'] : 'div';
		$_new_window = isset( $settings['wpte-product-list-image-open-new-window'] ) ? $settings['wpte-product-list-image-open-new-window'] : '';
		$_nofollow   = isset( $settings['wpte-product-list-image-nofollow'] ) ? $settings['wpte-product-list-image-nofollow'] : '';

		$hyperlink  = 'yes' === $_hyperlink ? 'a' : 'div';
		$new_window = 'a' === $hyperlink && 'yes' === $_new_window ? 'target="_blank"' : '';
		$nofollow   = 'a' === $hyperlink && 'yes' === $_nofollow ? 'rel="nofollow"' : '';

		// Show and Hide.
		$showImage       = isset( $settings['wpte_list_products_show_image'] ) ? $settings['wpte_list_products_show_image'] : '';
		$showTitle       = isset( $settings['wpte_list_products_show_title'] ) ? $settings['wpte_list_products_show_title'] : '';
		$showDescription = isset( $settings['wpte_list_products_show_description'] ) ? $settings['wpte_list_products_show_description'] : '';
		$showPrice       = isset( $settings['wpte_list_products_show_price'] ) ? $settings['wpte_list_products_show_price'] : '';
		$showQuantity    = isset( $settings['wpte_list_products_show_qty'] ) ? $settings['wpte_list_products_show_qty'] : '';
		$showButton      = isset( $settings['wpte_general_products_show_icons'] ) ? $settings['wpte_general_products_show_icons'] : '';
		$image_size      = isset( $settings['wpte_product_layout_table_style_1_image_size'] ) ? $settings['wpte_product_layout_table_style_1_image_size'] : '';
		$productExcerpt  = isset( $settings['wpte_product_layout_table_style_1_excerpt'] ) ? $settings['wpte_product_layout_table_style_1_excerpt'] : 10;

		$query = new \WP_Query( $args );
		if ( $query->have_posts() ) {
			$found_posts      = $query->found_posts;
			$max_page         = ceil( $found_posts / absint( $args['posts_per_page'] ) );
			$args['max_page'] = $max_page;
			?>
		<div class="wpte-product-column wpte-product-list-layout-column wpte-product-card wpte-col-lap-2 wpte-col-tab-1 wpte-col-mob-1">

			<?php
			while ( $query->have_posts() ) {
				$query->the_post();
				$product = wc_get_product( get_the_ID() );
				if ( ! $product ) {
					echo esc_html__( 'Product not found!', 'product-layouts' );
					return;
				}
				$img_href      = 'a' === $hyperlink ? 'href="' . esc_url( $product->get_permalink() ) . '"' : '';
				$product_image = $product->get_image( "$image_size", [ 'loading' => 'eager' ] ) ? wp_kses_post( $product->get_image( "$image_size", [ 'loading' => 'eager' ] ) ) : '';
				$disabled      = ( 'outofstock' === $product->get_stock_status() ) ? 'wpte-disabled' : '';
				?>
			<div class="wpte-product-list-row wpte-product-list-style-1 wpte-swiper-slide">
				<?php if ( $showImage ) : ?>
					<div class="wpte-product-list-product-image">
						<?php
						printf(
                            '<%1$s %2$s %3$s %4$s class="wpte-product-list-img">%5$s</%1$s>',
                            esc_html( $hyperlink ),
                            wp_kses( $img_href, true ),
                            wp_kses( $new_window, true ),
                            wp_kses( $nofollow, true ),
                            wp_kses_post( $product_image )
						);
						?>
					</div>
				<?php endif; ?>
				<div class="wpte-product-list-product-text">
					<?php if ( $showTitle ) : ?>
						<<?php echo esc_html( $title_tag ); ?> class="wpte-product-list-product-title">
							<?php printf( '<a href="%1$s">%2$s</a>', esc_url( $product->get_permalink() ), wp_kses_post( $product->get_title() ) ); ?>
						</<?php echo esc_html( $title_tag ); ?>>
					<?php endif;if ( $showDescription ) : ?>
					<div class="wpte-product-list-product-description">
						<p>
						<?php
						$short_desc = '';
						if ( $product->get_short_description() ) {
							$short_desc = wpte_single_product_summary( $product->get_short_description(), $productExcerpt );
						} else {
							$short_desc = wpte_single_product_summary( $product->get_description(), $productExcerpt );
						}
						echo wp_kses( $short_desc, true );
						?>
						</p>
					</div>
					<?php endif; ?>
				</div>
				<?php if ( $showPrice ) : ?>
					<div class="wpte-product-list-product-price">
						<?php echo wp_kses_data( wpte_get_product_price( $product ) ); ?>
					</div>
				<?php endif; ?>
				<div class="wpte-product-list-cart-area">
					<?php if ( $showQuantity ) : ?>
						<div class="wpte-product-list-product-quantity">
						<?php
						if ( 'simple' === $product->get_type() ) {
							$quantity_input = woocommerce_quantity_input( [ 'input_name' => get_the_ID() ], $product, false );
							echo wp_kses( $quantity_input, wpte_allow_quantity_input_html() );
						} else {
							echo '<input type="number" class="input-text qty text" disabled value="1" >';
						}
						?>
						</div>
					<?php endif; if ( $showButton ) : ?>
						<div class="wpte-product-list-product-button <?php echo esc_attr( $disabled ); ?>">
						<?php
							$this->wpte_product_cart_render( get_the_ID(), 'icontext', $settings ); // $operator = icon, text, icontext.
						?>
						</div>
					<?php endif ?>
				</div>
			</div>
				<?php
			}
			wp_reset_postdata();
			echo '</div>';
		}
	}
}