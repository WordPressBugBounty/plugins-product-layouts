<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\Tabs;

use WPTE_PRODUCT_LAYOUT\Includes\Admin\Pages\Create;

/**
 * Description of Table
 *
 * @author Richard
 */
class Tabs extends Create {

	/**
	 * Method json_data.
	 */
	public function json_data() {

		$shortcode_list = wpte_get_shortcode_list();
		$sortcode_id    = array_key_first( $shortcode_list );

		$this->TEMPLATE = [
			'tabs-1' => [
				'name'   => 'Tab 1',
				'status' => 'premium',
				'src'    => '',
				'files'  => [
					'{"style":{"id":"3","name":"Tabs Style 1","style_name":"tabs-1","rawdata":"{\"wpte_product_layout_tabs_style_1_get_layout\":\"' . $sortcode_id . '\",\"wpte_pl_tabs_category_all\":\"yes\",\"wpte_product_tab_style_1_typho-size-lap-choices\":\"px\",\"wpte_product_tab_style_1_typho-size-tab-choices\":\"px\",\"wpte_product_tab_style_1_typho-size-mob-choices\":\"px\",\"wpte_product_tab_style_1_typho-l-height-lap-choices\":\"px\",\"wpte_product_tab_style_1_typho-l-height-tab-choices\":\"px\",\"wpte_product_tab_style_1_typho-l-height-mob-choices\":\"px\",\"wpte_product_tab_style_1_typho-l-spacing-lap-choices\":\"px\",\"wpte_product_tab_style_1_typho-l-spacing-tab-choices\":\"px\",\"wpte_product_tab_style_1_typho-l-spacing-mob-choices\":\"px\",\"wpte_product_tab_style_1_normal_color\":\"#ffffff\",\"wpte_product_tab_style_1_normal_bg\":\"#83b735\",\"wpte_product_tab_style_1_normal_border-width-lap-choices\":\"px\",\"wpte_product_tab_style_1_normal_border-width-tab-choices\":\"px\",\"wpte_product_tab_style_1_normal_border-width-mob-choices\":\"px\",\"wwpte_product_tab_style_1_normal_boxshadow-horizontal-size\":\"0\",\"wwpte_product_tab_style_1_normal_boxshadow-vertical-size\":\"0\",\"wwpte_product_tab_style_1_normal_boxshadow-blur-size\":\"0\",\"wwpte_product_tab_style_1_normal_boxshadow-spread-size\":\"0\",\"wwpte_product_tab_style_1_normal_boxshadow-color\":\"#cccccc\",\"wpte_product_tab_style_1_normal_border_radius-lap-choices\":\"px\",\"wpte_product_tab_style_1_normal_border_radius-tab-choices\":\"px\",\"wpte_product_tab_style_1_normal_border_radius-mob-choices\":\"px\",\"wpte_product_tab_style_1_hove_color\":\"#ffffff\",\"wpte_product_tab_style_1_hover_bg\":\"#669125\",\"wpte_product_tab_style_1_hover_border-width-lap-choices\":\"px\",\"wpte_product_tab_style_1_hover_border-width-tab-choices\":\"px\",\"wpte_product_tab_style_1_hover_border-width-mob-choices\":\"px\",\"wwpte_product_tab_style_1_hover_boxshadow-horizontal-size\":\"0\",\"wwpte_product_tab_style_1_hover_boxshadow-vertical-size\":\"0\",\"wwpte_product_tab_style_1_hover_boxshadow-blur-size\":\"0\",\"wwpte_product_tab_style_1_hover_boxshadow-spread-size\":\"0\",\"wwpte_product_tab_style_1_hover_boxshadow-color\":\"#cccccc\",\"wpte_product_tab_style_1_hover_border_radius-lap-choices\":\"px\",\"wpte_product_tab_style_1_hover_border_radius-tab-choices\":\"px\",\"wpte_product_tab_style_1_hover_border_radius-mob-choices\":\"px\",\"wpte_product_tab_style_1_active_color\":\"#ffffff\",\"wpte_product_tab_style_1_active_bg\":\"#da3f3f\",\"wpte_product_tab_style_1_active_border-width-lap-choices\":\"px\",\"wpte_product_tab_style_1_active_border-width-tab-choices\":\"px\",\"wpte_product_tab_style_1_active_border-width-mob-choices\":\"px\",\"wwpte_product_tab_style_1_active_boxshadow-horizontal-size\":\"0\",\"wwpte_product_tab_style_1_active_boxshadow-vertical-size\":\"0\",\"wwpte_product_tab_style_1_active_boxshadow-blur-size\":\"0\",\"wwpte_product_tab_style_1_active_boxshadow-spread-size\":\"0\",\"wwpte_product_tab_style_1_active_boxshadow-color\":\"#cccccc\",\"wpte_product_tab_style_1_active_border_radius-lap-choices\":\"px\",\"wpte_product_tab_style_1_active_border_radius-tab-choices\":\"px\",\"wpte_product_tab_style_1_active_border_radius-mob-choices\":\"px\",\"wpte_product_tab_style_1_padding-lap-choices\":\"px\",\"wpte_product_tab_style_1_padding-tab-choices\":\"px\",\"wpte_product_tab_style_1_padding-mob-choices\":\"px\",\"wpte_product_tab_style_1_margin-lap-choices\":\"px\",\"wpte_product_tab_style_1_margin-tab-choices\":\"px\",\"wpte_product_tab_style_1_margin-mob-choices\":\"px\",\"wpte_product_layout_advanced_margin-lap-choices\":\"px\",\"wpte_product_layout_advanced_margin-tab-choices\":\"px\",\"wpte_product_layout_advanced_margin-mob-choices\":\"px\",\"wpte_product_layout_advanced_padding-lap-choices\":\"px\",\"wpte_product_layout_advanced_padding-tab-choices\":\"px\",\"wpte_product_layout_advanced_padding-mob-choices\":\"px\",\"wpte_product_layout_pagination_global_display\":\"none\",\"wpte_product_layout_pagination_preset\":\"preset_1\",\"wpte_product_pagination_global_typography-size-lap-choices\":\"px\",\"wpte_product_pagination_global_typography-size-tab-choices\":\"px\",\"wpte_product_pagination_global_typography-size-mob-choices\":\"px\",\"wpte_product_pagination_global_typography-l-height-lap-choices\":\"px\",\"wpte_product_pagination_global_typography-l-height-tab-choices\":\"px\",\"wpte_product_pagination_global_typography-l-height-mob-choices\":\"px\",\"wpte_product_pagination_global_typography-l-spacing-lap-choices\":\"px\",\"wpte_product_pagination_global_typography-l-spacing-tab-choices\":\"px\",\"wpte_product_pagination_global_typography-l-spacing-mob-choices\":\"px\",\"wpte_product_pagination_min_width-lap-choices\":\"px\",\"wpte_product_pagination_min_width-lap-size\":\"30\",\"wpte_product_pagination_min_width-tab-choices\":\"px\",\"wpte_product_pagination_min_width-tab-size\":\"30\",\"wpte_product_pagination_min_width-mob-choices\":\"px\",\"wpte_product_pagination_min_width-mob-size\":\"30\",\"wpte_product_pagination_min_height-lap-choices\":\"px\",\"wpte_product_pagination_min_height-lap-size\":\"30\",\"wpte_product_pagination_min_height-tab-choices\":\"px\",\"wpte_product_pagination_min_height-tab-size\":\"30\",\"wpte_product_pagination_min_height-mob-choices\":\"px\",\"wpte_product_pagination_min_height-mob-size\":\"30\",\"wpte_product_pagination_normal_border-width-lap-choices\":\"px\",\"wpte_product_pagination_normal_border-width-tab-choices\":\"px\",\"wpte_product_pagination_normal_border-width-mob-choices\":\"px\",\"wpte_product_pagination_normal_boxshadow-horizontal-size\":\"0\",\"wpte_product_pagination_normal_boxshadow-vertical-size\":\"0\",\"wpte_product_pagination_normal_boxshadow-blur-size\":\"0\",\"wpte_product_pagination_normal_boxshadow-spread-size\":\"0\",\"wpte_product_pagination_normal_boxshadow-color\":\"#cccccc\",\"wpte_product_pagination_normal_border_radius-lap-choices\":\"px\",\"wpte_product_pagination_normal_border_radius-tab-choices\":\"px\",\"wpte_product_pagination_normal_border_radius-mob-choices\":\"px\",\"wpte_product_pagination_hover_border-width-lap-choices\":\"px\",\"wpte_product_pagination_hover_border-width-tab-choices\":\"px\",\"wpte_product_pagination_hover_border-width-mob-choices\":\"px\",\"wpte_product_pagination_hover_boxshadow-horizontal-size\":\"0\",\"wpte_product_pagination_hover_boxshadow-vertical-size\":\"0\",\"wpte_product_pagination_hover_boxshadow-blur-size\":\"0\",\"wpte_product_pagination_hover_boxshadow-spread-size\":\"0\",\"wpte_product_pagination_hover_boxshadow-color\":\"#cccccc\",\"wpte_product_pagination_hover_border_radius-lap-choices\":\"px\",\"wpte_product_pagination_hover_border_radius-tab-choices\":\"px\",\"wpte_product_pagination_hover_border_radius-mob-choices\":\"px\",\"wpte_product_pagination_active_border-width-lap-choices\":\"px\",\"wpte_product_pagination_active_border-width-tab-choices\":\"px\",\"wpte_product_pagination_active_border-width-mob-choices\":\"px\",\"wpte_product_pagination_active_boxshadow-horizontal-size\":\"0\",\"wpte_product_pagination_active_boxshadow-vertical-size\":\"0\",\"wpte_product_pagination_active_boxshadow-blur-size\":\"0\",\"wpte_product_pagination_active_boxshadow-spread-size\":\"0\",\"wpte_product_pagination_active_boxshadow-color\":\"#cccccc\",\"wpte_product_pagination_active_border_radius-lap-choices\":\"px\",\"wpte_product_pagination_active_border_radius-tab-choices\":\"px\",\"wpte_product_pagination_active_border_radius-mob-choices\":\"px\",\"wpte_product_pagination_margin-lap-choices\":\"px\",\"wpte_product_pagination_margin-tab-choices\":\"px\",\"wpte_product_pagination_margin-mob-choices\":\"px\",\"wpte_product_pagination_prev_icon\":\"wpte-icon icon-arrow-10\",\"wpte_product_pagination_prev_text\":\"Previus\",\"wpte_product_pagination_next_icon\":\"wpte-icon icon-arrow-11\",\"wpte_product_pagination_next_text\":\"Next\",\"wpte_product_pagination_icon_spacing-lap-choices\":\"px\",\"wpte_product_pagination_icon_spacing-lap-size\":\"5\",\"wpte_product_pagination_icon_spacing-tab-choices\":\"px\",\"wpte_product_pagination_icon_spacing-tab-size\":\"5\",\"wpte_product_pagination_icon_spacing-mob-choices\":\"px\",\"wpte_product_pagination_icon_spacing-mob-size\":\"5\",\"wpte_product_pagination_load_more_text\":\"Load More\",\"wpte_product_load_more_typography-size-lap-choices\":\"px\",\"wpte_product_load_more_typography-size-tab-choices\":\"px\",\"wpte_product_load_more_typography-size-mob-choices\":\"px\",\"wpte_product_load_more_typography-l-height-lap-choices\":\"px\",\"wpte_product_load_more_typography-l-height-tab-choices\":\"px\",\"wpte_product_load_more_typography-l-height-mob-choices\":\"px\",\"wpte_product_load_more_typography-l-spacing-lap-choices\":\"px\",\"wpte_product_load_more_typography-l-spacing-tab-choices\":\"px\",\"wpte_product_load_more_typography-l-spacing-mob-choices\":\"px\",\"wpte_product_load_more_normal_border-width-lap-choices\":\"px\",\"wpte_product_load_more_normal_border-width-tab-choices\":\"px\",\"wpte_product_load_more_normal_border-width-mob-choices\":\"px\",\"wpte_product_load_more_normal_boxshadow-horizontal-size\":\"0\",\"wpte_product_load_more_normal_boxshadow-vertical-size\":\"0\",\"wpte_product_load_more_normal_boxshadow-blur-size\":\"0\",\"wpte_product_load_more_normal_boxshadow-spread-size\":\"0\",\"wpte_product_load_more_normal_boxshadow-color\":\"#cccccc\",\"wpte_product_load_more_normal_border_radius-lap-choices\":\"px\",\"wpte_product_load_more_normal_border_radius-tab-choices\":\"px\",\"wpte_product_load_more_normal_border_radius-mob-choices\":\"px\",\"wpte_product_load_more_hover_border-width-lap-choices\":\"px\",\"wpte_product_load_more_hover_border-width-tab-choices\":\"px\",\"wpte_product_load_more_hover_border-width-mob-choices\":\"px\",\"wpte_product_load_more_hover_boxshadow-horizontal-size\":\"0\",\"wpte_product_load_more_hover_boxshadow-vertical-size\":\"0\",\"wpte_product_load_more_hover_boxshadow-blur-size\":\"0\",\"wpte_product_load_more_hover_boxshadow-spread-size\":\"0\",\"wpte_product_load_more_hover_boxshadow-color\":\"#cccccc\",\"wpte_product_load_more_hover_border_radius-lap-choices\":\"px\",\"wpte_product_load_more_hover_border_radius-tab-choices\":\"px\",\"wpte_product_load_more_hover_border_radius-mob-choices\":\"px\",\"wpte_product_load_more_padding-lap-choices\":\"px\",\"wpte_product_load_more_padding-tab-choices\":\"px\",\"wpte_product_load_more_padding-mob-choices\":\"px\",\"wpte_product_load_more_margin-lap-choices\":\"px\",\"wpte_product_load_more_margin-tab-choices\":\"px\",\"wpte_product_load_more_margin-mob-choices\":\"px\",\"wpte_product_layout_advanced_border-width-lap-choices\":\"px\",\"wpte_product_layout_advanced_border-width-tab-choices\":\"px\",\"wpte_product_layout_advanced_border-width-mob-choices\":\"px\",\"wpte_product_layout_advanced_border_radius-lap-choices\":\"px\",\"wpte_product_layout_advanced_border_radius-tab-choices\":\"px\",\"wpte_product_layout_advanced_border_radius-mob-choices\":\"px\",\"wpte_product_layout_advanced_boxshadow-horizontal-size\":\"0\",\"wpte_product_layout_advanced_boxshadow-vertical-size\":\"0\",\"wpte_product_layout_advanced_boxshadow-blur-size\":\"0\",\"wpte_product_layout_advanced_boxshadow-spread-size\":\"0\",\"wpte_product_layout_advanced_boxshadow-color\":\"#cccccc\"}","stylesheet":".wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-layouts-tabs-style-1-list li{color: #ffffff;background: #83b735;border-width: px px px px;border-radius:px px px px;padding:px px px px;margin:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-layouts-tabs-style-1-list li:hover{color: #ffffff;background: #669125;border-width: px px px px;border-radius:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-layouts-tabs-style-1-list li.wpte-tab-active{color: #ffffff;background: #da3f3f;border-width: px px px px;border-radius:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-load{margin:px px px px;padding:px px px px;border-width: px px px px;border-radius:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-layout-pagination li{min-width: 30px;min-height: 30px;border-width: px px px px;border-radius:px px px px;margin:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-layout-pagination li:hover{border-width: px px px px;border-radius:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-layout-pagination .pagination-active{border-width: px px px px;border-radius:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-layout-pagination li .wpte_product_pagination_next_icon{padding-left: 5px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-layout-pagination li .wpte_product_pagination_prev_icon{padding-right: 5px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-load-more button.wpte-product-layout-load-more-button{border-width: px px px px;border-radius:px px px px;padding:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-load-more button.wpte-product-layout-load-more-button:hover{border-width: px px px px;border-radius:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-load-more{padding:px px px px;}@media only screen and (min-width : 669px) and (max-width : 993px){.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-layouts-tabs-style-1-list li{border-width: px px px px;border-radius:px px px px;padding:px px px px;margin:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-layouts-tabs-style-1-list li:hover{border-width: px px px px;border-radius:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-layouts-tabs-style-1-list li.wpte-tab-active{border-width: px px px px;border-radius:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-load{margin:px px px px;padding:px px px px;border-width: px px px px;border-radius:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-layout-pagination li{min-width: 30px;min-height: 30px;border-width: px px px px;border-radius:px px px px;margin:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-layout-pagination li:hover{border-width: px px px px;border-radius:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-layout-pagination .pagination-active{border-width: px px px px;border-radius:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-layout-pagination li .wpte_product_pagination_next_icon{padding-left: 5px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-layout-pagination li .wpte_product_pagination_prev_icon{padding-right: 5px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-load-more button.wpte-product-layout-load-more-button{border-width: px px px px;border-radius:px px px px;padding:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-load-more button.wpte-product-layout-load-more-button:hover{border-width: px px px px;border-radius:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-load-more{padding:px px px px;}}@media only screen and (max-width : 668px){.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-layouts-tabs-style-1-list li{border-width: px px px px;border-radius:px px px px;padding:px px px px;margin:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-layouts-tabs-style-1-list li:hover{border-width: px px px px;border-radius:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-layouts-tabs-style-1-list li.wpte-tab-active{border-width: px px px px;border-radius:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-load{margin:px px px px;padding:px px px px;border-width: px px px px;border-radius:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-layout-pagination li{min-width: 30px;min-height: 30px;border-width: px px px px;border-radius:px px px px;margin:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-layout-pagination li:hover{border-width: px px px px;border-radius:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-layout-pagination .pagination-active{border-width: px px px px;border-radius:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-layout-pagination li .wpte_product_pagination_next_icon{padding-left: 5px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-layout-pagination li .wpte_product_pagination_prev_icon{padding-right: 5px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-load-more button.wpte-product-layout-load-more-button{border-width: px px px px;border-radius:px px px px;padding:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-load-more button.wpte-product-layout-load-more-button:hover{border-width: px px px px;border-radius:px px px px;}.wpte-product-layout-wrapper-3 .wpte-product-row .wpte-product-load-more{padding:px px px px;}}","font_family":"null"}}',
				],
			],

		];
	}
}
