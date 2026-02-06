<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\General;

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
	 * Method register_controls
	 *
	 * @return void
	 */
	public function register_controls() {

		$this->wpte_settings_tabs_header(
			'wpte-general-section-tabs',
			[
				'options' => [
					'general' => __( 'Content', 'product-layouts' ),
					'style'   => __( 'Style', 'product-layouts' ),
				],
			]
		);

		$this->register_layout();
	}

	/**
	 * Method wpte_get_product_filterby_options.
	 */
	protected function wpte_get_product_filterby_options() {
		return [
			'recent-products'       => esc_html__( 'Recent Products', 'product-layouts' ),
			'featured-products'     => esc_html__( 'Featured Products', 'product-layouts' ),
			'best-selling-products' => esc_html__( 'Best Selling Products', 'product-layouts' ),
			'sale-products'         => esc_html__( 'Sale Products', 'product-layouts' ),
			'top-products'          => esc_html__( 'Top Rated Products', 'product-layouts' ),
		];
	}

	/**
	 * Method wpte_get_product_orderby_options.
	 */
	protected function wpte_get_product_orderby_options() {
		return [
			'ID'             => __( 'Product ID', 'product-layouts' ),
			'title'          => __( 'Product Title', 'product-layouts' ),
			'_price'         => __( 'Price', 'product-layouts' ),
			'_sku'           => __( 'SKU', 'product-layouts' ),
			'date'           => __( 'Date', 'product-layouts' ),
			'modified'       => __( 'Last Modified Date', 'product-layouts' ),
			'parent'         => __( 'Parent Id', 'product-layouts' ),
			'rand'           => __( 'Random', 'product-layouts' ),
			'menu_order'     => __( 'Menu Order', 'product-layouts' ),
			'alphabetically' => __( 'Alphabetically', 'product-layouts' ),
		];
	}

	/**
	 * Method wpte_intial_controls.
	 */
	protected function wpte_intial_controls() {

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
				'label'        => __( 'Column Gap', 'product-layouts' ),
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
				'label'        => __( 'Row Gap', 'product-layouts' ),
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
			'wpte_general_products_show_badge',
			$this->style,
			[
				'label'        => __( 'Show Badge', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'product-layouts' ),
				'label_off'    => __( 'No', 'product-layouts' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'wpte_general_products_show_cat',
			$this->style,
			[
				'label'        => __( 'Show Category', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'product-layouts' ),
				'label_off'    => __( 'No', 'product-layouts' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'wpte_general_products_show_title',
			$this->style,
			[
				'label'        => __( 'Show Title', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'product-layouts' ),
				'label_off'    => __( 'No', 'product-layouts' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'wpte_general_products_show_desc',
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
			'wpte_general_products_show_rating',
			$this->style,
			[
				'label'        => __( 'Show Rating', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'product-layouts' ),
				'label_off'    => __( 'No', 'product-layouts' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'wpte_general_products_show_image',
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
			'wpte_general_products_show_price',
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
			'wpte_general_products_show_icons',
			$this->style,
			[
				'label'        => __( 'Show icons', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'product-layouts' ),
				'label_off'    => __( 'No', 'product-layouts' ),
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
				'label'        => __( 'Hide out of stock products', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'product-layouts' ),
				'label_off'    => __( 'No', 'product-layouts' ),
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
				'label'   => __( 'Filter By', 'product-layouts' ),
				'type'    => Controls::SELECT,
				'loader'  => true,
				'default' => 'recent-products',
				'options' => $this->wpte_get_product_filterby_options(),
			]
		);

		$this->add_control(
			'wpte_product_layout_product_order_by', $this->style, [
				'label'   => __( 'Order By', 'product-layouts' ),
				'type'    => Controls::SELECT,
				'loader'  => true,
				'default' => 'date',
				'options' => $this->wpte_get_product_orderby_options(),
			]
		);

		$this->add_control(
			'wpte_product_layout_product_order', $this->style, [
				'label'   => __( 'Order', 'product-layouts' ),
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
				'label'   => __( 'Product Per Page', 'product-layouts' ),
				'type'    => Controls::NUMBER,
				'loader'  => true,
				'default' => '10',
				'min'     => -1,
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_product_body_style.
	 */
	protected function wpte_product_body_style() {

		$this->start_controls_section(
			'wpte-product-general-body',
			[
				'label'   => 'Product Body',
				'showing' => true,
			]
		);

		$this->add_control(
			'wpte_product_general_body_text_align',
			$this->style,
			[
				'label'       => __( 'Text Align', 'product-layouts' ),
				'type'        => Controls::CHOOSE,
				'operator'    => Controls::OPERATOR_ICON,
				'default'     => '',
				'options'     => [
					'left'   => [
						'title' => __( 'Left', 'product-layouts' ),
						'icon'  => 'dashicons dashicons-editor-alignleft',
					],
					'center' => [
						'title' => __( 'Center', 'product-layouts' ),
						'icon'  => 'dashicons dashicons-editor-aligncenter',
					],
					'right'  => [
						'title' => __( 'Right', 'product-layouts' ),
						'icon'  => 'dashicons dashicons-editor-alignright',
					],
				],
				'selector'    => [
					'{{WRAPPER}} .wpte-general-layout-row' => 'text-align:{{VALUE}};',
				],
				'description' => '',
			]
		);

		$this->start_controls_tabs(
			'wpte_product_general_body_start_tabs',
			[
				'options' => [
					'normal' => esc_html__( 'Normal ', 'product-layouts' ),
					'hover'  => esc_html__( 'Hover ', 'product-layouts' ),
				],
			]
		);

		$this->start_controls_tab();
		$this->add_control(
			'wpte_product_general_body_bg',
			$this->style, [
				'label'             => __( 'Background', 'product-layouts' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-row' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);
		$this->add_group_control(
			'wpte_product_general_body_border', $this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-row' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);
		$this->add_group_control(
			'wpte_product_general_body_boxshadow',
			$this->style, [
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-general-layout-row' => '',
				],
				'description' => '',
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab();
		$this->add_control(
			'wpte_product_general_body_bg_hover',
			$this->style, [
				'label'             => __( 'Background', 'product-layouts' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-row:hover' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);
		$this->add_group_control(
			'wpte_product_general_body_border_hover', $this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-row:hover' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);
		$this->add_group_control(
			'wpte_product_general_body_boxshadow_hover',
			$this->style, [
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-general-layout-row:hover' => '',
				],
				'description' => '',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'wpte_product_general_body_border_radius',
			$this->style,
			[
				'label'             => __( 'Border Radius', 'product-layouts' ),
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
					'{{WRAPPER}} .wpte-general-layout-row' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'         => 'before',
				'simpledescription' => '',
				'description'       => '',

			]
		);

		$this->add_responsive_control(
			'wpte_product_general_body_padding',
			$this->style,
			[
				'label'             => __( 'Padding', 'product-layouts' ),
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
					'{{WRAPPER}} .wpte-general-layout-row' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_product_body_style.
	 */
	protected function wpte_badge_style() {
		$this->start_controls_section(
			'wpte-product-general-badge',
			[
				'label'     => 'Badge Styles',
				'showing'   => true,
				'condition' => [ 'wpte_general_products_show_badge' => 'yes' ],
			]
		);

		$this->start_controls_tabs(
			'wpte_product_layout_general_badge_start_tabs',
			[
				'options' => [
					'onsale'   => esc_html__( 'Onsale ', 'product-layouts' ),
					'hot'      => esc_html__( 'Hot ', 'product-layouts' ),
					'outstock' => esc_html__( 'Out Stock', 'product-layouts' ),
				],
			]
		);
		$this->start_controls_tab();
		$this->add_control(
			'wpte_product_layout_general_badge_onsale_bg',
			$this->style, [
				'label'             => __( 'Background', 'product-layouts' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-image-area .onsale' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);
		$this->add_control(
			'wpte_product_layout_general_badge_onsale_color',
			$this->style, [
				'label'             => __( 'Color', 'product-layouts' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-image-area .onsale' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab();
		$this->add_control(
			'wpte_product_layout_general_badge_hot_bg',
			$this->style, [
				'label'             => __( 'Background', 'product-layouts' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-image-area .featured' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);
		$this->add_control(
			'wpte_product_layout_general_badge_hot_color', $this->style, [
				'label'             => __( 'Color', 'product-layouts' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-image-area .featured' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab();
		$this->add_control(
			'wpte_product_layout_general_badge_out_stock_bg',
			$this->style, [
				'label'             => __( 'Background', 'product-layouts' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-image-area .out-of-stock' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);
		$this->add_control(
			'wpte_product_layout_general_badge_out_stock_color', $this->style, [
				'label'             => __( 'Color', 'product-layouts' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-image-area .out-of-stock' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'wpte_product_layout_general_badge_min_width',
			$this->style,
			[
				'label'        => __( 'Min Width', 'product-layouts' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'separator'    => 'before',
				'default'      => [
					'unit' => 'px',
					'size' => '',
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
					'{{WRAPPER}} .wpte-general-layout-image-area ul li' => 'min-width: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);
		$this->add_responsive_control(
			'wpte_product_layout_general_badge_min_height',
			$this->style,
			[
				'label'        => __( 'Min Height', 'product-layouts' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '',
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
					'{{WRAPPER}} .wpte-general-layout-image-area ul li' => 'min-height: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_general_badge_typho', $this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-general-layout-image-area ul li' => '',
				],
				'description' => '',
			]
		);
		$this->add_control(
			'wpte_product_general_body_badge_align',
			$this->style,
			[
				'label'       => __( 'Position', 'product-layouts' ),
				'type'        => Controls::CHOOSE,
				'operator'    => Controls::OPERATOR_ICON,
				'default'     => '',
				'options'     => [
					'start'  => [
						'title' => __( 'Left', 'product-layouts' ),
						'icon'  => 'dashicons dashicons-editor-alignleft',
					],
					'center' => [
						'title' => __( 'Center', 'product-layouts' ),
						'icon'  => 'dashicons dashicons-editor-aligncenter',
					],
					'end'    => [
						'title' => __( 'Right', 'product-layouts' ),
						'icon'  => 'dashicons dashicons-editor-alignright',
					],
				],
				'selector'    => [
					'{{WRAPPER}} .wpte-general-layout-image-area ul' => 'align-items:{{VALUE}};',
				],
				'description' => '',
			]
		);
		$this->add_group_control(
			'wpte_product_layout_general_badge_border', $this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-image-area ul li' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_badge_border_radius',
			$this->style,
			[
				'label'             => __( 'Border Radius', 'product-layouts' ),
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
					'{{WRAPPER}} .wpte-general-layout-image-area ul li' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_badge_space',
			$this->style,
			[
				'label'        => __( 'Badge Space', 'product-layouts' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '',
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
					'{{WRAPPER}} .wpte-general-layout-image-area ul li' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);
		$this->add_responsive_control(
			'wpte_product_layout_general_badge_padding',
			$this->style,
			[
				'label'             => __( 'Padding', 'product-layouts' ),
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
					'{{WRAPPER}} .wpte-general-layout-image-area ul li' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);
		$this->add_responsive_control(
			'wpte_product_layout_general_badge_margin',
			$this->style,
			[
				'label'             => __( 'Margin', 'product-layouts' ),
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
					'{{WRAPPER}} .wpte-general-layout-image-area ul' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_image_style.
	 */
	protected function wpte_image_style() {
		$this->start_controls_section(
			'wpte-product-general-image',
			[
				'label'     => 'Image Styles',
				'showing'   => true,
				'condition' => [ 'wpte_general_products_show_image' => 'yes' ],
			]
		);

		$this->add_control(
			'wpte-product-general-image-hyperlink',
			$this->style,
			[
				'label'        => __( 'Hyperlink', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'product-layouts' ),
				'label_off'    => __( 'No', 'product-layouts' ),
				'return_value' => 'yes',
			]
		);
		$this->add_control(
			'wpte-product-general-image-open-new-window',
			$this->style,
			[
				'label'        => __( 'Open in new window', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'product-layouts' ),
				'label_off'    => __( 'No', 'product-layouts' ),
				'return_value' => 'yes',
				'condition'    => [ 'wpte-product-general-image-hyperlink' => 'yes' ],
			]
		);
		$this->add_control(
			'wpte-product-general-image-nofollow',
			$this->style,
			[
				'label'        => __( 'Add nofollow', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'product-layouts' ),
				'label_off'    => __( 'No', 'product-layouts' ),
				'return_value' => 'yes',
				'condition'    => [ 'wpte-product-general-image-hyperlink' => 'yes' ],
			]
		);

		$this->add_control(
			'wpte_product_layout_general_image_size', $this->style, [
				'label'   => __( 'Image Size', 'product-layouts' ),
				'type'    => Controls::SELECT,
				'loader'  => true,
				// 'multiple' => true,
				'default' => 'woocommerce_thumbnail',
				'options' => wpte_thumbnail_sizes(),
			]
		);

		$this->add_group_control(
			'wpte_product_layout_general_image_border', $this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-product-thumb,
					{{WRAPPER}} .wpte-general-layout-product-gallery-thumb' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_general_image_boxshadow',
			$this->style, [
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-general-layout-product-thumb,
					{{WRAPPER}} .wpte-general-layout-product-gallery-thumb
					' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_image_border_radius',
			$this->style,
			[
				'label'             => __( 'Border Radius', 'product-layouts' ),
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
					'{{WRAPPER}} .wpte-general-layout-product-thumb,
					{{WRAPPER}} .wpte-general-layout-product-thumb img,
					{{WRAPPER}} .wpte-general-layout-product-gallery-thumb,
					{{WRAPPER}} .wpte-general-layout-product-gallery-thumb img
					' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_image_padding',
			$this->style,
			[
				'label'             => __( 'Padding', 'product-layouts' ),
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
					'{{WRAPPER}} .wpte-general-layout-image-area' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_image_style_without_much_options.
	 */
	protected function wpte_image_style_without_much_options() {

		$this->start_controls_section(
			'wpte-product-general-image',
			[
				'label'     => 'Image Styles',
				'showing'   => true,
				'condition' => [ 'wpte_general_products_show_image' => 'yes' ],
			]
		);

		$this->add_control(
			'wpte-product-general-image-hyperlink',
			$this->style,
			[
				'label'        => __( 'Hyperlink', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'product-layouts' ),
				'label_off'    => __( 'No', 'product-layouts' ),
				'return_value' => 'yes',
			]
		);
		$this->add_control(
			'wpte-product-general-image-open-new-window',
			$this->style,
			[
				'label'        => __( 'Open in new window', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'product-layouts' ),
				'label_off'    => __( 'No', 'product-layouts' ),
				'return_value' => 'yes',
				'condition'    => [ 'wpte-product-general-image-hyperlink' => 'yes' ],
			]
		);
		$this->add_control(
			'wpte-product-general-image-nofollow',
			$this->style,
			[
				'label'        => __( 'Add nofollow', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'product-layouts' ),
				'label_off'    => __( 'No', 'product-layouts' ),
				'return_value' => 'yes',
				'condition'    => [ 'wpte-product-general-image-hyperlink' => 'yes' ],
			]
		);

		$this->add_control(
			'wpte_product_layout_general_image_size', $this->style, [
				'label'   => __( 'Image Size', 'product-layouts' ),
				'type'    => Controls::SELECT,
				'loader'  => true,
				// 'multiple' => true,
				'default' => 'woocommerce_thumbnail',
				'options' => wpte_thumbnail_sizes(),
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_cart_button_style.
	 */
	protected function wpte_cart_button_style() {
		$this->start_controls_section(
			'wpte-product-general-cart-button-icons',
			[
				'label'     => 'Cart Button Styles',
				'showing'   => true,
				'condition' => [ 'wpte_general_products_show_icons' => 'yes' ],
			]
		);

		$this->add_group_control(
			'wpte_product_layout_general_cart_button_cart_text_typo', $this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-general-layout-cart-button a span, {{WRAPPER}} .wpte-general-layout-cart-button .button span' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_cart_button_icon_size',
			$this->style,
			[
				'label'        => __( 'Icon Size', 'product-layouts' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '',
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
					'{{WRAPPER}} .wpte-general-layout-cart-button a,
					{{WRAPPER}} .wpte-general-layout-cart-button .button' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_cart_button_icon_gap',
			$this->style,
			[
				'label'        => __( 'Icon Gap', 'product-layouts' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '',
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
					'{{WRAPPER}} .wpte-general-layout-product-cart-button-wrapper .wpte-icon,
					{{WRAPPER}} .wpte-general-layout-product-cart-button-wrapper .loading::before' => 'margin-right: {{SIZE}}{{UNIT}} !important;',
				],
				'description'  => '',
			]
		);

		$this->start_controls_tabs(
			'wpte_product_layout_general_cart_button_start_tabs',
			[
				'options' => [
					'normal' => esc_html__( 'Normal ', 'product-layouts' ),
					'hover'  => esc_html__( 'Hover ', 'product-layouts' ),
				],
			]
		);
		$this->start_controls_tab();
		$this->add_control(
			'wpte_product_layout_general_cart_button_icon_bg',
			$this->style, [
				'label'             => __( 'Background', 'product-layouts' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-cart-button a,
					{{WRAPPER}} .wpte-general-layout-cart-button .button' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);
		$this->add_control(
			'wpte_product_layout_general_cart_button_icon_color', $this->style, [
				'label'             => __( 'Color', 'product-layouts' ),
				'type'              => Controls::COLOR,
				'separator'         => 'after',
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-cart-button a,
						{{WRAPPER}} .wpte-general-layout-cart-button .button' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab();
		$this->add_control(
			'wpte_product_layout_general_cart_button_icon_bg_hover',
			$this->style, [
				'label'             => __( 'Background', 'product-layouts' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-cart-button a:hover,
						{{WRAPPER}} .wpte-general-layout-cart-button .button:hover' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);
		$this->add_control(
			'wpte_product_layout_general_cart_button_icon_hover_color', $this->style, [
				'label'             => __( 'Color', 'product-layouts' ),
				'type'              => Controls::COLOR,
				'separator'         => 'after',
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-cart-button a:hover,
						{{WRAPPER}} .wpte-general-layout-cart-button .button:hover' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			'wpte_product_layout_general_cart_button_icon_border', $this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-cart-button a,
					{{WRAPPER}} .wpte-general-layout-cart-button .button' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_general_cart_button_icon_boxshadow',
			$this->style, [
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-general-layout-cart-button a,
					{{WRAPPER}} .wpte-general-layout-cart-button .button' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_cart_button_icon_border_radius',
			$this->style,
			[
				'label'             => __( 'Border Radius', 'product-layouts' ),
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
					'{{WRAPPER}} .wpte-general-layout-cart-button a,
					{{WRAPPER}} .wpte-general-layout-cart-button .button' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_cart_button_icon_padding',
			$this->style,
			[
				'label'             => __( 'Padding', 'product-layouts' ),
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
					'{{WRAPPER}} .wpte-general-layout-cart-button a,
					{{WRAPPER}} .wpte-general-layout-cart-button .button' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_icon_style.
	 */
	protected function wpte_icon_style() {
		$this->start_controls_section(
			'wpte-product-general-icons',
			[
				'label'     => 'Icon Styles',
				'showing'   => true,
				'condition' => [ 'wpte_general_products_show_icons' => 'yes' ],
			]
		);

		$this->add_control(
			'wpte_product_general_icon_align',
			$this->style,
			[
				'label'       => __( 'Align', 'product-layouts' ),
				'type'        => Controls::CHOOSE,
				'operator'    => Controls::OPERATOR_ICON,
				'default'     => '',
				'options'     => [
					'start'  => [
						'title' => __( 'Start', 'product-layouts' ),
						'icon'  => 'dashicons dashicons-editor-alignleft',
					],
					'center' => [
						'title' => __( 'Center', 'product-layouts' ),
						'icon'  => 'dashicons dashicons-editor-aligncenter',
					],
					'end'    => [
						'title' => __( 'End', 'product-layouts' ),
						'icon'  => 'dashicons dashicons-editor-alignright',
					],
				],
				'selector'    => [
					'{{WRAPPER}} .wpte-general-layout-icon-top,
						{{WRAPPER}} .wpte-general-layout-icon-right,
						{{WRAPPER}} .wpte-general-layout-icon-bottom,
						{{WRAPPER}} .wpte-general-layout-icon-left
						' => 'justify-content:{{VALUE}};',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_icon_min_width',
			$this->style,
			[
				'label'        => __( 'Min Width', 'product-layouts' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '',
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
					{{WRAPPER}} .wpte-general-layout-icons .button' => 'min-width: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_icon_min_height',
			$this->style,
			[
				'label'        => __( 'Min Height', 'product-layouts' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '',
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
					{{WRAPPER}} .wpte-general-layout-icons .button' => 'min-height: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->start_controls_tabs(
			'wpte_product_layout_general_start_tabs',
			[
				'options' => [
					'normal' => esc_html__( 'Normal ', 'product-layouts' ),
					'hover'  => esc_html__( 'Hover ', 'product-layouts' ),
				],
			]
		);
		$this->start_controls_tab();
		$this->add_control(
			'wpte_product_layout_general_icon_bg',
			$this->style, [
				'label'             => __( 'Background', 'product-layouts' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-icons a,
						{{WRAPPER}} .wpte-general-layout-icons .button' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);
		$this->add_control(
			'wpte_product_layout_general_icon_color', $this->style, [
				'label'             => __( 'Color', 'product-layouts' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-icons a,
						{{WRAPPER}} .wpte-general-layout-icons .button' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab();
		$this->add_control(
			'wpte_product_layout_general_icon_bg_hover',
			$this->style, [
				'label'             => __( 'Background', 'product-layouts' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-icons a:hover,
						{{WRAPPER}} .wpte-general-layout-icons .button:hover' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);
		$this->add_control(
			'wpte_product_layout_general_icon_hover_color', $this->style, [
				'label'             => __( 'Color', 'product-layouts' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-icons a:hover,
						{{WRAPPER}} .wpte-general-layout-icons .button:hover' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'wpte_product_layout_general_icon_size',
			$this->style,
			[
				'label'        => __( 'Icon Size', 'product-layouts' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'separator'    => 'before',
				'default'      => [
					'unit' => 'px',
					'size' => '',
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
					{{WRAPPER}} .wpte-general-layout-icons .button' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_icon_gap',
			$this->style,
			[
				'label'        => __( 'Icon Gap', 'product-layouts' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '',
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
			'wpte_product_layout_general_icon_border',
			$this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-icons a,
					{{WRAPPER}} .wpte-general-layout-icons .button' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_general_icon_boxshadow',
			$this->style, [
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-general-layout-icons a,
					{{WRAPPER}} .wpte-general-layout-icons .button' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_icon_border_radius',
			$this->style,
			[
				'label'             => __( 'Border Radius', 'product-layouts' ),
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
					'{{WRAPPER}} .wpte-general-layout-icons a,
					{{WRAPPER}} .wpte-general-layout-icons .button' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_icon_margin',
			$this->style,
			[
				'label'             => __( 'Margin', 'product-layouts' ),
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
					'{{WRAPPER}} .wpte-general-layout-product-icons' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_tooltip_style.
	 *
	 * @param string $indigator .
	 */
	protected function wpte_tooltip_style( $indigator = 'border-left-color' ) {
		$this->start_controls_section(
			'wpte-product-general-tooltip',
			[
				'label'   => 'Tooltip Styles',
				'showing' => true,
			]
		);

		$this->add_group_control(
			'wpte_product_layout_general_tooltip_typho',
			$this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-tooltip' => '',
				],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_general_tooltip_color', $this->style, [
				'label'             => __( 'Color', 'product-layouts' ),
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
			'wpte_product_layout_general_tooltip_indigator_color', $this->style, [
				'label'             => __( 'Indigator Color', 'product-layouts' ),
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
			'wpte_product_layout_general_tooltip_bg',
			$this->style,
			[
				'label'             => __( 'Background', 'product-layouts' ),
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
			'wpte_product_general_tooltip_border', $this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-product-tooltip' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_general_tooltip_border_radius',
			$this->style,
			[
				'label'             => __( 'Border Radius', 'product-layouts' ),
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
			'wpte_product_general_tooltip_padding',
			$this->style,
			[
				'label'             => __( 'Padding', 'product-layouts' ),
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
	 * Method wpte_category_style.
	 */
	protected function wpte_category_style() {
		$this->start_controls_section(
			'wpte-product-general-category',
			[
				'label'     => 'Category Styles',
				'showing'   => true,
				'condition' => [ 'wpte_general_products_show_cat' => 'yes' ],
			]
		);

		$this->add_group_control(
			'wpte_product_layout_general_category_typho', $this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-general-layout-category-area a, {{WRAPPER}} .wpte-general-layout-category-area' => '',
				],
				'description' => '',
			]
		);

		$this->start_controls_tabs(
			'wpte_product_layout_general_category_start_tabs',
			[
				'options' => [
					'normal' => esc_html__( 'Normal ', 'product-layouts' ),
					'hover'  => esc_html__( 'Hover ', 'product-layouts' ),
				],
			]
		);

		$this->start_controls_tab();

		$this->add_control(
			'wpte_product_layout_general_category_color', $this->style, [
				'label'             => __( 'Color', 'product-layouts' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-category-area a' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_general_category_bg', $this->style, [
				'label'             => __( 'Background', 'product-layouts' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-category-area a' => 'background: {{VALUE}};',
				],
				'separator'         => 'after',
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab();

		$this->add_control(
			'wpte_product_layout_general_category_hover_color', $this->style, [
				'label'             => __( 'Hover Color', 'product-layouts' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-category-area a:hover' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_general_category_bg_hover', $this->style, [
				'label'             => __( 'Background', 'product-layouts' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-category-area a:hover' => 'background: {{VALUE}};',
				],
				'separator'         => 'after',
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			'wpte_product_layout_general_category_boxshadow', $this->style, [
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-general-layout-category-area a' => '',
				],
				'separator'   => 'before',
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_category_radius',
			$this->style,
			[
				'label'             => __( 'Border Radius', 'product-layouts' ),
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
					'{{WRAPPER}} .wpte-general-layout-category-area a' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',

			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_category_padding',
			$this->style,
			[
				'label'             => __( 'Padding', 'product-layouts' ),
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
					'{{WRAPPER}} .wpte-general-layout-category-area a' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_category_margin',
			$this->style,
			[
				'label'             => __( 'Margin', 'product-layouts' ),
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
					'{{WRAPPER}} .wpte-general-layout-category-area a' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_category_style.
	 */
	protected function wpte_category_style_without_much_options() {
		$this->start_controls_section(
			'wpte-product-general-category',
			[
				'label'     => 'Category Styles',
				'showing'   => true,
				'condition' => [ 'wpte_general_products_show_cat' => 'yes' ],
			]
		);

		$this->add_group_control(
			'wpte_product_layout_general_category_typho', $this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-general-layout-category-area a, {{WRAPPER}} .wpte-general-layout-category-area' => '',
				],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_general_category_color', $this->style, [
				'label'             => __( 'Color', 'product-layouts' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-category-area a' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_category_margin',
			$this->style,
			[
				'label'             => __( 'Margin', 'product-layouts' ),
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
					'{{WRAPPER}} .wpte-general-layout-category-area a' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_title_style.
	 */
	protected function wpte_title_style() {

		$this->start_controls_section(
			'wpte_product_layout_general_title',
			[
				'label'     => 'Title Styles',
				'showing'   => true,
				'condition' => [ 'wpte_general_products_show_title' => 'yes' ],
			]
		);

		$this->add_control(
			'wpte_product_layout_general_title_tag', $this->style, [
				'label'   => __( 'Title Tag', 'product-layouts' ),
				'type'    => Controls::SELECT,
				'loader'  => true,
				'default' => 'h2',
				'options' => wpte_product_title_tags(),
			]
		);

		$this->add_group_control(
			'wpte_product_layout_general_title_typho', $this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-general-layout-title-area .wpte-general-layout-product-title,
					{{WRAPPER}} .wpte-general-layout-title-area .wpte-general-layout-product-title a' => '',
				],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_general_title_color', $this->style, [
				'label'             => __( 'Color', 'product-layouts' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-title-area .wpte-general-layout-product-title,
					{{WRAPPER}} .wpte-general-layout-title-area .wpte-general-layout-product-title a' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_general_title_hover_color', $this->style, [
				'label'             => __( 'Hover Color', 'product-layouts' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-title-area .wpte-general-layout-product-title a:hover' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_title_margin',
			$this->style,
			[
				'label'             => __( 'Margin', 'product-layouts' ),
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
					'{{WRAPPER}} .wpte-general-layout-product-title' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_general_style_description.
	 */
	public function wpte_general_style_description() {

		$this->start_controls_section(
			'wpte_product_layout_general_style_desc',
			[
				'label'     => 'Description Styles',
				'showing'   => true,
				'condition' => [ 'wpte_general_products_show_desc' => 'yes' ],
			]
		);

		$this->add_control(
			'wpte_product_layout_general_style_excerpt',
			$this->style,
			[
				'label'     => __( 'Product Excerpt', 'product-layouts' ),
				'type'      => Controls::NUMBER,
				'loader'    => true,
				'default'   => '10',
				'min'       => 0,
			]
		);

		$this->add_group_control(
			'wpte_product_layout_general_style_desc_typho',
			$this->style,
			[
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-general-layout-description-area' => '',
				],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_general_style_desc_color',
			$this->style,
			[
				'label'             => __( 'Color', 'product-layouts' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-description-area' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_style_desc_margin',
			$this->style,
			[
				'label'             => __( 'Margin', 'product-layouts' ),
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
					'{{WRAPPER}} .wpte-general-layout-description-area' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_rating_style.
	 */
	protected function wpte_rating_style() {
		$this->start_controls_section(
			'wpte_product_layout_general_rating',
			[
				'label'     => 'Rating Styles',
				'showing'   => true,
				'condition' => [ 'wpte_general_products_show_rating' => 'yes' ],
			]
		);

		$this->add_control(
			'wpte_product_layout_general_rating_color', $this->style, [
				'label'             => esc_html__( 'Icon Color', 'product-layouts' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-rating-area .wpte-icons' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_rating_size',
			$this->style,
			[
				'label'        => __( 'Icon Size', 'product-layouts' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '',
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
					'{{WRAPPER}} .wpte-general-layout-rating-area .wpte-icons' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_rating_margin',
			$this->style,
			[
				'label'             => __( 'Margin', 'product-layouts' ),
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
					'{{WRAPPER}} .wpte-general-layout-rating-area .wpte-icons' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_price_style.
	 */
	protected function wpte_price_style() {
		$this->start_controls_section(
			'wpte_product_layout_general_price',
			[
				'label'     => 'Price Styles',
				'showing'   => true,
				'condition' => [ 'wpte_general_products_show_price' => 'yes' ],
			]
		);

		$this->add_group_control(
			'wpte_product_layout_general_price_typho', $this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-general-layout-price-area .amount, {{WRAPPER}} .wpte-general-layout-price-area' => '',
				],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_general_regular_price_color', $this->style, [
				'label'             => __( 'Regular Price Color', 'product-layouts' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-price-area del .amount,
					{{WRAPPER}} .wpte-general-layout-price-area del' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_general_price_color', $this->style, [
				'label'             => __( 'Sale Price Color', 'product-layouts' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-general-layout-price-area .amount,
					{{WRAPPER}} .wpte-general-layout-price-area
					' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_general_price_margin',
			$this->style,
			[
				'label'             => __( 'Margin', 'product-layouts' ),
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
					'{{WRAPPER}} .wpte-general-layout-price-area' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}
}
