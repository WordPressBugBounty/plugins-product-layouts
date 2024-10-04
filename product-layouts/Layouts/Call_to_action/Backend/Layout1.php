<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\Call_to_action\Backend;

use WPTE_PRODUCT_LAYOUT\Layouts\Call_to_action\Layout;
use WPTE_PRODUCT_LAYOUT\Includes\Controls;

/**
 * Layout1
 */
class Layout1 extends Layout {

	/**
	 * Method register_controls
	 *
	 * @return void
	 */
	public function register_layout() {

		// Start Genetal Tabs.
		$this->start_section_tabs(
			'wpte-call-to-action-section-layout1-tabs',
			[
				'condition' => [
					'general',
				],
			]
		);

		// Initial Controls from Layout.php.
		// ================================================.
		$this->wpte_intial_controls();
		// ================================================.

		// =============CART SETTINGS=====================.
		$this->start_controls_section(
			'wpte-product-call-to-action-style-1-icons',
			[
				'label'   => 'Cart Setting',
				'showing' => true,
			]
		);

		$this->add_group_control(
			'wpte-product-call-to-action-style-1-cart-icon',
			$this->style,
			[
				'type'        => Controls::CART,
				'default'     => __( 'Cart Icons', 'wpte-product-layout' ),
				'operator'    => 'icontext', // icon, text, icontext.
				'condition'   => [
					'wpte_call_to_action_products_show_icons' => 'yes',
				],
				'description' => '',
			]
		);

		$this->end_controls_section();

		// =============END CART SETTINGS=====================.

		// =============WISH LIST SETTINGS=====================.
		$this->start_controls_section(
			'wpte-product-call-to-action-style-1-wishlist-icons',
			[
				'label'   => 'Wish List',
				'showing' => true,
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
				'wpte-product-call-to-action-style-1-quickview-icon',
				$this->style,
				[
					'type'        => Controls::WISHLIST,
					'default'     => __( 'Wishlist', 'wpte-product-layout' ),
					'operator'    => 'icon', // icon, text, icontext.
					'condition'   => [
						'wpte_call_to_action_products_show_icons' => 'yes',
					],
					'description' => '',
				]
			);

		}
		$this->end_controls_section();

		// =============END WISH LIST SETTINGS=====================.

		// =============QUICK VIEW SETTINGS=====================.
		$this->start_controls_section(
			'wpte-product-call-to-action-style-1-quickview-icons-title',
			[
				'label'   => 'Quick View',
				'showing' => true,
			]
		);

		$this->add_group_control(
			'wpte-product-call-to-action-style-1-quickview-icon',
			$this->style,
			[
				'type'        => Controls::QUICKVIEW,
				'default'     => __( 'Quick View', 'wpte-product-layout' ),
				'operator'    => 'icon', // icon, text, icontext.
				'condition'   => [
					'wpte_call_to_action_products_show_icons' => 'yes',
				],
				'description' => '',
			]
		);

		$this->end_controls_section();

		// =============END QUICK VIEW SETTINGS=====================.

		// =============PRODUCT COMPARE SETTINGS=====================.
		$this->start_controls_section(
			'wpte-product-call-to-action-style-1-compare-icons-title',
			[
				'label'   => 'Product Compare',
				'showing' => true,
			]
		);

		$this->add_group_control(
			'wpte-product-call-to-action-style-1-compare-icon',
			$this->style,
			[
				'type'        => Controls::COMPARE,
				'default'     => __( 'Compare', 'wpte-product-layout' ),
				'operator'    => 'icon', // icon, text, icontext.
				'condition'   => [
					'wpte_call_to_action_products_show_icons' => 'yes',
				],
				'description' => '',
			]
		);

		$this->end_controls_section();

		// =============END PRODUCT COMPARE SETTINGS=====================.

		$this->end_section_tabs();

		/**
		 * =========================================================================
		 * =================================STAET STYLE TAB=========================
		 * =========================================================================
		 */
		$this->start_section_tabs(
			'wpte-call-to-action-section-layout1-style-tabs',
			[
				'condition' => [
					'style',
				],
			]
		);

		$this->wpte_product_body_style();
		$this->wpte_product_body_content_style();
		$this->wpte_badge_style();
		$this->wpte_product_layouts_image_style();
		$this->wpte_product_layouts_icon_style();
		$this->wpte_product_layouts_tooltip_style( 'border-top-color' );
		$this->wpte_category_style();
		$this->wpte_title_style();
		$this->wpte_rating_style();
		$this->wpte_price_style();
		$this->wpte_cart_button_style();

		$this->end_section_tabs();
	}
}
