<?php

namespace WPTE_PRODUCT_LAYOUT\Templates;

/**
 * Quick View Class
 *
 * @since 1.0.1
 */
class Compare {

	/**
	 * Construct
	 *
	 * @param mixed $product_list .
	 * @since 1.0.1
	 */
	public function __construct( $product_list ) {

		$this->wpte_product_compare_template( $product_list );
	}

	/**
	 * Method wpte_product_compare_template
	 *
	 * @param mixed $product_list .
	 * @since 1.0.1
	 */
	public function wpte_product_compare_template( $product_list ) {

		if ( $product_list ) :
			?>
		<!-- DIRTY Responsive pricing table HTML -->
		<div class="wpte-compare-table-title">
			<h1><?php echo esc_html__( 'Compare Products', 'wpte-product-layout' ); ?></h1>
		</div>
		<article>
			<table>

				<tbody>
				<tr>
						<th class="hide"></th>
						<?php
						$arrg = [
							'post_type' => 'product',
							'post__in'  => $product_list,
						];
						$query = new \WP_Query( $arrg );

						if ( $query->have_posts() ) {
							while ( $query->have_posts() ) {
								$query->the_post();
								$product = wc_get_product( get_the_ID() );

								if ( $product ) {
									$product_image      = $product->get_image( 'woocommerce_thumbnail', [ 'loading' => 'eager' ] ) ? $product->get_image( 'woocommerce_thumbnail', [ 'loading' => 'eager' ] ) : '';
									$product_categories = wc_get_product_category_list( get_the_ID() );
									printf(
                                        '<td class="wpte-remove-%1$s">
										<div class="wpte-th-wraper">
										<div class="wpte-compare-product-remove" product_id="%1$s"><a>×</a></div>
										<div class="wpte-compare-product-img">%2$s</div>
										<div class="wpte-compare-product-cat">%3$s</div>
										<div class="wpte-compare-product-price">%4$s</div>
										<div class="wpte-compare-product-button">',
										intval( get_the_ID() ),
										wp_kses_post( $product_image ),
										wp_kses( $product_categories, true ),
										wp_kses_data( $product->get_price_html() )
									);

									woocommerce_template_loop_add_to_cart();

									printf( '</div></div></td>' );
								}
							}
							wp_reset_postdata();
						}
						?>
					</tr>
					<tr>
						<th><?php echo esc_html__( 'Description', 'wpte-product-layout' ); ?></th>
						<?php
						if ( $query->have_posts() ) {
							while ( $query->have_posts() ) {
								$query->the_post();
								$product = wc_get_product( get_the_ID() );
								if ( $product ) {
									printf( '<td class="wpte-remove-%s"><span>%s</span></td>', intval( get_the_ID() ), wp_kses( $product->get_short_description(), true ) );
								}
							}
							wp_reset_postdata();
						}
						?>
					</tr>
					<tr>
						<th><?php echo esc_html__( 'Availability', 'wpte-product-layout' ); ?></th>
						<?php
						if ( $query->have_posts() ) {
							while ( $query->have_posts() ) {
								$query->the_post();
								$product = wc_get_product( get_the_ID() );
								if ( $product ) {
									$stock_status = $product->get_stock_status();
									if ( $stock_status === 'instock' ) {
										$stock_status = 'In Stock';
									} elseif ( $stock_status === 'outofstock' ) {
										$stock_status = 'Out of Stock';
									} elseif ( $stock_status === 'onbackorder' ) {
										$stock_status = 'On Back Order';
									}
									printf( '<td class="wpte-remove-%s"><span>%s</span></td>', intval( get_the_ID() ), wp_kses( $stock_status, true ) );
								}
							}
							wp_reset_postdata();
						}
						?>
					</tr>
					<tr>
						<th><?php echo esc_html__( 'Weight', 'wpte-product-layout' ); ?></th>
						<?php
						if ( $query->have_posts() ) {
							while ( $query->have_posts() ) {
								$query->the_post();
								$product = wc_get_product( get_the_ID() );
								if ( $product ) {
									$wight = $product->get_weight() ? $product->get_weight() . ' ' . get_option( 'woocommerce_weight_unit' ) : '-';
									printf( '<td class="wpte-remove-%s"><span>%s</span></td>', intval( get_the_ID() ), esc_html( $wight ) );
								}
							}
							wp_reset_postdata();
						}
						?>
					</tr>
					<tr>
						<th><?php echo esc_html__( 'Dimensions', 'wpte-product-layout' ); ?></th>
						<?php
						if ( $query->have_posts() ) {
							while ( $query->have_posts() ) {
								$query->the_post();
								$product = wc_get_product( get_the_ID() );
								if ( $product ) {
									$dimensions = $product->get_dimensions() ? $product->get_dimensions() . ' ' . get_option( 'woocommerce_dimensions_unit' ) : '-';
									printf( '<td class="wpte-remove-%s"><span>%s</span></td>', intval( get_the_ID() ), esc_html( $dimensions ) );
								}
							}
							wp_reset_postdata();
						}
						?>
					</tr>
					<tr>
						<th><?php echo esc_html__( 'Color', 'wpte-product-layout' ); ?></th>
						<?php
						if ( $query->have_posts() ) {
							while ( $query->have_posts() ) {
								$query->the_post();
								$product = wc_get_product( get_the_ID() );
								if ( $product ) {
									$color = $product->get_attribute( 'pa_color' ) ? $product->get_attribute( 'pa_color' ) : '-';
									printf( '<td class="wpte-remove-%s"><span>%s</span></td>', intval( get_the_ID() ), wp_kses( $color, true ) );
								}
							}
							wp_reset_postdata();
						}
						?>
					</tr>
					<tr>
						<th><?php echo esc_html__( 'Size', 'wpte-product-layout' ); ?></th>
						<?php
						if ( $query->have_posts() ) {
							while ( $query->have_posts() ) {
								$query->the_post();
								$product = wc_get_product( get_the_ID() );
								if ( $product ) {
									$size = $product->get_attribute( 'pa_size' ) ? $product->get_attribute( 'pa_size' ) : '-';
									printf( '<td class="wpte-remove-%s"><span>%s</span></td>', intval( get_the_ID() ), wp_kses( $size, true ) );
								}
							}
							wp_reset_postdata();
						}
						?>
					</tr>
					<tr>
						<th><?php echo esc_html__( 'Sku', 'wpte-product-layout' ); ?></th>
						<?php
						if ( $query->have_posts() ) {
							while ( $query->have_posts() ) {
								$query->the_post();
								$product = wc_get_product( get_the_ID() );
								if ( $product ) {
									printf( '<td class="wpte-remove-%s"><span>%s</span></td>', intval( get_the_ID() ), wp_kses( $product->get_sku(), true ) );
								}
							}
							wp_reset_postdata();
						}
						?>
					</tr>
					<tr>
						<th class="price"><?php echo esc_html__( 'Price', 'wpte-product-layout' ); ?></th>
						<?php
						if ( $query->have_posts() ) {
							while ( $query->have_posts() ) {
								$query->the_post();
								$product = wc_get_product( get_the_ID() );
								if ( $product ) {
									printf( '<td class="wpte-compare-product-price wpte-remove-%s"><span>%s</span></td>', intval( get_the_ID() ), wp_kses_data( $product->get_price_html() ) );
								}
							}
							wp_reset_postdata();
						}
						?>
					</tr>
				</tbody>
			</table>
		</article>

			<?php
		endif;
	}
}