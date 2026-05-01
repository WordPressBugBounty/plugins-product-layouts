<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\PageBuilders;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Elementor {
	public function __construct() {
		if ( ! class_exists( '\Elementor\Plugin' ) ) {
			return;
		}
		add_action( 'elementor/widgets/register', [ $this, 'register' ] );
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'editor_icon_style' ] );
	}

	public function editor_icon_style() {
		$svg_path = WPTE_WPL_PATH . 'Image/product-layouts-icon.svg';

		if ( ! file_exists( $svg_path ) ) {
			return;
		}

		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$svg_data = base64_encode( file_get_contents( $svg_path ) );
		$data_uri = 'data:image/svg+xml;base64,' . $svg_data;

		echo '<style>
			i.icon-product-layouts::before,
			i.icon-product-layouts::after { display: none !important; }
			i.icon-product-layouts {
				display: inline-block !important;
				width: 28px !important;
				height: 28px !important;
				background-image: url("' . esc_attr( $data_uri ) . '") !important;
				background-size: contain !important;
				background-repeat: no-repeat !important;
				background-position: center !important;
				font-size: 0 !important;
			}
		</style>';
	}

	/**
	 * @param \Elementor\Widgets_Manager $widgets_manager
	 */
	public function register( $widgets_manager ) {
		if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
			return;
		}
		if ( ! class_exists( __NAMESPACE__ . '\Product_Layouts_Elementor_Widget' ) ) {
			wpte_define_product_layouts_elementor_widget();
		}
		$widgets_manager->register( new Product_Layouts_Elementor_Widget() );
	}
}

function wpte_define_product_layouts_elementor_widget() {
	if ( class_exists( '\Elementor\Widget_Base' ) && ! class_exists( __NAMESPACE__ . '\Product_Layouts_Elementor_Widget' ) ) {
		class Product_Layouts_Elementor_Widget extends \Elementor\Widget_Base {

			public function get_name() {
				return 'wpte_product_layouts';
			}

			public function get_title() {
				return esc_html__( 'Product Layouts', 'product-layouts' );
			}

			public function get_icon() {
				return 'icon-product-layouts';
			}

			public function get_categories() {
				return [ 'general' ];
			}

			public function get_style_depends() {
				return [ 'wpte-product-layouts-style' ];
			}

			public function get_script_depends() {
				return [ 'wpte-serializejson', 'wpte-global-js', 'wpte-quick-view-js', 'wpte-product-compare' ];
			}

			protected function register_controls() {
				global $wpdb;

				$options   = [];
				$edit_urls = [];
				$table     = $wpdb->prefix . 'wpte_product_layout_style';
				$rows      = $wpdb->get_results( "SELECT id, name, style_name FROM {$table} ORDER BY id DESC", ARRAY_A );

				if ( $rows ) {
					foreach ( $rows as $row ) {
						$label                          = ( isset( $row['name'] ) && $row['name'] !== '' ? $row['name'] : 'Product Layout' ) . ' (#' . $row['id'] . ')';
						$options[ (string) $row['id'] ] = $label;

						$parts                            = explode( '-', $row['style_name'] );
						$layout_type                      = isset( $parts[0] ) ? strtolower( $parts[0] ) : '';
						$edit_urls[ (string) $row['id'] ] = admin_url(
							'admin.php?page=product-layouts&layouts=' . $layout_type . '&styleid=' . $row['id']
						);
					}
				}

				$default = '';
				if ( ! empty( $options ) ) {
					$keys    = array_keys( $options );
					$default = reset( $keys );
				}

				$this->start_controls_section(
					'section_product_layouts',
					[ 'label' => esc_html__( 'Product Layouts', 'product-layouts' ) ]
				);

				$this->add_control(
					'id',
					[
						'label'   => esc_html__( 'Select Layout', 'product-layouts' ),
						'type'    => \Elementor\Controls_Manager::SELECT,
						'options' => $options,
						'default' => $default,
					]
				);

				// Build URL map as a JS object literal using esc_js() — no HTML encoding issues.
				$urls_js = '';
				foreach ( $edit_urls as $lid => $url ) {
					$urls_js .= '"' . esc_js( (string) $lid ) . '":"' . esc_js( $url ) . '",';
				}
				$urls_js = rtrim( $urls_js, ',' );

				$this->add_control(
					'edit_layout_btn',
					[
						'type'      => \Elementor\Controls_Manager::RAW_HTML,
						'raw'       => '<a class="wpte-edit-layout-btn" href="#" target="_blank"
								style="display:inline-flex;align-items:center;gap:6px;margin-top:4px;
								       padding:7px 18px;background:#6d59ef;color:#fff;border-radius:4px;
								       text-decoration:none;font-size:13px;font-weight:600;
								       transition:background .2s;"
								onmouseover="this.style.background=\'#5a48d4\'"
								onmouseout="this.style.background=\'#6d59ef\'">
								&#9998; ' . esc_html__( 'Edit Layout', 'product-layouts' ) . '
							</a>
							<script>
							(function() {
								var urls = {' . $urls_js . '};
								function wpteInit() {
									var select = document.querySelector( ".elementor-control-id select" );
									var btn    = document.querySelector( ".wpte-edit-layout-btn" );
									if ( ! select || ! btn ) {
										setTimeout( wpteInit, 100 );
										return;
									}
									function setUrl() {
										var url = urls[ select.value ];
										if ( url ) { btn.href = url; }
									}
									setUrl();
									select.addEventListener( "change", setUrl );
								}
								setTimeout( wpteInit, 0 );
							})();
							</script>',
						'separator' => 'before',
					]
				);

				$this->end_controls_section();
			}

			protected function render() {
				$settings = $this->get_settings_for_display();
				$id       = isset( $settings['id'] ) ? intval( $settings['id'] ) : 0;
				if ( ! $id ) {
					return;
				}
				echo do_shortcode( '[wpte_product_layout id="' . esc_attr( $id ) . '"]' );
			}
		}
	}
}
