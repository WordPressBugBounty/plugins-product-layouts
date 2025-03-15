<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin\Pages\Layout_list;

/**
 * Export Handler Class
 *
 * @since 1.0.0
 */
class Export {

	/**
	 * Export Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->wpte_layout_export();
	}

	/**
	 * Send file headers.
	 *
	 * @param string $file_name File name.
	 * @param int    $file_size File size.
	 */
	private function send_file_headers( $file_name, $file_size ) {
		header( 'Content-Type: application/octet-stream' );
		header( 'Content-Disposition: attachment; filename=' . $file_name );
		header( 'Expires: 0' );
		header( 'Cache-Control: must-revalidate' );
		header( 'Pragma: public' );
		header( 'Content-Length: ' . $file_size );
	}

	/**
	 * Method wpte_layout_export
	 *
	 * @since 1.0.0
	 */
	public function wpte_layout_export() {

		$action = isset( $_GET['action'] ) ? sanitize_text_field( wp_unslash( $_GET['action'] ) ) : '';
		$id     = isset( $_GET['id'] ) ? sanitize_text_field( wp_unslash( $_GET['id'] ) ) : '';

		if ( $action === 'export' && $id ) {
			$dbData    = wpte_get_layout( $id );
			$dbDataArr = json_decode( wp_json_encode( $dbData ), true );
			$arrgg     = [ 'style' => $dbDataArr ];
			$json_data = wp_json_encode( $arrgg );

			$filename = 'product-layouts-id-' . $id . '.json';

			$this->send_file_headers( $filename, strlen( $json_data ) );

			@ob_end_clean();
			flush();
			echo wp_kses( $json_data, wpte_plugins_allowedtags() );
			die;
		}
	}
}
