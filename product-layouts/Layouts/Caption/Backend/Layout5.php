<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\Caption\Backend;

use WPTE_PRODUCT_LAYOUT\Layouts\Caption\Layout;
use WPTE_PRODUCT_LAYOUT\Includes\Controls;

/**
 * Layout5
 */
class Layout5 extends Layout {
	/**
	 * Method register_controls
	 *
	 * @return void
	 */
	public function register_layout() {

		// Start Genetal Tabs.
		$this->start_section_tabs(
			'wpte-caption-section-layout-5-tabs',
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
			'status',
			$this->style,
			[
				'label' => 'All Premium',
				'type'  => Controls::HIDDEN,
				'value' => 'p',
			]
		);

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
			'wpte_product_layout_caption_style_5_effect',
			$this->style, [
				'label'   => __( 'Effects Direction', 'wpte-product-layout' ),
				'type'    => Controls::SELECT,
				'loader'  => true,
				// 'multiple' => true,
				'default' => 'open-horizontal',
				'options' => [
					'in'        => 'Bounce In',
					'in-up'     => 'Bounce In Up',
					'in-down'   => 'Bounce In Down',
					'in-left'   => 'Bounce In Left',
					'in-right'  => 'Bounce In Right',
					'out'       => 'Bounce Out',
					'out-up'    => 'Bounce Out Up',
					'out-down'  => 'Bounce Out Down',
					'out-left'  => 'Bounce Out Left',
					'out-right' => 'Bounce Out Right',
				],
			]
		);

		$this->wpte_inital_show_and_hide();

		$this->end_controls_section();

			// Initial Controls from Layout.php
			// ================================================.
			$this->wpte_intial_product_settings();
			// ===========Cart Button=================
			$this->wpte_caption_button();
			// ===========Wishlist Icon=================
			$this->wpte_cation_wishlist();

		$this->end_section_tabs();
		// =============END CART SETTINGS=====================

		/**
		 * =========================================================================
		 * =================================STAET STYLE TAB=========================
		 * =========================================================================
		 */
		$this->start_section_tabs(
			'wpte-caption-section-layout-5-style-tabs',
			[
				'condition' => [
					'style',
				],
			]
		);

		$this->start_controls_section(
			'wpte-product-caption-style-body',
			[
				'label'   => 'Product Body',
				'showing' => true,
			]
		);

		$this->add_control(
			'wpte_product_caption_style_body_bg',
			$this->style, [
				'label'             => __( 'Background', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'oparetor'          => true,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-caption-hover,
					{{WRAPPER}} .wpte-product-caption-hover:before,
					{{WRAPPER}} .wpte-product-caption-hover:after,
					{{WRAPPER}} .wpte-product-caption-hover .wpte-product-hover-figure,
					{{WRAPPER}} .wpte-product-caption-hover .wpte-product-hover-figure:before,
					{{WRAPPER}} .wpte-product-caption-hover .wpte-product-hover-figure:after,
					{{WRAPPER}} .wpte-product-caption-hover .wpte-product-hover-figure-caption,
					{{WRAPPER}} .wpte-product-caption-hover .wpte-product-hover-figure-caption:before,
					{{WRAPPER}} .wpte-product-caption-hover .wpte-product-hover-figure-caption:after' => 'background-color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);
		$this->add_group_control(
			'wpte_product_caption_style_body_border',
			$this->style,
			[
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-product-hover-style-caption' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);
		$this->add_group_control(
			'wpte_product_caption_style_body_boxshadow',
			$this->style,
			[
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-hover-style-caption' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_caption_style_body_border_radius',
			$this->style,
			[
				'label'             => __( 'Border Radius', 'wpte-product-layout' ),
				'type'              => Controls::DIMENSIONS,
				'default'           => [
					'unit' => 'px',
					'size' => '',
				],
				'range'             => [
					'px' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'em' => [
						'min'  => 0,
						'max'  => 100,
						'step' => .1,
					],
				],
				'selector'          => [
					'{{WRAPPER}} .wpte-product-hover-style-caption,
					{{WRAPPER}} .wpte-product-caption-hover-style-5,
					{{WRAPPER}} .wpte-product-caption-hover-style-5:before,
					{{WRAPPER}} .wpte-product-caption-hover-style-5:after,
					{{WRAPPER}} .wpte-product-caption-hover-style-5 .wpte-product-hover-figure,
					{{WRAPPER}} .wpte-product-caption-hover-style-5 .wpte-product-hover-figure:before,
					{{WRAPPER}} .wpte-product-caption-hover-style-5 .wpte-product-hover-figure:after,
					{{WRAPPER}} .wpte-product-caption-hover-style-5 .wpte-product-hover-figure-caption,
					{{WRAPPER}} .wpte-product-caption-hover-style-5 .wpte-product-hover-figure-caption:before,
					{{WRAPPER}} .wpte-product-caption-hover-style-5 .wpte-product-hover-figure-caption:after' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'         => 'before',
				'simpledescription' => '',
				'description'       => '',

			]
		);

		$this->end_controls_section();
		$this->wpte_caption_style_image();
		$this->wpte_caption_style_category();
		$this->wpte_caption_wishlist_icon_style();
		$this->wpte_caption_tooltip_style();
		$this->wpte_caption_style_title();
		$this->wpte_caption_style_description();
		$this->wpte_caption_style_rating();
		$this->wpte_caption_style_price();
		$this->wpte_caption_style_button();
		$this->end_section_tabs();
	}
}
