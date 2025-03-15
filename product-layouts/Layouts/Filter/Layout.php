<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\Filter;

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
	 * Method wpte_filter_for_shortcode_list.
	 */
	protected function wpte_filter_for_shortcode_list( $cat = '' ) {
		$this->start_controls_section(
			'wpte_settings',
			[
				'label'   => 'Layouts',
				'showing' => true,
			]
		);
		$this->add_control(
			'wpte_filter_for_shortcode', $this->style, [
				'label'       => __( 'Filter for', 'wpte-product-layout' ),
				'type'        => Controls::SELECT,
				'loader'      => true,
				// 'multiple' => true,
				'default'     => '',
				'options'     => wpte_get_shortcode_list(),
				'description' => 'Select a style. This filter will effect the shortcode',
			]
		);
		$this->add_control(
			'wpte_filters_preset',
			$this->style, [
				'label'       => esc_html__( 'Preset', 'wpte-product-layout' ),
				'type'        => Controls::SELECT,
				'loader'      => true,
				'default'     => 'normal',
				'css'         => 'margin-bottom: 20px',
				'description' => 'Change the filter style.',
				'options'     => [
					'normal'   => esc_html__( 'Normal', 'wpte-product-layout' ),
					'dropdown' => esc_html__( 'DropDown', 'wpte-product-layout' ),
				],
			]
		);

		if ( 'cat' === $cat ) {
			$this->add_control(
				'wpte_product_filter_post_count_switcher',
				$this->style,
				[
					'label'        => __( 'Show Post Count', 'wpte-product-layout' ),
					'type'         => Controls::SWITCHER,
					'default'      => 'yes',
					'label_on'     => __( 'Yes', 'wpte-product-layout' ),
					'label_off'    => __( 'No', 'wpte-product-layout' ),
					'return_value' => 'yes',
					'description'  => 'Display the number of posts.',
				]
			);
		}

		$this->end_controls_section();
	}

	/**
	 * Method wpte_filter_for_shortcode_list.
	 */
	protected function wpte_cateogry_query() {
		$this->start_controls_section(
			'wpte_f_category_query',
			[
				'label'   => __( 'Category Query', 'wpte-product-layout' ),
				'showing' => true,
			]
		);

		$this->add_control(
			'wpte_product_f_custom_category',
			$this->style,
			[
				'label'        => __( 'Show Custom Categories', 'wpte-product-layout' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __( 'Yes', 'wpte-product-layout' ),
				'label_off'    => __( 'No', 'wpte-product-layout' ),
				'return_value' => 'yes',
				'description'  => '',
			]
		);

		$this->add_control(
			'wpte_f_category_list',
			$this->style,
			[
				'label' => __( 'Categories', 'wpte-product-layout' ),
				'type'  => Controls::PARENTCATEGORIES,
				'condition'   => [
					'wpte_product_f_custom_category' => 'yes',
				],
			]
		);

		$this->add_control(
			'wpte_f_custom_subcategory',
			$this->style,
			[
				'label'        => __( 'Show Custom Subcategories', 'wpte-product-layout' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __( 'Yes', 'wpte-product-layout' ),
				'label_off'    => __( 'No', 'wpte-product-layout' ),
				'return_value' => 'yes',
				'description'  => '',
			]
		);

		$this->add_control(
			'wpte_f_sub_category_list',
			$this->style,
			[
				'label' => __( 'Sub Categories', 'wpte-product-layout' ),
				'type'  => Controls::SUBCATEGORIES,
				'condition'   => [
					'wpte_f_custom_subcategory' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_filter_for_attributee_shortcode_list.
	 */
	protected function wpte_filter_for_attributee_shortcode_list() {

		$this->start_controls_section(
			'wpte_settings',
			[
				'label'   => 'Layouts',
				'showing' => true,
			]
		);

		$this->add_control(
			'wpte_filter_for_shortcode', $this->style, [
				'label'       => __( 'Filter for', 'wpte-product-layout' ),
				'type'        => Controls::SELECT,
				'loader'      => true,
				// 'multiple' => true,
				'default'     => '',
				'options'     => wpte_get_shortcode_list(),
				'description' => 'Select a style. This filter will effect the shortcode',
			]
		);
		$this->add_control(
			'wpte_filters_attribute',
			$this->style, [
				'label'       => esc_html__( 'Attributes', 'wpte-product-layout' ),
				'type'        => Controls::SELECT,
				'loader'      => true,
				'default'     => 'color',
				'description' => 'Change the attribute.',
				'options'     => wpte_get_attribute_list(),
			]
		);

		$this->add_control(
			'wpte_filters_attribute_style',
			$this->style, [
				'label'       => esc_html__( 'Style', 'wpte-product-layout' ),
				'type'        => Controls::SELECT,
				'loader'      => true,
				'default'     => 'style_1',
				'description' => 'Change color box style.',
				'options'     => [
					'style_1' => esc_html__( 'Style 1', 'wpte-product-layout' ),
					'style_2' => esc_html__( 'Style 2', 'wpte-product-layout' ),
				],
			]
		);
		$this->add_control(
			'wpte_filters_preset',
			$this->style, [
				'label'       => esc_html__( 'Preset', 'wpte-product-layout' ),
				'type'        => Controls::SELECT,
				'loader'      => true,
				'default'     => 'normal',
				'css'         => 'margin-bottom: 20px',
				'description' => 'Change the filter style.',
				'options'     => [
					'normal'   => esc_html__( 'Normal', 'wpte-product-layout' ),
					'dropdown' => esc_html__( 'DropDown', 'wpte-product-layout' ),
				],
			]
		);

		$this->add_control(
			'wpte_filters_attribute_text',
			$this->style,
			[
				'label'        => __( 'Show Text', 'wpte-product-layout' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'wpte-product-layout' ),
				'label_off'    => __( 'No', 'wpte-product-layout' ),
				'return_value' => 'yes',
				'description'  => 'Display the text content.',
			]
		);

		$this->add_control(
			'wpte_product_filter_post_count_switcher',
			$this->style,
			[
				'label'        => __( 'Show Post Count', 'wpte-product-layout' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __( 'Yes', 'wpte-product-layout' ),
				'label_off'    => __( 'No', 'wpte-product-layout' ),
				'return_value' => 'yes',
				'description'  => 'Display the number of posts.',
			]
		);

		$this->add_control(
			'wpte_f_hide_empty',
			$this->style,
			[
				'label'        => __( 'Hide Empty', 'wpte-product-layout' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __( 'Yes', 'wpte-product-layout' ),
				'label_off'    => __( 'No', 'wpte-product-layout' ),
				'return_value' => 'yes',
				'description'  => 'Hide attribute if no post available',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_product_filter_title.
	 */
	protected function wpte_product_filter_title() {
		$this->start_controls_section(
			'wpte_filter_title',
			[
				'label'   => 'Title',
				'showing' => true,
			]
		);

		$this->add_control(
			'wpte_filters_title_show',
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
			'wpte_filters_custom_title',
			$this->style,
			[
				'label'        => __( 'Custom Title?', 'wpte-product-layout' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'wpte-product-layout' ),
				'label_off'    => __( 'No', 'wpte-product-layout' ),
				'return_value' => 'yes',
				'condition'    => [ 'wpte_filters_title_show' => 'yes' ],
			]
		);

		$this->add_control(
			'wpte_filters_custom_title_text',
			$this->style,
			[
				'label'       => esc_html__( 'Title Text', 'wpte-product-layout' ),
				'type'        => Controls::TEXT,
				'default'     => '',
				'description' => '',
				'condition'   => [ 'wpte_filters_custom_title' => 'yes' ],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_filter_for_shortcode_list.
	 */
	protected function wpte_product_filter_box() {

		$this->start_controls_section(
			'wpte_product_filter_box_wapper',
			[
				'label'     => esc_html__( 'Box Style', 'wpte-product-layout' ),
				'showing'   => true,
				'condition' => [ 'wpte_filters_preset' => 'dropdown' ],
			]
		);

		// Sort Filter.
		$this->add_group_control(
			'wpte_product_filter_box_typography',
			$this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [ '{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-product-filter-heading' => '' ],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_filter_box_bg',
			$this->style, [
				'label'             => esc_html__( 'Background', 'wpte-product-layout' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-product-filter-heading' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);
		$this->add_control(
			'wpte_product_filter_box_color',
			$this->style, [
				'label'             => __( 'Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-product-filter-heading' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_box_border_radius',
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
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-product-filter-heading' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_filter_box_border', $this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-product-filter-heading' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_filter_box_boxshadow',
			$this->style, [
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-product-filter-heading' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_box_padding',
			$this->style,
			[
				'label'             => __( 'Padding', 'wpte-product-layout' ),
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
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-product-filter-heading' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_box_margin',
			$this->style,
			[
				'label'             => __( 'Margin', 'wpte-product-layout' ),
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
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_product_filter_dropdown.
	 */
	protected function wpte_product_filter_dropdown() {

		$this->start_controls_section(
			'wpte_product_filter_dropdown',
			[
				'label'     => esc_html__( 'DropDown', 'wpte-product-layout' ),
				'showing'   => true,
				'condition' => [ 'wpte_filters_preset' => 'dropdown' ],
			]
		);

		$this->add_control(
			'wpte_product_filter_dropdown_align',
			$this->style,
			[
				'label'       => __( 'Position', 'wpte-product-layout' ),
				'type'        => Controls::CHOOSE,
				'operator'    => Controls::OPERATOR_ICON,
				'default'     => '',
				'options'     => [
					'right' => [
						'title' => __( 'Left', 'wpte-product-layout' ),
						'icon'  => 'dashicons dashicons-editor-alignleft',
					],
					'left'  => [
						'title' => __( 'Right', 'wpte-product-layout' ),
						'icon'  => 'dashicons dashicons-editor-alignright',
					],
				],
				'selector'    => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-product-filter-dropdown' => 'left:unset;{{VALUE}}:0;',
				],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_filter_dropdown_bg',
			$this->style, [
				'label'             => esc_html__( 'Background', 'wpte-product-layout' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-product-filter-dropdown' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_dropdown_min_width',
			$this->style,
			[
				'label'        => __( 'Min Width', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '260',
				],
				'range'        => [
					'px' => [
						'min'  => 0,
						'max'  => 800,
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
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-product-filter-dropdown' => 'min-width: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_dropdown_min_height',
			$this->style,
			[
				'label'        => __( 'Max Height', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '270',
				],
				'range'        => [
					'px' => [
						'min'  => 0,
						'max'  => 1200,
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
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-product-filter-dropdown' => 'max-height: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_dropdown_border_radius',
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
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-product-filter-dropdown' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_filter_dropdown_border', $this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-product-filter-dropdown' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_filter_dropdown_boxshadow',
			$this->style, [
				'type'        => Controls::BOXSHADOW,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-product-filter-dropdown' => '',
				],
				'description' => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_dropdown_padding',
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
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-product-filter-dropdown' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_product_filter_title.
	 */
	protected function wpte_product_filter_title_style() {

		$this->start_controls_section(
			'wpte_product_filter_title_style',
			[
				'label'     => esc_html__( 'Title', 'wpte-product-layout' ),
				'showing'   => true,
				'condition' => [ 'wpte_filters_preset' => 'normal' ],
			]
		);

		$this->add_group_control(
			'wpte_product_filter_title_typography',
			$this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-product-filter-heading-normal' => '',
				],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_filter_title_color',
			$this->style, [
				'label'             => esc_html__( 'Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-product-filter-heading-normal' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_title_margin',
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
						'max'  => 50,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 20,
						'step' => 1,
					],
					'em' => [
						'min'  => 0,
						'max'  => 10,
						'step' => .1,
					],
				],
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-product-filter-heading-normal' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_product_filter_checkbox.
	 */
	protected function wpte_product_filter_checkbox() {

		$this->start_controls_section(
			'wpte_product_filter_checkbox',
			[
				'label'   => esc_html__( 'Checkbox', 'wpte-product-layout' ),
				'showing' => true,
			]
		);

		$this->add_extra_control(
			'wpte_product_filter_checkbox_heading',
			$this->style,
			[
				'label' => 'Checkbox Style',
				'type'  => Controls::HEADING,
				'css'   => 'padding-top:10px; padding-bottom:10px',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_checkbox_size',
			$this->style,
			[
				'label'        => __( 'Box Size', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '16',
				],
				'range'        => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
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
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label:before' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option input[type=checkbox]:checked + .check-label:after' => 'font-size: calc({{SIZE}}{{UNIT}} - 5px);',
				],
				'description'  => '',
			]
		);

		$this->add_control(
			'wpte_product_filter_checkbox_bg',
			$this->style, [
				'label'             => esc_html__( 'Background Color', 'wpte-product-layout' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label:before' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_filter_checkbox_color',
			$this->style, [
				'label'             => esc_html__( 'Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option input[type=checkbox]:checked + .check-label:after' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_filter_checkbox_border',
			$this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label:before' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_checkbox_border_radius',
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
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label:before' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_filter_checkbox_position',
			$this->style,
			[
				'label'             => __( 'Checkbox position', 'wpte-product-layout' ),
				'type'              => Controls::DIMENSIONS,
				'default'           => [
					'unit' => 'px',
					'size' => '',
				],
				'range'             => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 0.1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					],
				],
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label:before' => 'top:{{TOP}}{{UNIT}}; right:{{RIGHT}}{{UNIT}}; bottom:{{BOTTOM}}{{UNIT}}; left:{{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_filter_checkbox_inner_circle_position',
			$this->style,
			[
				'label'             => __( 'Checkbox Inner position', 'wpte-product-layout' ),
				'type'              => Controls::DIMENSIONS,
				'default'           => [
					'unit' => 'px',
					'size' => '',
				],
				'range'             => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 0.1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					],
				],
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option input[type=checkbox]:checked + .check-label:after' => 'top:{{TOP}}{{UNIT}}; right:{{RIGHT}}{{UNIT}}; bottom:{{BOTTOM}}{{UNIT}}; left:{{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_extra_control(
			'wpte_product_filter_checkbox_text_heading',
			$this->style,
			[
				'label'     => 'Text Style',
				'type'      => Controls::HEADING,
				'css'       => 'padding-top:10px; padding-bottom:10px',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			'wpte_product_filter_checkbox_text_typography',
			$this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label,
					{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .radio-label' => '',
				],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_filter_checkbox_text_color',
			$this->style, [
				'label'             => esc_html__( 'Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label,
					{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .radio-label' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_extra_control(
			'wpte_product_filter_checkbox_spacing_heading',
			$this->style,
			[
				'label'     => 'Space',
				'type'      => Controls::HEADING,
				'css'       => 'padding-top:10px; padding-bottom:10px',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_checkbox_spacing_item',
			$this->style,
			[
				'label'        => esc_html__( 'Spacing ( Item to Item )', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '',
				],
				'range'        => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'em' => [
						'min'  => 0.0,
						'max'  => 10,
						'step' => 0.01,
					],
				],
				'selector'     => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_checkbox_text_spacing',
			$this->style,
			[
				'label'        => esc_html__( 'Spacing ( Checkbox to text )', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '',
				],
				'range'        => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'em' => [
						'min'  => 0.0,
						'max'  => 10,
						'step' => 0.01,
					],
				],
				'selector'     => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label,
					{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .radio-label' => 'padding-left: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->end_controls_section();
	}
	/**
	 * Method wpte_product_filter_checkbox.
	 */
	protected function wpte_product_filter_checkbox_rating() {

		$this->start_controls_section(
			'wpte_product_filter_checkbox',
			[
				'label'   => esc_html__( 'Checkbox and Icon', 'wpte-product-layout' ),
				'showing' => true,
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_checkbox_size',
			$this->style,
			[
				'label'        => __( 'Box Size', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '16',
				],
				'range'        => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
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
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label:before' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option input[type=checkbox]:checked + .check-label:after' => 'font-size: calc({{SIZE}}{{UNIT}} - 5px);',
				],
				'description'  => '',
			]
		);

		$this->add_control(
			'wpte_product_filter_checkbox_bg',
			$this->style, [
				'label'             => esc_html__( 'Background Color', 'wpte-product-layout' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label:before' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_filter_checkbox_color',
			$this->style, [
				'label'             => esc_html__( 'Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option input[type=checkbox]:checked + .check-label:after' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_filter_checkbox_border',
			$this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label:before' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_checkbox_border_radius',
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
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label:before' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_filter_checkbox_position',
			$this->style,
			[
				'label'             => __( 'Checkbox position', 'wpte-product-layout' ),
				'type'              => Controls::DIMENSIONS,
				'default'           => [
					'unit' => 'px',
					'size' => '',
				],
				'range'             => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 0.1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					],
				],
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label:before' => 'top:{{TOP}}{{UNIT}}; right:{{RIGHT}}{{UNIT}}; bottom:{{BOTTOM}}{{UNIT}}; left:{{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_filter_checkbox_inner_circle_position',
			$this->style,
			[
				'label'             => __( 'Checkbox Inner position', 'wpte-product-layout' ),
				'type'              => Controls::DIMENSIONS,
				'default'           => [
					'unit' => 'px',
					'size' => '',
				],
				'range'             => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 0.1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					],
				],
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option input[type=checkbox]:checked + .check-label:after' => 'top:{{TOP}}{{UNIT}}; right:{{RIGHT}}{{UNIT}}; bottom:{{BOTTOM}}{{UNIT}}; left:{{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_extra_control(
			'wpte_product_filter_checkbox_icon_heading',
			$this->style,
			[
				'label'     => 'Icon Style',
				'type'      => Controls::HEADING,
				'css'       => 'padding-top:10px; padding-bottom:10px',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'wpte_product_filter_rating_icon_color',
			$this->style, [
				'label'             => esc_html__( 'Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label .wpte-icons' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_rating_icon_size',
			$this->style,
			[
				'label'        => esc_html__( 'Icon Size', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '18',
				],
				'range'        => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'em' => [
						'min'  => 0.0,
						'max'  => 10,
						'step' => 0.01,
					],
				],
				'selector'     => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label .wpte-icons' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_extra_control(
			'wpte_product_filter_checkbox_spacing_heading',
			$this->style,
			[
				'label'     => 'Space',
				'type'      => Controls::HEADING,
				'css'       => 'padding-top:10px; padding-bottom:10px',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_checkbox_spacing_item',
			$this->style,
			[
				'label'        => esc_html__( 'Spacing ( Item to Item )', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '',
				],
				'range'        => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'em' => [
						'min'  => 0.0,
						'max'  => 10,
						'step' => 0.01,
					],
				],
				'selector'     => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_checkbox_icon_spacing',
			$this->style,
			[
				'label'        => esc_html__( 'Spacing ( Checkbox to Icon )', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '',
				],
				'range'        => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'em' => [
						'min'  => 0.0,
						'max'  => 10,
						'step' => 0.01,
					],
				],
				'selector'     => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label,
					{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .radio-label' => 'padding-left: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_rating_icon_spacing',
			$this->style,
			[
				'label'        => esc_html__( 'Spacing ( Icon to Icon )', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '',
				],
				'range'        => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'em' => [
						'min'  => 0.0,
						'max'  => 10,
						'step' => 0.01,
					],
				],
				'selector'     => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label .wpte-icons' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_product_filter_radio.
	 */
	protected function wpte_product_filter_radio() {

		$this->start_controls_section(
			'wpte_product_filter_radio',
			[
				'label'   => esc_html__( 'Radio', 'wpte-product-layout' ),
				'showing' => true,
			]
		);

		$this->add_extra_control(
			'wpte_product_filter_radio_circle',
			$this->style,
			[
				'label' => 'Circle Style',
				'type'  => Controls::HEADING,
				'css'   => 'padding-top:10px; padding-bottom:10px',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_radio_size',
			$this->style,
			[
				'label'        => esc_html__( 'Size', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '16',
				],
				'range'        => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
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
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .radio-label:before' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option input[type=radio]:checked + .radio-label:after' => 'width: calc({{SIZE}}{{UNIT}} - 6px);height: calc({{SIZE}}{{UNIT}} - 6px);',
				],
				'description'  => '',
			]
		);

		$this->add_control(
			'wpte_product_filter_radio_bg',
			$this->style, [
				'label'             => esc_html__( 'Background Color', 'wpte-product-layout' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .radio-label:before' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_filter_radio_color',
			$this->style, [
				'label'             => esc_html__( 'Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option input[type=radio]:checked + .radio-label:after' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_filter_radio_border', $this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .radio-label:before' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_filter_radio_circle_position',
			$this->style,
			[
				'label'             => __( 'Circle position', 'wpte-product-layout' ),
				'type'              => Controls::DIMENSIONS,
				'default'           => [
					'unit' => 'px',
					'size' => '',
				],
				'range'             => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 0.1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					],
				],
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .radio-label:before' => 'top:{{TOP}}{{UNIT}}; right:{{RIGHT}}{{UNIT}}; bottom:{{BOTTOM}}{{UNIT}}; left:{{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_filter_radio_inner_circle_position',
			$this->style,
			[
				'label'             => __( 'Inner circle position', 'wpte-product-layout' ),
				'type'              => Controls::DIMENSIONS,
				'default'           => [
					'unit' => 'px',
					'size' => '',
				],
				'range'             => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 0.1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					],
				],
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option input[type=radio]:checked+.radio-label:after' => 'top:{{TOP}}{{UNIT}}; right:{{RIGHT}}{{UNIT}}; bottom:{{BOTTOM}}{{UNIT}}; left:{{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_extra_control(
			'wpte_product_filter_radio_text_heading',
			$this->style,
			[
				'label'     => 'Text Style',
				'type'      => Controls::HEADING,
				'css'       => 'padding-top:10px; padding-bottom:10px',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			'wpte_product_filter_radio_text_typography',
			$this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label,
					{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .radio-label' => '',
				],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_filter_radio_text_color',
			$this->style, [
				'label'             => esc_html__( 'Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label,
					{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .radio-label' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_extra_control(
			'wpte_product_filter_radio_spacing_heading',
			$this->style,
			[
				'label'     => 'Space',
				'type'      => Controls::HEADING,
				'css'       => 'padding-top:10px; padding-bottom:10px',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_radio_spacing_item',
			$this->style,
			[
				'label'        => esc_html__( 'Spacing ( Item to Item )', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '',
				],
				'range'        => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'em' => [
						'min'  => 0.0,
						'max'  => 10,
						'step' => 0.01,
					],
				],
				'selector'     => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_radio_text_spacing',
			$this->style,
			[
				'label'        => esc_html__( 'Spacing ( Circle to text )', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '',
				],
				'range'        => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'em' => [
						'min'  => 0.0,
						'max'  => 10,
						'step' => 0.01,
					],
				],
				'selector'     => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label,
					{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .radio-label' => 'padding-left: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_product_filter_post_count.
	 */
	protected function wpte_product_filter_post_count() {

		$this->start_controls_section(
			'wpte_product_filter_post_count',
			[
				'label'   => esc_html__( 'Post Count', 'wpte-product-layout' ),
				'showing' => true,
				'condition'   => [ 'wpte_product_filter_post_count_switcher' => 'yes' ],
			]
		);

		$this->add_group_control(
			'wpte_product_filter_post_count_typography',
			$this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .cat-post' => '',
				],
				'condition'   => [ 'wpte_product_filter_post_count_switcher' => 'yes' ],
				'description' => '',
			]
		);

		$this->add_control(
			'wpte_product_filter_post_count_bg',
			$this->style, [
				'label'             => esc_html__( 'Background Color', 'wpte-product-layout' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .cat-post' => 'background: {{VALUE}};',
				],
				'condition'         => [ 'wpte_product_filter_post_count_switcher' => 'yes' ],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_filter_post_count_color',
			$this->style, [
				'label'             => esc_html__( 'Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .cat-post' => 'color: {{VALUE}};',
				],
				'condition'         => [ 'wpte_product_filter_post_count_switcher' => 'yes' ],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_post_count_spacing',
			$this->style,
			[
				'label'        => esc_html__( 'Spacing', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '2',
				],
				'range'        => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'em' => [
						'min'  => 0.0,
						'max'  => 10,
						'step' => 0.01,
					],
				],
				'selector'     => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .cat-post' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
				'condition'    => [ 'wpte_product_filter_post_count_switcher' => 'yes' ],
				'description'  => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_post_count_border_radius',
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
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .cat-post' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'         => [ 'wpte_product_filter_post_count_switcher' => 'yes' ],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_post_count_border_padding',
			$this->style,
			[
				'label'             => esc_html__( 'Padding', 'wpte-product-layout' ),
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
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .cat-post' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'         => [ 'wpte_product_filter_post_count_switcher' => 'yes' ],
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
	 * Method wpte_product_filter_color_checkbox.
	 */
	protected function wpte_product_filter_color_checkbox() {

		$this->start_controls_section(
			'wpte_product_filter_checkbox',
			[
				'label'     => esc_html__( 'Checkbox', 'wpte-product-layout' ),
				'showing'   => true,
			]
		);

		$this->add_extra_control(
			'wpte_product_filter_checkbox_heading',
			$this->style,
			[
				'label' => 'Checkbox Style',
				'type'  => Controls::HEADING,
				'css'   => 'padding-top:10px; padding-bottom:10px',
			]
		);

		$this->add_control(
			'wpte_product_filter_checkbox_bg',
			$this->style, [
				'label'             => esc_html__( 'Background Color', 'wpte-product-layout' ),
				'type'              => Controls::GRADIENT,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label:before' => 'background: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
				'notcondition'      => true,
				'condition'         => [ 'wpte_filters_attribute' => 'color' ],
			]
		);

		$this->add_control(
			'wpte_product_filter_checkbox_color',
			$this->style, [
				'label'             => esc_html__( 'Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option input[type=checkbox]:checked + .check-label:after' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_group_control(
			'wpte_product_filter_checkbox_border',
			$this->style, [
				'type'              => Controls::BORDER,
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label:before' => '',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_checkbox_border_radius',
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
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label:before' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_checkbox_size',
			$this->style,
			[
				'label'        => __( 'Box Size', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '',
				],
				'range'        => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
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
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label:before' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);
		$this->add_responsive_control(
			'wpte_product_filter_checkbox_icon_size',
			$this->style,
			[
				'label'        => __( 'Icon Size', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '',
				],
				'range'        => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
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
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option input[type=checkbox]:checked + .check-label:after' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_control(
			'wpte_product_filter_checkbox_position',
			$this->style,
			[
				'label'             => __( 'Checkbox position', 'wpte-product-layout' ),
				'type'              => Controls::DIMENSIONS,
				'default'           => [
					'unit' => 'px',
					'size' => '',
				],
				'range'             => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 0.1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					],
				],
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label:before' => 'top:{{TOP}}{{UNIT}}; right:{{RIGHT}}{{UNIT}}; bottom:{{BOTTOM}}{{UNIT}}; left:{{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_control(
			'wpte_product_filter_checkbox_inner_circle_position',
			$this->style,
			[
				'label'             => __( 'Checkbox Inner position', 'wpte-product-layout' ),
				'type'              => Controls::DIMENSIONS,
				'default'           => [
					'unit' => 'px',
					'size' => '',
				],
				'range'             => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 0.1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					],
				],
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option input[type=checkbox]:checked + .check-label:after' => 'top:{{TOP}}{{UNIT}}; right:{{RIGHT}}{{UNIT}}; bottom:{{BOTTOM}}{{UNIT}}; left:{{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_extra_control(
			'wpte_product_filter_checkbox_text_heading',
			$this->style,
			[
				'label'     => 'Text Style',
				'type'      => Controls::HEADING,
				'css'       => 'padding-top:10px; padding-bottom:10px',
				'separator' => 'before',
				'condition' => [ 'wpte_filters_attribute_text' => 'yes' ],
			]
		);

		$this->add_group_control(
			'wpte_product_filter_checkbox_text_typography',
			$this->style, [
				'type'        => Controls::TYPOGRAPHY,
				'selector'    => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label,
					{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .radio-label' => '',
				],
				'description' => '',
				'condition'   => [ 'wpte_filters_attribute_text' => 'yes' ],
			]
		);

		$this->add_control(
			'wpte_product_filter_checkbox_text_color',
			$this->style, [
				'label'             => esc_html__( 'Color', 'wpte-product-layout' ),
				'type'              => Controls::COLOR,
				'default'           => '',
				'selector'          => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label,
					{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .radio-label' => 'color: {{VALUE}};',
				],
				'simpledescription' => '',
				'description'       => '',
				'condition'         => [ 'wpte_filters_attribute_text' => 'yes' ],
			]
		);

		$this->add_extra_control(
			'wpte_product_filter_checkbox_spacing_heading',
			$this->style,
			[
				'label'     => 'Space',
				'type'      => Controls::HEADING,
				'css'       => 'padding-top:10px; padding-bottom:10px',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_checkbox_spacing_vertical',
			$this->style,
			[
				'label'        => esc_html__( 'Spacing ( Vertical )', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '',
				],
				'range'        => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'em' => [
						'min'  => 0.0,
						'max'  => 10,
						'step' => 0.01,
					],
				],
				'selector'     => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'description'  => '',
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_checkbox_spacing_horizontal',
			$this->style,
			[
				'label'        => esc_html__( 'Spacing ( Horizontal )', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'simpleenable' => false,
				'default'      => [
					'unit' => 'px',
					'size' => '',
				],
				'range'        => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'em' => [
						'min'  => 0.0,
						'max'  => 10,
						'step' => 0.01,
					],
				],
				'selector'     => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label' => 'padding-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-wc-color-attribute-filter .wpte-filter-option' => 'padding: 0;',
				],
				'description'  => '',
				'notcondition' => true,
				'condition'    => [ 'wpte_filters_attribute_text' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'wpte_product_filter_checkbox_text_spacing',
			$this->style,
			[
				'label'             => __( 'Spacing', 'wpte-product-layout' ),
				'type'              => Controls::DIMENSIONS,
				'default'           => [
					'unit' => 'px',
					'size' => '',
				],
				'range'             => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selector'     => [
					'{{WRAPPER}} .wpte-product-filter-wrapper .wpte-product-filter-items .wpte-product-filter-item .wpte-filter-option .check-label' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
				'condition'         => [ 'wpte_filters_attribute_text' => 'yes' ],
			]
		);

		$this->end_controls_section();
	}
}
