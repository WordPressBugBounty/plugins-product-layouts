<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\General\Frontend;

use WPTE_PRODUCT_LAYOUT\Includes\Helper\Public_Render;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Layout4
 */
class Layout4 extends Public_Render {

	/**
	 * Method public_js
	 *
	 * @return void
	 */
	public function public_js() {
		wp_enqueue_style( 'wpte-general-style4', WPTE_WPL_ASSETS . 'layouts/General/css/layout4.css', null, filemtime( WPTE_WPL_PATH . 'assets/layouts/General/css/layout4.css' ), false );
	}

	/**
	 * Method layout_render.
	 *
	 * @param mixed  $settings .
	 * @param string $user .
	 * @return void
	 */
	public function layout_render( $settings, $user ) {

		$column  = 'wpte-product-card ' . $this->column_render( 'wpte_product_layout_col', $settings );
		$args    = $this->wpte_get_woo_products( $settings ) ?? [];
		$is_icon = isset( $settings['wpte_product_layout_cart_icon_switcher'] ) ? $settings['wpte_product_layout_cart_icon_switcher'] : '';

		$title_tag   = isset( $settings['wpte_product_layout_general_title_tag'] ) ? $settings['wpte_product_layout_general_title_tag'] : 'h2';
		$_hyperlink  = isset( $settings['wpte-product-general-image-hyperlink'] ) ? $settings['wpte-product-general-image-hyperlink'] : 'div';
		$_new_window = isset( $settings['wpte-product-general-image-open-new-window'] ) ? $settings['wpte-product-general-image-open-new-window'] : '';
		$_nofollow   = isset( $settings['wpte-product-general-image-nofollow'] ) ? $settings['wpte-product-general-image-nofollow'] : '';

		$hyperlink  = 'yes' === $_hyperlink ? 'a' : 'div';
		$new_window = 'a' === $hyperlink && 'yes' === $_new_window ? 'target="_blank"' : '';
		$nofollow   = 'a' === $hyperlink && 'yes' === $_nofollow ? 'rel="nofollow"' : '';

		// Wish List.
		$is_wishlist_icon = isset( $settings['wpte_product_layout_wishlist_icon_switcher'] ) ? $settings['wpte_product_layout_wishlist_icon_switcher'] : '';

		// Quick View.
		$is_quickview_icon = isset( $settings['wpte_product_layout_quickview_icon_switcher'] ) ? $settings['wpte_product_layout_quickview_icon_switcher'] : '';

		$showCat    = isset( $settings['wpte_general_products_show_cat'] ) ? $settings['wpte_general_products_show_cat'] : '';
		$showTitle  = isset( $settings['wpte_general_products_show_title'] ) ? $settings['wpte_general_products_show_title'] : '';
		$showRating = isset( $settings['wpte_general_products_show_rating'] ) ? $settings['wpte_general_products_show_rating'] : '';
		$showImage  = isset( $settings['wpte_general_products_show_image'] ) ? $settings['wpte_general_products_show_image'] : '';
		$showPrice  = isset( $settings['wpte_general_products_show_price'] ) ? $settings['wpte_general_products_show_price'] : '';
		$showIcons  = isset( $settings['wpte_general_products_show_icons'] ) ? $settings['wpte_general_products_show_icons'] : '';
		$showBadge  = isset( $settings['wpte_general_products_show_badge'] ) ? $settings['wpte_general_products_show_badge'] : '';
		$image_size = isset( $settings['wpte_product_layout_general_style_4_image_size'] ) ? $settings['wpte_product_layout_general_style_4_image_size'] : '';

		$query = new \WP_Query( $args );

		if ( $query->have_posts() ) {
			$found_posts      = $query->found_posts;
			$max_page         = ceil( $found_posts / absint( $args['posts_per_page'] ) );
			$args['max_page'] = $max_page;
			?>
			<div class="wpte-product-column wpte-product-general-style-4-column <?php echo esc_attr( $column ); ?>">
			<?php
			while ( $query->have_posts() ) {
				$query->the_post();
				$product = wc_get_product( get_the_ID() );
				if ( ! $product ) {
					echo esc_html__( 'Product not found!', 'wpte-product-layout' );
					return;
				}

				$catArgs = [
					'orderby' => 'name',
				];

				$product_cats         = wp_get_post_terms( get_the_ID(), 'product_cat', $catArgs );
				$product_cats_counter = count( $product_cats );
				$img_href             = 'a' === $hyperlink ? 'href="' . esc_url( $product->get_permalink() ) . '"' : '';
				$product_image        = $product->get_image( "$image_size", [ 'loading' => 'eager' ] ) ? wp_kses_post( $product->get_image( "$image_size", [ 'loading' => 'eager' ] ) ) : '';
				?>

				<div class="wpte-general-layout-row wpte-product-general-style-4 wpte-swiper-slide">
					<div class="wpte-general-layout-image-area">
						<?php
						if ( $showBadge ) {
							$this->wpte_product_badge_label();
						}
						if ( $showImage ) :
							?>
						<div class="wpte-general-layout-product-img">
							<div class="wpte-general-layout-product-thumb">
								<?php
								printf(
                                    '<%1$s %2$s %3$s %4$s>%5$s</%1$s>',
                                    esc_html( $hyperlink ),
                                    wp_kses( $img_href, true ),
                                    wp_kses( $new_window, true ),
                                    wp_kses( $nofollow, true ),
                                    wp_kses_post( $product_image )
                                );

								if ( $is_quickview_icon ) :
									?>
								<div class="wpte-general-layout-quickview-icons wpte-general-layout-product-view wpte-product-layouts-top-quick-view">
									<?php
									$quick_view_icon = $this->wpte_product_quickview_render( get_the_ID(), 'icon', $settings, 'right' ); // $operator = icon, text, icontext // $IconPosition = top, right, bottom, left.
									echo wp_kses( $quick_view_icon, wpte_allow_icons_html() );
									?>
								</div>
								<?php endif; ?>
							</div>
						</div>
						<?php endif; if ( $showIcons ) : ?>
						<div class="wpte-general-layout-product-button-icons wpte-general-layout-icon-bottom">
							<?php if ( $is_icon ) : ?>
								<div class="wpte-general-layout-button-icons wpte-general-layout-product-button-cart">
									<?php
									$this->wpte_product_cart_render( get_the_ID(), 'icontext', $settings ); // $operator = icon, text, icontext
									?>
								</div>
								<?php
							endif;
							if ( $is_wishlist_icon && class_exists( 'TInvWL_Admin_Base' ) ) :
								?>
								<div class="wpte-general-layout-button-icons wpte-general-layout-product-button-wishlist">
									<?php
									$wishlist_icon = $this->wpte_product_wishlist_render( get_the_ID(), 'icontext', $settings ); // $operator = icon, text, icontext // $IconPosition = top, right, bottom, left.
									echo wp_kses( (string) $wishlist_icon, wpte_allow_wishlist_html() );
									?>
								</div>
							<?php endif; ?>
						</div>
						<?php endif; ?>
					</div>
					<?php if ( $showCat ) : ?>
					<div class="wpte-general-layout-category-area">
						<?php
						for ( $i = 0; $i < $product_cats_counter; $i++ ) {
							$_cat_link = get_term_link( $product_cats[ $i ]->term_id, 'product_cat' );
							$cat_link  = esc_url( $_cat_link );
							$cat_name  = esc_html( $product_cats[ $i ]->name );
							echo "<a href='" . esc_url( $cat_link ) . "'>" . esc_html( $cat_name ) . '</a>';
						}
						?>
					</div>
						<?php
					endif;
					if ( $showTitle ) :
						?>
					<div class="wpte-general-layout-title-area">
						<<?php echo esc_html( $title_tag ); ?> class="wpte-general-layout-product-title">
							<?php printf( '<a href="%1$s">%2$s</a>', esc_url( $product->get_permalink() ), wp_kses_post( $product->get_title() ) ); ?>
						</<?php echo esc_html( $title_tag ); ?>>
					</div>
						<?php
					endif;
					if ( $showPrice ) :
						?>
					<div class="wpte-general-layout-price-area">
						<?php echo wp_kses_data( wpte_get_product_price( $product ) ); ?>
					</div>

						<?php
					endif;
					if ( $showRating ) :
						?>
					<div class="wpte-general-layout-rating-area">
						<?php echo wp_kses_post( (string) product_rating_render( $product ) ); ?>
					</div>
					<?php endif; ?>
				</div>
				<?php
			}
			wp_reset_postdata();
			echo '</div>';
		}
	}
}

