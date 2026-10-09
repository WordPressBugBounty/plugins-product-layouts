<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin\Pages;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Settings Class
 *
 * Every field saves on change through the wpte_settings_form AJAX action,
 * which replaces the whole "wpte_pl_settings" option, so settings.js always
 * sends every field together.
 *
 * @since 1.0.0
 */
class Settings {

	/**
	 * Pricing page, also behind "Upgrade" in the plugin header.
	 */
	const PRICING_URL = 'https://product-layouts.com/pricing/';

	/**
	 * Settings Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->wpte_settings_form();
	}

	/**
	 * Read the license state from Freemius.
	 *
	 * Wrapped defensively: a Freemius error must never break the settings page.
	 *
	 * @since 1.4.5
	 * @return array
	 */
	private function license_state() {
		$state = [
			'status'      => 'free',
			'plan'        => '',
			'expires'     => '',
			'key'         => '',
			'can_manage'  => false,
			'affix'       => '',
			'account_url' => '',
		];
		try {
			if ( function_exists( 'wpl_fs' ) ) {
				$fs      = wpl_fs();
				$license = $fs->_get_license();

				$state['can_manage'] = $fs->is_user_admin();
				$state['affix']      = $fs->get_unique_affix();
				$state['plan']       = $fs->get_plan_title();
				if ( $fs->is_registered() ) {
					$state['account_url'] = $fs->get_account_url();
				}

				if ( is_object( $license ) ) {
					$state['key']     = $license->get_html_escaped_masked_secret_key();
					$state['expires'] = $license->is_lifetime() ? '' : date_i18n( get_option( 'date_format' ), strtotime( $license->expiration ) );
				}

				if ( $fs->is_trial() ) {
					$state['status'] = 'trial';
				} elseif ( $fs->can_use_premium_code() ) {
					$state['status'] = 'active';
				} elseif ( is_object( $license ) && $license->is_expired() ) {
					$state['status'] = 'expired';
				}
			}
		} catch ( \Throwable $e ) {
			$state['can_manage'] = false;
		}
		return $state;
	}

	/**
	 * Card header.
	 *
	 * @param string $icon        Dashicons class suffix.
	 * @param string $title       Card title.
	 * @param string $description Card subtitle.
	 * @param string $extra       Optional markup after the title, already escaped.
	 */
	private function card_head( $icon, $title, $description, $extra = '' ) {
		?>
		<div class="wpte-wpl-set-card-head">
			<span class="wpte-wpl-set-card-icon dashicons dashicons-<?php echo esc_attr( $icon ); ?>" aria-hidden="true"></span>
			<div class="wpte-wpl-set-card-text">
				<h2 class="wpte-wpl-set-card-title"><?php echo esc_html( $title ); ?></h2>
				<p class="wpte-wpl-set-card-sub"><?php echo esc_html( $description ); ?></p>
			</div>
			<?php echo $extra; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built from escaped values by the caller. ?>
		</div>
		<?php
	}

