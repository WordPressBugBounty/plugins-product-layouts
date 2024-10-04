<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin\Pages;

/**
 * Status Class
 *
 * @since 1.1.7
 */
class Status {

	/**
	 * Status Constructor
	 *
	 * @since 1.1.7
	 */
	public function __construct() {
		$this->wpte_product_layouts_status();
	}

	/**
	 * System Status.
	 *
	 * @since 1.1.7
	 */
	public function wpte_product_layouts_status() {

		global $wp_version;

		$wp_cache = WP_CACHE ? 'Yes' : 'No';

		$wpVersion            = version_compare( $wp_version, WPTE_WPL_MINIMUM_WP_VERSION, '<' ) ? " <td class=\"text-left red\">$wp_version  <span style='color:#444;font-size: 12px;'>Please Incrise WordPress Version</span></td>" : " <td class=\"text-left green\">$wp_version</td>";
		$phpVerseion          = version_compare( PHP_VERSION, WPTE_WPL_MINIMUM_PHP_VERSION, '<' ) ? ' <td class="text-left red">' . PHP_VERSION . ' <span style="color:#444;font-size: 12px;">Please Incrise PHP Version</span></td> ' : ' <td class=\"text-left green\">' . PHP_VERSION . '</td>';
		$WcVerseion           = version_compare( WC_VERSION, WPTE_WPL_MINIMUM_WC_VERSION, '<' ) ? ' <td class="text-left red">' . WC_VERSION . '<span style="color:#444;font-size: 12px;">Please Incrise WooCommerce Version</span></td>' : ' <td class="text-left green">' . WC_VERSION . '</td>';
		$max_input_vars_limit = 1200 > ini_get('max_input_vars') ? ' <td class="text-left red">' . ini_get('max_input_vars') . ' <span style="color:#444;font-size: 12px;">Please increase max_input_vars 1200 or greater than 1200. </span></td>' : ' <td class="text-left green">' . ini_get('max_input_vars') . '</td>';

		?>  

		<div class="wpte-system-status-wrapper">
			<div class="wpte-status-content">
				<h2> <i class="wpte-icon icon-setting"></i><?php echo esc_html__(' System Status', 'wpte-product-layout'); ?></h2>
				<hr>
				<table style="margin-top: 30px;" class="wpte-status-area">
					<tbody class="wpte-status-table-body">
						<tr>
							<td class="text-left"><?php echo esc_html__('Site Url', 'wpte-product-layout'); ?></td>
							<td class="text-left green"><?php echo esc_url( get_site_url() ); ?></td>
						</tr>
						<tr>
							<td class="text-left"><?php echo esc_html__('Define WP_CACHE', 'wpte-product-layout'); ?></td>
							<td class="text-left green"><?php echo wp_kses( $wp_cache, true); ?></td>
						</tr>
					</tbody>
				</table>

				<table style="margin-top: 50px; margin-bottom: 50px;" class="wpte-status-area">
					<tbody class="wpte-status-table-body">
						<tr>
							<td class="text-left"><?php echo esc_html__('WordPress Version', 'wpte-product-layout'); ?></td>
							<?php echo wp_kses( $wpVersion, true ); ?>
						</tr>
						<tr>
							<td class="text-left"><?php echo esc_html__('PHP Version', 'wpte-product-layout'); ?></td>
							<?php echo wp_kses( $phpVerseion, true ); ?>
						</tr>
						<tr>
							<td class="text-left"><?php echo esc_html__('WooCommerce Version', 'wpte-product-layout'); ?></td>
							<?php echo wp_kses( $WcVerseion, true ); ?>
						</tr>
						<tr>
							<td class="text-left"><?php echo esc_html( 'max_input_vars' ); ?></td>
							<?php echo wp_kses( $max_input_vars_limit, true ); ?>
						</tr>
						<tr>
							<td class="text-left"><?php echo esc_html__('Available Memory', 'wpte-product-layout'); ?></td>
							<td class="text-left green"><?php echo esc_html( WP_MAX_MEMORY_LIMIT ); ?></td>
						</tr>
						<tr>
							<td class="text-left"><?php echo esc_html__('Memory Limit', 'wpte-product-layout'); ?></td>
							<td class="text-left green"><?php echo esc_html( WP_MEMORY_LIMIT ); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<?php
	}
}