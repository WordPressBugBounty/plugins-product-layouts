<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin Notice Class
 *
 * @since 1.0.0
 */
class Notice {

	/**
	 * Option set to "yes" when the review notice is dismissed for good.
	 */
	const REVIEW_NOBUG = 'wpte_wpl_review_nobug';

	/**
	 * Option holding the time until which the review notice is snoozed.
	 */
	const REVIEW_SNOOZE = 'wpte_wpl_review_snooze_until';

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
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'product-layouts' ),
			'<strong>' . esc_html__( 'Product Layouts for Woocommerce', 'product-layouts' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'product-layouts' ) . '</strong>',
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

			$message  = wp_sprintf( '<p><strong>%s</strong>%s</p>', esc_html__( 'Product Layouts for Woocommerce', 'product-layouts' ), __( ' not working because you need to activate the WooCommerce plugin.', 'product-layouts' ) );
			$message .= wp_sprintf( '<p><a href="%s" class="button-primary">%s</a></p>', $activation_url, esc_html__( 'Activate WooCommerce Now', 'product-layouts' ) );
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
			$message     = wp_sprintf( '<p><strong>%s</strong>%s</p>', esc_html__( 'Product Layouts for Woocommerce', 'product-layouts' ), __( ' not working because you need to install the WooCommerce plugin.', 'product-layouts' ) );
			$message    .= wp_sprintf( '<p><a href="%s" class="button-primary">%s</a></p>', $install_url, esc_html__( 'Install WooCommerce Now', 'product-layouts' ) );
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
            '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', '%1$s' . esc_html__( ' requires ', 'product-layouts' ) . ' %2$s' . esc_html__( ' version ', 'product-layouts' ) . '%3$s' . esc_html__( 'or greater.', 'product-layouts' ),
            '<strong>' . esc_html__( 'Product Layouts for Woocommerce', 'product-layouts' ) . '</strong>',
            '<strong>' . esc_html__( 'Woocommerce', 'product-layouts' ) . '</strong>',
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
		if ( ! self::review_notice_due() ) {
			return;
		}
		?>
		<div id="wpte-get-review" class="notice wpte-notice-review is-dismissible">
			<div class="wpte-review-badge">⭐</div>
			<div class="wpte-review-body">
				<div class="wpte-review-stars">★★★★★</div>
				<h3><?php echo esc_html__( 'Product Layouts for Woocommerce', 'product-layouts' ); ?></h3>
				<p><?php echo esc_html__( 'Love our plugin? Leave us a 5-star review! Your feedback helps us thrive, motivating us to continuously update the plugin.', 'product-layouts' ); ?></p>
				<div class="wpte-review-actions">
					<a href="https://wordpress.org/support/plugin/product-layouts/reviews/#new-post" target="__blank"><button class="wpte-btn-deserve"><?php echo esc_html__( 'You Deserve It', 'product-layouts' ); ?></button></a>
					<button class="wpte-btn-given"><?php echo esc_html__( 'Already Given', 'product-layouts' ); ?></button>
					<button class="wpte-btn-never"><?php echo esc_html__( "Don't Show Again", 'product-layouts' ); ?></button>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Whether the review notice should show to the current user.
	 *
	 * The dismissal is saved on the site, so it survives logging out, other
	 * browsers and cleared cookies. The old cookie is still respected, so
	 * anyone who dismissed the notice before 1.4.6 doesn't see it again.
	 *
	 * @since 1.4.6
	 *
	 * @return bool
	 */
	public static function review_notice_due() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return false;
		}
		if ( 'yes' === get_option( self::REVIEW_NOBUG ) ) {
			return false;
		}
		if ( (int) get_option( self::REVIEW_SNOOZE, 0 ) > time() ) {
			return false;
		}
		if ( isset( $_COOKIE['wpte-user-review'] ) && '1' === $_COOKIE['wpte-user-review'] ) {
			return false;
		}
		return true;
	}

	/**
	 * Saves the review notice dismissal (AJAX).
	 *
	 * "later" (the corner ×) hides it for 7 days; "never" ("Already Given" or
	 * "Don't Show Again") hides it for good.
	 *
	 * @since 1.4.6
	 */
	public static function dismiss_review_notice() {
		if ( ! current_user_can( 'manage_options' ) || ! check_ajax_referer( 'wpte-review-notice', '_nonce', false ) ) {
			wp_send_json_error( null, 403 );
		}
		$mode = isset( $_POST['mode'] ) ? sanitize_key( wp_unslash( $_POST['mode'] ) ) : '';
		if ( 'never' === $mode ) {
			update_option( self::REVIEW_NOBUG, 'yes' );
		} elseif ( 'later' === $mode ) {
			update_option( self::REVIEW_SNOOZE, time() + 7 * DAY_IN_SECONDS );
		} else {
			wp_send_json_error( null, 400 );
		}
		wp_send_json_success();
	}
}