	/**
	 * License card. Activate and Change open Freemius' own license dialog,
	 * which Freemius only prints on the Plugins screen, so it is added to
	 * this page's footer here.
	 *
	 * @since 1.4.5
	 */
	private function license_card() {
		$state  = $this->license_state();
		$status = $state['status'];

		$show_dialog = $state['can_manage'] && '' !== $state['affix'];
		if ( $show_dialog ) {
			add_action( 'admin_footer', [ wpl_fs(), '_add_license_activation_dialog_box' ] );
		}
		$trigger = 'activate-license-trigger ' . $state['affix'];

		$pills = [
			'free'    => __( 'Free plan', 'product-layouts' ),
			'trial'   => __( 'Trial', 'product-layouts' ),
			'active'  => __( 'Active', 'product-layouts' ),
			'expired' => __( 'Expired', 'product-layouts' ),
		];
		$pill  = '<span class="wpte-wpl-set-pill is-' . esc_attr( $status ) . '">' . esc_html( $pills[ $status ] ) . '</span>';
		?>
		<section class="wpte-wpl-set-card wpte-wpl-set-license is-<?php echo esc_attr( $status ); ?>" id="license">
			<?php $this->card_head( 'admin-network', __( 'License', 'product-layouts' ), __( 'Your Product Layouts Pro license for this site.', 'product-layouts' ), $pill ); ?>
			<div class="wpte-wpl-set-license-body">
				<?php if ( in_array( $status, [ 'active', 'trial', 'expired' ], true ) && ( '' !== $state['plan'] || '' !== $state['key'] ) ) : ?>
					<dl class="wpte-wpl-set-license-facts">
						<?php if ( '' !== $state['plan'] && 'expired' !== $status ) : ?>
							<div>
								<dt><?php esc_html_e( 'Plan', 'product-layouts' ); ?></dt>
								<dd><?php echo esc_html( $state['plan'] ); ?></dd>
							</div>
						<?php endif; ?>
						<?php if ( '' !== $state['key'] ) : ?>
							<div>
								<dt><?php echo esc_html( 'expired' === $status ? __( 'Expired on', 'product-layouts' ) : __( 'Expires', 'product-layouts' ) ); ?></dt>
								<dd><?php echo esc_html( '' !== $state['expires'] ? $state['expires'] : __( 'Never (lifetime)', 'product-layouts' ) ); ?></dd>
							</div>
							<div>
								<dt><?php esc_html_e( 'License key', 'product-layouts' ); ?></dt>
								<dd class="wpte-wpl-set-license-key"><?php echo wp_kses( $state['key'], [] ); ?></dd>
							</div>
						<?php endif; ?>
					</dl>
				<?php endif; ?>

				<p class="wpte-wpl-set-license-text">
					<?php
					if ( 'active' === $status ) :
						esc_html_e( 'Pro is active on this site. Thank you for supporting Product Layouts.', 'product-layouts' );
					elseif ( 'trial' === $status ) :
						esc_html_e( 'Your Pro trial is running. Activate a license key to keep Pro when the trial ends.', 'product-layouts' );
					elseif ( 'expired' === $status ) :
						esc_html_e( 'Your license has expired. Renew it to get Pro back on this site.', 'product-layouts' );
					elseif ( ! $state['can_manage'] ) :
						esc_html_e( 'Pro is not active on this site yet.', 'product-layouts' );
					else :
						esc_html_e( 'Bought Pro? Paste the license key from your purchase email to activate it here.', 'product-layouts' );
					endif;
					?>
				</p>

				<?php ob_start(); ?>
					<?php if ( $show_dialog ) : ?>
						<?php if ( 'active' === $status ) : ?>
							<a href="#" class="wpte-wpl-set-btn <?php echo esc_attr( $trigger ); ?>"><?php esc_html_e( 'Change license', 'product-layouts' ); ?></a>
						<?php else : ?>
							<a href="#" class="wpte-wpl-set-btn is-primary <?php echo esc_attr( $trigger ); ?>">
								<span class="dashicons dashicons-admin-network" aria-hidden="true"></span><?php esc_html_e( 'Activate license', 'product-layouts' ); ?>
							</a>
						<?php endif; ?>
					<?php endif; ?>

					<?php if ( 'expired' === $status ) : ?>
						<a class="wpte-wpl-set-btn" target="_blank" rel="noopener" href="<?php echo esc_url( self::PRICING_URL ); ?>"><?php esc_html_e( 'Renew license', 'product-layouts' ); ?></a>
					<?php elseif ( $state['can_manage'] && ( 'free' === $status || 'trial' === $status ) ) : ?>
						<a class="wpte-wpl-set-btn" target="_blank" rel="noopener" href="<?php echo esc_url( self::PRICING_URL ); ?>"><?php esc_html_e( 'Get Pro', 'product-layouts' ); ?></a>
					<?php endif; ?>

					<?php if ( $state['can_manage'] && '' !== $state['account_url'] && 'free' !== $status ) : ?>
						<a class="wpte-wpl-set-link" href="<?php echo esc_url( $state['account_url'] ); ?>"><?php esc_html_e( 'Manage account', 'product-layouts' ); ?></a>
					<?php endif; ?>

					<?php if ( ! $state['can_manage'] && 'active' !== $status ) : ?>
						<span class="wpte-wpl-set-license-note"><?php esc_html_e( 'Ask a site administrator to activate the license.', 'product-layouts' ); ?></span>
					<?php endif; ?>
				<?php
				$actions = trim( ob_get_clean() );
				if ( '' !== $actions ) :
					?>
					<div class="wpte-wpl-set-actions"><?php echo $actions; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- markup built above, every value escaped there. ?></div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}

