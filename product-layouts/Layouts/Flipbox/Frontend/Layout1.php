<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\Flipbox\Frontend;

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

		$column = 'wpte-product-card ' . $this->column_render( 'wpte_product_layout_col', $settings );
		$args   = $this->wpte_get_woo_products( $settings ) ?? [];

		// Show and Hide.
		$show_cat         = isset( $settings['wpte_flipbox_products_show_cat'] ) ? $settings['wpte_flipbox_products_show_cat'] : '';
		$show_title       = isset( $settings['wpte_flipbox_products_show_title'] ) ? $settings['wpte_flipbox_products_show_title'] : '';
		$show_description = isset( $settings['wpte_flipbox_products_show_desc'] ) ? $settings['wpte_flipbox_products_show_desc'] : '';
		$show_rating      = isset( $settings['wpte_flipbox_products_show_rating'] ) ? $settings['wpte_flipbox_products_show_rating'] : '';
		$show_price       = isset( $settings['wpte_flipbox_products_show_price'] ) ? $settings['wpte_flipbox_products_show_price'] : '';
		$show_button      = isset( $settings['wpte_flipbox_products_show_button'] ) ? $settings['wpte_flipbox_products_show_button'] : '';
		$image_size       = isset( $settings['wpte_product_layout_flipbox_style_image_size'] ) ? $settings['wpte_product_layout_flipbox_style_image_size'] : '';
		$product_excerpt  = isset( $settings['wpte_product_layout_table_style_excerpt'] ) ? $settings['wpte_product_layout_table_style_excerpt'] : 5;
		$effect           = isset( $settings['wpte_product_layout_flipbox_style_1_effect'] ) ? $settings['wpte_product_layout_flipbox_style_1_effect'] : '';

		$query = new \WP_Query( $args );

		if ( $query->have_posts() ) {
			$found_posts      = $query->found_posts;
			$max_page         = ceil( $found_posts / absint( $args['posts_per_page'] ) );
			$args['max_page'] = $max_page;
			?>
			<div class="wpte-product-column wpte-product-flipbox-column <?php echo esc_attr( $column ); ?>">
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
				<div class="wpte-product-layout-flipbox wpte-swiper-slide">
					<div class="wpte-product-layout-flipbox-hover wpte-product-layout-flipbox-hover-style-1">
						<div class="wpte-product-layout-flipbox-figure wpte-product-flip-<?php echo esc_attr( $effect ); ?>">
							<div class="wpte-product-layout-flipbox-frontend">
								<div class="wpte-product-layout-flipbox-front-section">
									<?php echo wp_kses_post( $product_image ); ?>
								</div>
							</div>
							<div class="wpte-product-layout-flipbox-backend">
								<div class="wpte-product-layout-flipbox-back-section product-hover-align-center-center">
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
									<?php endif;if ( $show_title ) : ?>
										<h2 class="wpte-product-title">
											<?php printf( '<a href="%1$s">%2$s</a>', esc_url( $product->get_permalink() ), wp_kses_post( $product->get_title() ) ); ?>
										</h2>
									<?php endif; if ( $show_description ) : ?>
									<div class="wpte-product-content">
										<?php
										$sammary = '';
										if ( $product->get_short_description() ) {
											$sammary = wpte_single_product_summary( $product->get_short_description(), $product_excerpt );
										} else {
											$sammary = wpte_single_product_summary( $product->get_description(), $product_excerpt );
										}
										echo wp_kses( $sammary, true );
										?>
									</div>
									<?php endif; if ( $show_rating ) : ?>
										<div class="wpte-product-rating">
											<?php echo wp_kses_post( (string) product_rating_render( $product ) ); ?>
										</div>
									<?php endif; if ( $show_price ) : ?>
										<div class="wpte-product-price">
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
