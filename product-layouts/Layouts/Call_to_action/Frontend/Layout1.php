<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\Call_to_action\Frontend;

use WPTE_PRODUCT_LAYOUT\Includes\Helper\Public_Render;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Layout1
 */
class Layout1 extends Public_Render {

	/**
	 * Method public_css
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

		$column  = 'wpte-product-card ' . $this->column_render( 'wpte_product_layout_col', $settings );
		$args    = $this->wpte_get_woo_products( $settings ) ?? [];
		$is_icon = isset( $settings['wpte_product_layout_cart_icon_switcher'] ) ? $settings['wpte_product_layout_cart_icon_switcher'] : '';

		$title_tag   = isset( $settings['wpte_product_layout_call_to_action_title_tag'] ) ? $settings['wpte_product_layout_call_to_action_title_tag'] : 'h2';
		$_hyperlink  = isset( $settings['wpte-product-call-to-action-image-hyperlink'] ) ? $settings['wpte-product-call-to-action-image-hyperlink'] : 'div';
		$_new_window = isset( $settings['wpte-product-call-to-action-image-open-new-window'] ) ? $settings['wpte-product-call-to-action-image-open-new-window'] : '';
		$_nofollow   = isset( $settings['wpte-product-call-to-action-image-nofollow'] ) ? $settings['wpte-product-call-to-action-image-nofollow'] : '';

		$hyperlink  = 'yes' === $_hyperlink ? 'a' : 'div';
		$new_window = 'a' === $hyperlink && 'yes' === $_new_window ? 'target="_blank"' : '';
		$nofollow   = 'a' === $hyperlink && 'yes' === $_nofollow ? 'rel="nofollow"' : '';

		// Wish List.
		$is_wishlist_icon = isset( $settings['wpte_product_layout_wishlist_icon_switcher'] ) ? $settings['wpte_product_layout_wishlist_icon_switcher'] : '';

		// Quick View.
		$is_quickview_icon = isset( $settings['wpte_product_layout_quickview_icon_switcher'] ) ? $settings['wpte_product_layout_quickview_icon_switcher'] : '';

		// Cart.
		$is_cart_icon = isset( $settings['wpte_product_layout_cart_icon_switcher'] ) ? $settings['wpte_product_layout_cart_icon_switcher'] : '';

		// Compare.
		$show_compare = isset( $settings['wpte_product_layout_compare_icon_switcher'] ) ? $settings['wpte_product_layout_compare_icon_switcher'] : '';

		// Show and Hide.
		$showCat      = isset( $settings['wpte_call_to_action_products_show_cat'] ) ? $settings['wpte_call_to_action_products_show_cat'] : '';
		$showTitle    = isset( $settings['wpte_call_to_action_products_show_title'] ) ? $settings['wpte_call_to_action_products_show_title'] : '';
		$showRating   = isset( $settings['wpte_call_to_action_products_show_rating'] ) ? $settings['wpte_call_to_action_products_show_rating'] : '';
		$showImage    = isset( $settings['wpte_call_to_action_products_show_image'] ) ? $settings['wpte_call_to_action_products_show_image'] : '';
		$showPrice    = isset( $settings['wpte_call_to_action_products_show_price'] ) ? $settings['wpte_call_to_action_products_show_price'] : '';
		$showIcons    = isset( $settings['wpte_general_products_show_icons'] ) ? $settings['wpte_general_products_show_icons'] : '';
		$show_badge   = isset( $settings['wpte_call_to_action_products_show_badge'] ) ? $settings['wpte_call_to_action_products_show_badge'] : '';
		$image_size   = isset( $settings['wpte_product_layout_call_to_action_style_1_image_size'] ) ? $settings['wpte_product_layout_call_to_action_style_1_image_size'] : '';
		$iconPosition = isset( $settings['wpte_product_layout_icon_position'] ) ? $settings['wpte_product_layout_icon_position'] : '';

		$query = new \WP_Query( $args );

		if ( $query->have_posts() ) {
			$found_posts      = $query->found_posts;
			$max_page         = ceil( $found_posts / absint( $args['posts_per_page'] ) );
			$args['max_page'] = $max_page;
			?>
			<div class="wpte-product-column wpte-product-call-to-column <?php echo esc_attr( $column ); ?>">
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

				$product_cats          = wp_get_post_terms( get_the_ID(), 'product_cat', $catArgs );
				$product_cats_counter  = count( $product_cats );
				$img_href              = 'a' === $hyperlink ? 'href="' . esc_url( $product->get_permalink() ) . '"' : '';
				$product_image         = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'single-post-thumbnail' ) ? wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), "$image_size" ) : '';
				$product_gallery_image = isset( $product->get_gallery_image_ids()[0] ) ? wp_kses_post( wp_get_attachment_image_url( $product->get_gallery_image_ids()[0], "$image_size" ) ) : '';
				$hoverImage            = $product_gallery_image ? 'wpte-call-to-action-layout-product-hover-image' : '';
				$hoverGimage           = $product_gallery_image ? 'wpte-call-to-action-layout-product-hover-g-image' : '';

				?>

				<div class="wpte-call-to-action-layout-row wpte-call-to-action-layout-style-1 wpte-swiper-slide">
					<div class="wpte-call-to-action-layout-image-area">
						<?php
						if ( $show_badge ) {
							$this->wpte_product_badge_label();
						}
						if ( $showImage ) :
							printf(
                                '<%1$s %2$s %3$s %4$s class="wpte-call-to-action-layout-product-img">
								<div class="wpte-call-to-action-layout-product-thumb %5$s" style="background-image:url(%6$s)"></div>
								<div class="wpte-call-to-action-layout-product-gallery-thumb %7$s" style="background-image:url(%8$s)"></div>
							</%1$s>',
                                esc_html( $hyperlink ),
                                wp_kses( $img_href, true ),
                                wp_kses( $new_window, true ),
                                wp_kses( $nofollow, true ),
                                esc_attr( $hoverImage ),
                                wp_kses_post( $product_image[0] ),
                                esc_attr( $hoverGimage ),
                                wp_kses_post( $product_gallery_image )
							);
						endif;
						if ( $showIcons ) :
							?>
						<div class="wpte-call-to-action-layout-product-icons wpte-call-to-action-layout-icon-bottom">
								<?php if ( $is_wishlist_icon && class_exists( 'TInvWL_Admin_Base' ) ) : ?>
								<div class="wpte-call-to-action-layout-icons wpte-call-to-action-layout-product-wishlist">
									<?php
										$wpte_wishlist_icon = $this->wpte_product_wishlist_render( get_the_ID(), 'icon', $settings, 'bottom' ); // $operator = icon, text, icontext // $IconPosition = top, right, bottom, left.
										echo wp_kses( (string) $wpte_wishlist_icon, wpte_allow_wishlist_html() );
									?>
								</div>
								<?php endif; if ( $show_compare === 'yes' ) : ?>
								<div class="wpte-call-to-action-layout-icons wpte-call-to-action-layout-product-compare">
									<?php
										$wpte_compare_icon = $this->wpte_product_compare_render( get_the_ID(), 'icon', $settings, 'bottom' ); // $operator = icon, text, icontext // $IconPosition = top, right, bottom, left.
										echo wp_kses( (string) $wpte_compare_icon, wpte_allow_icons_html() );
									?>
								</div>
								<?php endif; if ( $is_quickview_icon ) : ?>
								<div class="wpte-call-to-action-layout-icons wpte-call-to-action-layout-product-view wpte-product-layouts-quick-view">
									<?php
										$wpte_quick_view_icon = $this->wpte_product_quickview_render( get_the_ID(), 'icon', $settings, 'bottom' ); // $operator = icon, text, icontext // $IconPosition = top, right, bottom, left.
										echo wp_kses( (string) $wpte_quick_view_icon, wpte_allow_icons_html() );
									?>
								</div>
							<?php endif; ?>
						</div>
						<?php endif; ?>
					</div>
					<div class="wpte-call-to-action-content-wrapper">
						<div class="wpte-call-to-action-content">
							<?php if ( $showCat ) : ?>
							<div class="wpte-call-to-action-layout-category-area">
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
							<div class="wpte-call-to-action-layout-title-area">
								<<?php echo esc_html( $title_tag ); ?> class="wpte-call-to-action-layout-product-title">
									<?php printf( '<a href="%1$s">%2$s</a>', esc_url( $product->get_permalink() ), wp_kses_post( $product->get_title() ) ); ?>
								</<?php echo esc_html( $title_tag ); ?>>
							</div>
								<?php
								endif;
							if ( $showRating ) :
								?>
							<div class="wpte-call-to-action-layout-rating-area">
								<?php echo wp_kses_post( (string) product_rating_render( $product ) ); ?>
							</div>
								<?php
								endif;
							if ( $showPrice ) :
								?>
							<div class="wpte-call-to-action-layout-price-area">
								<?php echo wp_kses_data( wpte_get_product_price( $product ) ); ?>
							</div>
								<?php endif; if ( $is_icon ) : ?>
							<div class="wpte-call-to-action-layout-product-cart-icons">
								<div class="wpte-call-to-action-layout-icons-cart wpte-call-to-action-layout-product-cart">
									<?php
									$this->wpte_product_cart_render( get_the_ID(), 'icontext', $settings ); // $operator = icon, text, icontext.
									?>
								</div>
							</div>
							<?php endif; ?>
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
