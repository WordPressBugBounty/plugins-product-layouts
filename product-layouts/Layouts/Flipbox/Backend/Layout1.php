<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\Flipbox\Backend;

use WPTE_PRODUCT_LAYOUT\Includes\Controls;
use WPTE_PRODUCT_LAYOUT\Layouts\Flipbox\Layout;

/**
 * Layout1
 */
class Layout1 extends Layout {
	/**
	 * Method register_controls
	 *
	 * @return void
	 */
	public function register_layout() {

		// Start Genetal Tabs.
		$this->start_section_tabs(
			'wpte-flipbox-section-layout-1-tabs',
			[
				'condition' => [
					'general',
				],
			]
		);

		$this->start_controls_section(
			'wpte_product_layout_settings',
			[
				'label'   => 'Layouts',
				'showing' => true,
			]
		);

		$this->wpte_initial_plugin_column();

		$this->add_extra_control(
			'wpte_product_layout_effect_heading',
			$this->style,
			[
				'label'     => 'Effects',
				'type'      => Controls::HEADING,
				'css'       => 'padding-top:10px; padding-bottom:10px',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'wpte_product_layout_flipbox_style_1_effect',
			$this->style, [
				'label'   => __( 'Effects Direction', 'wpte-product-layout' ),
				'type'    => Controls::SELECT,
				'loader'  => true,
				// 'multiple' => true,
				'default' => 'left-to-righ',
				'options' => [
					'top-to-bottom' => 'Top to Bottom',
					'bottom-to-top' => 'Bottom to Top',
					'right-to-left' => 'Right to Left',
					'left-to-right' => 'Left to Right',
				],
			]
		);

		$this->wpte_inital_show_and_hide();

		$this->end_controls_section();

		// Initial Controls from Layout.php
		// ================================================.
		$this->wpte_intial_product_settings();
		// ================================================

		// =============CART SETTINGS=====================
		$this->start_controls_section(
			'wpte-product-flipbox-style-1-icons',
			[
				'label'   => 'Button Setting',
				'showing' => true,
			]
		);

		$this->add_group_control(
			'wpte-product-flipbox-style-1-cart-icon',
			$this->style,
			[
				'type'        => Controls::CART,
				'default'     => __( 'Cart Icons', 'wpte-product-layout' ),
				'operator'    => 'icontext', // icon, text, icontext.
				'condition'   => [
					'wpte_flipbox_products_show_icons' => 'yes',
				],
				'description' => '',
			]
		);

		$this->end_controls_section();

		$this->end_section_tabs();
		// =============END CART SETTINGS=====================

		/**
		 * =========================================================================
		 * =================================START FRONT TAB=========================
		 * =========================================================================
		 */
		$this->start_section_tabs(
			'wpte-flipbox-section-layout1-frontend-tabs',
			[
				'condition' => [
					'frontend',
				],
			]
		);

		$this->wpte_flipbox_style_image();

		$this->end_section_tabs();

		/**
		 * =========================================================================
		 * =================================START BACK TAB=========================
		 * =========================================================================
		 */
		$this->start_section_tabs(
			'wpte-flipbox-section-layout1-backend-tabs',
			[
				'condition' => [
					'backend',
				],
			]
		);

		$this->wpte_flipbox_style_product_body();

		$this->wpte_flipbox_style_category();

		$this->wpte_flipbox_style_title();

		$this->wpte_flipbox_style_description();

		$this->wpte_flipbox_style_rating();

		$this->wpte_flipbox_style_price();

		$this->wpte_flipbox_style_button();

		$this->end_section_tabs();
	}
}
