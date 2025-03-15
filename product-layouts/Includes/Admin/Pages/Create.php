<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin\Pages;

/**
 * Description of Create
 *
 * @author wpkin
 */
class Create {

	/**
	 * Database Parent Table
	 *
	 * @var $parent_table
	 * @since 1.0.0
	 */
	public $parent_table;

	/**
	 * Define $wpdb
	 *
	 * @var $wpdb
	 * @since 1.0.0
	 */
	public $wpdb;

	/**
	 * Define layout
	 *
	 * @var $layouts
	 * @since 1.0.0
	 */
	public $layouts;

	/**
	 * Define $wpltype
	 *
	 * @var $wpltype
	 * @since 1.0.0
	 */
	public $wpltype;

	/**
	 * Define $TEMPLATE
	 *
	 * @var $TEMPLATE
	 * @since 1.0.0
	 */
	public $TEMPLATE = [];

	/**
	 * Create Constructor
	 *
	 * @return void
	 */
	public function __construct() {
		global $wpdb;
		$this->wpdb         = $wpdb;
		$this->parent_table = $this->wpdb->prefix . 'wpte_product_layout_style';

		$this->layouts = ( ! empty( $_GET['layouts'] ) ? sanitize_text_field( wp_unslash( $_GET['layouts'] ) ) : '' );
		$this->wpltype = $this->layouts . '-layout';
		$this->assets_loader();
		$this->json_data();
		$this->render();
	}

	/**
	 * Assets Loader
	 *
	 * @return void
	 */
	public function assets_loader() {

		wp_enqueue_script( 'wpte-wpl-bootstrap-js' );
		$this->admin_create_js();
		$this->wpte_compare_script_loader();
		$this->wpte_quickview_script_loader();
	}

	/**
	 * Admin Compare script loader
	 *
	 * @since 1.0.1
	 */
	public function wpte_compare_script_loader() {
		wp_enqueue_script( 'wpte-product-compare' );
	}

	/**
	 * QuickView Script Loader
	 *
	 * @return void
	 */
	public function wpte_quickview_script_loader() {
		if ( version_compare( WC()->version, '3.0.0', '>=' ) ) {
			if ( current_theme_supports( 'wc-product-gallery-zoom' ) ) {
				wp_enqueue_script( 'zoom' );
			}
			if ( current_theme_supports( 'wc-product-gallery-slider' ) ) {
				wp_enqueue_script( 'flexslider' );
			}
			wp_enqueue_script( 'wc-add-to-cart-variation' );
			wp_enqueue_script( 'wc-single-product' );
		}

		wp_enqueue_script( 'wpte-quick-view-js' );
	}

	/**
	 * Enqueue create js
	 *
	 * @return void
	 */
	public function admin_create_js() {
		wp_enqueue_script( 'wpte-wpl-admin-js' );
		wp_enqueue_script( 'wpte-wpl-create-js' );
		wp_localize_script(
            'wpte-wpl-create-js', 'wpteLayout', [
				'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
				'wpte_nonce' => wp_create_nonce( 'wpte-new-create-nonce' ),
				'error'      => __( 'Something Went Wrong!', 'wpte-product-layout' ),
			]
        );
		wp_enqueue_script( 'wpte-global-js' );
		wp_localize_script(
            'wpte-global-js', 'wpteGlobal', [
				'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
				'wpte_nonce' => wp_create_nonce( 'wpte-global-nonce' ),
				'error'      => __( 'Something Went Wrong!', 'wpte-product-layout' ),
			]
        );
	}

	/**
	 * Render
	 *
	 * @return void
	 */
	public function render() {
		apply_filters( 'wpte_product_layout_admin_menu', true );
		?>
		<div class="wpte-wpl-row">
			<?php
				$this->admin_header();
				$this->template();
				$this->create_new();
			?>
		</div>
		<?php
	}

	/**
	 * Get JSON DATA
	 *
	 * @return void
	 */
	public function json_data() {
	}

	/**
	 * Admin Header
	 *
	 * @return void
	 */
	public function admin_header() {
		?>
		<div class="wpte-popup-display"></div>
		<div class="wpte-wpl-wrapper">
			<div class="wpte-wpl-create-layouts text-center p-5">
				<?php
					printf( '<h1>%s</h1> <p>%s</p>', '' . esc_html( name_converter( (string) $this->layouts ) ) . esc_html__( ' Layouts › Create New', 'wpte-product-layout' ), esc_html__( 'Select Product layouts, Input your Product Layout name and create new Product layouts.', 'wpte-product-layout' ) );
				?>

			</div>
		</div>
		<?php
	}

