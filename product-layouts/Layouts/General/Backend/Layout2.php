<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\General\Backend;

use WPTE_PRODUCT_LAYOUT\Includes\Controls;
use WPTE_PRODUCT_LAYOUT\Layouts\General\Layout;

/**
 * Layout2
 */
class Layout2 extends Layout {
	/**
	 * Method register_controls
	 *
	 * @return void
	 */
	public function register_layout() {

		// Start Genetal Tabs.

		// Start Genetal Tabs.
		$this->start_section_tabs(
			'wpte-general-section-layout-2-tabs',
			[
				'condition' => [
					'general',
				],
			]
		);

		// Initial Controls from Layout.php
		// ================================================.
		$this->wpte_intial_controls();
		// ================================================

		// =============CART SETTINGS=====================
		$this->start_controls_section(
			'wpte-product-general-style-2-icons',
			[
				'label'     => 'Cart Icon Setting',
				'showing'   => true,
				'condition' => [
					'wpte_general_products_show_icons' => 'yes',
				],
			]
		);

		$this->add_group_control(
			'wpte-product-general-style-2-cart-icon',
			$this->style,
			[
				'type'        => Controls::CART,
				'default'     => __( 'Cart Icons', 'wpte-product-layout' ),
				'operator'    => 'icontext', // icon, text, icontext.
				'condition'   => [
					'wpte_general_products_show_icons' => 'yes',
				],
				'description' => '',
			]
		);

		$this->end_controls_section();

		// =============END CART SETTINGS=====================

		$this->end_section_tabs();

		$this->start_section_tabs(
			'wpte-general-section-layout-2-style-tabs',
			[
				'condition' => [
					'style',
				],
			]
		);

		$this->wpte_product_body_style();
		$this->wpte_badge_style();
		$this->wpte_image_style();
		$this->wpte_cart_button_style();
		$this->wpte_category_style();
		$this->wpte_title_style();
		$this->wpte_rating_style();
		$this->wpte_price_style();

		$this->end_section_tabs();
	}
}
