<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\Tabs;

use WPTE_PRODUCT_LAYOUT\Includes\Admin\Pages\AdminRender;

/**
 * Layout
 */
class Layout extends AdminRender {

	/**
	 * Method register_layout.
	 */
	public function register_layout() {
		return '';
	}

	/**
	 * Method register_controls
	 *
	 * @return void
	 */
	public function register_controls() {

		$this->wpte_settings_tabs_header(
			'wpte-general-section-tabs',
			[
				'options' => [
					'general' => __( 'Content', 'wpte-product-layout' ),
					'style'   => __( 'Style', 'wpte-product-layout' ),
				],
			]
		);

		$this->register_layout();
	}
}
