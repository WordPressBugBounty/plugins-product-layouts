<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin\Pages\Layout_list;

/**
 * Import Class.
 */
class Import {

	/**
	 * Import Constructor
	 *
	 * @return void
	 */
	public function __construct() {
		$this->shortcode_importer();
		$this->loader();
	}

	/**
	 * Script Loader
	 *
	 * @return void
	 */
	public function loader() {
		wp_enqueue_script( 'wpte-wpl-admin-js' );
		wp_localize_script( 'wpte-wpl-admin-js', 'wpteImport', [
			'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
			'wpte_nonce'  => wp_create_nonce( 'wpte-import-nonce' ),
			'error'       => esc_html__( 'Something Went Wrong!', 'wpte-product-layout' ),
			'importerror' => sprintf( '<strong>%s:</strong> %s', esc_html__( 'Error', 'wpte-product-layout' ), esc_html__( 'Please upload a exported valid Json file.', 'wpte-product-layout' ) ),
		] );
	}

	/**
	 * Shortcode Importer Field
	 *
	 * @return void
	 */
	public function shortcode_importer() {

		?>
			<div class="wpte-wpl-wrapper">
			<div class="wpte-wpl-row">
			<div class="wpte-wpl-wrapper">
				<div class="wpte-wpl-create-layouts text-center p-5">
						<?php
							printf( '<h1>%s</h1>
							<p>%s</p>', esc_html__( 'Product Layouts › Import', 'wpte-product-layout' ), esc_html__( 'WC Product Layout. Import your shortcode exported json file', 'wpte-product-layout' ) );
						?>
					</div>
				</div>
				<div class="wpte-wpl-row">
					<div class="wpte-file-uploader">
						<form id="wpte-import-file-uploader" action="" method="post" enctype="multipart/form-data">
							<div class="fileuploader fileuploader-theme-dragdrop">
								<label class="fileuploader-input">
									<div class="fileuploader-input-inner">
										<div class="fileuploader-icon-main">
											<span class="dashicons dashicons-cloud-upload"></span>
										</div>
										<h3 class="fileuploader-input-caption">
											<span><?php echo esc_html__( 'Drag and drop files here', 'wpte-product-layout' ); ?></span>
										</h3>
										<p><?php echo esc_html__( 'Or', 'wpte-product-layout' ); ?></p>
										<input id="wpte-file" type="file" name="wpte_file">
										<button type="button" class="fileuploader-input-button">
											<span><?php echo esc_html__( 'Browse files', 'wpte-product-layout' ); ?></span>
										</button>
									</div>
								</label>
								<div class="wpte-fileuploader-items">
									<ul class="wpte-fileuploader-items-list">

									</ul>
								</div>
								<div class="wpte-file-import">
									<button type="submit" id="wpte_product_layout_import" class="fileuploader-button fileuploader-input-button" disabled><?php echo esc_html__( 'Import Layout', 'wpte-product-layout' ); ?></button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

?>