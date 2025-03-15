<?php
namespace WPTE_PRODUCT_LAYOUT\Layouts\Tabs\Backend;

use WPTE_PRODUCT_LAYOUT\Layouts\Tabs\Layout;
use WPTE_PRODUCT_LAYOUT\Includes\Controls;

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
			'wpte-table-section-layout1-tabs',
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

		$this->add_control(
			'wpte_product_layout_tabs_style_1_get_layout', $this->style, [
				'label'   => __( 'Tab Layout', 'wpte-product-layout' ),
				'type'    => Controls::SELECT,
				'loader'  => true,
				// 'multiple' => true,
				'default' => '',
				'options' => wpte_get_shortcode_list(),
			]
		);

		$this->add_extra_control(
			'wpte_pl_tabs_settings',
			$this->style,
			[
				'label'     => 'Category Settings',
				'type'      => Controls::HEADING,
				'css'       => 'padding-top:10px; margin-top:10px',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'wpte_pl_tabs_category_all',
			$this->style,
			[
				'label'        => __( 'Enable button (All)', 'wpte-product-layout' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __( 'Yes', 'wpte-product-layout' ),
				'label_off'    => __( 'No', 'wpte-product-layout' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'wpte_product_layout_tabs_product_category',
			$this->style,
			[
				'label' => 'Product Category',
				'type'  => Controls::CATEGORIES,
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
			'wpte-tab-section-layout1-style-tabs',
			[
				'condition' => [
					'style',
				],
			]
		);

		$this->start_controls_section(
			'wpte-product-tab-style-1-body',
			[
				'label'   => 'Tab Style Settings',
				'showing' => true,
			]
		);

		$this->add_control(
			'wpte_product_tab_style_1_tab_align',
			$this->style,
			[
				'label'       => __( 'Align', 'wpte-product-layout' ),
				'type'        => Controls::CHOOSE,
				'operator'    => Controls::OPERATOR_ICON,
				'default'     => '',
				'options'     => [
					'start'  => [
						'title' => __( 'Left', 'wpte-product-layout' ),
						'icon'  => 'dashicons dashicons-editor-alignleft',
					],
					'center' => [
						'title' => __( 'Center', 'wpte-product-layout' ),
						'icon'  => 'dashicons dashicons-editor-aligncenter',
					],
					'end'    => [
						'title' => __( 'Right', 'wpte-product-layout' ),
						'icon'  => 'dashicons dashicons-editor-alignright',
					],
				],
				'selector'    => [
					'{{WRAPPER}} .wpte-product-layouts-tabs-style-1-list' => 'justify-content:{{VALUE}};',
				],
				'description' => '',
			]
		);

		$this->add_group_control(
			'wpte_product_tab_style_1_typho', $this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-layouts-tabs-style-1-list li' => '',
				],
				'description' => '',
			]
		);

		$this->start_controls_tabs(
			'wpte_product_layout_tab_style_1_tabs',
			[
				'options' => [
					'normal' => esc_html__( 'Normal ', 'wpte-product-layout' ),
					'hover'  => esc_html__( 'Hover ', 'wpte-product-layout' ),
					'active' => esc_html__( 'Active ', 'wpte-product-layout' ),
				],
			]
		);
		$this->start_controls_tab();

			$this->add_control(
				'wpte_product_tab_style_1_normal_color',
				$this->style, [
					'label'    => __( 'Color', 'wpte-product-layout' ),
					'type'     => Controls::COLOR,
					'default'  => '#ffffff',
					'selector' => [
						'{{WRAPPER}} .wpte-product-layouts-tabs-style-1-list li' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'wpte_product_tab_style_1_normal_bg',
				$this->style, [
					'label'             => __( 'Background', 'wpte-product-layout' ),
					'type'              => Controls::GRADIENT,
					'default'           => '#83b735',
					'selector'          => [
						'{{WRAPPER}} .wpte-product-layouts-tabs-style-1-list li' => 'background: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

			$this->add_group_control(
				'wpte_product_tab_style_1_normal_border',
				$this->style, [
					'type'              => Controls::BORDER,
					'selector'          => [
						'{{WRAPPER}} .wpte-product-layouts-tabs-style-1-list li' => '',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

			$this->add_group_control(
				'wwpte_product_tab_style_1_normal_boxshadow',
				$this->style, [
					'type'        => Controls::BOXSHADOW,
					'selector'    => [
						'{{WRAPPER}} .wpte-product-layouts-tabs-style-1-list li' => '',
					],
					'description' => '',
				]
			);

			$this->add_responsive_control(
				'wpte_product_tab_style_1_normal_border_radius',
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
						'{{WRAPPER}} .wpte-product-layouts-tabs-style-1-list li' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

		$this->end_controls_tab();
		$this->start_controls_tab();

			$this->add_control(
				'wpte_product_tab_style_1_hove_color',
				$this->style, [
					'label'    => __( 'Color', 'wpte-product-layout' ),
					'type'     => Controls::COLOR,
					'default'  => '#ffffff',
					'selector' => [
						'{{WRAPPER}} .wpte-product-layouts-tabs-style-1-list li:hover' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'wpte_product_tab_style_1_hover_bg',
				$this->style, [
					'label'             => __( 'Background', 'wpte-product-layout' ),
					'type'              => Controls::GRADIENT,
					'default'           => '#669125',
					'selector'          => [
						'{{WRAPPER}} .wpte-product-layouts-tabs-style-1-list li:hover' => 'background: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

			$this->add_group_control(
				'wpte_product_tab_style_1_hover_border',
				$this->style, [
					'type'              => Controls::BORDER,
					'selector'          => [
						'{{WRAPPER}} .wpte-product-layouts-tabs-style-1-list li:hover' => '',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

			$this->add_group_control(
				'wwpte_product_tab_style_1_hover_boxshadow',
				$this->style, [
					'type'        => Controls::BOXSHADOW,
					'selector'    => [
						'{{WRAPPER}} .wpte-product-layouts-tabs-style-1-list li:hover' => '',
					],
					'description' => '',
				]
			);

			$this->add_responsive_control(
				'wpte_product_tab_style_1_hover_border_radius',
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
						'{{WRAPPER}} .wpte-product-layouts-tabs-style-1-list li:hover' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);
		$this->end_controls_tab();
		$this->start_controls_tab();

			$this->add_control(
				'wpte_product_tab_style_1_active_color',
				$this->style, [
					'label'    => __( 'Color', 'wpte-product-layout' ),
					'type'     => Controls::COLOR,
					'default'  => '#ffffff',
					'selector' => [
						'{{WRAPPER}} .wpte-product-layouts-tabs-style-1-list li.wpte-tab-active' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'wpte_product_tab_style_1_active_bg',
				$this->style, [
					'label'             => __( 'Background', 'wpte-product-layout' ),
					'type'              => Controls::GRADIENT,
					'default'           => '#da3f3f',
					'selector'          => [
						'{{WRAPPER}} .wpte-product-layouts-tabs-style-1-list li.wpte-tab-active' => 'background: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

			$this->add_group_control(
				'wpte_product_tab_style_1_active_border',
				$this->style, [
					'type'              => Controls::BORDER,
					'selector'          => [
						'{{WRAPPER}} .wpte-product-layouts-tabs-style-1-list li.wpte-tab-active' => '',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

			$this->add_group_control(
				'wwpte_product_tab_style_1_active_boxshadow',
				$this->style, [
					'type'        => Controls::BOXSHADOW,
					'selector'    => [
						'{{WRAPPER}} .wpte-product-layouts-tabs-style-1-list li.wpte-tab-active' => '',
					],
					'description' => '',
				]
			);

			$this->add_responsive_control(
				'wpte_product_tab_style_1_active_border_radius',
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
						'{{WRAPPER}} .wpte-product-layouts-tabs-style-1-list li.wpte-tab-active' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'wpte_product_tab_style_1_padding',
			$this->style,
			[
				'label'             => __( 'Padding', 'wpte-product-layout' ),
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
				'separator'         => 'before',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-layouts-tabs-style-1-list li' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_tab_style_1_margin',
			$this->style,
			[
				'label'             => __( 'Margin', 'wpte-product-layout' ),
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
					'{{WRAPPER}} .wpte-product-layouts-tabs-style-1-list li' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();

		$this->end_section_tabs();
	}
}
