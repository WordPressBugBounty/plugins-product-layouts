<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ajax Handler Class
 */
class Ajax
{

	/**
	 * Method __construct
	 *
	 * @return void
	 */
	public function __construct()
	{

		add_action('wp_ajax_wpte_create_new_layout', [$this, 'wpte_create_new_layout']);
		add_action('wp_ajax_wpte_editor_update_form', [$this, 'wpte_editor_update_form']);
		add_action('wp_ajax_wpte_get_productc', [$this, 'wpte_w_get_productc']);
		add_action('wp_ajax_wpte_delete_shortcode', [$this, 'wpte_delete_shortcodes']);
		add_action('wp_ajax_wpte_shortcode_update_name', [$this, 'wpte_shortcode_update_name']);
		add_action('wp_ajax_wpte_shortcode_import_layout', [$this, 'wpte_shortcode_import_layout']);
		add_action('wp_ajax_wpte_clone_layout', [$this, 'wpte_clone_layout']);
		add_action('wp_ajax_wpte_settings_form', [$this, 'wpte_settings_form']);
		add_action('wp_ajax_wpte_delete_data_on_uninstall', [$this, 'wpte_delete_data_on_uninstall']);
		add_action('wp_ajax_wpte_delete_all_data', [$this, 'wpte_delete_all_data']);
		add_action('wp_ajax_wpte_preview_frame', [$this, 'wpte_preview_frame']);
		add_action('wp_ajax_wpte_review_notice', [Notice::class, 'dismiss_review_notice']);
	}

	/**
	 * Method url_conveter
	 *
	 * @param array $args .
	 * @return string.
	 */
	public function url_conveter($args = [])
	{
		$layoutName = explode('-', $args[0]);
		return admin_url('admin.php?page=product-layouts&layouts=' . $layoutName[0] . '&styleid=' . $args[1]);
	}

	/**
	 * Method wpte_create_new_layout
	 *
	 * @return mixed
	 */
	public function wpte_create_new_layout()
	{

		if (! current_user_can('manage_options')) {
			return;
		}

		$nonce = isset($_REQUEST['_nonce']) && '' !== $_REQUEST['_nonce'] ? sanitize_text_field(wp_unslash($_REQUEST['_nonce'])) : '';
		if (! wp_verify_nonce($nonce, 'wpte-new-create-nonce')) {
			return esc_html__('Nonce Varification Failed!', 'product-layouts');
		}

		$name        = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
		$style_name  = isset($_POST['style_name']) ? sanitize_text_field(wp_unslash($_POST['style_name'])) : '';
		$rawdata     = isset($_POST['rawdata']) ? stripslashes(sanitize_text_field(wp_unslash($_POST['rawdata']))) : '';
		$stylesheet  = isset($_POST['stylesheet']) ? sanitize_text_field(wp_unslash($_POST['stylesheet'])) : '';
		$font_family = sanitize_text_field('');

		$insert_id = wpte_layout_insert(
			[
				'name'        => $name,
				'style_name'  => $style_name,
				'rawdata'     => $rawdata,
				'stylesheet'  => $stylesheet,
				'font_family' => $font_family,
			]
		);

		wpte_layout_update_style($insert_id, $this->wrapper_for($stylesheet, $insert_id));

		wp_send_json_success(
			[
				'url' => $this->url_conveter([$style_name, $insert_id]),
			]
		);

		if (is_wp_error($insert_id)) {
			wp_send_json_error(
				[
					'message' => __('Data Insert Failed Please retry again!', 'product-layouts'),
				]
			);
		}
	}

	/**
	 * Method wpte_delete_shortcodes.
	 *
	 * @return mixed
	 */
	public function wpte_delete_shortcodes()
	{

		if (! current_user_can('manage_options')) {
			return;
		}

		$nonce = isset($_REQUEST['_nonce']) && '' !== $_REQUEST['_nonce'] ? sanitize_text_field(wp_unslash($_REQUEST['_nonce'])) : '';
		if (! wp_verify_nonce($nonce, 'wpte-delete-nonce')) {
			return esc_html__('Nonce Varification Failed!', 'product-layouts');
		}

		$id = isset($_POST['id']) ? intval($_POST['id']) : '';
		wpte_delete_layout($id);
		exit;
	}

