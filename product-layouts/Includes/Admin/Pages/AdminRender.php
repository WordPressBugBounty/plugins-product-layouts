<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin\Pages;

/**
 * AdminRender
 *
 * @since 1.0.0
 */
abstract class AdminRender
{

	use \WPTE_PRODUCT_LAYOUT\Includes\Helper\Helper;
	use \WPTE_PRODUCT_LAYOUT\Includes\Helper\Advanced;

	/**
	 * Wpteid
	 *
	 * @var $wpteid
	 * @since 1.0.0
	 */
	public $wpteid;

	/**
	 * Wpdb
	 *
	 * @var $wpdb
	 * @since 1.0.0
	 */
	public $wpdb;

	/**
	 * WP DB Table Name
	 *
	 * @var $wpte_table
	 * @since 1.0.0
	 */
	public $wpte_table;

	/**
	 * Dbdata
	 *
	 * @var $dbdata
	 * @since 1.0.0
	 */
	public $dbdata;

	/**
	 * Rawdata
	 *
	 * @var $rawdata
	 */
	public $rawdata;

	/**
	 * Style
	 *
	 * @var $style
	 */
	public $style = [];

	/**
	 * Current Elements Style name
	 *
	 * @var $StyleName
	 * @since 1.0.0
	 */
	public $StyleName;

	/**
	 * All Wrapper
	 *
	 * @var $WRAPPER
	 * @since 1.0.0
	 */
	public $WRAPPER;

	/**
	 * All CSS Wrapper
	 *
	 * @var $CSSWRAPPER
	 * @since 1.0.0
	 */
	public $CSSWRAPPER;

	/**
	 * All CSS Data
	 *
	 * @var $CSSDATA
	 * @since 1.0.0
	 */
	public $CSSDATA;

	/**
	 * Type
	 *
	 * @var $type
	 * @since 1.0.0
	 */
	public $type;

	/**
	 * Font
	 *
	 *  @var $font
	 * @since 1.0.0
	 */
	public $font;

	/**
	 * Method __construct
	 *
	 * @param string $type .
	 * @return void
	 */
	public function __construct($type = '')
	{

		global $wpdb;
		$this->wpdb       = $wpdb;
		$this->wpte_table = $wpdb->prefix . 'wpte_product_layout_style';
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$this->wpteid     = (! empty($_GET['styleid']) ? intval($_GET['styleid']) : 0);
		$this->WRAPPER    = '.wpte-product-layout-wrapper-' . $this->wpteid;
		$this->CSSWRAPPER = '.wpte-product-layout-wrapper-' . $this->wpteid . ' .wpte-product-row';
		$this->wpte_script_loader();
		$this->type = $type;
		if ($this->type != 'admin') {
			$this->wpte_db_data();
			$this->render();
		}
		new Layout_list\Export();
	}

	/**
	 * Method Hooks
	 *
	 * @return void
	 */
	public function wpte_db_data()
	{
		global $wpdb;
		$this->dbdata = $wpdb->get_row(
			$wpdb->prepare(
				'SELECT * FROM ' . $wpdb->prefix . 'wpte_product_layout_style WHERE id = %d ',
				$this->wpteid
			),
			ARRAY_A
		);
		$this->StyleName = explode('-', ucfirst($this->dbdata['style_name']));
		if (! empty($this->dbdata['rawdata'])) {
			$this->rawdata = json_decode($this->dbdata['rawdata'], true);
			if (is_array($this->rawdata)) {
				$this->style = $this->rawdata;
			}
		}
	}

	/**
	 * Method wpte_script_loader
	 *
	 * @return void
	 */
	public function wpte_script_loader()
	{

		// Js.
		wp_enqueue_script('wpte-serializejson');
		wp_enqueue_script('wpte-wpl-select2-js');
		wp_enqueue_script('wpte-nouislider');
		wp_enqueue_script('wpte-gradient-color');
		wp_enqueue_script('wpte-minicolors');
		wp_enqueue_script('jquery-ui-resizable');
		wp_enqueue_script('wpte-icon-picker');
		wp_enqueue_script('wpte-font-picker-js');
		wp_enqueue_script('wpte-global-js');
		wp_enqueue_script('wpte-condition-js');
		wp_enqueue_script('wpte-wpl-admin-js');
		wp_enqueue_script('wpte-wpl-editor');
		wp_enqueue_script('wpte-preview-controller');
		wp_enqueue_script('wpte-overlay-scrollbar');
		wp_enqueue_script('wpte-overlay-scrollbar-init', WPTE_WPL_ASSETS . 'lib/overlay-scrollbar/overlay-scrollbar.js', ['jquery', 'wpte-overlay-scrollbar'], filemtime(WPTE_WPL_PATH . 'assets/lib/overlay-scrollbar/overlay-scrollbar.js'), true);
		wp_localize_script(
			'wpte-wpl-editor',
			'wpteEditor',
			[
				'ajaxUrl'    => admin_url('admin-ajax.php'),
				'wpte_nonce' => wp_create_nonce('wpte-editor-update-nonce'),
				'error'      => __('Something Went Wrong!', 'product-layouts'),
			]
		);

		wp_localize_script(
			'wpte-global-js',
			'wpteGlobal',
			[
				'ajaxUrl'    => admin_url('admin-ajax.php'),
				'wpte_nonce' => wp_create_nonce('wpte-global-nonce'),
				'error'      => __('Something Went Wrong!', 'product-layouts'),
			]
		);

		$this->wpte_compare_script_loader();
		$this->wpte_quickview_script_loader();
	}

