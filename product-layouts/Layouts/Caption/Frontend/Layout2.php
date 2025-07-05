<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\Caption\Frontend;

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
		wp_enqueue_style( 'wpte-caption-style2', WPTE_WPL_ASSETS . 'layouts/Caption/css/block_effects.css', null, filemtime( WPTE_WPL_PATH . 'assets/layouts/Caption/css/block_effects.css' ), false );
	}

	/**
	 * Method layout_render
	 *
	 * @param mixed  $settings .
	 * @param string $user .
	 * @return void
	 */
	public function layout_render( $settings, $user ) {

		$column = 'wpte-product-card ' . $this->column_render( 'wpte_product_layout_col', $settings );
		$args   = $this->wpte_get_woo_products( $settings ) ?? [];

		// Wish List.
		$is_wishlist_icon = isset( $settings['wpte_general_products_show_icons'] ) ? $settings['wpte_general_products_show_icons'] : '';
		$wishtlist_switch = isset( $settings['wpte_product_layout_wishlist_icon_switcher'] ) ? $settings['wpte_product_layout_wishlist_icon_switcher'] : '';

		// Show and Hide.
		$show_cat         = isset( $settings['wpte_caption_products_show_cat'] ) ? $settings['wpte_caption_products_show_cat'] : '';
		$show_title       = isset( $settings['wpte_caption_products_show_title'] ) ? $settings['wpte_caption_products_show_title'] : '';
		$show_description = isset( $settings['wpte_caption_products_show_desc'] ) ? $settings['wpte_caption_products_show_desc'] : '';
		$show_rating      = isset( $settings['wpte_caption_products_show_rating'] ) ? $settings['wpte_caption_products_show_rating'] : '';
		$show_price       = isset( $settings['wpte_caption_products_show_price'] ) ? $settings['wpte_caption_products_show_price'] : '';
		$show_button      = isset( $settings['wpte_caption_products_show_button'] ) ? $settings['wpte_caption_products_show_button'] : '';
		$image_size       = isset( $settings['wpte_product_layout_caption_style_image_size'] ) ? $settings['wpte_product_layout_caption_style_image_size'] : '';
		$product_excerpt  = isset( $settings['wpte_product_layout_caption_excerpt'] ) ? $settings['wpte_product_layout_caption_excerpt'] : 5;
		$block_effect     = isset( $settings['wpte_product_layout_caption_style_2_effect'] ) ? $settings['wpte_product_layout_caption_style_2_effect'] : '';

		$query = new \WP_Query( $args );

		if ( $query->have_posts() ) {
			$found_posts      = $query->found_posts;
			$max_page         = ceil( $found_posts / absint( $args['posts_per_page'] ) );
			$args['max_page'] = $max_page;
			?>
			<div class="wpte-product-column wpte-product-caption-style-2-column <?php echo esc_attr( $column ); ?>">
			<?php
			while ( $query->have_posts() ) {
				$query->the_post();
				$product = wc_get_product( get_the_ID() );
				if ( ! $product ) {
					echo esc_html__( 'Product not found!', 'wpte-product-layout' );
					return;
				}

				$cat_args = [
					'orderby' => 'name',
				];

				$product_cats         = wp_get_post_terms( get_the_ID(), 'product_cat', $cat_args );
				$product_cats_counter = count( $product_cats );

				$product_image = $product->get_image( "$image_size", [ 'loading' => 'eager' ] ) ? wp_kses_post( $product->get_image( "$image_size", [ 'loading' => 'eager' ] ) ) : '';

				?>

				<div class="wpte-product-hover-style-caption wpte-swiper-slide">
					<div class="wpte-product-hover wpte-product-caption-hover wpte-product-caption-hover-style-2 wpte-product-blocks-<?php echo esc_attr( $block_effect ); ?>">
						<div class="wpte-product-hover-figure">
							<div class="wpte-product-hover-image">
								<?php echo wp_kses_post( $product_image ); ?>
							</div>
							<div class="wpte-product-hover-figure-caption">
								<div class="wpte-product-hover-caption-tab product-hover-align-center-center">
									<?php if ( $is_wishlist_icon && 'yes' === $wishtlist_switch && class_exists( 'TInvWL_Admin_Base' ) ) : ?>
										<div class="wpte-caption-layout-wishlist-icon">
											<?php
											$wishtlist_icon = $this->wpte_product_wishlist_render( get_the_ID(), 'icon', $settings, 'right' ); // $operator = icon, text, icontext // $IconPosition = top, right, bottom, left.
											echo wp_kses( (string) $wishtlist_icon, wpte_allow_wishlist_html() );
											?>
										</div>
									<?php endif; ?>
									<?php if ( $show_cat ) : ?>
										<div class="wpte-product-category">
											<?php
											for ( $i = 0; $i < $product_cats_counter; $i++ ) {
												$_cat_link = get_term_link( $product_cats[ $i ]->term_id, 'product_cat' );
												$cat_link  = esc_url( $_cat_link );
												$cat_name  = esc_html( $product_cats[ $i ]->name );
												echo "<a href='" . esc_url( $cat_link ) . "'>" . esc_html( $cat_name ) . '</a>';
											}
											?>
										</div>
									<?php endif; if ( $show_title ) : ?>
										<h2 class="wpte-product-title wpte-fade-up">
											<?php printf( '<a href="%1$s">%2$s</a>', esc_url( $product->get_permalink() ), wp_kses_post( $product->get_title() ) ); ?>
										</h2>
									<?php endif; if ( $show_description ) : ?>
										<div class="wpte-product-content wpte-fade-down">
											<?php
											$product_excerpts = '';
											if ( $product->get_short_description() ) {
												$product_excerpts = wpte_single_product_summary( $product->get_short_description(), $product_excerpt );
											} else {
												$product_excerpts = wpte_single_product_summary( $product->get_description(), $product_excerpt );
											}
											echo wp_kses( $product_excerpts, wpte_plugins_allowedtags() );
											?>
										</div>
									<?php endif; if ( $show_rating ) : ?>
										<div class="wpte-product-rating wpte-fade-up">
											<?php echo wp_kses_post( (string) product_rating_render( $product ) ); ?>
										</div>
									<?php endif; if ( $show_price ) : ?>
										<div class="wpte-product-price wpte-fade-up">
											<?php echo wp_kses_data( wpte_get_product_price( $product ) ); ?>
										</div>
									<?php endif; if ( $show_button ) : ?>
										<div class="wpte-product-button">
											<div class="wpte-fade-up">
												<?php
												$this->wpte_product_cart_render( get_the_ID(), 'icontext', $settings ); // $operator = icon, text, icontext.
												?>
											</div>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
				wp_reset_postdata();
				echo '</div>';
		}
	}
}
