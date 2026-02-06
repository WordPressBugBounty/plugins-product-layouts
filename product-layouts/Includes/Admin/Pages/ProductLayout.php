<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin\Pages;

/**
 * Admin Menu Class
 *
 * @since 1.0.0
 */
final class ProductLayout {

	use AdminTopMenu;

	/**
	 * ProductLayout class constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		$this->render_elements();
		add_action( 'admin_footer', [ $this, 'wpte_offer_popup' ] );
	}

	/**
	 * Method Wpte_offer_popup.
	 *
	 * @since 1.1.4
	 */
	public function wpte_offer_popup() {
		echo '<div id="wpte-offer-modal"></div>';
	}

	/**
	 * All Element Render in Admin page
	 *
	 * @since 1.0.0
	 */
	public function render_elements() {
		wp_enqueue_script( 'wpte-wpl-admin-js' );
		apply_filters( 'wpte_product_layout_admin_menu', true );
		$this->elements_render();
	}

	/**
	 * Elements List
	 * Status: Popular, Updated, Premium, New, Coming...
	 *
	 * @since 1.0.0
	 */
	public function elements() {
		$popular = wpte_version_control() ? 'Popular' : 'Premium';
		$Updated = wpte_version_control() ? 'Updated' : 'Premium';
		$New     = wpte_version_control() ? 'New' : 'Premium';
		$New_N   = wpte_version_control() ? __( 'New', 'product-layouts' ) : __( 'Premium', 'product-layouts' );
		$Normal  = wpte_version_control() ? '' : __( 'Premium', 'product-layouts' );
		$is_pro  = wpte_version_control() ? '' : 'wpte-po-element';
		return [

			'Product Layouts' => [
				'general'        => [
					'name'     => 'general-layouts',
					'status'   => 'Popular', // Popular, Updated, Premium, New, Coming...
					'status_n' => __( 'Popular', 'product-layouts' ),
					'icon'     => WPTE_WPL_URL . '/Image/general.svg',
					'src'      => '',
					'video'    => 'https://youtu.be/sU2Woih2-DU',
					'doc'      => 'https://wpkin.com/docs/how-to-create-general-layouts/',
					'demo'     => 'https://product-layouts.com/demo/general-layouts/',
					'is_pro'   => '',
					'version'  => 1.0,
				],
				'call_to_action' => [
					'name'     => 'call-to-action-layouts',
					'status'   => '',
					'status_n' => '',
					'icon'     => WPTE_WPL_URL . '/Image/call-to-action.svg',
					'src'      => '',
					'video'    => 'https://youtu.be/e8Aq1ohfYWo',
					'doc'      => 'https://wpkin.com/docs/how-to-create-call-to-action-layouts/',
					'demo'     => 'https://product-layouts.com/demo/call-to-action/',
					'is_pro'   => '',
					'version'  => 1.0,
				],
				'table'          => [
					'name'     => 'product-table-layouts',
					'status'   => '',
					'status_n' => '',
					'icon'     => WPTE_WPL_URL . '/Image/product-table.svg',
					'src'      => '',
					'video'    => 'https://youtu.be/fE2l_z4oEEg',
					'doc'      => 'https://wpkin.com/docs/how-to-create-table-layouts/',
					'demo'     => 'https://product-layouts.com/demo/product-table/',
					'is_pro'   => '',
					'version'  => 1.0,
				],
				'product_list'   => [
					'name'     => 'product-list-layouts',
					'status'   => 'New',
					'status_n' => __( 'New', 'product-layouts' ),
					'icon'     => WPTE_WPL_URL . '/Image/list.svg',
					'src'      => '',
					'video'    => 'https://youtu.be/ctu4Nfz_bUg',
					'doc'      => 'https://wpkin.com/docs/how-to-create-product-list-layouts/',
					'demo'     => 'https://product-layouts.com/demo/product-list/',
					'is_pro'   => '',
					'version'  => 1.0,
				],
				'caption'        => [
					'name'     => 'caption-layouts',
					'status'   => 'Updated',
					'status_n' => __( 'Updated', 'product-layouts' ),
					'icon'     => WPTE_WPL_URL . '/Image/caption.svg',
					'src'      => '',
					'video'    => 'https://youtu.be/C_hUfw6l_Y4',
					'doc'      => 'https://wpkin.com/docs/how-to-create-caption-layouts/',
					'demo'     => 'https://product-layouts.com/demo/caption-layouts/',
					'is_pro'   => '',
					'version'  => 1.0,
				],
				'flipbox'        => [
					'name'     => 'flipbox-layouts',
					'status'   => 'New',
					'status_n' => __( 'New', 'product-layouts' ),
					'icon'     => WPTE_WPL_URL . '/Image/flip-box.svg',
					'src'      => '',
					'video'    => 'https://youtu.be/x0RZRpX4M98',
					'doc'      => 'https://wpkin.com/docs/how-to-create-flip-box-layouts/',
					'demo'     => 'https://product-layouts.com/demo/flipbox-layouts/',
					'is_pro'   => '',
					'version'  => 1.0,
				],
			],

			'Addons'          => [
				'tabs'      => [
					'name'     => 'product-tabs',
					'status'   => $Normal,
					'status_n' => $Normal,
					'icon'     => WPTE_WPL_URL . '/Image/tabs.svg',
					'src'      => '',
					'video'    => 'https://youtu.be/cARaeKe3JSo',
					'doc'      => 'https://wpkin.com/docs/how-to-create-category-tabs/',
					'demo'     => 'https://product-layouts.com/demo/category-tabs/',
					'is_pro'   => $is_pro,
					'version'  => 1.0,
				],
				'carousel'  => [
					'name'     => 'carousel',
					'status'   => $New_N,
					'status_n' => $popular,
					'icon'     => WPTE_WPL_URL . '/Image/Carousel.svg',
					'src'      => '',
					'video'    => 'https://youtu.be/vTKz4-WQW7g',
					'doc'      => 'https://wpkin.com/docs/how-to-create-product-carousel/',
					'demo'     => 'https://product-layouts.com/demo/product-carousel/',
					'is_pro'   => $is_pro,
					'version'  => 1.0,
				],
				'filter'    => [
					'name'     => 'filter-&-sorting',
					'status'   => $New_N,
					'status_n' => $New_N,
					'icon'     => WPTE_WPL_URL . '/Image/filter.svg',
					'src'      => '',
					'video'    => 'https://youtu.be/GExYIEokH74',
					'doc'      => 'https://wpkin.com/docs/how-to-set-filter-sorting-in-product-layouts/',
					'demo'     => 'https://product-layouts.com/demo/filter-sorting/',
					'is_pro'   => $is_pro,
					'version'  => 1.1,
				],
				'accordion' => [
					'name'     => 'accordion',
					'status'   => 'Coming...',
					'status_n' => __( 'Coming...', 'product-layouts' ),
					'icon'     => WPTE_WPL_URL . '/Image/accordion.svg',
					'src'      => '',
					'video'    => '',
					'doc'      => '',
					'demo'     => '',
					'is_pro'   => '',
					'version'  => 1.0,
				],
			],
		];
	}

