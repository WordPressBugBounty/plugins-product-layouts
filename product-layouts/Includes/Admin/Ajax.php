<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin;

/**
 * Ajax Handler Class
 */
class Ajax {

	/**
	 * Method __construct
	 *
	 * @return void
	 */
	public function __construct() {

		add_action( 'wp_ajax_wpte_create_new_layout', [ $this, 'wpte_create_new_layout' ] );
		add_action( 'wp_ajax_wpte_editor_update_form', [ $this, 'wpte_editor_update_form' ] );
		add_action( 'wp_ajax_wpte_get_productc', [ $this, 'wpte_w_get_productc' ] );
		add_action( 'wp_ajax_wpte_delete_shortcode', [ $this, 'wpte_delete_shortcodes' ] );
		add_action( 'wp_ajax_wpte_shortcode_update_name', [ $this, 'wpte_shortcode_update_name' ] );
		add_action( 'wp_ajax_wpte_shortcode_import_layout', [ $this, 'wpte_shortcode_import_layout' ] );
		add_action( 'wp_ajax_wpte_clone_layout', [ $this, 'wpte_clone_layout' ] );
		add_action( 'wp_ajax_wpte_settings_form', [ $this, 'wpte_settings_form' ] );
	}

	/**
	 * Method url_conveter
	 *
	 * @param array $args .
	 * @return string.
	 */
	public function url_conveter( $args = [] ) {
		$layoutName = explode( '-', $args[0] );
		return admin_url( 'admin.php?page=product-layouts&layouts=' . $layoutName[0] . '&styleid=' . $args[1] );
	}

	/**
	 * Method wpte_create_new_layout
	 *
	 * @return mixed
	 */
	public function wpte_create_new_layout() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$nonce = isset( $_REQUEST['_nonce'] ) && '' !== $_REQUEST['_nonce'] ? sanitize_text_field( wp_unslash( $_REQUEST['_nonce'] ) ) : '';
		if ( ! wp_verify_nonce( $nonce, 'wpte-new-create-nonce' ) ) {
			return esc_html__( 'Nonce Varification Failed!', 'wpte-product-layout' );
		}

		$name        = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
		$style_name  = isset( $_POST['style_name'] ) ? sanitize_text_field( wp_unslash( $_POST['style_name'] ) ) : '';
		$rawdata     = isset( $_POST['rawdata'] ) ? stripslashes( sanitize_text_field( wp_unslash( $_POST['rawdata'] ) ) ) : '';
		$stylesheet  = isset( $_POST['stylesheet'] ) ? sanitize_text_field( wp_unslash( $_POST['stylesheet'] ) ) : '';
		$font_family = sanitize_text_field( '' );

		$insert_id = wpte_layout_insert(
            [
				'name'        => $name,
				'style_name'  => $style_name,
				'rawdata'     => $rawdata,
				'stylesheet'  => $stylesheet,
				'font_family' => $font_family,
			]
        );

		$names       = [];
		$is_match    = preg_match_all( '/(wpte-product-layout-wrapper-)[0-9]+/', $stylesheet, $names );
		$replaceData = "wpte-product-layout-wrapper-$insert_id";
		$get_match   = $names[0][0];
		$finalData   = preg_replace( "/$get_match/i", $replaceData, $stylesheet );
		wpte_layout_update_style( $insert_id, $finalData );

		wp_send_json_success(
            [
				'url' => $this->url_conveter( [ $style_name, $insert_id ] ),
			]
        );