	/**
	 * Admin Compare script loader
	 *
	 * @since 1.0.1
	 */
	public function wpte_compare_script_loader()
	{
		wp_enqueue_script('wpte-product-compare');
	}

	/**
	 * Admin Quick view script loader
	 *
	 * @since 1.0.1
	 */
	public function wpte_quickview_script_loader()
	{
		if (version_compare(WC()->version, '3.0.0', '>=')) {
			if (current_theme_supports('wc-product-gallery-zoom')) {
				wp_enqueue_script('zoom');
			}
			if (current_theme_supports('wc-product-gallery-slider')) {
				wp_enqueue_script('flexslider');
			}
			wp_enqueue_script('wc-add-to-cart-variation');
			wp_enqueue_script('wc-single-product');
		}

		wp_enqueue_script('wpte-quick-view-js');
	}

	/**
	 * Template Register Control
	 * return always true and abstract with current Style Template
	 *
	 * @since 1.0.0
	 */
	public function register_controls()
	{
		return true;
	}

	/**
	 * Template CSS Render.
	 *
	 * @param int   $id .
	 * @param mixed $rawData .
	 * @since 1.0.0
	 */
	public function template_css_render($id, $rawData)
	{
		$styleid      = $id;
		$this->wpteid = $styleid;

		$this->WRAPPER    = '.wpte-product-layout-wrapper-' . $this->wpteid;
		$this->CSSWRAPPER = '.wpte-product-layout-wrapper-' . $this->wpteid . ' .wpte-product-row';
		$this->style      = $rawData;

		ob_start();
		$this->register_controls();
		$this->wpte_advanced_controlers();
		ob_end_clean();

		$fullcssfile = '';
		foreach ($this->CSSDATA as $key => $responsive) {
			$tempcss = '';
			foreach ($responsive as $class => $classes) {
				$tempcss .= $class . '{';
				foreach ($classes as $properties) {
					$tempcss .= $properties;
				}
				$tempcss .= '}';
			}
			if ($key === 'laptop') :
				$fullcssfile .= $tempcss;
			elseif ($key === 'tab') :
				$fullcssfile .= '@media only screen and (min-width : 669px) and (max-width : 993px){';
				$fullcssfile .= $tempcss;
				$fullcssfile .= '}';
			elseif ($key === 'mobile') :
				$fullcssfile .= '@media only screen and (max-width : 668px){';
				$fullcssfile .= $tempcss;
				$fullcssfile .= '}';
			endif;
		}
		$font = wp_json_encode($this->font);
		global $wpdb;
		$wpdb->query($wpdb->prepare('UPDATE ' . $wpdb->prefix . 'wpte_product_layout_style SET stylesheet = %s WHERE id = %d', $fullcssfile, $styleid));
		$wpdb->query($wpdb->prepare('UPDATE ' . $wpdb->prefix . 'wpte_product_layout_style SET font_family = %s WHERE id = %d', $font, $styleid));
		exit;
	}

