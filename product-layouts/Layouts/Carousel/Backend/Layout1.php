<?php
namespace WPTE_PRODUCT_LAYOUT\Layouts\Carousel\Backend;

use WPTE_PRODUCT_LAYOUT\Layouts\Carousel\Layout;
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
			'wpte-table-section-layout1-tabs',
			[
				'condition' => [
					'general',
				],
			]
		);

		$this->wpte_product_layout_carousel_settings();

		$this->end_section_tabs();

		/**
		 * =========================================================================
		 * =================================STAET STYLE TAB=========================
		 * =========================================================================
		 */
		$this->start_section_tabs(
			'wpte-general-section-layout1-style-tabs',
			[
				'condition' => [
					'style',
				],
			]
		);

		$this->wpte_product_layout_carousel_arrow();
		$this->wpte_product_layout_carousel_dots();

		$this->end_section_tabs();
	}
}
