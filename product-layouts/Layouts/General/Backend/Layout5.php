<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\General\Backend;

use WPTE_PRODUCT_LAYOUT\Layouts\General\Layout;
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
	protected function wpte_layout_5_icon_style() {

		$this->start_controls_section(
			'wpte-product-general-style-5-icons',
			[
				'label'     => 'Icon Styles',
				'showing'   => true,
				'condition' => [ 'wpte_general_products_show_icons' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_style_5_icon_width',
			$this->style,
			[
				'label'        => __( 'Width', 'product-layouts-premium'  ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => 46,
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
					'{{WRAPPER}} .wpte-general-layout-product-icons-inner,
					{{WRAPPER}} .wpte-general-layout-icon-left .wpte-general-layout-product-plus' => 'width: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_style_5_icon_height',
			$this->style,
			[
				'label'        => __( 'Height', 'product-layouts-premium'  ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => 46,
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
					'{{WRAPPER}} .wpte-general-layout-product-icons-inner,
					{{WRAPPER}} .wpte-general-layout-icon-left .wpte-general-layout-product-plus' => 'height: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);
		$this->add_responsive_control(
			'wpte_product_layout_general_style_5_icon_hover_height',
			$this->style,
			[
				'label'        => __( 'Hover Height', 'product-layouts-premium'  ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => 214,
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
					'{{WRAPPER}} .wpte-general-layout-product-icons-inner:hover' => 'height: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->start_controls_tabs(
			'wpte_product_layout_general_style_5_start_tabs',
			[
				'options' => [
					'normal' => esc_html__('Normal ', 'product-layouts-premium' ),
					'hover'  => esc_html__('Hover ', 'product-layouts-premium' ),
				],
			]
		);
		$this->start_controls_tab();
			$this->add_control(
				'wpte_product_layout_general_style_5_icon_bg',
				$this->style, [
					'label'             => __( 'Background', 'product-layouts-premium'  ),
					'type'              => Controls::GRADIENT,
					'default'           => '#ffffff',
					'selector'          => [
						'{{WRAPPER}} .wpte-general-layout-product-icons-inner' => 'background: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);
			$this->add_control(
				'wpte_product_layout_general_style_5_icon_color', $this->style, [
					'label'             => __( 'Color', 'product-layouts-premium'  ),
					'type'              => Controls::COLOR,
					'default'           => '#ffffff',
					'selector'          => [
						'{{WRAPPER}} .wpte-general-layout-icons a,
						{{WRAPPER}} .wpte-general-layout-product-plus,
						{{WRAPPER}} .wpte-general-layout-icons .button' => 'color: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

		$this->end_controls_tab();

		$this->start_controls_tab();
			$this->add_control(
				'wpte_product_layout_general_style_5_icon_bg_hover',
				$this->style, [
					'label'             => __( 'Background', 'product-layouts-premium'  ),
					'type'              => Controls::GRADIENT,
					'default'           => '#ff6f61',
					'selector'          => [
						'{{WRAPPER}} .wpte-general-layout-product-icons-inner:hover' => 'background: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);
			$this->add_control(
				'wpte_product_layout_general_style_5_icon_hover_color', $this->style, [
					'label'             => __( 'Color', 'product-layouts-premium'  ),
					'type'              => Controls::COLOR,
					'default'           => '#ffffff',
					'selector'          => [
						'{{WRAPPER}} .wpte-general-layout-icons a:hover,
						{{WRAPPER}} .wpte-general-layout-product-plus:hover,
						{{WRAPPER}} .wpte-general-layout-icons .button:hover' => 'color: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'wpte_product_layout_general_style_5_icon_size',
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
					'{{WRAPPER}} .wpte-general-layout-icons a,
					{{WRAPPER}} .wpte-general-layout-product-plus,
					{{WRAPPER}} .wpte-general-layout-icons .button' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_style_5_icon_gap',
			$this->style,
			[
				'label'        => __( 'Icon Gap', 'product-layouts-premium'  ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
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
					'{{WRAPPER}} .wpte-general-layout-product-icons' => 'grid-gap: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_general_style_5_icon_border', $this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-product-icons-inner' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_general_style_5_icon_boxshadow',
			$this->style, [
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-general-layout-product-icons-inner' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_style_5_icon_border_radius',
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
					'{{WRAPPER}} .wpte-general-layout-product-icons-inner' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_style_5_icon_margin',
			$this->style,
			[
				'label'             => __( 'Margin', 'product-layouts-premium'  ),
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
					'{{WRAPPER}} .wpte-general-layout-product-icons-inner' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			'wpte-general-section-layout3-tabs',
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
			'wpte-product-general-style-5-icons',
			[
				'label'   => 'Cart Icon Setting',
				'showing' => true,
			]
		);

		$this->add_group_control(
			'wpte-product-general-style-5-cart-icon',
			$this->style,
			[
				'type'        => Controls::CART,
				'default'     => __('Cart Icons', 'product-layouts-premium' ),
				'operator'    => 'icon', // icon, text, icontext.
				'condition'   => [
					'wpte_general_products_show_icons' => 'yes',
				],
				'description' => '',
			]
		);

		$this->end_controls_section();

		// =============END CART SETTINGS=====================

		// =============WISH LIST SETTINGS=====================
		$this->start_controls_section(
			'wpte-product-general-style-5-wishlist-icons',
			[
				'label'   => 'Wish List',
				'showing' => true,
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
					'notice'      => admin_notice_missing_plugin($plugin, $file_path, $notice),
					'css'         => 'padding-bottom:10px',
					'description' => '',
				]
			);

		} else {

			$this->add_group_control(
				'wpte-product-general-style-5-wishlist-icon',
				$this->style,
				[
					'type'        => Controls::WISHLIST,
					'default'     => __('Wishlist', 'product-layouts-premium' ),
					'operator'    => 'icon', // icon, text, icontext.
					'condition'   => [
						'wpte_general_products_show_icons' => 'yes',
					],
					'description' => '',
				]
			);

		}
		$this->end_controls_section();

		// =============END WISH LIST SETTINGS=====================

		// =============QUICK VIEW SETTINGS=====================
		$this->start_controls_section(
			'wpte-product-general-style-5-quickview-icons-title',
			[
				'label'   => 'Quick View',
				'showing' => true,
			]
		);

		$this->add_group_control(
			'wpte-product-general-style-5-quickview-icon',
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

		// =============PRODUCT COMPARE SETTINGS=====================
		$this->start_controls_section(
			'wpte-product-general-style-5-compare-icons-title',
			[
				'label'   => 'Product Compare',
				'showing' => true,
			]
		);

		$this->add_group_control(
			'wpte-product-general-style-5-compare-icon',
			$this->style,
			[
				'type'        => Controls::COMPARE,
				'default'     => __('Compare', 'product-layouts-premium' ),
				'operator'    => 'icon', // icon, text, icontext.
				'condition'   => [
					'wpte_general_products_show_icons' => 'yes',
				],
				'description' => '',
			]
		);

		$this->end_controls_section();

		// =============END PRODUCT COMPARE SETTINGS=====================

		$this->end_section_tabs();

		/**
		 * =========================================================================
		 * =================================START STYLE TAB=========================
		 * =========================================================================
		 */
		$this->start_section_tabs(
			'wpte-general-section-layout3-style-tabs',
			[
				'condition' => [
					'style',
				],
			]
		);

		$this->wpte_product_body_style();
		$this->wpte_badge_style();
		$this->wpte_image_style();
		$this->wpte_layout_5_icon_style();
		$this->wpte_tooltip_style( 'border-right-color' );
		$this->wpte_category_style();
		$this->wpte_title_style();
		$this->wpte_rating_style();
		$this->wpte_price_style();

		$this->end_section_tabs();
	}
}
