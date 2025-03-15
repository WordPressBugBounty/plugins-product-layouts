<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin;

/**
 * Admin Menu Class
 *
 * @since 1.0.0
 */
class Menu {

	use Pages\AdminTopMenu;

	/**
	 * Menu class constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'regiter_admin_menu' ] );
		$this->admin_menu();
	}

	/**
	 * Admin Menu Method
	 *
	 * @since 1.0.0
	 */
	public function admin_menu() {
		add_filter( 'wpte_product_layout_admin_menu', [ $this, 'wpte_admin_menu' ] );
	}

	/**
	 * Register Admin Menue
	 *
	 * @return void
	 */
	public function regiter_admin_menu() {
		$user = 'manage_options';
		add_menu_page( __( 'Product Layouts', 'wpte-product-layout' ), __( 'Product Layouts', 'wpte-product-layout' ), $user, 'product-layouts', [ $this, 'plugin_page' ], WPTE_WPL_URL . '/Image/product-layouts-icon.svg', 56 );
		add_submenu_page( 'product-layouts', __( 'Product Layouts', 'wpte-product-layout' ), __( 'Product Layouts', 'wpte-product-layout' ), $user, 'product-layouts', [ $this, 'plugin_page' ] );
		add_submenu_page( 'product-layouts', __( 'Shortcode List', 'wpte-product-layout' ), __( 'Shortcode List', 'wpte-product-layout' ), $user, 'product-layouts-shortcode', [ $this, 'product_shortcode' ] );
		add_submenu_page( 'product-layouts', __( 'Settings', 'wpte-product-layout' ), __( 'Settings', 'wpte-product-layout' ), $user, 'product-layouts-settings', [ $this, 'product_settings' ] );
		add_submenu_page( 'product-layouts', __( 'Getting Started', 'wpte-product-layout' ), __( 'Getting Started', 'wpte-product-layout' ), $user, 'product-layouts-getting-started', [ $this, 'wpte_product_layout_getting_started' ] );
		add_submenu_page( 'product-layouts', __( 'Status', 'wpte-product-layout' ), __( 'Status', 'wpte-product-layout' ), $user, 'product-layouts-status', [ $this, 'wpte_product_layout_status' ] );
	}

	/**
	 * Plugin Admin Menu
	 *
	 * @return void
	 */
	public function plugin_page() {
		$module = new Plugin_Page();
		$module->module_page();
	}

	/**
	 * Plugin Admin SubMenu Shortcode
	 *
	 * @return void
	 */
	public function product_shortcode() {
		apply_filters( 'wpte_product_layout_admin_menu', true );
		$importPage = isset( $_REQUEST['page'] ) && ! empty( $_REQUEST['page'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '';
		$action     = isset( $_REQUEST['action'] ) && ! empty( $_REQUEST['action'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['action'] ) ) : '';
		if ( $importPage === 'product-layouts-shortcode' && $action === 'import' ) {
			new Pages\Layout_list\Import();
		} else {
			new Pages\Layout_list\Shortcode();
			new Pages\Layout_list\Export();
		}
	}

	/**
	 * Plugin Admin SubMenu Settings
	 *
	 * @return void
	 */
	public function product_settings() {
		apply_filters( 'wpte_product_layout_admin_menu', true );
		wp_enqueue_script( 'wpte-wpl-select2-js' );
		wp_enqueue_script( 'wpte-wpl-settings-js' );
		wp_localize_script(
            'wpte-wpl-settings-js', 'wpteSettings', [
				'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
				'wpte_nonce' => wp_create_nonce( 'wpte-settings-nonce' ),
				'error'      => __( 'Something Went Wrong!', 'wpte-product-layout' ),
			]
        );
		new Pages\Settings();
	}

	/**
	 * Plugin Admin SubMenu Getting Started
	 *
	 * @return void
	 */
	public function wpte_product_layout_getting_started() {
		apply_filters( 'wpte_product_layout_admin_menu', true );
		wp_enqueue_script( 'wpte-wpl-admin-js' );
		new Pages\Support();
	}

	/**
	 * Plugin Admin SubMenu Status
	 *
	 * @return void
	 */
	public function wpte_product_layout_status() {
		apply_filters( 'wpte_product_layout_admin_menu', true );
		new Pages\Status();
	}
}
