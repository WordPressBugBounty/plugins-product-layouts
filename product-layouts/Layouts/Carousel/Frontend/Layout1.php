<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\Carousel\Frontend;

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
		wp_enqueue_style( 'wpte-swiperjs-slider-style', WPTE_WPL_ASSETS . 'lib/swiperjs/swiper-bundle.min.css', null, filemtime( WPTE_WPL_PATH . 'assets/lib/swiperjs/swiper-bundle.min.css' ), false );
		wp_enqueue_script( 'wpte-swiperjs-slider', WPTE_WPL_ASSETS . 'lib/swiperjs/swiper-bundle.min.js', [ 'jquery' ], filemtime( WPTE_WPL_PATH . 'assets/lib/swiperjs/swiper-bundle.min.js' ), true );
		$this->jshandle = 'wpte-product-layout-swiperjs';
	}

	/**
	 * Method layout_render.
	 *
	 * @param mixed  $settings .
	 * @param string $user .
	 * @return void
	 */
	public function layout_render( $settings, $user ) {

		global $wpdb;

		$shortcode_id = isset( $settings['wpte_product_layout_carousel_style'] ) ? $settings['wpte_product_layout_carousel_style'] : '';
		$user         = 'admin';
		$db_data      = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'wpte_product_layout_style WHERE id = %d ', $shortcode_id ), ARRAY_A );
		$style_name   = explode( '-', ucfirst( $db_data['style_name'] ) );
		$cls          = '\WPTE_PRODUCT_LAYOUT\Layouts\\' . $style_name[0] . '\Frontend\Layout' . $style_name[1];
		?>
		<div class="wpte-product-layouts-carousel-wrapper">
			<?php
			if ( wpte_version_control() ) {
				$clas = new $cls( $db_data, $user );
			}

			?>
		</div>
		<?php

		$lap = isset( $settings['wpte_carousel_slider_per_view-lap-size'] ) && '' !== $settings['wpte_carousel_slider_per_view-lap-size'] ? $settings['wpte_carousel_slider_per_view-lap-size'] : 4;
		$tab = isset( $settings['wpte_carousel_slider_per_view-tab-size'] ) && '' !== $settings['wpte_carousel_slider_per_view-tab-size'] ? $settings['wpte_carousel_slider_per_view-tab-size'] : 2;
		$mob = isset( $settings['wpte_carousel_slider_per_view-mob-size'] ) && '' !== $settings['wpte_carousel_slider_per_view-mob-size'] ? $settings['wpte_carousel_slider_per_view-mob-size'] : 1;

		$space_between_lap = isset( $settings['wpte_carousel_slider_space_between-lap-size'] ) && '' !== $settings['wpte_carousel_slider_space_between-lap-size'] ? $settings['wpte_carousel_slider_space_between-lap-size'] : 20;
		$space_between_tab = isset( $settings['wpte_carousel_slider_space_between-tab-size'] ) && '' !== $settings['wpte_carousel_slider_space_between-tab-size'] ? $settings['wpte_carousel_slider_space_between-tab-size'] : 20;
		$space_between_mob = isset( $settings['wpte_carousel_slider_space_between-mob-size'] ) && '' !== $settings['wpte_carousel_slider_space_between-mob-size'] ? $settings['wpte_carousel_slider_space_between-mob-size'] : 10;

		$lap_item = isset( $settings['wpte_carousel_slide_to_scroll-lap-size'] ) && '' !== $settings['wpte_carousel_slide_to_scroll-lap-size'] ? $settings['wpte_carousel_slide_to_scroll-lap-size'] : 3;
		$tab_item = isset( $settings['wpte_carousel_slide_to_scroll-tab-size'] ) && '' !== $settings['wpte_carousel_slide_to_scroll-tab-size'] ? $settings['wpte_carousel_slide_to_scroll-tab-size'] : 2;
		$mob_item = isset( $settings['wpte_carousel_slide_to_scroll-mob-size'] ) && '' !== $settings['wpte_carousel_slide_to_scroll-mob-size'] ? $settings['wpte_carousel_slide_to_scroll-mob-size'] : 1;

		$prev = '<i class="' . $settings['wpte_carousel_left_arrow'] . '"></i>';
		$next = '<i class="' . $settings['wpte_carousel_right_arrow'] . '"></i>';

		$_autoplay       = isset( $settings['carousel_autoplay'] ) && 'yes' === $settings['carousel_autoplay'] ? true : false;
		$autoplayspeed   = isset( $settings['carousel_autoplay_speed'] ) ? $settings['carousel_autoplay_speed'] : 2000;
		$speed           = isset( $settings['carousel_speed'] ) ? $settings['carousel_speed'] : 500;
		$_pause_on_hover = isset( $settings['carousel_pause_on_hover'] ) && 'yes' === $settings['carousel_pause_on_hover'] ? true : false;
		$infinite        = isset( $settings['carousel_infinite'] ) && 'yes' === $settings['carousel_infinite'] ? 'true' : 'false';
		$adaptiveheight  = isset( $settings['carousel_adaptive_height'] ) && 'yes' === $settings['carousel_adaptive_height'] ? 'true' : 'false';
		$center_mode     = isset( $settings['carousel_center_mode'] ) && 'yes' === $settings['carousel_center_mode'] ? 'true' : 'false';

		$_arrows = isset( $settings['carousel_show_arrows'] ) && 'yes' === $settings['carousel_show_arrows'] ? true : false;
		$_dots   = isset( $settings['carousel_show_dots'] ) && 'yes' === $settings['carousel_show_dots'] ? true : false;

		$dots = $dot_class = $arrow_class = $arrows = $autoplay = $pause_on_hover = $paly_on_hover_leave = '';

		if ( $_autoplay ) {
			$autoplay = 'autoplay: {
				delay: ' . $autoplayspeed . ',
			  },';
		}
		if ( $_pause_on_hover ) {
			$pause_on_hover = 'swiper.el.addEventListener("mouseenter", function() {
				swiper.autoplay.stop();
			});';
			if ( $_autoplay ) {
				$paly_on_hover_leave = 'swiper.el.addEventListener("mouseleave", function() {
					swiper.autoplay.start();
				});';
			}
		}
		if ( $_arrows ) {
			$arrow_class = '$(".' . $this->WRAPPER . ' .wpte-product-layout-wrapper-' . $shortcode_id . ' .wpte-product-row").append(\'<div class="wpte_carousel_arrows wpte_carousel_prev wpte_carousel_prev-' . $shortcode_id . '">' . $prev . '</div><div class="wpte_carousel_arrows wpte_carousel_next wpte_carousel_next-' . $shortcode_id . '">' . $next . '</div>\');';
			$arrows = 'navigation: {
				nextEl: ".wpte_carousel_next-' . $shortcode_id . '",
				prevEl: ".wpte_carousel_prev-' . $shortcode_id . '",
			  },';
		}
		if ( $_dots ) {
			$dot_class = '$(".' . $this->WRAPPER . ' .wpte-product-layout-wrapper-' . $shortcode_id . ' .wpte-product-row").append(\'<div class="wpte-swiper-pagination  wpte-swiper-pagination-' . $shortcode_id . '"></div>\');';
			$dots = 'pagination: {
				el: ".wpte-swiper-pagination-' . $shortcode_id . '",
				clickable: true,
			},';
		}

		$jquery = ';(function ($) {
			$(document).ready(function(){
				$(".' . $this->WRAPPER . ' .wpte-product-column").addClass("swiper-wrapper");
				$(".' . $this->WRAPPER . ' .wpte-product-layout-wrapper-' . $shortcode_id . ' .wpte-swiper-slide").addClass("swiper-slide");
				$(".' . $this->WRAPPER . ' .wpte-product-layout-wrapper-' . $shortcode_id . ' .wpte-product-load").addClass("swiper wpte-product-carousel-layout-' . $shortcode_id . '");
				' . $arrow_class . '
				' . $dot_class . '
				$(".' . $this->WRAPPER . ' .wpte-product-layout-wrapper-' . $shortcode_id . ' .wpte-product-row .wpte-product-column").css({
					"grid-column-gap":"0px", 
					"grid-row-gap":"0px"
				});
				$(".' . $this->WRAPPER . ' .wpte-product-layout-wrapper-' . $shortcode_id . ' .wpte-swiper-slide").css({
					"display":"grid"
				});

				var swiper = new Swiper(".wpte-product-carousel-layout-' . $shortcode_id . '", {
					centeredSlides: ' . $center_mode . ',
					slidesPerView: ' . $lap . ',
					slidesPerGroup: ' . $lap_item . ',
					spaceBetween: ' . $space_between_lap . ',
					' . $autoplay . '
					loop: ' . $infinite . ',
					speed: ' . $speed . ',
					autoHeight: ' . $adaptiveheight . ',
					' . $arrows . '
					' . $dots . '
					breakpoints: {
						// when window width is >= 320px
						320: {
						slidesPerView: ' . $mob . ',
						slidesPerGroup: ' . $mob_item . ',
						spaceBetween: ' . $space_between_mob . '
						},
						480: {
						slidesPerView: ' . $tab . ',
						slidesPerGroup: ' . $tab_item . ',
						spaceBetween: ' . $space_between_tab . '
						},
						768: {
						slidesPerView: ' . $lap . ',
						slidesPerGroup: ' . $lap_item . ',
						spaceBetween: ' . $space_between_lap . '
						},
					},
				});
				' . $pause_on_hover . '
				' . $paly_on_hover_leave . '
			});
		})(jQuery);';

		wp_register_script( 'wpte-product-layout-swiperjs', null, null, WPTE_WPL_VERSION, true );
		wp_enqueue_script( 'wpte-product-layout-swiperjs' );
		wp_add_inline_script( 'wpte-product-layout-swiperjs', $jquery );
	}
}