	/**
	 * Method wpte_editor_update_form
	 *
	 * @return mixed
	 */
	public function wpte_editor_update_form()
	{

		if (! current_user_can('manage_options')) {
			return;
		}

		$nonce = isset($_REQUEST['_nonce']) && '' !== $_REQUEST['_nonce'] ? sanitize_text_field(wp_unslash($_REQUEST['_nonce'])) : '';
		if (! wp_verify_nonce($nonce, 'wpte-editor-update-nonce')) {
			return esc_html__('Nonce Varification Failed!', 'product-layouts');
		}

		$id       = isset($_POST['wpteid']) ? intval($_POST['wpteid']) : '';
		$rawdatas = ! empty($_POST['rawdata']) && is_array($_POST['rawdata']) ? filter_input(INPUT_POST, 'rawdata', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY) : [];
		$rawdata  = [];
		foreach ($rawdatas as $rawdata_val) {
			if (strpos($rawdata_val['name'], '[]') !== false) {
				$name = str_replace('[]', '', $rawdata_val['name']);
				$rawdata[$name][] = $rawdata_val['value'];
			} else {
				$name = $rawdata_val['name'];
				$rawdata[$name] = $rawdata_val['value'];
			}
		}
		$rawdata  = $rawdata ? wp_json_encode($rawdata) : '';
		$settings = json_decode($rawdata, true);
		wpte_layout_update($id, $rawdata);

		global $wpdb;
		$db_data   = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'wpte_product_layout_style WHERE id = %d', $id), ARRAY_A);
		$StyleName = explode('-', ucfirst($db_data['style_name']));
		$cls       = '\WPTE_PRODUCT_LAYOUT\Layouts\\' . $StyleName[0] . '\Backend\Layout' . $StyleName[1];

		if (class_exists($cls)) {
			$CLAS = new $cls('admin');
		}

		return $CLAS->template_css_render($id, $settings);
	}

	/**
	 * Method wpte_w_get_productc
	 *
	 * @return mixed.
	 */
	public function wpte_w_get_productc()
	{

		if (! current_user_can('manage_options')) {
			return;
		}

		$nonce =isset($_REQUEST['_nonce']) && '' !== $_REQUEST['_nonce'] ? sanitize_text_field(wp_unslash($_REQUEST['_nonce'])) : '';
		if (! wp_verify_nonce($nonce, 'wpte-editor-update-nonce')) {
			return esc_html__('Nonce Varification Failed!', 'product-layouts');
		}

		global $wpdb;
		$id        = isset($_POST['id']) ? intval($_POST['id']) : '';
		$rawdatas  = ! empty($_POST['rawdata']) && is_array($_POST['rawdata']) ? filter_input(INPUT_POST, 'rawdata', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY) : [];
		$rawdata   = [];
		foreach ($rawdatas as $rawdata_val) {
			if (strpos($rawdata_val['name'], '[]') !== false) {
				$name = str_replace('[]', '', $rawdata_val['name']);
				$rawdata[$name][] = $rawdata_val['value'];
			} else {
				$name = $rawdata_val['name'];
				$rawdata[$name] = $rawdata_val['value'];
			}
		}
		$rawdata   = $rawdata ? wp_json_encode($rawdata) : '';
		$settings  = json_decode($rawdata, true);
		$user      = 'admin';
		$db_data   = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'wpte_product_layout_style WHERE id = %d ', $id), ARRAY_A);
		$StyleName = explode('-', ucfirst($db_data['style_name']));

		$cls = '\WPTE_PRODUCT_LAYOUT\Layouts\\' . $StyleName[0] . '\Frontend\Layout' . $StyleName[1];

		if (class_exists($cls)) {
			$clas = new $cls([], $user);
		}

		$clas->layout_render($settings, $user);

		if (wpte_version_control()) {
			$pagination_load_more = (isset($settings['wpte_product_layout_pagination_global_display']) && $settings['wpte_product_layout_pagination_global_display']) ? $settings['wpte_product_layout_pagination_global_display'] : '';
			if ('pagination' === $pagination_load_more) {
				echo '<div class="wpte-product-paginations">';
				$clas->wpte_products_pagination_render($settings, 1, $id);
				echo '</div>';
			}
			if ('load_more' === $pagination_load_more) {
				printf('<div class="wpte-product-load-more">');
				$clas->wpte_products_load_more_render($settings, $id);
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
	public function wpte_shortcode_update_name()
	{

		if (! current_user_can('manage_options')) {
			return;
		}

		$nonce = isset($_REQUEST['_nonce']) && '' !== $_REQUEST['_nonce'] ? sanitize_text_field(wp_unslash($_REQUEST['_nonce'])) : '';
		if (! wp_verify_nonce($nonce, 'wpte-editor-update-nonce')) {
			return esc_html__('Nonce Varification Failed!', 'product-layouts');
		}

		$id   = isset($_POST['wpteid']) && $_POST['wpteid'] !== '' ? intval($_POST['wpteid']) : '';
		$data = isset($_POST['rawdata']) && $_POST['rawdata'] !== '' ? sanitize_text_field(wp_unslash($_POST['rawdata'])) : '';

		wpte_shortcode_name_update($id, $data);
		exit;
	}

	/**
	 * Generate safe path
	 *
	 * @param mixed $path .
	 * @since v1.0.0
	 */
	public function safe_path($path)
	{

		$path = str_replace(['//', '\\\\'], ['/', '\\'], $path);
		return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
	}

	/**
	 * Shortcode Importer.
	 *
	 * @since v1.0.0
	 */
	public function wpte_shortcode_import_layout()
	{
		if (! current_user_can('manage_options')) {
			return;
		}

		$nonce = isset($_REQUEST['_nonce']) ? sanitize_text_field(wp_unslash($_REQUEST['_nonce'])) : '';

		if (! wp_verify_nonce($nonce, 'wpte-import-nonce')) {
			echo esc_html__('You do not have sufficient permissions to access this page.', 'product-layouts');
			exit;
		}

		// Read the upload straight from PHP's temporary file. Before 1.4.6 it was
		// first moved into the plugin's public assets/export/ folder under its own
		// name, which left any uploaded file reachable from the web.
		// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- a server-side temp path, checked with is_uploaded_file().
		$tmp_name = isset($_FILES['file']['tmp_name']) && is_string($_FILES['file']['tmp_name']) ? $_FILES['file']['tmp_name'] : '';
		$FileData = '' !== $tmp_name && is_uploaded_file($tmp_name) ? file_get_contents($tmp_name) : '';

		$this->wpte_import_json((string) $FileData);
	}


	/**
	 * Creates a layout from an exported JSON file's contents.
	 *
	 * @param string $FileData File contents.
	 * @since 1.4.6
	 */
	public function wpte_import_json($FileData)
	{
		$params = json_decode($FileData, true);
		$style  = is_array($params) && isset($params['style']) && is_array($params['style']) ? $params['style'] : [];

		$name        = isset($style['name']) && is_scalar($style['name']) ? sanitize_text_field($style['name']) : '';
		$style_name  = isset($style['style_name']) && is_scalar($style['style_name']) ? sanitize_text_field($style['style_name']) : '';
		$rawdata     = isset($style['rawdata']) && is_scalar($style['rawdata']) ? stripslashes(sanitize_text_field($style['rawdata'])) : '';
		$stylesheet  = isset($style['stylesheet']) && is_scalar($style['stylesheet']) ? sanitize_text_field($style['stylesheet']) : '';
		$font_family = isset($style['font_family']) && is_scalar($style['font_family']) ? sanitize_text_field($style['font_family']) : '';

		if (! $style_name && ! $rawdata && ! $stylesheet) {
			wp_send_json_success(
				[
					'failed' => __('Invalid JSON File! Please import a exported valid JSON file.', 'product-layouts'),
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

		wpte_layout_update_style($insert_id, $this->wrapper_for($stylesheet, $insert_id));

		wp_send_json_success(
			[
				'url' => $this->url_conveter([$style_name, $insert_id]),
			]
		);
	}

	/**
	 * Points a layout's CSS at its new id (wpte-product-layout-wrapper-N).
	 *
	 * Before 1.4.6, CSS without that class was replaced with an empty pattern,
	 * which pasted the class name between every character.
	 *
	 * @param string $stylesheet Layout CSS.
	 * @param int    $id         New layout id.
	 * @return string
	 * @since 1.4.6
	 */
	private function wrapper_for($stylesheet, $id)
	{
		if (! preg_match('/wpte-product-layout-wrapper-[0-9]+/', $stylesheet, $match)) {
			return $stylesheet;
		}
		return preg_replace('/' . preg_quote($match[0], '/') . '/i', 'wpte-product-layout-wrapper-' . (int) $id, $stylesheet);
	}

	/**
	 * Get layout for clone.
	 *
	 * @since v1.0.0
	 */
	public function wpte_clone_layout()
	{

		if (! current_user_can('manage_options')) {
			return;
		}

		$nonce = isset($_REQUEST['_nonce']) ? sanitize_text_field(wp_unslash($_REQUEST['_nonce'])) : '';
		if (! wp_verify_nonce($nonce, 'wpte-new-create-nonce')) {
			return esc_html__('Nonce Varification Failed!', 'product-layouts');
		}

		$id         = isset($_POST['id']) ? intval($_POST['id']) : '';
		$db_data    = wpte_get_layout($id);
		$db_dataArr = json_decode(wp_json_encode($db_data), true);
		$arrgg      = ['style' => $db_dataArr];
		$JsonData   = wp_json_encode($arrgg);
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r
		print_r($JsonData);
		exit;
	}

	/**
	 * Save Settings.
	 *
	 * @since v1.0.0
	 */
	public function wpte_settings_form()
	{

		if (! current_user_can('manage_options')) {
			return;
		}

		$nonce = isset($_REQUEST['_nonce']) && '' !== $_REQUEST['_nonce'] ? sanitize_text_field(wp_unslash($_REQUEST['_nonce'])) : '';
		if (! wp_verify_nonce($nonce, 'wpte-settings-nonce')) {
			return esc_html__('Nonce Varification Failed!', 'product-layouts');
		}

		// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash,WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$items = isset($_POST['data']) && $_POST['data']
			? filter_input(INPUT_POST, 'data', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY)
			: [];

		$data = [];

		foreach ($items as $item) {
			$data[$item['name']] = $item['value'];
		}

		update_option('wpte_pl_settings', $data);

		wp_send_json_success(
			[
				'message' => esc_html__('Settings Saved', 'product-layouts'),
			]
		);
	}

	/**
	 * Danger zone: delete all data when the plugin is deleted.
	 *
	 * @since 1.4.5
	 */
	public function wpte_delete_data_on_uninstall()
	{
		if (! current_user_can('manage_options') || ! check_ajax_referer('wpte-settings-nonce', '_nonce', false)) {
			wp_send_json_error(null, 403);
		}
		$value = isset($_POST['value']) && 'yes' === $_POST['value'] ? 'yes' : 'no';
		update_option(\WPTE_PRODUCT_LAYOUT\Includes\Data_Cleaner::UNINSTALL_OPTION, $value, false);
		wp_send_json_success();
	}

	/**
	 * Danger zone: delete every layout and setting right now.
	 *
	 * The typed confirmation is checked here too, not only in the browser.
	 *
	 * @since 1.4.5
	 */
	public function wpte_delete_all_data()
	{
		if (! current_user_can('manage_options') || ! check_ajax_referer('wpte-settings-nonce', '_nonce', false)) {
			wp_send_json_error(null, 403);
		}
		if (! isset($_POST['confirm']) || 'DELETE' !== $_POST['confirm']) {
			wp_send_json_error(null, 400);
		}
		\WPTE_PRODUCT_LAYOUT\Includes\Data_Cleaner::delete_now();
		wp_send_json_success();
	}

	/**
	 * Preview Frame Handler
	 * Renders the iframe preview template
	 *
	 * @since 1.3.7
	 */
	public function wpte_preview_frame()
	{
		if (! current_user_can('manage_options')) {
			wp_die(esc_html__('You do not have permission to access this page.', 'product-layouts'));
		}

		// Load the preview frame template
		new Pages\PreviewFrame();
	}
}
