<?php

/**
 * Preview Frame Template
 * Renders ONLY the product layout block for iframe preview
 *
 * @package product-layouts
 * @since 1.3.7
 */

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin\Pages;

if (! defined('ABSPATH')) {
	exit;
}

/**
 * PreviewFrame Class
 * Minimal template for iframe preview rendering
 */
class PreviewFrame
{

	/**
	 * Layout ID
	 *
	 * @var int
	 */
	private $layout_id;

	/**
	 * Layout data from database
	 *
	 * @var array
	 */
	private $dbdata;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->layout_id = isset($_GET['styleid']) ? intval($_GET['styleid']) : 0;

		if (! $this->layout_id) {
			wp_die(esc_html__('Invalid layout ID', 'product-layouts'));
		}

		$this->load_layout_data();

		// Isolate preview environment
		add_action('wp_enqueue_scripts', [$this, 'assets_isolation'], 9999);
		add_action('wp_print_styles', [$this, 'assets_isolation'], 9999);

		$this->render();
	}

	/**
	 * Dequeue unwanted styles and scripts
	 */
	public function assets_isolation()
	{
		global $wp_scripts, $wp_styles;

		// Allowed Handles (Core, WooCommerce, and This Plugin)
		$allowed = [
			// WordPress Core
			'jquery',
			'jquery-core',
			'jquery-migrate',
			'wp-util',
			'underscore',
			'backbone',
			'wp-embed',
			'wp-api',
			'wp-polyfill',
			'regenerator-runtime',
			'common',
			'admin-bar',
			'buttons',
			'media-views',
			'wp-auth-check',

			// WooCommerce
			'woocommerce',
			'wc-add-to-cart',
			'wc-cart-fragments',
			'wc-checkout',
			'wc-add-to-cart-variation',
			'wc-single-product',
			'wc-country-select',
			'wc-address-i18n',
			'woocommerce-general',
			'woocommerce-layout',
			'woocommerce-smallscreen',
			'wc-block-style',
			'wc-blocks-style', // Block themes often use this

			// WooCommerce Product Gallery Dependencies (needed for Quick View)
			'flexslider',
			'zoom',
			'photoswipe',
			'photoswipe-ui-default',
			'photoswipe-default-skin',

			// Product Layouts Plugin (Our own assets)
			'wpte-product-layout-public',
			'wpte-global-js',
			'wpte-quick-view-js',
			'wpte-product-compare-js',
			'wpte-font-picker',
			'wpte-cart-icon-style',
			'wpte-product-layouts-style',
			'wpte-cart-icon-animation-style',
			'wpte-overlay-scrollbar-css',
			'wpte-overlay-scrollbar',
			'wpte-overlay-scrollbar-init',

			// Font Awesome (often needed)
			'font-awesome',
			'fontawesome',
			'wpte-icon-picker',
		];

		// Dequeue Scripts
		if (isset($wp_scripts->queue)) {
			foreach ($wp_scripts->queue as $handle) {
				if (!in_array($handle, $allowed) && !strpos($handle, 'wpte') !== false) {
					wp_dequeue_script($handle);
					wp_deregister_script($handle);
				}
			}
		}

		// Dequeue Styles
		if (isset($wp_styles->queue)) {
			foreach ($wp_styles->queue as $handle) {
				if (!in_array($handle, $allowed) && !strpos($handle, 'wpte') !== false) {
					wp_dequeue_style($handle);
					wp_deregister_style($handle);
				}
			}
		}
	}

	/**
	 * Load layout data from database
	 */
	private function load_layout_data()
	{
		global $wpdb;

		$this->dbdata = $wpdb->get_row(
			$wpdb->prepare(
				'SELECT * FROM ' . $wpdb->prefix . 'wpte_product_layout_style WHERE id = %d',
				$this->layout_id
			),
			ARRAY_A
		);

		if (! $this->dbdata) {
			wp_die(esc_html__('Layout not found', 'product-layouts'));
		}
	}

	/**
	 * Render the preview frame
	 */
	private function render()
	{
		$style_name = explode('-', ucfirst($this->dbdata['style_name']));

		// Load font families if any
		$font_family = ! empty($this->dbdata['font_family']) ? json_decode($this->dbdata['font_family'], true) : [];

?>
		<!DOCTYPE html>
		<html <?php language_attributes(); ?>>

		<head>
			<meta charset="<?php bloginfo('charset'); ?>">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<meta name="robots" content="noindex, nofollow">
			<title><?php esc_html_e('Preview', 'product-layouts'); ?></title>

			<?php
			// Load essential WordPress styles
			wp_head();

			// Load WooCommerce styles
			wp_enqueue_style('woocommerce-general');
			wp_enqueue_style('woocommerce-layout');
			wp_enqueue_style('woocommerce-smallscreen');

			// Load plugin frontend styles
			wp_enqueue_style('wpte-product-layout-public');

			// Load plugin frontend scripts
			wp_enqueue_script('wpte-global-js');
			wp_enqueue_script('wpte-quick-view-js');
			wp_enqueue_script('wc-add-to-cart-variation');

			// Register and enqueue OverlayScrollbars for the iframe preview
			wp_register_style('wpte-overlay-scrollbar-css', WPTE_WPL_ASSETS . 'lib/overlay-scrollbar/overlayscrollbars.min.css', [], WPTE_WPL_VERSION);
			wp_enqueue_style('wpte-overlay-scrollbar-css');
			wp_register_script('wpte-overlay-scrollbar', WPTE_WPL_ASSETS . 'lib/overlay-scrollbar/overlayscrollbars.min.js', [], WPTE_WPL_VERSION, true);
			wp_enqueue_script('wpte-overlay-scrollbar');
			wp_register_script('wpte-overlay-scrollbar-init', WPTE_WPL_ASSETS . 'lib/overlay-scrollbar/overlay-scrollbar.js', ['jquery', 'wpte-overlay-scrollbar'], WPTE_WPL_VERSION, true);
			wp_enqueue_script('wpte-overlay-scrollbar-init');

			// Load WooCommerce product gallery dependencies (not auto-registered on non-product pages)
			$wc_assets_url = plugins_url('', WC_PLUGIN_FILE) . '/assets/';
			$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

			// FlexSlider (required for Quick View image gallery)
			if (!wp_script_is('flexslider', 'registered')) {
				wp_register_script('flexslider', $wc_assets_url . 'js/flexslider/jquery.flexslider' . $suffix . '.js', ['jquery'], '2.7.2', true);
			}
			wp_enqueue_script('flexslider');

			// Zoom (required for product image zoom)
			if (!wp_script_is('zoom', 'registered')) {
				wp_register_script('zoom', $wc_assets_url . 'js/zoom/jquery.zoom' . $suffix . '.js', ['jquery'], '1.7.21', true);
			}
			wp_enqueue_script('zoom');

			// WC Single Product (initializes gallery with flexslider)
			if (!wp_script_is('wc-single-product', 'registered')) {
				wp_register_script('wc-single-product', $wc_assets_url . 'js/frontend/single-product' . $suffix . '.js', ['jquery', 'flexslider', 'zoom'], WC_VERSION, true);
			}
			wp_enqueue_script('wc-single-product');

			// Load saved stylesheet
			if (! empty($this->dbdata['stylesheet'])) {
				echo '<style id="pl-saved-styles">' . wp_strip_all_tags($this->dbdata['stylesheet']) . '</style>';
			}

			// Load font families
			if (! empty($font_family)) {
				font_familly_validation($font_family);
			}
			?>

			<?php
			// Get background color
			$style_data = !empty($this->dbdata['style_data']) ? json_decode(wp_unslash($this->dbdata['style_data']), true) : [];
			$preview_bg = isset($style_data['wpte-preview-bg-color']) ? esc_attr($style_data['wpte-preview-bg-color']) : '';
			?>

			<!-- Dynamic styles injection point -->
			<style id="pl-dynamic-styles"></style>

			<style>
				body {
					margin: 0;
					padding: 20px;
					min-height: 100%;
					font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
					background-image: url('<?php echo esc_url(WPTE_WPL_URL . '/assets/backend/images/transparent.png'); ?>');
					background-repeat: repeat;
					<?php if ($preview_bg !== '') : ?>
					background-color: <?php echo $preview_bg; ?>;
					<?php endif; ?>
				}

				.wpte-product-layout-wrapper {
					width: 100%;
				}

				/* Strict Isolation: Hide everything except our content */
				body.wpte-preview-frame>*:not(#wpte-isolated-content):not(.wpte-popup-display):not(script):not(style):not(link) {
					display: none !important;
				}

				/* Ensure our wrappers are visible and contain floats */
				#wpte-isolated-content {
					display: flow-root !important;
					width: 100%;
				}
			</style>
		</head>

		<body class="wpte-preview-frame">
			<?php
			echo '<div id="wpte-isolated-content">';
			// Render the layout
			$class_name = '\\WPTE_PRODUCT_LAYOUT\\Layouts\\' . ucfirst($style_name[0]) . '\\Frontend\\Layout' . $style_name[1];

			if (class_exists($class_name)) {
				new $class_name($this->dbdata, 'admin');
			} else {
				echo '<p>' . esc_html__('Layout class not found', 'product-layouts') . '</p>';
			}
			echo '</div>';

			// Popup container for Quick View and Compare
			echo '<div class="wpte-popup-display"></div>';

			// Load footer scripts
			wp_footer();
			?>
		</body>

		</html>
<?php
		exit;
	}
}
