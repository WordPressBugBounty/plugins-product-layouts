<?php

namespace WPTE_PRODUCT_LAYOUT\Includes;

/**
 * Admin Handler Class
 *
 * @since 1.0.0
 */
class Admin {

	/**
	 * Admin class constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		new Admin\Menu();
		new Admin\Notice();
	}
}
