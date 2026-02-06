<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\Carousel;

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
			'wpte-general-section-carusel',
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
	 * Method wpte_product_layout_carousel_settings.
	 */
	public function wpte_product_layout_carousel_settings() {

		$this->start_controls_section(
			'wpte_product_layout_settings',
			[
				'label'   => 'Layouts',
				'showing' => true,
			]
		);

		$this->add_control(
			'wpte_product_layout_carousel_style', $this->style, [
				'label'   => __( 'Carousel Style', 'product-layouts' ),
				'type'    => Controls::SELECT,
				'loader'  => true,
				// 'multiple' => true,
				'default' => '',
				'options' => wpte_get_shortcode_list(),
			]
		);

		$this->add_responsive_control(
			'wpte_carousel_slider_per_view',
			$this->style,
			[
				'label'       => esc_html__( 'Slider Per View', 'product-layouts' ),
				'type'        => Controls::SLIDER,
				'default'     => [
					'unit' => 'px',
					'size' => '4',
				],
				'range'       => [
					'px' => [
						'min'  => 1,
						'max'  => 10,
						'step' => 1,
					],
				],
				'description' => 'Number of slides visible in the view.',
			]
		);

		$this->add_responsive_control(
			'wpte_carousel_slider_space_between',
			$this->style,
			[
				'label'       => esc_html__( 'Space Between', 'product-layouts' ),
				'type'        => Controls::SLIDER,
				'default'     => [
					'unit' => 'px',
					'size' => '20',
				],
				'range'       => [
					'px' => [
						'min'  => 1,
						'max'  => 100,
						'step' => 1,
					],
				],
				'description' => 'Space between slides in pixels.',
			]
		);

		$this->add_responsive_control(
			'wpte_carousel_slide_to_scroll',
			$this->style,
			[
				'label'       => esc_html__( 'Slides to Scroll', 'product-layouts' ),
				'type'        => Controls::SLIDER,
				'default'     => [
					'unit' => 'px',
					'size' => '1',
				],
				'range'       => [
					'px' => [
						'min'  => 1,
						'max'  => 10,
						'step' => 1,
					],
				],
				'description' => 'Number of slides to scroll per swipe.',
			]
		);

		$this->add_control(
			'carousel_autoplay',
			$this->style,
			[
				'label'        => esc_html__( 'Autoplay', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'loader'       => true,
				'default'      => 'yes',
				'yes'          => esc_html__( 'Yes', 'product-layouts' ),
				'no'           => esc_html__( 'No', 'product-layouts' ),
				'return_value' => 'yes',
				'description'  => 'Do you want slider autoplay?.',
			]
		);
		$this->add_control(
            'carousel_autoplay_speed',
            $this->style,
            [
				'label'       => esc_html__( 'Autoplay Speed', 'product-layouts' ),
				'type'        => Controls::NUMBER,
				'default'     => 2000,
				'min'         => 0,
				'max'         => 10000,
				'condition'   => [
					'carousel_autoplay' => 'yes',
				],
				'description' => 'Set Autoplay Speed, Set with millisecond.',
			]
		);
		$this->add_control(
            'carousel_speed',
            $this->style,
            [
				'label'       => esc_html__( 'Animation Speed', 'product-layouts' ),
				'type'        => Controls::NUMBER,
				'default'     => 500,
				'min'         => 0,
				'max'         => 10000,
				'description' => 'Set Animation Speed, Set with millisecond.',
			]
		);
		$this->add_control(
            'carousel_pause_on_hover',
            $this->style,
            [
				'label'        => esc_html__( 'Pause on Hover', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'loader'       => true,
				'default'      => 'yes',
				'yes'          => esc_html__( 'Yes', 'product-layouts' ),
				'no'           => esc_html__( 'No', 'product-layouts' ),
				'return_value' => 'yes',
				'description'  => 'Do you want Pause on Hover.',
			]
		);
		$this->add_control(
            'carousel_infinite',
            $this->style,
            [
				'label'        => esc_html__( 'Infinite Loop', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'loader'       => true,
				'default'      => 'yes',
				'yes'          => esc_html__( 'Yes', 'product-layouts' ),
				'no'           => esc_html__( 'No', 'product-layouts' ),
				'return_value' => 'yes',
				'description'  => 'Do you want Infinite Loop.',
			]
		);
		$this->add_control(
            'carousel_adaptive_height',
            $this->style,
            [
				'label'        => esc_html__( 'Adaptive Height', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'loader'       => true,
				'default'      => 'yes',
				'yes'          => esc_html__( 'Yes', 'product-layouts' ),
				'no'           => esc_html__( 'No', 'product-layouts' ),
				'return_value' => 'yes',
				'description'  => 'Do you want auto height.',
			]
		);
		$this->add_control(
            'carousel_center_mode',
            $this->style,
            [
				'label'        => esc_html__( 'Center Mode', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'loader'       => true,
				'default'      => 'no',
				'yes'          => esc_html__( 'Yes', 'product-layouts' ),
				'no'           => esc_html__( 'No', 'product-layouts' ),
				'return_value' => 'yes',
				'description'  => 'Do you want center mode Options?',
			]
		);
		$this->add_control(
            'carousel_show_arrows',
            $this->style,
            [
				'label'        => esc_html__( 'Arrows', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'loader'       => true,
				'default'      => 'yes',
				'yes'          => esc_html__( 'Yes', 'product-layouts' ),
				'no'           => esc_html__( 'No', 'product-layouts' ),
				'return_value' => 'yes',
				'description'  => 'Do you want Arrows for navigation.',
			]
		);
		$this->add_control(
            'carousel_show_dots',
            $this->style,
            [
				'label'        => esc_html__( 'Dots', 'product-layouts' ),
				'type'         => Controls::SWITCHER,
				'loader'       => true,
				'default'      => 'no',
				'yes'          => esc_html__( 'Yes', 'product-layouts' ),
				'no'           => esc_html__( 'No', 'product-layouts' ),
				'return_value' => 'yes',
				'description'  => 'Do you want Dots for pagination.',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_product_layout_carousel_arrow.
	 */
	public function wpte_product_layout_carousel_arrow() {

		$this->start_controls_section(
			'wpte_product_layout_arrows',
			[
				'label'     => 'Carousel Arrows',
				'showing'   => true,
				'condition' => [
					'carousel_show_arrows' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'wpte_carousel_arrow_icon_size',
			$this->style,
			[
				'label'       => esc_html__( 'Icon Size', 'product-layouts' ),
				'type'        => Controls::SLIDER,
				'default'     => [
					'unit' => 'px',
					'size' => '16',
				],
				'range'       => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'em' => [
						'min'  => 0.0,
						'max'  => 20,
						'step' => 0.01,
					],
				],
				'selector'    => [
					'{{WRAPPER}} .wpte_carousel_arrows .wpte-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'description' => 'Set Arrow icon size..',
			]
		);

		$this->start_controls_tabs(
			'wpte_product_layout_arrows_tabs',
			[
				'options' => [
					'normal' => esc_html__( 'Left Arrow', 'product-layouts' ),
					'hover'  => esc_html__( 'Right Arrow', 'product-layouts' ),
				],
			]
		);

			$this->start_controls_tab();

				$this->add_control(
					'wpte_carousel_left_arrow',
					$this->style,
					[
						'label'       => __( 'Left Arrow', 'product-layouts' ),
						'type'        => Controls::ICON,
						'default'     => 'wpte-icon icon-arrow-10',
						'description' => '',
					]
				);

				$this->add_responsive_control(
					'wpte_left_arrow_icon_position_x',
					$this->style,
					[
						'label'       => esc_html__( 'Position X', 'product-layouts' ),
						'type'        => Controls::SLIDER,
						'default'     => [
							'unit' => 'px',
							'size' => '20',
						],
						'range'       => [
							'px' => [
								'min'  => -100,
								'max'  => 1200,
								'step' => 1,
							],
							'%'  => [
								'min'  => -10,
								'max'  => 100,
								'step' => 1,
							],
							'em' => [
								'min'  => -10,
								'max'  => 100,
								'step' => 0.01,
							],

						],
						'selector'    => [
							'{{WRAPPER}} .wpte_carousel_arrows.wpte_carousel_prev' => 'left: {{SIZE}}{{UNIT}};',
						],
						'description' => 'Set Arrow icon Position X.',
					]
				);

				$this->add_responsive_control(
					'wpte_left_arrow_icon_position_y',
					$this->style,
					[
						'label'       => esc_html__( 'Position Y', 'product-layouts' ),
						'type'        => Controls::SLIDER,
						'default'     => [
							'unit' => '%',
							'size' => '50',
						],
						'range'       => [
							'px' => [
								'min'  => -1200,
								'max'  => 1200,
								'step' => 1,
							],
							'%'  => [
								'min'  => -99,
								'max'  => 100,
								'step' => 1,
							],
							'em' => [
								'min'  => -100,
								'max'  => 100,
								'step' => 0.01,
							],

						],
						'selector'    => [
							'{{WRAPPER}} .wpte_carousel_arrows.wpte_carousel_prev' => 'top: {{SIZE}}{{UNIT}};',
						],
						'description' => 'Set Arrow icon Position Y.',
					]
				);

			$this->end_controls_tab();
			$this->start_controls_tab();

				$this->add_control(
					'wpte_carousel_right_arrow',
					$this->style,
					[
						'label'       => __( 'Right Arrow', 'product-layouts' ),
						'type'        => Controls::ICON,
						'default'     => 'wpte-icon icon-arrow-11',
						'description' => '',
					]
				);

				$this->add_responsive_control(
					'wpte_right_arrow_icon_position_x',
					$this->style,
					[
						'label'       => esc_html__( 'Position X', 'product-layouts' ),
						'type'        => Controls::SLIDER,
						'default'     => [
							'unit' => 'px',
							'size' => '20',
						],
						'range'       => [
							'px' => [
								'min'  => -100,
								'max'  => 1200,
								'step' => 1,
							],
							'%'  => [
								'min'  => -10,
								'max'  => 100,
								'step' => 1,
							],
							'em' => [
								'min'  => -10,
								'max'  => 100,
								'step' => 0.01,
							],

						],
						'selector'    => [
							'{{WRAPPER}} .wpte_carousel_arrows.wpte_carousel_next' => 'right: {{SIZE}}{{UNIT}};',
						],
						'description' => 'Set Arrow icon Position X.',
					]
				);

				$this->add_responsive_control(
					'wpte_right_arrow_icon_position_y',
					$this->style,
					[
						'label'       => esc_html__( 'Position Y', 'product-layouts' ),
						'type'        => Controls::SLIDER,
						'default'     => [
							'unit' => '%',
							'size' => '50',
						],
						'range'       => [
							'px' => [
								'min'  => -1200,
								'max'  => 1200,
								'step' => 1,
							],
							'%'  => [
								'min'  => -99,
								'max'  => 100,
								'step' => 1,
							],
							'em' => [
								'min'  => -100,
								'max'  => 100,
								'step' => 0.01,
							],

						],
						'selector'    => [
							'{{WRAPPER}} .wpte_carousel_arrows.wpte_carousel_next' => 'top: {{SIZE}}{{UNIT}};',
						],
						'description' => 'Set Arrow icon Position Y.',
					]
				);

			$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->start_controls_tabs(
			'wpte_carousel_arrows_style',
			[
				'options' => [
					'normal' => esc_html__( 'Normal', 'product-layouts' ),
					'hover'  => esc_html__( 'Hover', 'product-layouts' ),
				],
			]
		);

			$this->start_controls_tab();
				$this->add_control(
					'wpte_carousel_arrows_color', $this->style, [
						'label'             => __( 'Color', 'product-layouts' ),
						'type'              => Controls::COLOR,
						'default'           => '#ffffff',
						'selector'          => [
							'{{WRAPPER}} .wpte_carousel_arrows .wpte-icon' => 'color: {{VALUE}};',
						],
						'simpledescription' => '',
						'description'       => '',
					]
				);
				$this->add_control(
					'wpte_carousel_arrows_bg',
					$this->style, [
						'label'             => __( 'Background', 'product-layouts' ),
						'type'              => Controls::GRADIENT,
						'default'           => '',
						'selector'          => [
							'{{WRAPPER}} .wpte_carousel_arrows .wpte-icon' => 'background: {{VALUE}};',
						],
						'simpledescription' => '',
						'description'       => '',
					]
				);
				$this->add_group_control(
					'wpte_carousel_arrows_border',
					$this->style, [
						'type'              => Controls::BORDER,
						'selector'          => [
							'{{WRAPPER}} .wpte_carousel_arrows .wpte-icon' => '',
						],
						'simpledescription' => '',
						'description'       => '',
					]
				);
				$this->add_group_control(
					'wpte_carousel_arrows_boxshadow',
					$this->style, [
						'type'        => Controls::BOXSHADOW,
						'selector'    => [
							'{{WRAPPER}} .wpte_carousel_arrows .wpte-icon' => '',
						],
						'description' => '',
					]
				);

			$this->end_controls_tab();
			$this->start_controls_tab();
				$this->add_control(
					'wpte_carousel_arrows_h_color', $this->style, [
						'label'             => __( 'Color', 'product-layouts' ),
						'type'              => Controls::COLOR,
						'default'           => '#ffffff',
						'selector'          => [
							'{{WRAPPER}} .wpte_carousel_arrows .wpte-icon:hover' => 'color: {{VALUE}};',
						],
						'simpledescription' => '',
						'description'       => '',
					]
				);
				$this->add_control(
					'wpte_carousel_arrows_h_bg',
					$this->style, [
						'label'             => __( 'Background', 'product-layouts' ),
						'type'              => Controls::GRADIENT,
						'default'           => '',
						'selector'          => [
							'{{WRAPPER}} .wpte_carousel_arrows .wpte-icon:hover' => 'background: {{VALUE}};',
						],
						'simpledescription' => '',
						'description'       => '',
					]
				);
				$this->add_group_control(
					'wpte_carousel_arrows_h_border',
					$this->style, [
						'type'              => Controls::BORDER,
						'selector'          => [
							'{{WRAPPER}} .wpte_carousel_arrows .wpte-icon:hover' => '',
						],
						'simpledescription' => '',
						'description'       => '',
					]
				);
				$this->add_group_control(
					'wpte_carousel_arrows_h_boxshadow',
					$this->style, [
						'type'        => Controls::BOXSHADOW,
						'selector'    => [
							'{{WRAPPER}} .wpte_carousel_arrows .wpte-icon:hover' => '',
						],
						'description' => '',
					]
				);
			$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'wpte_carousel_arrows_border_radius',
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
					'{{WRAPPER}} .wpte_carousel_arrows .wpte-icon' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'         => 'before',
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->add_responsive_control(
			'wpte_carousel_arrows_padding',
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
					'{{WRAPPER}} .wpte_carousel_arrows .wpte-icon' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Method wpte_product_layout_carousel_dots.
	 */
	public function wpte_product_layout_carousel_dots() {

		$this->start_controls_section(
			'wpte_product_layout_dots',
			[
				'label'     => 'Carousel Dots',
				'showing'   => true,
				'condition' => [
					'carousel_show_dots' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'wpte_carousel_dots_width',
			$this->style,
			[
				'label'       => esc_html__( 'Width', 'product-layouts' ),
				'type'        => Controls::SLIDER,
				'default'     => [
					'unit' => 'px',
					'size' => '15',
				],
				'range'       => [
					'px' => [
						'min'  => 1,
						'max'  => 1200,
						'step' => 1,
					],
					'em' => [
						'min'  => 0.1,
						'max'  => 100,
						'step' => 0.01,
					],

				],
				'selector'    => [
					'{{WRAPPER}} .wpte-product-layouts-carousel-wrapper .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
				],
				'description' => 'Set dots width with multiple options.',
			]
		);

		$this->add_responsive_control(
			'wpte_carousel_dots_height',
			$this->style,
			[
				'label'       => esc_html__( 'Height', 'product-layouts' ),
				'type'        => Controls::SLIDER,
				'default'     => [
					'unit' => 'px',
					'size' => '15',
				],
				'range'       => [
					'px' => [
						'min'  => 1,
						'max'  => 1200,
						'step' => 1,
					],
					'em' => [
						'min'  => 0.1,
						'max'  => 100,
						'step' => 0.01,
					],

				],
				'selector'    => [
					'{{WRAPPER}} .wpte-product-layouts-carousel-wrapper .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};',
				],
				'description' => 'Set dots height with multiple options.',
			]
		);

		$this->add_responsive_control(
			'wpte_carousel_dots_x_position',
			$this->style,
			[
				'label'       => esc_html__( 'Position X', 'product-layouts' ),
				'type'        => Controls::SLIDER,
				'default'     => [
					'unit' => 'px',
					'size' => '0',
				],
				'range'       => [
					'px' => [
						'min'  => -200,
						'max'  => 1200,
						'step' => 1,
					],
					'%'  => [
						'min'  => -50,
						'max'  => 100,
						'step' => 1,
					],
					'em' => [
						'min'  => -50,
						'max'  => 100,
						'step' => 0.01,
					],

				],
				'selector'    => [
					'{{WRAPPER}} .wpte-product-layouts-carousel-wrapper .wpte-swiper-pagination' => 'left: {{SIZE}}{{UNIT}} !important;',
				],
				'description' => 'Set Dots position with Position Y. left to right',
			]
		);

		$this->add_responsive_control(
			'wpte_carousel_dots_y_position',
			$this->style,
			[
				'label'       => esc_html__( 'Position Y', 'product-layouts' ),
				'type'        => Controls::SLIDER,
				'default'     => [
					'unit' => 'px',
					'size' => '0',
				],
				'range'       => [
					'px' => [
						'min'  => -200,
						'max'  => 1200,
						'step' => 1,
					],
					'%'  => [
						'min'  => -50,
						'max'  => 100,
						'step' => 1,
					],
					'em' => [
						'min'  => -50,
						'max'  => 100,
						'step' => 0.01,
					],

				],
				'selector'    => [
					'{{WRAPPER}} .wpte-product-layouts-carousel-wrapper .wpte-swiper-pagination' => 'bottom: {{SIZE}}{{UNIT}} !important;',
				],
				'description' => 'Set Dots position with Position Y. bottom to top',
			]
		);

		$this->add_responsive_control(
			'wpte_carousel_dots_spacing',
			$this->style,
			[
				'label'       => esc_html__( 'Spacing', 'product-layouts' ),
				'type'        => Controls::SLIDER,
				'default'     => [
					'unit' => 'px',
					'size' => '5',
				],
				'range'       => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'em' => [
						'min'  => 0,
						'max'  => 10,
						'step' => 0.01,
					],

				],
				'selector'    => [
					'{{WRAPPER}} .wpte-product-layouts-carousel-wrapper .wpte-swiper-pagination .swiper-pagination-bullet' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'description' => 'Set dots spacing with multiple options.',
			]
		);

		$this->start_controls_tabs(
			'wpte_carousel_dot_style',
			[
				'options' => [
					'normal' => esc_html__( 'Normal', 'product-layouts' ),
					'hover'  => esc_html__( 'Hover', 'product-layouts' ),
					'active' => esc_html__( 'Active', 'product-layouts' ),
				],
			]
		);

			$this->start_controls_tab();

				$this->add_control(
					'wpte_carousel_dots_bg',
					$this->style, [
						'label'             => __( 'Background', 'product-layouts' ),
						'type'              => Controls::COLOR,
						'oparetor'          => true,
						'default'           => '#ddd',
						'selector'          => [
							'{{WRAPPER}} .wpte-product-layouts-carousel-wrapper .wpte-swiper-pagination .swiper-pagination-bullet' => 'background: {{VALUE}};',
						],
						'simpledescription' => '',
						'description'       => '',
					]
				);
				$this->add_group_control(
					'wpte_carousel_dots_border',
					$this->style, [
						'type'              => Controls::BORDER,
						'selector'          => [
							'{{WRAPPER}} .wpte-product-layouts-carousel-wrapper .wpte-swiper-pagination .swiper-pagination-bullet' => '',
						],
						'simpledescription' => '',
						'description'       => '',
					]
				);
			$this->end_controls_tab();

			$this->start_controls_tab();

				$this->add_control(
					'wpte_carousel_dots_h_bg',
					$this->style, [
						'label'             => __( 'Background', 'product-layouts' ),
						'type'              => Controls::COLOR,
						'oparetor'          => true,
						'default'           => '',
						'selector'          => [
							'{{WRAPPER}} .wpte-product-layouts-carousel-wrapper .wpte-swiper-pagination .swiper-pagination-bullet:hover' => 'background: {{VALUE}};',
						],
						'simpledescription' => '',
						'description'       => '',
					]
				);
				$this->add_group_control(
					'wpte_carousel_dots_h_border',
					$this->style, [
						'type'              => Controls::BORDER,
						'selector'          => [
							'{{WRAPPER}} .wpte-product-layouts-carousel-wrapper .wpte-swiper-pagination .swiper-pagination-bullet:hover' => '',
						],
						'simpledescription' => '',
						'description'       => '',
					]
				);

			$this->end_controls_tab();
			$this->start_controls_tab();

				$this->add_control(
					'wpte_carousel_dots_a_bg',
					$this->style, [
						'label'             => __( 'Background', 'product-layouts' ),
						'type'              => Controls::COLOR,
						'oparetor'          => true,
						'default'           => '',
						'selector'          => [
							'{{WRAPPER}} .wpte-product-layouts-carousel-wrapper .wpte-swiper-pagination .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
						],
						'simpledescription' => '',
						'description'       => '',
					]
				);
				$this->add_group_control(
					'wpte_carousel_dots_a_border',
					$this->style, [
						'type'              => Controls::BORDER,
						'selector'          => [
							'{{WRAPPER}} .wpte-product-layouts-carousel-wrapper .wpte-swiper-pagination .swiper-pagination-bullet-active' => '',
						],
						'simpledescription' => '',
						'description'       => '',
					]
				);

			$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'wpte_carousel_dots_border_radius',
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
					'{{WRAPPER}} .wpte-product-layouts-carousel-wrapper .wpte-swiper-pagination .swiper-pagination-bullet' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'         => 'before',
				'simpledescription' => '',
				'description'       => '',
			]
		);

		$this->end_controls_section();
	}
}
