<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\Table\Frontend;

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

		$args = $this->wpte_get_woo_products( $settings ) ?? [];

		$title_tag   = isset( $settings['wpte_product_layout_table_title_tag'] ) ? $settings['wpte_product_layout_table_title_tag'] : 'h2';
		$_hyperlink  = isset( $settings['wpte-product-table-image-hyperlink'] ) ? $settings['wpte-product-table-image-hyperlink'] : 'div';
		$_new_window = isset( $settings['wpte-product-table-image-open-new-window'] ) ? $settings['wpte-product-table-image-open-new-window'] : '';
		$_nofollow   = isset( $settings['wpte-product-table-image-nofollow'] ) ? $settings['wpte-product-table-image-nofollow'] : '';

		$hyperlink  = 'yes' === $_hyperlink ? 'a' : 'div';
		$new_window = 'a' === $hyperlink && 'yes' === $_new_window ? 'target="_blank"' : '';
		$nofollow   = 'a' === $hyperlink && 'yes' === $_nofollow ? 'rel="nofollow"' : '';

		// Show and Hide.
		$showImage       = isset( $settings['wpte_table_products_show_image'] ) ? $settings['wpte_table_products_show_image'] : '';
		$showTitle       = isset( $settings['wpte_table_products_show_title'] ) ? $settings['wpte_table_products_show_title'] : '';
		$showDescription = isset( $settings['wpte_table_products_show_description'] ) ? $settings['wpte_table_products_show_description'] : '';
		$showPrice       = isset( $settings['wpte_table_products_show_price'] ) ? $settings['wpte_table_products_show_price'] : '';
		$showQuantity    = isset( $settings['wpte_table_products_show_qty'] ) ? $settings['wpte_table_products_show_qty'] : '';
		$showButton      = isset( $settings['wpte_table_products_show_icons'] ) ? $settings['wpte_table_products_show_icons'] : '';
		$image_size      = isset( $settings['wpte_product_layout_table_style_1_image_size'] ) ? $settings['wpte_product_layout_table_style_1_image_size'] : '';
		$productExcerpt  = isset( $settings['wpte_product_layout_table_style_1_excerpt'] ) ? $settings['wpte_product_layout_table_style_1_excerpt'] : 10;

		$query = new \WP_Query( $args );
		if ( $query->have_posts() ) {
			$found_posts      = $query->found_posts;
			$max_page         = ceil( $found_posts / absint( $args['posts_per_page'] ) );
			$args['max_page'] = $max_page;
			?>
		<table class="wpte-product-table-layout-table wpte-product-table-layout-table-style-1">
			<thead class="wpte-product-table-for-lg">
				<?php if ( $showImage ) : ?>
					<th><?php echo esc_html__( 'Image', 'product-layouts' ); ?></th>
				<?php endif; if ( $showTitle ) : ?>
					<th><?php echo esc_html__( 'Name', 'product-layouts' ); ?></th>
				<?php endif; if ( $showDescription ) : ?>
					<th><?php echo esc_html__( 'Description', 'product-layouts' ); ?></th>
				<?php endif; if ( $showPrice ) : ?>
					<th><?php echo esc_html__( 'Price', 'product-layouts' ); ?></th>
				<?php endif; if ( $showQuantity ) : ?>
					<th><?php echo esc_html__( 'Quantity', 'product-layouts' ); ?></th>
				<?php endif; if ( $showButton ) : ?>
					<th><?php echo esc_html__( 'Add to cart', 'product-layouts' ); ?></th>
				<?php endif; ?>
			</thead>
			<thead class="wpte-product-table-for-sm">
				<?php if ( $showImage ) : ?>
					<th><?php echo esc_html__( 'Image', 'product-layouts' ); ?></th>
				<?php endif; ?>
					<th><?php echo esc_html__( 'Details', 'product-layouts' ); ?></th>

			</thead>
			<tbody  class="wpte-product-table-for-lg">
			<?php
			while ( $query->have_posts() ) {
				$query->the_post();
				$product = wc_get_product( get_the_ID() );
				if ( ! $product ) {
					echo esc_html__( 'Product not found', 'product-layouts' );
					return;
				}
				$img_href      = 'a' === $hyperlink ? 'href="' . esc_url( $product->get_permalink() ) . '"' : '';
				$product_image = $product->get_image( "$image_size", [ 'loading' => 'eager' ] ) ? wp_kses_post( $product->get_image( "$image_size", [ 'loading' => 'eager' ] ) ) : '';
				$disabled      = ( 'outofstock' === $product->get_stock_status() ) ? 'wpte-disabled' : '';
				?>
				<tr>
					<?php if ( $showImage ) : ?>
						<td>
							<?php
							printf(
                                '<%1$s %2$s %3$s %4$s class="wpte-product-table-layout-image">%5$s</%1$s>',
                                esc_html( $hyperlink ),
                                wp_kses( $img_href, true ),
                                wp_kses( $new_window, true ),
                                wp_kses( $nofollow, true ),
                                wp_kses_post( $product_image )
							);
							?>
						</td>
					<?php endif; if ( $showTitle ) : ?>
						<td>
							<<?php echo esc_html( $title_tag ); ?> class="wpte-product-table-layout-title">
								<?php printf( '<a href="%1$s">%2$s</a>', esc_url( $product->get_permalink() ), wp_kses_post( $product->get_title() ) ); ?>
							</<?php echo esc_html( $title_tag ); ?>>
						</td>
					<?php endif; if ( $showDescription ) : ?>
						<td>
							<div class="wpte-product-table-layout-description">
								<?php
								$product_summary = '';
								if ( $product->get_short_description() ) {
									$product_summary = wpte_single_product_summary( $product->get_short_description(), $productExcerpt );
								} else {
									$product_summary = wpte_single_product_summary( $product->get_description(), $productExcerpt );
								}
								echo wp_kses( (string) $product_summary, wpte_plugins_allowedtags() );
								?>
							</div>
						</td>
					<?php endif; if ( $showPrice ) : ?>
					<td>
						<div class="wpte-product-table-layouts-price">
							<?php echo wp_kses_data( wpte_get_product_price( $product ) ); ?>
						</div>
					</td>
					<?php endif; if ( $showQuantity ) : ?>
						<td>
							<div class="wpte-product-table-layout-quantity">
								<?php
								if ( 'simple' === $product->get_type() ) {
									$quantity_input = woocommerce_quantity_input( [ 'input_name' => get_the_ID() ], $product, false );
									echo wp_kses(
                                        $quantity_input, [
											'div'   => [
												'class' => [],
											],
											'label' => [
												'class' => [],
												'for'   => [],
											],
											'input' => [
												'type'         => [],
												'id'           => [],
												'class'        => [],
												'name'         => [],
												'value'        => [],
												'title'        => [],
												'size'         => [],
												'min'          => [],
												'max'          => [],
												'step'         => [],
												'placeholder' => [],
												'inputmode' => [],
												'autocomplete' => [],
											],
										]
                                    );
								} else {
									echo '<input type="number" class="input-text qty text" disabled value="1" >';
								}
								?>
							</div>
						</td>
					<?php endif; if ( $showButton ) : ?>
					<td>
						<div class="wpte-table-layout-icons-cart wpte-table-layout-product-cart <?php echo esc_attr( $disabled ); ?>">
							<?php
							$this->wpte_product_cart_render( get_the_ID(), 'icontext', $settings ); // $operator = icon, text, icontext.
							?>
						</div>
					</td>
					<?php endif; ?>
				</tr>
				<?php
			}
			wp_reset_postdata();
			?>

			</tbody>
			<tbody class="wpte-product-table-for-sm">
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

				<tr >
					<td>
						<?php if ( $showImage ) : ?>
							<?php
							printf(
                                '<%1$s %2$s %3$s %4$s class="wpte-product-table-layout-image">%5$s</%1$s>',
                                esc_html( $hyperlink ),
                                wp_kses( $img_href, true ),
                                wp_kses( $new_window, true ),
                                wp_kses( $nofollow, true ),
                                wp_kses_post( $product_image )
							);
							?>
						<?php endif; ?>
					</td>
					<td>
					<?php if ( $showTitle ) : ?>
						<<?php echo esc_html( $title_tag ); ?> class="wpte-product-table-layout-title">
							<?php printf( '<a href="%1$s">%2$s</a>', esc_url( $product->get_permalink() ), wp_kses_post( $product->get_title() ) ); ?>
						</<?php echo esc_html( $title_tag ); ?>>
					<?php endif; if ( $showDescription ) : ?>
						<div class="wpte-product-table-layout-description">
						<?php
						$pd_summary = '';
						if ( $product->get_short_description() ) {
							$pd_summary = wpte_single_product_summary( $product->get_short_description(), $productExcerpt );
						} else {
							$pd_summary = wpte_single_product_summary( $product->get_description(), $productExcerpt );
						}
						echo wp_kses( (string) $pd_summary, wpte_plugins_allowedtags() );
						?>
						</div>
						<?php
						endif;
					if ( $showPrice ) :
						echo "<div class='wpte-product-table-layout-price'>";
							echo wp_kses_data( wpte_get_product_price( $product ) );
						echo '</div>';
					endif;
					?>
						<div class="wpte-product-table-layout-group">
							<?php if ( $showQuantity ) : ?>
							<div class="wpte-product-table-layout-quantity">
								<?php
								if ( 'simple' === $product->get_type() ) {
									$quantity_input = woocommerce_quantity_input( [ 'input_name' => get_the_ID() ], $product, false );
									echo wp_kses( (string) $quantity_input, wpte_allow_quantity_input_html() );
								} else {
									echo '<input type="number" class="input-text qty text" disabled value="1" >';
								}
								endif;
							if ( $showButton ) :
								?>
							</div>
							<div class="wpte-table-layout-icons-cart wpte-table-layout-product-cart <?php echo esc_attr( $disabled ); ?>">
								<?php
								$this->wpte_product_cart_render( get_the_ID(), 'icontext', $settings ); // $operator = icon, text, icontext.
								?>
							</div>

							<?php endif; ?>
						</div>
					</td>
				</tr>
				<?php
			}
			wp_reset_postdata();
			?>
			</tbody>
		</table>
			<?php
		}
	}
}