	/**
	 * Method secondary_menut
	 *
	 * @return void
	 */
	public function secondary_menut()
	{
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$id = isset($_GET['styleid']) ? sanitize_text_field(wp_unslash($_GET['styleid'])) : '';
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$layouts = isset($_GET['layouts']) ? sanitize_text_field(wp_unslash($_GET['layouts'])) : '';
		$shortcode_name = wpte_get_layout($id) ? wpte_get_layout($id) : (object) [];
?>
		<div class="wpte-addons-header">
			<div class="wpte-addons-header-left">
				<a href="javascript:history.back()" class="wpte-btn-back">
					<i class="dashicons dashicons-arrow-left-alt2"></i> <?php esc_html_e('Back', 'product-layouts'); ?>
				</a>
				<a href="<?php echo esc_url(admin_url('admin.php?page=product-layouts')); ?>" class="wpte-btn-dashboard">
					<?php esc_html_e('Dashboard', 'product-layouts'); ?>
				</a>
				<a href="<?php echo esc_url(admin_url('admin.php?page=product-layouts-shortcode')); ?>" class="wpte-btn-dashboard">
					<?php esc_html_e('Shortcode List', 'product-layouts'); ?>
				</a>
			</div>
			<div class="wpte-addons-header-right">
				<?php if (wpte_version_control() !== true) : ?>
					<a href="https://product-layouts.com/pricing/" target="_blank" class="wpte-btn-upgrade">
						<?php esc_html_e('Upgrade', 'product-layouts'); ?>
					</a>
				<?php endif; ?>
				<a href="<?php echo esc_url(home_url()); ?>" target="_blank" class="wpte-btn-visit">
					<i class="dashicons dashicons-admin-site-alt3"></i> <?php esc_html_e('Visit Site', 'product-layouts'); ?>
				</a>
				<form method="post" id="wpte-shortcode-name-change-submit">
					<input type="hidden" name="addonsstylenameid" value="<?php echo esc_attr($id); ?>">
					<input type="text" class="wpte-header-name-input" name="addonsstylename" placeholder="<?php echo esc_attr__('Set Your Shortcode Name', 'product-layouts'); ?>" value="<?php echo isset($shortcode_name->name) ? esc_attr($shortcode_name->name) : ''; ?>">
					<button type="button" class="wpte-header-name-save-btn" id="addonsstylenamechange"><?php esc_html_e('Save', 'product-layouts'); ?></button>
				</form>
			</div>
		</div>
	<?php
	}

