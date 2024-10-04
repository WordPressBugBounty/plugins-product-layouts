<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin\Pages;

/**
 * Settings Class
 *
 * @since 1.0.0
 */
class Settings {

	/**
	 * Settings Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->wpte_settings_form();
	}

	/**
	 * Settings Form
	 *
	 * @since 1.0.0
	 */
	public function wpte_settings_form() {
		$wpte_pl_settings = get_option( 'wpte_pl_settings' ) ? get_option( 'wpte_pl_settings' ) : [];

		$google_font_checked           = isset( $wpte_pl_settings['wpte_google_font'] ) && $wpte_pl_settings['wpte_google_font'] === 'no' ? 'checked' : '';
		$wpte_settings_ctg_selected    = isset( $wpte_pl_settings['wpte-settings-category-select'] ) && $wpte_pl_settings['wpte-settings-category-select'] ? $wpte_pl_settings['wpte-settings-category-select'] : '';
		$wpte_settings_filter_selected = isset( $wpte_pl_settings['wpte-settings-filter-select'] ) && $wpte_pl_settings['wpte-settings-filter-select'] ? $wpte_pl_settings['wpte-settings-filter-select'] : '';

		$shortcodes        = wpte_get_shortcode_list();
		$filter_shortcodes = wpte_get_filter_shortcode_list();
		$is_po             = wpte_version_control() ? '' : 'settings-pre-check wpte-po-element';
		?>
		<form id="wpte-settings-form" action="" method="post">
			<div class="wpte-pl-tabs">
				<ul class="wpte-pl-tab-button">
					<li class="btn active"><a href="#general"><i class="demo-icon icon-general"></i> <?php echo esc_html__('General Settings', 'wc-thank-you-page'); ?></a></li>
					<li class="btn"><a href="#archive-page"><i class="demo-icon icon-code"></i> <?php echo esc_html__('Archive Page', 'wc-thank-you-page'); ?></a></li>
				</ul>
				<button class="wpte-settings-save-button" type="submit"><span class="wpte-setting-btn-loader dashicons dashicons-yes"></span> <span class="wpte-setting-btn-text">Save Changes</span></button>
				<div class="wpte-pl-tab-content">
					<div id="general" class="tab-item active">
						<h2> <i class="demo-icon icon-general"></i> <?php echo esc_html__('General Settings', 'wc-thank-you-page'); ?></h2>
						<div class="wpte-pl-tab-content">
							<div class="wpte-setting-table-card">
								<div class="wpte-setting-card-title">
									<h2><?php echo esc_html__( 'Google Font Support', 'wpte-product-layout' ); ?></h2>
								</div>
								<div class="wpte-setting-card-content">
									<div class="wpte-setting-field-label">
										<h4><?php echo esc_html__( 'Google Font', 'wpte-product-layout' ); ?></h4>
										<div class="wpte-pl_tooltip">
											<span class="wpte-pl_tooltip_content"><?php echo esc_html__('Load Google Font CSS at shortcode loading, If your theme already loaded, select No.', 'wpte-product-layout' ); ?></span>
										</div>
									</div>
									<div class="wpte-setting-switch">
										<input type="radio" class="radio" id="wpte_google_font_yes" name="wpte_google_font" value="yes" <?php echo ( $google_font_checked ? '' : 'checked' ); ?> >
										<label for="wpte_google_font_yes"><?php echo esc_html__( 'Yes', 'wpte-product-layout' ); ?></label>
										<input type="radio" class="radio" id="wpte_google_font_no" name="wpte_google_font" value="no" <?php echo esc_html( $google_font_checked ); ?>>
										<label for="wpte_google_font_no"><?php echo esc_html__('No', 'wpte-product-layout' ); ?></label>
										<span class="wpte_goggle_font_loader dashicons"></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="archive-page" class="tab-item">
						<h2> <i class="demo-icon icon-code"></i>  <?php echo esc_html__('Archive Page', 'wc-thank-you-page'); ?></h2>
						<div class="wpte-pl-tab-content">
							<div class="wpte-setting-table-card <?php echo esc_attr( $is_po ); ?>">
								<div class="wpte-setting-card-title">
									<h2><?php echo esc_html__( 'Category Page', 'wpte-product-layout' ); ?></h2>
								</div>
								<div class="wpte-setting-card-content">
									<div class="wpte-setting-field-label">
										<h4><?php echo esc_html__( 'Category Page', 'wpte-product-layout' ); ?></h4>
										<div class="wpte-pl_tooltip">
											<span class="wpte-pl_tooltip_content"><?php echo esc_html__('Select shortcode to change category page layout design.', 'wpte-product-layout' ); ?></span>
										</div>
									</div>
									<select name="wpte-settings-category-select" id="wpte-settings-category-select">
										<option value="">--Select--</option>
										<?php
										foreach( $shortcodes as $id => $shortcode ) {
											$selected = intval( $wpte_settings_ctg_selected ) === intval( $id ) ? 'selected' : '';
											printf( "<option value='%s' %s>%s</option>", $id, $selected, $shortcode );
										}
										?>
									</select>
								</div>
								<div class="wpte-setting-card-content">
									<div class="wpte-setting-field-label">
										<h4><?php echo esc_html__( 'Filter', 'wpte-product-layout' ); ?></h4>
										<div class="wpte-pl_tooltip">
											<span class="wpte-pl_tooltip_content"><?php echo esc_html__('Select filter shortcode to add filter in the category page.', 'wpte-product-layout' ); ?></span>
										</div>
									</div>
									<select name="wpte-settings-filter-select" id="wpte-settings-filter-select">
										<option value="">--Select--</option>
										<?php
										foreach( $filter_shortcodes as $id => $shortcode ) {
											$selected = intval( $wpte_settings_filter_selected ) === intval( $id ) ? 'selected' : '';
											printf( "<option value='%s' %s>%s</option>", $id, $selected, $shortcode );
										}
										?>
									</select>
								</div>
								<div class="wpte-setting-card-content">
									<div class="wpte-setting-field-label">
										<h4><?php echo esc_html__( 'Shortcode', 'wpte-product-layout' ); ?></h4>
										<div class="wpte-pl_tooltip">
											<span class="wpte-pl_tooltip_content"><?php echo esc_html__('Use this shortcode in the category page. This shortcode only works in the category page. You can only use this shortcode if you design category page usign any page builder ( elementor, divi, etc ) or code.', 'wpte-product-layout' ); ?></span>
										</div>
									</div>
									<input class="wpte-settings-shortcode-input-field" type="text" onclick="this.setSelectionRange(0, this.value.length)" value="[wpte_product_layout_for_category_page]">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
		<div id="wpte-offer-modal"></div>
		<?php
	}
}
