<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin\Pages\Layout_list;

/**
 * Shortcode List Class
 *
 * @since 1.0.0
 */
class Shortcode {

	/**
	 * Shortcode Constructor
	 *
	 * @return void
	 */
	public function __construct() {
		$this->shortcodes();
		$this->layout_clone();
		$this->loader();
	}

	/**
	 * Script Loader
	 *
	 * @return void
	 */
	public function loader() {
		wp_enqueue_script( 'wpte-wpl-admin-js' );

		wp_localize_script(
            'wpte-wpl-admin-js', 'wpteAdmin', [
				'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
				'wpte_nonce' => wp_create_nonce( 'wpte-delete-nonce' ),
				'error'      => esc_html__( 'Something Went Wrong!', 'product-layouts' ),
				'message'    => esc_html__( 'Are you sure?', 'product-layouts' ),
			]
        );
		wp_enqueue_script( 'wpte-wpl-bootstrap-js' );

		wp_enqueue_script( 'wpte-wpl-create-js' );

		wp_localize_script(
            'wpte-wpl-create-js', 'wpteLayout', [
				'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
				'wpte_nonce' => wp_create_nonce( 'wpte-new-create-nonce' ),
				'error'      => esc_html__( 'Something Went Wrong!', 'product-layouts' ),
			]
        );
	}

	/**
	 * Display everything in shortcode page
	 *
	 * @return void
	 */
	public function shortcodes() {
		?>
			<div class="wpte-wpl-wrapper">
			<div class="wpte-wpl-row">
			<div class="wpte-wpl-wrapper">
				<div class="wpte-wpl-create-layouts text-center p-5">
						<?php
							printf( '<h1>%s</h1><p>%s</p>', esc_html__( 'Product Layouts › Shortcodes', 'product-layouts' ), esc_html__( 'Collect WC Product Layout Shortcode, Edit, Delete, Clone or Export it..', 'product-layouts' ) );
						?>
					</div>
				</div>
				<div class="wpte-wpl-row">
					<div class="wrap">
						<h1 class="wp-heading-inline"><?php echo esc_html__( 'Shortcode', 'product-layouts' ); ?></h1>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=product-layouts' ) ); ?>" class="page-title-action"><?php echo esc_html__( 'Add New', 'product-layouts' ); ?></a>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=product-layouts-shortcode&action=import' ) ); ?>" class="page-title-action"><?php echo esc_html__( 'Import', 'product-layouts' ); ?></a>
					</div>
					<div class="wpte-wpl-list-data-table">
						<form method="GET">
							<?php
								$table = new \WPTE_PRODUCT_LAYOUT\Includes\Admin\Pages\Layout_list\Layouts_List();
								$table->prepare_items();
								$table->search_box( 'search', 'search_id' );
								$table->display();
								// phpcs:ignore WordPress.Security.NonceVerification.Recommended
								$page = isset( $_REQUEST['page'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '';
							?>
							<input type="hidden" name="page" value="<?php echo esc_attr( $page ); ?>">
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Create New Layout
	 *
	 * @return void
	 */
	public function layout_clone() {
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
			esc_html__( 'Clone Layout', 'product-layouts' ),
			esc_html__( 'Name', 'product-layouts' ),
			esc_html__( 'Close', 'product-layouts' ),
			esc_html__( 'Save', 'product-layouts' )
		);
	}
}