	/**
	 * Method wpte_editor_left_sidebar
	 *
	 * @return void
	 */
	public function wpte_editor_left_sidebar()
	{
	?>
		<aside id="wpte_setting_bar" data-visibale="true" class="ui-widget-content wpte-single-settings-card">
			<form id="wpte-editor-update-form" action="" method="POST">
				<div class="wpte-single-settings-card-header">
					<div class="wpte-settings-title"><?php echo esc_html__('Settings', 'product-layouts'); ?></div>
				</div>
				<div class="wpte-single-settings-card-body">
					<div class="wpte-single-settings-card-body-wrapper">
						<div class="wpte-single-settings-card-body-inner">
							<?php
							$this->register_controls();
							// phpcs:ignore WordPress.Security.NonceVerification.Recommended
							$product_layouts_page = isset($_GET['layouts']) && 'filter' !== $_GET['layouts'] ? true : false;
							if ($product_layouts_page) {
							?>
								<div class="wpte-layout-content-tabs" id="wpte-start-tabs-advanced">
									<?php echo esc_html($this->wpte_advanced_controlers()); ?>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="wpte-single-settings-card-footer">
					<input type="hidden" id="wpte-layouts-id" value="<?php echo esc_attr($this->wpteid); ?>">
					<button id="wpte-submit-editor-form" type="submit"><?php echo esc_html__('Save', 'product-layouts'); ?></button>
				</div>
			</form>
		</aside>
		<?php
	}

	/**
	 * Method wpte_single_layout_wraper
	 *
	 * @return mixed
	 */
	public function render()
	{
		$is_p = isset($this->rawdata['status_po']) && $this->rawdata['status_po'] ? $this->rawdata['status_po'] : '';
		if ('p' === $is_p) {
			if (wpte_version_control() !== true) {
		?>
				<div class="wpte-wpl-wrapper">
					<div class="wpte-wpl-row">
						<?php printf('<h1>%s</h1>', esc_html__('Opps! Please upgrade!', 'product-layouts')); ?>
					</div>
				</div>
		<?php
				return false;
			}
		}
		?>
		<?php $this->secondary_menut(); ?>
		
		<!-- Editor Preloader -->
		<div class="wpte-product-layouts-editor-preloader">
			<div class="wpte-product-layouts-editor-spinner"></div>
		</div>

		<div class="wpte-editor-page">
			<div class="wpte-editor-left-sidebar" id="wpte_setting_bar" data-visibale="true">
				<?php $this->wpte_editor_left_sidebar(); ?>
				<span class="wpte-sidebar-toggler"><i class="wpte-icon icon-arrow-6"></i></span>
			</div>
			<?php $this->wpte_singe_layout_preview(); ?>
		</div>
	<?php
	}

	/**
	 * Method wpte_singe_layout_preview
	 *
	 * @return void
	 */
	public function wpte_singe_layout_preview()
	{
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$id = isset($_GET['styleid']) ? sanitize_text_field(wp_unslash($_GET['styleid'])) : '';
	?>
		<div class="wpte-addons-Preview" id="wptepreviewreload">
			<div class="wpte-addons-wrapper">
				<div class="wpte-addons-style-left-preview">
					<div class="wpte-addons-style-left-preview-heading">
						<div class="wpte-preview-header-left">
							<div class="wpte-header-tooltip">
								<i class="dashicons dashicons-info" aria-hidden="true"></i>
								<span class="wpte-tooltip-text"><?php esc_html_e('Copy & paste the shortcode directly into any WordPress post, page or Page Builder.', 'product-layouts'); ?></span>
							</div>
							<div class="wpte-header-shortcode">
								<div class="wpte-shortcode-text">[wpte_product_layout id="<?php echo esc_attr($this->wpteid); ?>"]</div>
								<button type="button" class="wpte-copy-btn wpte-copy-shortcode" data-shortcode='[wpte_product_layout id="<?php echo esc_attr($this->wpteid); ?>"]'>
									<svg viewBox="64 64 896 896" focusable="false" data-icon="copy" width="1em" height="1em" fill="currentColor" aria-hidden="true">
										<path d="M832 64H296c-4.4 0-8 3.6-8 8v56c0 4.4 3.6 8 8 8h496v688c0 4.4 3.6 8 8 8h56c4.4 0 8-3.6 8-8V96c0-17.7-14.3-32-32-32zM704 192H192c-17.7 0-32 14.3-32 32v530.7c0 8.5 3.4 16.6 9.4 22.6l173.3 173.3c2.2 2.2 4.7 4 7.4 5.5v1.9h4.2c3.5 1.3 7.2 2 11 2H704c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32zM350 856.2L263.9 770H350v86.2zM664 888H414V746c0-22.1-17.9-40-40-40H232V264h432v624z"></path>
									</svg>
								</button>
							</div>
						</div>
						<div class="wpte-preview-header-center">
							<div class="wpte-header-devices" aria-label="Preview devices">
								<button class="wpte-device-btn wpte-form-responsive-switcher-desktop active" data-device="desktop" aria-label="Desktop preview">
									<svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true">
										<path d="M4 5h16a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-5v2h3a1 1 0 1 1 0 2H6a1 1 0 1 1 0-2h3v-2H4a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2zm0 2v9h16V7H4z"></path>
									</svg>
								</button>
								<button class="wpte-device-btn wpte-form-responsive-switcher-tablet" data-device="tablet" aria-label="Tablet preview">
									<svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true">
										<path d="M7 2h10a3 3 0 0 1 3 3v14a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3V5a3 3 0 0 1 3-3zm0 2a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1H7zm5 16a1.5 1.5 0 1 1 0 3a1.5 1.5 0 0 1 0-3z"></path>
									</svg>
								</button>
								<button class="wpte-device-btn wpte-form-responsive-switcher-mobile" data-device="mobile" aria-label="Mobile preview">
									<svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true">
										<path d="M8 2h8a3 3 0 0 1 3 3v14a3 3 0 0 1-3 3H8a3 3 0 0 1-3-3V5a3 3 0 0 1 3-3zm0 2a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1H8zm4 15a1.5 1.5 0 1 1 0 3a1.5 1.5 0 0 1 0-3z"></path>
									</svg>
								</button>
							</div>
						</div>
						<div class="wpte-preview-header-right">
							<?php $bg_color = isset($this->style['wpte-preview-bg-color']) ? $this->style['wpte-preview-bg-color'] : ''; ?>
							<input type="text" data-format="rgb" data-opacity="TRUE" class="wpte-addons-minicolor wpte-product-minicolor" id="wpte-preview-bg-color" name="wpte-preview-bg-color" value="<?php echo esc_attr($bg_color); ?>">
						</div>
					</div>
					<div class="wpte-preview-wrapper" id="wpte-preview-wrapper" data-device="desktop" template-wrapper="#wpte-product-layout-wrapper-<?php echo esc_attr($this->wpteid); ?>">
						<iframe
							id="wpte-preview-iframe"
							src="<?php echo esc_url(admin_url('admin-ajax.php?action=wpte_preview_frame&styleid=' . $this->wpteid)); ?>"
							frameborder="0"></iframe>
					</div>
				</div>
			</div>
			<div class="wpte-popup-display"></div>
		</div>
<?php
	}
}
