<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin;

/**
 * Class Plugin_Page.
 *
 * @since 1.0.0
 */
class Plugin_Page {

	/**
	 * Wpdb
	 *
	 * @var mixed
	 */
	public $wpdb;

	/**
	 * Parent_table
	 *
	 * @var mixed
	 */
	public $parent_table;

	/**
	 * Method Module_Page
	 *
	 * @return void
	 */
	public function module_page() {

		global $wpdb;
		$this->wpdb         = $wpdb;
		$this->parent_table = $wpdb->prefix . 'wpte_product_layout_style';

		$layouts = ( ! empty( $_GET['layouts'] ) ? sanitize_text_field( wp_unslash( $_GET['layouts'] ) ) : '' );
		$layouts = ucfirst( $layouts );
		$styleid = ( ! empty( $_GET['styleid'] ) ? sanitize_text_field( (int) wp_unslash( $_GET['styleid'] ) ) : '' );

		if ( ! empty( $layouts ) && ! empty( $styleid ) ) :
			$style = $wpdb->get_row( $wpdb->prepare( 'SELECT style_name FROM ' . $wpdb->prefix . 'wpte_product_layout_style WHERE id = %d ', $styleid ), ARRAY_A );

			$name = explode( '-', $style['style_name'] );

			if ( $layouts !== ucfirst( $name[0] ) ) :
				$url = admin_url( "admin.php?page=product-layouts&layouts=$name[0]&styleid=$styleid" );
				echo esc_url( $url );
				echo '<script type="text/javascript"> document.location.href="' . esc_url( $url ) . '"; </script>';
				exit;
			endif;
			$cls = '\WPTE_PRODUCT_LAYOUT\Layouts\\' . $layouts . '\Backend\\Layout' . $name[1];
			if ( class_exists( $cls ) ) :
				new $cls();
			endif;
		elseif ( ! empty( $layouts ) ) :
			$cls = '\WPTE_PRODUCT_LAYOUT\Layouts\\' . $layouts . '\\' . $layouts . '';
			if ( class_exists( $cls ) ) :
				new $cls();
			endif;
		else :
			new Pages\ProductLayout();
		endif;
	}
}
