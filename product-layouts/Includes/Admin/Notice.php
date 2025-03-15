<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin;

/**
 * Admin Notice Class
 *
 * @since 1.0.0
 */
class Notice {

	/**
	 * Notice class constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		$this->notice_init();
	}

	/**
	 * Method notice_init.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function notice_init() {

		// Check for required PHP version.
		if ( version_compare( PHP_VERSION, WPTE_WPL_MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'wpte_wpl_minimum_php_version' ] );
			return;
		}

		// Check if WooCommerce installed and activated.
		if ( ! class_exists( 'WooCommerce' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Woocommerce version.
		if ( version_compare( WC_VERSION, WPTE_WPL_MINIMUM_WC_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'wpte_wpl_minimum_wc_version' ] );
			return;
		}

		// Get Review from users
		add_action( 'admin_notices', [ $this, 'wpte_wpl_get_review_from_users' ] );
	}

	/**
	 * Method wpte_wpl_minimum_php_version.
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function wpte_wpl_minimum_php_version() {

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'wpte-product-layout' ),
			'<strong>' . esc_html__( 'Product Layouts for Woocommerce', 'wpte-product-layout' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'wpte-product-layout' ) . '</strong>',
			WPTE_WPL_MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', wp_kses( $message, wpte_plugins_allowedtags() ) );
	}

	/**
	 * Method admin_notice_missing_main_plugin.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		$screen = get_current_screen();
		if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
			return;
		}

		$plugin            = 'woocommerce';
		$file_path         = 'woocommerce/woocommerce.php';
		$installed_plugins = get_plugins();

		if ( isset( $installed_plugins[ $file_path ] ) ) { // check if plugin is installed.

			if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}
			$activation_url = wp_nonce_url( admin_url( 'plugins.php?action=activate&plugin=' . $file_path ), 'activate-plugin_' . $file_path );

			$message  = wp_sprintf( '<p><strong>%s</strong>%s</p>', esc_html__( 'Product Layouts for Woocommerce', 'wpte-product-layout' ), __( ' not working because you need to activate the WooCommerce plugin.', 'wpte-product-layout' ) );
			$message .= wp_sprintf( '<p><a href="%s" class="button-primary">%s</a></p>', $activation_url, esc_html__( 'Activate WooCommerce Now', 'wpte-product-layout' ) );
		} else {
			if ( ! current_user_can( 'install_plugins' ) ) {
				return;
			}
			$install_url = wp_nonce_url(
                add_query_arg(
                    [
						'action' => 'install-plugin',
						'plugin' => $plugin,
                    ],
					admin_url( 'update.php' )
                ),
                'install-plugin_' . $plugin
            );
			$message     = wp_sprintf( '<p><strong>%s</strong>%s</p>', esc_html__( 'Product Layouts for Woocommerce', 'wpte-product-layout' ), __( ' not working because you need to install the WooCommerce plugin.', 'wpte-product-layout' ) );
			$message    .= wp_sprintf( '<p><a href="%s" class="button-primary">%s</a></p>', $install_url, esc_html__( 'Install WooCommerce Now', 'wpte-product-layout' ) );
		}

		printf( '<div class="error"><p>%s</p></div>', wp_kses( $message, wpte_plugins_allowedtags() ) );
	}

	/**
	 * Method wpte_wpl_minimum_wc_version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function wpte_wpl_minimum_wc_version() {

		printf(
            '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', '%1$s' . esc_html__( ' requires ', 'wpte-product-layout' ) . ' %2$s' . esc_html__( ' version ', 'wpte-product-layout' ) . '%3$s' . esc_html__( 'or greater.', 'wpte-product-layout' ),
            '<strong>' . esc_html__( 'Product Layouts for Woocommerce', 'wpte-product-layout' ) . '</strong>',
            '<strong>' . esc_html__( 'Woocommerce', 'wpte-product-layout' ) . '</strong>',
            floatval( WPTE_WPL_MINIMUM_WC_VERSION )
        );
	}

	/**
	 * Method wpte_wpl_get_review_from_users.
	 *
	 * @since 1.2.2
	 *
	 * @access public
	 */
	public function wpte_wpl_get_review_from_users() {
		if ( ! ( isset( $_COOKIE['wpte-user-review'] ) && $_COOKIE['wpte-user-review'] == 1 ) ) :
			?>
		<div id="wpte-get-review" class="notice wpte-notice-review notice-warning is-dismissible">
			<h2>🌟 <?php echo esc_html__( 'Product Layouts for Woocommerce', 'wpte-product-layout' ); ?> 🌟</h2>
			<p><?php echo esc_html__( 'Love our plugin? Leave us a 5-star review! Your feedback helps us thrive, motivating us to continuously update the plugin.', 'wpte-product-layout' ); ?></p>
			<button class="wpte-btn-given"><?php echo esc_html__( 'Already Given', 'wpte-product-layout' ); ?></button>
			<a href="https://wordpress.org/support/plugin/product-layouts/reviews/#new-post" target="__blank"><button class="wpte-btn-deserve"><?php echo esc_html__( 'You Deserve It', 'wpte-product-layout' ); ?></button></a>
			<button class="wpte-btn-never"><?php echo esc_html__( "Don't Show Again", 'wpte-product-layout' ); ?></button>
		</div>
			<?php
		endif;
	}
}
