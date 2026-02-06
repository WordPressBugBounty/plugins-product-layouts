<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\Caption\Backend;

use WPTE_PRODUCT_LAYOUT\Layouts\Caption\Layout;
use WPTE_PRODUCT_LAYOUT\Includes\Controls;

/**
 * Layout4
 */
class Layout4 extends Layout {
	/**
	 * Method register_controls
	 *
	 * @return void
	 */
	public function register_layout() {

		// Start Genetal Tabs.
		$this->start_section_tabs(
			'wpte-caption-section-layout-4-tabs',
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

		$this->wpte_initial_plugin_column();

		$this->add_extra_control(
			'status',
			$this->style,
			[
				'label' => 'All Premium',
				'type'  => Controls::HIDDEN,
				'value' => 'p',
			]
		);

		$this->add_extra_control(
			'wpte_product_layout_effect_heading',
			$this->style,
			[
				'label'     => 'Effects',
				'type'      => Controls::HEADING,
				'css'       => 'padding-top:10px; padding-bottom:10px',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'wpte_product_layout_caption_style_4_effect',
			$this->style, [
				'label'   => __( 'Effects Direction', 'product-layouts' ),
				'type'    => Controls::SELECT,
				'loader'  => true,
				// 'multiple' => true,
				'default' => 'open-horizontal',
				'options' => [
					'reveal'              => 'Border Reveal',
					'reveal-vertical'     => 'Border Reveal Vertical',
					'reveal-horizontal'   => 'Border Reveal Horizontal',
					'reveal-corners-1'    => 'Border Reveal Corners One',
					'reveal-corners-2'    => 'Border Reveal Corners Two',
					'reveal-top-left'     => 'Border Reveal Top Left',
					'reveal-top-right'    => 'Border Reveal Top Right',
					'reveal-bottom-left'  => 'Border Reveal Bottom Left',
					'reveal-bottom-right' => 'Border Reveal Bottom Right',
					'reveal-cc-1'         => 'Border Reveal CC One',
					'reveal-ccc-1'        => 'Border Reveal CCC One',
					'reveal-cc-2'         => 'Border Reveal CC Two',
					'reveal-ccc-2'        => 'Border Reveal CCC Two',
					'reveal-cc-3'         => 'Border Reveal CC Three',
					'reveal-ccc-3'        => 'Border Reveal CCC Three',
				],
			]
		);

		$this->wpte_inital_show_and_hide();

		$this->end_controls_section();

			// Initial Controls from Layout.php
			// ================================================.
			$this->wpte_intial_product_settings();
			// ===========Cart Button=================
			$this->wpte_caption_button();
			// ===========Wishlist Icon=================
			$this->wpte_cation_wishlist();

		$this->end_section_tabs();
		// =============END CART SETTINGS=====================

		/**
		 * =========================================================================
		 * =================================STAET STYLE TAB=========================
		 * =========================================================================
		 */
		$this->start_section_tabs(
			'wpte-caption-section-layout-4-style-tabs',
			[
				'condition' => [
					'style',
				],
			]
		);

		$this->wpte_caption_style_product_body();
		$this->wpte_caption_style_image();
		$this->wpte_caption_style_category();
		$this->wpte_caption_wishlist_icon_style();
		$this->wpte_caption_tooltip_style();
		$this->wpte_caption_style_title();
		$this->wpte_caption_style_description();
		$this->wpte_caption_style_rating();
		$this->wpte_caption_style_price();
		$this->wpte_caption_style_button();
		$this->end_section_tabs();
	}
}
