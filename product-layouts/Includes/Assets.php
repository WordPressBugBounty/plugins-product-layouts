<?php

namespace WPTE_PRODUCT_LAYOUT\Includes;

/**
 * Assets Handler Class
 *
 * @since 1.0.0
 */
class Assets {

	/**
	 * Assets class constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scriptss' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'public_enqueue_scripts' ] );
	}

	/**
	 * Method admin_enqueue_scriptss.
	 *
	 * @since 1.0.0
	 */
	public function admin_enqueue_scriptss() {
		$this->admin_enqueue_css();
		$this->global_enqueue_css();
		$this->admin_enqueue_js();
		$this->library_enqueue_js();
	}

	/**
	 * Method public_enqueue_scripts.
	 *
	 * @since 1.0.0
	 */
	public function public_enqueue_scripts() {
		$this->global_enqueue_css();
		$this->library_enqueue_js();
	}

	/**
	 * Method admin_enqueue_css.
	 *
	 * @since 1.0.0
	 */
	public function admin_enqueue_css() {

		$current_screen = get_current_screen()->id;
		$current_page   = isset( $_GET['page'] ) && $_GET['page'] ? $_GET['page'] : '';

		if (
			'toplevel_page_product-layouts' === $current_screen ||
			'product-layouts-shortcode' === $current_page ||
			'product-layouts-settings' === $current_page ||
			'product-layouts-getting-started' === $current_page ||
			'product-layouts-status' === $current_page
			) {
			wp_enqueue_style( 'wpte-wpl-select2-css', WPTE_WPL_ASSETS . 'lib/select2/select2.min.css', null, filemtime( WPTE_WPL_PATH . 'assets/lib/select2/select2.min.css' ) );
			wp_enqueue_style( 'wpte-wpl-admin-style', WPTE_WPL_ASSETS . 'backend/css/admin.css', null, filemtime( WPTE_WPL_PATH . 'assets/backend/css/admin.css' ) );
			wp_enqueue_style( 'wpte-wpl-top-menu', WPTE_WPL_ASSETS . 'backend/css/top-menu.css', null, filemtime( WPTE_WPL_PATH . 'assets/backend/css/top-menu.css' ) );
		}

		if ( 'toplevel_page_product-layouts' === $current_screen && isset( $_GET['layouts'] ) && isset( $_GET['styleid'] ) ) {
			wp_enqueue_style( 'wpte-wpl-select2-css', WPTE_WPL_ASSETS . 'lib/select2/select2.min.css', null, filemtime( WPTE_WPL_PATH . 'assets/lib/select2/select2.min.css' ) );
			wp_enqueue_style( 'wpte-gradient-color-style', WPTE_WPL_ASSETS . 'lib/jquerygcolor/jquery.coloring-pick.min.css', null, filemtime( WPTE_WPL_PATH . 'assets/lib/jquerygcolor/jquery.coloring-pick.min.css' ) );
			wp_enqueue_style( 'wpte-minicolor-style', WPTE_WPL_ASSETS . 'lib/minicolor/minicolors.css', null, filemtime( WPTE_WPL_PATH . 'assets/lib/minicolor/minicolors.css' ) );
			wp_enqueue_style( 'wpte-jquery-ui', WPTE_WPL_ASSETS . 'lib/jQuery-ui/jquery-ui.css', null, filemtime( WPTE_WPL_PATH . 'assets/lib/jQuery-ui/jquery-ui.css' ) );
			wp_enqueue_style( 'wpte-cart-icon-style', WPTE_WPL_ASSETS . 'lib/icons/wpte-cart-icon.css', null, filemtime( WPTE_WPL_PATH . 'assets/lib/icons/wpte-cart-icon.css' ) );
			wp_enqueue_style( 'wpte-icon-picker', WPTE_WPL_ASSETS . 'lib/iconpicker/fontawesome-iconpicker.css', null, filemtime( WPTE_WPL_PATH . 'assets/lib/iconpicker/fontawesome-iconpicker.css' ) );
			wp_enqueue_style( 'wpte-nouislider-style', WPTE_WPL_ASSETS . 'lib/nouislider/nouislider.css', null, filemtime( WPTE_WPL_PATH . 'assets/lib/nouislider/nouislider.css' ) );
			wp_enqueue_style( 'wpte-single-layout-editor', WPTE_WPL_ASSETS . 'backend/css/wpte-single-layout-editor.css', null, filemtime( WPTE_WPL_PATH . 'assets/backend/css/wpte-single-layout-editor.css' ) );
		}

		if ( 'toplevel_page_product-layouts' === $current_screen && ! isset( $_GET['layouts'] ) && ! isset( $_GET['styleid'] ) ) {
			wp_enqueue_style( 'wpte-wpl-product-layout', WPTE_WPL_ASSETS . 'backend/css/product-layout.css', null, filemtime( WPTE_WPL_PATH . 'assets/backend/css/product-layout.css' ) );
		}

		if ( 'product-layouts-getting-started' === $current_page || 'product-layouts-shortcode' === $current_page || ( 'toplevel_page_product-layouts' === $current_screen && isset( $_GET['layouts'] ) && ! isset( $_GET['styleid'] ) ) ) {
			wp_enqueue_style( 'wpte-wpl-bootstrap-css', WPTE_WPL_ASSETS . 'lib/bootstrap/bootstrap.min.css', null, filemtime( WPTE_WPL_PATH . 'assets/lib/bootstrap/bootstrap.min.css' ) );
		}

		wp_enqueue_style( 'wpte-wpl-admin-global-style', WPTE_WPL_ASSETS . 'backend/css/admin-global.css', null, filemtime( WPTE_WPL_PATH . 'assets/backend/css/admin-global.css' ) );
	}