	/**
	 * A select row for the Category page card.
	 *
	 * @param string $name     Setting name, as stored in wpte_pl_settings.
	 * @param string $label    Row label.
	 * @param string $desc     Row help text.
	 * @param array  $options  Layout id => name.
	 * @param string $selected Saved layout id.
	 * @param bool   $locked   Free plan: shown but not editable.
	 */
	private function select_row( $name, $label, $desc, $options, $selected, $locked ) {
		?>
		<div class="wpte-wpl-set-row">
			<div class="wpte-wpl-set-row-text">
				<label class="wpte-wpl-set-label" for="<?php echo esc_attr( $name ); ?>"><?php echo esc_html( $label ); ?></label>
				<p class="wpte-wpl-set-desc"><?php echo esc_html( $desc ); ?></p>
			</div>
			<div class="wpte-wpl-set-row-control">
				<span class="wpte-wpl-set-status" data-status-for="<?php echo esc_attr( $name ); ?>" aria-live="polite"></span>
				<select class="wpte-wpl-set-select" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $name ); ?>" <?php disabled( $locked ); ?>>
					<option value=""><?php esc_html_e( 'None', 'product-layouts' ); ?></option>
					<?php foreach ( $options as $id => $layout ) : ?>
						<option value="<?php echo esc_attr( (int) $id ); ?>" <?php selected( (int) $selected, (int) $id ); ?>><?php echo esc_html( $layout ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<?php
	}

	/**
	 * Danger zone card. Administrators only: these actions remove data for
	 * the whole site.
	 *
	 * @since 1.4.5
	 */
	private function danger_zone() {
		$delete_on_uninstall = 'yes' === get_option( \WPTE_PRODUCT_LAYOUT\Includes\Data_Cleaner::UNINSTALL_OPTION );
		$layouts             = $this->layouts_text();
		?>
		<section class="wpte-wpl-set-card wpte-wpl-set-danger" aria-labelledby="wpte-wpl-danger-title">
			<div class="wpte-wpl-set-card-head">
				<span class="wpte-wpl-set-card-icon dashicons dashicons-warning" aria-hidden="true"></span>
				<div class="wpte-wpl-set-card-text">
					<h2 class="wpte-wpl-set-card-title" id="wpte-wpl-danger-title"><?php esc_html_e( 'Danger zone', 'product-layouts' ); ?></h2>
					<p class="wpte-wpl-set-card-sub"><?php esc_html_e( 'These actions permanently remove your Product Layouts data.', 'product-layouts' ); ?></p>
				</div>
			</div>
			<div class="wpte-wpl-set-row">
				<div class="wpte-wpl-set-row-text">
					<label class="wpte-wpl-set-label" for="wpte_pl_delete_data_on_uninstall"><?php esc_html_e( 'Delete data when the plugin is deleted', 'product-layouts' ); ?></label>
					<p class="wpte-wpl-set-desc" id="wpte_pl_delete_data_on_uninstall-desc"><?php esc_html_e( 'When you delete Product Layouts from the Plugins screen, also remove its layouts and settings. Deactivating never removes data, so you can safely deactivate while troubleshooting.', 'product-layouts' ); ?></p>
				</div>
				<div class="wpte-wpl-set-row-control">
					<span class="wpte-wpl-set-status" data-status-for="wpte_pl_delete_data_on_uninstall" aria-live="polite"></span>
					<span class="wpte-wpl-set-switch">
						<input type="checkbox" role="switch" id="wpte_pl_delete_data_on_uninstall" data-action="wpte_delete_data_on_uninstall" aria-describedby="wpte_pl_delete_data_on_uninstall-desc" <?php checked( $delete_on_uninstall ); ?>>
						<span class="wpte-wpl-set-switch-track" aria-hidden="true"><span class="wpte-wpl-set-switch-thumb"></span></span>
					</span>
				</div>
			</div>
			<div class="wpte-wpl-set-row">
				<div class="wpte-wpl-set-row-text">
					<span class="wpte-wpl-set-label"><?php esc_html_e( 'Delete all data now', 'product-layouts' ); ?></span>
					<p class="wpte-wpl-set-desc">
						<?php
						/* translators: %s: number of layouts, e.g. "6 layouts" */
						echo esc_html( sprintf( __( 'Remove %s and the settings on this page. Your license stays active.', 'product-layouts' ), $layouts ) );
						?>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=product-layouts-shortcode' ) ); ?>"><?php esc_html_e( 'Export what you want to keep first.', 'product-layouts' ); ?></a>
					</p>
				</div>
				<div class="wpte-wpl-set-row-control">
					<button type="button" class="wpte-wpl-set-btn is-danger" data-wpl-open="wpte-wpl-delete-dialog">
						<span class="dashicons dashicons-trash" aria-hidden="true"></span><?php esc_html_e( 'Delete all data', 'product-layouts' ); ?>
					</button>
				</div>
			</div>
		</section>
		<?php
	}