	/**
	 * Templates
	 *
	 * @return void
	 */
	public function template() {
		?>
		<div class="container-fluid">
			<div class="row">
				<?php
				foreach ( $this->TEMPLATE as $key => $value ) {
					$id = explode( '-', $key )[1];
					?>
						<div class="col-sm-12" id="<?php echo esc_attr( $key ); ?>">
							<div class="wpte-product-style-preview">
								<div class="wpte-product-style-preview-top wpte-product-center">
									<?php
									foreach ( $value['files'] as $file_data ) {
										$decode_data = json_decode( $file_data, true );
										$s           = explode( '-', $decode_data['style']['style_name'] );
										echo '<div class="wpte-bt-col-lg-4 wpte-bt-col-md-6 wpte-bt-col-sm-12 p-3">';

										$CLASS = 'WPTE_PRODUCT_LAYOUT\Layouts\\' . ucfirst( $s[0] ) . '\Frontend\Layout' . $s[1];

										if ( class_exists( $CLASS ) ) :
											new $CLASS( $decode_data['style'] );
										else :
											printf( '<div class="wpte_product_layout_premium_img"><img src="%s"/></div>', esc_attr( $value['src'] ) );
										endif;

										echo '<textarea style="display:none" id="wptestyle' . esc_attr( $id ) . 'data">' . esc_html( htmlentities( wp_json_encode( $decode_data ) ) ) . '</textarea>';
										echo '</div>';
									}
									?>
								</div>
								<div class="wpte-product-style-preview-bottom">
									<div class="wpte-product-style-preview-bottom-left">
										<?php echo esc_html( $value['name'] ); ?>
									</div>
									<?php

									$file = json_decode( $value['files'][0], true );
									$p    = array_key_exists( 'status_po', $file['style'] ) ? $file['style']['status_po'] : '';

									if ( ! wpte_version_control() && ( $value['status'] === 'premium' || 'p' === $p ) ) {
										?>
										<div class="text-right">
											<button type="button" class="btn btn-danger wpte-product-layout-premium wpte-po-element" ><?php echo esc_html__( 'Premium', 'wpte-product-layout' ); ?></button>
										</div>
										<?php
									} else {
										?>
										<div class="text-right">
											<button type="button" class="btn btn-success wpte-product-layout-template-create" layouts-data="wptestyle<?php echo esc_attr( $id ); ?>data"><?php echo esc_html__( 'Create Style', 'wpte-product-layout' ); ?></button>
										</div>
										<?php
									}
									?>
								</div>
							</div>
						</div>
					<?php
				}
				?>
			</div>
		</div>
		<?php
	}

	/**
	 * Create New Layout
	 *
	 * @return void
	 */
	public function create_new() {
		printf(
            '<div class="modal fade" id="wpte-product-layout-create-modal">
					<form method="post" id="wpte-wpl-create-modal-form">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title">%s</h4>
									<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
								</div>
								<div class="modal-body">
									<div class=" form-group row">
										<label for="addons-style-name" class="col-sm-4 col-form-label">%s</label>
										<div class="col-sm-8 addons-dtm-laptop-lock">
											<input class="form-control" type="text" value="" id="style-name" name="style-name">
										</div>
									</div>

								</div>
								<div class="modal-footer">
									<input type="hidden" id="wptestyledata" name="wptestyledata" value="">
									<span id="create-loader" class="spinner sa-spinner-open"></span>
									<button type="button" class="btn btn-danger" data-bs-dismiss="modal">%s</button>
									<input type="submit" class="btn btn-success" name="addonsdatasubmit" id="addonsdatasubmit" value="%s">
								</div>
							</div>
						</div>
					</form>
				</div>',
            esc_html__( 'New Product Layout', 'wpte-product-layout' ),
            esc_html__( 'Name', 'wpte-product-layout' ),
            esc_html__( 'Close', 'wpte-product-layout' ),
            esc_html__( 'Save', 'wpte-product-layout' )
        );
	}
}