	/**
	 * Method public_enqueue_css.
	 *
	 * @since 1.0.0
	 */
	public function public_enqueue_css() {
	}

	/**
	 * Method global_enqueue_css.
	 *
	 * @since 1.0.0
	 */
	public function global_enqueue_css() {
		wp_enqueue_style( 'wpte-font-picker', WPTE_WPL_ASSETS . 'lib/fontpicker/jquery.fontselect.min.css', null, filemtime( WPTE_WPL_PATH . 'assets/lib/fontpicker/jquery.fontselect.min.css' ) );
		wp_enqueue_style( 'wpte-cart-icon-style', WPTE_WPL_ASSETS . 'lib/icons/wpte-cart-icon.css', null, filemtime( WPTE_WPL_PATH . 'assets/lib/icons/wpte-cart-icon.css' ) );
		wp_enqueue_style( 'wpte-product-layouts-style', WPTE_WPL_ASSETS . 'global/css/wpte-product-layouts.css', null, filemtime( WPTE_WPL_PATH . 'assets/global/css/wpte-product-layouts.css' ) );
		wp_enqueue_style( 'wpte-cart-icon-animation-style', WPTE_WPL_ASSETS . 'lib/icons/animation.css', null, filemtime( WPTE_WPL_PATH . 'assets/lib/icons/animation.css' ) );
	}

	/**
	 * Admin JS List
	 *
	 * @since 1.0.0
	 */
	public function admin_assets_js() {
		return [
			[
				'handler'   => 'wpte-wpl-editor',
				'src'       => 'backend/js/editor.js',
				'deps'      => [ 'jquery' ],
				'in_footer' => true,
			],
			[
				'handler'   => 'wpte-wpl-create-js',
				'src'       => 'backend/js/create.js',
				'deps'      => [ 'jquery' ],
				'in_footer' => true,
			],
			[
				'handler'   => 'wpte-wpl-admin-js',
				'src'       => 'backend/js/admin.js',
				'deps'      => [ 'jquery' ],
				'in_footer' => true,
			],
			[
				'handler'   => 'wpte-wpl-settings-js',
				'src'       => 'backend/js/settings.js',
				'deps'      => [ 'jquery' ],
				'in_footer' => true,
			],
		];
	}

