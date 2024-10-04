<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Helper;

use WPTE_PRODUCT_LAYOUT\Includes\Controls;

trait Advanced {

	/**
	 * Method wpte_advanced_controlers.
	 *
	 * @return void
	 */
	public function wpte_advanced_controlers() {
		$this->start_controls_section(
			'wpte_product_layout_advanced_settings',
			[
				'label'   => 'Advanced',
				'showing' => true,
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_advanced_margin',
			$this->style,
			[
				'label'             => esc_html__( 'Margin', 'wpte-product-layout' ),
				'type'              => Controls::DIMENSIONS,
				'default'           => [
					'unit' => 'px',
					'size' => '',
				],
				'range'             => [
					'px'  => [
						'min'  => -500,
						'max'  => 1000,
						'step' => 1,
					],
					'em'  => [
						'min'  => -500,
						'max'  => 500,
						'step' => .1,
					],
					'%'   => [
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					],
					'rem' => [
						'min'  => -500,
						'max'  => 500,
						'step' => 1,
					],

				],
				'selector'          => [
					'{{WRAPPER}} .wpte-product-load' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_advanced_padding',
			$this->style,
			[
				'label'             => esc_html__( 'Padding', 'wpte-product-layout' ),
				'type'              => Controls::DIMENSIONS,
				'default'           => [
					'unit' => 'px',
					'size' => '',
				],
				'range'             => [
					'px'  => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'em'  => [
						'min'  => 0,
						'max'  => 500,
						'step' => .1,
					],
					'%'   => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'rem' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					],
				],
				'selector'          => [
					'{{WRAPPER}} .wpte-product-load' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'wpte_product_layout_pagination_global',
			[
				'label'   => 'Pagination',
				'showing' => true,
				'is_pro'  => 'yes',
			]
		);

		$this->add_control(
			'wpte_product_layout_pagination_global_display',
			$this->style, [
				'label'     => esc_html__( 'Pagination', 'wpte-product-layout' ),
				'type'      => Controls::SELECT,
				'loader'    => true,
				'default'   => 'none',
				'separator' => 'after',
				'options'   => [
					'none'       => esc_html__( 'None', 'wpte-product-layout' ),
					'pagination' => esc_html__( 'Pagination', 'wpte-product-layout' ),
					'load_more'  => esc_html__( 'Load More Button', 'wpte-product-layout' ),
				],
			]
		);

		$this->add_control(
			'wpte_product_layout_pagination_preset',
			$this->style, [
				'label'     => esc_html__( 'Preset', 'wpte-product-layout' ),
				'type'      => Controls::SELECT,
				'loader'    => true,
				'default'   => 'preset_1',
				'options'   => [
					'preset_1' => esc_html__( 'Preset 1', 'wpte-product-layout' ),
					'preset_2' => esc_html__( 'Preset 2', 'wpte-product-layout' ),
					'preset_3' => esc_html__( 'Preset 3', 'wpte-product-layout' ),
				],
				'condition' => [ 'wpte_product_layout_pagination_global_display' => 'pagination' ],
			]
		);

		$this->add_group_control(
			'wpte_product_pagination_global_typography',
			$this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-layout-pagination li,
					{{WRAPPER}} .wpte-product-layout-pagination li .wpte_product_pagination_prev_text,
					{{WRAPPER}} .wpte-product-layout-pagination li .wpte_product_pagination_prev_icon,
					{{WRAPPER}} .wpte-product-layout-pagination li .wpte_product_pagination_next_text,
					{{WRAPPER}} .wpte-product-layout-pagination li .wpte_product_pagination_next_icon' => '',
				],
				'description' => '',
				'condition'   => [
					'wpte_product_layout_pagination_global_display' => 'pagination',
				],
			]
		);

		$this->add_control(
			'wpte_product_pagination_global_align',
			$this->style,
			[
				'label'       => __( 'Align', 'wpte-product-layout' ),
				'type'        => Controls::CHOOSE,
				'operator'    => Controls::OPERATOR_ICON,
				'default'     => '',
				'options'     => [
					'start'  => [
						'title' => esc_html__('Left', 'wpte-product-layout'),
						'icon'  => 'dashicons dashicons-editor-alignleft',
					],
					'center' => [
						'title' => esc_html__('Center', 'wpte-product-layout'),
						'icon'  => 'dashicons dashicons-editor-aligncenter',
					],
					'end'    => [
						'title' => esc_html__('Right', 'wpte-product-layout'),
						'icon'  => 'dashicons dashicons-editor-alignright',
					],
				],
				'selector'    => [
					'{{WRAPPER}} .wpte-product-layout-pagination' => 'justify-content:{{VALUE}};',
				],
				'description' => '',
				'condition'   => [ 'wpte_product_layout_pagination_global_display' => 'pagination' ],
			]
		);

		$this->add_responsive_control(
			'wpte_product_pagination_min_width',
			$this->style,
			[
				'label'        => __( 'Min Width', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => 30,
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
					'{{WRAPPER}} .wpte-product-layout-pagination li' => 'min-width: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
				'condition'    => [ 'wpte_product_layout_pagination_global_display' => 'pagination' ],
			]
		);

		$this->add_responsive_control(
			'wpte_product_pagination_min_height',
			$this->style,
			[
				'label'        => esc_html__( 'Min Height', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => 30,
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
					'{{WRAPPER}} .wpte-product-layout-pagination li' => 'min-height: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
				'condition'    => [ 'wpte_product_layout_pagination_global_display' => 'pagination' ],
			]
		);

		$this->start_controls_tabs(
			'wpte_product_pagination_global_style_tabs',
			[
				'options'   => [
					'normal' => esc_html__('Normal ', 'wpte-product-layout' ),
					'hover'  => esc_html__('Hover ', 'wpte-product-layout' ),
					'active' => esc_html__('Active', 'wpte-product-layout' ),
				],
				'condition' => [ 'wpte_product_layout_pagination_global_display' => 'pagination' ],
			]
		);
		// Normal Tab.
		$this->start_controls_tab();

			$this->add_control(
				'wpte_product_pagination_normal_bg_color',
				$this->style, [
					'label'             => esc_html__( 'Background', 'wpte-product-layout'  ),
					'type'              => Controls::GRADIENT,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-product-layout-pagination li' => 'background: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);
			$this->add_control(
				'wpte_product_pagination_normal_color', $this->style, [
					'label'             => esc_html__( 'Color', 'wpte-product-layout'  ),
					'type'              => Controls::COLOR,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-product-layout-pagination li,
						{{WRAPPER}} .wpte-product-layout-pagination li .wpte_product_pagination_prev_text,
						{{WRAPPER}} .wpte-product-layout-pagination li .wpte_product_pagination_prev_icon,
						{{WRAPPER}} .wpte-product-layout-pagination li .wpte_product_pagination_next_text,
						{{WRAPPER}} .wpte-product-layout-pagination li .wpte_product_pagination_next_icon,
						{{WRAPPER}} .wpte-product-layout-pagination span' => 'color: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

			$this->add_group_control(
				'wpte_product_pagination_normal_border', $this->style, [
					'type'              => Controls::BORDER,
					'selector'          => [
						'{{WRAPPER}} .wpte-product-layout-pagination li' => '',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);
			$this->add_group_control(
				'wpte_product_pagination_normal_boxshadow',
				$this->style, [
					'type'        => Controls::BOXSHADOW,
					'selector'    => [
						'{{WRAPPER}} .wpte-product-layout-pagination li' => '',
					],
					'description' => '',
				]
			);

			$this->add_responsive_control(
				'wpte_product_pagination_normal_border_radius',
				$this->style,
				[
					'label'             => esc_html__( 'Border Radius', 'wpte-product-layout' ),
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
						'{{WRAPPER}} .wpte-product-layout-pagination li' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

		$this->end_controls_tab();
		// Hover Tab.
		$this->start_controls_tab();

			$this->add_control(
				'wpte_product_pagination_hover_bg_color',
				$this->style, [
					'label'             => esc_html__( 'Background', 'wpte-product-layout'  ),
					'type'              => Controls::GRADIENT,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-product-layout-pagination li:hover' => 'background: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);
			$this->add_control(
				'wpte_product_pagination_hover_color', $this->style, [
					'label'             => esc_html__( 'Color', 'wpte-product-layout'  ),
					'type'              => Controls::COLOR,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-product-layout-pagination li:hover,
						{{WRAPPER}} .wpte-product-layout-pagination li:hover .wpte_product_pagination_prev_text,
						{{WRAPPER}} .wpte-product-layout-pagination li:hover .wpte_product_pagination_prev_icon,
						{{WRAPPER}} .wpte-product-layout-pagination li:hover .wpte_product_pagination_next_text,
						{{WRAPPER}} .wpte-product-layout-pagination li:hover .wpte_product_pagination_next_icon' => 'color: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

			$this->add_group_control(
				'wpte_product_pagination_hover_border', $this->style, [
					'type'              => Controls::BORDER,
					'selector'          => [
						'{{WRAPPER}} .wpte-product-layout-pagination li:hover' => '',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

			$this->add_group_control(
				'wpte_product_pagination_hover_boxshadow',
				$this->style, [
					'type'        => Controls::BOXSHADOW,
					'selector'    => [
						'{{WRAPPER}} .wpte-product-layout-pagination li:hover' => '',
					],
					'description' => '',
				]
			);

			$this->add_responsive_control(
				'wpte_product_pagination_hover_border_radius',
				$this->style,
				[
					'label'             => esc_html__( 'Border Radius', 'wpte-product-layout' ),
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
						'{{WRAPPER}} .wpte-product-layout-pagination li:hover' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

		$this->end_controls_tab();
		// Active Tab.
		$this->start_controls_tab();

			$this->add_control(
				'wpte_product_pagination_active_bg_color',
				$this->style, [
					'label'             => esc_html__( 'Background', 'wpte-product-layout'  ),
					'type'              => Controls::GRADIENT,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-product-layout-pagination .pagination-active' => 'background: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);
			$this->add_control(
				'wpte_product_pagination_active_color', $this->style, [
					'label'             => esc_html__( 'Color', 'wpte-product-layout'  ),
					'type'              => Controls::COLOR,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-product-layout-pagination .pagination-active' => 'color: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

			$this->add_group_control(
				'wpte_product_pagination_active_border', $this->style, [
					'type'              => Controls::BORDER,
					'selector'          => [
						'{{WRAPPER}} .wpte-product-layout-pagination .pagination-active' => '',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);
			$this->add_group_control(
				'wpte_product_pagination_active_boxshadow',
				$this->style, [
					'type'        => Controls::BOXSHADOW,
					'selector'    => [
						'{{WRAPPER}} .wpte-product-layout-pagination .pagination-active' => '',
					],
					'description' => '',
				]
			);

			$this->add_responsive_control(
				'wpte_product_pagination_active_border_radius',
				$this->style,
				[
					'label'             => esc_html__( 'Border Radius', 'wpte-product-layout' ),
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
						'{{WRAPPER}} .wpte-product-layout-pagination .pagination-active' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'wpte_product_pagination_margin',
			$this->style,
			[
				'label'             => esc_html__( 'Margin', 'wpte-product-layout' ),
				'type'              => Controls::DIMENSIONS,
				'default'           => [
					'unit' => 'px',
					'size' => '',
				],
				'range'             => [
					'px'  => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'em'  => [
						'min'  => 0,
						'max'  => 500,
						'step' => .1,
					],
					'%'   => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'rem' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					],

				],
				'selector'          => [
					'{{WRAPPER}} .wpte-product-layout-pagination li' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
				'separator'         => 'before',
				'condition'         => [ 'wpte_product_layout_pagination_global_display' => 'pagination' ],
			]
		);

		$this->add_extra_control(
			'wpte_product_pagination_prev_heading',
			$this->style,
			[
				'label'     => 'Previus and Next Button',
				'type'      => Controls::HEADING,
				'css'       => 'padding-top:10px; padding-bottom:10px',
				'separator' => 'before',
				'condition' => [ 'wpte_product_layout_pagination_global_display' => 'pagination' ],
			]
		);

		$this->start_controls_tabs(
			'wpte_product_pagination_global_prev_next_tabs',
			[
				'options'   => [
					'previus' => esc_html__('Previus ', 'wpte-product-layout' ),
					'next'    => esc_html__('Next ', 'wpte-product-layout' ),
				],
				'condition' => [ 'wpte_product_layout_pagination_global_display' => 'pagination' ],
			]
		);
		// Previus Tab.
		$this->start_controls_tab();

			$this->add_control(
				'wpte_product_pagination_prev_icon',
				$this->style,
				[
					'label'       => esc_html__('Icon', 'wpte-product-layout'),
					'type'        => Controls::ICON,
					'default'     => 'wpte-icon icon-arrow-10',
					'description' => '',
				]
			);

			$this->add_control(
				'wpte_product_pagination_prev_text',
				$this->style,
				[
					'label'       => esc_html__('Text', 'wpte-product-layout'),
					'type'        => Controls::TEXT,
					'default'     => esc_html__('Previus', 'wpte-product-layout'),
					'description' => '',
				]
			);

		$this->end_controls_tab();

		// Next Tab.
		$this->start_controls_tab();

		$this->add_control(
			'wpte_product_pagination_next_icon',
			$this->style,
			[
				'label'       => esc_html__('Icon', 'wpte-product-layout'),
				'type'        => Controls::ICON,
				'default'     => 'wpte-icon icon-arrow-11',
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_pagination_next_text',
			$this->style,
			[
				'label'       => esc_html__('Next', 'wpte-product-layout'),
				'type'        => Controls::TEXT,
				'default'     => esc_html__('Next', 'wpte-product-layout'),
				'description' => '',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'wpte_product_pagination_icon_spacing',
			$this->style,
			[
				'label'        => esc_html__( 'Icon Spacing', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => 5,
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
					'{{WRAPPER}} .wpte-product-layout-pagination li .wpte_product_pagination_next_icon' => 'padding-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpte-product-layout-pagination li .wpte_product_pagination_prev_icon' => 'padding-right: {{SIZE}}{{UNIT}};',
				],
				'separator'    => 'before',
				'description'  => '',
				'condition'    => [ 'wpte_product_layout_pagination_global_display' => 'pagination' ],
			]
		);

		// LoadMore Button.
		$this->add_control(
			'wpte_product_pagination_load_more_text',
			$this->style,
			[
				'label'       => esc_html__('Load More Text', 'wpte-product-layout'),
				'type'        => Controls::TEXT,
				'default'     => esc_html__('Load More', 'wpte-product-layout'),
				'description' => '',
				'condition'   => [ 'wpte_product_layout_pagination_global_display' => 'load_more' ],
			]
		);

		$this->add_group_control(
			'wpte_product_load_more_typography',
			$this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-load-more button.wpte-product-layout-load-more-button .wpte_product_pagination_load_more_text' => '',
				],
				'description' => '',
				'condition'   => [
					'wpte_product_layout_pagination_global_display' => 'load_more',
				],
			]
		);

		$this->add_control(
			'wpte_product_load_more_align',
			$this->style,
			[
				'label'       => esc_html__( 'Align', 'wpte-product-layout' ),
				'type'        => Controls::CHOOSE,
				'operator'    => Controls::OPERATOR_ICON,
				'default'     => '',
				'options'     => [
					'start'  => [
						'title' => esc_html__('Left', 'wpte-product-layout'),
						'icon'  => 'dashicons dashicons-editor-alignleft',
					],
					'center' => [
						'title' => esc_html__('Center', 'wpte-product-layout'),
						'icon'  => 'dashicons dashicons-editor-aligncenter',
					],
					'end'    => [
						'title' => esc_html__('Right', 'wpte-product-layout'),
						'icon'  => 'dashicons dashicons-editor-alignright',
					],
				],
				'selector'    => [
					'{{WRAPPER}} .wpte-product-load-more' => 'justify-content:{{VALUE}};',
				],
				'description' => '',
				'condition'   => [ 'wpte_product_layout_pagination_global_display' => 'load_more' ],
			]
		);

		$this->start_controls_tabs(
			'wpte_product_load_more_style_tabs',
			[
				'options'   => [
					'normal' => esc_html__('Normal ', 'wpte-product-layout' ),
					'hover'  => esc_html__('Hover ', 'wpte-product-layout' ),
				],
				'condition' => [ 'wpte_product_layout_pagination_global_display' => 'load_more' ],
			]
		);
		// Normal Tab.
		$this->start_controls_tab();

			$this->add_control(
				'wpte_product_load_more_normal_bg_color',
				$this->style, [
					'label'             => __( 'Background', 'wpte-product-layout'  ),
					'type'              => Controls::GRADIENT,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-product-load-more button.wpte-product-layout-load-more-button' => 'background: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);
			$this->add_control(
				'wpte_product_load_more_normal_color', $this->style, [
					'label'             => __( 'Color', 'wpte-product-layout'  ),
					'type'              => Controls::COLOR,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-product-load-more button.wpte-product-layout-load-more-button' => 'color: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

			$this->add_group_control(
				'wpte_product_load_more_normal_border', $this->style, [
					'type'              => Controls::BORDER,
					'selector'          => [
						'{{WRAPPER}} .wpte-product-load-more button.wpte-product-layout-load-more-button' => '',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);
			$this->add_group_control(
				'wpte_product_load_more_normal_boxshadow',
				$this->style, [
					'type'        => Controls::BOXSHADOW,
					'selector'    => [
						'{{WRAPPER}} .wpte-product-load-more button.wpte-product-layout-load-more-button' => '',
					],
					'description' => '',
				]
			);

			$this->add_responsive_control(
				'wpte_product_load_more_normal_border_radius',
				$this->style,
				[
					'label'             => esc_html__( 'Border Radius', 'wpte-product-layout' ),
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
						'{{WRAPPER}} .wpte-product-load-more button.wpte-product-layout-load-more-button' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

		$this->end_controls_tab();
		// Hover Tab.
		$this->start_controls_tab();

			$this->add_control(
				'wpte_product_load_more_hover_bg_color',
				$this->style, [
					'label'             => esc_html__( 'Background', 'wpte-product-layout'  ),
					'type'              => Controls::GRADIENT,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-product-load-more button.wpte-product-layout-load-more-button:hover' => 'background: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);
			$this->add_control(
				'wpte_product_load_more_hover_color', $this->style, [
					'label'             => esc_html__( 'Color', 'wpte-product-layout'  ),
					'type'              => Controls::COLOR,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-product-load-more button.wpte-product-layout-load-more-button:hover' => 'color: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

			$this->add_group_control(
				'wpte_product_load_more_hover_border', $this->style, [
					'type'              => Controls::BORDER,
					'selector'          => [
						'{{WRAPPER}} .wpte-product-load-more button.wpte-product-layout-load-more-button:hover' => '',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

			$this->add_group_control(
				'wpte_product_load_more_hover_boxshadow',
				$this->style, [
					'type'        => Controls::BOXSHADOW,
					'selector'    => [
						'{{WRAPPER}} .wpte-product-load-more button.wpte-product-layout-load-more-button:hover' => '',
					],
					'description' => '',
				]
			);

			$this->add_responsive_control(
				'wpte_product_load_more_hover_border_radius',
				$this->style,
				[
					'label'             => esc_html__( 'Border Radius', 'wpte-product-layout' ),
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
						'{{WRAPPER}} .wpte-product-load-more button.wpte-product-layout-load-more-button:hover' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'wpte_product_load_more_padding',
			$this->style,
			[
				'label'             => esc_html__( 'Padding', 'wpte-product-layout' ),
				'type'              => Controls::DIMENSIONS,
				'default'           => [
					'unit' => 'px',
					'size' => '',
				],
				'range'             => [
					'px'  => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'em'  => [
						'min'  => 0,
						'max'  => 500,
						'step' => .1,
					],
					'%'   => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'rem' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					],

				],
				'selector'          => [
					'{{WRAPPER}} .wpte-product-load-more button.wpte-product-layout-load-more-button' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
				'separator'         => 'before',
				'condition'         => [ 'wpte_product_layout_pagination_global_display' => 'load_more' ],
			]
		);

		$this->add_responsive_control(
			'wpte_product_load_more_margin',
			$this->style,
			[
				'label'             => esc_html__( 'Margin', 'wpte-product-layout' ),
				'type'              => Controls::DIMENSIONS,
				'default'           => [
					'unit' => 'px',
					'size' => '',
				],
				'range'             => [
					'px'  => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'em'  => [
						'min'  => 0,
						'max'  => 500,
						'step' => .1,
					],
					'%'   => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'rem' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					],

				],
				'selector'          => [
					'{{WRAPPER}} .wpte-product-load-more' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
				'condition'         => [ 'wpte_product_layout_pagination_global_display' => 'load_more' ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'wpte_product_layout_advanced_background',
			[
				'label'   => 'Background',
				'showing' => true,
			]
		);

		$this->add_control(
			'wpte_product_layout_advanced_padding_bg_color',
			$this->style, [
				'label'             => esc_html__( 'Background Color', 'wpte-product-layout' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-load' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'wpte_product_layout_advanced_border',
			[
				'label'   => 'Border',
				'showing' => true,
			]
		);

		$this->add_group_control(
			'wpte_product_layout_advanced_border',
			$this->style,
			[
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-product-load' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_advanced_border_radius',
			$this->style,
			[
				'label'             => esc_html__( 'Border Radius', 'wpte-product-layout' ),
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
					'{{WRAPPER}} .wpte-product-load' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_advanced_boxshadow',
			$this->style, [
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-load' => '',
				],
				'css'         => 'padding-bottom:20px',
				'description' => '',
			]
		);

		$this->end_controls_section();
	}
}
