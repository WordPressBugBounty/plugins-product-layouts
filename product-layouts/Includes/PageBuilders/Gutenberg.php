<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\PageBuilders;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gutenberg / FSE Block integration.
 */
class Gutenberg {

	public function __construct() {
		add_action( 'init', [ $this, 'register_block' ] );
		add_action( 'enqueue_block_editor_assets', [ $this, 'editor_assets' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_assets' ], 15 );
	}

	/**
	 * Register the block type and editor script.
	 */
	public function register_block() {
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		wp_register_script(
			'wpte-product-layouts-block-editor',
			WPTE_WPL_URL . '/assets/blocks/product-layouts/index.js',
			[ 'wp-blocks', 'wp-element', 'wp-components', 'wp-server-side-render', 'wp-block-editor' ],
			WPTE_WPL_VERSION,
			true
		);

		wp_localize_script(
			'wpte-product-layouts-block-editor',
			'wpteBlockData',
			$this->get_editor_data()
		);

		register_block_type(
			WPTE_WPL_PATH . 'assets/blocks/product-layouts',
			[
				'render_callback' => [ $this, 'render_callback' ],
			]
		);
	}

	/**
	 * Enqueue plugin CSS + JS inside the Gutenberg editor so the block preview
	 * and the editor panel look correct.
	 */
	public function editor_assets() {
		// Global product layout stylesheet.
		wp_enqueue_style(
			'wpte-product-layouts-style',
			WPTE_WPL_ASSETS . 'global/css/wpte-product-layouts.css',
			[],
			filemtime( WPTE_WPL_PATH . 'assets/global/css/wpte-product-layouts.css' )
		);
		wp_enqueue_style(
			'wpte-cart-icon-style',
			WPTE_WPL_ASSETS . 'lib/icons/wpte-cart-icon.css',
			[],
			filemtime( WPTE_WPL_PATH . 'assets/lib/icons/wpte-cart-icon.css' )
		);
		wp_enqueue_style(
			'wpte-cart-icon-animation-style',
			WPTE_WPL_ASSETS . 'lib/icons/animation.css',
			[],
			filemtime( WPTE_WPL_PATH . 'assets/lib/icons/animation.css' )
		);

		// Frontend JS needed for interactive elements (quick view, compare, cart AJAX).
		wp_enqueue_script( 'wpte-serializejson' );
		wp_enqueue_script( 'wpte-global-js' );
		wp_enqueue_script( 'wpte-product-compare' );
	}

	/**
	 * Enqueue all plugin JS on the frontend when the page contains this block.
	 * This runs at priority 15 (after Assets::public_enqueue_scripts at default 10),
	 * so all scripts are already registered by then.
	 */
	public function frontend_assets() {
		if ( ! is_singular() ) {
			return;
		}

		global $post;

		if ( ! $post instanceof \WP_Post ) {
			return;
		}

		if ( ! has_block( 'product-layouts/product-layouts', $post ) ) {
			return;
		}

		// Enqueue everything the shortcode would enqueue, but early
		// (before wp_head fires) so scripts appear in <head> or footer correctly.
		wp_enqueue_script( 'wpte-serializejson' );
		wp_enqueue_script( 'wpte-global-js' );
		wp_enqueue_script( 'wpte-product-compare' );

		if ( function_exists( 'WC' ) && version_compare( WC()->version, '3.0.0', '>=' ) ) {
			wp_enqueue_script( 'wc-add-to-cart-variation' );
			wp_enqueue_script( 'wc-single-product' );
		}

		wp_enqueue_script( 'wpte-quick-view-js' );
	}

	/**
	 * Build the data passed to the block editor JS.
	 */
	private function get_editor_data() {
		global $wpdb;

		$table    = $wpdb->prefix . 'wpte_product_layout_style';
		$rows     = $wpdb->get_results( "SELECT id, name, style_name FROM {$table} ORDER BY id DESC", ARRAY_A ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		$options  = [];
		$editUrls = [];

		if ( $rows ) {
			foreach ( $rows as $row ) {
				$label              = ( isset( $row['name'] ) && '' !== $row['name'] ? $row['name'] : 'Product Layout' ) . ' (#' . $row['id'] . ')';
				$options[]          = [ 'value' => (string) $row['id'], 'label' => $label ];
				$parts              = explode( '-', $row['style_name'] );
				$layout_type        = isset( $parts[0] ) ? strtolower( $parts[0] ) : '';
				$editUrls[ (string) $row['id'] ] = admin_url(
					'admin.php?page=product-layouts&layouts=' . $layout_type . '&styleid=' . $row['id']
				);
			}
		}

		// Encode the plugin icon as a base64 data URI so the block JS can use it
		// without making a separate HTTP request and without path guessing.
		$icon_path = WPTE_WPL_PATH . 'Image/product-layouts-icon.svg';
		$icon_uri  = '';
		if ( file_exists( $icon_path ) ) {
			// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
			$icon_uri = 'data:image/svg+xml;base64,' . base64_encode( file_get_contents( $icon_path ) );
		}

		return [
			'layouts'  => $options,
			'editUrls' => $editUrls,
			'iconUri'  => $icon_uri,
			'i18n'     => [
				'selectLayout' => __( 'Select Layout', 'product-layouts' ),
				'editLayout'   => __( 'Edit Layout', 'product-layouts' ),
				'placeholder'  => __( 'Select a saved layout to display products.', 'product-layouts' ),
			],
		];
	}

	/**
	 * Server-side render callback.
	 *
	 * @param array $attributes Block attributes.
	 * @return string
	 */
	public function render_callback( $attributes ) {
		$id = isset( $attributes['layoutId'] ) ? absint( $attributes['layoutId'] ) : 0;

		if ( ! $id ) {
			return '<p style="padding:16px;border:2px dashed #ccc;text-align:center;">'
				. esc_html__( 'Please select a Product Layout from the block settings panel.', 'product-layouts' )
				. '</p>';
		}

		$output = '';

		// ServerSideRender calls this via REST API. External stylesheets enqueued via
		// enqueue_block_editor_assets don't reliably reach the iframed editor canvas,
		// so we inline the critical CSS directly into the preview HTML.
		if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
			$output .= $this->get_inline_editor_styles();
		}

		$output .= '<div class="wpte-gutenberg-block">'
			. do_shortcode( '[wpte_product_layout id="' . $id . '"]' )
			. '</div>';

		return $output;
	}

	/**
	 * Build a <style> block containing all CSS needed for the editor preview.
	 *
	 * @return string
	 */
	private function get_inline_editor_styles() {
		$files = [
			WPTE_WPL_PATH . 'assets/global/css/wpte-product-layouts.css', // shared layout styles
			WPTE_WPL_PATH . 'assets/lib/icons/wpte-cart-icon.css',
			WPTE_WPL_PATH . 'assets/lib/icons/animation.css',
		];

		$css = '';
		foreach ( $files as $file ) {
			if ( ! file_exists( $file ) ) {
				continue;
			}
			// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
			$content  = file_get_contents( $file );
			$file_rel = str_replace( WPTE_WPL_PATH, '', dirname( $file ) );
			$base_url = untrailingslashit( WPTE_WPL_URL ) . '/' . $file_rel . '/';
			$css     .= $this->absolutize_css_urls( $content, $base_url );
		}

		if ( ! $css ) {
			return '';
		}

		return '<style id="wpte-block-editor-inline-styles">' . $css . '</style>';
	}

	/**
	 * Replace relative url() references in CSS with absolute URLs.
	 *
	 * @param string $css      Raw CSS content.
	 * @param string $base_url Absolute URL of the directory the CSS file lives in.
	 * @return string
	 */
	private function absolutize_css_urls( $css, $base_url ) {
		$parsed      = wp_parse_url( $base_url );
		$base_origin = ( $parsed['scheme'] ?? 'https' ) . '://' . ( $parsed['host'] ?? '' );
		$base_path   = rtrim( $parsed['path'] ?? '', '/' ) . '/';

		return preg_replace_callback(
			'/url\(\s*[\'"]?([^\'"\)\s]+)[\'"]?\s*\)/i',
			function ( $matches ) use ( $base_origin, $base_path ) {
				$url = $matches[1];

				// Already absolute or a data URI — leave as-is.
				if (
					0 === strpos( $url, 'http' ) ||
					0 === strpos( $url, '//' ) ||
					0 === strpos( $url, 'data:' )
				) {
					return $matches[0];
				}

				// Root-relative — just prepend origin.
				if ( 0 === strpos( $url, '/' ) ) {
					return 'url("' . $base_origin . $url . '")';
				}

				// Separate query/hash suffix so it doesn't affect path resolution.
				$suffix = '';
				if ( preg_match( '/^([^?#]+)([?#].*)$/', $url, $m ) ) {
					$url    = $m[1];
					$suffix = $m[2];
				}

				// Merge base path + relative path, then collapse ../ and ./ segments.
				$merged = $base_path . $url;
				$parts  = explode( '/', $merged );
				$result = [];
				foreach ( $parts as $part ) {
					if ( '..' === $part ) {
						array_pop( $result );
					} elseif ( '.' !== $part ) {
						$result[] = $part;
					}
				}

				return 'url("' . $base_origin . implode( '/', $result ) . $suffix . '")';
			},
			$css
		);
	}
}