	/**
	 * Admin Assets Loader
	 *
	 * @since 1.0.0
	 */
	public function admin_enqueue_js() {

		$asset_js = $this->admin_assets_js();

		// Enqueue Admin Js.
		foreach ( $asset_js as $js_list ) {
			wp_register_script( $js_list['handler'], WPTE_WPL_ASSETS . $js_list['src'], $js_list['deps'], filemtime( WPTE_WPL_PATH . 'assets/' . $js_list['src'] ), $js_list['in_footer'] );
		}

		wp_enqueue_script( 'wpte-global-admin-js', WPTE_WPL_ASSETS . 'backend/js/global-admin.js', [ 'jquery' ], filemtime( WPTE_WPL_PATH . 'assets/backend/js/global-admin.js' ), true );
		$popup_data = wpte_get_upgrade_popup_data();

		wp_localize_script(
			'wpte-global-admin-js',
			'wpteoffer',
			[
				'img'         => esc_url( WPTE_WPL_URL . '/Image/' . $popup_data[5] ),
				'u_text'      => $popup_data[0],
				'discount'    => $popup_data[1],
				'description' => $popup_data[2],
				'button_text' => $popup_data[3],
				'button_url'  => $popup_data[4],
			]
		);
	}

	/**
	 * Library JS List
	 *
	 * @since 1.0.0
	 */
	public function library_assets_js() {
		return [
			[
				'handler'   => 'wpte-wpl-bootstrap-js',
				'src'       => 'lib/bootstrap/bootstrap.min.js',
				'deps'      => [ 'jquery' ],
				'in_footer' => true,
			],
			[
				'handler'   => 'wpte-wpl-select2-js',
				'src'       => 'lib/select2/select2.min.js',
				'deps'      => [ 'jquery' ],
				'in_footer' => true,
			],
			[
				'handler'   => 'wpte-serializejson',
				'src'       => 'lib/serializejson/jquery.serializejson.min.js',
				'deps'      => [ 'jquery' ],
				'in_footer' => true,
			],
			[
				'handler'   => 'wpte-nouislider',
				'src'       => 'lib/nouislider/nouislider.js',
				'deps'      => [ 'jquery' ],
				'in_footer' => true,
			],
			[
				'handler'   => 'wpte-minicolors',
				'src'       => 'lib/minicolor/minicolors.js',
				'deps'      => [ 'jquery' ],
				'in_footer' => true,
			],
			[
				'handler'   => 'wpte-gradient-color',
				'src'       => 'lib/jquerygcolor/jquery.coloring-pick.min.js',
				'deps'      => [ 'jquery' ],
				'in_footer' => true,
			],
			[
				'handler'   => 'wpte-icon-picker',
				'src'       => 'lib/iconpicker/fontawesome-iconpicker.js',
				'deps'      => [ 'jquery' ],
				'in_footer' => true,
			],
			[
				'handler'   => 'wpte-condition-js',
				'src'       => 'lib/condition/jquery.conditionize2.min.js',
				'deps'      => [ 'jquery' ],
				'in_footer' => true,
			],
			[
				'handler'   => 'wpte-font-picker-js',
				'src'       => 'lib/fontpicker/jquery.fontselect.min.js',
				'deps'      => [ 'jquery' ],
				'in_footer' => true,
			],
			[
				'handler'   => 'wpte-global-js',
				'src'       => 'global/js/wpte-global.js',
				'deps'      => [ 'jquery' ],
				'in_footer' => true,
			],
			[
				'handler'   => 'wpte-quick-view-js',
				'src'       => 'global/js/wpte-quickview.js',
				'deps'      => [ 'jquery', 'wc-single-product' ],
				'in_footer' => true,
			],
			[
				'handler'   => 'wpte-product-compare',
				'src'       => 'global/js/wpte-product-compare.js',
				'deps'      => [ 'jquery' ],
				'in_footer' => true,
			],

		];
	}

	/**
	 * Library Assets Loader
	 *
	 * @since 1.0.0
	 */
	public function library_enqueue_js() {

		$asset_js = $this->library_assets_js();

		// Enqueue Library Js.
		foreach ( $asset_js as $js_list ) {
			wp_register_script( $js_list['handler'], WPTE_WPL_ASSETS . $js_list['src'], $js_list['deps'], filemtime( WPTE_WPL_PATH . 'assets/' . $js_list['src'] ), $js_list['in_footer'] );
		}

		// Global JS For Localize Script.
		wp_localize_script(
			'wpte-global-js',
			'wpteGlobal',
			[
				'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
				'wpte_nonce' => wp_create_nonce( 'wpte-global-nonce' ),
				'error'      => __( 'Something Went Wrong!', 'wpte-product-layout' ),
			]
		);
	}
}
