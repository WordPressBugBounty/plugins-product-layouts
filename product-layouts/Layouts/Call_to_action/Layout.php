<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\Call_to_action;

use WPTE_PRODUCT_LAYOUT\Includes\Admin\Pages\AdminRender;
use WPTE_PRODUCT_LAYOUT\Includes\Controls;

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
	 * Method wpte_get_product_filterby_options.
	 */
	protected function wpte_get_product_filterby_options() {
		return [
			'recent-products'       => esc_html__( 'Recent Products', 'wpte-product-layout' ),
			'featured-products'     => esc_html__( 'Featured Products', 'wpte-product-layout' ),
			'best-selling-products' => esc_html__( 'Best Selling Products', 'wpte-product-layout' ),
			'sale-products'         => esc_html__( 'Sale Products', 'wpte-product-layout' ),
			'top-products'          => esc_html__( 'Top Rated Products', 'wpte-product-layout' ),
		];
	}

	/**
	 * Method wpte_get_product_orderby_options.
	 */
	protected function wpte_get_product_orderby_options() {
		return [
			'ID'             => __( 'Product ID', 'wpte-product-layout' ),
			'title'          => __( 'Product Title', 'wpte-product-layout' ),
			'_price'         => __( 'Price', 'wpte-product-layout' ),
			'_sku'           => __( 'SKU', 'wpte-product-layout' ),
			'date'           => __( 'Date', 'wpte-product-layout' ),
			'modified'       => __( 'Last Modified Date', 'wpte-product-layout' ),
			'parent'         => __( 'Parent Id', 'wpte-product-layout' ),
			'rand'           => __( 'Random', 'wpte-product-layout' ),
			'menu_order'     => __( 'Menu Order', 'wpte-product-layout' ),
			'alphabetically' => __( 'Alphabetically', 'wpte-product-layout' ),
		];
	}

	/**
	 * Method wpte_intial_controls.
	 */
	public function wpte_intial_controls() {

			$this->start_controls_section(
				'wpte_product_layout_settings',
				[
					'label'   => 'Layouts',
					'showing' => true,
				]
			);

			$this->add_group_control(
				'wpte_product_layout_col',
				$this->style, [
					'type'     => Controls::COLUMN,
					'loader'   => true,
					'selector' => [
						'{{WRAPPER}} .wpte-product-card' => '',
					],
				]
			);

			$this->add_responsive_control(
				'wpte_product_layout_col_gap',
				$this->style,
				[
					'label'        => __( 'Column Gap', 'wpte-product-layout' ),
					'type'         => Controls::SLIDER,
					'simpleenable' => false,
					'default'      => [
						'unit' => 'px',
						'size' => 20,
					],
					'range'        => [
						'px' => [
							'min'  => 0,
							'max'  => 500,
							'step' => 1,
						],
						'em' => [
							'min'  => 0.0,
							'max'  => 10,
							'step' => 0.01,
						],
						'%'  => [
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						],
					],
					'selector'     => [
						'{{WRAPPER}} .wpte-product-column' => 'grid-column-gap: {{SIZE}}{{UNIT}};',
					],
					'description'  => '',
				]
			);

			$this->add_responsive_control(
				'wpte_product_layout_row_gap',
				$this->style,
				[
					'label'        => __( 'Row Gap', 'wpte-product-layout' ),
					'type'         => Controls::SLIDER,
					'simpleenable' => false,
					'default'      => [
						'unit' => 'px',
						'size' => 20,
					],
					'range'        => [
						'px' => [
							'min'  => 0,
							'max'  => 500,
							'step' => 1,
						],
						'em' => [
							'min'  => 0.0,
							'max'  => 10,
							'step' => 0.01,
						],
						'%'  => [
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						],
					],
					'selector'     => [
						'{{WRAPPER}} .wpte-product-column' => 'grid-row-gap: {{SIZE}}{{UNIT}};',
					],
					'description'  => '',
				]
			);

			$this->add_extra_control(
				'wpte_product_layout_header',
				$this->style,
				[
					'label'     => 'Hide & Show',
					'type'      => Controls::HEADING,
					'css'       => 'padding-top:10px; padding-bottom:10px',
					'separator' => 'before',
				]
			);

			$this->add_control(
				'wpte_call_to_action_products_show_badge',
				$this->style,
				[
					'label'        => __( 'Show Badge', 'wpte-product-layout' ),
					'type'         => Controls::SWITCHER,
					'default'      => 'no',
					'label_on'     => __( 'Yes', 'wpte-product-layout' ),
					'label_off'    => __( 'No', 'wpte-product-layout' ),
					'return_value' => 'yes',
				]
			);

			$this->add_control(
				'wpte_call_to_action_products_show_cat',
				$this->style,
				[
					'label'        => __( 'Show Category', 'wpte-product-layout' ),
					'type'         => Controls::SWITCHER,
					'default'      => 'no',
					'label_on'     => __( 'Yes', 'wpte-product-layout' ),
					'label_off'    => __( 'No', 'wpte-product-layout' ),
					'return_value' => 'yes',
				]
			);

			$this->add_control(
				'wpte_call_to_action_products_show_title',
				$this->style,
				[
					'label'        => __( 'Show Title', 'wpte-product-layout' ),
					'type'         => Controls::SWITCHER,
					'default'      => 'no',
					'label_on'     => __( 'Yes', 'wpte-product-layout' ),
					'label_off'    => __( 'No', 'wpte-product-layout' ),
					'return_value' => 'yes',
				]
			);

			$this->add_control(
				'wpte_call_to_action_products_show_rating',
				$this->style,
				[
					'label'        => __( 'Show Rating', 'wpte-product-layout' ),
					'type'         => Controls::SWITCHER,
					'default'      => 'no',
					'label_on'     => __( 'Yes', 'wpte-product-layout' ),
					'label_off'    => __( 'No', 'wpte-product-layout' ),
					'return_value' => 'yes',
				]
			);

			$this->add_control(
				'wpte_call_to_action_products_show_image',
				$this->style,
				[
					'label'        => __( 'Show Image', 'wpte-product-layout' ),
					'type'         => Controls::SWITCHER,
					'default'      => 'no',
					'label_on'     => __( 'Yes', 'wpte-product-layout' ),
					'label_off'    => __( 'No', 'wpte-product-layout' ),
					'return_value' => 'yes',
				]
			);

			$this->add_control(
				'wpte_call_to_action_products_show_price',
				$this->style,
				[
					'label'        => __( 'Show Price', 'wpte-product-layout' ),
					'type'         => Controls::SWITCHER,
					'default'      => 'no',
					'label_on'     => __( 'Yes', 'wpte-product-layout' ),
					'label_off'    => __( 'No', 'wpte-product-layout' ),
					'return_value' => 'yes',
				]
			);

			$this->add_control(
				'wpte_general_products_show_icons',
				$this->style,
				[
					'label'        => __( 'Show icons', 'wpte-product-layout' ),
					'type'         => Controls::SWITCHER,
					'default'      => 'no',
					'label_on'     => __( 'Yes', 'wpte-product-layout' ),
					'label_off'    => __( 'No', 'wpte-product-layout' ),
					'css'          => 'padding-bottom:10px',
					'return_value' => 'yes',
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'wpte_product_settings',
				[
					'label'   => 'Product Query',
					'showing' => true,
				]
			);

			$this->add_control(
				'wpte_product_layout_product_stock_status',
				$this->style,
				[
					'label'        => __( 'Hide out of stock products', 'wpte-product-layout' ),
					'type'         => Controls::SWITCHER,
					'default'      => 'no',
					'label_on'     => __( 'Yes', 'wpte-product-layout' ),
					'label_off'    => __( 'No', 'wpte-product-layout' ),
					'return_value' => 'yes',
				]
			);

			$this->add_control(
				'wpte_product_layout_product_category',
				$this->style,
				[
					'label' => 'Product Category',
					'type'  => Controls::CATEGORIES,
				]
			);

			$this->add_control(
				'wpte_product_layout_product_type',
				$this->style,
				[
					'label' => 'Product Type',
					'type'  => Controls::PRODUCTTYPE,
				]
			);

			$this->add_control(
				'wpte_product_layout_include_product',
				$this->style,
				[
					'label' => 'Include Products',
					'type'  => Controls::PRODUCT,
				]
			);

			$this->add_control(
				'wpte_product_layout_exclude_product',
				$this->style,
				[
					'label' => 'Exclude Products',
					'type'  => Controls::PRODUCT,
				]
			);

			$this->add_control(
				'wpte_product_layout_product_filter', $this->style, [
					'label'   => __( 'Filter By', 'wpte-product-layout' ),
					'type'    => Controls::SELECT,
					'loader'  => true,
					'default' => 'recent-products',
					'options' => $this->wpte_get_product_filterby_options(),
				]
			);

			$this->add_control(
				'wpte_product_layout_product_order_by', $this->style, [
					'label'   => __( 'Order By', 'wpte-product-layout' ),
					'type'    => Controls::SELECT,
					'loader'  => true,
					'default' => 'date',
					'options' => $this->wpte_get_product_orderby_options(),
				]
			);

			$this->add_control(
				'wpte_product_layout_product_order', $this->style, [
					'label'   => __( 'Order', 'wpte-product-layout' ),
					'type'    => Controls::SELECT,
					'loader'  => true,
					'options' => [
						'asc'  => 'Ascending',
						'desc' => 'Descending',
					],
					'default' => 'desc',
				]
			);

			$this->add_control(
				'wpte_product_layout_product_number',
				$this->style,
				[
					'label'   => __( 'Product Per Page', 'wpte-product-layout' ),
					'type'    => Controls::NUMBER,
					'loader'  => true,
					'default' => '10',
					'min'     => -1,
				]
			);

			$this->end_controls_section();
	}

	/**
	 * Method register_controls
	 *
	 * @return void
	 */
	public function register_controls() {

		$this->wpte_settings_tabs_header(
			'wpte-call-to-action-section-tabs',
			[
				'options' => [
					'general' => __( 'Content', 'wpte-product-layout' ),
					'style'   => __( 'Style', 'wpte-product-layout' ),
				],
			]
		);

		$this->register_layout();
	}

	/**
	 * Method wpte_product_body_style
	 *
	 * @return void
	 */
	protected function wpte_product_body_style() {
		$this->start_controls_section(
			'wpte-product-call-to-action-body',
			[
				'label'   => 'Product Body',
				'showing' => true,
			]
		);

		$this->start_controls_tabs(
			'wpte_product_call_to_action_body_start_tabs',
			[
				'options' => [
					'normal' => esc_html__( 'Normal ', 'wpte-product-layout' ),
					'hover'  => esc_html__( 'Hover ', 'wpte-product-layout' ),
				],
			]
		);

			$this->start_controls_tab();
				$this->add_control(
					'wpte_product_call_to_action_body_bg',
					$this->style, [
						'label'             => __( 'Background', 'wpte-product-layout' ),
						'type'              => Controls::GRADIENT,
						'default'           => '',
						'selector'          => [
							'{{WRAPPER}} .wpte-call-to-action-layout-row' => 'background: {{VALUE}};',
						],
						'simpledescription' => '',
						'description'       => '',
					]
				);
				$this->add_group_control(
					'wpte_product_call_to_action_body_border', $this->style, [
						'type'              => Controls::BORDER,
						'selector'          => [
							'{{WRAPPER}} .wpte-call-to-action-layout-row' => '',
						],
						'simpledescription' => '',
						'description'       => '',
					]
				);
				$this->add_group_control(
					'wpte_product_call_to_action_body_boxshadow',
					$this->style, [
						'type'        => Controls::BOXSHADOW,
						'selector'    => [
							'{{WRAPPER}} .wpte-call-to-action-layout-row' => '',
						],
						'description' => '',
					]
				);
			$this->end_controls_tab();

			$this->start_controls_tab();
				$this->add_control(
					'wpte_product_call_to_action_body_bg_hover',
					$this->style, [
						'label'             => __( 'Background', 'wpte-product-layout' ),
						'type'              => Controls::GRADIENT,
						'default'           => '',
						'selector'          => [
							'{{WRAPPER}} .wpte-call-to-action-layout-row:hover' => 'background: {{VALUE}};',
						],
						'simpledescription' => '',
						'description'       => '',
					]
				);
				$this->add_group_control(
					'wpte_product_call_to_action_body_border_hover', $this->style, [
						'type'              => Controls::BORDER,
						'selector'          => [
							'{{WRAPPER}} .wpte-call-to-action-layout-row:hover' => '',
						],
						'simpledescription' => '',
						'description'       => '',
					]
				);
				$this->add_group_control(
					'wpte_product_call_to_action_body_boxshadow_hover',
					$this->style, [
						'type'        => Controls::BOXSHADOW,
						'selector'    => [
							'{{WRAPPER}} .wpte-call-to-action-layout-row:hover' => '',
						],
						'description' => '',
					]
				);
			$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'wpte_product_call_to_action_body_border_radius',
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
					'{{WRAPPER}} .wpte-call-to-action-layout-row' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'         => 'before',
				'simpledescription' => '',
				'description'       => '',

			]
		);

		$this->add_responsive_control(
			'wpte_product_call_to_action_body_padding',
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
						'max'  => 50,
						'step' => 1,
					],
					'em' => [
						'min'  => 0,
						'max'  => 100,
						'step' => .1,
					],
				],
				'selector'          => [
					'{{WRAPPER}} .wpte-call-to-action-layout-row' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_product_body_content_style
	 *
	 * @return void
	 */
	protected function wpte_product_body_content_style() {
		// Product Content Body.
		$this->start_controls_section(
			'wpte-product-call-to-action-body-content',
			[
				'label'   => 'Product Body Content',
				'showing' => true,
			]
		);

		$this->add_control(
			'wpte_product_call_to_action_body_content_text_align',
			$this->style,
			[
				'label'       => __( 'Text Align', 'wpte-product-layout' ),
				'type'        => Controls::CHOOSE,
				'operator'    => Controls::OPERATOR_ICON,
				'default'     => '',
				'options'     => [
					'left'   => [
						'title' => __( 'Left', 'wpte-product-layout' ),
						'icon'  => 'dashicons dashicons-editor-alignleft',
					],
					'center' => [
						'title' => __( 'Center', 'wpte-product-layout' ),
						'icon'  => 'dashicons dashicons-editor-aligncenter',
					],
					'right'  => [
						'title' => __( 'Right', 'wpte-product-layout' ),
						'icon'  => 'dashicons dashicons-editor-alignright',
					],
				],
				'selector'    => [
					'{{WRAPPER}} .wpte-call-to-action-content' => 'text-align:{{VALUE}};',
				],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_call_to_action_body_content_bg',
			$this->style, [
				'label'             => __( 'Background', 'wpte-product-layout' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-call-to-action-content' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);
		$this->add_group_control(
			'wpte_product_call_to_action_body_content_border',
			$this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-call-to-action-content' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);
		$this->add_group_control(
			'wpte_product_call_to_action_body_content_boxshadow',
			$this->style, [
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-call-to-action-content' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_call_to_action_body_content_border_radius',
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
					'{{WRAPPER}} .wpte-call-to-action-content' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'         => 'before',
				'simpledescription' => '',
				'description'       => '',

			]
		);

		$this->add_responsive_control(
			'wpte_product_call_to_action_body_content_padding',
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
						'max'  => 50,
						'step' => 1,
					],
					'em' => [
						'min'  => 0,
						'max'  => 100,
						'step' => .1,
					],
				],
				'selector'          => [
					'{{WRAPPER}} .wpte-call-to-action-content' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);
		$this->add_responsive_control(
			'wpte_product_call_to_action_body_content_margin',
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
						'max'  => 50,
						'step' => 1,
					],
					'em' => [
						'min'  => 0,
						'max'  => 100,
						'step' => .1,
					],
				],
				'selector'          => [
					'{{WRAPPER}} .wpte-call-to-action-content-wrapper' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_badge_style
	 *
	 * @return void
	 */
	protected function wpte_badge_style() {
		$this->start_controls_section(
			'wpte-product-call-to-action-badge',
			[
				'label'     => 'Badge Styles',
				'showing'   => true,
				'condition' => [ 'wpte_call_to_action_products_show_badge' => 'yes' ],
			]
		);

		$this->start_controls_tabs(
			'wpte_product_layout_call_to_action_badge_start_tabs',
			[
				'options' => [
					'onsale'   => esc_html__( 'Onsale ', 'wpte-product-layout' ),
					'hot'      => esc_html__( 'Hot ', 'wpte-product-layout' ),
					'outstock' => esc_html__( 'Out Stock', 'wpte-product-layout' ),
				],
			]
		);
		$this->start_controls_tab();
			$this->add_control(
				'wpte_product_layout_call_to_action_badge_onsale_bg',
				$this->style, [
					'label'             => __( 'Background', 'wpte-product-layout' ),
					'type'              => Controls::GRADIENT,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-call-to-action-layout-image-area .onsale' => 'background: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);
			$this->add_control(
				'wpte_product_layout_call_to_action_badge_onsale_color', $this->style, [
					'label'             => __( 'Color', 'wpte-product-layout' ),
					'type'              => Controls::COLOR,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-call-to-action-layout-image-area .onsale' => 'color: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

		$this->end_controls_tab();

		$this->start_controls_tab();
			$this->add_control(
				'wpte_product_layout_call_to_action_badge_hot_bg',
				$this->style, [
					'label'             => __( 'Background', 'wpte-product-layout' ),
					'type'              => Controls::GRADIENT,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-call-to-action-layout-image-area .featured' => 'background: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);
			$this->add_control(
				'wpte_product_layout_call_to_action_badge_hot_color', $this->style, [
					'label'             => __( 'Color', 'wpte-product-layout' ),
					'type'              => Controls::COLOR,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-call-to-action-layout-image-area .featured' => 'color: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

		$this->end_controls_tab();

		$this->start_controls_tab();
			$this->add_control(
				'wpte_product_layout_call_to_action_badge_out_stock_bg',
				$this->style, [
					'label'             => __( 'Background', 'wpte-product-layout' ),
					'type'              => Controls::GRADIENT,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-call-to-action-layout-image-area .out-of-stock' => 'background: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);
			$this->add_control(
				'wpte_product_layout_call_to_action_badge_out_stock_color', $this->style, [
					'label'             => __( 'Color', 'wpte-product-layout' ),
					'type'              => Controls::COLOR,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-call-to-action-layout-image-area .out-of-stock' => 'color: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_badge_min_width',
			$this->style,
			[
				'label'        => __( 'Min Width', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'separator'    => 'before',
				'default'      => [
					'unit' => 'px',
					'size' => 50,
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
					'{{WRAPPER}} .wpte-call-to-action-layout-image-area ul li' => 'min-width: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);
		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_badge_min_height',
			$this->style,
			[
				'label'        => __( 'Min Height', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => 50,
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
					'{{WRAPPER}} .wpte-call-to-action-layout-image-area ul li' => 'min-height: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_call_to_action_badge_typho', $this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-call-to-action-layout-image-area ul li' => '',
				],
				'description' => '',
			]
		);
		$this->add_control(
			'wpte_product_call_to_action_body_badge_align',
			$this->style,
			[
				'label'       => __( 'Position', 'wpte-product-layout' ),
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
					'{{WRAPPER}} .wpte-call-to-action-layout-image-area ul' => 'align-items:{{VALUE}};',
				],
				'description' => '',
			]
		);
		$this->add_group_control(
			'wpte_product_layout_call_to_action_badge_border', $this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-call-to-action-layout-image-area ul li' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_call_to_action_badge_boxshadow',
			$this->style, [
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-call-to-action-layout-image-area ul li' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_badge_border_radius',
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
					'{{WRAPPER}} .wpte-call-to-action-layout-image-area ul li' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_badge_space',
			$this->style,
			[
				'label'        => __( 'Badge Space', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => 5,
				],
				'range'        => [
					'px' => [
						'min'  => -360,
						'max'  => 360,
						'step' => 1,
					],
					'%'  => [
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					],
					'em' => [
						'min'  => -10,
						'max'  => 10,
						'step' => 0.01,
					],
				],
				'selector'     => [
					'{{WRAPPER}} .wpte-call-to-action-layout-image-area ul li' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);
		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_badge_padding',
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
				'selector'          => [
					'{{WRAPPER}} .wpte-call-to-action-layout-image-area ul li' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);
		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_badge_margin',
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
					'{{WRAPPER}} .wpte-call-to-action-layout-image-area ul' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_product_layouts_image_style
	 *
	 * @return void
	 */
	protected function wpte_product_layouts_image_style() {

		$this->start_controls_section(
			'wpte-product-call-to-action-image',
			[
				'label'     => 'Image Styles',
				'showing'   => true,
				'condition' => [
					'wpte_call_to_action_products_show_image' => 'yes',
				],
			]
		);

		$this->add_control(
			'wpte-product-call-to-action-image-hyperlink',
			$this->style,
			[
				'label'        => __( 'Hyperlink', 'wpte-product-layout' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'wpte-product-layout' ),
				'label_off'    => __( 'No', 'wpte-product-layout' ),
				'return_value' => 'yes',
			]
		);
		$this->add_control(
			'wpte-product-call-to-action-image-open-new-window',
			$this->style,
			[
				'label'        => __( 'Open in new window', 'wpte-product-layout' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'wpte-product-layout' ),
				'label_off'    => __( 'No', 'wpte-product-layout' ),
				'return_value' => 'yes',
				'condition'    => [ 'wpte-product-call-to-action-image-hyperlink' => 'yes' ],
			]
		);
		$this->add_control(
			'wpte-product-call-to-action-image-nofollow',
			$this->style,
			[
				'label'        => __( 'Add nofollow', 'wpte-product-layout' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'wpte-product-layout' ),
				'label_off'    => __( 'No', 'wpte-product-layout' ),
				'return_value' => 'yes',
				'condition'    => [ 'wpte-product-call-to-action-image-hyperlink' => 'yes' ],
			]
		);

		$this->add_control(
			'wpte_product_layout_call_to_action_image_size', $this->style, [
				'label'   => __( 'Image Size', 'wpte-product-layout' ),
				'type'    => Controls::SELECT,
				'loader'  => true,
				// 'multiple' => true,.
				'default' => 'woocommerce_thumbnail',
				'options' => wpte_thumbnail_sizes(),
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_image_max_width',
			$this->style,
			[
				'label'        => __( 'Max Width', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => '%',
					'size' => 100,
				],
				'range'        => [
					'px' => [
						'min'  => 0,
						'max'  => 3000,
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
					'{{WRAPPER}} .wpte-call-to-action-layout-product-thumb,
					{{WRAPPER}} .wpte-call-to-action-layout-product-gallery-thumb' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_image_min_height',
			$this->style,
			[
				'label'        => __( 'Min Height', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => 300,
				],
				'range'        => [
					'px' => [
						'min'  => 0,
						'max'  => 3000,
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
					'{{WRAPPER}} .wpte-call-to-action-layout-product-thumb,
					{{WRAPPER}} .wpte-call-to-action-layout-product-gallery-thumb' => 'min-height: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_call_to_action_image_border', $this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-call-to-action-layout-product-thumb,
					{{WRAPPER}} .wpte-call-to-action-layout-product-gallery-thumb' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_call_to_action_image_boxshadow',
			$this->style, [
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-call-to-action-layout-product-thumb,
					{{WRAPPER}} .wpte-call-to-action-layout-product-gallery-thumb
					' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_image_border_radius',
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
					'{{WRAPPER}} .wpte-call-to-action-layout-product-thumb, 
					{{WRAPPER}} .wpte-call-to-action-layout-product-thumb img,
					{{WRAPPER}} .wpte-call-to-action-layout-product-gallery-thumb,
					{{WRAPPER}} .wpte-call-to-action-layout-product-gallery-thumb img
					' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_image_padding',
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
						'max'  => 50,
						'step' => 1,
					],
					'em' => [
						'min'  => 0,
						'max'  => 100,
						'step' => .1,
					],
				],
				'selector'          => [
					'{{WRAPPER}} .wpte-call-to-action-layout-image-area' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_product_layouts_icon_style
	 *
	 * @return void
	 */
	protected function wpte_product_layouts_icon_style() {

		$this->start_controls_section(
			'wpte-product-call-to-action-icons',
			[
				'label'     => 'Icon Styles',
				'showing'   => true,
				'condition' => [ 'wpte_general_products_show_icons' => 'yes' ],
			]
		);

		$this->add_control(
			'wpte_product_call_to_action_icon_align',
			$this->style,
			[
				'label'       => __( 'Align', 'wpte-product-layout' ),
				'type'        => Controls::CHOOSE,
				'operator'    => Controls::OPERATOR_ICON,
				'default'     => '',
				'options'     => [
					'start'  => [
						'title' => __( 'Start', 'wpte-product-layout' ),
						'icon'  => 'dashicons dashicons-editor-alignleft',
					],
					'center' => [
						'title' => __( 'Center', 'wpte-product-layout' ),
						'icon'  => 'dashicons dashicons-editor-aligncenter',
					],
					'end'    => [
						'title' => __( 'End', 'wpte-product-layout' ),
						'icon'  => 'dashicons dashicons-editor-alignright',
					],
				],
				'selector'    => [
					'{{WRAPPER}} .wpte-call-to-action-layout-icon-top,
					{{WRAPPER}} .wpte-call-to-action-layout-icon-right,
					{{WRAPPER}} .wpte-call-to-action-layout-icon-bottom,
					{{WRAPPER}} .wpte-call-to-action-layout-icon-left
					' => 'justify-content:{{VALUE}};',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_icon_min_width',
			$this->style,
			[
				'label'        => __( 'Min Width', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => 40,
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
					'{{WRAPPER}} .wpte-call-to-action-layout-icons a,
					{{WRAPPER}} .wpte-call-to-action-layout-icons .button' => 'min-width: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_icon_min_height',
			$this->style,
			[
				'label'        => __( 'Min Height', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => 40,
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
					'{{WRAPPER}} .wpte-call-to-action-layout-icons a,
					{{WRAPPER}} .wpte-call-to-action-layout-icons .button' => 'min-height: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->start_controls_tabs(
			'wpte_product_layout_call_to_action_start_tabs',
			[
				'options' => [
					'normal' => esc_html__( 'Normal ', 'wpte-product-layout' ),
					'hover'  => esc_html__( 'Hover ', 'wpte-product-layout' ),
				],
			]
		);
		$this->start_controls_tab();
			$this->add_control(
				'wpte_product_layout_call_to_action_icon_bg',
				$this->style, [
					'label'             => __( 'Background', 'wpte-product-layout' ),
					'type'              => Controls::GRADIENT,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-call-to-action-layout-icons a,
						{{WRAPPER}} .wpte-call-to-action-layout-icons .button' => 'background: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);
			$this->add_control(
				'wpte_product_layout_call_to_action_icon_color', $this->style, [
					'label'             => __( 'Color', 'wpte-product-layout' ),
					'type'              => Controls::COLOR,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-call-to-action-layout-icons a,
						{{WRAPPER}} .wpte-call-to-action-layout-icons .button' => 'color: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

		$this->end_controls_tab();

		$this->start_controls_tab();
			$this->add_control(
				'wpte_product_layout_call_to_action_icon_bg_hover',
				$this->style, [
					'label'             => __( 'Background', 'wpte-product-layout' ),
					'type'              => Controls::GRADIENT,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-call-to-action-layout-icons a:hover,
						{{WRAPPER}} .wpte-call-to-action-layout-icons .button:hover' => 'background: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);
			$this->add_control(
				'wpte_product_layout_call_to_action_icon_hover_color', $this->style, [
					'label'             => __( 'Color', 'wpte-product-layout' ),
					'type'              => Controls::COLOR,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-call-to-action-layout-icons a:hover,
						{{WRAPPER}} .wpte-call-to-action-layout-icons .button:hover' => 'color: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_icon_size',
			$this->style,
			[
				'label'        => __( 'Icon Size', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'separator'    => 'before',
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
					'{{WRAPPER}} .wpte-call-to-action-layout-icons a,
					{{WRAPPER}} .wpte-call-to-action-layout-icons .button' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_icon_gap',
			$this->style,
			[
				'label'        => __( 'Icon Gap', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => 10,
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
					'{{WRAPPER}} .wpte-call-to-action-layout-product-icons' => 'grid-gap: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_call_to_action_icon_border', $this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-call-to-action-layout-icons a,
					{{WRAPPER}} .wpte-call-to-action-layout-icons .button' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_call_to_action_icon_boxshadow',
			$this->style, [
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-call-to-action-layout-icons a,
					{{WRAPPER}} .wpte-call-to-action-layout-icons .button' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_icon_border_radius',
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
					'{{WRAPPER}} .wpte-call-to-action-layout-icons a,
					{{WRAPPER}} .wpte-call-to-action-layout-icons .button' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_icon_margin',
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
					'{{WRAPPER}} .wpte-call-to-action-layout-product-icons' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_product_layouts_tooltip_style.
	 *
	 * @param string $indigator .
	 */
	protected function wpte_product_layouts_tooltip_style( $indigator = 'border-left-color' ) {
		$this->start_controls_section(
			'wpte-product-call-to-action-tooltip',
			[
				'label'   => 'Tooltip Styles',
				'showing' => true,
			]
		);

		$this->add_group_control(
			'wpte_product_layout_call_to_action_tooltip_typho',
			$this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-tooltip' => '',
				],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_call_to_action_tooltip_color', $this->style, [
				'label'             => __( 'Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-tooltip' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_call_to_action_tooltip_indigator_color', $this->style, [
				'label'             => __( 'Indigator Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-tooltip:after' => "$indigator: {{VALUE}};",
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_call_to_action_tooltip_bg',
			$this->style,
			[
				'label'             => __( 'Background', 'wpte-product-layout' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-tooltip' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_call_to_action_tooltip_border', $this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-product-tooltip' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_call_to_action_tooltip_boxshadow',
			$this->style, [
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-tooltip' => '',
				],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_call_to_action_tooltip_border_radius',
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
					'{{WRAPPER}} .wpte-product-tooltip' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',

			]
		);
		$this->add_control(
			'wpte_product_call_to_action_tooltip_padding',
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
				'selector'          => [
					'{{WRAPPER}} .wpte-product-tooltip' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',

			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_category_style
	 *
	 * @return void
	 */
	protected function wpte_category_style() {

		$this->start_controls_section(
			'wpte-product-call-to-action-category',
			[
				'label'     => 'Category Styles',
				'showing'   => true,
				'condition' => [ 'wpte_call_to_action_products_show_cat' => 'yes' ],
			]
		);

		$this->add_group_control(
			'wpte_product_layout_call_to_action_category_typho', $this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-call-to-action-layout-category-area a, {{WRAPPER}} .wpte-call-to-action-layout-category-area' => '',
				],
				'description' => '',
			]
		);

		$this->start_controls_tabs(
			'wpte_product_layout_call_to_action_category_start_tabs',
			[
				'options' => [
					'normal' => esc_html__( 'Normal ', 'wpte-product-layout' ),
					'hover'  => esc_html__( 'Hover ', 'wpte-product-layout' ),
				],
			]
		);

		$this->start_controls_tab();

			$this->add_control(
				'wpte_product_layout_call_to_action_category_color', $this->style, [
					'label'             => __( 'Color', 'wpte-product-layout' ),
					'type'              => Controls::COLOR,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-call-to-action-layout-category-area a' => 'color: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

			$this->add_control(
				'wpte_product_layout_call_to_action_category_bg', $this->style, [
					'label'             => __( 'Background', 'wpte-product-layout' ),
					'type'              => Controls::GRADIENT,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-call-to-action-layout-category-area a' => 'background: {{VALUE}};',
					],
					'separator'  => 'after',
					'simpledescription' => '',
					'description'       => '',
				]
			);

		$this->end_controls_tab();
		$this->start_controls_tab();

			$this->add_control(
				'wpte_product_layout_call_to_action_category_hover_color', $this->style, [
					'label'             => __( 'Hover Color', 'wpte-product-layout' ),
					'type'              => Controls::COLOR,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-call-to-action-layout-category-area a:hover' => 'color: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

			$this->add_control(
				'wpte_product_layout_call_to_action_category_bg_hover', $this->style, [
					'label'             => __( 'Background', 'wpte-product-layout' ),
					'type'              => Controls::GRADIENT,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-call-to-action-layout-category-area a:hover' => 'background: {{VALUE}};',
					],
					'separator'         => 'after',
					'simpledescription' => '',
					'description'       => '',
				]
			);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			'wpte_product_layout_call_to_action_category_boxshadow', $this->style, [
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-call-to-action-layout-category-area a' => '',
				],
				'separator'   => 'before',
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_category_radius',
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
					'{{WRAPPER}} .wpte-call-to-action-layout-category-area a' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',

			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_category_padding',
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
				'selector'          => [
					'{{WRAPPER}} .wpte-call-to-action-layout-category-area a' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_category_margin',
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
						'min'  => -500,
						'max'  => 500,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'em' => [
						'min'  => -100,
						'max'  => 100,
						'step' => .1,
					],
				],
				'selector'          => [
					'{{WRAPPER}} .wpte-call-to-action-layout-category-area a' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_title_style
	 *
	 * @return void
	 */
	protected function wpte_title_style() {
		$this->start_controls_section(
			'wpte_product_layout_call_to_action_title',
			[
				'label'     => 'Title Styles',
				'showing'   => true,
				'condition' => [ 'wpte_call_to_action_products_show_title' => 'yes' ],
			]
		);

		$this->add_control(
			'wpte_product_layout_call_to_action_title_tag', $this->style, [
				'label'   => __( 'Title Tag', 'wpte-product-layout' ),
				'type'    => Controls::SELECT,
				'loader'  => true,
				'default' => 'h2',
				'options' => wpte_product_title_tags(),
			]
		);

		$this->add_group_control(
			'wpte_product_layout_call_to_action_title_typho', $this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-call-to-action-layout-title-area .wpte-call-to-action-layout-product-title,
					{{WRAPPER}} .wpte-call-to-action-layout-title-area .wpte-call-to-action-layout-product-title a' => '',
				],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_call_to_action_title_color', $this->style, [
				'label'             => __( 'Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-call-to-action-layout-title-area .wpte-call-to-action-layout-product-title,
					{{WRAPPER}} .wpte-call-to-action-layout-title-area .wpte-call-to-action-layout-product-title a' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_call_to_action_title_hover_color', $this->style, [
				'label'             => __( 'Hover Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-call-to-action-layout-title-area .wpte-call-to-action-layout-product-title a:hover' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_title_margin',
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
					'{{WRAPPER}} .wpte-call-to-action-layout-product-title' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_rating_style
	 *
	 * @return void
	 */
	protected function wpte_rating_style() {
		$this->start_controls_section(
			'wpte_product_layout_call_to_action_rating',
			[
				'label'     => 'Rating Styles',
				'showing'   => true,
				'condition' => [ 'wpte_call_to_action_products_show_rating' => 'yes' ],
			]
		);

		$this->add_control(
			'wpte_product_layout_call_to_action_rating_color', $this->style, [
				'label'             => __( 'Icon Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-call-to-action-layout-rating-area .wpte-icons' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_rating_size',
			$this->style,
			[
				'label'        => __( 'Icon Size', 'wpte-product-layout' ),
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
					'{{WRAPPER}} .wpte-call-to-action-layout-rating-area .wpte-icons' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_rating_margin',
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
					'{{WRAPPER}} .wpte-call-to-action-layout-rating-area .wpte-icons' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_price_style
	 *
	 * @return void
	 */
	protected function wpte_price_style() {
		$this->start_controls_section(
			'wpte_product_layout_call_to_action_price',
			[
				'label'     => 'Price Styles',
				'showing'   => true,
				'condition' => [ 'wpte_call_to_action_products_show_price' => 'yes' ],
			]
		);

		$this->add_group_control(
			'wpte_product_layout_call_to_action_price_typho', $this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-call-to-action-layout-price-area .amount, {{WRAPPER}} .wpte-call-to-action-layout-price-area' => '',
				],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_call_to_action_price_color', $this->style, [
				'label'             => __( 'Regular Price Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-call-to-action-layout-price-area del .amount,
					{{WRAPPER}} .wpte-call-to-action-layout-price-area del' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_call_to_action_sale_price_color', $this->style, [
				'label'             => __( 'Sale Price Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-call-to-action-layout-price-area,
					{{WRAPPER}} .wpte-call-to-action-layout-price-area .amount' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_price_margin',
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
					'{{WRAPPER}} .wpte-call-to-action-layout-price-area' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_cart_button_style
	 *
	 * @return void
	 */
	protected function wpte_cart_button_style() {
		$this->start_controls_section(
			'wpte-product-call-to-action-cart-icons',
			[
				'label'     => 'Cart Button Styles',
				'showing'   => true,
				'condition' => [ 'wpte_general_products_show_icons' => 'yes' ],
			]
		);

		$this->add_group_control(
			'wpte_product_layout_call_to_action_cart_text_typo', $this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-call-to-action-layout-product-cart a, {{WRAPPER}} .wpte-call-to-action-layout-product-cart .button' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_cart_icon_size',
			$this->style,
			[
				'label'        => __( 'Size', 'wpte-product-layout' ),
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
					'{{WRAPPER}} .wpte-call-to-action-layout-product-cart a,
					{{WRAPPER}} .wpte-call-to-action-layout-product-cart .button' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_cart_icon_gap',
			$this->style,
			[
				'label'        => __( 'Icon Gap', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => 10,
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
					'{{WRAPPER}} .wpte-call-to-action-layout-product-cart-icons .wpte-icon, 
					{{WRAPPER}} .wpte-call-to-action-layout-product-cart-icons .loading::before' => 'margin-right: {{SIZE}}{{UNIT}} !important;',
				],
				'description'  => '',
			]
		);

		$this->start_controls_tabs(
			'wpte_product_layout_call_to_action_cart_start_tabs',
			[
				'options' => [
					'normal' => esc_html__( 'Normal ', 'wpte-product-layout' ),
					'hover'  => esc_html__( 'Hover ', 'wpte-product-layout' ),
				],
			]
		);
		$this->start_controls_tab();
			$this->add_control(
				'wpte_product_layout_call_to_action_cart_icon_bg',
				$this->style, [
					'label'             => __( 'Background', 'wpte-product-layout' ),
					'type'              => Controls::GRADIENT,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-call-to-action-layout-product-cart a,
						{{WRAPPER}} .wpte-call-to-action-layout-product-cart .button' => 'background: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);
			$this->add_control(
				'wpte_product_layout_call_to_action_cart_icon_color', $this->style, [
					'label'             => __( 'Color', 'wpte-product-layout' ),
					'type'              => Controls::COLOR,
					'separator'         => 'after',
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-call-to-action-layout-product-cart a,
						{{WRAPPER}} .wpte-call-to-action-layout-product-cart .button' => 'color: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

		$this->end_controls_tab();

		$this->start_controls_tab();
			$this->add_control(
				'wpte_product_layout_call_to_action_cart_icon_bg_hover',
				$this->style, [
					'label'             => __( 'Background', 'wpte-product-layout' ),
					'type'              => Controls::GRADIENT,
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-call-to-action-layout-product-cart a:hover,
						{{WRAPPER}} .wpte-call-to-action-layout-product-cart .button:hover' => 'background: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);
			$this->add_control(
				'wpte_product_layout_call_to_action_cart_icon_hover_color', $this->style, [
					'label'             => __( 'Color', 'wpte-product-layout' ),
					'type'              => Controls::COLOR,
					'separator'         => 'after',
					'default'           => '',
					'selector'          => [
						'{{WRAPPER}} .wpte-call-to-action-layout-product-cart a:hover,
						{{WRAPPER}} .wpte-call-to-action-layout-product-cart .button:hover' => 'color: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			'wpte_product_layout_call_to_action_cart_icon_border', $this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-call-to-action-layout-product-cart a,
					{{WRAPPER}} .wpte-call-to-action-layout-product-cart .button' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_call_to_action_cart_icon_boxshadow',
			$this->style, [
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-call-to-action-layout-product-cart a,
					{{WRAPPER}} .wpte-call-to-action-layout-product-cart .button' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_cart_icon_border_radius',
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
					'{{WRAPPER}} .wpte-call-to-action-layout-product-cart a,
					{{WRAPPER}} .wpte-call-to-action-layout-product-cart .button' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_call_to_action_cart_icon_padding',
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
				'selector'          => [
					'{{WRAPPER}} .wpte-call-to-action-layout-product-cart a,
					{{WRAPPER}} .wpte-call-to-action-layout-product-cart .button' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}
}
