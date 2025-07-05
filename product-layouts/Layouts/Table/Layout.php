<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\Table;

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
	 * @return mixed
	 */
	public function register_controls() {

		$this->wpte_settings_tabs_header(
			'wpte-general-section-tabs',
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
	 * Method wpte_product_table_setting_style
	 *
	 * @return mixed
	 */
	protected function wpte_product_table_setting_style() {
		$this->start_controls_section(
			'wpte-product-table-body',
			[
				'label'   => 'Product Table Settings',
				'showing' => true,
			]
		);

		$this->add_control(
			'wpte_product_table_body_text_align',
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
					'{{WRAPPER}} .wpte-product-table-layout-table' => 'text-align:{{VALUE}};',
				],
				'description' => '',
			]
		);

		$this->add_extra_control(
			'wpte_product_table_header',
			$this->style,
			[
				'label'     => 'Table Header',
				'type'      => Controls::HEADING,
				'css'       => 'padding-top:10px; padding-bottom:10px',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			'wpte_product_table_header_typho', $this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-table-layout-table th' => '',
				],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_table_header_bd',
			$this->style, [
				'label'             => __( 'Background', 'wpte-product-layout' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-table-layout-table th' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_table_header_color',
			$this->style, [
				'label'    => __( 'Color', 'wpte-product-layout' ),
				'type'     => Controls::COLOR,
				'default'  => '',
				'selector' => [
					'{{WRAPPER}} .wpte-product-table-layout-table th' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'wpte_product_table_header_padding',
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
					'{{WRAPPER}} .wpte-product-table-layout-table th' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_extra_control(
			'wpte_product_table_body',
			$this->style,
			[
				'label'     => 'Table Body',
				'type'      => Controls::HEADING,
				'css'       => 'padding-top:10px; padding-bottom:10px',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			'wpte_product_table_body_typho', $this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-table-layout-table td' => '',
				],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_table_odd_row_bg',
			$this->style, [
				'label'             => __( 'Odd Background', 'wpte-product-layout' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-table-layout-table tr:nth-child(odd)' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_table_even_row_bg',
			$this->style, [
				'label'             => __( 'Even Background', 'wpte-product-layout' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-table-layout-table tr:nth-child(even)' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_table_body_padding',
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
					'{{WRAPPER}} .wpte-product-table-layout-table td' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_extra_control(
			'wpte_product_table_body_padding_separator',
			$this->style,
			[
				'type' => Controls::SEPARATOR,
				'css'  => 'padding-top:10px; padding-bottom:10px',
			]
		);

		$this->add_group_control(
			'wpte_product_table_body_border',
			$this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-product-table-layout-table' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);
		$this->add_group_control(
			'wpte_product_table_body_boxshadow',
			$this->style, [
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-table-layout-table' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_table_body_border_radius',
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
					'{{WRAPPER}} .wpte-product-table-layout-table' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',

			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_product_table_image_style
	 *
	 * @return mixed
	 */
	protected function wpte_product_table_image_style() {
		$this->start_controls_section(
			'wpte-product-table-image',
			[
				'label'     => 'Image Styles',
				'showing'   => true,
				'condition' => [ 'wpte_table_products_show_image' => 'yes' ],
			]
		);

		$this->add_control(
			'wpte-product-table-image-hyperlink',
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
			'wpte-product-table-image-open-new-window',
			$this->style,
			[
				'label'        => __( 'Open in new window', 'wpte-product-layout' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'wpte-product-layout' ),
				'label_off'    => __( 'No', 'wpte-product-layout' ),
				'return_value' => 'yes',
				'condition'    => [ 'wpte-product-table-image-hyperlink' => 'yes' ],
			]
		);
		$this->add_control(
			'wpte-product-table-image-nofollow',
			$this->style,
			[
				'label'        => __( 'Add nofollow', 'wpte-product-layout' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'wpte-product-layout' ),
				'label_off'    => __( 'No', 'wpte-product-layout' ),
				'return_value' => 'yes',
				'condition'    => [ 'wpte-product-table-image-hyperlink' => 'yes' ],
			]
		);

		$this->add_control(
			'wpte_product_layout_table_image_size', $this->style, [
				'label'   => __( 'Image Size', 'wpte-product-layout' ),
				'type'    => Controls::SELECT,
				'loader'  => true,
				// 'multiple' => true,
				'default' => 'woocommerce_thumbnail',
				'options' => wpte_thumbnail_sizes(),
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_table_image_height',
			$this->style,
			[
				'label'        => __( 'Max Height', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => 100,
				],
				'range'        => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'em' => [
						'min'  => 0,
						'max'  => 10,
						'step' => 0.01,
					],
				],
				'selector'     => [
					'{{WRAPPER}} .wpte-product-table-layout-table td .wpte-product-table-layout-image' => 'height: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_table_image_width',
			$this->style,
			[
				'label'        => __( 'Max Width', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => 100,
				],
				'range'        => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'em' => [
						'min'  => 0,
						'max'  => 10,
						'step' => 0.01,
					],
				],
				'selector'     => [
					'{{WRAPPER}} .wpte-product-table-layout-table td .wpte-product-table-layout-image' => 'width: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_table_image_bg',
			$this->style, [
				'label'             => __( 'Background', 'wpte-product-layout' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-table-layout-table td .wpte-product-table-layout-image' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_table_image_border', $this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-product-table-layout-table td .wpte-product-table-layout-image' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_table_image_boxshadow',
			$this->style, [
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-table-layout-table td .wpte-product-table-layout-image' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_table_image_border_radius',
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
					'{{WRAPPER}} .wpte-product-table-layout-table td img,
					{{WRAPPER}} .wpte-product-table-layout-table td .wpte-product-table-layout-image' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_table_image_padding',
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
					'{{WRAPPER}} .wpte-product-table-layout-table td .wpte-product-table-layout-image' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_product_table_title_style
	 *
	 * @return mixed
	 */
	protected function wpte_product_table_title_style() {
		$this->start_controls_section(
			'wpte_product_layout_table_title',
			[
				'label'     => 'Title Styles',
				'showing'   => true,
				'condition' => [ 'wpte_table_products_show_title' => 'yes' ],
			]
		);

		$this->add_control(
			'wpte_product_layout_table_title_tag', $this->style, [
				'label'   => __( 'Title Tag', 'wpte-product-layout' ),
				'type'    => Controls::SELECT,
				'loader'  => true,
				'default' => 'h2',
				'options' => wpte_product_title_tags(),
			]
		);

		$this->add_control(
			'wpte_product_layout_table_title_color',
			$this->style, [
				'label'             => __( 'Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-table-layout-table td .wpte-product-table-layout-title a' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_table_title_hover_color',
			$this->style, [
				'label'             => __( 'Hover Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-table-layout-table td .wpte-product-table-layout-title a:hover' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_product_table_description_style
	 *
	 * @return mixed
	 */
	protected function wpte_product_table_description_style() {
		$this->start_controls_section(
			'wpte_product_layout_table_description',
			[
				'label'     => 'Description Styles',
				'showing'   => true,
				'condition' => [ 'wpte_table_products_show_description' => 'yes' ],
			]
		);

		$this->add_control(
			'wpte_product_layout_table_style_1_excerpt',
			$this->style,
			[
				'label'     => __( 'Product Excerpt', 'wpte-product-layout' ),
				'type'      => Controls::NUMBER,
				'loader'    => true,
				'default'   => '10',
				'min'       => 0,
			]
		);

		$this->add_control(
			'wpte_product_layout_table_description_color',
			$this->style, [
				'label'             => __( 'Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-table-layout-table td .wpte-product-table-layout-description' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_table_description_padding',
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
					'{{WRAPPER}} .wpte-product-table-layout-table td .wpte-product-table-layout-description' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			'wpte-product-table-price',
			[
				'label'     => 'Price Styles',
				'showing'   => true,
				'condition' => [ 'wpte_table_products_show_price' => 'yes' ],
			]
		);

		$this->add_control(
			'wpte-product-table-regular-color-price', $this->style, [
				'label'             => __( 'Regular Price Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-table-layouts-price del .amount,
					{{WRAPPER}} .wpte-product-table-layouts-price del' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte-product-table-sale-color-price', $this->style, [
				'label'             => __( 'Sale Price Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-table-layouts-price,
					{{WRAPPER}} .wpte-product-table-layouts-price .amount' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_product_table_quantity_style
	 *
	 * @return mixed
	 */
	protected function wpte_product_table_quantity_style() {
		$this->start_controls_section(
			'wpte-product-table-quantity',
			[
				'label'     => 'Quantity Styles',
				'showing'   => true,
				'condition' => [ 'wpte_table_products_show_icons' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_table_quantity_width',
			$this->style,
			[
				'label'        => __( 'Width', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => 70,
				],
				'range'        => [
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
						'min'  => 0.0,
						'max'  => 10,
						'step' => 0.01,
					],
				],
				'selector'     => [
					'{{WRAPPER}} .wpte-product-table-layout-quantity input' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_table_quantity_bg',
			$this->style, [
				'label'             => __( 'Background', 'wpte-product-layout' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-table-layout-quantity input' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_table_quantity_color', $this->style, [
				'label'             => __( 'Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'separator'         => 'after',
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-table-layout-quantity input' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_table_quantity_border', $this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-product-table-layout-quantity input' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_table_quantity_border_radius',
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
					'{{WRAPPER}} .wpte-product-table-layout-quantity input' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_table_quantity_padding',
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
					'{{WRAPPER}} .wpte-product-table-layout-quantity input' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_product_table_button_style
	 *
	 * @return mixed
	 */
	protected function wpte_product_table_button_style() {
		$this->start_controls_section(
			'wpte-product-table-cart-icons',
			[
				'label'     => 'Button Styles',
				'showing'   => true,
				'condition' => [ 'wpte_table_products_show_icons' => 'yes' ],
			]
		);

		$this->add_group_control(
			'wpte_product_layout_table_cart_text_typo', $this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-table-layout-product-cart a, {{WRAPPER}} .wpte-table-layout-product-cart .button' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_table_cart_icon_size',
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
					'{{WRAPPER}} .wpte-table-layout-product-cart a,
					{{WRAPPER}} .wpte-table-layout-product-cart .button' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_table_cart_icon_gap',
			$this->style,
			[
				'label'        => __( 'Icon Gap', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => 6,
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
					'{{WRAPPER}} .wpte-table-layout-product-cart .wpte-icon,
					{{WRAPPER}} .wpte-table-layout-product-cart .loading::before' => 'margin-right: {{SIZE}}{{UNIT}} !important;',
				],
				'description'  => '',
			]
		);

		$this->start_controls_tabs(
			'wpte_product_layout_table_cart_start_tabs',
			[
				'options' => [
					'normal' => esc_html__( 'Normal ', 'wpte-product-layout' ),
					'hover'  => esc_html__( 'Hover ', 'wpte-product-layout' ),
				],
			]
		);
		$this->start_controls_tab();
		$this->add_control(
			'wpte_product_layout_table_cart_icon_bg',
			$this->style, [
				'label'             => __( 'Background', 'wpte-product-layout' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-table-layout-product-cart a,
						{{WRAPPER}} .wpte-table-layout-product-cart .button' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);
		$this->add_control(
			'wpte_product_layout_table_cart_icon_color', $this->style, [
				'label'             => __( 'Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'separator'         => 'after',
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-table-layout-product-cart a,
						{{WRAPPER}} .wpte-table-layout-product-cart .button' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab();
		$this->add_control(
			'wpte_product_layout_table_cart_icon_bg_hover',
			$this->style, [
				'label'             => __( 'Background', 'wpte-product-layout' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-table-layout-product-cart a:hover,
						{{WRAPPER}} .wpte-table-layout-product-cart .button:hover' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);
		$this->add_control(
			'wpte_product_layout_table_cart_icon_hover_color', $this->style, [
				'label'             => __( 'Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'separator'         => 'after',
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-table-layout-product-cart a:hover,
						{{WRAPPER}} .wpte-table-layout-product-cart .button:hover' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			'wpte_product_layout_table_cart_icon_border', $this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-table-layout-product-cart a,
					{{WRAPPER}} .wpte-table-layout-product-cart .button' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_table_cart_icon_boxshadow',
			$this->style, [
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-table-layout-product-cart a,
					{{WRAPPER}} .wpte-table-layout-product-cart .button' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_table_cart_icon_border_radius',
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
					'{{WRAPPER}} .wpte-table-layout-product-cart a,
					{{WRAPPER}} .wpte-table-layout-product-cart .button' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_table_cart_icon_padding',
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
					'{{WRAPPER}} .wpte-table-layout-product-cart a,
					{{WRAPPER}} .wpte-table-layout-product-cart .button' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}
}
