<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin\Pages;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin Menu Class
 *
 * @since 1.0.0
 */
final class ProductLayout
{

	use AdminTopMenu;

	/**
	 * ProductLayout class constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct()
	{

		$this->render_elements();
		add_action('admin_footer', [$this, 'wpte_offer_popup']);
	}

	/**
	 * Method Wpte_offer_popup.
	 *
	 * @since 1.1.4
	 */
	public function wpte_offer_popup()
	{
		echo '<div id="wpte-offer-modal"></div>';
	}

	/**
	 * All Element Render in Admin page
	 *
	 * @since 1.0.0
	 */
	public function render_elements()
	{
		wp_enqueue_script('wpte-wpl-admin-js');
		apply_filters('wpte_product_layout_admin_menu', true);
		$this->elements_render();
	}

	/**
	 * Elements List
	 * Status: Popular, Updated, Premium, New, Coming...
	 *
	 * @since 1.0.0
	 */
	public function elements()
	{
		$popular = wpte_version_control() ? 'Popular' : 'Premium';
		$Updated = wpte_version_control() ? 'Updated' : 'Premium';
		$New_N   = wpte_version_control() ? __('New', 'product-layouts') : __('Premium', 'product-layouts');
		$Normal  = wpte_version_control() ? '' : __('Premium', 'product-layouts');
		$is_pro  = wpte_version_control() ? '' : 'wpte-po-element';
		return [

			'Product Layouts' => [
				'general'        => [
					'name'     => 'general-layouts',
					'status'   => 'Popular', // Popular, Updated, Premium, New, Coming...
					'status_n' => __('Popular', 'product-layouts'),
					'icon'     => WPTE_WPL_URL . '/Image/general.svg',
					'src'      => '',
					'video'    => 'https://youtu.be/sU2Woih2-DU',
					'doc'      => 'https://oxilab.dev/docs/product-layouts/create-layouts/how-to-create-general-layouts/',
					'demo'     => 'https://product-layouts.com/demo/general-layouts/',
					'is_pro'   => '',
					'items'    => 0,
					'version'  => 1.0,
				],
				'call_to_action' => [
					'name'     => 'call-to-action-layouts',
					'status'   => '',
					'status_n' => '',
					'icon'     => WPTE_WPL_URL . '/Image/call-to-action.svg',
					'src'      => '',
					'video'    => 'https://youtu.be/e8Aq1ohfYWo',
					'doc'      => 'https://oxilab.dev/docs/product-layouts/create-layouts/how-to-create-call-to-action-layouts/',
					'demo'     => 'https://product-layouts.com/demo/call-to-action/',
					'is_pro'   => '',
					'items'    => 0,
					'version'  => 1.0,
				],
				'table'          => [
					'name'     => 'product-table-layouts',
					'status'   => '',
					'status_n' => '',
					'icon'     => WPTE_WPL_URL . '/Image/product-table.svg',
					'src'      => '',
					'video'    => 'https://youtu.be/fE2l_z4oEEg',
					'doc'      => 'https://oxilab.dev/docs/product-layouts/create-layouts/how-to-create-table-layouts/',
					'demo'     => 'https://product-layouts.com/demo/product-table/',
					'is_pro'   => '',
					'items'    => 0,
					'version'  => 1.0,
				],
				'product_list'   => [
					'name'     => 'product-list-layouts',
					'status'   => 'New',
					'status_n' => __('New', 'product-layouts'),
					'icon'     => WPTE_WPL_URL . '/Image/list.svg',
					'src'      => '',
					'video'    => 'https://youtu.be/ctu4Nfz_bUg',
					'doc'      => 'https://oxilab.dev/docs/product-layouts/create-layouts/how-to-create-product-list-layouts/',
					'demo'     => 'https://product-layouts.com/demo/product-list/',
					'is_pro'   => '',
					'items'    => 0,
					'version'  => 1.0,
				],
				'caption'        => [
					'name'     => 'caption-layouts',
					'status'   => 'Updated',
					'status_n' => __('Updated', 'product-layouts'),
					'icon'     => WPTE_WPL_URL . '/Image/caption.svg',
					'src'      => '',
					'video'    => 'https://youtu.be/C_hUfw6l_Y4',
					'doc'      => 'https://oxilab.dev/docs/product-layouts/create-layouts/how-to-create-caption-layouts/',
					'demo'     => 'https://product-layouts.com/demo/caption-layouts/',
					'is_pro'   => '',
					'items'    => 0,
					'version'  => 1.0,
				],
				'flipbox'        => [
					'name'     => 'flipbox-layouts',
					'status'   => 'New',
					'status_n' => __('New', 'product-layouts'),
					'icon'     => WPTE_WPL_URL . '/Image/flip-box.svg',
					'src'      => '',
					'video'    => 'https://youtu.be/x0RZRpX4M98',
					'doc'      => 'https://oxilab.dev/docs/product-layouts/create-layouts/how-to-create-flip-box-layouts/',
					'demo'     => 'https://product-layouts.com/demo/flipbox-layouts/',
					'is_pro'   => '',
					'items'    => 0,
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
					'doc'      => 'https://oxilab.dev/docs/product-layouts/create-addons/how-to-create-category-tabs/',
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
					'doc'      => 'https://oxilab.dev/docs/product-layouts/create-addons/how-to-create-product-carousel/',
					'demo'     => 'https://product-layouts.com/demo/product-carousel/',
					'is_pro'   => $is_pro,
					'version'  => 1.0,
				],
				'filter'    => [
					'name'     => 'filter-&-sorting',
					'status'   => $Updated,
					'status_n' => $Updated,
					'icon'     => WPTE_WPL_URL . '/Image/filter.svg',
					'src'      => '',
					'video'    => 'https://youtu.be/GExYIEokH74',
					'doc'      => 'https://oxilab.dev/docs/product-layouts/create-addons/how-to-set-filter-sorting-in-product-layouts/',
					'demo'     => 'https://product-layouts.com/demo/filter-sorting/',
					'is_pro'   => $is_pro,
					'version'  => 1.1,
				],
				'accordion' => [
					'name'     => 'accordion',
					'status'   => 'Coming...',
					'status_n' => __('Coming...', 'product-layouts'),
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
	 * Number of designs each layout type offers, read from its json_data()
	 * without running its constructor (which would render the type page).
	 *
	 * @since 1.4.5
	 * @param string $type Layout type key, e.g. "call_to_action".
	 * @return int
	 */
	private function design_count( $type ) {
		$class = 'WPTE_PRODUCT_LAYOUT\Layouts\\' . ucfirst( $type ) . '\\' . ucfirst( $type );
		if ( ! class_exists( $class ) ) {
			return 0;
		}
		try {
			$layout = ( new \ReflectionClass( $class ) )->newInstanceWithoutConstructor();
			$layout->json_data();
			return is_array( $layout->TEMPLATE ) ? count( $layout->TEMPLATE ) : 0;
		} catch ( \Throwable $e ) {
			return 0;
		}
	}

	/**
	 * Saved layouts per type. Each saved layout's style_name starts with its
	 * type, e.g. "general-2" or "call_to_action-1".
	 *
	 * @since 1.4.5
	 * @return array<string,int>
	 */
	private function saved_counts() {
		global $wpdb;
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$rows   = $wpdb->get_results( "SELECT SUBSTRING_INDEX(style_name, '-', 1) AS type, COUNT(*) AS total FROM {$wpdb->prefix}wpte_product_layout_style GROUP BY type", ARRAY_A );
		$counts = [];
		foreach ( (array) $rows as $row ) {
			$counts[ $row['type'] ] = (int) $row['total'];
		}
		return $counts;
	}

	/**
	 * Elements Render
	 *
	 * Link rules are unchanged from before the redesign: a type marked
	 * "Premium" (free plan only) links back to this page and carries
	 * wpte-po-element, which opens the upgrade popup instead.
	 *
	 * @since 1.0.0
	 */
	public function elements_render()
	{
		$elements = $this->elements();
		$saved    = $this->saved_counts();
		$total    = array_sum( $saved );
		$sections = [
			'Product Layouts' => __( 'Product layouts', 'product-layouts' ),
			'Addons'          => __( 'Addons', 'product-layouts' ),
		];
		$pills    = [
			'Popular'   => 'is-popular',
			'New'       => 'is-new',
			'Updated'   => 'is-updated',
			'Premium'   => 'is-pro',
			'Coming...' => 'is-soon',
		];
		?>
		<div class="wpte-wpl-account wpte-wpl-settings wpte-wpl-pick">
			<header class="wpte-wpl-acc-hero">
				<img class="wpte-wpl-acc-hero-logo" src="<?php echo esc_url( WPTE_WPL_URL . '/Image/wpl-icon.svg' ); ?>" alt="" width="52" height="52">
				<div class="wpte-wpl-acc-hero-text">
					<h1 class="wpte-wpl-acc-title"><?php esc_html_e( 'Product Layouts', 'product-layouts' ); ?></h1>
					<p class="wpte-wpl-acc-subtitle"><?php esc_html_e( 'Choose a layout type to browse its designs. Every layout you create gets a shortcode you can place on any page.', 'product-layouts' ); ?></p>
				</div>
				<a class="wpte-wpl-set-btn" href="<?php echo esc_url( admin_url( 'admin.php?page=product-layouts-shortcode' ) ); ?>">
					<span class="dashicons dashicons-shortcode" aria-hidden="true"></span><?php esc_html_e( 'Your layouts', 'product-layouts' ); ?>
					<span class="wpte-wpl-pick-total"><?php echo esc_html( number_format_i18n( $total ) ); ?></span>
				</a>
			</header>
			<hr class="wp-header-end">

			<?php foreach ( $elements as $group => $items ) : ?>
				<?php if ( empty( $items ) ) { continue; } ?>
				<section class="wpte-wpl-pick-section" aria-labelledby="wpte-wpl-pick-<?php echo esc_attr( sanitize_title( $group ) ); ?>">
					<h2 class="wpte-wpl-pick-heading" id="wpte-wpl-pick-<?php echo esc_attr( sanitize_title( $group ) ); ?>">
						<?php echo esc_html( isset( $sections[ $group ] ) ? $sections[ $group ] : $group ); ?>
						<span class="wpte-wpl-pick-heading-count"><?php echo esc_html( number_format_i18n( count( $items ) ) ); ?></span>
					</h2>
					<div class="wpte-wpl-pick-grid">
						<?php
						foreach ( $items as $type => $value ) :
							$soon    = 'Coming...' === $value['status'];
							$premium = 'Premium' === $value['status'];
							// Same link as before: Premium (free plan) types stay on this page.
							$link    = $premium && ! wpte_version_control() ? 'admin.php?page=product-layouts' : 'admin.php?page=product-layouts&layouts=' . $type;
							$name    = name_converter( $value['name'] );
							$name    = '' !== $name ? $name : ucwords( str_replace( [ '-', '_' ], ' ', $value['name'] ) );
							$designs = $soon ? 0 : $this->design_count( $type );
							$mine    = isset( $saved[ $type ] ) ? $saved[ $type ] : 0;
							$locked  = '' !== $value['is_pro'];
							?>
							<div class="wpte-wpl-pick-card<?php echo $soon ? ' is-soon' : ''; ?><?php echo $locked ? ' is-locked' : ''; ?>" id="<?php echo esc_attr( $value['name'] ); ?>">
								<?php if ( $value['status'] ) : ?>
									<?php
									// Color by the label shown (status_n); fall back to status when the label is translated.
									$pill = isset( $pills[ $value['status_n'] ] ) ? $pills[ $value['status_n'] ] : ( isset( $pills[ $value['status'] ] ) ? $pills[ $value['status'] ] : '' );
									?>
									<span class="wpte-wpl-pick-pill <?php echo esc_attr( $pill ); ?>">
										<?php if ( $premium ) : ?><span class="dashicons dashicons-lock" aria-hidden="true"></span><?php endif; ?>
										<?php echo esc_html( $soon ? __( 'Coming soon', 'product-layouts' ) : $value['status_n'] ); ?>
									</span>
								<?php endif; ?>
								<span class="wpte-wpl-pick-icon"><img src="<?php echo esc_url( $value['icon'] ); ?>" alt="" width="32" height="32"></span>
								<h3 class="wpte-wpl-pick-name">
									<?php if ( $soon ) : ?>
										<?php echo esc_html( $name ); ?>
									<?php else : ?>
										<a class="wpte-wpl-pick-link addons-pre-check <?php echo esc_attr( $value['is_pro'] ); ?>" href="<?php echo esc_url( admin_url( $link ) ); ?>"><?php echo esc_html( $name ); ?></a>
									<?php endif; ?>
								</h3>
								<p class="wpte-wpl-pick-meta">
									<?php
									if ( $soon ) {
										esc_html_e( 'On its way in a future update.', 'product-layouts' );
									} else {
										/* translators: %s: number of designs */
										echo esc_html( sprintf( _n( '%s design', '%s designs', $designs, 'product-layouts' ), number_format_i18n( $designs ) ) );
										if ( $mine > 0 ) {
											echo ' <span aria-hidden="true">&middot;</span> ';
											/* translators: %s: number of saved layouts */
											echo esc_html( sprintf( _n( '%s saved', '%s saved', $mine, 'product-layouts' ), number_format_i18n( $mine ) ) );
										}
									}
									?>
								</p>
								<?php if ( ! empty( $value['doc'] ) || ! empty( $value['video'] ) || ! empty( $value['demo'] ) ) : ?>
									<div class="wpte-wpl-pick-links">
										<?php if ( ! empty( $value['video'] ) ) : ?>
											<a href="<?php echo esc_url( $value['video'] ); ?>" target="_blank" rel="noopener"><span class="dashicons dashicons-video-alt3" aria-hidden="true"></span><?php esc_html_e( 'Tutorial', 'product-layouts' ); ?></a>
										<?php endif; ?>
										<?php if ( ! empty( $value['doc'] ) ) : ?>
											<a href="<?php echo esc_url( $value['doc'] ); ?>" target="_blank" rel="noopener"><span class="dashicons dashicons-media-document" aria-hidden="true"></span><?php esc_html_e( 'Docs', 'product-layouts' ); ?></a>
										<?php endif; ?>
										<?php if ( ! empty( $value['demo'] ) ) : ?>
											<a href="<?php echo esc_url( $value['demo'] ); ?>" target="_blank" rel="noopener"><span class="dashicons dashicons-visibility" aria-hidden="true"></span><?php esc_html_e( 'Demo', 'product-layouts' ); ?></a>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				</section>
			<?php endforeach; ?>
		</div>
		<?php
	}
}
