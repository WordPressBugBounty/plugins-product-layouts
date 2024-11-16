<?php
/**
 * Plugin Name:       Product Layouts for Woocommerce
 * Plugin URI:        https://wpkin.com
 * Description:       This is woocommerce product layout plugin. you can design product using this plugin for your woocommerce store.
 * Version:           1.3.0
 * Author:            WPKIN
 * Author URI:        https://wpkin.com
 * Text Domain:       wpte-product-layout
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package product layouts for woocommrce.
 */

if ( ! defined( 'ABSPATH' ) ) {
	wp_die( esc_html__( 'You can\'t access this page', 'wpte-product-layout' ) );
}

if ( function_exists( 'wpl_fs' ) ) {
	wpl_fs()->set_basename( false, __FILE__ );
} else {
	if ( ! function_exists( 'wpl_fs' ) ) {
		// Create a helper function for easy SDK access.
		function wpl_fs() {
			global $wpl_fs;

			if ( ! isset( $wpl_fs ) ) {
				// Include Freemius SDK.
				require_once __DIR__ . '/freemius/start.php';

				$wpl_fs = fs_dynamic_init(
					[
						'id'                  => '11341',
						'slug'                => 'product-layouts',
						'type'                => 'plugin',
						'public_key'          => 'pk_897d6c8f989787c885cffb7ad7286',
						'is_premium'          => false,
						'has_premium_version' => false,
						'has_addons'          => false,
						'has_paid_plans'      => true,
						'has_affiliation'     => 'selected',
						'menu'                => [
							'slug'       => 'product-layouts',
							'first-path' => 'admin.php?page=product-layouts-getting-started',
							'contact'    => false,
							'support'    => false,
						],
					]
				);
			}

			return $wpl_fs;
		}

		// Init Freemius.
		wpl_fs();
		// Signal that SDK was initiated.
		do_action( 'wpl_fs_loaded' );
	}

	/**
	 * Included Autoload File
	 */
	require_once __DIR__ . '/vendor/autoload.php';

	/** If class `Product_Layouts` doesn't exists yet. */
	if ( ! class_exists( 'Product_Layouts' ) ) {

		/**
		 * Sets up and initializes the plugin.
		 * Main initiation class
		 *
		 * @since 1.0.0
		 */
		final class Product_Layouts {

			/**
			 * Plugin Version
			 */
			const VERSION = '1.3.0';

			/**
			 * Php Version
			 */
			const MIN_PHP_VERSION = '7.4';

			/**
			 * WC Version
			 */
			const MIN_WC_VERSION = '8.0.0';

			/**
			 * WordPress Version
			 */
			const MIN_WP_VERSION = '6.2';

			/**
			 * Class Constractor
			 */
			private function __construct() {

				$this->define_constance();
				register_activation_hook( __FILE__, [ $this, 'activate' ] );
				register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );
				add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
				add_action( 'init', [ $this, 'i18n' ] );
				// add_action( 'admin_init', [$this, 'activation_redirect'] );.
				add_filter( 'plugin_action_links_' . plugin_basename( WPTE_WPL_FILE ), [ __CLASS__, 'wpte_wpl_action_links' ] );
			}

			/**
			 * Initilize a singleton instance
			 *
			 * @return /Product_Layouts
			 */
			public static function init() {

				static $instance = false;

				if ( ! $instance ) {

					$instance = new self();
				}

				return $instance;
			}

			/**
			 * Plugin Constance
			 *
			 * @return void
			 */
			public function define_constance() {

				define( 'WPTE_WPL_VERSION', self::VERSION );
				define( 'WPTE_WPL_FILE', __FILE__ );
				define( 'WPTE_WPL_PATH', plugin_dir_path( __FILE__ ) );
				define( 'WPTE_WPL_URL', plugins_url( '', WPTE_WPL_FILE ) );
				define( 'WPTE_WPL_ASSETS', WPTE_WPL_URL . '/assets/' );
				define( 'WPTE_WPL_MINIMUM_PHP_VERSION', self::MIN_PHP_VERSION );
				define( 'WPTE_WPL_MINIMUM_WC_VERSION', self::MIN_WC_VERSION );
				define( 'WPTE_WPL_MINIMUM_WP_VERSION', self::MIN_WP_VERSION );
			}

			/**
			 * Load Textdomain
			 *
			 * Load plugin localization files.
			 *
			 * Fired by `init` action hook.
			 *
			 * @since 1.0.0
			 *
			 * @access public
			 */
			public function i18n() {
				load_plugin_textdomain( 'wpte-product-layout', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
			}

			/**
			 * After Activate Plugin
			 *
			 * Fired by `register_activation_hook` hook.
			 *
			 * @return void
			 *
			 * @since 1.0.0
			 *
			 * @access public
			 */
			public function activate() {

				new WPTE_PRODUCT_LAYOUT\Includes\Installation();
			}

			/**
			 * After Deactivate Plugin
			 *
			 * @return void
			 */
			public function deactivate() {

				new WPTE_PRODUCT_LAYOUT\Includes\Uninstallation();
			}

			/**
			 * Plugins Loaded
			 *
			 * @return void
			 */
			public function init_plugin() {

				new WPTE_PRODUCT_LAYOUT\Includes\Assets();

				if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
					new WPTE_PRODUCT_LAYOUT\Includes\Admin\Ajax();
				}

				if ( is_admin() ) {
					new WPTE_PRODUCT_LAYOUT\Includes\Admin();
				}
				new WPTE_PRODUCT_LAYOUT\Includes\Frontend();
				new WPTE_PRODUCT_LAYOUT\Includes\ArchivePage();
			}

			/**
			 *
			 * Redirect to settings page after activation the plugin
			 */
			public function activation_redirect() {

				if ( get_option( 'WPTE_wpl_activation_redirect', false ) ) {

					delete_option( 'WPTE_wpl_activation_redirect' );

					wp_safe_redirect( admin_url( 'admin.php?page=product-layouts-getting-started' ) );
					exit();
				}
			}

			/**
			 * Plugin Page Settings menu
			 *
			 * @param mixed $links .
			 */
			public static function wpte_wpl_action_links( $links ) {

				if ( ! current_user_can( 'manage_options' ) ) {
					return $links;
				}

				$links = array_merge(
					[
						sprintf(
							'<a href="%s">%s</a>',
							admin_url( 'admin.php?page=product-layouts' ),
							esc_html__( 'Settings', 'wpte-product-layout' )
						),
					],
					$links
				);

				return $links;
			}
		}

	}

	/**
	 * Initilize the main plugin
	 *
	 * @return /Product_Layouts
	 */
	function wpte_product_layout() {

		if ( class_exists( 'Product_Layouts' ) ) {
			return Product_Layouts::init();
		}

		return false;
	}

	/**
	 * Kick-off the plugin
	 */
	wpte_product_layout();
}
