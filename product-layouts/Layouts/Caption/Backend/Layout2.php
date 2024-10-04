<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\Caption\Backend;

use WPTE_PRODUCT_LAYOUT\Layouts\Caption\Layout;
use WPTE_PRODUCT_LAYOUT\Includes\Controls;

/**
 * Layout2
 */
class Layout2 extends Layout {
	/**
	 * Method register_controls
	 *
	 * @return void
	 */
	public function register_layout() {

		// Start Genetal Tabs.
		$this->start_section_tabs(
			'wpte-caption-section-layout-2-tabs',
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
			'wpte_product_layout_caption_style_2_effect',
			$this->style, [
				'label'   => __( 'Effects Direction', 'wpte-product-layout' ),
				'type'    => Controls::SELECT,
				'loader'  => true,
				// 'multiple' => true,
				'default' => 'horizontal',
				'options' => [
					'rotate-left'       => 'Block Rotate Left',
					'rotate-right'      => 'Block Rotate Right',
					'rotate-in-left'    => 'Block Rotate In Left',
					'rotate-in-right'   => 'Block Rotate In Right',
					'in'                => 'Block In',
					'out'               => 'Block Out',
					'float-up'          => 'Block Float Up',
					'float-down'        => 'Block Float Down',
					'float-left'        => 'Block Float Left',
					'float-right'       => 'Block Float Right',
					'zoom-top-left'     => 'Block Zoom Top Left',
					'zoom-top-right'    => 'Block Zoom Top Right',
					'zoom-bottom-left'  => 'Block Zoom Bottom Left',
					'zoom-bottom-right' => 'Block Zoom Bottom Right',
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
			'wpte-caption-section-layout2-style-tabs',
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
