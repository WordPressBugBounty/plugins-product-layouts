<?php

namespace WPTE_PRODUCT_LAYOUT\Includes;

/**
 * Plugin Uninstallation Class
 *
 * @since 1.0.0
 */
class Uninstallation {

	/**
	 * Uninstallation class constructor
	 *
	 * Text Domain
	 * Admin Menu
	 * Database
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		delete_transient( 'get_wpte_wpl_admin_menu' );
	}
}