	/**
	 * Elements Render
	 *
	 * @since 1.0.0
	 */
	public function elements_render() {

		$Elements = $this->elements();

		?>
		<div class="wpte-wpl-row">
			<div class="wpte-wpl-wrapper">
				<div class="wpte-wpl-row">
					<?php
					foreach ( $Elements as $key => $elements ) {
						$pre            = 'Extension';
						$elementshtml   = '';
						$elementsnumber = 0;

						foreach ( $elements as $k => $value ) {
							if ( $value['status'] === 'Premium' ) {
								$wpllink = wpte_version_control() ? 'admin.php?page=product-layouts&layouts=' . $k : 'admin.php?page=product-layouts';
							} else {
								$wpllink = 'admin.php?page=product-layouts&layouts=' . $k;
							}
							$pro     = $value['status'] === 'Premium' ? 'pro-status' : '';
							$Updated = $value['status'] === 'Updated' || $value['status'] === 'Coming...' ? 'Updated-status' : '';
							$status  = $value['status'] ? '<div class="wpte-wpl-element-status ' . $Updated . ' ' . $pro . '">' . esc_html( $value['status_n'] ) . '</div>' : '';
							$video   = $value['video'] ? $value['video'] : '';
							$doc     = $value['doc'] ? $value['doc'] : '';
							$demo    = $value['demo'] ? $value['demo'] : '';
							$icons   = $doc ? '<div class="wpte-wpl-element-icons">
													<a href="' . esc_url( $video ) . '" target="_blank"><span class="wpte-home-icon-tooltip">Tutorial</span><span class="dashicons dashicons-youtube"></span></a>
													<a href="' . esc_url( $doc ) . '" target="_blank"><span class="wpte-home-icon-tooltip">Doc</span><span class="dashicons dashicons-media-document"></span></a>
													<a href="' . esc_url( $demo ) . '" target="_blank"><span class="wpte-home-icon-tooltip">Demo</span><span class="dashicons dashicons-desktop"></span></a>
												</div>' : '';
							++$elementsnumber;
							$elementshtml .= ' <div class="wpte-wpl-element-import" id="' . $value['name'] . '" wpte-wpl-search="' . $value['name'] . '">
													' . $icons . '
													<a class="addons-pre-check ' . $value['is_pro'] . '" href="' . admin_url( $wpllink ) . '" wpte-type="' . $pre . '">
														' . $status . '
														<div class="wpte-wpl-element-import-top">
														<img src="' . $value['icon'] . '" >
														</div>
														<div class="wpte-wpl-element-import-bottom">
															<span>' . name_converter( $value['name'] ) . '</span>
														</div>
													</a>
												</div>';
						}
						if ( $elementsnumber > 0 ) {
							echo '  <div class="wpte-wpl-text-blocks-body-wrapper">
										<div class="wpte-wpl-text-blocks-body">
											<div class="wpte-wpl-text-blocks">
												<div class="wpte-wpl-text-blocks-heading">' . esc_html( $key ) . '</div>
												<div class="wpte-wpl-text-blocks-border">
													<div class="wpte-wpl-text-block-border"></div>
												</div>
												<div class="wpte-wpl-text-blocks-content">Available (' . intval( $elementsnumber ) . ')</div>
											</div>
										</div>
									</div>';
							echo '<div class="wpte-wpl-elements-list">' . wp_kses( $elementshtml, wpte_plugins_allowedtags() ) . '</div>';
						}
					}
					?>
				</div>
			</div>
		</div>
		<?php
	}
}