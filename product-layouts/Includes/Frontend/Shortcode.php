<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Frontend;

/**
 * Create Shortcode
 *
 * @since 1.0.0
 */
class Shortcode {

	/**
	 * Frontend class constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_shortcode( 'wpte_product_layout', [ $this, 'wpte_product_layout_shotcode_render' ] );
	}

	/**
	 * Shortcode Render
	 *
	 * @param array $attributes .
	 * @since 1.0.0
	 */
	public function wpte_product_layout_shotcode_render( $attributes ) {

        wp_enqueue_script( 'wpte-serializejson' );
        wp_enqueue_script( 'wpte-global-js' );
        // Compare Asset.
        $this->wpte_compare_script_loader();
        // Quick View Asset.
        $this->wpte_quickview_script_loader();

        $id      = isset( $attributes['id'] ) ? $attributes['id'] : '';
        $data    = wpte_get_layout( $id );
        $_dbData = json_decode( wp_json_encode( $data ), true );
        $dbData  = is_array( $_dbData ) ? $_dbData : [];

        // Check if 'catid' key exists in $attributes array
        if ( key_exists( 'catid', $attributes ) ) {
            if ( isset( $dbData['rawdata'] ) ) {
                $rawdata = json_decode( $dbData['rawdata'] ?? '', true );
                if ( is_array( $rawdata ) ) {
                    $rawdata['wpte_product_layout_product_category'] = [ $attributes['catid'] ];
                    $rawdata = wp_json_encode( $rawdata );
                    $dbData['rawdata'] = $rawdata;
                }
            }
        }

        ob_start();
        if ( isset( $dbData['style_name'] ) && ! empty( $dbData['style_name'] ) ) {
            $style = explode( '-', $dbData['style_name'] );
            if ( isset( $style[0] ) && isset( $style[1] ) ) {
                $CLASS = 'WPTE_PRODUCT_LAYOUT\Layouts\\' . ucfirst( $style[0] ) . '\Frontend\Layout' . $style[1];
                if ( class_exists( $CLASS ) ) {
                    new $CLASS( $dbData );
                }
            }
        }

        $html = '<div class="wpte-popup-display"></div>';
        return ( $html . ob_get_clean() );
    }

	/**
	 * Frontend Compare script loader
	 *
	 * @since 1.0.1
	 */
	public function wpte_compare_script_loader() {
		wp_enqueue_script( 'wpte-product-compare' );
	}

	/**
	 * Frontend Quick view script loader
	 *
	 * @since 1.0.1
	 */
	public function wpte_quickview_script_loader() {
		if ( version_compare( WC()->version, '3.0.0', '>=' ) ) {
			if ( current_theme_supports( 'wc-product-gallery-zoom' ) ) {
				wp_enqueue_script( 'zoom' );
			}
			if ( current_theme_supports( 'wc-product-gallery-slider' ) ) {
				wp_enqueue_script( 'flexslider' );
			}
			if ( current_theme_supports( 'wc-product-gallery-lightbox' ) ) {
				wp_enqueue_script( 'photoswipe-ui-default' );
				wp_enqueue_style( 'photoswipe-default-skin' );
				if ( has_action( 'wp_footer', 'woocommerce_photoswipe' ) === false ) {
					add_action( 'wp_footer', 'woocommerce_photoswipe', 15 );
				}
			}
			wp_enqueue_script( 'wc-add-to-cart-variation' );
			wp_enqueue_script( 'wc-single-product' );
		}

		wp_enqueue_script( 'wpte-quick-view-js' );
	}
}
