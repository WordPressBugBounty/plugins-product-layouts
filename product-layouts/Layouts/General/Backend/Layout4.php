<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\General\Backend;

use WPTE_PRODUCT_LAYOUT\Layouts\General\Layout;
use WPTE_PRODUCT_LAYOUT\Includes\Controls;

/**
 * Layout4
 */
class Layout4 extends Layout {

	/**
	 * Method wpte_layout_4_icon_style
	 */
	protected function wpte_layout_4_icon_style() {
		$this->start_controls_section(
			'wpte-product-general-qv-icons',
			[
				'label'     => 'Icon Styles',
				'showing'   => true,
				'condition' => [ 'wpte_general_products_show_icons' => 'yes' ],
			]
		);

		$this->start_controls_tabs(
			'wpte_product_layout_general_qv_start_tabs',
			[
				'options' => [
					'normal' => esc_html__('Normal ', 'product-layouts-premium' ),
					'hover'  => esc_html__('Hover ', 'product-layouts-premium' ),
				],
			]
		);
		$this->start_controls_tab();
			$this->add_control(
				'wpte_product_layout_general_qv_icon_bg',
				$this->style, [
					'label'             => __( 'Background', 'product-layouts-premium'  ),
					'type'              => Controls::GRADIENT,
					'default'           => '#ffffff',
					'selector'          => [
						'{{WRAPPER}} .wpte-general-layout-image-area .wpte-product-layouts-top-quick-view .wpte-product-layouts-quick-view a' => 'background: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);
			$this->add_control(
				'wpte_product_layout_general_qv_icon_color', $this->style, [
					'label'             => __( 'Color', 'product-layouts-premium'  ),
					'type'              => Controls::COLOR,
					'default'           => '#ffffff',
					'selector'          => [
						'{{WRAPPER}} .wpte-general-layout-image-area .wpte-product-layouts-top-quick-view .wpte-product-layouts-quick-view a' => 'color: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

		$this->end_controls_tab();

		$this->start_controls_tab();
			$this->add_control(
				'wpte_product_layout_general_qv_icon_bg_hover',
				$this->style, [
					'label'             => __( 'Background', 'product-layouts-premium'  ),
					'type'              => Controls::GRADIENT,
					'default'           => '#ff6f61',
					'selector'          => [
						'{{WRAPPER}} .wpte-general-layout-image-area .wpte-product-layouts-top-quick-view .wpte-product-layouts-quick-view a:hover' => 'background: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);
			$this->add_control(
				'wpte_product_layout_general_qv_icon_hover_color', $this->style, [
					'label'             => __( 'Color', 'product-layouts-premium'  ),
					'type'              => Controls::COLOR,
					'default'           => '#ffffff',
					'selector'          => [
						'{{WRAPPER}} .wpte-general-layout-image-area .wpte-product-layouts-top-quick-view .wpte-product-layouts-quick-view a:hover' => 'color: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'wpte_product_layout_general_qv_icon_size',
			$this->style,
			[
				'label'        => __( 'Icon Size', 'product-layouts-premium'  ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'separator'    => 'before',
				'default'      => [
					'unit' => 'px',
					'size' => 20,
				],
				'range'        => [
					'px' => [
						'min'  => 0,
						'max'  => 360,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'em' => [
						'min'  => 0.0,
						'max'  => 10,
						'step' => 0.01,
					],
				],
				'selector'     => [
					'{{WRAPPER}} .wpte-general-layout-image-area .wpte-product-layouts-top-quick-view .wpte-product-layouts-quick-view a' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_general_qv_icon_border', $this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-image-area .wpte-product-layouts-top-quick-view .wpte-product-layouts-quick-view a' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_general_qv_icon_boxshadow',
			$this->style, [
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-general-layout-image-area .wpte-product-layouts-top-quick-view .wpte-product-layouts-quick-view a' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_qv_icon_border_radius',
			$this->style,
			[
				'label'             => __( 'Border Radius', 'product-layouts-premium'  ),
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
					'{{WRAPPER}} .wpte-general-layout-image-area .wpte-product-layouts-top-quick-view .wpte-product-layouts-quick-view a' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_layout_4_button_style
	 */
	protected function wpte_layout_4_button_style() {
		$this->start_controls_section(
			'wpte-product-general-button-icons',
			[
				'label'     => 'Button Styles',
				'showing'   => true,
				'condition' => [ 'wpte_general_products_show_icons' => 'yes' ],
			]
		);

		$this->add_group_control(
			'wpte_product_layout_general_button_cart_text_typo', $this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-general-layout-button-icons a, {{WRAPPER}} .wpte-general-layout-button-icons .button' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_button_icon_size',
			$this->style,
			[
				'label'        => __( 'Size', 'product-layouts-premium'  ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => 16,
				],
				'range'        => [
					'px' => [
						'min'  => 0,
						'max'  => 360,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'em' => [
						'min'  => 0.0,
						'max'  => 10,
						'step' => 0.01,
					],
				],
				'selector'     => [
					'{{WRAPPER}} .wpte-general-layout-button-icons a,
					{{WRAPPER}} .wpte-general-layout-button-icons .button' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_button_icon_gap',
			$this->style,
			[
				'label'        => __( 'Icon Gap', 'product-layouts-premium'  ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => 8,
				],
				'range'        => [
					'px' => [
						'min'  => 0,
						'max'  => 360,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'em' => [
						'min'  => 0.0,
						'max'  => 10,
						'step' => 0.01,
					],
				],
				'selector'     => [
					'{{WRAPPER}} .wpte-general-layout-product-button-icons .wpte-icon, 
					{{WRAPPER}} .wpte-general-layout-product-button-icons .loading::before' => 'margin-right: {{SIZE}}{{UNIT}} !important;',
				],
				'description'  => '',
			]
		);

		$this->start_controls_tabs(
			'wpte_product_layout_general_button_start_tabs',
			[
				'options' => [
					'normal' => esc_html__('Normal ', 'product-layouts-premium' ),
					'hover'  => esc_html__('Hover ', 'product-layouts-premium' ),
				],
			]
		);
		$this->start_controls_tab();
			$this->add_control(
				'wpte_product_layout_general_button_icon_bg',
				$this->style, [
					'label'             => __( 'Background', 'product-layouts-premium'  ),
					'type'              => Controls::GRADIENT,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-general-layout-button-icons a,
						{{WRAPPER}} .wpte-general-layout-button-icons .button' => 'background: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);
			$this->add_control(
				'wpte_product_layout_general_button_icon_color', $this->style, [
					'label'             => __( 'Color', 'product-layouts-premium'  ),
					'type'              => Controls::COLOR,
					'separator'         => 'after',
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-general-layout-button-icons a,
						{{WRAPPER}} .wpte-general-layout-button-icons .button' => 'color: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

		$this->end_controls_tab();

		$this->start_controls_tab();
			$this->add_control(
				'wpte_product_layout_general_button_icon_bg_hover',
				$this->style, [
					'label'             => __( 'Background', 'product-layouts-premium'  ),
					'type'              => Controls::GRADIENT,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-general-layout-button-icons a:hover,
						{{WRAPPER}} .wpte-general-layout-button-icons .button:hover' => 'background: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);
			$this->add_control(
				'wpte_product_layout_general_button_icon_hover_color', $this->style, [
					'label'             => __( 'Color', 'product-layouts-premium'  ),
					'type'              => Controls::COLOR,
					'separator'         => 'after',
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-general-layout-button-icons a:hover,
						{{WRAPPER}} .wpte-general-layout-button-icons .button:hover' => 'color: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			'wpte_product_layout_general_button_icon_border', $this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-button-icons a,
					{{WRAPPER}} .wpte-general-layout-button-icons .button' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_general_button_icon_boxshadow',
			$this->style, [
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-general-layout-button-icons a,
					{{WRAPPER}} .wpte-general-layout-button-icons .button' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_button_icon_border_radius',
			$this->style,
			[
				'label'             => __( 'Border Radius', 'product-layouts-premium'  ),
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
					'{{WRAPPER}} .wpte-general-layout-button-icons a,
					{{WRAPPER}} .wpte-general-layout-button-icons .button' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_button_icon_padding',
			$this->style,
			[
				'label'             => __( 'Padding', 'product-layouts-premium'  ),
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
					'{{WRAPPER}} .wpte-general-layout-button-icons a,
					{{WRAPPER}} .wpte-general-layout-button-icons .button' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method register_controls
	 *
	 * @return void
	 */
	public function register_layout() {

		// Start Genetal Tabs.
		$this->start_section_tabs(
			'wpte-general-section-layout-4-tabs',
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

		$this->add_extra_control(
			'status',
			$this->style,
			[
				'label' => 'All Premium',
				'type'  => Controls::HIDDEN,
				'value' => 'p',
			]
		);

		// =============CART SETTINGS=====================
		$this->start_controls_section(
			'wpte-product-general-style-4-cart-icons',
			[
				'label'     => 'Cart Icon Setting',
				'showing'   => true,
				'condition' => [
					'wpte_general_products_show_icons' => 'yes',
				],
			]
		);

		$this->add_group_control(
			'wpte-product-general-style-4-cart-icon',
			$this->style,
			[
				'type'        => Controls::CART,
				'default'     => __('Cart Icons', 'product-layouts-premium' ),
				'operator'    => 'icontext', // icon, text, icontext.
				'condition'   => [
					'wpte_general_products_show_icons' => 'yes',
				],
				'description' => '',
			]
		);

		$this->end_controls_section();

		// =============END CART SETTINGS=====================

		// =============WISHLIST SETTINGS=====================
		$this->start_controls_section(
			'wpte-product-general-style-4-wishlist',
			[
				'label'     => 'Wish List Setting',
				'showing'   => true,
				'condition' => [
					'wpte_general_products_show_icons' => 'yes',
				],
			]
		);

		if ( ! class_exists( 'TInvWL_Admin_Base' ) ) {

			$plugin    = 'ti-woocommerce-wishlist';
			$file_path = 'ti-woocommerce-wishlist/ti-woocommerce-wishlist.php';
			$notice    = 'Wish List';

			$this->add_control(
				'wpte-product-wishlist-notice',
				$this->style,
				[
					'label'       => '',
					'type'        => Controls::NOTICE,
					'notice'      => admin_notice_missing_plugin( $plugin, $file_path, $notice ),
					'css'         => 'padding-bottom:10px',
					'description' => '',
				]
			);

		} else {
			$this->add_group_control(
				'wpte-product-general-style-4-wishlist-icon',
				$this->style,
				[
					'type'        => Controls::WISHLIST,
					'default'     => __('WishList Icons', 'product-layouts-premium' ),
					'operator'    => 'icontext', // icon, text, icontext.
					'condition'   => [
						'wpte_general_products_show_icons' => 'yes',
					],
					'description' => '',
				]
			);
		}

		$this->end_controls_section();

		// =============END WISHLIST SETTINGS=====================.

		// =============QUICK VIEW SETTINGS=====================
		$this->start_controls_section(
			'wpte-product-general-style-4-quickview-icons-title',
			[
				'label'   => 'Quick View',
				'showing' => true,
			]
		);

		$this->add_group_control(
			'wpte-product-general-style-4-quickview-icon',
			$this->style,
			[
				'type'        => Controls::QUICKVIEW,
				'default'     => __( 'Quick View', 'product-layouts-premium' ),
				'operator'    => 'icon', // icon, text, icontext.
				'condition'   => [
					'wpte_general_products_show_icons' => 'yes',
				],
				'description' => '',
			]
		);

		$this->end_controls_section();

		// =============END QUICK VIEW SETTINGS=====================

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
		$this->wpte_layout_4_icon_style();
		$this->wpte_tooltip_style();
		$this->wpte_layout_4_button_style();
		$this->wpte_category_style();
		$this->wpte_title_style();
		$this->wpte_rating_style();
		$this->wpte_price_style();

		$this->end_section_tabs();
	}
}
