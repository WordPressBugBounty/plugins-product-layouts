<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\Product_list\Backend;

use WPTE_PRODUCT_LAYOUT\Includes\Controls;
use WPTE_PRODUCT_LAYOUT\Layouts\Product_list\Layout;

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
			'wpte-list-section-layout1-tabs',
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

		$this->wpte_product_list_column();

		$this->add_extra_control(
			'wpte_product_layout_header',
			$this->style,
			[
				'label' => 'Hide & Show',
				'type'  => Controls::HEADING,
				'css'   => 'padding-top:10px; padding-bottom:10px',
			]
		);

		$this->add_control(
			'wpte_list_products_show_image',
			$this->style,
			[
				'label'        => __( 'Show Image', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'product-layouts' ),
				'label_off'    => __( 'No', 'product-layouts' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'wpte_list_products_show_title',
			$this->style,
			[
				'label'        => __( 'Show Name', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'product-layouts' ),
				'label_off'    => __( 'No', 'product-layouts' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'wpte_list_products_show_description',
			$this->style,
			[
				'label'        => __( 'Show Description', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'product-layouts' ),
				'label_off'    => __( 'No', 'product-layouts' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'wpte_list_products_show_price',
			$this->style,
			[
				'label'        => __( 'Show Price', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'product-layouts' ),
				'label_off'    => __( 'No', 'product-layouts' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'wpte_list_products_show_qty',
			$this->style,
			[
				'label'        => __( 'Show Quantity', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'product-layouts' ),
				'label_off'    => __( 'No', 'product-layouts' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'wpte_general_products_show_icons',
			$this->style,
			[
				'label'        => __( 'Show Button', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'product-layouts' ),
				'label_off'    => __( 'No', 'product-layouts' ),
				'css'          => 'padding-bottom:10px',
				'return_value' => 'yes',
			]
		);

		$this->end_controls_section();

		// Initial Controls from Layout.php
		// ================================================.
		$this->wpte_intial_controls();
		// ================================================

		$this->start_controls_section(
			'wpte-product-list-style-1-product-description',
			[
				'label'     => 'Product Description',
				'showing'   => true,
				'condition' => [
					'wpte_list_products_show_description' => 'yes',
				],
			]
		);

		$this->add_control(
			'wpte_product_layout_list_style_1_excerpt',
			$this->style,
			[
				'label'     => __( 'Product Excerpt', 'product-layouts' ),
				'type'      => Controls::NUMBER,
				'loader'    => true,
				'default'   => '10',
				'min'       => 0,
				'condition' => [
					'wpte_list_products_show_description' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// =============CART SETTINGS=====================
		$this->start_controls_section(
			'wpte-product-list-style-1-icons',
			[
				'label'     => 'Button Setting',
				'showing'   => true,
				'condition' => [
					'wpte_general_products_show_icons' => 'yes',
				],
			]
		);

		$this->add_group_control(
			'wpte-product-list-style-1-cart-icon',
			$this->style,
			[
				'type'        => Controls::CART,
				'default'     => __( 'Cart Icons', 'product-layouts' ),
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

		/**
		 * =========================================================================
		 * =================================STAET STYLE TAB=========================
		 * =========================================================================
		 */
		$this->start_section_tabs(
			'wpte-list-section-layout1-style-tabs',
			[
				'condition' => [
					'style',
				],
			]
		);

		$this->wpte_product_list_body_style();
		$this->wpte_product_list_image_style();
		$this->wpte_product_list_title_style();
		$this->wpte_product_list_description_style();
		$this->wpte_product_list_price_style();
		$this->wpte_product_list_quantity_style();
		$this->wpte_product_list_button_style();

		$this->end_section_tabs();
	}
}
