<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\Caption;

use WPTE_PRODUCT_LAYOUT\Includes\Admin\Pages\AdminRender;
use WPTE_PRODUCT_LAYOUT\Includes\Controls;

/**
 * Layout
 */
class Layout extends AdminRender {

	/**
	 * Method register_layout
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
	 * Method wpte_get_product_caption_effects.
	 */
	protected function wpte_get_product_caption_effects() {
		return [
			'ID'         => __( 'Product ID', 'wpte-product-layout' ),
			'title'      => __( 'Product Title', 'wpte-product-layout' ),
			'_price'     => __( 'Price', 'wpte-product-layout' ),
			'_sku'       => __( 'SKU', 'wpte-product-layout' ),
			'date'       => __( 'Date', 'wpte-product-layout' ),
			'modified'   => __( 'Last Modified Date', 'wpte-product-layout' ),
			'parent'     => __( 'Parent Id', 'wpte-product-layout' ),
			'rand'       => __( 'Random', 'wpte-product-layout' ),
			'menu_order' => __( 'Menu Order', 'wpte-product-layout' ),
		];
	}

	/**
	 * Method wpte_initial_plugin_column.
	 */
	public function wpte_initial_plugin_column() {
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
	}

	/**
	 * Method wpte_inital_show_and_hide.
	 */
	public function wpte_inital_show_and_hide() {
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
			'wpte_caption_products_show_cat',
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
			'wpte_caption_products_show_title',
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
			'wpte_caption_products_show_desc',
			$this->style,
			[
				'label'        => __( 'Show Description', 'wpte-product-layout' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'wpte-product-layout' ),
				'label_off'    => __( 'No', 'wpte-product-layout' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'wpte_caption_products_show_rating',
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
			'wpte_caption_products_show_price',
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
			'wpte_caption_products_show_button',
			$this->style,
			[
				'label'        => __( 'Show Button', 'wpte-product-layout' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'wpte-product-layout' ),
				'label_off'    => __( 'No', 'wpte-product-layout' ),
				'css'          => 'padding-bottom:10px',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'wpte_general_products_show_icons',
			$this->style,
			[
				'label'        => __( 'Show Wishlist', 'wpte-product-layout' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'wpte-product-layout' ),
				'label_off'    => __( 'No', 'wpte-product-layout' ),
				'css'          => 'padding-bottom:10px',
				'return_value' => 'yes',
			]
		);
	}

	/**
	 * Method wpte_intial_product_settings.
	 */
	public function wpte_intial_product_settings() {

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
	 * Method wpte_caption_button.
	 */
	public function wpte_caption_button() {
		// =============CART SETTINGS=====================.
		$this->start_controls_section(
			'wpte-product-caption-style-button',
			[
				'label'   => 'Button Setting',
				'showing' => true,
			]
		);

		$this->add_group_control(
			'wpte-product-caption-style-cart-button',
			$this->style,
			[
				'type'        => Controls::CART,
				'default'     => __( 'Cart Icons', 'wpte-product-layout' ),
				'operator'    => 'icontext', // icon, text, icontext.
				'condition'   => [
					'wpte_caption_products_show_icons' => 'yes',
				],
				'description' => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_cation_wishlist.
	 */
	public function wpte_cation_wishlist() {

		// =============WISH LIST SETTINGS=====================.
		$this->start_controls_section(
			'wpte-product-caption-wishlist-icons',
			[
				'label'     => 'Wish List',
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
				'wpte-product-caption-wishlist-icon',
				$this->style,
				[
					'type'        => Controls::WISHLIST,
					'default'     => __( 'Wishlist', 'wpte-product-layout' ),
					'operator'    => 'icon', // icon, text, icontext.
					'condition'   => [
						'wpte_general_products_show_icons' => 'yes',
					],
					'description' => '',
				]
			);
		}

		$this->end_controls_section();
	}

	/**
	 * Method wpte_caption_style_product_body.
	 */
	public function wpte_caption_style_product_body() {
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
			'wpte_product_caption_style_body_border', $this->style, [
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
			$this->style, [
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
					'{{WRAPPER}} .wpte-product-hover-style-caption' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'         => 'before',
				'simpledescription' => '',
				'description'       => '',

			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_caption_style_image.
	 */
	public function wpte_caption_style_image() {
		$this->start_controls_section(
			'wpte-product-caption-style-image',
			[
				'label'   => 'Image Styles',
				'showing' => true,
			]
		);

		$this->add_control(
			'wpte_product_layout_caption_style_image_size', $this->style, [
				'label'   => __( 'Image Size', 'wpte-product-layout' ),
				'type'    => Controls::SELECT,
				'loader'  => true,
				// 'multiple' => true,.
				'default' => 'woocommerce_thumbnail',
				'options' => wpte_thumbnail_sizes(),
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_caption_wishlist_icon_style.
	 */
	public function wpte_caption_wishlist_icon_style() {
		$this->start_controls_section(
			'wpte-product-caption-style-icon',
			[
				'label'     => 'Wishlist Icon',
				'showing'   => true,
				'condition' => [
					'wpte_general_products_show_icons' => 'yes',
					'wpte_product_layout_wishlist_icon_switcher' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'wpte_caption_style_wishlist_size',
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
					'{{WRAPPER}} .wpte-product-layouts-wish-list .wpte-product-wishlist-icon *' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_control(
			'wpte_caption_style_wishlist_color', $this->style, [
				'label'             => __( 'Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '#ffffff',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-layouts-wish-list a,
					{{WRAPPER}} .wpte-product-layouts-wish-list .wpte-product-wishlist-icon *' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_caption_style_wishlist_h_color', $this->style, [
				'label'             => __( 'Hover Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '#dfdcdc',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-layouts-wish-list .wpte-product-wishlist-icon:hover *,
					{{WRAPPER}} .wpte-product-layouts-wish-list a:hover' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_caption_tooltip_style.
	 */
	public function wpte_caption_tooltip_style() {
		$this->start_controls_section(
			'wpte-product-caption-style-tooltip',
			[
				'label'     => 'Tooltip Styles',
				'showing'   => true,
				'condition' => [
					'wpte_general_products_show_icons' => 'yes',
					'wpte_product_layout_wishlist_icon_tooltip_switcher' => 'yes',
				],
			]
		);

		$this->add_group_control(
			'wpte_caption_style_tooltip_typho',
			$this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-hover-style-caption .wpte-product-layouts-wish-list .wpte-product-tooltip *' => '',
				],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_caption_style_tooltip_color', $this->style, [
				'label'             => __( 'Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '#757373',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-hover-style-caption .wpte-product-layouts-wish-list .wpte-product-tooltip *' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_caption_style_tooltip_indigator_color', $this->style, [
				'label'             => __( 'Indigator Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '#ffffff',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-tooltip:after' => 'border-left-color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_caption_style_tooltip_bg',
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
			'wpte_caption_style_tooltip_border',
			$this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-product-tooltip' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_caption_style_tooltip_border_radius',
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
			'wpte_caption_style_tooltip_padding',
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
	 * Method wpte_caption_style_category.
	 */
	public function wpte_caption_style_category() {

		$this->start_controls_section(
			'wpte-product-caption-style-category',
			[
				'label'     => 'Category Styles',
				'showing'   => true,
				'condition' => [ 'wpte_caption_products_show_cat' => 'yes' ],
			]
		);

		$this->add_group_control(
			'wpte_product_layout_caption_style_category_typho',
			$this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-category a, {{WRAPPER}} .wpte-caption-layout-style-1-category-area' => '',
				],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_caption_style_category_color', $this->style, [
				'label'             => __( 'Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '#ffffff',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-category a' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_caption_style_category_hover_color', $this->style, [
				'label'             => __( 'Hover Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '#bebcbc',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-category a:hover' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_caption_style_category_margin',
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
					'{{WRAPPER}} .wpte-product-category a' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_caption_style_title.
	 */
	public function wpte_caption_style_title() {

		$this->start_controls_section(
			'wpte_product_layout_caption_style_title',
			[
				'label'     => 'Title Styles',
				'showing'   => true,
				'condition' => [ 'wpte_caption_products_show_title' => 'yes' ],
			]
		);

		$this->add_group_control(
			'wpte_product_layout_caption_style_title_typho',
			$this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-title,
					{{WRAPPER}} .wpte-product-title a' => '',
				],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_caption_style_title_color', $this->style, [
				'label'             => __( 'Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '#ffffff',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-title,
					{{WRAPPER}} .wpte-product-title a' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_caption_style_title_hover_color', $this->style, [
				'label'             => __( 'Hover Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '#bebcbc',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-title a:hover' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_caption_style_title_margin',
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
					'{{WRAPPER}} .wpte-product-title' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_caption_style_description.
	 */
	public function wpte_caption_style_description() {

		$this->start_controls_section(
			'wpte_product_layout_caption_style_desc',
			[
				'label'     => 'Description Styles',
				'showing'   => true,
				'condition' => [ 'wpte_caption_products_show_desc' => 'yes' ],
			]
		);

		$this->add_control(
			'wpte_product_layout_caption_excerpt',
			$this->style,
			[
				'label'     => __( 'Product Excerpt', 'wpte-product-layout' ),
				'type'      => Controls::NUMBER,
				'loader'    => true,
				'default'   => '5',
				'min'       => 0,
			]
		);

		$this->add_group_control(
			'wpte_product_layout_caption_style_desc_typho',
			$this->style,
			[
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-content' => '',
				],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_caption_style_desc_color',
			$this->style,
			[
				'label'             => __( 'Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '#ffffff',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-content' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_caption_style_desc_margin',
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
					'{{WRAPPER}} .wpte-product-content' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_caption_style_rating.
	 */
	public function wpte_caption_style_rating() {

		$this->start_controls_section(
			'wpte_product_layout_caption_style_rating',
			[
				'label'     => 'Rating Styles',
				'showing'   => true,
				'condition' => [ 'wpte_caption_products_show_rating' => 'yes' ],
			]
		);

		$this->add_control(
			'wpte_product_layout_caption_style_rating_color', $this->style, [
				'label'             => __( 'Icon Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '#ffa500',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-rating .wpte-icons' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_caption_style_rating_size',
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
					'{{WRAPPER}} .wpte-product-rating .wpte-icons' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_caption_style_rating_margin',
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
					'{{WRAPPER}} .wpte-product-rating .wpte-icons' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_caption_style_price.
	 */
	public function wpte_caption_style_price() {

		$this->start_controls_section(
			'wpte_product_layout_caption_style_price',
			[
				'label'     => 'Price Styles',
				'showing'   => true,
				'condition' => [ 'wpte_caption_products_show_price' => 'yes' ],
			]
		);

		$this->add_group_control(
			'wpte_product_layout_caption_style_price_typho', $this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-price .amount, {{WRAPPER}} .wpte-product-price' => '',
				],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_layout_caption_style_price_color', $this->style, [
				'label'             => __( 'Price Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '#ffffff',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-price del .amount,
					{{WRAPPER}} .wpte-product-price,
					{{WRAPPER}} .wpte-product-price del' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_caption_style_price_margin',
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
					'{{WRAPPER}} .wpte-product-price' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_caption_style_button.
	 */
	public function wpte_caption_style_button() {

		$this->start_controls_section(
			'wpte-product-caption-button',
			[
				'label'     => 'Button Styles',
				'showing'   => true,
				'condition' => [ 'wpte_caption_products_show_button' => 'yes' ],
			]
		);

		$this->add_group_control(
			'wpte_product_layout_caption_button_typo', $this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-button a, 
					{{WRAPPER}} .wpte-product-button .button' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_caption_button_icon_size',
			$this->style,
			[
				'label'        => __( 'Size', 'wpte-product-layout' ),
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
					'{{WRAPPER}} .wpte-product-button a,
					{{WRAPPER}} .wpte-product-button .button' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_caption_button_icon_gap',
			$this->style,
			[
				'label'        => __( 'Icon Gap', 'wpte-product-layout' ),
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
					'{{WRAPPER}} .wpte-product-button .wpte-icon, 
					{{WRAPPER}} .wpte-product-button .loading::before' => 'margin-right: {{SIZE}}{{UNIT}} !important;',
				],
				'description'  => '',
			]
		);

		$this->start_controls_tabs(
			'wpte_product_layout_caption_button_start_tabs',
			[
				'options' => [
					'normal' => esc_html__( 'Normal ', 'wpte-product-layout' ),
					'hover'  => esc_html__( 'Hover ', 'wpte-product-layout' ),
				],
			]
		);
		$this->start_controls_tab();
			$this->add_control(
				'wpte_product_layout_caption_button_bg',
				$this->style, [
					'label'             => __( 'Background', 'wpte-product-layout' ),
					'type'              => Controls::GRADIENT,
					'default'           => 'rgba(74, 130, 10, 1)',
					'selector'          => [
						'{{WRAPPER}} .wpte-product-hover-figure-caption .wpte-product-button a,
						{{WRAPPER}} .wpte-product-hover-figure-caption .wpte-product-button .button' => 'background: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);
			$this->add_control(
				'wpte_product_layout_caption_button_color', $this->style, [
					'label'             => __( 'Color', 'wpte-product-layout' ),
					'type'              => Controls::COLOR,
					'default'           => '#ffffff',
					'selector'          => [
						'{{WRAPPER}} .wpte-product-hover-figure-caption .wpte-product-button a,
						{{WRAPPER}} .wpte-product-hover-figure-caption .wpte-product-button .button' => 'color: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

			$this->add_responsive_control(
				'wpte_product_layout_caption_button_border_radius',
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
						'{{WRAPPER}} .wpte-product-button a,
						{{WRAPPER}} .wpte-product-button .button' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

		$this->end_controls_tab();

		$this->start_controls_tab();
			$this->add_control(
				'wpte_product_layout_caption_button_bg_hover',
				$this->style, [
					'label'             => __( 'Background', 'wpte-product-layout' ),
					'type'              => Controls::GRADIENT,
					'default'           => '#ffffff',
					'selector'          => [
						'{{WRAPPER}} .wpte-product-hover-figure-caption .wpte-product-button a:hover,
						{{WRAPPER}} .wpte-product-hover-figure-caption .wpte-product-button .button:hover' => 'background: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);
			$this->add_control(
				'wpte_product_layout_caption_button_hover_color', $this->style, [
					'label'             => __( 'Color', 'wpte-product-layout' ),
					'type'              => Controls::COLOR,
					'default'           => '#4a820a',
					'selector'          => [
						'{{WRAPPER}} .wpte-product-hover-figure-caption .wpte-product-button a:hover,
						{{WRAPPER}} .wpte-product-hover-figure-caption .wpte-product-button .button:hover' => 'color: {{VALUE}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

			$this->add_responsive_control(
				'wpte_product_layout_caption_button_border_hover_radius',
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
						'{{WRAPPER}} .wpte-product-button a:hover,
						{{WRAPPER}} .wpte-product-button .button:hover' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'simpledescription' => '',
					'description'       => '',
				]
			);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_extra_control(
			'wpte_product_layout_caption_button_separator',
			$this->style,
			[
				'type' => Controls::SEPARATOR,
				'css'  => 'padding-top:10px; padding-bottom:10px',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_caption_button_border', $this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-product-button a,
					{{WRAPPER}} .wpte-product-button .button' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_layout_caption_button_boxshadow',
			$this->style, [
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-button a,
					{{WRAPPER}} .wpte-product-button .button' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_layout_caption_button_padding',
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
					'{{WRAPPER}} .wpte-product-button a,
					{{WRAPPER}} .wpte-product-button .button' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
	public function register_controls() {

		$this->wpte_settings_tabs_header(
			'wpte-caption-section-tabs',
			[
				'options' => [
					'general' => __( 'Content', 'wpte-product-layout' ),
					'style'   => __( 'Style', 'wpte-product-layout' ),
				],
			]
		);

		$this->register_layout();
	}
}