		if ( is_wp_error( $insert_id ) ) {
			wp_send_json_error(
                [
					'message' => __( 'Data Insert Failed Please retry again!', 'wpte-product-layout' ),
				]
            );
		}
	}

	/**
	 * Method wpte_delete_shortcodes.
	 *
	 * @return mixed
	 */
	public function wpte_delete_shortcodes() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$nonce = isset( $_REQUEST['_nonce'] ) && '' !== $_REQUEST['_nonce'] ? sanitize_text_field( wp_unslash( $_REQUEST['_nonce'] ) ) : '';
		if ( ! wp_verify_nonce( $nonce, 'wpte-delete-nonce' ) ) {
			return esc_html__( 'Nonce Varification Failed!', 'wpte-product-layout' );
		}

		$id = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : '';
		wpte_delete_layout( $id );
		exit;
	}

	/**
	 * Method wpte_editor_update_form
	 *
	 * @return mixed
	 */
	public function wpte_editor_update_form() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$nonce = isset( $_REQUEST['_nonce'] ) && '' !== $_REQUEST['_nonce'] ? sanitize_text_field( wp_unslash( $_REQUEST['_nonce'] ) ) : '';
		if ( ! wp_verify_nonce( $nonce, 'wpte-editor-update-nonce' ) ) {
			return esc_html__( 'Nonce Varification Failed!', 'wpte-product-layout' );
		}

		$id       = isset( $_POST['wpteid'] ) ? intval( $_POST['wpteid'] ) : '';
		$rawdatas = ! empty( $_POST['rawdata'] ) && is_array( $_POST['rawdata'] ) ? filter_input( INPUT_POST, 'rawdata', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY ) : [];
		$rawdata  = [];
		foreach ( $rawdatas as $rawdata_val ) {
			if ( strpos( $rawdata_val['name'], '[]' ) !== false ) {
				$name = str_replace( '[]', '', $rawdata_val['name'] );
				$rawdata[ $name ][] = $rawdata_val['value'];
			} else {
				$name = $rawdata_val['name'];
				$rawdata[ $name ] = $rawdata_val['value'];
			}
		}
		$rawdata  = $rawdata ? wp_json_encode( $rawdata ) : '';
		$settings = json_decode( $rawdata, true );
		wpte_layout_update( $id, $rawdata );

		global $wpdb;
		$db_data   = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'wpte_product_layout_style WHERE id = %d', $id ), ARRAY_A );
		$StyleName = explode( '-', ucfirst( $db_data['style_name'] ) );
		$cls       = '\WPTE_PRODUCT_LAYOUT\Layouts\\' . $StyleName[0] . '\Backend\Layout' . $StyleName[1];

		if ( class_exists( $cls ) ) {
			$CLAS = new $cls( 'admin' );
		}

		return $CLAS->template_css_render( $id, $settings );
	}

	/**
	 * Method wpte_w_get_productc
	 *
	 * @return mixed.
	 */
	public function wpte_w_get_productc() {

		$nonce = isset( $_REQUEST['_nonce'] ) && '' !== $_REQUEST['_nonce'] ? sanitize_text_field( wp_unslash( $_REQUEST['_nonce'] ) ) : '';
		if ( ! wp_verify_nonce( $nonce, 'wpte-editor-update-nonce' ) ) {
			return esc_html__( 'Nonce Varification Failed!', 'wpte-product-layout' );
		}

		global $wpdb;
		$id        = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : '';
		$rawdatas  = ! empty( $_POST['rawdata'] ) && is_array( $_POST['rawdata'] ) ? filter_input( INPUT_POST, 'rawdata', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY ) : [];
		$rawdata   = [];
		foreach ( $rawdatas as $rawdata_val ) {
			if ( strpos( $rawdata_val['name'], '[]' ) !== false ) {
				$name = str_replace( '[]', '', $rawdata_val['name'] );
				$rawdata[ $name ][] = $rawdata_val['value'];
			} else {
				$name = $rawdata_val['name'];
				$rawdata[ $name ] = $rawdata_val['value'];
			}
		}
		$rawdata   = $rawdata ? wp_json_encode( $rawdata ) : '';
		$settings  = json_decode( $rawdata, true );
		$user      = 'admin';
		$db_data   = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'wpte_product_layout_style WHERE id = %d ', $id ), ARRAY_A );
		$StyleName = explode( '-', ucfirst( $db_data['style_name'] ) );

		$cls = '\WPTE_PRODUCT_LAYOUT\Layouts\\' . $StyleName[0] . '\Frontend\Layout' . $StyleName[1];

		if ( class_exists( $cls ) ) {
			$clas = new $cls( [], $user );
		}

		$clas->layout_render( $settings, $user );

		if ( wpte_version_control() ) {
			$pagination_load_more = ( isset( $settings['wpte_product_layout_pagination_global_display'] ) && $settings['wpte_product_layout_pagination_global_display'] ) ? $settings['wpte_product_layout_pagination_global_display'] : '';
			if ( 'pagination' === $pagination_load_more ) {
				echo '<div class="wpte-product-paginations">';
				$clas->wpte_products_pagination_render( $settings, 1, $id );
				echo '</div>';
			}
			if ( 'load_more' === $pagination_load_more ) {
				printf( '<div class="wpte-product-load-more">' );
				$clas->wpte_products_load_more_render( $settings, $id );
				echo '</div>';
			}
		}
		die();
	}

	/**
	 * Method wpte_shortcode_update_name
	 *
	 * @return mixed
	 */
	public function wpte_shortcode_update_name() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$nonce = isset( $_REQUEST['_nonce'] ) && '' !== $_REQUEST['_nonce'] ? sanitize_text_field( wp_unslash( $_REQUEST['_nonce'] ) ) : '';
		if ( ! wp_verify_nonce( $nonce, 'wpte-editor-update-nonce' ) ) {
			return esc_html__( 'Nonce Varification Failed!', 'wpte-product-layout' );
		}

		$id   = isset( $_POST['wpteid'] ) && $_POST['wpteid'] !== '' ? intval( $_POST['wpteid'] ) : '';
		$data = isset( $_POST['rawdata'] ) && $_POST['rawdata'] !== '' ? sanitize_text_field( wp_unslash( $_POST['rawdata'] ) ) : '';

		wpte_shortcode_name_update( $id, $data );
		exit;
	}

	/**
	 * Generate safe path
	 *
	 * @param mixed $path .
	 * @since v1.0.0
	 */
	public function safe_path( $path ) {

		$path = str_replace( [ '//', '\\\\' ], [ '/', '\\' ], $path );
		return str_replace( [ '/', '\\' ], DIRECTORY_SEPARATOR, $path );
	}

	/**
	 * Shortcode Importer.
	 *
	 * @since v1.0.0
	 */
	public function wpte_shortcode_import_layout() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$nonce = isset( $_REQUEST['_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_nonce'] ) ) : '';

		if ( ! wp_verify_nonce( $nonce, 'wpte-import-nonce' ) ) {
			echo esc_html__( 'You do not have sufficient permissions to access this page.', 'wpte-product-layout' );
			exit;
		}

		$filename = ! empty( $_FILES['file']['name'] ) ? sanitize_file_name( wp_unslash( $_FILES['file']['name'] ) ) : '';
		$folder   = $this->safe_path( WPTE_WPL_PATH . 'assets/export/' );
		if ( ! is_dir( $folder ) ) :
			mkdir( $folder, 0777 );
		endif;
		if ( is_file( $folder . $filename ) ) :
			unlink( $folder . $filename ); // delete file.
		endif;
		$uploaded_file_path = isset( $_FILES['file']['tmp_name'] ) ? filter_var( $_FILES['file']['tmp_name'], FILTER_SANITIZE_SPECIAL_CHARS ) : '';
		$files              = isset( $_FILES['file']['tmp_name'] ) ? $uploaded_file_path : '';
		move_uploaded_file( $files, $folder . $filename );

		$this->wpte_file_extract( $folder, $filename );
	}

	/**
	 * Import File extractor & insert.
	 *
	 * @param mixed $folder  .
	 * @param mixed $filename  .
	 * @since v1.0.0
	 */
	public function wpte_file_extract( $folder, $filename ) {

		if ( is_file( $folder . $filename ) ) {
			$FileData = file_get_contents( $folder . $filename );
			$params   = json_decode( $FileData, true );

			$name        = isset( $params['style']['name'] ) ? sanitize_text_field( $params['style']['name'] ) : '';
			$style_name  = isset( $params['style']['style_name'] ) ? sanitize_text_field( $params['style']['style_name'] ) : '';
			$rawdata     = isset( $params['style']['rawdata'] ) ? stripslashes( sanitize_text_field( $params['style']['rawdata'] ) ) : '';
			$stylesheet  = isset( $params['style']['stylesheet'] ) ? sanitize_text_field( $params['style']['stylesheet'] ) : '';
			$font_family = isset( $params['style']['font_family'] ) ? sanitize_text_field( $params['style']['font_family'] ) : '';

			if ( ! $style_name && ! $rawdata && ! $stylesheet ) {
				if ( is_file( $folder . $filename ) ) :
					unlink( $folder . $filename ); // delete file.
				endif;
				wp_send_json_success(
                    [
						'failed' => __( 'Invalid JSON File! Please import a exported valid JSON file.', 'wpte-product-layout' ),
					]
                );
				return;
			}

			$insert_id = wpte_layout_insert(
                [
					'name'        => $name,
					'style_name'  => $style_name,
					'rawdata'     => $rawdata,
					'stylesheet'  => $stylesheet,
					'font_family' => $font_family,
				]
            );

			$names       = [];
			$is_match    = preg_match_all( '/(wpte-product-layout-wrapper-)[0-9]+/', $stylesheet, $names );
			$replaceData = "wpte-product-layout-wrapper-$insert_id";
			$get_match   = $names[0][0];
			$finalData   = preg_replace( "/$get_match/i", $replaceData, $stylesheet );
			wpte_layout_update_style( $insert_id, $finalData );

			if ( is_file( $folder . $filename ) ) :
				unlink( $folder . $filename ); // delete file.
			endif;

			wp_send_json_success(
                [
					'url' => $this->url_conveter( [ $style_name, $insert_id ] ),
				]
            );

			if ( is_wp_error( $insert_id ) ) {
				wp_send_json_error(
                    [
						'message' => __( 'Data Insert Failed Please retry again!', 'wpte-product-layout' ),
					]
                );
			}
		}
	}

	/**
	 * Get layout for clone.
	 *
	 * @since v1.0.0
	 */
	public function wpte_clone_layout() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$nonce = isset( $_REQUEST['_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_nonce'] ) ) : '';
		if ( ! wp_verify_nonce( $nonce, 'wpte-new-create-nonce' ) ) {
			return esc_html__( 'Nonce Varification Failed!', 'wpte-product-layout' );
		}

		$id         = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : '';
		$db_data    = wpte_get_layout( $id );
		$db_dataArr = json_decode( wp_json_encode( $db_data ), true );
		$arrgg      = [ 'style' => $db_dataArr ];
		$JsonData   = wp_json_encode( $arrgg );
		print_r( $JsonData );
		exit;
	}

	/**
	 * Save Settings.
	 *
	 * @since v1.0.0
	 */
	public function wpte_settings_form() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$nonce = isset( $_REQUEST['_nonce'] ) && '' !== $_REQUEST['_nonce'] ? sanitize_text_field( wp_unslash( $_REQUEST['_nonce'] ) ) : '';
		if ( ! wp_verify_nonce( $nonce, 'wpte-settings-nonce' ) ) {
			return esc_html__( 'Nonce Varification Failed!', 'wpte-product-layout' );
		}

		$items = isset( $_POST['data'] ) && $_POST['data'] ? filter_input( INPUT_POST, 'data', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY ) : [];

		$data = [];

		foreach ( $items as $item ) {
			$data[ $item['name'] ] = $item['value'];
		}

		update_option( 'wpte_pl_settings', $data );

		wp_send_json_success(
            [
				'message' => esc_html__( 'Settings Saved', 'wpte-product-layout' ),
			]
        );
	}
}
