<?php

namespace WPTE_PRODUCT_LAYOUT\Layouts\Tabs\Frontend;

use WPTE_PRODUCT_LAYOUT\Includes\Helper\Public_Render;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Layout1
 */
class Layout1 extends Public_Render {

	/**
	 * Method public_js
	 *
	 * @return void
	 */
	public function public_js() {
		echo '';
	}

	/**
	 * Method layout_render
	 *
	 * @param mixed  $settings .
	 * @param string $user .
	 * @return void
	 */
	public function layout_render( $settings, $user ) {

		global $wpdb;

		$shortcode_id = isset( $settings['wpte_product_layout_tabs_style_1_get_layout'] ) ? $settings['wpte_product_layout_tabs_style_1_get_layout'] : '';
		$user         = 'admin';
		$db_data      = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'wpte_product_layout_style WHERE id = %d ', $shortcode_id ), ARRAY_A );
		$style_name   = explode( '-', ucfirst( $db_data['style_name'] ) );
		$cls          = '\WPTE_PRODUCT_LAYOUT\Layouts\\' . $style_name[0] . '\Frontend\Layout' . $style_name[1];
		$all          = isset( $settings['wpte_pl_tabs_category_all'] ) && $settings['wpte_pl_tabs_category_all'] === 'yes' ? true : false;

		if ( isset( $settings['wpte_product_layout_tabs_product_category'] ) && '' !== $settings['wpte_product_layout_tabs_product_category'] ) {
			$categories = $settings['wpte_product_layout_tabs_product_category'];
		} elseif ( wpte_get_category_ids() ) {
			$categories = wpte_get_category_ids();
		} else {
			$categories = [];
		}
		?>
		<div class="wpte-product-layouts-tabs-style-1-wrapper">
			<ul class="wpte-product-layouts-tabs wpte-product-layouts-tabs-style-1-list">
				<?php if ( $all ) { ?>
				<li class="wpte-tab-active" id='wpte-tab-1' catid="" layoutid="<?php echo esc_html( $shortcode_id ); ?>"><?php echo esc_html__( 'All', 'wpte-product-layout' ); ?></li>
				<?php } ?>
				<?php
				$i = 0;
				foreach ( $categories as $cat_id ) :
					$active = ! $all && $i === 0 ? 'wpte-tab-active' : '';
					?>
					<li class="<?php echo esc_attr( $active ); ?>" id='wpte-<?php echo intval( $cat_id ); ?>' catid="<?php echo intval( $cat_id ); ?>" layoutid="<?php echo esc_html( $shortcode_id ); ?>"><?php echo wp_kses( get_the_category_by_ID( $cat_id ), true ); ?></li>
					<?php
					++$i;
					endforeach;
				?>
			</ul>
			<?php
			if ( ! $all ) {
				$settings = json_decode( $db_data['rawdata'], true );
				$settings['wpte_product_layout_product_category'] = $categories[0];
				$db_data['rawdata']                               = wp_json_encode( $settings );
			}
			if ( wpte_version_control() ) {
				$clas = new $cls( $db_data, $user );
			}

			?>
		</div>
		<?php
	}
}
