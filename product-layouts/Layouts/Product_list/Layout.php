<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\Product_list;

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
	 * Method wpte_product_list_column.
	 */
	public function wpte_product_list_column() {

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
	 * Method wpte_product_list_body_style
	 *
	 * @return void
	 */
	public function wpte_product_list_body_style() {
		$this->start_controls_section(
			'wpte-product-list-body',
			[
				'label'   => 'Body Settings',
				'showing' => true,
			]
		);

		$this->add_control(
			'wpte_product_list_body_text_align',
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
					'{{WRAPPER}} .wpte-product-list-row' => 'text-align:{{VALUE}};',
				],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_list_header_bd',
			$this->style, [
				'label'             => __( 'Background', 'product-layouts' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-list-row' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_list_body_border',
			$this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-product-list-row' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);
		$this->add_group_control(
			'wpte_product_list_body_boxshadow',
			$this->style, [
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-list-row' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_list_body_border_radius',
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
					'{{WRAPPER}} .wpte-product-list-row' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',

			]
		);

		$this->add_responsive_control(
			'wpte_product_list_header_padding',
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
					'{{WRAPPER}} .wpte-product-list-row' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_product_list_image_style
	 *
	 * @return void
	 */
	public function wpte_product_list_image_style() {
		$this->start_controls_section(
			'wpte-product-list-image',
			[
				'label'     => 'Image Styles',
				'showing'   => true,
				'condition' => [ 'wpte_list_products_show_image' => 'yes' ],
			]
		);

		$this->add_control(
			'wpte-product-list-image-hyperlink',
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
			'wpte-product-list-image-open-new-window',
			$this->style,
			[
				'label'        => __( 'Open in new window', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'product-layouts' ),
				'label_off'    => __( 'No', 'product-layouts' ),
				'return_value' => 'yes',
				'condition'    => [ 'wpte-product-list-image-hyperlink' => 'yes' ],
			]
		);
		$this->add_control(
			'wpte-product-list-image-nofollow',
			$this->style,
			[
				'label'        => __( 'Add nofollow', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'product-layouts' ),
				'label_off'    => __( 'No', 'product-layouts' ),
				'return_value' => 'yes',
				'condition'    => [ 'wpte-product-list-image-hyperlink' => 'yes' ],
			]
		);

		$this->add_control(
			'wpte_product_layout_list_image_size', $this->style, [
				'label'   => __( 'Image Size', 'product-layouts' ),
				'type'    => Controls::SELECT,
				'loader'  => true,
				// 'multiple' => true,
				'default' => 'woocommerce_thumbnail',
				'options' => wpte_thumbnail_sizes(),
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_list_image_width',
			$this->style,
			[
				'label'        => __( 'Max Width', 'product-layouts' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => 150,
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
					'{{WRAPPER}} .wpte-product-list-product-image, .wpte-product-list-product-image .wpte-product-list-img img' => 'max-width: {{SIZE}}{{UNIT}} !important;',
				],
				'description'  => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_list_image_bg',
			$this->style, [
				'label'             => __( 'Background', 'product-layouts' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-product-image .wpte-product-list-img' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_list_image_border', $this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-product-image .wpte-product-list-img' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_list_image_boxshadow',
			$this->style, [
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-product-image .wpte-product-list-img' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_list_image_border_radius',
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
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-product-image .wpte-product-list-img img,
					{{WRAPPER}} .wpte-product-list-row .wpte-product-list-product-image .wpte-product-list-img' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_list_image_padding',
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
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-product-image .wpte-product-list-img' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_product_list_title_style
	 *
	 * @return void
	 */
	public function wpte_product_list_title_style() {
		$this->start_controls_section(
			'wpte_product_layout_list_title',
			[
				'label'     => 'Title Styles',
				'showing'   => true,
				'condition' => [ 'wpte_list_products_show_title' => 'yes' ],
			]
		);

		$this->add_group_control(
			'wpte_product_layout_list_title_typo', $this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-product-text .wpte-product-list-product-title a' => '',
				],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_list_title_tag', $this->style, [
				'label'   => __( 'Title Tag', 'product-layouts' ),
				'type'    => Controls::SELECT,
				'loader'  => true,
				'default' => 'h2',
				'options' => wpte_product_title_tags(),
			]
		);

		$this->add_control(
			'wpte_product_layout_list_title_color',
			$this->style, [
				'label'             => __( 'Color', 'product-layouts' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-product-text .wpte-product-list-product-title a' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_list_title_hover_color',
			$this->style, [
				'label'             => __( 'Hover Color', 'product-layouts' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-product-text .wpte-product-list-product-title a:hover' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_product_list_title_style
	 *
	 * @return void
	 */
	public function wpte_product_list_description_style() {
		$this->start_controls_section(
			'wpte_product_layout_list_description',
			[
				'label'     => 'Description Styles',
				'showing'   => true,
				'condition' => [ 'wpte_list_products_show_description' => 'yes' ],
			]
		);

		$this->add_group_control(
			'wpte_product_layout_list_desc_typo', $this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-product-text .wpte-product-list-product-description p' => '',
				],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_list_description_color',
			$this->style, [
				'label'             => __( 'Color', 'product-layouts' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-product-text .wpte-product-list-product-description p' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_list_description_padding',
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
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-product-text .wpte-product-list-product-description p' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_product_list_price_style
	 *
	 * @return void
	 */
	public function wpte_product_list_price_style() {
		$this->start_controls_section(
			'wpte-product-list-price',
			[
				'label'     => 'Price Styles',
				'showing'   => true,
				'condition' => [ 'wpte_list_products_show_price' => 'yes' ],
			]
		);

		$this->add_group_control(
			'wpte_product_layout_list_price_typo', $this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-product-price' => '',
				],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_list_regular_price_color', $this->style, [
				'label'             => __( 'Regular Price Color', 'product-layouts' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-product-price del .amount,
					{{WRAPPER}} .wpte-product-list-row .wpte-product-list-product-price del' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_list_price_color', $this->style, [
				'label'             => __( 'Sale Price Color', 'product-layouts' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-product-price,
					{{WRAPPER}} .wpte-product-list-row .wpte-product-list-product-price .amount' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_list_price_padding',
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
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-product-price' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_product_list_quantity_style
	 *
	 * @return void
	 */
	public function wpte_product_list_quantity_style() {
		$this->start_controls_section(
			'wpte-product-list-quantity',
			[
				'label'     => 'Quantity Styles',
				'showing'   => true,
				'condition' => [ 'wpte_list_products_show_qty' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_list_quantity_width',
			$this->style,
			[
				'label'        => __( 'Width', 'product-layouts' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '',
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
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-quantity .quantity input' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_list_quantity_bg',
			$this->style, [
				'label'             => __( 'Background', 'product-layouts' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-quantity .quantity input' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_list_quantity_color', $this->style, [
				'label'             => __( 'Color', 'product-layouts' ),
				'type'              => Controls::COLOR,
				'separator'         => 'after',
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-quantity .quantity input' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_list_quantity_border', $this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-quantity .quantity input' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_list_quantity_border_radius',
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
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-quantity .quantity input' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_list_quantity_padding',
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
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-quantity .quantity input' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_product_list_quantity_style
	 *
	 * @return void
	 */
	public function wpte_product_list_button_style() {
		$this->start_controls_section(
			'wpte-product-list-cart-icons',
			[
				'label'     => 'Button Styles',
				'showing'   => true,
				'condition' => [ 'wpte_general_products_show_icons' => 'yes' ],
			]
		);

		$this->add_group_control(
			'wpte_product_layout_list_cart_text_typo', $this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-button .wpte-product-cart-icon-render a,
						{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-button .wpte-product-cart-icon-render .button' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_list_cart_icon_size',
			$this->style,
			[
				'label'        => __( 'Size', 'product-layouts' ),
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
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-button .wpte-product-cart-icon-render a,
						{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-button .wpte-product-cart-icon-render .button' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_list_cart_icon_gap',
			$this->style,
			[
				'label'        => __( 'Icon Gap', 'product-layouts' ),
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
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-button .wpte-product-cart-icon-render .button .wpte-icon,
					{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-button .wpte-product-cart-icon-render .button .loading::before' => 'margin-right: {{SIZE}}{{UNIT}} !important;',
				],
				'description'  => '',
			]
		);

		$this->start_controls_tabs(
			'wpte_product_layout_list_cart_start_tabs',
			[
				'options' => [
					'normal' => esc_html__( 'Normal ', 'product-layouts' ),
					'hover'  => esc_html__( 'Hover ', 'product-layouts' ),
				],
			]
		);
		$this->start_controls_tab();
		$this->add_control(
			'wpte_product_layout_list_cart_icon_bg',
			$this->style, [
				'label'             => __( 'Background', 'product-layouts' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-button .wpte-product-cart-icon-render a,
						{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-button .wpte-product-cart-icon-render .button' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);
		$this->add_control(
			'wpte_product_layout_list_cart_icon_color', $this->style, [
				'label'             => __( 'Color', 'product-layouts' ),
				'type'              => Controls::COLOR,
				'separator'         => 'after',
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-button .wpte-product-cart-icon-render a,
						{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-button .wpte-product-cart-icon-render .button' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab();
		$this->add_control(
			'wpte_product_layout_list_cart_icon_bg_hover',
			$this->style, [
				'label'             => __( 'Background', 'product-layouts' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-button .wpte-product-cart-icon-render a:hover,
						{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-button .wpte-product-cart-icon-render .button:hover' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);
		$this->add_control(
			'wpte_product_layout_list_cart_icon_hover_color', $this->style, [
				'label'             => __( 'Color', 'product-layouts' ),
				'type'              => Controls::COLOR,
				'separator'         => 'after',
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-button .wpte-product-cart-icon-render a:hover,
						{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-button .wpte-product-cart-icon-render .button:hover' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			'wpte_product_layout_list_cart_icon_border', $this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-button .wpte-product-cart-icon-render a,
						{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-button .wpte-product-cart-icon-render .button' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_list_cart_icon_boxshadow',
			$this->style, [
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-button .wpte-product-cart-icon-render a,
						{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-button .wpte-product-cart-icon-render .button' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_list_cart_icon_border_radius',
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
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-button .wpte-product-cart-icon-render a,
						{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-button .wpte-product-cart-icon-render .button' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_list_cart_icon_padding',
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
					'{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-button .wpte-product-cart-icon-render a,
						{{WRAPPER}} .wpte-product-list-row .wpte-product-list-cart-area .wpte-product-list-product-button .wpte-product-cart-icon-render .button' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}
}