	/**
	 * "6 layouts", for the Danger zone and its dialog.
	 *
	 * @return string
	 */
	private function layouts_text() {
		$count = \WPTE_PRODUCT_LAYOUT\Includes\Data_Cleaner::count_layouts();
		/* translators: %s: number of layouts */
		return sprintf( _n( '%s layout', '%s layouts', $count, 'product-layouts' ), number_format_i18n( $count ) );
	}

	/**
	 * Confirmation dialog for "Delete all data". Printed outside the form.
	 *
	 * @since 1.4.5
	 */
	private function delete_dialog() {
		?>
		<div class="wpte-wpl-set-dialog" id="wpte-wpl-delete-dialog" hidden>
			<div class="wpte-wpl-set-dialog-backdrop" data-wpl-close></div>
			<div class="wpte-wpl-set-dialog-box" role="alertdialog" aria-modal="true" aria-labelledby="wpte-wpl-delete-title" aria-describedby="wpte-wpl-delete-desc">
				<span class="wpte-wpl-set-dialog-icon dashicons dashicons-warning" aria-hidden="true"></span>
				<h2 class="wpte-wpl-set-dialog-title" id="wpte-wpl-delete-title"><?php esc_html_e( 'Delete all Product Layouts data?', 'product-layouts' ); ?></h2>
				<div id="wpte-wpl-delete-desc">
					<p class="wpte-wpl-set-dialog-text"><?php esc_html_e( 'This permanently deletes:', 'product-layouts' ); ?></p>
					<ul class="wpte-wpl-set-dialog-list">
						<li><?php echo esc_html( $this->layouts_text() ); ?></li>
						<li><?php esc_html_e( 'The settings on this page, including the category page layouts', 'product-layouts' ); ?></li>
					</ul>
					<p class="wpte-wpl-set-dialog-text"><?php esc_html_e( 'Pages that use a Product Layouts shortcode, block or widget will show nothing in its place. This cannot be undone.', 'product-layouts' ); ?></p>
				</div>
				<label class="wpte-wpl-set-dialog-label" for="wpte-wpl-delete-confirm">
					<?php
					printf(
						/* translators: %s: the word the user must type */
						esc_html__( 'Type %s to confirm', 'product-layouts' ),
						'<code>DELETE</code>'
					);
					?>
				</label>
				<input type="text" class="wpte-wpl-set-input" id="wpte-wpl-delete-confirm" autocomplete="off" spellcheck="false" autocapitalize="characters">
				<p class="wpte-wpl-set-dialog-status" role="status" aria-live="polite"
					data-deleting="<?php esc_attr_e( 'Deleting all data', 'product-layouts' ); ?>"
					data-done="<?php esc_attr_e( 'All data deleted. Reloading the page.', 'product-layouts' ); ?>"
					data-error="<?php esc_attr_e( 'Nothing was deleted. Reload the page and try again.', 'product-layouts' ); ?>"></p>
				<div class="wpte-wpl-set-dialog-actions">
					<button type="button" class="wpte-wpl-set-btn" data-wpl-close><?php esc_html_e( 'Cancel', 'product-layouts' ); ?></button>
					<button type="button" class="wpte-wpl-set-btn is-danger-solid" id="wpte-wpl-delete-submit" disabled><?php esc_html_e( 'Delete everything', 'product-layouts' ); ?></button>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Settings Form
	 *
	 * @since 1.0.0
	 */
	public function wpte_settings_form() {
		$settings    = get_option( 'wpte_pl_settings' );
		$settings    = is_array( $settings ) ? $settings : [];
		$google_font = ! isset( $settings['wpte_google_font'] ) || 'no' !== $settings['wpte_google_font'];
		$category    = isset( $settings['wpte-settings-category-select'] ) ? $settings['wpte-settings-category-select'] : '';
		$filter      = isset( $settings['wpte-settings-filter-select'] ) ? $settings['wpte-settings-filter-select'] : '';
		$is_pro      = wpte_version_control();

		$pro_pill = $is_pro ? '' : '<span class="wpte-wpl-set-pill is-pro"><span class="dashicons dashicons-lock" aria-hidden="true"></span>' . esc_html__( 'Pro', 'product-layouts' ) . '</span>';
		?>
		<div class="wpte-wpl-account wpte-wpl-settings"
			data-saving="<?php esc_attr_e( 'Saving', 'product-layouts' ); ?>"
			data-saved="<?php esc_attr_e( 'Saved', 'product-layouts' ); ?>"
			data-error="<?php esc_attr_e( 'Not saved, try again', 'product-layouts' ); ?>"
			data-copied="<?php esc_attr_e( 'Copied', 'product-layouts' ); ?>">

			<header class="wpte-wpl-acc-hero">
				<img class="wpte-wpl-acc-hero-logo" src="<?php echo esc_url( WPTE_WPL_URL . '/Image/wpl-icon.svg' ); ?>" alt="" width="52" height="52">
				<div class="wpte-wpl-acc-hero-text">
					<h1 class="wpte-wpl-acc-title"><?php esc_html_e( 'Settings', 'product-layouts' ); ?></h1>
					<p class="wpte-wpl-acc-subtitle"><?php esc_html_e( 'Manage your license, the fonts your layouts load and the design of WooCommerce category pages.', 'product-layouts' ); ?></p>
				</div>
				<span class="wpte-wpl-set-autosave">
					<span class="wpte-wpl-set-autosave-dot" aria-hidden="true"></span>
					<?php esc_html_e( 'Changes save automatically', 'product-layouts' ); ?>
				</span>
			</header>
			<hr class="wp-header-end">

			<div class="wpte-wpl-set-layout">
				<form class="wpte-wpl-set-main" id="wpte-settings-form" action="" method="post">

					<?php $this->license_card(); ?>

					<section class="wpte-wpl-set-card">
						<?php $this->card_head( 'performance', __( 'Assets and performance', 'product-layouts' ), __( 'Turn off anything your theme already loads to keep pages lighter.', 'product-layouts' ) ); ?>
						<div class="wpte-wpl-set-row">
							<div class="wpte-wpl-set-row-text">
								<label class="wpte-wpl-set-label" for="wpte_google_font"><?php esc_html_e( 'Google Fonts', 'product-layouts' ); ?></label>
								<p class="wpte-wpl-set-desc" id="wpte_google_font-desc"><?php esc_html_e( 'Load the fonts used in your layouts from Google. If your theme already loads those fonts, turn this off for faster loading.', 'product-layouts' ); ?></p>
							</div>
							<div class="wpte-wpl-set-row-control">
								<span class="wpte-wpl-set-status" data-status-for="wpte_google_font" aria-live="polite"></span>
								<span class="wpte-wpl-set-switch">
									<input type="checkbox" role="switch" id="wpte_google_font" name="wpte_google_font" aria-describedby="wpte_google_font-desc" <?php checked( $google_font ); ?>>
									<span class="wpte-wpl-set-switch-track" aria-hidden="true"><span class="wpte-wpl-set-switch-thumb"></span></span>
								</span>
							</div>
						</div>
					</section>

					<section class="wpte-wpl-set-card wpte-wpl-set-category<?php echo $is_pro ? '' : ' is-locked'; ?>">
						<?php $this->card_head( 'category', __( 'Category pages', 'product-layouts' ), __( 'Show your own layout on WooCommerce product category pages.', 'product-layouts' ), $pro_pill ); ?>
						<?php
						$this->select_row(
							'wpte-settings-category-select',
							__( 'Products layout', 'product-layouts' ),
							__( 'Replaces the product grid on every category page with this layout, showing that category\'s products.', 'product-layouts' ),
							wpte_get_shortcode_list(),
							$category,
							! $is_pro
						);
						$this->select_row(
							'wpte-settings-filter-select',
							__( 'Filter', 'product-layouts' ),
							__( 'A Filter and Sorting layout shown above the products.', 'product-layouts' ),
							wpte_get_filter_shortcode_list(),
							$filter,
							! $is_pro
						);
						?>
						<div class="wpte-wpl-set-row">
							<div class="wpte-wpl-set-row-text">
								<label class="wpte-wpl-set-label" for="wpte-wpl-set-category-shortcode"><?php esc_html_e( 'Shortcode for custom templates', 'product-layouts' ); ?></label>
								<p class="wpte-wpl-set-desc"><?php esc_html_e( 'Built your category template with Elementor, Divi or code? Place this shortcode there instead. It works on category pages only, once a products layout is chosen above.', 'product-layouts' ); ?></p>
							</div>
							<div class="wpte-wpl-set-row-control wpte-wpl-set-copy">
								<input class="wpte-wpl-set-input" id="wpte-wpl-set-category-shortcode" type="text" readonly value="[wpte_product_layout_for_category_page]">
								<button type="button" class="wpte-wpl-set-btn wpte-wpl-set-copy-btn" data-copy="#wpte-wpl-set-category-shortcode">
									<span class="dashicons dashicons-clipboard" aria-hidden="true"></span><span class="wpte-wpl-set-copy-label"><?php esc_html_e( 'Copy', 'product-layouts' ); ?></span>
								</button>
							</div>
						</div>
						<?php if ( ! $is_pro ) : ?>
							<div class="wpte-wpl-set-upsell">
								<p><?php esc_html_e( 'Category page layouts are part of Product Layouts Pro.', 'product-layouts' ); ?></p>
								<a class="wpte-wpl-set-btn is-primary wpte-po-element" href="<?php echo esc_url( self::PRICING_URL ); ?>" target="_blank" rel="noopener">
									<span class="dashicons dashicons-unlock" aria-hidden="true"></span><?php esc_html_e( 'Get Pro', 'product-layouts' ); ?>
								</a>
							</div>
						<?php endif; ?>
					</section>

					<?php
					if ( current_user_can( 'manage_options' ) ) {
						$this->danger_zone();
					}
					?>
				</form>

				<aside class="wpte-wpl-set-aside">
					<div class="wpte-wpl-set-card wpte-wpl-set-help">
						<h2 class="wpte-wpl-set-card-title"><?php esc_html_e( 'Need a hand?', 'product-layouts' ); ?></h2>
						<p class="wpte-wpl-set-card-sub"><?php esc_html_e( 'Guides, videos and answers from our team.', 'product-layouts' ); ?></p>
						<ul class="wpte-wpl-set-links">
							<li>
								<a href="<?php echo esc_url( admin_url( 'admin.php?page=product-layouts-getting-started' ) ); ?>">
									<span class="dashicons dashicons-flag" aria-hidden="true"></span><?php esc_html_e( 'Getting started', 'product-layouts' ); ?>
								</a>
							</li>
							<li>
								<a target="_blank" rel="noopener" href="https://oxilab.dev/docs/product-layouts/">
									<span class="dashicons dashicons-book-alt" aria-hidden="true"></span><?php esc_html_e( 'Documentation', 'product-layouts' ); ?><span class="wpte-wpl-set-ext dashicons dashicons-external" aria-hidden="true"></span>
								</a>
							</li>
							<li>
								<a target="_blank" rel="noopener" href="https://www.youtube.com/playlist?list=PLnr-_fYXIk0UrNZ3-xEKeLVtZPFJadOIX">
									<span class="dashicons dashicons-video-alt3" aria-hidden="true"></span><?php esc_html_e( 'Video tutorials', 'product-layouts' ); ?><span class="wpte-wpl-set-ext dashicons dashicons-external" aria-hidden="true"></span>
								</a>
							</li>
							<li>
								<a target="_blank" rel="noopener" href="https://wordpress.org/support/plugin/product-layouts/">
									<span class="dashicons dashicons-sos" aria-hidden="true"></span><?php esc_html_e( 'Support forum', 'product-layouts' ); ?><span class="wpte-wpl-set-ext dashicons dashicons-external" aria-hidden="true"></span>
								</a>
							</li>
							<li>
								<a href="<?php echo esc_url( admin_url( 'admin.php?page=product-layouts-status' ) ); ?>">
									<span class="dashicons dashicons-yes-alt" aria-hidden="true"></span><?php esc_html_e( 'System status', 'product-layouts' ); ?>
								</a>
							</li>
						</ul>
						<div class="wpte-wpl-set-meta">
							<?php /* translators: %s: plugin version */ ?>
							<span><?php echo esc_html( sprintf( __( 'Version %s', 'product-layouts' ), WPTE_WPL_VERSION ) ); ?></span>
							<?php if ( $is_pro ) : ?>
								<span class="wpte-wpl-set-plan is-pro"><?php esc_html_e( 'Premium version', 'product-layouts' ); ?></span>
							<?php else : ?>
								<span class="wpte-wpl-set-plan"><?php esc_html_e( 'Free', 'product-layouts' ); ?></span>
							<?php endif; ?>
						</div>
					</div>
				</aside>
			</div>
			<?php
			if ( current_user_can( 'manage_options' ) ) {
				$this->delete_dialog();
			}
			?>
		</div>
		<div id="wpte-offer-modal"></div>
		<?php
	}
}
