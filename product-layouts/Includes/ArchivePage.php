<?php

namespace WPTE_PRODUCT_LAYOUT\Includes;

/**
 * Archive Handler Class
 *
 * @since 1.2.5
 */
class ArchivePage {

    /**
     * Archive Page class constructor
     *
     * @since 1.2.5
     */
    public function __construct() {
		$wpte_pl_settings = get_option( 'wpte_pl_settings' ) ? get_option( 'wpte_pl_settings' ) : [];
		$layout_id        = isset( $wpte_pl_settings['wpte-settings-category-select'] ) && $wpte_pl_settings['wpte-settings-category-select'] ? $wpte_pl_settings['wpte-settings-category-select'] : '';
        
		if ( $layout_id && wpte_version_control() ) {
			add_action('template_include', [$this, 'wpte_custom_category_template']);
			add_filter('woocommerce_locate_template', [$this, 'wpte_force_custom_template'], 10, 3);
			add_shortcode( 'wpte_product_layout_for_category_page', [ $this, 'wpte_product_layout_for_category_page' ] );
		}

    }

    /**
     * Custom Category Template
     *
     * @since 1.2.5
     */
    public function wpte_custom_category_template( $template ) {
		if ( is_tax('product_cat') ) {
			$custom_template = plugin_dir_path(__FILE__) . 'Woocommerce/custom-product-category.php';
			if ( file_exists( $custom_template ) ) {
				return $custom_template;
			}
		}
		return $template;
	}
	

    /**
     * Force WooCommerce to Use Custom Template
     *
     * @since 1.2.5
     */
    public function wpte_force_custom_template( $template, $template_name, $template_path ) {
        if ( $template_name === 'archive-product.php' && is_tax('product_cat') ) {
            $custom_template = plugin_dir_path(__FILE__) . 'Woocommerce/custom-product-category.php';
            if ( file_exists( $custom_template ) ) {
                return $custom_template;
            }
        }
        return $template;
    }

    /**
     * Shortcode for Product Category page.
     *
     * @since 1.2.5
     */
    public function wpte_product_layout_for_category_page() {

		$html = '';

		$current_category = get_queried_object();

		if ( $current_category && ! is_wp_error( $current_category ) ) {

			$wpte_pl_settings = get_option( 'wpte_pl_settings' ) ? get_option( 'wpte_pl_settings' ) : [];

			$filter_id = isset( $wpte_pl_settings['wpte-settings-filter-select'] ) && $wpte_pl_settings['wpte-settings-filter-select'] ? $wpte_pl_settings['wpte-settings-filter-select'] : '';
			$layout_id = isset( $wpte_pl_settings['wpte-settings-category-select'] ) && $wpte_pl_settings['wpte-settings-category-select'] ? $wpte_pl_settings['wpte-settings-category-select'] : '';

			$cat_id   = $current_category->term_id;

			$html .= "<div class='wpte-pl-cat-page-filter'>";
			$html .= do_shortcode( "[wpte_product_layout catid=$cat_id id=$filter_id]" );
			$html .= "</div>";
			$html .= "<div class='wpte-pl-cat-page-layout'>";
			$html .= do_shortcode( "[wpte_product_layout catid=$cat_id id=$layout_id]" );
			$html .= "</div>";

		} else {
			$html .= 'No category selected.';
		}

        return $html;
    }
}
